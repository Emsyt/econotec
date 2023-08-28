<?php
/*
  Modificado: Brayan Janco Cahuana Fecha:27/09/2021, Codigo: GAN-MS-A4-038,
  Descripcion: Se modifico para crear la funcion generar_pdf_cotizacion para obtener un pdf de tcpdf
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha:26/02/2023,  GAN-MS-B1-0500
  Descripcion: Se creo la funcion listar_menus() para poder ser consimida desde Ajax y no tener que recargar la pagina.
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha:26/02/2023,  GAN-MS-B1-0500
  Descripcion: Se mejoro la funcion listar_all_productos_categoria() para poder consumir por Ajax 
  obtener todos los productos de las categorias de un menu.
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha:12/06/2023,  GAN-MS-M0-0513
  Descripcion: Se creo la funcion lista_mesas() para obtener las mesas creadas en Administracion.
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha:12/06/2023,  GAN-MS-M4-0517
  Descripcion: Se creo la funcion get_lst_venta() para listar las ventas en estado PENDIENTE y 
  dlt_ventas() para cambiar su estado en ANULADO.
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha:26/06/2023,  GAN-MS-M0-0524
  Descripcion: Se implemento la funcionalidad para editar la cantidad de un pedido.
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha:03/07/2023,  GAN-MS-M4-0529
  Descripcion: Se implemento la funcionalidad para finalizar e imprimir pedido.
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha:13/07/2023,  GAN-MS-M3-0531
  Descripcion: Se corrigio el error de las cantidades al agregar productos al detalle del pedido.
*/
defined('BASEPATH') or exit('No direct script access allowed');

