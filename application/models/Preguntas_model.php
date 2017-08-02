<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preguntas_model extends CI_Model{
  var $table = 'pregunta';
  var $column_order = array('sPregunta','sNombre', 'sApellidos', 'sCategoria', 'nPuntuacion', null);
  var $column_search = array('sPregunta', 'sNombre', 'sApellidos','sCategoria', 'nPuntuacion');
  var $order = array('iId' => 'desc');

    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }

    /* Función privada que obtiene los datos de la BBDD necesarios para construir la vista.
    */
    private function _get_datatables_query() {
      if ($this->session->userdata('admin') == 1) {
        // Visualiza todas las preguntas.
        $this->db->select('pregunta.*, usuario.sNombre, usuario.sApellidos, categoria.sCategoria');
        $this->db->from('pregunta');
        $this->db->join('usuario', 'usuario.iId = pregunta.iId_Usuario');
        $this->db->join('categoria', 'categoria.iId = pregunta.iId_Categoria');
      } else {
        // Visualiza todas las preguntas de su ámbito.
        $this->db->select('pregunta.*, usuario.sNombre, usuario.sApellidos, categoria.sCategoria');
        $this->db->from('pregunta');
        $this->db->join('usuario', 'usuario.iId = pregunta.iId_Usuario');
        $this->db->join('categoria', 'categoria.iId = pregunta.iId_Categoria');
        $this->db->where_in('pregunta.iId_Universidad', $this->session->userdata('universidades'));
        $this->db->where_in('pregunta.iId_Titulacion', $this->session->userdata('titulaciones'));
        $this->db->where_in('pregunta.iId_Asignatura', $this->session->userdata('asignaturas'));
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
    Función que obtiene un registro de la tabla 'curso' según un $iId que obtiene como entrada.
    ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
    SALIDA:  Registro [curso].
  */
  public function get_by_id($iId) {
    $this->db->select('pregunta.*,
      usuario.sNombre, 
      usuario.sApellidos, 
      categoria.sCategoria');
    $this->db->from('pregunta');
    $this->db->join('usuario', 'usuario.iId = pregunta.iId_Usuario');
    $this->db->join('categoria', 'categoria.iId = pregunta.iId_Categoria');
    $this->db->where('pregunta.iId', $iId);
    
    $query = $this->db->get();
    return $query->row();
  }

  public function get_respuesta_A($iId) {
    $this->db->select('*');
    $this->db->from('respuesta');
    $this->db->where('iId_Pregunta', $iId);
    $this->db->where('iOrden', 1);

    $query = $this->db->get();
    return $query->row();
  }

  public function get_respuesta_B($iId) {
    $this->db->select('*');
    $this->db->from('respuesta');
    $this->db->where('iId_Pregunta', $iId);
    $this->db->where('iOrden', 2);

    $query = $this->db->get();
    return $query->row();
  }

  public function get_respuesta_C($iId) {
    $this->db->select('*');
    $this->db->from('respuesta');
    $this->db->where('iId_Pregunta', $iId);
    $this->db->where('iOrden', 3);

    $query = $this->db->get();
    return $query->row();
  }

  public function get_respuesta_D($iId) {
    $this->db->select('*');
    $this->db->from('respuesta');
    $this->db->where('iId_Pregunta', $iId);
    $this->db->where('iOrden', 4);

    $query = $this->db->get();
    return $query->row();
  }

  public function get_verdadera($iId) {
    $this->db->select('iOrden, bVerdadera');
    $this->db->from('respuesta');
    $this->db->where('iId_Pregunta', $iId);
    $this->db->where('bVerdadera', 1);

    $query = $this->db->get();
    return $query->row();
  }

  /* 
    Función que guarda un nuevo registro en la base de datos, que toma como parámetro de entrada.
    ENTRADA: $data_pregunta (Array con los datos de la pregunta.)
      1     | $data_respuesta (Array con los datos de las respuestas.) 
    SALIDA:  Último ID insertado.
  */
  public function save($data_pregunta, $data_respuesta) {
    $this->db->insert($this->table, $data_pregunta);
    $iId_Pregunta = $this->db->insert_id();

    // Insertamos las respuestas.

    $verdaderaA = FALSE; $verdaderaB = FALSE; $verdaderaC = FALSE; $verdaderaD = FALSE;
    switch ($data_respuesta['bVerdadera']) {
      case '1': $verdaderaA = TRUE; break;
      case '2': $verdaderaB = TRUE; break;
      case '3': $verdaderaC = TRUE; break;
      case '4': $verdaderaD = TRUE; break;
      default: break;
    }

    $data_respuesta1 = array('sRespuesta' => $data_respuesta['sResp1'],
      'iOrden' => 1,
      'iId_Pregunta' => $iId_Pregunta,
      'bVerdadera' => $verdaderaA);
    $this->db->insert('respuesta', $data_respuesta1);

    $data_respuesta2 = array('sRespuesta' => $data_respuesta['sResp2'],
      'iOrden' => 2,
      'iId_Pregunta' => $iId_Pregunta,
      'bVerdadera' => $verdaderaB);
    $this->db->insert('respuesta', $data_respuesta2);

    $data_respuesta3 = array('sRespuesta' => $data_respuesta['sResp3'],
      'iOrden' => 3,
      'iId_Pregunta' => $iId_Pregunta,
      'bVerdadera' => $verdaderaC);
    $this->db->insert('respuesta', $data_respuesta3);

    $data_respuesta4 = array('sRespuesta' => $data_respuesta['sResp4'],
      'iOrden' => 4,
      'iId_Pregunta' => $iId_Pregunta,
      'bVerdadera' => $verdaderaD);
    $this->db->insert('respuesta', $data_respuesta4);

    return $iId_Pregunta;
  }

  /*
    Función que actualiza un registro de la base de datos según una condición.
    ENTRADA:
      $where: Condición que cumplirá el registro que se quiere modificar.
      $data:  Array con los nuevos datos.
    SALIDA: Número de filas afectadas por la modificación.
  */
  public function update($where, $data_pregunta, $data_respuesta)
  {
    $this->db->update($this->table, $data_pregunta, $where);

    // Guardamos las respuestas.

    $verdaderaA = FALSE; $verdaderaB = FALSE; $verdaderaC = FALSE; $verdaderaD = FALSE;
    switch ($data_respuesta['bVerdadera']) {
      case '1': $verdaderaA = TRUE; break;
      case '2': $verdaderaB = TRUE; break;
      case '3': $verdaderaC = TRUE; break;
      case '4': $verdaderaD = TRUE; break;
      default: break;
    }

    $data_respuesta1 = array('sRespuesta' => $data_respuesta['sResp1'],
      'bVerdadera' => $verdaderaA);
    $this->db->where('iId_Pregunta', $where['iId']);
    $this->db->where('iOrden', 1);
    $this->db->update('respuesta', $data_respuesta1);

    $data_respuesta2 = array('sRespuesta' => $data_respuesta['sResp2'],
      'bVerdadera' => $verdaderaB);
    $this->db->where('iId_Pregunta', $where['iId']);
    $this->db->where('iOrden', 2);
    $this->db->update('respuesta', $data_respuesta2);

    $data_respuesta3 = array('sRespuesta' => $data_respuesta['sResp3'],
      'bVerdadera' => $verdaderaC);
    $this->db->where('iId_Pregunta', $where['iId']);
    $this->db->where('iOrden', 3);
    $this->db->update('respuesta', $data_respuesta3);

    $data_respuesta4 = array('sRespuesta' => $data_respuesta['sResp4'],
      'bVerdadera' => $verdaderaD);
    $this->db->where('iId_Pregunta', $where['iId']);
    $this->db->where('iOrden', 4);
    $this->db->update('respuesta', $data_respuesta4);

    

    return $this->db->affected_rows();
  }

  /* 
    Función que elimina un registro cuyo $iId se toma como entrada
    ENTRADA: $iId (Identificador del registro que se quiere eliminar).
    SALIDA: -
  */
  public function delete_by_id($iId) {
    // Primero borramos las ocurrencias de cada pregunta en las tablas 'cursopartida' y 'preguntasjugadas'
    $this->db->where('iId_Pregunta', $iId);
    $this->db->delete('cursopartida');

    $this->db->where('iId_Pregunta', $iId);
    $this->db->delete('preguntasjugadas');

    // Ahora borramos las respuestas, y posteriormente la pregunta.
    $this->db->where('iId_Pregunta', $iId);
    $this->db->delete('respuesta');

    $this->db->where('iId', $iId);
    $this->db->delete('pregunta');
  }


  /* Función para obtener las titulaciones disponibles en el sistema */
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

  /* Función para obtener las asignaturas disponibles en el sistema */
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

  /* Función para obtener las categorías disponibles en el sistema. */
  public function get_categorias() {
    $query = $this->db->query("select * from categoria");
    if ($query->num_rows() > 0) {
      // Almacenamos el resultado en una matriz.
      foreach($query->result() as $row)
        $categorias[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sCategoria, ENT_QUOTES);
      $query->free_result();
      return $categorias;
    }
  }

  /* Función para obtener las categorías disponibles en el sistema. */
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

  // Funciones para recarga de selects

  public function get_titulaciones_by_id($iId_Universidad) {
    if ($this->session->userdata('admin') == 1)
      $query = $this->db->query("select * from titulacion where iId_Universidad = $iId_Universidad");
    else {
      $this->db->select('titulacion.*, usuarioscurso.iId as iId_Cur_Tit');
      $this->db->from('titulacion');
      $this->db->join('usuarioscurso', 'usuarioscurso.iId_Titulacion = titulacion.iId');
      $this->db->where('usuarioscurso.iId_Usuario', $this->session->userdata('id_usuario'));
      $this->db->where('titulacion.iId_Universidad', $iId_Universidad);
      $query = $this->db->get();
    }
    return $query->result();
  }

  public function get_asignaturas_by_id($iId_Titulacion) {
    if ($this->session->userdata('admin') == 1)
      $query = $this->db->query("select * from asignatura where iId_Titulacion = $iId_Titulacion");
    else {
      $this->db->select('asignatura.* , usuarioscurso.iId as iId_Cur_Tit');
      $this->db->from('asignatura');
      $this->db->join('usuarioscurso', 'usuarioscurso.iId_Asignatura = asignatura.iId');
      $this->db->where('usuarioscurso.iId_Usuario', $this->session->userdata('id_usuario'));
      $this->db->where('asignatura.iId_Titulacion', $iId_Titulacion);
      $query = $this->db->get();
    }
      return $query->result();
    }

    public function get_categorias_by_id($iId_Asignatura) {
    if ($this->session->userdata('admin') == 1)
      $query = $this->db->query("select * from categoria where iId_Asignatura = $iId_Asignatura");
    else {
      $this->db->select('categoria.*');
      $this->db->from('categoria');
      $this->db->where_in('categoria.iId_Asignatura', $this->session->userdata('asignaturas'));
      $this->db->where('categoria.iId_Asignatura', $iId_Asignatura);
      $query = $this->db->get();
    }
      return $query->result();
    }


}
?>