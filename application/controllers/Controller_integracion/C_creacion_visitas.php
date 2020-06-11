<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_creacion_visitas extends WS_Controller {

	private $url_visita  		= 'https://api.simpliroute.com/v1/routes/visits/';
	private $url_visit_by_day   = 'https://api.simpliroute.com/v1/routes/visits/?planned_date=';
	
	private $metod_post 		= 'POST'; 		//utilizado para crear
	private $metod_get			= 'GET';  		//obtener datos
	private $metod_put 			= 'PUT';  		//upd
	private $metod_delete 		= 'DELETE';		//utilizado para eliminar

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_integracion/M_integracion_visitas'	,'M_visitas');
		$this->load->model('Model_integracion/M_integracion_rutas'		,'M_rutas');
		$this->load->model('Model_integracion/M_integracion_util'		,'M_util');
	}


	public function crear_visitas(){
		$operaciones 	= $this->M_rutas->get_operaciones();
		foreach ($operaciones as $key => $op) {
			echo var_dump($op).'<br/>========================================<br/>';

			$operacion = array('operacion' 		=> $op->CODIGO,
				'fecha_jornada'					=> $op->FECHA_PROCESO,
				'oficina_id'					=> $op->OFICODIGO,
				'estado_proceso' 				=> $op->ESTADO_PROCESO
			);

			if ($op->ESTADO_PROCESO == 'ABIERTO' || $op->ESTADO_PROCESO == 'PRE-ABIERTO') {

				/*SE OPTIENE ESTADO DE INTEGRACION PARA */
				$estado_integracion = $this->M_visitas->get_estado_integracion($op);
				
				if ($estado_integracion == '1'){ /*CUANDO EL ESTADO ES 1 SE PUEDE INTEGRAR POR LO CONTRARIO YA EXISTE UN PROCESO EN EJECUCION*/


					$this->get_visitas_creadas($op);

					$visits =  $this->M_visitas->get_visitas($operacion);


					$array_enviado = array();

					foreach ($visits as $key_visit => $visita) {
						$var_prioridad = ( $visita->PRIORIDAD ? true : false );
						
						$objecto = array(	
							'title' 			=> $visita->CLIENTE,
							'planned_date' 		=> $visita->FECHA_PEDIDO_R,
							'operacion' 		=> $visita->OPERACION,
							'address' 			=> $visita->DIRECCION,
							'reference'			=> $visita->CLICODIGO,
							'window_start' 		=> $visita->INICIO_HORARIO,
							'window_end' 		=> $visita->FIN_HORARIO,
							'window_start_2' 	=> $visita->INICIO_HORARIO2,
							'window_end_2' 		=> $visita->FIN_HORARIO2,
							'duration' 			=> $visita->TIEMPO_ESPERA,
							'notes'				=> $visita->CLICODIGO.'_'.$visita->FECHA_FACTURA,
							'latitude' 			=> ( $visita->LATITUD ? str_replace(',', '.', $visita->LATITUD ) : null ),
							'longitude' 		=> ( $visita->LATITUD ? str_replace(',', '.', $visita->LONGITUD) : null ),
							'load' 				=> $visita->PESO,
							'load_2' 			=> $visita->VOLUMEN,
							'load_3' 			=> $visita->BULTOS,
							'priority'			=> $var_prioridad,
							'priority_level'	=> ( $visita->PRIORIDAD ? $visita->PRIORIDAD : 0 )
							// ,'visit_type'		=> $visita->SUBCAMION
						);

						$array_enviado[] = $objecto;

						if( ($key_visit % 50) == 0){ /*se crea array cada 50 registros y se envia*/
							$this->add_visitas_lote($array_enviado,$op);
							$array_enviado = array();
						}
					}

					$this->add_visitas_lote($array_enviado,$op); /*se envia registros en caso que quede afera o no cumpla con los 50 */

					/*CERRAMOS LA INSTANCIA DE INTEGRACION PARA DEJAR DISPONIBLE A NUEVA EJCUCION POR OFICINA, OPERACION, FECHA_OP Y FECHA FAC*/
					$this->M_visitas->cierre_proceso_intgracion($op);

				}else{
					echo 'OTRO PROCEDIMIENTO SE ESTA EJECUTANTO';
				}

			}
		}

	}


	public function upd_visitas_ruteador(){
		$operaciones 	= $this->M_rutas->get_operaciones();
		foreach ($operaciones as $key => $op) {
			echo var_dump($op).'<br/>========================================<br/>';

			$operacion = array( 'operacion' 		=> $op->CODIGO,
				'fecha_jornada'		=> $op->FECHA_PROCESO,
				'oficina_id'		=> $op->OFICODIGO
			);

			if ($op->ESTADO_PROCESO == 'ABIERTO' || $op->ESTADO_PROCESO == 'PRE-ABIERTO') {

				/*SE OPTIENE ESTADO DE INTEGRACION PARA */
				$estado_integracion = $this->M_visitas->get_estado_integracion($op);
				
				if ($estado_integracion == '1'){ /*CUANDO EL ESTADO ES 1 SE PUEDE INTEGRAR POR LO CONTRARIO YA EXISTE UN PROCESO EN EJECUCION*/

					$visits =  $this->M_visitas->get_visitas_upd($operacion);

					foreach ($visits as $key => $v) {
						$var_prioridad = ( $v ? true : false );
						$url 	= $this->url_visita.$v->ID_CLIENTE.'/';

						$objecto= array(
							'id'				=> $v->ID_CLIENTE,
							'title' 			=> $v->CLIENTE,
							'reference'			=> $v->CLICODIGO,
							'planned_date' 		=> $v->FECHA_PEDIDO_R,
							'operacion' 		=> $v->OPERACION,
							'address' 			=> $v->DIRECCION,
							'window_start' 		=> $v->INICIO_HORARIO,
							'window_end' 		=> $v->FIN_HORARIO,
							'window_start_2'	=> $v->INICIO_HORARIO2,
							'window_end_2' 		=> $v->FIN_HORARIO2,
							'duration' 			=> $v->TIEMPO_ESPERA,
							'notes'				=> $v->CLICODIGO.'_'.$v->FECHA_FACTURA,
							// 'latitude' 		=> $v->LATITUD,
							// 'longitude' 		=> $v->LONGITUD,
							'load' 				=> $v->PESO,
							'load_2' 			=> $v->VOLUMEN,
							'load_3' 			=> $v->BULTOS,
							'priority'			=> $var_prioridad,
							'priority_level'	=> ( $visita->PRIORIDAD ? $visita->PRIORIDAD : 0 )
							// 'visit_type'		=> $v->SUBCAMION
						);
						$res    = $this->call_api($this->metod_put, $url ,$objecto, $op->TOKEN);
						$result =  json_decode($res);
						if ( !empty($result->id)) {

							$upd_element = array(
								'id_cliente'	=> $v->ID_CLIENTE,
								'clicodigo'		=> $v->CLICODIGO,
								'oficina_id'	=> $op->OFICODIGO,
								'fecha_pedido'	=> $v->FECHA_PEDIDO,
								'fecha_factura'	=> $v->FECHA_FACTURA,
								'operacion'		=> $v->OPERACION
								// ,'id_ruteador'	=> $result->id
							);
							$v_estado = $this->M_visitas->set_estado_actualizacion($upd_element);
							echo $v_estado;
							echo "<br/>";
						}else{
							$tipo_error = (empty($result)) ? 'TRAZA' : 'ERROR';
							$error 	    = array('tipo_error'=> $tipo_error,
								'user_id' 		=> 1099,
								'procedimiento' => 'INTEGRACION.ACTUALIZACION_VISITAS',
								'error' 		=> 'ERROR AL INTEGRAR VISITAS Y ACTUALIZAR DE PUNTOS DE ENTREGA EN RUTEADOR CLICODIGO:'.$v->CLICODIGO.' OFICODIGO:'.$v->OFICINA_ID.' FECHA_PEDIDO:'.$v->FECHA_PEDIDO.' FECHA_FACTURA:'.$v->FECHA_FACTURA.' OPERACION'.$v->OPERACION.' MSG ruteador:'.json_encode($result));
							$this->M_util->write_log($error);
						}
					}
					/*CERRAMOS LA INSTANCIA DE INTEGRACION PARA DEJAR DISPONIBLE A NUEVA EJCUCION POR OFICINA, OPERACION, FECHA_OP Y FECHA FAC*/
					$this->M_visitas->cierre_proceso_intgracion($op);
				}else{
					echo 'OTRO PROCEDIMIENTO SE ESTA EJECUTANTO';
				}

			}

		}

	}

	public function visitas_by_day(){
		$token   	= $this->input->get('token');
		$fecha   	= $this->input->get('fecha');
		$objecto 	= array();
		$url    	= $this->url_visit_by_day.$fecha;
		$res   		= $this->call_api($this->metod_get, $url ,$objecto, $token);
		$result 	=  json_decode($res);
		foreach ($result as $key => $v) {
			$url_del 		= $this->url_visita.$v->id.'/';
			echo $v->id;
			$this->call_api($this->metod_delete, $url_del ,$objecto, $token);
			
		}
	}


	/*funcio que registra las visitas ya creadas en ruteador en caso de tener problemas en integracion, va guardando id en oracle*/
	public function get_visitas_creadas($operacion_var){

		$fecha 			=  $operacion_var->FECHA_PROCESO_R;
		$fecha_proceso  =  $operacion_var->FECHA_PROCESO;
		$fecha_factura  =  $operacion_var->FECHA_FACTURAR;
		$operacion 		=  $operacion_var->CODIGO;
		$oficina_id 	=  $operacion_var->OFICODIGO;
		$token 			=  $operacion_var->TOKEN;
		$objecto 	= array();
		$url    	= $this->url_visit_by_day.$fecha;
		$res   		= $this->call_api($this->metod_get, $url ,$objecto, $token);
		$result 	=  json_decode($res);
		foreach ($result as $key => $visita) {

			$upd_element = array(
				'clicodigo'		=> $visita->reference,
				'oficina_id'	=> $oficina_id,
				'fecha_pedido'	=> $fecha_proceso,
				'fecha_factura'	=> $fecha_factura,
				'operacion'		=> $operacion,
				'id_ruteador'	=> $visita->id
			);

			$v_estado 	  = $this->M_visitas->add_id_ruteador($upd_element);
		}


	}


	public function add_visitas_lote($array_enviado,$op){
		$estado_envio = true;
		$res    = $this->call_api($this->metod_post, $this->url_visita ,$array_enviado, $op->TOKEN);
		$result =  json_decode($res);

		foreach ($result as $key => $v) {
			if ( !empty($v->id)) {

				$array_notes 	= explode('_', $v->notes);
				$clicodigo 		= $array_notes[0];
				$fecha_fact		= ( empty($array_notes[1]) ? $fecha : $array_notes[1] );

				$upd_element = array(
					'clicodigo'		=> $v->reference,
					'oficina_id'	=> $op->OFICODIGO,
					'fecha_pedido'	=> $op->FECHA_PROCESO,
					'fecha_factura'	=> $fecha_fact,
					'operacion'		=> $op->CODIGO,
					'id_ruteador'	=> $v->id
				);
				$v_estado 	  = $this->M_visitas->add_id_ruteador($upd_element);
				echo $v_estado;
			}else{
				$estado_envio = false;
			}
		}
		if ( !$estado_envio ){
			$tipo_error = (empty($result)) ? 'TRAZA' : 'ERROR';
			$error 	    = array('tipo_error' 	=> $tipo_error,
				'user_id' 		=> 1099,
				'procedimiento' => 'INTEGRACION.CREAR_VISITAS',
				'error' 		=> 'ERROR AL INTEGRAR VISITAR Y CREACION DE PUNTOS DE ENTREGA EN RUTEADOR OFICODIGO:'.$op->OFICODIGO.' FECHA_PEDIDO:'.$op->FECHA_PROCESO.' OPERACION'.$op->CODIGO.' MSG ruteador:'.json_encode($result) );
			$this->M_util->write_log($error);
		}

	}






}