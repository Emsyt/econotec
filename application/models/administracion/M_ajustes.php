<?php
class M_ajustes extends CI_Model {
    public function get_ajustes($valor, $id_usuario){
        $query = $this->db->query("SELECT * FROM fn_mostrar_ajustes($id_usuario,'$valor')");
        return  $query->row();
      }
    public function get_theme_list(){
      $query = $this->db->query("SELECT * FROM fn_mostrar_temas(1)");
      return $query->result();
    }
    public function update_ajustes($data, $id_usuario) {
      $query = $this->db->query("SELECT * FROM fn_registrar_ajustes('$id_usuario', '$data'::JSON)");
      return $query->result();
    }
    public function get_papeles() {
      $query = $this->db->query("SELECT * FROM fn_listar_papeles()");
      return $query->result();
    }

    public function update_papeles($idLogin, $idpapel) {
      $query = $this->db->query("SELECT * FROM fn_cambiar_papel($idLogin,$idpapel)");
      return $query->result();
    }
}

