<?php header('Content-Type: text/html; charset=utf-8');

	session_start();
	if (!isset($_SESSION['login_user'])) {
		header("location: ../../view/login.php");
	}

	require_once('tcpdf_include.php'); // Include the main TCPDF library.

	// Extender classe TCPDF. Fonte: http://softaox.info/php/generate-html-table-data-to-pdf-using-tcpdf-in-php/ 
	class CarroPDF extends TCPDF {

		function __construct() {

			parent::__construct('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); // chamando construtor da classe mae

			$this -> SetCreator(PDF_CREATOR);  
			$this -> SetTitle("Relatório de Carros usando biblioteca TCPDF");  
			$this -> SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
			$this -> setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
			$this -> setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
			$this -> SetDefaultMonospacedFont('helvetica');  
			$this -> SetFooterMargin(PDF_MARGIN_FOOTER);  
			$this -> SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
			$this -> setPrintHeader(false);  
			$this -> setPrintFooter(false);  
			$this -> SetAutoPageBreak(TRUE, 10);  
			$this -> SetFont('helvetica', '', 12);  
			$this -> AddPage();
		}

		public function renderizarTabelaDeCarros($carros) {
			$tabela = '';  
			$tabela .= '  
		    	<h4 align="center">Relatório de Carros</h4> 
		      	<table border="1" cellspacing="0" cellpadding="3">  
		        	<tr bgcolor="#CCF2FF">
		            	<th>Id</th>  
		                <th>Nome</th>  
		                <th>Marca</th>  
		                <th>Ano</th>
		                <th>Cor</th>
		                <th>Placa</th>
		                <th>Cliente</th>  
		           	</tr>';

			foreach ($carros as $carroDTO) { 
				$tabela .= '<tr>  
			                 	<td>'. $carroDTO -> getId()    .'</td>  
			                  	<td>'. $carroDTO -> getNome()  .'</td>  
			                  	<td>'. $carroDTO -> getMarca() .'</td>  
			                  	<td>'. $carroDTO -> getAno()   .'</td>
			                  	<td>'. $carroDTO -> getCor()   .'</td>
			                  	<td>'. $carroDTO -> getPlaca() .'</td>
			                  	<td>'. $carroDTO -> getNomeCliente() .'</td>  
			    			</tr>';  
			}
			$tabela .= '</table>';
			return $tabela;  
		}

	}

	// Criar PDF
	$pdf = new CarroPDF();

	// Listar os carros
	require_once("../../controller/carroController.php");
	$carroController = new CarroController();
	$carros = $carroController -> listarCarrosComClientes();

	// Renderizar tabela passando carros
	$tabela = $pdf -> renderizarTabelaDeCarros($carros);  

	// Escrever e renderizar PDF
	$pdf -> writeHTML($tabela);
	$pdf -> Output('Relatório_de_Carros.pdf', 'I');

?>