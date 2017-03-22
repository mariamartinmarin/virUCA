<?php
class Curso extends CI_Controller{
    public function __construct() {
        //llamamos al constructor de la clase padre
        parent::__construct(); 
         
        //llamo al helper url
        $this->load->helper("url");  
         
        //llamo o incluyo el modelo
        $this->load->model("curso_model");
         
        //cargo la libreria de sesiones
        $this->load->library("session");
        $this->load->library('pagination');
    }
     
    //controlador por defecto
    public function index(){
        $pages=5; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'index.php/curso/pagina/';
        $config['total_rows'] = $this->curso_model->filas();//calcula el número de filas  
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 5; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera';//primer link
        $config['last_link'] = 'Última';//último link
        $config["uri_segment"] = 3;//el segmento de la paginación
        $config['next_link'] = 'Siguiente';//siguiente link
        $config['prev_link'] = 'Anterior';//anterior link
        $this->pagination->initialize($config); //inicializamos la paginación       
        $data["curso"] = $this->curso_model->total_paginados($config['per_page'],$this->uri->segment(3));
        $data["titulaciones"] = $this->curso_model->get_titulaciones();
        $data["asignaturas"] = $this->curso_model->get_asignaturas();
                  
        
        //$usuarios["ver"]=$this->asignatura_model->ver();
         
        //cargo la vista y le paso los datos
        $this->load->view("curso",$data);
    }
     
    //controlador para añadir
    public function nueva(){
         
        //compruebo si se a enviado submit
        if($this->input->post("submit")){
            $this->form_validation->set_rules('sCurso', 'Curso', 'trim|required|max_length[128]|min_length[4]');
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', '%s es obligatorio.');
            $this->form_validation->set_message('valid_email', 'El %s no es válido.');
            $this->form_validation->set_message('min_length', '%s debe tener al menos %s caracteres.');
            $this->form_validation->set_message('max_length', '%s no puede tener más de %s caracteres.');

            if ($this->form_validation->run() == FALSE) {
                // Si la validación no se pasa, volvemos al directorio raiz.
                $this->index();
            } else {
                // Hacemos la inserción.
                $add=$this->curso_model->nueva($this->input->post("sCurso"), 
                    $this->input->post("sTitulaciones"),
                    $this->input->post("sAsignaturas"));
                if ($add == true) {
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('correcto', 
                        '<strong>Bien!</strong> el curso se registró con éxito.');
                } else {
                    $this->session->set_flashdata('incorrecto', 
                        '<strong>Oops!</strong>, parece que hubo un problema y no hemos podido añadir 
                        el nuevo curso.');
                }
         
                //redirecciono la pagina a la url por defecto
                redirect(base_url()."index.php/curso");
            }
        }
    }
     
    //controlador para modificar al que 
    //le paso por la url un parametro
    public function mod($iId){
        if(is_numeric($iId)){
          $datos["mod"]=$this->curso_model->mod($iId);
          $datos["titulaciones"] = $this->curso_model->get_titulaciones();
          $datos["asignaturas"] = $this->curso_model->get_asignaturas();
          
          $this->load->view("cursomod_view",$datos);
          if($this->input->post("submit")){
                $mod=$this->curso_model->mod(
                        $iId,
                        $this->input->post("submit"),
                        $this->input->post("sCurso"),
                        $this->input->post("iTitulacion"),
                        $this->input->post("iAsignatura"));
                if ( $mod == true) {
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('correcto', 
                        '<strong>Bien!</strong> el curso se modificó correctamente.');
                } else {
                    $this->session->set_flashdata('incorrecto', 
                        '<strong>Oops!</strong> no hemos podido modificar los datos.');
                }
                redirect(base_url()."index.php/curso");
            }
        } else {
            redirect(base_url()."index.php/curso"); 
        }
    }
     
    //Controlador para eliminar
    public function eliminar($iId){
        if(is_numeric($iId)){
          $eliminar=$this->curso_model->eliminar($iId);
          if($eliminar==true){
              $this->session->set_flashdata('correcto', '<strong>Bien!</strong> el curso se eliminó con éxito.');
          }else{
              $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no se pudo eliminar el curso.');
          }
          redirect(base_url()."index.php/curso");
        }else{
          redirect(base_url()."index.php/curso");
        }
    }

    //Controlador para eliminar
    public function eliminar_todos(){
        foreach ($_POST["curso"] as $item){
            $eliminar=$this->curso_model->eliminar($item);
        }
        if($eliminar==true){
            $this->session->set_flashdata('correcto', '<strong>Bien!</strong> se eliminaron los datos.');
        }else{
            $this->session->set_flashdata('incorrecto', '<strong>Oops!</strong> no se pudieron eliminar todos los datos o no seleccionó ningún registro.');
        } 
        redirect(base_url()."index.php/curso");
    }

}
?>