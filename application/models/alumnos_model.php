<?php

class Alumnos_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function filas()
    {
      $consulta=$this->db->query("SELECT * FROM usuario WHERE iPerfil = 1");
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento, $pages) 
    {
      $this->db->select('u.*, c.sCurso, t.sTitulacion');
      $this->db->from('curso c');
      $this->db->join('usuario u', 'c.iId = u.iId_Titulacion');
      $this->db->join('titulacion t', 'c.iId_Titulacion = t.iId');
      $this->db->where('iPerfil', 1);
      $this->db->order_by('sApellidos ASC');
      $consulta = $this->db->get('', $por_pagina, $segmento);

      if($consulta->num_rows()>0)
      {
        foreach($consulta->result() as $fila)
        {
          $data[] = $fila;
        }
        return $data;
      } else {
        $this->db->select('u.*, c.sCurso, t.sTitulacion');
        $this->db->from('curso c');
        $this->db->join('usuario u', 'c.iId = u.iId_Titulacion');
        $this->db->join('titulacion t', 'c.iId_Titulacion = t.iId');
        $this->db->where('iPerfil', 1);
        $this->db->order_by('sApellidos ASC');
      
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
     
    public function nueva($iPerfil, $sNombre, $sApellidos, $sEmail, $sUsuario, $sPassword, $sCursos){
      $data = array('iPerfil' => $iPerfil, 
        'sNombre' => $sNombre,
        'sApellidos' => $sApellidos,
        'sEmail' => $sEmail,
        'sUsuario' => $sUsuario,
        'sPassword' => sha1($sPassword),
        'iId_Titulacion' => $sCursos
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
        $sUsuario="NULL",
        $iPerfil="NULL",
        $iId_Curso="NULL") {
      
      if($modificar=="NULL"){
        $this->db->select('u.*, c.iId, t.sTitulacion');
        $this->db->from('curso c');
        $this->db->join('usuario u', 'c.iId = u.iId_Titulacion');
        $this->db->join('titulacion t', 't.iId = c.iId_Titulacion');
        $this->db->where('u.iId', $iId);
        $consulta = $this->db->get();
        return $consulta->result();
      } else {
        $consulta=$this->db->query("UPDATE usuario SET 
            sNombre = '$sNombre', 
            sApellidos = '$sApellidos',
            sEmail = '$sEmail',
            sUsuario = '$sUsuario',
            iId_Titulacion = '$iId_Curso' 
            WHERE iId = $iId;");
        if($consulta==true){
          return true;
        }else{
          return false;
        }
      }
    }
     
    public function eliminar($iId){
      // Hay que comprobar que el alumno NO tenga preguntas asociadas.
      $consulta = $this->db->query("SELECT iId FROM pregunta WHERE iId_Usuario = $iId");
      if($consulta->num_rows() == 0) {
        // El alumno NO tiene preguntas asociadas. Se puede proceder al borrado.
        $eliminar = $this->db->query("DELETE FROM usuario WHERE iId=$iId");
        if ($eliminar == true) {
          return true;
        } else {
          return false;
        }
      } else {
        // El alumno SI tiene preguntas asociadas, luego NO puede eliminarse.
        return false;
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