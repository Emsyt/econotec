<?php
/*
  Creador: Heidy Soliz Santos Fecha:20/04/2021, Codigo:SYSGAM-001
  Metodo: index 
  Descripcion:Se crea la funcion index para mostrar la vista de pedido por codigo 
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:27/04/2021, Codigo:SYSGAM-003
  Descripcion:Se modifico para crear la funcion datos_producto para obtener el nombre la cantidad y el precio
    ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:30/04/2021, Codigo:SYSGAM-005
  Descripcion:Se modifico cambiar la cantidad con la funcion cantidad_producto
  -------------------------------------------------------------------------------
   Modificado: Heidy Soliz Santos Fecha:05/05/2021, Codigo:SYSGAM-007
  Descripcion:Se modifico para mostrar la tabla producto 
   ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:06/05/2021, Codigo: SYSGAM-008
  Descripcion:Se modifico para implementar la funcion que calcula el cambio y para realizar la compra  tambien se modifico la funcion index para implemetar el caculo de cambio
------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:11/05/2021, Codigo: SYSGAM-009
  Descripcion: Se modifico para corregir  el error
  -----------------------------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:26/05/2021, Codigo:  GAM -011
  Descripcion: Se modifico para hacer la busqueda de nit como en el maquetado
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:8/06/2021, Codigo: GAM-027
  Descripcion: Se modifico para crear la funcion mostrar codigo
   ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:15/06/2021, Codigo: GAM-028
  Descripcion: Se modifico para completar el nombre del producto
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:07/07/2021, Codigo: GAM-032
  Descripcion: Se modifico para que el cliente no desaparesca
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:14/09/2021, GAN-MS-A4-028
  Descripcion: Se modifico para crear la funcion generar_pdf_venta_codigo 
  para obtener un pdf de tcpdf
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:23/09/2021, GAN-MS-A1-033
  Descripcion: Se realizaron la modificacion de la funcion relizar_cobro para que esta devuelva un idventa necesaria para imprimir pdf, tambien se añadio la funcion cambiar precio.
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:05/11/2021, GAN-MS-A4-063
  Descripcion: Se realizaron la creacion de la funcion verifica_cantidad que permite verificar el tamaño del stock del producto.
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:12/11/2021,  GAN-MS-A1-080
  Descripcion: Se Realizo la modificacion en pedidos por codigo para que al momento de cantidad se pueda cambiar a cantidades decimales 
  -----------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma fecha 08/09/2022 Codigo :GAN-MS-A1-436
  Descripcion: Se agrego la funcion mostrar_stock_total().
  -----------------------------------------------------------------------------
  Modificado: Gary German Valverde fecha 06/10/2022 Codigo :GAN-MS-M5-0034
  Descripcion: Se modifico el pdf de ticket para que muestre + unidad
  -----------------------------------------------------------------------------
  Modificado: Keyla Paola Usnayo Aguilar fecha 11/10/2022 Codigo: GAN-SC-M3-0041
  Descripcion: Se agrego la funcion mostrar_precio_total().
  -----------------------------------------------------------------------------
  Modificado: Alvaro Ruben Gonzales Vilte fecha 18/10/2022 Codigo: GAN-MS-A1-0058
  Descripcion: Se modifico la funcion fn_nota_venta()
  -----------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana fecha 11/10/2022 Codigo: GAN-MS-B9-0100
  Descripcion: Se modifico la funcion generar_pdf_venta_codigo(), donde se corregio el desfase de TOTAL,PAGADO Y SALDO
  ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:21/11/2022, Codigo:GAN-MS-A7-0126
  Descripcion: Se modifico la funcion generar_pdf_venta_codigo para anadir el usuario, hora , y codigo de venta
  ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:30/11/2022, Codigo: GAN-MS-A3-0162
  Descripcion: Se modifico el formato del pdf de nota de entrega acuerdo a lo adjunto
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Aguirre Fecha: 10/02/2023 Codigo: GAN-MS-B0-0213
  Descripcion: Se agrego la funcion cambiar_null_a_imagenes_sin_archivos_fisicos()
  ------------------------------------------------------------------------------
  Modificado: Ariel Ramos Paucara     Fecha: 29/03/2023   Codigo: GAN-MS-M0-0379
  Descripcion: Se agrego la funcion get_codigo() y get_descripcion
  */
defined('BASEPATH') or exit('No direct script access allowed');

