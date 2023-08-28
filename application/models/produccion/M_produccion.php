<?php
/*A
    -------------------------------------------------------------------------------------------------------------------------------
    Creacion: Melvin Salvador Cussi Callisaya Fecha 23/05/2022, Codigo: GAN-MS-A5-235
    Descripcion: se realizo el modulo de produccion segun actividad GAN-MS-A5-235
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Alison Paola Pari Pareja   Fecha:02/08/2022   Actividad:GAN-MS-A1-337
    Descripcion: Se anadio la funcion confirmar_ingreso_fila para confirmar el resgistro seleccionado
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Alcon Lazarte Kevin Gerardo  Fecha:15/03/2023   Actividad:GAN-MS-M0-0358
    Descripcion: Se anadio $id_usuario a la funcion confirmar_ingreso_fila 
*/
?>
<?php
class M_produccion extends CI_Model {

    public function eliminar_ingreso($login,$id) {
        $query=$this->db->query( "SELECT *
        FROM fn_eliminar_entrada('$login',$id)" );
        return $query->result();
   }
   public function set_ingreso($id,$login,$data) {
       $query=$this->db->query( "SELECT *
       FROM fn_registrar_entrada($id,'$login','$data'::json)" );
        return $query->result();
   }
   public function get_ingreso($id) {
        $query = $this->db->query( "SELECT * FROM fn_recuperar_entrada($id)" );
        return $query->row();
   }
  public function get_ubicacion() {
       $query = $this->db->query( "SELECT *
           FROM fn_listar_ubicaciones()" );
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
   public function get_reporte_ingreso() {
       $query = $this->db->query("SELECT * FROM fn_reporte_entradas()");
       return $query->result();
     }
     public function get_lote_ingreso($id_lote) {
        $query = $this->db->query("SELECT * FROM fn_reporte_ingreso($id_lote)");
        return $query->result();
      }
      public function confirmar_ingreso() {
        $query = $this->db->query("SELECT * FROM fn_confirmar_ingreso()");
        return $query->result();
      }
    //INICIO ALKG 16/03/2023 GAN-MS-M0-0358
    public function confirmar_ingreso_fila($id_usuario ,$id_lote) {
        $query = $this->db->query("SELECT * FROM fn_confirmar_ingreso_fila($id_usuario ,$id_lote)");
    //FIN ALKG 16/03/2023 GAN-MS-M0-0358
        return $query->result();
    }
      public function fn_calcular_stock_ubi($id_producto,$id_ubicacion){
        $query = $this->db->query("SELECT * FROM fn_calcular_stock_ubi($id_producto,$id_ubicacion)");
        return $query->result();
    }
    public function get_lst_productos_ubi($id_ubicacion) {
        $query = $this->db->query("SELECT * FROM fn_productos_ubicacion($id_ubicacion);");
        return $query->result();
    }
}
