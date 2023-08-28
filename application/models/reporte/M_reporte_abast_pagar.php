<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:11/11/2021, Codigo: GAN-MS-A5-078,
Creacion del Model M_reporte_creditos con sus respectivas funciones para la relacion con la base de datos
 */
class M_reporte_abast_pagar extends CI_Model {

  public function get_proveedor_cmb() {
    $query = $this->db->query("SELECT * from vw_proveedores");
    return $query->result();
  }
  public function get_lst_deudas_abastecimiento($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_deudas_abastecimiento($id_usuario,'$json'::JSON)");
    return $query->result();
  }

  public function get_pagar_deuda_abastecimiento($codigo, $detalle, $pago) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_pagar_deuda_abastecimiento($id_usuario, '$codigo', '$detalle', $pago)");
    return $query->result();
  }

  public function get_historial_deuda_abastecimiento($codigo, $detalle) {
    $query = $this->db->query("SELECT * FROM fn_historial_deuda_abastecimiento('$codigo', '$detalle')");
    return $query->result();
  }
  
}

