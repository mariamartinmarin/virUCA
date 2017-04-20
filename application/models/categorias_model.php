<?php

class Categorias_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
    
    public function filas()
    {
      $consulta = $this->db->get('categoria');
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento) 
    {
      $consulta = $this->db->get('categoria', $por_pagina, $segmento);
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
      $consulta=$this->db->query("SELECT * FROM categoria;");
      return $consulta->result();
    }
     
    public function nueva($sNombre, $sDescripcion, $sColor){
      $data = array('sNombre' => $sNombre, 'sDescripcion' => $sDescripcion, 'sColor' => $sColor);
      if ($this->db->insert('categoria', $data)) {
        return true;
      } else { 
        return false;
      }	
    }
     
    public function mod($iId,$modificar="NULL",$sNombre="NULL", $sDescripcion="NULL", $sColor="NULL"){
      if($modificar=="NULL"){
        $consulta=$this->db->query("SELECT * FROM categoria WHERE iId=$iId");
        return $consulta->result();
      }else{
        $consulta=$this->db->query("UPDATE categoria SET 
          sNombre='$sNombre', 
          sDescripcion='$sDescripcion',
          sColor='$sColor' WHERE iId=$iId;");
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