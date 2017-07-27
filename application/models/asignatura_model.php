<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignatura_model extends CI_Model{
  var $table = 'asignatura';
  var $column_order = array('sNombre','sTitulacion', 'sUniversidad', null);
  var $column_search = array('sNombre', 'sTitulacion', 'sUniversidad');
  var $order = array('iId' => 'desc');

    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    /* Función privada que obtiene los datos de la BBDD necesarios para construir la vista.
    */
    private function _get_datatables_query() {
      $this->db->select('a.*, t.sTitulacion, u.sUniversidad');
      $this->db->from('asignatura a');
      $this->db->join('titulacion t', 't.iId = a.iId_Titulacion');
      $this->db->join('universidad u', 'u.iId = a.iId_Universidad');
      
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
      Función que obtiene un registro de la tabla de 'titulacion' según un $iId que obtiene como entrada.
      ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
      SALIDA:  Registro [asignatura].
    */
    public function get_by_id($iId) {
      $this->db->select('a.iId iIdAsignatura, a.sNombre, a.iId_Titulacion, t.iId, t.sTitulacion, u.sUniversidad, u.iId as iId_Universidad');
      $this->db->from('asignatura a');
      $this->db->join('titulacion t', 't.iId = a.iId_Titulacion');
      $this->db->join('universidad u', 'u.iId = a.iId_Universidad');
      $this->db->where('a.iId', $iId);

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
      Función que comprueba que una asignatura no exista ya en el sistema con ese mismo nombre y en una misma titulación.
      ENTRADA: 
        $iId (Identificador del registro que se quiere eliminar).
        $iId_Titulacion (Identificador de la titulación de la asignatura).
      SALIDA: Booleano.
    */
    public function asignatura_duplicada($sNombre, $iId_Titulacion) {
      $this->db->from($this->table);
      $this->db->where('sNombre', $sNombre);
      $this->db->where('iId_Titulacion', $iId_Titulacion);
      $query = $this->db->get();
      return $query->num_rows();
    }

    /* 
      Función que comprueba que una asignatura puede ser eliminada.
      ENTRADA: $iId (Identificador del registro que se quiere eliminar).
      SALIDA: Booleano.
    */
    public function asignatura_curso($iId) {
      $this->db->from('curso');
      $this->db->where('iId_Asignatura', $iId);
      $query = $this->db->get();

      if ($query->num_rows() == 0)
        return 0;
      else 
        return 1;
    }

    /*
      Función que devuelve todas las titulaciones del sistema para ser utilizadas en la SELECT de modificación
      y/o inserción de asignatura.
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
      Función que devuelve todas las titulaciones del sistema para ser utilizadas en la SELECT de modificación
      y/o inserción de asignatura.
    */
    public function get_titulaciones_by_id($iId_Universidad) {
      $query = $this->db->query("select * from titulacion where iId_Universidad = $iId_Universidad");
      return $query->result();
    }

    public function get_last_universidad() {
        $query = $this->db->query("select iId from universidad order by iId limit 0,1");
        return $query->result();
    }

    /*
      Función que devuelve todas las universidades del sistema para ser utilizadas en la SELECT de modificación
      y/o inserción de asignatura.
    */
    public function get_universidades() {
      $query = $this->db->query("select * from universidad");
      if ($query->num_rows() > 0) {
        // Almacenamos el resultado en una matriz.
        foreach($query->result() as $row)
          $universidad[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sUniversidad, ENT_QUOTES);
        $query->free_result();
        return $universidad;
      }
    }  
    
}
?>