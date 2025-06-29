<?php
	session_start();
	require "libreria.php";

	$conexion = conexion();

	if (isset($_POST["completar"]) && is_numeric($_POST["solicitud_id"])) {
		$idSolicitud = $_POST["solicitud_id"];
		$usuario = $_POST["usuario"];
		$backupID = $_POST["backup_id"];

		$comando = "sudo /usr/local/bin/restaurar_backup.sh $usuario $backupID";
		$salida = shell_exec($comando);

		if (!$salida) {
			echo "❌ El script no devolvió salida.";
			return;
		}

		$lineas = array_filter(array_map('trim', explode("\n", $salida)));
		$nombreZip = "";

		// Buscar línea que contenga [ZIP_RESULT] y extraer el nombre
		foreach (array_reverse($lineas) as $linea) {
			if (preg_match('/^\\[ZIP_RESULT\\]\\s+(.+\\.zip)$/', $linea, $match)) {
				$nombreZip = trim($match[1]);
				break;
			}
		}

		if (!empty($nombreZip)) {
			completarSolicitud($conexion, $idSolicitud, $nombreZip);
		} else {
			echo "❌ Error al obtener el nombre del ZIP para solicitud $idSolicitud";
		}
	}

	$solicitudes = obtenerSolicitudes($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Solicitudes de Restauración</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>
	<h1>📦 Solicitudes de Restauración</h1>
	<nav>
		<a href="index.php">⬅️ Volver al Panel</a>
	</nav>

	<?php if (count($solicitudes) > 0) { ?>
	<table>
		<tr>
			<th>ID solicitud</th>
			<th>Usuario</th>
			<th>ID Backup</th>
			<th>Comentario</th>
			<th>Fecha</th>
			<th>Estado</th>
			<th>Acción</th>
		</tr>
		<?php foreach ($solicitudes as $solicitud) { ?>
			<tr>
				<td><?php echo $solicitud["id"]; ?></td>
				<td><?php echo $solicitud["usuario"]; ?></td>
				<td><?php echo $solicitud["backup_id"]; ?></td>
				<td><?php echo htmlspecialchars($solicitud["comentario"]); ?></td>
				<td><?php echo $solicitud["fecha_solicitud"]; ?></td>
				<td><?php echo $solicitud["estado"]; ?></td>
				<td>
					<form method="POST">
						<input type="hidden" name="solicitud_id" value="<?php echo $solicitud['id']; ?>">
						<input type="hidden" name="usuario" value="<?php echo $solicitud['usuario']; ?>">
						<input type="hidden" name="backup_id" value="<?php echo $solicitud['backup_id']; ?>">
						<input type="submit" name="completar" value="✅ Restaurar y Completar">
					</form>
				</td>
			</tr>
		<?php } ?>
	</table>
	<?php } else { ?>
		<div><p>No hay solicitudes pendientes</p></div>
	<?php } ?>

	<footer>
		<div><p>GUARDIANBACKUPVPN &reg</p></div>
	</footer>
</body>
</html>
