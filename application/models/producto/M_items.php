<?php
/*
------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:28/11/2022, GAN-MS-A7-0142,
Creacion del Model M_items y las funciones M_listar_lotes_garantia y M_mostrar_lotes_garantia
------------------------------------------------------------------------------
Modificacion: Aliso Paola Pari Pareja Fecha:29/11/2022, GAN-MS-A7-0145
Se anadieron funciones para el registro, edicion, y eliminacion de series
------------------------------------------------------------------------------
*/
class M_items extends CI_Model {

  public function M_listar_lotes_garantia(){
    $id_ubicacion = $this->session->userdata('ubicacion');
    $query = $this->db->query("SELECT * FROM fn_listar_lotes_garantia($id_ubicacion)");
    return $query->result();
  }
  public function M_mostrar_lotes_garantia($id_lote){
    $id_ubicacion = $this->session->userdata('ubicacion');
    $query = $this->db->query("SELECT * FROM fn_mostrar_lotes_garantia($id_lote,$id_ubicacion)");
    return $query->result();
  }
  public function M_validar_cantidad_serie($id_provision,$id_lote,$id_producto){
    $query = $this->db->query("SELECT * FROM fn_validar_faltantes_serie($id_provision,$id_lote,$id_producto)");
    return $query->result();
  }
  public function M_verificar_generado_serie($id_provision,$id_lote,$id_producto,$cantidad,$inicio){
    $id_login = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verificar_generado_serie($id_login,$id_provision,$id_lote,$id_producto,$cantidad,$inicio)");
    return $query->result();
  }

  public function M_serie($id_provision,$id_lote,$id_producto){
    $query = $this->db->query("SELECT codigo FROM cat_item ci where id_provision =$id_provision and id_lote = $id_lote and id_producto = $id_producto");
    return $query->result();
  }
  public function M_generar_serie_item($id_provision,$id_lote,$id_producto,$cantidad,$inicio){
    $id_login = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_generar_serie_item($id_login,$id_provision,$id_lote,$id_producto,$cantidad,$inicio)");
    return $query->result();
  }

  public function M_listar_series($id_producto,$id_lote,$id_provision){
    $query = $this->db->query("SELECT * FROM fn_listar_series($id_producto,$id_lote,$id_provision)");
    return $query->result();
  }
  public function M_add_edit_serie($tipo,$id_provision,$id_login,$id_producto,$id_lote,$serie){
    $query = $this->db->query("SELECT * FROM fn_registrar_serie($tipo,$id_provision,$id_login,$id_producto,$id_lote,'$serie')");
    return $query->result();
  }
  public function M_recuperar_serie($id_item){
    $query = $this->db->query("SELECT * FROM fn_recuperar_datos_serie($id_item)");
    return $query->result();
  }
  public function M_eliminar_serie($id_item){
    $id_login = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_serie($id_login,$id_item)");
    return $query->result();
  }
}
