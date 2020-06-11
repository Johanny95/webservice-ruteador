<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcion
{
	protected $ci;
	private $dir_excel_reponedor = 'uploads/excel/reponedor';
	private $dir_excel_meta = 'uploads/excel/meta';
	private $dir_excel_maquina = 'uploads/excel/maquina'; //Máquinas
	private $dir_excel_transaccion = 'uploads/excel/transaccion'; //Transacciones
	
	public function __construct()
	{
        $this->ci =& get_instance();
	}

	/*===========================================
	=            Funciones Generales            =
	===========================================*/

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

	public function mayucula($string)
	{
		return strtoupper($string);
	}

	public function limpiar_rut($string)
	{
		return strtoupper(str_replace('.','',$string));	
	}

	public function limpiar($string)
	{
		return trim($string);
	}

	public function formato_unidad_mil($string)
	{
		return number_format($string,'0', ',','.');
	}

	public function limpiar_precio($string)
	{
		$replace = array('.',',','$');
		$numero = str_replace($replace,"",trim($string));
		return $numero;
	}

	public function limpiar_numero($string)
	{
		$replace = array('.',',','$');
		$numero = str_replace($replace,"",trim($string));
		return $numero;
	}

	public function convertir_numero($string)
	{
		return floatval(str_replace(",",".",$string));
	}
	
	public function convertir_numero_oracle($string)
	{
		return str_replace(".",",",$string);
	}

	public function lista_mes()
	{
    	$mes = array(
		    'Enero',
		    'Febrero',
		    'Marzo',
		    'Abril',
		    'Mayo',
		    'Junio',
		    'Julio',
		    'Agosto',
		    'Septiembre',
		    'Octubre',
		    'Noviembre',
		    'Diciembre'
		);
    	return $mes;
	}

	public function rango($familia, $cp, $tipo, $rut)
	{
		// die(var_dump($rut));
		$rango = 0;
		$tipo  = strtoupper($tipo);
		$familia = strtoupper($familia);
		/** @var [numerico0] [quitar la converción en producción] */
		$cp = $this->convertir_numero($cp);

		$this->ci =& get_instance();
		$this->ci->load->model('M_tipo','tipo');

		$post          = new stdClass;
		$post->tipo    = $tipo;
		$post->familia = $familia;
		$post->calculo = $cp;
		$post->rut     = $rut;
		$elementoObj   = (object) $post;
		// $pago  = $this->ci->tipo->get_pago($rut,$familia);
		$rango = $this->ci->tipo->get_monto_pago($elementoObj);
		// $rango = ($pago > 0) ? $this->ci->tipo->get_monto_pago($elementoObj) : 0;
		return $rango;
	}

	public function string_with_commad($array)
    {
    	if ($array != null) {
	    	if (is_array($array)) {
	    		$data = implode(',',$array);
	    		return $data;
	    	}
	    	return null;
    	}
    	return null;
    }

	//Máquinas
	public function validar_modelo($mod)
	{
		if($mod != NULL)
		{
			return true;
		}else{
			return false;
		}
	}

	public function validar_factura($nfp)
	{
		if($nfp != NULL)
		{
			if(is_numeric($nfp) == TRUE)
			return $nfp;
		}else{
			return NULL;
		}
	}

	//Visitas
	public function validar_cliente($codigo)
	{
		if($codigo != NULL)
		{
			return true;
		}else{
			return false;
		}
	}	

	public function rellenar_codigo($codigo)
	{
		if(($codigo != NULL) && (strlen($codigo) < 8))
		{
			return str_pad($codigo, 8, "0", STR_PAD_LEFT);
		}
		else{
			return $codigo;
		}
	}

	public function revisar_entrega($estado)
	{
		if(($estado != NULL) && ($estado=='ENTRAGADA'))
		{
			return $estado = 'ENTREGADA';
		}
		else{
			return $estado;
		}
	}

	public function limpiar_nulos($string)
	{
		if(is_null($string) == TRUE)
		{
			$salida = " ";
		}
		else{
			$salida = $string;
		}
		return $salida;	
	}

	public function limpiar_numeros_nulos($number)
	{
		if(is_null($number) == TRUE)
		{
			$salida = 0;
		}
		else{
			$salida = $number;
		}
		return $salida;
	}

	public function validar_maximo($max)
	{
		if(is_null($max) == TRUE)
		{
			return 0;
		}
		else
		{
			return $max;
		}
	}

	public function limpiar_nulos_2($string)
	{
		if(is_null($string) == TRUE)
		{
			$salida = "-";
		}
		else{
			$salida = $string;
		}
		return $salida;	
	}

	public function crud_ins_mensaje($status,$es){
		$flash_msg = array();
		if ($status == TRUE) {
			$flash_msg = array(
				'callout_class'  => 'alert alert-success alert-dismissible',
				'callout_title'  => '<h4><i class="icon fa fa-check"></i> ¡Éxito! </h4>',
				'callout_text'   => '<p> Se ha registrado la '.$es.' exitosamente. </p>');
		}else{
			$flash_msg = array(
				'callout_class'  => 'alert alert-danger alert-dismissible',
				'callout_title'  => '<h4><i class="icon fa fa-ban"></i> ¡Error! </h4>',
				'callout_text'   => '<p> Hubo un error al tratar de registrar '.$es.'., contactar a informatica.</p>');
		}
        $this->ci->session->set_flashdata('msg',$flash_msg);
	}

	public function crud_upd_mensaje($status,$es){
		$flash_msg = array();
		if ($status == TRUE) {
			$flash_msg = array(
				'callout_class'  => 'alert alert-success alert-dismissible',
				'callout_title'  => '<h4><i class="icon fa fa-check"></i> ¡Éxito! </h4>',
				'callout_text'   => '<p> Se ha editado la '.$es.' exitosamente. </p>');
		}else{
			$flash_msg = array(
				'callout_class'  => 'alert alert-danger alert-dismissible',
				'callout_title'  => '<h4><i class="icon fa fa-ban"></i> ¡Error! </h4>',
				'callout_text'   => '<p> Hubo un error al tratar de editado '.$es.'., contactar a informatica.</p>');
		}
        $this->ci->session->set_flashdata('msg',$flash_msg);
	}

	public function crud_del_mensaje($status,$es){
		$flash_msg = array();
		if ($status == TRUE) {
			$flash_msg = array(
				'callout_class'  => 'alert alert-success alert-dismissible',
				'callout_title'  => '<h4><i class="icon fa fa-check"></i> ¡Éxito! </h4>',
				'callout_text'   => '<p> Se ha eliminado la '.$es.' exitosamente. </p>');
		}else{
			$flash_msg = array(
				'callout_class'  => 'alert alert-danger alert-dismissible',
				'callout_title'  => '<h4><i class="icon fa fa-ban"></i> ¡Error! </h4>',
				'callout_text'   => '<p> Hubo un error al tratar de eliminado '.$es.'., contactar a informatica.</p>');
		}
        $this->ci->session->set_flashdata('msg',$flash_msg);
	}

	public function crud_get_mensaje($status,$es){
		$flash_msg = array();
		if ($status == TRUE) {
			$flash_msg = array(
				'callout_class'  => 'alert alert-success alert-dismissible',
				'callout_title'  => '<h4><i class="icon fa fa-check"></i> ¡Éxito! </h4>',
				'callout_text'   => '<p> Se ha conseguido la '.$es.' exitosamente. </p>');
		}else{
			$flash_msg = array(
				'callout_class'  => 'alert alert-danger alert-dismissible',
				'callout_title'  => '<h4><i class="icon fa fa-ban"></i> ¡Error! </h4>',
				'callout_text'   => '<p> Hubo un error al tratar de conseguido '.$es.'., contactar a informatica.</p>');
		}
        $this->ci->session->set_flashdata('msg',$flash_msg);
	}

}

/* End of file Funciones.php */
/* Location: ./application/libraries/Funciones.php */
