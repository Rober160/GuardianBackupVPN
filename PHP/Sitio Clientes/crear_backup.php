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
	$nombreScript = "";
	$mostrarEnlace = false;


	if(isset($_POST["enviar"])) {
		if(isset($_POST["ruta"]) && isset($_POST["usuario_local"])) {
			$rutaCliente = trim($_POST["ruta"]); //eliminamos espacios
			$usuarioLocal = trim($_POST["usuario_local"]);

			$nombreScript = generarScriptRsync($usuario,$rutaCliente,$usuarioLocal);
			$mostrarEnlace = true;
		}
	}

	if(isset($_POST["crear_backup"])) {
		$resultado = crearBackupRestic($conexion,$usuario);

		if($resultado == true) {
			$mensaje = "[OK] Backup creado correctamente.";
		} else {
			$mensaje = "[X] Error al crear el backup.";
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Crear Copia de Seguridad</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h1>Crear Backup - <?php echo $usuario;?></h1>

	<nav>
		<a href="panel.php">Volver al Panel</a>
	</nav>

	<div><h2>1️⃣  Generar el script para sincronizar tu carpeta al servidor</h2></div>
	<form method="POST">
		<p>Ruta de la carpeta en tu Equipo:</p>
		<input type="text" name="ruta" placeholder="/home/miusuario/datos" 
		
		value="<?php
		        if(isset($_POST["ruta"])) {
		            echo $_POST["ruta"];
		        }
		?>"
		required><br>
		
		<p>Tu usuario local (nombre de tu usuario en el Equipo):</p>
		<input type="text" name="usuario_local" placeholder="Mi_Usuario" 
		
		value="<?php
		        if(isset($_POST["usuario_local"])) {
		            echo $_POST["usuario_local"];
		        }
		?>"
		required><br>

		<input type="submit" name="enviar" value="Generar Script">
	</form>

	<?php if($mostrarEnlace == true) { ?>
		<div>
			<p>✅ Script generado correctamente. Descárgalo aquí: </p>
			<a href="descargas/<?php echo $nombreScript; ?>" download><?php echo $nombreScript; ?></a>
		</div>

		<div><h2>2️⃣  Hacer el backup en el servidor</h2></div>
		<form method="POST">
			<input type="hidden" name="crear_backup" value="1">
			<input type="submit" name="crear_backup" value="Crear Backup">
		</form>

	<?php } ?>

	<div>
		<p><?php echo $mensaje;?></p>
	</div>

	<footer>
		<p>GUARDIANBACKUPVPN &reg</p>
	</footer>
</body>
</html>
