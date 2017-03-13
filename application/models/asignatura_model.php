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

    function total_paginados($por_pagina, $segmento) 
    {
      $consulta = $this->db->get('asignatura', $por_pagina, $segmento);
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
        //Hacemos una consulta
        $consulta=$this->db->query("SELECT * FROM asignatura;");
         
        //Devolvemos el resultado de la consulta
        return $consulta->result();
    }
     
    public function nueva($sNombre){
        $data = array('sNombre' => $sNombre);
        if ($this->db->insert('asignatura', $data)) {
            return true;
        } else { 
          return false;
        }	
    }
     
    public function mod($iId,$modificar="NULL",$sNombre="NULL"){
        if($modificar=="NULL"){
            $consulta=$this->db->query("SELECT * FROM asignatura WHERE iId=$iId");
            return $consulta->result();
        }else{
          $consulta=$this->db->query("UPDATE asignatura SET sNombre='$sNombre' WHERE iId=$iId;");
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
}
?>