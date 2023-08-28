<?php
/* 
  -------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
  Descripcion: se creo el modelo get_usuario1 y get_asgroles1 para configurar el limit de los datos que se mostraran en la tabla de la vista 
  -------------------------------------------------------------------------------------------------------
  Modificado: Richard Hector Orihuela Gil Fecha:29/07/2022, Codigo: GAN-MS-A1-327
  Descripcion: correcion del modulo de usuarios, En cuanto a la eliminacion de usuarios
  -------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Fecha:29/07/2022, Codigo: GAN-MS-A1-328
  Descripcion: Se creo la funcion abm_usuario para insertar y editar usuarios desde la funcion fn_registrar_usuario
  -------------------------------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar    Fecha:31/08/2022,   Codigo: GAN-SC-A1-417
  Descripcion: Se implemento la funcion fn_delete_usuario en delete_usuario para inactivar al usuario. 
    -------------------------------------------------------------------------------------------------------
  Modificado: Gary German Valverde Quisbert    Fecha:31/08/2022,   Codigo: GAN-SC-A1-416
  Descripcion: Se implemento las funciones para obtener el total , total filtrado y todos los usuarios.
  -------------------------------------------------------------------------------------------------------
  Modificado: Keyla Paola Usnayo    Fecha:31/08/2022,   Codigo: GAN-SC-A1-422
  Descripcion: Se modifico la query a una funcion fn_delete_usuario en delete_usuario para inactivar al usuario. 
  -------------------------------------------------------------------------------------------------------
  Modificado: Adamary Margell Uchani Mamani Fecha:31/08/2022, Codigo: GAN-MS-A1-424
  Descripcion: Se modifico la funcion fn_insert_rol para insertar desde la función un rol
  fn_insert_rol() de M_usuario
  -------------------------------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar  Fecha:31/08/2022, Codigo: GAN-SC-A1-420
  Descripcion: Actualizacion de update_usuariores en lugar de realizar un query llamamos a la funcion fn_update_usuario
   -------------------------------------------------------------------------------------------------------
  Modificado: Denilson Santander RIos  Fecha:31/08/2022, Codigo: GAN-SC-A1-418
  Descripcion: Se reemplazo el query que estaba en get_datos_usuario por una funcion fn_get_datos_usuario()
  --------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa  Fecha:01/09/2022, Codigo: GAN-SC-A1-423
  Descripcion: Se añadio la funcion get_datos_per para recuperar datos usuario
  --------------------------------------------------------------------------------------------------------
  Modificado: Jose Daniel Luna Flores  Fecha:01/09/2022, Codigo: GAN-SC-A1-425
  Descripcion: Se reemplazo el query que estaba en update_usuariores por una funcion fn_update_usuariores()
  --------------------------------------------------------------------------------------------------------

   --------------------------------------------------------------------------------------------------------
  Modificado: Denilson Santander Rios  Fecha:31/08/2022, Codigo: GAN-SC-A1-418 
  Descripcion: Se reemplazo el query que estaba en get_datos_usuario por una funcion fn_get_datos_usuario()
  --------------------------------------------------------------------------------------------------------
  Modificado:  Melani Alisson Cusi Burgoa Fecha:22/09/2022, Codigo: GAN-MS-A1-478
  Descripcion: Actualizacion funcion update_usuariores
  
  -------------------------------------------------------------------------------------------------------
*/


class M_usuario extends CI_Model {

