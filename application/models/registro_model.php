<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->default = $this->load->database('default', TRUE);
        $this->PERSONAL= $this->load->database('PERSONAL', TRUE);
	}

	public function consultausuario($cedula,$tipoper){

		$sql="SELECT * FROM nomina.consusr WHERE cedemp=? and tipoper=? ";
		$query=$this->db->query($sql,array($cedula,$tipoper));
		if($query->num_rows()>0){


			$this->session->set_flashdata('mensaje','Esta cedula esta Registrada...');
			redirect('blog/registrar');

		}else{

				$sql="SELECT a.tipoper,a.cedemp,a.nomemp,a.apeemp,a.diremp,b.cond, b.codtipnom ,d.descond FROM personal.empleados a, nomina.situaempnom b, nomina.tiponomina c,PERSONAL.condicionper d  WHERE a.cedemp=? and a.cedemp=b.cedemp and b.codnom='-' and b.codtipnom=c.codtipnom and c.codtipper=a.tipoper and b.cond=d.codcond and c.codtipper=? ";
				$query=$this->db->query($sql,array($cedula,$tipoper));
				if($query->num_rows()>0){
					foreach ($query->result() as $row) {

						$aux=array();
						$aux[]=$row->TIPOPER;
						$aux[]=$row->CEDEMP;
						$aux[]=$row->NOMEMP;
						$aux[]=$row->APEEMP;
						$aux[]=$row->DIREMP;
						$aux[]=$row->COND;
						$aux[]=$row->CODTIPNOM;
						$aux[]=$row->DESCOND;
						$datosemp[]=$aux;

					}
				return($datosemp);
				}else{

						if ($tipoper=='01') {
							$tipoper='Docente';
							
						}elseif ($tipoper=='02') {
							$tipoper='Administrativo';
						}elseif ($tipoper=='03') {
							$tipoper='Obrero';
						}
							
						$this->session->set_flashdata('mensaje','Esta cedula no pertenece a un empleado '.$tipoper.' de la UNEFM...');
						redirect('blog/registrar');
				}
		}
	}

	public function consultausuario2($cedula,$tipoper){

		$sql="SELECT * FROM nomina.consusr WHERE cedemp=? and tipoper=? ";
		$query=$this->db->query($sql,array($cedula,$tipoper));
		if($query->num_rows()==0){

			if ($tipoper=='01') {
				$tipoper='Docente';
							
			}elseif ($tipoper=='02') {
				$tipoper='Administrativo';
			}elseif ($tipoper=='03') {
				$tipoper='Obrero';
			}
							
			$this->session->set_flashdata('mensaje','Esta cedula no esta registrada a un empleado '.$tipoper.' de la UNEFM...');
			redirect('blog/recuperarus');

		}else{

				$sql="SELECT pregunta, pregunta2, cedemp, tipoper from NOMINA.consusr where cedemp=? and tipoper=?";
				$query=$this->db->query($sql,array($cedula,$tipoper));
				if($query->num_rows()>0){
					foreach ($query->result() as $row) {

						$aux=array();
						$aux[]=$row->PREGUNTA;
						$aux[]=$row->PREGUNTA2;
						$aux[]=$row->CEDEMP;
						$aux[]=$row->TIPOPER;
						$preguntas[]=$aux;

					}
				return($preguntas);
				}
		}
	}
	
	public function registrar($us,$clave,$clave2,$email,$tipoper,$cedula,$preg,$resp,$preg2,$resp2){

		if ($clave!=$clave2) {
			$this->session->set_flashdata('cedula',$cedula);
			$this->session->set_flashdata('tipoper',$tipoper);
			$this->session->set_flashdata('mensaje','Las contraseñas son diferentes');
			redirect('blog/error');
		}else{

			$sql="SELECT * FROM nomina.consusr WHERE usuario=?";
			$query=$this->db->query($sql,array($us));
			if($query->num_rows()>0){
				$this->session->set_flashdata('cedula',$cedula);
				$this->session->set_flashdata('tipoper',$tipoper);
				$this->session->set_flashdata('mensaje','El Nombre de usuario '.$us.' ya esta registrado en el sistema, por favor intente con otro.');
				redirect('blog/error');

			}else{


			 	$sql= "INSERT INTO nomina.consusr(usuario,tipoper,cedemp,clave,correo,pregunta,respuesta,pregunta2,respuesta2) VALUES (?,?,?,?,?,?,?,?,?)";
			 	$query= $this->db->query($sql,array($us,$tipoper,$cedula,$clave,$email,$preg,$resp,$preg2,$resp2));
				
				$this->session->set_flashdata('mensaje2','Usuario '.$us.' registrado correctamente.');
				redirect('blog/registrar');
			}
		}
	}
	
	public function recuperarusuario($respuesta,$respuesta2,$tipoper,$cedula){

			$sql="SELECT * from NOMINA.consusr where cedemp=? and tipoper=? and respuesta=? and respuesta2=?";
			$query=$this->db->query($sql,array($cedula,$tipoper,$respuesta,$respuesta2));
			if($query->num_rows()==0){
				$this->session->set_flashdata('cedula',$cedula);
				$this->session->set_flashdata('tipoper',$tipoper);
				$this->session->set_flashdata('mensaje','Las respuestas son incorrectas, por favor intente nuevamente.');
				redirect('blog/error2');

			}else{
			$q="SELECT usuario, clave from NOMINA.consusr where cedemp=? and tipoper=?";
		$query= $this->db->query($q,array($cedula,$tipoper));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$us=$row->USUARIO;
				$clave=$row->CLAVE;

			}
		}

			$this->session->set_flashdata('mensaje2','Sus datos de usuario son: <br><br>Usuario: <pre>'.$us.'</pre>');
			$this->session->set_flashdata('mensaje3','<br> Contraseña: <pre>'.$clave.'</pre>');//<br> Contraseña: <pre>'.$clave.'</pre>');
			redirect('blog/recuperarus');	
