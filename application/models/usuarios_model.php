<?php

class Usuarios_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
    
    public function filas()
    {
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iPerfil = 0");
      return  $consulta->num_rows() ;
    }

    
    function total_paginados($por_pagina, $segmento, $pages) 
    {
      $this->db->select('*');
      $this->db->from('usuario');
      $this->db->where('iPerfil', 0);
      $this->db->order_by('sApellidos', 'ASC');
      $consulta = $this->db->get('', $por_pagina, $segmento);

      if($consulta->num_rows()>0)
      {
        foreach($consulta->result() as $fila)
        {
          $data[] = $fila;
        }
        return $data;
      } else {
        $this->db->select('*');
        $this->db->from('usuario');
        $this->db->where('iPerfil', 0);
        $this->db->order_by('sApellidos', 'ASC');

        $segmento_anterior = $segmento - $pages;
        if ($segmento_anterior < 0) $segmento_anterior = "";
          $consulta = $this->db->get('', $por_pagina, $segmento_anterior);
          if($consulta->num_rows()>0) {
            foreach($consulta->result() as $fila) {
              $data[] = $fila;
            }
            return $data;
          }
        }
    }

    public function ver(){
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iPerfil = 0");
      return $consulta->result();
    }

    public function verUsuario($iId){
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iId = $iId");
      return $consulta->result();
    }
     
    public function nueva($iPerfil, $sNombre, $sApellidos, $sEmail, $sUsuario, $sPassword){
      $data = array('iPerfil' => $iPerfil, 
        'sNombre' => $sNombre,
        'sApellidos' => $sApellidos,
        'sEmail' => $sEmail,
        'sUsuario' => $sUsuario,
        'sPassword' => sha1($sPassword)
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
        $sUsuario="NULL") {
      
      if($modificar=="NULL"){
        $consulta=$this->db->query("SELECT * FROM usuario WHERE iId=$iId");
        return $consulta->result();
      } else {
        $consulta=$this->db->query("UPDATE usuario SET 
            sNombre = '$sNombre', 
            sApellidos = '$sApellidos',
            sEmail = '$sEmail',
            sUsuario = '$sUsuario' 
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