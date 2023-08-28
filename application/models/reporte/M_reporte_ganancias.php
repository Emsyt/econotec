<?php
/* 
------------------------------------------------------------------------------------------
Creacion: Gary German Valverde Quisbert Fecha:16/09/2022, Codigo: GAN-MS-A1-462,
Descripcion: modulo para generar los reportes de produccion
*/
class M_reporte_ganancias extends CI_Model {

  public function get_lst_ganancias($id_ubi,$fecha_inicial,$fecha_fin) {
    
    $x="SELECT * FROM fn_reporte_ganancia($id_ubi,'$fecha_inicial','$fecha_fin')";
    $query = $this->db->query("SELECT * FROM fn_reporte_ganancia2($id_ubi,'$fecha_inicial','$fecha_fin')");
    return $query->result();
  }

}