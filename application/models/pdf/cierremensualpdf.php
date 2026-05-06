<?php

require_once('fpdf.php');

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cierremensualpdf extends FPDF {

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

        // Arial bold 12
        $this->Ln(12);
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(1);
        $this->Cell(0, 5, utf8_decode('RELACIÓN'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('CIERRE DE LOTE'), 0, 1, 'C');
        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $fecha = date('Y-m-d');
        $fechaE = explode('-', $fecha);
        $this->Cell(0, 5, utf8_decode('MES: '.strtoupper($meses[$fechaE[1]-1]).' - '.$fechaE[0]), 0, 1, 'C');
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
        $this->Cell(0, 5, utf8_decode('FUENTE DE INFORMACIÓN: DPTO EVALUACIÓN Y SEGUIMEINTO ESTD. DE POSTGRADO'), 0, 1, 'C');
        $fecha = date('d/m/Y');
        $this->Cell(0, 10, $fecha, 0, 1, 'C');
    }

    function imprimir($pagos,$diasT,$tituloA) {
        $pdf = new Cierremensualpdf();
        $pdf->AddPage();
        $pdf->AliasNbPages();

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(37,5," ",'R');
        $pdf->Cell(10, 5, utf8_decode("DIA"), 1, 0, 'C');
        $pdf->Cell(30, 5, utf8_decode("HORA"), 1, 0, 'C');
        $pdf->Cell(30, 5, utf8_decode("MONTO Bs."), 1, 0, 'C');
        $pdf->Cell(15, 5, utf8_decode("LOTE"), 1, 0, 'C');
        $pdf->Cell(30, 5, utf8_decode("OBSERVACIÓN"), 1, 1, 'C');
        //$pdf->Cell(5, 7, utf8_decode("Seleccionado"), 1, 1, 'C',TRUE);
        $pdf->SetFont('Arial', '', 9);
        $fecha2 = explode('-', $pagos[0]['fecha']);
        $total = 0;

        for($i=0; $i<intval($diasT); $i++){
            $fecha3 = $fecha2[0].'-'.$fecha2[1].'-'.($i+1);
            $dia=date("w", strtotime($fecha3));

            if($dia == 6){
                $pdf->Cell(37,5," ",'R');
                $pdf->Cell(10, 5, utf8_decode($i+1), 1, 0, 'C');
                $pdf->Cell(30, 5, utf8_decode("-"), 1, 0, 'C');
                $pdf->Cell(30, 5, utf8_decode('-'), 1, 0, 'R');
                $pdf->Cell(15, 5, utf8_decode('-'), 1, 0, 'C');        
                $pdf->Cell(30, 5, utf8_decode('Sábado'), 1, 1, 'C');
            }elseif($dia == 0){
                $pdf->Cell(37,5," ",'R');
                $pdf->Cell(10, 5, utf8_decode($i+1), 1, 0, 'C');
                $pdf->Cell(30, 5, utf8_decode("-"), 1, 0, 'C');
                $pdf->Cell(30, 5, utf8_decode('-'), 1, 0, 'R');
                $pdf->Cell(15, 5, utf8_decode('-'), 1, 0, 'C');             
                $pdf->Cell(30, 5, utf8_decode('Domingo'), 1, 1, 'C');
            }else{
                foreach ($pagos as $value) {

                    $dia = explode('-', $value['fecha']);

                    if(intval($dia[2]) == ($i+1)){   
                        $pdf->Cell(37,5," ",'R');
                        $pdf->Cell(10, 5, utf8_decode($i+1), 1, 0, 'C');
                        $pdf->Cell(30, 5, utf8_decode($value['hora']), 1, 0, 'C');
                        $pdf->Cell(30, 5, utf8_decode($value['montoview']), 1, 0, 'R');
                        $pdf->Cell(15, 5, utf8_decode($value['lote']), 1, 0, 'C');
                        if($value['observacion'] == 1){
                            $pdf->Cell(30, 5, utf8_decode("Revisar monto"), 1, 1, 'C');
                        }else{
                            $pdf->Cell(30, 5, utf8_decode(""), 1, 1, 'C');
                        }
                        
                        $total = $total+floatval($value['totalb']);
                    }
                } 
            }                  
        }  

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(37,5," ",'R');
        $pdf->Cell(40, 5, utf8_decode("TOTAL DEL MES"), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(75, 5, utf8_decode(str_replace('.', ',', $total).' Bs.'), 1, 1, 'R');

        $pdf->AddPage();

        $coordX = [10,75,140];
        $coordY1 = [60,60,60];   

        $cont = 0;
        $contb = 0;

        foreach ($pagos as $value) {

            $pdf->Image(base_url('source/tmp/cierres/comprobantes/'.$value['img']),$coordX[$contb],$coordY1[$contb],60,100);   

            if($cont == 2){
                $coordY1[0] = ($coordY1[0]+110);
                $coordY1[1] = ($coordY1[1]+110);
                $coordY1[2] = ($coordY1[2]+110);
                $contb = 0;
            }

            if($cont == 5){
                $coordY1[0] = 60;
                $coordY1[1] = 60;
                $coordY1[2] = 60;  
                $contb = 0;    
                $cont = 0;
                $pdf->AddPage();          
            }

            if($cont < 6){
                $cont++;
            }else{
                $cont = 0;
            }

            if( $contb == 2){
                $contb = 0;
            }else{
                 $contb++;
            } 
        }      

        $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/sistema/source/tmp/'.$tituloA.'-'.$this->rand.'.pdf','F');
        $this->url = base_url().'source/tmp/'.$tituloA.'-'.$this->rand.'.pdf';

        return $this->url;
    }

}
