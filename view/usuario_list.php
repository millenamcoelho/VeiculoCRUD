<?php header('Content-Type: text/html; charset=utf-8');

	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../view/login.php");
	}

	// Somente usuário ADM tem permissão para acessar esta página
	if ($_SESSION['login_user']['tipo'] != 'ADM') {
		header("location: ../view/sem_permissao.php");
	}

	require_once("../controller/usuarioController.php");

	$usuarioController = new UsuarioController();
	$usuarios = $usuarioController -> listar();
?>

<html lang="pt-br">
<head>	
	<meta charset="utf-8">
	<title>Listagem de Usuários</title>
	<link rel="stylesheet" type="text/css" href="resources/css/estilos.css">
	<script type="text/javascript" src="resources/javascript/funcoes.js"></script>
</head>

<body>
	<a href="../view">Home</a> | 
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
				<th>Data de Nascimento</th>
				<th>Tipo</th>
				<th>Ações</th>
			</tr>
		</thead>

		<tbody>

			<?php if ($usuarios) : ?>

			<?php foreach ($usuarios as $usuario) : ?>
				<tr>
					<td align="center">
						<?php echo $usuario -> getId(); ?>
					</td>
					<td><?php echo $usuario -> getNome(); ?></td>
					<td><?php echo $usuario -> getEmail(); ?></td>
					<td><?php echo $usuario -> getDataNascimentoFormatoPTBR(); ?></td>
					<td><?php echo $usuario -> getTipoPorExtenso(); ?></td>

					<td align="center">
						<a id="deletar" href="javascript:deletarUsuario('<?php echo $usuario -> getIdPessoa(); ?>')">Deletar</a>
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
