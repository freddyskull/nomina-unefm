<?php

require_once('fpdf.php');

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Seleccionadospdf extends FPDF {

    public $rand = 0;
    public $url = '';
    public $cont = 21;
    public function __construct() {
        parent::__construct();
        $this->rand = rand(1,1000000);
    }

// Columna actual
    var $col = 0;
// Ordenada de comienzo de la columna
    var $y0;
// Cabecera de página
    function Header() {
        //fondo de agua
        $this->Image(base_url('source/img/14.png'), 18, 55, 164);
        // Cabacera
        global $title;
        // Logo
        $this->Image(base_url('source/img/encabezado.png'), 6, 4, 198);
        $this->Image(base_url('source/img/logo_unefm.png'), 17, 24, 11);
        // Arial bold 12
        $this->Ln(12);
        $this->SetFont('Arial', '', 10);
        $this->Ln(1);
        $this->Cell(0, 5, utf8_decode('UNIVERSIDAD NACIONAL EXPERIMENTAL'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('"FRANCISCO DE MIRANDA"'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('VICERECTORADO ACADÉMICO'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('DECANATO DE POSTGRADO'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('DEPARTAMENTO DE EVALUACIÓN Y SEGUIMIENTO ESTUDIANTIL'), 0, 1, 'C');
        // Arial bold 16

        // Salto de línea
        $this->Ln(11);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(125);
        $this->Cell(0, 10, 'Seleccionados', 0, 0, 'C');
        $this->Image(base_url('source/img/13x.png'), 3, 250, 200);
    }

    function imprimir($seleccion = array(),$programa,$cohorte,$lugar) {
        $pdf = new Seleccionadospdf();
        $pdf->AddPage();
        
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 5, utf8_decode('Listado de Seleccionados'), 0, 1, 'C');
        $pdf->Ln();
        $pdf->Cell(0, 5, utf8_decode(strtoupper(str_replace(' ',' - ', trim($cohorte))).' '.$lugar), 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetFillColor(229, 223, 223);
        $pdf->Cell(0, 7, utf8_decode(str_replace('%20', ' ', $programa)), 1, 1, 'C',TRUE);
        $pdf->Cell(10, 7, utf8_decode("Nº"), 1, 0, 'C',TRUE);
        $pdf->Cell(35, 7, utf8_decode("Cédula"), 1, 0, 'C',TRUE);
        $pdf->Cell(105, 7, utf8_decode("Apellidos y Nombres"), 1, 0, 'C',TRUE);
        $pdf->Cell(40, 7, utf8_decode("Seleccionado"), 1, 1, 'C',TRUE);
        for($i=0; $i<sizeof($seleccion); $i++){
            $pdf->Cell(10, 7, utf8_decode($i+1), 1, 0, 'C'); 
            $pdf->Cell(35, 7, utf8_decode($seleccion[$i]['cdei']), 1, 0, 'C'); 
            $pdf->Cell(105, 7, utf8_decode(strtoupper($seleccion[$i]['apellidos'].' '.$seleccion[$i]['nombres'])), 1, 0, 'C'); 
            $pdf->Cell(40, 7, utf8_decode('Si'), 1, 1, 'C');   
            if($i == 21 || $i == ($this->cont)){
                $this->cont += 26;
                $pdf->AddPage();
            }
        }

        $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/public/sistemaphp/source/tmp/'.'seleccion-'.$this->rand.'.pdf','F');
        $this->url = base_url().'source/tmp/'.'seleccion-'.$this->rand.'.pdf';

        return $this->url;
    }

}