return ($us);
			}
		}

		public function editar_clave($claveact,$clave1,$clave2){

		if ($clave1!=$clave2) {
			$this->session->set_flashdata('mensaje','Las contraseñas de su nueva clave son diferentes');
			redirect('blog/editar_clave');
		}else{
		echo "stringasdsad";
			$sql="SELECT clave FROM nomina.consusr where cedemp=? and tipoper=? and clave=?";
			$query=$this->db->query($sql,array($this->session->userdata('cedula'),$this->session->userdata('tipoper'),$claveact));
			if($query->num_rows()==0){
				$this->session->set_flashdata('mensaje','La Contraseña actual no conincide');
				redirect('blog/editar_clave');

			}else{


			 	$sql= "UPDATE nomina.consusr set clave=? where cedemp=? and tipoper=? ";
			 	$query= $this->db->query($sql,array($clave1,$this->session->userdata('cedula'),$this->session->userdata('tipoper')));
				
				$this->session->set_flashdata('mensaje2','Contraseña cambiada');
				redirect('blog/editar_clave');
			}
		}
	}

	public function editar_correo($email){


			 	$sql= "UPDATE nomina.consusr set correo=? where cedemp=? and tipoper=? ";
			 	$query= $this->db->query($sql,array($email,$this->session->userdata('cedula'),$this->session->userdata('tipoper')));
				
				$this->session->set_flashdata('mensaje','Correo cambiado');
				redirect('blog/editar_correo');
			}

	public function busc_preyres(){


		$q="SELECT pregunta, respuesta, pregunta2, respuesta2 from nomina.consusr where cedemp=? and tipoper=?";
		$query= $this->db->query($q,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
		if ($query->num_rows()>0){
			foreach ($query->result() as $row) {

				$aux=array();
				if ($row->PREGUNTA==null) {
					$aux['pregunta']= "";
				}else{
				$aux['pregunta']=$row->PREGUNTA;
				}
				if ($row->PREGUNTA2==null) {
					$aux['pregunta2']= "";
				}else{
				$aux['pregunta2']=$row->PREGUNTA2;
				}
				if ($row->RESPUESTA==null) {
					$aux['respuesta']= "";
				}else{
				$aux['respuesta']=$row->RESPUESTA;
				}				
				if ($row->RESPUESTA2==null) {
					$aux['respuesta2']= "";
				}else{
				$aux['respuesta2']=$row->RESPUESTA2;
				}
				$preyres[]=$aux;

			}
			return($preyres);
		}
	}
		public function editar_preyres2($pregunta,$respuesta,$pregunta2,$respuesta2){


			 	$sql= "UPDATE nomina.consusr set pregunta=?, respuesta=?, pregunta2=?, respuesta2=? where cedemp=? and tipoper=? ";
			 	$query= $this->db->query($sql,array($pregunta,$respuesta,$pregunta2,$respuesta2,$this->session->userdata('cedula'),$this->session->userdata('tipoper')));
				
				$datos=array(

					'pregunta2'=> TRUE	
				);
				$this->session->set_userdata($datos);
				$this->session->set_flashdata('mensaje','Preguntas y respuestas cambiadas');
				redirect('blog/editar_preyres');
			}
			

		public function familiares(){

				$sql="SELECT CEDEMP, CEDFAM, NOMBREFAM from  NOMINA.fondo_mut_familiares where cedemp=? ";
				$query=$this->db->query($sql,array($this->session->userdata('cedula')));
				if($query->num_rows()>0){
					foreach ($query->result() as $row) {

						$aux=array();
						$aux[]=$row->TIPOPER;
						$aux[]=$row->CEDEMP;
						$aux[]=$row->CEDFAM;
						$aux[]=$row->NOMBREFAM;
						$familiares[]=$aux;

					}
				return($familiares);
				}
		}

		public function medicinas(){

				$sql="SELECT * from  NOMINA.fondo_mut_medicinas ORDER BY nombre";
				$query=$this->db->query($sql,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
				if($query->num_rows()>0){
					foreach ($query->result() as $row) {

						$aux=array();
						$aux[]=$row->CODMED;
						$aux[]=$row->NOMBRE;
						$aux[]=$row->ESTATUS;
						$medicinas[]=$aux;

					}
				return($medicinas);
				}
		}

		public function mostrar_censo_medicina(){

				$sql="SELECT  a.cedemp, a.cedfam, a.codmed, b.nombre  
					FROM NOMINA.fondo_mut_censo_medicina a, NOMINA.fondo_mut_medicinas b 
					WHERE a.cedemp=? and a.tipoper=? and a.codmed = b.codmed  
					ORDER BY a.cedemp, a.cedfam ";
				$query=$this->db->query($sql,array($this->session->userdata('cedula'),$this->session->userdata('tipoper')));
				if($query->num_rows()>0){
					foreach ($query->result() as $row) {

						$aux=array();
						$aux[]=$row->CEDEMP;
						$aux[]=$row->CEDFAM;
						$aux[]=$row->CODMED;
						$aux[]=$row->NOMBRE;
						$censo[]=$aux;

					}
				return($censo);
				}
		}

		public function crear_censo_medicina($familiar,$medicina){
			
				$sql="SELECT * FROM NOMINA.fondo_mut_censo_medicina where CEDEMP=? and TIPOPER=? and CEDFAM=? and CODMED=? ";
				$query=$this->db->query($sql,array($this->session->userdata('cedula'),$this->session->userdata('tipoper'),$familiar,$medicina));
				if($query->num_rows()>0){
					$this->session->set_flashdata('mensaje2','Este familiar ya tiene registrada esta medicina');
					redirect('blog/medicina');

				}else{
				$sql="INSERT INTO nomina.fondo_mut_censo_medicina(tipoper, cedemp, cedfam, codmed) values (?,?,?,?)";
				$query=$this->db->query($sql,array($this->session->userdata('tipoper'),$this->session->userdata('cedula'),$familiar,$medicina));

				$this->session->set_flashdata('mensaje','Registrado correctamente.');
				redirect('blog/medicina');
		}
	
	}

			public function eliminar_censo_medicina($cedula,$codmed){

				$sql="DELETE from NOMINA.fondo_mut_censo_medicina where cedfam=? and codmed=? and tipoper=? and cedemp=?";

				$query=$this->db->query($sql,array($cedula,$codmed, $this->session->userdata('tipoper'),$this->session->userdata('cedula')));

				$this->session->set_flashdata('mensaje3','Eliminado.');
				redirect('blog/medicina');
		
	}

		public function nombrefamiliar($cedula)
		{
			$nombre="";
			$sql="SELECT nomemp FROM personal.empleados   WHERE cedemp=? and tipoper=? ";

				$query=$this->db->query($sql,array($cedula,$this->session->userdata('tipoper')));
				if($query->num_rows()>0)
				{
					foreach ($query->result() as $row) 
					{

										
						$nombre=$row->NOMEMP;

					}

				}
				else
				{
					$sql="SELECT NOMBREFAM from  NOMINA.fondo_mut_familiares where cedemp=? and cedfam=?";
					$query=$this->db->query($sql,array($this->session->userdata('cedula'), $cedula));
					if($query->num_rows()>0)
					{
						foreach ($query->result() as $row) 
						{

							$nombre=$row->NOMBREFAM;

					    }


					}
					else
					{
							$nombre="--";
					}
				}

			return $nombre;
		}


}



