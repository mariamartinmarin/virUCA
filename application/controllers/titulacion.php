<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Titulacion extends CI_Controller{

    /* Constructor */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Titulacion_model");
        $this->load->library("session");
    }

    /* Función que se utilizará para llamar a la vista y comprobar condiciones previas. */
    public function index()
    {
         if($this->session->userdata('admin') != 1)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }

        $data["universidades"] = $this->Titulacion_model->get_universidades();

        $this->load->helper('url');
        $this->load->view('titulacion', $data);
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Titulacion_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $titulacion) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="titulacion" class="titulacion" name="titulacion[]" value="'.$titulacion->iId.'">';
            $row[] = $titulacion->sTitulacion;
            $row[] = $titulacion->sUniversidad;
            
            // Añadimos HTML para las acciones de la tabla.
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_titulacion('."'".$titulacion->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_titulacion('."'".$titulacion->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Titulacion_model->count_all(),
            "recordsFiltered" => $this->Titulacion_model->count_filtered(),
            "data" => $data,
        );
        // Salida JSON.
        echo json_encode($output);
    }

    /*
        Función AJAX que se ejecutará cuando editemos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_edit($iId)
    {
        $data = $this->Titulacion_model->get_by_id($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'sTitulacion' => $this->input->post('sTitulacion'),
                'iId_Universidad' => $this->input->post('iId_Universidad'),
            );
        $insert = $this->Titulacion_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'sTitulacion' => $this->input->post('sTitulacion'),
                'iId_Universidad' => $this->input->post('iId_Universidad'),
            );
        $this->Titulacion_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_delete($iId)
    {
        $this->_validate_delete($iId);
        $this->Titulacion_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos registros de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["titulacion"] as $item){
            $eliminar = $this->Titulacion_model->delete_by_id($item);
        }
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

        if ($this->Titulacion_model->titulacion_curso($iId) > 0) {
            $data['inputerror'][] = 'sTitulacion';
            $data['error_string'][] = 'No puedes borrar la titulación, ya que está asignada a un curso académico.';
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

        if($this->input->post('sTitulacion') == '')
        {
            $data['inputerror'][] = 'sTitulacion';
            $data['error_string'][] = 'El nombre de la titulación es obligatorio';
            $data['status'] = FALSE;
        }
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    // FIN AJAX
    
}
?>