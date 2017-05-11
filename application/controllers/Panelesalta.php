<?php
class Panelesalta extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Panelesalta_model");
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
        $data["categorias"] = $this->Panelesalta_model->get_categorias();      
        $this->load->view("panelesalta",$data);
    }

    public function nueva(){
        if($this->input->post("submit")){
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sNombre','Nombre','trim|required|max_length[32]|min_length[5]');
            $this->form_validation->set_rules('iCasillas', 'Número de casillas', 'trim|required|integer|greater_than[5]');
            
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '<b>%s</b> es obligatorio.');
            $this->form_validation->set_message('greater_than', '<b>%s</b> debe ser un valor entero igual o superior a %s.');
            $this->form_validation->set_message('integer', '<b>%s</b> sólo admite datos de tipo entero.');
            $this->form_validation->set_message('min_length', 
                '<b>%s</b> debe tener al menos </b>%s</b> caracteres.');
            $this->form_validation->set_message('max_length', 
                '<b>%s</b> no puede tener más de <b>%s</b> caracteres.');
            
            if ($this->form_validation->run() == FALSE) {
                $this->index();
            } else {
                // Hacemos la inserción. Aquí insertaremos el panel y generamos tantas casillas por defecto como 
                // se haya indicado por el usuario.
                $activa = 0;
                $add = $this->Panelesalta_model->nueva(
                    $this->input->post("sNombre"), 
                    $this->input->post("iCasillas"));

                if ( $add == true ) {
                    $this->session->set_flashdata('correcto', 
                        '<strong>Bien!</strong> el panel ha sido dado de alta con éxito. Para personalizar las casillas, proceda a la modificación del mismo.');
                } else {
                    $this->session->set_flashdata('incorrecto', 
                        '<strong>Oops!</strong> parece que hubo un problema y no se ha podido dar de alta el panel, inténtelo más tarde o contacte con el administrador del sitio.');
                }       
                redirect(base_url()."index.php/panelesalta/");
            }
        }
    }

    public function get_random_cat() {
        return $this->Panelesalta_model->get_random_cat();
    }
     
    public function mod($iId){
        if(is_numeric($iId)){
            $datos["mod"]=$this->panelesalta_model->mod($iId);
            $datos["categorias"] = $this->preguntas_model->get_categorias();
            $this->load->view("panelesaltamod_view",$datos);
            
            if($this->input->post("submit")){
            
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sNombre','Nombre','trim|required|max_length[32]|min_length[5]');
            $this->form_validation->set_rules('iCasillas', 'Número de casillas', 'trim|required|integer|greater_than[$nCategorias]');
            
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '<b>%s</b> es obligatorio.');
            $this->form_validation->set_message('greater_than', '<b>%s</b> debe ser un valor entero igual o superior al número de categorías.');
            $this->form_validation->set_message('integer', '<b>%s</b> sólo admite datos de tipo entero.');
            $this->form_validation->set_message('min_length', 
                '<b>%s</b> debe tener al menos </b>%s</b> caracteres.');
            $this->form_validation->set_message('max_length', 
                '<b>%s</b> no puede tener más de <b>%s</b> caracteres.');
            
            if ($this->form_validation->run() == FALSE) {   
                $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> no se ha podido modificar el panel.');    
                redirect(base_url()."index.php/panelesalta/mod/".$iId, "refresh");
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