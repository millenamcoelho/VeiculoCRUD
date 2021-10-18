<?php header('Content-Type: text/html; charset=utf-8');

	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../view/login.php");
	}

	require_once("../controller/carroController.php");

	$carroController = new CarroController();
	$carros = $carroController -> listar();
?>

<html lang="pt-br">
<head>	
	<meta charset="utf-8">
	<title>Homepage da Concessionária</title>
	<link rel="stylesheet" type="text/css" href="resources/css/estilos.css">
	<script type="text/javascript" src="resources/javascript/funcoes.js"></script>
</head>

<body>
	<a href="carro_create.php">Adicionar um Carro</a> | 
	<a href="cliente_list.php">Clientes</a> | 

	<?php 
		// Somente usuário ADM tem permissão para acessar este link
		if ($_SESSION['login_user']['tipo'] == 'ADM') {
			echo "<a href='usuario_list.php'>Usuários</a> | ";
		}
	?>

	<a href="report/carros.php" target="_blank">Gerar PDF</a> | 
	<a href="../controller/loginController.php?acao=logout">Deslogar</a> | 
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
				<th>Marca</th>
				<th>Ano</th>
				<th>Cor</th>
				<th>Placa</th>
				<th>Ações</th>
			</tr>
		</thead>

		<tbody>

			<?php if ($carros) : ?>

			<?php foreach ($carros as $carro) : ?>
				<tr>
					<td align="center">
						<?php echo $carro -> getId(); ?>
					</td>
					<td><?php echo $carro -> getNome(); ?></td>
					<td><?php echo $carro -> getMarca(); ?></td>
					<td><?php echo $carro -> getAno(); ?></td>
					<td><?php echo $carro -> getCor(); ?></td>
					<td><?php echo $carro -> getPlaca(); ?></td>

					<td align="center">
						<a id="visualizar" href="javascript:visualizar('<?php echo $carro -> getId(); ?>')">Visualizar</a> |
						<a id="editar" href="javascript:editar('<?php echo $carro -> getId(); ?>')">Editar</a> |
						<a id="deletar" href="javascript:deletar('<?php echo $carro -> getId(); ?>')">Deletar</a>
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
