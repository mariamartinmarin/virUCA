<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Universidad extends CI_Controller{

    /* Constructor */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Universidad_model");
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
        $this->load->view('universidad');
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Universidad_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $universidad) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="universidad" class="universidad" name="universidad[]" value="'.$universidad->iId.'">';
            $row[] = $universidad->sUniversidad;
            $row[] = $universidad->sDireccion;
            $row[] = $universidad->nTelefono;
            $row[] = $universidad->nFax;
            $row[] = $universidad->sProvincia;
            
            // Añadimos HTML para las acciones de la tabla.
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="editar_universidad('."'".$universidad->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_universidad('."'".$universidad->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Universidad_model->count_all(),
            "recordsFiltered" => $this->Universidad_model->count_filtered(),
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
        $data = $this->Universidad_model->get_by_id($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'sUniversidad' => $this->input->post('sUniversidad'),
                'sDireccion' => $this->input->post('sDireccion'),
                'sCP' => $this->input->post('sCP'),
                'sLocalidad' => $this->input->post('sLocalidad'),
                'sProvincia' => $this->input->post('sProvincia'),
                'sPais' => $this->input->post('sPais'),
                'nTelefono' => $this->input->post('nTelefono'),
                'nFax' => $this->input->post('nFax'),
                'sWeb' => $this->input->post('sWeb'),
        );
        $insert = $this->Universidad_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_update()
    {
       $data = array(
            'sUniversidad' => $this->input->post('sUniversidad'),
            'sDireccion' => $this->input->post('sDireccion'),
            'sCP' => $this->input->post('sCP'),
            'sLocalidad' => $this->input->post('sLocalidad'),
            'sProvincia' => $this->input->post('sProvincia'),
            'sPais' => $this->input->post('sPais'),
            'nTelefono' => $this->input->post('nTelefono'),
            'nFax' => $this->input->post('nFax'),
            'sWeb' => $this->input->post('sWeb'),
        ); 
        $this->Universidad_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "titulacion" 
    */
    public function ajax_delete($iId)
    {
        $this->_validate_delete($iId);
        $this->Universidad_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Función AJAX que se ejecutará cuando eliminamos registros de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["universidad"] as $item){
            $eliminar = $this->Universidad_model->delete_by_id($item);
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

        if ($this->Universidad_model->universidad_usuarios($iId) > 0) {
            $data['inputerror'][] = 'sUniversidad';
            $data['error_string'][] = 'No puedes borrar la universidad. Existen usuarios asignados.';
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

    private function _validate($accion = "MOD")
    {
        $this->form_validation->set_message('required','Campo obligatorio.'); 
        $this->form_validation->set_message('min_length[3]','Debe tener más de 3 caracteres.');
        $this->form_validation->set_message('valid_email','E-mail no válido.');
        $this->form_validation->set_message('is_unique','Usuario existente.');
        $this->form_validation->set_message('valid_url','URL no válida.');

        
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

       if ($this->form_validation->set_rules('sUniversidad', 'Universidad', 'required|min_length[3]|trim')  
            && !$this->form_validation->run())
            {
                $data['inputerror'][] = 'sUniversidad';
                $data['error_string'][] =  strip_tags(form_error('sUniversidad'));
                $data['status'] = FALSE;
            }

        if ($this->form_validation->set_rules('nTelefono', 'Telefono', 'required|min_length[9]|trim')
            && !$this->form_validation->run())
        {
            $data['inputerror'][] = 'nTelefono';
            $data['error_string'][] = strip_tags(form_error('nTelefono'));
            $data['status'] = FALSE;
        }


        if ($this->form_validation->set_rules('sWeb', 'Web', 'min_length[3]|trim|valid_url')
            && !$this->form_validation->run())
        {
            $data['inputerror'][] = 'sWeb';
            $data['error_string'][] = strip_tags(form_error('sWeb'));
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