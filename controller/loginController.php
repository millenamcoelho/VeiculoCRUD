<?php header('Content-Type: text/html; charset=utf-8');

	require_once("controller.php");
	require_once("../model/dao/usuarioDAO.php");

	// Instanciar a classe aqui caso nao seja usada heranca (neste caso esta sendo instanciada no final). 
	// A instanciacao eh nos casos via requisicao.
	// new LoginController();

	class LoginController extends Controller {

		protected function processarAcao() {

			switch ($this -> acao) {
			    case "logar":
			        $this -> logar();
			        break;
			    case "logout":
			        $this -> logout();
			        break;
			}
		}

		private function logar() {

			if (empty($_POST['email']) || empty($_POST['senha'])) {
				$mensagem = "E-Mail do Usuário e senha são obrigatórios";
				$this -> criarMensagem($mensagem);

			} else {

				$email = $_POST['email'];
				$senha = $_POST['senha'];

				$usuarioDAO = new UsuarioDAO();
				$usuario = $usuarioDAO -> pegarUsuarioPorEmailSenha($email, $senha);
				
				if ($usuario -> getNome() != NULL) {

					session_start();
					//$_SESSION['login_user'] = $usuario -> getNome(); // Initializing Session
					$_SESSION['login_user'] = array(); // Initializing Session com array, para armazenar variaveis de sessao
					$_SESSION['login_user']['nome'] = $usuario -> getNome();
					$_SESSION['login_user']['tipo'] = $usuario -> getTipo();
					$this -> redirecionarPagina();

				} else {
					$mensagem = "E-Mail do Usuário ou senha inválida";
					$this -> criarMensagem($mensagem);
				}
			}

			header("Location: ../view/login.php");
		}

		private function logout() {
			
			session_start();
			if (session_destroy()) { 				   // Destroying All Sessions
				header("Location: ../view/login.php"); // Redirecting To Home Page
			}
		}

		// redireciona para pagina principal (index.php)
		protected function redirecionarPagina() {
			header("Location:../view");
		}

	}

	// eh preciso instanciar a classe para funcionar o acesso a ela via requisicao
	new LoginController();

?>