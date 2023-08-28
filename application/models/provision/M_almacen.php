
<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:15/04/2022, Codigo:GAN-FR-M4-159
  Descripcion: se modificaron los antiguos querys para que estos manejen funciones
  proporcionadas por base de datos
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:27/04/2022, Codigo:GAN-MS-A7-205
  Descripcion: se modificaron las funciones get lst_solicitud y confirmar_solicitud
  para que este acepte la fecha y el id_ubicacion respectivamente
*/
/*
  ------------------------------------------------------------------------------
  Modificado: Gary German Valverde Quisbert   Fecha:25/08/2022, Codigo:GAN-MS-A1-387
  Descripcion: Se modifico get_lst_ubicacion reemplazando el query por una funcion.
  fn_listar_ubicaciones_provision 
*/
class M_almacen extends CI_Model {

  public function get_lst_solicitud($login, $id_ubicacion){
    $query = $this->db->query("SELECT * FROM fn_listar_solicitud($login,$id_ubicacion);");
    return $query->result();
  }
  public function get_lst_ubicacion($login,$id_ubicacion){
    // GAN-MS-A1-387 Gary Valverde          Fecha:25/08/2022
    $query = $this->db->query("SELECT * FROM fn_listar_ubicaciones_provision($id_ubicacion)");
    // FIN  GAN-MS-A1-387 Gary Valverde          Fecha:25/08/2022
    return $query->result();
  }

  public function get_producto_cmb($id_ubicacion){
    $query = $this->db->query("select * FROM fn_productos_ubicacion($id_ubicacion);");
    return $query->result();
  }

  public function get_cantidad_almacen($id_ubicacion, $id_movimiento){
    $query = $this->db->query("SELECT * FROM fn_cantidad_producto_ubicacion($id_movimiento,$id_ubicacion); ");
    return $query->result();
  }
  // GAN-MS-B5-0456, 11/05/2023 ILaquis.
  public function get_lst_cliente(){
    $query = $this->db->query("SELECT * FROM vw_clientes");
    return $query->result();
  }
  public function insert_solicitud_distribuidor($id_mod,$id_usuario,$json){
    $query = $this->db->query("SELECT * FROM fn_registrar_solicitud_distribuidor($id_mod,$id_usuario,'$json'::JSON)");
    return $query->result();
  }
  // FIN GAN-MS-B5-0456, 11/05/2023 ILaquis.

  // GAN-MS-B1-0456, 12/05/2023 ILaquis.
  public function confirmar_solicitud_distribuidor($id_usuario,$fec_entrega,$sel_ubi,$id_cliente){
    $query = $this->db->query("SELECT * FROM fn_confirmar_solicitud_distribuidor($id_usuario,'$fec_entrega',$sel_ubi,$id_cliente);");
    return $query->result();
  }
  // FIN GAN-MS-B1-0456, 12/05/2023 ILaquis.

  public function contador_solicitudes($login,$id_ubicacion) {
    $query = $this->db->query("SELECT COUNT(id_movimiento) contador_solicitud 
      FROM mov_movimiento 
      WHERE apiestado = 'SOLICITUD'
      AND usucre = '$login'
      AND ubi_fin = $id_ubicacion ");
    return $query->row('contador_solicitud');
  }

  public function insert_solicitud($id_mod,$id_usuario,$json){
    $query = $this->db->query("SELECT * FROM fn_registrar_solicitud($id_mod,$id_usuario,'$json'::JSON)");
    return $query->result();
  }

  public function confirmar_solicitud($id_usuario,$fec_entrega,$sel_ubi){
    $query = $this->db->query("SELECT * FROM fn_confirmar_solicitud($id_usuario,'$fec_entrega',$sel_ubi);");
    return $query->result();
  }

  public function delete_solicitud($id_usuario, $id_prod){
    $query = $this->db->query("SELECT * FROM fn_eliminar_solicitud($id_usuario,$id_prod); ");
    return $query->result();
  }

}
