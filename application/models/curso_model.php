<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curso_model extends CI_Model{
  var $table = 'curso';
  var $column_order = array('sCurso','sUniversidad', 'sTitulacion', 'sNombre', null);
  var $column_search = array('sCurso', 'sUniversidad', 'sTitulacion', 'sNombre');
  var $order = array('iId' => 'desc');

  // Constructor
  public function __construct() {
    parent::__construct(); 
    $this->load->database();
  }

  /* Función privada que obtiene los datos de la BBDD necesarios para construir la vista. */
  private function _get_datatables_query() {
    $this->db->select('curso.*, titulacion.sTitulacion, asignatura.sNombre, universidad.sUniversidad');
    $this->db->from('curso');
    $this->db->join('titulacion', 'titulacion.iId = curso.iId_Titulacion');
    $this->db->join('asignatura', 'asignatura.iId = curso.iId_Asignatura');
    $this->db->join('universidad', 'universidad.iId = curso.iId_Universidad');
      
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
    Función que obtiene un registro de la tabla 'curso' según un $iId que obtiene como entrada.
    ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
    SALIDA:  Registro [curso].
  */
  public function get_by_id($iId) {
    $this->db->select('curso.*, titulacion.sTitulacion, asignatura.sNombre, universidad.sUniversidad');
    $this->db->from('curso');
    $this->db->join('titulacion', 'titulacion.iId = curso.iId_Titulacion');
    $this->db->join('asignatura', 'asignatura.iId = curso.iId_Asignatura');
    $this->db->join('universidad', 'universidad.iId = curso.iId_Universidad');
    $this->db->where('curso.iId', $iId);
    
    $query = $this->db->get();
    return $query->row();
  }

  /* 
    Función que guarda un nuevo registro en la base de datos, que toma como parámetro de entrada.
    ENTRADA: $data (Array con el registro a insertar.)
    SALIDA:  Último ID insertado.
  */
  public function save($data) {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
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
    $this->db->where('iId', $iId);
    $this->db->delete($this->table);
  }

  /* 
    Función que comprueba que un curso no exista ya en el sistema con ese mismo nombre bajo una misma combinación
    asignatura/titulación
    ENTRADA: 
      $iId (Identificador del registro que se quiere eliminar).
      $iId_Asignatura (Identificador de la asignatura)
      $iId_Titulacion (Identificador de la titulación de la asignatura).
    SALIDA: Booleano.
  */
  public function curso_duplicado($sCurso, $iId_Titulacion, $iId_Asignatura, $iId_Universidad) {
    $this->db->from($this->table);
    $this->db->where('sCurso', $sCurso);
    $this->db->where('iId_Titulacion', $iId_Titulacion);
    $this->db->where('iId_Asignatura', $iId_Asignatura);
    $this->db->where('iId_Universidad', $iId_Universidad);

    $query = $this->db->get();
    return $query->num_rows();
  }

  /* 
    Función que comprueba que un curso puede ser eliminado.
    ENTRADA: $iId (Identificador del registro que se quiere eliminar).
    SALIDA: Booleano.
  */
  public function curso_partida($iId) {
    $this->db->from('cursopartida');
    $this->db->where('iId_Curso', $iId);
    $queryA = $this->db->get();

    $this->db->from('partida');
    $this->db->where('iId_Curso', $iId);
    $queryB = $this->db->get();

    if ($queryA->num_rows() == 0 && $queryB->num_rows() == 0)
      return 0;
    else 
      return 1;
    }

  /*
    Función que devuelve todas las titulaciones del sistema para ser utilizadas en la SELECT de modificación
    y/o inserción de curso.
  */
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

  /*
    Función que devuelve todas las asignaturas del sistema para ser utilizadas en la SELECT de modificación
    y/o inserción de curso.
  */
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

    /*
    Función que devuelve todas las universidades del sistema para ser utilizadas en la SELECT de modificación
    y/o inserción de curso.
  */
  public function get_universidades() {
      $query = $this->db->query("select * from universidad");
      if ($query->num_rows() > 0) {
        // Almacenamos el resultado en una matriz.
        foreach($query->result() as $row)
          $universidades[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sUniversidad, ENT_QUOTES);
        $query->free_result();
        return $universidades;
      }
    }



  
}
?>