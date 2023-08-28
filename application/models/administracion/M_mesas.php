<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Ignacio Laquis Camargo Fecha:30/05/2023, Codigo: GAN-MS-M0-0504,
Descripcion: Creacion del Model M_mesas con sus respectivas funciones para la relacion con la base de datos.
-------------------------------------------------------------------------------------------------------------------------------
*/

class M_mesas extends CI_Model {

  public function insert_mesa($id_ubicacion, $id_usuario, $mesa) {
    $query = $this->db->query("SELECT * FROM fn_registrar_mesa($id_ubicacion, $id_usuario, '$mesa')");
    return $query->result();
  }

  public function get_lst_ubicacion() {
    $this->db->select('id_ubicacion, descripcion');
    $this->db->from('cat_ubicaciones');
    $this->db->order_by('id_ubicacion');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_lst_mesas($id_usuario) {
    $query = $this->db->query("SELECT * FROM fn_listas_mesas($id_usuario)");
    return $query->result();
  }

  public function get_usuario($id_ubicacion) {
    $this->db->select('u.id_usuario, u.login,carnet, u.nombre, u.paterno, u.materno, u.direccion, u.telefono, u.correo, u.apiestado, d.abreviatura expedido, ub.descripcion ubicacion');
    $this->db->from('seg_usuario u');
    $this->db->join('cat_departamento d', 'd.id_departamento = u.id_departamento');
    $this->db->join('cat_ubicaciones ub', 'ub.id_ubicacion = u.id_proyecto');
    $this->db->where('u.apiestado', 'ELABORADO');
    $this->db->where('u.id_proyecto', $id_ubicacion);
    $this->db->order_by('u.nombre');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_datos_mesa($id_usuario, $id_mesa) {
    $query = $this->db->query("SELECT * FROM fn_recuperar_mesa($id_usuario, $id_mesa);");
    return $query->result();
  }

  public function delete_mesa($id_mesa) {
    $query = $this->db->query(" SELECT * FROM fn_eliminar_mesa($id_mesa)");
    return $query->result();
  }

  public function modificar_mesa($id_mesa, $id_ubicacion, $id_usuario, $mesa) {
    $query = $this->db->query("SELECT * FROM fn_modificar_mesa($id_mesa, $id_ubicacion, $id_usuario, '$mesa','ELABORADO')");
    return $query->result();
  }
}
