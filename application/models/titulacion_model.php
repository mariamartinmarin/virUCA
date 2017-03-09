<?php

class Titulacion_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
     
    public function ver(){
        //Hacemos una consulta
        $consulta=$this->db->query("SELECT * FROM titulacion;");
         
        //Devolvemos el resultado de la consulta
        return $consulta->result();
    }
     
    public function nueva($sTitulacion){
        $data = array('sTitulacion' => $sTitulacion);
        if ($this->db->insert('titulacion', $data)) {
            return true;
        } else { 
          return false;
        }	
    }
     
    public function mod($iId,$modificar="NULL",$sTitulacion="NULL"){
        if($modificar=="NULL"){
            $consulta=$this->db->query("SELECT * FROM titulacion WHERE iId=$iId");
            return $consulta->result();
        }else{
          $consulta=$this->db->query("UPDATE titulacion SET sTitulacion='$sTitulacion' WHERE iId=$iId;");
          if($consulta==true){
              return true;
          }else{
              return false;
          }
        }
    }
     
    public function eliminar($iId){
       $consulta=$this->db->query("DELETE FROM titulacion WHERE iId=$iId");
       if($consulta==true){
           return true;
       }else{
           return false;
       }
    }
}
?>