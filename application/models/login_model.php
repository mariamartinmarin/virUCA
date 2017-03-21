<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Login_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function aplicacion_activa() {
		$this->db->where('iId',0);
		$query = $this->db->get('parametros');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}else{
			return 0;
		}
	}
	
	public function login_user($username,$password)
	{
		$this->db->where('sUsuario',$username);
		$this->db->where('sPassword',$password);
		$query = $this->db->get('usuario');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}else{
			$this->session->set_flashdata('usuario_incorrecto','Los datos introducidos son incorrectos');
			redirect(base_url().'index.php/login','refresh');
		}
	}
}