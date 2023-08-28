<?php
/*
------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:18/11/2022, GAN-MS-A7-0111,
Creacion del Model M_ejecucion
------------------------------------------------------------------------------
*/
class M_ejecucion extends CI_Model {
    public function lts_codigos_venta() {
        $query = $this->db->query("SELECT * FROM fn_listar_codigos_venta()");
        return $query->result();
    }
    public function mostrar_venta_garantia($codigo_venta) {
        $query = $this->db->query("SELECT * FROM fn_mostrar_venta_garantia('$codigo_venta')");
        return $query->result();
    }
    public function validar_garantia($codigo_venta) {
        $query = $this->db->query("SELECT * FROM fn_validar_garantia('$codigo_venta')");
        return $query->result();
    }
    public function datos_venta($idubicacion, $idlote, $usucre) {
        $query = $this->db->query("SELECT * FROM fn_historial_venta_garantia($idubicacion, $idlote, '$usucre')");
        return $query->result();
    }
    public function realizar_ejecucion($cod_venta, $ids_venta,$observaciones,$newName) {
        $idusuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_ejecutar_garantia('$cod_venta', ARRAY$ids_venta,'$observaciones','$newName',$idusuario)");
        return $query->result();
    }
}