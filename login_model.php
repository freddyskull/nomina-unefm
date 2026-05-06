<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model 
{

	public function __construct()
	{
		parent::__construct();
		$this->default = $this->load->database('default', TRUE);
    $this->PERSONAL= $this->load->database('PERSONAL', TRUE);

	}



	
	//Funcion que verifica los datos del usuario y si son correctos envia sus datos a la variable session
	public function login($usuario,$clave)
	{

		$sql =" select a.NOMEMP, b.tipoper, b.pregunta2, b.respuesta2, a.cedemp, a.apeemp,a.sexoemp from NOMINA.consusr b, PERSONAL.empleados a  ";
 		$sql.=" WHERE b.cedemp = a.cedemp  ";
		$sql.=" and b.cedemp != '24562144' and b.cedemp != '9805405' and b.cedemp != '10613014' and b.cedemp != '22134021' and b.cedemp != '15556767'  ";
		$sql.=" and b.cedemp != '17350925' and b.cedemp != '18481918' and b.cedemp != '21546001' and b.cedemp != '13204059'  ";
		$sql.=" and b.cedemp != '23680241' and b.cedemp != '12460206' and b.cedemp != '19824170' ";
		$sql.=" and b.cedemp != '14042858' and b.cedemp != '25370864'	 ";	
		$sql.=" and b.USUARIO=? and b.CLAVE=? ";
		$query=$this->db->query($sql,array($usuario,$clave));
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $row) 
			{
				$a1=$row->NOMEMP;
				$a2=$row->TIPOPER;
				$a3=$row->CEDEMP;
				$a4=$row->APEEMP;
				$a5=$row->SEXOEMP;
				$a6=$row->PREGUNTA2;
				$a7=$row->RESPUESTA2;

				$datos=array(
					'nombre' => $a1,
					'tipoper' => $a2,
					'cedula'=> $a3,
					'apellido'=> $a4,
					'sexo'=> $a5,
					'pregunta2'=> $a6,
					'respuesta2'=> $a7,
					'logueado' => TRUE
	
				);
				$this->session->set_userdata($datos);
			}


			$q="select a.codtipnom, a.codnom ";
			$q.=" FROM  nomina.situaempnom a, nomina.NOMINA b ";
			$q.=" WHERE a.cedemp=?   ";
			$q.=" AND a.codtipnom=b.codtipnom   ";
			$q.=" and a.codnom=b.codnom  ";
			$q.=" and a.codnom NOT LIKE 'B%'  ";
			$q.=" AND a.codnom NOT LIKE 'I%' ";
			$q.=" AND a.codnom NOT LIKE 'H%' ";
			$q.=" AND a.codnom NOT LIKE 'P%' ";
			$q.=" and a.codtipnom not in ('23','24','25','26','27','28','29') and b.situacion='0' ";
			$q.=" and a.codnom in (select codnom from NOMINA.detallenom  where cedemp=? and codcon in ('001','002','026','029','042','043') ) ";
			$q.=" and b.codtipnom in ( select codtipnom from nomina.TIPONOMINA where codtipper=?) ";
			$q.=" ORDER BY b.fechaini"; 

			//echo $q."<br>";
			//echo $this->session->userdata('cedula')." ".$this->session->userdata('cedula')." ".$this->session->userdata('tipoper')."<br>";


			$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('cedula'),$this->session->userdata('tipoper')));
			if ($query->num_rows()>0)
			{
				foreach ($query->result() as $row) 
				{
					$b1=$row->CODTIPNOM;
					$b2=$row->CODNOM;
					$datos=array(
						'codtipnom' => $b1,
						'codnom' => $b2,
					);

				}
				$this->session->set_userdata($datos);
			}


			if($this->session->userdata('tipoper')=='02' || $this->session->userdata('tipoper')=='03') 
			{

			  $q=" select C.codmacar FROM  NOMINA.SITUAEMPNOM A, PERSONAL.MANUCARGO C ";
				$q.=" WHERE  A.CODNOM='-'  ";
				$q.=" AND A.CEDEMP=?  ";
				$q.=" AND A.CARGCAT=C.CODMACAR  ";
				$q.=" and a.codtipnom in ( select codtipnom from nomina.TIPONOMINA where codtipper=?) ";

				$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
				if ($query->num_rows()>0)
				{
					foreach ($query->result() as $row) 
					{
						$c1=$row->CODMACAR;
						$datos=array(
							'codmacar' => $c1,
						);

					}
					$this->session->set_userdata($datos);
				}
			}

			if ($this->session->userdata('tipoper')=='01') 
			{
				$q="select A.CODDED, A.NUMHORA, C.CODCAT ";
				$q.=" FROM PERSONAL.DEDICACION b, NOMINA.SITUAEMPNOM A, PERSONAL.CATEGORIA C  ";
				$q.=" WHERE A.CODNOM='-' and a.CODDED=b.CODDED AND  A.CEDEMP=? AND  A.CARGCAT=C.CODCAT and a.codtipnom  ";
				$q.=" in ( select codtipnom from nomina.TIPONOMINA where codtipper=? ) ";

				$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
				if ($query->num_rows()>0)
				{
					foreach ($query->result() as $row) 
					{
						$d1=$row->CODDED;
						$d2=$row->NUMHORA;
						$d3=$row->CODCAT;
						$datos=array(
							'codded' => $d1,
							'hora' => $d2,
							'codcat' => $d3,
						);

					}
					$this->session->set_userdata($datos);
				}
			}
			else 
			{
				$q=" select A.CODDED ";
				$q.=" FROM PERSONAL.DEDICACION b, NOMINA.SITUAEMPNOM A, PERSONAL.MANUCARGO C ";
				$q.=" WHERE  A.CODNOM='-' and a.CODDED=b.CODDED AND A.CEDEMP=? AND A.CARGCAT=C.CODMACAR and a.codtipnom  ";
				$q.=" in ( select codtipnom from nomina.TIPONOMINA where codtipper=?) ";

				$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
				if ($query->num_rows()>0)
				{
					foreach ($query->result() as $row) 
					{
						$d1=$row->CODDED;
						$datos=array(
							'codded' => $d1,
						);

					}
					$this->session->set_userdata($datos);
				}
			}	


			return($a2);
		
		}
		else
		{
			$this->session->set_flashdata('mensaje','La combinación de nombre de Usuario/Clave<br> no es válida. Vuelve a intentarlo');
			redirect('blog');
		}
	}

	

	//funcion para obtener todos los contratos
	public function empleados()
	{


		$q="select a.cedemp, a.nomemp, a.apeemp, a.diremp, a.TELEMP, b.correo, a.FECNACEMP, a.LUGNACEMP, a.PAISNACEMP, a.RIF from PERSONAL.empleados a, NOMINA.consusr b where b.cedemp = a.cedemp and a.cedemp=? and a.TIPOPER=?";
		$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux[]=$row->CEDEMP;
				$aux[]=$row->NOMEMP;
				$aux[]=$row->APEEMP;
				$aux[]=$row->DIREMP;
				$aux[]=$row->TELEMP;
				$aux[]=$row->CORREO;
				$aux[]=$row->FECNACEMP;
				$aux[]=$row->LUGNACEMP;
				$aux[]=$row->PAISNACEMP;
				$aux[]=$row->RIF;
				$empleado[]=$aux;

			}
			return($empleado);
		}
	}


	public function datospersonal()
	{
		
		$q="select e.destipper,a.tipoper,a.cedemp,a.nomemp,a.apeemp,a.diremp,b.cond, b.codtipnom ,d.descond FROM personal.tipoper e,personal.empleados a, nomina.situaempnom b, nomina.tiponomina c,PERSONAL.condicionper d  WHERE a.cedemp=? and a.cedemp=b.cedemp and b.codnom='-' and b.codtipnom=c.codtipnom and c.codtipper=a.tipoper and c.codtipper=e.CODTIPPER and b.cond=d.codcond and c.codtipper=? ";
		$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux[]=$row->CEDEMP;
				$aux[]=$row->NOMEMP;
				$aux[]=$row->APEEMP;
				$aux[]=$row->DIREMP;
				$aux[]=$row->COND;
				$aux[]=$row->DESCOND;
				$aux[]=$row->DESTIPPER;
				$datosper[]=$aux;
			}
			return($datosper);
		}
	}

	public function cargafamiliar()
	{
		$q="select cedproffam,cedfam,nomfam,apefam,sexofam,fecfam,parenfam,vivefam from PERSONAL.cargafamiliar where cedproffam=? order by fecfam";

		$query= $this->db->query($q, array($this->session->userdata('cedula')) );
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $row) 
			{
			//	var_dump($row);
				$aux=array();
				$aux[]=$row->CEDPROFFAM;
				$aux[]=$row->CEDFAM;
				$aux[]=$row->NOMFAM;
				$aux[]=$row->APEFAM;
				$aux[]=$row->SEXOFAM;
				$aux[]=$row->FECFAM;
				$aux[]=$row->PARENFAM;
				$aux[]=$row->VIVEFAM;
				$datosper[]=$aux;
			}
			return($datosper);
			
		}
	}


	public function cargo()
	{
				if ($this->session->userdata('tipoper')=='01') 
				{

					$q="select b.DESDED, A.NUMHORA, A.CARGCAT,C.DESCAT, A.CODDED FROM PERSONAL.DEDICACION b, NOMINA.SITUAEMPNOM A, PERSONAL.CATEGORIA C WHERE A.CODNOM='-' and a.CODDED=b.CODDED AND  A.CEDEMP=? AND  A.CARGCAT=C.CODCAT and a.codtipnom in ( select codtipnom from nomina.TIPONOMINA where codtipper=? )";
					$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
					if ($query->num_rows()>0){
						foreach ($query->result() as $row) {

							$aux=array();
							$aux[]=$row->DESDED;
							$aux[]=$row->CODDED;
							$aux[]=$row->DESCAT;
							$aux[]=$row->NUMHORA;
							$cargos[]=$aux;
						}
						return($cargos);
					}
				}
				else
				{

						$q="select A.NUMHORA, b.DESDED, A.CODDED, A.CARGCAT,C.DESCORTAMA FROM PERSONAL.DEDICACION b, NOMINA.SITUAEMPNOM A, PERSONAL.MANUCARGO C WHERE  A.CODNOM='-' and a.CODDED=b.CODDED AND A.CEDEMP=? AND A.CARGCAT=C.CODMACAR and a.codtipnom in ( select codtipnom from nomina.TIPONOMINA where codtipper=?)";
						$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
						if ($query->num_rows()>0)
						{
							foreach ($query->result() as $row) 
							{

								$aux=array();
								$aux[]=$row->DESDED;
								$aux[]=$row->CODDED;
								$aux[]=$row->DESCORTAMA;
								$aux[]=$row->NUMHORA;
								$cargos[]=$aux;
							}
							return($cargos);
						}

			}

	}

	public function fechaini()
	{

		$q="select * FROM (SELECT TO_CHAR(fecautpro,'dd/mm/yyyy') as FECHAI ";
		$q.="FROM personal.movimiento WHERE cedempmov=? AND codtipper=? AND codtipmov='01'  order by fecautpro asc) WHERE  rownum <= 1";//
		$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $row) 
			{

				$aux=array();
				$aux[]=$row->FECHAI;
				$fechaini[]=$aux;
			}
			
			return($fechaini);
		}
		else
		{

			$q="select * from (SELECT TO_CHAR(fecha,'dd/mm/yyyy') as FECHAI FROM nomina.sueldoprestacion  ";
	 		$q.=" WHERE tipoper=? AND cedemp=? ORDER BY fecha) where ROWNUM <= 1  ";

			$query= $this->db->query($q,array($this->session->userdata('tipoper'),$this->session->userdata('cedula')));
			if($query->num_rows()>0)
			{
				foreach ($query->result() as $row) 
				{

					$aux=array();
					$aux[]=$row->FECHAI;
					$fechaini[]=$aux;
				}
				return($fechaini);
			}
			else
			{

				$q=" select * from(SELECT to_char(fecautpro, 'dd/mm/yyyy') as FECHAI from personal.movimiento where cedempmov=?  ";
				$q.=" and codtipper=? and (codcond='01' or codcond='09' or codcond='05')  "; //CONTRATADO PREST SERV; CONTRATADO SERVICIOS PROFESIONALES;SUPLENTE
				$q.=" and (codtipmov ='02' or codtipmov ='03' or codtipmov ='21'  or codtipmov ='24') order by fecautpro) where ROWNUM <= 1 ";//CONTRATO;RENOVACION DE CONTRATO;CONTRATO PRESTACION SERV; CONTRATO SERVICIOS PROFE

				$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
				if ($query->num_rows()>0)
				{
					foreach ($query->result() as $row) 
					{

						$aux=array();
						$aux[]=$row->FECHAI;
						$fechaini[]=$aux;
					}
					return($fechaini);
				}
			}
		}
	}

	
	public function fechaegre()
	{

		$q="select TO_CHAR(fecautpro,'dd/mm/yyyy') as FECHAE FROM personal.movimiento WHERE cedempmov=?  AND codtipper=? AND (codtipmov='04' OR codtipmov='05' OR codtipmov='09' OR codtipmov='15' OR codtipmov='18') order by fecautpro ";
		$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux[]=$row->FECHAE;
				$fechaegre[]=$aux;
			}
			return($fechaegre);
		}
	}



	public function fechacon() //retorna los contratos del empleado
	{

			$q ="select b.DESDEP, to_char(a.fecautpro,'dd/mm/yyyy') as fechaci, to_char(a.fecautdef,'dd/mm/yyyy') as fechacf, a.coddepmov, a.codcond "; 
			$q.=" FROM personal.movimiento a, PERSONAL.DEPENDENCIA b ";
			$q.=" WHERE b.CODDEP=a.CODDEPMOV ";
			$q.=" and a.cedempmov =?  AND a.codtipper=? AND a.codtipmov in ('02','21','22','23','24','03') ORDER BY a.fecautpro ";
			
			$query= $this->db->query( $q,array($this->session->userdata('cedula'), $this->session->userdata('tipoper')) );
			if ($query->num_rows()>0)
			{
				foreach ($query->result() as $row) 
				{

					$aux=array();
					$aux[]=$row->FECHACI;
					$aux[]=$row->FECHACF;
					$aux[]=$row->CODDEPMOV;
					$aux[]=$row->CODCOND;
					$aux[]=$row->DESDEP;
					$fechacon[]=$aux;
				}
				return($fechacon);
			}
	}

	public function meses(){

		$q="select mes,dmes,ano from nomina.const_m_a order by ano desc, mes desc";
		$query= $this->db->query($q,array($this->session->userdata('tipoper')));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux[]=$row->DMES;
				$aux[]=$row->MES;
				$aux[]=$row->ANO;
				$meses[]=$aux;
			}
			return($meses);
		}
	}

	public function sueldobasico()
	{

			$q= " select sum(monto)as monto from nomina.detallenom a, nomina.conceptos b ";
			$q.="	where a.codtipnom=? and a.codnom=? and a.codcon=b.codcon and b.codtipcon='1' ";
	    $q.="	and a.cedemp=? and a.codcon in ('001','002','026','029','042','043') ";
			$query= $this->db->query($q,array($this->session->userdata('codtipnom'),$this->session->userdata('codnom'),$this->session->userdata('cedula')));
			if ($query->num_rows()>0)
			{
				foreach ($query->result() as $row) 
				{
					$aux=array();
					$aux[]=$row->MONTO;
					$sub[]=$aux;
				}
				return($sub);
			}
		
	}

	public function sueldointegral()
	{

		$q="select sum(monto) as monto from nomina.detallenom a, nomina.conceptos b where a.codtipnom=? and a.codnom=? and a.codcon=b.codcon and b.codtipcon='1' and a.cedemp=? and a.codcon in (select codcon1 from nomina.conceptocon where codcon='494')";
		$query= $this->db->query($q,array($this->session->userdata('codtipnom'),$this->session->userdata('codnom'),$this->session->userdata('cedula')));

		//echo $q."<br>";
		//echo $this->session->userdata('codtipnom')." ".$this->session->userdata('codnom')." ".$this->session->userdata('cedula')."<br>";

		if($query->num_rows()>0)
		{
			foreach ($query->result() as $row) 
			{

				$aux=array();
				$aux[]=$row->MONTO;
				$monto[]=$aux;
			}
			return($monto);
		}
	}

	public function cuota()
	{

			$q= " select a.cuota from nomina.detallenom a, nomina.conceptos b ";
			$q.=" where a.codtipnom=? and a.codnom=? and a.codcon=b.codcon and b.codtipcon='1' and a.cedemp=? and a.codcon='001' and a.cuota IS NOT NULL";
			$query= $this->db->query($q,array($this->session->userdata('codtipnom'),$this->session->userdata('codnom'),$this->session->userdata('cedula')));

			if ($query->num_rows()>0)
			{
				foreach ($query->result() as $row) 
				{

					$aux=array();
					$aux[]=$row->CUOTA;
					$cuota[]=$aux;
				}

				return($cuota);
			}

	}

