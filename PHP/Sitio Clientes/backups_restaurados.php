<?php
	session_start();
	require "libreria.php";

	if(!isset($_SESSION["usuario"])) {
		header("Location:login.php");
		exit();
	}

	$conexion = conectar();
	$usuario = $_SESSION["usuario"];
	$restauraciones = obtenerRestauracionesCliente($conexion,$usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Copias de Seguridad Restauradas</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h1>📦 Backups Restaurados - <?php echo $usuario;?></h1>
	<nav>
		<a href="panel.php">⬅️ Volver al Panel</a>
	</nav>

	<?php if(!empty($restauraciones)) { ?>
	<table>
		<tr>
			<th>Fecha de Solicitud</th>
			<th>ID del Backup</th>
			<th>Enlace de Descarga</th>
		</tr>
		<?php
		foreach ($restauraciones as $fila) {
			$fechaSolicitud = strtotime($fila["fecha_solicitud"]);
			$ahora = time();
			$diasLimite = 3 * 24 * 60 * 60;

			$nombre_zip = $fila["nombre_zip"];
			$ruta_relativa = "descargas/" . $nombre_zip;
			$ruta_absoluta = "/var/www/clientes/" . $ruta_relativa;
			echo "<tr>";
				echo "<td>" . $fila["fecha_solicitud"] . "</td>";
				echo "<td>" . $fila["backup_id"] . "</td>";
				if(!empty($nombre_zip) && ($ahora - $fechaSolicitud) <= $diasLimite && file_exists($ruta_absoluta)) {
					echo "<td><a href='" . $ruta_relativa . "' target='_blank'>📥 Descargar Backup</a></td>";
				} else {
					echo "<td>⛔ Enlace caducado</td>";
				}
			echo "</tr>";
		}
		?>
	</table>

	<?php } else { ?>
		<div><p>No tienes backups restaurados disponibles.</p>
	<?php } ?>

	<footer>
		<p>GUARDIANBACKUPVPN &reg</p>
	</footer>
</body>
</html>
