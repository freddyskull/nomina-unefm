<?php

require_once('fpdf.php');

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controlpagospdf extends FPDF {

    public $rand = 0;
    public $url = '';
    public $cont = 21;
    
    public function __construct() {
        parent::__construct();
        $this->rand = rand(1,1000000);
    }

// Cabecera de página
    function Header() {
        //fondo de agua
        // Cabacera
        global $title;
        // Logo
        // Arial bold 12
        $this->Ln(12);
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(1);
        $this->Cell(0, 5, utf8_decode('REPORTE'), 0, 1, 'C');
        // Arial bold 16

        // Salto de línea
        $this->Ln(11);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(125);
        $this->Cell(0, 10, 'Reporte', 0, 0, 'C');
    }

    function imprimir($pagos = array(),$titulo,$tituloA) {
        $pdf = new Controlpagospdf();
        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 7, utf8_decode("Referencia"), 1, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode("Fecha de pago"), 1, 0, 'C');
        $pdf->Cell(60, 7, utf8_decode("Concepto"), 1, 0, 'C');
        $pdf->Cell(30, 7, utf8_decode("Monto"), 1, 1, 'C');
        //$pdf->Cell(5, 7, utf8_decode("Seleccionado"), 1, 1, 'C',TRUE);
        $pdf->SetFont('Arial', '', 9);

        $total = 0;

        foreach ($pagos as $value) {

            //$montoTemp = (floatval($value['monto']) + floatval($value['monto_ingresado']));

            $pdf->Cell(60, 7, utf8_decode($value['referencia']), 1, 0, 'C');
            $pdf->Cell(40, 7, utf8_decode($value['fecha_pago']), 1, 0, 'C');
            $pdf->Cell(60, 7, utf8_decode($value['descripcion']), 1, 0, 'C');
            $pdf->Cell(30, 7, utf8_decode($value['monto'].' Bs'), 1, 1, 'C');

            $total = ($total+floatval($value['monto']));
            
        }

        

        $pdf->Cell(60, 7, utf8_decode(""), 1, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode(""), 1, 0, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 7, utf8_decode("Total"), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, 7, utf8_decode($total.' Bs.'), 1, 1, 'C');

        $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/sistema/source/tmp/'.$tituloA.'-'.$this->rand.'.pdf','F');
        $this->url = base_url().'source/tmp/'.$tituloA.'-'.$this->rand.'.pdf';

        return $this->url;
    }

}
