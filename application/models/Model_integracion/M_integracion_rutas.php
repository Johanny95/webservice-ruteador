<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_integracion_rutas extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_operaciones(){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_INTEGRACION_RUTEADOR","GET_OPERACIONES_TOKEN", array
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


    public function get_secuencia_plan(){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_INTEGRACION_RUTEADOR","GET_SECUENCIA_PLAN", array
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


    public function add_ruta($ruta){
        $aux;
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_ADD_RUTA(:V_ID_RUTA,:V_SECUENCIA_PLAN,:V_FECHA_JORNADA,:V_OPERACION,:V_OFICINA_ID,:V_HORA_INICIO,:V_HORA_FIN,:V_TIEMPO_DURACION,:V_ID_VEHICULO,:V_PATENTE,:V_CODIGO_CHOFER,:V_CHOFER,:V_SUBCAMION,:V_PESO,:V_VOLUMEN,:V_BULTOS,:V_DISTANCIA,:V_PORCENTAJE_CARGA,:V_ESTADO); END;" );
        oci_bind_by_name($sp, ":V_ID_RUTA"            ,   $ruta['id_ruta']);
        oci_bind_by_name($sp, ":V_SECUENCIA_PLAN"     ,   $ruta['secuencia_plan']);
        oci_bind_by_name($sp, ":V_FECHA_JORNADA"      ,   $ruta['fecha_plan']);
        oci_bind_by_name($sp, ":V_OPERACION"          ,   $ruta['operacion']);
        oci_bind_by_name($sp, ":V_OFICINA_ID"         ,   $ruta['oficina_id']);
        oci_bind_by_name($sp, ":V_HORA_INICIO"        ,   $ruta['hora_inicio']);
        oci_bind_by_name($sp, ":V_HORA_FIN"           ,   $ruta['hora_fin']);
        oci_bind_by_name($sp, ":V_TIEMPO_DURACION"    ,   $ruta['duracion']);
        oci_bind_by_name($sp, ":V_ID_VEHICULO"        ,   $ruta['vehicle']);
        oci_bind_by_name($sp, ":V_PATENTE"            ,   $ruta['patente']);
        oci_bind_by_name($sp, ":V_CODIGO_CHOFER"      ,   $ruta['chofer']);
        oci_bind_by_name($sp, ":V_CHOFER"             ,   $ruta['rut_chofer']);
        oci_bind_by_name($sp, ":V_SUBCAMION"          ,   $ruta['comentario']);
        oci_bind_by_name($sp, ":V_PESO"               ,   $ruta['carga']);
        oci_bind_by_name($sp, ":V_VOLUMEN"            ,   $ruta['volumen']);
        oci_bind_by_name($sp, ":V_BULTOS"             ,   $ruta['bultos']);
        oci_bind_by_name($sp, ":V_DISTANCIA"          ,   $ruta['distancia']);
        oci_bind_by_name($sp, ":V_PORCENTAJE_CARGA"   ,   $ruta['carga_porcentaje']);
        //estado del proceso
        oci_bind_by_name($sp, ":V_ESTADO"             ,   $aux);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  (!empty($aux[0])) ? $aux[0] : 0;
        return $estado; 
    }


    public function add_clientes_det($ruta){
        $aux;
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_ADD_CLIENTES_RUTA(:V_CLICODIGO,:V_ORDEN_ENTREGA,:V_OPERACION,:V_OFICINA_ID,:V_FECHA_JORNADA,:V_FECHA_FACTURA,:V_CODIGO_RUTA,:V_SUBCAMION,:V_TRAKING_ID,:V_CLIENTE,:V_DIRECCION,:V_LONGITUD,:V_LATITUD,:V_KILOS,:V_VOLUMEN,:V_BULTOS,:V_TIEMPO_ESPERA,:V_HORA_ARRIVO,:V_HORA_SALIDA,:V_FECHA_CREACION_R,:V_ESTADO); END;" );


        oci_bind_by_name($sp, ":V_CLICODIGO"          ,   $ruta['clicodigo']);
        oci_bind_by_name($sp, ":V_ORDEN_ENTREGA"      ,   $ruta['orden']);
        oci_bind_by_name($sp, ":V_OPERACION"          ,   $ruta['operacion']);
        oci_bind_by_name($sp, ":V_OFICINA_ID"         ,   $ruta['oficina_id']);
        oci_bind_by_name($sp, ":V_FECHA_JORNADA"      ,   $ruta['fecha_jornada']);
        oci_bind_by_name($sp, ":V_FECHA_FACTURA"      ,   $ruta['fecha_factura']);
        oci_bind_by_name($sp, ":V_CODIGO_RUTA"        ,   $ruta['ruta']);
        oci_bind_by_name($sp, ":V_SUBCAMION"          ,   $ruta['subcamion']);
        oci_bind_by_name($sp, ":V_TRAKING_ID"         ,   $ruta['traking_id']);
        oci_bind_by_name($sp, ":V_CLIENTE"            ,   $ruta['cliente']);
        oci_bind_by_name($sp, ":V_DIRECCION"          ,   $ruta['direccion']);
        oci_bind_by_name($sp, ":V_LONGITUD"           ,   $ruta['longitud']);
        oci_bind_by_name($sp, ":V_LATITUD"            ,   $ruta['latitud']);
        oci_bind_by_name($sp, ":V_KILOS"              ,   $ruta['kilos']);
        oci_bind_by_name($sp, ":V_VOLUMEN"            ,   $ruta['volumen']);
        oci_bind_by_name($sp, ":V_BULTOS"             ,   $ruta['bultos']);
        oci_bind_by_name($sp, ":V_TIEMPO_ESPERA"      ,   $ruta['time_service']);
        oci_bind_by_name($sp, ":V_HORA_ARRIVO"        ,   $ruta['hora_arrivo']);
        oci_bind_by_name($sp, ":V_HORA_SALIDA"        ,   $ruta['hora_salida']);
        oci_bind_by_name($sp, ":V_FECHA_CREACION_R"   ,   $ruta['fecha_creacion']);
        //estado del proceso

        oci_bind_by_name($sp, ":V_ESTADO"             ,   $aux);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  (!empty($aux[0])) ? $aux[0] : 0;
        return $estado; 
    }



    public function format_visit_int($element){
        $aux;
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_FORMAT_VISIT(:V_FECHA_JORNADA,:V_OFICINA_ID,:V_OPERACION,:V_ESTADO); END;" );
        oci_bind_by_name($sp, ":V_FECHA_JORNADA"            ,   $element['fecha_jornada']   );
        oci_bind_by_name($sp, ":V_OFICINA_ID"               ,   $element['oficina_id']      );
        oci_bind_by_name($sp, ":V_OPERACION"                ,   $element['operacion']       );
        //estado del proceso
        oci_bind_by_name($sp, ":V_ESTADO"             ,   $aux);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  (!empty($aux[0])) ? $aux[0] : 0;
        return $estado; 
    }

    public function cerrar_carga_plan($element){
        $aux;
        $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_INTEGRACION_RUTEADOR.SP_CERRAR_CARGA_PLAN(:V_FECHA_JORNADA,:V_OFICINA_ID,:V_OPERACION,:V_ESTADO); END;" );
        oci_bind_by_name($sp, ":V_FECHA_JORNADA"            ,   $element['fecha_jornada']   );
        oci_bind_by_name($sp, ":V_OFICINA_ID"               ,   $element['oficina_id']      );
        oci_bind_by_name($sp, ":V_OPERACION"                ,   $element['operacion']       );
        //estado del proceso
        oci_bind_by_name($sp, ":V_ESTADO"             ,   $aux);
        oci_execute($sp, OCI_DEFAULT);
        $estado =  (!empty($aux[0])) ? $aux[0] : 0;
        return $estado; 
    }

    
       public function get_operacion_by_code($operacion){
        $str_sql="SELECT 
                        OP.CODIGO,
                        OP.TOKEN,
                        OP.DESCRIPCION,
                        OP.OFICINA_ID,
                        TO_DATE(F.FECHA_PROCESO,'DD-MM-RRRR') FECHA_PROCESO,
                        TO_DATE(F.FECHA_FACTURAR,'DD-MM-RRRR') FECHA_FACTURAR,
                        TO_CHAR(TO_DATE(F.FECHA_PROCESO,'DD-MM-RRRR'),'RRRR-MM-DD') FECHA_PROCESO_R,
                        TO_CHAR(TO_DATE(F.FECHA_FACTURAR,'DD-MM-RRRR'),'RRRR-MM-DD') FECHA_FACTURAR_R,
                        F.OFICODIGO,
                        F.ESTADO,
                        NVL(
                            (SELECT ESTADO_PROCESO
                             FROM   PF_PLANES_RUTEADOR_INTEGRACION
                             WHERE  TO_DATE(FECHA_JORNADA,'DD-MM-RRRR') = TO_DATE(F.FECHA_PROCESO,'DD-MM-RRRR')
                             AND    OPERACION  = OP.CODIGO
                             AND    OFICINA_ID = OP.OFICINA_ID
                            ),
                        'ABIERTO') ESTADO_PROCESO
                    FROM
                        (SELECT DC.CODIGO,
                             DC.NOMBRE AS TOKEN,
                             DC.DESCRIPCION,
                             DC.ATTRIBUTE1 OFICINA_ID
                        FROM APPS.DEV_LOOKUP_TYPES@PPFERI DT,
                           APPS.DEV_LOOKUP_CODES@PPFERI DC
                        WHERE DT.DEV_LOOKUP_TYPE_ID = DC.DEV_LOOKUP_TYPE_ID
                        AND DT.FLAG = 'S'
                        AND DC.FLAG = 'S'
                        AND DT.TYPE_NAME = 'PF_CONFIG_OFICINAS_RUTEADOR') OP,
                        APPS.PF_TR_PROG_FECHA_PROCESO@PPFERI F
                    WHERE   F.OFICODIGO                           = OP.OFICINA_ID
                    AND     F.ESTADO                              ='ABIERTO'
                    AND     OP.CODIGO                             = '".$operacion."'";
        $query = $this->db->query($str_sql);
        $result  = $query->result();
        return $result;
    }

                        
}