public function codnomh() //retorna las nominas paralelas que tengan como base la principal
{
			$and='';
			if ($this->session->userdata('codtipnom')=='04') 
			{
				$and="AND codnom != 'H1106'";
			}

			$q="  select DISTINCT(codnom) FROM nomina.detnombase "; 
			$q.=" WHERE codtipnom=?  "; 
			$q.=" AND codnomb=? "; 
			$q.=" AND codnom LIKE 'H%' "; 
			$q.=" and concat(codtipnom,codnom) in (select concat(codtipnom,codnom) from nomina.nomina where situacion='0') ".$and;

			$query= $this->db->query($q,array($this->session->userdata('codtipnom'),$this->session->userdata('codnom')));

			if ($query->num_rows()>0)
			{
				foreach ($query->result() as $row) 
				{
					$aux=array();
					$aux[]=$row->CODNOM;
					$codnomh[]=$aux;
				}
			}
			else
			{
				$codnomh[]=' ';
			}
			
			return($codnomh);



}
	
	public function sueldoh($codnomh) //retorna arreglo con sueldo entegral de las nominas paralelas
	{

		foreach ($codnomh as $key => $codnomh) 
		{
				$codh=$codnomh[0];

				$q= " select sum(monto) as monto ";
				$q.=" from nomina.detallenom a, nomina.conceptos b ";
				$q.=" where a.codtipnom=? ";
				$q.=" and a.codnom=? ";
				$q.=" and a.cedemp=? ";
				$q.=" and a.codcon=b.codcon ";
				$q.=" and b.codtipcon='1' ";
				$q.=" and a.codcon in (select codcon1 from nomina.conceptocon where codcon='494')";
				$query= $this->db->query($q,array($this->session->userdata('codtipnom'),$codh,$this->session->userdata('cedula')));
				if ($query->num_rows()>0)
				{
					foreach ($query->result() as $row) 
					{

						$aux=array();
						$aux[]=$row->MONTO;
						$monto2[]=$aux;
					}
				}
				else
				{
					$monto2[]=' ';
				}
		}
		
			return($monto2);

	}

	public function sueldohb($codnomh) //retorna arreglo con sueldo basico de las nominas paralelas
	{

			foreach ($codnomh as $key => $codnomh) 
			{
				$codh=$codnomh[0];

				$q="  select sum(monto)as monto from nomina.detallenom a, nomina.conceptos b ";
				$q.=" where a.codtipnom=? and a.codnom=? and a.codcon=b.codcon and b.codtipcon='1' and a.cedemp=? and a.codcon in ('001','002','026','029','042','043') ";
				$query= $this->db->query($q,array($this->session->userdata('codtipnom'),$codh,$this->session->userdata('cedula')));
				if ($query->num_rows()>0)
				{
					foreach ($query->result() as $row) 
					{

						$aux=array();
						$aux[]=$row->MONTO;
						$monto3[]=$aux;
					}
				}
				else
				{
					$monto3[]=' ';
				}
			
			}
			return($monto3);

	}


	public function tf() //retorna el tipo de frecuencia de la nomina ( 01-QUINCENAL 02-MENSUAL 03-SEMANAL)
	{ 

		$q="select codtipfre from NOMINA.tiponomina where codtipnom =? ";
		$query= $this->db->query($q,array($this->session->userdata('codtipnom')));
		if ($query->num_rows()>0)
		{
			foreach ($query->result() as $row) 
			{

				$aux=array();
				$aux[]=$row->CODTIPFRE;
				$tf[]=$aux;
			}
			return($tf);
		}
	}

	
 //////////////////////////////////////////////////////////////
