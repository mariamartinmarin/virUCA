<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Viruca extends CI_Controller {
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('titulacion_model');
		$this->load->helper('url_helper');	
	}		

	public function index()
	{
		$data['titulo'] = "Consulta de las titulaciones.";
		$data['titulaciones'] = $this->titulacion_model->get_titulaciones();

		$this->load->view('home', $data);
	}

	public function view() {
		$data['titulaciones_item'] = $this->titulacion_model->get_titulaciones();
	}
}
