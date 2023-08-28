<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Gabriela Mamani Choquehuanca Fecha:21/07/2022, Codigo: GAN-MS-A1-314,
Descripcion: Se añadio la funcion modificar y registrar;

 */

class M_control extends CI_Model {

  public function M_datos_sistema(){
    $query = $this->db->query("SELECT * FROM cat_facturacion WHERE apiestado ilike 'ELABORADO'");
    return $query->result();
  }
  
  public function M_gestionar_sistema($json){
    $idlogin= $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_gestionar_sistema($idlogin,'$json'::JSON)");
    return $query->result();
  }

  public function M_informacion_facturacion() {
    $query = $this->db->query("SELECT * FROM fn_informacion_facturacion();");
    return $query->result();
  }

  public function M_registrar_cuis($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_registrar_cuis($id_usuario,'$json'::JSON);");
    return $query->result();
  }

  public function estado_emision(){
    $query = $this->db->query("SELECT cod_emision FROM cat_facturacion WHERE apiestado ilike 'ELABORADO'");
    return $query->result();
  }


  public function M_registrar($codigo_ambiente,$codigo_sistema,$nit,$codigo_modalidad,$cafc_fcv,$cafc_fcvt,$codigo_emision,$token,$apiestado){
    $query = $this->db->query("insert into cat_facturacion (codigo_ambiente,codigo_sistema,nit,codigo_modalidad,cafc_fcv,cafc_fcvt,codigo_emision ,token,apiestado)
    values ($codigo_ambiente,'$codigo_sistema',$nit,$codigo_modalidad,'$cafc_fcv','$cafc_fcvt',$codigo_emision,'$token','$apiestado');");
    return $this->db->affected_rows();
  }

  public function M_modificar($codigo_sistema,$nit,$apiestado,$cafc_fcv,$cafc_fcvt,$codigo_ambiente,$codigo_emision,$token){
    $query = $this->db->query("UPDATE cat_facturacion SET codigo_sistema ='$codigo_sistema' ,nit= '$nit',apiestado = '$apiestado',cafc_fcv='$cafc_fcv',cafc_fcvt='$cafc_fcvt',codigo_ambiente='$codigo_ambiente',codigo_emision=$codigo_emision ,token = '$token' where id_facturacion = $this->id_facturacion");
    return $this->db->affected_rows();
  }

  public function cambio_estado_facuracion($codigo,$estado){
    $id_usuario = $this->session->userdata('id_usuario');
    $fecha = date('Y-m-d H:i:s');
    $query = $this->db->query("SELECT * from fn_estado_factura($id_usuario,$codigo,0,'$estado','$fecha'::timestamp)");
    return $query->result();
  }

  public function get_cufd($punto_venta,$estado){
    $query = $this->db->query("SELECT oc.cod_cufd, oc.id_cufd, oc.feccre, oc.fecven from ope_cufd oc where oc.cod_punto_venta = $punto_venta and oc.apiestado ilike '$estado' and oc.id_facturacion = (select cf.id_facturacion from cat_facturacion cf where apiestado ilike 'ELABORADO')");
    return $query->result();
  }

  public function get_reporte_fac($fechaHoraInicio,$fechaHoraFin,$tipofacturadocumento,$codigodocumentosector) {
    $query = $this->db->query("SELECT * FROM fn_reporte_factura('$fechaHoraInicio','$fechaHoraFin',$tipofacturadocumento,$codigodocumentosector)");
    return $query->result();
}

  public function get_id_evento($idCufdEvento) {
    $query = $this->db->query("SELECT oe.id_evento FROM ope_eventos oe WHERE oe.id_cufd = $idCufdEvento;");
    return $query->result();
  }

  public function fn_facturas_empaquetadas($id_evento,$ids){
    $id_usuario = $this->session->userdata('id_usuario');
    $ids=str_replace('"', '', $ids);
    $query = $this->db->query("SELECT * FROM fn_facturas_empaquetadas($id_usuario,$id_evento,ARRAY$ids);");
    return $query->result();
  }

  public function emision_paquetes($SolicitudServicio,$token) {
    // Servicios para consumir
    $wsdl ="https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionCompraVenta?wsdl";
    // $wsdl ="https://siatrest.impuestos.gob.bo/v2/ServicioFacturacionCompraVenta?wsdl";

    $client = new \SoapClient($wsdl, [
        'stream_context' => stream_context_create([
        'http'=> [
        'header' => "apikey: TokenApi $token"
        ]
        ]),
        'cache_wsdl' => WSDL_CACHE_NONE,
        'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
    ]);

    // =========================================================
    //	Etapa I - Obtención de CUIS - Prueba 2 - wsdl 1
    // =========================================================
    
    $respons = $client->recepcionPaqueteFactura($SolicitudServicio);
    $respons =json_decode(json_encode($respons));


    return json_encode($respons);
  }
  public $id_facturacion = 4;

  public function fn_registrar_cufd($json){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_registrar_cufd($id_usuario,'$json'::JSON)");
    return $query->result();
  }
  public function fechaEvento($estado){
    $query = $this->db->query("SELECT feccre from ope_estado oe where apiestado ilike '$estado'");
    return $query->result();
  }

  public function fn_registrar_evento($idlogin,$json){
    $query = $this->db->query("SELECT * FROM fn_registrar_evento($idlogin,'$json'::JSON)");
    return $query->result();
  }



  

  public function cambio_tipo_estado($tipo){
    $query = $this->db->query("UPDATE cat_facturacion SET cod_estado = $tipo where id_facturacion = $this->id_facturacion");
    return $this->db->affected_rows();
  }




  // FACTURACION

  public function datos_generales_facturacion() {
    $query = $this->db->query("SELECT * FROM fn_datos_facturacion($this->id_facturacion);");
    return $query->result();
  }


  public function datos_facturacion(){
    $idlogin = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_datos_facturacion($idlogin)");
    return $query->result();
  }

  // CORREGIR

  public function M_get_cuis(){
    $idlogin = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT 	(select cf.id_facturacion from cat_facturacion cf where apiestado ilike 'ELABORADO') as id_facturacion,
                                        a.cod_punto_venta, 
                                        a.cod_cuis 
                                  from cat_ubicaciones cu2 
                                  join (
                                          select * 
                                            from ope_cuis oc 
                                          where oc.apiestado ilike 'ELABORADO'
                                            and oc.id_facturacion = (select cf.id_facturacion from cat_facturacion cf where apiestado ilike 'ELABORADO')
                                        ) as a 
                                    on a.cod_punto_venta =  cu2.codigo_punto_venta 
                                    and a.id_ubicacion = cu2.id_ubicacion 
                                  where cu2.id_ubicacion in (
                                                              select su2.id_proyecto 
                                                                  from seg_usuario su2 
                                                              where su2.id_usuario = $idlogin)");
    return $query->result();
  }

  public function eventos($SolicitudEvento,$token) {

    $wsdl ="https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionOperaciones?wsdl";
    // $wsdl ="https://siatrest.impuestos.gob.bo/v2/FacturacionOperaciones?wsdl";
    
    $client = new \SoapClient($wsdl, [
        'stream_context' => stream_context_create([
        'http'=> [
        'header' => "apikey: TokenApi $token"
        ]
        ]),
        'cache_wsdl' => WSDL_CACHE_NONE,
        'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
    ]);
 
    $respons = $client->registroEventoSignificativo($SolicitudEvento);
    if (!$respons) {
        $respons = 'Error 001: Ha ocurrido un error. Comuníquese con el administrador de ECONOTEC.';
    }
    return json_encode($respons);
  }



  public function get_eventos() {
    $query = $this->db->query("SELECT * FROM cat_tipo_eventos where apiestado ilike 'FUERA DE LINEA'");
    return $query->result();
  }

  

  public function cod_estado(){
    $query = $this->db->query("SELECT cod_estado from cat_facturacion where id_facturacion = $this->id_facturacion ");
    return $query->result();
  }

  public function lts_sistema(){
    $query = $this->db->query("SELECT * FROM cat_facturacion where id_facturacion = $this->id_facturacion");
    return $query->result();
  }


  public function get_codigos_siat(){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("select cu.codigo_punto_venta,
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
                                  AND cc.id_facturacion =  $this->id_facturacion
                                  AND cc2.id_facturacion =  $this->id_facturacion");
    return $query->result();
  }

  public function fn_datos_facturacion(){
    $query = $this->db->query("select * from cat_facturacion  where id_facturacion = $this->id_facturacion;");
    return $query->result();
}

}