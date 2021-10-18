<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Cadastrar Usuário</title>
</head>

<body>
	<a href="../view">Voltar</a>
	<br/><br/>

	<form action="../controller/usuarioController.php" method="POST">
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
				<td>Data de Nascimento</td>
				<td><input type="date" name="data_nascimento"></td>
			</tr>
			<tr> 
				<td>Senha</td>
				<td><input type="password" name="senha" required></td>
			</tr>
			<tr> 
				<td></td>
				<td>
					<input type="hidden" name="acao" value="cadastrar">
					<input type="submit" value="Cadastrar">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>

