<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_integracion_util extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function write_log($error){
        $aux;
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_ESCRIBIR_LOG(:P_TIPO,:P_USUARIO ,:P_PROCEDIMIENTO, :P_ERROR ); END;" );
        oci_bind_by_name($sp, ":P_TIPO"          ,   $error['tipo_error']);
        oci_bind_by_name($sp, ":P_USUARIO"       ,   $error['user_id']);
        oci_bind_by_name($sp, ":P_PROCEDIMIENTO" ,   $error['procedimiento']);
        oci_bind_by_name($sp, ":P_ERROR"         ,   $error['error']);
        oci_execute($sp, OCI_DEFAULT);
        return true;
    }

}