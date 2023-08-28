<?php
/*
  Modificado: Brayan Janco Cahuana Fecha:27/09/2021, Codigo: GAN-MS-A4-038,
  Descripcion: Se modifico para crear la funcion get_lst_nota_venta_cotizacion
  ------------------------------------------------------------------------------
   Modificado: Alison Paola Pareja Fecha:20/07/2022, Codigo: GAN-MS-A1-315,
  Descripcion: Se modifico la funcion get_producto_cmb para concatenar el codigo alternativo
  ------------------------------------------------------------------------------
  Modificado: Gabriela Mamani Choquehuanca     Fecha: 09/08/2022    Código: GAN-MS-A1-330
  Descripción: Se modifico la funcion get_producto_cmb para que ya no se tome en cuanta el atributo id_relacion
  en ningun select 
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Pedro Rodrigo Beltran Poma.   Fecha:29/08/2022,   Codigo: GAN-SC-M5-405,
  Descripcion: Se reemplazo el query en delete_pedido()  por la funcion fn_delete_pedido() que realiza  un update
  en la tabla mov_venta.
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Gary German Valverde Quisbert.   Fecha:30/08/2022,   Codigo: GAN-SC-M5-410,
  Descripcion: Se reemplazo el query en get_cliente_cmb()  por la funcion fn_get_cliente_cmb() que obtiene los clientes
  para mostrarlos en un combo box
  ------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar     Fecha: 30/08/2022    Código: GAN-SC-M5-403
  Descripción: Se modifico la funcion get_producto_cmb para llamar a la funcion del databrach fn_get_productos_plataforma
  en ningun select
  ------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha:30/08/2022,   Codigo: GAN-MS-M5-411,
  Descripcion: Se modifico la funcion confirmar_pedido para reemplazar el query por una funcion.
  ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja  Fecha:17/11/2022,   Codigo: GAN-MS-A4-0061,
  Descripcion: Se creo la funcion insert_mov_pedido para registrar en mov_movimiento.
  ----------------------------------------------------------------------------------
  Modificado: Ariel Ramos Paucara  Fecha:20/03/2023,   Codigo: GAN-MS-B5-0327
  Descripcion: Se modifico la funcion insert_pedido para registrar con una
  funcion fn_insert_pedido(json) en mov_venta.
  ----------------------------------------------------------------------------------
  Modificado: Ariel Ramos Paucara  Fecha:20/03/2023,   Codigo: GAN-MS-B5-0327
  Descripcion: Se modifico la funcion insert_mov_pedido para registrar con una
  funcion fn_insert_mov_pedido(json) en mov_movimiento.
  */
class M_pedido extends CI_Model {

  public function get_producto_cmb(){
    //GAN-SC-M5-403, 29-08-2022, Luis Fabricio Pari Wayar.
    $ID_UBICACION = $this->session->userdata('ubicacion');
    $query = $this->db->query(" SELECT * FROM fn_get_productos_plataforma($ID_UBICACION)");
    return $query->result();
    // FINGAN-SC-M5-403, 29-08-2022, Luis Fabricio Pari Wayar.
  }


  public function get_datos_producto($id_producto){
    $id_ubicacion = $this->session->userdata('ubicacion');
    $query = $this->db->query("SELECT * FROM fn_buscar_producto($id_producto, $id_ubicacion)");
    return $query->row();
  }

  public function get_cliente_cmb(){
    // GAN-SC-M5-410, 30/08/2022, Gary Valverde
    $query = $this->db->query("SELECT * FROM fn_get_cliente_cmb()");
    // FIN GAN-SC-M5-410, 30/08/2022, Gary Valverde
    return $query->result();
  }

  public function contador_pedidos($usr){
    $query = $this->db->query("SELECT COUNT(id_venta) contador_pedido
      FROM mov_venta
      WHERE apiestado = 'RESERVA'
      AND usucre = '$usr' ");
    return $query->row('contador_pedido');
  }

  public function insert_pedido($data){
    // GAN-MS-B5-0327, 20/03/2023, Ariel Ramos
    $query = $this->db->query("SELECT * FROM fn_insert_pedido('$data'::JSON)");
    return $query->result();
    // FIN GAN-MS-B5-0327, 20/03/2023, Ariel Ramos
  }
  public function insert_mov_pedido($data){
    // GAN-MS-B5-0327, 20/03/2023, Ariel Ramos
    $query = $this->db->query("SELECT * FROM fn_insert_mov_pedido('$data'::JSON)");
    return $query->result();
    // FIN GAN-MS-B5-0327, 20/03/2023, Ariel Ramos
  }

  public function get_pedido(){
    $id_ubicacion = $this->session->userdata('ubicacion');
    $login = $this->session->userdata('usuario');
    $query = $this->db->query("SELECT mv.id_venta, cp.descripcion producto, mv.cantidad , mv.unidad, mv.precio FROM MOV_VENTA MV JOIN cat_producto CP ON MV.id_producto=CP.id_producto WHERE MV.ID_UBICACION=$id_ubicacion AND MV.APIESTADO='RESERVA' AND MV.ID_LOTE=0 AND MV.USUCRE='$login' ORDER BY mv.id_venta DESC");
    return $query->result();
  }

  public function get_total_pedido(){
    $id_ubicacion = $this->session->userdata('ubicacion');
    $login = $this->session->userdata('usuario');
    $query = $this->db->query("SELECT sum(mv.precio::numeric) AS total_pedido FROM MOV_VENTA MV JOIN cat_producto CP ON MV.id_producto=CP.id_producto WHERE MV.ID_UBICACION=$id_ubicacion AND MV.APIESTADO='RESERVA' AND MV.ID_LOTE=0 AND MV.USUCRE='$login'");
    return $query->row('total_pedido');
  }

  public function delete_pedido($id_ped, $data){
    // GAN-SC-M5-405, 29/08/2022, PBeltran
    $vData = array_values($data);
    $vapiestado = $vData[0];
    $vusumod = $vData[1];
    $query = $this->db->query("SELECT * FROM fn_delete_pedido($id_ped, '$vapiestado', '$vusumod');");
    return $query->result();
    // FIN GAN-SC-M5-405, 29/08/2022, PBeltran
  }

  public function update_pedido($where, $data){
    $this->db->update('mov_venta', $data, $where);
    
    return $this->db->affected_rows();
  }

  public function confirmar_pedido(){
    $ID_UBICACION = $this->session->userdata('ubicacion');
    $LOGIN = $this->session->userdata('usuario');
    // GAN-SC-M5-411 30/08/2022 Deivit Pucho
    $query = $this->db->query("SELECT * FROM fn_confirmar_pedido_venta($ID_UBICACION,'$LOGIN')");
    // Fin GAN-SC-M5-411 30/08/2022 Deivit Pucho
    return $this->db->affected_rows();
  }

  public function get_producto(){
    $this->db->select('p.id_producto, p.id_categoria, p.id_marca, p.codigo, p.descripcion producto, p.caracteristica, p.apiestado apiestado_prod, c.descripcion categoria, m.descripcion marca');
    $this->db->from('cat_producto p');
    $this->db->join('cat_categoria c', 'c.id_categoria = p.id_categoria');
    $this->db->join('cat_marca m', 'm.id_marca = p.id_marca');
    $query = $this->db->get();
    return $query->result();
  }
  public function get_lst_nota_venta_cotizacion($id_usuario,$id_venta) {
    $query = $this->db->query("SELECT * FROM fn_nota_venta_cotizacion($id_usuario,$id_venta,0)");
    return $query->result();
  }

}
