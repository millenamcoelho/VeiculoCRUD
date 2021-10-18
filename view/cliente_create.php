<?php header('Content-Type: text/html; charset=utf-8');

	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../view/login.php");
	}
?>

<html>
<head>
	<title>Adicionar Cliente</title>
</head>

<body>
	<a href="../view">Home</a> | 
	<a href="cliente_list.php">Clientes</a> | 
	<span>Usuário Logado: <?php echo $_SESSION['login_user']['nome']; ?></span> 
	<br/><br/>

	<form action="../controller/clienteController.php" method="POST">
		<table width="35%" border="0">
			<tr> 
				<td>Nome</td>
				<td><input type="text" name="nome" required></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="email" name="email" required></td>
			</tr>
			<tr> 
				<td>Telefone</td>
				<td><input type="number" name="telefone" required></td>
			</tr>
			<tr> 
				<td>Data de Nascimento</td>
				<td><input type="date" name="data_nascimento"></td>
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

