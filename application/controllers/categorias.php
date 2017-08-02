<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller{
    public function __construct() {
        parent::__construct(); 
        $this->load->model("Categorias_model");
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
        if ($this->session->userdata('admin') == 1)      
            $data["asignaturas"] = $this->Categorias_model->get_asignaturas();
        else
            $data["asignaturas"] = $this->Categorias_model->get_asignaturas($this->session->userdata('id_usuario'));


        $this->load->helper('url');
        $this->load->view("categorias", $data);
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Categorias_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $categoria) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="categoria" class="categoria" name="categoria[]" value="'.$categoria->iId.'">'; 
            $row[] = "<div style='background-color:".$categoria->sColor."'>&nbsp;</div>";
            $row[] = $categoria->sCategoria;
            $row[] = $categoria->sDescripcion;
            $row[] = $categoria->sAsignatura;

            // Añadimos HTML para las acciones de la tabla.
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_categoria('."'".$categoria->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_categoria('."'".$categoria->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Categorias_model->count_all(),
            "recordsFiltered" => $this->Categorias_model->count_filtered(),
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
        $data = $this->Categorias_model->get_by_id($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
            'sCategoria' => $this->input->post('sCategoria'),
            'sDescripcion' => $this->input->post('sDescripcion'),
            'sColor' => $this->input->post('sColor'),
            'iId_Asignatura' => $this->input->post('iId_Asignatura'),
        );
        $insert = $this->Categorias_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
            'sCategoria' => $this->input->post('sCategoria'),
            'sDescripcion' => $this->input->post('sDescripcion'),
            'sColor' => $this->input->post('sColor'),
            'iId_Asignatura' => $this->input->post('iId_Asignatura'),
        );
        $this->Categorias_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_delete($iId)
    {
        $this->_validate_delete($iId);
        $this->Categorias_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "categoria" de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["categoria"] as $item){
            $eliminar = $this->Categorias_model->delete_by_id($item);
        }
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función privada para comprobar si una categoría puede eliminarse del sistema sin provocar errores de integridad.
        ENTRADA: $iId (Identificador de la categoría que se desea eliminar) 
    */
    private function _validate_delete($iId) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;  

        if ($this->Categorias_model->categoria_partida($iId) > 0) {
            $data['inputerror'][] = 'sCategoria';
            $data['error_string'][] = 'No puedes borrar la categoría, ya que está asignada uno o más paneles de juego.';
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

        if($this->input->post('sCategoria') == '')
        {
            $data['inputerror'][] = 'sCategoria';
            $data['error_string'][] = 'El nombre de la categoría es obligatorio';
            $data['status'] = FALSE;
        }

        if($this->input->post('sColor') == '')
        {
            $data['inputerror'][] = 'sColor';
            $data['error_string'][] = 'El color es obligatorio';
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