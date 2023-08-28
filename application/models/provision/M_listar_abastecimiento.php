<?php
/* 
------------------------------------------------------------------------------------------
Creador: Kevin Gerardo Alcon Lazarte Fecha:28/03/2023, Codigo:GAN-DPR-M1-0373 ,
Creacion:Se creo el modelo M_listar_abastecimiento
----------------------------------------------------------------------------------------

 */
?>
<?php
class M_listar_abastecimiento extends CI_Model {

    public function get_ubicacion_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_ubicaciones');
    return $query->result();
    
    }
    public function get_lst_ubicaciones() {
    $query = $this->db->query("SELECT * FROM fn_listar_ubicaciones()");
    return $query->result();
    }

    public function get_rep_abastecimiento($json) {
    $query = $this->db->query("SELECT * FROM fn_listar_abastecimiento('$json'::JSON)");
    return $query->result();
    }

    public function get_eliminar_abastecimiento($id_lote) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_abastecimiento_lotes($id_usuario,$id_lote)");
    return $query->result();
    }

    public function get_historial_compra($id_lote) {
        $query = $this->db->query("SELECT * FROM fn_historial_compra($id_lote)");
        return $query->result();
    }
    public function get_editar_abast_lotes($id_lote) {
        $query = $this->db->query("SELECT * FROM fn_editar_por_lotes($id_lote)");
        return $query->result();
    }
    public function get_verificar_solicitud($login) {
        $query = $this->db->query("SELECT * FROM fn_verificar_solicitud('$login')");
        return $query->result();
        
    }

}