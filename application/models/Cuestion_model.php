<?php

class Cuestion_model extends CI_Model{
  public function __construct() {
    parent::__construct(); 
    $this->load->database();
  }

  public function get_resumen_partida() {
    if ($this->session->userdata('iId_Partida') != NULL) {
      $iId = $this->session->userdata('iId_Partida');
      
      if (is_numeric($iId)) {
        $this->db->select('*');
        $this->db->from('resumen');
        $this->db->where('iId_Partida', $iId);
        $this->db->order_by('iGrupo ASC');
        $consulta = $this->db->get();

        if ($consulta->num_rows() > 0) {
          foreach ($consulta->result() as $fila) {
            $data[] = $fila;
          }
          return $data;
        } else return false;
      } else return false;
     } else return false;    
  }

  public function get_categoria() {
      $iId_Partida = $this->session->userdata('iId_Partida');
      $iId_Grupo = $this->session->userdata('iTurno');
      $iId_Panel = $this->session->userdata('iId_Panel');
      $categoria = "";

      $query_resumen = $this->db->query("SELECT iCasilla FROM resumen WHERE
        iId_Partida = $iId_Partida AND iGrupo = $iId_Grupo");
      $datos_resumen = $query_resumen->row();
      $iCasilla = $datos_resumen->iCasilla;

      // Ahora busco la categoría de esa celda.

      $this->db->select('c.sCategoria');
      $this->db->from('categoria c');
      $this->db->join('panelcasillas pc', 'c.iId = pc.iId_Categoria');
      $this->db->where('pc.iNumCasilla', $iCasilla);
      $this->db->where('pc.iId_Panel', $iId_Panel); 

      $consulta = $this->db->get();

      if($consulta->num_rows()>0) {
        $datos = $consulta->row();
        $categoria = $datos->sCategoria;
      }
      return $categoria;
  }

  public function get_tipocasilla() {
      $iId_Partida = $this->session->userdata('iId_Partida');
      $iId_Grupo = $this->session->userdata('iTurno');
      $iId_Panel = $this->session->userdata('iId_Panel');
      $tipocasilla = "";

      $query_resumen = $this->db->query("SELECT iCasilla FROM resumen WHERE
        iId_Partida = $iId_Partida AND iGrupo = $iId_Grupo");
      $datos_resumen = $query_resumen->row();
      $iCasilla = $datos_resumen->iCasilla;

      // Ahora busco la categoría de esa celda.

      $this->db->select('eFuncion');
      $this->db->from('panelcasillas');
      $this->db->where('iNumCasilla', $iCasilla);
      $this->db->where('iId_Panel', $iId_Panel); 

      $consulta = $this->db->get();

      if($consulta->num_rows()>0) {
        $datos = $consulta->row();
        $tipocasilla = $datos->eFuncion;
      }
      return $tipocasilla;
  }


  public function obtener_pregunta() {

    if (($this->session->userdata('iId_Partida') != NULL) && 
       ($this->session->userdata('iTurno') != NULL) &&
       ($this->session->userdata('iId_Panel') != NULL)) {

      $iId_Panel = $this->session->userdata('iId_Panel');
      $iId_Partida = $this->session->userdata('iId_Partida');
      $iTurno = $this->session->userdata('iTurno');

      if (is_numeric($iId_Partida) && is_numeric($iTurno)) {
        $query_resumen = $this->db->query("SELECT iCasilla from resumen 
          where iId_Partida = $iId_Partida AND iGrupo = $iTurno");
        $datos_resumen = $query_resumen->row();
        $iCasilla = $datos_resumen->iCasilla;

        // Ahora vamos a obtener la categoría del panel y si es casilla especial o no.
        $query_panel = $this->db->query("SELECT iId_Categoria, eFuncion, iNumCasilla 
                FROM panelcasillas where iId_Panel = $iId_Panel AND iNumCasilla = $iCasilla");
        $datos_panel = $query_panel->row();
        $iId_Categoria = $datos_panel->iId_Categoria;
        $this->session->set_userdata('eFuncion', $datos_panel->eFuncion);

        // Si la función de la casilla es "VIENTO", vamos a ver donde está la siguiente casilla "VIENTO", si es
        // que la hay.

        if ($this->session->userdata('eFuncion') == "Viento") {
          $query_especial = $this->db->query("SELECT iNumCasilla FROM panelcasillas where iId_Panel = $iId_Panel 
              AND eFuncion ='Viento' 
              AND iNumCasilla > $iCasilla
              LIMIT 1");
          if ($query_especial->num_rows() > 0) {
            $datos_especial = $query_especial->row();
            $this->session->set_userdata('iCasillaFuncion', $datos_especial->iNumCasilla );
          } else {
            $query_especial = $this->db->query("SELECT iNumCasilla FROM panelcasillas where iId_Panel = $iId_Panel  
              AND iNumCasilla = $iCasilla
              LIMIT 1");
              $datos_especial = $query_especial->row();
            $this->session->set_userdata('iCasillaFuncion', $datos_especial->iNumCasilla);
          }
        }

        // Finalmente, seleccionamos un iId aleatorio de pregunta.
        $this->db->where('bActiva', 1);
        $this->db->order_by('iId', 'RANDOM');
        $this->db->limit(1);
        $query_iId_Pregunta = $this->db->get('pregunta');
        $datos_iId_Pregunta = $query_iId_Pregunta->row();
        $iId_Pregunta = $datos_iId_Pregunta->iId;

        // Devolvemos los datos de la pregunta.
        $this->db->select('p.iId, p.sPregunta, p.iId_Categoria, r.iId as iId_Respuesta, r.sRespuesta, r.bVerdadera');
        $this->db->from('pregunta p');
        $this->db->join('respuesta r', 'p.iId = r.iId_Pregunta');
        $this->db->where('p.iId', $iId_Pregunta);
        //$this->db->where('p.iId_Categoria', $iId_Categoria);

        $pregunta = $this->db->get();
        if($pregunta->num_rows()>0) {
          foreach($pregunta->result() as $fila) {
            $data[] = $fila;
          }
          return $data;
        }
      }
    }
  }



}
?>