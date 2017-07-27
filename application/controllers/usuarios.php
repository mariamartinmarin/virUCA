<?php
class Usuarios extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->load->library("session");
    }
     
    //controlador por defecto
    public function index(){  
        if($this->session->userdata('perfil') == 1)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }

        $data["universidades"] = $this->Usuarios_model->get_universidades();
        $data["titulaciones"] = $this->Usuarios_model->get_titulaciones();
        $data["asignaturas"] = $this->Usuarios_model->get_asignaturas();

        $this->load->helper('url'); 
        $this->load->view("usuarios");
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Usuarios_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $usuario) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="usuario" class="usuario" name="usuario[]" value="'.$usuario->iId.'">';
            $row[] = $usuario->sNombre;
            $row[] = $usuario->sApellidos;

            switch ($usuario->iAdmin) {
                case '1':
                    $row_content = '<span class="label label-danger">Admin</span>';
                    break;
                case '0':
                    if ($usuario->iPerfil == 0)
                        $row_content = '<span class="label label-info">Profesor</span>';
                    else 
                        $row_content = '<span class="label label-success">Alumno</span>';
                    break;
                default:
                    break;
            }
            $row[] = $row_content;
            $row[] = $usuario->sEmail;

            // Añadimos HTML para las acciones de la tabla.
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_usuario('."'".$usuario->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
            <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Curso" onclick="editar_cursos('."'".$usuario->iId."'".')"><i class="glyphicon glyphicon-plus"></i> Curso</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_usuario('."'".$usuario->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>
                ';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Usuarios_model->count_all(),
            "recordsFiltered" => $this->Usuarios_model->count_filtered(),
            "data" => $data,
        );
        // Salida JSON.
        echo json_encode($output);
    }

    public function mod_view($iId){
       $usuarios["verUsuario"]=$this->usuarios_model->verUsuario($iId);
       $this->load->view("usuariomod_view",$usuarios);
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
            $this->form_validation->set_message('required', '<b>%s</B> es obligatorio.');
            $this->form_validation->set_message('valid_email', 'El <b>%s</b> no es válido.');
            $this->form_validation->set_message('min_length', '<b>%s</b> debe tener al menos <b>%s</b> caracteres.');
            $this->form_validation->set_message('max_length', '<b>%s</b> no puede tener más de <b>%s</b> caracteres.');

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
                    $this->input->post("sPassword"),
                    $this->input->post("sTitulaciones"),
                    $this->input->post("sAsignaturas")
                    );
                if($add==true){
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, El profesor se registró con éxito.');
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

                // Una vez establecidas las reglas, validamos los campos.
                $this->form_validation->set_message('required', '%s es obligatorio.');
                $this->form_validation->set_message('valid_email', 'El %s no es válido.');
                $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
                $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');
                
                if ($this->form_validation->run() == FALSE) {   
                    $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong>, no hemos podido modificar los datos del profesor.');               
                    redirect(base_url()."index.php/usuarios/mod/".$iId, "refresh");
                } else {
                    $mod=$this->usuarios_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sNombre"),
                        $this->input->post("sApellidos"),
                        $this->input->post("sEmail"),
                        $this->input->post("sUsuario"),
                        $this->input->post("iPerfil"),
                        $this->input->post("iTitulacion"),
                        $this->input->post("iAsignatura"));
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
    public function eliminar($iId, $npag="NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        if(is_numeric($iId)){
            $eliminar=$this->usuarios_model->eliminar($iId);
            if($eliminar==true){
                $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, el profesor se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, no se pudo eliminar el profesor.');
          }
          redirect(base_url()."index.php/usuarios/pagina/$npag");
        }else{
          redirect(base_url()."index.php/usuarios/pagina/$npag");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos($npag="NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        foreach ($_POST["usuario"] as $item){
            $eliminar=$this->usuarios_model->eliminar($item);
        }
        if($eliminar==true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        }else{
            $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/usuarios/pagina/$npag");
    }
}
?>