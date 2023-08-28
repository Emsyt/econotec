<?php
/* A
------------------------------------------------------------------------------------------
Creador: Aliso Paola Pari Pareja Fecha:28/11/2022, GAN-MS-A7-0142
Creacion del Controlador C_items para conectar con la vista items y M_items con sus respectivas funciones
------------------------------------------------------------------------------------------
Modificacion: Aliso Paola Pari Pareja Fecha:29/11/2022, GAN-MS-A7-0145
Se anadieron funciones para el registro, edicion, y eliminacion de series
------------------------------------------------------------------------------
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_items extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('producto/M_items','items');
        $this->load->library('Pdf_venta');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['lotes']= $this->items->M_listar_lotes_garantia();
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'producto/items';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function registro_serie() {
        if ($this->session->userdata('login')) {
           
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['lote'] = $id_lote=$this->input->post('idlote');
            $data['provision'] = $id_provision=$this->input->post('id_provision');
            $data['producto'] = $id_producto=$this->input->post('id_producto');
            $data['cant'] = $cantidad=$this->input->post('cantidad');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'producto/registro_serie';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function mostrar_lotes_garantia(){
        $id_lote=$this->input->post('id_lote');
        $data = $this->items->M_mostrar_lotes_garantia($id_lote);
        echo json_encode($data);
    }
    public function listar_series(){
        $id_provision=$this->input->post('id_provision');
        $id_lote=$this->input->post('id_lote');
        $id_producto=$this->input->post('id_producto');
        $data = $this->items->M_listar_series($id_producto,$id_lote,$id_provision);
        echo json_encode($data);
    }
    public function validar_cantidad_serie(){
        $id_provision=$this->input->post('id_provision');
        $id_lote=$this->input->post('id_lote');
        $id_producto=$this->input->post('id_producto');
        $data = $this->items->M_validar_cantidad_serie($id_provision,$id_lote,$id_producto);
        echo json_encode($data);
    }
    public function add_edit_serie(){
        $tipo=$this->input->post('btn');
        $id_provision=$this->input->post('id_provision');
        $id_login=$this->session->userdata('id_usuario');
        $id_producto=$this->input->post('id_producto');        
        $id_lote=$this->input->post('id_lote');
        $serie=$this->input->post('serie');
        $data = $this->items-> M_add_edit_serie($tipo,$id_provision,$id_login,$id_producto,$id_lote,$serie);
        echo json_encode($data);
    }
    public function recuperar_serie(){
        $id_item=$this->input->post('id_item');
        $data = $this->items->M_recuperar_serie($id_item);
        $data= $data[0]->fn_recuperar_datos_serie;
        echo json_encode($data);
    }
    public function eliminar_serie(){
        $id_item=$this->input->post('id_item');
        $data = $this->items->M_eliminar_serie($id_item);
        echo json_encode($data);
    }

    public function verificar_generado_serie(){
        $id_provision=$this->input->post('id_provision');
        $id_lote=$this->input->post('id_lote');
        $id_producto=$this->input->post('id_producto');
        $cantidad=$this->input->post('cantidad');
        $inicio=$this->input->post('inicio');
        $data = $this->items->M_verificar_generado_serie($id_provision,$id_lote,$id_producto,$cantidad,$inicio);
        echo json_encode($data);
    }


    public function generar_serie_item(){
        $id_provision=$this->input->post('id_provision');
        $id_lote=$this->input->post('id_lote');
        $id_producto=$this->input->post('id_producto');
        $cantidad=$this->input->post('cantidad');
        $inicio=$this->input->post('inicio');
        $data = $this->items->M_generar_serie_item($id_provision,$id_lote,$id_producto,$cantidad,$inicio);
        echo json_encode($data);
    }


    public function pdf_serie(){

        $id_provision = $this->input->post('provision1');
        // echo '<br>';
        $id_lote = $this->input->post('lote1');
        // echo '<br>';
        $id_producto = $this->input->post('producto1');
        // echo '<br>';
        // echo $this->input->post('cant_copias');
        $data = $this->items->M_serie($id_provision,$id_lote,$id_producto);

        $id_barcode = $this->input->post('lote1');
        $cantidad_barcode = $this->input->post('cant_copias') * count($data);
        $cantidad_bar = count($data);
        $id_usuario = $this->session->userdata('id_usuario');
        
        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
            $pdfFontSizeData= PDF_FONT_SIZE_DATA;
            $pdfSize = PDF_PAGE_FORMAT;
            $pdfFontSizeMain= PDF_FONT_SIZE_MAIN;
            $footerMargin=true;
            $marginz=5;
        } else {
            $heightPaper=80;
            if($cantidad_barcode>2){
                $heightPaper=($cantidad_barcode)*35.2; 
            }
            $pdfSize = array(80,$heightPaper);
            $pdfFontSizeMain= 9;
            $pdfFontSizeData= 8;
            $footerMargin=false;
            $marginz=0;
        }
        $pdf = new Pdf_venta(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Código de barras');
        $pdf->SetSubject('Código de barras');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0,75,146), array(0,75,146));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, 'B', $pdfFontSize));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(10, 10, $marginz);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(10);

        $pdf->SetAutoPageBreak($footerMargin, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);

        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);

        $pdf->SetFont('times', '', $pdfFontSizeMain, '', true);
        $pdf->AddPage('P', $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        $style = array(
            'position' => '',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, 
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 5,
        );
        
        if ($id_papel[0]->oidpapel == 1304) {
            $x=7;
            $y=10;
            if(strlen($id_barcode)>16){
                $s=95;
                $l=120;
                $d='99';
                if(strlen($id_barcode)>26){
                    $s=100;
                    $l=100;
                    $d='';
                }
            }else{
                if(strlen($id_barcode)>11){
                    $s=65;
                    $l=150;
                    $d='65';
                }else{
                    $s=50;
                    $l=200;
                    $d='';
                    if(strlen($id_barcode)<8){
                        $s=40;
                        $l=200;
                        $d='41';
                    }
                }
            }
            $s=65;
            $l=195;
            $d='65';
            $val = 1;
            $cant_cp = $this->input->post('cant_copias');
            $num = 0;

            for ($i=0; $i <count($data) ; $i++) { 

                for ($j=0; $j < $cant_cp; $j++) { 
                    $pdf->write1DBarcode($data[$i]->codigo, 'C93', $x, $y, 60, 14, 0.34, $style, 'N');
                    $x=$x+$s;
                    if($x>$l){
                        $x=7;
                        $y=$y+14;
                    }
                    if($y>240){
                        $y=10;
                        if($i!=$cantidad_barcode-1){
                            $pdf->AddPage();
                        }
                    }
                }



                // $val = $val + 1;
            }
        }else{
            if(strlen($id_barcode)>13){
                $x=0;
            }else{
                $x=10;
            }
            $y=3;
            for ($i=0; $i <$cantidad_barcode ; $i++) { 
                $pdf->write1DBarcode($id_barcode, 'C93', $x, $y, '', 14, 0.34, $style, 'N');
                    $y=$y+35;
                
            }
        }
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Barcode.pdf', 'I');

    }

}
