<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('mc_table.php');

class Constanciapdf extends PDF_MC_Table 
{
    public function __construct()
    {
        parent::__construct();
        
    }


    // Cabecera de página
    function Header() 
    {
        $this->SetY(6);
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(0);
        $this->Cell(160, 5,'FECHA: '.date("d/m/Y"), 0,1,'R');
         $this->Image(FCPATH . 'source/img/wensly_2.jpg', 18, 12, 164);
        $this->Ln(35);
      
    }


    function Cuerpo()
    {
        
        //$this->Image(base_url('source/img/firma_pirona.jpg'),'51','209','50','30','JPG');

        $this->SetY(50);
        
        if (empty($this->datosper)) {
            return; // Handle case with no data
        }
        
        $datosper = $this->datosper[0]; // Get the first record

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

        $this->Ln(7);
        if ($this->tipoper=='01') 
        {
            $this->Cell(60, 7,utf8_decode('   CATEGORÍA:'), 1,0,'L');
        }
        else
        {
            $this->Cell(60, 7,utf8_decode('   CARGO:'), 1,0,'L');
        }

        foreach ($this->cargos as $key => $cargos) 
        {
            if ($cargos[0]=='T.CONV.') 
            {
                $this->Cell(114, 7,utf8_decode('   '.$cargos[2].' '.$cargos[0].' '.$cargos[3].' Horas'), 1,0,'L');
            }
            else
            {
                $this->Cell(114, 7,utf8_decode('   '.$cargos[2].' '.$cargos[0]), 1,0,'L');
            }
        }

        foreach ($this->fechaini as $key => $fechaini) 
        { 
            $this->Ln(7);
            $this->Cell(60, 7,'   FECHA DE INGRESO:', 1,0,'L');
            $this->Cell(114, 7,'   '.$fechaini[0], 1,0,'L');
        }

        if(isset($this->fechaegre) && !empty($this->fechaegre)) 
        {
            foreach ($this->fechaegre as $key => $fechaegre) 
            {
                $this->Ln(7);
                $this->Cell(60, 7,'   FECHA DE EGRESO:', 1,0,'L');
                $this->Cell(114, 7,'   '.$fechaegre[0], 1,0,'L');    
            }
        }


        if($this->sueldo=='01') 
        { 
            //SUELDO INTEGRAL

            $this->Ln(7);

            //si condicion es jubilado o pensionado
            if ($datosper[4]=='07' || $datosper[4]=='08') 
            {
                $homologaciones=0;
                foreach ($this->monto2 as $key => $monto2) 
                {
                    $homologaciones+=$monto2[0];     
                }
            
                foreach ($this->monto as $key => $monto) 
                {       
                    foreach ($this->tf as $key => $tf) 
                    {
                        if ($tf[0]=='03') 
                        {//OBRERO
                            $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                            $this->Cell(114, 7,'   '.number_format($homologaciones+($monto[0]/7*30), 2, ',', '.').' Bs.', 1,0,'L'); 
                        }
                        else
                        {
                            $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                            $this->Cell(114, 7,'   '.number_format($homologaciones+$monto[0], 2, ',', '.').' Bs.', 1,0,'L');
                        }
                    }
                }
                

            }
            else
            {
                $homologaciones=0;
                foreach ($this->monto2 as $key => $monto2) 
                {
                    $homologaciones+=$monto2[0];
                }
                     
                foreach ($this->monto as $key => $monto) 
                {
                    foreach ($this->tf as $key => $tf) 
                    {
                        if ($tf[0]=='03') 
                        { //OBRERO
                            $this->Cell(60, 7,'   SUELDO INTEGRAL:', 1,0,'L');
                            $this->Cell(114, 7,'   '.number_format($homologaciones+($monto[0]/7*30), 2, ',', '.').' Bs.', 1,0,'L'); 
                        }
                        else
                        {

                            if(!empty($this->cuota)) //identifica sui es un pago fracionado
                            {      
                                foreach ($this->cuota as $key => $cuota) 
                                {
                                    $largoc = strlen($cuota[0]);
                                    if ($largoc==4) 
                                    {
                                        $a=substr($cuota[0], 0,2);
                                        $this->Cell(60, 7,'   SUELDO INTEGRAL:', 1,0,'L');
                                        $this->Cell(114, 7,'   '.number_format((($homologaciones+$monto[0])/$a)*30, 2, ',', '.').' Bs.', 1,0,'L');
                                    }
                                    else
                                    {
                                        $a=substr($cuota[0], 0,1);
                                        $this->Cell(60, 7,'   SUELDO INTEGRAL:', 1,0,'L');
                                        $this->Cell(114, 7,'   '.number_format((($homologaciones+$monto[0])/$a)*30, 2, ',', '.').' Bs.', 1,0,'L');
                                    }
                                }
                            }
                            else
                            {
                                $this->Cell(60, 7,'   SUELDO INTEGRAL:', 1,0,'L');
                                $this->Cell(114, 7,'           '.number_format($homologaciones+$monto[0], 2, ',', '.').' Bs.', 1,0,'L');
                            }
                        }
                    }
                }
            }
        }   

        if($this->sueldo=='02') 
        { 
            //SUELDO ANUAL

            $this->Ln(7);
            if ($datosper[4]=='07' || $datosper[4]=='08') 
            {   //jubilado o pensionado
                
                $homologaciones=0;
                foreach ($this->monto2 as $key => $monto2) 
                {
                    $homologaciones+=$monto2[0];     
                }
            
                foreach ($this->monto as $key => $monto) 
                {
                    foreach ($this->tf as $key => $tf) 
                    {
                        if ($tf[0]=='03') 
                        { //OBRERO
                            $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                            $this->Cell(114, 7,'   '.number_format( ( $homologaciones+($monto[0]/7*30) )*12, 2, ',', '.').' Bs.', 1,0,'L'); 
                        }
                        else
                        {
                            $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                            $this->Cell(114, 7,'   '.number_format( ($homologaciones+$monto[0])*12, 2, ',', '.').' Bs.', 1,0,'L');
                        }
                    }
                }
                
            }
            else
            {
                $homologaciones=0;
                foreach ($this->monto2 as $key => $monto2) 
                {
                    $homologaciones+=$monto2[0];     
                }

                foreach ($this->monto as $key => $monto) 
                {
                    foreach ($this->tf as $key => $tf) 
                    {
                        if($tf[0]=='03') 
                        {
                            //OBRERO
                            $this->Cell(60, 7,'   SUELDO ANUAL:', 1,0,'L');
                            $this->Cell(114, 7,'   '.number_format(($homologaciones+($monto[0]/7*30))*12, 2, ',', '.').' Bs.', 1,0,'L'); 
                        }
                        else
                        {

                            if (!empty($this->cuota)) 
                            {
                                foreach ($this->cuota as $key => $cuota) 
                                {
                                    $largoc = strlen($cuota[0]);
                                    if ($largoc==4) 
                                    {
                                        $a=substr($cuota[0], 0,2);
                                        $this->Cell(60, 7,'   SUELDO ANUAL:', 1,0,'L');
                                        $this->Cell(114, 7,'   '.number_format((($homologaciones+$monto[0])/$a)*360, 2, ',', '.').' Bs.', 1,0,'L'); 
                                    }
                                    else
                                    {
                                        $a=substr($cuota[0], 0,1);
                                        $this->Cell(60, 7,'   SUELDO ANUAL:', 1,0,'L');
                                        $this->Cell(114, 7,'   '.number_format((($homologaciones+$monto[0])/$a)*360, 2, ',', '.').' Bs.', 1,0,'L');
                                    }
                                }

                            }
                            else
                            {
                                $this->Cell(60, 7,'   SUELDO ANUAL:', 1,0,'L');
                                $this->Cell(114, 7,'   '.number_format(($homologaciones+$monto[0])*12, 2, ',', '.').' Bs.', 1,0,'L'); 
                            }
                        }
                    }
                }
                
            } 
        }

        if ($this->sueldo=='03') 
        { 
            //SUELDO BASICO

            $this->Ln(7);
            if($datosper[4]=='07' || $datosper[4]=='08') 
            {
                //jubilado o pensionado

                $homologaciones=0;
		        foreach ($this->monto3 as $key => $monto3) 
                {
                    $homologaciones+=$monto3[0];  
                }
            
                foreach ($this->sub as $key => $sub) 
                {
                    foreach ($this->tf as $key => $tf) 
                    {//OBRERO
                        if ($tf[0]=='03') 
                        {
                            $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                            $this->Cell(114, 7,'   '.number_format( $homologaciones+($sub[0]/7*30), 2, ',', '.').' Bs', 1,0,'L');

                        }
                        else
                        {
                            $this->Cell(60, 7,utf8_decode('   PENSIÓN:'), 1,0,'L');
                            $this->Cell(114, 7,'   '.number_format($homologaciones+$sub[0], 2, ',', '.').' Bs', 1,0,'L'); 
                        }
    		        }
                }
                

            }
            else
            {
		        foreach ($this->monto3 as $key => $monto3) 
                {
                    $homologaciones=0;
                    $homologaciones+=$monto3[0]; 
                    foreach ($this->sub as $key => $sub) 
                    {
                        foreach ($this->tf as $key => $tf) 
                        {
                        if ($tf[0]=='03') {//OBRERO
                            $this->Cell(60, 7,utf8_decode('   SUELDO BÁSICO:'), 1,0,'L');
                            $this->Cell(114, 7,'   '.number_format($homologaciones+($sub[0]/7*30), 2, ',', '.').' Bs', 1,0,'L');
                        }
                        else
                        {

                            if (!empty($this->cuota)) 
                            {
                                foreach ($this->cuota as $key => $cuota) 
                                {
                                    $largoc = strlen($cuota[0]);
                                    if ($largoc==4) 
                                    {
                                        $a=substr($cuota[0], 0,2);
                                        $this->Cell(60, 7,utf8_decode('   SUELDO BÁSICO:'), 1,0,'L');
                                        $this->Cell(114, 7,'   '.number_format((($homologaciones+$sub[0])/$a)*30, 2, ',', '.').' Bs.', 1,0,'L');
                                    }
                                    else
                                    {
                                        $a=substr($cuota[0], 0,1);
                                        $this->Cell(60, 7,utf8_decode('   SUELDO BÁSICO:'), 1,0,'L');
                                        $this->Cell(114, 7,'   '.number_format((($homologaciones+$sub[0])/$a)*30, 2, ',', '.').' Bs.', 1,0,'L');
                                    }
                                }
                            }
                            else
                            { 
                                $this->Cell(60, 7,utf8_decode('   SUELDO BÁSICO:'), 1,0,'L');
                                $this->Cell(114, 7,'   '.number_format($homologaciones+$sub[0], 2, ',', '.').' Bs', 1,0,'L');
                            }
                        }
                        } 
                    }
		        }
            }
        }

        //si su condicion es contratado o suplente
        if ($datosper[4]=='01' || $datosper[4]=='09' || $datosper[4]=='05')   
        {
            $this->SetFont('Helvetica', '', 10);
            if ($this->tipoper=='01') 
            {

                $this->Ln(7);
                $this->Cell(54, 7,utf8_decode('LAPSO DE CONTRATACIÓN:'), 1,0,'L',true);
                $this->Cell(60, 7,utf8_decode('CONDICIÓN:'), 1,0,'L',true);
                $this->Cell(60, 7,'DEPENDENCIA:', 1,0,'L',true);
                $this->Ln(7);

                foreach ($this->fechacon as $key => $fechacon) 
                {
                        $this->SetFont('Helvetica', '', 8);
                        $this->SetWidths(array(54,60,60));
                        $this->SetAligns(array('L','L','L'));
                        $this->Row(array(utf8_decode('Desde: '.$fechacon[0].' Hasta: '.$fechacon[1]),utf8_decode($datosper[5]),utf8_decode($fechacon[4])));
                        //$this->Ln(5);
                }
        
            }
            else
            {
            
                $this->Ln(7);
                $this->Cell(60, 7,utf8_decode('DEPENDENCIA:'), 1,0,'L',true);
                $this->Cell(114, 7,utf8_decode('LAPSO DE CONTRATACIÓN:'), 1,0,'L',true);
                $this->Ln(7);

                foreach ($this->fechacon as $key => $fechacon) 
                {
                        $this->SetFont('Helvetica', '', 8);
                        $this->SetWidths(array(60,114));
                        $this->SetAligns(array('L','L'));
                        $this->Row(array(utf8_decode($fechacon[4]),utf8_decode('Desde: '.$fechacon[0].' Hasta: '.$fechacon[1])));

                        //$this->Ln(5);
    
                } 
            }

        }
        else
        {
            $this->Ln(8);
        }

        if($this->ces=='02') 
        {
            $this->Ln(3);
            $this->SetFont('Arial', '', 8);
            $this->MultiCell(0, 5,utf8_decode('Nota Observatoria: Percibe el beneficio de Cesta de Alimentación vigente en el País.'), 0,'J');
        }
    
        $this->Ln(4);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 5,utf8_decode('    Constancia que se expide a petición de la parte interesada, en Santa Ana de Coro a los '.date("d").' días del mes de '.$this->mes.' de '.date("Y")), 0,'J');
        
