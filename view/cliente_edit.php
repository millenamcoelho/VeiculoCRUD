<?php header('Content-Type: text/html; charset=utf-8');

	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../view/login.php");
	}

	require_once("../controller/clienteController.php");

	$id = $_GET['id']; // id que vem da pagina de listagem

	$clienteController = new ClienteController();
	$cliente = $clienteController -> pegarClientePorId($id);
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Editar Cliente</title>
</head>

<body>
	<a href="../view">Home</a> | 
	<a href="cliente_list.php">Clientes</a> | 
	<span>Usuário Logado: <?php echo $_SESSION['login_user']['nome']; ?></span> 
	<br/><br/>
	
	<form method="POST" action="../controller/clienteController.php">
		<table width="35%" border="0">
			<tr> 
				<td>Nome</td>
				<td><input type="text" name="nome" value="<?php echo $cliente -> getNome(); ?>" required></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="email" name="email" value="<?php echo $cliente -> getEmail(); ?>" required></td>
			</tr>
			<tr> 
				<td>Telefone</td>
				<td><input type="number" name="telefone" value="<?php echo $cliente -> getTelefone(); ?>" required></td>
			</tr>
			<tr> 
				<td>Data de Nascimento</td>
				<td>
					<!-- TODO: corrigir: conversao da data, vindo do banco, para o formato date do html5 não está funcionando -->
					<input type="text" name="data_nascimento" value="<?php echo $cliente -> getDataNascimentoFormatoPTBR(); ?>" >
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="id" value="<?php echo $cliente -> getId(); ?>">
					<input type="hidden" name="id_pessoa" value="<?php echo $cliente -> getIdPessoa(); ?>">
					<input type="hidden" name="acao" value="atualizar"> <!-- acao utilizada no controller -->
					<input type="submit" value="Atualizar">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
