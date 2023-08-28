<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:11/11/2021, Codigo: GAN-MS-A5-078,
Creacion del Controlador C_reporte_creditos para conectar con creditos y M_reporte_creditos para la corrida de funciones
 */
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_reporte_creditos extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('reporte/M_reporte_creditos','reporte_creditos');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['cliente'] = $this->reporte_creditos->get_lst_clientes();
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
            $data['contenido'] = 'reporte/creditos';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function lst_reporte_creditos() {

        $array_creditos = array(
            'estado' => $this->input->post('selc_cli_estado'),
            'id_cliente' => $this->input->post('selc_cli'),
            'fecha_inicial' => $this->input->post('selc_frep'),
            'fecha_fin' => $this->input->post('selc_finrep'),
        );
        $json_creditos=json_encode($array_creditos);

        
        $data['usuario'] = $this->session->userdata('usuario');
        $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
        $lst_creditos = $this->reporte_creditos->get_lst_rep_deudas($json_creditos);
        $data= array('responce'=>'success','posts'=>$lst_creditos);
        echo json_encode($data);
        
        
    }
    public function pagar_deuda() {
        $idlote = $this->input->post('dato1');
        $usucre = $this->input->post('dato2');
        $idcliente = $this->input->post('dato3');
        $pago = $this->input->post('dato4');
        $pago_deuda = $this->reporte_creditos->get_pagar_deuda($idlote,$usucre,$idcliente,$pago);
        echo json_encode($pago_deuda);
    }

    public function historial_deuda() {
        $idlote = $this->input->post('dato1');
        $usucre = $this->input->post('dato2');
        $idcliente = $this->input->post('dato3');
        $historial_deuda = $this->reporte_creditos->get_historial_deuda($idlote, $usucre, $idcliente);
        $historial_deuda= $historial_deuda[0]->fn_historial_deuda;
        echo $historial_deuda;
    }

    public function generar_excel_creditos(){
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
                    ->setCellValue('B7', 'Razon Social')
                    ->setCellValue('C7', 'Fecha')
                    ->setCellValue('D7', 'Total')
                    ->setCellValue('E7', 'Pagado')
                    ->setCellValue('F7', 'Saldo')
                    ->setCellValue('G7', 'Estado');
        
        $objPHPExcel->getActiveSheet()->setCellValue('C2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('C2:G2');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);            

        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'REPORTE DE CREDITOS');
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

        $objPHPExcel->getActiveSheet()->getStyle("A7:G7")->getFont()->setBold(true);                    

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('15');

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('30');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('30');

        $objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array('rgb' => 'A1A5A8')
        ));



        $array_creditos = array(
            'estado' => $this->input->post('cli_estado'),
            'id_cliente' => $this->input->post('cli_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_creditos=json_encode($array_creditos);
        
        $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
        $lst_creditos = $this->reporte_creditos->get_lst_rep_deudas($json_creditos);

        $excel_row=8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
                )
            ),
        );
        foreach($lst_creditos as $row)
        {   
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, $excel_row-7)
                                          ->setCellValue('B' . $excel_row, "$row->orazonsocial")
                                          ->setCellValue('C' . $excel_row, "$row->ofecha")
                                          ->setCellValue('D' . $excel_row, "$row->ototal")
                                          ->setCellValue('E' . $excel_row, "$row->opagado")
                                          ->setCellValue('F' . $excel_row, "$row->osaldo")
                                          ->setCellValue('G' . $excel_row, "$row->oestado");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row.':G'.($excel_row))->applyFromArray($borders);                                
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);          
            $objPHPExcel->getActiveSheet()->getStyle('C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
        header('Content-Disposition: attachment;filename="Reporte Creditos.xlsx"');
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

    
    public function generar_pdf_creditos(){

        $array_creditos = array(
            'estado' => $this->input->post('cli_estado'),
            'id_cliente' => $this->input->post('cli_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_creditos=json_encode($array_creditos);
        
        
        $data['usuario'] = $this->session->userdata('usuario');
        $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;

        // configuracion de tamaños de letras y margenes
        $id_usuario = $this->session->userdata('id_usuario');
        $id_papel = $this->general->get_papel_size($id_usuario);
        $lst_creditos = $this->reporte_creditos->get_lst_rep_deudas($json_creditos);
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
            $rsocialWidth = 228;
            $fechaWidth = 80;
            $totalWidth = 80;
            $pagadoWidth = 80;
            $saldoWidth = 80;
            $estadoWidth = 80;
            $footer=true;
        } else  {
            $dim=80;
            $dim=$dim+(count($lst_creditos)*10);
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
            $rsocialWidth = 50;
            $fechaWidth = 40;
            $totalWidth = 35;
            $pagadoWidth = 35;
            $saldoWidth = 35;
            $estadoWidth = 40;
            $footer=false;
        }

        // fin configuracion



        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT,  $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Creditos');
        $pdf->SetSubject('Reporte de Creditos');

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
       
        $usuario = $this->session->userdata('usuario');
        $fec_impresion = date('Y-m-d H:i:s');

        $tbl = '
        <div style="text-align:rigth; font-size: 12px">
        <font><b>Usuario:</b> '.$usuario.' </font><br>
        <font><b>Fecha:</b> '.$fec_impresion.' </font>
        </div>

        <div style="text-align:center;">
            <font><b> REPORTE DE CREDITOS </b></font><br>
        </div> ';

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$rsocialWidth.'px"> Razon Social </th>
                <th width="'.$fechaWidth.'px">Fecha </th>
                <th width="'.$totalWidth.'px"> Total </th>
                <th width="'.$pagadoWidth.'px"> Pagado </th>
                <th width="'.$saldoWidth.'px"> Saldo </th>
                <th width="'.$estadoWidth.'px"> Estado </th>
            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($lst_creditos as $ven):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td>'.$ven->orazonsocial.'</td>
                  <td align="rigth">'.$ven->ofecha.'</td>
                  <td align="rigth">'.$ven->ototal.'</td>
                  <td align="rigth">'.$ven->opagado.'</td>
                  <td align="rigth">'.$ven->osaldo.'</td>
                  <td align="rigth">'.$ven->oestado.'</td>
                </tr>';
            endforeach;
              $tbl3 = '
          </table> ';

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_creditos.pdf', 'I');
    }

    public function generar_pdf_historial(){

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;

        $idlote = $this->input->post('id_lote');
        $usucre = $this->input->post('usucre');
        $idcliente = $this->input->post('idcliente');
        $historial_deuda = $this->reporte_creditos->get_historial_deuda($idlote, $usucre, $idcliente);
        $historial_deuda= $historial_deuda[0]->fn_historial_deuda;
        $historial_deuda=json_decode($historial_deuda);
        $cliente = $historial_deuda->cliente;
        $fecha = $historial_deuda->fecha;
        $total = $historial_deuda->total;
        $pagado = $historial_deuda->pagado;
        $saldo = $historial_deuda->saldo;
        $productos = $historial_deuda->productos;
        $historial = $historial_deuda->historial;

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Creditos');
        $pdf->SetSubject('Reporte de Creditos');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0,75,146), array(0,75,146));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, 'B', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, 'B', PDF_FONT_SIZE_DATA));
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

        $image_file = 'assets/img/icoLogo/'.$logo;

        $pdf->Image($image_file, 20, 15, 45, 15, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', 13);

        $titulo='        EMPRESA '.$titulo;
        
        $pdf->MultiCell(80, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', 11);

        $usuario = $this->session->userdata('usuario');
        $fec_impresion = date('Y-m-d H:i:s');

        $tbl = '
        <div style="text-align:rigth; color:#96999c; font-size: 12px">
        <font><b>Usuario:</b> '.$usuario.' </font><br>
        <font><b>Fecha:</b> '.$fec_impresion.' </font>
        </div>

        <div style="text-align:center;">
            <font size="14px"><b> HISTORIAL </b></font><br>
        </div> 
        <div>
            <font size="12px"><b> Cliente: </b>'.$cliente.'</font><br>
            <font size="12px"><b> Fecha: </b>'.$fecha.'</font><br>
            <font size="12px"><b> Monto total Adeudado: </b>'.$total.'</font><br>
            <font size="12px"><b> Pagado hasta la fecha: </b>'.$pagado.'</font><br>
            <font size="12px"><b> Saldo: </b>'.$saldo.'</font>
        </div> 

        ';

        $tbl1 = '
        <div style="text-align:center;">
        <font size="13px"><b> DETALLE </b></font><br>
        </div> 
          <table cellpadding="3" border="1" style="margin-left: auto; margin-right: auto;">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="30px"> N&ordm; </th>
                <th width="500px"> Producto </th>
                <th width="128px"> Precio </th>
            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($productos as $ven):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td>'.$ven->producto.'</td>
                  <td align="center">'.$ven->precio.'</td>
                </tr>';
            endforeach;
              $tbl3 = '
              <tr style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="30px"></th>
                <th width="500px">Total: </th>
                <th align="center" width="128px">'.$total.'</th>
              </tr> 
          </table> ';
          $tbl4 = '
          <div style="text-align:center;">
          <br><font size="13px"><b> HISTORIAL </b></font><br>
          </div> 
          <table align="center" cellpadding="3" border="1" margin-right= 122px;>
            <tr  style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="30px"> N&ordm; </th>
                <th width="210px"> Fecha </th>
                <th width="209px"> Monto </th>
                <th width="209px"> Saldo </th>
            </tr> ';

            $nro1=0;
            $tbl5 = '';
            foreach ($historial as $ven):
              $nro1++;
              $tbl5 = $tbl5.'
                <tr>
                  <td align="center">'.$nro1.'</td>
                  <td>'.$ven->fecha.'</td>
                  <td align="center">'.$ven->monto.'</td>
                  <td align="center">'.$ven->saldo.'</td>
                </tr>';
            endforeach;
              $tbl6 = '
          </table> '; 

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3.$tbl4.$tbl5.$tbl6, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_historial.pdf', 'I');

    }


}
