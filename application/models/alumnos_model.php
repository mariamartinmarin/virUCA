<?php

class Alumnos_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
    
    public function ver(){
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iPerfil = 1");
      return $consulta->result();
    }

    public function verAlumno($iId){
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iId = $iId");
      return $consulta->result();
    }
     
    public function nueva($iPerfil, $sNombre, $sApellidos, $sEmail, $sUsuario, $sPassword){
      $data = array('iPerfil' => $iPerfil, 
        'sNombre' => $sNombre,
        'sApellidos' => $sApellidos,
        'sEmail' => $sEmail,
        'sUsuario' => $sUsuario,
        'sPassword' => $sPassword
        );
      if ($this->db->insert('usuario', $data)) {
        return true;
      } else { 
        return false;
      }	
    }
     
    public function mod($iId,
        $modificar="NULL",
        $sNombre="NULL", 
        $sApellidos="NULL", 
        $sEmail="NULL", 
        $sUsuario="NULL", 
        $sPassword="NULL") {
      
      if($modificar=="NULL"){
        $consulta=$this->db->query("SELECT * FROM usuario WHERE iId=$iId");
        return $consulta->result();
      } else {
        $consulta=$this->db->query("UPDATE usuario SET 
            sNombre = '$sNombre', 
            sApellidos = '$sApellidos',
            sEmail = '$sEmail',
            sUsuario = '$sUsuario',
            sPassword = '$sPassword' 
            WHERE iId = $iId;");
        if($consulta==true){
          return true;
        }else{
          return false;
        }
      }
    }
     
    public function eliminar($iId){
      $consulta=$this->db->query("DELETE FROM usuario WHERE iId=$iId");
      if($consulta==true){
        return true;
      }else{
        return false;
      }
    }
}
?>