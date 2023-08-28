<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:11/11/2021, Codigo: GAN-MS-A5-078,
Creacion del Model M_reporte_creditos con sus respectivas funciones para la relacion con la base de datos
------------------------------------------------------------------------------------------
Creador: Alvaro Ruben Gonzales Vilte Fecha:04/10/2022, Codigo: GAN-CV-B6-0028,
Modificacion: se modifico el llamado a la función para completar el pago de deuda correctamente
------------------------------------------------------------------------------------------
Creador: Keyla Paola Usnayo Aguilar Fecha:17/11/2022, Codigo: GAN-MS-A3-0106,
Modificacion: se modifico el llamado a la función para listar el reporte
 */
class M_reporte_creditos extends CI_Model {

  public function get_lst_clientes() {
    $query = $this->db->query("SELECT * from vw_clientes vc where id_personas <> 0");
    return $query->result();
  }
  public function get_lst_rep_deudas($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_reporte_deudas_v2($id_usuario,'$json'::JSON)");
    return $query->result();
  }

  public function get_pagar_deuda($idlote, $usucre, $idcliente, $pago) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_pagar_deuda($id_usuario, $idlote, '$usucre', $idcliente, $pago)");
    return $query->result();
  }

  public function get_historial_deuda($idlote, $usucre, $idcliente) {
    $query = $this->db->query("SELECT * FROM fn_historial_deuda($idlote, '$usucre', $idcliente)");
    return $query->result();
  }
  
}

