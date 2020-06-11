<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_denegado extends CI_Controller {
	private $denegado = 'errors/html/error_denegado';
	private $override = 'errors/html/error_404';

	public function __construct()
	{
		parent::__construct();
	}

	public function denegado()
	{
		$this->load->view($this->denegado);
	}

	public function override()
	{
		$this->load->view($this->override);
	}
}

/* End of file C_denegado.php */
/* Location: ./application/controllers/C_denegado.php */