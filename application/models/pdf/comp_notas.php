<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('fpdf.php');
class Comp_notas extends FPDF {
	public function __construct()
	{
		parent::__construct();
		
	}

	// Columna actual
    var $col = 0;
// Ordenada de comienzo de la columna
    var $y0;

// Cabecera de página
    function Header() {
        // Cabacera
        global $title;
        // Logo
        $this->Image(base_url('source/img/logo_unefm.png'), 17, 18, 11);
        // Arial bold 12 azul
        $this->Ln(6);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(15,15,130);
        $this->Cell(15, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(65, 5, utf8_decode('Universidad Nacional Experimental'), 0, 0, 'C');
        //foto
        $this->Cell(32, 32, $this->Image(base_url('source/img/imagen_vacia.png'), $this->GetX(), $this->GetY(), 32), 1, 0);
        //$this->Image(base_url('source/img/imagen_vacia.png'), 91, 17, 30);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(5, 5, '', 0, 0, 'L');
        $this->Cell(42, 5, utf8_decode('Profesor: '.$this->profesor), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(15,15,130);
        $this->Cell(33, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(25, 5, utf8_decode('Francisco de Miranda'), 0, 0, 'C');
        $this->Cell(59, 5, utf8_decode(''), 0, 0, 'C');
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(42, 5, utf8_decode('Cédula: '.$this->ciProf), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(15,15,130);
        $this->Cell(33, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(25, 5, utf8_decode('Vicerrectorado Académico'), 0, 0, 'C');
        $this->Cell(59, 5, utf8_decode(''), 0, 0, 'C');
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(42, 5, utf8_decode('Cohorte: '.$this->cohorte), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(15,15,130);
        $this->Cell(33, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(25, 5, utf8_decode('Decanato de Postgrado'), 0, 0, 'C');
        $this->Cell(59, 5, utf8_decode(''), 0, 0, 'C');
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(42, 5, utf8_decode('Periodo: '.$this->periodo), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(15,15,130);
        $this->Cell(33, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(25, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(59, 5, utf8_decode(''), 0, 0, 'C');
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(42, 5, utf8_decode('Sección: '.$this->seccion), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(15,15,130);
        $this->Cell(33, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(25, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(59, 5, utf8_decode(''), 0, 0, 'C');
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(42, 5, utf8_decode('Cursada Desde: '.$this->tiempo[0]." Hasta: ".$this->tiempo[1]), 0, 1, 'L');
        // Arial bold 16
        $this->Ln(4);
        $this->SetFont('Arial', '', 14);
        $this->SetTextColor(0);
        $this->Ln(6);
        $this->Cell(0, 5, utf8_decode('COMPROBANTE DE NOTAS'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, strtoupper(utf8_decode($this->programa)), 0, 1, 'C');
        // Salto de línea
        $this->Ln(2);
    }

    function tabla()
    {

    $this->SetFont('Arial','B',8);
    $this->SetFillColor(215);
    $fill=false;
    // Salto de línea
        $this->Ln(3);
            $this->SetFont('Arial','',10);
            $fill=true;
            $this->Cell(185,8,utf8_decode($this->asignatura),1,0,'C',$fill);
            $this->Ln(8);
            $this->Cell(15,8,utf8_decode("Nº"),1,0,'C',$fill);
            $this->Cell(40,8,utf8_decode("Cédula"),1,0,'C',$fill);
            $this->Cell(100,8,"Apellidos y Nombres",1,0,'C',$fill);
            $this->Cell(30,8,"Nota",1,0,'C',$fill);
            
        
        $this->Ln();
    // Datos
    $aux="";
    $cont=1;
        foreach($this->alumnos as $row => $value)
        {
            $this->Cell(15,5,utf8_decode($cont),'LRT',0,'L');
            $this->Cell(40,5,utf8_decode($row),'LRT',0,'L');
            $this->Cell(100,5,utf8_decode($value[0])." ".utf8_decode($value[1]),'LRT',0,'L');
            if (strcasecmp($value[2], "Sin Informacion")==0) {
                $this->Cell(30,5,utf8_decode('0'),'LRT',0,'L');
            }else
            $this->Cell(30,5,utf8_decode($value[2]),'LRT',0,'L');
            $this->Ln();
            $cont+=1;
            

        }
    $this->Cell(185,0,'','T');
    
    }
	function tabla2()
	{

    $this->SetFont('Arial','B',8);
    $this->SetFillColor(215);
    $fill=false;
    // Salto de línea
		$this->Ln(3);
			$this->SetFont('Arial','',10);
			$fill=true;
			$this->Cell(185,8,utf8_decode("PARTICIPANTES CON CONDICION DE INSOLVENTES"),1,0,'C',$fill);
			$this->Ln(8);
			$this->Cell(15,8,utf8_decode("Nº"),1,0,'C',$fill);
			$this->Cell(40,8,utf8_decode("Cédula"),1,0,'C',$fill);
			$this->Cell(100,8,"Apellidos y Nombres",1,0,'C',$fill);
			$this->Cell(30,8,"Nota",1,0,'C',$fill);
			
		
		$this->Ln();
    // Datos
    $aux="";
    $cont=1;
		foreach($this->alumnosInsolventes as $row => $value)
		{
            if (strcasecmp($value[2], "Otra Seccion")!=0) {
    			$this->Cell(15,5,utf8_decode($cont),'LRT',0,'L');
    			$this->Cell(40,5,utf8_decode($row),'LRT',0,'L');
    			$this->Cell(100,5,utf8_decode($value[0])." ".utf8_decode($value[1]),'LRT',0,'L');
                if (strcasecmp($value[2], "Sin Informacion")==0) {
                    $this->Cell(30,5,utf8_decode('0'),'LRT',0,'L');
                }else
    			    $this->Cell(30,5,utf8_decode($value[2]),'LRT',0,'L');
    			$this->Ln();
    			$cont+=1;
			}

		}
	$this->Cell(185,0,'','T');
    
	}

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(0, 10,utf8_decode('Fecha de impresión:').date("d/m/Y"), 0, 0, 'L');
    }

    function Titles($label) {
        // Arial 12
        $this->SetFont('Arial', 'B', 13);
        // Color de fondo
        $this->SetFillColor(15, 15, 130);
        $this->SetTextColor(255);
        // Título
        $this->Cell(194, 5, utf8_decode("$label"), 0, 1, 'L', true);
    }

    function imprimir($profesor,$ciProf,$programa,$cohorte,$periodo,$alumnos,$seccion,$tiempo,$asignatura,$alumnos2) {
        $pdf = new Comp_notas();
        $pdf->profesor=$profesor;
        $pdf->ciProf=$ciProf;
        $pdf->programa=$programa;
        $pdf->cohorte=$cohorte;
        $pdf->periodo=$periodo;
        $pdf->alumnos=$alumnos;
        $pdf->alumnosInsolventes=$alumnos2;
        $pdf->seccion=$seccion;
        $pdf->tiempo=$tiempo;
        $pdf->asignatura=$asignatura;
        $pdf->AddPage();
        $pdf->SetMargins(12, 0);
        $pdf->tabla();
        $pdf->tabla2();
        

        $pdf->Output();
    }

}

/* End of file prueba.php */
/* Location: ./application/models/prueba.php */