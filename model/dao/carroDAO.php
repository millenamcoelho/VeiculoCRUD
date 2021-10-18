<?php header('Content-Type: text/html; charset=utf-8');

	/* 
	 * Verificar e pegar localização do arquivo à incluir. É preciso 
	 * verificar a localização devido aos includes realizados em outras páginas.
	 * Exemplo com array. 
	*/
	$include_dirs = array(
		'../model/entity/carro.php',
		'../../model/entity/carro.php',
		'../model/dto/carroDTO.php',
		'../../model/dto/carroDTO.php'
	);
	
	foreach ($include_dirs as $include_path) {
		if (@file_exists($include_path)) {
			require_once($include_path);
		}
	}

	require_once('conexao.php');
	
	class CarroDAO extends Conexao {

		function inserir($carro) {
			$this -> conectar();

			$stmt = $this -> conexao -> prepare("INSERT INTO carro (id_cliente, nome, marca, ano, cor, placa, caminho_imagem) 
				VALUES (?, ?, ?, ?, ?, ?, ?)");
			$stmt -> bind_param("ississs", $carro -> getIdCliente(), $carro -> getNome(), $carro -> getMarca(), 
				$carro -> getAno(), $carro -> getCor(), $carro -> getPlaca(), $carro -> getCaminhoImagem());

			// TODO: colocar log no lugar de echo
			if ($stmt -> execute() === TRUE) {
			    echo "<font color='green'>O carro " . $carro -> getNome() . " foi inserido com sucesso!<br>";
			} else {
			    echo "Erro na inserção do carro.<br>";
			}

			$stmt -> close();
		    $this -> desconectar();
		}

		function atualizar($carro) {
			$this -> conectar();

			$stmt = $this -> conexao -> prepare("UPDATE carro SET id_cliente = ?, nome = ? ,  
				marca = ? , ano = ? , cor = ? , placa = ?, caminho_imagem = ? WHERE id = ?");

			$stmt -> bind_param("ississsi", $carro -> getIdCliente(), $carro -> getNome(), 
				$carro -> getMarca(), $carro -> getAno(), $carro -> getCor(), $carro -> getPlaca(), 
				$carro -> getCaminhoImagem(), $carro -> getId());

			if ($stmt -> execute() === TRUE) {
			    echo $carro -> getNome() . " foi atualizado com sucesso!<br>";
			} else {
			    echo "Erro na atualização do carro.<br>";
			}

			$stmt -> close();
			$this -> desconectar();
		}

		public function listar() {
			$this -> conectar();

			$sql = "SELECT * FROM carro";
			$resultado = $this -> conexao -> query($sql);

		    $lista_carro = array();
			while ($row = $resultado -> fetch_assoc()) {
				$carro = $this -> criarCarroDeArray($row);
			    $lista_carro[] = $carro;
			}

			$this -> desconectar();

			return $lista_carro;
		}

		public function listarCarrosComClientes() {
			$this -> conectar();

			$sql = "SELECT ca.*, p.nome AS nome_cliente 
				FROM carro ca, cliente c, pessoa p 
				WHERE ca.id_cliente = c.id AND c.id_pessoa = p.id 
				ORDER BY ca.id;";

			$resultado = $this -> conexao -> query($sql);

		    $lista_carro = array();
			while ($row = $resultado -> fetch_assoc()) {
				$carroDTO = $this -> criarCarroDTODeArray($row);
			    $lista_carro[] = $carroDTO;
			}

			$this -> desconectar();

			return $lista_carro;
		}

		// Não está em uso
		public function consultar($nome) {
			$this -> conectar();

			$stmt = $this -> conexao -> prepare("SELECT * FROM carro WHERE nome = ?");
			$stmt -> bind_param("s", $nome);
			$stmt -> execute();
			$resultado = $stmt -> get_result();

			$lista_carro = array();
			while ($row = $resultado -> fetch_assoc()) {
				$carro = $this -> criarCarroDeArray($row);
			    $lista_carro[] = $carro;
			}

			$stmt -> close();
			$this -> desconectar();

			return $lista_carro;
		}

		public function pegarCarroPorId($id) {
			$this -> conectar();

			$stmt = $this -> conexao -> prepare("SELECT * FROM carro WHERE id = ? LIMIT 1");
			$stmt -> bind_param("i", $id);
			$stmt -> execute();
			$resultado = $stmt -> get_result();

			$carro = new Carro();
			while ($row = $resultado -> fetch_assoc()) {
				$carro = $this -> criarCarroDeArray($row);
			}

			$stmt -> close();
			$this -> desconectar();

			return $carro;
		}

		private function criarCarroDeArray($row) {
		    
		    $carro = new Carro();
		    $carro -> setId($row["id"]);
		    $carro -> setIdCliente($row["id_cliente"]);
			$carro -> setNome($row["nome"]);
			$carro -> setMarca($row["marca"]);
			$carro -> setAno($row["ano"]);
			$carro -> setCor($row["cor"]);
			$carro -> setPlaca($row["placa"]);
			$carro -> setCaminhoImagem($row["caminho_imagem"]);

		    return $carro; 
		}

		public function pegarCarroComClientePorId($id) {
			$this -> conectar();

			$stmt = $this -> conexao -> prepare("SELECT ca.*, p.nome AS nome_cliente 
				FROM carro ca, cliente c, pessoa p 
				WHERE ca.id_cliente = c.id AND c.id_pessoa = p.id AND ca.id = ? LIMIT 1");
			$stmt -> bind_param("i", $id);
			$stmt -> execute();
			$resultado = $stmt -> get_result();

			$carroDTO = new CarroDTO();
			while ($row = $resultado -> fetch_assoc()) {
				$carroDTO = $this -> criarCarroDTODeArray($row);
			}

			$stmt -> close();
			$this -> desconectar();

			return $carroDTO;
		}

		private function criarCarroDTODeArray($row) {
		    
		    $carro = $this -> criarCarroDeArray($row);
		    $carroDTO = new CarroDTO($carro);
			$carroDTO -> setNomeCliente($row["nome_cliente"]); // atributo transiente de CarroDTO

		    return $carroDTO; 
		}

		public function deletar($id) {
			$this -> conectar();

			$sql = "DELETE FROM carro WHERE id = " . $id;

			if ($this -> conexao -> query($sql) === TRUE) {
			    echo "Registro deletado com sucesso!<br>";
			} else {
			    echo "Erro ao tentar deletar registro: " . $this -> conexao -> error;
			}

			$this -> desconectar();
		}

	}

?>