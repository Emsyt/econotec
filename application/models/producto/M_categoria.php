<?php
/* -------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
Descripcion: se modifico modelo get_categoria para configurar el limit de los datos que se mostraran en la tabla de la vista 
---------------------------------------------------------------------------------------------------------
Modificado: Deivit Pucho Aguilar.   Fecha:25/08/2022,   Codigo: GAN-MS-A1-389,
Descripcion: Se reemplazo WHERE y UPDATE con la funcion fn_delete_categoria() que extrae un 
id_categoria y data de la base de datos cat_categoria.

---------------------------------------------------------------------------------------------------------
Modificado: Denilson Santander Rios.   Fecha:25/08/2022,   Codigo: GAN-MS-A1-390,
Descripcion: Se reemplazo el query por la funcion fn_insert_categoria() lo que realiza es una insercion
de una nueva categoria

---------------------------------------------------------------------------------------------------------
Modificado:  Pedro Rodrigo Beltran Poma.   Fecha:25/08/2022,   Codigo: GAN-MS-A1-388,
Descripcion: Se reemplazo el query por la funcion fn_get_datos_categoria() que realiza  una consulta
en la tabla cat_categoria  dado el id_cat ingresado.

---------------------------------------------------------------------------------------------------------
Modificado: Luis Fabricio Pari Wayar.   Fecha:25/08/2022,   Codigo: GAN-MS-A1-391,
Descripcion: Se reemplazo el query por la funcion fn_modificar categoria() lo que realiza es una modificacion
de una categoria
*/
class M_categoria extends CI_Model {

  
  public function get_categoria($postData=null){

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
      case 'apiestado':
        $ordernar = 'apiestado'
        ;break;
    
      
      default:
        # code...
        break;
    }
    // ## Search 
    // $searchQuery = "";
    // if($searchValue != ''){
    //     $searchQuery = " nro::text ilike '%$searchValue%' or codigo::text ilike '%$searchValue%' or descripcion ilike '%$searchValue%' or apiestado ilike '%$searchValue%' ";
    // }
    
    ## Total number of records without filtering
    $this->db->select('count(*) as allcount');
    $this->db->from('cat_categoria');
    $records = $this->db->get()->result();
    $totalRecords = $records[0]->allcount;

    ## Total number of record with filtering
    $this->db->select('count(*) as allcount');
    $this->db->from('cat_categoria');
    $this->db->where("codigo::text ilike '%$searchValue%' or descripcion ilike '%$searchValue%' or apiestado ilike '%$searchValue%'");

    if($searchQuery != '')
       $this->db->where($searchQuery);
    $records = $this->db->get()->result();
    $totalRecordwithFilter = $records[0]->allcount;

    ## Fetch records
    $this->db->select('ROW_NUMBER() OVER(ORDER BY codigo  ASC) AS nro,*');
    $this->db->from('cat_categoria');
    $this->db->where("codigo::text ilike '%$searchValue%' or descripcion ilike '%$searchValue%' or apiestado ilike '%$searchValue%'");
    
    $this->db->order_by($ordernar, $columnSortOrder);
    
    $this->db->limit($rowperpage, $start);
    $records = $this->db->get()->result();

    $data = array();

    foreach($records as $record ){

       $data[] = array( 
          "nro"=>$record->nro,
          "codigo"=>$record->codigo,
          "id_categoria"=>$record->id_categoria,
          "descripcion"=>$record->descripcion,
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


  public function insert_categoria($data){
    // GAN-MS-A1-390 Denilson Santander Rios
    $vData = array_values($data);
    $vcodigo = $vData[0];
    $vdescripcion = $vData[1];
    $vusucre = $vData[2];
    $vimagen = $vData[3];

    $query = $this->db->query("SELECT * FROM fn_insert_categoria('$vcodigo', '$vdescripcion', '$vusucre', '$vimagen')");
    // FIN GAN-MS-A1-390 Denilson Santander Rios
  }

  public function update_categoria($id_cat,$Data){
    //   GAN-MS-A1-391 Luis Fabricio Pari Wayar
    $Data = array_values($Data);
    $id_cat = $id_cat['id_categoria'];
    $vcodigo = $Data[0];
    $vdescripcion = $Data[1];
    $vusumod = $Data[2];
    $vimagen = $Data[3];
    $query = $this->db->query("SELECT * FROM fn_modificar_categoria($id_cat,'$vcodigo', '$vdescripcion', '$vimagen','$vusumod')");
    // FIN   GAN-MS-A1-391 Luis Fabricio Pari Wayar
  }

  public function get_datos_categoria($id_cat){
    // GAN-MS-A1-388, 25/08/2022 PBeltran.
    $query = $this->db->query("SELECT * FROM fn_get_datos_categoria($id_cat)");
    return $query->row();
    // FIN GAN-MS-A1-388, 25/08/2022 PBeltran. 
  }

  public function delete_categoria($id_cat, $data){
    //GAN-MS-A1-389, 25/08/2022 Deivit Pucho
    //Variables para extraccion
    $vdata = array_values($data);
    $vapiestado = $vdata[0];
    $vusumod = $vdata[1];

    $query = $this->db->query("SELECT * FROM fn_delete_categoria($id_cat, '$vapiestado', '$vusumod')");
    //Fin GAN-MS-A1-389, 25/08/2022 Deivit Pucho
  }

  public function validacion($codigo){
    $query = $this->db->query("SELECT * FROM cat_categoria WHERE codigo = '$codigo'");
    return $query->num_rows();
  }
}
