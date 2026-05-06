<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payroll_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_meses()
    {
        $q = "select MES, DMES, ANO from NOMINA.CONST_M_A order by ANO desc, MES desc";
        $query = $this->db->query($q);
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $aux = array();
                $aux[] = $row->DMES;
                $aux[] = $row->MES;
                $aux[] = $row->ANO;
                $data[] = $aux;
            }
        }
        return $data;
    }

    public function get_datos_pdf_nomina($cedula, $tipoper, $mes, $anio)
    {
        $q = "select a.CEDEMP, a.CODNOM, a.CODTIPNOM, to_char(c.FECHAINI,'mm/yyyy') as FECHAINI, b.CODDEP ";
        $q .= "from NOMINA.SITUAEMPNOM a, PERSONAL.EMPLEADOS b, NOMINA.NOMINA c ";
        $q .= "where a.CEDEMP=? ";
        $q .= "and a.CEDEMP=b.CEDEMP ";
        $q .= "and a.CODNOM=c.CODNOM ";
        $q .= "and a.CODTIPNOM=c.CODTIPNOM ";
        $q .= "and c.SITUACION='0' ";
        $q .= "and a.CODTIPNOM in (select CODTIPNOM from NOMINA.TIPONOMINA where CODTIPPER=? ) ";
        $q .= "and to_char(c.FECHAINI,'mm')=? ";
        $q .= "and to_char(c.FECHAINI,'yyyy')=? ";
        $q .= "and a.CODNOM not like 'P%' ";
        $q .= "order by a.CODTIPNOM, a.CODNOM ";

        $query = $this->db->query($q, array($cedula, $tipoper, $mes, $anio));
        $data = array();
        foreach ($query->result() as $row) {
            $data[] = array(
                'cedemp' => $row->CEDEMP,
                'codnom' => $row->CODNOM,
                'codtipnom' => $row->CODTIPNOM,
                'fechaini' => $row->FECHAINI,
                'coddep' => $row->CODDEP
            );
        }
        return $data;
    }

    public function get_detalles_nomina($codnom, $codtipnom)
    {
        $q = "select upper(a.DESTIPNOM) as DESTIPNOM, upper(b.DESNOM) as DESNOM, a.CODTIPFRE ";
        $q .= "from NOMINA.NOMINA b, NOMINA.TIPONOMINA a ";
        $q .= "where b.CODNOM =? ";
        $q .= "and a.CODTIPNOM =? ";
        $q .= "and a.CODTIPNOM = b.CODTIPNOM ";

        $query = $this->db->query($q, array($codnom, $codtipnom));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return array(
                'destipnom' => $row->DESTIPNOM,
                'desnom' => $row->DESNOM,
                'codtipfre' => $row->CODTIPFRE
            );
        }
        return array();
    }

    public function get_asignaciones($cedula, $codtipnom, $codnom)
    {
        $q = "select a.CODCON, b.DESCORTA, a.MONTO, a.CUOTA ";
        $q .= "from NOMINA.DETALLENOM a, NOMINA.CONCEPTOS b ";
        $q .= "where a.CEDEMP =? and a.CODTIPNOM =? and a.CODNOM =? ";
        $q .= "and b.CODTIPCON='1' and a.CODCON = b.CODCON order by CODCON";

        $query = $this->db->query($q, array($cedula, $codtipnom, $codnom));
        $data = array();
        foreach ($query->result() as $row) {
            $data[] = array(
                'codcon' => $row->CODCON,
                'descorta1' => $row->DESCORTA,
                'monto1' => $row->MONTO,
                'cuota1' => $row->CUOTA
            );
        }
        return $data;
    }

    public function get_deducciones($cedula, $codtipnom, $codnom)
    {
        $q = "select a.CODCON, b.DESCORTA, a.MONTO, a.CUOTA ";
        $q .= "from NOMINA.DETALLENOM a, NOMINA.CONCEPTOS b ";
        $q .= "where a.CEDEMP =? and a.CODTIPNOM =? and a.CODNOM =? ";
        $q .= "and b.CODTIPCON='0' and a.CODCON = b.CODCON order by CODCON";

        $query = $this->db->query($q, array($cedula, $codtipnom, $codnom));
        $data = array();
        foreach ($query->result() as $row) {
            $data[] = array(
                'codcon' => $row->CODCON,
                'descorta2' => $row->DESCORTA,
                'monto2' => $row->MONTO,
                'cuota2' => $row->CUOTA
            );
        }
        return $data;
    }

    public function get_dependencia($coddep)
    {
        $q = "select DESDEP, UBIDEP from PERSONAL.DEPENDENCIA where CODDEP=?";
        $query = $this->db->query($q, array($coddep));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return array(
                'desdep' => $row->DESDEP,
                'ubidep' => $row->UBIDEP
            );
        }
        return array('desdep' => '', 'ubidep' => '');
    }

    public function get_cargo_pdf($cedula, $codnom, $codtipnom, $tipoper)
    {
        if ($tipoper == '01') {
            $q = "select C.DESCAT as DES_CARGO ";
            $q .= "from NOMINA.SITUAEMPNOM A, PERSONAL.CATEGORIA C ";
            $q .= "where A.CEDEMP=? and A.CODNOM=? and A.CODTIPNOM=? and A.CARGCAT=C.CODCAT";
        } else {
            $q = "select C.DESCORTAMA as DES_CARGO ";
            $q .= "from NOMINA.SITUAEMPNOM A, PERSONAL.MANUCARGO C ";
            $q .= "where A.CEDEMP=? and A.CODNOM=? and A.CODTIPNOM=? and A.CARGCAT=C.CODMACAR";
        }

        $query = $this->db->query($q, array($cedula, $codnom, $codtipnom));
        if ($query->num_rows() > 0) {
            return array('des_cargo' => $query->row()->DES_CARGO);
        }
        return array('des_cargo' => '');
    }
    public function get_payroll_summary($cedula, $tipoper, $codnom, $codtipnom)
    {
        if (empty($codnom) || empty($codtipnom)) {
            return null;
        }

        $detalles = $this->get_detalles_nomina($codnom, $codtipnom);
        $desnom = isset($detalles['desnom']) ? $detalles['desnom'] : 'NÓMINA ACTUAL';

        $asignaciones = $this->get_asignaciones($cedula, $codtipnom, $codnom);
        $deducciones = $this->get_deducciones($cedula, $codtipnom, $codnom);

        $totalasig = 0;
        foreach ($asignaciones as $asig) {
            $totalasig += $asig['monto1'];
        }

        $totalded = 0;
        foreach ($deducciones as $ded) {
            $totalded += $ded['monto2'];
        }

        $neto = $totalasig - $totalded;
        $quincena1 = $neto / 2;
        $quincena2 = $neto - $quincena1;

        return array(
            'total_asignaciones' => $totalasig,
            'total_deducciones' => $totalded,
            'neto' => $neto,
            'quincena1' => $quincena1,
            'quincena2' => $quincena2,
            'codnom' => $codnom,
            'desnom' => $desnom
        );
    }
    public function get_last_nomina_info($cedula, $tipoper)
    {
        $q="select a.CODTIPNOM, a.CODNOM ";
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
            return $query->row_array();
        }
        return null;
    }
}
