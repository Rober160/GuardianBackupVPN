<?php
	require "libreria.php";
	$conexion = conexion();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Ver Backups por Usuario</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h1>Consulta de Backups</h1>

	<nav>
		<a href="index.php">Volver al Panel</a>
	</nav>

	<form method="POST">
		<p>Nombre del usuario:</p>
		<input type="text" name="usuario" 
		
		value="<?php
                if (isset($_POST["usuario"])) {
                    echo $_POST["usuario"];
                }
                ?>"
		required><br>
		<input type="submit" name="enviar" value="Buscar Backups">
	</form>

	<div>
		<?php
			if(isset($_POST["enviar"]) && !empty($_POST["usuario"])) {
				$usuario = $_POST["usuario"];
				listarBackupsUsuario($conexion,$usuario);
			}
		?>
	</div>

	<footer>
		<p>GUARDIANBACKUPVPN &reg</p>
	</footer>
</body>
</html>
