<?php
class M_tarea extends CI_Model {
  
  public function listar_clientes(){
    $query = $this->db->query("SELECT * FROM fn_listar_clientes()");
      return $query->result();
  }

  public function get_producto($idlogin){
    $query = $this->db->query("SELECT * FROM fn_listar_productos_ubicacion($idlogin)");
    return $query->result();
  }

  public function listar_empleado(){
    $query = $this->db->query("SELECT * FROM fn_listar_usuarios()");
      return $query->result();
  }
  
  public function fn_registrar_tarea($btnid,$idlogin,$json){
   /* echo "SELECT * FROM fn_registrar_tarea($btnid,$idlogin,'$json'::JSON)"; exit;
   */
    $query = $this->db->query("SELECT * FROM fn_registrar_tarea($btnid,$idlogin,'$json'::JSON)");
    return $query->result();
  }

  public function fn_reporte_tarea()
  {
    $query = $this->db->query("SELECT * FROM fn_reporte_tarea()");
    return $query->result();
  }
  public function fn_datos_tarea($id_actividad)
  {
    $query = $this->db->query("SELECT * FROM fn_recuperar_tarea($id_actividad)");
    return $query->result();
  }
  public function fn_eliminar_tarea($idlogin,$idtarea) {
    $query = $this->db->query("SELECT * FROM fn_eliminar_tarea($idlogin,$idtarea)");
    return $query->result();
}  
  public function fn_calcular_stock($id_producto){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_calcular_stock($id_usuario,$id_producto)");
    return $query->result();
  }
}
