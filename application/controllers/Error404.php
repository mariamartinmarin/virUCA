<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
class Error404 extends CI_Controller { 
   public function index(){
   		$data['titulo'] = "Oops! parece que hubo un problema.";
   		$this->load->view('error404',$data);
   }
}