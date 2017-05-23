<?php
class Cuestion extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Cuestion_model");
        $this->load->library("session");
    }
     
    //controlador por defecto
    public function index(){  
        if($this->session->userdata('perfil') != 0)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }
        $data["pregunta"] = $this->Cuestion_model->obtener_pregunta();
        $data["resumen"] = $this->Cuestion_model->get_resumen_partida();
        
        $this->load->view("cuestion",$data);
    }
    
    
}
?>