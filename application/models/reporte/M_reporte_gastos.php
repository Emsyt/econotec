<?php
class M_reporte_gastos extends CI_Model {

  public function get_lst_estados_gastos($id_usuario) {
    $query = $this->db->query("SELECT * FROM fn_estados_gastos($id_usuario)");
    return $query->result();
  }
  public function get_rep_gastos($id_usuario,$json) {
    $query = $this->db->query("SELECT * FROM fn_reporte_gastos($id_usuario,'$json'::JSON)");
    return $query->result();
  }
  
}