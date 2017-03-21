<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inactiva extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->database('default');
    }
	
	public function index()
	{	
		$data['titulo'] = 'Oops!!';
		$this->load->view('inactiva',$data);
	}
}