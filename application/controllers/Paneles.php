<?php
class Paneles extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("Paneles_model");
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
        $pages=20; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'index.php/paneles/pagina/';
        $config['total_rows'] = $this->Paneles_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación
        $data["categorias"] = $this->Paneles_model->get_categorias(); 
        $data["paneles"] = $this->Paneles_model->total_paginados(
            $config['per_page'],
            $this->uri->segment(3),
            $pages);          
        $data["num_filas"] = $config['total_rows'];
        $this->load->view("paneles",$data);
    }
     
    public function mod($iId){
        if(is_numeric($iId)){
            $datos["paneles"]=$this->Paneles_model->mod($iId);
            $datos["categorias"] = $this->Paneles_model->get_categorias();
            $datos["enpartida"] = $this->Paneles_model->enPartida($iId);

            $this->load->view("panelesmod_view",$datos);
            
            if(count($this->input->post("categorias")) > 0){
                $mod = $this->Paneles_model->mod(
                    $iId,
                    $this->input->post("submit"),
                    $this->input->post("panel"),
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
                $this->session->set_flashdata('profesor_ko', 'Es:'.$mierda);
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
}
?>