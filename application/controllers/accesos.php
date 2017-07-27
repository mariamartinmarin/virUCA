<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accesos extends CI_Controller{

    /* Construcción */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Accesos_model");
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
        $this->load->view('accesos');
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Accesos_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $acceso) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="acceso" class="acceso" name="acceso[]" value="'.$acceso->iId.'">';     
            $row[] = $acceso->sNombreCompleto;
            $row[] = $acceso->dFecha;
            $row[] = $acceso->sIP;
            
            // Añadimos HTML para las acciones de la tabla.
            $row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_acceso('."'".$acceso->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Accesos_model->count_all(),
            "recordsFiltered" => $this->Accesos_model->count_filtered(),
            "data" => $data,
        );
        // Salida JSON.
        echo json_encode($output);
    }

    
    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "acceso" 
    */
    public function ajax_delete($iId)
    {
        $this->Accesos_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "acceso" de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["acceso"] as $item){
            $eliminar = $this->Accesos_model->delete_by_id($item);
        }
        echo json_encode(array("status" => TRUE));
    }
}
?>