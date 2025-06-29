<?php
	require "libreria.php";
	$conexion = conexion();
	$mensaje = "";

	if(isset($_POST["eliminar"])) {
		$idEliminar = (int) $_POST["id_usuario"];
		$eliminar = "delete from usuarios where id = $idEliminar";
		$resultado = mysqli_query($conexion,$eliminar);

		if(mysqli_affected_rows($conexion) == 1) {
			$mensaje = "✅ Usuario eliminado correctamente.";
		} else {
			$mensaje = "❌ Error al eliminar el usuario.";
		}
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Dar de Baja Usuarios</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h1>Dar de Baja un Usuario</h1>

	<nav>
		<a href="index.php">Volver al Panel</a>
	</nav>

	<form method="POST">
		<p>Nombre del usuario:</p>
		<input type="text" name="usuario" required><br>
		<input type="submit" name="buscar" value="Buscar Usuario">
	</form>

	<div>
		<?php echo $mensaje;?>
	</div>

	<?php
		if(isset($_POST["buscar"]) && !empty($_POST["usuario"])) {
			$usuario = $_POST["usuario"];
			mostrarUsuarioBaja($conexion,$usuario);
		}
	?>

	<footer>
		<p>GUARDIANBACKUPVPN &reg</p>
	</footer>
</body>
</html>
