<?php

	session_start();
	if (isset($_SESSION['login_user'])) {
		header("location:../view");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="resources/css/estilos.css">
</head>
<body>

<form action="../controller/loginController.php" method="POST">

	<label>Email:</label>
	<input id="email" name="email" placeholder="E-Mail do Usuário" type="text">
	<label>Senha:</label>
	<input id="senha" name="senha" placeholder="Senha do Usuário" type="password">

	<input type="hidden" name="acao" value="logar">
	<input type="submit" value="Logar"> | 
	<a href="../view/usuario_cadastro.php">Cadastrar-se</a>
	<br/><br/>

	<div class="messages_error">
		<?php

			if(isset($_COOKIE["message"])) {
			    $msg = $_COOKIE["message"] . "<br/><br/>";
			    setcookie("message", "", time() - 60, '/'); // expirar o cookie
			} else {
			    $msg = "";
			}

			echo $msg;
		?>
	</div>

</form>

</body>
</html>