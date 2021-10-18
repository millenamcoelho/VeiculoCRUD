<?php 

	require_once('conexao.php');
	require_once('../model/entity/usuario.php');
	
	class UsuarioDAO extends Conexao {

		public function inserir($usuario) {

			$foiInserido = false;
			$this -> conectar();

			$stmt = $this -> conexao -> prepare("INSERT INTO pessoa (nome, email, data_nascimento) VALUES (?, ?, ?)");
			$stmt -> bind_param("sss", $usuario -> getNome(), $usuario -> getEmail(), $usuario -> getDataNascimento());

			if ($stmt -> execute() === TRUE) {
			    $idPessoa = $this -> conexao -> insert_id; // pegar o id da pessoa inserida
			    $usuario -> setIdPessoa($idPessoa);
			}
			
			// inserir usuario com o id da pessoa inserida
			if ($usuario -> getIdPessoa() != NULL) {

				$senhaEncriptada = base64_encode($usuario -> getSenha()); // encriptar para base64
				
				$stmt = $this -> conexao -> prepare("INSERT INTO usuario (id_pessoa, tipo, senha) VALUES (?, ?, ?)");
				$stmt -> bind_param("iss", $usuario -> getIdPessoa(), $usuario -> getTipo(), $senhaEncriptada);

				if ($stmt -> execute() === TRUE) $foiInserido = true;
			}

			$stmt -> close();
		    $this -> desconectar();

		    return $foiInserido;
		}

		public function pegarUsuarioPorEmailSenha($email, $senha) {
			$this -> conectar();

			$senha = base64_encode($senha); // codificar para base64

			// $sql = "SELECT * FROM usuario WHERE email = ? AND senha = ? LIMIT 1";
			$sql = "SELECT u.id, u.id_pessoa, u.tipo, u.senha, p.nome, p.email, p.data_nascimento  
				FROM usuario u, pessoa p 
				WHERE u.id_pessoa = p.id AND p.email = ? AND u.senha = ? LIMIT 1";

			$stmt = $this -> conexao -> prepare($sql);
			$stmt -> bind_param("ss", $email, $senha);
			$stmt -> execute();

			$resultado = $stmt -> get_result(); 

			// caso as linhas acima dêem erro com o prepared statement, devido a versao do php (na 7 funciona), usar:
			// $sql = "SELECT * FROM usuario WHERE email = '" .$email. "' AND senha = '" .$senha. "' LIMIT 1";
			// $resultado = $this -> conexao -> query($sql);

			$usuario = new Usuario();
			while ($row = $resultado -> fetch_assoc()) {
				$usuario = $this -> criarUsuarioDeArray($row);
			}

			$stmt -> close();
			$this -> desconectar();

			return $usuario;
		}

		public function listar() {
			$this -> conectar();

			$sql = "SELECT u.id, u.id_pessoa, u.tipo, u.senha, p.nome, p.email, p.data_nascimento 
				FROM usuario u, pessoa p 
				WHERE u.id_pessoa = p.id 
				ORDER BY u.id;";
				
			$resultado = $this -> conexao -> query($sql);

		    $lista_usuario = array();
			while ($row = $resultado -> fetch_assoc()) {
				$usuario = $this -> criarUsuarioDeArray($row);
			    $lista_usuario[] = $usuario;
			}

			$this -> desconectar();

			return $lista_usuario;
		}

		private function criarUsuarioDeArray($row) {
		    
		    $usuario = new Usuario();
		    $usuario -> setId($row["id"]);
		    $usuario -> setIdPessoa($row["id_pessoa"]);
			$usuario -> setNome($row["nome"]);
			$usuario -> setEmail($row["email"]);
			$usuario -> setDataNascimento($row["data_nascimento"]);
			$usuario -> setTipo($row["tipo"]);
			$usuario -> setSenha(base64_decode($row["senha"])); // decodificar senha
			
		    return $usuario; 
		}

		public function deletar($idPessoa) {

			$foiDeletado = false;
			$this -> conectar();

			$sql = "DELETE FROM pessoa WHERE id = " . $idPessoa; // deletar o usuario em cascata

			if ($this -> conexao -> query($sql) === TRUE) {
				$foiDeletado = true;
			    echo "Registro deletado com sucesso!<br>";
			} else {
			    echo "Erro ao tentar deletar registro: " . $this -> conexao -> error;
			}

			$this -> desconectar();

			return $foiDeletado;
		}

	}

 ?>