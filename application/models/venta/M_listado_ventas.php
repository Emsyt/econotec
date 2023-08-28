<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:17/11/2021, GAN-MS-A4-092,
Creacion del Model M_listado_ventas con sus respectivas funciones para la relacion con la base de datos
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:22/03/2022, Codigo:GAN-MS-M6-136
Descripcion: se agrego la funcion get_lst_nota_venta_cotizacion para recuperar la nota de venta
------------------------------------------------------------------------------
Modificado: Saul Imanol Quiroga Castrillo Fecha:07/08/2022, Codigo:GAN-MS-A1-340
Descripcion: agregadas la funciones respectivas para el modulo de entregas
------------------------------------------------------------------------------
Modificado: Gary German Valverde  Fecha:14/10/2022, Codigo:GAN-SC-M4-0047
Descripcion: Se modifico la tabla para optimizar el limit y el listado de entregas
*/
class M_listado_ventas extends CI_Model {

  public function get_lst_clientes() {
    $query = $this->db->query("SELECT * from vw_clientes vc where id_personas <> 0");
    return $query->result();
  }

  

  public function get_lst_reporte_ABMventas($postData=null,$json) {
    //GAN-MS-A0-0046 Gary Valverde 13/10/2022
    try{
      $response = array();
            ## Read value
            $draw = $postData['draw'];
            $start = $postData['start'];
            $rowperpage = $postData['length']; // Rows display per page
            $columnIndex = $postData['order'][0]['column']; // Column index
            $columnName = $postData['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
            $searchValue = $postData['search']['value']; // Search value
            $ordernar='ofecha';

            switch ($columnName) 
            {
              case 'pnro':
                $ordernar = 'nro';
                break;
              case 'pcodigo':
                $ordernar = 'a.codigo';
                break;
              case 'pcodigo_alt':
                $ordernar = 'a.codigo_alt';
                break;
              case 'pproducto':
                $ordernar = 'a.descripcion';
                break;
              case 'pprecio':
                $ordernar = 'b.precio';
                break;
              case 'pubicacion':
                $ordernar = 'a.ubicacion';
                break;
              case 'pcantidad':
                $ordernar = 'a.cantidad';
                break;
              case 'ptipo_venta':
                $ordernar = 'a.tipo_venta';
                break;
              default:
                # code...
                break;
            }

            $id_usuario = $this->session->userdata('id_usuario');

    
           
            $query = $this->db->query("SELECT ROW_NUMBER() OVER(ORDER BY ofecha) AS fila, * FROM fn_reporte_ABMventas_v2($id_usuario,'$json'::JSON,'$ordernar','$columnSortOrder',$rowperpage,$start,'$searchValue');");
            
            $x= "SELECT * FROM fn_reporte_ABMventas_v2($id_usuario,'$json'::JSON,'$ordernar','$columnSortOrder',$rowperpage,$start,'$searchValue');";

            $querytotal = $this->db->query("SELECT count(*) FROM fn_reporte_ABMventas($id_usuario,'$json'::JSON);");
            $y = "SELECT count(*) FROM fn_reporte_ABMventas($id_usuario,'$json'::JSON);";
            
            $queryfilter = $this->db->query("SELECT count(*) FROM fn_reporte_ABMventas($id_usuario,'$json'::JSON) where ocodigo ilike '%$searchValue%' or ocliente ilike '%$searchValue%' or ototal::text ilike '%$searchValue%' or ofecha::text ilike '%$searchValue%' or ohora::text ilike '%$searchValue%';");
            $z = "SELECT count(*) FROM fn_reporte_ABMventas($id_usuario,'$json'::JSON) where ocodigo ilike '%$searchValue%' or ocliente ilike '%$searchValue%' or ototal::text ilike '%$searchValue%' or ofecha::text ilike '%$searchValue%' or ohora::text ilike '%$searchValue%';";
            
              $records      =  $query->result();
              $totales      = $querytotal->result();
              $totalRecords = $totales[0]->count;

              $totfilter =  $queryfilter->result();
              $totalRecordwithFilter = $totfilter[0]->count;
              
              $data = array();
        
              $status = "Error";
              /* GAN-SC-M4-0047 Gary Valverde 14-10-2022 */
              foreach($records as $record )
              {
                $data[] = array(
                "nrorow" => $record->fila,
                "oidubicacion" => $record->oidubicacion,
                "ousucre" => $record->ousucre,
                "oidventa" => $record->oidventa, 
                "olote" => $record->olote, 
                "onro"          => $record->onro,
                "ocodigo"  => $record->ocodigo,
                "ocliente" => $record->ocliente,
                "ototal"       => $record->ototal,
                "ofecha"     => $record->ofecha,
                "ohora"       => $record->ohora,
                "otipo"       => $record->otipo,
                ); 
              }/* fin GAN-SC-M4-0047 Gary Valverde 14-10-2022 */

              ## Response
          $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "columnsna" => $columnName,
            "start" => $start,
            "aaData" => $data
         );
    
         return $response; 
        }
        catch(Exception $error )
        {
          $log['error'] = $error;
        }
    //fin GAN-MS-A0-0046 GaryValverde 13/10/2022
  }




  public function get_eliminar_venta($idubicacion, $idlote, $usucre) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_venta_completada($id_usuario,$idubicacion, $idlote,'$usucre')");
    return $query->result();
  }

  public function get_cargar_venta($idubicacion, $idlote, $usucre) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cargar_venta($id_usuario,$idubicacion, $idlote,'$usucre')");
    return $query->result();
  }

  public function get_historial_venta($idubicacion, $idlote, $usucre) {
    $query = $this->db->query("SELECT * FROM fn_historial_venta($idubicacion, $idlote, '$usucre')");
    $x="SELECT * FROM fn_historial_venta_v2($idubicacion, $idlote, '$usucre')";
    return $query->result();
  }

  public function get_ingresos_ventas($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_ingresos_dia($id_usuario,'$json'::JSON)");
    return $query->result();
  }
  public function get_lst_nota_venta_cotizacion($id_usuario,$id_venta) {
    $query = $this->db->query("SELECT * FROM fn_nota_venta($id_usuario,$id_venta,0)");
    return $query->result();
  }

  public function get_lst_entregas($idventa, $idlote) {
    $query = $this->db->query("SELECT * FROM fn_listar_productos_entrega($idventa, $idlote)");
    $x="SELECT * FROM fn_listar_productos_entrega($idventa, $idlote)";
    return $query->result();
  }

  public function get_ingresar_entrega($idventa, $idlote, $producto, $cantidad) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_registrar_productos_entrega($idventa, $idlote,'$producto'::text, $cantidad, '$id_usuario'::text)");
    return $query->result();
  }
  
  public function get_actualizar_entrega($identrega, $cant_Total_Entregada, $apiestado) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_cambiar_productos_entrega($identrega, $cant_Total_Entregada, $id_usuario, '$apiestado'::text)");  
    return $query->result();
  }
}