
<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Creador: karen quispe chavez Fecha:01/08/2022, Codigo: GAN-MS-A1-333,
Descripcion: Se creo el modelo del ABM llamado recepcion de pedidos, el cual muestra su respectivo formulario 
-------------------------------------------------------------------------------------------------------------------------------

*/
class M_recepcion_pedidos extends CI_Model {


    public function get_lst_solicitud_recepcion($login){
        $query = $this->db->query("SELECT * FROM fn_listar_recepcion($login)");
        return $query->result();
    }

    public function eliminar_recepcion($id_lote){
        $query = $this->db->query("SELECT * FROM fn_eliminar_recepcion($id_lote)");
        return $query->result();
    }

    public function get_conf_solicitud($id_lote){
        $query = $this->db->query("SELECT * FROM fn_listar_lote_recepcionado($id_lote);");
        return $query->result();
      }

      public function confirmar_cambio($array, $array2){
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT *FROM fn_confirmar_pedido1($id_usuario,ARRAY$array,ARRAY$array2)");
        return $query->result();
      }


}
