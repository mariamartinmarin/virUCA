<?php
class Partidas extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Partidas_model");
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
        $config['base_url'] = base_url().'index.php/partidas/pagina/';
        $config['total_rows'] = $this->Partidas_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación 
        $data["categorias"] = $this->Partidas_model->get_categorias();      
        $data["partida"] = $this->Partidas_model->total_paginados(
            $config['per_page'],
            $this->uri->segment(3),
            $pages);          
        $data["num_filas"] = $config['total_rows'];
        $this->load->view("partidas",$data);
    }
     
    public function mod($iId){
        if(is_numeric($iId)){
            $datos["mod"]=$this->Partidas_model->mod($iId);
            $datos["respuestas"] = $this->Partidas_model->respuestas($iId);
            $datos["categorias"] = $this->preguntas_model->get_categorias();
            $this->load->view("preguntasmod_view",$datos);
            
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

     
    //Controlador para eliminar
    public function eliminar($iId, $npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        
        if(is_numeric($iId)){
            $eliminar = $this->preguntas_model->eliminar($iId);
            if ($eliminar == true){
                $this->session->set_flashdata('correcto', 
                    '<strong>Bien!</strong> la pregunta se eliminó con éxito.');
            } else {
                $this->session->set_flashdata('incorrecto',
                    '<strong>Oops!</strong> no se pudo eliminar la pregunta.');
            }
            redirect(base_url()."index.php/preguntas/pagina/$npag");
        } else {
          redirect(base_url()."index.php/preguntas/pagina/$npag");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos($npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        
        foreach ($_POST["pregunta"] as $item){
            $eliminar = $this->preguntas_model->eliminar($item);
        }
        if ($eliminar == true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        } else {
            $this->session->set_flashdata('incorrecto', 
                '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/preguntas/pagina/$npag");
    }
}
?>