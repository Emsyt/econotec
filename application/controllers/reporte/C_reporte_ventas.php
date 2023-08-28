<?php
/* 
------------------------------------------------------------------------------------------
Modificacion: Brayan Janco Cahuana Fecha:11/11/2021, Codigo: GAN-MS-A3-079,
Descripcion: se agregaron las funciones lst_reporte_ventas, generar_pdf_ventas y generar_excel_ventas
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Ariel Ramos Paucara Fecha:20/04/2023, Codigo: GAN-MS-A0-0426,
Descripcion: Se añadio el campo codigo para mostrar en pdf y excel
 */
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_reporte_ventas extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('reporte/M_reporte_ventas','rep_venta');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');

            $data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['id_ubicacion'] = $this->session->userdata('ubicacion');
            $data['ubicaciones'] = $this->rep_venta->get_ubicacion_cmb();
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
            $data['contenido'] = 'reporte/ventas';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    //------- FUNCIONES AUXILIARES -------//
    public function func_auxiliares(){
        try{
            $accion = $_REQUEST['accion'];
            if(empty($accion))
                throw new Exception("Error accion no valida");
            switch($accion)
            {
                case 'tbl_ventas':
                    $id_ubi = $data['id_ubi'] = $this->input->post('selc_ubi');
                    $fec = $data['fec'] = $this->input->post('selc_frep');
                    $data['usuario'] = $this->session->userdata('usuario');
                    $data['fecha_imp'] = date('Y-m-d H:i:s');
                    $data['lst_ventas'] = $lst_ventas = $this->rep_venta->get_lst_ventas($id_ubi, $fec);
                    $this->load->view('reporte/tbl_ventas', $data);
                  break;

                default;
                    echo 'Error: Accion no encontrada';
            }
        }
        catch(Exception $e)
        {
            $log['error'] = $e;
        }
    }

    public function lst_reporte_ventas(){

        $array_ventas = array(
            'id_ubicacion' => $this->input->post('selc_ubi'),
            'fecha_inicial' => $this->input->post('fecha_ini'),
            'fecha_fin' => $this->input->post('fecha_fin'),
            'tipo_venta' => $this->input->post('tipo'),
        );
        $json_ventas=json_encode($array_ventas);
        $lst_ventas = $this->rep_venta->get_lst_ventas($json_ventas);
        $data= array('responce'=>'success','posts'=>$lst_ventas);
        echo json_encode($data);
    }

    public function totales_reporte_ventas(){

        $array_ventas = array(
            'id_ubicacion' => $this->input->post('selc_ubi'),
            'fecha_inicial' => $this->input->post('fecha_ini'),
            'fecha_fin' => $this->input->post('fecha_fin'),
            'tipo_venta' => $this->input->post('tipo'),
        );
        $json_ventas=json_encode($array_ventas);
        $totales_ventas = $this->rep_venta->get_totales_ventas($json_ventas);
        $data= array('responce'=>'success','posts'=>$totales_ventas);
        echo json_encode($totales_ventas);
    }

    public function generar_pdf_ventas() {
        $array_ventas = array(
            'id_ubicacion' => $this->input->post('ubi_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
            'tipo_venta' => $this->input->post('tipo'),
        );
        $json_ventas=json_encode($array_ventas);
        $lst_ventas = $this->rep_venta->get_lst_ventas($json_ventas);

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
            $marginTitle = 77;
            $fechaWidth = 55;
            $PrecUniWidth= 55;
            $CantidadWidth= 40;
            $ProductoWidth= 110;
            $CodigoWidth= 45;
            $VendedorWidth= 68;
            $ClienteWidth= 68;
            $cantidadWidth= 30;
            $pdfMarginLeft = 15;
            $pdfMarginRight = 15;
            $pdfFontSizeData= PDF_FONT_SIZE_DATA;
            $pdfSize = PDF_PAGE_FORMAT;
            $pdfFontSizeMain= PDF_FONT_SIZE_MAIN;
            $imageSizeN= 15;
            $imageSizeM= 20;
            $imageSizeX = 45;
            $imageSizeY = 15;
            $footer=true;
            
        } else {
            // tamaño carta
            $dim=80;
            $dim=$dim+(count($lst_ventas)*13.5);
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
            $cantidadWidth= 15;
            $VendedorWidth= 25;
            $ClienteWidth= 25;
            $ProductoWidth= 40;
            $CodigoWidth= 15;
            $CantidadWidth= 20;
            $PrecUniWidth= 25;
            $fechaWidth = 28;
            $footer=false;
        }
        
        // fin configuracion

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Venta');
        $pdf->SetSubject('Reporte de Venta');

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
          <div style="text-align:right;">
              <font><b>Usuario:</b> '.$usuario.' </font><br>
              <font><b>Fecha:</b> '.$fec_impresion.' </font>
          </div>

          <div style="text-align:center;">
              <font><b> REPORTE DE VENTAS POR DÍA </b></font><br>
          </div> ';
        

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$cantidadWidth.'px" align="right"> N&ordm; </th>
                <th width="'.$VendedorWidth.'px"> Vendedor </th>
                <th width="'.$ClienteWidth.'px"> Cliente </th>
                    <th width="'.$ProductoWidth.'px"> Producto </th>
                <th width="'.$CodigoWidth.'px"> Código </th>    
                <th width="'.$CantidadWidth.'px"> Cantidad </th>
                    <th width="'.$PrecUniWidth.'px"> Precio Unitario </th>
                    <th width="'.$PrecUniWidth.'px"> Costo Total</th>
                <th width="'.$PrecUniWidth.'px"> Ut. Bruta </th>
                <th width="'.$fechaWidth.'px"> Fecha </th>
                <th width="'.$fechaWidth.'px"> Tipo de venta </th>
            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($lst_ventas as $ven):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="right">'.$nro.'</td>
                  <td align="right">'.$ven->ovendedor.'</td>
                  <td align="left">'.$ven->ocliente.'</td>
                  <td>'.$ven->oproducto.'</td>
                  <td>'.$ven->ocodigo.'</td>
                  <td align="rigth">'.$ven->ocantidad.'</td>
                  <td align="rigth">'.$ven->oprecio.'</td>
                  <td align="rigth">'.$ven->ototal.'</td>
                  <td align="rigth">'.$ven->outilidad.'</td>
                  <td align="center">'.$ven->ofecha.'</td>
                  <td align="center">'.$ven->otipoventa.'</td>
                </tr>';
            endforeach;
              $tbl3 = '
          </table> ';

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_venta.pdf', 'I');
    }

    public function generar_excel_ventas(){

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
                    ->setCellValue('B7', 'Vendedor')
                    ->setCellValue('C7', 'Cliente')
                    ->setCellValue('D7', 'Producto')
                    ->setCellValue('E7', 'Código')
                    ->setCellValue('F7', 'Cantidad')
                    ->setCellValue('G7', 'Precio Unitario')
                    ->setCellValue('H7', 'Costo Total')
                    ->setCellValue('I7', 'Ut. Bruta')
                    ->setCellValue('J7', 'Fecha')
                    ->setCellValue('K7', 'Tipo de venta');

        $objPHPExcel->getActiveSheet()->setCellValue('D2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D2:H2');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);            

        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'REPORTE DE VENTA POR DIA');
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
                    

        $objPHPExcel->getActiveSheet()->getStyle("A7:K7")->getFont()->setBold(true);                    

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('18');

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('30');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('30');

        $objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array('rgb' => 'A1A5A8')
        ));

        $array_ventas = array(
            'id_ubicacion' => $this->input->post('ubi_trabajo'),
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
            'tipo_venta' => $this->input->post('tipo'),
        );
        $json_ventas=json_encode($array_ventas);
        $lst_ventas = $this->rep_venta->get_lst_ventas($json_ventas);
        $excel_row=8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
                )
            ),
        );
        foreach($lst_ventas as $row)
        {   
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, $excel_row-7)
                                          ->setCellValue('B' . $excel_row, "$row->ovendedor")
                                          ->setCellValue('C' . $excel_row, "$row->ocliente")
                                          ->setCellValue('D' . $excel_row, "$row->oproducto")
                                          ->setCellValueExplicit('E' . $excel_row, $row->ocodigo, PHPExcel_Cell_DataType::TYPE_STRING)
                                          ->setCellValue('F' . $excel_row, "$row->ocantidad")
                                          ->setCellValue('G' . $excel_row, "$row->oprecio")
                                          ->setCellValue('H' . $excel_row, "$row->ototal")
                                          ->setCellValue('I' . $excel_row, "$row->outilidad")
                                          ->setCellValue('J' . $excel_row, "$row->ofecha")
                                          ->setCellValue('K' . $excel_row, "$row->otipoventa");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row.':K'.($excel_row))->applyFromArray($borders);                                
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);          
            $objPHPExcel->getActiveSheet()->getStyle('F'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                                      
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
        header('Content-Disposition: attachment;filename="Reporte Ventas por dia.xlsx"');
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
