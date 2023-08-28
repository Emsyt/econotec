<?php
/*
  Creador: Heidy Soliz Santos Fecha:20/04/2021, Codigo:SYSGAM-001
  Metodo: contador pedidos 
  Descripcion:Se crea la funcion contador_pedidos para contar los pedidos realizados 
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:27/04/2021, Codigo:SYSGAM-003
  Descripcion:Se modifico para crear la funcion get_datos_producto 
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:30/04/2021, Codigo:SYSGAM-005
  Descripcion:Se modifico cambiar la cantidad con la funcion cantidad_producto  
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:5/05/2021, Codigo:SYSGAM-007
  Descripcion:Se modifico para implementar la  fn_mostrar_tabla en la funcion mostrar
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:06/05/2021, Codigo: SYSGAM-008
  Descripcion:Se modifico para implementar la funcion que calcula el cambio y para realizar la compra
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:8/06/2021, Codigo: GAM-027
  Descripcion: Se modifico para crear la funcion mostrar codigo que devuelve la lista de codigos
   ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:15/06/2021, Codigo: GAM-028
  Descripcion: Se modifico para completar el nombre del producto
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:14/09/2021, Codigo: GAN-MS-A4-028
  Descripcion: Se modifico para crear la funcion  get_lst_nota_venta que devuelve una lista en formato JSON
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:23/09/2021, GAN-MS-A1-033
  Descripcion: Se modifico para crear la funcion  cambiar_precio, tambien se modifico la funcion fn_realizar_cobro donde se modificaron los parámetros de entrada, se agregó el CI
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:05/11/2021, GAN-MS-A4-063
  Descripcion: Se modifico para crear la funcion verifica_cantidad que permite verificar el tamaño del stock del producto.
  ------------------------------------------------------------------------------
   Modificado: Alison Paola Pareja Fecha:20/07/2022, Codigo: GAN-MS-A1-315,
  Descripcion: Se modifico la funcion mostrar_codigo para filtrar por codigo alternativo
  -------------------------------------------------------------------------------
  Modificado: Gabriela Mamani Choquehuanca     Fecha: 09/08/2022    Código: GAN-MS-A1-330
  Descripción: Se modifico la funcion mostrar_codigo  para que ya no se tome en cuanta el atributo id_relacion
  en ningun select de esta , eliminando a id_relacion de la funcion
   -------------------------------------------------------------------------------
  Modificado: Gabriela Mamani Choquehuanca     Fecha: 09/08/2022    Código: GAN-MS-A1-330
  Descripción: Se modifico la funcion mostrar_producto  para que ya no se tome en cuanta el atributo id_relacion
  en ningun select de esta , eliminando a id_relacion de la funcion
  -------------------------------------------------------------------------------
  Modificado: Kevin Mauricio Larrazabal Calle     Fecha: 30/08/2022    Código: GAN-SC-M5-413
  Descripción: Actualizacion de el query mostrar_lts_nombre por funcion de postgres fn_mostrar_lts_nombre()
  ------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar     Fecha: 30/08/2022    Código: GAN-SC-M5-414
  Descripción: Se modifico la funcion mostrar_codigo() para llamar a la funcion del databrach fn_mostrar_codigo
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Pedro Rodrigo Beltran Poma.   Fecha:30/08/2022,   Codigo: GAN-SC-M5-415,
  Descripcion: Se modifico la funcion mostrar_producto cambiando el query por la funcion fn_mostrar_producto_descripcion.
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Denilson Santander Rios.   Fecha:30/08/2022,   Codigo: GAN-SC-M5-412,
  Descripcion: Se modifico la funcion mostrar_nit() por un cambio de query a funcion fn_mostrar_nit().
    ---------------------------------------------------------------------------------------------------------
  Modificado:  Gary German Valverde Quisbert.   Fecha:08/09/2022,   Codigo: GAN-MS-A1-442,
  Descripcion: Se modifico la funcion cambiar_precio() y cambiar_precio_unitario().
  -----------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma fecha 08/09/2022 Codigo :GAN-MS-A1-436
  Descripcion: Se agrego la funcion mostrar_stock_total().
      ---------------------------------------------------------------------------------------------------------
  Modificado:  Gary German Valverde Quisbert.   Fecha:06/10/2022,   Codigo: GAN-MS-M5-0034
  Descripcion: Se modifico las funciones marcadas para que retornen su unidad
  -----------------------------------------------------------------------------
  Modificado: Keyla Paola Usnayo Aguilar fecha 11/10/2022 Codigo: GAN-SC-M3-0041
  Descripcion: Se agrego la funcion mostrar_precio_total().
  -----------------------------------------------------------------------------
  Modificado: Alvaro Ruben Gonzales Vilte fecha 18/10/2022 Codigo: GAN-MS-A1-0058
  Descripcion: Se modifico la funcion fn_nota_venta().
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Aguirre Fecha: 10/02/2023 Codigo: GAN-MS-B0-0213
  Descripcion: Se agrego la funcion cambiar_null_a_imagenes_sin_archivos_fisicos().
  ------------------------------------------------------------------------------
  Modificado: Ariel Ramos Paucara     Fecha: 29/03/2023   Codigo: GAN-MS-M0-0379
  Descripcion: Se agrego la funcion get_codigo() y get_descripcion  
*/

