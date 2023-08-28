<?php
/* -------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
Descripcion: se creo el modelo get_proveedor1 para configurar el limit de los datos que se mostraran en la tabla de la vista 
----------------------------------------------------------------------------------------------------------
Modificado: Kevin Mauricio Larrazabal Calle.   Fecha:29/08/2022,   Codigo: GAN-SC-M5-402,
Descripcion: Actualizacion de los querys insert_proveedor, update_proveedor y delete_proveedor 
por funcion de postgres

----------------------------------------------------------------------------------------------------------
Modificado: Denilson Santander Rios.   Fecha:29/08/2022,   Codigo: GAN-SC-M5-401,
Descripcion: Actualizacion de los querys que estaban en la funcion get_proveedor1(), por funciones de
postgres
*/
class M_proveedor extends CI_Model {

  public function get_proveedor(){   
    $this->db->where('id_catalogo', 1274);
    $query = $this->db->get('cat_personas');
    return $query->result();
  }
  
  public function get_proveedor1($postData=null)
  {
    try
    {


    $response = array();
          ## Read value
          $draw = $postData['draw'];
          $start = $postData['start'];
          $rowperpage = $postData['length']; // Rows display per page
          $columnIndex = $postData['order'][0]['column']; // Column index
          $columnName = $postData['columns'][$columnIndex]['data']; // Column name
          $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
          $searchValue = $postData['search']['value']; // Search value
          $ordernar='';
            switch ($columnName) 
            {
              case 'nro':
                $ordernar = 'nro';
                break;
              case 'nombre_rsocial':
                $ordernar = 'nombre_rsocial';
                break;
              case 'apellidos_sigla':
                $ordernar = 'apellidos_sigla'
                ;break;
              case 'nit_ci':
                $ordernar = 'nit_ci'
                ;break;
              case 'movil':
                $ordernar = 'movil'
                ;break;  
              
              case 'apiestado':
                $ordernar = 'apiestado'
                ;break;
            
              
              default:
                # code...
                break;
            }


          ## Search 
          $searchQuery = "";
          if($searchValue != ''){
              $searchQuery = " nombre_rsocial ilike '%".$searchValue."%' or apellidos_sigla ilike '%".$searchValue."%' or (nit_ci::text) ilike '%".$searchValue."%' or apiestado ilike '%".$searchValue."%'";
          }


          // GAN-SC-M5-401 Denilson Santander Rios
          $query = $this->db->query("SELECT * FROM fn_get_proveedor1('$ordernar','$columnSortOrder',$rowperpage,$start,'$searchValue')");

          $querytotal = $this->db->query("SELECT fn_total_proveedor() as total");

          $queryfilter = $this->db->query("SELECT fn_total_proveedores_filtrados('$searchValue') as total");
          
          // FIN GAN-SC-M5-401 Denilson Santander Rios

     
          ## Total number of records without filtering
          //$query->select('count(*) as allcount');
          $records =  $query->result();
          $totales = $querytotal->result();
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
          $records =  $query->result();;
     
          $data = array();
        
          $status = "Error";

          foreach($records as $record )
          {
            
     
            $data[] = array( 
              "nro"=>$record->nro,
              "nombre_rsocial"=>$record->nombre_rsocial,
              "id_personas"=>$record->id_personas,
              "apellidos_sigla"=>$record->apellidos_sigla,
              "nit_ci"=>$record->nit_ci,
              "movil"=>$record->movil,
              "apiestado"=>$record->apiestado,
              
              
           ); 
          }
     
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
  }
  // KLarrazabal, 29/08/2022, GAN-SC-M5-402
  public function insert_proveedor($data){
    $vData = array_values($data);
    $vid_catalogo = $vData[0];
    $vnombre_rsocial = $vData[1];
    $vapellidos_sigla = $vData[2]; 
    $vnit_ci = $vData[3]; 
    $vtel_movil = $vData[4]; 
    $vusucre = $vData[5];    
    if ($vtel_movil=='')
    {
      $vtel_movil = 0;
    }
    $query = $this->db->query("SELECT * FROM fn_insert_proveedor($vid_catalogo,'$vnombre_rsocial','$vapellidos_sigla','$vnit_ci',$vtel_movil,'$vusucre')");
    return $query->result();
  }
  // FIN KLarrazabal, 29/08/2022, GAN-SC-M5-402


  // KLarrazabal, 29/08/2022, GAN-SC-M5-402
 public function update_proveedor($where, $data){

  $vId_personas = $where['id_personas'];
  $vData = array_values($data);
  $pNombre_rsocial = $vData[0];
  $pApellidos_sigla = $vData[1];
  $pNit_ci = $vData[2];
  $pTel_movil = $vData[3];
  $pUsucre = $vData[4];
 $query = $this->db->query("SELECT * FROM fn_update_proveedor($vId_personas,'$pNombre_rsocial','$pApellidos_sigla','$pNit_ci','$pTel_movil','$pUsucre')");
 return $query->result();
}
// FIN KLarrazabal, 29/08/2022, GAN-SC-M5-402

  public function get_datos_proveedor($id_prov){
    $this->db->where('id_personas', $id_prov);
    $query = $this->db->get('cat_personas');
    return $query->row();
  }

  // KLarrazabal, 29/08/2022, GAN-SC-M5-402
  public function delete_proveedor($id_prov, $data){
    $vData = array_values($data);
    $vapiestado = $vData[0];
    $vusumod = $vData[1];    
    $query = $this->db->query("SELECT * FROM fn_delete_proveedor($id_prov,'$vapiestado','$vusumod')");
  }
// FIN KLarrazabal, 29/08/2022, GAN-SC-M5-402
}
