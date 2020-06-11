<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controlador  Home
	 * 
	 * @Package		
	 * @Autor       Paolo Castillo
	 * @link        <http://url/dashboard_meta/index.php/inicio.html>
	 */

	/**
	 * Controlador   Class
	 * HO_Controller HO_Controller
	 * @subpackage   Libreria Login
	 * @categoria    Libreria
	 */
class C_home extends HE_Controller {

	private $body = 'home/dashboard'; 
	/**
	 * [__construct cargar modelo]
	 */
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * [inicio vista inicio]
	 * @return [type] [vista]
	 */
	public function inicio()
	{
		$this->load->view($this->view_head());
		// $this->load->view('home/dashboard');
		$this->load->view($this->view_footer());
	}

}

/* End of file C_home.php */
/* Location: ./application/controllers/C_home.php */