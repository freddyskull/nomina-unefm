<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medical_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_familiares_fondo($cedula)
    {
        $this->db->where('CEDEMP', $cedula);
        $query = $this->db->get('NOMINA.FONDO_MUT_FAMILIARES');
        return $query->result_array();
    }

    public function get_medicinas()
    {
        $query = $this->db->get('NOMINA.FONDO_MUT_CAT_MEDICINA');
        return $query->result_array();
    }

    public function get_censo_medicina($cedula, $tipoper)
    {
        $this->db->where('CEDEMP', $cedula);
        $this->db->where('TIPOPER', $tipoper);
        $query = $this->db->get('NOMINA.FONDO_MUT_CENSO_MEDICINA');
        return $query->result_array();
    }

    public function add_censo_medicina($cedula, $tipoper, $cedula_fam, $codmed)
    {
        $sql="SELECT * FROM NOMINA.FONDO_MUT_CENSO_MEDICINA where CEDEMP=? and TIPOPER=? and CEDFAM=? and CODMED=? ";
        $query = $this->db->query($sql, array($cedula, $tipoper, $cedula_fam, $codmed));

        if ($query->num_rows() > 0) {
            return 'EXISTS';
        }

        $data = array(
            'TIPOPER' => $tipoper,
            'CEDEMP' => $cedula,
            'CEDFAM' => $cedula_fam,
            'CODMED' => $codmed
        );
        return $this->db->insert('NOMINA.FONDO_MUT_CENSO_MEDICINA', $data);
    }

    public function delete_censo_medicina($cedula, $tipoper, $cedula_fam, $codmed)
    {
        $this->db->where('CEDEMP', $cedula);
        $this->db->where('TIPOPER', $tipoper);
        $this->db->where('CEDFAM', $cedula_fam);
        $this->db->where('CODMED', $codmed);
        return $this->db->delete('NOMINA.FONDO_MUT_CENSO_MEDICINA');
    }
}
