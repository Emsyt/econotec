<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:17/11/2021, GAN-MS-A4-092,
Creacion del Controlador C_listado_ventas para conectar con listado_ventas y M_listado_ventas con sus respectivas funciones
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:22/03/2022, Codigo:GAN-MS-M6-136
Descripcion: se agrego el pdf correspondiente para la impresion de la nota de venta
-------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:28/04/2023, Codigo: 
Descripcion: Se modifico la funcion enviar_correo para obtener los datos del servidor de correo desde la db
-------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert Fecha:24/05/2023, Codigo: GAN-MS-A5-0494
Descripcion: Se modifico la funcion enviar_correo correspondiente a envio de compra venta
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_listado_facturas extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('venta/M_listado_facturas', 'listado_ventas');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('Ciqrcode');
        $this->load->library('excel');
        $this->load->helper(array('email'));
        $this->load->library(array('email'));
        $this->load->library('Facturacion');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['fecha_imp'] = date('Y-m-d H:i:s');

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'venta/listado_facturas';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    public function C_listado_facturas()
    {
        $array_reporte_ABMventas = array(
            'fecha_inicial' => $this->input->post('selc_frep'),
            'fecha_fin'     => $this->input->post('selc_finrep'),
        );
        $data = $this->listado_ventas->M_reporte_abm_facturas(json_encode($array_reporte_ABMventas));
        echo json_encode($data);
    }

    public function C_nota_credito_debito()
    {
        $idubicacion    = $this->input->post('idubicacion');
        $idlote         = $this->input->post('idlote');
        $usucre         = $this->input->post('usucre');

        $lts_prod       = '';
        $montoGiftCard  = '';

        $data       = $this->listado_ventas->M_registrar_nota_credito_debito($idubicacion, $idlote, $usucre);
        if ($data[0]->oboolean == 't') {
            $nombrexml      = $this->listado_ventas->M_nombre_archivo($idlote);
            $nombrexml      = $nombrexml[0]->archivo;
            $xml_open       = simplexml_load_file(FCPATH . 'assets/facturasxml/' . $nombrexml);
            $montoGiftCard  = $xml_open->cabecera->montoGiftCard . '';
            $data           = $this->listado_ventas->M_nota_credito_debito($idubicacion, $idlote, $usucre);
            $data           = $data[0]->fn_nota_credito_debito;
            $lts_prod       = $this->listado_ventas->M_lts_nota_credito_debito($idlote);
        }

        $data = array('data' => $data, 'productos' => $lts_prod, 'gift' => $montoGiftCard);
        echo json_encode($data);
    }

    public function C_cambiar_cantidad_nota_debito()
    {
        $idventa    = $this->input->post('idventa');
        $cantidad   = $this->input->post('cantidad');
        $data       = $this->listado_ventas->M_cambiar_cantidad_nota_debito($idventa, $cantidad);
        echo json_encode($data);
    }

    public function ingresos_reporte_ventas()
    {

        $array_ventas = array(
            'fecha_inicial' => $this->input->post('selc_frep'),
            'fecha_fin' => $this->input->post('selc_finrep'),
        );
        $json_ventas = json_encode($array_ventas);
        $ingresos_ventas = $this->listado_ventas->get_ingresos_ventas($json_ventas);
        $data = array('responce' => 'success', 'posts' => $ingresos_ventas);
        echo json_encode($ingresos_ventas);
    }

    public function historial_venta()
    {
        $idubicacion = $this->input->post('dato1');
        $idlote = $this->input->post('dato2');
        $usucre = $this->input->post('dato3');

        $historial_ventas = $this->listado_ventas->get_historial_venta($idubicacion, $idlote, $usucre);
        $historial_venta = $historial_ventas[0]->fn_historial_venta;
        echo $historial_venta;
    }

    public function get_eliminar_venta()
    {
        $idubicacion = $this->input->post('dato1');
        $idlote = $this->input->post('dato2');
        $usucre = $this->input->post('dato3');

        $eliminar_venta = $this->listado_ventas->get_eliminar_venta($idubicacion, $idlote, $usucre);
        echo json_encode($eliminar_venta);;
    }

    public function get_cargar_venta()
    {
        $idubicacion = $this->input->post('dato1');
        $idlote = $this->input->post('dato2');
        $usucre = $this->input->post('dato3');

        $cargar_venta = $this->listado_ventas->get_cargar_venta($idubicacion, $idlote, $usucre);
        echo json_encode($cargar_venta);;
    }



    // public function enviar_correo_nota1() {
    //     $correo= $this->input->post('correo');
    //     $id_venta= $this->input->post('id_venta');
    //     $id_lote= $this->input->post('id_lote');
    //     $nombre_archivo = $this->listado_ventas->nombre_archivo_xml($id_lote.'002');
    //     $nombre_archivo = $nombre_archivo[0]->archivo;
    //     //$id_lote = $nombre_archivo[0]->id_lote;
    //   // $correo= 'alibummie19@gmail.com';
    //     $this->load->library('email');
    //     $config = array(
    //         'protocol'  => 'smtp',
    //         'smtp_host' => 'mail.gandi.net',
    //         'smtp_port' => 587,
    //         'smtp_user' => 'jesus@mendozaviscarra.site',
    //         'smtp_pass' => 'Fyj*s1e99',
    //         'smtp_crypto'=> 'tls',
    //         'send_multipart' => FALSE,
    //         'wordwrap' => TRUE,
    //         'smtp_timeout' => '400',
    //         'validate' => true,
    //        // 'mailtype'  => 'html',
    //         'charset'   => 'utf-8',
    //         'newline' => "\r\n",
    //         'crlf' => "\r\n"
    //     );
    //     // $config = array(
    //     //     'protocol'  => 'smtp',
    //     //     'smtp_host' => 'smtp.gmail.com',
    //     //     'smtp_port' => 587,
    //     //     'smtp_user' => 'work.soporte.oso@gmail.com',
    //     //     'smtp_pass' => 'waeooqulbtcrkbay',
    //     //     'smtp_crypto'=> 'tls',
    //     //     'send_multipart' => FALSE,
    //     //     'wordwrap' => TRUE,
    //     //     'smtp_timeout' => '400',
    //     //     'validate' => true,
    //     //    // 'mailtype'  => 'html',
    //     //     'charset'   => 'utf-8',
    //     //     'newline' => "\r\n",
    //     //     'crlf' => "\r\n"
    //     // );
    //     $this->email->initialize($config);
    //     $this->email->set_newline("\r\n");
    //     //$this->email->set_mailtype("html");


    //     //email content
    //     //$htmlContent = '<h1>Enviando correo de prueba</h1>';
    //     //$htmlContent .= '<p>Prueba.</p>';
    //     $this->email->from('jesus@mendozaviscarra.site','Econotec');
    //     //$this->email->from('work.soporte.oso@gmail.com','INNOVA');
    //     // $this->email->from('emsytsrl@gmail.com','WebFactu');
    //     $this->email->to($correo);
    //     $this->email->subject('Factura');
    //     $this->email->message('Estimado cliente, Adjunto le hacemos llegar el documento con el detalle de la transacción de la nota debito-credito que realizó.');
    //     //$this-> email-> attach ( 'assets\facturasxml\1D54DB53941CE4DC86DD0F50DC3C219993BB9A4A9477357DAED12A6D74.xml' );
    //     $this-> email-> attach ( FCPATH.'assets/facturaspdf/Nota_debito_'.$id_lote.'002.pdf' );
    //     $this-> email-> attach ( FCPATH.'assets/facturasfirmadasxml/'.$nombre_archivo);
    //     //Send email
    //     if ($this->email->send()) {
    //         echo json_encode('enviado');
    //     } else {
    //         echo json_encode('no enviado');
    //        // print_r($this->email->print_debugger());
    //     }
    // }

    public function enviar_correo_nota()
    {
        $correo = $this->input->post('correo');
        $id_venta = $this->input->post('id_venta');
        $id_lote = $this->input->post('id_lote');
        $nombre_archivo = $this->listado_ventas->nombre_archivo_xml($id_lote . '002');
        $nombre_archivo = $nombre_archivo[0]->archivo;

        $titulo     = $this->listado_ventas->titulo();
        $titulo     = $titulo[0]->otitulo;
        $this->load->library('email');
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'mail.gandi.net',
            'smtp_port' => 587,
            'smtp_user' => 'jesus@mendozaviscarra.site',
            'smtp_pass' => 'Fyj*s1e99',
            'smtp_crypto' => 'tls',
            'send_multipart' => FALSE,
            'wordwrap' => TRUE,
            'smtp_timeout' => '400',
            'validate' => true,
            // 'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline' => "\r\n",
            'crlf' => "\r\n"
        );

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $xml_open               = simplexml_load_file(FCPATH . 'assets/facturasxml/' . $nombre_archivo);

        //Datos del contenido
        $imagenRuta = "https://images.freeimages.com/vhq/images/previews/214/generic-logo-140952.png";
        $tituloContenido = "Nota Crédito - Débito";
        $subtituloContenido = "Estimado cliente:";
        $textoContenido = " <p>Adjunto le hacemos llegar el documento con el detalle de la transacción de Nota Crédito - Débito que realizó.</p> <p>Documentos en formatos PDF y XML.</p>";
        $empresaFooter = $xml_open->cabecera->razonSocialEmisor;
        $sedeFooter = "CASA MATRIZ";
        $puntoVentaFooter = $xml_open->cabecera->codigoPuntoVenta;
        $ubicacionFooter = $xml_open->cabecera->direccion;
        $telefonoFooter = $xml_open->cabecera->telefono;
        $municipioFooter = $xml_open->cabecera->municipio;

        //Datos de estilo
        $color = "rgb(0,121,58)";

        // Formato HTML correo

        $body = "
      <div class='card' style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);overflow: hidden; margin-left:25px;margin-right:50px;'>
        <div class='header' style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);overflow: hidden;'>
            <div class='title' style=' padding:1px;
            margin-bottom:20px;
            border-bottom: 6px solid " . $color . "; padding: 1px;'>
              <h1 style='text-align: center;font-family:Verdana;'>
              " . $tituloContenido . "
              </h1>
            </div>
        </div>
        <div class='subtitle' style='padding: 10px;
            font-weight: bold;
            font-family:Calibri;
            font-size:20px;'>
            " . $subtituloContenido . "
        </div>
        <div class='content' style='padding-left: 10px;
            font-family:Calibri;
            font-size:17px;'>
            " . $textoContenido . "
        </div>
        <div class='contentcenter' style=' width: max-content;
            margin: 0 auto;
            font-family:Calibri;
            font-size:17px;'>
            <p>Agradecemos su preferencia.</p>
            <p class='empresa' style='display: flex;
              justify-content: center;
              text-align: center;
              font-size:20px;
              color:" . $color . ";'>
              " . $empresaFooter . "
            </p>
        </div>
        <div class='fotter' style='
            margin-top:50px;
            justify-content: center;
            text-align: center;
            background-color: rgb(217, 219, 218);
            padding: 10px;
            font-family:Calibri;
            font-size:12px;'>
            <p style='padding: 0;margin:1px;'>" . $sedeFooter . "</p>
            <p style='padding: 0;margin:1px;'>No. Punto de Venta: " . $puntoVentaFooter . "</p>
            <p style='padding: 0;margin:1px;'>" . $ubicacionFooter . "</p>
            <p style='padding: 0;margin:1px;'>Telefono: " . $telefonoFooter . "</p>
            <p style='padding: 0;margin:1px;'>" . $municipioFooter . "</p>
        </div>
      </div>
    ';
      ";

        $this->email->message($body);

        // Configurar los encabezados del correo electrónico
        $this->email->set_mailtype('html');
        //email content
        //$htmlContent = '<h1>Enviando correo de prueba</h1>';
        //$htmlContent .= '<p>Prueba.</p>';
        $this->email->from('jesus@mendozaviscarra.site', 'Econotec');
        // $this->email->from('work.soporte.oso@gmail.com', 'DAO SYSTEMS');
        $this->email->to($correo);
        $this->email->subject('Factura');
        $this->email->attach(FCPATH . 'assets/facturaspdf/Nota_debito_' . $id_lote . '002.pdf');
        $this->email->attach(FCPATH . 'assets/facturasfirmadasxml/' . $nombre_archivo);
        if ($this->email->send()) {
            echo json_encode('enviado');
        } else {
            echo json_encode('no enviado');
            // print_r($this->email->print_debugger());
        }
    }

    public function generar_pdf_cotizacion()
    {
        $usr = $this->session->userdata('id_usuario');
        $id_vent = $this->input->post('id_venta');

        $nota_venta = $this->listado_ventas->get_lst_nota_venta_cotizacion($usr, $id_vent);
        $lst_nota_venta = $nota_venta[0]->fn_nota_venta;
        $lstas_nota_venta = json_decode($lst_nota_venta);

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        // configuracion de tamaños de letras y margenes
        $id_usuario = $this->session->userdata('id_usuario');
        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->id_papel == 1304) {
            // tamaño carta
            $marginTitle = 100;
            $marginSubTitle = 100;
            $pdfMarginLeft = 15;
            $pdfMarginRight = 15;
            $pdfFontSizeData = PDF_FONT_SIZE_DATA;
            $pdfSize = PDF_PAGE_FORMAT;
            $pdfFontSizeMain = PDF_FONT_SIZE_MAIN;
            $imageSizeN = 15;
            $imageSizeM = 20;
            $imageSizeX = 45;
            $imageSizeY = 15;
            $numeroWidth = 30;
            $cantidadWidth = 79;
            $descripcionWidth = 313;
            $precioWidth = 118;
            $importeWidth = 118;
            $espacioWidth = 480;
            $footer = true;
        } else {
            $dim = 80;
            $dim = $dim + (count($lstas_nota_venta->pedidos) * 10);
            $pdfSize = array(80, $dim);
            $pdfFontSizeMain = 9;
            $pdfFontSizeData = 8;
            $pdfMarginLeft = 2;
            $pdfMarginRight = 7;
            $imageSizeM = 5;
            $imageSizeN = 5;
            $imageSizeX = 25;
            $imageSizeY = 15;
            $marginTitle = 40;
            $marginSubTitle = 20;
            $numeroWidth = 20;
            $cantidadWidth = 50;
            $descripcionWidth = 100;
            $precioWidth = 40;
            $importeWidth = 40;
            $espacioWidth = 440;
            $footer = false;
        }

        // fin configuracion

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('NOTA DE VENTA');
        $pdf->SetSubject('NOTA DE VENTA');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0, 75, 146), array(0, 75, 146));
        $pdfFontSize = "";
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSize));
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

        $pdf->SetFont('times', '', $pdfFontSizeMain, '', true);
        $pdf->AddPage('P', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $fecha = $lstas_nota_venta->fecha;
        $nombre_rsocial = $lstas_nota_venta->nombre_rsocial;
        $ci_nit = $lstas_nota_venta->ci_nit;
        $lst_pedidos = $lstas_nota_venta->pedidos;
        $total = $lstas_nota_venta->total;
        $nombre = $lstas_nota_venta->nombre;
        $direccion = $lstas_nota_venta->direccion;
        $pagina = $lstas_nota_venta->pagina;
        $telefono = $lstas_nota_venta->telefono;

        $image_file = 'assets/img/icoLogo/' . $logo;

        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

        $titulo = '        NOTA DE VENTA';
        $txt = '        ' . $nombre . '
        ' . $direccion . '
        Telf.' . $telefono . '           ' . $pagina;

        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeData);
        $pdf->MultiCell($marginSubTitle, 5, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(77, 5, $txt, 0, 'C', 0, 1, '', '', true);

        $tbl = '

        <div>
            <br>
            <font><b> FECHA:&nbsp;</b>' . $fecha . '</font><br>
            <font><b> RAZON SOCIAL/NOMBRE:&nbsp;</b>' . $nombre_rsocial . '</font><br>
            <font><b> CI/NIT/Cod. Cliente:&nbsp;</b>' . $ci_nit . '</font><br>
        </div> ';

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="' . $numeroWidth . 'px"> N&ordm; </th>
                <th width="' . $cantidadWidth . 'px"> cantidad </th>
                    <th width="' . $descripcionWidth . 'px"> Descripcion</th>
                <th width="' . $precioWidth . 'px"> Precio (Bs.) </th>
                    <th width="' . $importeWidth . 'px"> Importe (Bs.) </th>

            </tr> ';

        $nro = 0;
        $tbl2 = '';
        foreach ($lst_pedidos as $ped) :
            $nro++;
            $tbl2 = $tbl2 . '
                <tr>
                  <td align="center">' . $nro . '</td>
                  <td align="center">' . $ped->cantidad . '</td>
                  <td >' . $ped->descripcion . '</td>
                  <td align="center">' . $ped->precio . '</td>
                  <td align="center">' . $ped->importe . '</td>
                </tr>';
        endforeach;
        $tbl3 = '<br>
            <table>
            <tr>
                <td width="' . $espacioWidth . '">
                </td>
                <td width="92">
                    <font><b> TOTAL:</b></font><br>
                </td>
                <td width="118">
                    <font>' . $total . '</font><br>
                </td>
                
            </tr>
          </table>                
        </table>
          ';

        $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Nota_Venta.pdf', 'I');
    }

    public function generar_excel_listado_ventas()
    {

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;

        $empresa = 'EMPRESA ' . $titulo;
        $direccion_img = 'assets/img/icoLogo/' . $logo;

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        $usuario = $this->session->userdata('usuario');
        $fec_impresion = date('Y-m-d H:i:s');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A7', 'Nº')
            ->setCellValue('B7', 'Codigo de Ventas')
            ->setCellValue('C7', 'Cliente')
            ->setCellValue('E7', 'Total')
            ->setCellValue('F7', 'Fecha');


        $objPHPExcel->getActiveSheet()->mergeCells('C7:D7');

        $objPHPExcel->getActiveSheet()->setCellValue('D2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D2:F2');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'LISTADO DE VENTAS');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D3:F3');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Usuario: ' . $usuario);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D4:F4');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Fecha: ' . $fec_impresion);
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->mergeCells('D5:F5');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $objPHPExcel->getActiveSheet()->getStyle("A7:F7")->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('20');



        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('30');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('30');

        $objPHPExcel->getActiveSheet()->getStyle('A7:F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:F7')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array('rgb' => 'A1A5A8')
        ));


        $array_reporte_ABMventas = array(
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_reporte_ABMventas = json_encode($array_reporte_ABMventas);
        $lst_ventas = $this->listado_ventas->M_reporte_abm_facturas($json_reporte_ABMventas);

        $excel_row = 8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                )
            ),
        );
        foreach ($lst_ventas as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, $excel_row - 7)
                ->setCellValue('B' . $excel_row, "$row->ocodigo")
                ->setCellValue('C' . $excel_row, "$row->ocliente")
                ->setCellValue('E' . $excel_row, "$row->ototal")
                ->setCellValue('F' . $excel_row, "$row->ofecha");
            $objPHPExcel->getActiveSheet()->mergeCells('C' . $excel_row . ':D' . ($excel_row));
            $objPHPExcel->getActiveSheet()->getStyle('A' . $excel_row . ':F' . ($excel_row))->applyFromArray($borders);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel_row++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        $objPHPExcel->setActiveSheetIndex(0);

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('test_img');
        $objDrawing->setDescription('test_img');
        $objDrawing->setPath($direccion_img);
        $objDrawing->setCoordinates('B2');
        $objDrawing->setOffsetX(60);
        $objDrawing->setOffsetY(5);
        $objDrawing->setWidth(100);
        $objDrawing->setHeight(132);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Listado de ventas.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }


    public function generar_pdf_listado_ventas()
    {

        $array_reporte_ABMventas = array(
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_reporte_ABMventas = json_encode($array_reporte_ABMventas);
        $lst_ventas = $this->listado_ventas->M_reporte_abm_facturas($json_reporte_ABMventas);

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;

        // configuracion de tamaños de letras y margenes
        $id_usuario = $this->session->userdata('id_usuario');
        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->id_papel == 1304) {
            // tamaño carta
            $marginTitle = 77;
            $pdfMarginLeft = 15;
            $pdfMarginRight = 15;
            $pdfFontSizeData = PDF_FONT_SIZE_DATA;
            $pdfSize = PDF_PAGE_FORMAT;
            $pdfFontSizeMain = PDF_FONT_SIZE_MAIN;
            $imageSizeN = 15;
            $imageSizeM = 20;
            $imageSizeX = 45;
            $imageSizeY = 15;
            $numeroWidth = 30;
            $codigoWidth = 128;
            $clienteWidth = 300;
            $totalWidth = 100;
            $fechaWidth = 100;
            $footer = true;
        } else {
            $dim = 80;
            $dim = $dim + (count($lst_ventas) * 8.5);
            $pdfSize = array(80, $dim);
            $pdfFontSizeMain = 9;
            $pdfFontSizeData = 8;
            $pdfMarginLeft = 2;
            $pdfMarginRight = 7;
            $imageSizeM = 5;
            $imageSizeN = 5;
            $imageSizeX = 25;
            $imageSizeY = 15;
            $marginTitle = 30;
            $numeroWidth = 20;
            $codigoWidth = 75;
            $clienteWidth = 60;
            $totalWidth = 40;
            $fechaWidth = 60;
            $footer = false;
        }
        // fin configuracion

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Listado de ventas');
        $pdf->SetSubject('Listado de ventas');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0, 75, 146), array(0, 75, 146));
        $pdfFontSize = "";
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSize));
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

        $pdf->SetFont('times', '', $pdfFontSizeMain, '', true);
        $pdf->AddPage('P', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $image_file = 'assets/img/icoLogo/' . $logo;

        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

        $titulo = '        EMPRESA ' . $titulo;

        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeData);

        $usuario = $this->session->userdata('usuario');
        $fec_impresion = date('Y-m-d H:i:s');

        $tbl = '
        <div style="text-align:rigth; font-size: 12px">
        <font><b>Usuario:</b> ' . $usuario . ' </font><br>
        <font><b>Fecha:</b> ' . $fec_impresion . ' </font>
        </div>

        <div style="text-align:center;">
            <font><b> LISTADO DE VENTAS </b></font><br>
        </div> ';

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="' . $numeroWidth . 'px"> N&ordm; </th>
                <th width="' . $codigoWidth . 'px">Codigo de Ventas</th>
                <th width="' . $clienteWidth . 'px">Cliente </th>
                <th width="' . $totalWidth . 'px"> Total </th>
                <th width="' . $fechaWidth . 'px"> Fecha </th>

            </tr> ';

        $nro = 0;
        $tbl2 = '';
        foreach ($lst_ventas as $ven) :
            $nro++;
            $tbl2 = $tbl2 . '
                <tr>
                  <td align="center">' . $nro . '</td>
                  <td align="center">' . $ven->ocodigo . '</td>
                  <td>' . $ven->ocliente . '</td>
                  <td align="center">' . $ven->ototal . '</td>
                  <td align="center">' . $ven->ofecha . '</td>
                </tr>';
        endforeach;
        $tbl3 = '
          </table> ';

        $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Listado de ventas.pdf', 'I');
    }

    public function generar_pdf_historial_ventas()
    {

        $idlote = $this->input->post('id_lote');
        $usucre = $this->input->post('usucre');
        $idubicacion = $this->input->post('idubicacion');

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;

        $historial_ventas = $this->listado_ventas->get_historial_venta($idubicacion, $idlote, $usucre);
        $historial_venta = $historial_ventas[0]->fn_historial_venta;
        $historial_venta = json_decode($historial_venta);
        $cliente = $historial_venta->cliente;
        $codigo = $historial_venta->codigo;
        $fecha = $historial_venta->fecha;
        $productos = $historial_venta->productos;
        $total = $historial_venta->total;


        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Historial de Venta');
        $pdf->SetSubject('Historial de Venta');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0, 75, 146), array(0, 75, 146));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'B', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, 'B', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(15, 20, 15);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(15);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);

        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);

        $pdf->SetFont('times', '', 10, '', true);
        $pdf->AddPage('P', 'LETTER');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $image_file = 'assets/img/icoLogo/' . $logo;

        $pdf->Image($image_file, 20, 15, 45, 15, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', 13);

        $titulo = '        EMPRESA ' . $titulo;

        $pdf->MultiCell(80, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', 11);

        $usuario = $this->session->userdata('usuario');
        $fec_impresion = date('Y-m-d H:i:s');

        $tbl = '
        <div style="text-align:rigth; color:#96999c; font-size: 12px">
        <font><b>Usuario:</b> ' . $usuario . ' </font><br>
        <font><b>Fecha:</b> ' . $fec_impresion . ' </font>
        </div>

        <div style="text-align:center;">
            <font size="14px"><b> HISTORIAL </b></font><br>
        </div> 
        <div>
            <font size="12px"><b> Cliente: </b>' . $cliente . '</font><br>
            <font size="12px"><b> Codigo de Venta: </b>' . $codigo . '</font><br>
            <font size="12px"><b> Fecha: </b>' . $fecha . '</font>
        </div> 

        ';

        $tbl1 = '
        <div style="text-align:center;">
        <font size="13px"><b> DETALLE </b></font><br>
        </div> 
          <table cellpadding="3" border="1" style="margin-left: auto; margin-right: auto;">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="30px"> N&ordm; </th>
                <th width="300px"> Producto </th>
                <th width="109px"> Cantidad </th>
                <th width="109px"> Precio Unitario</th>
                <th width="110px"> Sub Total</th>
            </tr> ';

        $nro = 0;
        $tbl2 = '';
        foreach ($productos as $ven) :
            $nro++;
            $tbl2 = $tbl2 . '
                <tr>
                  <td align="center">' . $nro . '</td>
                  <td>' . $ven->producto . '</td>
                  <td align="center">' . $ven->cantidad . '</td>
                  <td align="center">' . $ven->precio . '</td>
                  <td align="center">' . $ven->sub_total . '</td>
                </tr>';
        endforeach;
        $tbl3 = '
              <tr style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="30px"></th>
                <th width="518px">Total: </th>
                <th align="center" width="110px">' . $total . '</th>
              </tr> 
          </table> ';
        $tbl6 = '
          </table> ';

        $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3 . $tbl6, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_historial.pdf', 'I');
    }



    public function lts_nota_credito_debito()
    {
        $idlote = $this->input->post('dato');
        $data = $this->listado_ventas->M_lts_nota_credito_debito($idlote);
        echo json_encode($data);
    }

    public function eliminar_prod()
    {
        $idventa = $this->input->post('dato');
        $data = $this->listado_ventas->eliminar_prod($idventa);
        echo json_encode($data);
    }




    public function C_emitir_nota()
    {
        $idlote             = $this->input->post('dato');
        $usuario            = $this->session->userdata('usuario');
        $facturacion        = $this->listado_ventas->datos_facturacion();
        $lst_productos      = $this->listado_ventas->fn_lts_nota_credito_devueltos($idlote);
        $leyenda            = $this->listado_ventas->leyenda_factura();
        $leyenda            = $leyenda[0]->odescripcion;

        $nit                = $facturacion[0]->nit;
        $codigoSucursal     = $facturacion[0]->cod_sucursal;
        $CodigoEmision      = 1;
        $codigoModalidad    = $facturacion[0]->cod_modalidad;
        $codigoPuntoVenta   = $facturacion[0]->cod_punto_venta;
        $codigo_control     = $facturacion[0]->cod_control;
        $cufd               = $facturacion[0]->cod_cufd;
        $nfactura           = $idlote . '002';

        $DatosCuf = array(
            'Nit'                 => $nit,
            'CodigoSucursal'      => $codigoSucursal,
            'CodigoModalidad'     => $codigoModalidad,
            'CodigoEmision'       => $CodigoEmision,
            'TipoFactura'         => 3,
            'TipoDocumentoSector' => 24,
            'CodigoPuntoVenta'    => $codigoPuntoVenta,
            'CodigoControl'       => $codigo_control
        );

        $codigoCuf          = new GeneradorCuf($DatosCuf);
        $ArrayCuf           = $codigoCuf->generarCuf($nfactura);


        $cuf                = $ArrayCuf['cuf'];
        $fechaEnvio         = $ArrayCuf['fecha'];

        $factura            = $this->listado_ventas->fn_datos_factura($idlote);
        $numeroAutorizacionCuf = $factura[0]->cuf;
        $archivoXml         = $factura[0]->archivo;

        $xml_open = simplexml_load_file(FCPATH . 'assets/facturasxml/' . $archivoXml);

        $nombreRazonSocial      = $xml_open->cabecera->nombreRazonSocial . '';
        $numeroDocumento        = $xml_open->cabecera->numeroDocumento . '';
        $complemento            = $xml_open->cabecera->complemento . '';
        $fechaEmisionFactura    = $xml_open->cabecera->fechaEmision . '';
        $montoTotalOriginal     = $xml_open->cabecera->montoTotal . '';
        $montoTotalDevuelto     = 0;
        $cantidadDevuelto       = 0;

        foreach ($lst_productos as $val) {
            $montoTotalDevuelto = $montoTotalDevuelto + $val->osub_total;
            $cantidadDevuelto   = $cantidadDevuelto + $val->ocantidad;
        }

        $cantidadOriginal       = 0;
        foreach ($xml_open->detalle as $ped) :
            $cantidadOriginal   = $cantidadOriginal + $ped->cantidad;
        endforeach;

        $descuentoAdicional = $xml_open->cabecera->descuentoAdicional . '';
        $descuentoAdicional = ($descuentoAdicional / $cantidadOriginal) * $cantidadDevuelto;
        $montoTotalDevuelto = number_format($montoTotalDevuelto - $descuentoAdicional, 2);
        $montoDescuentoCreditoDebito = number_format($descuentoAdicional, 2);
        $montoEfectivoCreditoDebito = number_format(($montoTotalDevuelto * 0.13), 2);

        $Cabecera_Array = array(
            'numeroNotaCreditoDebito'       => $nfactura,
            'nitEmisor'                     => $xml_open->cabecera->nitEmisor . '',
            'razonSocialEmisor'             => $xml_open->cabecera->razonSocialEmisor . '',
            'municipio'                     => $xml_open->cabecera->municipio . '',
            'telefono'                      => $xml_open->cabecera->telefono . '',
            'direccion'                     => $xml_open->cabecera->direccion . '',
            'codigoTipoDocumentoIdentidad'  => $xml_open->cabecera->codigoTipoDocumentoIdentidad . '',
            'codigoCliente'                 => $xml_open->cabecera->codigoCliente . '',
            'codigoExcepcion'               => $xml_open->cabecera->codigoExcepcion . '',
            'cuf'                           => $cuf,
            'cufd'                          => $cufd,
            'codigoSucursal'                => $codigoSucursal,
            'codigoPuntoVenta'              => $codigoPuntoVenta,
            'fechaEmision'                  => $fechaEnvio,
            'nombreRazonSocial'             => $nombreRazonSocial,
            'numeroDocumento'               => $numeroDocumento,
            'complemento'                   => $complemento,
            'numeroFactura'                 => $idlote,
            'numeroAutorizacionCuf'         => $numeroAutorizacionCuf,
            'fechaEmisionFactura'           => $fechaEmisionFactura,
            'montoTotalOriginal'            => $montoTotalOriginal + $xml_open->cabecera->descuentoAdicional,
            'montoTotalDevuelto'            => $montoTotalDevuelto,
            'montoDescuentoCreditoDebito'   => $montoDescuentoCreditoDebito,
            'montoEfectivoCreditoDebito'    => $montoEfectivoCreditoDebito,
            'leyenda'                       => $leyenda,
            'usuario'                       => $usuario,
        );



        $xml = new GeneradorXml();
        $xml_nota_debito = $xml->NotaCreditoDebito($Cabecera_Array, $lst_productos);

        $rutaXml = FCPATH . 'assets/facturasxml/' . $cuf . '.xml';
        $DocumentoAjuste = new DocumentoAjuste($facturacion);
        $respons = $DocumentoAjuste->solicitudRecepcionDocumentoAjuste($rutaXml, $fechaEnvio);
        $success = $respons['success'];
        if ($success) {
            $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            if ($response->RespuestaServicioFacturacion->transaccion) {
                $datos            = $this->listado_ventas->datos_cliente($numeroDocumento);
                $correo           = $datos[0]->correo;
                if (!$correo) {
                    $correo = 'No se asigno un correo electronico';
                }
                $codigoRecepcion = $response->RespuestaServicioFacturacion->codigoRecepcion;
                if ($codigoRecepcion) {
                    $data = array(
                        'id_lote' => $nfactura,
                        'cuf' => $cuf,
                        'codigoRecepcion' => $codigoRecepcion,
                        'namefactura' => $cuf . '.xml',
                        'xmlfactura' => '',
                        'nombre_rsocial' => $nombreRazonSocial,
                        'numero_documento' => $numeroDocumento,
                        'correo' => $correo,
                        'total' => $montoTotalDevuelto,
                        'tipofacturadocumento' => 3,
                        'codigodocumentosector' => 24,
                        'fechaHora' => $fechaEnvio,
                        'estado' => 'ACEPTADO',
                    );
                    $data = $this->listado_ventas->save_factura(json_encode($data));
                    if ($data[0]->oboolean == 't') {
                        $data = array(
                            (object) array(
                                'oboolean' => 't',
                                'omensaje' => $response->RespuestaServicioFacturacion->codigoDescripcion,
                                'ocuf'     => $cuf,
                                'Ofecha'   => $fechaEnvio,
                            )
                        );
                    }
                } else {
                    $data = array(
                        (object) array(
                            'oboolean' => 'f',
                            'omensaje' => 'Error al obtener el codigo de recepcion.',
                        )
                    );
                }
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaServicioFacturacion->mensajesList->descripcion,
                    )
                );
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $respons['error'],
                )
            );
        }

        // $privateKey = 'Econotec_private.pem';
        // $publicKey = 'Econotec.pem';

        // // $Nota->firmadorNota($cuf,$privateKey,$publicKey);


        // $codigoAmbiente     = 2;
        // $codigoSistema      = $facturacion[0]->cod_sistema;
        // $cuis               = $facturacion[0]->cod_cuis;

        // date_default_timezone_set('America/La_Paz');
        // $fechaEnvio = str_replace(' ', 'T', date('Y-m-d H:i:s.v'));

        // $contenidoXml   = file_get_contents(FCPATH . 'assets/facturasfirmadasxml/' . $cuf . '.xml');
        // $gz = gzencode($contenidoXml, 9);

        // $hash = hash('sha256', $gz);

        // $SolicitudServicio = array(
        //     'SolicitudServicioRecepcionDocumentoAjuste' => array(
        //         'codigoAmbiente'   => $codigoAmbiente,
        //         'codigoSistema'    => $codigoSistema,
        //         'nit'              => $nit,
        //         'cuis'             => $cuis,
        //         'codigoPuntoVenta' => $codigoPuntoVenta,
        //         'codigoSucursal'   => $codigoSucursal,
        //         'codigoEmision'    => $CodigoEmision,
        //         'archivo'          => $gz,
        //         'hashArchivo'      => $hash,
        //         'codigoModalidad'  => $codigoModalidad,
        //         'fechaEnvio'       => $fechaEnvio,
        //         'tipoFacturaDocumento'  => 3,
        //         'codigoDocumentoSector' => 24,
        //         'cufd'             => $cufd,
        //     ),
        // );

        // $respons = $this->listado_ventas->send_factura($SolicitudServicio, $facturacion[0]->cod_token);

        // $datos            = $this->listado_ventas->datos_cliente($numeroDocumento);
        // $correo           = $datos[0]->correo;
        // $cod_cliente      = $datos[0]->cod_cliente;
        // if (!$correo) {
        //     $correo = 'No se asigno un correo electronico';
        // }


        // $codigoRecepcion = $respons->RespuestaServicioFacturacion->codigoRecepcion;
        // $feccre = date('Y-m-d H:i:s.v');
        // if ($codigoRecepcion) {
        //     $val = array(
        //         'id_lote' => $nfactura,
        //         'cuf' => $cuf,
        //         'codigoRecepcion' => $codigoRecepcion,
        //         'namefactura' => $cuf . '.xml',
        //         'xmlfactura' => '',
        //         'nombre_rsocial' => $nombreRazonSocial,
        //         'numero_documento' => $numeroDocumento,
        //         'correo' => $correo,
        //         'total' => $montoTotalDevuelto,
        //         'tipofacturadocumento' => 3,
        //         'codigodocumentosector' => 24,
        //         'fechaHora' => $fechaEnvio,
        //         'estado' => 'ACEPTADO',
        //     );
        //     $val = $this->listado_ventas->save_factura(json_encode($val));
        // }
        // echo json_encode(array('respuesta' => $respons, 'cuf' => $cuf, 'fecha' => $fechaEnvio));
        echo json_encode($data);
    }


    public function pdf_factura()
    {

        $cuf_pdf            = $this->input->post('cuf_pdf');
        $ajustes            = $this->general->get_ajustes("logo");
        $ajuste             = json_decode($ajustes->fn_mostrar_ajustes);
        $logo               = $ajuste->logo;
        $repGrafica         = 'Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una Modalidad de Facturación en Línea';
        $titulofactura      = "NOTA DE CRÉDITO - DEBITO";
        $facsubtitle        = "";
        $facturacion        = $this->listado_ventas->datos_facturacion();
        $codigoAmbiente         = $facturacion[0]->cod_ambiente;
        //    tamaño carta
        $marginTitle = 180;
        $marginSubTitle = 180;
        $pdfMarginLeft = 15;
        $pdfMarginRight = 15;
        $pdfFontSizeData = PDF_FONT_SIZE_DATA;
        $dim1 = 140;
        $dim = $dim1 + (3 * 10);
        //$pdfSize = array(180,200);
        $pdfSize =  PDF_PAGE_FORMAT;
        $codigoSize = 2;
        $pdfFontSizeMain = 8;
        $imageSizeN = 10;
        $imageSizeM = 15;
        $imageSizeX = 35;
        $imageSizeY = 10;
        $numeroWidth = 100;
        $cantidadWidth = 68;
        $descripcionWidth = 180;
        $precioWidth = 70;
        $widthtext2 = 50;
        $qrxy = 100;
        $widthtotalcredito = 335;
        $footer = false;

        $xml_open = simplexml_load_file(FCPATH . 'assets/facturasxml/' . $cuf_pdf . '.xml');

        $nitEmisor                      = $xml_open->cabecera->nitEmisor . '';
        $numeroNotaCreditoDebito        = $xml_open->cabecera->numeroNotaCreditoDebito . '';
        $fechaEmision                   = $xml_open->cabecera->fechaEmision . '';
        $montoTotalDevuelto             = $xml_open->cabecera->montoTotalDevuelto . '';
        $montoEfectivoCreditoDebito     = $xml_open->cabecera->montoEfectivoCreditoDebito . '';
        $leyenda                        = $xml_open->cabecera->leyenda . '';
        $numeroDocumento        = $xml_open->cabecera->numeroDocumento . '';
        $complemento            = $xml_open->cabecera->complemento . '';
        if ($complemento != '') {
            $docmuentoCompleto = $numeroDocumento . '-' . $complemento;
        } else {
            $docmuentoCompleto = $numeroDocumento;
        }
        $datos_cliente          = $this->listado_ventas->mostrar_datos_cliente($docmuentoCompleto);


        $txtl = '       ' . $xml_open->cabecera->razonSocialEmisor . '
            CASA MATRIZ' . '
          No. Punto de Venta ' . $xml_open->cabecera->codigoPuntoVenta . '
' . $xml_open->cabecera->direccion . '
          Telefono: ' . $xml_open->cabecera->telefono . '
           ' . $xml_open->cabecera->municipio . '';

        if ($codigoAmbiente == 1) {
            $kodenya = 'https://siat.impuestos.gob.bo/consulta/QR?nit=' . $nitEmisor . '&cuf=' . $cuf_pdf . '&numero=' . $numeroNotaCreditoDebito . '&t=2';
        } else {
            $kodenya = 'https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=' . $nitEmisor . '&cuf=' . $cuf_pdf . '&numero=' . $numeroNotaCreditoDebito . '&t=2';
        }


        $file = 'assets/img/facturas/' . $cuf_pdf . '.png';
        QRcode::png(
            $kodenya,
            $outfile = $file,
            $level = QR_ECLEVEL_H,
            $size = 6,
            $margin = 2
        );

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');

        $pdf->SetTitle($titulofactura);
        $pdf->SetSubject($titulofactura);
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

        $pdf->SetFont('helvetica', '', $pdfFontSizeData, '', true);
        $pdf->AddPage('P', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter($footer);
        $cam = "CAMBIO";


        $image_file = 'assets/img/icoLogo/' . $logo;
        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $left_column = '<table border="0">
        <tr>
        <td width="220px"></td>
        <td width="120px"><b>NOTA N°:</b></td>
        <td width="160px" align="left">' . $numeroNotaCreditoDebito . '</td>
        </tr>
        <tr>
        <td width="220px"></td>
        <td width="120px"><b>NIT:</b></td>
        <td width="160px" align="left">' . $nitEmisor . '</td>
        </tr>
        <tr>
        <td width="220px"></td>
        <td width="120px"><b>CÓD. AUTORIZACIÓN:</b></td>
        <td width="160px" align="left">' . $cuf_pdf . '</td>
        </tr>
        </table>';
        $right_column = null;
        $pdf->writeHTML($left_column . $right_column, true, false, false, false, '');
        $pdf->MultiCell($widthtext2, 5, $txtl, 0, 'L', 0, 1, '', '', true);
        $pdf->SetFont('helvetica', 'N', $pdfFontSizeMain);
        $pdf->MultiCell($marginTitle, 5, $titulofactura, 0, 'C', 0, 1, '', '', true);
        $pdf->MultiCell($marginSubTitle, 5,  $facsubtitle, 0, 'C', 0, 0, '', '', true);


        ####################### N O T A   D E   D E B I T O   -   C R E D I T O ##############################
        $tbl = '
        <br>
        <br>
            <table border="0">
                <tr >
                    <td width="115">
                    <b>Fecha:</b>
                    </td>
                    <td width="192">' . str_replace('T', ' ', $fechaEmision) . '
                    </td>
                    <td width="115">
                    <b>NIT/CI/CEX:</b>
                    </td>
                    <td width="192">' . $docmuentoCompleto . '
                    </td>

                </tr>
                <tr >
                    <td width="115">
                    <b>Nombre/Razón Social:</b>
                    </td>
                    <td width="192">' . strtoupper($this->xmlEscape($xml_open->cabecera->nombreRazonSocial) . ' ' . $xml_open->cabecera->complemento) . '
                    </td>
                    <td width="115">
                    <b>Cod. Cliente:</b>
                    
                    </td>
                    <td width="192">' . strtoupper($xml_open->cabecera->codigoCliente) . '
                    </td>

                </tr>
                <tr >
                    <td width="115">
                    <b>N° Factura:</b>
                    </td>
                    <td width="192">' . $xml_open->cabecera->numeroFactura . '
                    </td>
                    <td width="115">
                    <b>Fecha Factura:</b>
                    </td>
                    <td width="192">' . str_replace('T', ' ', $xml_open->cabecera->fechaEmisionFactura) . '
                    </td>

                </tr>
                <tr >
                    <td width="115">
                    </td>
                    <td width="192">
                    </td>
                    <td width="115">
                    <b>N° Autorización/CUF:</b>
                    </td>
                    <td width="192">' . $xml_open->cabecera->numeroAutorizacionCuf . '
                    </td>

                </tr>
            </table>
            <br>
            <div>
                <font><b>DATOS FACTURA ORIGINAL</b></font><br>
            </div> ';

        $tbl1 = '
        <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="' . $numeroWidth . 'px">CÓDIGO PRODUCTO</th>
                <th width="' . $cantidadWidth . 'px">CANTIDAD </th>
                <th width="' . $cantidadWidth . 'px">UNIDAD DE MEDIDA</th>
                <th width="' . $descripcionWidth . 'px">DESCRIPCION</th>
                <th width="' . $precioWidth . 'px">PRECIO UNITARIO</th>
                <th width="' . $precioWidth . 'px">DESCUENTO</th>
                <th width="' . $precioWidth . 'px">SUB TOTAL</th>
            </tr> ';
        $tbl2 = '';
        $unidades         = $this->listado_ventas->get_parametricas_cmb();
        foreach ($xml_open->detalle as $ped) :
            if ($ped->codigoDetalleTransaccion == 1) {
                $out_descripcion = '';
                foreach ($unidades as $item) {
                    if ($item->out_codclas == $ped->unidadMedida) {
                        $out_descripcion = $item->out_descripcion;
                        break;
                    }
                }
                $tbl2 = $tbl2 . '
                <tr>
                    <td align="center">' . $ped->codigoProducto . '</td>
                    <td align="center">' . $ped->cantidad . '</td>
                    <td align="center">' . $out_descripcion . '</td>
                    <td >' . $ped->descripcion . '</td>
                    <td align="center">' . $ped->precioUnitario . '</td>
                    <td align="center">' . $ped->montoDescuento . '</td>
                    <td align="center">' . $ped->subTotal . '</td>
                </tr>';
            }
        endforeach;
        $aux = new FuncionesAux();
        // $totalletras = $aux->convertir($total);
        $montoTotalOriginal = $xml_open->cabecera->montoTotalOriginal . '';
        $tbl3 = '<br>
            <table border="0">
            <tr>
                <td width="' . $widthtotalcredito . '">
                </td>
                <td width="210"><font><b>MONTO TOTAL ORIGINAL Bs</b></font>
                </td>
                <td width="70" align="right">
                    <font>' . number_format($montoTotalOriginal, 2) . '</font>
                </td>

            </tr>
        </table>
        </table>
        ';

        $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');

        $tbl = '
            <div>
                <font><b>DETALLE DE LA DEVOLUCIÓN O RESCISIÓN </b></font><br>
            </div> ';

        $tbl1 = '
        <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="' . $numeroWidth . 'px">CÓDIGO PRODUCTO</th>
                <th width="' . $cantidadWidth . 'px">CANTIDAD </th>
                <th width="' . $cantidadWidth . 'px">UNIDAD DE MEDIDA</th>
                <th width="' . $descripcionWidth . 'px">DESCRIPCION</th>
                <th width="' . $precioWidth . 'px">PRECIO UNITARIO</th>
                <th width="' . $precioWidth . 'px">DESCUENTO</th>
                <th width="' . $precioWidth . 'px">SUB TOTAL</th>
            </tr> ';
        $tbl2 = '';
        foreach ($xml_open->detalle as $ped) :
            if ($ped->codigoDetalleTransaccion == 2) {
                $out_descripcion = '';
                foreach ($unidades as $item) {
                    if ($item->out_codclas == $ped->unidadMedida) {
                        $out_descripcion = $item->out_descripcion;
                        break;
                    }
                }
                $tbl2 = $tbl2 . '
                <tr>
                    <td align="center">' . $ped->codigoProducto . '</td>
                    <td align="center">' . $ped->cantidad . '</td>
                    <td align="center">' . $out_descripcion . '</td>
                    <td >' . $ped->descripcion . '</td>
                    <td align="center">' . $ped->precioUnitario . '</td>
                    <td align="center">' . $ped->montoDescuento . '</td>
                    <td align="center">' . $ped->subTotal . '</td>
                </tr>';
            }
        endforeach;
        $aux = new FuncionesAux();
        $totalletras = $aux->convertir(number_format($montoTotalDevuelto, 2));

        $tbl3 = '<br>
            <table border ="0">
            <tr>
                <td width="' . $widthtotalcredito . '"></td>
                <td width="210"><font><b>MONTO TOTAL DEVUELTO Bs</b></font>
                </td>
                <td width="70" align="right">
                    <font>' . number_format($montoTotalDevuelto, 2) . '</font><br>
                </td>

            </tr>
            <tr>
            <td width="' . $widthtotalcredito . '"></td>
            <td width="210"><b>MONTO EFECTIVO DE DEBITO-CREDITO</b>
            </td>
            <td width="70" align="right">' . number_format($montoEfectivoCreditoDebito, 2) . '</td>
            </tr>
            <tr>
            <td width="500">
            Son: ' . $totalletras . '
            </td>
            </tr>

        </table>
        </table>
        ';

        $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');
        $footerText = '<table border="0" width="100%">
                        <tr align="center">
                            <td width="80%"><b>ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE
                            ACUERDO A LEY
                            </b>
                            </td>
                            <td rowspan="3" width="18%" align="right">
                            <img src="' . $file . '" width="' . $qrxy . '" height="' . $qrxy . '">
                            </td>
                        </tr>
                        <tr align="center">
                            <td><br><br>' . $leyenda . '
                            </td>
                        </tr>
                        <tr>
                            <td align="center" width="80%"><br><br>"' . $repGrafica . '"
                            </td>
                         </tr>
                        </table>';
        $pdf->writeHTML($footerText, true, false, false, false, '');

        ob_end_clean();
        $pdf_ruta = $pdf->Output(FCPATH . './assets/facturaspdf/Nota_debito_' . $numeroNotaCreditoDebito . '.pdf', 'FI');

        $correo = $datos_cliente[0]->correo;

        if ($correo != '') {
            $this->enviar_correo($correo, $numeroNotaCreditoDebito, $cuf_pdf);
        }
    }

    /* GAN-MS-A5-0494 Gvalverde */
    public function enviar_correo()
    {
        $correo = $this->input->post('correo');
        $id_lote = $this->input->post('id_lote');
        $nombre_archivo = $this->listado_ventas->nombre_archivo_xml($id_lote);
        $nombre_archivo = $nombre_archivo[0]->archivo;

        $serv_mail = $this->general->datos_smtp();
        $host = $serv_mail[0]->smtp_host;
        $port = $serv_mail[0]->smtp_port;
        $user = $serv_mail[0]->smtp_user;
        $pass = $serv_mail[0]->smtp_pass;
        $empresa = $serv_mail[0]->descripcion;
        $this->load->library('email');
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => $host,
            'smtp_port' => $port,
            'smtp_user' => $user,
            'smtp_pass' => $pass,
            'smtp_crypto' => 'tls',
            'send_multipart' => FALSE,
            'wordwrap' => TRUE,
            'smtp_timeout' => '400',
            'validate' => true,
            // 'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline' => "\r\n",
            'crlf' => "\r\n"
        );

        $this->email->initialize($config);
        $this->email->set_newline("\r\n"); 
        $this->email->from($user, $empresa);
        $this->email->to($correo);
        $this->email->subject('Factura');
        $this->email->message('Estimado cliente, Adjunto le hacemos llegar el documento con el detalle de la transacción de compra que realizó.');
        $this->email->attach(FCPATH . 'assets/facturaspdf/factura_' . $id_lote . '.pdf');
        $this->email->attach(FCPATH . 'assets/facturasxml/' . $nombre_archivo);
        if ($this->email->send()) {
            echo json_encode('Correo enviado correctamente.');
        } else {
            echo json_encode('Error al enviar el correo: ' . $this->email->print_debugger() . ' ');
        }
    }

    /* public function enviar_correo($correo, $numeroFactura, $cuf)
    {
        $correo = urldecode($correo);
        //Datos del servidor SMTP
        $serv_mail = $this->general->datos_smtp();
        $host = $serv_mail[0]->smtp_host;
        $port = $serv_mail[0]->smtp_port;
        $user = $serv_mail[0]->smtp_user;
        $pass = $serv_mail[0]->smtp_pass;
        $empresa = $serv_mail[0]->descripcion;
        ///////
        $this->load->library('email');
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => $host,
            'smtp_port' => $port,
            'smtp_user' => $user,
            'smtp_pass' => $pass,
            'smtp_crypto' => 'tls',
            'send_multipart' => FALSE,
            'wordwrap' => TRUE,
            'smtp_timeout' => '400',
            'validate' => true,
            // 'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline' => "\r\n",
            'crlf' => "\r\n"
        );

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $xml_open               = simplexml_load_file(FCPATH . 'assets/facturasxml/' . $cuf . '.xml');

        //Datos del contenido
        $tituloContenido = "Nota de Crédito – Débito";

        $subtituloContenido = "Estimado cliente:";
        $textoContenido = " <p>Adjunto le hacemos llegar el documento con el detalle de la emisió​n de Nota Crédito/Débito que se realizó.</p> <p>Documentos en formatos PDF y XML.</p>";
        $empresaFooter = $xml_open->cabecera->razonSocialEmisor;
        $sedeFooter = "CASA MATRIZ";
        $puntoVentaFooter = $xml_open->cabecera->codigoPuntoVenta;
        $ubicacionFooter = $xml_open->cabecera->direccion;
        $telefonoFooter = $xml_open->cabecera->telefono;
        $municipioFooter = $xml_open->cabecera->municipio;

        //Datos de estilo
        $color = "rgb(0,121,58)";

        // Formato HTML correo

        $body = "
    <div class='card' style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);overflow: hidden; margin-left:25px;margin-right:50px;'>
      <div class='header' style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);overflow: hidden;'>
          <div class='title' style=' padding:1px;
          margin-bottom:20px;
          border-bottom: 6px solid " . $color . "; padding: 1px;'>
            <h1 style='text-align: center;font-family:Verdana;'>
            " . $tituloContenido . "
            </h1>
          </div>
      </div>
      <div class='subtitle' style='padding: 10px;
          font-weight: bold;
          font-family:Calibri;
          font-size:20px;'>
          " . $subtituloContenido . "
      </div>
      <div class='content' style='padding-left: 10px;
          font-family:Calibri;
          font-size:17px;'>
          " . $textoContenido . "
      </div>
      <div class='contentcenter' style=' width: max-content;
          margin: 0 auto;
          font-family:Calibri;
          font-size:17px;'>
          <p>Agradecemos su preferencia.</p>
          <p class='empresa' style='display: flex;
            justify-content: center;
            text-align: center;
            font-size:20px;
            color:" . $color . ";'>
            " . $empresaFooter . "
          </p>
      </div>
      <div class='fotter' style='
          margin-top:50px;
          justify-content: center;
          text-align: center;
          background-color: rgb(217, 219, 218);
          padding: 10px;
          font-family:Calibri;
          font-size:12px;'>
          <p style='padding: 0;margin:1px;'>" . $sedeFooter . "</p>
          <p style='padding: 0;margin:1px;'>No. Punto de Venta: " . $puntoVentaFooter . "</p>
          <p style='padding: 0;margin:1px;'>" . $ubicacionFooter . "</p>
          <p style='padding: 0;margin:1px;'>Telefono: " . $telefonoFooter . "</p>
          <p style='padding: 0;margin:1px;'>" . $municipioFooter . "</p>
      </div>
    </div>
  ';
    ";
        $this->email->message($body);

        // Configurar los encabezados del correo electrónico
        $this->email->set_mailtype('html');
        //email content
        //$htmlContent = '<h1>Enviando correo de prueba</h1>';
        //$htmlContent .= '<p>Prueba.</p>';
        $this->email->from($user, $empresa);
        // $this->email->from('work.soporte.oso@gmail.com', 'DAO SYSTEMS');
        $this->email->to($correo);
        $this->email->subject('Factura');
        $this->email->attach(FCPATH . 'assets/facturaspdf/Nota_debito_' . $numeroFactura . '.pdf');
        $this->email->attach(FCPATH . 'assets/facturasxml/' . $cuf . '.xml');
        if ($this->email->send()) {
            echo json_encode('enviado');
        } else {
            echo json_encode('no enviado');
        }
    } */
    /* fin GAN-MS-A5-0494 Gvalverde */


    function xmlEscape($string)
    {
        return str_replace(array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), array('&', '<', '>', '\'', '"'), $string);
    }
}
