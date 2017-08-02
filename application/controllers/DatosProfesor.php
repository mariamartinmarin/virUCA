<?php
class DatosProfesor extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("DatosProfesor_model");
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
        $profesor["titulo"] = 'Modificación del perfil del usuario.';
        $iId = $this->session->userdata('id_usuario');
        $profesor["verProfesor"] = $this->DatosProfesor_model->verUsuario($iId);
        $profesor["cursos"] = $this->DatosProfesor_model->verCursos($iId);
        $this->load->view("datosprofesor", $profesor);
    }

    public function oldpassword_check($old_pass){
        $old_password = sha1($old_pass);
        $old_password_db = $this->DatosProfesor_model->obtenerPassword($this->session->userdata('id_usuario'));

        if($old_password != $old_password_db)
        {
            $this->form_validation->set_message('oldpassword_check', 'Las constraseñas no coinciden');
            return FALSE;
        } 
        return TRUE;
    }
    
    public function mod(){
        $iId = $this->session->userdata('id_usuario');
        if(is_numeric($iId)){
            //$datos["mod"]=$this->DatosProfesor_model->mod($iId);
            //$this->load->view("DatosProfesor",$datos);
            
            if($this->input->post("submit")){
                // Hay que volver a validar los datos.
                $this->form_validation->set_rules('sNombre', 'Nombre', 'trim|required|max_length[32]|min_length[2]');
                $this->form_validation->set_rules('sApellidos','Apellidos', 'trim|required|max_length[128]|min_length[2]');
                $this->form_validation->set_rules('sUsuario','Usuario','trim|required|max_length[32]|min_length[2]');
                $this->form_validation->set_rules('sEmail','E-mail','trim|valid_email|required|max_length[128]|min_length[2]');

                if ($this->input->post("sPassword_now") != NULL ||
                    $this->input->post("sPassword_new") != NULL ||
                    $this->input->post("sPassword_new_confirm") != NULL) {
                    // Comprobar que la contraseña antigua coincide realmente.
                    $this->form_validation->set_rules('sPassword_now', 'Constraseña', 'trim|required|callback_oldpassword_check');
                    // Comprobar que los dos campos de la nueva contraseña coinciden.
                    $this->form_validation->set_rules('sPassword_new', 'Nueva Contraseña', 'trim|required');
                    $this->form_validation->set_rules('sPassword_new_confirm', 'Nueva Contraseña', 'trim|required|matches[sPassword_new]');
                    $this->form_validation->set_message('matches', 'Las contraseñas no coinciden.');    
                }
                //$this->form_validation->set_rules('sPassword', 'Contraseña', 'trim|required|max_length[64]|min_length[8]');

                // Una vez establecidas las reglas, validamos los campos.
                $this->form_validation->set_message('required', '%s es obligatorio.');
                $this->form_validation->set_message('valid_email', 'El %s no es válido.');
                $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
                $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');
                
                if ($this->form_validation->run() == FALSE) {                 
                    $this->index();
                } else {
                    $mod = $this->DatosProfesor_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sNombre"),
                        $this->input->post("sApellidos"),
                        $this->input->post("sEmail"),
                        $this->input->post("sUsuario"),
                        trim($this->input->post("sPassword_new")));
                    if ($mod == true) {
                        $this->session->set_flashdata('profesor_ok', '<strong>Bien!</strong> tus datos se han modificado.');
                    }else{
                        $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> los datos no han sido modificados con éxito. Inténtalo más tarde.');
                    }

                    redirect(base_url()."index.php/DatosProfesor", "refresh");

                }
            }
        } else {
            redirect(base_url()."index.php/DatosProfesor"); 
        }
    }
}
?>