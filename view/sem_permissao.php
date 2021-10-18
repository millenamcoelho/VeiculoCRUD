<?php
	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../view/login.php");
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Sem permissão de acesso</title>
</head>
<body>

	<h1>Você não tem permissão para acessar esta página. Caso queira ter acesso, falar com o Administrador.</h1>

	<a href="../view">Voltar</a>

</body>
</html>

