<?php
class Preguntasalta extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("preguntas_model");
        $this->load->library("session");
        $this->load->library('pagination');
    }
     
    //controlador por defecto
    public function index($iId="NULL"){  
        if($this->session->userdata('perfil') != 0)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }
        $data["categorias"] = $this->preguntas_model->get_categorias();      
        $this->load->view("preguntasalta",$data);
    }

    public function nueva(){
        if($this->input->post("submit")){
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sPregunta','Pregunta','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp1','Respuesta A','trim|required|max_length[512]|min_length[2]');
            $this->form_validation->set_rules('sResp2','Respuesta B','trim|required|max_length[512]|min_length[2]');
            $this->form_validation->set_rules('sResp3','Respuesta C','trim|required|max_length[512]|min_length[2]');
            $this->form_validation->set_rules('sResp4','Respuesta D','trim|required|max_length[512]|min_length[2]');
            $this->form_validation->set_rules('nPuntuacion', 'Puntuación', 'trim|required|numeric');
            
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '<b>%s</b> es obligatorio.');
            $this->form_validation->set_message('min_length', 
                '<b>%s</b> debe tener al menos </b>%s</b> caracteres.');
            $this->form_validation->set_message('max_length', 
                '<b>%s</b> no puede tener más de <b>%s</b> caracteres.');
            $this->form_validation->set_message('numeric', '<b>%s</b> debe ser un valor numérico (entero o decimal separado por <b>punto</b>).');

            if ($this->form_validation->run() == FALSE) {
                $this->index();
            } else {
                // Hacemos la inserción. Hay que insertar en dos tablas, pregunta y respuestas.
                $activa = 0;
                $add=$this->preguntas_model->nueva(
                    $this->input->post("sPregunta"), 
                    $this->input->post("sResp1"),
                    $this->input->post("sResp2"),
                    $this->input->post("sResp3"),
                    $this->input->post("sResp4"),
                    $this->input->post("sCategorias"),
                    $activa, 
                    $this->input->post("iId_Usuario"), 
                    $this->input->post("nPuntuacion"),
                    $this->input->post("verdadera"),
                    $this->input->post("sObservaciones"));
                if ( add == true ){
                    $this->session->set_flashdata('correcto', 
                        '<strong>Bien!</strong> la pregunta se registró con éxito.');
                }else{
                    $this->session->set_flashdata('incorrecto', 
                        '<strong>Oops!</strong> parece que hubo un problema y no hemos podido añadir la pregunta.');
                }       
                redirect(base_url()."index.php/preguntas/");
            }
        }
    }
     
    public function mod($iId){
        if(is_numeric($iId)){
            $datos["mod"]=$this->preguntas_model->mod($iId);
            $datos["respuestas"] = $this->preguntas_model->respuestas($iId);
             $datos["categorias"] = $this->preguntas_model->get_categorias();
            $this->load->view("preguntasmod_view",$datos);
            
            if($this->input->post("submit")){
            
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sPregunta','Pregunta','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp1','Respuesta A','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp2','Respuesta B','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp3','Respuesta C','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp4','Respuesta D','trim|required|max_length[512]|min_length[10]');
            
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '%s es obligatorio.');
            $this->form_validation->set_message('valid_email', 'El %s no es válido.');
            $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
            $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');

            if ($this->form_validation->run() == FALSE) {   
                $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> no hemos podido modificar la pregunta.');               
                redirect(base_url()."index.php/preguntas/mod/".$iId, "refresh");
            } else {
                $activa = 1;
                if ($this->input->post("bActiva")[0] == "") $activa = 0;
                $mod=$this->preguntas_model->mod(
                    $iId,
                    $this->input->post("submit"),
                    $this->input->post("sPregunta"),
                    $this->input->post("sResp1"),
                    $this->input->post("sResp2"),
                    $this->input->post("sResp3"),
                    $this->input->post("sResp4"),
                    $this->input->post("iCategoria"),
                    $activa, 
                    $this->input->post("iId_Usuario"), 
                    $this->input->post("nPuntuacion"),
                    $this->input->post("verdadera"),
                    $this->input->post("sObservaciones"));

                if ($mod == true) {
                    $this->session->set_flashdata('profesor_ok', '<strong>Bien!</strong> la pregunta se modificó con éxito.');
                } else {
                    $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> no hemos podido modificar la pregunta.');
                    }

                    redirect(base_url()."index.php/preguntas/mod/".$iId, "refresh");
                }
            }
        } else {
            redirect(base_url()."index.php/preguntas"); 
        }
    }

     
   
}
?>