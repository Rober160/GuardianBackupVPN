<?php
function conexion() {
	$servidor = "localhost";
	$usuario = "webuser";
	$passwd = "ClaveRoot#20";
	$db = "backups_web";

	$conexion = mysqli_connect($servidor,$usuario,$passwd,$db);
	return $conexion;
}

function listar() {
	$consulta = "SELECT * FROM usuarios";
	return $consulta;
}

function listarBackupsUsuario($conexion,$usuario) {
	$consulta = "select id from usuarios where usuario = '$usuario'";
	$resultado = mysqli_query($conexion,$consulta);

	if(mysqli_num_rows($resultado) == 1) {
		$fila = mysqli_fetch_assoc($resultado);
		$usuario_id = $fila["id"];

		$select = "select * from backups where cliente_id = $usuario_id order by fecha_backup desc";
		$resultado_backups = mysqli_query($conexion,$select);

		if(mysqli_num_rows($resultado_backups) > 0) {
			$fila_backup = mysqli_fetch_assoc($resultado_backups);

			echo "<table>";

			echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Fecha</th>";
			echo "<th>Tamaño</th>";
			echo "<th>Estado</th>";
			echo "</tr>";

			while($fila_backup) {
				echo "<tr>";
				echo "<td>" . $fila_backup["id"] . "</td>";
				echo "<td>" . $fila_backup["fecha_backup"] . "</td>";
				echo "<td>" . $fila_backup["tamano_backup"] . "</td>";
				echo "<td>" . $fila_backup["estado"] . "</td>";
				echo "</tr>";
				$fila_backup = mysqli_fetch_assoc($resultado_backups);
			}

			echo "</table>";
		} else {
			echo "<h2>El usuario '$usuario no tiene backups registrados.</h2>";
		}
	} else {
		echo "<div><h2>[X] El usuario '$usuario' no existe.</h2></div>";
	}
}

function mostrarUsuarioBaja($conexion,$usuario) {
	$consulta = "select * from usuarios where usuario = '$usuario'";
	$resultado = mysqli_query($conexion,$consulta);

	if(mysqli_num_rows($resultado) == 1) {
		$fila = mysqli_fetch_assoc($resultado);

		echo "<form method='POST'>";
		echo "<table>";

		echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Usuario</th>";
			echo "<th>Acción</th>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>" . $fila["id"] . "</td>";
			echo "<td>" . $fila["usuario"] . "</td>";
			echo "<td>";
				echo "<input type='hidden' name='id_usuario' value='" . $fila["id"] . "'>";
				echo "<input type='submit' name='eliminar' value='Dar de baja' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este usuario?');\">";
			echo "</td>";
		echo "</tr>";

		echo "</table>";
		echo "</form>";
	} else {
		echo "<div><h2>[X] No se encontró el usuario '$usuario'.</h2></div>";
	}
}

function obtenerSolicitudes($conexion) {
	$solicitudes = [];

	$consulta = "SELECT s.id, s.backup_id, s.fecha_solicitud, s.estado, s.comentario, u.usuario
        FROM solicitudes s
     	JOIN usuarios u ON s.cliente_id = u.id
        WHERE s.estado = 'Pendiente'
        ORDER BY s.fecha_solicitud DESC";

	$resultado = mysqli_query($conexion,$consulta);

	while($fila = mysqli_fetch_assoc($resultado)) {
		$solicitudes[] = $fila;
	}

	return $solicitudes;
}

function completarSolicitud($conexion,$idSolicitud,$nombreZip) {
	$consulta = "update solicitudes set estado = 'Completado', nombre_zip = '$nombreZip' where id = '$idSolicitud'";
	$resultado = mysqli_query($conexion,$consulta);
	return $resultado;
}

?>
