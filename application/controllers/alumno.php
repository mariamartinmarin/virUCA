<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Alumno extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
	}
	
	public function index()
	{
		if($this->session->userdata('perfil') != 1)
		{
			redirect(base_url().'index.php/login');
		}
		$data['titulo'] = 'Bienvenido!! ' .$this->session->userdata('perfil');
		$this->load->view('alumno_view',$data);
	}

}