class C_venta_grafica extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('venta/M_venta_grafica', 'venta_grafica');
    $this->load->library('Pdf_venta');
  }

  public function index() {
    if ($this->session->userdata('login')) {
      $log['permisos'] = $this->session->userdata('permisos');
      $usr = $this->session->userdata('usuario');
      $data['lst_categorias'] = $this->venta_grafica->get_categoria();
      $data['lst_menus'] = $this->venta_grafica->get_listar_menus();
      $data['lst_estados'] = $this->venta_grafica->listar_estados();

      $data['lib'] = 0;
      $data['datos_menu'] = $log;
      $data['cantidadN'] = $this->general->count_notificaciones();
      $data['lst_noti'] = $this->general->lst_notificacion();
      $data['titulo'] = $this->general->get_ajustes("titulo");
      $data['thema'] = $this->general->get_ajustes("tema");
      $data['descripcion'] = $this->general->get_ajustes("descripcion");
      $data['contenido'] = 'venta/venta_grafica';
      $this->load->view('templates/estructura', $data);
    } else {
      redirect('logout');
    }
  }

  // GAN-MS-B1-0500, 26/05/2023 ILaquis.
  public function listar_menus() {
    $data = $this->venta_grafica->get_listar_menus();
    echo json_encode($data);
  }
  // FIN GAN-MS-B1-0500, 26/05/2023 ILaquis.

  // GAN-MS-B3-0501, 26/05/2023 ILaquis.
  public function listar_all_productos_categoria() {
    $data = $this->input->post('id_menu');
    $data = $this->venta_grafica->categorias_menu($data);
    foreach ($data as $item) {
      $id_cat[] = $item->oidcategoria;
    }
    $todos_productos = [];
    for ($i = 0; $i < count($id_cat); $i++) {
      $productos = $this->venta_grafica->listar_productos_categoria($id_cat[$i]);
      $todos_productos = array_merge($todos_productos, $productos);
    }
    echo json_encode($todos_productos);
  }
  // FIN GAN-MS-B3-0501, 26/05/2023 ILaquis.

  public function listar_productos_categoria() {
    $data = $this->input->post('id_categoria');
    $data = $this->venta_grafica->listar_productos_categoria($data);
    echo json_encode($data);
  }

  public function registrar_menu() {
    $nombre = $this->input->post('nombre');
    $categorias = $this->input->post('categorias');
    $categorias = explode("-", $categorias);
    for ($i = 0; $i < count($categorias); $i++) {
      $categoria = explode(",", $categorias[$i]);
      $data[$i]['id_categoria'] = (int)$categoria[0];
      $data[$i]['color'] = $categoria[1];
    }

    $array = array(
      "nombre" => $this->input->post('nombre'),
      "categorias" => json_encode($data),
    );
    $json = json_encode($array);
    $data = $this->venta_grafica->registrar_menu(0, $json);
    echo json_encode($data);
  }

  public function get_categorias_menu() {
    $data = $this->input->post('id_menu');
    $data = $this->venta_grafica->categorias_menu($data);
    echo json_encode($data);
  }

  public function get_mov_inventario() {
    $id_prod = $this->input->post('id_prod');
    $data = $this->venta_grafica->mov_inventario($id_prod);
    echo json_encode($data);
  }

  public function mostrar_producto_grafico() {
    $id_prod = $this->input->post('id_prod');
    $cantidad = $this->input->post('cantidad');
    $data = $this->venta_grafica->mostrar_producto_grafico($id_prod, $cantidad);
    echo json_encode($data);
  }

  public function cambiar_estado_producto() {
    $id_prod = $this->input->post('id_prod');
    $num = $this->input->post('num');
    $data = $this->venta_grafica->cambiar_estado_producto($id_prod, $num);
    echo json_encode($data);
  }

  public function eliminar_menu() {
    $id_menu = $this->input->post('id_menu');
    $data = $this->venta_grafica->eliminar_menu($id_menu);
    echo json_encode($data);
  }

  // GAN-MS-M0-0513, 12/06/2023 ILaquis.
  public function lista_mesas() {
    $id_usuario = $this->session->userdata('id_usuario');
    $data = $this->venta_grafica->get_lst_mesas($id_usuario);
    echo json_encode($data);
  }
  // FIN GAN-MS-M0-0513, 12/06/2023 ILaquis.
  // GAN-MS-M4-0517, 14/06/2023 ILaquis.
  public function dlt_venta($id_prod) {
    $id_usuario = $this->session->userdata('id_usuario');
    $sol_delete = $this->venta_grafica->delete_venta($id_usuario, $id_prod);
    echo json_encode($sol_delete);
  }

  public function get_lst_venta() {
    $id_usuario = $this->session->userdata('id_usuario');
    $data = $this->venta_grafica->get_lst_venta($id_usuario);
    echo json_encode($data);
  }
  // FIN GAN-MS-M4-0517, 14/06/2023 ILaquis.

  // GAN-MS-M0-0519, 16/06/2023 ILaquis.
  public function asignar_mesa() {
    $id_mesa = $this->input->post('id_mesa');
    $id_usuario = $this->session->userdata('id_usuario');
    $lote_pendiente = $this->venta_grafica->get_ultimo_lote_pendiente($id_usuario);
    $lote_actual = $this->venta_grafica->get_ultimo_lote_mesa($id_mesa, $id_usuario);
    // Si lote_actual esta vacio, insertamos todo
    if (empty($lote_actual)) {
      $idventas = array_map(function ($item) {
        return $item->id_venta;
      }, $lote_pendiente);

      $cantidades = array_map(function ($item) {
        return $item->cantidad;
      }, $lote_pendiente);
      $this->venta_grafica->actualizar_mov_movimiento($id_usuario);
      $data = $this->venta_grafica->asignar_mesa($id_usuario, $idventas, $cantidades, $id_mesa, 0);
      echo json_encode($data);
    } else {
      $this->venta_grafica->actualizar_mov_movimiento($id_usuario);
      // Obtener las coincidencias por id_producto
      $coincidencias = array_intersect(array_column($lote_pendiente, 'id_producto'), array_column($lote_actual, 'id_producto'));

      // Obtener las diferencias por id_producto
      $diferencias = array_diff(array_column($lote_pendiente, 'id_producto'), array_column($lote_actual, 'id_producto'));

      // Coincidencias en pendiente
      $array3 = array_filter($lote_pendiente, function ($item) use ($coincidencias) {
        return in_array($item->id_producto, $coincidencias);
      });
      // Diferencias en pendiente
      $array4 = array_filter($lote_pendiente, function ($item) use ($diferencias) {
        return in_array($item->id_producto, $diferencias);
      });

      // Coincidencias en actual
      $array5 = array_filter($lote_actual, function ($item) use ($coincidencias) {
        return in_array($item->id_producto, $coincidencias);
      });

      // Anulamos lo que coincide de pendiente
      $idventas_3 = array_map(function ($item) {
        return $item->id_venta;
      }, $array3);

      $cantidades_3 = array_map(function ($item) {
        return $item->cantidad;
      }, $array3);

      if (!empty($array3)) {
        $data = $this->venta_grafica->asignar_mesa($id_usuario, $idventas_3, $cantidades_3, $id_mesa, 2);
      }

      // Insertamos las diferencias de pendiente
      $idventas_4 = array_map(function ($item) {
        return $item->id_venta;
      }, $array4);

      $cantidades_4 = array_map(function ($item) {
        return $item->cantidad;
      }, $array4);

      if (!empty($array4)) {
        $data = $this->venta_grafica->asignar_mesa($id_usuario, $idventas_4, $cantidades_4, $id_mesa, 0);
      }

      // Acumulamos las coincidencias en actual
      $cantidades_new = array_map(function ($item) {
        return $item->cantidad;
      }, $array3);
      $cantidades_old = array_map(function ($item) {
        return $item->cantidad;
      }, $array5);

      $cantidades_new = array_values($cantidades_new);
      $cantidades_old = array_values($cantidades_old);

      $longitud = count($cantidades_new);

      $idventas_2 = array_map(function ($item) {
        return $item->id_venta;
      }, $array5);
      $idventas_2 = array_values($idventas_2);

      // Realizar la suma elemento por elemento y agregar al nuevo array
      for ($i = 0; $i < $longitud; $i++) {
        $valor1 = intval($cantidades_new[$i]);
        $valor2 = intval($cantidades_old[$i]);
        $cantidades_2[] = strval($valor1 + $valor2);
      }
      if (!empty($idventas_2)) {
        $data = $this->venta_grafica->asignar_mesa($id_usuario, $idventas_2, $cantidades_2, $id_mesa, 1);
      }
      echo json_encode($data);
    }
  }

  public function get_lst_detalle_mesa() {
    $id_mesa = $this->input->post('id_mesa');
    $id_usuario = $this->session->userdata('id_usuario');
    $data = $this->venta_grafica->get_lst_detalle_mesa($id_usuario, $id_mesa);
    echo json_encode($data);
  }
  // FIN GAN-MS-M0-0519, 16/06/2023 ILaquis.

  // GAN-MS-M0-0524, 26/06/2023 ILaquis.
  public function editar_mesa() {
    $id_mesa = $this->input->post('id_mesa');
    $id_usuario = $this->session->userdata('id_usuario');
    $data = $this->venta_grafica->editar_mesa($id_mesa, $id_usuario);
    echo json_encode($data);
  }

  public function datos_pedido() {
    $id_venta = $this->input->post('id_venta');
    $id_producto = $this->input->post('id_producto');
    $id_mesa = $this->input->post('id_mesa');
    $id_usuario = $this->session->userdata('id_usuario');
    $data = $this->venta_grafica->get_datos_pedido($id_venta, $id_producto, $id_mesa, $id_usuario);
    echo json_encode($data);
  }

  public function update_pedido() {
    $id_venta = $this->input->post('id_venta');
    $cant_pedido = $this->input->post('cant_pedido');
    $data = $this->venta_grafica->modificar_pedido($id_venta, $cant_pedido);
    echo json_encode($data);
  }
  // GAN-MS-M0-0524, 26/06/2023 ILaquis.
  // GAN-MS-M4-0529, 03/07/2023 ILaquis.
  public function realizar_cobro() {
    $id_mesa = $this->input->post('id_mesa');
    $id_usuario = $this->session->userdata('id_usuario');
    $data = $this->venta_grafica->realizar_cobro($id_mesa, $id_usuario);
    echo json_encode($data);
  }

  public function generar_pdf_pedido() {
    $id_mesa = $this->input->post('id_mesa_pedido');
    $id_usuario = $this->session->userdata('id_usuario');
    $nota_venta = $this->venta_grafica->get_mesa_pedido($id_mesa, $id_usuario);

    $ajustes = $this->general->get_ajustes("logo");
    $consi = $this->general->get_ajustes("consideracion");

    $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
    $logo = $ajuste->logo;
    $ajuste = json_decode($consi->fn_mostrar_ajustes);
    $consideracion = $ajuste->consideracion;

    $id_usuario = $this->session->userdata('id_usuario');
    $usuario = $this->session->userdata('usuario');
    $nombre = $this->session->userdata('name_ubicacion');
    $nombre_rsocial = '';
    $ci_nit = '';

    $lst_pedidos = $nota_venta;

    $codigo_vent = 0;
    $fecha = '';
    foreach ($lst_pedidos as $ped) :
      $codigo_vent = $ped->id_lote;
      $fecha = $ped->fecha_hora;
    endforeach;

    $direccion = '';
    $pagina = '';
    $telefono = '';
    $codigo = '123';
    $tipo_venta = 'Contado';
    $id_lote = $codigo_vent;
    $id_papel = $this->general->get_papel_size($id_usuario);
    if ($id_papel[0]->oidpapel == 1304) {
      // tamaño carta
      $marginTitle = 100;
      $marginTitleBotton = 15;
      $marginSubTitle = 200;
      $marginSubBotton = 5;
      $subtitle = 65;
      $pdfMarginLeft = 15;
      $pdfMarginRight = 15;
      $pdfFontSizeData = PDF_FONT_SIZE_DATA;
      $pdfSize = PDF_PAGE_FORMAT;
      $pdfFontSizeMain = 15;
      $imageSizeN = 15;
      $imageSizeM = 20;
      $imageSizeX = 45;
      $imageSizeY = 15;
      $numeroWidth = 30;
      $cantidadWidth = 75;
      $descripcionWidth = 300;
      $precioWidth = 80;
      $espacioWidth = 435;
      $titulosWidth = 80;
      $importesWidth = 125;
      $footer = true;
      $datos = '
            <table cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="left">
                <font><b>FECHA: </b>' . $fecha . '</font><br>
                <font><b>NRO DE VENTA: </b>' . $id_lote . '</font>        
                </td>
                <td align="left">
                <font><b>SUCURSAL: </b>' . $nombre . '</font><br>
                <font><b>USUARIO: </b>' . $usuario . '</font> 
                </td>
                <td align="left">
                </td>
                
            </tr>
            </table> ';
    } else {
      $dim = 80;
      $dim = $dim + (15 * 10) + 30;
      $pdfSize = array(80, $dim);
      $pdfFontSizeMain = 9;
      $pdfFontSizeData = 9;
      $pdfMarginLeft = 5;
      $pdfMarginRight = 7;
      $imageSizeM = 5;
      $imageSizeN = 5;
      $imageSizeX = 25;
      $imageSizeY = 15;
      $marginTitle = 30;
      $marginTitleBotton = 2;
      $marginSubTitle = 30;
      $marginSubBotton = 17;
      $subtitle = 30;
      $numeroWidth = 20;
      $cantidadWidth = 30;
      $descripcionWidth = 100;
      $precioWidth = 40;
      $espacioWidth = 80;
      $titulosWidth = 70;
      $importesWidth = 115;
      $footer = false;
      $datos = '
            <div>
                <br>
                <font><b> FECHA:&nbsp;</b>' . $fecha . '</font><br>
                <font><b> NRO DE VENTA:&nbsp;</b>' . $id_lote . '</font><br>
                <font><b> RAZON SOCIAL/NOMBRE:&nbsp;</b>' . $nombre_rsocial . '</font><br>
                <font><b> CI/NIT/Cod. Cliente:&nbsp;</b>' . $ci_nit . '</font><br>
                <font><b> CODIGO DE VENTA:&nbsp;</b>' . $codigo_vent . '</font><br>
            </div> ';
    }

    $pdf = new Pdf_venta(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('-');
    $pdf->SetTitle('COMANDA');
    $pdf->SetSubject('COMANDA');

    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setFooterData(array(0, 75, 146), array(0, 75, 146));
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSizeMain));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, 'B', $pdfFontSizeData));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    $pdf->SetMargins($pdfMarginLeft, 20, $pdfMarginRight);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(15);

    $pdf->SetAutoPageBreak($footer, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->setFontSubsetting(true);

    $pdf->setPrintHeader(true);
    $pdf->setPrintFooter(true);

    $pdf->SetFont('times', '', $pdfFontSizeData, '', true);
    $pdf->AddPage('P', $pdfSize);

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $image_file = 'assets/img/icoLogo/' . $logo;

    $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);


    $pdf->MultiCell(0, 0, '', 0, 'C', 0, 1, '', '', true);

    //$html = '<span style="text-align:right;">Direccion: ' . $direccion . ' <br/> Telf: ' . $telefono . '</span>';
    $html = '';
    $pdf->SetFont('times', 'N', $pdfFontSizeData);
    $pdf->writeHTML($html, true, 0, true, true);

    $pdf->SetFont('times', 'B', $pdfFontSizeMain);
    $titulo = 'COMANDA';
    $pdf->Cell(0, $marginTitleBotton, $titulo, 0, true, 'C', 0, '', 1, true, 'M', 'M');
    $pdf->SetFont('times', 'N', $pdfFontSizeData);

    $tbl = $datos;
    $tbl1 = '
      <table cellpadding="3">
        <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
            <th width="' . $numeroWidth . 'px" border="1"> # </th>
            <th width="' . $cantidadWidth . 'px" border="1"> Cantidad </th>
            <th width="' . $cantidadWidth . 'px" border="1"> Unidad </th>
            <th width="' . $descripcionWidth . 'px" border="1"> Descripcion</th>
            <th width="' . $precioWidth . 'px" border="1"> Precio (Bs.) </th>
            <th width="' . $precioWidth . 'px" border="1"> Importe (Bs.) </th>

        </tr> ';
    $nro = 0;
    $total = 0;
    $tbl2 = '';
    foreach ($lst_pedidos as $ped) :
      $nro++;
      $importe = $ped->precio / $ped->cantidad;
      $total += $ped->precio;
      $tbl2 = $tbl2 . '
            <tr>
              <td align="center" border="1">' . $nro . '</td>
              <td align="center" border="1">' . $ped->cantidad . '</td>
              <td align="center" border="1">' . $ped->unidad . '</td>
              <td border="1">' . $ped->descripcion . '</td>
              <td align="center" border="1">' . number_format($importe, 2) . '</td>
              <td align="center" border="1">' . number_format($ped->precio, 2) . '</td>
            </tr>';
    endforeach;
    $tbl3 = '
          <tr >
              <td width="' . $espacioWidth . 'px"  rowspan = "3">
              </td>
              <td width="' . $titulosWidth . 'px">
                  <font><b> TOTAL:</b></font>
              </td>
              <td width="' . $importesWidth . 'px" align= "right">
                  <font>' . number_format($total, 2) . '</font>
              </td>
              
          </tr>
      </table>
      <div style="text-align:center;">
      ' . $consideracion . '
      </div>';

    $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');

    ob_end_clean();
    $pdf_ruta = $pdf->Output('Reporte_nota_entrega.pdf', 'I');
  }
  // FIN GAN-MS-M4-0529, 03/07/2023 ILaquis.
}
