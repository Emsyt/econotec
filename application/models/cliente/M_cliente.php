<?php
/* -------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
Descripcion: se creo el modelo get_cliente1 para configurar el limit de los datos que se mostraran en la tabla de la vista
-----------------------------------------------------------------------------------------------
Modificado: Richard Hector Orihuela G. Fecha:23/06/2022, Codigo: GAN-MS-A3-285,
Descripcion: Se agrego el area direccion para las funciones de Base de datos de cliente.
-----------------------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert Fecha:29/08/2022, Codigo: GAN-SC-M5-405,
Descripcion: Se modifico los querys de cliente por funciones
-----------------------------------------------------------------------------------------------
Modificado: Keyla Paola Usnayo Aguilar Fecha:31/08/2022, Codigo: GAN-SC-M5-408,
Descripcion: Se modifico los querys de eliminar cliente por funciones
-----------------------------------------------------------------------------------------------
Modificado: Alvaro Ruben Gonzales Vilte Fecha:09/12/2022, Codigo: GAN-MS-A1-0176,
Descripcion: Se agrego el campo para la descripcion del cliente.
*/

class M_cliente extends CI_Model {

  public function M_confirmar_facturacion(){
    $query = $this->db->query("SELECT * FROM fn_confirmar_facturacion();");
    return $query->result();
  }

  public function datos_facturacion(){
    $idlogin = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_datos_facturacion($idlogin)");
    return $query->result();
  }

  
  public function M_listar_documentos(){
    $query = $this->db->query("SELECT * FROM fn_listar_documentos();");
    return $query->result();
  }

  public function M_gestionar_cliente($json){
    $idlogin= $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_registrar_cliente($idlogin,'$json'::JSON)");
    return $query->result();
  }

  public function get_cliente(){
       $query = $this->db->query("SELECT * FROM cat_personas WHERE id_catalogo = 1275 AND (apiestado = 'ELIMINADO' OR apiestado = 'ELABORADO')");
       return $query->result();
     }
  public function get_cliente1($postData=null)
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
          $ordernar = '';
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
            case 'tipo_documento':
              $ordernar = 'tipo_documento'
              ;break;
            case 'movil':
              $ordernar = 'movil'
              ;break;
            case 'direccion':
              $ordernar = 'direccion'
              ;break;
            case 'correo':
              $ordernar = 'correo'
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
              $searchQuery = " nombre_rsocial ilike '%".$searchValue."%' or apellidos_sigla ilike '%".$searchValue."%' or (nit_ci::text) ilike '%".$searchValue."%' or (movil::text) ilike '%".$searchValue."%' or direccion ilike '%".$searchValue."%' or apiestado ilike '%".$searchValue."%' or correo ilike '%".$searchValue."%'";
          }

          // GAN-SC-M5-405 Gary Valverde 29/08/2022
          $query = $this->db->query("SELECT * FROM fn_get_cliente('$ordernar','$columnSortOrder',$rowperpage,$start,'$searchValue')");

          $querytotal = $this->db->query("SELECT fn_total_clientes() as total");

          $queryfilter = $this->db->query("SELECT fn_total_clientes_filtrados('$searchValue') as total");
          // FIN GAN-SC-M5-405 Gary Valverde 29/08/2022

     
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
              "tipo_documento"=>$record->tipo_documento,
              "apiestado"=>$record->apiestado,
              "movil"=>$record->movil,
              "descripcion"=>$record->descripcion,
              "direccion"=>$record->direccion,
              "latitud"=>$record->latitud,
              "longitud"=>$record->longitud,
              "correo"=>$record->correo,
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
  public function M_add_update_cliente($usuario,$id_personas,$nombre_rsocial,$apellidos_sigla,$nit_ci,$movil,$direccion,$latitud,$longitud,$descripcion){
    $resultado = $this->db->query("SELECT * FROM fn_registrar_cliente('$usuario',$id_personas,'$nombre_rsocial','$apellidos_sigla','$nit_ci','$movil','$direccion','$latitud','$longitud','$descripcion');");
    return $resultado->result();
  }

  public function get_datos_cliente($id_cli){
    $this->db->where('id_personas', $id_cli);
    $query = $this->db->get('cat_personas');
    return $query->row();
  }

  //Kusnayo
  public function delete_cliente($id_cli, $data){
    $vData = array_values($data);
    $vapiestado = $vData[0];
    $vusumod = $vData[1];
    $query = $this->db->query("SELECT * FROM fn_delete_cliente($id_cli, '$vapiestado', '$vusumod')");
  }
  //Kusnayo
}
