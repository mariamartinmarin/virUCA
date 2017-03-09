<?php
class Usuarios extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("usuarios_model");
        $this->load->library("session");
    }
     
    //controlador por defecto
    public function index($iId="NULL"){
       if ($iId == "NULL") {   
            $usuarios["ver"]=$this->usuarios_model->ver();
            $this->load->view("usuarios",$usuarios);
        } else {
            $usuarios["verUsuario"]=$this->usuarios_model->verUsuario($iId);
            $this->load->view("usuariomod_view",$usuarios); 
        }
       
    }

     
    public function nueva(){
        if($this->input->post("submit")){
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sNombre', 'Nombre', 'trim|required|max_length[32]|min_length[2]');
            $this->form_validation->set_rules('sApellidos', 'Apellidos', 'trim|required|max_length[128]|min_length[2]');
            $this->form_validation->set_rules('sUsuario', 'Usuario', 'trim|required|max_length[32]|min_length[2]');
            $this->form_validation->set_rules('sEmail', 'E-mail', 'trim|valid_email|required|max_length[128]|min_length[2]');
            $this->form_validation->set_rules('sPassword', 'Contraseña', 'trim|required|max_length[64]|min_length[8]');

            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '%s es obligatorio.');
            $this->form_validation->set_message('valid_email', 'El %s no es válido.');
            $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
            $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');

            if ($this->form_validation->run() == FALSE) {
                // Si la validación no se pasa, volvemos al directorio raiz.
                $this->index();
            } else {
                // Hacemos la inserción.
                 $add=$this->usuarios_model->nueva(
                    $this->input->post("iPerfil"), 
                    $this->input->post("sNombre"),
                    $this->input->post("sApellidos"),
                    $this->input->post("sEmail"),
                    $this->input->post("sUsuario"),
                    md5($this->input->post("sPassword"))
                    );
                if($add==true){
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, El usuario se registró con éxito.');
                }else{
                    $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, parece que hubo un problema y no hemos podido añadir el nuevo profesor.');
                }       
                redirect(base_url()."index.php/usuarios", "refresh");
            }
        }
    }
     
    public function mod($iId){
        if(is_numeric($iId)){
           
            $datos["mod"]=$this->usuarios_model->mod($iId);
            $this->load->view("usuariomod_view",$datos);
            if($this->input->post("submit")){

                // Hay que volver a validar los datos.
                $this->form_validation->set_rules('sNombre', 'Nombre', 'trim|required|max_length[32]|min_length[2]');
                $this->form_validation->set_rules('sApellidos', 'Apellidos', 'trim|required|max_length[128]|min_length[2]');
                $this->form_validation->set_rules('sUsuario', 'Usuario', 'trim|required|max_length[32]|min_length[2]');
                $this->form_validation->set_rules('sEmail', 'E-mail', 'trim|valid_email|required|max_length[128]|min_length[2]');
                $this->form_validation->set_rules('sPassword', 'Contraseña', 'trim|required|max_length[64]|min_length[8]');

                // Una vez establecidas las reglas, validamos los campos.
                $this->form_validation->set_message('required', '%s es obligatorio.');
                $this->form_validation->set_message('valid_email', 'El %s no es válido.');
                $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
                $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');
                
                if ($this->form_validation->run() == FALSE) {    
                    $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong>, no ha sido posible modificar los datos. Asegúrese que ha escrito todos los campos correctamente.');               
                    $this->index($iId); 
                } else {
                    $mod=$this->usuarios_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sNombre"),
                        $this->input->post("sApellidos"),
                        $this->input->post("sEmail"),
                        $this->input->post("sUsuario"),
                        md5($this->input->post("sPassword")),
                        $this->input->post("iPerfil"));
                    if($mod==true){
                        $this->session->set_flashdata('profesor_ok', '<strong>Bien!</strong>, el profesor se modificó correctamente.');
                    }else{
                        $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong>, no hemos podido modificar los datos del profesor.');
                    }

                    redirect(base_url()."index.php/usuarios/mod/".$iId, "refresh");

                }
            }
        } else {
            redirect(base_url()."index.php/usuarios"); 
        }
    }
     
    //Controlador para eliminar
    public function eliminar($iId){
        if(is_numeric($iId)){
            $eliminar=$this->usuarios_model->eliminar($iId);
            if($eliminar==true){
                $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, el profesor se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, no se pudo eliminar el profesor.');
          }
          redirect(base_url()."index.php/usuarios");
        }else{
          redirect(base_url()."index.php/usuarios");
        }
    }
}
?>