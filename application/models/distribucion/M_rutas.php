
<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Dotnara Isabel condori Condori Fecha:12/05/2023, Codigo:GAN-MS-B1-0463
  Descripcion: se creo el controlador de Rutas que contiene un dropdown con 
  distribuidores y un mapa
  ------------------------------------------------------------------------------
     Modificado: Alison Paola Pari Pareja Fecha:18/05/2023, Codigo:GAN-MS-A1-0481
  Descripcion: Se creo la funcion M_fn_listar_clientes_distribuidor para listar 
  la ubicacion geografica y estado de acuerdo a la ubicacion enviada
------------------------------------------------------------------------------ 
*/
class M_rutas extends CI_Model {

  public function get_listar_distribuidores($id_usuario){
    $query = $this->db->query("SELECT * FROM fn_listar_distribuidores($id_usuario)");
    return $query->result();
  }
  public function M_fn_listar_clientes_distribuidor($id_ubicacion){
    $query = $this->db->query("SELECT * FROM fn_listar_clientes_distribuidor($id_ubicacion);");
    return $query->result();
  }
  public function M_fn_ruta_cobrar($id_lote){
    $query = $this->db->query("SELECT * FROM fn_ruta_cobrar($id_lote);");
    return $query->result();
  }
}
