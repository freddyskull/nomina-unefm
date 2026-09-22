<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'mihelper'));
        $this->load->library('session');
        $this->load->model(array('user_model', 'payroll_model'));

        if (!$this->session->userdata('logueado')) {
            $this->session->set_flashdata('mensaje', 'No has iniciado sesión');
            redirect('auth');
        }

        if ($this->session->userdata('pregunta2') == null) {
            $this->session->set_flashdata('mensaje', 'Primero debe llenar el formulario de seguridad');
            redirect('profile/editar_preyres');
        }
    }

    public function index()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');
        $data['datosper'] = $this->user_model->get_datos_personal($this->session->userdata('cedula'), $this->session->userdata('tipoper'));
        $data['cargaf'] = $this->user_model->get_carga_familiar($this->session->userdata('cedula'));
        $data['datosban'] = $this->user_model->get_datos_bancarios($this->session->userdata('cedula'), $this->session->userdata('tipoper'));

        $cedula = $this->session->userdata('cedula');
        $tipoper = $this->session->userdata('tipoper');
        $codnom = $this->session->userdata('codnom');
        $codtipnom = $this->session->userdata('codtipnom');

        if (empty($codnom) || empty($codtipnom)) {
            $last_nomina = $this->payroll_model->get_last_nomina_info($cedula, $tipoper);
            if ($last_nomina) {
                $codnom = $last_nomina['CODNOM'];
                $codtipnom = $last_nomina['CODTIPNOM'];
            }
        }

        // Bloquear cálculo del sueldo si el personal está inactivo en nómina
        $data['inactivo'] = $this->user_model->empleado_inactivo($cedula, $codtipnom);

        if (!$data['inactivo']) {
            $data['payroll_summary'] = $this->payroll_model->get_payroll_summary($cedula, $tipoper, $codnom, $codtipnom);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}
