<?php

class Asignatura_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function filas()
    {
      $consulta = $this->db->get('asignatura');
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento, $pages) 
    {
      $this->db->select('a.*, t.sTitulacion');
      $this->db->from('titulacion t');
      $this->db->join('asignatura a', 't.iId = a.iId_Titulacion');
      $this->db->order_by('a.sNombre', 'ASC');
      $consulta = $this->db->get('', $por_pagina, $segmento);
      
      if($consulta->num_rows()>0)
      {
        foreach($consulta->result() as $fila)
        {
          $data[] = $fila;
        }
        return $data;
      } else {
        $this->db->select('a.*, t.sTitulacion');
        $this->db->from('titulacion t');
        $this->db->join('asignatura a', 't.iId = a.iId_Titulacion');
        $this->db->order_by('a.sNombre', 'ASC');
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
        //Hacemos una consulta
        $consulta=$this->db->query("SELECT * FROM asignatura;");
         
        //Devolvemos el resultado de la consulta
        return $consulta->result();
    }
     
    public function nueva($sNombre, $sTitulaciones){
        $data = array('sNombre' => $sNombre, 'iId_Titulacion' => $sTitulaciones);
        if ($this->db->insert('asignatura', $data)) {
            return true;
        } else { 
          return false;
        }	
    }
     
    public function mod($iId,$modificar="NULL",$sNombre="NULL",$iId_Titulacion="NULL"){
        if($modificar=="NULL"){
          $this->db->select('a.*, t.iId');
          $this->db->from('titulacion t');
          $this->db->join('asignatura a', 't.iId = a.iId_Titulacion');
          $this->db->where('a.iId', $iId);
          $consulta = $this->db->get();
          return $consulta->result();
        }else{
          $consulta=$this->db->query("UPDATE asignatura SET sNombre='$sNombre', iId_Titulacion = '$iId_Titulacion' WHERE iId=$iId;");
          if($consulta==true){
              return true;
          }else{
              return false;
          }
        }
    }
     
    public function eliminar($iId){
       $consulta=$this->db->query("DELETE FROM asignatura WHERE iId=$iId");
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