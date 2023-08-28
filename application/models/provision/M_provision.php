<?php 
/*------------------------------------------------------------------------------
  Modificado: Maribel Teran Arispe Fecha:28/05/2021, Codigo:GAM-023
  Descripcion: en la funcion get_producto_cmb se modifica el query por el del adjunto solucion3.sql
   ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos  Fecha:28/06/2021, Codigo:GAM-030
  Descripcion: Se modifico el formulario para mostrar el precio de venta
  ------------------------------------------------------------------------------
  Modificado: Blanca Sinka Colmena Fecha:29/06/2021, Codigo: ECOGAN-MS-M4-033,
  Descripcion: Se modifico la función get_lst_compra para adicionar la columna destino
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:11/11/2021, Codigo: GAN-MS-A6-083,
  Descripcion: Se modifico al modulo de ECOGAN , ABASTECIMIENTO para recuperar
              los valores de precios de compra y de venta de acuerdo a lo 
              explicado en la reunion
  ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:14/04/2021, Codigo: GAN-MS-A0-156,
  Descripcion: Se modifico la funcion insert_provision , para poder insertar un producto con la 
  funcion dada fn_registrar_abastecimiento
  ------------------------------------------------------------------------------
  Modificado: Daniel Castillo Quispe   Fecha:12/05/5055, Codigo: GAN-SC-A4-232,
  Descripcion: Se ha agregó el insert de una notificación cuando se realiza la confirmación
               de un abastecimiento.
  ------------------------------------------------------------------------------
  Modificado: Kevin Mauricio Larrazabal Calle Fecha:23/08/2022, Codigo: GAN-SC-M3-369,
  Descripcion: Se cambio Query de la funcion confirmar_provision por funcion de postgresql 
    ------------------------------------------------------------------------------
  Modificado: Kevin Mauricio Larrazabal Calle Fecha:25/08/2022, Codigo: GAN-MS-A1-386,
  Descripcion: Se cambio Query de la funcion cdelete_provision por funcion de postgresql fn_delete_provision
  ------------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma Fecha:26/09/2022, Codigo: GAN-SC-A1-484,
  Descripcion: Se corrigio el combo de producto para mostrar solo la cantidad de unidades en la ubicacion actual.
    ------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar     Fecha: 29/09/2022    Código: GAN-SC-M3-0015
  Descripción: Se modifico la funcion get_producto_cmb para llamar a la funcion del databrach fn_get_producto_compra
  ----------------------------------------------------------------------------------------
  Modificado: Jose Daniel Luna Flores  Fecha: 28/11/2022 Codigo:GAN-MS-M6-0140
  Descripcion: Se modifico el modelo de provision para realizar cambios en el query de get_lst_compra()
  ----------------------------------------------------------------------------------------
  Modificado: Kevin Gerardo Alcon Lazarte  Fecha: 28/11/2022 Codigo:GAN-DPR-M1-0373
  Descripcion: Se agregaron las funciones get_edit_fil y editar_fila
  ----------------------------------------------------------------------------------------
  Modificado: Kevin Gerardo Alcon Lazarte  Fecha: 05/04/2023 Codigo:GAN-MS-M4-0391
  Descripcion: Se edito las funciones  get_edit_fil y editar_fila
  ----------------------------------------------------------------------------------------
  Modificado: Ayrton Jhonny Guevara Montaño  Fecha: 26/04/2023 Codigo:GAN-MS-B1-0437
  Descripcion: Se añadio una variable mas a la funcion confirmar_provision
----------------------------------------------------------------------------------------
*/

?>
<?php
class M_provision extends CI_Model {

