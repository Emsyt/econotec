<?php
class M_flujo extends CI_Model
{
   public function fn_registrar_ingreso($usuario, $monto, $descripcion, $fecha)
   {
      $query = $this->db->query("SELECT * FROM fn_ingreso_extra($usuario, $monto, $descripcion, $fecha)");
      return $query->result();
   }

   public function fn_registrar_gasto($usuario, $monto, $descripcion, $fecha)
   {
      $query = $this->db->query("SELECT * FROM fn_gasto_extra($usuario, $monto, $descripcion, $fecha)");
      return $query->result();
   }

   public function fn_reporte($id, $fecha)
    {
        $query = $this->db->query("SELECT * FROM fn_listar_flujo($id, $fecha)");
        return $query->result();
    }
}