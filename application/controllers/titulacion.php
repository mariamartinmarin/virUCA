<?php
class Titulacion extends CI_Controller{
    public function __construct() {
        //llamamos al constructor de la clase padre
        parent::__construct(); 
         
        //llamo al helper url
        $this->load->helper("url");  
         
        //llamo o incluyo el modelo
        $this->load->model("titulacion_model");
         
        //cargo la libreria de sesiones
        $this->load->library("session");

        $this->load->library('pagination');
    }
     
    //controlador por defecto
    public function index(){
        $pages=5; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'index.php/titulacion/pagina/';
        $config['total_rows'] = $this->titulacion_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación       
        $data["titulacion"] = $this->titulacion_model->total_paginados($config['per_page'],$this->uri->segment(3));          
        
        $this->load->view("titulacion",$data);
    }
     
    //controlador para añadir
    public function nueva(){
        // Primero vamos a hacer las validaciones.
        $this->form_validation->set_rules('sTitulacion', 'Titulación', 'trim|required|max_length[32]|min_length[2]');
            
        // Una vez establecidas las reglas, validamos los campos.
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
        $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');

        if ($this->form_validation->run() == FALSE) {
            // Si la validación no se pasa, volvemos al directorio raiz.
            $this->index();
        } else {
            // Hacemos la inserción.
            $add=$this->titulacion_model->nueva(
                $this->input->post("sTitulacion"));
            if ($add == true){
                //Sesion de una sola ejecución
                $this->session->set_flashdata('correcto', '<strong>Bien!</strong> la titulación se registró con éxito.');
            }else{
                $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong>, parece que hubo un problema y no hemos podido añadir la nueva titulación.');
            }       
            redirect(base_url()."index.php/titulacion", "refresh");
        }
    }     
     
    //controlador para modificar al que 
    //le paso por la url un parametro
    public function mod($iId){
        if(is_numeric($iId)){
            $datos["mod"]=$this->titulacion_model->mod($iId);
            $this->load->view("titulacionmod_view",$datos);
            
            if($this->input->post("submit")){
                // Hay que volver a validar los datos.
                $this->form_validation->set_rules('sTitulacion', 'Titulación', 'trim|required|max_length[32]|min_length[2]');
                
                // Una vez establecidas las reglas, validamos los campos.
                $this->form_validation->set_message('required', '%s es obligatorio.');
                $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
                $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');
                
                if ($this->form_validation->run() == FALSE) {   
                    $this->session->set_flashdata('titulacion_ko', '<strong>Oops!</strong> no hemos podido modificar los datos de la titulación.');               
                    redirect(base_url()."index.php/titulacion/mod/".$iId, "refresh");
                } else {
                    $mod=$this->titulacion_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sTitulacion"));
                    if($mod==true){
                        $this->session->set_flashdata('titulacion_ok', '<strong>Bien!</strong> la titulacion se modificó correctamente.');
                    }else{
                        $this->session->set_flashdata('titulacion_ko', '<strong>Oops!</strong> no hemos podido modificar la titulacion.');
                    }

                    redirect(base_url()."index.php/titulacion/mod/".$iId, "refresh");

                }
            }
        } else {
            redirect(base_url()."index.php/titulacion"); 
        }
    }
     
    //Controlador para eliminar
    public function eliminar($iId){
        if(is_numeric($iId)){
          $eliminar=$this->titulacion_model->eliminar($iId);
          if($eliminar==true){
              $this->session->set_flashdata('correcto', '<strong>Bien!</strong> la titulación se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no se pudo eliminar la titulación. Sepa que si la <b>Titulacion</b> está vinculada a una o más asignaturas (o alumnos), no es posible el borrado de la misma.');
          }
          redirect(base_url()."index.php/titulacion");
        }else{
          redirect(base_url()."index.php/titulacion");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos(){
        foreach ($_POST["titulacion"] as $item){
            $eliminar=$this->titulacion_model->eliminar($item);
        }
        if($eliminar==true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        }else{
            $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro. Sepa que si la <b>Titulacion</b> está vinculada a una o más asignaturas, no es posible el borrado de la misma.');
        } 
        redirect(base_url()."index.php/titulacion");
    }
}
?>