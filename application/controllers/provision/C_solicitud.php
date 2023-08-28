<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Melvin Salvador Cussi Callisaya Fecha:12/04/2022, Codigo: GAN-MS-A4-149,
Descripcion: se agrego la funcion get_lst_solicitud para recuperar la lista
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:19/04/2022, Codigo:GAN-FR-A0-165
Descripcion: se implemento la parte funcional de la confirmación de PEDIDOS DE PRODUCTOS.
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:19/04/2022, Codigo:GAN-MS-M3-169
Descripcion: se implemento la impresion de pdf a los controladores con la funcionalidad
de registro al momento de imprimir.
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:19/04/2022, Codigo:GAN-MS-A4-184
Descripcion: se adiciono al pdf el campo de Observaciones y el campo para firmar el pdf.
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:27/04/2022, Codigo:GAN-MS-A6-194
Descripcion: se adiciono al pdf la firma respectiva para el transporte .
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:29/04/2022, Codigo:GAN-BA-A7-215
Descripcion: se adiciono el dato de rol al momento de cargar la pagina para limitar
la vista de prioridad tambien se adiciono la funcion priorizar para guardar el estado 
de prioridad del id_ lote correspondiente
------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma Fecha:19/09/2022, Codigo:GAN-MS-A1-466
Descripcion: se modifico el ajax para enviar la cantidad del producto modificada al controlador.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Keyla Paola Usnayo Aguilar    Fecha:29/09/2022,     Codigo: GAN-MS-M0-0013,
Descripcion: Se modifico la funcion index() para que en la URL se muestre el nombre registrado en ajustes
------------------------------------------------------------------------------
Modificado: Oscar Laura Aguirre  Fecha: 17/02/2023,   Codigo: GAN-MS-B1-0253
Descripcion: Se cambio el texto ALMACENES al la ubicacion actual del solicitante.
------------------------------------------------------------------------------
Modificado: Oscar Laura Aguirre  Fecha: 20/03/2023,   Codigo: GAN-MS-M1-0251
Descripcion: se modifico la funcion confirmacion_solicitud para que envie la fecha de la 
solicitud de producto a la vista y la muestre.
*/
defined('BASEPATH') or exit('No direct script access allowed');

