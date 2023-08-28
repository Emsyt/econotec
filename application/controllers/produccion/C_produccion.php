<?php
/*
    -------------------------------------------------------------------------------------------------------------------------------
    Creacion: Melvin Salvador Cussi Callisaya Fecha 23/05/2022, Codigo: GAN-MS-A5-235
    Descripcion: se realizo el modulo de produccion segun actividad GAN-MS-A5-235
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Alison Paola Pari Pareja   Fecha:02/08/2022   Actividad:GAN-MS-A1-337
    Descripcion: Se anadio la funcion confirmar_ingreso_fila para confirmar el resgistro seleccionado
*/
?>
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_produccion extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');

        $this->load->library('upload');
        $this->load->model('produccion/M_produccion', 'produccion');
        $this->load->library('Pdf_venta');
    }

    public function index(){
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['ubicacion'] = $this->produccion->get_ubicacion();
            $data['producto'] = $this->produccion->get_producto();
            $data['unidad'] = $this->produccion->get_unidad();
            $data['lst_ingreso'] = $this->produccion->get_reporte_ingreso();

            $data['lib'] = 0;
            $data['datos_menu'] = $log;

            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'produccion/produccion';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }
    public function datos_ingreso($id){
        $data = $this->produccion->get_ingreso($id);
        $data = json_encode($data);
        echo $data;
    }

    public function dlt_ingreso($login, $id){
        echo ($this->produccion->eliminar_ingreso($login, $id));
        redirect('produccion');
    }
    public function get_lote_ingreso(){
        $id = $this->input->post('id_lote');
        $data=$this->produccion->get_lote_ingreso($id);
        echo json_encode($data);
    }
    public function confirmar_ingreso(){
        $data=$this->produccion->confirmar_ingreso();
        echo json_encode($data);
    }
    public function confirmar_ingreso_fila($id_lote){
        $id_usuario = $this->session->userdata('id_usuario'); //modificado 16/03/2023
        $data=$this->produccion->confirmar_ingreso_fila($id_usuario,$id_lote);//modificado 16/03/2023
        echo json_encode($data);
    }
    public function calcular_stock_ubi(){
        $id_producto = $this->input->post('id_producto');
        $id_ubicacion = $this->input->post('id_ubicacion');
        $data = $this->produccion->fn_calcular_stock_ubi($id_producto,$id_ubicacion);
        $data = $data[0]->fn_calcular_stock_ubi;
        echo json_encode($data);
    }
    public function get_ubiproducto(){
        $id_ubicacion = $this->input->post('ubicacion');
        $data = $this->produccion->get_lst_productos_ubi($id_ubicacion);
        echo json_encode($data);
    }
    public function add_produccion(){
        $id = $this->input->post('id_lote');
        $login = $this->session->userdata('usuario');
        $productArray = array();
        for ($i = 0; $i <= $this->input->post('count0'); $i++) {
            if ($this->input->post('id_procedencia' . $i) != null) {
                $productArray[$i] = array(
                    'id_procedencia' => $this->input->post('id_procedencia' . $i),
                    'id_producto' => $this->input->post('id_producto' . $i),
                    'cantidad' => $this->input->post('cantidad' . $i),
                    'id_unidad' => $this->input->post('id_unidad' . $i),
                );
            }
        }
        $data = array(
            'id_destino' => $this->input->post('destino'),
            'fecha' => $this->input->post('fecmes'),
            'hora' => $this->input->post('hora'),
            'productos' => $productArray,
        );

        $json = json_encode($data);
       // echo json_encode($data);
         $data_insert = $this->produccion->set_ingreso($id, $login, $json);
        // print_r($data_insert[0]->omensaje);
        if ($data_insert) {
            $this->session->set_flashdata('success', 'Registro insertado exitosamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al insertar Registro.');
        }
        redirect('produccion');
        // if($data_insert[0]->oboolean == 't')
        // {
        //     $this->session->set_flashdata('success','Registro insertado exitosamente.'); 
        //     redirect('produccion'); 
        // }
        // else
        // {
        //     $this->session->set_flashdata('error',$data_insert[0]->omensaje);  
        // }
        
    }
    public function pdf_lote_produccion(){
        $id = $this->input->post('lote_detalle');
        $data=$this->produccion->get_lote_ingreso($id);
        echo json_encode($data);

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;
        
        $id_usuario = $this->session->userdata('id_usuario');

        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
            // tamaño carta
            $marginTitle = 100;
            $marginSubTitle = 100;
            $subtitle = 65;
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
            $ubicacionWidth = 35;
            $unidadWidth = 30;
            $fechaWidth = 30;
            $horaWidth = 30;
            $precioWidth = 118;
            $footer=true;
        } else {
            $dim=80;
            $dim = $dim+(count ($data)*10);
            $pdfSize = array(80,$dim);
            $pdfFontSizeMain= 9;
            $pdfFontSizeData= 9;
            $pdfMarginLeft = 5;
            $pdfMarginRight = 7;
            $imageSizeM= 5;
            $imageSizeN = 5;
            $imageSizeX = 25;
            $imageSizeY = 15;
            $marginTitle = 30;
            $marginSubTitle = 30;
            $subtitle = 30;
            $numeroWidth = 20;
            $cantidadWidth = 40;
            $descripcionWidth = 60;
            $ubicacionWidth = 35;
            $unidadWidth = 30;
            $fechaWidth = 30;
            $horaWidth = 30;
            $precioWidth = 40;
            $footer=false;
        }
                         
        $pdf = new Pdf_venta(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle( 'Detalle_produccion');
        $pdf->SetSubject('Detalle_produccion');

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

        $pdf->SetFont('times', '', $pdfFontSizeData, '', true);
        $pdf->AddPage('P', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
    
        $fecha = date('d-m-y h:i:s');;
        $nombre = $this->session->userdata('usuario');

        $image_file = 'assets/img/icoLogo/'.$logo;

        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

        $titulo='        DETALLE PRODUCCIÓN';
		$txt='        
        
        ';
        
        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeMain);
        $pdf->MultiCell($marginSubTitle, 5, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell($subtitle, 5, $txt, 0, 'C', 0, 1, '', '', true);

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$ubicacionWidth.'px"> Ubicacion </th>
                <th width="'.$descripcionWidth.'px"> Producto</th>
                <th width="'.$cantidadWidth.'px"> Cantidad </th>
                <th width="'.$unidadWidth.'px"> Unidad </th>
                <th width="'.$fechaWidth.'px">  Fecha</th>
                    <th width="'.$horaWidth.'px"> Hora </th>

            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($data as $ped):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td align="center">'.$ped->oubicacion.'</td>
                  <td >'.$ped->oproducto.'</td>
                  <td align="center">'.$ped->ocantidad.'</td>
                  <td align="center">'.$ped->ounidad.'</td>
                  <td align="center">'.$ped->ofecha.'</td>
                  <td align="center">'.$ped->ohora.'</td>
                </tr>';
            endforeach;
            $tbl3 = '<br>
        </table>
          ';

        $pdf->writeHTML($tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_Detalle_produccion.pdf', 'I');
    }

    public function pdf_detalle_produccion(){
                     
        $nota_venta = $this->produccion->get_reporte_ingreso();
        // echo json_encode($nota_venta);
        // echo ((count ($nota_venta)));
        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;
        
        $id_usuario = $this->session->userdata('id_usuario');

        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
            // tamaño carta
            $marginTitle = 100;
            $marginSubTitle = 100;
            $subtitle = 65;
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
            $footer=true;
        } else {
            $dim=80;
            $dim = $dim+(count ($nota_venta)*10);
            $pdfSize = array(80,$dim);
            $pdfFontSizeMain= 9;
            $pdfFontSizeData= 9;
            $pdfMarginLeft = 5;
            $pdfMarginRight = 7;
            $imageSizeM= 5;
            $imageSizeN = 5;
            $imageSizeX = 25;
            $imageSizeY = 15;
            $marginTitle = 30;
            $marginSubTitle = 30;
            $subtitle = 30;
            $numeroWidth = 20;
            $cantidadWidth = 40;
            $descripcionWidth = 100;
            $precioWidth = 40;
            $footer=false;
        }
                         
        $pdf = new Pdf_venta(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle( 'Detalle_produccion');
        $pdf->SetSubject('Detalle_produccion');

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

        $pdf->SetFont('times', '', $pdfFontSizeData, '', true);
        $pdf->AddPage('P', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
    
        $fecha = date('d-m-y h:i:s');;
        $nombre = $this->session->userdata('usuario');

        $image_file = 'assets/img/icoLogo/'.$logo;

        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

        $titulo='        DETALLE PRODUCCIÓN';
		$txt='        
        
        ';
        
        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeMain);
        $pdf->MultiCell($marginSubTitle, 5, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell($subtitle, 5, $txt, 0, 'C', 0, 1, '', '', true);

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$cantidadWidth.'px"> Lote </th>
                <th width="'.$descripcionWidth.'px"> Destino</th>
                <th width="'.$precioWidth.'px">  Fecha</th>
                    <th width="'.$precioWidth.'px"> Hora </th>

            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($nota_venta as $ped):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center">'.$nro.'</td>
                  <td align="center">'.$ped->olote.'</td>
                  <td >'.$ped->odestino.'</td>
                  <td align="center">'.$ped->ofecha.'</td>
                  <td align="center">'.$ped->ohora.'</td>
                </tr>';
            endforeach;
            $tbl3 = '<br>
        </table>
          ';

        $pdf->writeHTML($tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_Detalle_produccion.pdf', 'I');
    }
}
