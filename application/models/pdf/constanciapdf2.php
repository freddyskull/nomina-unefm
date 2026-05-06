<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('mc_table.php');
class Constanciapdf extends PDF_MC_Table {
    public function __construct()
    {
        parent::__construct();
        
    }


// Cabecera de página
    function Header() {
        $this->SetY(6);
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(0);
        $this->Cell(160, 5,'FECHA: '.date("d/m/Y"), 0,1,'R');
        $this->Image(base_url('source/img/wensly_2.jpg'), 18, 12, 164);
        $this->Ln(35);
      
    }

    function Cuerpo(){
        //$this->Image(base_url('source/img/firma_pirona.jpg'),'51','209','50','30','JPG');

        $this->SetY(50);
        foreach ($this->datosper as $key => $datosper) {
        $this->SetFont('Arial', '', 14);
        $this->SetTextColor(0);
        $this->Cell(0, 5,utf8_decode('CONSTANCIA'), 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Ln(6);
        $this->MultiCell(0, 7,utf8_decode(' Quien suscribe, Director(a) de Recursos Humanos, de la Universidad Nacional Experimental Francisco de Miranda (UNEFM), hago constar por medio de la presente que los datos indicados a continuación corresponden a nuestro Personal '.$datosper[6].' '.$datosper[5].':'), 0,'J');
        $this->Ln(5);
        $this->SetFillColor(204,204,204);
        $this->Cell(60, 7,utf8_decode('   NOMBRES Y APELLIDOS:'), 1,0,'L');
        $this->Cell(114, 7,utf8_decode('   '.$datosper[1].' '.$datosper[2]), 1,0,'L');
        $this->Ln(7);
        $this->Cell(60, 7,utf8_decode('   CÉDULA DE IDENTIDAD:'), 1,0,'L');
        $this->Cell(114, 7,'   '.$datosper[0], 1,0,'L');
        }
        $this->Ln(7);
        if ($this->tipoper=='01') {
        $this->Cell(60, 7,utf8_decode('   CATEGORÍA:'), 1,0,'L');
        }else{
        $this->Cell(60, 7,utf8_decode('   CARGO:'), 1,0,'L');
        }
        foreach ($this->cargos as $key => $cargos) {
        if ($cargos[0]=='T.CONV.') {
            $this->Cell(114, 7,utf8_decode('   '.$cargos[2].' '.$cargos[0].' '.$cargos[3].' Horas'), 1,0,'L');
        }else{
        $this->Cell(114, 7,utf8_decode('   '.$cargos[2].' '.$cargos[0]), 1,0,'L');
        }
        }
        foreach ($this->fechaini as $key => $fechaini) { 
            $this->Ln(7);
            $this->Cell(60, 7,'   FECHA DE INGRESO:', 1,0,'L');
            $this->Cell(114, 7,'   '.$fechaini[0], 1,0,'L');
        }
            if ($datosper[4]=='07' || $datosper[4]=='08') {//jubilado o pensionado
                foreach ($this->fechaegre as $key => $fechaegre) {
                    $this->Ln(7);
                    $this->Cell(60, 7,'   FECHA DE EGRESO:', 1,0,'L');
                    $this->Cell(114, 7,'   '.$fechaegre[0], 1,0,'L');    
                }
            }
        if ($this->sueldo=='01') { //SUELDO INTEGRAL

            $this->Ln(7);
            if ($datosper[4]=='07' || $datosper[4]=='08') {
                foreach ($this->monto as $key => $monto) {     
                foreach ($this->tf as $key => $tf) {
                if ($tf[0]=='03') {
                $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                $this->Cell(114, 7,'   '.number_format($monto[0]/7*30, 2, ',', '.'), 1,0,'L'); 
            }else{
                $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                $this->Cell(114, 7,'   '.number_format($monto[0], 2, ',', '.'), 1,0,'L');
            }
            }
            }
            }else{
                foreach ($this->monto as $key => $monto) {
                foreach ($this->tf as $key => $tf) {
                if ($tf[0]=='03') {
                $this->Cell(60, 7,'   SUELDO INTEGRAL:', 1,0,'L');
                $this->Cell(114, 7,'   '.number_format($monto[0]/7*30, 2, ',', '.'), 1,0,'L'); 
            }else{
                $this->Cell(60, 7,'   SUELDO INTEGRAL:', 1,0,'L');
                $this->Cell(114, 7,'   '.number_format($monto[0], 2, ',', '.'), 1,0,'L');
            }
            }
            }
            }
        }    
        if ($this->sueldo=='02') { //SUELDO ANUAL

            $this->Ln(7);
            if ($datosper[4]=='07' || $datosper[4]=='08') {//jubilado o pensionado
                foreach ($this->monto as $key => $monto) {
                foreach ($this->tf as $key => $tf) {
                    if ($tf[0]=='03') {
                        $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                        $this->Cell(114, 7,'   '.number_format(($monto[0]/7*30)*12, 2, ',', '.'), 1,0,'L'); 
                    }else{
                        $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                        $this->Cell(114, 7,'   '.number_format($monto[0]*12, 2, ',', '.'), 1,0,'L');
                    }
                }
                }
            }else{
                foreach ($this->monto as $key => $monto) {
                foreach ($this->tf as $key => $tf) {
                    if ($tf[0]=='03') {
                        $this->Cell(60, 7,'   SUELDO ANUAL:', 1,0,'L');
                        $this->Cell(114, 7,'   '.number_format(($monto[0]/7*30)*12, 2, ',', '.'), 1,0,'L'); 
                    }else{   
                        $this->Cell(60, 7,'   SUELDO ANUAL:', 1,0,'L');
                        $this->Cell(114, 7,'   '.number_format($monto[0]*12, 2, ',', '.'), 1,0,'L'); 
                    }
                }
                }
            } 
        }
        if ($this->sueldo=='03') { //SUELDO BASICO

            $this->Ln(7);
            if ($datosper[4]=='07' || $datosper[4]=='08') {//jubilado o pensionado
                foreach ($this->sub as $key => $sub) {
                $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                $this->Cell(114, 7,'   '.number_format($sub[0], 2, ',', '.'), 1,0,'L'); 
                }
            }else{
                foreach ($this->sub as $key => $sub) {
                $this->Cell(60, 7,utf8_decode('   SUELDO BÁSICO:'), 1,0,'L');
                $this->Cell(114, 7,'   '.number_format($sub[0], 2, ',', '.'), 1,0,'L');
                } 
            }
        }

        if ($datosper[4]=='01' || $datosper[4]=='09' || $datosper[4]=='05')   {
            $this->SetFont('Helvetica', '', 10);
            if ($this->tipoper=='01') {

            $this->Ln(7);
            $this->Cell(54, 7,utf8_decode('LAPSO DE CONTRATACIÓN:'), 1,0,'L',true);
            $this->Cell(60, 7,utf8_decode('CONDICIÓN:'), 1,0,'L',true);
            $this->Cell(60, 7,'DEPENDENCIA:', 1,0,'L',true);
            $this->Ln(7);

            foreach ($this->fechacon as $key => $fechacon) {

                    $this->SetFont('Helvetica', '', 8);
                    $this->SetWidths(array(54,60,60));
                    $this->SetAligns(array('L','L','L'));
                    $this->Row(array(utf8_decode('Desde: '.$fechacon[0].' Hasta: '.$fechacon[1]),utf8_decode($datosper[5]),utf8_decode($fechacon[4])));

                    //$this->Ln(5);


                 
                }
        

            }else{
            $this->Ln(7);
            $this->Cell(60, 7,utf8_decode('DEPENDENCIA:'), 1,0,'L',true);
            $this->Cell(114, 7,utf8_decode('LAPSO DE CONTRATACIÓN:'), 1,0,'L',true);
            $this->Ln(7);

            foreach ($this->fechacon as $key => $fechacon) {
                    $this->SetFont('Helvetica', '', 8);
                    $this->SetWidths(array(60,114));
                    $this->SetAligns(array('L','L'));
                    $this->Row(array(utf8_decode($fechacon[4]),utf8_decode('Desde: '.$fechacon[0].' Hasta: '.$fechacon[1])));

                    //$this->Ln(5);


                 
                
            } 
            }
        }
        $this->Ln(7);
        if ($this->ces=='02') {
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(0, 5,utf8_decode('Nota Observatoria: Percibe el beneficio de Cesta de Alimentación vigente en el País equivalente a 12 Unidades Tributarias (U.T) diarias en base a treinta (30) días por mes.'), 0,'J');
            
        }
    $this->Ln(2);
    $this->SetFont('Arial', '', 12);
    $this->MultiCell(0, 5,utf8_decode('    Constancia que se expide a petición de la parte interesada, en Santa Ana de Coro a los '.date("d").' días del mes de '.$this->mes.' de '.date("Y")), 0,'J');
    
    $this->ln(15);
    $this->Cell(61, 7,'', 0,0,'L');
    $this->Cell(20,30,$this->Image(base_url('source/img/firma_pirona.jpg'), $this->GetX(), $this->GetY(),51),0);
    $this->ln(31);

    $this->Cell(55, 5,'', 0,0,'L');
    $this->Cell(121, 5,'Lcda. Adriana Boscarino Berto                       Certificado', 0,0,'L');
    $this->ln(5);
    $this->Cell(52, 5,'', 0,0,'L');
    $this->Cell(121, 5,'Director(a) de Recursos Humanos', 0,0,'L');
    
    }

// Pie de página
    function Footer() {
        $this->SetY(-38);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->MultiCell(0, 5,utf8_decode('Nota: Constancia válida por 3 meses, debe poseer sello húmedo de la Dirección Recursos Humanos Correo:registroycontrol@correo.unefm.edu.ve'), 0,'J');
        $this->Image(base_url('source/img/wensly_1.jpg'), 19, 271, 172);

    }

    function imprimir($tipoper,$datosper,$cargos,$fechaini,$fechaegre,$sueldo,$ces,$fechacon,$monto,$tf,$sub) {
        $pdf = new Constanciapdf('P', 'mm', 'Letter');
        $pdf->tipoper=$tipoper;
        $pdf->sueldo=$sueldo;
        $pdf->ces=$ces;
        $pdf->datosper=$datosper;
        $pdf->fechaegre=$fechaegre;
        $pdf->cargos=$cargos;
        $pdf->fechaini=$fechaini;
        $pdf->fechacon=$fechacon;
        $pdf->monto=$monto;
        $pdf->tf=$tf;
        $pdf->sub=$sub;
        $mes=date("F");
        if ($mes=="January") $mes="Enero";
        if ($mes=="February") $mes="Febrero";
        if ($mes=="March") $mes="Marzo";
        if ($mes=="April") $mes="Abril";
        if ($mes=="May") $mes="Mayo";
        if ($mes=="June") $mes="Junio";
        if ($mes=="July") $mes="Julio";
        if ($mes=="August") $mes="Agosto";
        if ($mes=="September") $mes="Setiembre";
        if ($mes=="October") $mes="Octubre";
        if ($mes=="November") $mes="Noviembre";
        if ($mes=="December") $mes="Diciembre";
        $pdf->mes=$mes;
        $pdf->SetMargins(18,1 , 18); 
        $pdf->SetAutoPageBreak(true,45);
        $pdf->AddPage();
        $pdf->Cuerpo();
        $pdf->Output();
    }

}

