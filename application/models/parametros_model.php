<?php

class Parametros_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function ver(){
      $consulta=$this->db->query("SELECT * FROM parametros;");
      return $consulta->result();
    }
     
     
    public function mod($iActiva, $iEdicion){
      $consulta=$this->db->query("UPDATE parametros SET 
          iActiva = '$iActiva',
          iEdicion = '$iEdicion' 
          WHERE iId = 0;");

      if($consulta==true) 
        return true;
      else
        return false;
    }
}
?>