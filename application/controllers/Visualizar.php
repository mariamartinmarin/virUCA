<?php
class Visualizar extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Visualizar_model");
        $this->load->library("session");
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

        // Comprobar que no sea una partida acabada.
        if ($this->Visualizar_model->partida_acabada($iId_Partida) == true)
            redirect(base_url().'index.php/partidas'); 

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

       
        $data["partida"] = $this->Visualizar_model->get_partida($iId_Partida);
        $data["panel"] = $this->Visualizar_model->get_panel($iId_Panel[0]);      
        $data["casillas"] = $this->Visualizar_model->get_casillas($iId_Panel[0]);
        $data["resumen"] = $this->Visualizar_model->get_resumen_partida($iId_Partida); 
        $iId_Profesor = $this->Visualizar_model->get_profesor_id($iId_Partida); 

        // Decidimos si vamos a mostrar el tablero, o una pregunta o el tablero en curso.
        $this->load->view("visualizar", $data);
        
    }

    public function correccion() {
        
        $pregunta = $this->Jugar_model->get_respuesta_ok($this->input->post("iId_Pregunta"));
        if ($pregunta->iOrden == $this->input->post("respuesta")) {
            // El equipo ha acertado. Hay que comprobar si está en una celda especial, en cuyo caso, el
            // tratamiento es diferente.
            $this->Jugar_model->establecer_acierto();
            $texto = "<strong>¡Enhorabuena!</strong> la respuesta es correcta!";
            $this->session->set_flashdata('respuesta_ok', $texto);
        } else {
            // El equipo no ha acertado. Hay que tener en cuenta, que si es una casilla de retroceso (Jeringuilla)
            // Hay que hacer que vuelva al inicio de la partida.
            switch ($pregunta->iOrden) {
                case '1': $resp = "A"; break;
                case '2': $resp = "B"; break;
                case '3': $resp = "C"; break;
                case '4': $resp = "D"; break; 
                default: break;
            }

            // Hay que restaurar la posición del grupo a la que tenía antes.
            $this->Jugar_model->restablecer_grupo();
            $texto = "<strong>!Lo siento!</strong> la respuesta no es correcta!.<br>La respuesta correcta a la pregunta <b>".$pregunta->sPregunta."</b><br>era la <b>".$resp."</b>.<br>Lo sentimos, pero retrocederás a la posición anterior.";
            $this->session->set_flashdata('respuesta_ko', $texto);
        }

        // Actualizamos las variables de sesión. Hay que tener en cuenta que si el grupo que tiene el turno es
        // el último, hay que empezar por el primero.
        $this->Jugar_model->actualizar_session();

        $url = "index.php/jugar/".$this->session->userdata('iId_Partida')."/".$this->session->userdata('iId_Panel');
        redirect(base_url().$url);
    }

    public function finalizar($iId_Partida) {
        // La función se ha llamado expresamente para abortar la partida y acabarla.
        if (is_numeric($iId_Partida)) {
            $this->Jugar_model->finalizar($iId_Partida);
        }
        redirect(base_url()."index.php/partidas","refresh");
    }
    
    public function salir($iId_Partida) {
        if (is_numeric($iId_Partida)) {
            $finalizar = $this->Jugar_model->salir($iId_Partida);
            if ($finalizar) 
                $this->session->set_flashdata('correcto', '<strong>Bien!</strong> la partida ha sido cerrada.');
            else
                $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no podemos cerrar la partida.');
        }
        redirect(base_url()."index.php/partidas", "refresh");
    }
}
?>