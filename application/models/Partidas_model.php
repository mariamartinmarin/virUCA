<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partidas_model extends CI_Model{
  var $table = 'partida';
  var $column_order = array(null, 'sPartida', 'dFecha', null , null, null);
  var $column_search = array('sPartida', 'dFecha', 'panel.sNombre');
  var $order = array('iId' => 'desc');

  public function __construct() {
    parent::__construct(); 
    $this->load->database();
  }

  /* Función privada que obtiene los datos de la BBDD necesarios para construir la vista.
    */
    private function _get_datatables_query() {
      $perfil = 1;
      if ($this->session->userdata('admin') == 1) {
        // Administrador. Acceso a todo.
        $this->db->select("partida.*, 
          usuario.sNombre as sNombre_Profesor, 
          usuario.sApellidos as sApellidos_Profesor, 
          panel.sNombre as sNombre_Panel");
        $this->db->from("partida");
        $this->db->join("usuario", "usuario.iId = partida.iId_Profesor");
        $this->db->join("panel", "panel.iId = partida.iId_Panel");
      } else {
        // Profesor. Acceso a su ámbito.
        // Obtengamos primero la tupla de su ámbito (universidad-titulación-asignatura).

        $this->db->select("partida.*, 
          usuario.sNombre as sNombre_Profesor, 
          usuario.sApellidos as sApellidos_Profesor, 
          panel.sNombre as sNombre_Panel,
          panel.iId_Universidad, panel.iId_Titulacion, panel.iId_Asignatura");
        $this->db->from("partida");
        $this->db->join("usuario", "usuario.iId = partida.iId_Profesor");
        $this->db->join("panel", "panel.iId = partida.iId_Panel");
        $this->db->where_in('panel.iId_Universidad', $this->session->userdata('universidades'));
        $this->db->where_in('panel.iId_Titulacion', $this->session->userdata('titulaciones'));
        $this->db->where_in('panel.iId_Asignatura', $this->session->userdata('asignaturas'));
        $this->db->where('partida.iId_Profesor', $this->session->userdata('id_usuario')); 
      }
      
      $i = 0;

      foreach ($this->column_search as $item) {
        if($_POST['search']['value']) {
          if($i===0) {
            $this->db->group_start();
            $this->db->like($item, $_POST['search']['value']);
          }
          else {
            $this->db->or_like($item, $_POST['search']['value']);
          }

          if(count($this->column_search) - 1 == $i) 
            $this->db->group_end();
        }
        $i++;
      }

      if(isset($_POST['order'])) {
        $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      } 
      else if(isset($this->order)) {
        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);
      }
    }

      /* Función que se utilizará para devolver a la vista los datos que ésta mostrará. Utiliza la función _get_datatables_query()
    como soporte
  */
  function get_datatables() {
    $this->_get_datatables_query();
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

   /* Función que devuelve el número de resultados de una consulta filtrada. */
  function count_filtered() {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  /* Función que devuelve el número total de registros de una consulta */
  public function count_all() {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }
  

  /* 
    Función que guarda un nuevo registro en la base de datos, que toma como parámetro de entrada.
    ENTRADA: $data_pregunta (Array con los datos de la pregunta.)
      1     | $data_respuesta (Array con los datos de las respuestas.) 
    SALIDA:  Último ID insertado.
  */
  public function save($data) {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }  

  /* 
    Función que obtiene un registro de la tabla 'curso' según un $iId que obtiene como entrada.
    ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
    SALIDA:  Registro [curso].
  */
  public function get_by_id($iId) {
    $this->db->select('*');
    $this->db->from('partida');
    $this->db->where('iId', $iId);
    
    $query = $this->db->get();
    return $query->row();
  }

   /*
    Función que actualiza un registro de la base de datos según una condición.
    ENTRADA:
      $where: Condición que cumplirá el registro que se quiere modificar.
      $data:  Array con los nuevos datos.
    SALIDA: Número de filas afectadas por la modificación.
  */
  public function update($where, $data)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  /* 
    Función que elimina un registro cuyo $iId se toma como entrada
    ENTRADA: $iId (Identificador del registro que se quiere eliminar).
    SALIDA: -
  */
  public function delete_by_id($iId) {
    // Borramos las ocurrencias en preguntasjugadas
    $this->db->where('iId_Partida', $iId);
    $this->db->delete('preguntasjugadas');
     // Borramos las ocurrencias en preguntasjugadas
    $this->db->where('iId_Partida', $iId);
    $this->db->delete('cursopartida');
    // Eliminamos la ocurrencia de la tabla panel.
    $this->db->where('iId', $iId);
    $this->db->delete('partida');
  }








    public function filas()
    {
      $consulta = $this->db->query("SELECT * FROM partida");
      return  $consulta->num_rows() ;
    }

    function total_paginados($por_pagina, $segmento, $pages) 
    {
      $this->db->select('p.*, pa.iId as iId_Partida, pa.sNombre as nombrePanel, cu.sCurso as nombreCurso, u.sNombre as nombreProfesor');
      $this->db->from('partida p');
      $this->db->join('panel pa', 'p.iId_Panel = pa.iId');
      $this->db->join('curso cu', 'p.iId_Curso = cu.iId');
      $this->db->join('usuario u', 'p.iId_Profesor = u.iId');
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

        $this->db->select('p.*, pa.iId as iId_Partida, pa.sNombre as nombrePanel, cu.sCurso as nombreCurso, u.sNombre as nombreProfesor');
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

    public function get_paneles() {
      if ($this->session->userdata('admin') == 1)
        $query = $this->db->query("select * from panel where bActivo = 1");
      else {
        // Sólo cogemos los paneles del ámbito del profesor en cuestión.
        $this->db->select("*");
        $this->db->from("panel");
        //$this->db->where_in('panel.iId_Universidad', $this->session->userdata('universidades'));
        //$this->db->where_in('panel.iId_Titulacion', $this->session->userdata('titulaciones'));
        //$this->db->where_in('panel.iId_Asignatura', $this->session->userdata('asignaturas'));
        $this->db->where('iId_Propietario', $this->session->userdata('id_usuario'));
        $this->db->where('bActivo', 1);
        $query = $this->db->get();
      }
      if ($query->num_rows() > 0) {
        // Almacenamos el resultado en una matriz.
        foreach($query->result() as $row)
          $paneles[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sNombre, ENT_QUOTES);
        $query->free_result();
        return $paneles;
      }
    }
    
    public function get_cursos() {
      $query = $this->db->query("select * from curso");
      if ($query->num_rows() > 0) {
        // Almacenamos el resultado en una matriz.
        foreach($query->result() as $row)
          $paneles[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sCurso, ENT_QUOTES);
        $query->free_result();
        return $paneles;
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
            iId_Panel = '$iPanel',
            iId_Curso = '$iCurso'
            WHERE iId = $iId");
        if ($consulta == true)
          return true;
        else
          return false;
      }
    }
     
    public function eliminar($iId){
      // Primero tenemos que eliminar el contenido de la tabla 'cursopartida'
      $consulta1 = $this->db->query("DELETE FROM cursopartida WHERE iId_Partida = $iId");
      $consulta2 = $this->db->query("DELETE FROM resumen WHERE iId_Partida = $iId");
      if ($consulta1 == true && $consulta2 == true) {
        // Borramos la partida.
        $consulta2 = $this->db->query("DELETE FROM partida WHERE iId = $iId");
        if ($consulta2 == true) return true; else return false;
      } else {
        return false;
      }
    }

    public function desbloquear($iId) {
      $query_desbloquear = $this->db->query("UPDATE partida SET
        bAbierta = 0 WHERE iId = $iId");
      if ($query_desbloquear == true) return true; else return false;
    }
}
?>