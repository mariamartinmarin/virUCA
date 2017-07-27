<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ayuda extends CI_Controller{
    public function __construct() {
        parent::__construct();  
        $this->load->library("session");
    }
    
    //controlador por defecto
    public function index(){
        $this->load->helper('url');
        $this->load->view("ayuda");
    }

}
?>