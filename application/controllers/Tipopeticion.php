<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipopeticion extends CI_Controller{

    /* Constructor */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Tipopeticion_model");
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

        $this->load->helper('url');
        $this->load->view('tipopeticion');
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Tipopeticion_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $peticion) {
            $no++;
            $row = array();
            if ($peticion->bActiva == 1) $tex_activo = "SI"; else $tex_activo = "NO";
            $row[] = '<input type="checkbox" id="peticion" class="peticion" name="peticion[]" value="'.$peticion->iId.'">';
            $row[] = $peticion->sPeticion_lista;
            $row[] = $tex_activo;
            
            // Añadimos HTML para las acciones de la tabla.
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_peticion('."'".$peticion->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_peticion('."'".$peticion->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Tipopeticion_model->count_all(),
            "recordsFiltered" => $this->Tipopeticion_model->count_filtered(),
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
        $data = $this->Tipopeticion_model->get_by_id($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_add()
    {
        $this->_validate();
        
        $activa = 1;
        if ($this->input->post("bActiva")[0] == "") $activa = 0;
        
        $data = array(
                'sPeticion_lista' => $this->input->post('sPeticion'),
                'sRequerimientos' => $this->input->post('sRequerimientos'),
                'bActiva' => $activa,
        );
        $insert = $this->Tipopeticion_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_update()
    {
        $activa = 1;
        if ($this->input->post("bActiva")[0] == "") $activa = 0;
        
        $data = array(
                'sPeticion_lista' => $this->input->post('sPeticion'),
                'sRequerimientos' => $this->input->post('sRequerimientos'),
                'bActiva' => $activa,
        );
        $this->Tipopeticion_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_delete($iId)
    {
        $this->Tipopeticion_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Función AJAX que se ejecutará cuando eliminamos registros de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["peticion"] as $item){
            $eliminar = $this->Tipopeticion_model->delete_by_id($item);
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

        if($this->input->post('sPeticion') == '')
        {
            $data['inputerror'][] = 'sPeticion';
            $data['error_string'][] = 'Dato obligatorio';
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