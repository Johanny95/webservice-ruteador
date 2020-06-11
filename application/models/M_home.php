<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_home extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

}

/* End of file M_home.php */
/* Location: ./application/models/M_home.php */