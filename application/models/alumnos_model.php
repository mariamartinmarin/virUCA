<?php

class Alumnos_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function filas()
    {
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iPerfil = 1");
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento) 
    {
      $this->db->select('u.*, t.sTitulacion');
      $this->db->from('titulacion t');
      $this->db->join('usuario u', 't.iId = u.iId_Titulacion');
      $this->db->where('iPerfil', 1);
      $this->db->order_by('sApellidos ASC');
      $consulta = $this->db->get('', $por_pagina, $segmento);
      
      if($consulta->num_rows()>0)
      {
        foreach($consulta->result() as $fila)
        {
          $data[] = $fila;
        }
        return $data;
      }
    }
    
    public function ver(){
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iPerfil = 1");
      return $consulta->result();
    }

    public function verAlumno($iId){
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iId = $iId");
      return $consulta->result();
    }
     
    public function nueva($iPerfil, $sNombre, $sApellidos, $sEmail, $sUsuario, $sPassword, $sTitulaciones){
      $data = array('iPerfil' => $iPerfil, 
        'sNombre' => $sNombre,
        'sApellidos' => $sApellidos,
        'sEmail' => $sEmail,
        'sUsuario' => $sUsuario,
        'sPassword' => $sPassword,
        'iId_Titulacion' => $sTitulaciones
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
        $sPassword="NULL",
        $iPerfil="NULL",
        $iId_Titulacion="NULL") {
      
      if($modificar=="NULL"){
        $this->db->select('u.*, t.iId');
        $this->db->from('titulacion t');
        $this->db->join('usuario u', 't.iId = u.iId_Titulacion');
        $this->db->where('u.iId', $iId);
        $consulta = $this->db->get();
        return $consulta->result();
      } else {
        $consulta=$this->db->query("UPDATE usuario SET 
            sNombre = '$sNombre', 
            sApellidos = '$sApellidos',
            sEmail = '$sEmail',
            sUsuario = '$sUsuario',
            sPassword = '$sPassword',
            iId_Titulacion = '$iId_Titulacion' 
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

    public function get_titulaciones() {
      $query = $this->db->query("select * from titulacion");
      if ($query->num_rows() > 0) {
        // Almacenamos el resultado en una matriz.
        foreach($query->result() as $row)
          $titulaciones[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sTitulacion, ENT_QUOTES);
        $query->free_result();
        return $titulaciones;
      }
    }
}
?>