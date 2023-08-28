<?php
/*A
    -------------------------------------------------------------------------------------------------------------------------------
    Creacion: Melvin Salvador Cussi Callisaya Fecha 23/05/2022, Codigo: GAN-MS-A5-235
    Descripcion: se realizo el modulo de salida_de_produccion segun actividad GAN-MS-A5-235
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Alison Paola Pari Pareja   Fecha:02/08/2022   Actividad:GAN-MS-A1-337
    Descripcion: Se modificaron algunos modelos para realizazr los ajustes y correcciones en salida_produccion
-------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Alison Paola Pari Pareja   Fecha:17/11/2022   Actividad:GAN-MS-A4-0061
    Descripcion: Se modifico la funcion confirmar_salida para enviar el usuario.
    -------------------------------------------------------------------------------------------------------------------------------
    Creacion: Ariel Ramos Paucara          Fecha:22/03/2023           Actividad:GAN-DPR-M5-0245
    Descripcion: Se creo dos funciones que obtiene id_lote get_lote($lote) y la otra funcion obtiene un array id_productos get_productos_lote($idPro)
    */
?>
<?php

class M_salida_produccion extends CI_Model {
    public function set_salida($id,$login,$data) {
        $query=$this->db->query( "SELECT *
        FROM fn_registrar_salida1($id,'$login','$data'::json)" );
        return $query->row();
    }
    public function get_reporte_salida() {
        $query = $this->db->query("SELECT * FROM fn_reporte_salidas()");
        return $query->result();
    }
    public function get_salida($id) {
        $query = $this->db->query( "SELECT * FROM fn_recuperar_salida($id)" );
        return $query->row();
   }
   public function get_ubicacion() {
    $query = $this->db->query( "SELECT * FROM fn_listar_ubicaciones()" );
    return $query->result();
}
   public function get_lote_salida($id_lote) {
    $query = $this->db->query("SELECT * FROM fn_reporte_salida($id_lote)");
    return $query->result();
  }
    public function eliminar_salida($id,$login) {
         $query=$this->db->query( "SELECT *
         FROM fn_eliminar_salida($id,'$login')" );
         return $query->result();
    }
    public function get_producto() {
        $query = $this->db->query( "SELECT *
            FROM fn_listar_productos()" );
        return $query->result();
    }
    public function get_unidad() {
        $query = $this->db->query( "SELECT *
            FROM fn_listar_unidades()" );
        return $query->result();
    }
    public function confirmar_salida($id_lote) {
        $usuario= $this->session->userdata('usuario');
        $query = $this->db->query("SELECT * FROM fn_confirmar_salida($id_lote,'$usuario')");
        return $query->row();
      }
    public function get_productos_lote($id_lote) {
        $query = $this->db->query("SELECT * FROM fn_get_productos_lote($id_lote);");
        return $query->result();
    }
}