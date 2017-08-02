<?php
class Alumnos extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Alumnos_model");
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
        if($this->session->userdata('admin') == 1) {
            $data["universidades"] = $this->Alumnos_model->get_universidades();
            $data["titulaciones"] = $this->Alumnos_model->get_titulaciones();
            $data["asignaturas"] = $this->Alumnos_model->get_asignaturas();
        } else {
            $data["universidades"] = $this->Alumnos_model->get_universidades($this->session->userdata('id_usuario'));
            $data["titulaciones"] = $this->Alumnos_model->get_titulaciones($this->session->userdata('id_usuario'));
            $data["asignaturas"] = $this->Alumnos_model->get_asignaturas($this->session->userdata('id_usuario')); 
        }

        $this->load->helper('url'); 
        $this->load->view("alumnos", $data);
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Alumnos_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $alumno) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="usuario" class="usuario" name="usuario[]" value="'.$alumno->iId.'">';
            $row[] = $alumno->sNombre;
            $row[] = $alumno->sApellidos;
            $row[] = $alumno->sEmail;

            // Añadimos HTML para las acciones de la tabla.

            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_alumno('."'".$alumno->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Datos</a>
                <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Curso" onclick="editar_cursos('."'".$alumno->iId."'".')"><i class="glyphicon glyphicon-plus"></i> Curso</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_alumno('."'".$alumno->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>
                ';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Alumnos_model->count_all(),
            "recordsFiltered" => $this->Alumnos_model->count_filtered(),
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
        $list = $this->Alumnos_model->get_datatables_cursos($iId);
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
            "recordsTotal" => $this->Alumnos_model->count_all_cursos($iId),
            "recordsFiltered" => $this->Alumnos_model->count_filtered_cursos($iId),
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
        $this->_validate();

        $admin = 0;
        $activo = 1;
        if ($this->input->post("bActivo")[0] == "") $activo = 0;

        $bloqueado = 1;
        if ($this->input->post("bBloqueado")[0] == "") $bloqueado = 0;

        $data = array(
            'iPerfil' => 1,
            'sNombre' => $this->input->post('sNombre'),
            'sApellidos' => $this->input->post('sApellidos'),
            'sUsuario' => $this->input->post('sUsuario'),
            'sPassword' => sha1($this->input->post('sPassword')),
            'sEmail' => $this->input->post('sEmail'),
            'iAdmin' => $admin,
            'bActivo' => $activo,
            'bBloqueado' => $bloqueado,
        );


        $insert = $this->Alumnos_model->save($data, 
            $this->input->post('iId_Universidad'), 
            $this->input->post('iId_Titulacion'), 
            $this->input->post('iId_Asignatura'));

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

        $insert = $this->Alumnos_model->save_cursos($data);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Funciones AJAX que se ejecutarán cuando editemos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_edit($iId)
    {
        $data = $this->Alumnos_model->get_by_id($iId);
        echo json_encode($data);
    }

     /*
        Funciones AJAX que se ejecutarán cuando editemos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_edit_cursos($iId)
    {
        $data = $this->Alumnos_model->get_by_id_cursos($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_update()
    {
        $this->_validate();

        $admin = 0;
        $activo = 1;
        if ($this->input->post("bActivo")[0] == "") $activo = 0;
        $bloqueado = 1;
        if ($this->input->post("bBloqueado")[0] == "") $bloqueado = 0;

        $data = array(
            'sNombre' => $this->input->post('sNombre'),
            'sApellidos' => $this->input->post('sApellidos'),
            'sUsuario' => $this->input->post('sUsuario'),
            'sPassword' => sha1($this->input->post('sPassword')),
            'sEmail' => $this->input->post('sEmail'),
            'iAdmin' => $admin,
            'bActivo' => $activo,
            'bBloqueado' => $bloqueado,
        );
        
        $this->Alumnos_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_delete($iId)
    {
        $this->Alumnos_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "usuario" de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["usuario"] as $item){
            $eliminar = $this->Alumnos_model->delete_by_id($item);
        }
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_delete_curso($iId)
    {
        $this->Alumnos_model->delete_curso_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }


    /*
        Función auxiliar para validar los campos del formulario antes de darlo de alta como nuevo registro o
        para la modificación del mismo. En ambas acciones se utilizará la validación. 
    */
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('sNombre') == '')
        {
            $data['inputerror'][] = 'sNombre';
            $data['error_string'][] = 'Dato obligatorio.';
            $data['status'] = FALSE;
        }

        if($this->input->post('sApellidos') == '')
        {
            $data['inputerror'][] = 'sApellidos';
            $data['error_string'][] = 'Dato obligatorio.';
            $data['status'] = FALSE;
        }

        if($this->input->post('sUsuario') == '')
        {
            $data['inputerror'][] = 'sUsuario';
            $data['error_string'][] = 'Dato obligatorio.';
            $data['status'] = FALSE;
        }

        if($this->input->post('sPassword') == '')
        {
            $data['inputerror'][] = 'sPassword';
            $data['error_string'][] = 'Dato obligatorio.';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('sEmail') == '')
        {
            $data['inputerror'][] = 'sEmail';
            $data['error_string'][] = 'Dato obligatorio.';
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
            $titulaciones = $this->Alumnos_model->get_titulaciones_by_id($iId_Universidad);
            $data = array("titulaciones" => $titulaciones);
            echo json_encode($data);
        }
    }

    public function ajax_recarga_asignaturas()
    {
        if($this->input->is_ajax_request() && $this->input->get("titulacion"))
        {
            $iId_Titulacion = $this->input->get("titulacion");
            $asignaturas = $this->Alumnos_model->get_asignaturas_by_id($iId_Titulacion);
            $data = array("asignaturas" => $asignaturas);
            echo json_encode($data);
        }
    }
}
?>