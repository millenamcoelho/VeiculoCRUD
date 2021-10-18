<?php header('Content-Type: text/html; charset=utf-8');

	class Conexao {

		private $servername;
		private $username;
		private $password;
		private $db_name;
		protected $conexao;

		function __construct() {

			/* 
			 * Verificar e pegar localização do arquivo de configuração. É preciso 
			 * verificar a localização devido aos includes realizados em outras páginas. 
			*/
			$filePath = '../conf/application.ini';
			if (! @file_exists($filePath)) {
				$filePath = '../' . $filePath;
			}

			// ler arquivo de configuracao
			$config = parse_ini_file($filePath);

			// Ler e pegar configurações
			$this -> servername = $config['servername'];
		    $this -> username = $config['username'];
		    $this -> password = $config['password'];
		    $this -> db_name = $config['db_name'];

		    // $this -> conectar();
		}

		protected function conectar() {

			// Create connection with mysqli
			$this -> conexao = new mysqli($this -> servername, $this -> username, 
				$this -> password, $this -> db_name);

			// Check connection
			if ($this -> conexao -> connect_error) {
			    die("Falha na conexão: " . $this -> conexao -> connect_error);
			}

			$this -> conexao -> set_charset("utf8");
			// echo "Conexão realizada com sucesso!<br>";
		}

		protected function desconectar() {

			// close connection with mysqli
			$this -> conexao -> close();
			// echo "Fechando conexão com o banco.";
		}

	}

?>