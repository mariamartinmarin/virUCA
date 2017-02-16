<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Titulacion_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}
 	public function get_titulaciones($iId = false){
 		$query = $this->db->get('titulacion');
 		return $query->result_array();
 	}
}