<?php
/* 
----------------------------------------------------------------------------------------
Modificado: Jose Daniel Luna Flores  Fecha: 28/11/2022 Codigo:GAN-MS-M6-0140
Descripcion: Se modifico el modelo de reporte_abastecimiento para apuntar a la funcion fn_reporte_abastecimiento()   
 */
?> 
<?php
class M_reporte_abastecimiento extends CI_Model {

  public function get_ubicacion_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_ubicaciones');
    return $query->result();
  }
  public function get_lst_ubicaciones() {
    $query = $this->db->query("SELECT * FROM fn_listar_ubicaciones()");
    return $query->result();
  }

  public function get_rep_abastecimiento($json) {
  //GAN-MS-A1-481 Gary Valverde 26-09-2022
    //INICIO GAN-MS-M6-0140 J.LUNA 28-11-2022
    $query = $this->db->query("SELECT * FROM fn_reporte_abastecimiento('$json'::JSON)");
    //FIN GAN-MS-M6-0140 J.LUNA 28-11-2022
  //fin GAN-MS-A1-481 Gary Valverde 26-09-2022
    return $query->result();
  }

  public function get_eliminar_abastecimiento($id_abastecimiento) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_abastecimiento($id_usuario,$id_abastecimiento)");
    return $query->result();
  }

}