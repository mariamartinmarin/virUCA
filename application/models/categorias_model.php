<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_model extends CI_Model{
  var $table = 'categoria';
  var $column_order = array(null, 'sColor','sCategoria', 'sDescripcion', 'sAsignatura', null);
  var $column_search = array('sColor', 'sCategoria', 'sDescripcion', 'a.sNombre');
  var $order = array('iId' => 'desc');

  public function __construct() {
    parent::__construct(); 
    $this->load->database();
  }

  /* Función privada que obtiene los datos de la BBDD necesarios para construir la vista. */
  private function _get_datatables_query() {
    if ($this->session->userdata('admin') == 1) {
      $this->db->select('c.*, a.sNombre sAsignatura');
      $this->db->from('categoria c');
      $this->db->join('asignatura a', 'a.iId = c.iId_Asignatura');
    } else {
      $this->db->select('c.*, a.sNombre sAsignatura');
      $this->db->from('categoria c');
      $this->db->join('asignatura a', 'a.iId = c.iId_Asignatura');
      $this->db->join('usuarioscurso u', 'a.iId = u.iId_Asignatura');
      $this->db->where('u.iId_Usuario', $this->session->userdata('id_usuario'));
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
    como soporte    */
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
    Función que obtiene un registro de la tabla de 'categoria' según un $iId que obtiene como entrada.
    ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
    SALIDA:  Registro [categoria].
  */
  public function get_by_id($iId) {
    $this->db->select('c.*, a.sNombre sAsignatura');
    $this->db->from('categoria c');
    $this->db->join('asignatura a', 'a.iId = c.iId_Asignatura');
    $this->db->where('c.iId', $iId);

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
    Función que comprueba que una categoria no exista ya en el sistema con ese mismo nombre y en una misma asignatura.
    ENTRADA: 
      $iId (Identificador del registro que se quiere eliminar).
      $iId_Asignatura (Identificador de la asignatura).
    SALIDA: Booleano.
  */
  public function asignatura_duplicada($sCategoria, $iId_Asignatura) {
    $this->db->from($this->table);
    $this->db->where('sCategoria', $sCategoria);
    $this->db->where('iId_Asignatura', $iId_Asignatura);
    $query = $this->db->get();
    return $query->num_rows();
  }

  /* 
    Función que comprueba que una categoria pueda ser eliminada. Para ello hay que comprobar que no forme parte
    de ningún panel.
    ENTRADA: $iId (Identificador del registro que se quiere eliminar).
    SALIDA: Booleano.
  */
  public function categoria_partida($iId) {
    $this->db->from('panelcasillas');
    $this->db->where('iId_Categoria', $iId);
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
  public function get_asignaturas($iId_Usuario = NULL) {

    if (is_null($iId_Usuario))
      // Si es el administrador.
      $query = $this->db->query("select * from asignatura");
    else {
      // Si es un profesor, podrá asignar a las categorías cualesquiera de las asignaturas de su ámbito.
      $this->db->select('asignatura.*, usuarioscurso.iId as iId_Cur_Asg');
      $this->db->from('asignatura');
      $this->db->join('usuarioscurso', 'usuarioscurso.iId_Asignatura = asignatura.iId');
      $this->db->where('usuarioscurso.iId_Usuario', $this->session->userdata('id_usuario'));
      $query = $this->db->get();
    }

    if ($query->num_rows() > 0) {
      // Almacenamos el resultado en una matriz.
      foreach($query->result() as $row)
        $asignaturas[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sNombre, ENT_QUOTES);
      $query->free_result();
      return $asignaturas;
    }
  } 
}
?>