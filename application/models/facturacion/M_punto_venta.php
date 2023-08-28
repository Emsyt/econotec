<?php
class M_punto_venta extends CI_Model {

    public function M_listar_sucursales_activos() {
        $query = $this->db->query("SELECT * FROM fn_listar_sucursal_activos();");
        return $query->result();
    }
    
    public function M_credenciales_facturacion($codPuntoVenta,$id_sucursal) {
        $query = $this->db->query("SELECT * FROM fn_credenciales_facturacion($codPuntoVenta,$id_sucursal);");
        return $query->result();
    }

    public function M_gestionar_catalogo_facturacion($json){
        $idlogin= $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_gestionar_catalogo_facturacion($idlogin,'$json'::JSON)");
        return $query->result();
    }

    public function M_registrar_estado_evento_inicio($codigopuntoventa, $idfacturacion, $idsucursal, $codigoevento, $descripcion){
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * from fn_registrar_estado_evento($id_usuario,$codigopuntoventa, $idfacturacion, $idsucursal, $codigoevento, '$descripcion')");
        return $query->result();
    }

    public function M_listar_punto_venta($id_sucursal) {
        $query = $this->db->query("SELECT * FROM fn_listar_punto_venta($id_sucursal);");
        return $query->result();
    }

    public function M_informacion_facturacion($id_sucursal) {
        $query = $this->db->query("SELECT * FROM fn_informacion_facturacion($id_sucursal);");
        return $query->result();
    }

    public function M_datos_cuis($codigoPuntoVenta,$idSucursal) {
        $query = $this->db->query("SELECT * FROM fn_datos_cuis($codigoPuntoVenta,$idSucursal);");
        return $query->result();
    }

    public function M_gestionar_punto_venta_existente($json) {
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_gestionar_punto_venta_existente($id_usuario,'$json'::JSON);");
        return $query->result();
    }  

    public function M_fn_datos_estado_eventos() {
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_datos_estado_eventos($id_usuario);");
        return $query->result();
    }

    public function M_datos_evento($estado, $id_facturacion, $id_sucursal, $cod_punto_venta){
        $query = $this->db->query("SELECT oe.cod_evento, oe.descripcion, oe.feccre, oe.fecmod 
                                    from ope_estado oe 
                                    where oe.apiestado ilike '$estado' 
                                    and oe.id_facturacion = $id_facturacion
                                    and oe.id_sucursal = $id_sucursal
                                    and oe.cod_punto_venta = $cod_punto_venta"
                                );
        return $query->result();
    }

    public function M_registrar_cuis($json) {
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_registrar_cuis($id_usuario,'$json'::JSON);");
        return $query->result();
    }

    public function M_registrar_cufd($json){
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_registrar_cufd($id_usuario,'$json'::JSON)");
        return $query->result();
    }

    public function M_nom_ubicacion($id_ubicacion) {
        $query = $this->db->query("SELECT * FROM fn_get_nom_ubicacion($id_ubicacion);");
        return $query->result();
    }

    public function M_datos_facturacion() {
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_datos_facturacion($id_usuario);");
        return $query->result();
    }

    public function M_datos_cufd($punto_venta,$id_sucursal, $estado){
        $query = $this->db->query("SELECT oc.cod_cufd, oc.id_cufd, oc.feccre, oc.fecven from ope_cufd oc where oc.cod_punto_venta = $punto_venta and oc.id_sucursal = $id_sucursal and oc.apiestado ilike '$estado' and oc.id_facturacion = (select cf.id_facturacion from cat_facturacion cf where apiestado ilike 'ELABORADO')");
        return $query->result();
    }

    public function M_datos_fecha_evento($id_evento){
        $query = $this->db->query("SELECT oe.codigo, oe.fecini, oe.fecfin from ope_eventos oe where id_evento = $id_evento");
        return $query->result();
    }

