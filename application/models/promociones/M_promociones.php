<?php
/*
------------------------------------------------------------------------------
  Modificado: Fabian Candia Alvizuri Fecha:13/10/2021, GAN-MS-A5-041
  Descripcion: Se realizaron la modificacion de para la creacion de funciones de las páginas 94 a 103
------------------------------------------------------------------------------
    Modificado: Fabian Candia Alvizuri Fecha:10/11/2021, GAN-MS-A4-069
    Descripcion: Se realizaron la modificacion para que liste los productos por su ubicacion 
    -------------------------------------------------------------------------------------------------------
    Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
    Descripcion: se creo el modelo fn_reporte_promociones1 para configurar el limit de los datos que se mostraran en la tabla de la vista
*/
class M_promociones extends CI_Model {

    
    public function mov_promociones(){
        $query = $this->db->query("SELECT * FROM cat_promociones");
        return $query->result();
    }

    public function fn_registrar_promocion($btnid,$idlogin,$json){
        $query = $this->db->query("SELECT * FROM fn_registrar_promocion($btnid,$idlogin,'$json'::JSON)");
        return $query->result();
    }

    public function fn_reporte_promociones($idlogin) {
        $query = $this->db->query("SELECT * FROM fn_reporte_promociones($idlogin)");
        return $query->result();
    }
    public function fn_reporte_promociones1($postData=null){
        $id_usuario = $this->session->userdata('id_usuario');
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
          case 'ocodigo':
            $ordernar = 'ocodigo';
            break;
          case 'onombre':
            $ordernar = 'onombre'
            ;break;
          case 'oprecio':
            $ordernar = 'oprecio'
            ;break;
          case 'ofechalimite':
            $ordernar = 'ofechalimite'
            ;break;
         
          default:
            # code...
            break;
        }
        
        ## Total number of records without filtering
       
        $this->db->select('count(*) as allcount');
        $this->db->from("fn_reporte_promociones($id_usuario)");
       
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;
    
        ## Total number of record with filtering
      
        $this->db->select('count(*) as allcount');
        $this->db->from("fn_reporte_promociones($id_usuario)");
        $this->db->where("ocodigo::text ilike '%$searchValue%' or onombre ilike '%$searchValue%' or oprecio::text ilike '%$searchValue%' or ofechalimite::text ilike '%$searchValue%'");

       
        if($searchQuery != '')
           $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;
    
        ## Fetch records
       
        $this->db->select("ROW_NUMBER() OVER(ORDER BY onombre ASC) AS nro, *");   
        $this->db->from("fn_reporte_promociones($id_usuario)");
        $this->db->where("ocodigo::text ilike '%$searchValue%' or onombre ilike '%$searchValue%' or oprecio::text ilike '%$searchValue%' or ofechalimite::text ilike '%$searchValue%'");

        $this->db->order_by($ordernar, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
    
        $data = array();
       
        foreach($records as $record ){
            
           $data[] = array( 
             
              "oidpromocion"=>$record->oidpromocion,
              "ocodigo"=>$record->ocodigo,
              "onro"=>$record->nro,
              "onombre"=>$record->onombre,
              "oprecio"=>$record->oprecio,
              "ofechalimite"=>$record->ofechalimite,
         
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
    

    public function fn_recuperar_promocion($idpromocion){
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_recuperar_promocion($idpromocion,$id_usuario)");
        return $query->result();
    }

    public function fn_eliminar_promocion($idlogin,$idpromocion) {
        $query = $this->db->query("SELECT * FROM fn_eliminar_promocion($idlogin,$idpromocion)");
        return $query->result();
    }
    
    public function get_producto($idlogin){
        $query = $this->db->query("SELECT * FROM fn_listar_productos_ubicacion($idlogin)");
        return $query->result();
    }
    
    public function fn_calcular_stock($id_producto){
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_calcular_stock($id_usuario,$id_producto)");
        return $query->result();
    }
}
