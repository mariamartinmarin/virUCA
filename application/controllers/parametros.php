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
        if($this->session->userdata('perfil') != 0)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }
        $data["parametros"] = $this->parametros_model->ver();
        $this->load->view("parametros",$data);
    }
     
    public function mod(){
        //$datos["parametros"]=$this->parametros_model->mod();
        //$this->load->view("parametros",$datos);
        
        $activa = 1;
        if ($this->input->post("iActiva")[0] == "") $activa = 0;
                  
        $mod = $this->parametros_model->mod($activa);
        if ($mod == true){
            $this->session->set_flashdata('parametros_ok', '<strong>Bien!</strong> cambios efectuados.');
        }else{
            $this->session->set_flashdata('parametros_ko', '<strong>Oops!</strong> los cambios no se llevaron a cabo.');
        }

        redirect(base_url()."index.php/parametros/");   
    }
}
?>