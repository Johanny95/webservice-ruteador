<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	public function limpiar_rut($string)
	{
		return strtoupper(str_replace('.','',$string));	
	}

	public function validar_rut($rut){
		$suma = NULL;
		if(strpos($rut,"-")==false){
			$RUT[0] = substr($rut, 0, -1);
			$RUT[1] = substr($rut, -1);
		}else{
			$RUT = explode("-", trim($rut));
		}
		$elRut = str_replace(".", "", trim($RUT[0]));
		$factor = 2;
		for($i = strlen($elRut)-1; $i >= 0; $i--):
			$factor = $factor > 7 ? 2 : $factor;
			$suma += $elRut{$i}*$factor++;
		endfor;
		$resto = $suma % 11;
		$dv = 11 - $resto;
		if($dv == 11){
			$dv=0;
		}else if($dv == 10){
			$dv="k";
		}else{
			$dv=$dv;
		}
		if($dv == trim(strtolower($RUT[1]))){
			return true;
		}else{
			return false;
		}
	}

	public function mayucula_minuscula($string)
	{
		return ucwords(mb_strtolower($string));
	}
}

/* End of file Funciones.php */
/* Location: ./application/libraries/Funciones.php */
