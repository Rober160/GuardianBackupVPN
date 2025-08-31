<?php
	session_start();
	if(!isset($_SESSION["usuario"])) {
		header("Location: login.php");
		exit();
	}

	$usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Panel del Usuario</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h1>Bienvenido, <?php echo $usuario;?> </h1>

	<nav class="panel">
		<a href="ver_backups.php">[ARCHIVOS] Ver Backups</a>
		<span>↑  Lista todas tus copias de seguridad guardadas ↑</span>
		<a href="crear_backup.php">[SAVE] Crear Backup</a><br>
		<span>↑  Lanza una copia de seguridad ahora ↑</span>
		<a href="restaurar_backups.php">[RESTORE] Solicitud Restauración</a>
		<span>↑  Pide recuperar una copia de seguridad ahora ↑</span>
		<a href="backups_restaurados.php">[OK] Backups Restaurados</a>
		<span>↑  Ver copias de seguridad restauradas disponibles ↑</span>
		<a href="cerrar_sesion.php" onclick="return confirm('¿Estas seguro de que quieres cerrar sesión?')">[X] Cerrar Sesión</a>
		<span>↑  Salir de tu cuenta ↑</span>
	</nav>

	<footer>
		<p>GUARDIANBACKUPVPN &reg</p>
	</footer>
</body>
</html>
