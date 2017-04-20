<?php
class Asignatura extends CI_Controller{
    public function __construct() {
        //llamamos al constructor de la clase padre
        parent::__construct(); 
         
        //llamo al helper url
        $this->load->helper("url");  
         
        //llamo o incluyo el modelo
        $this->load->model("asignatura_model");
         
        //cargo la libreria de sesiones
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
        $config['base_url'] = base_url().'index.php/asignatura/pagina/';
        $config['total_rows'] = $this->asignatura_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación       
        $data["asignatura"] = $this->asignatura_model->total_paginados($config['per_page'],$this->uri->segment(3));
        $data["titulaciones"] = $this->asignatura_model->get_titulaciones();
                  
        
        //$usuarios["ver"]=$this->asignatura_model->ver();
         
        //cargo la vista y le paso los datos
        $this->load->view("asignatura",$data);
    }
     
    //controlador para añadir
    public function nueva(){
        if($this->input->post("submit")){
            $this->form_validation->set_rules('sNombre', 'Asignatura', 
                'trim|required|max_length[128]|min_length[4]');
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '<b>%s</b> es obligatorio.');
            $this->form_validation->set_message('min_length', '<b>%s</b> debe tener al menos <b>%s</b> caracteres.');
            $this->form_validation->set_message('max_length', 
                '<b>%s</b> no puede tener más de <b>%s</b> caracteres.');

            if ($this->form_validation->run() == FALSE) {
                // Si la validación no se pasa, volvemos al directorio raiz.
                $this->index();
            } else {
                // Hacemos la inserción.
                $add=$this->asignatura_model->nueva($this->input->post("sNombre"), 
                    $this->input->post("sTitulaciones"));
        
                if ($add == true) {
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('correcto', 
                        '<strong>Bien!</strong> asignatura registrada.');
                } else {
                    $this->session->set_flashdata('incorrecto', 
                        '<strong>Oops!</strong> no se pudo añadir la asignatura.');
                }
         
                //redirecciono la pagina a la url por defecto
                redirect(base_url()."index.php/asignatura");
            }
        }
    }
     
    //controlador para modificar al que 
    //le paso por la url un parametro
    public function mod($iId){
        if(is_numeric($iId)){
          $datos["mod"]=$this->asignatura_model->mod($iId);
          $datos["titulaciones"] = $this->asignatura_model->get_titulaciones();
          
          $this->load->view("asignaturamod_view",$datos);
          if($this->input->post("submit")){
                $mod=$this->asignatura_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sNombre"),
                        $this->input->post("iTitulacion"));
                if($mod==true){
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('correcto', '<strong>Bien!</strong> la asignatura se modificó correctamente.');
                }else{
                    $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no hemos podido modificar los datos.');
                }
                redirect(base_url()."index.php/asignatura");
            }
        }else{
            redirect(base_url()."index.php/asignatura"); 
        }
    }
     
    //Controlador para eliminar
    public function eliminar($iId){
        if(is_numeric($iId)){
          $eliminar=$this->asignatura_model->eliminar($iId);
          if($eliminar==true){
              $this->session->set_flashdata('correcto', '<strong>Bien!</strong> la asignatura se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no se pudo eliminar la asignatura.');
          }
          redirect(base_url()."index.php/asignatura");
        }else{
          redirect(base_url()."index.php/asignatura");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos(){
        foreach ($_POST["asignatura"] as $item){
            $eliminar=$this->asignatura_model->eliminar($item);
        }
        if($eliminar==true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        }else{
            $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/asignatura");
    }

}
?>