  public function get_departamento_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_departamento');
    return $query->result();
  }

  public function get_ubicacion_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_ubicaciones');
    return $query->result();
  }

  public function get_usuario(){
    $this->db->select('u.id_usuario, u.login,carnet, u.nombre, u.paterno, u.materno, u.direccion, u.telefono, u.correo, u.apiestado, d.abreviatura expedido, ub.descripcion ubicacion');
    $this->db->from('seg_usuario u');
    $this->db->join('cat_departamento d', 'd.id_departamento = u.id_departamento');
    $this->db->join('cat_ubicaciones ub', 'ub.id_ubicacion = u.id_proyecto');
    $this->db->where('u.apiestado', 'ELABORADO');
    $this->db->order_by('u.nombre');
    $query = $this->db->get();
    return $query->result();
  }
  public function get_usuario1($postData=null){

    $response = array();

    ## Read value
    $draw = $postData['draw'];
    $start = $postData['start'];
    $rowperpage = $postData['length']; // Rows display per page
    $columnIndex = $postData['order'][0]['column']; // Column index
    $columnName = $postData['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
    $searchValue = $postData['search']['value']; // Search value
// GAN-SC-A1-416 Gary Valverde 31/08/2022 
$ordernar='nro';
switch ($columnName) 
{
  case 'nro':
    $ordernar = 'nro';
    break;
  case 'login':
    $ordernar = 'login';
    break;
  case 'nombre':
    $ordernar = 'nombre'
    ;break;
  case 'carnet':
    $ordernar = 'carnet'
    ;break;
  case 'correo':
    $ordernar = 'correo'
    ;break;
  case 'telefono':
    $ordernar = 'telefono'
    ;break;
  case 'ubicacion':
    $ordernar = 'ubicacion'
    ;break;

  
  default:
    # code...
    break;
}

## Querys de usuarios
$query = $this->db->query("SELECT * FROM fn_get_usuarios('$ordernar','$columnSortOrder',$rowperpage,$start,'$searchValue')");

$querytotal = $this->db->query("SELECT fn_total_usuarios() as allcount");

$queryfilter = $this->db->query("SELECT fn_total_usuarios_filtrados('$searchValue') as allcount");

## Total number of records without filtering
$records =  $query->result();
$totales = $querytotal->result();
$totalRecords = $totales[0]->allcount;


 ## Total number of record with filtering
 $totfilter =  $queryfilter->result();
 $totalRecordwithFilter = $totfilter[0]->allcount;

## Fetch records
$records =  $query->result();
// fin GAN-SC-A1-416 Gary Valverde 31/08/2022

    $data = array();

    foreach($records as $record ){

       $data[] = array( 
          "nro"=>$record->nro,
          "id_usuario"=>$record->id_usuario,
          "login"=>$record->login,
          "nombre"=>$record->nombre,
          "paterno"=>$record->paterno,
          "materno"=>$record->materno,
          "carnet"=>$record->carnet,
          "expedido"=>$record->expedido,
          "correo"=>$record->correo,
          "telefono"=>$record->telefono,
          "ubicacion"=>$record->ubicacion,
          "apiestado"=>$record->apiestado,
       ); 
    }

    ## Response
    $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecords,
       "iTotalDisplayRecords" => $totalRecordwithFilter,
       "aaData" => $data
    );

    return $response; 
  }
  public function abm_usuario($btn,$data){
    $resultado = $this->db->query("SELECT * FROM fn_registrar_usuario($btn,'$data'::JSON)");
    return $resultado->result();
  }
  
  public function get_datos_usuario($id_usr){
    // GAN-SC-A1-418 Denilson Santander Rios, 31/08/2022
    $query = $this->db->query("SELECT * FROM fn_get_datos_usuario($id_usr)");
    return $query->row();
    // FIN GAN-SC-A1-418 Denilson Santander Rios, 31/08/2022
   
  }

  public function delete_usuario($id_usr, $data){
    //GAN-SC-A1-417, 31/08/2022 Deivit Pucho
    $vdata = array_values($data);
    $vapiestado = $vdata[0];
    $vusumod = $vdata[1];

    $query = $this->db->query("SELECT * FROM fn_delete_usuario($id_usr, '$vapiestado', '$vusumod')");
    //Fin GAN-SC-A1-417, 31/08/2022 Deivit Pucho
    return $this->db->affected_rows();
  }


  public function get_roles_cmb(){
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('seg_rol');
    return $query->result();
  }
  public function get_asgroles(){
    $query = $this->db->query("SELECT sur.id_usurestriccion, sur.id_usuario, sur.id_rol, sur.apiestado, su.login, su.carnet, su.nombre, su.paterno, su.materno, sr.descripcion
      FROM seg_usuariorestriccion AS sur
      JOIN seg_usuario AS su ON sur.id_usuario = su.id_usuario
      JOIN seg_rol AS sr ON sur.id_rol = sr.id_rol
      WHERE sur.apiestado = 'ELABORADO'");
    return $query->result();
  }

  public function get_asgroles1($postData=null){
    $response = array();

    ## Read value
    $draw = $postData['draw'];
    $start = $postData['start'];
    $rowperpage = $postData['length']; // Rows display per page
    $columnIndex = $postData['order'][0]['column']; // Column index
    $columnName = $postData['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
    $searchValue = $postData['search']['value']; // Search value
    // $ordernar;
    // switch ($columnName) 
    // {
    //   case 'rnro':
    //     $ordernar = 'nro';
    //     break;
    //   case 'rlogin':
    //     $ordernar = 'su.login';
    //     break;
    //   case 'rnombre':
    //     $ordernar = 'su.nombre'
    //     ;break;
    //   case 'rpaterno':
    //     $ordernar = 'su.paterno'
    //     ;break;
    //   case 'rmaterno':
    //     $ordernar = 'su.materno';
    //     break;
    //   case 'rcarnet':
    //     $ordernar = 'su.carnet';
    //     break;
    //   case 'rpermiso':
    //     $ordernar = 'sr.descripcion';
    //     break;
     
    //   case 'restado':
    //     $ordernar = 'sur.apiestado';
    //     break;
      
    //   default:
    //     # code...
    //     break;
    // }


      ## Total number of records without filtering
          //$query->select('count(*) as allcount');
          $this->db->select('count(*) as allcount');
          $this->db->from('seg_usuariorestriccion sur');
          $this->db->join('seg_usuario su' , 'sur.id_usuario = su.id_usuario');
          $this->db->join('seg_rol sr ', 'sur.id_rol = sr.id_rol');
          $this->db->where('sur.apiestado', 'ELABORADO');
          
          $records = $this->db->get()->result();
          $totalRecords = $records[0]->allcount;
      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      $this->db->from('seg_usuariorestriccion sur');
      $this->db->join('seg_usuario su' , 'sur.id_usuario = su.id_usuario');
      $this->db->join('seg_rol sr ', 'sur.id_rol = sr.id_rol');
      $this->db->where('sur.apiestado', 'ELABORADO');
      $this->db->where("login ilike '%$searchValue%' or nombre ilike '%$searchValue%' or paterno ilike '%$searchValue%' or materno ilike '%$searchValue%' or carnet::text ilike '%$searchValue%' or descripcion ilike '%$searchValue%'");

      if($searchQuery != '')
      $this->db->where($searchQuery);
      $records = $this->db->get()->result();
      $totalRecordwithFilter = $records[0]->allcount;
     
     
        ## Fetch records
       
       $this->db->select("ROW_NUMBER() OVER(ORDER BY su.nombre ASC) AS nro, sur.id_usurestriccion, 
       sur.id_usuario, sur.id_rol, sur.apiestado, su.login, su.carnet,
       su.nombre, su.paterno, su.materno, sr.descripcion");
       $this->db->from('seg_usuariorestriccion sur');
      $this->db->join('seg_usuario su' , 'sur.id_usuario = su.id_usuario');
      $this->db->join('seg_rol sr ', 'sur.id_rol = sr.id_rol');
      $this->db->where('sur.apiestado', 'ELABORADO');
      $this->db->where("login ilike '%$searchValue%' or nombre ilike '%$searchValue%' or paterno ilike '%$searchValue%' or materno ilike '%$searchValue%' or carnet::text ilike '%$searchValue%' or descripcion ilike '%$searchValue%'");

     $this->db->order_by($ordernar, $columnSortOrder);
     
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get()->result();
    
          $data = array();
        
       foreach($records as $record ){
   
          $data[] = array( 
             "nro"=>$record->nro,
             "id_usurestriccion"=>$record->id_usurestriccion,
             "login"=>$record->login,
             "nombre"=>$record->nombre,
             "paterno"=>$record->paterno,
             "materno"=>$record->materno,
             "carnet"=>$record->carnet,
             "descripcion"=>$record->descripcion,
             "apiestado"=>$record->apiestado,
             
          ); 
       }
   
       ## Response
       $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
     );
 
     return $response; 
  }

  public function get_datos_per($id_usr){
    // GAN-SC-A1-423, 01/09/2022 ACusi.
    $query = $this->db->query("SELECT * FROM fn_get_datos_persona($id_usr)");
    // FIN GAN-SC-A1-423, 01/09/2022 ACusi.
    return $query->row();
  }

  public function insert_rol($data){
    // GAN-MS-A1-424    AUchani
    $vdata = array_values($data);
    $vidproyecto = $vdata[0];
    $vidusuario = $vdata[1];
    $vidrol = $vdata[2];
    $vdepartamentos = $vdata[3];
    $vusucre = $vdata[4];

    $query = $this->db->query("SELECT * FROM fn_insert_rol('$vidproyecto', '$vidusuario', '$vidrol', '$vdepartamentos', '$vusucre')");
    return $query->result();
    // FIN GAN-MS-A1-424  AUchani
  }

  public function get_datos_usuariores($id_usres){
      $this->db->where('id_usurestriccion', $id_usres);
      $query = $this->db->get('seg_usuariorestriccion');
      return $query->row();
  }

  // GAN-MS-A1-478, 22/09/2022 ACusi.
  public function update_usuariores($pid_usurestriccion, $pid_rol, $papiestado, $pusumod ){
    $query = $this->db->query("SELECT * FROM fn_update_usuariores('$pid_usurestriccion','$pid_rol', '$papiestado', '$pusumod')");
    return $query->result();
  }
  // FIN GAN-MS-A1-478, 22/09/2022 ACusi.
  
  public function update_usuario($where, $data){
      //   GAN-SC-A1-420 Luis Fabricio Pari Wayar
      $Data = array_values($Data);
      $id_user = $where['id_usuario'];
      $uCarnet=$Data[3];
      $uNombre=$Data[4];
      $uPaterno=$Data[5];
      $uMaterno=$Data[6];
      $uDireccion=$Data[7];
      $uTelefono=$Data[8];
      $uCorreo=$Data[10]; 
      $uCargo=$Data[15];
      $uUsumod=$Data[16];
      $query = $this->db->query("SELECT * FROM fn_update_usuario($id_user,'$uCarnet', '$uNombre', '$uPaterno','$uMaterno','$uDireccion','$uTelefono','$uCorreo','$uCargo','$uUsumod')");
      //  FIN GAN-SC-A1-420 Luis Fabricio Pari Wayar
      return $this->db->affected_rows();
  }


  //Kusnayo
  public function eliminar_usuariores($id_usres,$data){
    $data = array_values($data);
    $vapiestado = $data[0];
    $vusumod = $data[1];
    $query = $this->db->query("SELECT * FROM fn_eliminar_usuario($id_usres, '$vapiestado','$vusumod')"); 
    return $query->result();   
  }
  //Kusnayo

}
