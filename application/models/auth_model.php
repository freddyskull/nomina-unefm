<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login($usuario, $contra) 
    {
        $sql =" select a.NOMEMP, b.tipoper, b.pregunta2, b.respuesta2, a.cedemp, a.apeemp, a.sexoemp from NOMINA.CONSUSR b, PERSONAL.EMPLEADOS a ";
        $sql.=" WHERE b.cedemp = a.cedemp ";
        $sql.=" and b.USUARIO=? and b.CLAVE=? ";
        
        $query = $this->db->query($sql, array($usuario, $contra));

        if ($query->num_rows() == 1) {
            $row = $query->row();
            $data = array(
                'cedula' => $row->CEDEMP,
                'nombre' => $row->NOMEMP,
                'apellido' => $row->APEEMP,
                'sexo' => $row->SEXOEMP,
                'tipoper' => $row->TIPOPER,
                'pregunta2' => $row->PREGUNTA2,
                'logueado' => TRUE
            );
            $this->load->model('user_model');
            $summary = $this->user_model->get_summary($row->CEDEMP, $row->TIPOPER);
            $data['tipo_personal'] = $summary['tipo_personal'];
            $data['condicion'] = $summary['condicion'];

            $this->session->set_userdata($data);
            $this->obtener_datos_nomina($row->CEDEMP, $row->TIPOPER);
            return TRUE;
        }
        return FALSE;
    }

    private function obtener_datos_nomina($cedula, $tipoper)
    {
        $q="select a.codtipnom, a.codnom ";
        $q.=" FROM  NOMINA.SITUAEMPNOM a, NOMINA.NOMINA b ";
        $q.=" WHERE a.cedemp=? ";
        $q.=" AND a.codtipnom=b.codtipnom ";
        $q.=" and a.codnom=b.codnom ";
        $q.=" and a.codnom NOT LIKE 'B%' ";
        $q.=" AND a.codnom NOT LIKE 'I%' ";
        $q.=" AND a.codnom NOT LIKE 'H%' ";
        $q.=" AND a.codnom NOT LIKE 'P%' ";
        $q.=" and a.codtipnom not in ('23','24','25','26','27','28','29') and b.situacion='0' ";
        $q.=" and b.codtipnom in ( select codtipnom from NOMINA.TIPONOMINA where codtipper=?) ";
        $q.=" ORDER BY b.fechaini DESC"; 

        $query = $this->db->query($q, array($cedula, $tipoper));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata(array(
                'codtipnom' => $row->CODTIPNOM,
                'codnom' => $row->CODNOM
            ));
        }
    }

    public function consultausuario($cedula, $tipoper)
    {
        $this->db->where('CEDEMP', $cedula);
        $this->db->where('TIPOPER', $tipoper);
        $query = $this->db->get('NOMINA.CONSUSR');

        if ($query->num_rows() > 0) {
            return 'EXISTS';
        }

        $this->db->where('CEDEMP', $cedula);
        $query2 = $this->db->get('PERSONAL.EMPLEADOS');

        if ($query2->num_rows() > 0) {
            return $query2->result_array();
        }

        return 'NOT_FOUND';
    }
}
