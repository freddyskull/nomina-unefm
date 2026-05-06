<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'mihelper'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('auth_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            redirect('dashboard');
        } else {
            $this->load->view('auth/login_view');
        }
    }

    public function ingresar() 
    {
        $this->form_validation->set_rules('usuario', 'Usuario', 'required|xss_clean');
        $this->form_validation->set_rules('contra', 'Contraseña', 'required|xss_clean');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login_view');
        } else {
            $usuario = $this->input->post('usuario'); 
            $contra = $this->security->xss_clean(strip_tags($this->input->post('contra')));
            
            $res = $this->auth_model->login($usuario, $contra);

            if ($res) {
                redirect('dashboard');
            } else {
                if (!$this->session->flashdata('mensaje')) {
                    $this->session->set_flashdata('mensaje', 'Credenciales inválidas.');
                }
                redirect('auth');
            }
        }
    }

    public function registrar()
    {
        if ($this->session->userdata('logueado')) {
            redirect('dashboard');
        }
        $this->load->view('auth/registrar');
    }

    public function verificar_usuario()
    {
        $cedula = $this->input->post('cedula'); 
        $tipoper = $this->input->post('tipoper');
        $res = $this->auth_model->consultausuario($cedula, $tipoper);

        if ($res === 'EXISTS') {
            $this->session->set_flashdata('mensaje', 'Esta cédula ya está registrada.');
            redirect('auth/registrar');
        } elseif ($res === 'NOT_FOUND') {
            $this->session->set_flashdata('mensaje', 'Cédula no encontrada en el personal activo.');
            redirect('auth/registrar');
        } else {
            $data['datosemp'] = $res;
            $this->load->view('auth/registrar_paso2', $data);
        }
    }

    public function procesar_registro()
    {
        $data = array(
            'usuario' => $this->input->post('us'),
            'clave' => $this->input->post('clave'),
            'email' => $this->input->post('email'),
            'tipoper' => $this->input->post('tipoper'),
            'cedemp' => $this->input->post('cedula'),
            'pregunta' => strtoupper($this->input->post('preg')),
            'respuesta' => strtoupper($this->input->post('resp')),
            'pregunta2' => strtoupper($this->input->post('preg2')),
            'respuesta2' => strtoupper($this->input->post('resp2'))
        );

        $res = $this->auth_model->registrar($data);

        if ($res === 'USER_EXISTS') {
            $this->session->set_flashdata('mensaje', 'El nombre de usuario ya existe.');
            redirect('auth/registrar');
        } else {
            $this->session->set_flashdata('mensaje_exito', 'Usuario registrado correctamente.');
            redirect('auth');
        }
    }

    public function recuperarus()
    {
        if ($this->session->userdata('logueado')) {
            redirect('dashboard');
        }
        $this->load->view('auth/recuperarus');
    }

    public function verificar_recuperacion()
    {
        $cedula = $this->input->post('cedula'); 
        $tipoper = $this->input->post('tipoper');
        $res = $this->auth_model->consultausuario2($cedula, $tipoper);

        if ($res === 'NOT_REGISTERED') {
            $this->session->set_flashdata('mensaje', 'Esta cédula no está registrada.');
            redirect('auth/recuperarus');
        } else {
            $data['preguntas'] = $res;
            $this->load->view('auth/recuperarus_paso2', $data);
        }
    }

    public function procesar_recuperacion()
    {
        $respuesta = strtoupper($this->input->post('respuesta')); 
        $respuesta2 = strtoupper($this->input->post('respuesta2'));
        $tipoper = $this->input->post('tipoper');
        $cedula = $this->input->post('cedula'); 

        $res = $this->auth_model->recuperarusuario($respuesta, $respuesta2, $tipoper, $cedula);

        if ($res) {
            $this->session->set_flashdata('mensaje_exito', 'Tus datos de usuario son: <br>Usuario: ' . $res['USUARIO'] . '<br>Contraseña: ' . $res['CLAVE']);
            redirect('auth');
        } else {
            $this->session->set_flashdata('mensaje', 'Respuestas incorrectas.');
            redirect('auth/recuperarus');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
