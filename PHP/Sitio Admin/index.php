<?php
	require "libreria.php";
	$conexion = conexion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Panel de Administración</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h2>Panel de Administración</h2>
	<nav>
		<a href="listar_clientes.php">Ver clientes</a>
		<a href="ver_backups.php">Ver backups</a>
		<a href="ver_solicitudes.php">Ver solicitudes</a>
		<a href="baja_clientes.php">Dar de baja cliente</a>
	</nav>

	<p>Bienvenido al área de administración</p>

	<footer>
		<p>GUARDIANBACKUPVPN &reg;</p>
	</footer>
</body>
</html>
