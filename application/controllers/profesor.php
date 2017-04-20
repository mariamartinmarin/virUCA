<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profesor extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
	}
	
	public function index()
	{
		// POr aquí no está entrando OJO.
		if($this->session->userdata('perfil') != 0)
		{
			redirect(base_url().'index.php/login');
		}
		if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }
		$data['titulo'] = 'Bienvenido Administrador';
		$this->load->view('profesor_view',$data);
	}
}