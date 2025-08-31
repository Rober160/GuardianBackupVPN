<?php
	session_start();
	require "libreria.php";
	$conexion = conectar();

	$mensaje = "";

	if (isset($_POST["usuario"]) && isset($_POST["password"])) {
		$usuario = $_POST["usuario"];
		$password = $_POST["password"];

		if (!empty($usuario) && !empty($password)) {
			$consulta = "select * from usuarios where usuario = '$usuario' and password = '$password'";
			$resultado = mysqli_query($conexion,$consulta);

			if(mysqli_num_rows($resultado) == 1) {
				$_SESSION["usuario"] = $usuario;
				header("Location: panel.php");
				exit();
			} else {
				$mensaje = "Datos incorrectos";
			}
		} else {
			$mensaje = "Debes rellenar todos los campos.";
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Iniciar sesión</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h1>Iniciar Sesión - GuardianBackupVPN</h1>

	<form method="POST">
		<p><strong>Usuario:</strong></p>
		<input type="text" name="usuario" required><br>
		<p><strong>Contraseña:</strong></p>
		<input type="password" name="password"><br>
		<input type="submit" value="Entrar">
		<p><a href="registro.php">Registrarse</a></p>
	</form>

	<div>
		<?php echo $mensaje;?>
	</div>

	<footer>
		<p>GUARDIANBACKUPVPN &reg</p>
	</footer>
</body>
</html>
