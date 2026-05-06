<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'mihelper'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('user_model');

        if (!$this->session->userdata('logueado')) {
            $this->session->set_flashdata('mensaje', 'No has iniciado sesión');
            redirect('auth');
        }
    }

    public function index()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');
        $data['empleado'] = $this->user_model->get_empleado($this->session->userdata('cedula'), $this->session->userdata('tipoper'));

        $this->load->view('templates/header', $data);
        $this->load->view('profile/index', $data);
        $this->load->view('templates/footer');
    }

    public function editar_clave()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');

        $this->load->view('templates/header', $data);
        $this->load->view('profile/editar_clave', $data);
        $this->load->view('templates/footer');
    }

    public function procesar_clave()
    {
        $claveact = $this->input->post('contraact'); 
        $clave1 = $this->input->post('contra1'); 
        $clave2 = $this->input->post('contra2');

        if ($clave1 != $clave2) {
            $this->session->set_flashdata('mensaje', 'Las nuevas contraseñas no coinciden.');
            redirect('profile/editar_clave');
        }

        $this->user_model->update_clave($this->session->userdata('cedula'), $this->session->userdata('tipoper'), $clave1);
        $this->session->set_flashdata('mensaje_exito', 'Contraseña actualizada.');
        redirect('profile/editar_clave');
    }

    public function editar_correo()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');
        $data['empleado'] = $this->user_model->get_empleado($this->session->userdata('cedula'), $this->session->userdata('tipoper'));

        $this->load->view('templates/header', $data);
        $this->load->view('profile/editar_correo', $data);
        $this->load->view('templates/footer');
    }

    public function procesar_correo()
    {
        $email = $this->input->post('email');
        $this->user_model->update_correo($this->session->userdata('cedula'), $this->session->userdata('tipoper'), $email);
        $this->session->set_flashdata('mensaje_exito', 'Correo electrónico actualizado.');
        redirect('profile/editar_correo');
    }

    public function editar_preyres()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');
        $data['preyres'] = $this->user_model->get_preguntas_seguridad($this->session->userdata('cedula'), $this->session->userdata('tipoper'));

        $this->load->view('templates/header', $data);
        $this->load->view('profile/editar_preyres', $data);
        $this->load->view('templates/footer');
    }

    public function procesar_preyres()
    {
        $data = array(
            'pregunta' => strtoupper($this->input->post('pregunta')),
            'respuesta' => strtoupper($this->input->post('respuesta')),
            'pregunta2' => strtoupper($this->input->post('pregunta2')),
            'respuesta2' => strtoupper($this->input->post('respuesta2'))
        );

        $this->user_model->update_preguntas_seguridad($this->session->userdata('cedula'), $this->session->userdata('tipoper'), $data);
        $this->session->set_userdata('pregunta2', TRUE);
        $this->session->set_flashdata('mensaje_exito', 'Preguntas de seguridad actualizadas.');
        redirect('profile/editar_preyres');
    }
}
