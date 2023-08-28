
<?php
/*
  ------------------------------------------------------------------------------
  Creado: Luis Fabricio Pari Wayar   Fecha:19/10/2022, Codigo:GAN-DPR-M6-0060
  Descripcion: Se creo el Modelo de "envio de productos" 
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Agurire Fecha:10/02/2023, Codigo: GAN-MS-B0-0254
  Descripcion: se agrego get_lst_ubicacion que devuelve una lista de ubicaciones
  menos la que es del usuario logueado.
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha: 18/05/2023, Codigo: GAN-MS-B1-0477
  Descripcion: Se realizo el mantenimiento de todo este modelo para que el sub modulo Envio de productos funcione.
*/
class M_envio extends CI_Model
{

  public function get_lst_solicitud($login,$id_ubicacion){
    $query = $this->db->query("SELECT * FROM fn_listar_envio($login,$id_ubicacion);");
    return $query->result();
  }
  // INICIO Oscar L., GAN-MS-B0-0254 
  public function get_lst_ubicacion($login,$id_ubicacion){
    $query = $this->db->query("SELECT * FROM fn_listar_ubicaciones_provision($id_ubicacion)");
    return $query->result();
  }
  // FIN GAN-MS-B0-0254 
  // GAN-MS-B1-0471, 17/05/2023 ILaquis.
  public function get_producto_cmb($id_ubicacion){
    $query = $this->db->query("select * FROM fn_productos_ubicacion($id_ubicacion);");
    return $query->result();
  }
  // FIN GAN-MS-B1-0471, 17/05/2023 ILaquis.

  public function get_cantidad_almacen($id_ubicacion,$id_movimiento){
    $query = $this->db->query("SELECT * FROM fn_cantidad_producto_ubicacion($id_movimiento,$id_ubicacion); ");
    return $query->result();
  }

  public function contador_solicitudes($login,$id_ubicacion){
    $query = $this->db->query("SELECT COUNT(id_movimiento) contador_solicitud
      FROM mov_movimiento 
      WHERE apiestado = 'SOLICITUD'
      AND usucre = '$login'
      AND ubi_fin = $id_ubicacion ");
    return $query->row('contador_solicitud');
  }

  public function insert_solicitud($id_mod,$id_usuario,$json){
    $query = $this->db->query("SELECT * FROM fn_registrar_envio($id_mod,$id_usuario,'$json'::JSON)");
    return $query->result();
  }

  public function confirmar_solicitud($id_usuario,$fec_entrega,$sel_ubi){
    $query = $this->db->query("SELECT * FROM fn_confirmar_envio($id_usuario,'$fec_entrega',$sel_ubi);");
    return $query->result();
  }

  public function delete_solicitud($id_usuario,$id_prod){
    $query = $this->db->query("SELECT * FROM fn_eliminar_solicitud($id_usuario,$id_prod); ");
    return $query->result();
  }

  // GAN-MS-B1-0477, 22/05/2023 ILaquis.
  public function lista_lotes_solicitudes($login){
    $query = $this->db->query("SELECT * FROM fn_lista_lotes_solicitudes($login);");
    return $query->result();
  }

  public function get_conf_solicitud($id_lote){
    $query = $this->db->query("SELECT * FROM fn_listar_lote_pedidos($id_lote);");
    return $query->result();
  }
  public function aceptar_lote($id_usuario,$array,$array2, $id_transporte,$fecha){
    $query = $this->db->query("SELECT * FROM fn_confirmar_lote_pedidos2($id_usuario,ARRAY$array,ARRAY$array2,$id_transporte,'$fecha');");
    return $query->result();
  }

  public function confirmar_cambio($array, $array2){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT *FROM fn_actualizar_inventario_envio($id_usuario,ARRAY$array,ARRAY$array2)");
    return $query->result();
  }
  // FIN GAN-MS-B1-0477, 22/05/2023 ILaquis.
}
