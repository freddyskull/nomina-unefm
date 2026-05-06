<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('mc_table.php');
class Nominapdf extends PDF_MC_Table 
{
    public function __construct()
    {
        parent::__construct();
        
    }



    function Cuerpo_quincenal()
    {
        //$this->Image(base_url('source/img/firma_pirona.jpg'),'51','209','50','30','JPG');

        $this->SetFillColor(204,204,204);
        $this->SetTextColor(0);
        foreach ($this->datoscont as $key => $value) 
        {
        $this->Cell(5, 7,'', 0,0,'L');
        $this->ln();
        $this->SetFont('Arial', 'B', 11);
        $this->Image(FCPATH . 'source/img/logo.png', 9, $this->GetY(),8,10,'PNG');
        $this->Cell(0, 5,utf8_decode('UNIVERSIDAD NACIONAL EXPERIMENTAL'), 0, 1, 'C');
        $this->Cell(0, 5,utf8_decode('"FRANCISCO DE MIRANDA"'), 0, 1, 'C');
        $this->Cell(0, 5,utf8_decode('RELACION DE ASIGNACIONES Y DEDUCCIONES'), 0, 1, 'C');
        $this->MultiCell(0, 5,utf8_decode($value['destipnom'].' '.$value['desnom']), 0,'C');
        $this->SetFont('Arial', '', 11);

        
        $this->Cell(40, 5,utf8_decode('CEDULA: '.$value['datosprinc']['cedula']), 0, 0, 'L');
        $this->Cell(95, 5,utf8_decode('NOMBRE: '.$value['datosprinc']['apellido'].' '.substr($value['datosprinc']['nombre'],0,8)), 0, 0, 'L');
        $this->Cell(70, 5,utf8_decode('SUELDO BASICO: '.number_format($value['asignaciones'][0]['monto1'], 2, ',', '.')), 0, 0, 'L');
        $this->Ln(5);
        $this->Cell(73, 5,utf8_decode('CARGO: '.substr($value['cargo']['des_cargo'],0,20)), 0, 0, 'L');
        $this->Cell(73, 5,utf8_decode('UBICACION: '.substr($value['dependencia']['desdep'],0,23).'-'.substr($value['dependencia']['ubidep'],0,12)), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(49, 5,utf8_decode('ASIGNACIONES'), 0, 0, 'L',true);
        $this->Cell(25, 5,utf8_decode('MONTO'), 0, 0, 'L',true);
        $this->Cell(15, 5,utf8_decode('ACUM'), 0, 0, 'L',true);
        $this->Cell(39, 5,utf8_decode('DEDUCCIONES'), 0, 0, 'L',true);
        $this->Cell(22, 5,utf8_decode('CUOTA'), 0, 0, 'L',true);
        $this->Cell(30, 5,utf8_decode('MONTO'), 0, 0, 'L',true);
        $this->Cell(20, 5,utf8_decode('ACUM'), 0, 0, 'L',true);

        //$this->Cell(0, 5,utf8_decode($this->session->flashdata('mes')), 0, 1, 'C');


        $this->Ln(5);
        $this->SetFont('Arial', '', 11);

        if (count($value['asignaciones'])<count($value['deducciones'])) 
        {
            foreach ($value['deducciones'] as $key1 => $value2) {

        
                $cont=$key1;
                if (isset($value['asignaciones'][$cont]['descorta1'])) {
                    $this->Cell(49, 5,utf8_decode($value['asignaciones'][$cont]['descorta1']), 0, 0, 'L');
                 }else{
                    $this->Cell(49, 5,utf8_decode(''), 0, 0, 'L');
                 }
                if (isset($value['asignaciones'][$cont]['monto1'])) {
                    $this->Cell(25, 5,utf8_decode(number_format($value['asignaciones'][$cont]['monto1'], 2, ',', '.')), 0, 0, 'L');
                 }else{
                    $this->Cell(25, 5,utf8_decode(''), 0, 0, 'L');
                 }
                if (isset($value['asignaciones'][$cont]['cuota1'])) {
                    $this->Cell(15, 5,utf8_decode($value['asignaciones'][$cont]['cuota1']), 0, 0, 'L');
                 }else{
                    $this->Cell(15, 5,utf8_decode(''), 0, 0, 'L');
                 }
                 
                $this->Cell(39, 5,utf8_decode($value['deducciones'][$cont]['descorta2']), 0, 0, 'L');
                $this->Cell(22, 5,utf8_decode(utf8_decode($value['deducciones'][$cont]['cuota2'])), 0, 0, 'L');
                $this->Cell(30, 5,utf8_decode(number_format($value['deducciones'][$cont]['monto2'], 2, ',', '.')), 0, 0, 'L');

                $this->ln(5);

            }
        }
        elseif (count($value['asignaciones'])>count($value['deducciones'])) 
        {
            foreach ($value['asignaciones'] as $key1 => $value2) 
            {

        
                $cont=$key1;

                $this->Cell(49, 5,utf8_decode($value['asignaciones'][$cont]['descorta1']), 0, 0, 'L');
                $this->Cell(25, 5,utf8_decode(number_format($value['asignaciones'][$cont]['monto1'], 2, ',', '.')), 0, 0, 'L');
                $this->Cell(15, 5,utf8_decode($value['asignaciones'][$cont]['cuota1']), 0, 0, 'L');
                            
                if (isset($value['deducciones'][$cont]['descorta2'])) {
                    $this->Cell(39, 5,utf8_decode($value['deducciones'][$cont]['descorta2']), 0, 0, 'L');
                }else{
                    $this->Cell(39, 5,utf8_decode(''), 0, 0, 'L');
                }
                if (isset($value['deducciones'][$cont]['cuota2'])) {
                    $this->Cell(22, 5,utf8_decode($value['deducciones'][$cont]['cuota2']), 0, 0, 'L');
                }else{
                    $this->Cell(22, 5,utf8_decode(''), 0, 0, 'L');
                }
                if (isset($value['deducciones'][$cont]['monto2'])) {
                    
                    if ($value['deducciones'][$cont]['monto2']=='') {
                        $this->Cell(30, 5,utf8_decode($value['deducciones'][$cont]['monto2']), 0, 0, 'L');    
                    }else{


                        $this->Cell(30, 5,utf8_decode(number_format($value['deducciones'][$cont]['monto2'], 2, ',', '.')), 0, 0, 'L'); 
                    }
                }else{
                    $this->Cell(30, 5,utf8_decode(''), 0, 0, 'L');
                }
                $this->ln(5);

            }

        }
        else
        {
            foreach ($value['asignaciones'] as $key1 => $value2) 
            {

        
                $cont=$key1;

                $this->Cell(49, 5,utf8_decode($value['asignaciones'][$cont]['descorta1']), 0, 0, 'L');
                $this->Cell(25, 5,utf8_decode(number_format($value['asignaciones'][$cont]['monto1'], 2, ',', '.')), 0, 0, 'L');
                $this->Cell(15, 5,utf8_decode($value['asignaciones'][$cont]['cuota1']), 0, 0, 'L');

                $this->Cell(39, 5,utf8_decode($value['deducciones'][$cont]['descorta2']), 0, 0, 'L');
                $this->Cell(22, 5,utf8_decode(utf8_decode($value['deducciones'][$cont]['cuota2'])), 0, 0, 'L');
                if ($value['deducciones'][$cont]['monto2']=='') {
                $this->Cell(30, 5,utf8_decode($value['deducciones'][$cont]['monto2']), 0, 0, 'L');  
                }
                else
                {
                $this->Cell(30, 5,utf8_decode(number_format($value['deducciones'][$cont]['monto2'], 2, ',', '.')), 0, 0, 'L');
                }
                $this->ln(5);
            }
        }


        $totalasig=0;
        foreach ($value['asignaciones'] as $key1 => $value2) 
        {
            $cont=$key1;

            $totalasig+=$value['asignaciones'][$cont]['monto1'];

        }

        $totalded=0;
        foreach ($value['deducciones'] as $key2 => $value2) 
        {
            $cont=$key2;

            $totalded+=$value['deducciones'][$cont]['monto2'];

        }

        //Quincenal
        $totalsueldo=($totalasig-$totalded);
        $QUINCENA1=$totalsueldo/2;
        $QUINCENA2=$totalsueldo-$QUINCENA1;



        //Calculando salto de linea antes del total
        if (count($value['asignaciones'])>count($value['deducciones'])) 
        {
        $cantidad=count($value['asignaciones']);
        $salto=0;
        $salto=60-($cantidad*5);

        }
        else 
        {
        $cantidad=count($value['deducciones']);
        $salto=0;
        $salto=60-($cantidad*5); 
        }


        $this->Ln($salto);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(45, 5,utf8_decode('TOT. ASIGNAC :'), 0, 0, 'L',true);
        $this->SetFont('Arial', '', 11);
        $this->Cell(40, 5,utf8_decode(number_format($totalasig, 2, ',', '.')), 0, 0, 'L',true);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(62, 5,utf8_decode('TOT. DEDUCC :'), 0, 0, 'L',true);
        $this->SetFont('Arial', '', 11);
        $this->Cell(53, 5,utf8_decode(number_format($totalded, 2, ',', '.')), 0, 0, 'L',true);

        $this->ln(5);
    

        if ($value['codtipfre']=='01' && substr($value['datosprinc']['codnom'],0,1)!='P' && substr($value['datosprinc']['codnom'],0,1)!='B' && substr($value['datosprinc']['codnom'],0,1)!='H' ) 
        {
        

            $this->SetFont('Arial', 'B', 11);
            $this->Cell(32, 5,utf8_decode('1RA QUINCENA:'), 0, 0, 'L',true);
            $this->SetFont('Arial', '', 11);
            $this->Cell(35, 5,utf8_decode(number_format($QUINCENA1, 2, ',', '.')), 0, 0, 'L',true);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(32, 5,utf8_decode('2DA QUINCENA:'), 0, 0, 'L',true);
            $this->SetFont('Arial', '', 11);
            $this->Cell(35, 5,utf8_decode(number_format($QUINCENA2, 2, ',', '.')), 0, 0, 'L',true);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(36, 5,utf8_decode('NETO A COBRAR:'), 0, 0, 'L',true);
            $this->SetFont('Arial', '', 11);
            $this->Cell(30, 5,utf8_decode(number_format($totalsueldo, 2, ',', '.')), 0, 0, 'L',true);
        }
        else
        {
            $this->Cell(0, 5,utf8_decode('NETO A COBRAR: '.number_format($totalsueldo, 2, ',', '.').''), 0, 1, 'C',true);

        }
        
            $this->ln(25);


        }

    }

    function Cuerpo_semanal()
    {
        //$this->Image(base_url('source/img/firma_pirona.jpg'),'51','209','50','30','JPG');

        $this->SetFillColor(204,204,204);
        $this->SetTextColor(0);
        foreach ($this->datoscont as $key => $value) 
        {
        $this->Cell(5, 7,'', 0,0,'L');
        $this->ln();
        $this->SetFont('Arial', 'B', 11);
        $this->Image(base_url('source/img/logo.png'), 9, $this->GetY(),8,10,'PNG');
        $this->Cell(0, 5,utf8_decode('UNIVERSIDAD NACIONAL EXPERIMENTAL'), 0, 1, 'C');
        $this->Cell(0, 5,utf8_decode('"FRANCISCO DE MIRANDA"'), 0, 1, 'C');
        $this->Cell(0, 5,utf8_decode('RELACION DE ASIGNACIONES Y DEDUCCIONES'), 0, 1, 'C');
        $this->MultiCell(0, 5,utf8_decode($value['destipnom'].' '.$value['desnom']), 0,'C');
        $this->SetFont('Arial', '', 11);

        
        $this->Cell(40, 5,utf8_decode('CEDULA: '.$value['datosprinc']['cedula']), 0, 0, 'L');
        $this->Cell(95, 5,utf8_decode('NOMBRE: '.$value['datosprinc']['apellido'].' '.substr($value['datosprinc']['nombre'],0,8)), 0, 0, 'L');
        $this->Cell(70, 5,utf8_decode('SUELDO BASICO: '.number_format($value['asignaciones'][0]['monto1'], 2, ',', '.')), 0, 0, 'L');
        $this->Ln(5);
        $this->Cell(73, 5,utf8_decode('CARGO: '.substr($value['cargo']['des_cargo'],0,20)), 0, 0, 'L');
        $this->Cell(73, 5,utf8_decode('UBICACION: '.substr($value['dependencia']['desdep'],0,23).'-'.substr($value['dependencia']['ubidep'],0,12)), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(45, 5,utf8_decode('ASIGNACIONES'), 0, 0, 'L',true);
        $this->Cell(25, 5,utf8_decode('MONTO'), 0, 0, 'L',true);
        $this->Cell(15, 5,utf8_decode('ACUM'), 0, 0, 'L',true);
        $this->Cell(39, 5,utf8_decode('DEDUCCIONES'), 0, 0, 'L',true);
        $this->Cell(22, 5,utf8_decode('CUOTA'), 0, 0, 'L',true);
        $this->Cell(30, 5,utf8_decode('MONTO'), 0, 0, 'L',true);
        $this->Cell(24, 5,utf8_decode('ACUM'), 0, 0, 'L',true);

        //$this->Cell(0, 5,utf8_decode($this->session->flashdata('mes')), 0, 1, 'C');


        $this->Ln(5);
        $this->SetFont('Arial', '', 11);

        if (count($value['asignaciones'])<count($value['deducciones'])) 
        {
            foreach ($value['deducciones'] as $key1 => $value2) {

        
                $cont=$key1;
                if (isset($value['asignaciones'][$cont]['descorta1'])) {
                    $this->Cell(45, 5,utf8_decode($value['asignaciones'][$cont]['descorta1']), 0, 0, 'L');
                 }else{
                    $this->Cell(45, 5,utf8_decode(''), 0, 0, 'L');
                 }
                if (isset($value['asignaciones'][$cont]['monto1'])) {
                    $this->Cell(25, 5,utf8_decode(number_format($value['asignaciones'][$cont]['monto1'], 2, ',', '.')), 0, 0, 'L');
                 }else{
                    $this->Cell(25, 5,utf8_decode(''), 0, 0, 'L');
                 }
                if (isset($value['asignaciones'][$cont]['cuota1'])) {
                    $this->Cell(15, 5,utf8_decode($value['asignaciones'][$cont]['cuota1']), 0, 0, 'L');
                 }else{
                    $this->Cell(15, 5,utf8_decode(''), 0, 0, 'L');
                 }
                 
                $this->Cell(39, 5,utf8_decode($value['deducciones'][$cont]['descorta2']), 0, 0, 'L');
                $this->Cell(22, 5,utf8_decode(utf8_decode($value['deducciones'][$cont]['cuota2'])), 0, 0, 'L');
                $this->Cell(30, 5,utf8_decode(number_format($value['deducciones'][$cont]['monto2'], 2, ',', '.')), 0, 0, 'L');

                $this->ln(5);

            }
        }
        elseif (count($value['asignaciones'])>count($value['deducciones'])) 
        {
            foreach ($value['asignaciones'] as $key1 => $value2) 
            {

        
                $cont=$key1;

                $this->Cell(45, 5,utf8_decode($value['asignaciones'][$cont]['descorta1']), 0, 0, 'L');
                $this->Cell(25, 5,utf8_decode(number_format($value['asignaciones'][$cont]['monto1'], 2, ',', '.')), 0, 0, 'L');
                $this->Cell(15, 5,utf8_decode($value['asignaciones'][$cont]['cuota1']), 0, 0, 'L');
                            
                if (isset($value['deducciones'][$cont]['descorta2'])) {
                    $this->Cell(39, 5,utf8_decode($value['deducciones'][$cont]['descorta2']), 0, 0, 'L');
                }else{
                    $this->Cell(39, 5,utf8_decode(''), 0, 0, 'L');
                }
                if (isset($value['deducciones'][$cont]['cuota2'])) {
                    $this->Cell(22, 5,utf8_decode($value['deducciones'][$cont]['cuota2']), 0, 0, 'L');
                }else{
                    $this->Cell(22, 5,utf8_decode(''), 0, 0, 'L');
                }
                if (isset($value['deducciones'][$cont]['monto2'])) {
                    
                    if ($value['deducciones'][$cont]['monto2']=='') {
                        $this->Cell(30, 5,utf8_decode($value['deducciones'][$cont]['monto2']), 0, 0, 'L');    
                    }else{


                        $this->Cell(30, 5,utf8_decode(number_format($value['deducciones'][$cont]['monto2'], 2, ',', '.')), 0, 0, 'L'); 
                    }
                }else{
                    $this->Cell(30, 5,utf8_decode(''), 0, 0, 'L');
                }
                $this->ln(5);

            }

        }
        else
        {
            foreach ($value['asignaciones'] as $key1 => $value2) 
            {

        
                $cont=$key1;

                $this->Cell(45, 5,utf8_decode($value['asignaciones'][$cont]['descorta1']), 0, 0, 'L');
                $this->Cell(25, 5,utf8_decode(number_format($value['asignaciones'][$cont]['monto1'], 2, ',', '.')), 0, 0, 'L');
                $this->Cell(15, 5,utf8_decode($value['asignaciones'][$cont]['cuota1']), 0, 0, 'L');

                $this->Cell(39, 5,utf8_decode($value['deducciones'][$cont]['descorta2']), 0, 0, 'L');
                $this->Cell(22, 5,utf8_decode(utf8_decode($value['deducciones'][$cont]['cuota2'])), 0, 0, 'L');
                if ($value['deducciones'][$cont]['monto2']=='') {
                $this->Cell(30, 5,utf8_decode($value['deducciones'][$cont]['monto2']), 0, 0, 'L');  
                }
                else
                {
                $this->Cell(30, 5,utf8_decode(number_format($value['deducciones'][$cont]['monto2'], 2, ',', '.')), 0, 0, 'L');
                }
                $this->ln(5);
            }
        }


        $totalasig=0;
        foreach ($value['asignaciones'] as $key1 => $value2) 
        {
            $cont=$key1;

            $totalasig+=$value['asignaciones'][$cont]['monto1'];

        }

        $totalded=0;
        foreach ($value['deducciones'] as $key2 => $value2) 
        {
            $cont=$key2;

            $totalded+=$value['deducciones'][$cont]['monto2'];

        }

        //Semanal
        $totalsueldo=($totalasig-$totalded);
        
        $SEMANA = $totalsueldo/4;
        $SEMANA1= round($SEMANA , 2);
        $SEMANA4 = $totalsueldo - ($SEMANA1*3);

       

        //Calculando salto de linea antes del total
        if (count($value['asignaciones'])>count($value['deducciones'])) 
        {
        $cantidad=count($value['asignaciones']);
        $salto=0;
        $salto=60-($cantidad*5);

        }
        else 
        {
        $cantidad=count($value['deducciones']);
        $salto=0;
        $salto=60-($cantidad*5); 
        }


        $this->Ln($salto);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(45, 5,utf8_decode('TOT. ASIGNAC :'), 0, 0, 'L',true);
        $this->SetFont('Arial', '', 11);
        $this->Cell(40, 5,utf8_decode(number_format($totalasig, 2, ',', '.')), 0, 0, 'L',true);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(62, 5,utf8_decode('TOT. DEDUCC :'), 0, 0, 'L',true);
        $this->SetFont('Arial', '', 11);
        $this->Cell(53, 5,utf8_decode(number_format($totalded, 2, ',', '.')), 0, 0, 'L',true);

        $this->ln(5);


        if ($value['codtipfre']=='01' && substr($value['datosprinc']['codnom'],0,1)!='P' && substr($value['datosprinc']['codnom'],0,1)!='B' && substr($value['datosprinc']['codnom'],0,1)!='H' ) 
        {
        
            $SEMANA1 = number_format($SEMANA1, 2,',', '.');
            $SEMANA4 = number_format($SEMANA4, 2,',', '.');

            $this->SetFont('Arial', 'B', 10);
            $this->Cell(20, 5,utf8_decode('1RA SEM:'), 0, 0, 'L',true);
            $this->SetFont('Arial', '', 10);
            $this->Cell(18, 5,utf8_decode($SEMANA1), 0, 0, 'L',true);

            $this->SetFont('Arial', 'B', 10);
            $this->Cell(20, 5,utf8_decode('2DA SEM:'), 0, 0, 'L',true);
            $this->SetFont('Arial', '', 10);
            $this->Cell(18, 5,utf8_decode($SEMANA1), 0, 0, 'L',true);

            $this->SetFont('Arial', 'B', 10);
            $this->Cell(20, 5,utf8_decode('3RA SEM:'), 0, 0, 'L',true);
            $this->SetFont('Arial', '', 10);
            $this->Cell(18, 5,utf8_decode($SEMANA1), 0, 0, 'L',true);

            $this->SetFont('Arial', 'B', 10);
            $this->Cell(20, 5,utf8_decode('4TA SEM:'), 0, 0, 'L',true);
            $this->SetFont('Arial', '', 10);
            $this->Cell(18, 5,utf8_decode($SEMANA4), 0, 0, 'L',true);


            $this->SetFont('Arial', 'B', 10);
            $this->Cell(32, 5,utf8_decode('NETO A COBRAR:'), 0, 0, 'L',true);
            $this->SetFont('Arial', '', 10);
            $this->Cell(16, 5,utf8_decode(number_format($totalsueldo, 2, ',', '.')), 0, 0, 'L',true);
        }
        else
        {
            $this->Cell(0, 5,utf8_decode('NETO A COBRAR: '.number_format($totalsueldo, 2, ',', '.').''), 0, 1, 'C',true);

        }
            $this->ln(25);


        }

    }

// Pie de página


    function imprimir($anio,$meses,$datoscont) 
    {
        $pdf = new Nominapdf('P', 'mm', 'Letter');
        $pdf->meses=$meses;
        $pdf->anio=$anio;
        $pdf->datoscont=$datoscont;

     //    echo "listo para imprimir 1";

        $pdf->SetMargins(5,10 , 5); 
       // $pdf->SetAutoPageBreak(true,97);
        if ($pdf->meses >= '09' and $pdf->meses <='11') 
        {
            //echo "listo para imprimir 2";
            $pdf->AddPage();
           // echo "listo para imprimir 3";
            $pdf->Cuerpo_semanal();
            //echo "listo para imprimir 4";
        
        }
        else
        {
           // echo "listo para imprimir 2-2";
            $pdf->AddPage();
            //echo "listo para imprimir 3";
            $pdf->Cuerpo_quincenal();
           // echo "listo para imprimir 4";
            
        }
        
        $pdf->Output(); 


        
    }

}

?>
