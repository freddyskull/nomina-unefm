<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validar_constancia extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'mihelper'));
        $this->load->model('user_model');
    }

    public function index($token = '')
    {
        $datos = constancia_verificar($token);

        if (!$datos) {
            $this->load->view('validar_constancia/invalid');
            return;
        }

        if ($datos['expirada']) {
            $datos['empleado'] = $this->user_model->get_nombre_empleado($datos['cedula']);
            $this->load->view('validar_constancia/expired', $datos);
            return;
        }

        $datos['empleado'] = $this->user_model->get_nombre_empleado($datos['cedula']);
        $this->load->view('validar_constancia/valid', $datos);
    }
}