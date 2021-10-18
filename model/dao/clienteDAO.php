<?php 

	require_once('conexao.php');
	require_once('../model/entity/cliente.php');
	
	class ClienteDAO extends Conexao {

		function inserir($cliente) {

			$foiInserido = false;
			$this -> conectar();

			// inserir pessoa
			$stmt = $this -> conexao -> prepare("INSERT INTO pessoa (nome, email, data_nascimento) VALUES (?, ?, ?)");
			$stmt -> bind_param("sss", $cliente -> getNome(), $cliente -> getEmail(), $cliente -> getDataNascimento());

			if ($stmt -> execute() === TRUE) {
			    $idPessoa = $this -> conexao -> insert_id; // pegar o id da pessoa inserida
			    $cliente -> setIdPessoa($idPessoa);
			}
			
			// inserir cliente com o id da pessoa inserida
			if ($cliente -> getIdPessoa() != NULL) {
				
				$stmt = $this -> conexao -> prepare("INSERT INTO cliente (id_pessoa, telefone) VALUES (?, ?)");
				$stmt -> bind_param("ii", $cliente -> getIdPessoa(), $cliente -> getTelefone());

				if ($stmt -> execute() === TRUE) $foiInserido = true;
			}

			$stmt -> close();
		    $this -> desconectar();

		    return $foiInserido;
		}

		function atualizar($cliente) {

			$foiAtualizado = false;
			$this -> conectar();

			// atualizar pessoa
			$stmt = $this -> conexao -> prepare("UPDATE pessoa SET nome = ? , email = ? , data_nascimento = ? WHERE id = ?");
			$stmt -> bind_param("sssi", $cliente -> getNome(), $cliente -> getEmail(), 
				$cliente -> getDataNascimento(), $cliente -> getIdPessoa());
			$stmt -> execute();

			// atualizar cliente
			$stmt = $this -> conexao -> prepare("UPDATE cliente SET telefone = ? WHERE id = ?");
			$stmt -> bind_param("ii", $cliente -> getTelefone(), $cliente -> getId());

			if ($stmt -> execute() === TRUE) $foiAtualizado = true;

			$stmt -> close();
			$this -> desconectar();

			return $foiAtualizado;
		}

		public function listar() {
			$this -> conectar();

			$sql = "SELECT c.id, c.id_pessoa, c.telefone, p.nome, p.email, p.data_nascimento FROM cliente c, pessoa p 
				WHERE c.id_pessoa = p.id;";
			$resultado = $this -> conexao -> query($sql);

		    $lista_cliente = array();
			while ($row = $resultado -> fetch_assoc()) {
				$cliente = $this -> criarClienteDeArray($row);
			    $lista_cliente[] = $cliente;
			}

			$this -> desconectar();

			return $lista_cliente;
		}

		public function pegarClientePorId($id) {
			$this -> conectar();

			$stmt = $this -> conexao -> prepare("SELECT c.id, c.id_pessoa, c.telefone, p.nome, p.email, p.data_nascimento 
				FROM cliente c, pessoa p WHERE c.id_pessoa = p.id AND c.id = ? LIMIT 1");
			$stmt -> bind_param("i", $id);
			$stmt -> execute();
			$resultado = $stmt -> get_result();

			$cliente = new Cliente();
			while ($row = $resultado -> fetch_assoc()) {
				$cliente = $this -> criarClienteDeArray($row);
			}

			$stmt -> close();
			$this -> desconectar();

			return $cliente;
		}

		private function criarClienteDeArray($row) {
		    
		    $cliente = new Cliente();
		    $cliente -> setId($row["id"]);
		    $cliente -> setIdPessoa($row["id_pessoa"]);
			$cliente -> setNome($row["nome"]);
			$cliente -> setEmail($row["email"]);
			$cliente -> setTelefone($row["telefone"]);
			$cliente -> setDataNascimento($row["data_nascimento"]);

		    return $cliente; 
		}

		public function deletar($idPessoa) {

			$foiDeletado = false;
			$this -> conectar();

			$sql = "DELETE FROM pessoa WHERE id = " . $idPessoa; // deletar o cliente em cascata

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