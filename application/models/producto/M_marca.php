
<?php
/*  -------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
Descripcion: se creo el modelo get_marca1 para configurar el limit de los datos que se mostraran en la tabla de la vista
------------------------------------------------------------------------------
Modificado: Kevin Mauricio Larrazabal Calle Fecha:26/08/2022, Codigo: GAN-SC-M4-396
Descripcion: Se cambio Query de la funcion delete_marca por funcion de postgresql fn_delete_marca
------------------------------------------------------------------------------
Modificado: Luis Fabricio Pari Wayar  Fecha:26/08/2022, Codigo: GAN-SC-M4-397
Descripcion: Se cambio Query de la funcion get_Datos_marca() por funcion de postgresql fn_get_datos_marca 
------------------------------------------------------------------------------
Modificado: Denilson Santander Rios  Fecha:26/08/2022, Codigo: GAN-SC-M4-395
Descripcion: Se cambio Query de la funcion update_marca() por funcion de postgresql fn_update_marca
-----------------------------------------------------------------------------------------------------------
Modificado: Deivit Pucho Aguilar.   Fecha:26/08/2022,   Codigo: GAN-SC-M4-394,
Descripcion: Se integro la funcion fn_insert_marca para integrar nuevos datos a la tabla cat_marca 
*/
class M_marca extends CI_Model {

