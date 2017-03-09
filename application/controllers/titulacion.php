<?php
class Titulacion extends CI_Controller{
    public function __construct() {
        //llamamos al constructor de la clase padre
        parent::__construct(); 
         
        //llamo al helper url
        $this->load->helper("url");  
         
        //llamo o incluyo el modelo
        $this->load->model("titulacion_model");
         
        //cargo la libreria de sesiones
        $this->load->library("session");
    }
     
    //controlador por defecto
    public function index(){
         
        //array asociativo con la llamada al metodo
        //del modelo
        $usuarios["ver"]=$this->titulacion_model->ver();
         
        //cargo la vista y le paso los datos
        $this->load->view("titulacion",$usuarios);
    }
     
    //controlador para añadir
    public function nueva(){
         
        //compruebo si se a enviado submit
        if($this->input->post("submit")){
         
        //llamo al metodo add
        $add=$this->titulacion_model->nueva($this->input->post("sTitulacion"));
        }
        if($add==true){
            //Sesion de una sola ejecución
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, la titulación se registró con éxito.');
        }else{
            $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, parece que hubo un problema y no hemos podido añadir la nueva titulación.');
        }
         
        //redirecciono la pagina a la url por defecto
        redirect(base_url()."index.php/titulacion");
    }
     
    //controlador para modificar al que 
    //le paso por la url un parametro
    public function mod($iId){
        if(is_numeric($iId)){
          $datos["mod"]=$this->titulacion_model->mod($iId);
          $this->load->view("titulacionmod_view",$datos);
          if($this->input->post("submit")){
                $mod=$this->titulacion_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sTitulacion"));
                if($mod==true){
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, la titulación se modificó correctamente.');
                }else{
                    $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, no hemos podido modificar los datos.');
                }
                redirect(base_url()."index.php/titulacion");
            }
        }else{
            redirect(base_url()."index.php/titulacion"); 
        }
    }
     
    //Controlador para eliminar
    public function eliminar($iId){
        if(is_numeric($iId)){
          $eliminar=$this->titulacion_model->eliminar($iId);
          if($eliminar==true){
              $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, la titulación se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, no se pudo eliminar la titulación.');
          }
          redirect(base_url()."index.php/titulacion");
        }else{
          redirect(base_url()."index.php/titulacion");
        }
    }
}
?>