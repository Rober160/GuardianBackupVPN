<?php
date_default_timezone_set('Europe/Madrid');

function conectar() {
	$servidor = "localhost";
	$usuario = "webuser";
	$passwd = "ClaveRoot#20";
	$db = "backups_web";

	$conexion = mysqli_connect($servidor,$usuario,$passwd,$db);
	return $conexion;
}

function generarScriptRsync($usuarioWeb, $rutaCliente, $usuarioLocal) {
    $nombreArchivo = "sincronizar_backup_$usuarioWeb.sh";
    $rutaScript = "/var/www/clientes/descargas/$nombreArchivo";

    // Carpeta personalizada del usuario en el servidor
    $carpetaDestino = "/VPN_cli/rsync_tmp/rsync_$usuarioWeb";

    $contenido = "#!/bin/bash\n\n";
    $contenido .= "# Script generado automáticamente para enviar archivos a GuardianBackupVPN\n";
    $contenido .= "# Contraseña para crear primer backup: 'ClaveRoot#20'\n\n";
    $contenido .= "ORIGEN=\"$rutaCliente\"\n";
    $contenido .= "CLAVE=\"\$HOME/.ssh/clave_backup_$usuarioWeb\"\n";
    $contenido .= "DESTINO=\"rsync-user@clientes.guardianvpn.es:$carpetaDestino\"\n\n";

    // Crear clave si no existe
    $contenido .= "if [ ! -f \"\$CLAVE\" ]; then\n";
    $contenido .= "    echo \"Generando clave SSH...\"\n";
    $contenido .= "    ssh-keygen -t rsa -b 2048 -f \"\$CLAVE\" -N \"\"\n";
    $contenido .= "fi\n\n";

    // Copiar clave al servidor
    $contenido .= "echo \"Enviando clave pública al servidor (puede pedir contraseña)...\"\n";
    $contenido .= "ssh-copy-id -i \"\$CLAVE.pub\" rsync-user@clientes.guardianvpn.es\n\n";

    // Ejecutar script remoto como sudo con pseudo-terminal (-t)
    $contenido .= "echo \"Ejecutando limpieza forzada del directorio remoto con sudo...\"\n";
    $contenido .= "ssh -t -i \"\$CLAVE\" rsync-user@clientes.guardianvpn.es \"sudo /usr/local/bin/reset_rsync_dir.sh $usuarioWeb\"\n\n";

    // Sincronización con rsync usando la clave
    $contenido .= "echo \"🚀 Enviando archivos al servidor...\"\n";
    $contenido .= "rsync -av --progress -e \"ssh -i \$CLAVE -o StrictHostKeyChecking=no\" \"\$ORIGEN/\" \"\$DESTINO\"\n";
    $contenido .= "echo \"[OK] Sincronización completada. Vuelve a la web para lanzar el backup.\"\n";

    // Guardar y preparar el script
    file_put_contents($rutaScript, $contenido);
    chmod($rutaScript, 0755);

    // Ajustar permisos del destino, por si se usa manualmente
    shell_exec("chown -R rsync-user:rsync-user " . escapeshellarg($carpetaDestino));
    shell_exec("chmod -R 755 " . escapeshellarg($carpetaDestino));

    return $nombreArchivo;
}


function crearBackupRestic($conexion,$usuario) {
	$carpeta = "/VPN_cli/rsync_tmp/rsync_" . $usuario;

	shell_exec("sudo /usr/local/bin/permisos.sh " . $usuario);

	shell_exec("chmod o+rx /VPN_cli");
	shell_exec("chmod o+rx /VPN_cli/rsync_tmp");

	shell_exec("chown -R www-data:www-data /VPN_cli/rsync_tmp/rsync_$usuario");
	shell_exec("chmod -R 755 /VPN_cli/rsync_tmp/rsync_$usuario");

	$repo = "/mnt/backups/repo_" . $usuario;
	$restic_password = "ClaveRoot#20";

	putenv("RESTIC_PASSWORD=$restic_password");
	putenv("HOME=/var/www/tmp_home_wwwdata");
	putenv("RESTIC_CACHE_DIR=/var/www/tmp_home_wwwdata/.cache");

	$comando = "restic -r " . escapeshellarg($repo) . " backup " . escapeshellarg($carpeta) . " 2>&1";
	$salida = shell_exec($comando);

	$tamano = "O B";
	if (preg_match('/Added to the repository:\s*([0-9.,]+\s+[KMGTPE]?i?B)/i', $salida, $coincidencias)) {
        	$tamano = trim($coincidencias[1]);
    	}

	if(strpos($salida, "snapshot") !== false && $tamano !== "0 B") {
		$booleano = true;
		$estado = "Exitoso";
	} else {
		$booleano = false;
		$estado = "Fallido";
	}

	
	$consulta = "select id from usuarios where usuario = '$usuario'";
	$resultado = mysqli_query($conexion,$consulta);

	if($fila = mysqli_fetch_assoc($resultado)) {
		$cliente_id = $fila["id"];
		$fecha = date("Y-m-d H:i:s"); //formato mysql

		$insertar = "insert into backups (cliente_id, fecha_backup, tamano_backup, estado) values ('$cliente_id','$fecha','$tamano', '$estado')";
		mysqli_query($conexion,$insertar);
	}

	shell_exec("chown -R rsync-user:rsync-user " . escapeshellarg($carpeta));

	return $booleano;
}

