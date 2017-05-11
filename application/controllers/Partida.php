<?php
class Partida extends CI_Controller{
    public function __construct() {
        parent::__construct(); 
        $this->load->helper("url");  
        $this->load->model("partida_model");
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
        $data["cursos"] = $this->partida_model->get_cursos();
        $data["paneles"] = $this->partida_model->get_paneles();
        $this->load->view("partida", $data);
    }
     
    //controlador para crear una nueva partida.
    public function nueva(){
        // Primero vamos a hacer las validaciones.
        $this->form_validation->set_rules('nGrupos', '', 'trim|required|numeric|max_length[2]|min_length[1]');
            
        // Una vez establecidas las reglas, validamos los campos.
        $this->form_validation->set_message('required', 'El <b>número de grupos</b> es un dato obligatorio.');
        $this->form_validation->set_message('numeric', 'Se esperaba un valor numérico.');
        $this->form_validation->set_message('min_length', 'Debe tener al menos 1 dígito.');
        $this->form_validation->set_message('max_length', 'No puede tener más de 2 dígitos.');

        if ($this->form_validation->run() == FALSE) {
            // Si la validación no se pasa, volvemos al directorio raiz.
            $this->index();
        } else {
            // Hacemos la inserción.
            $add=$this->partida_model->nueva(
                $this->input->post("nGrupos"),
                $this->session->userdata('id_usuario'),
                $this->input->post("sCursos"),
                $this->input->post("sPaneles"));
            if ($add != true){
                $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> parece que hubo un problema y no hemos podido crear la nueva partida.');
            }       
            redirect(base_url()."index.php/juego", "refresh");
        }
    }     
     
    
}
?>