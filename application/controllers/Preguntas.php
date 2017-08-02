<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preguntas extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Preguntas_model");
        $this->load->library("session");
    }
     
    //controlador por defecto
    public function index($iId="NULL"){  
        if($this->session->userdata('perfil') == 1)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }
        $data["categorias"] = $this->Preguntas_model->get_categorias();
        $data["titulaciones"] = $this->Preguntas_model->get_titulaciones();
        $data["asignaturas"] = $this->Preguntas_model->get_asignaturas();
        $data["universidades"] = $this->Preguntas_model->get_universidades();

        $this->load->helper('url'); 
        $this->load->view("preguntas", $data);
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Preguntas_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pregunta) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="pregunta" class="pregunta" name="pregunta[]" value="'.$pregunta->iId.'">';
            $row[] = $pregunta->sPregunta;
            $row[] = $pregunta->sNombre;
            $row[] = $pregunta->sApellidos;
            $row[] = $pregunta->sCategoria;
            $row[] = $pregunta->nPuntuacion;

            // Añadimos HTML para las acciones de la tabla.
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_pregunta('."'".$pregunta->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_pregunta('."'".$pregunta->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Preguntas_model->count_all(),
            "recordsFiltered" => $this->Preguntas_model->count_filtered(),
            "data" => $data,
        );
        // Salida JSON.
        echo json_encode($output);
    }

    /*
        Funciones AJAX que se ejecutarán cuando editemos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_edit($iId)
    {
        $data = $this->Preguntas_model->get_by_id($iId);
        echo json_encode($data);
    }

     public function ajax_editA($iId)
    {
        $data = $this->Preguntas_model->get_respuesta_A($iId);
        echo json_encode($data);
    }

    public function ajax_editB($iId)
    {
        $data = $this->Preguntas_model->get_respuesta_B($iId);
        echo json_encode($data);
    }

    public function ajax_editC($iId)
    {
        $data = $this->Preguntas_model->get_respuesta_C($iId);
        echo json_encode($data);
    }

    public function ajax_editD($iId)
    {
        $data = $this->Preguntas_model->get_respuesta_D($iId);
        echo json_encode($data);
    }

    public function obtener_verdadera($iId) {
        $data = $this->Preguntas_model->get_verdadera($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_add()
    {
        $this->_validate();
        $data_pregunta = array(
            'sPregunta' => $this->input->post('sPregunta'),
            'iId_Usuario' => $this->session->userdata('id_usuario'),
            'iId_Titulacion' => $this->input->post('iId_Titulacion'),
            'iId_Asignatura' => $this->input->post('iId_Asignatura'),
            'iId_Categoria' => $this->input->post('iId_Categoria'),
            'iId_Universidad' => $this->input->post('iId_Universidad'),
            'sObservaciones' => $this->input->post('sObservaciones'),
            'nPuntuacion' => $this->input->post('nPuntuacion'),
        );

        $data_respuesta = array(
            'sResp1' => $this->input->post('sResp1'),
            'sResp2' => $this->input->post('sResp2'),
            'sResp3' => $this->input->post('sResp3'),
            'sResp4' => $this->input->post('sResp4'),
            'bVerdadera' => $this->input->post('bVerdadera'),
        );
        
        $insert = $this->Preguntas_model->save($data_pregunta, $data_respuesta);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_update()
    {
        $this->_validate();
        $data_pregunta = array(
            'sPregunta' => $this->input->post('sPregunta'),
            'iId_Categoria' => $this->input->post('iId_Categoria'),
            'iId_Titulacion' => $this->input->post('iId_Titulacion'),
            'iId_Asignatura' => $this->input->post('iId_Asignatura'),
            'iId_Universidad' => $this->input->post('iId_Universidad'),
            'sObservaciones' => $this->input->post('sObservaciones'),
            'nPuntuacion' => $this->input->post('nPuntuacion'),
        );
        
        $data_respuesta = array(
            'sResp1' => $this->input->post('sResp1'),
            'sResp2' => $this->input->post('sResp2'),
            'sResp3' => $this->input->post('sResp3'),
            'sResp4' => $this->input->post('sResp4'),
            'bVerdadera' => $this->input->post('bVerdadera'),
        );

        $this->Preguntas_model->update(array('iId' => $this->input->post('iId')), $data_pregunta, $data_respuesta);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_delete($iId)
    {
        $this->Preguntas_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "pregunta" de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["pregunta"] as $item){
            $eliminar = $this->Preguntas_model->delete_by_id($item);
        }
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

        // Comprobar que no haya ya un sTitulacion con el mismo nombre en la base de datos.

        if($this->input->post('sPregunta') == '')
        {
            $data['inputerror'][] = 'sPregunta';
            $data['error_string'][] = 'El texto de la pregunta es obligatorio';
            $data['status'] = FALSE;
        }

        if($this->input->post('iId_Categoria') == '')
        {
            $data['inputerror'][] = 'iId_Categoria';
            $data['error_string'][] = 'Categoría obligatoria';
            $data['status'] = FALSE;
        }

        if($this->input->post('sResp1') == '')
        {
            $data['inputerror'][] = 'sResp1';
            $data['error_string'][] = 'Respuesta obligatoria';
            $data['status'] = FALSE;
        }

        if($this->input->post('sResp2') == '')
        {
            $data['inputerror'][] = 'sResp2';
            $data['error_string'][] = 'Respuesta obligatoria';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('sResp3') == '')
        {
            $data['inputerror'][] = 'sResp3';
            $data['error_string'][] = 'Respuesta obligatoria';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('sResp4') == '')
        {
            $data['inputerror'][] = 'sResp4';
            $data['error_string'][] = 'Respuesta obligatoria';
            $data['status'] = FALSE;
        }

        if($this->input->post('nPuntuacion') != '' and !is_numeric($this->input->post('nPuntuacion')))
        {
            $data['inputerror'][] = 'nPuntuacion';
            $data['error_string'][] = 'Dato incorrecto';
            $data['status'] = FALSE;
        }
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    // Para la recarga de los selectores


    public function ajax_recarga_titulaciones()
    {
        if($this->input->is_ajax_request() && $this->input->get("universidad"))
        {
            $iId_Universidad = $this->input->get("universidad");
            $titulaciones = $this->Preguntas_model->get_titulaciones_by_id($iId_Universidad);
            $data = array("titulaciones" => $titulaciones);
            echo json_encode($data);
        }
    }

    public function ajax_recarga_asignaturas()
    {
        if($this->input->is_ajax_request() && $this->input->get("titulacion"))
        {
            $iId_Titulacion = $this->input->get("titulacion");
            $asignaturas = $this->Preguntas_model->get_asignaturas_by_id($iId_Titulacion);
            $data = array("asignaturas" => $asignaturas);
            echo json_encode($data);
        }
    }

    public function ajax_recarga_categorias()
    {
        if($this->input->is_ajax_request() && $this->input->get("asignatura"))
        {
            $iId_Asignatura = $this->input->get("asignatura");
            $categorias = $this->Preguntas_model->get_categorias_by_id($iId_Asignatura);
            $data = array("categorias" => $categorias);
            echo json_encode($data);
        }
    }
}
?>