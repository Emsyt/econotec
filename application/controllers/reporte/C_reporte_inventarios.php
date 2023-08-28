<?php
/* 
------------------------------------------------------------------------------------------
Modificacion: Brayan Janco Cahuana Fecha:29/11/2021, Codigo: GAN-MS-A7-107,
Descripcion: se agregaron las funciones lst_reporte_inventarios, generar_pdf_inventarios y generar_excel_inventarios
------------------------------------------------------------------------------------------
Modificacion: Alvaro Ruben Gonzales Vilte Fecha:09/11/2022, Codigo: GAN-MS-A0-0096,
Descripcion: Se modifico el llamado de la funcion get_lst_inventario_beta para mostrar el pdf con los datos del pdf de reporte inventario
------------------------------------------------------------------------------------------
Modificado: Melani Alisson Cusi Burgoa Fecha:05/12/2022, Codigo: GAN-MS-A3-0157,
Descripcion: Se agrego un contador de productos con ayuda de la funcion fn_reporte_contador
------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha:09/12/2022, Codigo: GAN-MS-A1-0174,
Descripcion: Se modifico las funciones de generado de pdf y excel para la agregacion de nuevos datos
 */
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_reporte_inventarios extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('reporte/M_reporte_inventarios','rep_inventario');
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
            $data['ubicaciones'] = $this->rep_inventario->get_ubicacion_cmb();

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'reporte/inventarios';
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
                case 'tbl_inventarios':
                    $id_ubi = $data['id_ubi'] = $this->input->post('selc_ubi');
                    $data['usuario'] = $this->session->userdata('usuario');
                    $data['fecha_imp'] = date('Y-m-d H:i:s');
                    //
                    //$data['lst_inventarios'] = $lst_inventarios = $this->rep_inventario->get_lst_inventarios($id_ubi);
                    // prueba GAN-MS-A1-473
                    
                    $postData = $this->input->post();
                    $data['lst_inventarios'] = $lst_inventarios = $this->rep_inventario->get_lst_inventarios_beta($postData,$id_ubi);
                   
                    //fin GAN-MS-A1-473
                    $this->load->view('reporte/tbl_inventarios', $data);
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

    public function lst_reporte_inventarios($id_ubi) {
     /*    $id_ubi = $this->input->post('selc_ubi');
        $lst_inventarios = $this->rep_inventario->get_lst_inventarios($id_ubi);
        $data= array('responce'=>'success','posts'=>$lst_inventarios);
        echo json_encode($data); */

        // prueba GAN-MS-A1-473
        
        try{
            $postData   = $this->input->post();
            //$id_ubi = $this->input->post('selc_ubi');
            $data       = $this->rep_inventario->get_lst_inventarios($postData,$id_ubi);
            echo json_encode($data);
        }
        catch(Exception $uu){
            $log['error'] = $uu;
        } 
       
        //fin GAN-MS-A1-473
    }
    public function cantidad_productos() {
        $id_ubicacion = $this->input->post('selc_ubi');
        $totales_prod = $this->rep_inventario->get_cant_prod($id_ubicacion);
        echo json_encode($totales_prod);
    }

    public function costo_total() {
        $id_ubicacion = $this->input->post('selc_ubi');
        $totales_prod = $this->rep_inventario->get_costo_total($id_ubicacion);
        echo json_encode($totales_prod);
    }

    public function generar_pdf_inventarios() {

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajustes = $this->general->get_ajustes("titulo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $titulo = $ajuste->titulo;
        $id_ubi = $this->input->post('ubi_trabajo');
        $lst_inventarios = $this->rep_inventario->get_lst_inventarios_beta($id_ubi);
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

            $cantidadWidth = 40;
            $ubicacionWidth = 60;
            $categoriaWidth = 60;
            $marcaWidth = 60;
            $precioWidth = 50;
            $codigoWidth = 108;
            $productoWidth = 128;
            $numeroWidth = 40;


            // $cantidadWidth = 60;
            // $ubicacionWidth = 115;
            // $precioWidth = 70;
            // $codigoWidth = 108;
            // $productoWidth = 265;
            // $numeroWidth = 40;
            $footer=true;
        } else {
            $dim=80;
            $dim=$dim+(count($lst_inventarios)*10.25);
            $pdfSize = array(80,$dim);
            $pdfFontSizeMain= 9;
            $pdfFontSizeData= 8;
            $pdfMarginLeft = 2;
            $pdfMarginRight = 5;
            $imageSizeM= 5;
            $imageSizeN = 5;
            $imageSizeX = 25;
            $imageSizeY = 15;
            $marginTitle = 30;
            $numeroWidth = 20;
            $codigoWidth = 50;
            $productoWidth = 73;
            $precioWidth = 25;
            $ubicacionWidth = 55;
            $cantidadWidth = 30;
            $categoriaWidth = 30;
            $marcaWidth = 30;
            $footer=false;
        }
        // fin configuracion

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Reporte de Inventarios');
        $pdf->SetSubject('Reporte de Inventarios');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0,75,146), array(0,75,146));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, 'B', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, 'B',$pdfFontSizeData));
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
              <font><b> REPORTE DE INVENTARIOS </b></font><br>
          </div> ';
        
        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$categoriaWidth.'px"> Categoria </th>
                <th width="'.$marcaWidth.'px"> Marca </th>
                <th width="'.$codigoWidth.'px"> Codigo </th>
                <th width="'.$productoWidth.'px"> Producto </th>
                <th width="'.$precioWidth.'px"> Costo Unit. (Bs.) </th>
                <th width="'.$precioWidth.'px"> Costo Total (Bs.) </th>
                <th width="'.$precioWidth.'px"> Precio Unit. (Bs.) </th>
                <th width="'.$ubicacionWidth.'px"> Ubicación </th>
                <th width="'.$cantidadWidth.'px"> Cant. </th>
            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($lst_inventarios as $inv):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td>'.$inv->categoria.'</td>
                  <td>'.$inv->marca.'</td>
                  <td>'.$inv->codigo.'</td>
                  <td>'.$inv->producto.'</td>
                  <td align="rigth">'.$inv->costo_unitario.'</td>
                  <td align="rigth">'.$inv->costo_total.'</td>
                  <td align="rigth">'.$inv->precio_unitario.'</td>
                  <td align="rigth">'.$inv->ubicacion.'</td>
                  <td align="rigth">'.$inv->cantidad.'</td>
                </tr>';
            endforeach;
              $tbl3 = '
          </table> ';

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_inventarios.pdf', 'I');
    }

    public function generar_excel_inventarios(){

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
                    ->setCellValue('B7', 'CATEGORIA')
                    ->setCellValue('C7', 'MARCA')
                    ->setCellValue('D7', 'CODIGO')
                    ->setCellValue('E7', 'PRODUCTO')
                    ->setCellValue('G7', 'COSTO UNITARIO(BS.)')
                    ->setCellValue('H7', 'COSTO TOTAL(BS.)')
                    ->setCellValue('I7', 'PRECIO UNITARIO (BS.)')
                    ->setCellValue('J7', 'UBICACIÓN')
                    ->setCellValue('K7', 'CANTIDAD');

        $objPHPExcel->getActiveSheet()->mergeCells('E7:F7');                    

        $objPHPExcel->getActiveSheet()->setCellValue('D2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D2:K2');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);            

        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'REPORTE DE INVENTARIOS');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D3:K3');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Usuario: '.$usuario);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D4:K4');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Fecha: '.$fec_impresion);
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->mergeCells('D5:K5');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    

        $objPHPExcel->getActiveSheet()->getStyle("A7:K7")->getFont()->setBold(true);                    

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('15');


        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('30');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('30');

        $objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:K7')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array('rgb' => 'A1A5A8')
        ));

        $id_ubi = $this->input->post('ubi_trabajo');
        $lst_inventarios = $this->rep_inventario->get_lst_inventarios_beta($id_ubi);


        $excel_row=8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
                )
            ),
        );
        foreach($lst_inventarios as $row)
        {   
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, $excel_row-7)
                                          ->setCellValue('B' . $excel_row, "$row->categoria")
                                          ->setCellValue('C' . $excel_row, "$row->marca")
                                          ->setCellValue('D' . $excel_row, "$row->codigo"." ")
                                          ->setCellValue('E' . $excel_row, "$row->producto")
                                          ->setCellValue('G' . $excel_row, "$row->costo_unitario")
                                          ->setCellValue('H' . $excel_row, "$row->costo_total")
                                          ->setCellValue('I' . $excel_row, "$row->precio_unitario")
                                          ->setCellValue('J' . $excel_row, "$row->ubicacion")
                                          ->setCellValue('K' . $excel_row, "$row->cantidad");
            $objPHPExcel->getActiveSheet()->mergeCells('E'.$excel_row.':F'.($excel_row));        
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row.':K'.($excel_row))->applyFromArray($borders);                                
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);          
            $objPHPExcel->getActiveSheet()->getStyle('F'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                                                    
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
        header('Content-Disposition: attachment;filename="Reporte Inventarios.xlsx"');
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
