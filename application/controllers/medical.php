<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medical extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'mihelper'));
        $this->load->library('session');
        $this->load->model('medical_model');

        if (!$this->session->userdata('logueado')) {
            $this->session->set_flashdata('mensaje', 'No has iniciado sesión');
            redirect('auth');
        }
    }

    public function index()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');
        $data['familiares'] = $this->medical_model->get_familiares_fondo($this->session->userdata('cedula'));
        $data['medicinas'] = $this->medical_model->get_medicinas();
        $data['censo'] = $this->medical_model->get_censo_medicina($this->session->userdata('cedula'), $this->session->userdata('tipoper'));

        $this->load->view('templates/header', $data);
        $this->load->view('medical/index', $data);
        $this->load->view('templates/footer');
    }

    public function procesar_censo()
    {
        $familiar = $this->input->post('familiar');
        $medicina = $this->input->post('medicina');
        
        $res = $this->medical_model->add_censo_medicina($this->session->userdata('cedula'), $this->session->userdata('tipoper'), $familiar, $medicina);
        
        if ($res === 'EXISTS') {
            $this->session->set_flashdata('mensaje', 'Este familiar ya tiene registrada esta medicina.');
        } else {
            $this->session->set_flashdata('mensaje_exito', 'Medicina registrada correctamente.');
        }
        redirect('medical');
    }

    public function eliminar_censo($cedula_fam, $codmed)
    {
        $this->medical_model->delete_censo_medicina($this->session->userdata('cedula'), $this->session->userdata('tipoper'), $cedula_fam, $codmed);
        $this->session->set_flashdata('mensaje_exito', 'Registro eliminado.');
        redirect('medical');
    }
}