  public function get_marca(){
    $query = $this->db->get('cat_marca');
    return $query->result();
  }
  public function get_marca1($postData=null){
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

    $ordernar;
    switch ($columnName) 
    {
      case 'nro':
        $ordernar = 'nro';
        break;
      case 'codigo':
        $ordernar = 'codigo';
        break;
      case 'descripcion':
        $ordernar = 'descripcion'
        ;break;
      case 'garantia':
        $ordernar = 'garantia'
        ;break;
      case 'tiempo_garantia':
        $ordernar = 'tiempo_garantia'
        ;break;
      case 'apiestado':
        $ordernar = 'apiestado'
        ;break;
    
      
      default:
        # code...
        break;
    }

    ## Total number of records without filtering
    $this->db->select('count(*) as allcount');
    $this->db->from('cat_marca');
    $records = $this->db->get()->result();
    $totalRecords = $records[0]->allcount;

    

    ## Total number of record with filtering
    $this->db->select('count(*) as allcount');
    $this->db->from('cat_marca');
    $this->db->where("codigo::text ilike '%$searchValue%' or descripcion ilike '%$searchValue%' or garantia::text ilike '%$searchValue%' or tiempo_garantia::text ilike '%$searchValue%' or apiestado ilike '%$searchValue%'");

    if($searchQuery != '')
       $this->db->where($searchQuery);
    $records = $this->db->get()->result();
    $totalRecordwithFilter = $records[0]->allcount;

    ## Fetch records
    $this->db->select('ROW_NUMBER() OVER(ORDER BY codigo  ASC) AS nro,*');
    $this->db->from('cat_marca');
    $this->db->where("codigo::text ilike '%$searchValue%' or descripcion ilike '%$searchValue%' or garantia::text ilike '%$searchValue%' or tiempo_garantia::text ilike '%$searchValue%' or apiestado ilike '%$searchValue%'");
    $this->db->order_by($ordenar, $columnSortOrder);
    $this->db->order_by($columnName, $columnSortOrder);
    $this->db->limit($rowperpage, $start);
    $records = $this->db->get()->result();

    $data = array();

    foreach($records as $record ){

       $data[] = array( 
          "nro"=>$record->nro,
          "codigo"=>$record->codigo,
          "id_marca"=>$record->id_marca,
          "descripcion"=>$record->descripcion,
          "garantia"=>$record->garantia,
          "tiempo_garantia"=>$record->tiempo_garantia,
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
  public function get_marca2($postData=null)
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
          $ordernar;
          switch ($columnName) 
          {
            case 'nro':
              $ordernar = 'nro';
              break;
            case 'codigo':
              $ordernar = 'codigo';
              break;
            case 'descripcion':
              $ordernar = 'descripcion'
              ;break;
            case 'garantia':
              $ordernar = 'garantia'
              ;break;
            case 'tiempo_garantia':
              $ordernar = 'tiempo_garantia'
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
              $searchQuery = " (codigo::text) ilike '%".$searchValue."%' or descripcion ilike '%".$searchValue."%' or (garantia::text) ilike '%".$searchValue."%' or (tiempo_garantia::text) ilike '%".$searchValue."%' or apiestado ilike '%".$searchValue."%'";
          }

          $query = $this->db->query("SELECT ROW_NUMBER() OVER(ORDER BY codigo  ASC) AS nro,*
                FROM cat_marca
               WHERE apiestado NOT ilike 'ANULADO'
                 AND (codigo::text ilike '%$searchValue%' 
                      or descripcion ilike '%$searchValue%' 
                      or garantia::text ilike '%$searchValue%' 
                      or tiempo_garantia::text ilike '%$searchValue%' 
                      or apiestado ilike '%$searchValue%')
             ORDER BY $ordernar $columnSortOrder
                LIMIT $rowperpage
               OFFSET $start");

          $querytotal = $this->db->query("SELECT count(*)::text as total
                from cat_marca ");

          $queryfilter = $this->db->query("SELECT count(*)::text as total
                FROM cat_marca
               WHERE apiestado NOT ilike 'ANULADO'
                 AND (codigo::text ilike '%$searchValue%' 
                      or descripcion ilike '%$searchValue%' 
                      or garantia::text ilike '%$searchValue%' 
                      or tiempo_garantia::text ilike '%$searchValue%' 
                      or apiestado ilike '%$searchValue%') ");


     
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
              "codigo"=>$record->codigo,
              "id_marca"=>$record->id_marca,
              "descripcion"=>$record->descripcion,
              "garantia"=>$record->garantia,
              "tiempo_garantia"=>$record->tiempo_garantia,
              "apiestado"=>$record->apiestado
              
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
  public function insert_marca($data){
    //GAN-SC-M4-394, 26/08/2022 Deivit Pucho
    //variables que extraen los valores de data
    $vdata = array_values($data);
    $vcodigo = $vdata[0];
    $vdescripcion = $vdata[1];
    $vgarantia = $vdata[2];
    $vtiempoGarantia = $vdata[3];
    $vimagen = $vdata[4];
    $vmostrar = $vdata[5];
    $vusucre = $vdata[6];
    $vmostrarmarc;
    if ($vmostrarmarc) {
      $vmostrarmarc = 1;
    }
    else {
      $vmostrarmarc = 0;
    }
    //Ejecucion de funcion
    $query = $this->db->query("SELECT * FROM fn_insert_marca('$vcodigo','$vdescripcion',$vgarantia,$vtiempoGarantia,'$vimagen',$vmostrarmarc,'$vusucre');");
    return $query->result();
    //Fin GAN-SC-M4-394, 26/08/2022 Deivit Pucho 
  }

 
  public function update_marca($id_mar, $Data){
    // Denilson Santander Rios 26/08/2022 GAN-SC-M4-395
    $Data = array_values($Data);
    $id_mar = $id_mar['id_marca']; 
    $vcodigo = $Data[0]; 
    $vdescripcion = $Data[1];
    $vgarantia = $Data[2];
    $vtiempo_garantia = $Data[3];
    $vimagen = $Data[4];
    $vusumod = $Data[5];
    $query = $this->db->query("SELECT * FROM fn_update_marca($id_mar,'$vcodigo', '$vdescripcion', '$vgarantia', '$vtiempo_garantia', '$vusumod','$vimagen' )");
    // FIN Denilson Santander Rios 26/08/2022 GAN-SC-M4-395
  }


  // Luis Fabricio Pari Wayra, 26/08/2022, GAN-SC-M4-397
  public function get_datos_marca($id_mar){
    $query = $this->db->query("SELECT * FROM fn_get_datos_marca($id_mar)");
    return $query->row();
  }
  // FIN Luis Fabricio Pari Wayra, 26/08/2022, GAN-SC-M4-397

  // KLarrazabal, 26/08/2022, GAN-SC-M4-396
  public function delete_marca($id_mar, $data){

    $vData = array_values($data);
    $vapiestado = $vData[0];
    $vusumod = $vData[1];    
    $query = $this->db->query("SELECT * FROM fn_delete_marca($id_mar,'$vapiestado','$vusumod')");
  }
// FIN KLarrazabal, 26/08/2022, GAN-SC-M4-396

  public function validacion($codigo){
    $query = $this->db->query("SELECT * FROM cat_marca WHERE codigo = '$codigo'");
    return $query->num_rows();
  }
}
