<?php

class Partidas_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
    
    public function filas()
    {
      $consulta = $this->db->query("SELECT * FROM partida");
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento, $pages) 
    {
      $this->db->select('p.*, pa.sNombre as nombrePanel, cu.sCurso as nombreCurso, u.sNombre as nombreProfesor');
      $this->db->from('partida p');
      $this->db->join('panel pa', 'pa.iId = p.iId_Panel');
      $this->db->join('curso cu', 'cu.iId = p.iId_Curso');
      $this->db->join('usuario u', 'u.iId = p.iId_Profesor');
      $this->db->order_by('dFecha ASC');

      $consulta = $this->db->get('', $por_pagina, $segmento);

      if($consulta->num_rows()>0)
      {
        foreach($consulta->result() as $fila)
        {
          $data[] = $fila;
        }
        return $data;
      } else {

        $this->db->select('p.*, pa.sNombre as nombrePanel, cu.sCurso as nombreCurso, u.sNombre as nombreProfesor');
        $this->db->from('partida p');
        $this->db->join('panel pa', 'pa.iId = p.iId_Panel');
        $this->db->join('curso cu', 'cu.iId = p.iId_Curso');
        $this->db->join('usuario u', 'u.iId = p.iId_Profesor');
        $this->db->order_by('dFecha ASC');

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
 
     
    public function mod($iId,
        $modificar="NULL",
        $nGrupos="NULL", 
        $iPanel="NULL", 
        $iCurso="NULL") {
      
      if ($modificar == "NULL"){
        $consulta=$this->db->query("SELECT * FROM partida WHERE iId = $iId");
        return $consulta->result();
      } else {
        $consulta=$this->db->query("UPDATE partida SET 
            nGrupos = '$nGrupos', 
            iId_Panel = '$iId_Panel',
            iId_Curso = '$iId_Curso',
            WHERE iId = $iId;");
        if ($consulta == true)
          return true;
        else
          return false;
      }
    }
     
    public function eliminar($iId){
      $consulta=$this->db->query("DELETE FROM pregunta WHERE iId=$iId");
      if ($consulta == true){
        // Borramos las respuestas.
        $consulta2 = $this->db->query("DELETE FROM respuesta WHERE iId_Pregunta = $iId");
        if ($consulta2 == true)
          return true;
        else return false;
      } else {
        return false;
      }
    }

    public function get_categorias() {
      $query = $this->db->query("select * from categoria");
      if ($query->num_rows() > 0) {
        // Almacenamos el resultado en una matriz.
        foreach($query->result() as $row)
          $categorias[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sNombre, ENT_QUOTES);
        $query->free_result();
        return $categorias;
      }
    }


}
?>