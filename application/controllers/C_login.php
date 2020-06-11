<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controlador  Login
	 * 
	 * @Package		
	 * @Autor       Paolo Castillo
	 * @link        <http://url/dashboard_meta/index.php/login.html>
	 */

	/**
	 * Controlador   Class
	 * HO_Controller HO_Controller
	 * @subpackage   Libreria Login
	 * @categoria    Libreria
	 */

class C_login extends WS_Controller {
	/**
	 * [__construct Call Modelo login]
	 */
	private $maintenance = 'errors/html/maintenance';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login','home');
	}
	/**
	 * [login validar usuario]
	 * @return [type] [returna una vista si cumple]
	 */
	public function login()
	{
		$data['path'] = $this->view_login();
		if ($this->input->post()) {
			$this->form_validation->set_rules('id_rut', 'Rut', 'trim|required|min_length[1]|max_length[15]|callback_verificar_usuario|callback_verificar_rut');
			if ($this->form_validation->run() == TRUE) {
				// die(var_dump($this->input->post()));
				$usuario = $this->home->get_usuario($this->login->limpiar_rut($this->input->post('id_rut')));
				$rol  = array();
				foreach ($usuario as $key) {
					$this->session->set_userdata('usuid', $key->USUID);
					$this->session->set_userdata('nombre', $this->login->mayucula_minuscula($key->USUNOM));
					$this->session->set_userdata('oficina_origen', $key->OF_ORIGEN);
					$this->session->set_userdata('oficina_codigo', $key->OFICOD);
					$this->session->set_userdata('oficina_nombre', $this->login->mayucula_minuscula($key->NOMBRE_OFICINA));
					$this->session->set_userdata('departamento', $this->login->mayucula_minuscula($key->NOM_DEPTO));
				}
				foreach ($usuario as $key) {
					$rol[] = $key->ROLID;
				}
				$this->session->set_userdata('rol', $rol);
				$this->session->set_userdata('rut', $this->login->limpiar_rut($this->input->post('id_rut')));
            	$this->session->set_userdata('login', true);
            	$this->session->set_userdata('last_visited' , time());
            	redirect('inicio');
			} else {
				$data['errors'] = validation_errors();
			}
		}
		$this->load->view($data['path'],$data);
	}

	/**
	 * [cerrar_sesion Matar cookies]
	 * @return [type] [redireccionar]
	 */
	public function cerrar_sesion()
	{
        $this->session->unset_userdata('nombre');
        $this->session->unset_userdata('oficina_origen');
        $this->session->unset_userdata('oficina_codigo');
        $this->session->unset_userdata('oficina_nombre');
        $this->session->unset_userdata('departamento');
        $this->session->unset_userdata('rol');
        $this->session->unset_userdata('rut');
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('last_visited');
        $this->session->unset_userdata('usuid');

        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
	}
	/**
	 * [verificar_usuario virificar usuario]
	 * @param  [type] $rut [rut en formato 11.111.111-0]
	 * @return [type]      [string]
	 */
	public function verificar_usuario($rut)
	{
		$element           = new stdClass;
		$element->rut      = $this->login->limpiar_rut($rut);
		$element->password = $this->input->post('password');
		$elementObj        = (object) $element;
		if ($this->home->verificar_usuario($elementObj) > 0) {
			return TRUE;
		}
	    $this->form_validation->set_message('verificar_usuario', 'Credenciales no coinciden.');
		return FALSE;
	}

	/**
	 * [session creacion para la navegación]
	 * [En base a la config se verifica si tiene movimiento dentro del sistema]
	 * @return [type] [json]
	 */
  	public function session() {
  		$timout = '+' . $this->config->item('sess_time') . ' minutes' ;                        
		// Timeout de la sesion
  		$sessionRenew = date('Y-m-d H:i:s',$this->session->userdata("last_visited"));
		// Ultimo timestamp de cuando se renovó la sesión
  		$sessionExpire = date("Y-m-d H:i:s", strtotime($timout, strtotime($sessionRenew)));
		// Timestamp de cuando caducará la sesión
  		$sessionNow = date("Y-m-d H:i:s");
		// Timestamp de este instante
		// Si estamos en un instante anterior a la caducidad de la sesion solo retornamos true
  		if( $sessionNow < $sessionExpire ){
  			$session['logged'] = true;
  		}
		// Sino devolvemos FALSE y cerramos la sesión
  		else{
  			$session['logged'] = false;
  			$this->session->set_userdata('login') == NULL;
  			redirect(site_url('login'), 'refresh');
  		}
		// Debugging
		// $r['renew']   =  $sessionRenew;
		// $r['expire']  =  $sessionExpire;
		// $r['now']     =  $sessionNow;
		// $r['timeout'] =  $timout;
     	$this->output->set_output(json_encode($session));
  	}
  	/**
  	 * [verificar_rut validar rut chileno]
  	 * @param  [type] $rut [rut formato 11111111-1]
  	 * @return [type]      [Boolean]
  	 */
  	public function verificar_rut($rut)
  	{
		if ($this->login->validar_rut($rut)) {
			return TRUE;
		}
	    $this->form_validation->set_message('verificar_rut', 'Rut no valido.');
		return FALSE;
  	}

  	/**
  	 * [log de navegacion del usuario en base a jquery]
  	 * @return [type] [empty]
  	 */
  	public function log()
  	{
  		if ($this->input->is_ajax_request() || $this->input->post()) {
	  		//Something to write to txt log
	  		$status = $this->input->post('status');
	  		$text = $this->input->post('text');
	  		$data = $this->input->post('data');
	  		$this->home->ins_error($status,$text);
			$log  = "IP: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
			        "Texto: ".($status == 1 ? 'Success':'Failed').PHP_EOL.
			        "Comentario: ".$text.PHP_EOL.
			        "Data: ".$data.PHP_EOL.
			        "Usuario: ".$this->session->rut.PHP_EOL.
			        "-------------------------".PHP_EOL;
			//Save string to log, use FILE_APPEND to append.
			file_put_contents(APPPATH.'logs/./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
  		}
  	}

  	public function maintenance()
  	{
	    $this->output->set_status_header('503'); 
	    $this->load->view($this->maintenance);
  	}
}

/* End of file C_home.php */
/* Location: ./application/controllers/C_home.php */