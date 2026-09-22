<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payroll extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'mihelper'));
        $this->load->library('session');
        $this->load->model(array('payroll_model', 'user_model'));

        if (!$this->session->userdata('logueado')) {
            $this->session->set_flashdata('mensaje', 'No has iniciado sesión');
            redirect('auth');
        }
    }

    public function nominas()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');
        $data['meses'] = $this->payroll_model->get_meses();

        $this->load->view('templates/header', $data);
        $this->load->view('payroll/nominas', $data);
        $this->load->view('templates/footer');
    }

    public function pdf_nomina()
    {
        $this->load->model('pdf/nominapdf');
        $mes = $this->input->post('meses');

        if (empty($mes)) {
            $this->session->set_flashdata('mensaje', 'Selecciona el Mes');
            redirect('payroll/nominas'); 
        }

        $anio = date('Y'); 
        $cedula = $this->session->userdata('cedula');
        $tipoper = $this->session->userdata('tipoper');

        $datos_princ_list = $this->payroll_model->get_datos_pdf_nomina($cedula, $tipoper, $mes, $anio);
        
        if (empty($datos_princ_list)) {
            $this->session->set_flashdata('mensaje', 'No hay datos de nómina para el periodo seleccionado.');
            redirect('payroll/nominas');
        }

        $datos_cont = array();
        foreach ($datos_princ_list as $row) {
            $cod = $row['codnom'];
            $ctn = $row['codtipnom'];
            
            // Build the specific structure expected by Nominapdf
            $item = $this->payroll_model->get_detalles_nomina($cod, $ctn);
            
            // Personal data with specific keys
            $item['datosprinc'] = array(
                'cedula' => $row['cedemp'],
                'nombre' => $this->session->userdata('nombre'),
                'apellido' => $this->session->userdata('apellido'),
                'codnom' => $cod
            );
            
            // Cargo and Dependencia
            $item['cargo'] = $this->payroll_model->get_cargo_pdf($cedula, $cod, $ctn, $tipoper);
            $item['dependencia'] = $this->payroll_model->get_dependencia($row['coddep']);
            
            // Asignaciones and Deducciones with legacy keys
            $item['asignaciones'] = $this->payroll_model->get_asignaciones($cedula, $ctn, $cod);
            $item['deducciones'] = $this->payroll_model->get_deducciones($cedula, $ctn, $cod);
            
            $datos_cont[$cod] = $item;
        }

        $this->nominapdf->imprimir($anio, $mes, $datos_cont);
    }

    public function constancias()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');
        $data['datosper'] = $this->user_model->get_datos_personal($this->session->userdata('cedula'), $this->session->userdata('tipoper'));

        $cedula = $this->session->userdata('cedula');
        $codtipnom = $this->session->userdata('codtipnom');
        if (empty($codtipnom)) {
            $last_nomina = $this->payroll_model->get_last_nomina_info($cedula, $this->session->userdata('tipoper'));
            if ($last_nomina) {
                $codtipnom = $last_nomina['CODTIPNOM'];
            }
        }
        $data['inactivo'] = $this->user_model->empleado_inactivo($cedula, $codtipnom);

        $this->load->view('templates/header', $data);
        $this->load->view('payroll/constancias', $data);
        $this->load->view('templates/footer');
    }

    public function pdf_constancia()
    {
        $this->load->model('pdf/constanciapdf');
        $sueldo_tipo = $this->input->post('sueldo');
        $cesta_ticket = $this->input->post('ces');

        if (empty($sueldo_tipo) || empty($cesta_ticket)) {
            $this->session->set_flashdata('mensaje', 'Selecciona el tipo de sueldo y cesta ticket.');
            redirect('payroll/constancias');
        }

        $cedula = $this->session->userdata('cedula');
        $tipoper = $this->session->userdata('tipoper');
        $codnom = $this->session->userdata('codnom');
        $codtipnom = $this->session->userdata('codtipnom');

        // Fallback if session doesn't have codnom (e.g. session started before modernization)
        if (empty($codnom) || empty($codtipnom)) {
            $last_nomina = $this->payroll_model->get_last_nomina_info($cedula, $tipoper);
            if ($last_nomina) {
                $codnom = $last_nomina['CODNOM'];
                $codtipnom = $last_nomina['CODTIPNOM'];
                // Update session for future calls
                $this->session->set_userdata(array('codnom' => $codnom, 'codtipnom' => $codtipnom));
            } else {
                $this->session->set_flashdata('mensaje', 'No se encontró historial de nómina para generar el sueldo.');
                redirect('payroll/constancias');
            }
        }

        // Bloquear emisión si el personal está inactivo en nómina
        if ($this->user_model->empleado_inactivo($cedula, $codtipnom)) {
            redirect('payroll/constancias');
        }

        // Código QR para validación de la constancia (válida 3 meses desde su emisión)
        $this->load->helper('mihelper');
        $qrcode_url = site_url('validar_constancia/index/' . constancia_token($cedula));

        // Gather all data required by Constanciapdf::imprimir
        $datosper = $this->user_model->get_datos_personal($cedula, $tipoper);
        $cargos = $this->user_model->get_cargo_info($cedula, $tipoper);
        $historial = $this->user_model->get_historial_laboral($cedula, $tipoper);
        $fechaini = array(array($historial['ingreso']));
        $fechaegre = $this->user_model->get_fecha_egreso($cedula, $tipoper);
        $fechacon = $this->user_model->get_contratos($cedula, $tipoper);
        
        $monto = $this->user_model->get_sueldo_integral($cedula, $codtipnom, $codnom);
        $sub = $this->user_model->get_sueldo_basico($cedula, $codtipnom, $codnom);
        $cuota = $this->user_model->get_cuota($cedula, $codtipnom, $codnom);
        $tf = $this->user_model->get_frecuencia($codtipnom);
        
        $cod_hom = $this->user_model->get_codigos_homologacion($codtipnom, $codnom);
        $monto2 = $this->user_model->get_homologaciones_integral($cedula, $codtipnom, $cod_hom);
        $monto3 = $this->user_model->get_homologaciones_basico($cedula, $codtipnom, $cod_hom);

        $this->constanciapdf->imprimir(
            $tipoper,
            $datosper,
            $cargos,
            $fechaini,
            $fechaegre,
            $sueldo_tipo,
            $cesta_ticket,
            $fechacon,
            $monto,
            $cuota,
            $tf,
            $sub,
            $monto2,
            $monto3,
            $qrcode_url
        );
    }
    public function arc()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');
        $data['cedula'] = $this->session->userdata('cedula');
        $data['tipoper'] = $this->session->userdata('tipoper');

        $this->load->view('templates/header', $data);
        $this->load->view('payroll/arc', $data);
        $this->load->view('templates/footer');
    }

    public function adelanto_prestaciones()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');

        $this->load->view('templates/header', $data);
        $this->load->view('payroll/adelanto_prestaciones', $data);
        $this->load->view('templates/footer');
    }

    public function iiiccu()
    {
        $data['sesion'] = $this->session->userdata('nombre');
        $data['sexo'] = $this->session->userdata('sexo');
        $data['cedula'] = $this->session->userdata('cedula');
        $data['tipoper'] = $this->session->userdata('tipoper');

        $this->load->view('templates/header', $data);
        $this->load->view('payroll/iiiccu', $data);
        $this->load->view('templates/footer');
    }
}
