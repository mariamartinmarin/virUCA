<?php
class Categorias extends CI_Controller{
    public function __construct() {
        parent::__construct(); 
        $this->load->helper("url");  
        $this->load->model("categorias_model");
        $this->load->library("session");
    }
     
    //controlador por defecto
    public function index(){
         
        $categorias["ver"]=$this->categorias_model->ver();
        $this->load->view("categorias",$categorias);
    }
     
    public function nueva(){
        if($this->input->post("submit")){
            $add=$this->categorias_model->nueva($this->input->post("sNombre"), $this->input->post("sDescripcion"));
        }

        if($add==true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, la categoría se registró con éxito.');
        }else{
            $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, parece que hubo un problema y no hemos podido añadir la nueva categoría.');
        }
         
        //redirecciono la pagina a la url por defecto
        redirect(base_url()."index.php/categorias");
    }
     
    public function mod($iId){
        if(is_numeric($iId)){
            $datos["mod"]=$this->categorias_model->mod($iId);
            $this->load->view("categoriasmod_view",$datos);
            if($this->input->post("submit")){
                $mod=$this->categorias_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sNombre"),
                        $this->input->post("sDescripcion"));
                if($mod==true){
                    $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, la categoria se modificó correctamente.');
                }else{
                    $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, no hemos podido modificar los datos.');
                }
                redirect(base_url()."index.php/categorias");
            }
        }else{
            redirect(base_url()."index.php/categorias"); 
        }
    }
     
    //Controlador para eliminar
    public function eliminar($iId){
        if(is_numeric($iId)){
            $eliminar=$this->categorias_model->eliminar($iId);
            if($eliminar==true){
                $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, la categoria se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, no se pudo eliminar la categoria.');
          }
          redirect(base_url()."index.php/categorias");
        }else{
          redirect(base_url()."index.php/categorias");
        }
    }
}
?>