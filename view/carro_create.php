<?php header('Content-Type: text/html; charset=utf-8');

	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../view/login.php");
	}

	require_once("../controller/clienteController.php");

	$clienteController = new ClienteController();
	$clientes = $clienteController -> listar();

?>

<html>
<head>
	<title>Adicionar Carro</title>
</head>

<body>
	<a href="../view">Home</a> | <span>Usuário Logado: <?php echo $_SESSION['login_user']['nome']; ?></span> 
	<br/><br/>

	<form action="../controller/carroController.php" method="POST" enctype="multipart/form-data">
		<table width="35%" border="0">
			<tr> 
				<td>Nome</td>
				<td><input type="text" name="nome" required></td>
			</tr>
			<tr> 
				<td>Marca</td>
				<td><input type="text" name="marca" required></td>
			</tr>
			<tr> 
				<td>Ano</td>
				<td><input type="number" name="ano" required></td>
			</tr>
			<tr> 
				<td>Cor</td>
				<td><input type="text" name="cor"></td>
			</tr>
			<tr> 
				<td>Placa</td>
				<td><input type="text" name="placa" required></td>
			</tr>
			<tr> 
				<td>Cliente</td>
				<td>
					<!-- TODO: usar input datalist ou ajax para autocompletar -->
					<select name="id_cliente" required>
						<option value="">Selecione um cliente</option>

						<?php foreach ($clientes as $cliente) : ?>

							<option value = <?php echo $cliente -> getId(); ?> >
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
					<input type="hidden" name="acao" value="inserir">
					<input type="submit" value="Salvar">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>

