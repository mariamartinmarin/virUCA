<?php

class Preguntas_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
    
    public function filas()
    {
      $id_usuario = $this->session->userdata('id_usuario');
      $consulta = $this->db->query("SELECT * FROM pregunta");
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento, $pages) 
    {
      
      $id_usuario = $this->session->userdata('id_usuario');
      $this->db->select('p.*, u.sNombre, u.sApellidos');
      $this->db->from('pregunta p');
      $this->db->join('usuario u', 'u.iId = p.iId_Usuario');
      $this->db->order_by('sPregunta ASC');

      $consulta = $this->db->get('', $por_pagina, $segmento);

      if($consulta->num_rows()>0)
      {
        foreach($consulta->result() as $fila)
        {
          $data[] = $fila;
        }
        return $data;
      } else {
        $this->db->select('*');
        $this->db->from('pregunta');
      
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
      $consulta=$this->db->query("SELECT * FROM pregunta WHERE iId_Usuario = $this->session->userdata('id_usuario')");
      return $consulta->result();
    }

    public function verPregunta($iId){
      $consulta=$this->db->query("SELECT * FROM pregunta WHERE iId = $iId");
      return $consulta->result();
    }
     
    public function nueva($sPregunta, 
      $sResp1, $sResp2, $sResp3, $sResp4, 
      $sCategorias, $bActiva, $iId_Usuario, $nPuntuacion, $verdadera, $sObservaciones){
      $data_pregunta = array('sPregunta' => $sPregunta,
        'nPuntuacion' => $nPuntuacion,
        'iId_Usuario' => $iId_Usuario,
        'iId_Categoria'=> $sCategorias,
        'bActiva'=> $bActiva,
        'sObservaciones' => $sObservaciones);

      if ($this->db->insert('pregunta', $data_pregunta)) {
        $id_Pregunta = $this->db->insert_id(); 
        // Ahora hay que insertar las respuestas (4)
        $verdaderaA = FALSE; $verdaderaB = FALSE; $verdaderaC = FALSE; $verdaderaD = FALSE;
        switch ($verdadera) {
          case '1':
            $verdaderaA = TRUE;
            break;
          case '2':
            $verdaderaB = TRUE;
            break;
          case '3':
            $verdaderaC = TRUE;
            break;
          case '4':
            $verdaderaD = TRUE;
            break;
          default:
            break;
        }
        $data_respuesta1 = array('sRespuesta' => $sResp1,
          'iOrden' => 1,
          'iId_Pregunta' => $id_Pregunta,
          'bVerdadera' => $verdaderaA);
        $this->db->insert('respuesta', $data_respuesta1);

        $data_respuesta2 = array('sRespuesta' => $sResp2,
          'iOrden' => 2,
          'iId_Pregunta' => $id_Pregunta,
          'bVerdadera' => $verdaderaB);
        $this->db->insert('respuesta', $data_respuesta2);

        $data_respuesta3 = array('sRespuesta' => $sResp3,
          'iOrden' => 3,
          'iId_Pregunta' => $id_Pregunta,
          'bVerdadera' => $verdaderaC);
        $this->db->insert('respuesta', $data_respuesta3);

        $data_respuesta4 = array('sRespuesta' => $sResp4,
          'iOrden' => 4,
          'iId_Pregunta' => $id_Pregunta,
          'bVerdadera' => $verdaderaD);
        $this->db->insert('respuesta', $data_respuesta4);

        return true;
      } else { 
        return false;
      }	
    }
     
    public function mod($iId,
        $modificar="NULL",
        $sPregunta="NULL", 
        $sResp1="NULL", 
        $sResp2="NULL", 
        $sResp3="NULL", 
        $sResp4="NULL", 
        $iId_Categoria="NULL", 
        $bActiva="NULL", 
        $iId_Usuario="NULL", 
        $nPuntuacion="NULL", 
        $verdadera="NULL",
        $sObservaciones="NULL") {
      
      if ($modificar == "NULL"){
        $consulta=$this->db->query("SELECT * FROM pregunta WHERE iId = $iId");
        return $consulta->result();
      } else {
        // Hay que modificar no solo la pregunta en sí, sino la posibilidad de que se hayan modificado
        // sus respuesta.
        $consulta=$this->db->query("UPDATE pregunta SET 
            sPregunta = '$sPregunta', 
            iId_Categoria = '$iId_Categoria',
            nPuntuacion = '$nPuntuacion',
            sObservaciones = '$sObservaciones',
            bActiva = '$bActiva' 
            WHERE iId = $iId;");
          // Ahora vamos a modificar las posibles respuestas. (4)

          $verdaderaA = 0; $verdaderaB = 0; $verdaderaC = 0; $verdaderaD = 0;
          switch ($verdadera) {
            case '1':
              $verdaderaA = 1;
              break;
            case '2':
              $verdaderaB = 1;
              break;
            case '3':
              $verdaderaC = 1;
              break;
            case '4':
              $verdaderaD = 1;
              break;
            default:
              break;
          }
          
          $consulta1 = $this->db->query("UPDATE respuesta SET 
            sRespuesta = '$sResp1', 
            bVerdadera = $verdaderaA 
            WHERE iId_Pregunta = $iId AND iOrden = 1;");
          
          $consulta2 = $this->db->query("UPDATE respuesta SET 
            sRespuesta = '$sResp2', 
            bVerdadera = $verdaderaB 
            WHERE iId_Pregunta = $iId AND iOrden = '2';");
          
          $consulta3 = $this->db->query("UPDATE respuesta SET 
            sRespuesta = '$sResp3', 
            bVerdadera = $verdaderaC 
            WHERE iId_Pregunta = $iId AND iOrden = '3';");
          
          $consulta4 = $this->db->query("UPDATE respuesta SET 
            sRespuesta = '$sResp4', 
            bVerdadera = $verdaderaD 
            WHERE iId_Pregunta = $iId AND iOrden = '4';");
          
          return true;
      }
    }

    public function respuestas($iId) {
      $this->db->select('*');
      $this->db->from('respuesta');
      $this->db->where('iId_Pregunta', $iId);

      $consulta = $this->db->get();
      if($consulta->num_rows()>0)
      {
        foreach($consulta->result() as $fila)
        {
          $data[] = $fila;
        }
        return $data;
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