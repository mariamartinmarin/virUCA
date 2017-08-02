<?php
class Paneles extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Paneles_model");
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
            $data["universidades"] = $this->Paneles_model->get_universidades();
            $data["titulaciones"] = $this->Paneles_model->get_titulaciones();
            $data["asignaturas"] = $this->Paneles_model->get_asignaturas();
        } else {
            $data["universidades"] = $this->Paneles_model->get_universidades($this->session->userdata('id_usuario'));
            $data["titulaciones"] = $this->Paneles_model->get_titulaciones($this->session->userdata('id_usuario'));
            $data["asignaturas"] = $this->Paneles_model->get_asignaturas($this->session->userdata('id_usuario')); 
        }

        $this->load->helper('url'); 
        $this->load->view("paneles", $data);
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Paneles_model->get_datatables();
        $id_usuario = $this->session->userdata('id_usuario');
        $admin = $this->session->userdata('admin');

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $panel) {
            $no++;
            if ($panel->bActivo == 1) $tex_activo = "SI"; else $tex_activo = "NO";
            $row = array();
            $row[] = '<input type="checkbox" id="panel" class="panel" name="panel[]" value="'.$panel->iId.'">';
            $row[] = $panel->sNombre;
            $row[] = $panel->iCasillas;
            $row[] = $panel->sTitulacion;
            $row[] = $panel->sNombre_Asignatura;
            $row[] = $tex_activo;

            // Añadimos HTML para las acciones de la tabla.
            if ($panel->iId_Propietario == $id_usuario || $admin == 1)
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Datos" onclick="editar_panel('."'".$panel->iId."'".')"><i class="glyphicon glyphicon-pencil"></i> Datos</a>
                <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Editar" onclick="editar_casillas('."'".$panel->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Editar casillas</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_panel('."'".$panel->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
            else 
                $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Editar" onclick="editar_casillas('."'".$panel->iId."'".')"><i class="glyphicon glyphicon-trash"></i> Editar casillas</a>';
        
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Paneles_model->count_all(),
            "recordsFiltered" => $this->Paneles_model->count_filtered(),
            "data" => $data,
        );
        // Salida JSON.
        echo json_encode($output);
    }

    /*
        Función AJAX que se ejecutará cuando añadimos un registro de la tabla de la BBDD "panel" 
    */
    public function ajax_add()
    {
        $this->_validate();

        $activo = 1;
        if ($this->input->post("bActivo")[0] == "") $activo = 0;

        $data = array(
            'sNombre' => $this->input->post('sNombre'),
            'iCasillas' => $this->input->post('iCasillas'),
            'iId_Propietario' => $this->session->userdata('id_usuario'),
            'iId_Universidad' => $this->input->post('iId_Universidad'),
            'iId_Titulacion' => $this->input->post('iId_Titulacion'),
            'iId_Asignatura' => $this->input->post('iId_Asignatura'),
            'bActivo' => $activo,
        );
        $insert = $this->Paneles_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_update()
    {
        $this->_validate();

        $activo = 1;
        if ($this->input->post("bActivo")[0] == "") $activo = 0;

        $data = array(
            'sNombre' => $this->input->post('sNombre'),
            'iCasillas' => $this->input->post('iCasillas'),
            'iId_Propietario' => $this->session->userdata('id_usuario'),
            'iId_Universidad' => $this->input->post('iId_Universidad'),
            'iId_Titulacion' => $this->input->post('iId_Titulacion'),
            'iId_Asignatura' => $this->input->post('iId_Asignatura'),
            'bActivo' => $activo,
        );
        
        $this->Paneles_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }



     /*
        Funciones AJAX que se ejecutarán cuando editemos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_edit($iId)
    {
        $data = $this->Paneles_model->get_by_id($iId);
        echo json_encode($data);
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_delete($iId)
    {
        $this->_validate_delete($iId);
        $this->Paneles_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

   
  /*
        Función auxiliar para confirmar si se puede borrar un panel o no.
    */
    private function _validate_delete($iId)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->Paneles_model->tiene_partidas($iId) == 1) {
            $data['inputerror'][] = 'sNombre';
            $data['error_string'][] = 'Tiene partidas asociadas. No puede borrar el panel.';
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

        if($this->input->post('sNombre') == '')
        {
            $data['inputerror'][] = 'sNombre';
            $data['error_string'][] = 'Dato obligatorio.';
            $data['status'] = FALSE;
        }


        if($this->input->post('iId_Universidad') == '')
        {
            $data['inputerror'][] = 'sUsuario';
            $data['error_string'][] = 'Dato obligatorio.';
            $data['status'] = FALSE;
        }

        if($this->input->post('iId_Titulacion') == '')
        {
            $data['inputerror'][] = 'sPassword';
            $data['error_string'][] = 'Dato obligatorio.';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('iId_Asignatura') == '')
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
     
    
     
    public function mod($iId){
        if(is_numeric($iId)){
            $datos["paneles"]=$this->Paneles_model->mod($iId);
            $datos["categorias"] = $this->Paneles_model->get_categorias();
            $datos["enpartida"] = $this->Paneles_model->enPartida($iId);

            $this->load->view("panelesmod_view",$datos);
            
            if(count($this->input->post("categorias")) > 0){
                $activo = 1;
                if ($this->input->post("bActivo")[0] == "") $activo = 0;
        
                $mod = $this->Paneles_model->mod(
                    $iId,
                    $this->input->post("submit"),
                    $activo,
                    $this->input->post("panel"),
                    $this->input->post("identificadores"),
                    $this->input->post("funciones"),
                    $this->input->post("categorias"));
                
                if ($mod == true) {
                    $this->session->set_flashdata('profesor_ok', '<b>Bien!</b> el panel ha sido modificado con éxito.');
                } else {
                    $this->session->set_flashdata('profesor_ko', 
                        '<b>Oops!</b> no se ha modificado el panel. Inténtelo más tarde o contacte con el administrador.');
                } 
                
                redirect(base_url()."index.php/paneles/mod/".$iId, "refresh");
            } else {
                $mierda = $this->input->post("submit");
                //$this->session->set_flashdata('profesor_ko', 'Es:'.$mierda);
            } 
        } else {
            redirect(base_url()."index.php/paneles"); 
        }
    }

     
    //Controlador para eliminar
    public function eliminar($iId, $npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        
        if(is_numeric($iId)){
            $eliminar = $this->Paneles_model->eliminar($iId);
            if ($eliminar == true){
                $this->session->set_flashdata('correcto', 
                    '<strong>Bien!</strong> el panel se eliminó con éxito.');
            } else {
                $this->session->set_flashdata('incorrecto',
                    '<strong>Oops!</strong> no se puede eliminar el panel.');
            }
            redirect(base_url()."index.php/paneles/pagina/$npag");
        } else {
          redirect(base_url()."index.php/paneles/pagina/$npag");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos($npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        
        foreach ($_POST["panel"] as $item){
            $eliminar = $this->Paneles_model->eliminar($item);
        }
        if ($eliminar == true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        } else {
            $this->session->set_flashdata('incorrecto', 
                '<strong>Oops!</strong> no se pudieron eliminar todos los paneles o no seleccionó ningún registro. Recuerde que no es posible eliminar un panel que participe en una o más partidas.');
        } 
        redirect(base_url()."index.php/paneles/pagina/$npag");
    }

    public function eliminar_casillas($iId){
        foreach ($_POST["panel"] as $item){
            $eliminar = $this->Paneles_model->eliminar_casilla($item);
        }
        if ($eliminar == true){
            $this->session->set_flashdata('profesor_ok', '<strong>Bien!</strong> se eliminaron todas las casillas señaladas.');
        } else {
            $this->session->set_flashdata('profesor_ko', 
                '<strong>Oops!</strong> no se pudiero eliminar una o todas las casillas señaladas.');
        } 
        redirect(base_url()."index.php/paneles/mod/".$this->input->post('iId'));
    }

    public function nueva($iId) {
        
        $add = $this->Paneles_model->add($iId, $this->input->post("eFuncion"), $this->input->post("iId_Categoria"));
        if ($add == true) {
            $this->session->set_flashdata('profesor_ok', '<strong>Bien!</strong> celda añadida.');
        } else {
            $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> no se pudo añadir la celda.');
        }
        redirect(base_url()."index.php/paneles/mod/".$iId);
    }
}
?>