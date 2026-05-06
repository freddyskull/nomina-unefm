<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller 
{

    function __construct()
    {
        parent:: __construct();
        $this->load->helper(array('form', 'url','mihelper'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model(array('login_model','registro_model'));
    }

   

    public function index()
    {

        if($this->session->userdata('logueado'))
        {
            redirect('blog/inicio');

        }
        else
        {
            $this->load->view('login_view');    
        }
       
    }

    public function ingresar() 
    {
        $userData = array(
            array(
                'field' => 'usuario',
                'rules' => 'required|xss_clean'
            ),
            array(
                'field' => 'contra',
                'rules' => 'required|xss_clean'
        ));

        $this->form_validation->set_rules($userData);

        if ($this->form_validation->run() === FALSE) 
        {
            $this->load->view('login_view', array('error' => ' '));
        } 
        else 
        {
            $usuario = $this->input->post('usuario'); 
            //$contra = sha1($this->input->post('contra'));
            $contra = $this->security->xss_clean(strip_tags($this->input->post('contra')));
            //$contra=sha1($contra);
            $datos=$this->login_model->login($usuario,$contra);

            //print_r($this->session->all_userdata() );

            redirect('blog/inicio');

        }

    }
           


    public function inicio()
    {
        if($this->session->userdata('logueado'))
        {  //si está logueado muestra:
            $data['sesion']=$this->session->userdata('nombre');
            $data['sexo']=$this->session->userdata('sexo');
            $data['datosper']=$this->login_model->datospersonal();
            $data['cargaf']=$this->login_model->cargafamiliar();
            if($this->session->userdata('pregunta2')==null)
            {
                $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
                redirect('blog/editar_preyres');
            }
            else
            {

                $this->load->view('templates/header',$data);
                $this->load->view('principal/inicio',$data);

            }
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }



    }   

    public function registrar()
    {

            $this->load->view('registrar');

    }

    public function recuperarus()
    {

            $this->load->view('recuperarus');

    }

    public function verificarus()
    {

            $cedula = $this->input->post('cedula'); 
            $tipoper = $this->input->post('tipoper');
            $data['datosemp']=$this->registro_model->consultausuario($cedula,$tipoper);
            $this->load->view('registrar2',$data);
    }

    public function verificarus2()
    {

            $cedula = $this->input->post('cedula'); 
            $tipoper = $this->input->post('tipoper');
            $data['preguntas']=$this->registro_model->consultausuario2($cedula,$tipoper);
            $this->load->view('recuperarus2',$data);
    }  

    public function registrar2()
    {
            $us = $this->input->post('us'); 
            $clave = $this->input->post('clave'); 
            $clave2 = $this->input->post('clave2'); 
            $email = $this->input->post('email'); 
            $tipoper = $this->input->post('tipoper');
            $cedula = $this->input->post('cedula');
            $preg = strtoupper($this->input->post('preg'));
            $resp = strtoupper($this->input->post('resp'));
            $preg2 = strtoupper($this->input->post('preg2'));
            $resp2 = strtoupper($this->input->post('resp2'));
            $data['datosemp']=$this->registro_model->registrar($us,$clave,$clave2,$email,$tipoper,$cedula,$preg,$resp,$preg2,$resp2);

    }

    public function recuperarus2()
    {
            $respuesta = strtoupper($this->input->post('respuesta')); 
            $respuesta2= strtoupper($this->input->post('respuesta2'));
            $tipoper = $this->input->post('tipoper');
            $cedula = $this->input->post('cedula'); 
            $data['respuestas']=$this->registro_model->recuperarusuario($respuesta,$respuesta2,$tipoper,$cedula);

    }

    public function error()
    {
            $cedula=$this->session->flashdata('cedula');
            $tipoper=$this->session->flashdata('tipoper');
            $data['datosemp']=$this->registro_model->consultausuario($cedula,$tipoper);
            $this->load->view('registrar2',$data);

    }

    public function error2()
    {
            $cedula=$this->session->flashdata('cedula');
            $tipoper=$this->session->flashdata('tipoper');
            $data['preguntas']=$this->registro_model->consultausuario2($cedula,$tipoper);
            $this->load->view('recuperarus2',$data);

    }


    public function usuario()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $data['sesion']=$this->session->userdata('nombre');
            $data['sexo']=$this->session->userdata('sexo');
            
            $data['empleado']=$this->login_model->empleados();

            if($this->session->userdata('pregunta2')==null){
            $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
            redirect('blog/editar_preyres');
            }else{
            $this->load->view('templates/header',$data);
            $this->load->view('principal/datousuario',$data);
            }
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

    public function editar_correo()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $data['sesion']=$this->session->userdata('nombre');
            $data['sexo']=$this->session->userdata('sexo');
            $data['empleado']=$this->login_model->empleados();
            if($this->session->userdata('pregunta2')==null){
            $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
            redirect('blog/editar_preyres');
            }else{
            $this->load->view('templates/header',$data);
            $this->load->view('principal/editar_correo',$data);
        }
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

    public function editar_correo2()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra: 
            $email = $this->input->post('email');
            $data['correo']=$this->registro_model->editar_correo($email);
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

    public function editar_clave()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $data['sesion']=$this->session->userdata('nombre');
            $data['sexo']=$this->session->userdata('sexo');
            if($this->session->userdata('pregunta2')==null){
            $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
            redirect('blog/editar_preyres');
            }else{
            $this->load->view('templates/header',$data);
            $this->load->view('principal/editar_clave',$data);
        }
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

    public function editar_clave2()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $claveact = $this->input->post('contraact'); 
            $clave1 = $this->input->post('contra1'); 
            $clave2 = $this->input->post('contra2');
            $data['clave']=$this->registro_model->editar_clave($claveact,$clave1,$clave2);
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

    public function editar_preyres()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $data['sesion']=$this->session->userdata('nombre');
            $data['sexo']=$this->session->userdata('sexo');
            $data['preyres']=$this->registro_model->busc_preyres();
            $this->load->view('templates/header',$data);
            $this->load->view('principal/editar_preyres',$data);
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

    public function editar_preyres2()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $pregunta = strtoupper($this->input->post('pregunta')); 
            $respuesta = strtoupper($this->input->post('respuesta')); 
            $pregunta2 = strtoupper($this->input->post('pregunta2'));
            $respuesta2 = strtoupper($this->input->post('respuesta2'));
            $data['preyres']=$this->registro_model->editar_preyres2($pregunta,$respuesta,$pregunta2,$respuesta2);
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

   

    public function arc()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $data['sexo']=$this->session->userdata('sexo');
            $data['sesion']=$this->session->userdata('nombre');
            $data['cedula']=$this->session->userdata('cedula');
            $data['tipoper']=$this->session->userdata('tipoper');
            if($this->session->userdata('pregunta2')==null){
            $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
            redirect('blog/editar_preyres');
            }else{
            $this->load->view('templates/header',$data);
            $this->load->view('principal/arc',$data);
        }
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          } 
    }

    public function adelanto_prest()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $data['sesion']=$this->session->userdata('nombre');
            $data['sexo']=$this->session->userdata('sexo');
            if($this->session->userdata('pregunta2')==null){
            $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
            redirect('blog/editar_preyres');
            }else{
            $this->load->view('templates/header',$data);
            $this->load->view('principal/adelanto_prest',$data);
        }
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          } 

    }

    public function iiiccu()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $data['sexo']=$this->session->userdata('sexo');
            $data['sesion']=$this->session->userdata('nombre');
            $data['cedula']=$this->session->userdata('cedula');
            $data['tipoper']=$this->session->userdata('tipoper');
            if($this->session->userdata('pregunta2')==null){
            $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
            redirect('blog/editar_preyres');
            }else{
            $this->load->view('templates/header',$data);
            $this->load->view('principal/iiiccu',$data);
        }
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          } 
    }


    

    

    public function medicina()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $data['sesion']=$this->session->userdata('nombre');
            $data['sexo']=$this->session->userdata('sexo');
            $data['apellido']=$this->session->userdata('apellido');
            $data['cedula']=$this->session->userdata('cedula');
            $data['familiares']=$this->registro_model->familiares();
            $data['medicinas']=$this->registro_model->medicinas();
            $data['censo']=$this->registro_model->mostrar_censo_medicina();
            if($this->session->userdata('pregunta2')==null){
            $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
            redirect('blog/editar_preyres');
            }else{
            $this->load->view('templates/header',$data);
            $this->load->view('principal/formumedicina',$data);
            }
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

    public function censo_medicina()
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            $familiar = $this->input->post('familiar');
            $medicina = $this->input->post('medicina');
            $data['censo']=$this->registro_model->crear_censo_medicina($familiar,$medicina);

        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

    public function eliminar_censo_medicina($cedula,$codmed)
    {
        if($this->session->userdata('logueado')){  //si está logueado muestra:
            echo $cedula = $this->uri->segment(3) ;
            echo $codmed = $this->uri->segment(4) ;
            $this->registro_model->eliminar_censo_medicina($cedula,$codmed) ; 
        }else{//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          }
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('privilegios');
        $this->session->unset_userdata('user');
        redirect('blog');
    }


////////////////////////////////////////////

   

    //muestra el formulario para sacar las nomias del mes
    public function nominas()
    {
        if($this->session->userdata('logueado'))
        {  //si está logueado muestra:
            $data['meses']=$this->login_model->meses();
            $data['sexo']=$this->session->userdata('sexo');
            $data['sesion']=$this->session->userdata('nombre');
            $data['datosper']=$this->login_model->datospersonal();
            if($this->session->userdata('pregunta2')==null)
            {
                $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
                redirect('blog/editar_preyres');
            }
            else
            {
                $this->load->view('templates/header',$data);
                $this->load->view('principal/nominas',$data);
            }

        }
        else
        {   //No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
          } 
    }

    //genera  el pdf de las nominas del mes seleccionado
    public function pdfnomina()
    { 
        //imprime pdf de nomina
        $this->load->model('pdf/nominapdf');
       
       if($this->session->userdata('logueado'))
       {  //si está logueado muestra:

            $meses=$this->input->post('meses');
            if ($meses=='') 
            {
                $this->session->set_flashdata('mensaje','Selecciona el Mes');
                redirect('blog/nominas'); 
                
            }
            else
            {

                //echo "listo para imprimir 1"; 

                $data['anio']=$this->login_model->anio($meses);


                $data['datosprinc']=$this->login_model->datosprinc($meses,$data['anio']);
                
                $data['datoscont']=$this->login_model->datoscont($data['datosprinc']);
                $data['dependencia']=$this->login_model->dependencia($data['datosprinc']);
                $data['cargo']=$this->login_model->des_cargo($data['datosprinc']);
                
                //echo "listo para imprimir 2";

                $data['asignaciones']=$this->login_model->asignaciones($data['datosprinc']);
                $data['deducciones']=$this->login_model->deducciones($data['datosprinc']);
                $data['asig_quinc']=$this->login_model->asig_quinc($data['datosprinc']);
                $data['ded_quinc']=$this->login_model->ded_quinc($data['datosprinc']);
                
                //echo "listo para imprimir 3";

                 foreach ($data['datoscont'] as $key => $value) 
                 {
                        $data['datoscont'][$key]['datosprinc']=$data['datosprinc'][$key];
                        $data['datoscont'][$key]['dependencia']=$data['dependencia'][$key];
                        $data['datoscont'][$key]['cargo']=$data['cargo'][$key];
                        $data['datoscont'][$key]['asignaciones']=$data['asignaciones'][$key];
                        $data['datoscont'][$key]['deducciones']=$data['deducciones'][$key];
                }

                //echo "listo para imprimir 4";

                $this->nominapdf->imprimir($data['anio'],$meses,$data['datoscont']);
            }
        }
        else
        {//No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
        } 
    }

////////////////////////////////////////////////////

    //muestra formulario para solicitar constancia de trabajo
    public function consttra()
    {
        if($this->session->userdata('logueado'))
        {   //si está logueado muestra:
            $data['sesion']=$this->session->userdata('nombre');
            $data['sexo']=$this->session->userdata('sexo');
            $data['datosper']=$this->login_model->datospersonal();
            
            if($this->session->userdata('pregunta2')==null)
            {
                $this->session->set_flashdata('mensaje3','Primero debe llenar el formulario');
                redirect('blog/editar_preyres');
            }
            else
            {
                $this->load->view('templates/header',$data);
                $this->load->view('principal/constancia',$data);
            }

        }
        else
        {
            //No está logueado así que lo devuelve al login.
            $this->session->set_flashdata('mensaje','No has iniciado sesión');
            redirect('blog');
        } 
    }

    //crea el pdf de las constancia de trabajo
     public function pdf()
    {       
        $this->load->model('pdf/constanciapdf');
        if($this->session->userdata('logueado'))
        {  //si está logueado muestra:
            $sueldo=$this->input->post('sueldo');
            $ces=$this->input->post('ces');

            if ($ces=='' || $sueldo=='') 
            {
                $this->session->set_flashdata('mensaje','Selecciona el Tipo de sueldo y Cesta Ticket');
                redirect('blog/consttra'); 
                
            }
            else
            {
                
                $data['sesion']=$this->session->userdata('tipoper');
                
                $data['datosper']=$this->login_model->datospersonal();

                $data['cargos']=$this->login_model->cargo();

                $data['fechaini']=$this->login_model->fechaini(); //fecha de ingreso

                $fechaIng=null;
                if(count($data['fechaini'])>0 )
                    foreach ($data['fechaini'] as $fecha) 
                        $fechaIng=$fecha[0];
                
                $data['fechaegre']=$this->login_model->fechaegre($fechaIng); //fecha de egreso
                $data['fechacon']=$this->login_model->fechacon(); //retorna fecha de los contratos

                $data['monto']=$this->login_model->sueldointegral(); //sueldo integral
                $data['sub']=$this->login_model->sueldobasico(); //sueldo basico
                
                $data['cuota']=$this->login_model->cuota(); //numero de dias pagados si los hay
                $data['tf']=$this->login_model->tf(); //tipo de frecuencia ( 01-QUINCENAL 02-MENSUAL 03-SEMANAL)
                
                $data['codnomh']=$this->login_model->codnomh(); //retorna las nomihas hijas o paralelas de la principal
                $data['monto2']=$this->login_model->sueldoh($data['codnomh']); //sueldo entegral de las nominas paralelas
                $data['monto3']=$this->login_model->sueldohb($data['codnomh']);//sueldo basico de las nominas paralelas

               
                

                $this->constanciapdf->imprimir(
                    $data['sesion']
                    ,$data['datosper']
                    ,$data['cargos']
                    ,$data['fechaini']
                    ,$data['fechaegre']
                    ,$sueldo
                    ,$ces
                    ,$data['fechacon']
                    ,$data['monto']
                    ,$data['cuota']
                    ,$data['tf']
                    ,$data['sub']
                    ,$data['monto2']
                    ,$data['monto3']);
            }

        }
        else
        {//No está logueado así que lo devuelve al login.
                $this->session->set_flashdata('mensaje','No has iniciado sesión');
                redirect('blog');
        } 
    }



}




