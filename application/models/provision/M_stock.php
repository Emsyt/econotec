<?php

/*
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana    Fecha:15/09/2022,     Codigo: GAN-MS-A1-439,
Descripcion: Se modifico la funcion get_lst_inventarios para  insertar el limit del modelo en el datatable en el modulo de stock
*/
class M_stock extends CI_Model {

    public function get_ubicacion_cmb(){
        $this->db->where('apiestado', 'ELABORADO');
        $query = $this->db->get('cat_ubicaciones');
        return $query->result();
    }

    public function get_lst_inventarios($id_ubi,$postData=null){
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
      $ordernar         = '';

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
        default:
          # code...
          break;
      }

  
      ## Search 
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " pcodigo ilike '%".$searchValue."%' or pcodigo_alt ilike '%".$searchValue."%' or pproducto ilike '%".$searchValue."%' or pprecio ilike '%".$searchValue."%' or pubicacion ilike '%".$searchValue."%' or pcantidad ilike '%".$searchValue."%'";
      }
      
      //solo una consulta

          $query        = $this->db->query("SELECT * FROM fn_inventario($id_ubi,'$ordernar','$columnSortOrder','$rowperpage','$start','$searchValue');");
          $querytotal   = $this->db->query("SELECT COUNT(*) as total FROM fn_inventario($id_ubi,'','','','','');");
          $queryfilter  = $this->db->query("SELECT COUNT(*) as total FROM fn_inventario($id_ubi,'','','','','$searchValue');");
     

      // 3 consultas fn
      /* 
      $query        = $this->db->query("SELECT * FROM fn_inventario($id_ubi,'$ordernar ','$columnSortOrder',$rowperpage,$start,'$searchValue');");
      $querytotal   = $this->db->query("SELECT fn_total_inventario($id_ubi) as total;");
      $queryfilter  = $this->db->query("SELECT fn_total_inventario_filtrados($id_ubi,'$searchValue') as total;"); 
      */
  
      ## Total number of records without filtering
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
            "pcodigo"       => $record->codigo,
            "pcodigo_alt"   => $record->codigo_alt,
            "pproducto"     => $record->producto,
            "pprecio"       => $record->precio,
            "pubicacion"    => $record->ubicacion,
            "pcantidad"     => $record->cantidad,
          ); 
      }
  
      ## Response
      $response = array(
          "draw"                  => intval($draw),
          "iTotalRecords"         => $totalRecords,
          "iTotalDisplayRecords"  => $totalRecordwithFilter,
          "columnsna"             => $columnName,
          "start"                 => $start,
          "aaData"                => $data
      );
  
      return $response; 
    }
    catch(Exception $error )
    {
      $log['error'] = $error;
    }
  }

  public function cambiar_cantidad($id_ubi, $id_prod,$idus,$newcantidad, $description){
    $query = $this->db->query("SELECT * FROM  fn_ajustar_stock($idus, $id_ubi, $id_prod, $newcantidad, '$description')");
    return $query->result();
  }
  
}
