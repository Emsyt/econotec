<?php
/*
------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha:24/09/2021, GAN-MS-M6-035
Descripcion: Se realizaron la modificacion de para la creacion de funciones de las páginas 105 a 108 
-------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
Descripcion: se creo el modelo fn_mostrar_gastos1 para configurar el limit de los datos que se mostraran en la tabla de la vista
-------------------------------------------------------------------------------------------------------
Modificado: Wilson Huanca Callisaya Fecha:17/02/2023, Codigo: GAN-MS-B0-0280
Descripcion: se modificó  fn_mostrar_gastos1 para adicionar las columnas ototal y ofeccre en la tabla de la vista
*/
class M_gastos extends CI_Model
{

    public function mov_gastos()
    {
        $query = $this->db->query("SELECT * FROM mov_gastos");
        return $query->result();
    }
    public function fn_registrar_gasto($idgasto, $idlogin, $json)
    {
        $query = $this->db->query("SELECT * FROM fn_registrar_gasto($idgasto,$idlogin,'$json'::JSON)");
        return $query->result();
    }
    public function fn_mostrar_gastos($idlogin)
    {
        $query = $this->db->query("SELECT * FROM fn_mostrar_gastos($idlogin)");
        return $query->result();
    }
    public function fn_mostrar_gastos1($postData = null)
    {
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
        switch ($columnName) {
            case 'nro':
                $ordernar = 'nro';
                break;
            case 'odescripcion':
                $ordernar = 'odescripcion';
                break;
            case 'omonto_uni':
                $ordernar = 'omonto_uni'
                ;
                break;
            case 'ocantidad':
                $ordernar = 'ocantidad'
                ;
                break;
            case 'ototal':
                $ordernar = 'ototal'
                ;
                break;
            case 'ofeccre':
                $ordernar = 'ofeccre'
                ;
                break;

            default:
                # code...
                break;
        }
        ## Total number of records without filtering

        $this->db->select('count(*) as allcount');
        $this->db->from("fn_mostrar_gastos($id_usuario)");

        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering

        $this->db->select('count(*) as allcount');
        $this->db->from("fn_mostrar_gastos($id_usuario)");
        $this->db->where("odescripcion ilike '%$searchValue%' or omonto_uni::text ilike '%$searchValue%' or ocantidad::text ilike '%$searchValue%' or ofeccre::text ilike '%$searchValue%' or ototal::text ilike '%$searchValue%'");


        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records

        $this->db->select("*");
        $this->db->from("fn_mostrar_gastos($id_usuario)");
        $this->db->where("odescripcion ilike '%$searchValue%' or omonto_uni::text ilike '%$searchValue%' or ocantidad::text ilike '%$searchValue%' or ofeccre::text ilike '%$searchValue%' or ototal::text ilike '%$searchValue%'");

        $this->db->order_by($ordernar, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();

        $data = array();

        foreach ($records as $record) {

            $data[] = array(
                "oidgasto"         => $record->oidgasto,
                "onro"             => $record->onro,
                "odescripcion"     => $record->odescripcion,
                "omonto_uni"       => $record->omonto_uni,
                "ocantidad"        => $record->ocantidad,
                "ototal"           => $record ->ototal,
                "ofeccre"          => $record ->ofeccre  


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
    public function fn_recuperar_gasto($idgasto)
    {
        $query = $this->db->query("SELECT * FROM fn_recuperar_gasto($idgasto)");
        return $query->result();
    }
    public function fn_eliminar_gasto($idlogin, $idgasto)
    {
        $query = $this->db->query("SELECT * FROM fn_eliminar_gasto($idlogin,$idgasto)");
        return $query->result();
    }
    public function fn_total_gastos($idlogin)
    {
        $query = $this->db->query("SELECT * FROM fn_total_gastos($idlogin)");
        return $query->result();
    }
}