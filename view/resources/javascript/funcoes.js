// carro
function visualizar(id) {
  	window.location.href='../view/carro_view.php?id=' + id;
}

function editar(id) {
  	window.location.href='../view/carro_edit.php?id=' + id;
}

function deletar(id) {
	if (confirm('Tem certeza de que deseja deletar este carro?')) {
  		window.location.href='../controller/carroController.php?acao=deletar&id=' + id;
 	}
}

// cliente
function editarCliente(id) {
  	window.location.href='../view/cliente_edit.php?id=' + id;
}

function deletarCliente(idPessoa) {
	if (confirm('Tem certeza de que deseja deletar este cliente?')) {
  		window.location.href='../controller/clienteController.php?acao=deletar&id_pessoa=' + idPessoa;
 	}
}

// usuario
function deletarUsuario(idPessoa) {
	if (confirm('Tem certeza de que deseja deletar este usuário?')) {
  		window.location.href='../controller/usuarioController.php?acao=deletar&id_pessoa=' + idPessoa;
 	}
}

/*
function logout() {
  	window.location.href='../controller/loginController.php?acao=logout';
}
*/