class C_solicitud extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('provision/M_solicitud', 'solicitud');
        $this->load->library('Pdf_venta');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');

            $id_usuario = $this->session->userdata('id_usuario');
            $data['lst_lotes'] = $this->solicitud->lista_lotes_solicitudes($id_usuario);
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['rol'] = $this->solicitud->que_cargo_tiene($id_usuario);
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'provision/lista_solicitudes';

            $data['chatUsers'] = $this->general->chat_users($id_usuario);
            $data['getUserDetails'] = $this->general->get_user_details($id_usuario);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    public function confirmacion_solicitud()
    {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['ubicacion'] = $this->session->userdata('ubicacion');
            $data['lst_transportes'] = $this->solicitud->fn_listar_transportes();
            $lote = $this->input->post('lote');
            $solicitante = $this->input->post('solicitante');
            $tipo = $this->input->post('tipo');
            /* Inicio Oacar Laura Aguirre GAN-MS-M1-0251 */
            $ofechaent = $this->input->post('ofechaent');
            $data['ofechaent'] = $ofechaent;
            /* FIN Oacar Laura Aguirre GAN-MS-M1-0251 */

            $data['proveedores'] = $this->solicitud->get_proveedores();

            if (isset($_COOKIE["solicitante"]) && $_COOKIE["solicitante"] != "") {
                $data['solicitante'] = $_COOKIE["solicitante"];
            } else {
                $data['solicitante'] = $solicitante;
                setcookie("solicitante", $solicitante);
            }

            if (isset($_COOKIE["lote"]) && $_COOKIE["lote"] != "") {
                $data['lote'] = $_COOKIE["lote"];
            } else {
                $data['lote'] = $lote;
                setcookie("lote", $lote);
            }

            if (isset($_COOKIE["tipo"]) && $_COOKIE["tipo"] != "") {
                $data['tipo'] = $_COOKIE["tipo"];
            } else {
                $data['tipo'] = $tipo;
                setcookie("tipo", $tipo);
            }

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['contenido'] = 'provision/aprobar_solicitud';
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    public function confirmar_producto()
    {
        $id_movimiento = $this->input->post('id_movimiento');
        $id_usuario = $this->session->userdata('id_usuario');

        $com_update = $this->solicitud->aceptar_solicitud($id_usuario, $id_movimiento);
        if ($com_update[0]->oboolean == 'f') {
            $this->session->set_flashdata('error', $com_update[0]->omensaje);
        } else {
            $this->session->set_flashdata('success', 'Solicitud de Producto realizada exitosamente.');
        }

        redirect('conf_solicitud');
    }

    public function confirmar_lote()
    {
        $fecha = $this->input->post('fec_entrega');
        //GAN-MS-A1-466 19-9-2022 PBeltran 
        $id_transporte = $this->input->post('tran');
        $id_usuario = $this->session->userdata('id_usuario');
        $array = $this->input->post('array');
        $array = json_encode($array);
        $array = str_replace('"', '', $array);
        $array2 = $this->input->post('array2');
        $array2 = json_encode($array2);
        $array2 = str_replace('"', '', $array2);
        $fecha = str_replace("/", "-", $fecha);

        $com_update = $this->solicitud->aceptar_lote($id_usuario, $array, $array2, $id_transporte, $fecha);
        //FIN GAN-MS-A1-466 19-9-2022 PBeltran 
        if ($com_update[0]->oboolean == 'f') {
            $this->session->set_flashdata('error', $com_update[0]->omensaje);
        } else {
            $this->session->set_flashdata('success', 'Solicitud de Producto realizada exitosamente.');
        }
        redirect('conf_solicitud');
    }
    public function dlt_producto($id_movimiento)
    {
        $id_usuario = $this->session->userdata('id_usuario');
        $sol_delete = $this->solicitud->delete_producto($id_usuario, $id_movimiento);
        if ($sol_delete[0]->oboolean == 'f') {
            $this->session->set_flashdata('error', $sol_delete[0]->omensaje);
        } else {
            $this->session->set_flashdata('success', 'Solicitud de Producto realizada exitosamente.');
        }

        redirect('conf_solicitud');
    }
    public function priorizar()
    {
        $id_usuario = $this->session->userdata('id_usuario');
        $lote = $this->input->post('olote');
        $estado = $this->input->post('oestado');
        $data = $this->solicitud->set_prior($id_usuario, $lote, $estado);
        echo json_encode($data);
    }
    public function get_lst_solicitud()
    {
        $lote = $_COOKIE["lote"];
        $data = $this->solicitud->get_conf_solicitud($lote);
        echo json_encode($data);
    }

    public function set_msg_whatsapp($telf){
        $lote = $_COOKIE["lote"];
        $data = $this->solicitud->msg_whatsapp($lote,$telf);
        echo json_encode($data);
    }
    public function get_telf_proveedor($id_proveedor){
        $data = $this->solicitud->get_telf_proveedor($id_proveedor);
        echo json_encode($data);
    }

    public function generar_pdf()
    {
        //GAN-MS-A1-466 19-9-2022 PBeltran 
        $lote = $_COOKIE["lote"];
        $array = $this->input->post('array');
        $array2 = $this->input->post('array2');
        $fec = $this->input->post('fec');
        $fec = str_replace("/", "-", $fec);

        $id_transporte = $this->input->post('id_transporte');
        $array = str_replace('"', '', $array);
        $array2 = str_replace('"', '', $array2);
        $id_usuario = $this->session->userdata('id_usuario');
        /*  INICIO Oscar L., GAN-MS-B1-0253  */
        $solicitante = $_COOKIE["solicitante"];
        /*  FIN GAN-MS-B1-0253  */

        $com_update = $this->solicitud->aceptar_lote($id_usuario, $array, $array2, $id_transporte, $fec);
        if ($com_update[0]->oboolean == 'f') {
            $this->session->set_flashdata('error', $com_update[0]->omensaje);
        } else {
            $this->session->set_flashdata('success', 'Solicitud de Producto realizada exitosamente.');
        }
        $data = $this->solicitud->get_solicitud2($lote, $array);
        // FIN GAN-MS-A1-466 19-9-2022 PBeltran
        // configuracion de tamaños de letras y margenes
        $id_usuario = $this->session->userdata('id_usuario');
        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
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
            $codigoWidth = 60;
            $productoWidth = 240;
            $unidadWidth = 100;
            $cantidadWidth = 119;
        } else {
            $pdfSize = array(80, 1000);
            $pdfFontSizeMain = 9;
            $pdfFontSizeData = 8;
            $pdfMarginLeft = 2;
            $pdfMarginRight = 7;
            $imageSizeM = 5;
            $imageSizeN = 5;
            $imageSizeX = 25;
            $imageSizeY = 15;
            $marginTitle = 50;
            $codigoWidth = 40;
            $productoWidth = 60;
            $unidadWidth = 50;
            $cantidadWidth = 50;
        }

        // fin configuracion
        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $pdf = new Pdf_venta(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('ORDEN DE PEDIDO');
        $pdf->SetSubject('ORDEN DE PEDIDO');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0, 75, 146), array(0, 75, 146));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSize=0));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, 'B', $pdfFontSizeData));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins($pdfMarginLeft, 20, $pdfMarginRight);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(15);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);

        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);

        $pdf->SetFont('times', '', $pdfFontSizeMain, '', true);
        $pdf->AddPage('P', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $image_file = 'assets/img/icoLogo/' . $logo;
        $pdf->Image($image_file,  $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);
        $fecha = date("d/m/Y");
        $titulo = '  ORDEN DE PEDIDO';

        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeData);
        $pdf->MultiCell(65, 5, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell($marginTitle, 10, '', 0, 'C', 0, 1, '', '', true);


        $tbl = '<br>
        <div>
            <table>
            <th><font><b> SOLICITANTE:&nbsp;</b>' . $data[0]->osolicitado . '</font></th>
            <th></th>
            <th style="text-align:right;"><font><b> FECHA:&nbsp;</b>' . $fecha . '</font></th>
            </table>
        </div> ';

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="' . $codigoWidth . 'px"> CÓDIGO </th>
                <th width="' . $productoWidth . 'px"> PRODUCTO </th>
                <th width="' . $unidadWidth . 'px"> UNIDAD</th>
                <th width="' . $cantidadWidth . 'px"> CANTIDAD (Sol.)</th>
                <th width="' . $cantidadWidth . 'px"> CANTIDAD (Dis.)</th>
            </tr> ';
        $tbl2 = '';
        $contador = 0;
        foreach ($data as $ped) :
            $tbl2 = $tbl2 . '
                <tr>
                  <td style="text-align:center;"> P-' . $ped->oidmovimiento . '</td>
                  <td>' . $ped->oproducto . '</td>
                  <td style="text-align:center;">' . $ped->ounidad . '</td>
		  <td style="text-align:center;">' . $ped->ocantidad_solicitada . '</td>
                  <td style="text-align:center;">' . $ped->odisponible . '</td>
                </tr>';
        endforeach;
        /*  INICIO Oscar L., GAN-MS-B1-0253  */
        $tbl3 = '</table>
              <table border="1"> <th><b>&nbsp;&nbsp;Observaciones:</b><BR></th></table>
              <br><br><br><br><br>
                <div>
                    <table>
                    <tr>
                        <th style="text-align:center;"><font><b>-----------------------------------</b></font><BR>
                        <b>' . $solicitante . '</b>
                        </th>
                        <th style="text-align:center;">
                        <font><b>-----------------------------------</b></font><BR><b>SUPERVISOR</b><BR><BR><BR><BR><BR>
                        <font><b>-----------------------------------</b></font><BR><b>TRANSPORTE</b>
                        </th>
                        <th style="text-align:center;"><font><b>-----------------------------------</b></font><BR>
                        <b>SOLICITADO POR</b>
                        </th>
                        </tr>
                    </table>
                </div> ';
        /*  FIN GAN-MS-B1-0253  */
        $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');

        ob_end_clean();
        $pdf_ruta = $pdf->Output('ORDEN DE PEDIDO.pdf', 'I');
    }
}
