<?php
class Accesos extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("accesos_model");
        $this->load->library("session");
        $this->load->library('pagination');
    }
     
    //controlador por defecto
    public function index($iId="NULL"){  
        // Para la paginación

        $data['title'] = 'Paginacion_ci';
        $pages=5; //Número de registros mostrados por páginas
         //Cargamos la librería de paginación
        $config['base_url'] = base_url().'index.php/accesos/pagina/'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->accesos_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación       
        $data["acceso"] = $this->accesos_model->total_paginados($config['per_page'],$this->uri->segment(3));          
                

        //$accesos["ver"]=$this->accesos_model->ver();
        $this->load->view("accesos",$data);
    }

    
    //Controlador para eliminar
    public function eliminar($iId="NULL"){
        if(is_numeric($iId)){
            $eliminar=$this->accesos_model->eliminar($iId);
            if($eliminar==true){
                $this->session->set_flashdata('correcto', '<strong>Bien!</strong>, el acceso se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, no se pudo eliminar el acceso.');
          }
          redirect(base_url()."index.php/accesos");
        }else{

          redirect(base_url()."index.php/accesos");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos(){
        foreach ($_POST["acceso"] as $item){
            $eliminar=$this->accesos_model->eliminar($item);
        }
        if($eliminar==true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        }else{
            $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/accesos");
    }
}
?>