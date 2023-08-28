<?php
/*
  ------------------------------------------------------------------------------
  Creador: Ayrton Jhonny Guevara Montaño Fecha:19/05/2023, Codigo: GAN-DPR-B5-0478
  Descripcion: Se creo el modelo del submodulo de tickets en el modulo de promociones
  */

class M_ticket extends CI_Model
{
  public function insert_ticket($NInicial,$NFinal,$Rango,$tipo){
    $query = $this->db->query("SELECT * FROM fn_agregar_conf_ticket($NInicial,$NFinal,$Rango,'$tipo')");
    return $query->result();
  }
}
