<?php
/*
------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:18/11/2022, GAN-MS-A7-0111,
Creacion del Model M_retorno
------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:18/11/2022   GAN-DPR-A7-0121,
Descripcion: Se crearon las funciones para listado de proveedor y listado de los retornos
------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:09/12/2022   GAN-MS-A5-0177,
Descripcion: Se Realizo y/o modifico el funcionamiento garantia ejecucion, registro y retorno 
considerando ya el numero de serie
*/
class M_retorno extends CI_Model {
    public function get_proveedor_cmb(){
        $query = $this->db->query("SELECT * FROM vw_proveedores");
        return $query->result();
      }
    public function M_get_retorno($id_proveedor){
    $query = $this->db->query("SELECT * FROM fn_listar_retorno($id_proveedor);");
    return $query->result();
    }
    public function M_realizar_retorno($id_lotes){
      $id_usuario=$this->session->userdata('id_usuario');
      $query = $this->db->query("SELECT * FROM fn_realizar_retorno(ARRAY$id_lotes,$id_usuario);");
      return $query->result();
      }
}