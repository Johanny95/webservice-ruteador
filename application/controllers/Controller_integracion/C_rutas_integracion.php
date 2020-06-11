<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_rutas_integracion extends WS_Controller {

	private $url_rutas_by_day  	= 'https://api.simpliroute.com/v1/routes/routes/?planned_date=';
	private $url_visit_by_day   = 'https://api.simpliroute.com/v1/routes/visits/?planned_date=';


	private $url_get_camion     = 'https://api.simpliroute.com/v1/routes/vehicles/';
	private $url_get_chofer     = 'https://api.simpliroute.com/v1/accounts/drivers/';
	private $metod_post 		= 'POST'; 		//utilizado para crear
	private $metod_get			= 'GET';  		//obtener datos
	private $metod_put 			= 'PUT';  		//upd
	private $metod_delete 		= 'DELETE';		//utilizado para eliminar

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_integracion/M_integracion_rutas','M_rutas');
	}

	public function integrar_rutas_det(){
		$this->get_rutas_by_day();
		$this->get_visit_by_day();
	}

	public function get_rutas_by_day(){
		$element 		= array();
		$operaciones 	= $this->M_rutas->get_operaciones();
		
		
		foreach ($operaciones as $key => $op) {
			echo var_dump($op);
			echo "============================";
			if ($op->ESTADO_PROCESO == 'ABIERTO' || $op->ESTADO_PROCESO == 'PRE-ABIERTO') {
			
			// $fecha    		= $this->input->get('fecha');
			$fecha 			= $op->FECHA_PROCESO_R;
			$url  	  		= $this->url_rutas_by_day.$fecha;

			$response 	= $this->call_api( $this->metod_get, $url ,$element, $op->TOKEN );
			$result   	= json_decode($response);


			//se valdia que existan rutas en el sistema de ruteo
			if(!empty($result)){

			//obtenemos secuencia de plan
				$secuencia 	= $this->M_rutas->get_secuencia_plan();


			//conexion para obtener los camiones de la operacion en ejecución.
				$camion 	= $this->call_api($this->metod_get, $this->url_get_camion.'/', $element , $op->TOKEN );
				$cam_json   = json_decode($camion);

			//conxcion para obtener los choferes de la operacion en ejecución.
				$choferes   = $this->call_api($this->metod_get, $this->url_get_chofer, $element , $op->TOKEN);
				$ch_json    = json_decode($choferes);


				foreach ($result as $key => $ruta) {
					$patente = null;
					$chofer  = null;
					foreach ($cam_json as $key => $c) {
						if($c->id == $ruta->vehicle){
							$patente = $c->name;
							break;
						}	
					}
					foreach ($ch_json as $key => $ch) {
						if($ch->id == $ruta->driver){
							$array_chofer = explode('_', $ch->username);
							$chofer = $array_chofer[0];
							break;
						}		
					}

					$data = array( 
						'secuencia_plan' 		=> $secuencia[0]->SECUENCIA,
						'id_ruta' 				=> $ruta->id,
						'vehicle' 				=> $ruta->vehicle,
						'patente'				=> $patente,
						'operacion'				=> $op->CODIGO,
						'oficina_id'			=> $op->OFICINA_ID,
						'chofer' 				=> $ruta->driver,
						'rut_chofer'			=> $chofer,
						'fecha_plan'			=> $ruta->planned_date,
						'hora_inicio' 			=> $ruta->estimated_time_start,
						'hora_fin' 				=> $ruta->estimated_time_end,
						'duracion' 				=> $ruta->total_duration,
						'distancia'		 		=> $ruta->total_distance,
						'carga' 				=> $ruta->total_load,
						'volumen' 				=> 0,
						'bultos'				=> 0,
						'carga_porcentaje'		=> $ruta->total_load_percentage,
						'comentario'		    => $ruta->comment
					);

					echo  var_dump($data);
					$res = $this->M_rutas->add_ruta($data);
					echo var_dump($res);
					echo '===================================================================';
				}
			}
		}

		} 
	}


	public function get_visit_by_day(){
		$element 		= array();
		
		$operaciones 	= $this->M_rutas->get_operaciones();
		
		foreach ($operaciones as $key => $op) {
			
			// $fecha    		= $this->input->get('fecha');
			$fecha 			= $op->FECHA_PROCESO_R;
			echo var_dump($op);
			echo "============================";

			if ($op->ESTADO_PROCESO == 'ABIERTO' || $op->ESTADO_PROCESO == 'PRE-ABIERTO') {

			$url  	  		= $this->url_visit_by_day.$fecha;

			$response 	= $this->call_api( $this->metod_get, $url ,$element, $op->TOKEN );
			$result   	= json_decode($response);

			$rutas_size = count($result)-1;

			if (!empty($result)){
			//format_visit_int
				$format = array(
					'fecha_jornada' => $fecha,
					'oficina_id'	=> $op->OFICINA_ID,
					'operacion'		=> $op->CODIGO);

				$res = $this->M_rutas->format_visit_int($format);
				

				foreach ($result as $key => $visit) {

					$array_notes 	= explode('_', $visit->notes);
					$clicodigo 		= $array_notes[0];
					$fecha_fact		= ( empty($array_notes[1]) ? $fecha : $array_notes[1] );

					$data  = array(
						'clicodigo' 	=> $clicodigo,
						'orden'		  	=> $visit->order,
						'operacion'		=> $op->CODIGO,
						'oficina_id'	=> $op->OFICINA_ID,
						'fecha_jornada' => $fecha,
						'fecha_factura'	=> $fecha_fact,
						'ruta'			=> $visit->route,
						'subcamion'		=> $visit->visit_type,
						'traking_id'	=> $visit->tracking_id,
						'cliente'		=> $visit->title,
						'direccion'		=> $visit->address,
						'longitud'		=> $visit->longitude,
						'latitud'		=> $visit->latitude,
						'kilos'			=> $visit->load,
						'volumen'		=> $visit->load_2,
						'bultos'		=> $visit->load_3,
						'window_start'	=> $visit->window_start,
						'window_end'	=> $visit->window_end,
						'window_start_2'=> $visit->window_start_2,
						'window_end_2'	=> $visit->window_end_2,
						'time_service'	=> $visit->duration,
						'hora_arrivo'	=> $visit->estimated_time_arrival,
						'hora_salida'	=> $visit->estimated_time_departure,
						'fecha_creacion'=> $visit->created,
						'fecha_modified'=> $visit->modified
					);

					echo var_dump($data);
					$add_res = $this->M_rutas->add_clientes_det($data);
					echo 	 $add_res.'   =================<br/>';

					if ( $rutas_size == $key){
						$objecto = array('fecha_jornada' => $op->FECHA_PROCESO,
									     'oficina_id'	 => $op->OFICINA_ID,
									 	 'operacion'     => $op->CODIGO
									 	 );
						$this->M_rutas->cerrar_carga_plan($objecto);
						echo "CERRADA CARGA";
					}

				}	

			}

		}
	}

	}


	

	public function oracle_rutas_visitas(){
		$code_operacion    		= $this->input->get('operacion');
		$operacion = $this->M_rutas->get_operacion_by_code($code_operacion);
		$op = $operacion[0];
		echo var_dump($op);
		if ( $op->ESTADO_PROCESO == 'ABIERTO' || $op->ESTADO_PROCESO == 'PRE-ABIERTO' ) {

			$this->oracle_rutas($op);

			$this->integracion_oracle_visitas($op);

		}
	}

	public function oracle_rutas($op){
		$element 		= array();
		$fecha 			= $op->FECHA_PROCESO_R;
		$url  	  		= $this->url_rutas_by_day.$fecha;

		$response 	= $this->call_api( $this->metod_get, $url ,$element, $op->TOKEN );
		$result   	= json_decode($response);

		if(!empty($result)){

			$secuencia 	= $this->M_rutas->get_secuencia_plan();


			$camion 	= $this->call_api($this->metod_get, $this->url_get_camion.'/', $element , $op->TOKEN );
			$cam_json   = json_decode($camion);

			$choferes   = $this->call_api($this->metod_get, $this->url_get_chofer, $element , $op->TOKEN);
			$ch_json    = json_decode($choferes);


			foreach ($result as $key => $ruta) {
				$patente = null;
				$chofer  = null;
				foreach ($cam_json as $key => $c) {
					if($c->id == $ruta->vehicle){
						$patente = $c->name;
						break;
					}	
				}
				foreach ($ch_json as $key => $ch) {
					if($ch->id == $ruta->driver){
						$array_chofer = explode('_', $ch->username);
						$chofer = $array_chofer[0];
						break;
					}		
				}

				$data = array( 
					'secuencia_plan' 		=> $secuencia[0]->SECUENCIA,
					'id_ruta' 				=> $ruta->id,
					'vehicle' 				=> $ruta->vehicle,
					'patente'				=> $patente,
					'operacion'				=> $op->CODIGO,
					'oficina_id'			=> $op->OFICINA_ID,
					'chofer' 				=> $ruta->driver,
					'rut_chofer'			=> $chofer,
					'fecha_plan'			=> $ruta->planned_date,
					'hora_inicio' 			=> $ruta->estimated_time_start,
					'hora_fin' 				=> $ruta->estimated_time_end,
					'duracion' 				=> $ruta->total_duration,
					'distancia'		 		=> $ruta->total_distance,
					'carga' 				=> $ruta->total_load,
					'volumen' 				=> 0,
					'bultos'				=> 0,
					'carga_porcentaje'		=> $ruta->total_load_percentage,
					'comentario'		    => $ruta->comment
				);

				echo  var_dump($data);
				$res = $this->M_rutas->add_ruta($data);
				echo var_dump($res);
				echo '===================================================================';
			}
		}
	}



	public function integracion_oracle_visitas($op){

		$fecha 			= $op->FECHA_PROCESO_R;
		$url  	  		= $this->url_visit_by_day.$fecha;
		$element 		= array();
		$response 	= $this->call_api( $this->metod_get, $url ,$element, $op->TOKEN );
		$result   	= json_decode($response);

		$rutas_size = count($result)-1;

		if (!empty($result)){
			$format = array(
				'fecha_jornada' => $fecha,
				'oficina_id'	=> $op->OFICINA_ID,
				'operacion'		=> $op->CODIGO);

			$res = $this->M_rutas->format_visit_int($format);

			foreach ($result as $key => $visit) {

				$array_notes 	= explode('_', $visit->notes);
				$clicodigo 		= $array_notes[0];
				$fecha_fact		= ( empty($array_notes[1]) ? $fecha : $array_notes[1] );

				$data  = array(
					'clicodigo' 	=> $clicodigo,
					'orden'		  	=> $visit->order,
					'operacion'		=> $op->CODIGO,
					'oficina_id'	=> $op->OFICINA_ID,
					'fecha_jornada' => $fecha,
					'fecha_factura'	=> $fecha_fact,
					'ruta'			=> $visit->route,
					'subcamion'		=> $visit->visit_type,
					'traking_id'	=> $visit->tracking_id,
					'cliente'		=> $visit->title,
					'direccion'		=> $visit->address,
					'longitud'		=> $visit->longitude,
					'latitud'		=> $visit->latitude,
					'kilos'			=> $visit->load,
					'volumen'		=> $visit->load_2,
					'bultos'		=> $visit->load_3,
					'window_start'	=> $visit->window_start,
					'window_end'	=> $visit->window_end,
					'window_start_2'=> $visit->window_start_2,
					'window_end_2'	=> $visit->window_end_2,
					'time_service'	=> $visit->duration,
					'hora_arrivo'	=> $visit->estimated_time_arrival,
					'hora_salida'	=> $visit->estimated_time_departure,
					'fecha_creacion'=> $visit->created,
					'fecha_modified'=> $visit->modified
				);

				echo var_dump($data);
				$add_res = $this->M_rutas->add_clientes_det($data);
				echo 	 $add_res.'   =================<br/>';
				if ( $rutas_size == $key){
					$objecto = array('fecha_jornada' => $op->FECHA_PROCESO,
						'oficina_id'	 => $op->OFICINA_ID,
						'operacion'      => $op->CODIGO
					);
					$this->M_rutas->cerrar_carga_plan($objecto);
					echo "CERRADA CARGA";
				}

			}	

		}

	}

	




}


