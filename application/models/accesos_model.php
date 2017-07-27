<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accesos_model extends CI_Model{
  var $table = 'acceso';
  var $column_order = array('sNombreCompleto', 'dFecha', 'sIP', null);
  var $column_search = array('sNombreCompleto', 'dFecha', 'sIP');
  var $order = array('iId' => 'desc');

    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    /* Función privada que obtiene los datos de la BBDD necesarios para construir la vista.
    */
    private function _get_datatables_query() {
      $this->db->from($this->table);
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
      Función que elimina un registro cuyo $iId se toma como entrada
      ENTRADA: $iId (Identificador del registro que se quiere eliminar).
      SALIDA: -
    */
    public function delete_by_id($iId) {
      $this->db->where('iId', $iId);
      $this->db->delete($this->table);
    }

}
?>