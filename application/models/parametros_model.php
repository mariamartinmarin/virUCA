<?php

class Parametros_model extends CI_Model{
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
      $consulta=$this->db->query("SELECT * FROM parametros;");
      return $consulta->result();
    }
     
     
    public function mod($iActiva){
      $consulta=$this->db->query("UPDATE parametros SET iActiva = '$iActiva' WHERE iId = 0;");
      if($consulta==true){
        return true;
      }else{
        return false;
      }
    }
     
}
?>