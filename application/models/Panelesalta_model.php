<?php

class Panelesalta_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
    
    public function filas()
    {
      $consulta = $this->db->query("SELECT * FROM paneles");
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento, $pages) 
    {
      
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

    public function get_random_cat() {
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $query = $this->db->get('categoria');

        foreach($query->result() as $fila){
          $iId_Categoria = $fila->iId;
        }
        return $iId_Categoria;
    }

    public function nueva($sNombre, $iCasillas) {
      $data_panel = array('iCasillas' => $iCasillas,
        'sNombre' => $sNombre,
        'iId_Propietario' => $this->session->userdata('id_usuario'));

      if ($this->db->insert('panel', $data_panel)) {
        // Ahora se generan las casillas para el panel.
        $id_panel =  $this->db->insert_id();
        for ($i = 1; $i <= $iCasillas; $i++) {
          // Seleccionar categoría aleatoria.
          $id_categoria = $this->Panelesalta_model->get_random_cat();
          // Por defecto, función nula.
          $funcion = "Ninguno";
          // Dar de alta casilla.
          $data_casilla = array('iId_Panel' => $id_panel,
            'iId_Categoria' => $id_categoria,
            'iNumCasilla' => $i,
            'eFuncion' => $funcion);
          $add_casilla = $this->db->insert('panelcasillas', $data_casilla);
        }
        return true;
        // Fin de inserción de casillas.
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
          $categorias[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sCategoria, ENT_QUOTES);
        $query->free_result();
        return $categorias;
      }
    }

    public function eliminar_panel($iId_Panel) {
      $this->db->query("DELETE FROM panel WHERE iId = $iId_Panel");
    }

}
?>