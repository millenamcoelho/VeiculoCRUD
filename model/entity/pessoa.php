<?php 

	class Pessoa {

		private $idPessoa;
		private $nome;
		private $email;
		private $dataNascimento;

		public function setIdPessoa($idPessoa) {
			$this -> idPessoa = $idPessoa;
		}

		public function getIdPessoa() {
			return $this -> idPessoa;
		}

		public function setNome($nome) {
			$this -> nome = $nome;
		}

		public function getNome() {
			return $this -> nome;
		}

		public function setEmail($email) {
			$this -> email = $email;
		}

		public function getEmail() {
			return $this -> email;
		}

		// Seta a data no formato d/m/Y. Formato PT-BR.
		public function setDataNascimento($dataNascimentoString) {
			$dataNascimentoString = str_replace('/', '-', $dataNascimentoString);
			$this -> dataNascimento = date('d/m/Y', strtotime($dataNascimentoString));
			// fonte: https://stackoverflow.com/questions/2891937/strtotime-doesnt-work-with-dd-mm-yyyy-format
		}

		public function getDataNascimentoFormatoPTBR() {
			return $this -> dataNascimento;
		}

		// Retorna a data no formato Y-m-d (formato original do tipo date). Usada para operações no banco de dados
		public function getDataNascimento() {
			$this -> dataNascimento = str_replace('/', '-', $this -> dataNascimento);
			$this -> dataNascimento = date('Y-m-d', strtotime($this -> dataNascimento));
			return $this -> dataNascimento;
		}
	}

?>