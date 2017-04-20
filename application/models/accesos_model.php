<?php

class Accesos_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
    public function filas()
    {
      $consulta = $this->db->get('acceso');
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina,$segmento) 
    {
      $this->db->select('*');
      $this->db->from('acceso');
      $this->db->order_by('dFecha', 'DESC');
      $consulta = $this->db->get('', $por_pagina, $segmento);

      //$consulta = $this->db->get('acceso', $por_pagina, $segmento);
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
      $consulta=$this->db->query("SELECT * FROM acceso ORDER BY iId asc");
      return $consulta->result();
    }

    
     
    
     
    public function eliminar($iId){
      $consulta=$this->db->query("DELETE FROM acceso WHERE iId=$iId");
      if($consulta==true){
        return true;
      }else{
        return false;
      }
    }
}
?>