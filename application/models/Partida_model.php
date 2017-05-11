<?php

class Partida_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
     
    public function nueva($nGrupos, $iId_Profesor, $iId_Curso, $iId_Panel){
      $timestamp = date('Y-m-d G:i:s');
      $data = array('nGrupos' => $nGrupos,
          'dFecha' => $timestamp,
          'bFinalizada' => false,
          'iId_Profesor' => $iId_Profesor,
          'iId_Curso' => $iId_Curso,
          'iId_Panel' => $iId_Panel);
      if ($this->db->insert('partida', $data)) {
        return true;
      } else { 
        return false;
      }	
  }

  public function get_paneles() {
    $query = $this->db->query("select * from panel where bActivo = 1");
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $paneles[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sNombre, ENT_QUOTES);
      }
      $query->free_result();
      return $paneles;
    }
  }

  public function get_cursos() {
      $query = $this->db->query("select * from curso");
      if ($query->num_rows() > 0) {
        // Almacenamos el resultado en una matriz.
        foreach($query->result() as $row)
          $cursos[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sCurso, ENT_QUOTES);
        $query->free_result();
        return $cursos;
      }
    }
}
?>