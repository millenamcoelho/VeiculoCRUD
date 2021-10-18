<?php header('Content-Type: text/html; charset=utf-8');

	require_once("controller.php");
	require_once("../model/dao/clienteDAO.php");

	class ClienteController extends Controller {

		private $clienteDAO;

		function __construct() {
			$this -> clienteDAO = new ClienteDAO();
			parent :: __construct(); // chamar construtor da classe mae de maneira estatica (::)
		}

		protected function processarAcao() {

			switch ($this -> acao) {
			    case "inserir":
			        $this -> inserir();
			        break;
			    case "atualizar":
			        $this -> atualizar();
			        break;
			    case "deletar":
			        $this -> deletar();
			        break;
			}
		}

		public function listar() {
			return $this -> clienteDAO -> listar();
		}

		public function pegarClientePorId($id) {
			return $this -> clienteDAO -> pegarClientePorId($id);
		}

		private function inserir() {

			$cliente = new Cliente();
			$cliente -> setNome($_POST['nome']);
			$cliente -> setEmail($_POST['email']);
			$cliente -> setTelefone($_POST['telefone']);
			$cliente -> setDataNascimento($_POST['data_nascimento']);

			$foiInserido = $this -> clienteDAO -> inserir($cliente); // chamar o dao para inserir o cliente no banco de dados

			// criar uma mensagem para ser exibida na página principal (de listagem)
			$mensagem = "O cliente " . $cliente -> getNome() . " foi adicionado com sucesso!";
			if ($foiInserido == false) $mensagem = "Erro ao adicionar cliente!";
			$this -> criarMensagem($mensagem);

			$this -> redirecionarPagina();
		}

		private function atualizar() {
			
			$cliente = new Cliente();
			$cliente -> setId($_POST['id']);
			$cliente -> setIdPessoa($_POST['id_pessoa']);
			$cliente -> setNome($_POST['nome']);
			$cliente -> setEmail($_POST['email']);
			$cliente -> setTelefone($_POST['telefone']);
			$cliente -> setDataNascimento($_POST['data_nascimento']);

			$foiAtualizado = $this -> clienteDAO -> atualizar($cliente);

			$mensagem = "O cliente " . $cliente -> getNome() . " foi atualizado com sucesso!";
			if ($foiAtualizado == false) $mensagem = "Erro ao atualizar cliente!";
			$this -> criarMensagem($mensagem);

			$this -> redirecionarPagina();
		}

		private function deletar() {
			
			$idPessoa = $_GET['id_pessoa'];

			$foiDeletado = $this -> clienteDAO -> deletar($idPessoa);

			// criar uma mensagem para ser exibida na página principal (de listagem)
			$mensagem = "O cliente foi deletado com sucesso!";
			if ($foiDeletado == false) $mensagem = "Erro ao deletar cliente!";
			$this -> criarMensagem($mensagem);

			$this -> redirecionarPagina();
		}

		// redirecionar para a página de listagem de clientes
		protected function redirecionarPagina() {
			header("Location:../view/cliente_list.php");
		}

	}

	// eh preciso instanciar a classe para funcionar o acesso a ela via requisicao
	new ClienteController();

?>