<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paneles_model extends CI_Model{
  var $table = 'panel';
  
  var $column_order = array(null, 'sNombre', 'iCasillas', 'sTitulacion' , 'sNombre_Asignatura', null,  null);
  var $column_search = array('sNombre', 'iCasillas', 'sTitulacion' , 'sNombre_Asignatura');
  var $order = array('iId' => 'desc');

  public function __construct() {
    parent::__construct(); 
    $this->load->database();
  }
    
  /* Función privada que obtiene los datos de la BBDD necesarios para construir la vista. */
  private function _get_datatables_query() {
    if ($this->session->userdata('admin') == 1) {
      // Administrador. Acceso a todo.
      $this->db->select('panel.*, 
          titulacion.sTitulacion, 
          asignatura.sNombre as sNombre_Asignatura,
          titulacion.sTitulacion,
          usuario.sNombre as sNombre_Usuario,
          usuario.sApellidos');
      $this->db->from('panel');
      $this->db->join('usuario', 'usuario.iId = panel.iId_Propietario');
      $this->db->join('titulacion', 'titulacion.iId = panel.iId_Titulacion');
      $this->db->join('asignatura', 'asignatura.iId = panel.iId_Asignatura');
    
    } else {
      // Profesor. Acceso a su ámbito.
      $this->db->select('panel.*, 
          titulacion.sTitulacion, 
          asignatura.sNombre as sNombre_Asignatura,
          titulacion.sTitulacion,
          usuario.sNombre as sNombre_Usuario,
          usuario.sApellidos');
      $this->db->from('panel');
      $this->db->join('usuario', 'usuario.iId = panel.iId_Propietario');
      $this->db->join('titulacion', 'titulacion.iId = panel.iId_Titulacion');
      $this->db->join('asignatura', 'asignatura.iId = panel.iId_Asignatura');
      $this->db->where_in('panel.iId_Universidad', $this->session->userdata('universidades'));
      $this->db->where_in('panel.iId_Titulacion', $this->session->userdata('titulaciones'));
      $this->db->where_in('panel.iId_Asignatura', $this->session->userdata('asignaturas'));  
      $this->db->where('panel.iId_Propietario', $this->session->userdata('id_usuario')); 
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
    como soporte */

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
    $iId_Panel = $this->db->insert_id();

    // Ahora generamos las casillas.
    for ($i = 1; $i <= $data["iCasillas"]; $i++) {
      // Seleccionar categoría aleatoria.
      $id_categoria = $this->get_random_cat($data["iId_Asignatura"]);
      // Por defecto, función nula.
      $funcion = "Ninguno";
      // Dar de alta casilla.
      $data_casilla = array('iId_Panel' => $iId_Panel,
        'iId_Categoria' => $id_categoria,
        'iNumCasilla' => $i,
        'eFuncion' => $funcion);
      $add_casilla = $this->db->insert('panelcasillas', $data_casilla);
    }
    
    return $iId_Panel;    
  }

  public function get_random_cat($iId_Asignatura) {
    // Sólo podemos tomar las categorías para las que ha sido designado el panel según su asignatura y su
    // titulación.
    $this->db->join("asignatura", "asignatura.iId = $iId_Asignatura");
    $this->db->order_by('rand()');
    $this->db->limit(1);
    $query = $this->db->get('categoria');

    foreach($query->result() as $fila){
      $iId_Categoria = $fila->iId;
    }
    return $iId_Categoria;
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
    Función que obtiene un registro de la tabla 'curso' según un $iId que obtiene como entrada.
    ENTRADA: $iId (Identificador único del registro que queremos obtener de la base de datos)
    SALIDA:  Registro [curso].
  */
  public function get_by_id($iId) {
    $this->db->select('*');
    $this->db->from('panel');
    $this->db->where('iId', $iId);
    
    $query = $this->db->get();
    return $query->row();
  }

   /* 
    Función que elimina un registro cuyo $iId se toma como entrada
    ENTRADA: $iId (Identificador del registro que se quiere eliminar).
    SALIDA: -
  */
  public function delete_by_id($iId) {
    
    // Primero, borramos todas las casillas.
    $this->db->where('iId_Panel', $iId);
    $this->db->delete('panelcasillas');

    // Eliminamos la ocurrencia de la tabla panel.
    $this->db->where('iId', $iId);
    $this->db->delete('panel');
  }


  // Funcion para saber si hay partidas asociadas.

  public function tiene_partidas($iId) {
    $this->db->select('iId');
    $this->db->from('partida');
    $this->db->where('iId_Panel', $iId);
    $query = $this->db->get();

      if ($query->num_rows() == 0)
        return 0;
      else 
        return 1;
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

  // Vamos a obtener las categorías para la modificación del panel. Sólo podremos tomar las categorías de la asignatura
  // que esté definida en dicho panel.
  public function get_categorias($iId_Panel) {
    $query_asignatura = $this->db->query("select iId_Asignatura from panel where iId = $iId_Panel");
    $datos_asignatura = $query_asignatura->row();
    $iId_Asignatura = $datos_asignatura->iId_Asignatura;

    $query_categorias = $this->db->query("select * from categoria where iId_Asignatura = $iId_Asignatura");

    if ($query_categorias->num_rows() > 0)
      // Almacenamos el resultado en una matriz.
      foreach($query_categorias->result() as $row)
        $categorias[htmlspecialchars($row->iId, ENT_QUOTES)] = htmlspecialchars($row->sCategoria, ENT_QUOTES);

    $query_categorias->free_result();
    return $categorias;
    }

    // Elimina una casilla del panel.

    public function eliminar_casilla($iId, $iId_Panel){
      // Obtengo antes el número de casillas del panel actual.
      $panel_query = $this->db->query("SELECT iId, iId_Panel FROM panelcasillas where iId=$iId");
      if($panel_query->num_rows()>0) {
        $datos_panel = $panel_query->row();
        $iId_Panel = $datos_panel->iId_Panel;
      }

      $casillas_query = $this->db->query("SELECT iCasillas FROM panel where iId=$iId_Panel");
      if($casillas_query->num_rows()>0) {
        $datos_casillas = $casillas_query->row();
        $nCasillas = $datos_casillas->iCasillas;
      }

      $consulta=$this->db->query("DELETE FROM panelcasillas WHERE iId=$iId");
      if ($consulta == true){
        // Decrementamos en 1 el campo iCasillas de la tabla panel.
        $newiCasillas = $nCasillas - 1;
        $consulta = $this->db->query("UPDATE panel set iCasillas = $newiCasillas where iId = $iId_Panel");

        // Reorganizamos los índices.
        $this->reorganiza_casillas($iId_Panel);
        

        // Devolvemos el estatus.

        return true;
      } else {
        return false;
      }
    }

    // Una vez que se ha eliminado una casilla, hay que reorganizar los ordendes.

    public function reorganiza_casillas($iId_Panel) {
      $query_celdas = $this->db->query("SELECT iId FROM panelcasillas WHERE iId_Panel = $iId_Panel");
        if ($query_celdas->num_rows() > 0) {
          $orden_casilla = 1;
          foreach ($query_celdas->result() as $casilla) {
            $query_actualiza_pos = $this->db->query("UPDATE panelcasillas SET
              iNumCasilla = $orden_casilla WHERE iId = $casilla->iId");
            $orden_casilla++;
          }
        }
    }

    // Añadir una casilla o casillas al panel.
     public function add($iId_Panel, $eFuncion, $iId_Categoria) {
      if ($eFuncion != "" && $iId_Categoria != "") {
        $data = array('iId_Categoria' => $iId_Categoria,
        'iId_Panel' => $iId_Panel,
        'eFuncion' => $eFuncion);

        if ($this->db->insert('panelcasillas', $data)) {
          $this->Paneles_model->reorganiza_casillas($iId_Panel);
          // Actualizar el número de casillas de la tabla PANEL.
          $obtener_casillas = $this->db->query("SELECT iCasillas FROM panel where iId = $iId_Panel");
          $datos_casillas = $obtener_casillas->row();
          $iCasillas_new = $datos_casillas->iCasillas + 1;
          $actualiza_panel = $this->db->query("UPDATE panel SET iCasillas = $iCasillas_new WHERE iId = $iId_Panel");
          return true;
        } else { 
          return false;
        }
      }
    }

    // Función para saber si un panel pertenece al usuario logueado.

    function esPropietario($iId_Panel) {
      $query = $this->db->query("select iId_Propietario from panel where iId = $iId_Panel");
      $datos = $query->row();

      if ($query->num_rows() > 0)
        if ($datos->iId_Propietario == $this->session->userdata('id_usuario'))
          return true;
        else
          return false;
      else 
        return false;
    }








    function total_paginados($por_pagina, $segmento, $pages) 
    {
      
      $this->db->select('p.sNombre as nombrePanel, p.*, u.sNombre, u.sApellidos');
      $this->db->from('panel p');
      $this->db->join('usuario u', 'u.iId = p.iId_Propietario');
      $this->db->order_by('p.sNombre ASC');

      $consulta = $this->db->get('', $por_pagina, $segmento);

      if($consulta->num_rows()>0)
      {
        foreach($consulta->result() as $fila)
        {
          $data[] = $fila;
        }
        return $data;
      } else {
        
        $segmento_anterior = $segmento - $pages;
        if ($segmento_anterior < 0) $segmento_anterior = "";
          //$consulta = $this->db->get('', $por_pagina, $segmento_anterior);
          if($consulta->num_rows()>0) {
            foreach($consulta->result() as $fila) {
              $data[] = $fila;
            }
            return $data;
          }
        }
    }

    public function enPartida($iId) {
      if (is_numeric($iId)) {
        $this->db->select('iId');
        $this->db->from('partida');
        $this->db->where('iId_Panel', $iId);
        $this->db->where('bEmpezada', 1);
        $this->db->where('bFinalizada', 0);

        $consulta = $this->db->get();
        return $consulta->num_rows();
      }
    }
     
    public function mod($iId,
        $modificar="NULL",
        $bActivo="NULL",
        $panel="NULL", 
        $identificadores="NULL",
        $funciones="NULL", 
        $categorias="NULL") {
      
      if ($modificar == "NULL"){
        // Si la opción es visitar la página de modificación, obtenemos los datos.
        $this->db->select('p.*, pc.eFuncion, pc.iId_Categoria, pc.iId_Panel, pc.iId as iId_Casilla');
        $this->db->from('panel p');
        $this->db->join('panelcasillas pc', 'p.iId = pc.iId_Panel');
        $this->db->where('p.iId', $iId);
        $this->db->order_by('pc.iId ASC');
      
        $consulta = $this->db->get();
        return $consulta->result();

      } else {
        // En este caso es que queremos modificar el panel. Procedemos a ello.
        $sinErrores = true;
        for ($i = 0; $i < count($funciones); $i++) {
          $consulta = $this->db->query("UPDATE panelcasillas SET
            iId_Categoria = '$categorias[$i]',
            eFuncion = '$funciones[$i]'
            WHERE iId_Panel = $iId AND iId = $identificadores[$i];");

          if ($consulta == false && $sinErrores == true) $sinErrores = false;
        }

        // Ahora hay que cambiar los datos del panel, no de las casillas.
        if ($sinErrores) {
          $consulta = $this->db->query("UPDATE panel SET
            bActivo = '$bActivo'
            WHERE iId = $iId");
          if ($consulta == false && $sinErrores == true) $sinErrores = false;
        }
        return $sinErrores;
      }
    }

    
     
    public function eliminar($iId){
      // Eliminamos las casillas y posteriormente el panel.
      $consulta = $this->db->query("DELETE FROM panelcasillas WHERE iId_Panel = $iId;");
      if ($consulta == true){
        // Borramos las casillas.
        $consulta2 = $this->db->query("DELETE FROM panel WHERE iId = $iId");
        if ($consulta2 == true)
          return true;
        else return false;
      } else {
        return false;
      }
    }

    

    

   

    


}
?>