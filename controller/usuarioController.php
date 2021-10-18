<?php header('Content-Type: text/html; charset=utf-8');

	require_once("controller.php");
	require_once("../model/dao/usuarioDAO.php");

	class UsuarioController extends Controller {

		private $usuarioDAO;

		function __construct() {
			$this -> usuarioDAO = new UsuarioDAO();
			parent :: __construct(); // chamar construtor da classe mae de maneira estatica (::)
		}

		protected function processarAcao() {

			switch ($this -> acao) {
				case "cadastrar":
			        $this -> cadastrarFuncionario();
					break;
				case "deletar":
			        $this -> deletar();
					break;
			}
		}

		public function listar() {
			return $this -> usuarioDAO -> listar();
		}

		private function cadastrarFuncionario() {

			$usuario = new Usuario();
			$usuario -> setNome($_POST['nome']);
			$usuario -> setEmail($_POST['email']);
			$usuario -> setSenha($_POST['senha']);
			$usuario -> setDataNascimento($_POST['data_nascimento']);

			$usuario -> setTipo('F'); // Usuário a ser cadastrado será F (Funcionário) como padrão

			$foiInserido = $this -> usuarioDAO -> inserir($usuario);

			// criar uma mensagem para ser exibida na página
			$mensagem = "O usuário " . $usuario -> getNome() . " foi adicionado com sucesso! Faça o login para ter acesso ao sistema.";
			if ($foiInserido == false) $mensagem = "Erro ao cadastrar usuário! Talvez o e-mail informado já esteja sendo utilizado.";
			$this -> criarMensagem($mensagem);

			header("Location:../view/login.php");
		}

		private function deletar() {
			
			$idPessoa = $_GET['id_pessoa'];

			$foiDeletado = $this -> usuarioDAO -> deletar($idPessoa);

			// criar uma mensagem para ser exibida na página principal (de listagem)
			$mensagem = "O usuário foi deletado com sucesso!";
			if ($foiDeletado == false) $mensagem = "Erro ao deletar usuário!";
			$this -> criarMensagem($mensagem);

			$this -> redirecionarPagina();
		}

		protected function redirecionarPagina() {
			header("Location:../view/usuario_list.php");
		}

	}

	// eh preciso instanciar a classe para funcionar o acesso a ela via requisicao
	new UsuarioController();

?>