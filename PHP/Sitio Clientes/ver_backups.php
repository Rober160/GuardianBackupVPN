<?php
	session_start();
	require "libreria.php";
	$conexion = conectar();

	if(!isset($_SESSION["usuario"])) {
		header("Location:login.php");
		exit();
	}

	$usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Mis Copias de Seguridad</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h1>Mis Backups</h1>

	<nav>
		<a href="panel.php">Volver al Panel</a>
	</nav>

	<div>
		<?php mostrarBackups($conexion,$usuario); ?>
	</div>

	<footer>
		<p>GUARDIANBACKUPVPN &reg</p>
	</footer>
</body>

</html>
