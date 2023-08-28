<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:16/11/2022, Codigo: GAN-MS-A4-0061,
Descripcion: Se creo el controlador para el reporte de movimiento.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:24/11/2022, Codigo: GAN-MS-A7-0131
Descripcion: Se modifico para añadir los montos al reporte pdf y excel.
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_reporte_movimiento extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('reporte/M_reporte_movimiento','reporte_movimiento');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $data['fecha_imp'] = date('Y-m-d H:i:s');
            $data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['ubicaciones'] = $this->reporte_movimiento->get_ubicacion_cmb();
            $data['id_ubicacion'] = $this->session->userdata('ubicacion');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'reporte/movimiento';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function lst_reporte_movimiento() {

        $array_stock = array(
            'id_ubicacion' => $this->input->post('ubi_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_stock=json_encode($array_stock);
        $data = $this->reporte_movimiento->get_lst_reporte_movimiento($json_stock);
        echo json_encode($data);
    }

    public function generar_pdf_movimiento() {
        $array_stock = array(
            'id_ubicacion' => $this->input->post('ubi_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_stock=json_encode($array_stock);
        $lista_mov = $this->reporte_movimiento->get_lst_reporte_movimiento($json_stock);
        

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;

        // configuracion de tamaños de letras y margenes
        $id_usuario = $this->session->userdata('id_usuario');
        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
            // tamaño carta
            $marginTitle = 77;
            $marginSubTitle = 77;
            $pdfMarginLeft = 15;
            $pdfMarginRight = 15;
            $pdfFontSizeData= PDF_FONT_SIZE_DATA;
            $pdfSize = PDF_PAGE_FORMAT;
            $pdfFontSizeMain= PDF_FONT_SIZE_MAIN;
            $imageSizeN= 15;
            $imageSizeM= 20;
            $imageSizeX = 45;
            $imageSizeY = 15;
            $numeroWidth = 30;
            $fechaWidth = 98;
            $productoWidth = 170;
            $detalleWidth = 105;
            $stockWidth = 68;
            $importeWidth = 118;
            $espacioWidth = 480;
            $footer=true;
        } else  {
            $dim=80;
            $dim=$dim+(count($lista_mov)*12);
            $pdfSize = array(80,$dim);
            $pdfFontSizeMain= 9;
            $pdfFontSizeData= 8;
            $pdfMarginLeft = 2;
            $pdfMarginRight = 7;
            $imageSizeM= 5;
            $imageSizeN = 5;
            $imageSizeX = 25;
            $imageSizeY = 15;
            $marginTitle = 40;
            $marginSubTitle = 20;
            $numeroWidth = 20;
            $fechaWidth = 50;
            $productoWidth = 70;
            $detalleWidth = 30;
            $stockWidth = 30;
            $importeWidth = 40;
            $espacioWidth = 440;
            $footer=false;
        }
        
        // fin configuracion

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Movimiento');
        $pdf->SetSubject('Reporte de Movimiento');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0,75,146), array(0,75,146));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSize));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, 'B', $pdfFontSizeData));
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
        $pdf->AddPage('L', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $image_file = 'assets/img/icoLogo/'.$logo;

        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

        $titulo='        EMPRESA '.$titulo;
        
        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeData);

        $usuario = $this->session->userdata('usuario');
        date_default_timezone_set('America/La_Paz');
        $fec_impresion = date('Y-m-d H:i:s');

        $tbl = '
          <div style="text-align:rigth; font-size: 12px">
              <font><b>Usuario:</b> '.$usuario.' </font><br>
              <font><b>Fecha:</b> '.$fec_impresion.' </font>
          </div>
          <div style="text-align:center;">
              <font><b> REPORTE DE MOVIMIENTO </b></font><br>
          </div> ';

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$fechaWidth.'px"> Fecha </th>
                <th width="'.$productoWidth.'px"> Producto </th>
                <th width="'.$fechaWidth.'px"> Detalle </th>
                <th width="'.$stockWidth.'px"> Cantidad entrante</th>
                <th width="'.$stockWidth.'px"> Cantidad saliente </th>
                <th width="'.$stockWidth.'px"> Stock anterior</th>
                <th width="'.$stockWidth.'px"> Stock actual</th>
                <th width="'.$stockWidth.'px"> Monto entrante</th>
                <th width="'.$stockWidth.'px"> Monto saliente</th>
                <th width="'.$stockWidth.'px"> Monto anterior</th>
                <th width="'.$stockWidth.'px"> Monto actual</th>
            </tr> ';

            $nro=0;
            $tbl2 = '';
            
            foreach ($lista_mov as $in):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td>'.$in->ofecha_mov.'</td>
                  <td>'.$in->odescripcion.'</td>
                  <td align="center">'.$in->odetalle.'</td>
                  <td align="center">'.$in->oentrante.'</td>
                  <td align="center">'.$in->osaliente.'</td>
                  <td align="center">'.$in->ostock_ant.'</td>
                  <td align="center">'.$in->ostock_act.'</td>
                  <td align="center">'.$in->om_entrante.'</td>
                  <td align="center">'.$in->om_saliente.'</td>
                  <td align="center">'.$in->om_anterior.'</td>
                  <td align="center">'.$in->om_actual.'</td>

                </tr>';
            endforeach;
              $tbl3 = '
          </table> ';

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_Movimiento.pdf', 'I');
    }

    public function generar_excel_movimiento(){

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;
        
        $empresa = 'EMPRESA '.$titulo;
        $direccion_img = 'assets/img/icoLogo/'.$logo;


        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document")
                                    ->setSubject("Office 2007 XLSX Test Document")
                                    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                    ->setKeywords("office 2007 openxml php")
                                    ->setCategory("Test result file");
                
        $usuario = $this->session->userdata('usuario');
        date_default_timezone_set('America/La_Paz');
        $fec_impresion = date('Y-m-d H:i:s');
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A7', 'Nº')
                    ->setCellValue('B7', 'Fecha')
                    ->setCellValue('C7', 'Producto')
                    ->setCellValue('D7', 'Detalle')
                    ->setCellValue('E7', 'Cantidad Entrante')
                    ->setCellValue('F7', 'Cantidad Saliente')
                    ->setCellValue('G7', 'Stock Anterior')
                    ->setCellValue('H7', 'Stock Actual')
                    ->setCellValue('I7', 'Monto Entrante')
                    ->setCellValue('J7', 'Monto Saliente')
                    ->setCellValue('K7', 'Monto Anterior')
                    ->setCellValue('L7', 'Monto Actual');

        $objPHPExcel->getActiveSheet()->setCellValue('C2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('C2:G2');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);            

        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'REPORTE DE MOVIMIENTO');
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(15)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('C3:G3');
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Usuario: '.$usuario);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('C4:G4');
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'Fecha: '.$fec_impresion);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->mergeCells('C5:G5');
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    

        $objPHPExcel->getActiveSheet()->getStyle("A7:L7")->getFont()->setBold(true);                    

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('34');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('24');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('12');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('12');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('12');
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('12');
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('12');
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('12');
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('12');
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth('12');

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('30');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('30');

        $objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array('rgb' => 'A1A5A8')
        ));

        $array_stock = array(
            'id_ubicacion' => $this->input->post('ubi_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_stock=json_encode($array_stock);
        $lista_mov = $this->reporte_movimiento->get_lst_reporte_movimiento($json_stock);

        $excel_row=8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
                )
            ),
        );
        foreach($lista_mov as $row)
        {      
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, $excel_row-7)
                                          ->setCellValue('B' . $excel_row, "$row->ofecha_mov")
                                          ->setCellValue('C' . $excel_row, "$row->odescripcion")
                                          ->setCellValue('D' . $excel_row, "$row->odetalle")
                                          ->setCellValue('E' . $excel_row, "$row->oentrante")
                                          ->setCellValue('F' . $excel_row, "$row->osaliente")
                                          ->setCellValue('G' . $excel_row, "$row->ostock_ant")
                                          ->setCellValue('H' . $excel_row, "$row->ostock_act")
                                          ->setCellValue('I' . $excel_row, "$row->om_entrante")
                                          ->setCellValue('J' . $excel_row, "$row->om_saliente")
                                          ->setCellValue('K' . $excel_row, "$row->om_anterior")
                                          ->setCellValue('L' . $excel_row, "$row->om_actual");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row.':L'.($excel_row))->applyFromArray($borders);                                
            $objPHPExcel->getActiveSheet()->getStyle('D'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel_row++;                                           
        }

        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        $objPHPExcel->setActiveSheetIndex(0);

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('test_img');
        $objDrawing->setDescription('test_img');
        $objDrawing->setPath($direccion_img);
        $objDrawing->setCoordinates('B2');                      
        $objDrawing->setOffsetX(30); 
        $objDrawing->setOffsetY(20);                
        $objDrawing->setWidth(100); 
        $objDrawing->setHeight(80); 
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Movimiento.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}
