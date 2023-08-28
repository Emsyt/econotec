<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:19/04/2022, Codigo:GAN-FR-A0-165
  Descripcion: se actualizaron los modelos para hacer uso de las funciones actualizadas de base de datos
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:19/04/2022, Codigo:GAN-MS-M3-169
  Descripcion: se modifico el query de fn_listar_lote_pedidos para que imprima solo 
  los checkbox seleccionados en el pdf.
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:27/04/2022, Codigo:GAN-MS-A6-194
  Descripcion: se adiciono la funcion fn_listar_transportes para el combo de select de transporte
  asi como tambien se modifico la funcion aceptar_lote para que esta misma registre el id_transporte.
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:27/04/2022, Codigo:GAN-MS-A7-205
  Descripcion: se modifico la funcion aceptar lote para que este acepte la fecha de envio
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:29/04/2022, Codigo:GAN-BA-A7-215
  Descripcion: se adiciono las funciones que_cargo_tiene para que este me devuelva
  el rol del usuario logueado y set_prior para que edite la prioridad del lote
  ------------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma Fecha:19/09/2022, Codigo:GAN-MS-A1-466
  Descripcion: se agrego get_solicitud2 que devuelve los productos aceptados y se modifico
  aceptar_lote para aceptar un array de cantidades.
  */
class M_solicitud extends CI_Model {

  public function lista_lotes_solicitudes($login){
    $query = $this->db->query("SELECT * FROM fn_lista_lotes_solicitudes($login);");
    return $query->result();
  }

  public function get_conf_solicitud($id_lote){
    $query = $this->db->query("SELECT * FROM fn_listar_lote_pedidos($id_lote);");
    return $query->result();
  }
  public function fn_listar_transportes(){
    $query = $this->db->query("SELECT * FROM fn_listar_transportes();");
    return $query->result();
  }
  public function get_proveedores(){
    $query = $this->db->query("SELECT * FROM vw_proveedores;");
    return $query->result();
  }
  public function get_telf_proveedor($id_proveedor){
    $query = $this->db->query("SELECT movil FROM cat_personas cp WHERE id_personas = $id_proveedor;");
    return $query->result();
  }
  public function msg_whatsapp($id_lote,$telf_proveedor){
    $query = $this->db->query("SELECT * FROM fn_msg_whatsapp($id_lote,'$telf_proveedor')");
    return $query->result();
  }
  public function get_solicitud($id_lote, $array){
    $query = $this->db->query("SELECT * FROM fn_listar_lote_pedidos($id_lote) where oidmovimiento in (select unnest (ARRAY$array))");
    return $query->result();
  }
  //GAN-MS-A1-466 19-9-2022 PBeltran 
  public function get_solicitud2($id_lote, $array){
    $query = $this->db->query("SELECT * FROM fn_listar_lote_pedidos2($id_lote) where oidmovimiento in (select unnest (ARRAY$array))");
    return $query->result();
  }
  //FIN GAN-MS-A1-466 19-9-2022 PBeltran 
  public function aceptar_solicitud($id_usuario,$id_movimiento){
    $query = $this->db->query("SELECT * FROM fn_confirmar_producto_individual($id_usuario,$id_movimiento);");
    return $query->result();
  }

  //GAN-MS-A1-466 19-9-2022 PBeltran 
  public function aceptar_lote($id_usuario,$array,$array2, $id_transporte,$fecha){
    $query = $this->db->query("SELECT * FROM fn_confirmar_lote_pedidos2($id_usuario,ARRAY$array,ARRAY$array2,$id_transporte,'$fecha');");
    return $query->result();
  }
  //FIN GAN-MS-A1-466 19-9-2022 PBeltran 
  public function set_prior($id_usuario, $lote,$estado){
    $query = $this->db->query("SELECT * FROM fn_priorizar_lote($id_usuario, $lote, $estado);");
    return $query->result();
  }  
  public function que_cargo_tiene($id_usuario){
    $query = $this->db->query("SELECT id_rol FROM seg_usuariorestriccion su WHERE id_usuario=$id_usuario");
    return $query->result();
  }
  public function delete_producto($id_usuario, $id_movimiento){
    $query = $this->db->query("SELECT * FROM fn_anular_producto_individual($id_usuario,$id_movimiento);");
    return $query->result();
  }
}
