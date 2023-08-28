<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:11/11/2021, Codigo: GAN-MS-A5-078,
Creacion del Controlador C_reporte_abast_pagar para conectar con abastecimiento_pagar y reporte_abast_pagar para la corrida de funciones
 */
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_reporte_abast_pagar extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('reporte/M_reporte_abast_pagar','reporte_abast_pagar');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['proveedores'] = $this->reporte_abast_pagar->get_proveedor_cmb();
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
            $data['contenido'] = 'reporte/abastecimiento_pagar';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function lst_reporte_abast_pagar() {

        $array_deudas_abastecimiento = array(
            'estado' => $this->input->post('selc_cli_estado'),
            'id_proveedor' => $this->input->post('selc_prov'),
            'fecha_inicial' => $this->input->post('selc_frep'),
            'fecha_fin' => $this->input->post('selc_finrep'),
        );
        $json_deudas_abastecimiento=json_encode($array_deudas_abastecimiento);
        $lst_deudas_abastecimiento = $this->reporte_abast_pagar->get_lst_deudas_abastecimiento($json_deudas_abastecimiento);
        $data= array('responce'=>'success','posts'=>$lst_deudas_abastecimiento);
        echo json_encode($data);
        
        
    }
    public function pagar_deuda() {
        $codigo = $this->input->post('dato1');
        $detalle = $this->input->post('dato2');
        $pago = $this->input->post('dato4');
        $pago_deuda = $this->reporte_abast_pagar->get_pagar_deuda_abastecimiento($codigo, $detalle, $pago);
        echo json_encode($pago_deuda);
    }

    public function historial_deuda() {
        $codigo = $this->input->post('dato1');
        $detalle = $this->input->post('dato2');
        $historial_deuda = $this->reporte_abast_pagar->get_historial_deuda_abastecimiento($codigo, $detalle);
        $historial_deuda = $historial_deuda[0]->fn_historial_deuda_abastecimiento;
        echo $historial_deuda;
    }

    public function generar_excel__abast_pagar(){

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
                    ->setCellValue('B7', 'Ubicacion')
                    ->setCellValue('C7', 'Proveedor')
                    ->setCellValue('D7', 'Fecha')
                    ->setCellValue('E7', 'Total')
                    ->setCellValue('F7', 'Pagado')
                    ->setCellValue('G7', 'Saldo')
                    ->setCellValue('H7', 'Estado');
                    

        $objPHPExcel->getActiveSheet()->setCellValue('D2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D2:H2');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);            

        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'REPORTE DE ABASTECIMIENTO A PAGAR');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D3:H3');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Usuario: '.$usuario);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D4:H4');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Fecha: '.$fec_impresion);
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->mergeCells('D5:H5');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    

        $objPHPExcel->getActiveSheet()->getStyle("A7:H7")->getFont()->setBold(true);                    

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('15');

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('30');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('30');

        $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array('rgb' => 'A1A5A8')
        ));

        $array_deudas_abastecimiento = array(
            'estado' => $this->input->post('cli_estado'),
            'id_proveedor' => $this->input->post('cli_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_deudas_abastecimiento=json_encode($array_deudas_abastecimiento);
        $lst_deudas_abastecimiento = $this->reporte_abast_pagar->get_lst_deudas_abastecimiento($json_deudas_abastecimiento);

        $excel_row=8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
                )
            ),
        );
        foreach($lst_deudas_abastecimiento as $row)
        {   
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, $excel_row-7)
                                          ->setCellValue('B' . $excel_row, "$row->oubicacion")
                                          ->setCellValue('C' . $excel_row, "$row->oproveedor")
                                          ->setCellValue('D' . $excel_row, "$row->ofecha")
                                          ->setCellValue('E' . $excel_row, "$row->ototal")
                                          ->setCellValue('F' . $excel_row, "$row->opagado")
                                          ->setCellValue('G' . $excel_row, "$row->osaldo")
                                          ->setCellValue('H' . $excel_row, "$row->oestado");
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row.':H'.($excel_row))->applyFromArray($borders);                                
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);          
            $objPHPExcel->getActiveSheet()->getStyle('B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
               
            $excel_row++;                                           
        }

        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        $objPHPExcel->setActiveSheetIndex(0);

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('test_img');
        $objDrawing->setDescription('test_img');
        $objDrawing->setPath($direccion_img);
        $objDrawing->setCoordinates('C2');                      
        $objDrawing->setOffsetX(10); 
        $objDrawing->setOffsetY(5);                
        $objDrawing->setWidth(100); 
        $objDrawing->setHeight(132); 
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Abast Pagar.xlsx"');
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

    
    public function generar_pdf_abast_pagar(){

        $array_deudas_abastecimiento = array(
            'estado' => $this->input->post('cli_estado'),
            'id_proveedor' => $this->input->post('cli_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_deudas_abastecimiento=json_encode($array_deudas_abastecimiento);
        $lst_deudas_abastecimiento = $this->reporte_abast_pagar->get_lst_deudas_abastecimiento($json_deudas_abastecimiento);
        
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
            $ubicacionWidth = 60;
            $proveedorWidth = 208;
            $fechaWidth = 70;
            $totalWidth = 60;
            $pagadoWidth = 60;
            $saldoWidth = 60;
            $estadoWidth = 80;
            $footer=true;
        } else  {
            $dim=80;
            $dim=$dim+(count($lst_deudas_abastecimiento)*26);
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
            $numeroWidth = 15;
            $ubicacionWidth = 30;
            $proveedorWidth = 40;
            $fechaWidth = 30;
            $totalWidth = 35;
            $pagadoWidth = 35;
            $saldoWidth = 35;
            $estadoWidth = 30;
            $footer=false;
        }
        
        // fin configuracion

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Abastecimiento por Pagar');
        $pdf->SetSubject('Reporte de Abastecimiento por Pagar');

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
            <font><b> REPORTE DE ABASTECIMIENTO POR PAGAR</b></font><br>
        </div> ';

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$ubicacionWidth.'px"> Ubicacion </th>
                <th width="'.$proveedorWidth.'px"> Proveedor </th>
                <th width="'.$fechaWidth.'px">Fecha </th>
                <th width="'.$totalWidth.'px"> Total </th>
                    <th width="'.$pagadoWidth.'px"> Pagado </th>
                    <th width="'.$saldoWidth.'px"> Saldo </th>
                    <th width="'.$estadoWidth.'px"> Estado </th>


            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($lst_deudas_abastecimiento as $ven):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td>'.$ven->oubicacion.'</td>
                  <td>'.$ven->oproveedor.'</td>
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
        $pdf_ruta = $pdf->Output('Reporte_Abast_Pagar.pdf', 'I');
    }

    public function generar_pdf_historial_abast_pagar(){

        $codigo = $this->input->post('codigo');
        $detalle = $this->input->post('detalle');
        $historial_deuda = $this->reporte_abast_pagar->get_historial_deuda_abastecimiento($codigo, $detalle);
        $historial_deuda = $historial_deuda[0]->fn_historial_deuda_abastecimiento;
        $historial_deuda=json_decode($historial_deuda);
        $cliente = $historial_deuda->proveedor;
        $fecha = $historial_deuda->fecha;
        $total = $historial_deuda->total;
        $pagado = $historial_deuda->pagado;
        $saldo = $historial_deuda->saldo;
        $productos = $historial_deuda->productos;
        $historial = $historial_deuda->historial;

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;
        
        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;

        // configuracion de tamaños de letras y margenes
        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
             // tamaño carta
            $marginTitle = 77;
            
            $pdfMarginLeft = 15;
            $pdfMarginRight = 15;
            $pdfFontSizeData= 12;
            $pdfSize = PDF_PAGE_FORMAT;
            $pdfFontSizeMain= PDF_FONT_SIZE_MAIN;
            $imageSizeN= 15;
            $imageSizeM= 20;
            $imageSizeX = 45;
            $imageSizeY = 15;
            $numeroWidth = 30;
            $productoWidth = 400;
            $cantidadWidth = 100;
            $precioWidth = 128;
            $totalWidth = 500;
            $fechaWidth = 210;
            $saldoWidth = 209;

        } else {
            $pdfSize = array(80,1000);
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
            $productoWidth = 130;
            $cantidadWidth = 50;
            $precioWidth = 40;
            $totalWidth = 180;
            $fechaWidth = 75;
            $saldoWidth = 75;
        }
        // fin configuracion

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Abasteciminto a pagar');
        $pdf->SetSubject('Reporte de Abasteciminto a pagar');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0,75,146), array(0,75,146));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSize));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, 'B', $pdfFontSizeData));
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

        $image_file = 'assets/img/icoLogo/'.$logo;

        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

        $usuario = $this->session->userdata('usuario');
        $fec_impresion = date('Y-m-d H:i:s');
        
        $titulo='        EMPRESA '.$titulo;
        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeData);
       
        $tbl = '
        <div style="text-align:rigth; font-size: 12px">
        <font><b>Usuario:</b> '.$usuario.' </font><br>
        <font><b>Fecha:</b> '.$fec_impresion.' </font>
        </div>

        <div style="text-align:center;">
            <font size="'.$pdfFontSizeMain.'px"><b> HISTORIAL </b></font><br>
        </div> 
        <div>
            <font size="'.$pdfFontSizeData.'px"><b> Cliente: </b>'.$cliente.'</font><br>
            <font size="'.$pdfFontSizeData.'px"><b> Fecha: </b>'.$fecha.'</font><br>
            <font size="'.$pdfFontSizeData.'px"><b> Monto total Adeudado: </b>'.$total.'</font><br>
            <font size="'.$pdfFontSizeData.'px"><b> Pagado hasta la fecha: </b>'.$pagado.'</font><br>
            <font size="'.$pdfFontSizeData.'px"><b> Saldo: </b>'.$saldo.'</font><br>
        </div> 

        ';

        $tbl1 = '
        <div style="text-align:center;">
        <font size="'.$pdfFontSizeMain.'px"><b> DETALLE </b></font><br>
        </div> 
          <table cellpadding="3" border="1" style="margin-left: auto; margin-right: auto;">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$productoWidth.'px"> Producto </th>
                <th width="'.$cantidadWidth.'px"> Cantidad </th>
                <th width="'.$precioWidth.'px"> Precio </th>
            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($productos as $ven):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td>'.$ven->producto.'</td>
                  <td>'.$ven->cantidad.'</td>
                  <td align="center">'.$ven->precio.'</td>
                </tr>';
            endforeach;
              $tbl3 = '
              <tr style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"></th>
                <th width="'.$totalWidth.'px">Total: </th>
                <th align="center" width="'.$precioWidth.'px">'.$total.'</th>
              </tr> 
          </table> ';
          $tbl4 = '
          <div style="text-align:center;">
          <br><font size="'.$pdfFontSizeMain.'px"><b> HISTORIAL </b></font><br>
          </div> 
          <table align="center" cellpadding="3" border="1" margin-right= 122px;>
            <tr  style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$fechaWidth.'px"> Fecha </th>
                <th width="'.$saldoWidth.'px"> Monto </th>
                <th width="'.$saldoWidth.'px"> Saldo </th>
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
        $pdf_ruta = $pdf->Output('Reporte_historial_Abast.pdf', 'I');

    }


}
