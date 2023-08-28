
<?php
/* A
------------------------------------------------------------------------------------------
Creador: Pedro Rodrigo Beltran Poma Fecha:24/10/2022, GAN-MS-A6-071,
Creacion del Controlador C_reporte_cotizacion para conectar con cotizaciones y M_reporte_cotizacion con sus respectivas funciones
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma Fecha: 28/10/2022 GAN-MS-A6-0079
Descripcion: Se agrego el campo observaciones en el pdf_nota_cotizacion
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma Fecha: 28/10/2022 GAN-MS-A6-0080
Descripcion: Se modifico el pdf de la cotizacion a la fecha de validez.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha: 24/11/2022 GAN-MS-A7-0134
Descripcion: Se agrego la funcion verificar_productos.
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_reporte_cotizacion extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('reporte/M_reporte_cotizacion','reporte_cotizacion');
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
            $data['contenido'] = 'reporte/cotizaciones';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function lst_listado_cotizacion() {
        $datax= $this->input->post('selc_frep');
        $datay= $this->input->post('selc_finrep');

        $array_reporte_ABMcotizacion = array(
            'fecha_inicial' => $datax,
            'fecha_fin' =>  $datay
        );
        $json_reporte_ABMcotizacion=json_encode($array_reporte_ABMcotizacion);
        $postData   = $this->input->post();
        $data = $this->reporte_cotizacion->get_lst_reporte_ABMcotizacion2($postData,$json_reporte_ABMcotizacion);

        echo json_encode($data);
    }

    public function ingresos_reporte_ventas(){

        $array_ventas = array(
            'fecha_inicial' => $this->input->post('selc_frep'),
            'fecha_fin' => $this->input->post('selc_finrep'),
        );
        $json_ventas=json_encode($array_ventas);
        $ingresos_ventas = $this->listado_ventas->get_ingresos_ventas($json_ventas);
        $data= array('responce'=>'success','posts'=>$ingresos_ventas);
        echo json_encode($ingresos_ventas);
    }

    public function historial_cotizacion() {
        $idubicacion = $this->input->post('dato1');
        $idlote = $this->input->post('dato2');
        $usucre = $this->input->post('dato3');

        $historial_cotizaciones = $this->reporte_cotizacion->get_historial_cotizacion($idubicacion, $idlote, $usucre);
        $historial_cotizacion= $historial_cotizaciones[0]->fn_historial_cotizacion;
        echo $historial_cotizacion;
    }

    public function get_eliminar_cotizacion() {
        $idubicacion = $this->input->post('dato1');
        $idlote = $this->input->post('dato2');
        $usucre = $this->input->post('dato3');

        $eliminar_cotizacion = $this->reporte_cotizacion->get_eliminar_cotizacion($idubicacion, $idlote, $usucre);
        echo json_encode($eliminar_cotizacion);;
    }

    public function get_cargar_cotizacion() {
        $idubicacion = $this->input->post('dato1');
        $idlote = $this->input->post('dato2');
        $usucre = $this->input->post('dato3');

        $cargar_cotizacion = $this->reporte_cotizacion->get_cargar_cotizacion($idubicacion, $idlote, $usucre);
        echo json_encode($cargar_cotizacion);;
    }
    public function verificar_productos() {
        $idubicacion    = $this->input->post('idubicacion');
        $idlote         = $this->input->post('idlote');
        $usucre         = $this->input->post('usucre');
        $data = $this->reporte_cotizacion->verificar_productos($idubicacion, $idlote, $usucre);
        echo json_encode($data);;
    }

    public function generar_pdf_cotizacion(){
        $usr=$this->session->userdata('id_usuario');
        $id_vent=$this->input->post('id_venta');
        
        $nota_venta = $this->reporte_cotizacion->get_lst_nota_venta_cotizacion($usr,$id_vent);
        $lst_nota_venta = $nota_venta[0]->fn_nota_cotizacion;
        $lstas_nota_venta = json_decode($lst_nota_venta);

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        // configuracion de tamaños de letras y margenes
        $id_usuario = $this->session->userdata('id_usuario');
        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
            // tamaño carta
            $marginTitle = 100;
            $marginSubTitle = 100;
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
            $cantidadWidth = 79;
            $descripcionWidth = 313;
            $precioWidth = 118;
            $importeWidth = 118;
            $espacioWidth = 480;
            $footer=true;
        } else {
            $dim=80;
            $dim=$dim+(count($lstas_nota_venta->pedidos)*10);
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
            $cantidadWidth = 50;
            $descripcionWidth = 100;
            $precioWidth = 40;
            $importeWidth = 40;
            $espacioWidth = 440;
            $footer=false;
        }
        
        // fin configuracion
                         
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('NOTA DE COTIZACION');
        $pdf->SetSubject('NOTA DE COTIZACION');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0,75,146), array(0,75,146));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSizeMain));
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
       
	$fecha = $lstas_nota_venta->fecha;
        $observaciones = $lstas_nota_venta->observacion;
        $nombre_rsocial = $lstas_nota_venta->nombre_rsocial;
        $ci_nit = $lstas_nota_venta->ci_nit;
        $lst_pedidos = $lstas_nota_venta->pedidos;
        $total = $lstas_nota_venta->total;
        $nombre = $lstas_nota_venta->nombre;
        $direccion = $lstas_nota_venta->direccion;
        $pagina = $lstas_nota_venta->pagina;
        $telefono = $lstas_nota_venta->telefono;

        $image_file = 'assets/img/icoLogo/'.$logo;

        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

        $titulo='        NOTA DE COTIZACION';
		$txt='        '.$nombre.'
        '.$direccion.'
        Telf.'.$telefono.'           '.$pagina;
        
        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeData);
        $pdf->MultiCell($marginSubTitle, 5, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(77, 5, $txt, 0, 'C', 0, 1, '', '', true);
// GAN-MS-A6-0080, PBeltran 28/10/2022
        $tbl = '

        <div>
            <br>
            <font><b> FECHA VALIDA HASTA:&nbsp;</b>'.$fecha.'</font><br>
            <font><b> RAZON SOCIAL/NOMBRE:&nbsp;</b>'.$nombre_rsocial.'</font><br>
            <font><b> CI/NIT/Cod. Cliente:&nbsp;</b>'.$ci_nit.'</font><br>
        </div> ';
// FIN GAN-MS-A6-0080, PBeltran 28/10/2022
        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$cantidadWidth.'px"> cantidad </th>
                    <th width="'.$descripcionWidth.'px"> Descripcion</th>
                <th width="'.$precioWidth.'px"> Precio (Bs.) </th>
                    <th width="'.$importeWidth.'px"> Importe (Bs.) </th>

            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($lst_pedidos as $ped):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td align="center">'.$ped->cantidad.'</td>
                  <td >'.$ped->descripcion.'</td>
                  <td align="center">'.$ped->precio.'</td>
                  <td align="center">'.$ped->importe.'</td>
                </tr>';
            endforeach;
	// GAN-MS-A6-79, PBeltran 28/10/2022
            $tbl3 = '<br>
            <table>
            <tr>
                <td width="'.$espacioWidth.'">
                </td>
                <td width="92">
                    <font><b> TOTAL:</b></font><br>
                </td>
                <td width="118">
                    <font>'.$total.'</font><br>
                </td>
                
            </tr>
          </table>                
        </table>
      <div>
        <br>
        <font><b> OBSERVACIONES:&nbsp;</b>'.$observaciones.'</font><br>
    </div>
          ';
	//FIN GAN-MS-A6-79, PBeltran 28/10/2022
	    
        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Nota_Venta.pdf', 'I');
    }

    public function generar_excel_listado_cotizacion(){

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
                    ->setCellValue('B7', 'Cliente')
                    ->setCellValue('C7', 'Total')
                    ->setCellValue('E7', 'Fecha Cotizacion')
                    ->setCellValue('F7', 'Fecha Validez')
                    ->setCellValue('G7', 'Observaciones');
                    

        $objPHPExcel->getActiveSheet()->mergeCells('C7:D7');                    

        $objPHPExcel->getActiveSheet()->setCellValue('D2', $empresa);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(14)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFill()->getStartColor()->setRGB('F28A8C');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D2:F2');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);            

        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'LISTADO DE COTIZACIONES');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(15)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D3:F3');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Usuario: '.$usuario);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('D4:F4');
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Fecha: '.$fec_impresion);
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setSize(12)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->mergeCells('D5:F5');
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    

        $objPHPExcel->getActiveSheet()->getStyle("A7:G7")->getFont()->setBold(true);                    

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('20');



        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight('30');
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('30');

        $objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array('rgb' => 'A1A5A8')
        ));


        $array_reporte_ABMcotizacion = array(
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_reporte_ABMcotizacion=json_encode($array_reporte_ABMcotizacion);
        $lst_cotizacion = $this->reporte_cotizacion->get_lst_reporte_ABMcotizacion2(null,$json_reporte_ABMcotizacion);

        $excel_row=8;
        $borders = array(
            'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
                )
            ),
        );
        foreach($lst_cotizacion as $row)
        {   
		foreach ($row	as $cot ) {
			$cliente = $cot['pcliente'];
			$total = $cot['ptotal'];
			$feccre = $cot['pfeccre'];
			$fecval = $cot['pfecvali'];
			$observaciones = $cot['pobservaciones'];
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $excel_row, $excel_row-7)
                                          ->setCellValue('B' . $excel_row, "$cliente")
                                          ->setCellValue('C' . $excel_row, $total)
                                          ->setCellValue('E' . $excel_row, "$feccre")
                                          ->setCellValue('F' . $excel_row, "$fecval")
                                          ->setCellValue('G' . $excel_row, "$observaciones");
            $objPHPExcel->getActiveSheet()->mergeCells('C'.$excel_row.':D'.($excel_row));        
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row.':G'.($excel_row))->applyFromArray($borders);                                
            $objPHPExcel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);          
            $objPHPExcel->getActiveSheet()->getStyle('G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
               
            $excel_row++;                                           
		}
        }

        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        $objPHPExcel->setActiveSheetIndex(0);

	/*
         *$objDrawing = new PHPExcel_Worksheet_Drawing();
         *$objDrawing->setName('test_img');
         *$objDrawing->setDescription('test_img');
         *$objDrawing->setPath($direccion_img);
         *$objDrawing->setCoordinates('B2');                      
         *$objDrawing->setOffsetX(60); 
         *$objDrawing->setOffsetY(5);                
         *$objDrawing->setWidth(100); 
         *$objDrawing->setHeight(132); 
         *$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	 */

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Listado de cotizaciones.xlsx"');
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

    
    public function generar_pdf_listado_cotizacion(){

        $array_reporte_ABMcotizacion = array(
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_reporte_ABMcotizacion=json_encode($array_reporte_ABMcotizacion);
        $lst_cotizacion = $this->reporte_cotizacion->get_lst_reporte_ABMcotizacion2(null,$json_reporte_ABMcotizacion);

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
            $clienteWidth = 200;
            $totalWidth = 100;
            $fechaWidth = 100;
            $horaWidth = 100;
            $footer=true;
        } else {
            $dim=80;
            $dim=$dim+(count($lst_cotizacion)*8.5);
            $pdfSize = array(95,$dim);
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
            $clienteWidth = 60;
            $totalWidth = 40;
            $fechaWidth = 60;
            $horaWidth = 60;
            $footer=false;
        }
         // fin configuracion
        
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Listado de cotizaciones');
        $pdf->SetSubject('Listado de cotizaciones');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0,75,146), array(0,75,146));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSizeMain));
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
            <font><b> LISTADO DE COTIZACIONES </b></font><br>
        </div> ';

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$clienteWidth.'px">Cliente </th>
                <th width="'.$totalWidth.'px"> Total </th>
                <th width="'.$fechaWidth.'px"> Fecha Cotizacion </th>
                <th width="'.$fechaWidth.'px"> Fecha Validez </th>
                <th width="'.$horaWidth.'px"> Observaciones </th>

            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($lst_cotizacion as $ven):
		    foreach ($ven as $cot ) {
              		$nro++;
              		$tbl2 = $tbl2.'
                		<tr>
                  		<td align="center">'.$nro.'</td>
                  		<td align="center">'.$cot['pcliente'].'</td>
                  		<td>'.$cot['ptotal'].'</td>
                  		<td align="center">'.$cot['pfeccre'].'</td>
                  		<td align="center">'.$cot['pfecvali'].'</td>
                  		<td align="center">'.$cot['pobservaciones'].'</td>
                		</tr>';
		    }
            endforeach;
              $tbl3 = '
          </table> ';

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Listado de cotizaciones.pdf', 'I');
    }

    public function generar_pdf_historial_ventas(){

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
        $historial_venta= $historial_ventas[0]->fn_historial_venta;
        $historial_venta=json_decode($historial_venta);
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
            <font size="12px"><b> Codigo de Venta: </b>'.$codigo.'</font><br>
            <font size="12px"><b> Fecha: </b>'.$fecha.'</font>
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

            $nro=0;
            $tbl2 = '';
            foreach ($productos as $ven):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td>'.$ven->producto.'</td>
                  <td align="center">'.$ven->cantidad.'</td>
                  <td align="center">'.$ven->precio.'</td>
                  <td align="center">'.$ven->sub_total.'</td>
                </tr>';
            endforeach;
              $tbl3 = '
              <tr style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="30px"></th>
                <th width="518px">Total: </th>
                <th align="center" width="110px">'.$total.'</th>
              </tr> 
          </table> ';
              $tbl6 = '
          </table> '; 

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3.$tbl6, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_historial.pdf', 'I');

    }


}
