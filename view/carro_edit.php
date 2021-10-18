<?php header('Content-Type: text/html; charset=utf-8');

	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../view/login.php");
	}

	require_once("../controller/carroController.php");

	$id = $_GET['id']; // id que vem da pagina de listagem

	$carroController = new CarroController();
	$carro = $carroController -> pegarCarroPorId($id);

	require_once("../controller/clienteController.php");

	$clienteController = new ClienteController();
	$clientes = $clienteController -> listar();
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Editar Carro</title>
</head>

<body>
	<a href="../view">Home</a> | <span>Usuário Logado: <?php echo $_SESSION['login_user']['nome']; ?></span> 
	<br/><br/>
	
	<form method="POST" action="../controller/carroController.php" enctype="multipart/form-data">
		<table width="35%" border="0">
			<tr> 
				<td>Nome</td>
				<td><input type="text" name="nome" value="<?php echo $carro -> getNome(); ?>" required></td>
			</tr>
			<tr> 
				<td>Marca</td>
				<td><input type="text" name="marca" value="<?php echo $carro -> getMarca(); ?>" required></td>
			</tr>
			<tr> 
				<td>Ano</td>
				<td><input type="number" name="ano" value="<?php echo $carro -> getAno(); ?>" required></td>
			</tr>
			<tr> 
				<td>Cor</td>
				<td><input type="text" name="cor" value="<?php echo $carro -> getCor(); ?>"></td>
			</tr>
			<tr> 
				<td>Placa</td>
				<td><input type="text" name="placa" value="<?php echo $carro -> getPlaca(); ?>" required></td>
			</tr>
			<tr> 
				<td>Cliente</td>
				<td>
					<!-- TODO: usar input datalist ou ajax para autocompletar -->
					<select name="id_cliente" required>

						<?php foreach ($clientes as $cliente) : ?>

							<option value = <?php echo $cliente -> getId(); ?> 
								<?php echo ($cliente -> getId() == $carro -> getIdCliente()) ? 'selected' : ''; ?> >
									<?php echo $cliente -> getNome(); ?>
							</option>

						<?php endforeach; ?>

					</select>
				</td>
			</tr>
			<tr> 
				<td>Imagem (jpg, jpeg, png, gif, bmp)</td>
				<td><input type="file" name="imagem" id="imagem"></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="id" value="<?php echo $carro -> getId(); ?>">
					<input type="hidden" name="acao" value="atualizar"> <!-- acao utilizada no controller -->
					<input type="submit" value="Atualizar">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
