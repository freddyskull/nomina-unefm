<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('fpdf.php');
class Prueba extends FPDF {
	public function __construct()
	{
		parent::__construct();
		
	}

	// Cabecera de página
	function Header()
	{
    // Logo
		$this->Image('http://localhost/sistemaphp/source/img/pdf/logo.png',10,8,33);
    // Arial bold 15
		$this->SetFont('Arial','B',15);
    // Movernos a la derecha
		$this->Cell(80);
    // Título
		$this->Cell(30,10,'Title',1,0,'C');
    // Salto de línea
		$this->Ln(20);
	}

// Pie de página
	function Footer()
	{
    // Posición: a 1,5 cm del final
		$this->SetY(-15);
    // Arial italic 8
		$this->SetFont('Arial','I',8);
    // Número de página
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

	public function imprimir(){
		// Creación del objeto de la clase heredada
		$pdf = new Prueba();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		for($i=1;$i<=40;$i++)
			$pdf->Cell(0,10,utf8_decode('Imprimiendo línea número '.$i),0,1);
		$pdf->Output();
	}

}

/* End of file prueba.php */
/* Location: ./application/models/prueba.php */