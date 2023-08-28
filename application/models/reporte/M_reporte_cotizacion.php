
<?php
/* A
------------------------------------------------------------------------------------------
Creador: Pedro Rodrigo Beltran Poma Fecha:25/10/2022, GAN-MS-A4-092,
Creacion del Model M_listado_ventas con sus respectivas funciones para la relacion con la base de datos
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma Fecha: 28/10/2022 GAN-MS-A6-0079
Descripcion: Se modifico la funcion get_lst_reporte_ABMcotizacion2 para obtener el campo observaciones
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Jose Daniel Luna Flores Fecha: 08/11/2022 GAN-IC-A0-0093
Descripcion: Se modifico la funcion get_lst_reporte_ABMcotizacion2 para obtener el campo observaciones correctamente
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha: 24/11/2022 GAN-MS-A7-0134
Descripcion: Se agrego la funcion verificar_productos.
*/
class M_reporte_cotizacion extends CI_Model {

  public function get_lst_clientes() {
    $query = $this->db->query("SELECT * from vw_clientes vc where id_personas <> 0");
    return $query->result();
  }

  public function get_lst_reporte_ABMcotizacion2($postData=null,$json){
    $id_usuario = $this->session->userdata('id_usuario');
    //INICIO GAN-IC-A0-0093, JLuna 08/11/2022
    $query = $this->db->query("SELECT * FROM fn_reporte_ABMcotizaciones2($id_usuario,'$json'::JSON);");
    //FIN GAN-IC-A0-0093, JLuna 08/11/2022
    $records =  $query->result();
    $data = Array();
    $response = Array();
    if(!empty($records)){

          foreach($records as $record )
          {
             $data[] = array( 
                "pidlote"=>$record->oidlote,
                "pcliente"=>$record->ocliente,
                "ptotal"=>$record->ototal,
                "pfeccre"=>$record->ofeccre,
                "pfecvali"=>$record->ofecvali,
                // GAN-MS-A6-79, PBeltran 28/10/2022
                "pobservaciones"=>$record->oobservaciones,
                //FIN GAN-MS-A6-79, PBeltran 28/10/2022
                "pidubicacion"=>$record->oidubicacion,
                "pusucre"=>$record->ousucre,
                "pidcotizacion"=>$record->oidcotizacion
             ); 
          }
          $response = array(
             "aaData" => $data
          );
    }else{
	    $response = array(
		    "aaData" => []
	    );
    }

    return $response;
  }


  public function get_eliminar_cotizacion($idubicacion, $idlote, $usucre) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_cotizacion_completada($id_usuario,$idubicacion, $idlote,'$usucre')");
    return $query->result();
  }

  public function get_cargar_cotizacion($idubicacion, $idlote, $usucre) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cargar_cotizacion($id_usuario,$idubicacion, $idlote,'$usucre')");
    return $query->result();
  }

  public function verificar_productos($idubicacion, $idlote, $usucre) {
    $query = $this->db->query("SELECT * FROM fn_verificar_producto($idubicacion, $idlote,'$usucre')");
    return $query->result();
  }

  public function get_historial_cotizacion($idubicacion, $idlote, $usucre) {
    $query = $this->db->query("SELECT * FROM fn_historial_cotizacion($idubicacion, $idlote, '$usucre')");
    return $query->result();
  }

  public function get_lst_nota_venta_cotizacion($id_usuario,$id_venta) {
    $query = $this->db->query("SELECT * FROM fn_nota_cotizacion($id_usuario,$id_venta,0)");
    return $query->result();
  }

  
}
