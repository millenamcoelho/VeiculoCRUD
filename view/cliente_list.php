<?php header('Content-Type: text/html; charset=utf-8');

	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../view/login.php");
	}

	require_once("../controller/clienteController.php");

	$clienteController = new ClienteController();
	$clientes = $clienteController -> listar();
?>

<html lang="pt-br">
<head>	
	<meta charset="utf-8">
	<title>Listagem de Clientes</title>
	<link rel="stylesheet" type="text/css" href="resources/css/estilos.css">
	<script type="text/javascript" src="resources/javascript/funcoes.js"></script>
</head>

<body>
	<a href="../view">Home</a> | 
	<a href="cliente_create.php">Adicionar um Cliente</a> | 
	<span>Bem-vindo, <?php echo $_SESSION['login_user']['nome']; ?>!</span> 
	<br/><br/>

	<div class="messages">
		<?php
			// TODO: ao clicar em voltar, a mensagem continua. fazer com session array
			if(isset($_COOKIE["message"])) {
			    $msg = $_COOKIE["message"] . "<br/><br/>";
			    setcookie("message", "", time() - 60, '/'); // expirar o cookie
			} else {
			    $msg = "";
			}

			echo $msg;
		?>
	</div>

	<table width='80%' border=0>
		<thead>
			<tr bgcolor='#CCCCCC'>
				<th>ID</th>
				<th>Nome</th>
				<th>Email</th>
				<th>Telefone</th>
				<th>Data de Nascimento</th>
				<th>Ações</th>
			</tr>
		</thead>

		<tbody>

			<?php if ($clientes) : ?>

			<?php foreach ($clientes as $cliente) : ?>
				<tr>
					<td align="center">
						<?php echo $cliente -> getId(); ?>
					</td>
					<td><?php echo $cliente -> getNome(); ?></td>
					<td><?php echo $cliente -> getEmail(); ?></td>
					<td><?php echo $cliente -> getTelefone(); ?></td>
					<td><?php echo $cliente -> getDataNascimentoFormatoPTBR(); ?></td>

					<td align="center">
						<a id="editar" href="javascript:editarCliente('<?php echo $cliente -> getId(); ?>')">Editar</a> |
						<a id="deletar" href="javascript:deletarCliente('<?php echo $cliente -> getIdPessoa(); ?>')">Deletar</a>
					</td>
				</tr>
			<?php endforeach; ?>

			<?php else : ?>
				<tr>
					<td colspan="6">Nenhum registro encontrado.</td>
				</tr>
			<?php endif; ?>

		</tbody>
	</table>

</body>
</html>
