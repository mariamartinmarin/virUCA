<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos_model extends CI_Model{
  var $table = 'usuario';
  
  var $column_order = array(null, 'sNombre', 'sApellidos', null , 'sEmail', null);
  var $column_search = array('sNombre','sApellidos', 'sEmail');
  var $order = array('iId' => 'desc');

  var $table_cursos = 'usuarioscurso';
  var $column_order_cursos = array('sUniversidad', 'sTitulacion', 'sNombre', null);
  var $column_search_cursos = array('sUniversidad', 'sTitulacion', 'sNombre');
  var $order_cursos = array('iId' => 'desc');

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
        $this->db->from($this->table);
        $this->db->where('iPerfil', $perfil);
      } else {
        // Profesor. Acceso a su ámbito.
        $this->db->select("usuario.*, usuarioscurso.iId_Usuario, 
          usuarioscurso.iId_Universidad, 
          usuarioscurso.iId_Titulacion, 
          usuarioscurso.iId_Asignatura");
        $this->db->from("usuario");
        
        $this->db->join("usuarioscurso", "usuarioscurso.iId_Usuario = usuario.iId");
        $this->db->where('iPerfil', $perfil);
        $this->db->where_in('usuarioscurso.iId_Universidad', $this->session->userdata('universidades'));
        $this->db->where_in('usuarioscurso.iId_Titulacion', $this->session->userdata('titulaciones'));
        $this->db->where_in('usuarioscurso.iId_Asignatura', $this->session->userdata('asignaturas'));
        
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

    /* Función privada que obtiene los datos de la BBDD necesarios para construir la vista.
    */
    private function _get_datatables_query_cursos($iId) {
      $this->db->select("usuarioscurso.*, asignatura.sNombre, universidad.sUniversidad, titulacion.sTitulacion");
      $this->db->from("usuarioscurso");
      $this->db->join("asignatura", "usuarioscurso.iId_Asignatura = asignatura.iId");
      $this->db->join("universidad", "usuarioscurso.iId_Universidad = universidad.iId");
      $this->db->join("titulacion", "usuarioscurso.iId_Titulacion = titulacion.iId");
      $this->db->where("usuarioscurso.iId_Usuario", $iId); 

      $i = 0;

      foreach ($this->column_search_cursos as $item) {
        if($_POST['search']['value']) {
          if($i===0) {
            $this->db->group_start();
            $this->db->like($item, $_POST['search']['value']);
          }
          else {
            $this->db->or_like($item, $_POST['search']['value']);
          }

          if(count($this->column_search_cursos) - 1 == $i) 
            $this->db->group_end();
        }
        $i++;
      }

      if(isset($_POST['order'])) {
        $this->db->order_by($this->column_order_cursos[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      } 
      else if(isset($this->order_cursos)) {
        $order_cursos = $this->order_cursos;
        $this->db->order_by(key($order_cursos), $order_cursos[key($order_cursos)]);
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

    /* Función que se utilizará para devolver a la vista los datos que ésta mostrará. Utiliza la función _get_datatables_query()
    como soporte
  */
  function get_datatables_cursos($iId) {
    $this->_get_datatables_query_cursos($iId);
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

  /* Función que devuelve el número de resultados de una consulta filtrada. */
  function count_filtered_cursos($iId) {
    $this->_get_datatables_query_cursos($iId);
    $query = $this->db->get();
    return $query->num_rows();
  }

  /* Función que devuelve el número total de registros de una consulta */
  public function count_all() {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  /* Función que devuelve el número total de registros de una consulta */
  public function count_all_cursos($iId) {

    $this->db->select("usuarioscurso.*, asignatura.sNombre, universidad.sUniversidad, titulacion.sTitulacion");
    $this->db->from("usuarioscurso");
    $this->db->join("asignatura", "usuarioscurso.iId_Asignatura = asignatura.iId");
    $this->db->join("universidad", "usuarioscurso.iId_Universidad = universidad.iId");
    $this->db->join("titulacion", "usuarioscurso.iId_Titulacion = titulacion.iId");
    $this->db->where("usuarioscurso.iId", $iId);
    return $this->db->count_all_results();
  }

  /* 
    Función que obtiene un registro de la tabla 'curso' según un $iId que obtiene como entrada.
    ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
    SALIDA:  Registro [curso].
  */
  public function get_by_id($iId) {
    $this->db->select('*');
    $this->db->from('usuario');
    $this->db->where('iId', $iId);
    
    $query = $this->db->get();
    return $query->row();
  }

  /* 
    Función que obtiene un registro de la tabla 'curso' según un $iId que obtiene como entrada.
    ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
    SALIDA:  Registro [curso].
  */
  public function get_by_id_cursos($iId) {
    $this->db->select('*');
    $this->db->from('usuario');
    $this->db->where('iId', $iId);
    
    $query = $this->db->get();
    return $query->row();
  }

  /* 
    Función que guarda un nuevo registro en la base de datos, que toma como parámetro de entrada.
    ENTRADA: $data_pregunta (Array con los datos de la pregunta.)
      1     | $data_respuesta (Array con los datos de las respuestas.) 
    SALIDA:  Último ID insertado.
  */
  public function save($data, $iId_Universidad=NULL, $iId_Titulacion=NULL, $iId_Asignatura=NULL) {
    $this->db->insert($this->table, $data);
    $id_usuario = $this->db->insert_id();

    // Si hay cursos que insertar, lo hacemos.
    if ($iId_Asignatura != "NULL") {
     $data = array(
      'iId_Asignatura' => $iId_Asignatura,
      'iId_Titulacion' => $iId_Titulacion,
      'iId_Universidad' => $iId_Universidad,
      'iId_Usuario' => $id_usuario,
      );

      $this->db->insert('usuarioscurso', $data);
    }
    return $id_usuario;
  }

  /* 
    Función que guarda un nuevo registro en la base de datos, que toma como parámetro de entrada.
    ENTRADA: $data_pregunta (Array con los datos de la pregunta.)
      1     | $data_respuesta (Array con los datos de las respuestas.) 
    SALIDA:  Último ID insertado.
  */
  public function save_cursos($data) {
    $this->db->insert('usuarioscurso', $data);
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
    // Primero vamos a borrar todas sus preguntas
    $this->db->select('*');
    $this->db->from('pregunta');
    $this->db->where('iId_Usuario',$iId);

    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      foreach($query->result() as $row) {
        // Borramos las respuestas de esa pregunta.
        $this->db->query("delete from respuesta where iId_Pregunta = $row->iId");
      }
      // Borramos todas las preguntas.
      $this->db->query("delete from pregunta where iId_Usuario = $iId");    
    }

    // Segundo vamos a borrar todos sus cursos
    $this->db->where('iId_Usuario', $iId);
    $this->db->delete('usuarioscurso');

    // Tercero vamos a borrar el alumno en si
    $this->db->where('iId', $iId);
    $this->db->delete('usuario');
  }

  /* 
    Función que elimina un registro cuyo $iId se toma como entrada
    ENTRADA: $iId (Identificador del registro que se quiere eliminar).
    SALIDA: -
  */
  public function delete_curso_by_id($iId) {
    $this->db->where('iId', $iId);
    $this->db->delete('usuarioscurso');
  }

  /* Funciones para obtener los datos de las selects, tener en cuenta que si el usuario es "ADMIN", puede tener acceso
    a todo el ámbito. En caso contrario, sólo puede tener acceso a su propio ámbito.
  */

  /* Función para obtener las titulaciones disponibles en el sistema */
  public function get_universidades($iId = NULL) {
    if (is_null($iId))
      $query = $this->db->query("select * from universidad");
    else {
      $this->db->select('universidad.*, usuarioscurso.iId as iId_Cur_Uni');
      $this->db->from('universidad');
      $this->db->join('usuarioscurso', 'usuarioscurso.iId_Universidad = universidad.iId');
      $this->db->where('usuarioscurso.iId_Usuario', $iId);
      $query = $this->db->get();
    }

    if ($query->num_rows() > 0) {
      // Almacenamos el resultado en una matriz.
      foreach($query->result() as $row)
        $universidades[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sUniversidad, ENT_QUOTES);
      $query->free_result();
      return $universidades;
    }
  }


  /* Función para obtener las titulaciones disponibles en el sistema */
  public function get_titulaciones($iId=NULL) {
    if ($iId == NULL)
      $query = $this->db->query("select * from titulacion");
    else {
      $this->db->select('titulacion.*, usuarioscurso.iId as iId_Cur_tit');
      $this->db->from('titulacion');
      $this->db->join('usuarioscurso', 'usuarioscurso.iId_Titulacion = titulacion.iId');
      $this->db->where('usuarioscurso.iId_Usuario', $iId);
      $query = $this->db->get();
    }

    if ($query->num_rows() > 0) {
      // Almacenamos el resultado en una matriz.
      foreach($query->result() as $row)
        $titulaciones[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sTitulacion, ENT_QUOTES);
      $query->free_result();
      return $titulaciones;
    }
  }

  /* Función para obtener las asignaturas disponibles en el sistema */
  public function get_asignaturas($iId = NULL) {
    if ($iId == NULL)
      $query = $this->db->query("select * from asignatura");
    else {
      $this->db->select('asignatura.*, usuarioscurso.iId as iId_Cur_Asi');
      $this->db->from('asignatura');
      $this->db->join('usuarioscurso', 'usuarioscurso.iId_Asignatura = asignatura.iId');
      $this->db->where('usuarioscurso.iId_Usuario', $iId);
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


}
?>