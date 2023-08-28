<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:17/11/2021, GAN-MS-A4-092,
Creacion del Model M_listado_ventas con sus respectivas funciones para la relacion con la base de datos
------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha:12/06/2023,  GAN-MS-M0-0513
Descripcion: Se creo la funcion get_lst_mesas() para obtener las mesas creadas en Administracion.
------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha:12/06/2023,  GAN-MS-M4-0517
Descripcion: Se creo la funcion get_lst_venta() para listar las ventas en estado PENDIENTE y 
delete_venta() para cambiar su estado en ANULADO.
------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha:26/06/2023,  GAN-MS-M0-0524
Descripcion: Se implemento la funcionalidad para editar la cantidad de un pedido.
------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha:03/07/2023,  GAN-MS-M4-0529
Descripcion: Se implemento la funcionalidad para finalizar e imprimir pedido.
------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha:13/07/2023,  GAN-MS-M3-0531
Descripcion: Se corrigio el error de las cantidades al agregar productos al detalle del pedido.
*/
class M_venta_grafica extends CI_Model {

  public function get_categoria() {
    $query = $this->db->query("SELECT * from cat_categoria where apiestado = 'ELABORADO'");
    return $query->result();
  }

  public function registrar_menu($id_registro, $json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_registrar_menu($id_registro,$id_usuario,'$json'::JSON)");
    return $query->result();
  }

  public function get_listar_menus() {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_listar_menus($id_usuario)");
    return $query->result();
  }

  public function categorias_menu($data) {
    $query = $this->db->query("SELECT * FROM fn_categorias_menu($data)");
    return $query->result();
  }

