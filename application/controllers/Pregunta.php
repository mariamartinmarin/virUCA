<?php
class Pregunta extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("pregunta_model");
        $this->load->library("session");
        $this->load->library('pagination');
    }
     
    //controlador por defecto
    public function index($iId="NULL"){  
        if($this->session->userdata('perfil') != 1)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }
        $pages=5; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'index.php/pregunta/pagina/';
        $config['total_rows'] = $this->pregunta_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación 
        $data["categorias"] = $this->pregunta_model->get_categorias();      
        $data["pregunta"] = $this->pregunta_model->total_paginados(
            $config['per_page'],
            $this->uri->segment(3),
            $pages);          
        $data["num_filas"] = $config['total_rows'];
        $data["iEdicion"] = $this->pregunta_model->get_edicion();
        $this->load->view("pregunta",$data);
    }

    public function mod_view($iId){
       $usuarios["verPregunta"]=$this->pregunta_model->verPregunta($iId);
       $usuarios["iEdicion"] = $this->pregunta_model->get_edicion();
       $this->load->view("preguntamod_view",$usuarios);
    }
    
    public function nueva(){
        if($this->input->post("submit")){
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sPregunta','Pregunta','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp1','Respuesta A','trim|required|max_length[512]');
            $this->form_validation->set_rules('sResp2','Respuesta B','trim|required|max_length[512]');
            $this->form_validation->set_rules('sResp3','Respuesta C','trim|required|max_length[512]');
            $this->form_validation->set_rules('sResp4','Respuesta D','trim|required|max_length[512]');

            
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '%s es obligatorio.');
            $this->form_validation->set_message('valid_email', 'El %s no es válido.');
            $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
            $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');

            if ($this->form_validation->run() == FALSE) {
                $this->index();
            } else {
                // Hacemos la inserción. Hay que insertar en dos tablas, pregunta y respuestas.
                 $add=$this->pregunta_model->nueva(
                    $this->input->post("sPregunta"), 
                    $this->input->post("sResp1"),
                    $this->input->post("sResp2"),
                    $this->input->post("sResp3"),
                    $this->input->post("sResp4"),
                    $this->input->post("sCategorias"),
                    $this->input->post("bActiva"), 
                    $this->input->post("iId_Usuario"), 
                    $this->input->post("nPuntuacion"),
                    $this->input->post("verdadera"));
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
            $datos["mod"]=$this->pregunta_model->mod($iId);
            $datos["respuestas"] = $this->pregunta_model->respuestas($iId);
            $datos["categorias"] = $this->pregunta_model->get_categorias();
            $this->load->view("preguntamod_view",$datos);
            
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
                redirect(base_url()."index.php/pregunta/mod/".$iId, "refresh");
            } else {
                $mod=$this->pregunta_model->mod(
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
                    $this->input->post("verdadera"));

                if ($mod == true) {
                    $this->session->set_flashdata('profesor_ok', '<strong>Bien!</strong> la pregunta se modificó con éxito.');
                } else {
                    $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong>, no hemos podido modificar la pregunta.');
                    }

                    redirect(base_url()."index.php/pregunta/mod/".$iId, "refresh");
                }
            }
        } else {
            redirect(base_url()."index.php/pregunta"); 
        }
    }

     
    //Controlador para eliminar
    public function eliminar($iId, $npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        if(is_numeric($iId)){
            $eliminar=$this->pregunta_model->eliminar($iId);
            if($eliminar==true){
                $this->session->set_flashdata('correcto', 
                    '<strong>Bien!</strong> la pregunta se eliminó con éxito.');
            } else {
                $this->session->set_flashdata('incorrecto',
                    '<strong>Oops!</strong> no se pudo eliminar la pregunta.');
            }
            redirect(base_url()."index.php/pregunta/pagina/$npag");
        } else {
          redirect(base_url()."index.php/pregunta/pagina/$npag");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos($npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        foreach ($_POST["pregunta"] as $item){
            $eliminar=$this->pregunta_model->eliminar($item);
        }
        if ($eliminar == true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        } else {
            $this->session->set_flashdata('incorrecto', 
                '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/pregunta/pagina/$npag");
    }
}
?>