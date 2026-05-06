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