function mostrarBackups($conexion,$usuario) {
	$consulta = "select id from usuarios where usuario = '$usuario'";
	$resultado = mysqli_query($conexion,$consulta);

	if(mysqli_num_rows($resultado) == 1) {
		$fila = mysqli_fetch_assoc($resultado);
		$cliente_id = $fila["id"];

		$consulta_backups = "select * from backups where cliente_id = $cliente_id order by fecha_backup desc";
		$resultado_backups = mysqli_query($conexion,$consulta_backups);

		if(mysqli_num_rows($resultado_backups) > 0) {
			$fila = mysqli_fetch_assoc($resultado_backups);
			echo "<table>";

			echo "<tr>";
				echo "<th>Fecha</th>";
				echo "<th>Tamaño</th>";
				echo "<th>Estado</th>";
			echo "</tr>";

			while($fila) {
				echo "<tr>";
					echo "<td>" . $fila["fecha_backup"] . "</td>";
					echo "<td>" . $fila["tamano_backup"] . "</td>";
					echo "<td>" . $fila["estado"] . "</td>";
				echo "</tr>";
				$fila = mysqli_fetch_assoc($resultado_backups);
			}
			echo "</table>";
		} else {
			echo "<div><p>No tienes backups registrados aún.</p></div>";
		}
	} else {
		echo "<div><p>[X] Error: no se encontró tu usuario en la base de datos.</p></div>";
	}
}


function obtenerBackups($usuario) {
	$repo = "/mnt/backups/repo_" . $usuario;
    	$password = "ClaveRoot#20";

    // Variables de entorno necesarias para Restic
    	putenv("RESTIC_PASSWORD=$password");
    	putenv("HOME=/var/www/tmp_home_wwwdata");
    	putenv("RESTIC_CACHE_DIR=/var/www/tmp_home_wwwdata/.cache");

    // Ejecutar el comando de restic para listar snapshots
    	$comando = "restic -r " . escapeshellarg($repo) . " snapshots 2>/dev/null";
    	$salida = shell_exec($comando);
	$backups = [];

    // Verificar que haya salida antes de procesar
    	if (!empty($salida)) {
        	$lineas = explode("\n", $salida);

       		foreach ($lineas as $linea) {
            		if (preg_match('/^([a-f0-9]{8})\s+(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/', $linea, $match)) {
                		$backups[] = [
                    		"id" => $match[1],
                    		"fecha" => $match[2]
                		];
            		}
        	}
    	}

    	return $backups;
}

function insertarSolicitud($conexion,$usuario,$backupID,$comentario) {
	$consultaUsuario = "select id from usuarios where usuario = '$usuario'";
	$resultadoUsuario = mysqli_query($conexion,$consultaUsuario);

	if($fila = mysqli_fetch_assoc($resultadoUsuario)) {
		$cliente_id = $fila["id"];
		$fecha = date("Y-m-d H:i:s");

		$consulta = "insert into solicitudes (cliente_id,backup_id,comentario,fecha_solicitud, estado) values ('$cliente_id','$backupID','$comentario','$fecha','Pendiente')";
		$resultado = mysqli_query($conexion,$consulta);
		return $consulta;
	}
	return false;
}

function obtenerRestauracionesCliente($conexion,$usuario) {
	$consulta_id = "select id from usuarios where usuario = '$usuario'";
	$resultado_id = mysqli_query($conexion,$consulta_id);

	$fila_id = mysqli_fetch_assoc($resultado_id);
	$cliente_id = $fila_id["id"];

	$consulta = "SELECT backup_id, fecha_solicitud, nombre_zip
        	FROM solicitudes
            	WHERE cliente_id = $cliente_id
              	AND estado = 'Completado'
            	ORDER BY fecha_solicitud DESC";

	$resultado = mysqli_query($conexion,$consulta);
	$restauraciones = [];

	while($fila = mysqli_fetch_assoc($resultado)) {
		$restauraciones[] = $fila;
	}
	return $restauraciones;
}

?>
