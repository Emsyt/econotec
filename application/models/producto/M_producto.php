<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:08/03/2022,  GAN-MS-A1-123
  Descripcion: Se agrego la funcion get_datos_precio para que devuelva los valores de precio compra y precio venta
   --------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:27/06/2022, Codigo: GAN-FR-A6-278
  Descripcion: Se añadio la funcion cambiar_existencia para actualizar el campo min_stock del producto.
  --------------------------------------------------------------------------
  Modificado: karen quispe chavez  Fecha:26/07/2022, Codigo: GAN-PB-A1-316
  Descripcion: Se añadio la funcion fn_registrar producto para poder arreglar el doble registro
  --------------------------------------------------------------------------
  Modificado: Gary German Valverde Quisbert  Fecha:26/08/2022, Codigo: GAN-SC-M4-399
  Descripcion: Se modifico parte de la funcion de get_products reemplazando por funciones a los querys en $query_total y $query_filter
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Pedro Rodrigo Beltran Poma.   Fecha:26/08/2022,   Codigo: GAN-SC-M4-398,
  Descripcion: Se reemplazo el query en update_producto()  por la funcion fn_update_producto() que realiza  un update
  en la tabla cat_producto  dado el id_producto ingresado.
  --------------------------------------------------------------------------
  Modificado: Gary German Valverde Quisbert  Fecha:28/08/2022, Codigo: GAN-SC-M4-399
  Descripcion: Se modifico parte de la funcion de get_products reemplazando por funciones al query para rescatar los productos
  --------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha:29/08/2022, Codigo: GAN-SC-M5-400
  Descripcion: Se añadio la funcion fn_cambiar_precio_producto para poder cambiar el precio del producto.
  --------------------------------------------------------------------------
  Modificado: Adamary Margell Uchani Mamani  Fecha:30/08/2022, Codigo: GAN-SC-M5-406
  Descripcion: Se añadio la funcion fn_delete_producto() por funcion de postgresql fn_delete_producto()
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:4/10/2022, Codigo: GAN-MS-A2-0009
  Descripcion: se añadio el campo unidad en get_products, update_producto y insert_producto
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:7/10/2022, Codigo: GAN-MS-A0-0035
  Descripcion: se añadio la funcion cambiar_unidad 
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:21/10/2022, Codigo: GAN-MS-A1-0051
  Descripcion: se añadio las funciones para la creacion, modificacion y eliminacion de precios en cat_precios 
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:21/10/2022, Codigo: GAN-MS-A1-0064
  Descripcion: se corrigio get_datos_precio para mandar un empty array.
  --------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar  Fecha:25/10/2022, Codigo: GAN-MS-A1-0069
  Descripcion: se realizo la funcion "validacion_cod_alternativo"
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:16/11/2022,  GAN-CV-A4-0107
  Descripcion: Se modifico la funcion get_datos_precio para un mejor manejo y utilizacion de datos obtenidos de la base de datos
  ------------------------------------------------------------------------------
  Modificado: Henry Quispe Huayta Fecha:06/02/2023,  GAN-MS-B0-0219
  Descripcion: Se creo la funcion validacion_descripcion para validar los nuevos productos
  ------------------------------------------------------------------------------
  Modificado: Henry Quispe Huayta Fecha:09/02/2023,  GAN-MS-B0-0234
  Descripcion: Se adiciono una validacion extra a las funciones validacion y validacion_cod_alternativo
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Aguirre     Fecha:16/03/2023,  GAN-MS-B9-0356
  Descripcion: se adiciono el nombre de la columna pgarantia en la funcion get_products 
  para que ordene en la tabla.
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Aguirre     Fecha:16/03/2023,  ABC-FCL-B3-0009
  Descripcion: se corregir las columnes de min_existencia, unidad y acción que no 
  permitian aplicar el boton de ordenado.
  ------------------------------------------------------------------------------
  Modificado: Ayrton Jhonny Guevara Montaño     Fecha:15/05/2023,  GAN-MS-B1-0468
  Descripcion: se creo una condicional en insert producto y update_producto por un error de 
  sintaxis al no contar con el dato unidad y codigoSIN respectivamente.
----------------------------------------------------------------------------------------
-- Modificado: Dotnara Isable        Condori     Fecha:24/05/2023,  GAN-MS-B1-0487    --
-- Descripcion: Realizar el funcionamiento del guardado de caracteristcas Adicionales --
-- de un nuevo producto                                                               --
----------------------------------------------------------------------------------------
-- Modificado: Dotnara Isable  Condori           Fecha:29/05/2023,  GAN-MS-B1-0495    --
-- Descripcion: Realizar del modal de adicionales                                     --
----------------------------------------------------------------------------------------
-- Modificado: Dotnara Isable  Condori           Fecha:14/06/2023,  GAN-MS-B1-0487    --
-- Descripcion: Se agrego el editar y eliminar adicionales                            --
----------------------------------------------------------------------------------------
*/

