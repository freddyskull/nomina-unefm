<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_datos_personal($cedula, $tipoper)
    {
        $q = "select e.DESTIPPER, a.TIPOPER, a.CEDEMP, a.NOMEMP, a.APEEMP, a.DIREMP, b.COND, b.CODTIPNOM, d.DESCOND ";
        $q .= "FROM PERSONAL.TIPOPER e, PERSONAL.EMPLEADOS a, NOMINA.SITUAEMPNOM b, NOMINA.TIPONOMINA c, PERSONAL.CONDICIONPER d ";
        $q .= "WHERE a.CEDEMP=? and c.CODTIPPER=? and b.CODNOM='-' and a.CEDEMP=b.CEDEMP and b.CODTIPNOM=c.CODTIPNOM ";
        $q .= "and c.CODTIPPER=a.TIPOPER and c.CODTIPPER=e.CODTIPPER and b.COND=d.CODCOND";
        
        $query = $this->db->query($q, array($cedula, $tipoper));
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $aux = array();
                $aux[] = $row->CEDEMP;
                $aux[] = $row->NOMEMP;
                $aux[] = $row->APEEMP;
                $aux[] = $row->DIREMP;
                $aux[] = $row->COND;
                $aux[] = $row->DESCOND;
                $aux[] = $row->DESTIPPER;
                $data[] = $aux;
            }
        }
        return $data;
    }

    public function get_carga_familiar($cedula)
    {
        $q = "select CEDPROFFAM, CEDFAM, NOMFAM, APEFAM, SEXOFAM, FECFAM, PARENFAM, VIVEFAM ";
        $q .= "from PERSONAL.CARGAFAMILIAR where CEDPROFFAM=? order by FECFAM";
        
        $query = $this->db->query($q, array($cedula));
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $aux = array();
                $aux[] = $row->CEDPROFFAM;
                $aux[] = $row->CEDFAM;
                $aux[] = $row->NOMFAM;
                $aux[] = $row->APEFAM;
                $aux[] = $row->SEXOFAM;
                $aux[] = $row->FECFAM;
                $aux[] = $row->PARENFAM;
                $aux[] = $row->VIVEFAM;
                $data[] = $aux;
            }
        }
        return $data;
    }

    public function get_empleado($cedula, $tipoper)
    {
        $q = "select a.CEDEMP, a.NOMEMP, a.APEEMP, a.DIREMP, a.TELEMP, b.CORREO, a.FECNACEMP, a.LUGNACEMP, a.PAISNACEMP, a.RIF ";
        $q .= "from PERSONAL.EMPLEADOS a, NOMINA.CONSUSR b ";
        $q .= "where b.CEDEMP = a.CEDEMP and a.CEDEMP=? and a.TIPOPER=?";
        
        $query = $this->db->query($q, array($cedula, $tipoper));
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $aux = array();
                $aux[] = $row->CEDEMP;
                $aux[] = $row->NOMEMP;
                $aux[] = $row->APEEMP;
                $aux[] = $row->DIREMP;
                $aux[] = $row->TELEMP;
                $aux[] = $row->CORREO;
                $aux[] = $row->FECNACEMP;
                $aux[] = $row->LUGNACEMP;
                $aux[] = $row->PAISNACEMP;
                $aux[] = $row->RIF;
                $data[] = $aux;
            }
        }
        return $data;
    }

    public function update_clave($cedula, $tipoper, $nueva_clave)
    {
        $this->db->where('CEDEMP', $cedula);
        $this->db->where('TIPOPER', $tipoper);
        return $this->db->update('NOMINA.CONSUSR', array('CLAVE' => $nueva_clave));
    }

    public function update_correo($cedula, $tipoper, $nuevo_correo)
    {
        $this->db->where('CEDEMP', $cedula);
        $this->db->where('TIPOPER', $tipoper);
        return $this->db->update('NOMINA.CONSUSR', array('CORREO' => $nuevo_correo));
    }

    public function get_preguntas_seguridad($cedula, $tipoper)
    {
        $this->db->select('PREGUNTA as pregunta, RESPUESTA as respuesta, PREGUNTA2 as pregunta2, RESPUESTA2 as respuesta2');
        $this->db->where('CEDEMP', $cedula);
        $this->db->where('TIPOPER', $tipoper);
        $query = $this->db->get('NOMINA.CONSUSR');
        return $query->row_array();
    }

    public function update_preguntas_seguridad($cedula, $tipoper, $data)
    {
        $this->db->where('CEDEMP', $cedula);
        $this->db->where('TIPOPER', $tipoper);
        return $this->db->update('NOMINA.CONSUSR', array(
            'PREGUNTA' => $data['pregunta'],
            'RESPUESTA' => $data['respuesta'],
            'PREGUNTA2' => $data['pregunta2'],
            'RESPUESTA2' => $data['respuesta2']
        ));
    }

    public function get_cargo_info($cedula, $tipoper)
    {
        if ($tipoper == '01') {
            $q = "SELECT b.DESDED, a.NUMHORA, a.CARGCAT, c.DESCAT, a.CODDED ";
            $q .= "FROM PERSONAL.DEDICACION b, NOMINA.SITUAEMPNOM a, PERSONAL.CATEGORIA c ";
            $q .= "WHERE a.CODNOM='-' AND a.CODDED=b.CODDED AND a.CEDEMP=? AND a.CARGCAT=c.CODCAT ";
            $q .= "AND a.CODTIPNOM IN (SELECT CODTIPNOM FROM NOMINA.TIPONOMINA WHERE CODTIPPER=?)";
        } else {
            $q = "SELECT a.NUMHORA, b.DESDED, a.CODDED, a.CARGCAT, c.DESCORTAMA ";
            $q .= "FROM PERSONAL.DEDICACION b, NOMINA.SITUAEMPNOM a, PERSONAL.MANUCARGO c ";
            $q .= "WHERE a.CODNOM='-' AND a.CODDED=b.CODDED AND a.CEDEMP=? AND a.CARGCAT=c.CODMACAR ";
            $q .= "AND a.CODTIPNOM IN (SELECT CODTIPNOM FROM NOMINA.TIPONOMINA WHERE CODTIPPER=?)";
        }

        $query = $this->db->query($q, array($cedula, $tipoper));
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $aux = array();
                $aux[] = $row->DESDED;
                $aux[] = $row->CODDED;
                $aux[] = ($tipoper == '01') ? $row->DESCAT : $row->DESCORTAMA;
                $aux[] = $row->NUMHORA;
                $data[] = $aux;
            }
        }
        return $data;
    }

    public function get_historial_laboral($cedula, $tipoper)
    {
        // Ingreso
        $q = "SELECT * FROM (SELECT TO_CHAR(fecautpro,'dd/mm/yyyy') as FECHAI ";
        $q .= "FROM personal.movimiento WHERE cedempmov=? AND codtipper=? AND codtipmov='01' ORDER BY fecautpro ASC) WHERE ROWNUM <= 1";
        $query = $this->db->query($q, array($cedula, $tipoper));
        
        $ingreso = '';
        if ($query->num_rows() > 0) {
            $ingreso = $query->row()->FECHAI;
        } else {
            $q = "SELECT * FROM (SELECT TO_CHAR(fecha,'dd/mm/yyyy') as FECHAI FROM nomina.sueldoprestacion ";
            $q .= "WHERE tipoper=? AND cedemp=? ORDER BY fecha) WHERE ROWNUM <= 1";
            $query = $this->db->query($q, array($tipoper, $cedula));
            if ($query->num_rows() > 0) {
                $ingreso = $query->row()->FECHAI;
            } else {
                $q = "SELECT * FROM (SELECT TO_CHAR(fecautpro, 'dd/mm/yyyy') as FECHAI FROM personal.movimiento WHERE cedempmov=? ";
                $q .= "AND codtipper=? AND (codcond='01' OR codcond='09' OR codcond='05') ";
                $q .= "AND (codtipmov ='02' OR codtipmov ='03' OR codtipmov ='21' OR codtipmov ='24') ORDER BY fecautpro) WHERE ROWNUM <= 1";
                $query = $this->db->query($q, array($cedula, $tipoper));
                if ($query->num_rows() > 0) {
                    $ingreso = $query->row()->FECHAI;
                }
            }
        }

        return array('ingreso' => $ingreso);
    }

    public function get_fecha_egreso($cedula, $tipoper)
    {
        $q = "SELECT TO_CHAR(fecautpro,'dd/mm/yyyy') as FECHAE FROM personal.movimiento ";
        $q .= "WHERE cedempmov=? AND codtipper=? AND (codtipmov='04' OR codtipmov='05' OR codtipmov='09' OR codtipmov='15' OR codtipmov='18') ";
        $q .= "ORDER BY fecautpro";
        $query = $this->db->query($q, array($cedula, $tipoper));
        
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = array($row->FECHAE);
            }
        }
        return $data;
    }

    public function get_contratos($cedula, $tipoper)
    {
        $q = "SELECT b.DESDEP, to_char(a.fecautpro,'dd/mm/yyyy') as fechaci, to_char(a.fecautdef,'dd/mm/yyyy') as fechacf, a.coddepmov, a.codcond ";
        $q .= "FROM personal.movimiento a, PERSONAL.DEPENDENCIA b ";
        $q .= "WHERE b.CODDEP=a.CODDEPMOV AND a.cedempmov =? AND a.codtipper=? ";
        $q .= "AND a.codtipmov in ('02','21','22','23','24','03') ORDER BY a.fecautpro";
        
        $query = $this->db->query($q, array($cedula, $tipoper));
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = array($row->FECHACI, $row->FECHACF, $row->CODDEPMOV, $row->CODCOND, $row->DESDEP);
            }
        }
        return $data;
    }

    public function get_sueldo_basico($cedula, $codtipnom, $codnom)
    {
        $q = "SELECT SUM(monto) as monto FROM nomina.detallenom a, nomina.conceptos b ";
        $q .= "WHERE a.codtipnom=? AND a.codnom=? AND a.codcon=b.codcon AND b.codtipcon='1' ";
        $q .= "AND a.cedemp=? AND a.codcon in ('001','002','026','029','042','043')";
        
        $query = $this->db->query($q, array($codtipnom, $codnom, $cedula));
        $monto = 0;
        if ($query->num_rows() > 0 && $query->row()->MONTO > 0) {
            $monto = $query->row()->MONTO;
        } else {
            // Fallback: Last known basico from ANY recent nomina
            $q3 = "SELECT monto FROM (SELECT monto FROM nomina.detallenom WHERE cedemp=? AND codcon='001' AND monto>0 ORDER BY codnom DESC) WHERE ROWNUM=1";
            $query3 = $this->db->query($q3, array($cedula));
            if ($query3->num_rows() > 0) {
                $monto = $query3->row()->MONTO;
            }
        }
        return array(array($monto));
    }

    public function get_sueldo_integral($cedula, $codtipnom, $codnom)
    {
        $q = "SELECT SUM(monto) as monto FROM nomina.detallenom a, nomina.conceptos b ";
        $q .= "WHERE a.codtipnom=? AND a.codnom=? AND a.codcon=b.codcon AND b.codtipcon='1' ";
        $q .= "AND a.cedemp=? AND (a.codcon in (SELECT codcon1 FROM nomina.conceptocon WHERE codcon='494') OR b.codcon='494')";
        
        $query = $this->db->query($q, array($codtipnom, $codnom, $cedula));
        $monto = 0;
        if ($query->num_rows() > 0 && $query->row()->MONTO > 0) {
            $monto = $query->row()->MONTO;
        } else {
            // Fallback 1: Total assignments for this period
            $q2 = "SELECT SUM(monto) as monto FROM nomina.detallenom a, nomina.conceptos b ";
            $q2 .= "WHERE a.codtipnom=? AND a.codnom=? AND a.cedemp=? AND a.codcon=b.codcon AND b.codtipcon='1'";
            $query2 = $this->db->query($q2, array($codtipnom, $codnom, $cedula));
            if ($query2->num_rows() > 0 && $query2->row()->MONTO > 0) {
                $monto = $query2->row()->MONTO;
            } else {
                // Fallback 2: Last known integral from ANY recent nomina
                $q3 = "SELECT SUM(monto) as monto FROM (SELECT SUM(monto) as monto, codnom FROM nomina.detallenom a, nomina.conceptos b WHERE a.cedemp=? AND a.codcon=b.codcon AND b.codtipcon='1' GROUP BY codnom ORDER BY codnom DESC) WHERE ROWNUM=1";
                $query3 = $this->db->query($q3, array($cedula));
                if ($query3->num_rows() > 0) {
                    $monto = $query3->row()->MONTO;
                }
            }
        }
        return array(array($monto));
    }

    public function get_cuota($cedula, $codtipnom, $codnom)
    {
        $q = "SELECT a.cuota FROM nomina.detallenom a, nomina.conceptos b ";
        $q .= "WHERE a.codtipnom=? AND a.codnom=? AND a.codcon=b.codcon AND b.codtipcon='1' ";
        $q .= "AND a.cedemp=? AND a.codcon='001' AND a.cuota IS NOT NULL";
        
        $query = $this->db->query($q, array($codtipnom, $codnom, $cedula));
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = array($row->CUOTA);
            }
        }
        return $data;
    }

    public function get_frecuencia($codtipnom)
    {
        $q = "SELECT codtipfre FROM NOMINA.tiponomina WHERE codtipnom =?";
        $query = $this->db->query($q, array($codtipnom));
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = array($row->CODTIPFRE);
            }
        } else {
            // Default to Mensual (02) if not found
            $data[] = array('02');
        }
        return $data;
    }

    public function get_codigos_homologacion($codtipnom, $codnom)
    {
        $and = '';
        if ($codtipnom == '04') {
            $and = " AND codnom != 'H1106'";
        }

        $q = "SELECT DISTINCT(codnom) FROM nomina.detnombase ";
        $q .= "WHERE codtipnom=? AND codnomb=? AND codnom LIKE 'H%' ";
        $q .= "AND concat(codtipnom,codnom) in (SELECT concat(codtipnom,codnom) FROM nomina.nomina WHERE situacion='0') " . $and;

        $query = $this->db->query($q, array($codtipnom, $codnom));
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = array($row->CODNOM);
            }
        } else {
            $data[] = array(' ');
        }
        return $data;
    }

    public function get_homologaciones_integral($cedula, $codtipnom, $codnom_hom_list)
    {
        $data = array();
        foreach ($codnom_hom_list as $cod_arr) {
            $codh = $cod_arr[0];
            if ($codh == ' ') {
                $data[] = array(0);
                continue;
            }

            $q = "SELECT SUM(monto) as monto FROM nomina.detallenom a, nomina.conceptos b ";
            $q .= "WHERE a.codtipnom=? AND a.codnom=? AND a.cedemp=? AND a.codcon=b.codcon ";
            $q .= "AND b.codtipcon='1' AND a.codcon in (SELECT codcon1 FROM nomina.conceptocon WHERE codcon='494')";
            
            $query = $this->db->query($q, array($codtipnom, $codh, $cedula));
            if ($query->num_rows() > 0) {
                $data[] = array($query->row()->MONTO);
            } else {
                $data[] = array(0);
            }
        }
        return $data;
    }

    public function get_homologaciones_basico($cedula, $codtipnom, $codnom_hom_list)
    {
        $data = array();
        foreach ($codnom_hom_list as $cod_arr) {
            $codh = $cod_arr[0];
            if ($codh == ' ') {
                $data[] = array(0);
                continue;
            }

            $q = "SELECT SUM(monto) as monto FROM nomina.detallenom a, nomina.conceptos b ";
            $q .= "WHERE a.codtipnom=? AND a.codnom=? AND a.codcon=b.codcon AND b.codtipcon='1' ";
            $q .= "AND a.cedemp=? AND a.codcon in ('001','002','026','029','042','043')";
            
            $query = $this->db->query($q, array($codtipnom, $codh, $cedula));
            if ($query->num_rows() > 0) {
                $data[] = array($query->row()->MONTO);
            } else {
                $data[] = array(0);
            }
        }
        return $data;
    }
    public function get_summary($cedula, $tipoper)
    {
        $q = "select e.DESTIPPER, d.DESCOND ";
        $q .= "FROM PERSONAL.TIPOPER e, NOMINA.SITUAEMPNOM b, NOMINA.TIPONOMINA c, PERSONAL.CONDICIONPER d ";
        $q .= "WHERE b.CEDEMP=? and c.CODTIPPER=? and b.CODNOM='-' and b.CODTIPNOM=c.CODTIPNOM ";
        $q .= "and c.CODTIPPER=e.CODTIPPER and b.COND=d.CODCOND";
        
        $query = $this->db->query($q, array($cedula, $tipoper));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return array(
                'tipo_personal' => $row->DESTIPPER,
                'condicion' => $row->DESCOND
            );
        }
        return array('tipo_personal' => 'PERSONAL', 'condicion' => '');
    }
}
