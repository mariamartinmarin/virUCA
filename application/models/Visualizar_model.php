<?php

class Visualizar_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function gestionar_partida($iId_Partida="NULL",$iId_Panel="NULL", $iTurno="NULL", $tirada="NULL") {
      $error = false;

      // Obtenemos los datos de la partida.
      $consulta = $this->db->query("SELECT * FROM partida WHERE iId = $iId_Partida");
      if ($consulta->num_rows() == 1) {
        
        // Obtengo los datos de la partida para compararlos con los que tengo.
        $datos_partida = $consulta->row();
        $iId_Panel_Partida = $datos_partida->iId_Panel;
        $iTurno_Partida = $datos_partida->iTurno;
        
        if ($iId_Panel_Partida == $iId_Panel && $iTurno_Partida = $iTurno) {
          // El panel y el turno son los correctos. Hay que comprobar la tirada.
          if ($tirada > 0 && $tirada <= 6) {
            // Actualizamos las tablas. (partida y resumen)
            // Nº casillas del panel.
            $query_panel = $this->db->query("SELECT iCasillas FROM panel where iId = $iId_Panel");
            $datos_panel = $query_panel->row();
            $iCasillas = $datos_panel->iCasillas;

            // Pos. del equipo en el panel.
            $query_posicion = $this->db->query("SELECT * from resumen 
              where iId_Partida = $iId_Partida and iGrupo = $iTurno");
            $datos_posicion = $query_posicion->row();
            $iPosicion = $datos_posicion->iCasilla;

            $nueva_posicion = $iPosicion + $tirada;
            if ($nueva_posicion > $iCasillas)
              $nueva_posicion = $iCasillas - ($tirada - ($iCasillas - $iPosicion));

            $query_actualiza_resumen = $this->db->query("UPDATE resumen SET
                iCasilla = $nueva_posicion, 
                iPosAnt = $iPosicion
                WHERE iId_Partida = $iId_Partida AND iGrupo = $iTurno");

            // Actualizamos las variables de sesión. Ojo con las variables para celdas especiales.
            $query_especiales = $this->db->query("SELECT eFuncion FROM panelcasillas 
              WHERE iId_Panel = $iId_Panel AND iNumCasilla = $nueva_posicion");
            $datos_especiales = $query_especiales->row();


            $this->session->set_userdata('iId_Partida', $iId_Partida);
            $this->session->set_userdata('iId_Panel', $iId_Panel);
            $this->session->set_userdata('iTurno', $iTurno);
            $this->session->set_userdata('tirada', $tirada);
            $this->session->set_userdata('pregunta', 1);
            $this->session->set_userdata('eFuncion', $datos_especiales->eFuncion);
            // Esta variable almacena la posición del siguiente viento, cuando la casilla es de viento.
            $this->session->set_userdata('iCasillaFuncion','');

          } else $error = true;
        } else $error = true;
      } else $error = true;
      return $error;
    }

       public function get_partida($iId = "NULL") {
      if ($iId != "NULL") {
        $consulta = $this->db->query("SELECT * FROM partida where iId = $iId");
        if($consulta->num_rows()>0) {
          foreach($consulta->result() as $fila) {
            $data[] = $fila;
          }
          return $data;
        } else return false;  
      } else return false;
    
    }

    public function get_panel($iId="NULL") {
      if ($iId != "NULL") {
        $consulta = $this->db->query("SELECT * FROM panel where iId = $iId");
        if($consulta->num_rows()>0) {
          foreach($consulta->result() as $fila) {
            $data[] = $fila;
          }
          return $data;
        } else return false;  
      } else return false;
    }

    public function get_casillas($iId="NULL") {
      if ($iId != "NULL") {
        $this->db->select('pc.*, cat.sColor, cat.sNombre');
        $this->db->from('panelcasillas pc');
        $this->db->join('categoria cat', 'pc.iId_Categoria = cat.iId');
        $this->db->where('pc.iId_Panel', $iId);
        $this->db->order_by('pc.iId ASC');

        $consulta = $this->db->get();

        if ($consulta->num_rows() > 0) {
          foreach ($consulta->result() as $fila) {
            $data[] = $fila;
          }
          return $data;
        } else return false;
      } else return false;
    }

    public function get_resumen_partida($iId="NULL") {
      if ($iId != "NULL") {
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

    public function get_respuesta_ok($iId="NULL") {
      if ($iId != "NULL") {
        $this->db->select('p.sPregunta, r.sRespuesta, r.iOrden');
        $this->db->from('pregunta p');
        $this->db->join('respuesta r', 'p.iId = r.iId_Pregunta');
        $this->db->where('p.iId', $iId);
        $this->db->where('r.bVerdadera', 1);

        $consulta = $this->db->get();

        if($consulta->num_rows()>0) {
          return $consulta->row();
        } else return false;  
      } else return false;
    }

    

    public function partida_acabada($iId_Partida) {
      $query_finalizada = $this->db->query("SELECT bFinalizada FROM partida where iId = $iId_Partida");
        if ($query_finalizada->num_rows() > 0 && $this->session->userdata('iTurno') != "") {
            $datos_finalizada = $query_finalizada->row();
            if ($datos_finalizada->bFinalizada == 1)
                return true;
            else
              return false;
    }
  }

  public function get_profesor_id($iId_Partida) {
    $iId_Profesor = 0;
    $consulta_profesor = $this->db->query("SELECT iId_Profesor_Act FROM partida WHERE iId = $iId_Partida");
    if ($consulta_profesor->result() > 0) {
      $datos_profesor = $consulta_profesor->row();
      $iId_Profesor = $datos_profesor->iId_Profesor_Act;   
    }
    return $iId_Profesor;
  }

}
?>