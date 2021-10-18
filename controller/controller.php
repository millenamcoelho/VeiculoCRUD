<?php header('Content-Type: text/html; charset=utf-8');

	abstract class Controller {

		protected $acao;

		function __construct() {
			$this -> acao = "";

			if (isset($_POST['acao'])) {
				$this -> acao = $_POST["acao"];

			} elseif (isset($_GET['acao'])) {
				$this -> acao = $_GET["acao"];
			}

			if (!empty($this -> acao)) {
				$this -> processarAcao();
			}
		}

		abstract protected function processarAcao();

		// redirecionar para outra pagina (view)
		abstract protected function redirecionarPagina();

		// criar cookie de duracao por 1 minuto. O "/" significa que esta disponivel em todo aplicacao
		protected function criarMensagem($mensagem) {

			$tempoExpiracao = time() + 60;
			setcookie("message", $mensagem, $tempoExpiracao, "/");
		}
	}

?>