    function M_validar_paquete($codigoDescripcion,$id_evento){
        $query = $this->db->query("UPDATE ope_eventos SET apiestado  = '$codigoDescripcion' WHERE id_evento = $id_evento;");
        return $this->db->affected_rows();
    }

    function M_validar_empaquetados($codigoRecepcion, $id_evento, $id_facturacion, $id_sucursal, $cod_punto_venta){
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_validar_empaquetados($id_usuario,$id_evento,'$codigoRecepcion', $id_facturacion, $id_sucursal, $cod_punto_venta);");
        return $query->result();
    }      

    public function M_facturas_empaquetadas($id_evento,$ids){
        $id_usuario = $this->session->userdata('id_usuario');
        $ids=str_replace('"', '', $ids);
        $query = $this->db->query("SELECT * FROM fn_facturas_empaquetadas($id_usuario,$id_evento,ARRAY$ids);");
        return $query->result();
    }

    public function M_lts_reporte_facturas($fechaHoraInicio,$fechaHoraFin,$tipofacturadocumento,$codigodocumentosector, $id_facturacion, $id_sucursal, $codigo_punto_venta) {
        $query = $this->db->query("SELECT * FROM fn_reporte_factura('$fechaHoraInicio','$fechaHoraFin', $tipofacturadocumento, $codigodocumentosector, $id_facturacion, $id_sucursal, $codigo_punto_venta)");
        return $query->result();
    }


    public function M_registrar_evento($json){
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_registrar_evento($id_usuario,'$json'::JSON)");
        return $query->result();
    }

    public function M_eliminar_ubicacion_punto_venta($id_ubicacion) {
        $query = $this->db->query("SELECT * FROM fn_eliminar_ubicacion_punto_venta($id_ubicacion);");
        return $query->result();
    }

    public function M_registrar_ubicacion_punto_venta($id_ubi,$id_sucursal,$codigo) {
        $query = $this->db->query("SELECT * FROM fn_registrar_punto_venta_ubicacion($id_ubi,$id_sucursal,$codigo);");
        return $query->result();
    }

    public function get_ubicacion($id_ubicacion) {
        $query = $this->db->query("SELECT * FROM fn_get_ubicacion($id_ubicacion);");
        return $query->result();
    }

    public function registrar_cuis($json) {
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_registrar_cuis($id_usuario,'$json'::JSON);");
        return $query->result();
    }
  
    public function M_registrar_punto_venta($codpuntoventa,$cod_tipo,$id_facturacion,$idsucursal,$descripcion,$nombre) {
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_registrar_punto_venta($id_usuario,$codpuntoventa,$cod_tipo,$id_facturacion,$idsucursal,'$descripcion','$nombre')");
        return $query->result();
    }

    public function listar_punto_venta_ubicaciones() {
        $query = $this->db->query("SELECT * FROM fn_listar_punto_venta_ubicaciones();");
        return $query->result();
    }

    public function M_generar_lista_actividades($id_facturacion, $id_sucursal, $cod_punto_venta) {
        $query = $this->db->query("SELECT * FROM fn_lista_actividades_facturacion($id_facturacion, $id_sucursal, $cod_punto_venta);");
        return $query->result();
    }
    
    public function eliminar_punto_venta($id_facturacion,$cod_punto_venta, $id_sucursal) {
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_eliminar_punto_venta($id_usuario,$id_facturacion,$cod_punto_venta, $id_sucursal);");
        return $query->result();
    }

    public function M_agregar_actividad($json) {
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_agregar_actividad($id_usuario,'$json'::JSON);");
        return $query->result();
    }      

    public function listar_tipo_venta() {
        $query = $this->db->query("SELECT * FROM fn_listar_tipo_venta();");
        return $query->result();
    }

    public function listar_ubicaciones() {
        $query = $this->db->query("SELECT * FROM fn_listar_ubicaciones_libres();");
        return $query->result();
    }        
}
