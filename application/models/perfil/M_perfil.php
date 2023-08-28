<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Milena Rojas Fecha:18/04/2022, Codigo: GAN-MS-M4-162,
Descripcion: se aImplementó el funcionamiento del cambio de contraseña
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class M_perfil extends CI_Model {
    
    public function verificar_password() {
        $user = $this->session->userdata('usuario');
        $this->db->where('login', $user);
        $this->db->where('password', do_hash($_POST['password'], 'md5'));
        $query = $this->db->get('seg_usuario');        
        return $query->result();
    }

    public function update_pass($id_usuario,$old_pass, $new_pass) {
      $query = $this->db->query("SELECT * FROM fn_cambiar_pass($id_usuario, '$old_pass', '$new_pass')");
      return $query->result();
    }
}