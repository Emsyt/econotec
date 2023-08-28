<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:15/11/2022, Codigo: GAN-MS-A4-0061,
Descripcion: Se realizo la creacion del modelo movimiento, con las funciones get_ubicacion_cmb y get_lst_reporte_movimiento.
*/

class M_reporte_movimiento extends CI_Model {

  public function get_ubicacion_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_ubicaciones');
    return $query->result();
  }

  public function get_lst_reporte_movimiento($json_stock) {
    $query = $this->db->query("SELECT * FROM fn_reporte_movimiento('$json_stock'::JSON)");
    return $query->result();
  }
  
}