<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:17/11/2021, GAN-MS-A4-092,
Creacion del Model M_listado_ventas con sus respectivas funciones para la relacion con la base de datos
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:22/03/2022, Codigo:GAN-MS-M6-136
Descripcion: se agrego la funcion get_lst_nota_venta_cotizacion para recuperar la nota de venta
*/
class M_listado_facturas extends CI_Model {

  public function M_reporte_abm_facturas($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_reporte_abm_facturas($id_usuario,'$json'::JSON)");
    return $query->result();
  }


  public function M_nota_credito_debito($idubicacion, $idlote, $usucre) {
    $query = $this->db->query("SELECT * FROM fn_nota_credito_debito($idubicacion, $idlote, '$usucre')");
    return $query->result();
  }

  public function M_registrar_nota_credito_debito($idubicacion, $idlote, $usucre) {
    $query = $this->db->query("SELECT * FROM fn_registrar_nota_credito_debito($idubicacion, $idlote, '$usucre')");
    return $query->result();
  }


  public function M_lts_nota_credito_debito($idlote) {
    $query = $this->db->query("SELECT * FROM fn_lts_nota_credito_debito($idlote)");
    return $query->result();
  }

  public function M_nombre_archivo($idlote) {
    $query = $this->db->query("SELECT of2.archivo FROM ope_factura of2 WHERE of2.id_lote = $idlote");
    return $query->result();
  }

  public function M_cambiar_cantidad_nota_debito($idventa,$cantidad) {
    $query = $this->db->query("SELECT * FROM fn_cambiar_cantidad_nota_debito($idventa,$cantidad)");
    return $query->result();
  }

  public function get_lst_clientes() {
    $query = $this->db->query("SELECT * FROM vw_clientes vc WHERE id_personas <> 0");
    return $query->result();
  }


  public function get_eliminar_venta($idubicacion, $idlote, $usucre) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_venta_completada($id_usuario,$idubicacion, $idlote,'$usucre')");
    return $query->result();
  }

  public function get_cargar_venta($idubicacion, $idlote, $usucre) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cargar_venta($id_usuario,$idubicacion, $idlote,'$usucre')");
    return $query->result();
  }

  public function get_historial_venta($idubicacion, $idlote, $usucre) {
    $query = $this->db->query("SELECT * FROM fn_historial_venta($idubicacion, $idlote, '$usucre')");
    return $query->result();
  }

  public function get_ingresos_ventas($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_ingresos_dia($id_usuario,'$json'::JSON)");
    return $query->result();
  }
  public function get_lst_nota_venta_cotizacion($id_usuario,$id_venta) {
    $query = $this->db->query("SELECT * FROM fn_nota_venta($id_usuario,$id_venta,0)");
    return $query->result();
  }

  




  

  public function eliminar_prod($idventa) {
    $query = $this->db->query("UPDATE ope_nota_credito_debito SET apiestado = 'ANULADO' where id_venta = $idventa");
    return $this->db->affected_rows();
  }



  public function get_codigos_siat($id_usuario){
    // retorna codigo_punto_venta, cuis, cufd, codigo_control
    $query = $this->db->query("SELECT cu.codigo_punto_venta,
                                      cc.cuis,  
                                      cc2.cufd,
                                      cc2.codigo_control,
                                      cc2.direccion
                                  FROM cat_ubicaciones cu 
                                  JOIN cat_cuis cc 
                                  ON cu.codigo_punto_venta = cc.codigo_punto_venta 
                                  JOIN cat_cufd cc2
                                  ON  cc2.codigo_punto_venta = cu.codigo_punto_venta
                                  WHERE cu.id_ubicacion = (
                                                        SELECT id_proyecto 
                                                          FROM seg_usuario 
                                                          WHERE id_usuario=1
                                                        )
                                  AND cc.apiestado ILIKE  'ACTIVO'
                                  AND cc2.apiestado  ILIKE 'ACTIVO'");
    return $query->result();
  }
  public function fn_datos_facturacion(){
    $query = $this->db->query("select * from cat_facturacion;");
    return $query->result();
  }

  public function fn_datos_factura($idlote){
    $query = $this->db->query("select * from ope_factura of2 where id_lote = $idlote");
    return $query->result();
  }

  public function fn_lts_nota_credito_devueltos($idlote) {
    $query = $this->db->query("SELECT * FROM fn_lts_nota_credito_devueltos($idlote)");
    return $query->result();
  }

  public function send_factura($SolicitudServicio, $token){
    $wsdl ="https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionDocumentoAjuste?wsdl";
    // $wsdl ="https://siatrest.impuestos.gob.bo/v2/ServicioFacturacionDocumentoAjuste?wsdl";
    
    $client = new \SoapClient($wsdl, [
      'stream_context' => stream_context_create([
      'http'=> [
      'header' => "apikey: TokenApi $token"
      ]
      ]),

      'cache_wsdl' => WSDL_CACHE_NONE,
      'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
    ]);

    $respons = $client->recepcionDocumentoAjuste($SolicitudServicio);

    return  $respons;
  }

  public function nombre_archivo_xml($id_lote){
    $query = $this->db->query("SELECT archivo,id_lote from ope_factura where id_lote = $id_lote order by feccre desc limit 1");
    return $query->result();
  }

  public function leyenda_activa(){
    $query = $this->db->query("SELECT descripcion  
    from cat_catalogo cc 
   where catalogo ilike 'cat_leyendas_factura' 
     and codigo ilike '620000'
     and apiestado ilike 'elaborado'");
    return $query->result();
  }


  public function datos_cliente($ci_nit){
    $query = $this->db->query("select cp.correo::TEXT,cp.cod_cliente from cat_personas cp where nit_ci ilike '$ci_nit';");
    return $query->result();
  }

  public function save_factura($json){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_registrar_factura($id_usuario,'$json'::JSON)");
    return $query->result();
  }

  // FACTURACION

  public function datos_facturacion(){
    $idlogin = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_datos_facturacion($idlogin)");
    return $query->result();
  }

  public function mostrar_datos_cliente($nit){
    $query = $this->db->query("SELECT * FROM fn_datos_cliente('$nit');");
    return $query->result();
  }

  public function leyenda_factura(){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_leyenda_factura($id_usuario)");
    return $query->result();
  }

  public function M_llaves(){
    $query = $this->db->query("SELECT (select descripcion from cat_catalogo cc where codigo ilike 'privateKey' and catalogo ilike 'cat_firmador') as oprivatekey,
		(select descripcion from cat_catalogo cc where codigo ilike 'PublicKey' and catalogo ilike 'cat_firmador') as opublickey");
    return $query->result();
  }

  public function titulo(){
    $query = $this->db->query("SELECT cc.descripcion as otitulo from cat_catalogo cc where cc.catalogo ilike 'cat_sistema' and cc.codigo ilike 'titulo';");
    return $query->result();
  }

  public function get_parametricas_cmb()
  {
      $query = $this->db->query("SELECT * FROM fn_get_parametricas()");
      return $query->result();
  }
}