<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Creador: Adamary Margel Uchani Mamani Fecha: 22/11/2022, Codigo: SAM-MS-A7-0001,
Descripcion: Creacion del Modelo M_registro y el listado de activos
-------------------------------------------------------------------------------------------------------------------------------
Creador: Adamary Margel Uchani Mamani Fecha: 24/11/2022, Codigo: SAM-MS-A7-0007,
Descripcion: Creacion del Modelo M_registros y la funcion del AVM de activos
-------------------------------------------------------------------------------------------------------------------------------
Creador: Flavio Abdon Condori Vela  Fecha: 28/03/2023, Codigo: GAN-MS-M0-0364
Descripcion:Se añadió la función registrar_devolucion.
*/

class M_registro extends CI_Model {

    public function get_productos_cmb(){
        $query = $this->db->query("SELECT * FROM fn_listar_productos()");
        return $query->result();
    }

    public function get_usuarios_cmb(){
        $query = $this->db->query("SELECT id_usuario,CONCAT(nombre,' ',paterno,' ',materno) as nombre_usu FROM seg_usuario WHERE apiestado='ELABORADO'");
        return $query->result();
    }

    public function listar_reg_activos($id_usuario) {
        $query = $this->db->query("SELECT * FROM fn_listar_activos('$id_usuario')");
        return $query->result();
    }

    public function agg_mod_activo($id_activo,$id_login, $json){
        $x= "SELECT * FROM fn_registrar_activo('$id_activo', '$id_login', '$json'::JSON)";
        $query = $this->db->query("SELECT * FROM fn_registrar_activo('$id_activo', '$id_login', '$json'::JSON)");
        return $query->result();
    }

    //GAN-MS-M0-0364 Inicio Flavio A.C.V 
    public function registrar_devolucion($id_activo,$id_login, $json){
        $x= "SELECT * FROM fn_registrar_devolucion('$id_activo', '$id_login', '$json'::JSON)";
        $query = $this->db->query("SELECT * FROM fn_registrar_devolucion('$id_activo', '$id_login', '$json'::JSON)");
        return $query->result();
    }
    //GAN-MS-M0-0364 Fin Flavio A.C.V 
    public function recuperar_activos($id_activo){
        $query = $this->db->query("SELECT * FROM fn_recuperar_activo('$id_activo')");
        return $query->result();
    }

    public function eliminar_activos($id_login,$id_activo){
        $query = $this->db->query("SELECT * FROM fn_eliminar_activo('$id_login','$id_activo')");
        return $query->result();
    }
    
}