<?php
/*
------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:18/11/2022, GAN-MS-A7-0111,
Creacion del Model M_registro_garantia
------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:18/11/2022   GAN-MS-A7-0120,
Descripcion: Se crearon las funciones para listado y registro de garantias
*/
class M_registro_garantia extends CI_Model {
    public function M_get_lst_garantias1($json_gar) {
        $idusuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_listar_ventas_garantia($idusuario,'$json_gar'::json)");
        
        return $query->result();
      }
    public function M_registro_garantias($idusuario,$lote,$fecha,$caracteristica,$newName) {
    $query = $this->db->query("SELECT * FROM fn_registro_garantia($idusuario,$lote,'$fecha','$caracteristica','$newName')");
    
    return $query->result();
    }
    public function M_get_lst_garantias()
    {
        echo 'json_encode($data)';
    //   try
    //   {
        
        // $idusuario = $this->session->userdata('id_usuario');
        // $response         = array();
        // ## Read value
        // $draw             = $postData['draw'];
        // $start            = $postData['start'];
        // $rowperpage       = $postData['length']; // Rows display per page
        // $columnIndex      = $postData['order'][0]['column']; // Column index
        // $columnName       = $postData['columns'][$columnIndex]['data']; // Column name
        // $columnSortOrder  = $postData['order'][0]['dir']; // asc or desc
        // $searchValue      = $postData['search']['value']; // Search value
        // $ordernar         = '1';
  
        // switch ($columnName) 
        // {
        //   case 'onro':
        //     $ordernar = 'onro';
        //     break;
        //   case 'ocodigo':
        //     $ordernar = 'ocodigo';
        //     break;
        //   case 'ocliente':
        //     $ordernar = 'ocliente';
        //     break;
        //   case 'ousucre':
        //     $ordernar = 'ousucre';
        //     break;
        //   case 'ototal':
        //     $ordernar = 'ototal';
        //     break;
        //   case 'ofecha':
        //     $ordernar = 'ofecha';
        //     break;
        //   case 'ohora':
        //     $ordernar = 'ohora';
        //     break;
        //   default:
        //     # code...
        //     break;
        // }
        //     $query        = $this->db->query("SELECT * FROM fn_listar_ventas_garantia_filtrado($idusuario,'$data'::json,'$ordernar','$columnSortOrder','$rowperpage','$start','$searchValue');");
        //     $querytotal   = $this->db->query("SELECT COUNT(*) as total FROM fn_listar_ventas_garantia_filtrado($idusuario,'$data'::json,'','','','','');");
        //     $queryfilter  = $this->db->query("SELECT COUNT(*) as total FROM fn_listar_ventas_garantia_filtrado($idusuario,'$data'::json,'','','','','$searchValue');");
            
       
        //     $records      =  $query->result();
        //     $totales      = $querytotal->result();
        //     $totalRecords = $totales[0]->total;
  
        //     ## Total number of record with filtering
        // $this->db->select('count(*) as allcount');
        // if($searchQuery != '')
        //     $this->db->where($searchQuery);
        // $totfilter =  $queryfilter->result();
        // $totalRecordwithFilter = $totfilter[0]->total;
    
        // ## Fetch records
        // $this->db->select('*');
        // if($searchQuery != '')
        //     $this->db->where($searchQuery);
        // $this->db->order_by($columnName, $columnSortOrder);
        // $this->db->limit($rowperpage, $start);
        // $records =  $query->result();
       
        //     $data = array();
          
        //     $status = "Error";
  
        //     foreach($records as $record )
        // {
        //     $data[] = array( 
        //       "onro"          => $record->onro,
        //       "oidventa"  => $record->oidventa,
        //       "oidubicacion" => $record->oidubicacion,
        //       "olote"       => $record->olote,
        //       "ousucre"     => $record->ousucre,
        //       "ocodigo"       => $record->ocodigo,
        //       "ocliente"    => $record->ocliente,
        //       "ototal"     => $record->ototal,
        //       "ofecha"     => $record->ofecha,
        //       "ohora"     => $record->ohora,
        //     ); 
        // }
       
        //     ## Response
        //     $response = array(
        //        "draw" => intval($draw),
        //        "iTotalRecords" => $totalRecords,
        //        "iTotalDisplayRecords" => $totalRecords,
        //        "columnsna" => $columnName,
        //        "start" => $start,
        //        "aaData" => $data
        //     );
       
        //     return $response; 
        //   }
        //   catch(Exception $error )
        //   {
        //     $log['error'] = $error;
        //   }
    }
}