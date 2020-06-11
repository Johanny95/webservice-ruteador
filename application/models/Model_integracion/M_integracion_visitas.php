<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_integracion_visitas extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_visitas($elemento){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_INTEGRACION_RUTEADOR","SP_GET_VISITAS_CREACION", array
            (
                array('name' => ':V_OPERACION'      ,'value'  => $elemento['operacion']     ,    'type' => SQLT_CHR        ,'length' => -1),
                array('name' => ':V_FECHA_JORNADA'  ,'value'  => $elemento['fecha_jornada'] ,    'type' => SQLT_CHR        ,'length' => -1),
                array('name' => ':V_OFICINA_ID'     ,'value'  => $elemento['oficina_id']    ,    'type' => SQLT_CHR        ,'length' => -1),
                array('name' => ':P_CURSOR'         ,'value'  => $curs                      ,    'type' => OCI_B_CURSOR    ,'length' => -1)
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




    public function add_id_ruteador($visit){

        $aux;
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_ADD_ID_RUTEADOR(:V_CLICODIGO,:V_OFICINA_ID,:V_FECHA_PEDIDO,:V_FECHA_FACTURA,:V_OPERACION,:V_ID_RUTEADOR,:V_ESTADO_PROCESO); END;" );
        oci_bind_by_name($sp, ":V_CLICODIGO"      ,   $visit['clicodigo']);
        oci_bind_by_name($sp, ":V_OFICINA_ID"     ,   $visit['oficina_id']);
        oci_bind_by_name($sp, ":V_FECHA_PEDIDO"   ,   $visit['fecha_pedido']);
        oci_bind_by_name($sp, ":V_FECHA_FACTURA"  ,   $visit['fecha_factura']);
        oci_bind_by_name($sp, ":V_OPERACION"      ,   $visit['operacion']);
        oci_bind_by_name($sp, ":V_ID_RUTEADOR"    ,   $visit['id_ruteador']);
        //estado del proceso
        oci_bind_by_name($sp, ":V_ESTADO_PROCESO"             ,   $aux);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  (!empty($aux[0])) ? $aux[0] : 0;
        return $estado; 
    }

    public function get_visitas_upd($elemento){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_INTEGRACION_RUTEADOR","SP_GET_VISITAS_UPDATE", array
            (
                array('name' => ':V_OPERACION'      ,'value'  => $elemento['operacion']     ,    'type' => SQLT_CHR        ,'length' => -1),
                array('name' => ':V_FECHA_JORNADA'  ,'value'  => $elemento['fecha_jornada'] ,    'type' => SQLT_CHR        ,'length' => -1),
                array('name' => ':V_OFICINA_ID'     ,'value'  => $elemento['oficina_id']    ,    'type' => SQLT_CHR        ,'length' => -1),
                array('name' => ':P_CURSOR'         ,'value'  => $curs                      ,    'type' => OCI_B_CURSOR    ,'length' => -1)
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

    public function set_estado_actualizacion($visit){
        $aux;
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_SET_ESTADO_UPDATE(:V_CLICODIGO,:V_OFICINA_ID,:V_FECHA_PEDIDO,:V_FECHA_FACTURA,:V_OPERACION,:V_ID_RUTEADOR,:V_ID_CLIENTE,:V_ESTADO_PROCESO); END;" );
        oci_bind_by_name($sp, ":V_CLICODIGO"      ,   $visit['clicodigo']);
        oci_bind_by_name($sp, ":V_OFICINA_ID"     ,   $visit['oficina_id']);
        oci_bind_by_name($sp, ":V_FECHA_PEDIDO"   ,   $visit['fecha_pedido']);
        oci_bind_by_name($sp, ":V_FECHA_FACTURA"  ,   $visit['fecha_factura']);
        oci_bind_by_name($sp, ":V_OPERACION"      ,   $visit['operacion']);
        oci_bind_by_name($sp, ":V_ID_RUTEADOR"    ,   $visit['id_ruteador']);
        oci_bind_by_name($sp, ":V_ID_CLIENTE"     ,   $visit['id_cliente']);
        
        //estado del proceso
        oci_bind_by_name($sp, ":V_ESTADO_PROCESO"             ,   $aux);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  (!empty($aux[0])) ? $aux[0] : 0;
        return $estado; 
    }


    public function get_visitas_del($elemento){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_INTEGRACION_RUTEADOR","SP_GET_VISITAS_DELETE", array
            (
                array('name' => ':V_OPERACION'      ,'value'  => $elemento['operacion']     ,    'type' => SQLT_CHR        ,'length' => -1),
                array('name' => ':V_FECHA_JORNADA'  ,'value'  => $elemento['fecha_jornada'] ,    'type' => SQLT_CHR        ,'length' => -1),
                array('name' => ':V_OFICINA_ID'     ,'value'  => $elemento['oficina_id']    ,    'type' => SQLT_CHR        ,'length' => -1),
                array('name' => ':P_CURSOR'         ,'value'  => $curs                      ,    'type' => OCI_B_CURSOR    ,'length' => -1)
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


    public function confirmar_eliminacion($visit){
        $aux;
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_SET_ESTADO_DELETE(:V_CLICODIGO,:V_OFICINA_ID,:V_FECHA_PEDIDO,:V_FECHA_FACTURA,:V_OPERACION,:V_ID_RUTEADOR,:V_ID_CLIENTE,:V_ESTADO_PROCESO); END;" );
        oci_bind_by_name($sp, ":V_CLICODIGO"      ,   $visit['clicodigo']);
        oci_bind_by_name($sp, ":V_OFICINA_ID"     ,   $visit['oficina_id']);
        oci_bind_by_name($sp, ":V_FECHA_PEDIDO"   ,   $visit['fecha_pedido']);
        oci_bind_by_name($sp, ":V_FECHA_FACTURA"  ,   $visit['fecha_factura']);
        oci_bind_by_name($sp, ":V_OPERACION"      ,   $visit['operacion']);
        oci_bind_by_name($sp, ":V_ID_RUTEADOR"    ,   $visit['id_ruteador']);
        oci_bind_by_name($sp, ":V_ID_CLIENTE"     ,   $visit['id_cliente']);
        
        //estado del proceso
        oci_bind_by_name($sp, ":V_ESTADO_PROCESO" ,   $aux);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  (!empty($aux[0])) ? $aux[0] : 0;
        return $estado; 
    }


    public function get_estado_integracion($operacion){
        $aux;
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_GET_ESTADO_INTEGREACION(:V_OPERACION,:V_FECHA_OPERACION,:V_FECHA_FACTURA,:V_OFICINA_ID,:V_ESTADO_PROCESO); END;" );
        oci_bind_by_name($sp, ":V_OPERACION"        ,   $operacion->CODIGO);
        oci_bind_by_name($sp, ":V_FECHA_OPERACION"  ,   $operacion->FECHA_PROCESO);
        oci_bind_by_name($sp, ":V_FECHA_FACTURA"    ,   $operacion->FECHA_FACTURAR);
        oci_bind_by_name($sp, ":V_OFICINA_ID"       ,   $operacion->OFICODIGO);
        oci_bind_by_name($sp, ":V_ESTADO_PROCESO"   ,   $aux);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  $aux[0];
        return $estado;
        /*PROCEDIMIENTO RETORNA 1 CUANDO SE PUEDE INTEGRAR Y 0 CUANDO SE ENCUENTRA PROCESANDO OTRO PROCEDIMIENTO*/
    }

    public function cierre_proceso_intgracion($operacion){
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_CERRAR_INTEGRACION(:V_OPERACION,:V_FECHA_OPERACION,:V_FECHA_FACTURA,:V_OFICINA_ID,:V_ESTADO_PROCESO); END;" );
        oci_bind_by_name($sp, ":V_OPERACION"        ,   $operacion->CODIGO);
        oci_bind_by_name($sp, ":V_FECHA_OPERACION"  ,   $operacion->FECHA_PROCESO);
        oci_bind_by_name($sp, ":V_FECHA_FACTURA"    ,   $operacion->FECHA_FACTURAR);
        oci_bind_by_name($sp, ":V_OFICINA_ID"       ,   $operacion->OFICODIGO);
        oci_bind_by_name($sp, ":V_ESTADO_PROCESO"   ,   $aux);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  (!empty($aux[0])) ? $aux[0] : 0;
        return $estado; 
    }

    

}
