<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestionarpeticiones_model extends CI_Model{
  var $table = 'peticion';
  var $column_order = array('sPeticion_lista', 'sApellidos', 'sNombre', 'dFecha_Peticion', 'bPendiente',  null);
  var $column_search = array('sPeticion_lista','sApellidos', 'sNombre', 'dFecha_Peticion', 'bPendiente');
  var $order = array('iId' => 'desc');

    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    /* Función privada que obtiene los datos de la BBDD necesarios para construir la vista.
    */
    private function _get_datatables_query() {
      $this->db->select('peticion.*, tipopeticion.sPeticion_lista, usuario.sNombre, usuario.sApellidos');
      $this->db->from('peticion');
      $this->db->join('tipopeticion', 'tipopeticion.iId = peticion.iId_Peticion');
      $this->db->join('usuario', 'usuario.iId = peticion.iId_Usuario');
      
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
      ENTRADA: $data (Array con el registro a insertar.)
      SALIDA:  Último ID insertado.
    */
    public function save($data) {
      $this->db->insert($this->table, $data);
      return $this->db->insert_id();
    }

    /* 
      Función que obtiene un registro de la tabla de 'titulacion' según un $iId que obtiene como entrada.
      ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
      SALIDA:  Registro [asignatura].
    */
    public function get_requerimiento_by_id($iId) {
      $this->db->select('sRequerimientos');
      $this->db->from('tipopeticion');
      $this->db->where('tipopeticion.iId', $iId);

      $query = $this->db->get();
      return $query->result();
    }

    /* 
      Función que obtiene un registro de la tabla de 'titulacion' según un $iId que obtiene como entrada.
      ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
      SALIDA:  Registro [asignatura].
    */
    public function get_by_id($iId) {
      $this->db->select('peticion.*, tipopeticion.sPeticion_lista');
      $this->db->from('peticion');
      $this->db->join('tipopeticion', 'tipopeticion.iId = peticion.iId_Peticion');
      $this->db->where('peticion.iId', $iId);

      $query = $this->db->get();
      return $query->row();
    }

    /* 
    Función que elimina un registro cuyo $iId se toma como entrada
    ENTRADA: $iId (Identificador del registro que se quiere eliminar).
    SALIDA: -
  */
  public function delete_by_id($iId) {
    // Primero borramos las ocurrencias de cada pregunta en las tablas 'cursopartida' y 'preguntasjugadas'
    $this->db->where('iId', $iId);
    $this->db->delete('peticion');
  }

  /*
    Función que actualiza un registro de la base de datos según una condición.
    ENTRADA:
      $where: Condición que cumplirá el registro que se quiere modificar.
      $data:  Array con los nuevos datos.
    SALIDA: Número de filas afectadas por la modificación.
  */
  public function update_respuesta($where, $data)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  
    /* Funciones que devuelve todos los tipos de peticiones activas que ofrece el sistema */

    public function get_tipospeticiones() {
      $query = $this->db->query("select * from tipopeticion where bActiva = 1");
      if ($query->num_rows() > 0) {
        // Almacenamos el resultado en una matriz.
        foreach($query->result() as $row)
          $universidad[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sPeticion_lista, ENT_QUOTES);
        $query->free_result();
        return $universidad;
      }
    }   
    
}
?>