class M_pedidoCodigo extends CI_Model
{

  public function contador_pedidos($usr)
  {
    $query = $this->db->query("SELECT COUNT(id_venta) contador_pedido
      FROM mov_venta
      WHERE apiestado = 'RESERVA'
      AND usucre = '$usr' ");
    return $query->row('contador_pedido');
  }
  public function get_datos_producto($id_producto)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    //GAN-MS-M5-0034 06/10/2022 GValverde.
    $query = $this->db->query("SELECT * FROM fn_mostrar_producto_v3($id_usuario,'$id_producto')");
    //fin GAN-MS-M5-0034 06/10/2022 GValverde.
    return $query->result();
  }
  public function cantidad_producto($id_venta, $cantidad)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    //GAN-MS-M5-0034 06/10/2022 GValverde.
    $query = $this->db->query("SELECT * FROM fn_cambiar_cantidad_v2($id_venta,$id_usuario,'$cantidad')");
    //fin GAN-MS-M5-0034 06/10/2022 GValverde.
    return $query->result();
  }
  public function verifica_cliente($nit)
  {
    $query = $this->db->query("SELECT * FROM fn_verifica_cliente('$nit'); ");
    return $query->result();
  }
  public function registrar($id, $nit, $razonSocial,$id_ubi)
  {
    $query = $this->db->query("SELECT * FROM fn_registrar_cliente_venta($id,'$razonSocial','$nit',$id_ubi)");
    return $query->result();
  }
  public function delete_pedido($id_venta)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_venta($id_venta,$id_usuario)");
    return $this->db->affected_rows();
  }
  public function mostrar()
  {
    $id_usuario = $this->session->userdata('id_usuario');
    //GAN-MS-M5-0034 06/10/2022 GValverde.
    $query = $this->db->query("SELECT * FROM fn_mostrar_tabla_v2($id_usuario)");
    //fin GAN-MS-M5-0034 06/10/2022 GValverde.
    return $query->result();
  }
  public function calcular_cambio($id_tipo, $monto)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_calcular_cambio($id_tipo,$id_usuario, $monto)");
    return $query->result();
  }
  public function realizar_cobro($tipo, $nit)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_realizar_cobro($tipo,$id_usuario,'$nit')");
    return $query->result();
  }
  public function mostrar_nit()
  {

    // Denilson Santander Rios, 30/08/2022,GAN-SC-M5-412
    $query = $this->db->query("SELECT * FROM fn_mostrar_nit()");
    return $query->result();
    // FIN Denilson Santander Rios, 30/08/2022,GAN-SC-M5-412
  }
  public function mostrar_nit_usuario($nit)
  {
    $query = $this->db->query("SELECT * FROM fn_recuperar_cliente_ci($nit)");
    return $query->result();
  }
  // KLarrazabal, 30/08/2022, GAN-SC-M5-413
  public function mostrar_lts_nombre()
  {
    $query = $this->db->query("SELECT * FROM fn_mostrar_lts_nombre()");
    return $query->result();
  }
  // KLarrazabal, 30/08/2022, GAN-SC-M5-413
  public function mostrar_codigo()
  {
    //GAN-SC-M5-414, 30-08-2022, Luis Fabricio Pari Wayar.
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * from fn_mostrar_codigo($id_usuario)");
    return $query->result();
    //FIN GAN-SC-M5-414, 30-08-2022, Luis Fabricio Pari Wayar.
  }
  public function mostrar_nombre($nit)
  {
    $query = $this->db->query("SELECT * FROM fn_recuperar_cliente('$nit');");
    return $query->result();
  }
  public function mostrar_producto()
  {
    $id_usuario = $this->session->userdata('id_usuario');
    // GAN-SC-M5-415, 30/08/2022, PBeltran.
    $query = $this->db->query("SELECT * FROM fn_mostrar_producto_descripcion($id_usuario);");
    // FIN GAN-SC-M5-415, 30/08/2022, PBeltran.
    return $query->result();
  }
  public function get_datos_nombre($nombre)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    //GAN-MS-M5-0034 06/10/2022 GValverde.
    $query = $this->db->query("SELECT * FROM fn_mostrar_por_nombre_v3($id_usuario,'$nombre')");
    //fin GAN-MS-M5-0034 06/10/2022 GValverde.
    return $query->result();
  }
  public function get_lst_nota_venta($id_venta, $pagado)
  {
    $usr = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_nota_venta($usr,$id_venta,$pagado)");
    return $query->result();
  }
  public function cambiar_precio($id_venta, $monto)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    //GAN-MS-M5-0034 06/10/2022 GValverde.
    $query = $this->db->query("SELECT * FROM fn_cambiar_precio_v2($id_usuario,$id_venta,$monto)");
    //fin GAN-MS-M5-0034 06/10/2022 GValverde.
    return $query->result();
  }
  public function verificar_cambio_precio($id_venta, $monto)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verificar_cambio_precio($id_venta,$id_usuario,$monto)");
    return $query->result();
  }
  public function cambio_precio_uni($id_venta, $monto)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    //GAN-MS-M5-0034 06/10/2022 GValverde.
    $query = $this->db->query("SELECT * FROM fn_cambiar_precio_unitario_v2($id_venta,$id_usuario,$monto)");
    //GAN-MS-M5-0034 06/10/2022 GValverde.
    return $query->result();
  }
  public function listar_tipos_venta()
  {
    $query = $this->db->query("SELECT * FROM fn_listar_tipos_venta()");
    return $query->result();
  }
  public function verificar_cambio_precio_total($id_venta, $monto)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verificar_cambio_precio_total($id_venta,$id_usuario,$monto)");
    return $query->result();
  }
  public function verifica_cantidad($id_venta, $cantidad)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verifica_cantidad($id_venta,$id_usuario,$cantidad)");
    return $query->result();
  }
  // GAN-MS-A1-436, 08/09/2022, PBeltran
  public function mostrar_stock_total($codigo)
  {
    $query = $this->db->query("SELECT * FROM fn_get_producto_stock('$codigo')");
    return $query->result();
  }
  // FIN GAN-MS-A1-436, 08/09/2022, PBeltran

  // GAN-SC-M3-0041, 07/10/2022, KUsnayo
  public function mostrar_precios_total($codigo)
  {
    $query = $this->db->query("SELECT * FROM fn_recuperar_precios('$codigo')");
    return $query->result();
  }
  // FIN GAN-SC-M3-0041, 07/10/2022, KUsnayo

  // INICIO Oscar L., GAN-MS-B0-0213
  public function cambiar_null_a_imagenes_sin_archivos_fisicos($nombre_img)
  {
    $query = $this->db->query("SELECT public.fn_cambiar_null_a_imagenes_sin_archivos_fisicos('" . $nombre_img . "')");
    $query = intval($query->result()[0]->fn_cambiar_null_a_imagenes_sin_archivos_fisicos);
    return $query;
  }
  //  FIN GAN-MS-B0-0213

  // INICIO Ariel R. GAN-MS-M0-0379
  public function get_codigo($cod)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * from fn_mostrar_codigo_producto($id_usuario,'$cod')");
    return $query->row();
  } 
  public function get_descripcion($cod)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * from fn_mostrar_nombre_producto($id_usuario,'$cod')");
    return $query->row();
  }   
  // FIN Ariel R. GAN-MS-M0-0379
}
