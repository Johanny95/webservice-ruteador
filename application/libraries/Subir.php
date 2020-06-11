<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subir
{
	protected $ci;
	private $dir_upload = 'uploads';
	private $dir_upload_meta = 'uploads/metas';
	private $dir_upload_meta_vendedor = 'uploads/vendedor';
	private $dir_upload_maquina = 'uploads/maquinas'; //Máquinas
	private $dir_upload_transaccion = 'uploads/transacciones'; //Transacciones
	private $dir_upload_visitas = 'uploads/visitas'; //Visitas
	private $dir_upload_ruta = 'uploads/ruta';
	private $dir_upload_ruta_vendedor = 'uploads/ruta/vendedor';
	private $dir_upload_ruta_oficina = 'uploads/ruta/oficina';

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	public function get_dir_meta()
	{
		return $this->dir_upload_meta;
	}

	//Máquinas
	public function get_dir_maquina()
	{
		return $this->dir_upload_maquina;
	}

	//Transacciones
	public function get_dir_transaccion()
	{
		return $this->dir_upload_transaccion;
	}

	//Visitas
	public function get_dir_visitas()
	{
		return $this->dir_upload_visitas;
	}

	public function get_dir_ruta_vendedor()
	{
		return $this->dir_upload_ruta_vendedor;
	}

	public function get_dir_ruta_oficina()
	{
		return $this->dir_upload_ruta_oficina;
	}

	public function dir_upload()
	{
		if (!is_dir($this->dir_upload)) {
			mkdir($this->dir_upload);
		}
	}

	public function dir_upload_meta()
	{
		$this->dir_upload();
		if (!is_dir($this->dir_upload_meta)) {
			mkdir($this->dir_upload_meta);
		}
	}

	//Máquinas
	public function dir_upload_maquina()
	{
		$this->dir_upload();
		if (!is_dir($this->dir_upload_maquina)) {
			mkdir($this->dir_upload_maquina);
		}
	}

	//Transacciones
	public function dir_upload_transaccion()
	{
		$this->dir_upload();
		if (!is_dir($this->dir_upload_transaccion)) {
			mkdir($this->dir_upload_transaccion);
		}
	}

	//Visitas
	public function dir_upload_visitas()
	{
		$this->dir_upload();
		if (!is_dir($this->dir_upload_visitas)) {
			mkdir($this->dir_upload_visitas);
		}
	}

	public function get_dir_vendedor()
	{
		return $this->dir_upload_meta_vendedor;
	}

	public function dir_upload_meta_vendedor()
	{
		$this->dir_upload();
		if (!is_dir($this->dir_upload_meta_vendedor)) {
			mkdir($this->dir_upload_meta_vendedor);
		}
	}

	// ruta
	public function dir_upload_ruta()
	{
		if (!is_dir($this->dir_upload)) {
			mkdir($this->dir_upload);
			if (!is_dir($this->dir_upload_ruta)) {
				mkdir($this->dir_upload_ruta);
			}
		}
	}

	// ruta vendedor
	public function dir_upload_ruta_vendedor()
	{
		if (!is_dir($this->dir_upload_ruta_vendedor)) {
			mkdir($this->dir_upload_ruta_vendedor);
		}
	}

	// ruta vendedor
	public function dir_upload_ruta_oficina()
	{
		if (!is_dir($this->dir_upload_ruta_oficina)) {
			mkdir($this->dir_upload_ruta_oficina);
		}
	}

	public function upload_meta()
	{
		$this->dir_upload_meta();
		$ci = &get_instance();
		$ci->load->library('upload');
		$config['upload_path']   = realpath(APPPATH. '../uploads/metas');
		$config['file_name']     = date('d-m-Y_h-i-s').'_metas_'.$ci->session->rut;
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size']      = '*';
	    $ci->upload->initialize($config);
		if (!$ci->upload->do_upload('file')){
			$error = array('error' => '<span class="help-block">'.$ci->upload->display_errors().'</span>', 'status' => FALSE);
			return $error;
		}
		else{
			$data = array('upload_data' => $ci->upload->data(), 'status' => TRUE);
			return $data;
		}
	}

	public function upload_meta_vendedor()
	{
		$this->dir_upload_meta_vendedor();
		$ci = &get_instance();
		$ci->load->library('upload');
		$config['upload_path']   = realpath(APPPATH. '../uploads/vendedor');
		$config['file_name']     = date('d-m-Y_h-i-s').'_metas_'.$ci->session->rut;
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size']      = '*';
	    $ci->upload->initialize($config);
		if (!$ci->upload->do_upload('file')){
			$error = array('error' => '<span class="help-block">'.$ci->upload->display_errors().'</span>', 'status' => FALSE);
			return $error;
		}
		else{
			$data = array('upload_data' => $ci->upload->data(), 'status' => TRUE);
			return $data;
		}
	}

	//Máquinas
	public function upload_maquina()
	{
		$this->dir_upload_maquina();
		$ci = &get_instance();
		$ci->load->library('upload');
		$config['upload_path']   = realpath(APPPATH. '../uploads/maquinas');
		$config['file_name']     = date('d-m-Y_h-i-s').'_maquinas_'.$ci->session->rut;
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size']      = '*';
	    $ci->upload->initialize($config);
		if (!$ci->upload->do_upload('file')){
			$error = array('error' => '<span class="help-block">'.$ci->upload->display_errors().'</span>', 'status' => FALSE);
			return $error;
		}
		else{
			$data = array('upload_data' => $ci->upload->data(), 'status' => TRUE);
			return $data;
		}
	}

	//Transacciones
	public function upload_transaccion()
	{
		$this->dir_upload_transaccion();
		$ci = &get_instance();
		$ci->load->library('upload');
		$config['upload_path']   = realpath(APPPATH. '../uploads/transacciones');
		$config['file_name']     = date('d-m-Y_h-i-s').'_transacciones_'.$ci->session->rut;
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size']      = '*';
	    $ci->upload->initialize($config);
		if (!$ci->upload->do_upload('file')){
			$error = array('error' => '<span class="help-block">'.$ci->upload->display_errors().'</span>', 'status' => FALSE);
			return $error;
		}
		else{
			$data = array('upload_data' => $ci->upload->data(), 'status' => TRUE);
			return $data;
		}
	}

	//Visitas
	public function upload_visitas()
	{
		$this->dir_upload_visitas();
		$ci = &get_instance();
		$ci->load->library('upload');
		$config['upload_path']   = realpath(APPPATH. '../uploads/visitas');
		$config['file_name']     = date('d-m-Y_h-i-s').'_visitas_'.$ci->session->rut;
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size']      = '*';
	    $ci->upload->initialize($config);
		if (!$ci->upload->do_upload('file')){
			$error = array('error' => '<span class="help-block">'.$ci->upload->display_errors().'</span>', 'status' => FALSE);
			return $error;
		}
		else{
			$data = array('upload_data' => $ci->upload->data(), 'status' => TRUE);
			return $data;
		}
	}

	//Ruta Vendedor
	public function upload_ruta_vendedor()
	{
		$this->dir_upload_ruta();
		$this->dir_upload_ruta_vendedor();
		$ci = &get_instance();
		$ci->load->library('upload');
		$config['upload_path']   = realpath(APPPATH. '../uploads/ruta/vendedor');
		$config['file_name']     = date('d-m-Y_h-i-s').'_ruta_'.$ci->session->rut;
		$config['allowed_types'] = 'kml';
		$config['max_size']      = '*';
	    $ci->upload->initialize($config);
		if (!$ci->upload->do_upload('file')){
			$error = array('error' => '<span class="help-block">'.$ci->upload->display_errors().'</span>', 'status' => FALSE);
			return $error;
		}
		else{
			$data = array('upload_data' => $ci->upload->data(), 'status' => TRUE);
			return $data;
		}
	}

	//Ruta Oficina
	public function upload_ruta_oficina()
	{
		$this->dir_upload_ruta();
		$this->dir_upload_ruta_oficina();
		$ci = &get_instance();
		$ci->load->library('upload');
		$config['upload_path']   = realpath(APPPATH. '../uploads/ruta/oficina');
		$config['file_name']     = date('d-m-Y_h-i-s').'_ruta_'.$ci->session->rut;
		$config['allowed_types'] = 'kml';
		$config['max_size']      = '*';
	    $ci->upload->initialize($config);
		if (!$ci->upload->do_upload('file')){
			$error = array('error' => '<span class="help-block">'.$ci->upload->display_errors().'</span>', 'status' => FALSE);
			return $error;
		}
		else{
			$data = array('upload_data' => $ci->upload->data(), 'status' => TRUE);
			return $data;
		}
	}
}

/* End of file Funciones.php */
/* Location: ./application/libraries/Funciones.php */
