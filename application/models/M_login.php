<?php
/* 
-----------------------------------------------------------------------------------------------
Modificado: Deivit Pucho Aguilar.   Fecha:23/08/2022,   Codigo: GAN-SC-M3-368,
Descripcion: Se reemplazo el query de getDatosUsuario por una funcion de Base de datos de Usuario.
*/
/* 
-----------------------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma.   Fecha:23/08/2022,   Codigo: GAN-SC-M3-364,
Descripcion: Se reemplazo el query de verificar_usuario() por una funcion de Base de datos de Usuario
fn_verificar_usuario.
*/
/* 
-----------------------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert.   Fecha:23/08/2022,   Codigo: GAN-SC-M3-367,
Descripcion: Se reemplazo el query de que_permisos_tiene() por una funcion de Base de datos de Usuario
fn_listar_permisos_rol.
*/
/* 
-----------------------------------------------------------------------------------------------
Modificado: Denilson Santander Rios.       Fecha:23/08/2022,   Codigo: GAN-SC-M-366,
Descripcion: Se reemplazo el query de que_cargo_es() por una funcion de Base de datos 
fn_que_cargo_es.
*/
/* 
-----------------------------------------------------------------------------------------------
Modificado: Luis Fabricio Pari Wayar.       Fecha:23/08/2022,   Codigo: GAN-MS-A1-378,
Descripcion: Se reemplazo el query de que_rol_es() por una funcion de Base de datos de Usuario
fn_que_rol_es.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

    public function verificar_usuario() {
        // GAN-SC-M3-364, 23-08-2022, Pedro Beltran.
	$pass = do_hash($_POST['password'], 'md5');
        $user = $_POST['usuario'];
        $query = $this->db->query("SELECT * FROM fn_verificar_usuario('$user', '$pass')");
        return $query->result();
        // GAN-SC-M3-364, 23-08-2022, Pedro Beltran.
    }

    public function roles() {
        $query = $this->db->get('seg_rol');
        return $query->result();
    }
    
    // GAN-MS-A1-378, 23-08-2022, Luis Fabricio Pari Wayar
    public function que_rol_es($id_usuario) {
        $query = $this->db->query("SELECT * FROM fn_que_rol_es($id_usuario)");
        return $query->result();
    }
    // FIN GAN-MS-A1-378, 23-08-2022, Luis Fabricio Pari Wayar

    // GAN-SC-M-366, 23-08-2022, Denilson Santaner Rios
    public function que_cargo_es($id_usuario) {
        $query = $this->db->query("SELECT * FROM fn_que_cargo_es($id_usuario)");
        return $query->result();
    }
    // FIN GAN-SC-M-366, 23-08-2022, Denilson Santaner Rios

    // GAN-SC-M3-367, 23-08-2022, Gary Valverde.
    public function listar_permisos_rol($id_rol) {
        $query = $this->db->query("SELECT * FROM fn_listar_permisos_rol($id_rol)");
    // FIN GAN-SC-M3-367, 23-08-2022, Gary Valverde
        return $query->result();
    }

    public function getDatosUsuario($ci) {
        // GAN-SC-M3-368, 23/08/2022 Deivit Pucho. 
        // Reemplazo de query por la funcion fn_mostrar_datos_usuario($ci).
        $query = $this->db->query("SELECT * FROM fn_mostrar_datos_usuario('$ci')");
        // Fin GAN-SC-M3-368 23/08/2022 Deivit Pucho.
        $error=$this->db->_error_message();
        if(!empty($error))
            throw new Exception("Error Base de datos: ".$error);
        return $query->result();
    }

    public function guardar_log($data){
        if($this->db->insert('seg_log', $data))
            return true;         
        else
            return $this->db->_error_message();
    }
    public function get_ajustes($valor){
        $query = $this->db->query("SELECT * FROM fn_mostrar_ajustes(1,'$valor')");
        return  $query->row();
    }
}