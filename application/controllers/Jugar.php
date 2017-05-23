<?php
class Jugar extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Jugar_model");
        $this->load->library("session");
        $this->load->library('pagination');
    }

    public function _remap($method, $params = array())
    {
        //comprobamos si existe el método, no queremos que al llamar
        //a un método codeigniter crea que es un parámetro del index
        if(!method_exists($this, $method))
        {
            $this->index($method, $params);
        }else{
            return call_user_func_array(array($this, $method), $params);
        }
    }
     
    //controlador por defecto
    public function index($iId_Partida="NULL", $iId_Panel="NULL", $iTurno = "", $tirada = ""){  
        $iTurno = $this->uri->segment(4);
        $tirada = $this->uri->segment(5);
       
        if($this->session->userdata('perfil') != 0)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }

        // Comprobamos si se va a continuar con una jugada o lo que quiere hacerse en cargar una partida
        // de primeras.
        if ($iTurno != "" && $tirada != "") {
            $this->Jugar_model->gestionar_partida($iId_Partida,
                $iId_Panel[0],
                $iTurno,
                $tirada);

            $data["tirada"] = $tirada;
            $data["iTurno"] = $iTurno;
        }

        // Tenemos que preparar la partida, rellenando la tabla resumen.
        $this->Jugar_model->preparar_partida($iId_Partida);

        $data["partida"] = $this->Jugar_model->get_partida($iId_Partida);
        $data["panel"] = $this->Jugar_model->get_panel($iId_Panel[0]);      
        $data["casillas"] = $this->Jugar_model->get_casillas($iId_Panel[0]);
        $data["resumen"] = $this->Jugar_model->get_resumen_partida($iId_Partida);  

        // Inicializamos los valores correspondientes de las variables de sesión.
        if ($this->session->userdata('iId_Partida') == '') {   
            $this->session->set_userdata('iId_Partida', $iId_Partida);
            $this->session->set_userdata('iId_Panel', $iId_Panel);
            $this->session->set_userdata('iTurno', $iTurno);
            $this->session->set_userdata('tirada', $tirada);
            $this->session->set_userdata('pregunta', 0);     
        }

        // Decidimos si vamos a mostrar el tablero, o una pregunta.
        if ($this->session->userdata('pregunta') == 1) 
            redirect(base_url()."index.php/cuestion", "refresh");
        else
            $this->load->view("jugar",$data);
    }
    
    public function salir($iId_Partida) {
        if (is_numeric($iId_Partida)) {
            $this->Jugar_model->salir($iId_Partida);

            $this->session->unset_userdata('iId_Partida');
            $this->session->unset_userdata('iId_Panel');
            $this->session->unset_userdata('iTurno');
            $this->session->unset_userdata('tirada');
            $this->session->unset_userdata('pregunta');
        }
        redirect(base_url()."index.php/partidas", "refresh");
    }

    public function mod($iId){
        if(is_numeric($iId)){
            $datos["mod"]=$this->preguntas_model->mod($iId);
            $datos["respuestas"] = $this->preguntas_model->respuestas($iId);
            $datos["categorias"] = $this->preguntas_model->get_categorias();
            $this->load->view("preguntasmod_view",$datos);
            
            if($this->input->post("submit")){
            
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sPregunta','Pregunta','trim|required|max_length[512]|min_length[10]');
            $this->form_validation->set_rules('sResp1','Respuesta A','trim|required|max_length[512]');
            $this->form_validation->set_rules('sResp2','Respuesta B','trim|required|max_length[512]');
            $this->form_validation->set_rules('sResp3','Respuesta C','trim|required|max_length[512]');
            $this->form_validation->set_rules('sResp4','Respuesta D','trim|required|max_length[512]');
            
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '%s es obligatorio.');
            $this->form_validation->set_message('valid_email', 'El %s no es válido.');
            $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
            $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');

            if ($this->form_validation->run() == FALSE) {   
                $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> no hemos podido modificar la pregunta.');               
                redirect(base_url()."index.php/preguntas/mod/".$iId, "refresh");
            } else {
                $activa = 1;
                if ($this->input->post("bActiva")[0] == "") $activa = 0;
                $mod=$this->preguntas_model->mod(
                    $iId,
                    $this->input->post("submit"),
                    $this->input->post("sPregunta"),
                    $this->input->post("sResp1"),
                    $this->input->post("sResp2"),
                    $this->input->post("sResp3"),
                    $this->input->post("sResp4"),
                    $this->input->post("iCategoria"),
                    $activa, 
                    $this->input->post("iId_Usuario"), 
                    $this->input->post("nPuntuacion"),
                    $this->input->post("verdadera"),
                    $this->input->post("sObservaciones"));

                if ($mod == true) {
                    $this->session->set_flashdata('profesor_ok', '<strong>Bien!</strong> la pregunta se modificó con éxito.');
                } else {
                    $this->session->set_flashdata('profesor_ko', '<strong>Oops!</strong> no hemos podido modificar la pregunta.');
                    }

                    redirect(base_url()."index.php/preguntas/mod/".$iId, "refresh");
                }
            }
        } else {
            redirect(base_url()."index.php/preguntas"); 
        }
    }

     
    //Controlador para eliminar
    public function eliminar($iId, $npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        
        if(is_numeric($iId)){
            $eliminar = $this->preguntas_model->eliminar($iId);
            if ($eliminar == true){
                $this->session->set_flashdata('correcto', 
                    '<strong>Bien!</strong> la pregunta se eliminó con éxito.');
            } else {
                $this->session->set_flashdata('incorrecto',
                    '<strong>Oops!</strong> no se pudo eliminar la pregunta.');
            }
            redirect(base_url()."index.php/preguntas/pagina/$npag");
        } else {
          redirect(base_url()."index.php/preguntas/pagina/$npag");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos($npag = "NULL"){
        if ((is_numeric($npag) == FALSE) or (is_numeric($npag) && $npag < 0)) $npag = "";
        
        foreach ($_POST["pregunta"] as $item){
            $eliminar = $this->preguntas_model->eliminar($item);
        }
        if ($eliminar == true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        } else {
            $this->session->set_flashdata('incorrecto', 
                '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/preguntas/pagina/$npag");
    }
}
?>