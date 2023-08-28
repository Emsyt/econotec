<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:26/04/2022, Codigo: GAN-MS-A5-198,
Descripcion: Se realizo la creacion del modelo stock, con las funciones get_ubicacion_cmb y get_lst_reporte_stock.
*/

class M_reporte_stock extends CI_Model {

  public function get_ubicacion_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_ubicaciones');
    return $query->result();
  }

  public function get_lst_reporte_stock($json_stock) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_reporte_ajuste_stock($id_usuario,'$json_stock'::JSON)");
    return $query->result();
  }
  
}