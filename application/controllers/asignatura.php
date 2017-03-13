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
        
        //$usuarios["ver"]=$this->asignatura_model->ver();
         
        //cargo la vista y le paso los datos
        $this->load->view("asignatura",$data);
    }
     
    //controlador para añadir
    public function nueva(){
         
        //compruebo si se a enviado submit
        if($this->input->post("submit")){
         
        //llamo al metodo add
        $add=$this->asignatura_model->nueva($this->input->post("sNombre"));
        }
        if($add==true){
            //Sesion de una sola ejecución
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, la asignatura se registró con éxito.');
        }else{
            $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, parece que hubo un problema y no hemos podido añadir la nueva asignatura.');
        }
         
        //redirecciono la pagina a la url por defecto
        redirect(base_url()."index.php/asignatura");
    }
     
    //controlador para modificar al que 
    //le paso por la url un parametro
    public function mod($iId){
        if(is_numeric($iId)){
          $datos["mod"]=$this->asignatura_model->mod($iId);
          $this->load->view("asignaturamod_view",$datos);
          if($this->input->post("submit")){
                $mod=$this->asignatura_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sNombre"));
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