<?php
class Partidas extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Partidas_model");
        $this->load->library("session");
    }
    //controlador por defecto
    public function index(){  
        if($this->session->userdata('perfil') == 1)
            redirect(base_url().'index.php/login');
       
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }

        $data["paneles"] = $this->Partidas_model->get_paneles();
        
        $this->load->helper('url'); 
        $this->load->view("partidas", $data);
    }

    /* 
        Función que "montará" la lista según los datos que se mostrarán en la vista y que obtendremos a través del 
        modelo.
    */
    public function ajax_list()
    {
        $list = $this->Partidas_model->get_datatables();

        $id_usuario = $this->session->userdata('id_usuario');
        $admin = $this->session->userdata('admin');

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $partida) {
            $no++;
            // Los usuarios sólo podrán modificar
            if ($partida->bEmpezada == 1) $tex_activo = "SI"; else $tex_activo = "NO";
            $row = array();
            if ($partida->iId_Profesor == $id_usuario)
                $row[] = '<input type="checkbox" id="partida" class="partida" name="partida[]" value="'.$partida->iId.'">';
            else
                $row[] = '';
            $row[] = $partida->sPartida;
            $row[] = $partida->dFecha;
            $row[] = $partida->nGrupos;
            $row[] = $partida->sNombre_Panel;
            $row[] = $partida->sNombre_Profesor.", ".$partida->sApellidos_Profesor;

            // Añadimos HTML para las acciones de la tabla.
            $boton_aux="";
            $botones="";
            if ($admin || $partida->iId_Profesor == $id_usuario) {
                if ($partida->bFinalizada) {
                    $boton_aux = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Ver CLasificación" onclick="ver_clasificacion('."'".$partida->iId."','".$partida->iId_Panel."'".')">
                        <i class="glyphicon glyphicon-pencil"></i> Clasificación</a>&nbsp;';
                    $botones = $botones.$boton_aux;
                } else {
                    if ((($partida->bEmpezada && $partida->bAbierta) || (!$partida->bEmpezada && !$partida->bAbierta) ||
                        (!$partida->bFinalizada || $partida->bEmpezada)) && !$admin )
                        $boton_aux = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Jugar!" onclick="jugar_partida('."'".$partida->iId."','".$partida->iId_Panel."'".')">
                        <i class="glyphicon glyphicon-pencil"></i> Jugar!</a>&nbsp;';
                    $botones = $botones.$boton_aux;
                }
                if (!$partida->bEmpezada) {
                    $boton_aux = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Editar" onclick="editar_partida('."'".$partida->iId."'".')">
                        <i class="glyphicon glyphicon-pencil"></i> Editar</a>&nbsp;';
                    $botones = $botones.$boton_aux;
                }

                if (!$partida->bAbierta || $admin || $partida->iId_Profesor == $id_usuario ) {
                    $boton_aux = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Borrar" onclick="borrar_partida('."'".$partida->iId."'".')">
                        <i class="glyphicon glyphicon-pencil"></i> Borrar</a>&nbsp;';
                    $botones = $botones.$boton_aux;
                }
                
            } else {
                // El usuario no es ni administrador, ni propietario.
                if ($partida->bFinalizada) {
                    $boton_aux = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Ver CLasificación" onclick="ver_clasificacion('."'".$partida->iId."','".$partida->iId_Panel."'".')">
                        <i class="glyphicon glyphicon-pencil"></i> Clasificación</a>&nbsp;';
                    $botones = $botones.$boton_aux;
                } 
            }
            
            $row[] = $botones;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Partidas_model->count_all(),
            "recordsFiltered" => $this->Partidas_model->count_filtered(),
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
        $timestamp = date('Y-m-d G:i:s');
        $data = array(
            'dFecha' => $timestamp,
            'nGrupos' => $this->input->post('nGrupos'),
            'iId_Panel' => $this->input->post('iId_Panel'),
            'iId_Profesor' => $this->session->userdata('id_usuario'),
            'sPartida' => $this->input->post('sPartida'),
        );
        $insert = $this->Partidas_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Funciones AJAX que se ejecutarán cuando editemos un registro de la tabla de la BBDD "pregunta" 
    */
    public function ajax_edit($iId)
    {
        $data = $this->Partidas_model->get_by_id($iId);
        echo json_encode($data);
    }


    /*
        Función AJAX que se ejecutará cuando actualizamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_update()
    {
         $data = array(
            'nGrupos' => $this->input->post('nGrupos'),
            'iId_Panel' => $this->input->post('iId_Panel'),
            'sPartida' => $this->input->post('sPartida'),
        );
        
        $this->Partidas_model->update(array('iId' => $this->input->post('iId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "usuario" 
    */
    public function ajax_delete($iId)
    {
        $this->Partidas_model->delete_by_id($iId);
        echo json_encode(array("status" => TRUE));
    }

     /*
        Función AJAX que se ejecutará cuando eliminamos un registro de la tabla de la BBDD "usuario" de forma masiva. 
    */
    public function ajax_delete_todos()
    {
        foreach ($_POST["partida"] as $item){
            $eliminar = $this->Partidas_model->delete_by_id($item);
        }
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

        if ($this->Partidas_model->tiene_partidas($iId) == 1) {
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

        if($this->input->post('sPartida') == '')
        {
            $data['inputerror'][] = 'sPartida';
            $data['error_string'][] = 'Dato obligatorio.';
            $data['status'] = FALSE;
        }

        if($this->input->post('nGrupos') == '' || !is_numeric($this->input->post('nGrupos')))
        {
            $data['inputerror'][] = 'nGrupos';
            $data['error_string'][] = 'Dato numérico obligatorio.';
            $data['status'] = FALSE;
        }


        
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
     
    // Modificación de las celdas de un panel.
     
    public function mod($iId){
        

        if(is_numeric($iId) && $this->Paneles_model->esPropietario($iId)) {
            $datos["paneles"]=$this->Paneles_model->mod($iId);
            $datos["categorias"] = $this->Paneles_model->get_categorias($iId);
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
            redirect(base_url()); 
        }
    }

    // Función para añadir una nueva casilla
     public function nueva($iId) {
        $add = $this->Paneles_model->add($iId, $this->input->post("eFuncion"), $this->input->post("iId_Categoria"));

        if ($add == true) {
            $this->session->set_flashdata('profesor_ok', '<strong>Bien!</strong> celda añadida.');
        } else {
            $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> no se pudo añadir la celda.');
        }
        redirect(base_url()."index.php/paneles/mod/".$iId);
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

   









     
    
     
    public function mods($iId){
        if(is_numeric($iId)){
            $datos["mod"]=$this->Partidas_model->mod($iId);
            $datos["paneles"] = $this->Partidas_model->get_paneles();
            $datos["cursos"] = $this->Partidas_model->get_cursos();
            $this->load->view("partidamod_view",$datos);
            
            if($this->input->post("submit")){
            
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('nGrupos', '', 
                'trim|required|numeric|max_length[2]|min_length[1]|greater_than[1]');
            
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', 'El <b>número de grupos</b> es un dato obligatorio.');
            $this->form_validation->set_message('numeric', 'Se esperaba un valor numérico.');
            $this->form_validation->set_message('min_length', 'Debe tener al menos 1 dígito.');
            $this->form_validation->set_message('max_length', 'No puede tener más de 2 dígitos.');
            $this->form_validation->set_message('greater_than', 'Deben existir al menos, 2 grupos.');

            if ($this->form_validation->run() == FALSE) {   
                $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> no hemos podido modificar la pregunta.');
                $this->Partidas_model->mod($iId);
                //redirect(base_url()."index.php/partidas/mod/".$iId, "refresh");
            } else {
                $mod=$this->Partidas_model->mod(
                    $iId,
                    $this->input->post("submit"),
                    $this->input->post("nGrupos"),
                    $this->input->post("iPanel"),
                    $this->input->post("iCurso"));

                if ($mod == true) {
                    $this->session->set_flashdata('profesor_ok', '<strong>Bien!</strong> la partida se modificó con éxito.');
                } else {
                    $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> no se puede modificar la partida.');
                }

                    redirect(base_url()."index.php/partidas/mod/".$iId, "refresh");
                }
            }
        } else {
            redirect(base_url()."index.php/partidas"); 
        }
    }

     
    //Controlador para eliminar
    public function eliminars($iId, $npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        
        if(is_numeric($iId)){
            $eliminar = $this->Partidas_model->eliminar($iId);
            if ($eliminar == true){
                $this->session->set_flashdata('correcto', 
                    '<strong>Bien!</strong> la partida se eliminó con éxito.');
            } else {
                $this->session->set_flashdata('incorrecto',
                    '<strong>Oops!</strong> no se pudo eliminar la partida. Inténtalo más tarde.');
            }
            redirect(base_url()."index.php/partidas/pagina/$npag");
        } else {
          redirect(base_url()."index.php/partidas/pagina/$npag");
        }
    }

    public function desbloquear($iId, $npag = "NULL") {
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        if (is_numeric($iId)) {
            $desbloquear = $this->Partidas_model->desbloquear($iId);
            if ($desbloquear == true) {
                $this->session->set_flashdata('correcto', 
                    '<strong>Bien!</strong> la partida se ha desbloqueado con éxito, puede reanudarla cuando lo desee.');
            } else {
                $this->session->set_flashdata('incorrecto', 
                    '<strong>Bien!</strong> la partida no se puede desbloquear, pruebe en unos instantes de nuevo, y si el problema persiste, consulte con el administrador del sitio.');
            }
            redirect(base_url()."index.php/partidas/pagina/$npag");
        } else {
           redirect(base_url()."index.php/partidas/pagina/$npag"); 
        }
    }

    //Controlador para eliminar
    public function eliminar_todoss($npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        
        foreach ($_POST["partida"] as $item){
            $eliminar = $this->Partidas_model->eliminar($item);
        }
        if ($eliminar == true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron todas las partidas señaladas.');
        } else {
            $this->session->set_flashdata('incorrecto', 
                '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/partidas/pagina/$npag");
    }
}
?>