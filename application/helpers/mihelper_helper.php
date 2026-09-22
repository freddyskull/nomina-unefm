<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
//si no existe la función invierte_date_time la creamos
if(!function_exists('nombrefamiliar'))
{

 function nombrefamiliar($cedula)
 {
        //asignamos a $ci el super objeto de codeigniter
 //$ci será como $this
 
 $ci =& get_instance();
 $n = $ci->registro_model->nombrefamiliar($cedula);
 return $n;
 //return "hola";
 
 }

}

//si el empleado está inactivo en nómina
if(!function_exists('empleado_inactivo'))
{
    function empleado_inactivo($cedula, $codtipnom)
    {
        if (empty($cedula) || empty($codtipnom)) {
            return FALSE;
        }

        $ci =& get_instance();
        $ci->load->model('user_model');
        return $ci->user_model->empleado_inactivo($cedula, $codtipnom);
    }

}

//genera el token firmado de validación para una constancia de trabajo
if(!function_exists('constancia_token'))
{
    function constancia_token($cedula)
    {
        $ci =& get_instance();
        $secret = $ci->config->item('encryption_key');
        $fecha = date('Ymd');
        $datos = $cedula . '.' . $fecha;
        $sig = substr(hash_hmac('sha256', $datos, $secret), 0, 16);
        return $datos . '.' . $sig;
    }

}

//verifica un token de constancia: valida firma y expiración (3 meses)
if(!function_exists('constancia_verificar'))
{
    function constancia_verificar($token)
    {
        if (empty($token) || substr_count($token, '.') !== 2) {
            return FALSE;
        }

        list($cedula, $fecha, $sig) = explode('.', $token);
        if (empty($cedula) || !preg_match('/^\d{8}$/', $fecha) || !preg_match('/^[A-Za-z0-9]{4,12}$/', $cedula)) {
            return FALSE;
        }

        $ci =& get_instance();
        $secret = $ci->config->item('encryption_key');
        $esperado = substr(hash_hmac('sha256', $cedula . '.' . $fecha, $secret), 0, 16);
        if (!hash_equals($esperado, $sig)) {
            return FALSE;
        }

        $emision = DateTime::createFromFormat('Ymd', $fecha);
        if (!$emision) {
            return FALSE;
        }

        $expiracion = clone $emision;
        $expiracion->modify('+3 months');

        $hoy = new DateTime();
        $diff = $hoy->diff($expiracion);
        $dias_restantes = $diff->invert ? -$diff->days : $diff->days;

        return array(
            'cedula' => $cedula,
            'emision' => $emision->format('d/m/Y'),
            'expiracion' => $expiracion->format('d/m/Y'),
            'expirada' => $hoy > $expiracion,
            'dias_restantes' => (int) $dias_restantes
        );
    }

}