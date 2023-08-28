<?php
/* 
------------------------------------------------------------------------------------------
Creacion: Gary German Valverde Quisbert Fecha:16/09/2022, Codigo: GAN-MS-A1-462,
Descripcion: modulo para generar los reportes de produccion
*/
class M_reporte_produccion extends CI_Model {

  public function get_lst_produccion($fecha_inicial,$fecha_fin) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_reportes_produccion('$fecha_inicial','$fecha_fin')");
    return $query->result();
  }

}
