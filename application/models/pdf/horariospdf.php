<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('fpdf.php');
class Horariospdf extends FPDF {

    var $titulo;
    var $numeroplan;
    public $linea; 

    public function __construct()
    {
        parent::__construct();
        
    }
    function Header()
    {
    // Logo
        $this->Image(base_url('source/img/logo_unefm.png'), 17, 16, 11);
        // Arial bold 12
        $this->Ln(4);
        $this->SetFont('Arial', '', 10);
        $this->Ln(1);
        $this->Cell(0, 5, utf8_decode('UNIVERSIDAD NACIONAL EXPERIMENTAL'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('"FRANCISCO DE MIRANDA"'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('VICERECTORADO ACADÉMICO'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('DECANATO DE POSTGRADO'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('DEPARTAMENTO DE EVALUACIÓN Y SEGUIMIENTO ESTUDIANTIL'), 0, 1, 'C');
        // Arial bold 16
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 12);

        // Salto de línea
        $this->Ln(6);

        if($this->linea > 0){
            $w = array(18, 58,12, 13, 13,17,15,10,16,17);
            $this->Cell($w[0],4," ",'T');
            $this->Cell($w[1],4," ",'T');
            $this->Cell($w[2],4," ",'T');
            $this->Cell($w[3],4," ",'T');
            $this->Cell($w[4],4," ",'T');
            $this->Cell($w[5],4," ",'T');
            $this->Cell($w[6],4," ",'T');
            $this->Cell($w[7],4," ",'T');
            $this->Cell($w[8],4," ",'T');
            $this->Cell($w[9],4," ",'T');
        }
    }

// Pie de página
    function Footer()
    {
        $w = array(18, 58,12, 13, 13,17,15,10,16,17);
        $this->Cell($w[0],4," ",'T');
        $this->Cell($w[1],4," ",'T');
        $this->Cell($w[2],4," ",'T');
        $this->Cell($w[3],4," ",'T');
        $this->Cell($w[4],4," ",'T');
        $this->Cell($w[5],4," ",'T');
        $this->Cell($w[6],4," ",'T');
        $this->Cell($w[7],4," ",'T');
        $this->Cell($w[8],4," ",'T');
        $this->Cell($w[9],4," ",'T');
    // Posición: a 1,5 cm del final
        $this->SetY(-15);
    // Arial italic 8
        $this->SetFont('Arial','I',8);
    // Número de página
        $this->Ln();
        $this->Cell(0,10,utf8_decode('Horarios - Página '.$this->PageNo()),0,0,'C');
    }

    // Una tabla más completa
    function tabla($header,$cohorte,$programa,$horarios)
    {
    // Anchuras de las columnas
    $w = array(18, 58,12, 13, 13,17,15,10,16,17);
 
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(189,8,utf8_encode($cohorte),0,1,'C');
    $this->Ln(2);
    $this->SetFillColor(229, 223, 223);
    $this->SetFont('Arial', 'B', 12);
    $this->Cell(189,8,strtoupper(utf8_encode($programa)),1,1,'C',TRUE);
    $this->Cell(189,2,'  ',1,1,'C',TRUE);
    // Cabeceras
    $this->SetFont('Arial','B',7);
    $this->SetFillColor(190);
    $fill=false;
    // Salto de línea

        for($i=0;$i<count($header);$i++){
            if($i==0)
            $this->Cell($w[$i],8,utf8_decode($header[$i]),'LR',0,'C',$fill);
            else{
                $fill=true;
                $this->Cell($w[$i],8,utf8_decode($header[$i]),1,0,'C',$fill);
            }
        }
        
    $this->Ln();
    $aux = "";
    $cont = 0;
    $print_horarios = array();
    $tempK = "a";

    for ($i = 0; $i < count($horarios); $i++) { 
        $periodo = $horarios[$i];
        $key = ($periodo['tipo'] == 'NIVELACION' ? 'NIVELACION' : $periodo['numero'].'-'.$periodo['tipo']);

        if(array_key_exists($key, $print_horarios)) {
            $print_horarios[$key][] = $horarios[$i];
        } else {
            $print_horarios[$key] = array();
            $print_horarios[$key][] = $horarios[$i];
        }
    }

    foreach ($print_horarios as $key => $value) {
        $this->SetFont('Arial','B',6.5);
        $this->Cell($w[0],4,utf8_decode($key),'LRT',0,'C');
        for($i=0; $i<sizeof($value); $i++){
            if($i != 0){
                $this->Cell($w[0],4," ",'LR');
            }     

            $aula = $value[$i]['area'].' - '.$value[$i]['nombre_aula'];     
            $subaula = substr($aula, 0,10);
            $subaula2 = substr($aula, 10,10);
            $subaula3 = substr($aula, 20,10);;  
            $subaula4 = substr($aula, 30,10);;    

            $temProf = explode(' ', $value[$i]['nombre_y_apellido']);

            if(sizeof($temProf)>2){
                if(isset($temProf[2])){
                    $prof = $temProf[0].' '.$temProf[2];
                }
            }else{
                if(isset($temProf[1])){
                    $prof = $temProf[0].' '.$temProf[1];
                }
            }

            $suprof = substr($prof, 0,10);
            $suprof2 = substr($prof, 10,10);
            $suprof3 = substr($prof, 20,10);   
            $suprof4 = substr($prof, 30,10);    

            if(strlen($suprof2)==0){
                $suprof2 = '';
            }

            if(strlen($suprof3)==0){
                $suprof3 = '';
            }               

            if(strlen($suprof4)==0){
                $suprof4 = '';
            }

            if(strlen($value[$i]['nombre_asignatura']) < 40 ){

                if(strlen($value[$i]['dia2']) > 0){

                    if($value[$i]['dia2'] == 'SIN INFORMACION'){
                        $value[$i]['dia2'] = 'S/I';
                    }

                    if($value[$i]['dia'] == 'SIN INFORMACION'){
                        $value[$i]['dia'] = 'S/I';
                    }

                    $this->Cell($w[1],4,utf8_decode($value[$i]['nombre_asignatura']),'LRT',0,'C'); 
                    $this->Cell($w[2],4,utf8_decode($value[$i]['dia']),'LRT',0,'C');
                    $this->Cell($w[3],4,utf8_decode($value[$i]['hora_inicio']),'LRT',0,'C');
                    $this->Cell($w[4],4,utf8_decode($value[$i]['hora_fin']),'LRT',0,'C');
                    $this->Cell($w[5],4,utf8_decode($value[$i]['fecha_inicio']),'LRT',0,'C');
                    $this->Cell($w[6],4,utf8_decode($value[$i]['fecha_fin']),'LRT',0,'C');
                    $this->Cell($w[7],4,utf8_decode($value[$i]['nombre_seccion']),'LRT',0,'C');
                    $this->Cell($w[8],4,utf8_decode($subaula),'LRT',0,'C');
                    $this->Cell($w[9],4,utf8_decode($suprof),'LRT',0,'C');
                    $this->Ln();

                    $this->Cell($w[0],4,'','LR');
                    $this->Cell($w[1],4,'','LR',0,'C');
                    $this->Cell($w[2],4,utf8_decode($value[$i]['dia2']),'LR',0,'C');
                    $this->Cell($w[3],4,utf8_decode($value[$i]['hora_inicio2']),'LR',0,'C');
                    $this->Cell($w[4],4,utf8_decode($value[$i]['hora_fin2']),'LR',0,'C');
                    $this->Cell($w[5],4,utf8_decode(''),'LR',0,'C');
                    $this->Cell($w[6],4,utf8_decode(''),'LR',0,'C');
                    $this->Cell($w[7],4,'','LR',0,'C');
                    $this->Cell($w[8],4,utf8_decode($subaula2),'LR',0,'C');
                    $this->Cell($w[9],4,utf8_decode($suprof2),'LR',0,'C');               
                    $this->Ln();   

                    $this->Cell($w[0],4,'','LR');
                    $this->Cell($w[1],4,'','LR',0,'C');
                    $this->Cell($w[2],4,'','LR',0,'C');
                    $this->Cell($w[3],4,'','LR',0,'C');
                    $this->Cell($w[4],4,'','LR',0,'C');
                    $this->Cell($w[5],4,'','LR',0,'C');
                    $this->Cell($w[6],4,'','LR',0,'C');
                    $this->Cell($w[7],4,'','LR',0,'C');
                    $this->Cell($w[8],4,utf8_decode($subaula3),'LR',0,'C');
                    $this->Cell($w[9],4,utf8_decode($suprof3),'LR',0,'C');               
                    $this->Ln();                   

                    $this->Cell($w[0],4,'','LR');
                    $this->Cell($w[1],4,'','LR',0,'C');
                    $this->Cell($w[2],4,'','LR',0,'C');
                    $this->Cell($w[3],4,'','LR',0,'C');
                    $this->Cell($w[4],4,'','LR',0,'C');
                    $this->Cell($w[5],4,'','LR',0,'C');
                    $this->Cell($w[6],4,'','LR',0,'C');
                    $this->Cell($w[7],4,'','LR',0,'C');
                    $this->Cell($w[8],4,utf8_decode($subaula4),'LR',0,'C');
                    $this->Cell($w[9],4,utf8_decode($suprof4),'LR',0,'C');               
                    $this->Ln(); 

                    $this->Cell($w[0],1,'','LR',0,'C');
                    $this->Cell($w[1],1,"",1,0,'C',TRUE);
                    $this->Cell($w[2],1,"",1,0,'C',TRUE);
                    $this->Cell($w[3],1,"",1,0,'C',TRUE);
                    $this->Cell($w[4],1,"",1,0,'C',TRUE);
                    $this->Cell($w[5],1,"",1,0,'C',TRUE);
                    $this->Cell($w[6],1,"",1,0,'C',TRUE);
                    $this->Cell($w[7],1,"",1,0,'C',TRUE);
                    $this->Cell($w[8],1,"",1,0,'C',TRUE);
                    $this->Cell($w[9],1,"",1,0,'C',TRUE);
                    $this->Ln(); 

                }else{

                    $this->Cell($w[1],4,utf8_decode($value[$i]['nombre_asignatura']),'LRT',0,'C'); 
                    $this->Cell($w[2],4,utf8_decode($value[$i]['dia']),'LRT',0,'C');
                    $this->Cell($w[3],4,utf8_decode($value[$i]['hora_inicio']),'LRT',0,'C');
                    $this->Cell($w[4],4,utf8_decode($value[$i]['hora_fin']),'LRT',0,'C');
                    $this->Cell($w[5],4,utf8_decode($value[$i]['fecha_inicio']),'LRT',0,'C');
                    $this->Cell($w[6],4,utf8_decode($value[$i]['fecha_fin']),'LRT',0,'C');
                    $this->Cell($w[7],4,utf8_decode($value[$i]['nombre_seccion']),'LRT',0,'C');
                    $this->Cell($w[8],4,utf8_decode($subaula),'LRT',0,'C');
                    $this->Cell($w[9],4,utf8_decode($suprof),'LRT',0,'C');
                    $this->Ln();

                    $this->Cell($w[0],4,'','LR');
                    $this->Cell($w[1],4,'','LR',0,'C');
                    $this->Cell($w[2],4,'','LR',0,'C');
                    $this->Cell($w[3],4,'','LR',0,'C');
                    $this->Cell($w[4],4,'','LR',0,'C');
                    $this->Cell($w[5],4,'','LR',0,'C');
                    $this->Cell($w[6],4,'','LR',0,'C');
                    $this->Cell($w[7],4,'','LR',0,'C');
                    $this->Cell($w[8],4,utf8_decode($subaula2),'LR',0,'C');
                    $this->Cell($w[9],4,utf8_decode($suprof2),'LR',0,'C');               
                    $this->Ln();  

                    $this->Cell($w[0],4,'','LR');
                    $this->Cell($w[1],4,'','LR',0,'C');
                    $this->Cell($w[2],4,'','LR',0,'C');
                    $this->Cell($w[3],4,'','LR',0,'C');
                    $this->Cell($w[4],4,'','LR',0,'C');
                    $this->Cell($w[5],4,'','LR',0,'C');
                    $this->Cell($w[6],4,'','LR',0,'C');
                    $this->Cell($w[7],4,'','LR',0,'C');
                    $this->Cell($w[8],4,utf8_decode($subaula3),'LR',0,'C');
                    $this->Cell($w[9],4,utf8_decode($suprof3),'LR',0,'C');               
                    $this->Ln(); 

                    $this->Cell($w[0],4,'','LR');
                    $this->Cell($w[1],4,'','LR',0,'C');
                    $this->Cell($w[2],4,'','LR',0,'C');
                    $this->Cell($w[3],4,'','LR',0,'C');
                    $this->Cell($w[4],4,'','LR',0,'C');
                    $this->Cell($w[5],4,'','LR',0,'C');
                    $this->Cell($w[6],4,'','LR',0,'C');
                    $this->Cell($w[7],4,'','LR',0,'C');
                    $this->Cell($w[8],4,utf8_decode($subaula4),'LR',0,'C');
                    $this->Cell($w[9],4,utf8_decode($suprof4),'LR',0,'C');               
                    $this->Ln(); 

                    $this->Cell($w[0],1,'','LR',0,'C');
                    $this->Cell($w[1],1,"",1,0,'C',TRUE);
                    $this->Cell($w[2],1,"",1,0,'C',TRUE);
                    $this->Cell($w[3],1,"",1,0,'C',TRUE);
                    $this->Cell($w[4],1,"",1,0,'C',TRUE);
                    $this->Cell($w[5],1,"",1,0,'C',TRUE);
                    $this->Cell($w[6],1,"",1,0,'C',TRUE);
                    $this->Cell($w[7],1,"",1,0,'C',TRUE);
                    $this->Cell($w[8],1,"",1,0,'C',TRUE);
                    $this->Cell($w[9],1,"",1,0,'C',TRUE);
                    $this->Ln();  
                }

            }else{

                $sub1 = substr($value[$i]['nombre_asignatura'], 0,40);
                $sub2 = substr($value[$i]['nombre_asignatura'], 40);

                $aula = $value[$i]['area'].' - '.$value[$i]['nombre_aula'];     
                $subaula = substr($aula, 0,10);
                $subaula2 = substr($aula, 10,10);
                $subaula3 = substr($aula, 20,10);;
                $subaula4 = substr($aula, 30,10);;

                $temProf = explode(' ', $value[$i]['nombre_y_apellido']);

                if(sizeof($temProf)>2){
                    $prof = $temProf[0].' '.$temProf[2];
                }else{
                    $prof = $temProf[0].' '.$temProf[1];
                }

                $suprof = substr($prof, 0,10);
                $suprof2 = substr($prof, 10,10);
                $suprof3 = substr($prof, 20,10);   
                $suprof4 = substr($prof, 30,10);  

                if(strlen($suprof2)==0){
                    $suprof2 = '';
                }

                if(strlen($suprof3)==0){
                    $suprof3 = '';
                }               

                if(strlen($suprof4)==0){
                    $suprof4 = '';
                }

                if($value[$i]['dia2'] == 'SIN INFORMACION'){
                    $value[$i]['dia2'] = 'S/I';
                }

                if($value[$i]['dia'] == 'SIN INFORMACION'){
                    $value[$i]['dia'] = 'S/I';
                }

                $this->Cell($w[1],4,utf8_decode($sub1),'LRT',0,'C');
                $this->Cell($w[2],4,utf8_decode($value[$i]['dia']),'LRT',0,'C');
                $this->Cell($w[3],4,utf8_decode($value[$i]['hora_inicio']),'LRT',0,'C');
                $this->Cell($w[4],4,utf8_decode($value[$i]['hora_fin']),'LRT',0,'C');
                $this->Cell($w[5],4,utf8_decode($value[$i]['fecha_inicio']),'LRT',0,'C');
                $this->Cell($w[6],4,utf8_decode($value[$i]['fecha_fin']),'LRT',0,'C');
                $this->Cell($w[7],4,utf8_decode($value[$i]['nombre_seccion']),'LRT',0,'C');
                $this->Cell($w[8],4,utf8_decode($subaula),'LRT',0,'C');
                $this->Cell($w[9],4,utf8_decode($suprof),'LRT',0,'C');
                $this->Ln();

                $this->Cell($w[0],4," ",'LR');
                $this->Cell($w[1],4,utf8_decode($sub2),'LR',0,'C');
                $this->Cell($w[2],4,'','LR',0,'C');
                $this->Cell($w[3],4,'','LR',0,'C');
                $this->Cell($w[4],4,'','LR',0,'C');
                $this->Cell($w[5],4,'','LR',0,'C');
                $this->Cell($w[6],4,'','LR',0,'C');
                $this->Cell($w[7],4,'','LR',0,'C');
                $this->Cell($w[8],4,utf8_decode($subaula2),'LR',0,'C');
                $this->Cell($w[9],4,utf8_decode($suprof2),'LR',0,'C');               
                $this->Ln();

                $this->Cell($w[0],4," ",'LR');
                $this->Cell($w[1],4,'','LR',0,'C');
                $this->Cell($w[2],4,'','LR',0,'C');
                $this->Cell($w[3],4,'','LR',0,'C');
                $this->Cell($w[4],4,'','LR',0,'C');
                $this->Cell($w[5],4,'','LR',0,'C');
                $this->Cell($w[6],4,'','LR',0,'C');
                $this->Cell($w[7],4,'','LR',0,'C');
                $this->Cell($w[8],4,utf8_decode($subaula3),'LR',0,'C');
                $this->Cell($w[9],4,utf8_decode($suprof3),'LR',0,'C');               
                $this->Ln();

                $this->Cell($w[0],4," ",'LR');
                $this->Cell($w[1],4,'','LR',0,'C');
                $this->Cell($w[2],4,'','LR',0,'C');
                $this->Cell($w[3],4,'','LR',0,'C');
                $this->Cell($w[4],4,'','LR',0,'C');
                $this->Cell($w[5],4,'','LR',0,'C');
                $this->Cell($w[6],4,'','LR',0,'C');
                $this->Cell($w[7],4,'','LR',0,'C');
                $this->Cell($w[8],4,utf8_decode($subaula4),'LR',0,'C');
                $this->Cell($w[9],4,utf8_decode($suprof4),'LR',0,'C');               
                $this->Ln();

                $this->Cell($w[0],1,'','LR',0,'C');
                $this->Cell($w[1],1,"",1,0,'C',TRUE);
                $this->Cell($w[2],1,"",1,0,'C',TRUE);
                $this->Cell($w[3],1,"",1,0,'C',TRUE);
                $this->Cell($w[4],1,"",1,0,'C',TRUE);
                $this->Cell($w[5],1,"",1,0,'C',TRUE);
                $this->Cell($w[6],1,"",1,0,'C',TRUE);
                $this->Cell($w[7],1,"",1,0,'C',TRUE);
                $this->Cell($w[8],1,"",1,0,'C',TRUE);
                $this->Cell($w[9],1,"",1,0,'C',TRUE);
                $this->Ln(); 
               
            }

        }

        $this->linea++;
    }


    }

    public function imprimir($cohorte,$programa,$horarios){
        // Creación del objeto de la clase heredada

        $pdf = new Horariospdf();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $cabezera=array('','Unidades Curriculares','Días','Hora Inicio','Hora Fin','Fecha Inicio','Fecha Fin','Seccion','Aula','Profesor');
        
        
        $pdf->tabla($cabezera,$cohorte,$programa,$horarios);

        $pdf->SetFont('Times','',12);
        // echo json_encode(site_url().'source/pdf/doc.pdf');
        // $doc = rand(1, 9999);
        $doc = 'doc';
        $path = '/source/tmp/horario-'.$doc.'.pdf';
        $url = $_SERVER['DOCUMENT_ROOT'].'/public/sistemaphp';
        $pdf->Output($url.$path, 'F');
        // $url = sys_get_temp_dir().'/doc.pdf';
        // $pdf->Output($url, 'F');
        // $pdf->Output();
        return base_url($path);
        // return $url;
        // $pdf->Output('tmp_pdf/doc.pdf', 'I');
        
        //print_r($data);
    }

}

/* End of file  */
/* Location: ./application/models/ */