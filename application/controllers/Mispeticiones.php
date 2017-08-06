<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mispeticiones extends CI_Controller{
    public function __construct() {
        parent::__construct(); 
        $this->load->model("Mispeticiones_model");
        $this->load->library("session");
    }
     
    //controlador por defecto
    public function index(){
        if($this->session->userdata('admin') == 1 || $this->session->userdata('perfil') == 1)
        {
            // Sólo si eres profesor, puedes ver esta página.
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }     
        $data["tipospeticiones"] = $this->Mispeticiones_model->get_tipospeticiones();

        $this->load->helper('url');
        $this->load->view("mispeticiones", $data);
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Mispeticiones_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $peticion) {
             if ($peticion->bPendiente == 1) 
                $tex_activo = '<i class="glyphicon glyphicon-remove-circle"></i>'; 
            else $tex_activo = '<i class="glyphicon glyphicon-ok-circle"></i>'; 
            $no++;
            $row = array();
            $row[] = '';
            $row[] = $peticion->sPeticion_lista;
            $row[] = $peticion->dFecha_Peticion;
            $row[] = $tex_activo;

            // Añadimos HTML para las acciones de la tabla.
            $boton_aux = "";
            $botones = "";
            $botones = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="ver_peticion('."'".$peticion->iId."'".')"><i class="glyphicon glyphicon-eye-open"></i> Ver</a>';

            if ($peticion->bPendiente == 0) {
                $boton_aux = '&nbsp;<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Ver respuesta" onclick="ver_respuesta('."'".$peticion->iId."'".')"><i class="glyphicon glyphicon-align-justify"></i> Ver respuesta</a>';
                $botones = $botones.$boton_aux;
            }

            
            $row[] = $botones;
            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mispeticiones_model->count_all(),
            "recordsFiltered" => $this->Mispeticiones_model->count_filtered(),
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
        $data = $this->Mispeticiones_model->get_by_id($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando editemos un registro de la tabla de la BBDD "aignatura" 
    */
    public function ajax_edit_leido($iId)
    {
        // Indicamos que el usuario ha leído el comentario.
        $this->Mispeticiones_model->respuesta_leida($iId);
        // Obtenemos los datos para mostrarlos.
        $data = $this->Mispeticiones_model->get_by_id($iId);
        echo json_encode($data);
    }

    /* Función para recargar los requerimientos según la petición seleccionada. */
    public function ajax_recarga_requerimiento()
    {
        if($this->input->is_ajax_request() && $this->input->get("peticion"))
        {
            $iId_Peticion = $this->input->get("peticion");
            $peticion = $this->Mispeticiones_model->get_requerimiento_by_id($iId_Peticion);
            $data = array("peticion" => $peticion);
            echo json_encode($data);
        }
    }


   
    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_add()
    {
        $this->_validate();

        $timestamp = date('Y-m-d G:i:s');
        $data = array(
            'iId_Peticion' => $this->input->post('iId_Peticion'),
            'sAsunto' => $this->input->post('sAsunto'),
            'sPeticion' => $this->input->post('sPeticion'),
            'dFecha_Peticion' => $timestamp,
            'iId_Usuario' => $this->session->userdata('id_usuario'),
        );
        $insert = $this->Mispeticiones_model->save($data);
        if ($insert == 0)
            echo json_encode(array("status" => FALSE));
        else
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
        if($this->input->post('iId_Peticion') == '')
        {
            $data['inputerror'][] = 'iId_Peticion';
            $data['error_string'][] = 'Tipo obligatorio.';
            $data['status'] = FALSE;
        }

        if($this->input->post('sAsunto') == '')
        {
            $data['inputerror'][] = 'sAsunto';
            $data['error_string'][] = 'Campo obligatorio.';
            $data['status'] = FALSE;
        }

        if($this->input->post('sPeticion') == '')
        {
            $data['inputerror'][] = 'sPeticion';
            $data['error_string'][] = 'Campo obligatorio.';
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