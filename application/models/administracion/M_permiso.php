<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha: 13/09/2022, Codigo: GAN-MS-A1-451,
Descripcion: Creacion del Model M_permiso y sus funciones.
*/
class M_permiso extends CI_Model {
    public function registrar_modificar_rol($id_rol,$id_login ,$formulario){
        $query = $this->db->query("SELECT * FROM fn_registrar_modificar_rol('$id_rol', '$id_login', '$formulario'::JSON)");
        return $query->result();
    }

    public function get_lst_roles(){
        $query = $this->db->query("SELECT * FROM fn_listar_roles()");
        return  $query->result();
    }

    public function get_lst_permisos(){
        $query = $this->db->query("SELECT * FROM fn_listar_permisos()");
        return  $query->result();
    }

    public function get_datos_rol($id_rol){
        $query = $this->db->query("select sigla , descripcion from seg_rol cc  where cc.id_rol = $id_rol");
        return $query->result();
    }

    public function get_lst_permisos_rol($id_rol){
        $query = $this->db->query("SELECT * FROM fn_listar_permisos_rol_mod('$id_rol')");
        return  $query->result();
    }

    public function delete_rol($id_login, $id_rol){
        $query = $this->db->query("SELECT * FROM fn_eliminar_rol('$id_login', '$id_rol')");
        return  $query->result();        
    }
}
