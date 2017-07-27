<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curso extends CI_Controller{
    public function __construct() {
        parent::__construct();  
        $this->load->model("Curso_model");
        $this->load->library("session");
    }
    
    //controlador por defecto
    public function index(){
        if($this->session->userdata('admin') != 1)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }           
        $data["titulaciones"] = $this->Curso_model->get_titulaciones();
        $data["asignaturas"] = $this->Curso_model->get_asignaturas();
        $data["universidades"] = $this->Curso_model->get_universidades();

        $this->load->helper('url');
        $this->load->view("curso", $data);
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Curso_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $curso) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="curso" class="curso" name="curso[]" value="'.$curso->iId.'">';
            $row[] = $curso->sCurso;
            $row[] = $curso->sUniversidad;
            $row[] = $curso->sTitulacion;
            $row[] = $curso->sNombre;

            // Añadimos HTML para las acciones de la tabla.
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_curso('."'".$curso->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_curso('."'".$curso->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Curso_model->count_all(),
            "recordsFiltered" => $this->Curso_model->count_filtered(),
            "data" => $data,
        );
        // Salida JSON.
        echo json_encode($output);
    }

    /*
        Función AJAX que se ejecutará cuando editemos un registro de la tabla de la BBDD "curso" 
    */
    public function ajax_edit($iId)
    {
        $data = $this->Curso_model->get_by_id($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "curso" 
    */
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
            'sCurso' => $this->input->post('sCurso'),
            'iId_Titulacion' => $this->input->post('iId_Titulacion'),
            'iId_Asignatura' => $this->input->post('iId_Asignatura'),
            'iId_Universidad' => $this->input->post('iId_Universidad'),
        );
        $insert = $this->Curso_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "curso" 
    */
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
            'sCurso' => $this->input->post('sCurso'),
            'iId_Titulacion' => $this->input->post('iId_Titulacion'),
            'iId_Asignatura' => $this->input->post('iId_Asignatura'),
            'iId_Universidad' => $this->input->post('iId_Universidad'),
        );
        $this->Curso_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "curso" 
    */
    public function ajax_delete($iId)
    {
        $this->_validate_delete($iId);
        $this->Curso_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "curso" de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["curso"] as $item){
            $eliminar = $this->Curso_model->delete_by_id($item);
        }
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función privada para comprobar si un curso puede eliminarse del sistema sin provocar errores de integridad.
        ENTRADA: $iId (Identificador del curso que se desea eliminar) 
    */
    private function _validate_delete($iId) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;  

        if ($this->Curso_model->curso_partida($iId) > 0) {
            $data['inputerror'][] = 'sCurso';
            $data['error_string'][] = 'No puedes borrar el curso académico, ya que está ligado a una o varias partidas.';
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
        para la modificación del mismo. En ambas acciones se utilizará la validación. 
    */
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        // Comprobar que no haya ya un sTitulacion con el mismo nombre en la base de datos.

        if($this->input->post('sCurso') == '')
        {
            $data['inputerror'][] = 'sCurso';
            $data['error_string'][] = 'El nombre del curso es obligatorio';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}
?>