<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto extends CI_Controller{
    public function __construct() {
        parent::__construct();  
        //$this->load->model("Contacto_model");
        $this->load->library("session");
    }
    
    //controlador por defecto
    public function index(){
        $this->load->helper('url');
        $this->load->view("contacto");
    }

}
?>