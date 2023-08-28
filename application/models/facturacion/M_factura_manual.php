<?php
/*
    Creador: Alison Paola Pari Fecha:07/06/2022, facturacion
    Descripcion:Se creo y modifico el modeloa semejanza del modelo M_pedido_codigo 
    para realizar el registro de facturas manuales
  ------------------------------------------------------------------------------

*/
class M_factura_manual extends CI_Model {

  public function M_llaves(){
    $query = $this->db->query("SELECT (select descripcion from cat_catalogo cc where codigo ilike 'privateKey' and catalogo ilike 'cat_firmador') as oprivatekey,
		(select descripcion from cat_catalogo cc where codigo ilike 'PublicKey' and catalogo ilike 'cat_firmador') as opublickey");
    return $query->result();
  }

  public function get_parametricas_cmb()
  {
      $query = $this->db->query("SELECT * FROM fn_get_parametricas()");
      return $query->result();
  }
  
  public function cod_estado(){
    $query = $this->db->query("SELECT cod_emision as cod_estado from cat_facturacion where apiestado = 'ELABORADO'");
    return $query->result();
  }

  public function titulo(){
    $query = $this->db->query("SELECT cc.descripcion as otitulo from cat_catalogo cc where cc.catalogo ilike 'cat_sistema' and cc.codigo ilike 'titulo';");
    return $query->result();
  }

  public $id_facturacion = 4;
  public function contador_pedidos($usr){
    $query = $this->db->query("SELECT COUNT(id_venta) contador_pedido
      FROM mov_venta
      WHERE apiestado = 'RESERVA'
      AND usucre = '$usr' ");
    return $query->row('contador_pedido');
  }
  public function get_datos_producto($id_producto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_mostrar_producto($id_usuario,'$id_producto')");
    return $query->result();
  }
  public function cantidad_producto($id_venta,$cantidad){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cambiar_cantidad($id_venta,$id_usuario,'$cantidad')");
    return $query->result();
  }
  public function verifica_cliente($nit){
    $query = $this->db->query("SELECT * FROM fn_verifica_cliente('$nit'); ");
    return $query->result();
  }
  public function registrar($id,$nit,$razonSocial,$complemento,$codigoExcepcion,$docs_identidad){
    $query = $this->db->query("SELECT * FROM fn_registrar_cliente_venta($id,'$razonSocial','$nit', '$complemento', $codigoExcepcion, $docs_identidad)");
    return $query->result();
  }
  public function delete_pedido($id_venta){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_venta($id_venta,$id_usuario)");  
    return $this->db->affected_rows();
  }
  public function mostrar(){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_mostrar_tabla($id_usuario)");
    return $query->result();
  }
  public function calcular_cambio($id_tipo,$monto,$descuento){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_calcular_cambio($id_tipo,$id_usuario, $monto,$descuento)");
    return $query->result();
  }
  public function realizar_cobro($tipo,$nit){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_realizar_cobro ($tipo,$id_usuario,'$nit')");
    return $query->result();
  }
  public function mostrar_nit(){
    $query = $this->db->query("SELECT nit_ci 
                                 FROM cat_personas cp 
                                WHERE id_catalogo IN
                                      (
                                      SELECT id_catalogo FROM cat_catalogo cc WHERE catalogo = 'cat_personas' AND  codigo='CLI'
                                      )
                                  AND apiestado LIKE 'ELABORADO'
                                  ");

    return $query->result();
  }
  public function mostrar_nit_usuario($nit){
    $query = $this->db->query("SELECT * FROM fn_recuperar_cliente_ci($nit)");
    return $query->result();
  }
  public function mostrar_lts_nombre(){
    $query = $this->db->query("SELECT * FROM vw_clientes");
    return $query->result();
  }
  public function mostrar_codigo(){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT cp.codigo from cat_producto cp
    join (select distinct id_producto from mov_provision where apiestado<>'ANULADO'
    and id_ubicacion in (select id_ubicacion
                                      from cat_ubicaciones cu
                                     where id_relacion = (select case when id_relacion=0 then id_ubicacion  else id_relacion end
                                                            from cat_ubicaciones
                                                           where id_ubicacion =(select id_proyecto from seg_usuario where id_usuario=$id_usuario ))
                                      or id_ubicacion =(select case when id_relacion=0 then id_ubicacion  else id_relacion end
                                                          from cat_ubicaciones
                                                         where id_ubicacion =(select id_proyecto from seg_usuario where id_usuario=$id_usuario))
                                                       )
                           ) mp on cp.id_producto =mp.id_producto
    join mov_inventario mi on cp.id_producto = mi.id_producto
    where cp.apiestado <>'ELIMINADO'
    and mi.id_ubicacion = (SELECT id_proyecto FROM seg_usuario WHERE id_usuario = $id_usuario)
    and mi.cantidad >0;");
    return $query->result();
  }
  public function mostrar_nombre($nit){
    $query = $this->db->query("SELECT * FROM fn_recuperar_cliente('$nit');");
    return $query->result();
  }
  
  public function mostrar_complemento($nit){
    $query = $this->db->query("SELECT * FROM fn_recuperar_complemento('$nit');");
    return $query->result();
  }
  public function mostrar_producto(){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query(
    "SELECT cp.descripcion from cat_producto cp
    join (select distinct id_producto from mov_provision where apiestado<>'ANULADO'
    and id_ubicacion in (select id_ubicacion
                                      from cat_ubicaciones cu
                                     where id_relacion = (select case when id_relacion=0 then id_ubicacion  else id_relacion end
                                                            from cat_ubicaciones
                                                           where id_ubicacion =(select id_proyecto from seg_usuario where id_usuario=$id_usuario ))
                                      or id_ubicacion =(select case when id_relacion=0 then id_ubicacion  else id_relacion end
                                                          from cat_ubicaciones
                                                         where id_ubicacion =(select id_proyecto from seg_usuario where id_usuario=$id_usuario))
                                                       )
                           ) mp on cp.id_producto =mp.id_producto
    join mov_inventario mi on cp.id_producto = mi.id_producto
    where cp.apiestado <>'ELIMINADO'
    and mi.id_ubicacion = (SELECT id_proyecto FROM seg_usuario WHERE id_usuario = $id_usuario)
    and mi.cantidad >0;");
    return $query->result();
  }
  public function get_datos_nombre($nombre){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_mostrar_por_nombre($id_usuario,'$nombre')");
    return $query->result();
  }
  public function get_lst_nota_venta($id_venta,$pagado) {
    $usr= $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_nota_venta($usr,$id_venta,$pagado)");
    return $query->result();
  }
  public function cambiar_precio($id_venta,$monto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cambiar_precio($id_usuario,$id_venta,$monto)");
    return $query->result();
  }
  public function verificar_cambio_precio($id_venta,$monto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verificar_cambio_precio($id_venta,$id_usuario,$monto)");
    return $query->result();
  }
  public function cambio_precio_uni($id_venta,$monto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cambiar_precio_unitario($id_venta,$id_usuario,$monto)");
    return $query->result();
  }
  public function listar_tipos_venta(){
    $query = $this->db->query("SELECT * FROM fn_listar_tipos_venta()");
    return $query->result();
  }
  public function verificar_cambio_precio_total($id_venta,$monto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verificar_cambio_precio_total($id_venta,$id_usuario,$monto)");
    return $query->result();
  }
  public function verifica_cantidad($id_venta,$cantidad){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verifica_cantidad($id_venta,$id_usuario,$cantidad)");
    return $query->result();
  }
  public function datos_factura($id_facturacion){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM cat_facturacion WHERE id_facturacion = $id_facturacion");
    return $query->result();
  }

  public function get_cuis($id_punto_venta){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT cuis FROM cat_cuis cc WHERE codigo_punto_venta = $id_punto_venta and apiestado = 'ACTIVO'");
    return $query->result();
  }
  public function save_factura($json){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_registrar_factura($id_usuario,'$json'::JSON)");
    return $query->result();
  }

  public function get_cufd($id_facturacion){
    $query = $this->db->query("SELECT cufd FROM cat_cufd WHERE id_facturacion = $id_facturacion and apiestado = 'ACTIVO'");
    return $query->result();
  }
  public function get_codigo_control($id_facturacion){
    $query = $this->db->query("SELECT codigo_control FROM cat_cufd WHERE id_facturacion = 2 and apiestado = 'ACTIVO'");
    return $query->result();
  }

  public function count_facturas(){
    $query = $this->db->query("SELECT count(*) FROM cat_factura");
    return $query->result();
  }


  public function get_eventos() {
    $usuario = $this->session->userdata('usuario');
    $query = $this->db->query("SELECT cte2.evento||'  '||oe.fecini||' / '||oe.fecfin as evento,oe.id_evento,oe.feccre  from ope_eventos oe join cat_tipo_eventos cte2 on oe.id_tipo_evento =cte2.id_tipo_evento where oe.usucre ilike '$usuario' AND oe.apiestado = 'ELABORADO' AND oe.id_tipo_evento in (5,6,7) order by oe.id_evento desc");
    return $query->result();
  }
  public function get_codigos_siat($id_usuario){
    $query = $this->db->query("SELECT cu.codigo_punto_venta,
                                      cc.cod_cuis,  
                                      cc2.cod_cufd,
                                      cc2.cod_control,
                                      cc2.direccion
                                  FROM cat_ubicaciones cu 
                                  JOIN ope_cuis cc 
                                  ON cu.codigo_punto_venta = cc.cod_punto_venta 
                                  JOIN ope_cufd cc2
                                  ON  cc2.cod_punto_venta = cu.codigo_punto_venta
                                  WHERE cu.id_ubicacion = (
                                                        SELECT id_proyecto 
                                                          FROM seg_usuario 
                                                          WHERE id_usuario=$id_usuario
                                                        )
                                  AND cc.apiestado ILIKE  'ELABORADO'
                                  AND cc2.apiestado  ILIKE 'ACTIVO'
                                  and cc.id_facturacion = (select cf.id_facturacion from cat_facturacion cf where apiestado ilike 'ELABORADO')
                                  and cc2.id_facturacion = (select cf.id_facturacion from cat_facturacion cf where apiestado ilike 'ELABORADO')");
    return $query->result();
  }
  public function get_datos_cufd($id_evento) {
    $usuario = $this->session->userdata('usuario');
    $query = $this->db->query("SELECT cc.cufd,cc.codigo_control,oe.fechatemp,oe.fecini from ope_eventos oe join cat_cufd cc on oe.id_cufd =cc.id_cufd where id_evento =$id_evento and oe.usucre ilike '$usuario' " );
    return $query->result();
  }
  public function fn_datos_facturacion(){
    $query = $this->db->query("select * from cat_facturacion;");
    return $query->result();
  }
  

  public function nro_factura($id_venta){
    $query = $this->db->query("SELECT id_lote FROM mov_venta mv WHERE id_venta = $id_venta;");
    return $query->result();
  }
    
    public function lts_metodo_pago(){
    $query = $this->db->query("select codigo, descripcion from cat_catalogo cc where catalogo ilike 'cat_tipos_ventas' and apiestado ilike 
    'elaborado'");
    return $query->result();
  }
  public function lts_docs_identidad(){
    $query = $this->db->query("select codigo, descripcion  from cat_catalogo cc where catalogo ilike 'cat_docs_identidad' and apiestado ilike 
    'elaborado'");
    return $query->result();
  }
  
public function id_venta($login){
    $query = $this->db->query("SELECT id_venta from mov_venta
    where usucre ilike '$login'
    and apiestado ilike 'pendiente'
    order by feccre desc limit 1 ");
    return $query->result();
  }

  public function datos_venta($json){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_datos_venta($id_usuario,'$json'::JSON)");
    return $query->result();
  }

  public function MetodoPago($MetodoPago){
    $query = $this->db->query("SELECT codigo FROM cat_catalogo cc where cc.id_catalogo = $MetodoPago");
    return $query->result();
  }

  public function leyenda_factura(){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_leyenda_factura($id_usuario)");
    return $query->result();
  }

  public function leyenda_activa(){
    $query = $this->db->query("SELECT descripcion  
    from cat_catalogo cc 
   where catalogo ilike 'cat_leyendas_factura' 
     and apiestado ilike 'elaborado'");
    return $query->result();
  }
  
  public function datos_cliente($ci_nit){
    $query = $this->db->query("select (COALESCE(cp.nombre_rsocial,'')||
                                      CASE WHEN cp.apellidos_sigla IS NULL THEN '' ELSE ' '||cp.apellidos_sigla END) nombre_rsocial, 
                                      cp.correo::TEXT,
                                      cp.cod_cliente 
                                 from cat_personas cp where nit_ci ilike '$ci_nit';");
    return $query->result();
  }

  public function cod_cliente($ci_nit){
    $query = $this->db->query("SELECT cod_cliente from cat_personas cp where nit_ci ilike '$ci_nit'");
    return $query->result();
  }

  public function obtener_cufd($id_evento, $id_facturacion, $id_sucursal, $cod_punto_venta){
    $query = $this->db->query("SELECT oe.id_cufd, oe.fechatemp from ope_eventos oe where oe.id_evento = $id_evento and oe.id_facturacion = $id_facturacion and oe.id_sucursal = $id_sucursal and oe.cod_punto_venta = $cod_punto_venta");
    return $query->result();
  }

  public function M_fn_datos_estado_eventos() {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_datos_estado_eventos($id_usuario);");
    return $query->result();
  }


  // FACTURACION
  public function datos_facturacion(){
    $idlogin = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_datos_facturacion($idlogin)");
    return $query->result();
  }

  public function M_datos_facturacion() {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_datos_facturacion($id_usuario);");
    return $query->result();
}

  public function datos_generales_facturacion() {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_datos_facturacion($id_usuario,(select cf.id_facturacion from cat_facturacion cf where apiestado ilike 'ELABORADO'));");
    return $query->result();
  }
  public function mostrar_cod_excepcion($nit){
    $query = $this->db->query("SELECT * FROM fn_recuperar_codigo_excepcion('$nit');");
    return $query->result();
  }


  // CORREGIR
  public function obtener_codigo_control($id_cufd, $id_facturacion, $id_sucursal, $cod_punto_venta){
    $query = $this->db->query("SELECT cc.cod_cufd, cc.cod_control from ope_cufd cc where cc.id_cufd = $id_cufd and cc.id_facturacion = $id_facturacion and cc.id_sucursal = $id_sucursal and cc.cod_punto_venta = $cod_punto_venta");
    return $query->result();
  }

  public function guardar_fechatemp($fechatemp,$id_evento) {
    $usuario = $this->session->userdata('usuario');
    $query = $this->db->query("UPDATE ope_eventos SET fechatemp = '$fechatemp' WHERE id_evento = $id_evento");
    return $this->db->affected_rows();
  }

  public function rsocial_emisor(){
    $query = $this->db->query("SELECT descripcion FROM cat_catalogo cc WHERE catalogo ilike 'cat_sistema' AND codigo ilike 'razon_social'");
    return $query->result();
  }

  public function mostrar_datos_cliente($nit){
    $query = $this->db->query("SELECT * FROM fn_datos_cliente('$nit');");
    return $query->result();
  }
  
}
?>
