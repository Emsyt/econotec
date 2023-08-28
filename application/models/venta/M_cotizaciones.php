<?php
/*
  Creador: Deivit Pucho Aguilar Fecha:26/09/2022, Codigo:GAN-FR-A1-483
  Descripcion:Se crea el modelo M_cotizaciones.
  ---------------------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha: 28/09/2022,  Codigo:GAN-MS-M6-0014
  Descripcion: Se reemplazo la funcion cambiar_catidad a cambiar_cantidad_cotizacion.
  ---------------------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha: 30/09/2022,  Codigo:GAN-CV-A1-0018
  Descripcion: Se reemplazaron multiples funciones para mov_cotizacion.
  ---------------------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha: 18/10/2022,  Codigo: GAN-MS-M0-0059
  Descripcion: Se la funcion de mostrar nombre y codigo por una funcion propia de cotizacion.
  ---------------------------------------------------------------------------------------------
  Modificado: Jose Daniel Luna Flores fecha 09/11/2022 Codigo: GAN-MS-A0-0095
  Descripcion: Se modifico la funcion mostrar_producto() y mostrar_codigo() para que ya no se 
  visualicen repetidos en el combo box
  ---------------------------------------------------------------------------------------------
  Modificado: Briyan Julio Torrez Vargas  Fecha: 03/02/2023,  Codigo: GAN-MS-B0-0214
  Descripcion: Se adiciono la función get_fecha_validez(), que retorna la fecha_validez desde la bd
*/


class M_cotizaciones extends CI_Model {

  public function contador_pedidos($usr){
    $query = $this->db->query("SELECT COUNT(id_cotizacion) contador_pedido
      FROM mov_cotizacion
      WHERE apiestado = 'RESERVA'
      AND usucre = '$usr' ");
    return $query->row('contador_pedido');
  }
  public function get_datos_producto($id_producto,$observaciones,$fecha_val){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_mostrar_producto_cotizacion($id_usuario,'$id_producto','$observaciones','$fecha_val')");
    return $query->result();
  }
  public function cantidad_producto($id_venta,$cantidad){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cambiar_cantidad_cotizacion($id_venta,$id_usuario,'$cantidad')");
    return $query->result();
  }
  public function verifica_cliente($nit){
    $query = $this->db->query("SELECT * FROM fn_verifica_cliente('$nit'); ");
    return $query->result();
  }
  public function registrar($id,$nit,$razonSocial,$id_ubi){
    $query = $this->db->query("SELECT * FROM fn_registrar_cliente_venta($id,'$razonSocial','$nit',$id_ubi)");
    return $query->result();
  }
  public function delete_pedido($id_venta){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_cotizacion($id_venta,$id_usuario)");  
    return $this->db->affected_rows();
  }
  public function mostrar(){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_mostrar_tabla_cotizacion($id_usuario)");
    return $query->result();
  }
  public function calcular_cambio($id_tipo,$monto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_calcular_cambio($id_tipo,$id_usuario, $monto)");
    return $query->result();
  }
  public function realizar_cobro($tipo,$nit,$obs){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_realizar_cotizacion($tipo,$id_usuario,'$nit','$obs')");
    return $query->result();
  }
  public function mostrar_nit(){

    $query = $this->db->query("SELECT * FROM fn_mostrar_nit()");
    return $query->result();
  }
  public function mostrar_nit_usuario($nit){
    $query = $this->db->query("SELECT * FROM fn_recuperar_cliente_ci($nit)");
    return $query->result();
  }

  public function mostrar_lts_nombre(){
    $query = $this->db->query("SELECT * FROM fn_mostrar_lts_nombre()");
    return $query->result();
  }
  //GAN-MS-M0-0059 18/10/2022 DPucho
  public function mostrar_codigo(){
    //GAN-MS-A0-0095 09/11/2022 JLuna
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * from fn_mostrar_codigo_cotizacion($id_usuario)");
    //FIN GAN-MS-A0-0095 09/11/2022 JLuna
    return $query->result();
  }
  //FIN GAN-MS-M0-0059 18/10/2022 DPucho 
  public function mostrar_nombre($nit){
    $query = $this->db->query("SELECT * FROM fn_recuperar_cliente('$nit');");
    return $query->result();
  }
  //GAN-MS-M0-0059 18/10/2022 DPucho
  public function mostrar_producto(){
    //GAN-MS-A0-0095 09/11/2022 JLuna
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_mostrar_producto_descripcion_cotizacion($id_usuario);");
    //FIN GAN-MS-A0-0095 09/11/2022 JLuna
    return $query->result();
  }
  //FIN GAN-MS-M0-0059 18/10/2022 DPucho
  //GAN-MS-M4-0063 21/10/2020 DPucho
  public function get_datos_nombre($nombre,$observaciones,$fecha_val){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_mostrar_por_nombre_cotizacion($id_usuario,'$nombre','$observaciones','$fecha_val')");
    return $query->result();
  }
  //FIN GAN-MS-M4-0063 21/10/2020 DPucho
  public function get_lst_nota_venta($id_venta,$pagado) {
    $usr= $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_nota_cotizacion($usr,$id_venta,$pagado)");
    return $query->result();
  }
  public function cambiar_precio($id_venta,$monto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cambiar_precio_cotizacion($id_usuario,$id_venta,$monto)");
    return $query->result();
  }
  public function verificar_cambio_precio($id_venta,$monto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verificar_cambio_precio_cotizacion($id_venta,$id_usuario,$monto)");
    return $query->result();
  }
  public function cambio_precio_uni($id_venta,$monto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cambiar_precio_unitario_cotizacion($id_venta,$id_usuario,$monto)");
    return $query->result();
  }
  public function listar_tipos_venta(){
    $query = $this->db->query("SELECT * FROM fn_listar_tipos_venta()");
    return $query->result();
  }
  public function verificar_cambio_precio_total($id_venta,$monto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verificar_cambio_precio_total_cotizacion($id_venta,$id_usuario,$monto)");
    return $query->result();
  }
  public function verifica_cantidad($id_venta,$cantidad){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_verifica_cantidad_cotizacion($id_venta,$id_usuario,$cantidad)");
    return $query->result();
  }

  public function mostrar_stock_total($codigo){
    $query = $this->db->query("SELECT * FROM fn_get_producto_stock('$codigo')");
    return $query->result();
  }
  public function get_fecha_validez(){
    $query = $this->db->query("SELECT * FROM fn_get_fecha_validez()");
    return $query->result();
  }

}
?>
