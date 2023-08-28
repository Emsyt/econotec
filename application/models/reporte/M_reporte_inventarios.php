<?php
/* 
------------------------------------------------------------------------------------------
Modificacion: Alvaro Ruben Gonzales Vilte Fecha:09/11/2022, Codigo: GAN-MS-A0-0096,
Descripcion: Se modifico el llamado de la funcion get_lst_inventario_beta para mostrar el pdf con los datos del pdf de reporte inventario
------------------------------------------------------------------------------------------
Modificado: Melani Alisson Cusi Burgoa Fecha:05/12/2022, Codigo: GAN-MS-A3-0157,
Descripcion: Se agrego un contador de productos con ayuda de la funcion fn_reporte_contador
------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha:09/12/2022, Codigo: GAN-MS-A1-0174,
Descripcion: Se modifico la funcion get_lst_inventarios_beta para la agregacion de nuevos datos
 */
?>
<?php
class M_reporte_inventarios extends CI_Model {

  public function get_ubicacion_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_ubicaciones');
    return $query->result();
  }

  public function get_lst_inventarios_beta($id_ubi) {
    $query = $this->db->query("SELECT * FROM fn_inventario($id_ubi,'','','','','')");
    
    // $query = $this->db->query("select * from fn_inventario (0,'nro','asc',10,0,'');");
   
    return $query->result();
  }

  public function get_lst_inventarios($postData=null,$id_ubi)
  {
    try
    {
      $response         = array();
      ## Read value
      $draw             = $postData['draw'];
      $start            = $postData['start'];
      $rowperpage       = $postData['length']; // Rows display per page
      $columnIndex      = $postData['order'][0]['column']; // Column index
      $columnName       = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder  = $postData['order'][0]['dir']; // asc or desc
      $searchValue      = $postData['search']['value']; // Search value
      $ordernar         = '1';

      switch ($columnName) 
      {
        case 'pnro':
          $ordernar = 'f.nro';
          break;
        case 'pcategoria':
          $ordernar = 'f.categoria';
          break;
        case 'pmarca':
          $ordernar = 'f.marca';
          break;
        case 'pcodigo':
          $ordernar = 'f.codigo';
          break;
        case 'pcodigo_alt':
          $ordernar = 'f.codigo_alt';
          break;
        case 'pproducto':
          $ordernar = 'f.descripcion';
          break;
        case 'pcosto_uni':
          $ordernar = 'f.costo_uni';
          break;
        case 'pcosto_total':
          $ordernar = 'f.costo_total';
          break;   
        case 'pprecio':
          $ordernar = 'f.precio_unitario';
          break;                 
        case 'pubicacion':
          $ordernar = 'f.ubicacion';
          break;
        case 'pcantidad':
          $ordernar = 'f.cantidad';
          break;
        default:
          # code...
          break;
      }
     
          ## Search 
          /* 
          $query        = $this->db->query("SELECT * FROM fn_inventario($id_ubi,'$ordernar ','$columnSortOrder','$rowperpage','$start','$searchValue');");
          $querytotal   = $this->db->query("SELECT fn_total_inventario($id_ubi) as total;");
          $queryfilter  = $this->db->query("SELECT fn_total_inventario_filtrados($id_ubi,'$searchValue') as total;");
          */
          
          $query        = $this->db->query("SELECT * FROM fn_inventario($id_ubi,'$ordernar','$columnSortOrder','$rowperpage','$start','$searchValue');");
          $querytotal   = $this->db->query("SELECT COUNT(*) as total FROM fn_inventario($id_ubi,'','','','','');");
          $queryfilter  = $this->db->query("SELECT COUNT(*) as total FROM fn_inventario($id_ubi,'','','','','$searchValue');");
          
     
          $records      =  $query->result();
          $totales      = $querytotal->result();
          $totalRecords = $totales[0]->total;

          ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
          $this->db->where($searchQuery);
      $totfilter =  $queryfilter->result();
      $totalRecordwithFilter = $totfilter[0]->total;
  
      ## Fetch records
      $this->db->select('*');
      if($searchQuery != '')
          $this->db->where($searchQuery);
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records =  $query->result();
     
          $data = array();
        
          $status = "Error";

          foreach($records as $record )
      {
          $data[] = array( 
            "pnro"          => $record->nro,
            "pid_producto"  => $record->id_producto,
            "pid_ubicacion" => $record->id_ubicacion,
            "pcategoria"    => $record->categoria,
            "pmarca"        => $record->marca,
            "pcodigo"       => $record->codigo,
            "pproducto"     => $record->producto,
            "pcosto_uni"    => $record->costo_unitario,
            "pcosto_total"  => $record->costo_total,
            "pprecio"       => $record->precio_unitario,
            "pubicacion"    => $record->ubicacion,
            "pcantidad"     => $record->cantidad,
          ); 
      }
     
          ## Response
          $response = array(
             "draw" => intval($draw),
             "iTotalRecords" => $totalRecords,
             "iTotalDisplayRecords" => $totalRecords,
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
  }
  public function get_cant_prod($id_ubi) {
    $query = $this->db->query("SELECT sum(cantidad) FROM fn_inventario($id_ubi,'','','','','')");
    return $query->result();
  }

  public function get_costo_total($id_ubi) {
    $query = $this->db->query("SELECT sum(costo_total) FROM fn_inventario($id_ubi,'','','','','')");
    return $query->result();
  }

}
