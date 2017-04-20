<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Construccion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
	}
	
	public function index()
	{	
		$data['titulo'] = 'Oops!!';
		$this->load->view('Construccion',$data);
	}
}