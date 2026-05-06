<?php

class Blog2 extends CI_Controller {
		function __construct(){
		parent:: __construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('session', 'form_validation'));
        $this->load->model(array('login_model','pdf/nominapdf'));


	}

public function index()
{
if($this->session->userdata('logueado')){
    redirect('blog/inicio');

}else{
    $this->load->view('login_view');    
}


}


public function nominas(){
    if($this->session->userdata('logueado')){  //si está logueado muestra:
        $data['meses']=$this->login_model->meses();
        $data['sesion']=$this->session->userdata('nombre');
        $data['datosper']=$this->login_model->datospersonal();
        $this->load->view('templates/header',$data);
        $this->load->view('principal/nominas',$data);
    }else{//No está logueado así que lo devuelve al login.
        $this->session->set_flashdata('mensaje','No has iniciado sesión');
        redirect('blog');
      } 
}


public function pdfnomina(){ //imprime pdf de nomina
   if($this->session->userdata('logueado')){  //si está logueado muestra:

    $meses=$this->input->post('meses');
    if ($meses=='') {
        $this->session->set_flashdata('mensaje','Selecciona el Mes');
        redirect('blog/nominas'); 
        
    }else{
    $data['anio']=$this->login_model->anio($meses);
    $data['datosprinc']=$this->login_model->datosprinc($meses,$data['anio']);
    $data['datoscont']=$this->login_model->datoscont($data['datosprinc']);
    $data['dependencia']=$this->login_model->dependencia($data['datosprinc']);
    $data['cargo']=$this->login_model->des_cargo($data['datosprinc']);
    $data['asignaciones']=$this->login_model->asignaciones($data['datosprinc']);
    $data['deducciones']=$this->login_model->deducciones($data['datosprinc']);
    $data['asig_quinc']=$this->login_model->asig_quinc($data['datosprinc']);
    $data['ded_quinc']=$this->login_model->ded_quinc($data['datosprinc']);

     foreach ($data['datoscont'] as $key => $value) {
            $data['datoscont'][$key]['datosprinc']=$data['datosprinc'][$key];
            $data['datoscont'][$key]['dependencia']=$data['dependencia'][$key];
            $data['datoscont'][$key]['cargo']=$data['cargo'][$key];
            $data['datoscont'][$key]['asignaciones']=$data['asignaciones'][$key];
            $data['datoscont'][$key]['deducciones']=$data['deducciones'][$key];




    }

    $this->nominapdf->imprimir($data['anio'],$meses,$data['datoscont']);
    }
}else{//No está logueado así que lo devuelve al login.
        $this->session->set_flashdata('mensaje','No has iniciado sesión');
        redirect('blog');
      } 
}

}




