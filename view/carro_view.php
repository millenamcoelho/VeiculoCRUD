<?php header('Content-Type: text/html; charset=utf-8');

	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../view/login.php");
	}

	require_once("../controller/carroController.php");

	$id = $_GET['id']; // id que vem da pagina de listagem

	$carroController = new CarroController();
	$carroDTO = $carroController -> pegarCarroComClientePorId($id);
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Visualizar Carro</title>
</head>

<body>
	<a href="../view">Home</a> | <span>Usuário Logado: <?php echo $_SESSION['login_user']['nome']; ?></span> 
	<br/><br/>
	<table width="35%" border="0">
		<tr> 
			<td>Nome</td>
			<td><input type="text" value="<?php echo $carroDTO -> getNome(); ?>" readonly></td>
		</tr>
		<tr> 
			<td>Marca</td>
			<td><input type="text" value="<?php echo $carroDTO -> getMarca(); ?>" readonly></td>
		</tr>
		<tr> 
			<td>Ano</td>
			<td><input type="number" value="<?php echo $carroDTO -> getAno(); ?>" readonly></td>
		</tr>
		<tr> 
			<td>Cor</td>
			<td><input type="text" value="<?php echo $carroDTO -> getCor(); ?>"></td>
		</tr>
		<tr> 
			<td>Placa</td>
			<td><input type="text" value="<?php echo $carroDTO -> getPlaca(); ?>" readonly></td>
		</tr>
		<tr> 
			<td>Cliente</td>
			<td><input type="text" value="<?php echo $carroDTO -> getNomeCliente(); ?>" readonly></td>
		</tr>
		<tr>
			<td>Imagem</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php
					$imagem = $carroDTO -> getCaminhoImagem();
					if ($imagem != null) {
						$imagemData = base64_encode(file_get_contents($imagem));
						echo '<img width="500" height="400" src="data:image/jpeg;base64,' . $imagemData . '">';
					}
				?>
			</td>
		</tr>
	</table>
</body>
</html>
