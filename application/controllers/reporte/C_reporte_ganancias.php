<?php
/* 
------------------------------------------------------------------------------------------
Creacion: Gary German Valverde Quisbert Fecha:16/09/2022, Codigo: GAN-MS-A1-462,
Descripcion: modulo para generar los reportes de produccion
 */
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_reporte_ganancias extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('reporte/M_reporte_ganancias', 'reporte_ganancias');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['fecha_imp'] = date('Y-m-d H:i:s');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'reporte/ganancias';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    //------- FUNCIONES AUXILIARES -------//
    public function func_auxiliares()
    {
        try {
            $accion = $_REQUEST['accion'];
            if (empty($accion))
                throw new Exception("Error accion no valida");
            switch ($accion) {
                case 'tbl_ganancias':
                    $id_ubi = $data['id_ubi'] = $this->input->post('selc_ubi');
                    $fec = $data['fec'] = $this->input->post('selc_frep');
                    $data['usuario'] = $this->session->userdata('usuario');
                    $data['fecha_imp'] = date('Y-m-d H:i:s');
                    $data['lst_ganancias'] = $lst_ganancias = $this->reporte_ganancias->get_lst_ganancias($fec);
                    $this->load->view('reporte/tbl_ganancias', $data);
                    break;

                default;
                    echo 'Error: Accion no encontrada';
            }
        } catch (Exception $e) {
            $log['error'] = $e;
        }
    }

    public function lst_reporte_ganancias()
    {

        $fecha_inicial =  $this->input->post('fecha_inicial');
        $fecha_fin = $this->input->post('fecha_fin');
        $id_ubicacion = $this->session->userdata('ubicacion');
        $lst_ganancias = $this->reporte_ganancias->get_lst_ganancias($id_ubicacion, $fecha_inicial, $fecha_fin);
        $data = array('responce' => 'success', 'posts' => $lst_ganancias);
        echo json_encode($data);
    }

    public function generar_pdf_ganancias()
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
        $fecha_inicial =  $this->input->post('fecha_inicial');
        $fecha_fin = $this->input->post('fecha_fin');
        $id_ubicacion = $this->session->userdata('ubicacion');
        $lst_ganancias = $this->reporte_ganancias->get_lst_ganancias($id_ubicacion, $fecha_inicial, $fecha_fin);

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
            $dim = $dim + (count($lst_ganancias) * 13.5);
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

        $pdf = new Pdf('Paisaje', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Ganancias');
        $pdf->SetSubject('Reporte de Ganancias');

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
              <font><b> REPORTE DE GANANCIAS </b></font><br>
          </div> ';


        $tbl1 = '
          <table cellpadding="3" border="1"> ';

        $tbl2 = '';
        foreach ($lst_ganancias as $reg) :
            if ($reg->detalle == 'INGRESOS') {
                $tbl2 = $tbl2 . '
                <tr style="background-color: #5CD3E5;">
                  <td width="5%" align="right">' . $reg->fila . '</td>
                  <td width="40%" align="left">' . $reg->detalle . '</td>
                  <td width="12%" align="right">' . $reg->fecha . '</td>
                  <td width="10%" align="right">' . $reg->cantidad . '</td>
                  <td width="18%" align="right">' . $reg->monto_unitario . '</td>
                  <td width="15%" align="right">' . $reg->monto_total . '</td>
                  
                </tr>';
            } else if ($reg->detalle == 'EGRESOS') {
                $tbl2 = $tbl2 . '
                <tr style="background-color: #FFB194;">
                  <td align="right">' . $reg->fila . '</td>
                  <td align="left">' . $reg->detalle . '</td>
                  <td align="right">' . $reg->fecha . '</td>
                  <td align="right">' . $reg->cantidad . '</td>
                  <td align="right">' . $reg->monto_unitario . '</td>
                  <td align="right">' . $reg->monto_total . '</td>
                  
                </tr>';
            } else if ($reg->detalle == 'DESCRIPCIÓN INGRESOS') {
                $tbl2 = $tbl2 . '
                <tr style="background-color: #D9F7F1;">
                  <td align="right">' . $reg->fila . '</td>
                  <td align="left">' . $reg->detalle . '</td>
                  <td align="right">' . $reg->fecha . '</td>
                  <td align="right">' . $reg->cantidad . '</td>
                  <td align="right">' . $reg->monto_unitario . '</td>
                  <td align="right">' . $reg->monto_total . '</td>
                  
                </tr>';
            } else if ($reg->detalle == 'DESCRIPCIÓN EGRESOS') {
                $tbl2 = $tbl2 . '
                <tr style="background-color: #FDE3D9;">
                  <td align="right">' . $reg->fila . '</td>
                  <td align="left">' . $reg->detalle . '</td>
                  <td align="right">' . $reg->fecha . '</td>
                  <td align="right">' . $reg->cantidad . '</td>
                  <td align="right">' . $reg->monto_unitario . '</td>
                  <td align="right">' . $reg->monto_total . '</td>
                  
                </tr>';
            } else if ($reg->detalle == 'RESULTADOS FINALES') {
                $tbl2 = $tbl2 . '
                <tr style="background-color: #E5CFEC;">
                  <td align="right">' . $reg->fila . '</td>
                  <td align="left">' . $reg->detalle . '</td>
                  <td align="right">' . $reg->fecha . '</td>
                  <td align="right">' . $reg->cantidad . '</td>
                  <td align="right">' . $reg->monto_unitario . '</td>
                  <td align="right">' . $reg->monto_total . '</td>
                  
                </tr>';
            } else if ($reg->fila == '=') {
                $tbl2 = $tbl2 . '
                <tr >
                  <td align="right">' . $reg->fila . '</td>
                  <td align="left">' . $reg->detalle . '</td>
                  <td align="right">' . $reg->fecha . '</td>
                  <td align="right">' . $reg->cantidad . '</td>
                  <td align="right" style="background-color: #737373;color:white;">' . $reg->monto_unitario . '</td>';
                  if (($reg->monto_total) < 0) {
                    $tbl2 = $tbl2 . '<td align="right" style="background-color: #F18585;">' . $reg->monto_total . '</td>';
                    }else if (($reg->monto_total) == '0') {
                    $tbl2 = $tbl2 . '<td align="right" style="background-color: #FFFCB2;">' . $reg->monto_total . '</td>';    
                    }else{
                    $tbl2 = $tbl2 . '<td align="right" style="background-color: #C3F7B9;">' . $reg->monto_total . '</td>';
                    }
                  
                    $tbl2 = $tbl2 . '</tr>';
            } else if ($reg->fila == '.') {
                $tbl2 = $tbl2 . '
                <tr >
                  <td align="right">' . $reg->fila . '</td>
                  <td align="left">' . $reg->detalle . '</td>
                  <td align="right">' . $reg->fecha . '</td>
                  <td align="right">' . $reg->cantidad . '</td>
                  <td align="right">' . $reg->monto_unitario . '</td>';

                if (($reg->monto_total) < 0) {
                    $tbl2 = $tbl2 . '<td align="right" style="background-color: #F18585;">' . $reg->monto_total . '</td>';
                }else if (($reg->monto_total) == '0') {
                    $tbl2 = $tbl2 . '<td align="right" style="background-color: #FFFCB2;">' . $reg->monto_total . '</td>';    
                }else{
                    $tbl2 = $tbl2 . '<td align="right" style="background-color: #C3F7B9;">' . $reg->monto_total . '</td>';
                }
                
                $tbl2 = $tbl2 . '</tr>';
            } else {
                $tbl2 = $tbl2 . '
                <tr>
                  <td align="right">' . $reg->fila . '</td>
                  <td align="left">' . $reg->detalle . '</td>
                  <td align="right">' . $reg->fecha . '</td>
                  <td align="right">' . $reg->cantidad . '</td>
                  <td align="right">' . $reg->monto_unitario . '</td>
                  <td align="right">' . $reg->monto_total . '</td>
                  
                </tr>';
            }

        endforeach;
        $tbl3 = '
          </table> ';

        $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_ganancias.pdf', 'I');
    }



    public function generar_excel_ganancias()
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
            ->setCellValue('B7', 'DETALLE')
            ->setCellValue('C7', 'FECHA')
            ->setCellValue('D7', 'CANTIDAD')
            ->setCellValue('E7', 'MONTO UNITARIO')
            ->setCellValue('F7', 'MONTO TOTAL');

        /* empresa */
        $objPHPExcel->getActiveSheet()->setCellValue('D2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D2:H2');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /* Titulo del reporte */
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'REPORTE DE GANANCIAS');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D3:H3');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /* Usuario */
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Usuario: ' . $usuario);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D4:H4');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /* Fecha */
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Fecha: ' . $fec_impresion);
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->mergeCells('D5:H5');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /* Negrita a los encabezados */
        $objPHPExcel->getActiveSheet()->getStyle("A7:F7")->getFont()->setBold(true);

        /* Ancho de columnas */
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('7');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('30');

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
        $fecha_inicial =  $this->input->post('fecha_inicial');
        $fecha_fin = $this->input->post('fecha_fin');
        $id_ubicacion = $this->session->userdata('ubicacion');
        $lst_ganancias = $this->reporte_ganancias->get_lst_ganancias($id_ubicacion, $fecha_inicial, $fecha_fin);
        $excel_row = 8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                )
            ),
        );

        foreach ($lst_ganancias as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, "$row->fila")
                ->setCellValue('B' . $excel_row, "$row->detalle")
                ->setCellValue('C' . $excel_row, "$row->fecha")
                ->setCellValue('D' . $excel_row, "$row->cantidad")
                ->setCellValue('E' . $excel_row, "$row->monto_unitario")
                ->setCellValue('F' . $excel_row, "$row->monto_total");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $excel_row . ':F' . ($excel_row))->applyFromArray($borders);

            $excel_row++;
        }
        /* $objPHPExcel->getActiveSheet()->setTitle('Simple');
        $objPHPExcel->setActiveSheetIndex(0);

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('test_img');
        $objDrawing->setDescription('test_img');
        $objDrawing->setPath($direccion_img);
        $objDrawing->setCoordinates('B2');
        $objDrawing->setOffsetX(80);
        $objDrawing->setOffsetY(5);
        $objDrawing->setWidth(100);
        $objDrawing->setHeight(132);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
         */
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Producción.xlsx"');
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