  public function eliminar_menu($data) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_menu($id_usuario,$data)");
    return $query->result();
  }

  public function eliminar_categoria_menu($data) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_categoria_menu($id_usuario,$data)");
    return $query->result();
  }


  public function listar_all_productos_categoria() {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_listar_productos_ubicacion($id_usuario)");
    return $query->result();
  }

  public function listar_productos_categoria($data) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_listar_productos_categoria($data,'',$id_usuario)");
    return $query->result();
  }

  public function cambiar_estado_producto($id_producto, $estado) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cambiar_estado_producto($id_producto,$id_usuario,$estado)");
    return $query->result();
  }

  public function mostrar_producto_grafico($id_producto, $cantidad) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_mostrar_producto_grafico($id_usuario, $id_producto, $cantidad)");
    return $query->result();
  }

  //prueba
  public function get_producto($data) {
    $query = $this->db->query("SELECT * from cat_producto cp where id_categoria = 52");
    return $query->result();
  }

  public function mov_inventario($data) {
    $query = $this->db->query("SELECT * FROM mov_inventario where id_producto=$data order by feccre desc limit 1");
    return $query->result();
  }

  public function listar_estados() {
    $query = $this->db->query("SELECT * FROM fn_listar_estados()");
    return $query->result();
  }
  // GAN-MS-M0-0513, 12/06/2023 ILaquis.
  public function get_lst_mesas($id_usuario) {
    $query = $this->db->query("SELECT * FROM fn_listas_mesas($id_usuario) WHERE id_responsable = $id_usuario");
    return $query->result();
  }
  // FIN GAN-MS-M0-0513, 12/06/2023 ILaquis.
  // GAN-MS-M4-0517, 14/06/2023 ILaquis.
  public function delete_venta($id_usuario, $id_prod) {
    $query = $this->db->query("SELECT * FROM fn_eliminar_venta($id_prod, $id_usuario); ");
    return $query->result();
  }

  public function get_lst_venta($id_usuario) {
    $query = $this->db->query("SELECT * FROM fn_listar_ventas_grafica($id_usuario);");
    return $query->result();
  }
  // FIN GAN-MS-M4-0517, 14/06/2023 ILaquis.
  // GAN-MS-M4-0517, 14/06/2023 ILaquis.
  public function asignar_mesa($id_usuario, $idventas, $cantidades, $idmesa, $switch) {
    $idventasStr = implode(',', $idventas);
    $cantidadesStr = implode(',', $cantidades);
    $query = $this->db->query("SELECT * FROM fn_actualizar_mov_venta_grafica($id_usuario, ARRAY[$idventasStr], ARRAY[$cantidadesStr], $idmesa, $switch);");
    $consulta = $query->result();
    return $consulta;
  }
  public function get_lst_detalle_mesa($id_usuario, $id_mesa) {
    $query = $this->db->query("SELECT * FROM fn_listar_pedidos_ventas_grafica($id_usuario, $id_mesa);");
    return $query->result();
  }
  // FIN GAN-MS-M4-0517, 14/06/2023 ILaquis.
  // GAN-MS-M0-0519, 22/06/2023 ILaquis.
  public function get_ultimo_lote_pendiente($id_usuario) {
    $this->db->select('login');
    $this->db->from('seg_usuario');
    $this->db->where('id_usuario', $id_usuario);
    $usuario = $this->db->get()->result();
    $nombre_usuario = '';
    if (!empty($usuario)) {
      $nombre_usuario = $usuario[0]->login;
    }

    $this->db->select('mv.id_venta, mv.id_producto, mv.cantidad, mv.id_lote');
    $this->db->from('mov_venta mv');
    $this->db->where('mv.apiestado', 'PENDIENTE');
    $this->db->where('mv.id_mesa IS NULL');
    $this->db->where('mv.usucre', $nombre_usuario);
    $this->db->order_by('mv.id_venta');
    $query = $this->db->get();
    return $query->result();
  }
  public function get_ultimo_lote_mesa($id_mesa, $id_usuario) {
    $this->db->select('login');
    $this->db->from('seg_usuario');
    $this->db->where('id_usuario', $id_usuario);
    $usuario = $this->db->get()->result();
    $nombre_usuario = '';
    if (!empty($usuario)) {
      $nombre_usuario = $usuario[0]->login;
    }

    $this->db->select('mv.id_venta, mv.id_producto, mv.cantidad');
    $this->db->from('mov_venta mv');
    $this->db->where('mv.apiestado', 'COMANDA');
    $this->db->where('mv.id_mesa', $id_mesa);
    $this->db->where('mv.usucre', $nombre_usuario);
    $this->db->order_by('mv.id_venta');
    $query = $this->db->get();
    return $query->result();
  }
  // FIN GAN-MS-M0-0519, 22/06/2023 ILaquis.

  // GAN-MS-M0-0524, 26/06/2023 ILaquis.
  public function editar_mesa($id_mesa, $id_usuario) {
    $this->db->select('login');
    $this->db->from('seg_usuario');
    $this->db->where('id_usuario', $id_usuario);
    $usuario = $this->db->get()->result();
    $nombre_usuario = '';
    if (!empty($usuario)) {
      $nombre_usuario = $usuario[0]->login;
    }

    $data = array(
      'apiestado' => 'PENDIENTE'
    );

    $this->db->where('apiestado', 'COMANDA');
    $this->db->where('id_mesa', $id_mesa);
    $this->db->where('usucre', $nombre_usuario);
    $this->db->update('mov_venta', $data);
    return $this->db->affected_rows();
  }
  public function get_datos_pedido($id_venta, $id_producto, $id_mesa, $id_usuario) {
    $this->db->select('login');
    $this->db->from('seg_usuario');
    $this->db->where('id_usuario', $id_usuario);
    $usuario = $this->db->get()->result();
    $nombre_usuario = '';
    if (!empty($usuario)) {
      $nombre_usuario = $usuario[0]->login;
    }

    $this->db->select('mv.cantidad');
    $this->db->from('mov_venta mv');
    $this->db->where('mv.apiestado', 'COMANDA');
    $this->db->where('mv.id_venta', $id_venta);
    $this->db->where('mv.id_producto', $id_producto);
    $this->db->where('mv.id_mesa', $id_mesa);
    $this->db->where('mv.usucre', $nombre_usuario);
    $this->db->order_by('mv.id_venta');
    $query = $this->db->get();
    return $query->result();
  }

  public function modificar_pedido($id_venta, $cantidad_pedido) {
    $data = array(
      'cantidad' => $cantidad_pedido
    );
    $this->db->where('id_venta', $id_venta);
    $this->db->update('mov_venta', $data);
    return $this->db->affected_rows();
  }
  // FIN GAN-MS-M0-0524, 26/06/2023 ILaquis.
  // GAN-MS-M4-0529, 03/07/2023 ILaquis.
  public function realizar_cobro($id_mesa, $id_usuario) {
    $this->db->select('login');
    $this->db->from('seg_usuario');
    $this->db->where('id_usuario', $id_usuario);
    $usuario = $this->db->get()->result();
    $nombre_usuario = '';
    if (!empty($usuario)) {
      $nombre_usuario = $usuario[0]->login;
    }

    $data = array(
      'apiestado' => 'COBRADO'
    );

    $this->db->where('apiestado', 'COMANDA');
    $this->db->where('id_mesa', $id_mesa);
    $this->db->where('usucre', $nombre_usuario);
    $this->db->update('mov_venta', $data);
    $this->db->select('mv.id_venta, mv.id_producto, mv.cantidad');
    $this->db->from('mov_venta mv');
    $this->db->where('mv.apiestado', 'COBRADO');
    $this->db->where('mv.id_mesa', $id_mesa);
    $this->db->where('mv.usucre', $nombre_usuario);
    $this->db->order_by('mv.id_venta');
    $query = $this->db->get();
    return $query->result();
  }
  public function get_mesa_pedido($id_mesa, $id_usuario) {
    $this->db->select('login');
    $this->db->from('seg_usuario');
    $this->db->where('id_usuario', $id_usuario);
    $usuario = $this->db->get()->result();
    $nombre_usuario = '';
    if (!empty($usuario)) {
      $nombre_usuario = $usuario[0]->login;
    }

    $this->db->select('mv.id_venta, mv.id_producto, cp.descripcion, mv.precio, mv.cantidad, (mv.cantidad * mv.precio) as total');
    $this->db->select('mv.id_lote');
    $this->db->select("TO_CHAR(mv.feccre, 'YYYY-MM-DD HH24:MI') as fecha_hora");
    $this->db->from('mov_venta mv');
    $this->db->join('cat_producto cp', 'cp.id_producto = mv.id_producto', 'inner');
    $this->db->where('mv.apiestado', 'COMANDA');
    $this->db->where('mv.id_mesa', $id_mesa);
    $this->db->where('mv.usucre', $nombre_usuario);
    $this->db->order_by('mv.id_venta');
    $query = $this->db->get();
    return $query->result();
  }
  // FIN GAN-MS-M4-0529, 03/07/2023 ILaquis.

  // GAN-MS-M3-0531, 13/07/2023 ILaquis.
  public function actualizar_mov_movimiento($id_usuario) {
    $this->db->select('login, id_proyecto');
    $this->db->from('seg_usuario');
    $this->db->where('id_usuario', $id_usuario);
    $usuario = $this->db->get()->result();
    $nombre_usuario = '';
    $id_ubicacion = '';
    if (!empty($usuario)) {
      $nombre_usuario = $usuario[0]->login;
      $id_ubicacion = $usuario[0]->id_proyecto;
    }
    // Obtenemos el lote pendiente
    $lote_pendiente = $this->get_lote_pendiente($id_usuario);
    $id_productos = array();
    $cantidad_pendiente = array();
    $id_lote = 0;
    // Recorremos los objetos en el array y almacenamos los id_productos
    foreach ($lote_pendiente as $objeto) {
      $id_productos[] = $objeto->id_producto;
      $cantidad_pendiente[] = $objeto->cantidad;
      $id_lote = $objeto->id_lote;
    }
    // Cantidades del inventario
    $cantidades = $this->get_cantidad_mov_inventario($id_ubicacion, $id_productos);

    // Modificamos mov_movimiento
    $length = count($id_productos);
    for ($i = 0; $i < $length; $i++) {
      $id_producto = $id_productos[$i];
      $cantidad = $cantidades[$i] - $cantidad_pendiente[$i];
      $this->set_id_lote_mov_movimiento($id_lote, $cantidad, $id_ubicacion, $id_producto, $nombre_usuario);
      $this->set_cantidad_mov_inventario($cantidad, $id_ubicacion, $id_producto, $nombre_usuario);
    }
    return $cantidad_pendiente;
  }

  public function get_lote_pendiente($id_usuario) {
    $this->db->select('login');
    $this->db->from('seg_usuario');
    $this->db->where('id_usuario', $id_usuario);
    $usuario = $this->db->get()->result();
    $nombre_usuario = '';
    if (!empty($usuario)) {
      $nombre_usuario = $usuario[0]->login;
    }

    $this->db->select('mv.id_producto, mv.cantidad, mv.id_lote');
    $this->db->from('mov_venta mv');
    $this->db->where('mv.apiestado', 'PENDIENTE');
    $this->db->where('mv.id_mesa IS NULL');
    $this->db->where('mv.usucre', $nombre_usuario);
    $this->db->order_by('mv.id_producto');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_cantidad_mov_inventario($id_ubicacion, $id_productos) {
    $this->db->select('mi.cantidad');
    $this->db->from('mov_inventario mi');
    $this->db->where('mi.apiestado', 'ELABORADO');
    $this->db->where('mi.id_ubicacion', $id_ubicacion);
    $this->db->where_in('mi.id_producto', $id_productos);
    $query = $this->db->get()->result();

    $cantidades = array();
    foreach ($query as $objeto) {
      $cantidades[] = $objeto->cantidad;
    }

    return $cantidades;
  }

  public function set_id_lote_mov_movimiento($id_lote, $cantidad, $id_ubicacion, $id_producto, $usucre) {
    $data = array(
      'id_lote' => $id_lote,
      'cantidad_destino' => $cantidad,
      'usumod' => $usucre,
      'fecmod' => date('Y-m-d H:i:s'),
      'apiestado' => 'ELABORADO'
    );
    $this->db->where('id_lote is null');
    $this->db->where('apiestado', 'LISTADO');
    $this->db->where('id_producto', $id_producto);
    $this->db->where('ubi_ini', $id_ubicacion);
    $this->db->where('usucre', $usucre);
    $this->db->update('mov_movimiento', $data);
  }

  public function set_cantidad_mov_inventario($cantidad, $id_ubicacion, $id_producto, $usucre) {
    $data = array(
      'cantidad' => $cantidad,
      'fecmod' => date('Y-m-d H:i:s'),
      'usumod' => $usucre,
    );
    $this->db->where('apiestado', 'ELABORADO');
    $this->db->where('id_producto', $id_producto);
    $this->db->where('id_ubicacion', $id_ubicacion);
    $this->db->where('usucre', $usucre);
    $this->db->update('mov_inventario', $data);
  }
  // FIN GAN-MS-M3-0531, 13/07/2023 ILaquis.
}
