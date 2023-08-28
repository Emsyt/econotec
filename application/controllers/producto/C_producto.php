<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:08/03/2022,  GAN-MS-A1-123
  Descripcion: Se agrego la funcion datos_precio que devuelve los valores de precio compra y precio venta
  --------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:06/05/2022, Codigo: GAN-FR-M3-227
  Descripcion: se implemento la impresion en pdf de los codigos de barras 
  --------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:27/06/2022, Codigo: GAN-FR-A6-278
  Descripcion: Se añadio la funcion change_exis para modificar el minimo de existencias.
    --------------------------------------------------------------------------
  Modificado: karen quispe chavez  Fecha:26/07/2022, Codigo: GAN-PB-A1-316
  Descripcion: Se añadio la funcion fn_registrar producto para poder arreglar el doble registro
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Pedro Rodrigo Beltran Poma.   Fecha:26/08/2022,   Codigo: GAN-SC-M4-398,
  Descripcion: Se ajusto la funcion add_update_producto() para que funcione acorde a la modificacion hecha 
  en M_producto.
    --------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha:29/08/2022, Codigo: GAN-SC-M5-400
  Descripcion: Se añadio la funcion fn_cambiar_precio_producto para poder cambiar el precio del producto.
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:4/10/2022, Codigo: GAN-MS-A2-0009
  Descripcion: Se modifico la funcion add_update_producto para aceptar un nuevo campo 'id_unidad'
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:7/10/2022, Codigo: GAN-MS-A0-0035
  Descripcion: se añadio la funcion change_unit 
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:21/10/2022, Codigo: GAN-MS-A1-0051
  Descripcion: se añadio las funciones para la creacion, modificacion y eliminacion de precios en cat_precios 
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:21/10/2022, Codigo: GAN-MS-A1-0064
  Descripcion: se corrigio el campo descripcion al enviar mas de 1 palabra.
  --------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar  Fecha:25/10/2022, Codigo: GAN-MS-A1-0069
  Descripcion: se realizo la funcion "validacion_cod_alt"
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:16/11/2022,  GAN-CV-A4-0107
  Descripcion: Se modifico la funcion datos_producto para corregir el error al intentar obtener datos de la funcion get_datos_precio
    ------------------------------------------------------------------------------
  Modificado: Alvaro Ruben Gonzales Vilte Fecha:23/11/2022,  GAN-MS-A4-0127
  Descripcion: Se modifico la funcion para cambiar el precio de un producto
  ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:02/12/2022,  GAN-MS-A7-0164
  Descripcion: Se modifico las funciones de registro y edicion del producto para guardar la garantia
  ------------------------------------------------------------------------------
  Modificado: Henry Quispe Huayta Fecha:06/02/2023,  GAN-MS-B0-0219
  Descripcion: Se creo la funcion validacion_descripcion para validar los nuevos productos
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
defined('BASEPATH') or exit('No direct script access allowed');

