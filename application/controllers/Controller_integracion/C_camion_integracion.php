<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_camion_integracion extends WS_Controller {

	private $url  	    	= 'https://api.simpliroute.com/v1/routes/vehicles/';
	private $metod_post 	= 'POST'; 		//utilizado para crear
	private $metod_get		= 'GET';  		//obtener datos
	private $metod_put 		= 'PUT';  		//upd
	private $metod_delete 	= 'DELETE';		//utilizado para eliminar

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_integracion/M_integracion_camion','M_camion');
	}

	public function add_camiones(){
		$camiones = $this->M_camion->get_camiones();

		foreach ($camiones as $key => $camion) {

			$element = array(
				'name'						=> $camion->PATENTE,
				'capacity'					=> $camion->CAPACIDAD,
				'default_driver'			=> null,
				'location_start_address'	=> $camion->OPERACION,
				'location_start_latitude'	=> $camion->LATITUD_ORG,
				'location_start_longitude'	=> $camion->LONGITUD_ORG,
				'location_end_address'		=> $camion->OPERACION,
				'location_end_latitude'		=> $camion->LATITUD_FIN,
				'location_end_longitude'	=> $camion->LONGITUD_FIN,
				'skills'					=> []);
			$response = $this->call_api( $this->metod_post, $this->url ,$element, $camion->TOKEN );
			$result   = json_decode($response);
			echo var_dump($result);
			if ( !empty($result->id) ) {
				echo $result->id;
				$element['ID_RUTEADOR'] =  $result->id;
				$element['CODCAMION']	=  $camion->CODCAMION;
				$element['OPERACION']	=  $camion->OPERACION;
				$status = $this->M_camion->set_envio_camion($element);
			}else{
				echo 'VACIO';
			}
		}

	}


	public function upd_camiones(){
		$camiones = $this->M_camion->get_upd_camiones();

		foreach ($camiones as $key => $camion) {
			$element = array(
				'name'						=> $camion->PATENTE,
				'capacity'					=> $camion->CAPACIDAD,
				'default_driver'			=> null,
				'location_start_address'	=> $camion->OPERACION,
				'location_start_latitude'	=> $camion->LATITUD,
				'location_start_longitude'	=> $camion->LONGITUD,
				'location_end_address'		=> $camion->OPERACION,
				'location_end_latitude'		=> $camion->LATITUD,
				'location_end_longitude'	=> $camion->LONGITUD,
				'skills'					=> []
			);
			$response = $this->call_api( $this->metod_put, $this->url.$camion->ID_RUTEADOR.'/' ,$element, $camion->TOKEN );
			$result   = json_decode($response);
			echo var_dump($result);
		}
	}


	public function del_camiones(){
		
		$camiones = $this->M_camion->get_del_camiones();
		foreach ($camiones as $key => $camion) {
			$element = array(
				'name'		=> $camion->PATENTE
			);
			$response = $this->call_api( $this->metod_delete, $this->url.$camion->ID_RUTEADOR.'/' ,$element, $camion->TOKEN );
			$result   = json_decode($response);
			echo var_dump($result);
		}

	}


	public function get_camion_by_code($codigo_camion,$token){

		$camion 	= $this->call_api($this->metod_get, $this->url.$codigo_camion.'/', $element , $token );
		$cam_json   = json_decode($camion);
		return $cam_json;

	}




}