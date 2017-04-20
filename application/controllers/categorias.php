<?php
class Categorias extends CI_Controller{
    public function __construct() {
        parent::__construct(); 
        $this->load->helper("url");  
        $this->load->model("categorias_model");
        $this->load->library("session");
        $this->load->library('pagination');
    }
     
    //controlador por defecto
    public function index(){
        if($this->session->userdata('perfil') != 0)
        {
            redirect(base_url().'index.php/login');
        }
        if ($this->session->userdata('is_logued_in') == FALSE)  {
            $this->session->set_flashdata('SESSION_ERR', 'Debe identificarse en el sistema.');
            redirect(base_url().'index.php/login');
        }
        
        $pages=5; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'index.php/categorias/pagina/';
        $config['total_rows'] = $this->categorias_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación       
        $data["categoria"] = $this->categorias_model->total_paginados($config['per_page'],$this->uri->segment(3));          
        
        $this->load->view("categorias",$data);
    }
    
    public function _validHexColor($sColor) {
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $sColor)) 
            return TRUE;
        else 
            return FALSE;
    }

    public function nueva(){
        if($this->input->post("submit")){
            // Primero vamos a hacer las validaciones.
            $this->form_validation->set_rules('sNombre', 'Categoría', 'trim|required|max_length[32]|min_length[2]');
            $this->form_validation->set_rules('sColor', 'Color', 'trim|required|callback__validHexColor');
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '<b>%s</b> es obligatorio.');
            $this->form_validation->set_message('min_length', '<b>%s</b> debe tener al menos <b>%s</b> caracteres.');
            $this->form_validation->set_message('max_length', 
                '<b>%s</b> no puede tener más de <b>%s</b> caracteres.');
            $this->form_validation->set_message('validHexColor', 'Color no válido.');

            if ($this->form_validation->run() == FALSE) {
                // Si la validación no se pasa, volvemos al directorio raiz.
                $this->index();
            } else {
                // Hacemos la inserción.
                 $add=$this->categorias_model->nueva(
                    $this->input->post("sNombre"),
                    $this->input->post("sDescripcion"),
                    $this->input->post("sColor"));
                if ($add == true){
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('categoria_ok', '<strong>Bien!</strong> la categoría se registró con éxito.');
                }else{
                    $this->session->set_flashdata('categoria_ko', '<strong>Oops!</strong> parece que hubo un problema y no hemos podido añadir la nueva categoría.');
                }       
                redirect(base_url()."index.php/categorias", "refresh");
            }
        }
    }
     
    public function mod($iId){
        if(is_numeric($iId)){
            $datos["mod"]=$this->categorias_model->mod($iId);
            $this->load->view("categoriasmod_view",$datos);
            
            if($this->input->post("submit")){
                // Hay que volver a validar los datos.
                $this->form_validation->set_rules('sNombre', 'Nombre', 'trim|required|max_length[32]|min_length[2]');
                $this->form_validation->set_rules('sColor', 'Color', 'trim|required|callback__validHexColor');
                // Una vez establecidas las reglas, validamos los campos.
                $this->form_validation->set_message('required', '%s es obligatorio.');
                $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
                $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');
                $this->form_validation->set_message('validHexColor', 'Color no válido.');
                
                if ($this->form_validation->run() == FALSE) {   
                    $this->session->set_flashdata('categoria_ko', '<strong>Oops!</strong> no hemos podido modificar los datos de la categoría.');               
                    redirect(base_url()."index.php/categorias/mod/".$iId, "refresh");
                } else {
                    $mod = $this->categorias_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sNombre"),
                        $this->input->post("sDescripcion"),
                        $this->input->post("sColor"));
                    if ($mod == true){
                        $this->session->set_flashdata('categoria_ok', '<strong>Bien!</strong> la categoría se modificó correctamente.');
                    }else{
                        $this->session->set_flashdata('categoria_ko', '<strong>Oops!</strong> no hemos podido modificar la categoría.');
                    }

                    redirect(base_url()."index.php/categorias/mod/".$iId, "refresh");

                }
            }
        } else {
            redirect(base_url()."index.php/categorias"); 
        }

    }
     
    //Controlador para eliminar
    public function eliminar($iId){
        if(is_numeric($iId)){
            $eliminar=$this->categorias_model->eliminar($iId);
            if($eliminar==true){
                $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, la categoria se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, no se pudo eliminar la categoria.');
          }
          redirect(base_url()."index.php/categorias");
        }else{
          redirect(base_url()."index.php/categorias");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos(){
        foreach ($_POST["categoria"] as $item){
            $eliminar=$this->categorias_model->eliminar($item);
        }
        if($eliminar==true){
            $this->session->set_flashdata('categoria_ok', '<strong>Bien!</strong> se eliminaron los datos.');
        }else{
            $this->session->set_flashdata('categoria_ko', '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/categorias");
    }

}
?>