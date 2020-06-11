<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends CI_Model {
	private $id = 'U.USUID';
	private $nombre = 'U.USUNOM';
	private $oficina_origen = 'U.OF_ORIGEN';
	private $oficina_codigo = 'U.OFICOD';
	private $oficina_nombre = 'O.NOMBRE_OFICINA';
	private $id_login = 'U.USULOGIN';
	private $nombre_departamento = 'D.NOM_DEPTO';
	private $rol = 'I.ROLID';

	private $webusuario = 'WEBUSUARIO U';
	private $webdepartamento = 'PF_MA_DEPARTAMENTOS D';
	private $weboficina = 'PF_OFICINA@OBIOPER O';
	private $webrol = 'ITR_USUROL I';

	private $where_departamento = 'U.ID_DEPTO = D.ID_DEPTO';
	private $where_oficina = 'O.CODIGO_OFICINA = U.OF_ORIGEN';
	private $where_id = 'I.USUID = U.USUID';

	private $where_login = 'U.RUT_USUARIO';
	private $where_clave = 'USUCLAVE';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function verificar_usuario($element)
	{
		$array = array('03');
		$this->db->select($this->id);
		$this->db->select($this->nombre);
		$this->db->select($this->oficina_origen);
		$this->db->select($this->oficina_codigo);
		$this->db->select($this->oficina_nombre);
		$this->db->select($this->id_login);
		$this->db->select($this->nombre_departamento);
		$this->db->select($this->rol);
		$this->db->from($this->webusuario);
		$this->db->join($this->webrol, $this->where_id,NULL, FALSE);
		$this->db->join($this->webdepartamento, $this->where_departamento,'LEFT', FALSE);
		$this->db->join($this->weboficina, $this->where_oficina,'LEFT', FALSE);
		$this->db->where($this->where_login,$element->rut);
		$this->db->where($this->where_clave,$element->password);
		$this->db->where($this->where_clave,$element->password);
		$this->db->where_in($this->rol,$array);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_usuario($rut)
	{
		$this->db->select($this->id);
		$this->db->select($this->nombre);
		$this->db->select($this->oficina_origen);
		$this->db->select($this->oficina_codigo);
		$this->db->select($this->oficina_nombre);
		$this->db->select($this->id_login);
		$this->db->select($this->nombre_departamento);
		$this->db->select($this->rol);
		$this->db->from($this->webusuario);
		$this->db->join($this->webrol, $this->where_id,NULL, FALSE);
		$this->db->join($this->webdepartamento, $this->where_departamento,'LEFT', FALSE);
		$this->db->join($this->weboficina, $this->where_oficina,'LEFT', FALSE);
		$this->db->where($this->where_login,$rut);
		$query = $this->db->get();
		return $query->result();
	}

	public function ins_error($status,$text)
	{
		$text = $this->session->rut .' '. $text;
		$sp = oci_parse($this->db->conn_id, "BEGIN PF_SYS_INVENTARIO.INS_ERROR(:P_STATUS,:P_COMENTARIO); END;");
        oci_bind_by_name($sp, ":P_STATUS"       ,    $status);
        oci_bind_by_name($sp, ":P_COMENTARIO"   ,    $text  );
        oci_execute($sp, OCI_DEFAULT);
	}
}

/* End of file M_home.php */
/* Location: ./application/models/M_home.php */