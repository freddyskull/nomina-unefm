<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('fpdf.php');
class Planestudio2 extends FPDF {

	var $titulo;
	var $numeroplan;
	public function __construct()
	{
		parent::__construct();
		
	}
	function Header()
	{
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
        $this->Cell(0, 5, $this->titulo, 0, 1, 'C');
        $this->Cell(0, 5, 'Plan de Estudio #: '.$this->numeroplan, 0, 1, 'C');
        // Salto de línea
        $this->Ln(6);
	}

// Pie de página
	function Footer()
	{
    // Posición: a 1,5 cm del final
		$this->SetY(-15);
    // Arial italic 8
		$this->SetFont('Arial','I',8);
    // Número de página
    $this->Ln();
		$this->Cell(0,10,'Plan de Estudio',0,0,'C');
		$this->Image(base_url('source/img/13x.png'), 3, 262, 200);
	}

	// Una tabla más completa
	function tabla($header, $data)
	{
    // Anchuras de las columnas
		$w = array(25, 90,8, 7, 7,25,7,20);
    // Cabeceras
    $this->SetFont('Arial','B',8);
    $this->SetFillColor(190);
    $fill=false;
    // Salto de línea
		$this->Ln(3);
		for($i=0;$i<count($header);$i++){
			if($i==0)
			$this->Cell($w[$i],8,$header[$i],1,0,'C',$fill);
			else{
				$fill=true;
				$this->Cell($w[$i],8,$header[$i],1,0,'C',$fill);
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
			if(strcasecmp($aux, $row[0])!=0){
				$this->SetFont('Arial','B',8);
				$cont=0;
				$this->Cell($w[0],4,utf8_decode($row[0]),'LRT',0,'C');
			}else{
				$cont++;
				$this->Cell($w[0],4," ",'LR');
			}
			if($cont==0){
				$this->Cell($w[1],1,"",1,0,'C',$fill);
				$this->Cell($w[2],1,"",1,0,'C',$fill);
				$this->Cell($w[3],1,"",1,0,'C',$fill);
				$this->Cell($w[4],1,"",1,0,'C',$fill);
				$this->Cell($w[5],1,"",1,0,'C',$fill);
				$this->Cell($w[6],1,"",1,0,'C',$fill);
				$this->Cell($w[7],1,"",1,0,'C',$fill);

				$this->Ln();
				$this->Cell($w[0],4," ",'LR');
			}
			
			if(strlen($row[1])<40){
				$this->SetFont('Arial','',8);
				$this->Cell($w[1],4,utf8_decode($row[1]),1,0,'C');
				$this->Cell($w[2],4,utf8_decode($row[6]),1,0,'C');
				$this->Cell($w[3],4,utf8_decode($row[2]),1,0,'C');
				$this->Cell($w[4],4,utf8_decode($row[3]),1,0,'C');
				$this->Cell($w[5],4,utf8_decode($row[4]),1,0,'C');
				$this->Cell($w[6],4,utf8_decode($row[5]),1,0,'C');
				$this->Cell($w[7],4,utf8_decode($row[7]),1,0,'C');
				$this->Ln();
				$aux=$row[0];
			}else{
				$this->SetFont('Arial','',8);
				$a=$this->character_limiter($row[1],40);
				if(is_array($a)){
					$this->Cell($w[1],4,utf8_decode($a[0]),'LRT',0,'C');
					$this->Cell($w[2],4,utf8_decode($row[6]),'LRT',0,'C');
					$this->Cell($w[3],4,utf8_decode($row[2]),'LRT',0,'C');
					$this->Cell($w[4],4,utf8_decode($row[3]),'LRT',0,'C');
					$this->Cell($w[5],4,utf8_decode($row[4]),'LRT',0,'C');
					$this->Cell($w[6],4,utf8_decode($row[5]),'LRT',0,'C');
					$this->Cell($w[7],4,utf8_decode($row[7]),'LRT',0,'C');

					$this->Ln();
					$this->Cell($w[0],4," ",'LR');
					$this->Cell($w[1],4,utf8_decode($a[1]),'LR',0,'C');
					$this->Cell($w[2],4,'','LR',0,'C');
					$this->Cell($w[3],4,'','LR',0,'C');
					$this->Cell($w[4],4,'','LR',0,'C');
					$this->Cell($w[5],4,'','LR',0,'C');
					$this->Cell($w[6],4,'','LR',0,'C');
					$this->Cell($w[7],4,'','LR',0,'C');
					
					$this->Ln();
				}else{
					$this->Cell($w[1],4,utf8_decode(trim($a)),'LRT',0,'C');
					$this->Cell($w[2],4,utf8_decode($row[6]),'LRT',0,'C');
					$this->Cell($w[3],4,utf8_decode($row[2]),'LRT',0,'C');
					$this->Cell($w[4],4,utf8_decode($row[3]),'LRT',0,'C');
					$this->Cell($w[5],4,utf8_decode($row[4]),'LRT',0,'C');
					$this->Cell($w[6],4,utf8_decode($row[5]),'LRT',0,'C');
					$this->Cell($w[7],4,utf8_decode($row[7]),'LRT',0,'C');

					$this->Ln();
				}
			}
			
			$horasTotales+=number_format($row[4]);
			$ucTotales+=number_format($row[5]);

			$cont=0;
		}

    // Línea de cierre
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln();
		$this->Cell(array_sum($w)-80,6," ",'');
		$this->SetFont('Arial','B',8);
		$this->Cell(40,6,'Horas Totales',1,0,'C');
		$this->Cell(40,6,'Unidades Credito Totales',1,0,'C');
		$this->Ln();
		$this->SetFont('Arial','',8);
		$this->Cell(array_sum($w)-80,6," ",'');
		$this->Cell(40,6,$horasTotales,1,0,'C');
		$this->Cell(40,6,$ucTotales,1,0,'C');
	}

	public function imprimir($nombre,$planEstudio,$numeroplan){
		// Creación del objeto de la clase heredada

		$pdf = new Planestudio2();
		$pdf->numeroplan=$numeroplan;
		$pdf->titulo=utf8_decode($nombre);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$cabezera=array('PERIODO','UNIDAD CURRICULAR','ID','H.P','H.T','HORAS TOTALES','U.C','Prelacion');
		
		
		$pdf->tabla($cabezera,$planEstudio);
		$pdf->SetFont('Times','',12);
		// echo json_encode(site_url().'source/pdf/doc.pdf');
		// $doc = rand(1, 9999);
		$doc = 'doc';
		$path = '/source/tmp/planestudio-'.$doc.'.pdf';
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