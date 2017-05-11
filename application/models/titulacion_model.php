<?php

class Titulacion_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function filas()
    {
      $consulta = $this->db->get('titulacion');
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento, $pages) 
    {
      $consulta = $this->db->get('titulacion', $por_pagina, $segmento);
      if($consulta->num_rows()>0)
      {
        foreach($consulta->result() as $fila)
        {
          $data[] = $fila;
        }
        return $data;
      } else {
        //$consulta = $this->db->get('titulacion', $por_pagina, $segmento);
        $segmento_anterior = $segmento - $pages;
        if ($segmento_anterior < 0) $segmento_anterior = "";
          $consulta = $this->db->get('titulacion', $por_pagina, $segmento_anterior);
          if($consulta->num_rows()>0) {
            foreach($consulta->result() as $fila) {
              $data[] = $fila;
            }
            return $data;
          }
        }
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
      $this->db->select('a.iId');
      $this->db->from('asignatura a');
      $this->db->where('a.iId_Titulacion', $iId);
      $consulta = $this->db->get();
      
      $this->db->select('c.iId');
      $this->db->from('curso c');
      $this->db->where('c.iId_Titulacion', $iId);
      $consulta2 = $this->db->get();

      if (($consulta->num_rows() >= 1) || ($consulta2->num_rows() >= 1)) {
        return false;
      } else {
        $consulta=$this->db->query("DELETE FROM titulacion WHERE iId=$iId");
        if($consulta==true){
           return true;
        }else{
           return false;
        }
      }
    }
}
?>