<?php
class Preguntas extends CI_Controller{
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
        $pages=20; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'index.php/preguntas/pagina/';
        $config['total_rows'] = $this->preguntas_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación 
        $data["categorias"] = $this->preguntas_model->get_categorias();      
        $data["pregunta"] = $this->preguntas_model->total_paginados($config['per_page'],$this->uri->segment(3));          
        
        $this->load->view("preguntas",$data);
    }

    public function mod_view($iId){
       $usuarios["verPregunta"]=$this->pregunta_model->verPregunta($iId);
       $this->load->view("preguntasmod_view",$usuarios);
    }
    
    public function nueva(){
        if($this->input->post("submit")){
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sPregunta','Pregunta','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp1','Respuesta A','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp2','Respuesta B','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp3','Respuesta C','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp4','Respuesta D','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('nPuntuacion', 'Puntuación', 'trim|required|decimal');
            
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '<b>%s</b> es obligatorio.');
            $this->form_validation->set_message('min_length', 
                '<b>%s</b> debe tener al menos </b>%s</b> caracteres.');
            $this->form_validation->set_message('max_length', 
                '<b>%s</b> no puede tener más de <b>%s</b> caracteres.');
            $this->form_validation->set_message('decimal', '<b>%s</b> debe ser un valor numérico.');

            if ($this->form_validation->run() == FALSE) {
                $this->index();
            } else {
                // Hacemos la inserción. Hay que insertar en dos tablas, pregunta y respuestas.
                 $add=$this->preguntas_model->nueva(
                    $this->input->post("sPregunta"), 
                    $this->input->post("sResp1"),
                    $this->input->post("sResp2"),
                    $this->input->post("sResp3"),
                    $this->input->post("sResp4"),
                    $this->input->post("sCategorias"),
                    $this->input->post("bActiva"), 
                    $this->input->post("iId_Usuario"), 
                    $this->input->post("nPuntuacion"),
                    $this->input->post("verdadera"),
                    $this->input->post("sObservaciones"));
                if ( add == true){
                    $this->session->set_flashdata('correcto', 
                        '<strong>Bien!</strong> la pregunta se registró con éxito.');
                }else{
                    $this->session->set_flashdata('incorrecto', 
                        '<strong>Oops!</strong> parece que hubo un problema y no hemos podido añadir la pregunta.');
                }       
                redirect(base_url()."index.php/pregunta");
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
                $mod=$this->preguntas_model->mod(
                    $iId,
                    $this->input->post("submit"),
                    $this->input->post("sPregunta"),
                    $this->input->post("sResp1"),
                    $this->input->post("sResp2"),
                    $this->input->post("sResp3"),
                    $this->input->post("sResp4"),
                    $this->input->post("iCategoria"),
                    $this->input->post("bActiva"), 
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

     
    //Controlador para eliminar
    public function eliminar($iId){
        if(is_numeric($iId)){
            $eliminar = $this->preguntas_model->eliminar($iId);
            if ($eliminar == true){
                $this->session->set_flashdata('correcto', 
                    '<strong>Bien!</strong> la pregunta se eliminó con éxito.');
            } else {
                $this->session->set_flashdata('incorrecto',
                    '<strong>Oops!</strong> no se pudo eliminar la pregunta.');
            }
            redirect(base_url()."index.php/preguntas");
        } else {
          redirect(base_url()."index.php/preguntas");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos(){
        foreach ($_POST["pregunta"] as $item){
            $eliminar = $this->preguntas_model->eliminar($item);
        }
        if ($eliminar == true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        } else {
            $this->session->set_flashdata('incorrecto', 
                '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/preguntas");
    }
}
?>