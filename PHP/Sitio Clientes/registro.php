<?php
	require "libreria.php";
	$conexion = conectar();
	$mensaje = "";
	$nombreUsuario = "";

	if (isset($_POST["enviar"]) && isset($_POST["password"])) {
		$password = $_POST["password"];

		if (!empty($password)) {
			$nombreUsuario = $_POST["usuario"];
			$insertar = "insert into usuarios (usuario, password) VALUES ('$nombreUsuario', '$password')";

			if (mysqli_query($conexion, $insertar)) {
				$mensaje = "Registro exitoso. Serás redirigido al login en unos instantes...";
				$meta = '<meta http-equiv="refresh" content="5;url=login.php">';
			} else {
				$mensaje = "Error al registrar: " . mysqli_error($conexion);
			}
		} else {
			$mensaje = "Debes introducir una contraseña.";
		}
	} else {
		// Cálculo del siguiente nombre disponible
		$consulta = "SELECT usuario FROM usuarios WHERE usuario LIKE 'usuario%' ORDER BY id DESC LIMIT 1";
		$resultado = mysqli_query($conexion, $consulta);

		$nuevoNumero = 1;

		if ($fila = mysqli_fetch_assoc($resultado)) {
			$ultimoCliente = $fila["usuario"];
			$numero = (int) filter_var($ultimoCliente, FILTER_SANITIZE_NUMBER_INT);
			$nuevoNumero = $numero + 1;
		}
		$nombreUsuario = "usuario" . $nuevoNumero;
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Registro Clientes</title>
	<link rel="stylesheet" href="css/estilos.css">
	<?php if(!empty($meta)) echo $meta;?>
</head>
<body>
	<h1>Registro - GuardianBackupVPN</h1>

	<form method="POST">
		<p><strong>Tu nombre de usuario será:</strong> <?php echo $nombreUsuario; ?></p>
		<input type="hidden" name="usuario" value="<?php echo $nombreUsuario; ?>">
		<p>Introduce tu contraseña:</p>
		<input type="password" name="password" id="password" required><br>
		<input type="submit" name="enviar" value="Registrarse">
		<p><a href="login.php">Iniciar sesión</a></p>
	</form>

	<div>
		<?php echo $mensaje; ?>
	</div>

	<footer>
		<p>GUARDIANBACKUPVPN &reg;</p>
	</footer>
</body>
</html>
