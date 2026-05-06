<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inscripcionpdf extends FPDF {

    public function __construct() {
        parent::__construct();
        
    }
    var $B;
    var $I;
    var $U;
    var $HREF;

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
        $this->Ln(1);
        $this->Cell(0, 5, utf8_decode('PLANILLA DE INSCRIPCIÓN'), 0, 1, 'C');
        // Salto de línea
        $this->Ln(6);
    }

    // Una tabla más completa
    function tabla($header, $data)
    {
    // Anchuras de las columnas
        $w = array(75, 6,6, 13, 8,30,28,28);
    // Cabeceras
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(231,223,223);
        $fill=false;
        for($i=0;$i<count($header);$i++){
            if($i<0)
                $this->Cell($w[$i],4,utf8_decode($header[$i]),1,0,'C',$fill);
            else{
                $fill=true;
                $this->Cell($w[$i],4,utf8_decode($header[$i]),1,0,'C',$fill);
            }
        }
        
        $this->Ln();
    // Datos
        $aux="";
        $horasTotales=0;
        $ucTotales=0;
        $cont=0;
        foreach($data as $row)
        {   
            $this->SetFont('Arial','',7);

            if(strlen($row[0][0])<40 && strlen($row[7][0])<15){
                $this->Cell($w[0],3,utf8_decode($row[0]),'LRT',0,'C');
                $this->Cell($w[1],3,utf8_decode($row[1]),1,0,'C');
                $this->Cell($w[2],3,utf8_decode($row[6]),1,0,'C');
                $this->Cell($w[3],3,utf8_decode($row[2]),1,0,'C');
                $this->Cell($w[4],3,utf8_decode($row[3]),1,0,'C');
                $this->Cell($w[5],3,utf8_decode($row[4]),1,0,'C');
                $this->Cell($w[6],3,utf8_decode($row[5]),1,0,'C');
                $this->Cell($w[7],3,utf8_decode($row[7]),1,0,'C');
                $this->Ln();
                $aux=$row[0];
                $cont=0;
            }else if (strlen($row[7][0])>15 && strlen($row[0][0])<40){
                $this->Cell($w[0],3,utf8_decode($row[0]),'LRT',0,'C');
                $this->Cell($w[1],3,utf8_decode($row[1]),'LRT',0,'C');
                $this->Cell($w[2],3,utf8_decode($row[6]),'LRT',0,'C');
                $this->Cell($w[3],3,utf8_decode($row[2]),'LRT',0,'C');
                $this->Cell($w[4],3,utf8_decode($row[3]),'LRT',0,'C');
                $this->Cell($w[5],3,utf8_decode($row[4]),'LRT',0,'C');
                $this->Cell($w[6],3,utf8_decode($row[5]),'LRT',0,'C');
                $this->Cell($w[7],3,utf8_decode($row[7][0]),'LRT',0,'C');
                $this->Ln();
                $this->Cell($w[0],3,'','LR',0,'C');
                $this->Cell($w[1],3,"",'LR',0,'C');
                $this->Cell($w[2],3,"",'LR',0,'C');
                $this->Cell($w[3],3,"",'LR',0,'C');
                $this->Cell($w[4],3,"",'LR',0,'C');
                $this->Cell($w[5],3,"",'LR',0,'C');
                $this->Cell($w[6],3,"",'LR',0,'C');
                $this->Cell($w[7],3,utf8_decode($row[7][1]),'LR',0,'C');
                $this->Ln();
                $aux=$row[0];
                $cont=0;
            }else if (strlen($row[0][0])>40 && strlen($row[7][0])>15){
                $this->Cell($w[0],3,utf8_decode($row[0][0]),'LRT',0,'C');
                $this->Cell($w[1],3,utf8_decode($row[1]),'LRT',0,'C');
                $this->Cell($w[2],3,utf8_decode($row[6]),'LRT',0,'C');
                $this->Cell($w[3],3,utf8_decode($row[2]),'LRT',0,'C');
                $this->Cell($w[4],3,utf8_decode($row[3]),'LRT',0,'C');
                $this->Cell($w[5],3,utf8_decode($row[4]),'LRT',0,'C');
                $this->Cell($w[6],3,utf8_decode($row[5]),'LRT',0,'C');
                $this->Cell($w[7],3,utf8_decode($row[7][0]),'LRT',0,'C');
                $this->Ln();
                $this->Cell($w[0],3,utf8_decode($row[0][1]),'LR',0,'C');
                $this->Cell($w[1],3,"",'LR',0,'C');
                $this->Cell($w[2],3,"",'LR',0,'C');
                $this->Cell($w[3],3,"",'LR',0,'C');
                $this->Cell($w[4],3,"",'LR',0,'C');
                $this->Cell($w[5],3,"",'LR',0,'C');
                $this->Cell($w[6],3,"",'LR',0,'C');
                $this->Cell($w[7],3,utf8_decode($row[7][1]),'LR',0,'C');
                $this->Ln();
                $aux=$row[0];
                $cont=0;
            }else if (strlen($row[0][0])>40 && strlen($row[7][0])<15){
                $this->Cell($w[0],3,utf8_decode($row[0][0]),'LRT',0,'C');
                $this->Cell($w[1],3,utf8_decode($row[1]),'LRT',0,'C');
                $this->Cell($w[2],3,utf8_decode($row[6]),'LRT',0,'C');
                $this->Cell($w[3],3,utf8_decode($row[2]),'LRT',0,'C');
                $this->Cell($w[4],3,utf8_decode($row[3]),'LRT',0,'C');
                $this->Cell($w[5],3,utf8_decode($row[4]),'LRT',0,'C');
                $this->Cell($w[6],3,utf8_decode($row[5]),'LRT',0,'C');
                $this->Cell($w[7],3,utf8_decode($row[7]),'LRT',0,'C');
                $this->Ln();
                $this->Cell($w[0],3,utf8_decode($row[0][1]),'LR',0,'C');
                $this->Cell($w[1],3,"",'LR',0,'C');
                $this->Cell($w[2],3,"",'LR',0,'C');
                $this->Cell($w[3],3,"",'LR',0,'C');
                $this->Cell($w[4],3,"",'LR',0,'C');
                $this->Cell($w[5],3,"",'LR',0,'C');
                $this->Cell($w[6],3,"",'LR',0,'C');
                $this->Cell($w[7],3,"",'LR',0,'C');
                $this->Ln();
                $aux=$row[0];
                $cont=0;
            }
            
        }

    // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
        $this->Ln();
    }

    function tabla2($header, $data,$costo_periodo)
    {
    // Anchuras de las columnas
        $w = array(39, 39,39, 39, 38);
    // Cabeceras
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(231,223,223);
        $fill=false;
        for($i=0;$i<count($header);$i++){
            if($i<0)
                $this->Cell($w[$i],4,utf8_decode($header[$i]),1,0,'C',$fill);
            else{
                $fill=true;
                $this->Cell($w[$i],4,utf8_decode($header[$i]),1,0,'C',$fill);
            }
        }
        
        $this->Ln();
    // Datos
        $aux="";
        $horasTotales=0;
        $ucTotales=0;
        $cont=0;
        foreach($data as $row)
        {   
            $this->SetFont('Arial','',7);
            if(strcasecmp($aux, $row[0])!=0){
                $cont=0;
                $this->Cell($w[0],3,utf8_decode($row[0]),'LRT',0,'C');
            }else{
                $cont++;
                $this->Cell($w[0],3,"",1,'LR');
            }
            $this->Cell($w[1],3,utf8_decode($row[1]."  Bs"),1,0,'C');
            $this->Cell($w[2],3,utf8_decode($row[2]),1,0,'C');
            $this->Cell($w[3],3,utf8_decode($row[3]."  Bs"),1,0,'C');
            $this->Cell($w[4],3,utf8_decode($row[4]),1,0,'C');
            $this->Ln();
            $aux=$row[0];

            $cont=0;
        }

    // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
        $this->Ln();
        $this->Cell(array_sum($w)-77,5," ",'');
        $this->Cell(39,3,utf8_decode('Costo del Período'),1,0,'C');
        $this->Cell(38,3,$costo_periodo." Bs",1,0,'C',$fill);

    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(125);
        $this->Cell(0, 10, 'Inscripcion Web', 0, 0, 'C');
        $this->Image(base_url('source/img/13x.png'), 3, 262, 200);
    }

    function Titles($label) {
        // Arial 12
        $this->SetFont('Arial', 'B', 11);
        // Color de fondo
        $this->SetFillColor(38, 41, 111);
        $this->SetTextColor(255);
        // Título
        $this->Cell(194, 5, utf8_decode("$label"), 1, 1, 'L', true);
    }

    function imprimir($cdei, $nombres, $apellidos,$cohorte,$periodo,$seccion,$programa,$lapsoAcademico, $fechaYHoraInscripcion,$horaInscripcion,$codigo_inscripcion,$datos_periodo,$datos_control_pagos,$foto='') {
        $pdf = new Inscripcionpdf();
        $pdf->AddPage();
        $a=array();
        $data=array();
        $prof="ALEJANDRO ACOSTA MENA";
        
        $a[0]="Unidades Curriculares";
        $a[1]="U.C";
        $a[2]="H.T";
        $a[3]="Días";
        $a[4]="Aula";
        $a[5]="Hora Inicio - Hora Fin";
        $a[6]="Desde - Hasta";
        $a[7]="Profesor";

        $a2[0]="Descripción";
        $a2[1]="Pago";
        $a2[2]="Fechas de Pago";
        $a2[3]="Deuda";
        $a2[4]="Estatus";
        
        $i=0;
        foreach ($datos_periodo as $key => $value) {
            $materia=$key;
            $materiax=$pdf->character_limiter($materia,40);
            $datosExtra=explode("%", $value[0]);
            if (strlen($materia)>=40){
                $data[$i][0]=$materiax;
            }
            else{
                $data[$i][0]=$materia;
            }
            $data[$i][1]=$datosExtra[1];
            $data[$i][2]=$datosExtra[2];
            $data[$i][3]=$datosExtra[4];
            $data[$i][4]=$datosExtra[5];
            $data[$i][5]=$datosExtra[6];
            $data[$i][6]=$datosExtra[0];
            $prof=$datosExtra[7];
            if (strlen($prof)>=17){
                $data[$i][7]=$pdf->character_limiter($prof,17);
            }
            else{
                $data[$i][7]=$prof;
            }
            $i++;
        }
        $i=0;
        $costo_periodo=0;
        foreach ($datos_control_pagos as $key => $value) {
            $data2[$i][0]=$value['tipo'];
            $data2[$i][1]=$value['monto_cuota'];
            $data2[$i][2]=$value['fecha_pago'];
            $data2[$i][3]=$value['deuda'];
            $data2[$i][4]=$value['estatus'];
            $costo_periodo=$value['costo_periodo'];
            $i++;
        }
        

        $pdf->SetMargins(10, 0);
        $pdf->Titles('DATOS PERSONALES DEL ASPIRANTE');
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(133, 10, utf8_decode('Tipo Identificación: Cédula'), 0, 0);
        $pdf->Cell(85, 10, utf8_decode('Fecha de Inscripción: '.$fechaYHoraInscripcion['fecha']), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(85, 10, utf8_decode('C.I.Nº: ' . $cdei), 0, 0);
        $pdf->Cell(32, 32, utf8_decode(''), 1, 0);
        $pdf->Cell(19, 10, utf8_decode(''), 0, 0);
        $pdf->Cell(85, 10, utf8_decode('Hora de Inscripción: '.$fechaYHoraInscripcion['hora']), 0, 0);
        if(!empty($foto)){
            $pdf->Image(base_url($foto), 96, 68, 30,30);
        }else{
            $pdf->Image(base_url('source/img/imagen_vacia.png'), 96, 68, 30);
            // $pdf->Image(base_url('source/img/imagen_vacia.png'), 96, 68, 30);
        }
        $pdf->Ln(6);
        $pdf->Cell(85, 10, utf8_decode('Nombres del Alumno(a): ' . $nombres), 0, 0);
        //$pdf->Image(base_url('source/img/imagen_vacia.png'), 95, 83, 30);
        $pdf->Ln(6);
        $pdf->Cell(0, 10, utf8_decode('Apellidos del Alumno(a): ' . $apellidos), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('Cohorte: '.$cohorte), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(0, 10, utf8_decode('Período: '.$periodo), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('Sección: '.$seccion), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('Nro Carnet: '), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('Programa: '.$programa), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('Lapso Académico: '.$lapsoAcademico), 0, 0);
        //$pdf->SetMargins(10, 0);
        $pdf->Ln(12);
        $pdf->SetMargins(10, 0);
        $pdf->Titles('DATOS DEL PERIODO A CURSAR');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0);
        $pdf->tabla($a,$data);
        $pdf->SetMargins(10, 0);
        $pdf->Ln(6);
        //$pdf->SetMargins(12, 0);
        $pdf->Titles('CONTROL DE PAGOS');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0);
        $pdf->tabla2($a2,$data2,$costo_periodo);
        $pdf->Ln(12);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(85, 10, utf8_decode('Firma del Aspirante: ______________'), 0, 0);
        $pdf->Cell(85, 10, utf8_decode('Firma del Funcionario Receptor: ______________'), 0, 0);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 10);
        // Codigo de Referencia
        $pdf->Cell(85, 10, utf8_decode('3211-22-25265-23'), 0, 0);
        $pdf->Ln(10);
        $pdf->Cell(85, 10, utf8_decode('Va sin enmienda'), 0, 0);
        $pdf->Ln(4);
        $pdf->Cell(85, 10, utf8_decode('Válido únicamente con firma y sello'), 0, 0);
        //BarCode
        $pdf->SetFillColor(0,0,0);
        $pdf->write1DBarcode($codigo_inscripcion, 'C128B', 153, 82, 50, 14, '', '', 'B');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(1);
        $pdf->Cell(142, 3, utf8_decode(''), 0, 0, 'L');
        $pdf->Cell(0, 3, utf8_decode($codigo_inscripcion), 0, 0, 'C');
        $pdf->write2DBarcode('www.google.com', 'QRCODE,L', 170, 107, 15, 15, '', 'N');

        $pdf->Output();
    }

}
