<?php

class DatosAlumno_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function verUsuario($iId){
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iId = $iId");
      return $consulta->result();
    }

    public function verCursos($iId) {
      $this->db->select('usuarioscurso.*, titulacion.sTitulacion, asignatura.sNombre, universidad.sUniversidad');
      $this->db->from('usuarioscurso');
      $this->db->join('titulacion', 'titulacion.iId = usuarioscurso.iId_Titulacion');
      $this->db->join('asignatura', 'asignatura.iId = usuarioscurso.iId_Asignatura');
      $this->db->join('universidad', 'universidad.iId = usuarioscurso.iId_Universidad');
      $this->db->where('usuarioscurso.iId_Usuario', $iId);

      $query = $this->db->get();
      return $query->result();
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
      $sPassword_new = "NULL") {
      
      if ($modificar == "NULL"){
        $consulta=$this->db->query("SELECT * FROM usuario WHERE iId=$iId");
        return $consulta->result();
      } else {
        // Modifiquemos los datos. Pero tenemos que tener en cuenta si se va a modificar o no la contraseña.
        // Con revisar si sólo uno de los campos viene diferente de NULL, lo sabremos.
        if ($sPassword_new == "") {
          $consulta=$this->db->query("UPDATE usuario SET 
            sNombre = '$sNombre', 
            sApellidos = '$sApellidos',
            sEmail = '$sEmail'
            WHERE iId = $iId;");

        } else {
          // Modificación de contraseña. 
          $pass = sha1($sPassword_new);
          $consulta=$this->db->query("UPDATE usuario SET 
            sNombre = '$sNombre', 
            sApellidos = '$sApellidos',
            sEmail = '$sEmail',
            sPassword = '$pass' 
            WHERE iId = $iId;");
        }
        if ($consulta == true) return true; else return false;
      }
    }

}
?>