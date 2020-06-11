<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * @package    
	 * @subpackage 
	 * @author     Paolo Castillo
     * @version    0.1
	 */
class M_menu extends CI_Model {
	private $id_menu = 'ID_MENU';
	private $padre = 'PADRE';
	private $nombre = 'NOMBRE';
	private $icono = 'ICONO';
	private $token = 'TOKEN';
	private $orden = 'ORDEN';
	private $key = 'KEY';
	private $id_rol = 'ID_ROL';
	private $fecha_creacion = 'FECHA_CREACION';
	private $fecha_modificacion = 'FECHA_MODIFICACION';
	private $fecha_eliminacion = 'FECHA_ELIMINACION';
	private $por = 'POR';

	private $tabla = 'PF_MENU_AR';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
	}

	public function get_menu()
	{
		$rol = $this->session->rol;
		$this->db->select('*');
		$this->db->from($this->tabla);
		$this->db->where_in($this->id_rol,$rol);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_padre()
	{
		$this->db->select($this->padre);
		$this->db->from($this->tabla);
		$query = $this->db->get();
		return $query->result_array();
	}
}

/* End of file M_menu.php */
/* Location: ./application/models/M_menu.php */