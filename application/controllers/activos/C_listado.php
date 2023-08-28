<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha:22/11/2022   SAM-MS-A7-0002,
Descripcion: Se Realizo el controlador de listado bitacora activos
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Melani Alisson Cusi Burgoa Fecha:24/11/2022   SAM-MS-A7-0005,
Descripcion: Se creo la funcion para general EXCEL Y PDF
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_listado extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('activos/M_listado','listado');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['fecha_imp'] = date('Y-m-d H:i:s');
            
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'activos/listado';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    //
    public function mostrar_listado_producto_cod(){
        $codigo_producto = $this->input->post('codigo_producto');
        $data = $this->listado->mostrar_listado_producto_cod($codigo_producto);
        echo json_encode($data);
    }

    public function lts_codigos_bitacora(){
        $data = $this->listado->lts_codigos_bitacora();
        echo json_encode($data);
    }

    public function generar_pdf_listado()
    {

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;

        // configuracion de tamaños de letras y margenes
        $id_usuario = $this->session->userdata('id_usuario');
        $id_papel = $this->general->get_papel_size($id_usuario);
        /* NUEVO */
        $codigo_prod =  $this->input->post('cod_prod');
        
        $lst_bitprod = $this->listado->mostrar_listado_producto_cod($codigo_prod);

        if ($id_papel[0]->oidpapel == 1304) {
            $marginTitle = 77;
            $fechaWidth = 70;
            $idloteWidth = 10;
            $horaWidth = 10;
            $ProductoWidth = 10;
            $usuarioWidth = 10;
            $ubicacionWidth = 10;
            $pdfMarginLeft = 15;
            $pdfMarginRight = 15;
            $pdfFontSizeData = PDF_FONT_SIZE_DATA;
            $pdfSize = PDF_PAGE_FORMAT;
            $pdfFontSizeMain = PDF_FONT_SIZE_MAIN;
            $imageSizeN = 15;
            $imageSizeM = 20;
            $imageSizeX = 45;
            $imageSizeY = 15;
            $footer = true;
        } else {
            // tamaño carta
            $dim = 80;
            $dim = $dim + (count($lst_bitprod) * 13.5);
            $pdfSize = array(80, $dim);
            $pdfFontSizeMain = 9;
            $pdfFontSizeData = 8;
            $pdfMarginLeft = 2;
            $pdfMarginRight = 7;
            $imageSizeM = 5;
            $imageSizeN = 5;
            $imageSizeX = 20;
            $imageSizeY = 20;
            $marginTitle = 20;
            $fechaWidth = 60;
            $idloteWidth = 50;
            $horaWidth = 60;
            $ProductoWidth = 100;
            $usuarioWidth = 60;
            $ubicacionWidth = 80;
            $footer = false;
        }

        // fin configuracion

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Listado');
        $pdf->SetSubject('Reporte de Listado');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0, 75, 146), array(0, 75, 146));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSizeData));
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
            <div style="text-align:right;">
                <font><b>Usuario:</b> ' . $usuario . ' </font><br>
                <font><b>Fecha:</b> ' . $fec_impresion . ' </font>
            </div>

            <div style="text-align:center;">
                <font><b> REPORTE DE LISTADO BITÁCORA DE COD.PRODUCTO '.$codigo_prod.' </b></font><br>
            </div> ';
        // titulos de la tabla 1 pdf
        $tbl1 = '
            <table cellpadding="10" border="1"> 
            <thead>
                <tr bgcolor="#E5E6E8">
                    <th width="10%" >Nº</th>
                    <th width="20%">Usuario</th>
                    <th width="15%">Fecha Asignación</th>
                    <th width="15%">Fecha Devolución</th>
                    <th width="25%">Motivo</th>
                    <th width="15%">Estado</th>
                </tr>
            </thead>';
        // contenido tabla 2 pdf
        $tbl2 = '<tbody>';
        foreach ($lst_bitprod as $reg) :
            $tbl2 = $tbl2 . '
                <tr> 
                    <td width="10%" >' . $reg->onum . '</td>
                    <td width="20%">' . $reg->ousuario . '</td>
                    <td width="15%">' . $reg->ofecha_salida . '</td>
                    <td width="15%">' . $reg->ofecha_regreso . '</td>
                    <td width="25%">' . $reg->omotivo . '</td>
                    <td width="15%">' . $reg->oestado . '</td>
                </tr>
            ';
        endforeach;
        $tbl3 = '
                </tbody>
            </table> ';

        $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('reporte_listado.pdf', 'I');
    }

    public function generar_excel_listado()
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

        /*CONTENDIO  */

        /* tabla encabezados */
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A7', 'Nº')
            ->setCellValue('B7', 'USUARIO')
            ->setCellValue('C7', 'FECHA ASIGNACION')
            ->setCellValue('D7', 'FECHA DEVOLUCION')
            ->setCellValue('E7', 'MOTIVO')
            ->setCellValue('F7', 'ESTADO');

        /* empresa */
        $objPHPExcel->getActiveSheet()->setCellValue('B2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('B2:F2');
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /* Titulo del reporte */
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'REPORTE DE LISTADO BITÁCORA COD. PRODUCTO ');
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(15)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('B3:F3');
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /* Usuario */
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Usuario: ' . $usuario);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('B4:F4');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /* Fecha */
        $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Fecha: ' . $fec_impresion);
        $objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->mergeCells('B5:F5');
        $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /* Negrita a los encabezados */
        $objPHPExcel->getActiveSheet()->getStyle("A7:F7")->getFont()->setBold(true);

        /* Ancho de columnas */
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('7');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('25');

        /* Alto de columnas de titulo */
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('30');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('30');

        /* Resaltar encabezados */
        $objPHPExcel->getActiveSheet()->getStyle('A7:F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:F7')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array('rgb' => 'A1A5A8')
        ));

        /* Rescatamos la tabla */
        
        $codigo_prod =  $this->input->post('cod_prod');
        
        $lst_bitprod = $this->listado->mostrar_listado_producto_cod($codigo_prod);

        $excel_row = 8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                )
            ),
        );

        foreach ($lst_bitprod as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, "$row->onum")
                ->setCellValue('B' . $excel_row, "$row->ousuario")
                ->setCellValue('C' . $excel_row, "$row->ofecha_salida")
                ->setCellValue('D' . $excel_row, "$row->ofecha_regreso")
                ->setCellValue('E' . $excel_row, "$row->omotivo")
                ->setCellValue('F' . $excel_row, "$row->oestado");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $excel_row . ':F' . ($excel_row))->applyFromArray($borders);

            $excel_row++;
        }
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte listado bitácora producto.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

        echo 'Todo bien hasta ahora';
    }

}
