<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Gabriela Mamani Choquehuanca Fecha:21/07/2022, Codigo: GAN-MS-A1-314,
Descripcion: Se añadio la funcion modificar y registrar;
-------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:28/04/2023, Codigo: 
Descripcion: Se modifico la funcion M_datos_sistema para obtener tambien los datos del servidor de correo desde la db
 */

class M_configuracion extends CI_Model {

  public function M_datos_sistema(){
    $query = $this->db->query("SELECT id_facturacion ,nit,cod_sistema ,cod_ambiente ,cod_modalidad ,cod_emision ,cod_token ,cod_cafc, cafc_ini, cafc_fin, cod_cafc_tasas, cafc_tasas_ini, cafc_tasas_fin, cc.descripcion,
                                    smtp_host ,smtp_port ,smtp_user ,smtp_pass 
                                    FROM cat_facturacion cf,cat_catalogo cc  
                                    WHERE cf.apiestado ilike 'ELABORADO'
                                    and cc.catalogo ='cat_sistema'
                                    and cc.codigo='titulo'");
    return $query->result();
  }
  
  public function M_sucursal_inicial(){
    $query = $this->db->query("SELECT cs.id_sucursal 
                                 FROM cat_sucursal cs 
                                WHERE cs.codigo_sucursal = 0 
                                  AND cs.id_facturacion = (SELECT cf.id_facturacion FROM cat_facturacion cf WHERE cf.apiestado ilike 'ELABORADO')");
    return $query->result();
  }

  public function M_gestionar_sistema($json){
    $idlogin= $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_gestionar_sistema($idlogin,'$json'::JSON)");
    return $query->result();
  }

  public function M_modifcar_crt_pk($crt_filename,$pk_filename){
    $idlogin= $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_modificar_crt_pk ('$idlogin','$crt_filename','$pk_filename');");
    return $query->result();
  }

  public function M_informacion_facturacion($id_sucursal) {
    $query = $this->db->query("SELECT * FROM fn_informacion_facturacion($id_sucursal);");
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

  public function M_registrar_cuis($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_registrar_cuis($id_usuario,'$json'::JSON);");
    return $query->result();
  }

  public function fn_registrar_cufd($json){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_registrar_cufd($id_usuario,'$json'::JSON)");
    return $query->result();
  }

  public function M_datos_iniciales_cuis($id_sucursal){
    $query = $this->db->query("SELECT oc.id_facturacion,
                                      oc.cod_punto_venta,
                                      oc.cod_cuis 
                                 FROM ope_cuis oc 
                                WHERE oc.apiestado ilike 'ELABORADO' 
                                  AND oc.cod_punto_venta = 0 
                                  AND id_facturacion = (SELECT cf.id_facturacion FROM cat_facturacion cf WHERE apiestado ilike 'ELABORADO')
                                  AND id_sucursal = $id_sucursal;");
    return $query->result();
  }

}