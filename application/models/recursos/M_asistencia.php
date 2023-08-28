<?php
/* 
------------------------------------------------------------------------------------------
Creado: Alison Paola Pari Pareja Fecha:03/03/2023, Codigo: GAN-DPR-M6-0335,
Se creo el modelo del sub modulo asistencia y la funcion get_usuario
------------------------------------------------------------------------------------------
 */
class M_asistencia extends CI_Model {
  public function get_usuario()
  {
      $this->db->select('u.id_usuario, u.login,carnet, u.nombre, u.paterno, u.materno, u.direccion, u.telefono, u.correo, u.apiestado, d.abreviatura expedido, ub.descripcion ubicacion');
      $this->db->from('seg_usuario u');
      $this->db->join('cat_departamento d', 'd.id_departamento = u.id_departamento');
      $this->db->join('cat_ubicaciones ub', 'ub.id_ubicacion = u.id_proyecto');
      $this->db->where('u.apiestado', 'ELABORADO');
      $this->db->order_by('u.nombre');
      $query = $this->db->get();
      return $query->result();
  }

}