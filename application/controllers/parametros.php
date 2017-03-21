<?php
class Parametros extends CI_Controller{
    public function __construct() {
        parent::__construct(); 
        $this->load->helper("url");  
        $this->load->model("parametros_model");
        $this->load->library("session");
    }
     
    //controlador por defecto
    public function index(){
         
        $data["parametros"] = $this->parametros_model->ver();
        $this->load->view("parametros",$data);
    }
     
    public function mod(){
        //$datos["parametros"]=$this->parametros_model->mod();
        //$this->load->view("parametros",$datos);
        $dato = $this->input->post("iActiva");  
        $mod = $this->parametros_model->mod($dato[0]);
        if ($mod == true){
            $this->session->set_flashdata('parametros_ok', '<strong>Bien!</strong> cambios efectuados.');
        }else{
            $this->session->set_flashdata('parametros_ko', '<strong>Oops!</strong> los cambios no se llevaron a cabo.');
        }

        redirect(base_url()."index.php/parametros/");   
    }
}
?>