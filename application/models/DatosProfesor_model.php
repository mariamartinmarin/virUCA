<?php

class DatosProfesor_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function verUsuario($iId){
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iId = $iId");
      return $consulta->result();
    }

    public function obtenerPassword($iId) {
      if (is_numeric($iId)) {
        $consulta = $this->db->query("SELECT sPassword FROM usuario WHERE iId=$iId");
        $resultado = $consulta->result();
        foreach($resultado as $variable){ $pass = $variable->sPassword;}
        return $pass;
      } else {
        return false;
      }
    }
     
    public function mod($iId, $modificar="NULL",
      $sNombre="NULL", 
      $sApellidos="NULL", 
      $sEmail="NULL", 
      $sUsuario="NULL",
      $sPassword_new = "NULL") {
      
      if ($modificar == "NULL"){
        $consulta=$this->db->query("SELECT * FROM usuario WHERE iId=$iId");
        return $consulta->result();
      } else {
        // Hay que revisar si el nombre de usuario (si se ha modificado) no coincide con el de otro usuario.
        // Si es así, no podrá darse como válido.
        $consulta = $this->db->query("SELECT * FROM usuario WHERE sUsuario = '$sUsuario' AND iId <> $iId ");
        // Modifiquemos los datos. Pero tenemos que tener en cuenta si se va a modificar o no la contraseña.
        // Con revisar si sólo uno de los campos viene diferente de NULL, lo sabremos.
        if ($sPassword_new == "") {
          $consulta=$this->db->query("UPDATE usuario SET 
            sNombre = '$sNombre', 
            sApellidos = '$sApellidos',
            sEmail = '$sEmail',
            sUsuario = '$sUsuario' 
            WHERE iId = $iId;");

        } else {
          // Modificación de contraseña. 
          $pass = sha1($sPassword_new);
          $consulta=$this->db->query("UPDATE usuario SET 
            sNombre = '$sNombre', 
            sApellidos = '$sApellidos',
            sEmail = '$sEmail',
            sUsuario = '$sUsuario',
            sPassword = '$pass' 
            WHERE iId = $iId;");
        }
        if ($consulta == true) return true; else return false;
      }
    }

}
?>