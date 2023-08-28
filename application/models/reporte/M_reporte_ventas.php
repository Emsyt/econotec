<?php
/* 
------------------------------------------------------------------------------------------
Modificacion: Brayan Janco Cahuana Fecha:19/11/2021, Codigo: GAN-MS-A3-079,
Se modifico la funcion get_lst_ventas por una funcion mas actualizada con la base de datos

------------------------------------------------------------------------------------------
Modificacion: Brayan Janco Cahuana Fecha:22/11/2021, Codigo: GAN-MS-A2-099,
Se agrego la funcion get_totales_ventas la cual devuelve el la suma total tanto de costo total y utilidad bruta
 */
class M_reporte_ventas extends CI_Model {

  public function get_ubicacion_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_ubicaciones');
    return $query->result();
  }

  public function get_lst_ventas($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_reporte_ventas($id_usuario,'$json'::JSON)");
    return $query->result();
  }

  public function get_totales_ventas($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT sum(ototal)total,sum(outilidad)utilidad FROM fn_reporte_ventas($id_usuario,'$json'::JSON)");
    return $query->result();
  }

}