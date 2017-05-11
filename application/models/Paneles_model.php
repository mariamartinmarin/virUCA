<?php

class Paneles_model extends CI_Model{
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
    }
    
    public function filas()
    {
      $consulta = $this->db->query("SELECT * FROM panel");
      return  $consulta->num_rows() ;
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

        $consulta = $this->db->get();
        return $consulta->num_rows();
      }
    }
     
    public function mod($iId,
        $modificar="NULL",
        $panel="NULL", 
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
            WHERE iId_Panel = $iId AND iNumCasilla = ($i+1);");

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

    public function eliminar_casilla($iId){
      $consulta=$this->db->query("DELETE FROM panelcasillas WHERE iId=$iId");
      if ($consulta == true){
        return true;
      } else {
        return false;
      }
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