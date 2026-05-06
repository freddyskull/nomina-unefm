<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Censopdf extends FPDF {

    public function __construct() {
        parent::__construct();
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
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 16);
        $this->Ln(6);
        $this->Cell(0, 5, utf8_decode('PLANILLA DE CENSO'), 0, 1, 'C');
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
        $this->Cell(0, 10, 'Censo Web', 0, 0, 'C');
        $this->Image(base_url('source/img/13x.png'), 3, 250, 200);
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

    function imprimir($cdei, $nombres, $apellidos, $fnac, $edad, $edocivil, $dirhab, $telhab, $telmov, $sexo, $mail, $institucion, $empresa, $teltrab, $prof, $fegre, $cohorte, $programa, $fechapre, $codigoCenso,$foto) {
        $pdf = new Censopdf();
        $pdf->AddPage();
        $pdf->SetMargins(12, 0);
        $pdf->Titles('I. DATOS PERSONALES DEL ASPIRANTE');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0);
        $pdf->Cell(85, 10, utf8_decode('Tipo Identificación: Cédula'), 0, 0);
        $pdf->Cell(48, 10, utf8_decode('C.I.Nº: ' . $cdei), 0, 0);
        $pdf->Cell(85, 10, utf8_decode('Nacionalidad: VENEZOLANO'), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(0, 10, utf8_decode('Nombres del Solicitante: ' . $nombres), 0, 0);
        //$pdf->Image(base_url('source/img/imagen_vacia.png'), 162, 90, 37);
        $pdf->Image(base_url($foto), 162, 90, 37);
        $pdf->Ln(6);
        $pdf->Cell(0, 10, utf8_decode('Apellidos del Solicitante: ' . $apellidos), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('Fecha de Nacimiento: ' . $fnac), 0, 0);
        $pdf->Cell(0, 10, utf8_decode('Edad: ' . $edad), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('Edo.Civil: ' . $edocivil), 0, 0);
        $pdf->Ln(6);
        $b=$this->character_limiter($dirhab,40);
        if(is_array($b)){
            $pdf->Cell(85, 10, utf8_decode('Dirección de Habitación: ' ."$b[0]"),0,0);
            $pdf->Ln(6);
            $pdf->Cell(47, 10, utf8_decode(""),0,0);
            $pdf->Cell(85, 10, utf8_decode("$b[1]"),0,0);
        }else{
            $pdf->Cell(86, 10, utf8_decode('Dirección de Habitación: ' . $dirhab), 0, 0);
        }
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('Telef.Habit: ' . $telhab), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('Telef.Movil: ' . $telmov), 0, 0);
        $pdf->Cell(0, 10, utf8_decode('Sexo: ' . $sexo), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(86, 10, utf8_decode('E-mail: ' . $mail), 0, 0);
        $pdf->SetMargins(10, 0);
        $pdf->Ln(12);
        $pdf->SetMargins(12, 0);
        $pdf->Titles('II. ULTIMOS DATOS ACADEMICOS Y SOCIOECONOMICOS OBTENIDOS');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0);
        $pdf->Cell(21, 10, utf8_decode('Institución:'), 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $a=$this->character_limiter($institucion,70);
        if(is_array($a)){
            $pdf->Cell(85, 10, utf8_decode("$a[0]"),0,0);
            $pdf->Ln(6);
            $pdf->Cell(21, 10, utf8_decode(""),0,0);
            $pdf->Cell(85, 10, utf8_decode("$a[1]"),0,0);
        }else{
            $pdf->Cell(85, 10, utf8_decode("$institucion"),0,0);
        }
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(85, 10, utf8_decode('Empresa: ' . $empresa), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(85, 10, utf8_decode('Telefono de trabajo: ' . $teltrab), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(85, 10, utf8_decode('Profesion: ' . $prof), 0, 0);
        $pdf->Ln(6);
        $pdf->Cell(85, 10, utf8_decode('Fecha de Egreso:' . $fegre), 0, 0);
        $pdf->SetMargins(10, 0);
        $pdf->Ln(12);
        $pdf->SetMargins(12, 0);
        $pdf->Titles('III. PROGRAMA QUE DESEA CURSAR');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0);
        $pdf->Cell(85, 10, utf8_decode(/*"Cohorte-" . $cohorte . " -> " .*/ $programa), 0, 0);
        $pdf->Ln(12);
        $pdf->Cell(85, 10, utf8_decode('Fecha de censo: ' . $fechapre), 0, 0);
        $pdf->Ln(35);
        //$pdf->Cell(85, 10, utf8_decode('Firma del Aspirante: ______________'), 0, 0);
        //$pdf->Cell(85, 10, utf8_decode('Firma del Funcionario Receptor: ______________'), 0, 0);
        $pdf->Ln(6);
        //BarCode
        $pdf->SetFillColor(0,0,0);
        $pdf->write1DBarcode($codigoCenso, 'C128B', 105, 210, 50, 14, '', '', 'B');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(1);
        $pdf->Cell(44, 3, utf8_decode(''), 0, 0, 'L');
        $pdf->Cell(0, 3, utf8_decode($codigoCenso), 0, 0, 'C');
        $pdf->write2DBarcode('www.google.com', 'QRCODE,L', 170, 210, 15, 15, '', 'N');

        $pdf->Output();
    }

}
