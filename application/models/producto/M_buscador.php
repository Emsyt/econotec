<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Creador: Gary German Valverde Quisbert Fecha:22/05/2022   ,
Descripcion: Se Realizo la vista y funcionamiento del submodulo buscador
-------------------------------------------------------------------------------------------------------------------------------
*/
class M_buscador extends CI_Model {
    public function get_lst_producto_buscador($id_ubi,$producto,$medidas,$equivParam,$columsearch,$preciso) {   
        $x = "SELECT * FROM fn_busqueda_medidas($id_ubi, '$producto', '$medidas', $equivParam, '$columsearch', '$preciso');";
        $query = $this->db->query("SELECT * FROM fn_busqueda_medidas($id_ubi, '$producto', '$medidas', $equivParam ,'$columsearch', '$preciso');");
        return $query->result();
    }

    public function get_lst_precios($id_producto,$id_ubi) {
        $query = $this->db->query("SELECT * FROM fn_listar_precios($id_producto,$id_ubi);");
        return $query->result();
    }

    public function get_lst_stock_sucursales($id_producto) {
        $query = $this->db->query("SELECT * FROM fn_listar_stock_sucursales($id_producto)");
        return $query->result();
    }
}