class M_producto extends CI_Model
{

  public function get_categoria_cmb()
  {
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_categoria');
    return $query->result();
  }

  public function get_marca_cmb()
  {
    $this->db->where('apiestado', 'ELABORADO');
    $query = $this->db->get('cat_marca');
    return $query->result();
  }

  public function get_codsim_cmb()
  {
    $idlogin= $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_get_codsim_productos($idlogin)");
    return $query->result();
  }

  public function get_parametricas_cmb()
  {
    $idlogin= $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_get_parametricas($idlogin)");
    return $query->result();
  }

  public function get_products($postData = null, $usuario)
  {

    try {
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

      switch ($columnName) {
        case 'pnro':
          $ordernar = 'nro';
          break;
        case 'pmarca':
          $ordernar = 'marca';
          break;
        case 'pcategoria':
          $ordernar = 'categoria';
          break;
        case 'pcodigo':
          $ordernar = 'p.codigo';
          break;
        case 'pcodigo_alt':
          $ordernar = 'p.codigo_alt';
          break;
          // GAN-MS-B9-0356, Oscar Laura.
        case 'pgarantia':
          $ordernar = 'p.garantia';
          break;
          // FIN GAN-MS-B9-0356, Oscar Laura.
        case 'pproducto':
          $ordernar = 'productoname';
          break;
        case 'pcara':
          $ordernar = 'p.caracteristica';
          break;
        case 'pprecio':
          $ordernar = 'precio';
          break;
          // ABC-FCL-B3-0009, Oscar Laura.
        case 'pstock':
          $ordernar = 'min_stock';
          break;
        case 'punidad':
          $ordernar = 'id_unidad';
          break;
          // FIN ABC-FCL-B3-0009, Oscar Laura.
        case 'pestado':
          $ordernar = 'apiestado_prod';
          break;
          // ABC-FCL-B3-0009, Oscar Laura.
        case 'pimagen':
          $ordernar = 'imagen_prod';
          break;
          // FIN ABC-FCL-B3-0009, Oscar Laura.
        default:
          # code...
          break;
      }




      ## Search 
      $searchQuery = "";
      if ($searchValue != '') {
        $searchQuery = " pcategoria ilike '%" . $searchValue . "%' or pmarca ilike '%" . $searchValue . "%' or pcodigo ilike '%" . $searchValue . "%' or pcodigo_alt ilike '%" . $searchValue . "%' or pproducto ilike '%" . $searchValue . "%' or pcara ilike '%" . $searchValue . "%' or (pprecio::text) like '%" . $searchValue . "%' or pestado ilike '%" . $searchValue . "%'";
      }
      // GAN-SC-M4-399, 28-08-2022, Gary Valverde.
      $query = $this->db->query("SELECT * FROM fn_get_productos2 ($usuario,'$ordernar ','$columnSortOrder ',$rowperpage,$start,'$searchValue');");
      // FIN GAN-SC-M4-399, 28-08-2022, Gary Valverde.

      // GAN-SC-M4-399, 26-08-2022, Gary Valverde.
      $querytotal = $this->db->query("SELECT fn_total_productos($usuario) as total;");

      $queryfilter = $this->db->query("SELECT fn_total_prod_filtrados($usuario,'$searchValue') as total;");
      // FIN GAN-SC-M4-399, 26-08-2022, Gary Valverde.


      ## Total number of records without filtering
      //$query->select('count(*) as allcount');
      $records =  $query->result();
      $totales = $querytotal->result();
      $totalRecords = $totales[0]->total;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if ($searchQuery != '')
        $this->db->where($searchQuery);
      $totfilter =  $queryfilter->result();
      $totalRecordwithFilter = $totfilter[0]->total;

      ## Fetch records
      $this->db->select('*');
      if ($searchQuery != '')
        $this->db->where($searchQuery);
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records =  $query->result();;

      $data = array();

      $status = "Error";

      foreach ($records as $record) {


        $data[] = array(
          "pnro" => $record->nro,
          "pcategoria" => $record->categoria,
          "pmarca" => $record->marca,
          "pidprod" => $record->aidi,
          "pcodigo" => $record->codigo,
          "pcodigo_alt" => $record->codigo_alt,
          "pproducto" => $record->productoname,
          "pcara" => $record->caracteristica,
          "pprecio" => $record->precio,
          "pstock" => $record->min_stock,
          // GAN-SC-A2-0009, 4/10/2022 PBeltran.
          "punidad" => $record->id_unidad,
          //FIN GAN-SC-A2-0009, 4/10/2022 PBeltran.
          "pestado" => $record->apiestado_prod,
          "pimagen" => $record->imagen_prod,
          "pgarantia" => $record->garantia
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
    } catch (Exception $error) {
      $log['error'] = $error;
    }
  }
   // DCondori 24-05-2023 GAN-MS-B1-0487
  public function insert_producto($data, $adicionales)
  {
    $idcategoria = $data['id_categoria'];
    $id_marca = $data['id_marca'];
    $codigo = $data['codigo'];
    $codigo_alt = $data['codigo_alt'];
    $descripcion = $data['descripcion'];
    $caracteristica = $data['caracteristica'];
    $imagen = $data['imagen'];
    $codsin = $data['codsin'];
    $id_unidades = $data['unidades'];
    $usucre = $data['usucre'];
    $garantia = $data['garantia'];

    if ($codsin==NULL) {
      $codsin=0;
    }
      /*Ayrton Guevara 15-05-2023 GAN-MS-B1-0468*/
    if($id_unidades == null ){
      $id_unidades = 'null';
    }
    /*FIN Ayrton Guevara 15-05-2023 GAN-MS-B1-0468*/

    $x="SELECT * FROM fn_registrar_productos($idcategoria,$id_marca,$id_unidades, '$codigo' , '$codigo_alt','$descripcion', '$caracteristica',$codsin,'$imagen','$usucre','$garantia', '$adicionales'::json)";
    $query = $this->db->query("SELECT * FROM fn_registrar_productos($idcategoria,$id_marca,$id_unidades, '$codigo' , '$codigo_alt','$descripcion', '$caracteristica',$codsin,'$imagen','$usucre','$garantia', '$adicionales'::json)");
    return $query->result();
  }
  //FIN DCondori 24-05-2023 GAN-MS-B1-0487

  public function cambiar_precio($id_prod, $idus, $newprecio)
  {
    // GAN-SC-M5-400, 29/08/2022 Deivit Pucho
    // Reemplazo de query por una funcion llamada fn_cambiar_precio_producto
    $query = $this->db->query("SELECT * FROM fn_cambiar_precio_producto($id_prod,$idus,$newprecio);");
    // Fin GAN-SC-M5-400, 29/08/2022 Deivit Pucho
    return $this->db->affected_rows();
  }
  public function cambiar_existencia($id_prod, $newstock, $idus)
  {
    $query = $this->db->query("SELECT * FROM fn_modificar_min_stock($id_prod,$newstock,$idus);");
    return $this->db->affected_rows();
  }
  // GAN-SC-A0-0035, 7/10/2022 PBeltran.
  public function cambiar_unidad($id_prod, $newunit, $idus)
  {
    $query = $this->db->query("SELECT * FROM fn_cambiar_unidad_producto($id_prod,$newunit,'$idus');");
    return $this->db->affected_rows();
  }
  // FIN GAN-SC-A0-0035, 7/10/2022 PBeltran.
// GAN-MS-B1-0495, 14/06/2023 DCondori
  public function update_producto($where, $data, $adicionales)
  {
    $id_producto = $where['id_producto'];
    $idcategoria = $data['id_categoria'];
    $id_marca = $data['id_marca'];
    $codigo = $data['codigo'];
    $codigo_alt = $data['codigo_alt'];
    $descripcion = $data['descripcion'];
    $caracteristica = $data['caracteristica'];
    $imagen = $data['imagen'];
    $codsin = $data['codsin'];
    $id_unidades = $data['unidades'];
    $usucre = $data['usucre'];
    $garantia = $data['garantia'];

    /*Ayrton Guevara 15-05-2023 GAN-MS-B1-0468*/
    if($codsin == null){
      $codsin = 0;
    }
    if($id_unidades == null ){
      $id_unidades = 'null';
    }
    /*FIN Ayrton Guevara 16-05-2023 */
    $query = $this->db->query("SELECT * FROM fn_update_producto($id_producto,$idcategoria,$id_marca,$id_unidades, '$codigo' , '$codigo_alt','$descripcion', '$caracteristica',$codsin,'$imagen','$usucre','$garantia','$adicionales'::json)");
    // FIN GAN-MS-B1-0495, 14/06/2023 DCondori
    return $query->result();
  }


  public function get_cod_producto($id_prod)
  {
    $this->db->where('id_producto', $id_prod);
    $query = $this->db->get('cat_producto');
    return $query->row('codigo');
  }

  public function get_datos_producto($id_cat)
  {
    $this->db->where('id_producto', $id_cat);
    $query = $this->db->get('cat_producto');
    return $query->row();
  }

  public function get_datos_precio($id_producto)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_calcular_precio($id_producto,$id_usuario)");
    return $query->result();
  }

  public function delete_producto($id_cat, $data)
  {
    //GAN-SC-M5-406, 30/08/2022  AUchani
    //Variables para extracción
    $vdata = array_values($data);
    $vapiestado = $vdata[0];
    $vusumod = $vdata[1];

    $query = $this->db->query("SELECT * FROM fn_delete_producto($id_cat, '$vapiestado', '$vusumod')");
    //Fin GAN-SC-M5-406, 30/08/2022  AUchani
  }

  //GAN-MS-A1-0069 27/10/2022 LPari
  public function validacion($codigo)
  {
    $query = $this->db->query("SELECT codigo FROM CAT_PRODUCTO WHERE CODIGO ilike trim('$codigo') UNION ALL SELECT codigo FROM CAT_PRODUCTO WHERE CODIGO_ALT ilike trim('$codigo') UNION ALL SELECT codigo FROM CAT_ITEM WHERE CODIGO ilike trim('$codigo')");
    return $query->num_rows();
  }
  //FIN GAN-MS-A1-0069 27/10/2022 LPari

  //GAN-MS-A1-0069 25/10/2022 LPari
  public function validacion_cod_alternativo($codigo_alt)
  {
    $query = $this->db->query("SELECT codigo FROM CAT_PRODUCTO WHERE CODIGO ilike trim('$codigo_alt') UNION ALL SELECT codigo FROM CAT_PRODUCTO WHERE CODIGO_ALT ilike trim('$codigo_alt') UNION ALL SELECT codigo FROM CAT_ITEM WHERE CODIGO ilike trim('$codigo_alt')");
    return $query->num_rows();
  }
  //Fin GAN-MS-A1-0069 25/10/2022 LPari

  public function validacion_descripcion($descripcion)
  {
    $query = $this->db->query("SELECT * FROM CAT_PRODUCTO WHERE DESCRIPCION = '$descripcion'");
    return $query->num_rows();
  }

  // GAN-MS-A1-0051, 21/10/2022 PBeltran
  public function get_datos_precios_prod2($id_producto)
  {
    $query = $this->db->query("SELECT * FROM fn_get_precios('$id_producto');");
    $records =  $query->result();
    $data = array();
    $response = array();
    if (!empty($records)) {

      foreach ($records as $record) {


        $data[] = array(
          "pidprecio" => $record->oidprecio,
          "pdescripcion" => $record->odescripcion,
          "pprecio" => $record->oprecio,
          "pusucre" => $record->ousucre
        );
      }
      $response = array(
        "aaData" => $data
      );
    } else {
      // GAN-MS-A1-0064, 21/10/2022 PBeltran
      $response = array(
        "aaData" => []
      );
      // FIN GAN-MS-A1-0064, 21/10/2022 PBeltran
    }

    return $response;
  }
// GAN-MS-B1-0495, 29/05/2023 DCondori
  public function get_datos_caracteristicas_prod($id_producto)
  {
    $query = $this->db->query("SELECT * FROM fn_get_adicionales('$id_producto');");
    $records =  $query->result();
    $data = array();
    $response = array();
    if (!empty($records)) {
      foreach ($records as $record) {
        $data[] = array(
          "didcaracteristicas" => $record->didcaracteristicas,
          "dtipo" => $record->dtipo,
          "ddetalle" => $record->ddetalle,
          "dusucre" => $record->dusucre
        );
      }
      $response = array(
        "aaData" => $data
      );
    } else {
      $response = array(
        "aaData" => []
      );
    }
    return $response;
  }
  //FIN GAN-MS-B1-0495, 29/05/2023 DCondori

  public function insert_precios_prod($data)
  {
    $id_producto = $data['id_producto'];
    $descripcion = $data['descripcion'];
    $precio = $data['precio'];
    $usuario = $data['usucre'];
    $query = $this->db->query("SELECT * FROM fn_registrar_precio('$id_producto','$descripcion',$precio,'$usuario');");
    return $query->result();
  }

  public function update_precios_prod($id_precio, $descripcion, $precio, $usuario)
  {
    $query = $this->db->query("SELECT * FROM fn_update_precio($id_precio,'$descripcion',$precio,'$usuario');");
    return $query->result();
  }

  public function delete_precios_prod($id_precio, $usuario)
  {
    $query = $this->db->query("SELECT * FROM fn_delete_precio($id_precio, '$usuario');");
    return $this->db->affected_rows();
  }
  // FIN GAN-MS-A1-0051, 21/10/2022 PBeltran

}