////////////////VARIABLES PARA EL PDF DE NOMINA///////////////
//////////////////////////////////////////////////////////////

	//busca el año///
	public function anio($meses)
	{

		$q="select ano from nomina.const_m_a where mes=".$meses;
		$query= $this->db->query($q,array($this->session->userdata('codtipnom')));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux[]=$row->ANO;
				$anio[]=$aux;
			}
			return($anio);
		}
	}


	//Busca los datos personales
	public function datosprinc($meses,$anio)
	{
		foreach ($anio as $key => $anio) 
		{

		$q="select a.cedemp, b.apeemp, b.nomemp, b.coddep, a.cargcat, a.codded,  a.codnom, to_char(c.fechaini,'mm/yyyy') as FECHAINI, a.codtipnom ";
		$q.=" from nomina.situaempnom a, personal.empleados b, nomina.nomina c ";
		$q.=" where  a.cedemp=? ";
		$q.=" and b.tipoper=?  ";
		$q.=" and a.codnom!='-'  ";
		$q.=" and a.codnom=c.codnom   ";
		$q.=" and a.codtipnom=c.codtipnom  ";
		$q.=" and c.situacion='0'  ";
  	$q.=" and a.codtipnom in (select codtipnom from NOMINA.tiponomina where codtipper=? ) ";
		$q.=" and to_char(c.fechaini,'mm')>=".$meses."  ";
		$q.=" and to_char(c.fechaini,'mm')<=".$meses."  ";
		$q.=" and to_char(c.fechaini,'yyyy')=".$anio[0]."  ";
		$q.=" and a.cedemp=b.cedemp  ";
		
		// esto es para que no salgan estas nominsa
		$q.="  and concat(a.codtipnom,a.codnom) not in ( ";

		$q.=" '05P1103','07P1262','05P1102','07P1263','07P1264','12P0416','05P1107','05P1108','07P1268','07P1269','07P1270','34P047','02P2044','02P2045','02P2046','04P1628','04P1629','01P1634','01P1635','01P1636', ";
		$q.=" '10P1730','10P1731','30P0161','30P0162', ";

		$q.=" '01P1645','01P1646','01P1650','01P1651','01P1652','01P1653','10P1754','10P1755','10P1761','10P1762','27P0121','30P0186','30P0188','02P2056','02P2058','02P2059','02P2062','02P2063','02P2064','02P2066','04P1640','04P1643','04P1644','04P1645','28P0119','32P092','05P1116','05P1120','05P1121','05P1122','05P1125','07P1277','07P1279','07P1280','07P1285','07P1298','07P1299','07P1303','29P0116','34P052','01P1645','01P1646','01P1650','01P1651','01P1652','01P1653','10P1754','10P1755','10P1761','10P1762','27P0121','30P0186','30P0188','02P2056','02P2058','02P2059','02P2062','02P2063','02P2064','02P2066','04P1640','04P1643','04P1644','04P1645','28P0119','32P092','05P1116','05P1120','05P1121','05P1122','05P1125','07P1277','07P1279','07P1280','07P1285','07P1298','07P1299','07P1303','29P0116','34P052' ";

		
		$q.=" ) ";
		////////////////////////////////

		$q.=" order by a.codtipnom,a.codnom,to_char(c.fechaini,'mm/yyyy') ";


		}
		$query= $this->db->query($q,array($this->session->userdata('cedula'), $this->session->userdata('tipoper'), $this->session->userdata('tipoper')));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux['cedula']=$row->CEDEMP;
				$aux['apellido']=$row->APEEMP;
				$aux['nombre']=$row->NOMEMP;
				if ($row->CODDEP==null) {
					$aux['coddep']="072";
					
				}else{
				$aux['coddep']=$row->CODDEP;
				}
				$aux['cargcat']=$row->CARGCAT;
				$aux['codded']=$row->CODDED;
				$aux['codnom']=$row->CODNOM;
				$aux['fechaini']=$row->FECHAINI;
				$aux['codtipnom']=$row->CODTIPNOM;
				$datosprinc[$row->CODNOM]=$aux;

			}
			return($datosprinc);
		}else{

			$this->session->set_flashdata('mensaje','Nomina del mes '.$meses.' no disponible.');
			redirect('blog/nominas');

		}
	}

	public function datoscont($datosprinc)
	{
	foreach ($datosprinc as $key => $datosprinc) 
	{
			$codnom=$datosprinc['codnom'];
			$codtipnom=$datosprinc['codtipnom'];
		  $q=" select upper(a.destipnom) as DESTIPNOM,  upper(b.desnom) as DESNOM, upper(c.descond) as DESCOND, a.codtipfre  ";
			$q.=" from nomina.nomina b, nomina.tiponomina a, personal.condicionper c  ";
			$q.=" where b.codnom =?  ";
			$q.=" and a.codtipnom =? ";
			$q.=" and a.codcond = c.codcond  ";
			$q.=" and a.codtipnom = b.codtipnom ";

		$query= $this->db->query($q,array($codnom,$codtipnom));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux['destipnom']=$row->DESTIPNOM;
				$aux['desnom']=$row->DESNOM;
				$aux['descond']=$row->DESCOND;
				$aux['codtipfre']=$row->CODTIPFRE;
				$datoscont[$codnom]=$aux;

			}
		}
	}
			return($datoscont);
	}

	//busca las dependencias
	public function dependencia($datosprinc)
	{
		foreach ($datosprinc as $key => $datosprinc) {
			$coddep=$datosprinc['coddep'];
			$codnom=$datosprinc['codnom'];


		$q="select desdep,ubidep from personal.dependencia where coddep=?";
		$query= $this->db->query($q,array($coddep));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux['desdep']=$row->DESDEP;
				$aux['ubidep']=$row->UBIDEP;
				$dependencia[$codnom]=$aux;
			}
		}
	}
			return($dependencia);
}



	//busca la desc del cargo
	public function des_cargo($datosprinc)
	{
		foreach ($datosprinc as $key => $datosprinc) 
		{
			$cargcat=$datosprinc['cargcat'];
			$codnom=$datosprinc['codnom'];
		if ($this->session->userdata('tipoper')=='01') 
		{
			$q="select descat from personal.categoria 	where codcat=?";
		
			$query= $this->db->query($q,array($cargcat));
			if ($query->num_rows()>0)
			{
				foreach ($query->result() as $row) 
				{

					$aux=array();
					$aux['des_cargo']=$row->DESCAT;
					$cargo[$codnom]=$aux;
				}
			}

		}
		else
		{
			$q="select upper(descortama) as DESCORTAMA from personal.manucargo where codmacar=?";
		
			$query= $this->db->query($q,array($cargcat));
			if ($query->num_rows()>0){
				foreach ($query->result() as $row) {

					$aux=array();
					$aux['des_cargo']=$row->DESCORTAMA;
					$cargo[$codnom]=$aux;
				}
			}
		}
	}
		return($cargo);
	}

	
	//busca las Asignaciones
	public function asignaciones($datosprinc)
	{
		foreach ($datosprinc as $key => $datosprinc) 
		{
			$cedemp=$datosprinc['cedula'];
			$codtipnom=$datosprinc['codtipnom'];
			$codnom=$datosprinc['codnom'];

		$q=" select a.codcon, b.descorta, a.monto, a.cuota ";
		$q.="	from nomina.detallenom a, nomina.conceptos b  ";
		$q.="	where a.cedemp =?  ";
		$q.="	and a.codtipnom =?  ";
		$q.="	and a.codnom =? ";
		$q.="	and b.codtipcon='1' "; 
		$q.="	and a.codcon = b.codcon order by codcon"; 
		
		$query= $this->db->query($q,array($cedemp,$codtipnom,$codnom));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux['codcon1']=$row->CODCON;
				$aux['descorta1']=$row->DESCORTA;
				$aux['monto1']=$row->MONTO;
				$aux['cuota1']=$row->CUOTA;
				$asignaciones[$codnom][]=$aux;


			}
		}
	}
			return($asignaciones);
}
	
	//busca las Deducciones
	public function deducciones($datosprinc)
	{
		foreach ($datosprinc as $key => $datosprinc) 
		{
			$cedemp=$datosprinc['cedula'];
			$codtipnom=$datosprinc['codtipnom'];
			$codnom=$datosprinc['codnom'];

		$q="select a.codcon, b.descorta, a.monto, a.cuota ";
		$q.="		from nomina.detallenom a, nomina.conceptos b "; 
			$q.="	where a.cedemp =?  ";
			$q.="	and a.codtipnom =? ";
			$q.="	and a.codnom =? ";
			$q.="	and b.codtipcon='0'  ";
			$q.="	and a.codcon = b.codcon order by codcon"; 

		$query= $this->db->query($q,array($cedemp,$codtipnom,$codnom));
		if ($query->num_rows()>0)
		{
			foreach ($query->result() as $row) 
			{

				$aux=array();
				$aux['codcon2']=$row->CODCON;
				$aux['descorta2']=$row->DESCORTA;
				$aux['monto2']=$row->MONTO;
				$aux['cuota2']=$row->CUOTA;
				$deducciones[$codnom][]=$aux;
			}
		}
		else
		{
				$aux=array();
				$aux['codcon2']='';
				$aux['descorta2']='';
				$aux['monto2']='';
				$aux['cuota2']='';
				$deducciones[$codnom][]=$aux;
		}
	}

			return($deducciones);
}
	
	//busca las Asignaciones quincenales
	public function asig_quinc($datosprinc)
	{
		foreach ($datosprinc as $key => $datosprinc) 
		{
			$cedemp=$datosprinc['cedula'];
			$codtipnom=$datosprinc['codtipnom'];
			$codnom=$datosprinc['codnom'];

		$q="select a.monto, b.FRECON from nomina.detallenom a, nomina.conceptos b  ";
		$q.="		where a.codcon = b.codcon   ";
			$q.="	and a.codtipnom=?  ";
			$q.="	and a.codnom=?  ";
			$q.="	and a.cedemp=? ";
			$q.="	and b.codtipcon ='1' ";

		$query= $this->db->query($q,array($codtipnom,$codnom,$cedemp));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				$aux['monto_aq']=$row->MONTO;
				$aux['frecon_aq']=$row->FRECON;
				$asig_quinc[$codnom]=$aux;
			}
		}
	}
			return($asig_quinc);
}
	//busca las Deducciones quincenales
	public function ded_quinc($datosprinc)
	{
		$ded_quinc  = array();
		
		foreach ($datosprinc as $key => $datosprinc) 
		{
			$cedemp=$datosprinc['cedula'];
			$codtipnom=$datosprinc['codtipnom'];
			$codnom=$datosprinc['codnom'];

			$q="select a.monto, b.FRECON from nomina.detallenom a, nomina.conceptos b  ";
			$q.="		where a.codcon = b.codcon   ";
			$q.="	and a.codtipnom=? ";
			$q.="	and a.codnom=?  ";
			$q.="	and a.cedemp=? ";
			$q.="	and b.codtipcon ='0' ";
			
			$query= $this->db->query($q,array($codtipnom,$codnom,$cedemp));
			if ($query->num_rows()>0)
			{
				foreach ($query->result() as $row) 
				{

					$aux=array();
					$aux['monto_dq']=$row->MONTO;
					$aux['frecon_dq']=$row->FRECON;
					$ded_quinc[$codnom]=$aux;
				}
			}
		}
		
		return $ded_quinc ;
}









}

