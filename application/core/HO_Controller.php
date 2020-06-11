<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class WS_Controller extends CI_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->helper('xml');
		$this->load->library('xmlrpc');
		$this->load->library('xmlrpcs');
		ini_set('max_execution_time', 0);
	}

	function call_api($metod, $url ,$element, $token){
		switch ($metod) {
			case 'POST':
				$metodo = 'POST';
			break;
			case 'PUT':
				$metodo = 'PUT';
			break;
			case 'GET':
				$metodo = 'GET';
			break;
			case 'DELETE':
				$metodo = 'DELETE';
			break;
			default:
				$metodo = 'POST';
			break;
		}
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 200,
			CURLOPT_SSL_VERIFYPEER=> false,
			CURLOPT_SSL_VERIFYHOST=> 0,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $metodo,
			CURLOPT_POSTFIELDS => json_encode($element),
			CURLOPT_HTTPHEADER => array(
				'authorization: Token '.$token,
				'content-type: application/json'
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		
		if ($err) {
			$msg = $err;
		} else {
			$msg = $response;
		}
		return $msg;
	}





} 




