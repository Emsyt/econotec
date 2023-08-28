<?php 
/*------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja  Fecha:21/04/2022, Codigo: GAN-MS-A3-182,
Descripcion: Se crearon las funciones get_lst_ubicaciones , get_lst_productos_ubi 
para mostrar las ubicaciones y los productos en los combos de la vista ;insert_conversion 
para registrar la conversion y get_lst_conversiones para mostrar el reporte de conversiones
*/
?>
<?php
class M_conversion_paquete extends CI_Model {
    public function get_lst_ubicaciones() {
        $query = $this->db->query("SELECT * FROM fn_listar_ubicaciones();");
        return $query->result();
      }
    public function get_lst_unidades() {
    $query = $this->db->query("SELECT * FROM fn_listar_unidades();");
    return $query->result();
    }
    public function get_lst_productos_ubi($id_ubicacion) {
        $query = $this->db->query("SELECT * FROM fn_productos_ubicacion($id_ubicacion);");
        return $query->result();
    }
    public function insert_conversion($login,$json){
        $query = $this->db->query("SELECT * FROM fn_registrar_conversion('$login','$json'::JSON)");
        return $query->result();
    }
    public function get_lst_conversiones(){
    $query = $this->db->query("SELECT * FROM fn_reporte_conversion();");
    return $query->result();
    }
}
?>
