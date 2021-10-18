<?php header('Content-Type: text/html; charset=utf-8');

	/* 
	 * Verificar e pegar localização do arquivo à incluir. É preciso 
	 * verificar a localização devido aos includes realizados em outras páginas.
	 * Exemplo com array. 
	*/
	$include_dirs = array(
		'../model/dao/carroDAO.php',
		'../../model/dao/carroDAO.php'
	);
	
	foreach ($include_dirs as $include_path) {
		if (@file_exists($include_path)) {
			require_once($include_path);
			break;
		}
	}

	require_once("controller.php");

	// instanciar a classe aqui caso nao seja usada heranca (neste caso esta sendo instanciada no final). a instanciacao eh nos casos via requisicao
	// new CarroController();

	class CarroController extends Controller {

		private $carroDAO;

		function __construct() {
			$this -> carroDAO = new CarroDAO();
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
			return $this -> carroDAO -> listar();
		}

		public function listarCarrosComClientes() {
			return $this -> carroDAO -> listarCarrosComClientes();
		}

		public function pegarCarroPorId($id) {
			return $this -> carroDAO -> pegarCarroPorId($id);
		}

		public function pegarCarroComClientePorId($id) {
			return $this -> carroDAO -> pegarCarroComClientePorId($id);
		}

		private function inserir() {

			// criar um carro com os valores dos parametros vindos de uma requisicao POST (em geral, um formulario)
			$carro = new Carro();
			$carro -> setIdCliente($_POST['id_cliente']);
			$carro -> setNome($_POST['nome']);
			$carro -> setMarca($_POST['marca']);
			$carro -> setAno($_POST['ano']);
			$carro -> setCor($_POST['cor']);
			$carro -> setPlaca($_POST['placa']); // fazer validacao

			// salvar imagem em um diretorio e pegar o caminho dela
			$caminhoImagem = $this -> salvarImagemEPegarCaminho();
			if (!empty($caminhoImagem)) {
				$carro -> setCaminhoImagem($caminhoImagem);
			}
			
			$this -> carroDAO -> inserir($carro); // chamar o dao para inserir o carro no banco de dados

			// criar uma mensagem para ser exibida na página principal (de listagem)
			$mensagem = "O carro " . $carro -> getNome() . " foi adicionado com sucesso!";
			$this -> criarMensagem($mensagem);

			$this -> redirecionarPagina(); // redirecionar para a página principal
		}

		private function atualizar() {
			
			$carro = new Carro();
			$carro -> setId($_POST['id']);
			$carro -> setIdCliente($_POST['id_cliente']);
			$carro -> setNome($_POST['nome']);
			$carro -> setMarca($_POST['marca']);
			$carro -> setAno($_POST['ano']);
			$carro -> setCor($_POST['cor']);
			$carro -> setPlaca($_POST['placa']); // fazer validacao

			$caminhoImagem = $this -> salvarImagemEPegarCaminho();

			if (empty($caminhoImagem)) {
				$carroExistente = $this -> pegarCarroPorId($carro -> getId());
				$caminhoImagem = $carroExistente -> getCaminhoImagem(); // pegar o caminho da imagem ja existente, para nao setar como nula
			}

			$carro -> setCaminhoImagem($caminhoImagem);

			$this -> carroDAO -> atualizar($carro);

			$mensagem = "O carro " . $carro -> getNome() . " foi atualizado com sucesso!";
			$this -> criarMensagem($mensagem);

			$this -> redirecionarPagina();
		}

		private function salvarImagemEPegarCaminho() {
			//Fonte: https://www.w3schools.com/php/php_file_upload.asp

			$config = parse_ini_file("../conf/application.ini"); // ler arquivo de configuracao
			$diretorioUpload = $config['upload_directory']; // diretorio do xampp nao dá permissao para upload. no linux, é preciso dar permissao chmod 777

			$nomeTemporarioImagem = $_FILES["imagem"]["tmp_name"]; // nome do arquivo temporario
			$nomeImagem = $_FILES["imagem"]["name"]; // nome do arquivo
			$caminhoImagem = $diretorioUpload . basename($nomeImagem); // caminho completo para onde o arquivo deve ser movido
			

			$uploadOk = 1;
			$mensagemUpload = "";

			// verificar se a imagem possui formato valido
			$tipoImagem = pathinfo($caminhoImagem, PATHINFO_EXTENSION);
			if ($tipoImagem != "jpg" && $tipoImagem != "png" 
				&& $tipoImagem != "jpeg" && $tipoImagem != "gif" && $tipoImagem != "bmp") {
				    $uploadOk = 0;
			}

			// Check if file already exists
			if (file_exists($caminhoImagem)) {
			    $uploadOk = 0;
			}

			// limitar upload para 500KB
			if ($_FILES["imagem"]["size"] > 500000) {
			    $uploadOk = 0;
			}

			// renomear caminho da imagem adicionando o timestamp, 
			// para que se possa usar uma mesma imagem para varios carros
			$caminhoImagemSplited = explode("." . $tipoImagem, $caminhoImagem);
			$caminhoImagem = $caminhoImagemSplited[0] . "_" . time() . "." . $tipoImagem;

			// mover imagem para o diretorio onde esta sendo feito o upload das imagens
			if ($uploadOk == 1) {
			    if (move_uploaded_file($nomeTemporarioImagem, $caminhoImagem)) {
			    	$mensagemUpload = $caminhoImagem; // string com o caminho da imagem
			    }
			}

			return $mensagemUpload;
		}

		private function deletar() {
			
			$id = $_GET['id'];

			$this -> carroDAO -> deletar($id);

			$mensagem = "O carro foi deletado com sucesso!";
			$this -> criarMensagem($mensagem);

			$this -> redirecionarPagina();
		}

		// redireciona para pagina principal (index.php)
		protected function redirecionarPagina() {
			header("Location:../view");
		}

	}

	// eh preciso instanciar a classe para funcionar o acesso a ela via requisicao
	new CarroController();
	
?>