        // $this->ln(15);
        // $this->Cell(61, 7,'', 0,0,'L');
        // $this->Cell(20,30,$this->Image(base_url('source/img/firma_pirona.jpg'), $this->GetX(), $this->GetY(),51),0);
        // $this->ln(31);

        // $this->Cell(55, 5,'', 0,0,'L');
        // $this->Cell(121, 5,'Lcda. Adriana Boscarino Berto                       Certificado', 0,0,'L');
        // $this->ln(5);
        // $this->Cell(52, 5,'', 0,0,'L');
        // $this->Cell(121, 5,'Director(a) de Recursos Humanos', 0,0,'L');

        
    }
    
    

    
    
    // Pie de página
    function Footer() 
    {
        $this->SetY(-95);
        $this->SetFont('Arial', '', 12);
        $this->Cell(61, 7,'', 0,0,'L');
        $this->Cell(20,30,$this->Image(FCPATH . 'source/img/Natali.png', $this->GetX(), $this->GetY(),51),0);
        $this->ln(31);

        $this->Cell(58, 5,'', 0,0,'L');
        $this->Cell(121, 5,'Dra. Natali Galicia                                  Certificado', 0,0,'L');
        $this->ln(5);
        $this->Cell(45, 5,'', 0,0,'L');
        $this->Cell(150, 5,'Directora de Recursos Humanos', 0,0,'L');
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->ln(22);
        $this->MultiCell(0, 5,utf8_decode('Nota: Constancia válida por 3 meses, debe poseer sello húmedo de la Dirección Recursos Humanos Correo:registroycontrol@correo.unefm.edu.ve'), 0,'J');
        $this->Image(FCPATH . 'source/img/wensly_1.jpg', 19, 271, 172);

    }

    function imprimir($tipoper,$datosper, $cargos, $fechaini,$fechaegre,$sueldo,$ces,$fechacon,$monto,$cuota,$tf,$sub,$monto2,$monto3) 
    {
        $pdf = new Constanciapdf('P', 'mm', 'Letter');
        $pdf->tipoper=$tipoper;
        $pdf->sueldo=$sueldo; //tipo de sueldo
        $pdf->ces=$ces;
        $pdf->datosper=$datosper;
        $pdf->fechaegre=$fechaegre;
        $pdf->cargos=$cargos;
        $pdf->fechaini=$fechaini;
        $pdf->fechacon=$fechacon;
        $pdf->monto=$monto; //sueldo integral
        $pdf->sub=$sub; //sueldo basico

        $pdf->monto2=$monto2; //sueldo integral nominas paralelas
        $pdf->monto3=$monto3; //sueldo basico nominas paralelas

        $pdf->cuota=$cuota;
        
        $pdf->tf=$tf; //tipo de frecuencia ( 01-QUINCENAL 02-MENSUAL 03-SEMANAL)
        
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
        $pdf->SetAutoPageBreak(true,97);
        $pdf->AddPage();
        $pdf->Cuerpo();
        
        $pdf->Output();

    }
    
}

?>
