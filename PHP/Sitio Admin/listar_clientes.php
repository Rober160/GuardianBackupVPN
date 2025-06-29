<?php
	require "libreria.php";
	$conexion = conexion();

	$consulta = listar();
	$resultado = mysqli_query($conexion,$consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Lista de Clientes</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<h1>Listado de Clientes</h1>

	<nav>
		<a href="index.php">Volver al Panel</a>
	</nav>

	<?php
		if (mysqli_num_rows($resultado) > 0) {
			echo "<table>";
				echo "<tr>";
				echo "<th>ID</th>";
				echo "<th>Usuario</th>";
				echo "</tr>";

			while ($fila = mysqli_fetch_assoc($resultado)) {
				echo "<tr>";
					echo "<td>" . $fila["id"] . "</td>";
					echo "<td>" . $fila["usuario"] . "</td>";
				echo "</tr>";
			}

			echo "</table>";
		} else {
			echo "<p>No hay clientes registrados</p>";
		}
	?>

	<footer>
		<p>GUARDIANBACKUPVPN &reg</p>
	</footer>
</body>
</html>
