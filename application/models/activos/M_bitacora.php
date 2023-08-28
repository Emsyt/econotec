<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Creador: Keyla Paola Usnayo Aguilar Fecha: 22/11/2022, Codigo: SAM-MS-A7-0003,
Descripcion: Creacion del Controlador M_bitacora
*/

class M_bitacora extends CI_Model {

    public function get_lst_usuarios(){
        $query = $this->db->query("SELECT * FROM fn_listar_usuarios()");
        return  $query->result();
    }   

    public function get_lst_productos(){
        $query = $this->db->query("SELECT * FROM fn_listar_productos()");
        return  $query->result();
    } 

    public function insert_bitacora($id_bitacora,$id_usuario,$json){
        $query = $this->db->query("SELECT * FROM fn_registrar_bitacora($id_bitacora,$id_usuario,'$json'::json);");
        return $query->result_array();
    }

    public function add_edit_bitacora($id_bitacora,$id_usuario,$json){
        $query = $this->db->query("SELECT * FROM fn_registrar_bitacora($id_bitacora,$id_usuario,'$json'::json);");
        return $query->result_array();
    }
    
}