class C_pedidoCodigo extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('venta/M_pedidoCodigo', 'pedidoCodigo');
    $this->load->library('Pdf_venta');
  }

  public function index()
  {
    if ($this->session->userdata('login')) {
      $log['permisos'] = $this->session->userdata('permisos');
      $usr = $this->session->userdata('usuario');
      $data['producto'] = $this->pedidoCodigo->mostrar();
      $data['contador'] = $this->pedidoCodigo->contador_pedidos($usr);
      $data['lib'] = 0;
      $data['datos_menu'] = $log;
      $data['cantidadN'] = $this->general->count_notificaciones();
      $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
      $data['titulo'] = $this->general->get_ajustes("titulo");
      $data['thema'] = $this->general->get_ajustes("tema");
      $data['descripcion'] = $this->general->get_ajustes("descripcion");
      $data['contenido'] = 'venta/V_pedidoCodigo';
      $usrid = $this->session->userdata('id_usuario');
      $data['chatUsers'] = $this->general->chat_users($usrid);
      $data['getUserDetails'] = $this->general->get_user_details($usrid);
      $this->load->view('templates/estructura', $data);
    } else {
      redirect('logout');
    }
  }
  public function mostrar_produc()
  {
    $data = $this->pedidoCodigo->mostrar();;
    echo json_encode($data);
  }
  public function lst_tipo_venta()
  {
    $data = $this->pedidoCodigo->listar_tipos_venta();
    echo json_encode($data);
  }
  public function datos_producto()
  {
    $id_producto = $this->input->post('buscar');
    $data = $this->pedidoCodigo->get_datos_producto($id_producto);
    echo json_encode($data);
  }
  public function cantidad_producto()
  {
    $id_venta = $this->input->post('dato1');
    $cantidad = $this->input->post('dato2');
    $data = $this->pedidoCodigo->cantidad_producto($id_venta, $cantidad);
    echo json_encode($data);
  }
  public function cambiar_precio()
  {
    $id_venta = $this->input->post('dato1');
    $monto = $this->input->post('dato2');
    $data = $this->pedidoCodigo->cambiar_precio($id_venta, $monto);
    echo json_encode($data);
  }
  public function verificar_cambio_precio()
  {
    $id_venta = $this->input->post('dato1');
    $monto = $this->input->post('dato2');
    $data = $this->pedidoCodigo->verificar_cambio_precio($id_venta, $monto);
    echo json_encode($data);
  }
  public function verificar_cambio_precio_total()
  {
    $id_venta = $this->input->post('dato1');
    $monto = $this->input->post('dato2');
    $data = $this->pedidoCodigo->verificar_cambio_precio_total($id_venta, $monto);
    echo json_encode($data);
  }
  public function verifica_cantidad()
  {
    $id_venta = $this->input->post('dato1');
    $cantidad = $this->input->post('dato2');
    $data = $this->pedidoCodigo->verifica_cantidad($id_venta, $cantidad);
    echo json_encode($data);
  }
  public function cambio_precio_uni()
  {
    $id_venta = $this->input->post('dato3');
    $monto = $this->input->post('dato4');
    $data = $this->pedidoCodigo->cambio_precio_uni($id_venta, $monto);
    echo json_encode($data);
  }
  public function dlt_pedido()
  {
    $id_ped = $this->input->post("buscar");
    $ped_delete = $this->pedidoCodigo->delete_pedido($id_ped);
    echo json_encode($ped_delete);
  }
  public function calcular_cambio()
  {
    $id_tipo = $this->input->post('id_tipo');
    $pagado = $this->input->post('pagado');
    $cambio = $this->pedidoCodigo->calcular_cambio($id_tipo, $pagado);
    echo json_encode($cambio);
  }
  public function relizar_cobro()
  {
    $id_venta = $this->pedidoCodigo->mostrar();
    $id_vent = $id_venta[0]->oidventa;
    $nit = $this->input->post('valor_nit') . "";
    $tipo = $this->input->post('tipo');
    $cobro = $this->pedidoCodigo->realizar_cobro($tipo, $nit);
    $array_cobro = array(
      'oestado' => $cobro[0]->oestado,
      'omensaje' => $cobro[0]->omensaje,
      'idventa' => $id_vent,
    );
    echo "[" . json_encode($array_cobro) . "]";
  }
  public function mostrar_nit()
  {
    $nit = $this->pedidoCodigo->mostrar_nit();
    echo json_encode($nit);
  }
  public function verifica_cliente()
  {
    $nit = $this->input->post('valor_nit') . "";
    $valor = $this->pedidoCodigo->verifica_cliente($nit);
    echo json_encode($valor);
  }
  public function registrar()
  {
    $id_ubi = $this->session->userdata('ubicacion');
    $id = $this->session->userdata('id_usuario');
    $nit = $this->input->post('valor_nit') . "";
    $razonSocial = $this->input->post('razonSocial') . "";
    $valor = $this->pedidoCodigo->registrar($id, $nit, $razonSocial,$id_ubi);
    echo json_encode($valor);
  }
  public function mostrar_lts_nombre()
  {
    $nombre = $this->pedidoCodigo->mostrar_lts_nombre();
    echo json_encode($nombre);
  }
  public function mostrar_nit_usuario()
  {
    $band = 0;
    $cad = "";
    $nit = $this->input->post('buscar');
    for ($i = 0; $i < strlen($nit); $i++) {
      if ($nit[$i] == "-") {
        $band = 1;
      }
      if ($band == 1) {
        $cad = "" . $cad . "" . $nit[$i] . "";
      }
    }
    echo (substr($cad, 1));
  }
  public function mostrar_codigo()
  {
    $codigo = $this->pedidoCodigo->mostrar_codigo();
    echo json_encode($codigo);
  }
  public function mostrar_nombre()
  {
    $nit = $this->input->post('buscar');
    $nombre = $this->pedidoCodigo->mostrar_nombre($nit);
    echo json_encode($nombre);
  }
  public function mostrar_producto()
  {
    $nombre = $this->pedidoCodigo->mostrar_producto();
    echo json_encode($nombre);
  }
  public function datos_nombre()
  {
    $nombre = $this->input->post('buscar');
    $data = $this->pedidoCodigo->get_datos_nombre($nombre);
    echo json_encode($data);
  }
  public function generar_pdf_venta_codigo()
  {
    $id_venta = $this->input->post('id_venta');
    $pagado = $this->input->post('pagado');
    $nota_venta = $this->pedidoCodigo->get_lst_nota_venta($id_venta, $pagado);

    $lst_nota_venta = $nota_venta[0]->fn_nota_venta;

    $lstas_nota_venta = json_decode($lst_nota_venta);

    $ajustes = $this->general->get_ajustes("logo");
    $consi = $this->general->get_ajustes("consideracion");

    $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
    $logo = $ajuste->logo;
    $ajuste = json_decode($consi->fn_mostrar_ajustes);
    $consideracion = $ajuste->consideracion;

    $id_usuario = $this->session->userdata('id_usuario');
    $usuario = $this->session->userdata('usuario');
    $fecha = $lstas_nota_venta->fecha;
    $nombre_rsocial = $lstas_nota_venta->nombre_rsocial;
    $ci_nit = $lstas_nota_venta->ci_nit;
    $lst_pedidos = $lstas_nota_venta->pedidos;
    $total = $lstas_nota_venta->total;
    $pagado = $lstas_nota_venta->pagado;
    $cambio = $lstas_nota_venta->cambio;
    $saldo = $lstas_nota_venta->saldo;
    $nombre = $lstas_nota_venta->nombre;
    $direccion = $lstas_nota_venta->direccion;
    $pagina = $lstas_nota_venta->pagina;
    $telefono = $lstas_nota_venta->telefono;
    $codigo = $lstas_nota_venta->codigo;
    $codigo_vent = $lstas_nota_venta->cod_venta;
    $tipo_venta = $lstas_nota_venta->tipo_venta;
    $hora = $lstas_nota_venta->hora;
    $id_lote = $lstas_nota_venta->id_lote;
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
                <font><b>RAZON SOCIAL/NOMBRE: </b>' . $nombre_rsocial . '</font><br>
                <font><b>FECHA: </b>' . $fecha . ' ' . $hora . '</font><br>
                <font><b>NRO DE VENTA: </b>' . $id_lote . '</font>        
                </td>
                <td align="left">
                <font><b>SUCURSAL: </b>' . $nombre . '</font><br>
                <font><b>USUARIO: </b>' . $usuario . '</font> 
                </td>
                <td align="left">
                <font><b> CI/NIT/Cod. Cliente: </b>' . $ci_nit . '</font><br>
                <font><b> CODIGO DE VENTA: </b>' . $codigo_vent . '</font><br>
                <font><b> TIPO DE VENTA: </b>' . $tipo_venta . '</font><br>
                </td>
                
            </tr>
            </table> ';
    } else {
      $dim = 80;
      $dim = $dim + (count($lstas_nota_venta->pedidos) * 10) + 30;
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
                <font><b> FECHA:&nbsp;</b>' . $fecha . ' ' . $hora . '</font><br>
                <font><b> NRO DE VENTA:&nbsp;</b>' . $id_lote . '</font><br>
                <font><b> RAZON SOCIAL/NOMBRE:&nbsp;</b>' . $nombre_rsocial . '</font><br>
                <font><b> CI/NIT/Cod. Cliente:&nbsp;</b>' . $ci_nit . '</font><br>
                <font><b> CODIGO DE VENTA:&nbsp;</b>' . $codigo_vent . '</font><br>
            </div> ';
    }

    $pdf = new Pdf_venta(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('-');
    $pdf->SetTitle('Nota de entrega');
    $pdf->SetSubject('Nota de entrega');

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

    $cam = "CAMBIO";
    if ($cambio == null && $cambio == "") {
      $cambio = $lstas_nota_venta->saldo;
      $cam = "SALDO";
    } else {
      $cambio = $lstas_nota_venta->cambio;
      $cam = "CAMBIO";
    }

    $image_file = 'assets/img/icoLogo/' . $logo;

    $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);


    $pdf->MultiCell(0, 0, '', 0, 'C', 0, 1, '', '', true);

    $html = '<span style="text-align:right;">Direccion: ' . $direccion . ' <br/> Telf: ' . $telefono . '</span>';
    $pdf->SetFont('times', 'N', $pdfFontSizeData);
    $pdf->writeHTML($html, true, 0, true, true);

    $pdf->SetFont('times', 'B', $pdfFontSizeMain);
    $titulo = 'NOTA DE ENTREGA- ' . $codigo;
    $pdf->Cell(0, $marginTitleBotton, $titulo, 0, true, 'C', 0, '', 1, true, 'M', 'M');
    $pdf->SetFont('times', 'N', $pdfFontSizeData);

    $tbl = $datos;
    //GAN-MS-M5-0034 GValverde 06/10/2022
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
    //fin GAN-MS-M5-0034 GValverde 06/10/2022
    $nro = 0;
    $tbl2 = '';
    //GAN-MS-M5-0034 GValverde 06/10/2022
    foreach ($lst_pedidos as $ped) :
      $nro++;
      $tbl2 = $tbl2 . '
            <tr>
              <td align="center" border="1">' . $nro . '</td>
              <td align="center" border="1">' . $ped->cantidad . '</td>
              <td align="center" border="1">' . $ped->unidad . '</td>
              <td border="1">' . $ped->descripcion . '</td>
              <td align="center" border="1">' . $ped->precio . '</td>
              <td align="center" border="1">' . $ped->importe . '</td>
            </tr>';
    //fin GAN-MS-M5-0034 GValverde 06/10/2022
    endforeach;
    $tbl3 = '
          <tr >
              <td width="' . $espacioWidth . 'px"  rowspan = "3">
              </td>
              <td width="' . $titulosWidth . 'px">
                  <font><b> TOTAL:</b></font>
              </td>
              <td width="' . $importesWidth . 'px" align= "right">
                  <font>' . $total . '</font>
              </td>
              
          </tr>
          <tr >
            <td width="' . $titulosWidth . 'px">
                <font><b> PAGADO:</b></font>
            </td>
            <td width="' . $importesWidth . 'px" align= "right">
                <font>' . $pagado . '</font>
            </td>
          </tr>
          <tr >
            <td width="' . $titulosWidth . 'px">
                <font><b> ' . $cam . ':</b></font>
            </td>
            <td width="' . $importesWidth . 'px" align= "right">
                <font>' . $cambio . '</font>
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
  // GAN-MS-A1-436, 08/09/2022, PBeltran
  public function mostrar_stock_total()
  {
    $codigo = $this->input->post('dato1');
    $data = $this->pedidoCodigo->mostrar_stock_total($codigo);
    echo json_encode($data);
  }
  // FIN GAN-MS-A1-436, 08/09/2022, PBeltran

  // GAN-SC-M3-0041, 07/10/2022, KUsnayo
  public function mostrar_precios_total()
  {
    $codigo = $this->input->post('dato1');
    $data = $this->pedidoCodigo->mostrar_precios_total($codigo);
    echo json_encode($data);
  }
  // FIN GAN-SC-M3-0041, 07/10/2022, KUsnayo

  // INICIO Oscar L., GAN-MS-B0-0213
  public function cambiar_null_a_imagenes_sin_archivos_fisicos()
  {
    $nombre_img = $this->input->post('dato1');
    $data = $this->pedidoCodigo->cambiar_null_a_imagenes_sin_archivos_fisicos($nombre_img);
    echo $data;
  }
  //  FIN GAN-MS-B0-0213

  // INICIO Ariel R. GAN-MS-M0-0379  
  public function get_codigo()
  {
    $code = $this->input->post('code');
    $data = $this->pedidoCodigo->get_codigo($code);
    echo json_encode($data);
  }
  public function get_descripcion()
  {
    $code = $this->input->post('code');
    $data = $this->pedidoCodigo->get_descripcion($code);
    echo json_encode($data);  
  }
  // FIN Ariel R. GAN-MS-M0-0379
}
