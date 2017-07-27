<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignatura extends CI_Controller{
    public function __construct() {
        parent::__construct(); 
        $this->load->model("Asignatura_model");
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
        $data["titulaciones"] = $this->Asignatura_model->get_titulaciones();
        $data["universidades"] = $this->Asignatura_model->get_universidades();

        $this->load->helper('url');
        $this->load->view("asignatura", $data);
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Asignatura_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $asignatura) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="asignatura" class="asignatura" name="asignatura[]" value="'.$asignatura->iId.'">'; 
            $row[] = $asignatura->sNombre;
            $row[] = $asignatura->sTitulacion;
            $row[] = $asignatura->sUniversidad;

            // Añadimos HTML para las acciones de la tabla.
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_asignatura('."'".$asignatura->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_asignatura('."'".$asignatura->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Asignatura_model->count_all(),
            "recordsFiltered" => $this->Asignatura_model->count_filtered(),
            "data" => $data,
        );
        // Salida JSON.
        echo json_encode($output);
    }

    /*
        Función AJAX que se ejecutará cuando editemos un registro de la tabla de la BBDD "aignatura" 
    */
    public function ajax_edit($iId)
    {
        $data = $this->Asignatura_model->get_by_id($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
            'sNombre' => $this->input->post('sNombre'),
            'iId_Titulacion' => $this->input->post('iId_Titulacion'),
            'iId_Universidad' => $this->input->post('iId_Universidad'),
        );
        $insert = $this->Asignatura_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
            'sNombre' => $this->input->post('sNombre'),
            'iId_Titulacion' => $this->input->post('iId_Titulacion'),
            'iId_Universidad' => $this->input->post('iId_Universidad'),
        );
        $this->Asignatura_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_delete($iId)
    {
        $this->_validate_delete($iId);
        $this->Asignatura_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "asignatura" de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["asignatura"] as $item){
            $eliminar = $this->Asignatura_model->delete_by_id($item);
        }
        echo json_encode(array("status" => TRUE));
    }


    public function ajax_recarga_titulaciones()
    {
        if($this->input->is_ajax_request() && $this->input->get("universidad"))
        {
            $iId_Universidad = $this->input->get("universidad");
            $titulaciones = $this->Asignatura_model->get_titulaciones_by_id($iId_Universidad);
            $data = array("titulaciones" => $titulaciones);
            echo json_encode($data);
        }
    }

    public function ajax_obtener_universidad() {
        $data = $this->Asignatura_model->get_last_universidad();
        //$data = array("iId_Universidad" => $iId_Universidad);
        echo json_encode($data);
    }

    /*
        Función privada para comprobar si una asignatura puede eliminarse del sistema sin provocar errores de integridad.
        ENTRADA: $iId (Identificador de la asignatura que se desea eliminar) 
    */
    private function _validate_delete($iId) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;  

        if ($this->Asignatura_model->asignatura_curso($iId) > 0) {
            $data['inputerror'][] = 'sNombre';
            $data['error_string'][] = 'No puedes borrar la asignatura, ya que está asignada a un curso académico.';
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

        if($this->input->post('sNombre') == '')
        {
            $data['inputerror'][] = 'sNombre';
            $data['error_string'][] = 'El nombre de la asignatura es obligatorio';
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