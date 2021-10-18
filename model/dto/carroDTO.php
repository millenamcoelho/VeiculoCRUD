<?php header('Content-Type: text/html; charset=utf-8');

	$filePath = '../model/entity/carro.php';
	if (! @file_exists($filePath)) {
		$filePath = '../' . $filePath;
	}

	require_once($filePath);

	/** 
	   Classe que representa um Objeto de Transferência de Dados (DTO). 
	   Utilizada para Relatórios e visualização de dados de um carro.
	   Ajuda a diminuir o uso de mais de uma consulta ao banco de dados 
	   e a evitar adicionar atributos transientes na classe entidade (Carro).
	*/
	class CarroDTO extends Carro {

		// atributo que não existe na entidade/tabela Carro. Usado apenas para transferência de dados
		private $nomeCliente;

		function __construct() {

	 		$argumentos = func_get_args(); // pegar argumentos passados ao construtor

	 		/* 
	 		   PHP não suporta multiplos construtores. 
	 		   Esta é uma maneira de simular múltiplos construtores, em que pegamos 
	 		   a quantidade de argumentos passados ao construtor e direcionamos para algum método.
	 		*/
	 		if (sizeof($argumentos) == 1 && $argumentos[0] instanceof Carro) {
	 			$carro = $argumentos[0];
	 			$this -> criarCarroDTO($carro);
	 		}
		}

		// Setar os atributos de CarroDTO com o Carro passado como parâmetro.
		// esta maneira para criar um CarroDTO foi assim implementada pois o PHP não faz Cast de classe mae para filha.
		private function criarCarroDTO($carro) {

			$this -> setId($carro -> getId());
		    $this -> setIdCliente($carro -> getIdCliente());
			$this -> setNome($carro -> getNome());
			$this -> setMarca($carro -> getMarca());
			$this -> setAno($carro -> getAno());
			$this -> setCor($carro -> getCor());
			$this -> setPlaca($carro -> getPlaca());
			$this -> setCaminhoImagem($carro -> getCaminhoImagem());
		}

		public function setNomeCliente($nomeCliente) {
			$this -> nomeCliente = $nomeCliente;
		}

		public function getNomeCliente() {
			return $this -> nomeCliente;
		}

	}

?>