<?php

class Curso_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function filas()
    {
      $consulta = $this->db->get('curso');
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento) 
    {
      $this->db->select('curso.*, titulacion.sTitulacion, asignatura.sNombre');
      $this->db->from('curso');
      $this->db->join('titulacion', 'titulacion.iId = curso.iId_Titulacion');
      $this->db->join('asignatura', 'asignatura.iId = curso.iId_Asignatura');
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
        //Hacemos una consulta
        $consulta=$this->db->query("SELECT * FROM curso;");
         
        //Devolvemos el resultado de la consulta
        return $consulta->result();
    }
     
    public function nueva($sCurso, $sTitulaciones, $sAsignaturas){
        $data = array('sCurso' => $sCurso, 
          'iId_Titulacion' => $sTitulaciones,
          'iId_Asignatura' => $sAsignaturas);
        if ($this->db->insert('curso', $data)) {
            return true;
        } else { 
          return false;
        }	
    }
     
    public function mod($iId,
      $modificar = "NULL",
      $sCurso = "NULL",
      $iId_Titulacion = "NULL",
      $iId_Asignatura = "NULL") {

        if ($modificar == "NULL") {
          $this->db->select('curso.*, titulacion.sTitulacion, asignatura.sNombre');
          $this->db->from('curso');
          $this->db->join('titulacion', 'titulacion.iId = curso.iId_Titulacion');
          $this->db->join('asignatura', 'asignatura.iId = curso.iId_Asignatura');
          $this->db->where('curso.iId', $iId);
          $consulta = $this->db->get();
          return $consulta->result();
        } else {
          $consulta = $this->db->query("UPDATE curso 
            SET sCurso = '$sCurso', 
                iId_Titulacion = '$iId_Titulacion',
                iId_Asignatura = '$iId_Asignatura' 
            WHERE iId = $iId;");
          if ($consulta == true) {
              return true;
          } else {
              return false;
          }
        }
    }
     
    public function eliminar($iId){
       $consulta=$this->db->query("DELETE FROM curso WHERE iId=$iId");
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

    public function get_asignaturas() {
      $query = $this->db->query("select * from asignatura");
      if ($query->num_rows() > 0) {
        // Almacenamos el resultado en una matriz.
        foreach($query->result() as $row)
          $asignaturas[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sNombre, ENT_QUOTES);
        $query->free_result();
        return $asignaturas;
      }
    }
}
?>