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
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sNombre', 'Nombre', 'trim|required|max_length[32]|min_length[2]');
            
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '%s es obligatorio.');
            $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
            $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');

            if ($this->form_validation->run() == FALSE) {
                // Si la validación no se pasa, volvemos al directorio raiz.
                $this->index();
            } else {
                // Hacemos la inserción.
                 $add=$this->categorias_model->nueva(
                    $this->input->post("sNombre"),
                    $this->input->post("sDescripcion"));
                if ($add == true){
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('categoria_ok', '<strong>Bien!</strong>, la categoría se registró con éxito.');
                }else{
                    $this->session->set_flashdata('categoria_ko', '<strong>Oops!</strong>, parece que hubo un problema y no hemos podido añadir la nueva categoría.');
                }       
                redirect(base_url()."index.php/categorias", "refresh");
            }
        }
    }
     
    public function mod($iId){
        if(is_numeric($iId)){
            $datos["mod"]=$this->categorias_model->mod($iId);
            $this->load->view("categoriasmod_view",$datos);
            
            if($this->input->post("submit")){
                // Hay que volver a validar los datos.
                $this->form_validation->set_rules('sNombre', 'Nombre', 'trim|required|max_length[32]|min_length[2]');
                
                // Una vez establecidas las reglas, validamos los campos.
                $this->form_validation->set_message('required', '%s es obligatorio.');
                $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
                $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');
                
                if ($this->form_validation->run() == FALSE) {   
                    $this->session->set_flashdata('categoria_ko', '<strong>Oops!</strong>, no hemos podido modificar los datos de la categoría.');               
                    redirect(base_url()."index.php/categorias/mod/".$iId, "refresh");
                } else {
                    $mod=$this->categorias_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sNombre"),
                        $this->input->post("sDescripcion"));
                    if($mod==true){
                        $this->session->set_flashdata('categoria_ok', '<strong>Bien!</strong>, la categoría se modificó correctamente.');
                    }else{
                        $this->session->set_flashdata('categoria_ko', '<strong>Oops!</strong>, no hemos podido modificar la categoría.');
                    }

                    redirect(base_url()."index.php/categorias/mod/".$iId, "refresh");

                }
            }
        } else {
            redirect(base_url()."index.php/categorias"); 
        }


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