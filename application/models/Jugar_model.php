<?php

class Jugar_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    public function salir($iId_Partida) {
      if (is_numeric($iId_Partida)) {
        // Hay que liberar la partida, tenemos que poner el valor 'bAbierta' a falso.
        $this->db->set('bAbierta','0');
        $this->db->where('iId', $iId_Partida);
        $this->db->update('partida');
        return true;
      }

      // Resetear variables de sesion.
      $this->session->unset_userdata('iId_Partida');
      $this->session->unset_userdata('iId_Panel');
      $this->session->unset_userdata('iTurno');
      $this->session->unset_userdata('tirada');
      $this->session->unset_userdata('pregunta');
      $this->session->unset_userdata('eFuncion');
      $this->session->unset_userdata('iCasillaFuncion');
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

    public function preparar_partida($iId_Partida) {
      if (is_numeric($iId_Partida)) {
        $consulta = $this->db->query("SELECT iId FROM resumen WHERE iId_Partida = $iId_Partida");
        if ($consulta->num_rows() <= 0) {
          // La partida no se ha iniciado nunca, así que la damos por empezada y rellenamos resumen.
          $query_nGrupos = $this->db->query("SELECT nGrupos FROM partida WHERE iId = $iId_Partida");
          $nGrupos = $query_nGrupos->row();
          $query_update_partida = $this->db->query("UPDATE partida SET 
            bEmpezada = 1, 
            bAbierta = 1
            WHERE iId = $iId_Partida");
          if ($query_update_partida) {
            for ($i=1; $i <= $nGrupos->nGrupos ; $i++) { 
              $data = array(
                'iId_Partida' => $iId_Partida,
                'iGrupo' => $i,
                'iCasilla' => 0);
              $this->db->insert('resumen', $data);
            } // for
          } // if ($query_update_partida)
        } // if ($consulta->num_rows())
      }
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

    public function establecer_acierto() {
      // Esta función restablece las posiciones en caso de acierto.
      // Si acierta, y la casilla es de viento, tenemos que posicionar la jugada al siguiente viento.
      // Si la casilla es de retroceso, no se hace nada, ya que esa casilla solo se va a activar cuando
      // la pregunta se contesta mal.
      $iId_Panel = $this->session->userdata('iId_Panel');
      $iId_Partida = $this->session->userdata('iId_Partida');
      $iTurno = $this->session->userdata('iTurno');
      $iPosicionFinal = 0;
      
      if ($this->session->userdata('eFuncion') == 'Viento') {
        $this->db->select('iPosAnt');
        $this->db->from('resumen');
        $this->db->where('iId_Partida', $iId_Partida);
        $this->db->where('iGrupo', $iTurno);
        $consulta_anterior = $this->db->get();

        $consulta = '';
        if ($consulta_anterior->num_rows() > 0)
          $consulta = $consulta_anterior->row();
        $casilla_anterior = $consulta->iPosAnt;
        
        $iCasillaFuncion = $this->session->userdata('iCasillaFuncion');

        $actualiza = $this->db->query("UPDATE resumen SET 
          iCasilla = $iCasillaFuncion,
          iPosAnt = $casilla_anterior
          WHERE iId_Partida = $iId_Partida AND 
                iGrupo = $iTurno");
      }

      // Ahora hay que comprobar que si el jugador se ha posicionado en la última posición del panel
      // acabará el juego, y ya no tendrá turno. 

      $iCasillas = ''; $iCasilla = '';
      
      // Obtengo número de casillas del panel en curso.
      $consulta_casillas = $this->db->query("SELECT iCasillas FROM panel WHERE iId = $iId_Panel");
      if ($consulta_casillas->num_rows() > 0) {
        $datos_casillas = $consulta_casillas->row();
        $iCasillas = $datos_casillas->iCasillas;
      }

      // Obtener la posición actual del grupo.
      $consulta_posicion = $this->db->query("SELECT iCasilla FROM resumen WHERE iId_Partida = $iId_Partida
            AND iGrupo = $iTurno");
      if ($consulta_posicion->num_rows() > 0) {
        $datos_posicion = $consulta_posicion->row();
        $iCasilla = $datos_posicion->iCasilla;
      } 

      // Vemos si el grupo actual ha llegado a la casilla final.
      if ($iCasillas == $iCasilla) {
        $query_ultimapos = $this->db->query("SELECT iPosJuego FROM resumen WHERE iId_Partida = $iId_Partida 
            ORDER BY iPosJuego DESC LIMIT 1");
        $datos_ultimapos = $query_ultimapos->row();
        $ranking = $datos_ultimapos->iPosJuego + 1;

        // Actualizamos la posicion en el resumen.
        $actualiza_resumen = $this->db->query("UPDATE resumen SET 
            iPosJuego = $ranking 
            WHERE iId_Partida = $iId_Partida AND iGrupo = $iTurno");
      }

    }

    public function restablecer_grupo() {
      // Esta función restablece la posición anterior que tenía el jugador.
      $iId_Partida = $this->session->userdata('iId_Partida');
      $iTurno = $this->session->userdata('iTurno');
      
      $casilla_nueva = 0;
      $casilla_anterior = 0;
      
      if ($this->session->userdata('eFuncion') != 'Retroceder') {
       
        $this->db->select('iPosAnt');
        $this->db->from('resumen');
        $this->db->where('iId_Partida', $this->session->userdata('iId_Partida'));
        $this->db->where('iGrupo', $this->session->userdata('iTurno'));
        $consulta_anterior = $this->db->get();

        $consulta = '';
        if ($consulta_anterior->num_rows() > 0)
          $consulta = $consulta_anterior->row();

        $casilla_nueva = $consulta->iPosAnt;
        $casilla_anterior = $consulta->iPosAnt;
      }

      $actualiza = $this->db->query("UPDATE resumen SET 
          iCasilla = $casilla_nueva,
          iPosAnt = $casilla_anterior
          WHERE iId_Partida = $iId_Partida AND 
                iGrupo = $iTurno");
    }

    public function actualizar_session() {
      if (is_numeric($this->session->userdata('iId_Partida'))) {
        $iId_Partida = $this->session->userdata('iId_Partida');

        $query_grupos = $this->db->query("SELECT nGrupos FROM partida 
          where iId = $iId_Partida");
        if ($query_grupos->num_rows() > 0) 
          $grupos = $query_grupos->row();

        $nGrupos = $grupos->nGrupos;

        if ($this->session->userdata('iTurno') == $nGrupos) {
          $siguiente = 1;
          $this->session->set_userdata('iTurno', 1);
        }
        else {
          $siguiente = $this->session->userdata('iTurno') + 1;
          $this->session->set_userdata('iTurno', $siguiente);
        }

        
        // Preparamos cuál será el siguiente turno en jugar. 
        // Seleccionaremos un grupo cuyo número sea igual o mayor que el identificador del grupo en curso. Esto
        // es así porque tenemos que obtener el inmediatamente siguiente grupo que aún sigue en el juego, ya
        // que es posible, que ya haya llegado al final del tablero, por lo que se saltaría su turno.
        $seguir = false;

        $query_obtiene_turno = $this->db->query("SELECT iGrupo FROM resumen WHERE iId_Partida = $iId_Partida 
              AND iGrupo >= $siguiente AND iPosJuego = 0 LIMIT 1");

        if ($query_obtiene_turno->num_rows() == 0) {
          // Probamos desde la parte superior (iGrupo = 1).
          $query_obtiene_turno_sup = $this->db->query("SELECT iGrupo FROM resumen WHERE iId_Partida = $iId_Partida 
              AND iGrupo >= 1 AND iPosJuego = 0 LIMIT 1");
          if ($query_obtiene_turno_sup->num_rows() > 0) {
            $seguir = true;
            $datos_obtiene_turno_sup = $query_obtiene_turno_sup->row();
            $siguiente = $datos_obtiene_turno_sup->iGrupo;
          }
        } else {
          $seguir = true;
          $datos_obtiene_turno = $query_obtiene_turno->row();
          $siguiente = $datos_obtiene_turno->iGrupo;
        }

        // Existe al menos, un grupo, que aún está jugando y no ha llegado al final del tablero.
        if ($seguir == true) {
          $query_actualiza_partida = $this->db->query("UPDATE partida SET
          iTurno = $siguiente
          WHERE iId = $iId_Partida");
        } else {
          // Ya no hay grupos jugando, todos han acabado la partida. Se cierra.
          $query_actualiza_partida = $this->db->query("UPDATE partida SET
          bFinalizada = 1
          WHERE iId = $iId_Partida");
        }

        

        $this->session->set_userdata('pregunta', 0);
        $this->session->set_userdata('eFuncion', '');
        $this->session->set_userdata('iCasillaFuncion', '');
      }
    }

}
?>