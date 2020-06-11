<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_integracion_camion extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_camiones(){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_INTEGRACION_RUTEADOR","GET_CAMIONES_INTEGRACION", array
            (
                array('name' => ':P_CURSOR','value' => $curs,'type' => OCI_B_CURSOR,'length' => -1)
            )
        );
        oci_execute($curs);
        $data = array();
        while (($row = oci_fetch_object($curs)) != false) {
            $data[] = $row; 
        }
        oci_free_statement($curs);
        $result = $data;
        return $result; 		
    }

    public function set_envio_camion($camion){
        // PF_WEBSERVICE_UNIGIS.SET_ENVIO_CAMIONES 
        echo var_dump($camion);
        $aux = array();
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SET_ENVIO_CAMIONES(:V_CODCAMION,:V_OFICINA_ID,:V_ID_RUTEADOR, :V_ESTADO); END;" );
        oci_bind_by_name($sp, ":V_CODCAMION"                       ,   $camion['CODCAMION']);
        oci_bind_by_name($sp, ":V_OFICINA_ID"                      ,   $camion['V_OFICINA_ID']);
        oci_bind_by_name($sp, ":V_ID_RUTEADOR"                     ,   $camion['ID_RUTEADOR']);
        oci_bind_by_name($sp, ":V_ESTADO"                          ,   $aux[]);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  (!empty($aux[0])) ? $aux[0] : 0;
        return $estado; 
    }

    public function get_upd_camiones(){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_INTEGRACION_RUTEADOR","GET_CAMIONES_UPD", array
            (
                array('name' => ':P_CURSOR','value' => $curs,'type' => OCI_B_CURSOR,'length' => -1)
            )
        );
        oci_execute($curs);
        $data = array();
        while (($row = oci_fetch_object($curs)) != false) {
            $data[] = $row; 
        }
        oci_free_statement($curs);
        $result = $data;
        return $result;
    }

    public function get_del_camiones(){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_INTEGRACION_RUTEADOR","GET_CAMIONES_DEL", array
            (
                array('name' => ':P_CURSOR','value' => $curs,'type' => OCI_B_CURSOR,'length' => -1)
            )
        );
        oci_execute($curs);
        $data = array();
        while (($row = oci_fetch_object($curs)) != false) {
            $data[] = $row; 
        }
        oci_free_statement($curs);
        $result = $data;
        return $result;
    }




}