  public function get_lst_compra($login){
  // BSINKA, 29/06/2021, ECOGAN-MS-M4-033
    //INICIO GAN-MS-M6-0140 J.LUNA 28-11-2022
    $query = $this->db->query("SELECT mp.id_provision, mp.id_lote id_lote, mp.id_producto, cp.descripcion, cu.descripcion destino, mp.cantidad, mp.unidad, 
    (select trim(trailing '0' from ROUND(mp.precio,8)::text)::numeric)::NUMERIC precio, (select trim(trailing '0' from ROUND(mp.precio_venta,8)::text)::numeric)::NUMERIC precio_venta
    FROM mov_provision mp
    JOIN cat_producto cp ON mp.id_producto = cp.id_producto
    JOIN cat_ubicaciones cu ON mp.id_ubicacion = cu.id_ubicacion
    WHERE mp.apiestado = 'SOLICITUD' AND mp.usucre = '$login' AND (cp.apiestado = 'ELABORADO' OR cp.apiestado = 'HABILITADO')
    UNION ALL
        SELECT NULL,null, NULL, 'TOTAL', NULL, SUM(mp.cantidad), 'UNIDAD', (select trim(trailing '0' from ROUND(SUM(mp.precio),8)::text)::numeric)::NUMERIC, 
        (select trim(trailing '0' from ROUND(SUM(mp.precio_venta),8)::text)::numeric)::NUMERIC
        FROM mov_provision mp
        JOIN cat_producto cp ON mp.id_producto = cp.id_producto
        WHERE mp.apiestado = 'SOLICITUD' AND mp.usucre = '$login' AND (cp.apiestado = 'ELABORADO' OR cp.apiestado = 'HABILITADO') ");
    //FIN GAN-MS-M6-0140 J.LUNA 28-11-2022
  // FIN BSINKA, 29/06/2021, ECOGAN-MS-M4-033
    return $query->result();
  }

  public function get_proveedor_cmb(){
    $query = $this->db->query("SELECT * FROM vw_proveedores");
    return $query->result();
  }

  public function get_producto_cmb($id_ubicacion){
    //GAN-SC-M3-0015, 29-09-2022, Luis Fabricio Pari Wayar.
    $query = $this->db->query(" SELECT * FROM fn_get_producto_compra($id_ubicacion)");
    return $query->result();
    //FIN GAN-SC-M3-0015, 29-09-2022, Luis Fabricio Pari Wayar.
  }

  public function get_destino_cmb($id_ubicacion){
    $query = $this->db->query("SELECT * FROM fn_buscar_destino($id_ubicacion)");
    return $query->result();
  }

  public function insert_provision($id_login,$json){
    
    $query = $this->db->query("SELECT * FROM fn_registrar_abastecimiento(0,$id_login,'$json'::JSON)");
    return $query->result();
  }
  public function insert_precios($id_login,$json){
    
    $query = $this->db->query("SELECT * FROM fn_registrar_precios($id_login,'$json'::JSON)");
    return $query->result();
  }

  public function contador_provisiones($login) {
    $query = $this->db->query("SELECT COUNT(id_provision) contador_provision
      FROM mov_provision
      WHERE apiestado = 'SOLICITUD'
      AND usucre = '$login' ");
    return $query->row('contador_provision');
  }

  public function get_precio_total($login){
    $query = $this->db->query("SELECT SUM(precio) precio_total
      FROM mov_provision
      WHERE apiestado='SOLICITUD' AND usucre='$login'");
    return $query->row('precio_total');
  }
  public function recuperar_precio_abastecimiento($login,$prov,$prod){
    
    if($prov!=""){
      $query = $this->db->query("SELECT * from fn_recuperar_precio_abastecimiento($login,$prov,$prod)");
      return $query->result();
    }else{
      $query = $this->db->query("SELECT * from fn_recuperar_precio_abastecimiento($login,null,$prod)");
      return $query->result();
    }
  }

  // KLarrazabal, 23/08/2022, GAN-SC-M3-369
  //Ayrton Guevara M. 26/04/2023 GAN-MS-B1-0437 
  public function confirmar_provision($login, $id_usuario, $id_ubicacion, $precio, $pago){
    $x= "SELECT * FROM fn_confirmar_provision('$login', $id_usuario, $id_ubicacion, $precio)";
    $query = $this->db->query("SELECT * FROM fn_confirmar_provision('$login', $id_usuario, $id_ubicacion, $precio, '$pago')");
    return $query->result();
  }
  //Fin Ayrton Guevara M. 26/04/2023 GAN-MS-B1-0437
  // Fin KLarrazabal, 23/08/2022, GAN-SC-M3-369
  // KLarrazabal, 25/08/2022, GAN-MS-A1-386
   public function delete_provision($id_prov, $data){
    $vData = array_values($data);
    $vapiestado = $vData[0];
    $vusumod = $vData[1];
    $query = $this->db->query("SELECT * FROM fn_delete_provision($id_prov,'$vapiestado','$vusumod')");
    return $query->result();
  }
// FIN KLarrazabal, 25/08/2022, GAN-MS-A1-386
  //Inicio ALKG 05/04/2023 GAN-MS-M4-0391
  //Inicio ALKG 27/03/2023 GAN-DPR-M1-0373
  public function get_edit_fil($id_lote, $id_prov){
    $query = $this->db->query("SELECT * FROM fn_obtener_filas_id_lote($id_lote,$id_prov)");
    return $query->result();
  }
  public function editar_fila($oprovision,$edit_lote,$oproveedor,$oproducto,$ocantidad,$oid_unidad0,$oprecio_compra,$oprecio_venta,$odes_provision,$ofecha_vencimiento){  
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_editar_provision($id_usuario,$oprovision,$edit_lote,$oproveedor,$oproducto,$ocantidad,$oid_unidad0,$oprecio_compra,$oprecio_venta,$odes_provision,'$ofecha_vencimiento'::date)");
    return $query->result();
  }

  //Fin ALKG 27/03/2023 GAN-DPR-M1-0373
  //Fin ALKG 05/04/2023 GAN-MS-M4-0391
}
?>
