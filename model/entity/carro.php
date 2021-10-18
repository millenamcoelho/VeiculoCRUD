<?php 

	class Carro {

		private $id;
		private $idCliente;
		private $nome;
		private $marca;
		private $ano;
		private $cor;
		private $placa;
		private $caminhoImagem;

		public function setId($id) {
			$this -> id = $id;
		}

		public function getId() {
			return $this -> id;
		}

		public function setIdCliente($idCliente) {
			$this -> idCliente = $idCliente;
		}

		public function getIdCliente() {
			return $this -> idCliente;
		}

		public function setNome($nome) {
			$this -> nome = $nome;
		}

		public function getNome() {
			return $this -> nome;
		}

		public function setMarca($marca) {
			$this -> marca = $marca;
		}

		public function getMarca() {
			return $this -> marca;
		}

		public function setAno($ano) {
			$this -> ano = $ano;
		}

		public function getAno() {
			return $this -> ano;
		}

		public function setCor($cor) {
			$this -> cor = $cor;
		}

		public function getCor() {
			return $this -> cor;
		}

		public function setPlaca($placa) {
			$this -> placa = $placa;
		}

		public function getPlaca() {
			return $this -> placa;
		}

		public function setCaminhoImagem($caminhoImagem) {
			$this -> caminhoImagem = $caminhoImagem;
		}

		public function getCaminhoImagem() {
			return $this -> caminhoImagem;
		}
		
	}

?>