<?php 

	require_once('pessoa.php');	

	class Usuario extends Pessoa {

		private $id;
		private $tipo;
		private $senha;

		public function setId($id) {
			$this -> id = $id;
		}

		public function getId() {
			return $this -> id;
		}

		public function setTipo($tipo) {
			$this -> tipo = $tipo;
		}

		public function getTipo() {
			return $this -> tipo;
		}

		public function getTipoPorExtenso() {
			$tipo = "Administrador";
			if ($this -> tipo == 'F') {
				$tipo = "Funcionário";
			}
			return $tipo;
		}

		public function setSenha($senha) {
			$this -> senha = $senha;
		}

		public function getSenha() {
			return $this -> senha;
		}
		
	}

?>