<?php header("Content-type: text/html; charset=utf-8");

	require_once('pessoa.php');

	/** Cliente tem id e idPessoa. Como cliente herda de Pessoa, o ideal seria cliente ter apenas o idPessoa
	    (como se a chave estrangeira servisse como primária), pois cliente é uma pessoa, e todas as operações 
	    crud se basearem nisso. Contudo, na implementação desse exemplo, foi seguida da forma mais utilizada 
	    nos fóruns na web, e também mais ou menos na forma indicada para hibernate (Java), em que herança não 
	    é indicada e usasse composição, tornando cliente e pessoa entidades distintas. Obs.: esta implementação
	    não é de composição, é uma herança em que o cliente tem seu próprio id, em vez de usar o idPessoa somente.
	*/
	class Cliente extends Pessoa {

		private $id;
		private $telefone;

		public function setId($id) {
			$this -> id = $id;
		}

		public function getId() {
			return $this -> id;
		}

		public function setTelefone($telefone) {
			$this -> telefone = $telefone;
		}

		public function getTelefone() {
			return $this -> telefone;
		}
		
	}

?>