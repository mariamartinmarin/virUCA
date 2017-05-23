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
    }

    public function gestionar_partida($iId_Partida="NULL",$iId_Panel="NULL", $iTurno="NULL", $tirada="NULL") {
      $error = false;

      // Obtenemos los datos de la partida.
      $consulta = $this->db->query("SELECT * FROM partida WHERE iId = $iId_Partida");
      echo "Partida:".$iId_Partida;
      if ($consulta->num_rows() == 1) {
        // Obtengo los datos de la partida para compararlos con los que tengo.
        $datos_partida = $consulta->row();
        $iId_Panel_Partida = $datos_partida->iId_Panel;
        echo "Panel: ".$iId_Panel_Partida;
        $iTurno_Partida = $datos_partida->iTurno;
        echo "Turno:".$iTurno_Partida;echo "Tirada:".$tirada;
        if ($iId_Panel_Partida == $iId_Panel && $iTurno_Partida = $iTurno) {
          // El panel y el turno son los correctos. Hay que comprobar la tirada.
          if ($tirada > 0 && $tirada <= 6) {
            // Actualizamos las tablas. (partida y resumen)
            echo "Tirada:".$tirada;
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
              $nueva_posicion = $iCasillas - $tirada + ($iCasillas - ($iCasillas - $iPosicion));

            $query_actualiza_resumen = $this->db->query("UPDATE resumen SET
                iCasilla = $nueva_posicion, 
                iPosAnt = $iPosicion
                WHERE iId_Partida = $iId_Partida AND iGrupo = $iTurno");

            // Actualizamos las variables de sesión.

            $this->session->set_userdata('iId_Partida', $iId_Partida);
            $this->session->set_userdata('iId_Panel', $iId_Panel);
            $this->session->set_userdata('iTurno', $iTurno);
            $this->session->set_userdata('tirada', $tirada);
            $this->session->set_userdata('pregunta', 1);

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


}
?>