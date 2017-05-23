<?php
class Partidas extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Partidas_model");
        $this->load->library("session");
        $this->load->library('pagination');
    }
     
    //controlador por defecto
    public function index($iId="NULL"){  
        if($this->session->userdata('perfil') != 0)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }
        $pages=5; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'index.php/partidas/pagina/';
        $config['total_rows'] = $this->Partidas_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación 
        $data["partida"] = $this->Partidas_model->total_paginados(
            $config['per_page'],
            $this->uri->segment(3),
            $pages);          
        $data["num_filas"] = $config['total_rows'];
        $this->load->view("partidas",$data);
    }
     
    public function mod($iId){
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
    public function eliminar($iId, $npag = "NULL"){
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

    //Controlador para eliminar
    public function eliminar_todos($npag = "NULL"){
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