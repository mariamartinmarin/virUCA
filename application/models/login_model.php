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

	public function get_asignaturas_id($iId) {
		$query = $this->db->query("select distinct iId_Asignatura from usuarioscurso where iId_Usuario = $iId");
		if ($query->num_rows() > 0) {
			$i = 0;
      		foreach ($query->result() as $row) {
        		$a[$i] = $row->iId_Asignatura;
        		$i++;
      		}
      	$query->free_result();
      	return $a;
    	}
	}

	public function get_universidades_id($iId) {
		$query = $this->db->query("select distinct iId_Universidad from usuarioscurso where iId_Usuario = $iId");
		if ($query->num_rows() > 0) {
			$i = 0;
      		foreach ($query->result() as $row) {
        		$a[$i] = $row->iId_Universidad;
        		$i++;
      		}
      	$query->free_result();
      	return $a;
    	}
	}

	public function get_titulaciones_id($iId) {
		$query = $this->db->query("select distinct iId_Titulacion from usuarioscurso where iId_Usuario = $iId");
		if ($query->num_rows() > 0) {
			$i = 0;
      		foreach ($query->result() as $row) {
        		$a[$i] = $row->iId_Titulacion;
        		$i++;
      		}
      	$query->free_result();
      	return $a;
    	}
	}
}