class C_producto extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');

        $this->load->library('upload');
        $this->load->model('producto/M_producto', 'producto');
        $this->load->library('Pdf_venta');
        // GAN-SC-A2-0009, 4/10/2022 PBeltran.
        $this->load->model('produccion/M_produccion', 'produccion');
        // FIN GAN-SC-A2-0009, 4/10/2022 PBeltran.
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['categorias'] = $this->producto->get_categoria_cmb();
            $data['marcas'] = $this->producto->get_marca_cmb();

            // GAN-SC-A2-0009, 4/10/2022 PBeltran.
            $data['unidad'] = $this->produccion->get_unidad();
            // FIN GAN-SC-A2-0009, 4/10/2022 PBeltran.
            /* FAC-MS-M4-0003 Gary Valverde  15-03-2023   */
            $data['codsim'] = $this->producto->get_codsim_cmb();
            $data['unidades'] = $this->producto->get_parametricas_cmb();
            /* FIN FAC-MS-M4-0003 Gary Valverde  15-03-2023  */

            $data['lib'] = 0;
            $data['datos_menu'] = $log;

            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'producto/producto';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    public function products()
    {
        try {
            $postData = $this->input->post();

            // Get data
            $data = $this->producto->get_products($postData, $this->session->userdata('id_usuario'));

            echo json_encode($data);
            // POST data
        } catch (Exception $uu) {
            $log['error'] = $uu;
        }
    }

    public function add_update_producto()
    {
        if ($this->input->post('btn') == 'add') {
            $codigo_prod = $this->input->post('codigo');
            $config['allowed_types'] = 'jpg|png|JPEG';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);

            if (!file_exists($_FILES['img_producto']['tmp_name']) || !is_uploaded_file($_FILES['img_producto']['tmp_name'])) {
                $newName = NULL;
                $val_mostrar = FALSE;
            } else {
                $extension = explode('.', $_FILES['img_producto']['name']);
                $newName = $codigo_prod . '.' . $extension[1];
                $destination = './assets/img/productos/' . $newName;
                move_uploaded_file($_FILES['img_producto']['tmp_name'], $destination);
                $val_mostrar = TRUE;
            }

            $data = array(
                'id_categoria' => $this->input->post('categoria'),
                'id_marca' => $this->input->post('marca'),
                'codigo' => $this->input->post('codigo'),
                'codigo_alt' => $this->input->post('codigo_alt'),
                'descripcion' => $this->input->post('producto'),
                'caracteristica' => $this->input->post('caracteristica'),
                'imagen' => $newName,
                'codsin' => $this->input->post('codsin'),
                'unidades' => $this->input->post('unidades'),
                'usucre' => $this->session->userdata('usuario'),
                'garantia' => $this->input->post('guarantee')
            );
            // DCondori 24-05-2023 GAN-MS-B1-0487
            $adicionales = array();
            $count0n = $this->input->post('count0');
            $conAddicionales = $this-> input->post('con_adicionales');
            if($conAddicionales){
                for ($i = 0; $i <= $this->input->post('count0'); $i++) {
                    if ($this->input->post('tipo' . $i) != null) {
                        $objeto = new stdClass();
                        $objeto->tipo = $this->input->post('tipo' . $i);
                        $objeto->detalle = $this->input->post('detalle' . $i);
                        $adicionales[] = $objeto;
                    }
                }
            }
            $json = json_encode(array(
                'adicionales' => $adicionales
            ), JSON_UNESCAPED_UNICODE);
            $prod_insert = $this->producto->insert_producto($data, $json);
            //FIN DCondori 24-05-2023 GAN-MS-B1-0487

            if ($prod_insert[0]->oboolean == 't') {
                $this->session->set_flashdata('success', 'Registro insertado exitosamente.');
            } else {
                $this->session->set_flashdata('error', $prod_insert[0]->omensaje);
            }
        } elseif ($this->input->post('btn') == 'edit') {
            $codigo_prod = $this->input->post('codigo');

            $config['allowed_types'] = 'jpg|png|JPEG';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);

            if ($_FILES['img_producto']['name'] == '') {
                $newName = $this->input->post('imagen');
            } else {
                $extension = explode('.', $_FILES['img_producto']['name']);
                $newName = $codigo_prod . '.' . $extension[1];
                $destination = './assets/img/productos/' . $newName;
                move_uploaded_file($_FILES['img_producto']['tmp_name'], $destination);
            }

            $data = array(
                'id_categoria' => $this->input->post('categoria'),
                'id_marca' => $this->input->post('marca'),
                'codigo' => $codigo_prod,
                'codigo_alt' => $this->input->post('codigo_alt'),
                'descripcion' => $this->input->post('producto'),
                'caracteristica' => $this->input->post('caracteristica'),
                'codsin' => $this->input->post('codsin'),
                'unidades' => $this->input->post('unidades'),
                'imagen' => $newName,
                'usumod' => $this->session->userdata('usuario'),
                'fecmod' => date('Y-m-d H:i:s'),
                'precio' => $this->input->post('precio'),
                'garantia' => $this->input->post('guarantee')
            );
            // GAN-MS-B1-0495, 14/06/2023 DCondori
            $adicionales = array();
            $count0n = $this->input->post('count0');
            $conAddicionales = $this-> input->post('con_adicionales');
            if($conAddicionales){
                for ($i = 0; $i <= $this->input->post('count0'); $i++) {
                    if ($this->input->post('tipo' . $i) != null) {
                        $objeto = new stdClass();
                        $objeto->tipo = $this->input->post('tipo' . $i);
                        $objeto->detalle = $this->input->post('detalle' . $i);
                        $adicionales[] = $objeto;
                    }
                }
            }
            $json = json_encode(array(
                'adicionales' => $adicionales
            ), JSON_UNESCAPED_UNICODE);
            $prod_update = $this->producto->update_producto(array('id_producto' => $this->input->post('id_producto')), $data,$json);

            $id_prod = $this->input->post('id_producto');
            $precio_actual = $this->producto->get_datos_precio($id_prod);
            $precio_actual =  $precio_actual[0]->round;
            $precio_nuevo = $this->input->post('precio');

            $idus = $this->session->userdata('id_usuario');
            if ($precio_nuevo != null) {
                $this->producto->cambiar_precio($id_prod, $idus, $precio_nuevo);
            }
            // GAN-SC-M4-398, 26/08/2022 PBeltran.
            // extrae el valor resultante true o false de update_producto
            $vVerificar = false;
            foreach ($prod_update as $row) {
                $vVerificar = $row->oboolean;
            }
            // FIN GAN-SC-M4-398, 26/08/2022 PBeltran.
            if ($vVerificar) {
                $this->session->set_flashdata('success', 'Registro modificado exitosamente.');
            } else {
                $this->session->set_flashdata('error', 'Error al modificar registro.');
            }
        }
        redirect('producto');
    }

    public function dlt_producto($id_prod, $estado)
    {
        if ($estado == 'ELABORADO') {
            $estado_act = 'ELIMINADO';
        } else {
            $estado_act = 'ELABORADO';
        }
        $data = array(
            'apiestado' => $estado_act,
            'usumod' => $this->session->userdata('usuario'),
            'fecmod' => date('Y-m-d H:i:s')
        );
        $this->producto->delete_producto($id_prod, $data);
        redirect('producto');
    }

    public function change_price($id_prod, $newprecio)
    {
        $idus = $this->session->userdata('id_usuario');
        $resultado = $this->producto->cambiar_precio($id_prod, $idus, $newprecio);
        if ($resultado !== 0) {

            // GAN-SC-M5-400 29/08/2022 Deivit Pucho
            // Se quito $resultado de set_flashdata
            $this->session->set_flashdata('success', 'Registro modificado exitosamente.');
            redirect('producto');
            // Fin GAN-SC-M5-400 29/08/2022 Deivit Pucho
        } else {
            //redirect('marca'); 
        }
    }
    public function change_exis($id_prod, $newstock)
    {
        $idus = $this->session->userdata('id_usuario');
        $resultado = $this->producto->cambiar_existencia($id_prod, $newstock, $idus);
        if ($resultado !== 0) {

            $this->session->set_flashdata('success', 'Registro modificado exitosamente.' + $resultado);
            redirect('producto');
        }
    }

    // GAN-SC-A0-0035, 7/10/2022 PBeltran.
    public function change_unit($id_prod, $newunit)
    {
        $idus = $this->session->userdata('usuario');
        $resultado = $this->producto->cambiar_unidad($id_prod, $newunit, $idus);
        if ($resultado !== 0) {

            $this->session->set_flashdata('success', 'Registro modificado exitosamente.');
            redirect('producto');
        }
    }
    // FIN GAN-SC-A0-0035, 7/10/2022 PBeltran.

    public function datos_producto($id_prod)
    {
        $data = $this->producto->get_datos_producto($id_prod);
        $precio = $this->producto->get_datos_precio($id_prod);
        $caracteristicas = $this->producto->get_datos_caracteristicas_prod($id_prod);
        $data = array(
            'datos' => $data,
            'precio' => $precio[0]->fn_calcular_precio,
            'caracteristicas' => $caracteristicas
        );
        //FIN GAN-MS-B1-0495, 14/06/2023 DCondori
        echo json_encode($data);
    }
    public function pdf()
    {
        $id_barcode = $this->input->post('id_barcode');
        $cantidad_barcode = $this->input->post('cantidad_barcode');
        $id_usuario = $this->session->userdata('id_usuario');

        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
            $pdfFontSizeData = PDF_FONT_SIZE_DATA;
            $pdfSize = PDF_PAGE_FORMAT;
            $pdfFontSizeMain = PDF_FONT_SIZE_MAIN;
            $footerMargin = true;
            $marginz = 5;
        } else {
            $heightPaper = 80;
            if ($cantidad_barcode > 2) {
                $heightPaper = ($cantidad_barcode) * 35.2;
            }
            $pdfSize = array(80, $heightPaper);
            $pdfFontSizeMain = 9;
            $pdfFontSizeData = 8;
            $footerMargin = false;
            $marginz = 0;
        }
        $pdf = new Pdf_venta(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Código de barras');
        $pdf->SetSubject('Código de barras');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0, 75, 146), array(0, 75, 146));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSize=''));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(10, 10, $marginz);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(10);

        $pdf->SetAutoPageBreak($footerMargin, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);

        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);

        $pdf->SetFont('times', '', $pdfFontSizeMain, '', true);
        $pdf->AddPage('P', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $style = array(
            'position' => '',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false,
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 5,
        );
        if ($id_papel[0]->oidpapel == 1304) {
            $x = 7;
            $y = 10;
            if (strlen($id_barcode) > 16) {
                $s = 95;
                $l = 120;
                $d = '99';
                if (strlen($id_barcode) > 26) {
                    $s = 100;
                    $l = 100;
                    $d = '';
                }
            } else {
                if (strlen($id_barcode) > 11) {
                    $s = 65;
                    $l = 150;
                    $d = '65';
                } else {
                    $s = 50;
                    $l = 200;
                    $d = '';
                    if (strlen($id_barcode) < 8) {
                        $s = 40;
                        $l = 200;
                        $d = '41';
                    }
                }
            }

            for ($i = 0; $i < $cantidad_barcode; $i++) {

                $pdf->write1DBarcode($id_barcode, 'C93', $x, $y, $d, 28, 0.34, $style, 'N');
                $x = $x + $s;
                if ($x > $l) {
                    $x = 7;
                    $y = $y + 30;
                }
                if ($y > 240) {
                    $y = 10;
                    if ($i != $cantidad_barcode - 1) {
                        $pdf->AddPage();
                    }
                }
            }
        } else {
            if (strlen($id_barcode) > 13) {
                $x = 0;
            } else {
                $x = 10;
            }
            $y = 3;
            for ($i = 0; $i < $cantidad_barcode; $i++) {
                $pdf->write1DBarcode($id_barcode, 'C93', $x, $y, '', 34, 0.34, $style, 'N');
                $y = $y + 35;
            }
        }
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Barcode.pdf', 'I');
    }


    // GAN-MS-A1-0051, 21/10/2022 PBeltran
    //------ FUNCIONES PRECIO ---------//
    public function add_update_precio()
    {
        if ($this->input->post('btn') == 'add') {
            $codigo_prod = $this->input->post('codigo');

            $data = array(
                'id_producto' => $this->input->post('id_producto'),
                'descripcion' => $this->input->post('descripcion'),
                'precio' => $this->input->post('precio'),
                'usucre' => $this->session->userdata('usuario')
            );

            $prod_insert = $this->producto->insert_precios_prod($data);

            if ($prod_insert[0]->oboolean == 't') {
                $this->session->set_flashdata('success', 'Registro insertado exitosamente.');
            } else {
                $this->session->set_flashdata('error', $prod_insert[0]->omensaje);
            }
        } elseif ($this->input->post('btn') == 'edit') {
            $codigo_prod = $this->input->post('codigo');

            $data = array(
                'id_producto' => $this->input->post('id_producto'),
                'descripcion' => $this->input->post('descripcion'),
                'precio' => $this->input->post('precio'),
                'usumod' => $this->session->userdata('usuario')
            );
            $prod_update = $this->producto->update_precios_prod($data);

            // extrae el valor resultante true o false de update_producto
            $vVerificar = false;
            foreach ($prod_update as $row) {
                $vVerificar = $row->oboolean;
            }
            if ($vVerificar) {
                $this->session->set_flashdata('success', 'Registro modificado exitosamente.');
            } else {
                $this->session->set_flashdata('error', 'Error al modificar registro.');
            }
        }
        redirect('producto');
    }

    public function dlt_precios($id_precio)
    {
        $this->producto->delete_precios_prod($id_precio, $this->session->userdata('usuario'));
        redirect('producto');
    }

    public function precios($id_prod)
    {
        try {

            // Get data
            $data = $this->producto->get_datos_precios_prod2($id_prod);

            echo json_encode($data);
            // POST data
        } catch (Exception $uu) {
            $log['error'] = $uu;
        }
    }
    // GAN-MS-B1-0495, 29/05/2023 DCondori
    public function list_adicionales($id_prod)
    {
        try {
            // Get data
            $data = $this->producto->get_datos_caracteristicas_prod($id_prod);
            echo json_encode($data);
            // POST data
        } catch (Exception $uu) {
            $log['error'] = $uu;
        }
    }
    //FIN GAN-MS-B1-0495, 29/05/2023 DCondori

    public function add_precio()
    {

        $data = array(
            'id_producto' => $this->input->post('id_producto1'),
            'descripcion' => $this->input->post('descripcion'),
            'precio' => $this->input->post('precio'),
            'usucre' => $this->session->userdata('usuario')
        );

        $prod_insert = $this->producto->insert_precios_prod($data);

        if ($prod_insert[0]->oboolean == 't') {
            $this->session->set_flashdata('success', 'Registro insertado exitosamente.');
        } else {
            $this->session->set_flashdata('error', $prod_insert[0]->omensaje);
        }
        redirect('producto');
    }

    public function mod_precio($idprecio, $descripcion, $precio)
    {
        // GAN-MS-A1-0064, 21/10/2022 PBeltran
        $descrip = urldecode($descripcion);
        // FIN GAN-MS-A1-0064, 21/10/2022 PBeltran
        $prod_update = $this->producto->update_precios_prod($idprecio, $descrip, $precio, $this->session->userdata('usuario'));

        $vVerificar = false;
        foreach ($prod_update as $row) {
            $vVerificar = $row->oboolean;
        }
        if ($vVerificar) {
            $this->session->set_flashdata('success', 'Registro modificado exitosamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al modificar registro.');
        }
        redirect('producto');
    }
    // FIN GAN-MS-A1-0051, 21/10/2022 PBeltran



    //------- FUNCIONES AUXILIARES -------//
    public function func_auxiliares()
    {
        try {
            $accion = $_REQUEST['accion'];
            if (empty($accion))
                throw new Exception("Error accion no valida");
            switch ($accion) {
                case 'val_codigo':
                    $codigo = $this->input->post('text_cod');
                    $query = $this->producto->validacion($codigo);
                    echo $query;
                    break;

                default;
                    echo 'Error: Accion no encontrada';
            }
        } catch (Exception $e) {
            $log['error'] = $e;
        }
    }
    //GAN-MS-A1-0069 25/10/2022 LPari
    public function validacion_cod_alt()
    {
        try {
            $accion = $_REQUEST['accion'];
            if (empty($accion))
                throw new Exception("Error accion no valida");
            switch ($accion) {
                case 'val_codigo_alt':
                    $codigo_alt = $this->input->post('text_cod_alt');
                    $query = $this->producto->validacion_cod_alternativo($codigo_alt);
                    echo $query;
                    break;

                default;
                    echo 'Error: Accion no encontrada';
            }
        } catch (Exception $e) {
            $log['error'] = $e;
        }
    }
    //Fin GAN-MS-A1-0069 25/10/2022 LPari

    public function validacion_descripcion()
    {
        try {
            $accion = $_REQUEST['accion'];
            if (empty($accion))
                throw new Exception("Error accion no valida");
            switch ($accion) {
                case 'val_descripcion':
                    $descripcion = $this->input->post('text_descripcion');
                    $query = $this->producto->validacion_descripcion($descripcion);
                    echo $query;
                    break;

                default;
                    echo 'Error: Accion no encontrada';
            }
        } catch (Exception $e) {
            $log['error'] = $e;
        }
    }
}
