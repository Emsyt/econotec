<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:07/09/2021, Codigo: GAN-MS-A3-026,
Creacion del Controlador C_reporte_gastos para conectar con gastos 
y M_reporte_gastos
 */
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_reporte_gastos extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('reporte/M_reporte_gastos','reporte_gastos');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['ubicaciones'] = $this->reporte_gastos->get_lst_estados_gastos($usr);
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
            $data['contenido'] = 'reporte/gastos';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function lst_reporte_gastos() {

        $array_gastos = array(
            'estado' => $this->input->post('selc_ubi'),
            'fecha_inicial' => $this->input->post('selc_frep'),
            'fecha_fin' => $this->input->post('selc_finrep'),
        );
        $json_gastos=json_encode($array_gastos);

        $data['usuario'] = $this->session->userdata('usuario');
        $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
        $lst_gastos = $this->reporte_gastos->get_rep_gastos($usr,$json_gastos);
        
        $data= array('responce'=>'success','posts'=>$lst_gastos);
        echo json_encode($data);
        
        
    }

    public function generar_excel_gastos(){

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
        $fec_impresion = date('Y-m-d H:i:s');

        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A7', 'Nº')
                    ->setCellValue('B7', 'Detalle')
                    ->setCellValue('E7', 'Monto Total')
                    ->setCellValue('F7', 'Fecha')
                    ->setCellValue('G7', 'Estado');

        $objPHPExcel->getActiveSheet()->mergeCells('B7:D7');                    

        $objPHPExcel->getActiveSheet()->setCellValue('D2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D2:G2');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);            

        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'REPORTE DE GASTOS');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D3:G3');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Usuario: '.$usuario);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D4:G4');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Fecha: '.$fec_impresion);
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->mergeCells('D5:G5');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    

        $objPHPExcel->getActiveSheet()->getStyle("A7:G7")->getFont()->setBold(true);                    

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('15');


        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('30');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('30');

        $objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array('rgb' => 'A1A5A8')
        ));


        $array_gastos = array(
            'estado' => $this->input->post('ubi_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_gastos=json_encode($array_gastos);

        $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
        $lst_gastos = $this->reporte_gastos->get_rep_gastos($usr,$json_gastos);

        $excel_row=8;
        $excel_row=8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
                )
            ),
        );
        foreach($lst_gastos as $row)
        {   
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, $excel_row-7)
                                          ->setCellValue('B' . $excel_row, "$row->odetalle")
                                          ->setCellValue('E' . $excel_row, "$row->omonto_total")
                                          ->setCellValue('F' . $excel_row, "$row->ofecha")
                                          ->setCellValue('G' . $excel_row, "$row->oestado");
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$excel_row.':D'.($excel_row));        
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row.':G'.($excel_row))->applyFromArray($borders);                                
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);          
            $objPHPExcel->getActiveSheet()->getStyle('F'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
               
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
        header('Content-Disposition: attachment;filename="Reporte Gasto.xlsx"');
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

    
    public function generar_pdf_gastos(){

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;

        $array_gasto = array(
            'estado' => $this->input->post('ubi_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json=json_encode($array_gasto);
        $usuario = $this->session->userdata('usuario');
        $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
        $lst_gastos = $this->reporte_gastos->get_rep_gastos($usr,$json);
         // configuracion de tamaños de letras y margenes
        $id_usuario = $this->session->userdata('id_usuario');
        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
            // tamaño carta
            $marginTitle = 77;
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
            $detalleWidth = 328;
            $montoWidth = 100;
            $fechaWidth = 100;
            $estadoWidth = 100;
            $footer=true;
        } else {
            $dim=80;
            $dim=$dim+(count($lst_gastos)*10.25);
            $pdfSize = array(80,$dim);
            $pdfFontSizeMain= 9;
            $pdfFontSizeData= 8;
            $pdfMarginLeft = 2;
            $pdfMarginRight = 7;
            $imageSizeM= 5;
            $imageSizeN = 5;
            $imageSizeX = 25;
            $imageSizeY = 15;
            $marginTitle = 30;
            $numeroWidth = 20;
            $detalleWidth = 100;
            $montoWidth = 40;
            $fechaWidth = 40;
            $estadoWidth = 50;
            $footer=false;
        }
         // fin configuracion

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Gastos');
        $pdf->SetSubject('Reporte de Gastos');

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
        $pdf->AddPage('P', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);


        $image_file = 'assets/img/icoLogo/'.$logo;

        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

        $titulo='        EMPRESA '.$titulo;
        
        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeData);

        $fec_impresion = date('Y-m-d H:i:s');

        $tbl = '
        <div style="text-align:rigth; font-size: 12px">
        <font><b>Usuario:</b> '.$usuario.' </font><br>
        <font><b>Fecha:</b> '.$fec_impresion.' </font>
        </div>

        <div style="text-align:center;">
            <font><b> REPORTE DE GASTOS </b></font><br>
        </div> ';

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$detalleWidth.'px"> Detalle </th>
                <th width="'.$montoWidth.'px"> Monto Total </th>
                <th width="'.$fechaWidth.'px"> Fecha </th>
                <th width="'.$estadoWidth.'px"> Estado </th>

            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($lst_gastos as $ven):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td>'.$ven->odetalle.'</td>
                  <td align="rigth">'.$ven->omonto_total.'</td>
                  <td align="rigth">'.$ven->ofecha.'</td>
                  <td align="rigth">'.$ven->oestado.'</td>
                </tr>';
            endforeach;
              $tbl3 = '
          </table> ';

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_gatos.pdf', 'I');
    }


}
