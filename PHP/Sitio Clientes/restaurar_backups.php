<?php
	session_start();
	require "libreria.php";

	if(!isset($_SESSION["usuario"])) {
		header("Location:login.php");
		exit();
	}

	$conexion = conectar();
	$usuario = $_SESSION["usuario"];
	$mensaje = "";

	if(isset($_POST["restaurar"])) {
		$backupID = $_POST["backup"];
		$comentario = trim($_POST["comentario"]);

		if(insertarSolicitud($conexion,$usuario,$backupID,$comentario)) {
			$mensaje = "[OK] Solicitud enviada correctamente. Espera a que el administrador la procese.";
		} else {
			$mensaje = "[X] Error al registrar la solicitud.";
		}
	}

	$backups = obtenerBackups($usuario);

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Restaurar Copia de Seguridad</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h1>Restaurar Backup - <?php echo $usuario;?></h1>

	<nav>
		<a href="panel.php">Volver al Panel</a>
	</nav>

	<?php
		if(!empty($mensaje)) {
			echo "<div>";
				echo "<p><strong>" . $mensaje . "</strong></p>";
			echo "</div>";
		}
	?>

	<?php if(!empty($backups)) {?>
	<form method="POST">
		<div>
			<p>Selecciona el backup que deseas restaurar. 
			El administrador recibirá la solicitud.</p>
		</div>

		<p>Backups disponibles</p>
		<select name="backup" required>
			<option value="">Selecciona un backup</option>
			<?php
			foreach ($backups as $backup) {
				echo "<option value='" . $backup['id'] . "'>" . $backup['fecha'] . " (ID: " . $backup['id'] . ")</option>";
			}
			?>
		</select>
		<br><br>

		<p>Comentario (opcional):</p>
		<textarea name="comentario" rows="4" cols="25" placeholder="Por qué necesitas restaurar este backup..."></textarea>
		<br><br>

		<input type="submit" name="restaurar" value="Enviar solicitud">
	</form>

	<?php } else {?>
		<div><p>No hay backups disponibles para solicitar</p></div>
	<?php } ?>

	<footer>
		<p>GUARDIANBACKUPVPN &reg</p>
	</footer>
</body>
</html>
