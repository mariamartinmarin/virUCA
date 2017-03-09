<?php

class Categorias_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
    
    public function ver(){
      $consulta=$this->db->query("SELECT * FROM categoria;");
      return $consulta->result();
    }
     
    public function nueva($sNombre, $sDescripcion){
      $data = array('sNombre' => $sNombre, 'sDescripcion' => $sDescripcion);
      if ($this->db->insert('categoria', $data)) {
        return true;
      } else { 
        return false;
      }	
    }
     
    public function mod($iId,$modificar="NULL",$sNombre="NULL", $sDescripcion="NULL"){
      if($modificar=="NULL"){
        $consulta=$this->db->query("SELECT * FROM categoria WHERE iId=$iId");
        return $consulta->result();
      }else{
        $consulta=$this->db->query("UPDATE categoria SET sNombre='$sNombre', sDescripcion='$sDescripcion' WHERE iId=$iId;");
        if($consulta==true){
          return true;
        }else{
          return false;
        }
      }
    }
     
    public function eliminar($iId){
      $consulta=$this->db->query("DELETE FROM categoria WHERE iId=$iId");
      if($consulta==true){
        return true;
      }else{
        return false;
      }
    }
}
?>