<?php
class Usuarios extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->load->library('form_validation'); // Para las validaciones.
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
        $this->load->view("usuarios", $data);
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

            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_usuario('."'".$usuario->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Datos</a>
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

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list_cursos($iId)
    {
        $list = $this->Usuarios_model->get_datatables_cursos($iId);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $curso) {
            $no++;
            $row = array();
            $row[] = $curso->sUniversidad;
            $row[] = $curso->sTitulacion;
            $row[] = $curso->sNombre;

            // Añadimos HTML para las acciones de la tabla.

            $row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_curso('."'".$curso->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>
                ';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Usuarios_model->count_all_cursos($iId),
            "recordsFiltered" => $this->Usuarios_model->count_filtered_cursos($iId),
            "data" => $data,
        );
        // Salida JSON.
        echo json_encode($output);
    }

    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_add()
    {
        $modo = "NEW";
        $this->_validate($modo);

        $admin = 1;
        if ($this->input->post("iAdmin")[0] == "") $admin = 0;

        $activo = 1;
        if ($this->input->post("bActivo")[0] == "") $activo = 0;

        $bloqueado = 1;
        if ($this->input->post("bBloqueado")[0] == "") $bloqueado = 0;


        $data = array(
            'iPerfil' => 0,
            'sNombre' => $this->input->post('sNombre'),
            'sApellidos' => $this->input->post('sApellidos'),
            'sUsuario' => $this->input->post('sUsuario'),
            'sPassword' => sha1($this->input->post('sPassword')),
            'sEmail' => $this->input->post('sEmail'),
            'iAdmin' => $admin,
            'bActivo' => $activo,
            'bBloqueado' => $bloqueado,
        );

        $insert = $this->Usuarios_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_add_curso($iId_Usuario)
    {
        $data = array(
            'iId_Asignatura' => $this->input->post('iId_Asignatura'),
            'iId_Titulacion' => $this->input->post('iId_Titulacion'),
            'iId_Universidad' => $this->input->post('iId_Universidad'),
            'iId_Usuario' => $iId_Usuario,
        );

        $insert = $this->Usuarios_model->save_cursos($data);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Funciones AJAX que se ejecutarán cuando editemos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_edit($iId)
    {
        $data = $this->Usuarios_model->get_by_id($iId);
        echo json_encode($data);
    }

     /*
        Funciones AJAX que se ejecutarán cuando editemos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_edit_cursos($iId)
    {
        $data = $this->Usuarios_model->get_by_id_cursos($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_update()
    {
        $this->_validate();

        $admin = 1;
        if ($this->input->post("iAdmin")[0] == "") $admin = 0;

        $activo = 1;
        if ($this->input->post("bActivo")[0] == "") $activo = 0;

        $bloqueado = 1;
        if ($this->input->post("bBloqueado")[0] == "") $bloqueado = 0;

        $data = array(
            'sNombre' => $this->input->post('sNombre'),
            'sApellidos' => $this->input->post('sApellidos'),
            'sPassword' => sha1($this->input->post('sPassword')),
            'sEmail' => $this->input->post('sEmail'),
            'iAdmin' => $admin,
            'bActivo' => $activo,
            'bBloqueado' => $bloqueado,
        );
        
        $this->Usuarios_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_delete($iId)
    {
        $this->_validate_delete($iId);
        $this->Usuarios_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "usuario" de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["usuario"] as $item){
            $eliminar = $this->Usuarios_model->delete_by_id($item);
        }
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_delete_curso($iId)
    {
        $this->Usuarios_model->delete_curso_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Función privada para comprobar si una titulación puede eliminarse del sistema sin provocar errores de integridad.
        ENTRADA: $iId (Identificador de la titulación que se desea eliminar) 
    */
    private function _validate_delete($iId) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;  

        if ($this->Usuarios_model->tiene_partidas($iId) > 0) {
            $data['inputerror'][] = '';
            $data['error_string'][] = 'Este profesor no puede ser eliminado, ya que participa en una o más partidas.';
            $data['status'] = FALSE;
        }
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }


    /*
        Función auxiliar para validar los campos del formulario antes de darlo de alta como nuevo registro o
        para la modificación del mismo. En ambas acciones se utilizará la validación. $accion puede ser MOD o NEW.
    */
    private function _validate($accion = "MOD")
    {
        $this->form_validation->set_message('required','Campo obligatorio.'); 
        $this->form_validation->set_message('min_length[3]','Debe tener más de 3 caracteres.');
        $this->form_validation->set_message('valid_email','E-mail no válido.');
        $this->form_validation->set_message('is_unique','Usuario existente.');

        
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->form_validation->set_rules('sNombre', 'Nombre', 'required|min_length[3]|trim')  
            && !$this->form_validation->run())
        {
            $data['inputerror'][] = 'sNombre';
            $data['error_string'][] =  strip_tags(form_error('sNombre'));
            $data['status'] = FALSE;
        }

        if ($this->form_validation->set_rules('sApellidos', 'Apellidos', 'required|min_length[3]|trim')
            && !$this->form_validation->run())
        {
            $data['inputerror'][] = 'sApellidos';
            $data['error_string'][] = strip_tags(form_error('sApellidos'));
            $data['status'] = FALSE;
        }

        if ($accion == "NEW")
            if ($this->form_validation->set_rules('sUsuario', 'Usuarios', 'required|is_unique[usuario.sUsuario]|min_length[3]|trim') && !$this->form_validation->run())
            {
                $data['inputerror'][] = 'sUsuario';
                $data['error_string'][] = strip_tags(form_error('sUsuario'));
                $data['status'] = FALSE;
            }
        else
            if ($this->form_validation->set_rules('sUsuario', 'Usuarios', 'required|min_length[3]|trim')
            && !$this->form_validation->run())
            {
                $data['inputerror'][] = 'sUsuario';
                $data['error_string'][] = strip_tags(form_error('sUsuario'));
                $data['status'] = FALSE;
            }


        if ($this->form_validation->set_rules('sPassword', 'Contraseña', 'required|min_length[3]|trim')
            && !$this->form_validation->run())
        {
            $data['inputerror'][] = 'sPassword';
            $data['error_string'][] = strip_tags(form_error('sPassword'));
            $data['status'] = FALSE;
        }
        
        if ($this->form_validation->set_rules('sEmail', 'Email', 'required|min_length[3]|trim|valid_email')
            && !$this->form_validation->run())
        {
            $data['inputerror'][] = 'sEmail';
            $data['error_string'][] = strip_tags(form_error('sEmail'));
            $data['status'] = FALSE;
        }
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    // Recarga de selectores

    public function ajax_recarga_titulaciones()
    {
        if($this->input->is_ajax_request() && $this->input->get("universidad"))
        {
            $iId_Universidad = $this->input->get("universidad");
            $titulaciones = $this->Usuarios_model->get_titulaciones_by_id($iId_Universidad);
            $data = array("titulaciones" => $titulaciones);
            echo json_encode($data);
        }
    }

    public function ajax_recarga_asignaturas()
    {
        if($this->input->is_ajax_request() && $this->input->get("titulacion"))
        {
            $iId_Titulacion = $this->input->get("titulacion");
            $asignaturas = $this->Usuarios_model->get_asignaturas_by_id($iId_Titulacion);
            $data = array("asignaturas" => $asignaturas);
            echo json_encode($data);
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
}
?>