<?php
class Alumnos extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("alumnos_model");
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
        $config['base_url'] = base_url().'index.php/alumnos/pagina/';
        $config['total_rows'] = $this->alumnos_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación       
        $data["alumnos"] = $this->alumnos_model->total_paginados($config['per_page'],$this->uri->segment(3));
        $data["num_filas"] = $config['total_rows'];
        $data["titulaciones"] = $this->alumnos_model->get_titulaciones();          
        
        //cargo la vista y le paso los datos
        $this->load->view("alumnos",$data);
    }

    public function mod_view($iId){
       $alumnos["verAlumno"]=$this->alumnos_model->verAlumno($iId);
       $this->load->view("alumnomod_view",$alumnos);
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
            $this->form_validation->set_message('required', '<b>%s</b> es obligatorio.');
            $this->form_validation->set_message('valid_email', 'El <b>%s</b> no es válido.');
            $this->form_validation->set_message('min_length', '<b>%s</b> debe tener al menos <b>%s</b> caracteres.');
            $this->form_validation->set_message('max_length', '<b>%s</b> no puede tener más de <b>%s</b> caracteres.');

            if ($this->form_validation->run() == FALSE) {
                // Si la validación no se pasa, volvemos al directorio raiz.
                $this->index();
            } else {
                // Hacemos la inserción.
                 $add=$this->alumnos_model->nueva(
                    $this->input->post("iPerfil"), 
                    $this->input->post("sNombre"),
                    $this->input->post("sApellidos"),
                    $this->input->post("sEmail"),
                    $this->input->post("sUsuario"),
                    $this->input->post("sPassword"),
                    $this->input->post("sTitulaciones")
                    );
                if($add==true){
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, El alumno se registró con éxito.');
                }else{
                    $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, parece que hubo un problema y no hemos podido añadir el nuevo alumno.');
                }       
                redirect(base_url()."index.php/alumnos", "refresh");
            }
        }
    }
     
    public function mod($iId, $npag="NULL"){
        if (($npag == "NULL") or (is_numeric($npag) == FALSE)) $npag = 1;
        if(is_numeric($iId)){
            $datos["mod"]=$this->alumnos_model->mod($iId);
            $datos["titulaciones"] = $this->alumnos_model->get_titulaciones();
            $this->load->view("alumnomod_view",$datos);
            
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
                    $this->session->set_flashdata('alumno_ko', '<strong>Oops!</strong>, no hemos podido modificar los datos del alumno.');               
                    redirect(base_url()."index.php/alumnos/mod/".$iId, "refresh");
                } else {
                    $mod=$this->alumnos_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sNombre"),
                        $this->input->post("sApellidos"),
                        $this->input->post("sEmail"),
                        $this->input->post("sUsuario"),
                        md5($this->input->post("sPassword")),
                        $this->input->post("iPerfil"),
                        $this->input->post("iTitulacion"));
                    if($mod==true){
                        $this->session->set_flashdata('alumno_ok', '<strong>Bien!</strong>, el alumno se modificó correctamente.');
                    }else{
                        $this->session->set_flashdata('alumno_ko', '<strong>Oops!</strong>, no hemos podido modificar los datos del alumno.');
                    }

                    redirect(base_url()."index.php/alumnos/mod/".$iId, "refresh");

                }
            }
        } else {
            redirect(base_url()."index.php/alumno"); 
        }
    }

     
    //Controlador para eliminar
    public function eliminar($iId,$npag="NULL"){
        if (($npag == "NULL") or (is_numeric($npag) == FALSE)) $npag = 1;
        if(is_numeric($iId)){
            $eliminar=$this->alumnos_model->eliminar($iId);
            if($eliminar==true){
                $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, el alumno se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, no se pudo eliminar el alumno.');
          }
          redirect(base_url()."index.php/alumnos");
        }else{
          redirect(base_url()."index.php/alumnos");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos(){
        foreach ($_POST["alumno"] as $item){
            $eliminar=$this->alumnos_model->eliminar($item);
        }
        if($eliminar==true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        }else{
            $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/alumnos");
    }
}
?>