<?php
/*
  Modificado: Brayan Janco Cahuana Fecha:27/09/2021, Codigo: GAN-MS-A4-038,
  Descripcion: Se modifico para crear la funcion generar_pdf_cotizacion para obtener un pdf de tcpdf
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Pedro Rodrigo Beltran Poma.   Fecha:29/08/2022,   Codigo: GAN-SC-M5-405,
  Descripcion: Se modifoc la funcion dlt_pedido para funcionar acorde la logica en M_pedido.
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Alison Paola Pari Pareja.   Fecha:16/11/2022,   Codigo: GAN-MS-A4-0061,
  Descripcion: Se modifico la funcion add_pedido para insertar el movimiento.
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Ariel Ramos Paucara.   Fecha:20/03/2023,   Codigo: GAN-MS-B5-0327
  Descripcion: Se modifico la funcion add_pedido para enviar datos de tipo json al insertar la venta y movimiento.
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_pedido extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('venta/M_pedido','pedido');
        $this->load->library('Pdf_venta');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $this->session->userdata('usuario');
            $data['productos'] = $this->pedido->get_producto_cmb();

            $data['contador'] = $this->pedido->contador_pedidos($usr);
            //$data['contador'] = 2;
            $data['lst_pedidos'] = $this->pedido->get_pedido();
            $data['total_pedido'] = $this->pedido->get_total_pedido();
            $data['clientes'] = $this->pedido->get_cliente_cmb();

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'venta/pedido';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function add_pedido(){
        $data = array(
            'id_ubicacion' => $this->session->userdata('ubicacion'),
            'id_lote' => 0,
            'id_producto' => $this->input->post('id_producto'),
            'id_persona' => 0,
            'cantidad' => $this->input->post('cantidad'),
            'unidad' => $this->input->post('id_unidad'),
            'precio_compra' => $this->input->post('pre_compra'),
            'precio' => $this->input->post('pre_total'),
            'factura' => 0,
            'usucre' => $this->session->userdata('usuario'),
            'apiestado' => 'RESERVA'
        );
        // GAN-MS-B5-0327, 20/03/2023, Ariel Ramos
        $datos = json_encode($data);
        $ped_insert = $this->pedido->insert_pedido($datos);
        // Fin GAN-MS-B5-0327, 20/03/2023, Ariel Ramos
          if ($ped_insert) {
              $this->session->set_flashdata('success','Registro insertado exitosamente.');
          } else {
              $this->session->set_flashdata('error','Error al insertar Registro.');
          }
          $data1 = array(
            'ubi_ini' => $this->session->userdata('ubicacion'),
            'ubi_fin' => $this->session->userdata('ubicacion'),
            'usuenvio' => $this->session->userdata('id_usuario'),
            'usurecibe' => $this->session->userdata('id_usuario'),
            'id_producto' => $this->input->post('id_producto'),
            'cantidad' => $this->input->post('cantidad'),
            'unidad' => $this->input->post('id_unidad'),
            'id_lote' => 0,
            'feccre' => 'now()',
            'usucre' => $this->session->userdata('usuario'),
            'apiestado' => 'RESERVA'
        );
        // GAN-MS-B5-0327, 20/03/2023, Ariel Ramos
        $data_mov = json_encode($data1);
        $mov_insert = $this->pedido->insert_mov_pedido($data_mov);
        // Fin GAN-MS-B5-0327, 20/03/2023, Ariel Ramos
          if ($mov_insert) {
              $this->session->set_flashdata('success','Registro insertado exitosamente.');
          } else {
              $this->session->set_flashdata('error','Error al insertar Registro.');
          }
        redirect('pedido');
    }

    public function add_pedido_respaldo(){
        if ($this->input->post('factura') == 1) {
            $factura = 1;
        } else {
            $factura = 0;
        }

        $data = array(
            'id_ubicacion' => $this->session->userdata('ubicacion'),
            'id_lote' => 0,
            'id_producto' => $this->input->post('id_producto'),
            'id_persona' => $this->input->post('cliente'),
            'cantidad' => $this->input->post('cantidad'),
            'unidad' => 'UNIDAD',
            'precio_compra' => $this->input->post('pre_compra'),
            'precio' => $this->input->post('pre_total'),
            'factura' => $factura,
            'apiestado' => 'RESERVA',
            'usucre' => $this->session->userdata('usuario')
        );
        $ped_insert = $this->pedido->insert_pedido($data);
          if ($ped_insert) {
              $this->session->set_flashdata('success','Registro insertado exitosamente.');
          } else {
              $this->session->set_flashdata('error','Error al insertar Registro.');
          }
        redirect('pedido');
    }

    public function dlt_pedido($id_ped){
        $data = array(
            'apiestado' => 'ANULADO',
            'usumod' => $this->session->userdata('usuario'),
            'fecmod' => date('Y-m-d H:i:s')
        );
        $ped_delete = $this->pedido->delete_pedido($id_ped, $data);
    // GAN-SC-M5-405, 29/08/2022, PBeltran
        $vValor=0;
        foreach ($ped_delete as $row){
            $vValor = $row->ovalor;
        }
        if ($vValor == 1) {
    // FIN GAN-SC-M5-405, 29/08/2022, PBeltran
              $this->session->set_flashdata('success','Registro eliminado exitosamente.');
          } else {
              $this->session->set_flashdata('error','Error al eliminar Registro.');
          }
        redirect('pedido');
    }

    public function add_cliente(){
        if ($this->input->post('factura') == 1) {
            $factura = 1;
        } else {
            $factura = 0;
        }

        $data = array(
            'id_persona' => $this->input->post('cliente'),
            'factura' => $factura,
        );
        $gar_insert = $this->pedido->update_pedido(array('id_lote' => $this->input->post('id_lote')), $data);
        if ($gar_insert) {
            $this->session->set_flashdata('success','Registro insertado correctamente.');
        } else {
            $this->session->set_flashdata('error','Error al insertar Registro.');
        }
        redirect('pedido');
    }

    public function confirmar_pedido(){
        if ($this->input->post('factura') == 1) {
            $factura = 1;
        } else {
            $factura = 0;
        }

        $data = array(
            'id_persona' => $this->input->post('cliente'),
            'factura' => $factura
        );
        $gar_insert = $this->pedido->update_pedido(array('id_lote' => $this->input->post('id_lote')), $data);
        if ($gar_insert) {
            $this->session->set_flashdata('success','Registro insertado correctamente.');
        } else {
            $this->session->set_flashdata('error','Error al insertar Registro.');
        }
        $ped_update = $this->pedido->confirmar_pedido();
        if ($ped_update) {
              $this->session->set_flashdata('success','Pedido confirmado exitosamente.');
          } else {
              $this->session->set_flashdata('error','Error al confirmar pedido.');
          }
        redirect('pedido');
    }

    //------- FUNCIONES AUXILIARES -------//
    public function func_auxiliares(){
        try{
            $accion = $_REQUEST['accion'];
            if(empty($accion))
                //echo "aca accion" .$accion;
                throw new Exception("Error accion no valida");
            //$cmb = new Combo_box();
            switch($accion)
            {
                case 'form_pedido':
                    $data['id_prod'] = $id_producto = $this->input->post('selc_prod');
                    $data['producto'] = $this->pedido->get_datos_producto($id_producto);
                    $data['clientes'] = $this->pedido->get_cliente_cmb();

                    $log['permisos'] = $this->session->userdata('permisos');

                    $lib = 0;
                    $data['datos_menu'] = $log;
                    $data['cantidadN'] = $this->general->count_notificaciones();
                    $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
                    $data['titulo'] = $this->general->get_ajustes("titulo");
                    $this->load->view('venta/form_pedido',$data);
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

    // FUNCION OPCIONAL //
    public function datos_producto($id_producto){
        $data = $this->pedido->get_datos_producto($id_producto);
        echo json_encode($data);
    }
    public function generar_pdf_cotizacion(){
        echo 'Aqui';
        if ($this->input->post('factura') == 1) {
            $factura = 1;
        } else {
            $factura = 0;
        }
        $id_ubicacion2 = $this->session->userdata('ubicacion');
        $login2 = $this->session->userdata('usuario');
        echo '<br>id_ubicacion2:';
        echo $id_ubicacion2;
        echo '<br>login2:';
        echo $login2;
        $dato = array(
            'id_persona' => $this->input->post('cliente'),
            'factura' => $factura,
        );
        echo '<br>dato:';
        echo $dato;
        echo '<br>id_persona:';
        echo $this->input->post('cliente');
        echo '<br>factura:';
        echo $factura;
        echo '<br>array:';
        $id_lote = $this->input->post('id_lote');
        $datos23 = array('id_lote' => $id_lote);
        echo '<pre>';
        print_r($datos23);
        echo '</pre>';
        $gar_insert = $this->pedido->update_pedido(array('id_lote' => $this->input->post('id_lote')), $dato);
        echo '<br>gar_insert:';
        echo $gar_insert;
        if ($gar_insert) {
            $this->session->set_flashdata('success','Registro insertado correctamente.');
            echo '<br>TRUE:';
        } else {
            $this->session->set_flashdata('error','Error al insertar Registro.');
            echo '<br>FALSE:';
        }
        
        $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
        $array = $this->pedido->get_pedido();
        $id_vent = $array[0]->id_venta;
        echo '<br>user:';     
        echo $usr;
        echo '<br>Id_venta:';
        echo $id_vent;
        $nota_venta = $this->pedido->get_lst_nota_venta_cotizacion($usr,$id_vent);
        echo '<br>user2';
        echo '<br>nota_venta:';
        echo $nota_venta;
        echo '-----';
        echo count($nota_venta);
        echo '-----';
        // echo '<br>primer elento:';
        // $primer_elemento = reset($nota_venta);
        // echo $primer_elemento;
        $lst_nota_venta = $nota_venta[0]->fn_nota_venta_cotizacion;
        echo '<br>lst_nota_venta:';
        echo $lst_nota_venta;
        echo '<br>user3';
        $lstas_nota_venta = json_decode($lst_nota_venta);
        echo '<br>lst_nota_venta:';
        echo $lst_nota_venta;
        echo 'user4';
        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;
        echo 'Aqui3';
        $id_usuario = $this->session->userdata('id_usuario');
        echo 'Aqui4';
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
            $dim = $dim+(count ($lstas_nota_venta->pedidos)*10);
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
        echo 'Aqui10';                
        $pdf = new Pdf_venta(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle( 'Cotizacion');
        $pdf->SetSubject('Cotizacion');

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
        echo '<br>VENTAAAA: ';
        // echo $lstas_nota_venta;
        echo '<br>FECHA: ';
        $fecha = $lstas_nota_venta->fecha;
        echo $fecha;
        $nombre_rsocial = $lstas_nota_venta->nombre_rsocial;
        echo '<br>Razon social:';
        echo $nombre_rsocial;
        $ci_nit = $lstas_nota_venta->ci_nit;
        echo '<br>ci_nit:';
        echo $ci_nit;
        $lst_pedidos = $lstas_nota_venta->pedidos;
        echo '<br>lst_pedidos:';
        echo $lst_pedidos;
        $total = $lstas_nota_venta->total;
        $pagado = $lstas_nota_venta->pagado;
        $cambio = $lstas_nota_venta->cambio;
        $nombre = $lstas_nota_venta->nombre;
        $direccion = $lstas_nota_venta->direccion;
        $pagina = $lstas_nota_venta->pagina;
        $telefono = $lstas_nota_venta->telefono;

        $image_file = 'assets/img/icoLogo/'.$logo;

        $pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

        $titulo='        COTIZACION';
		$txt='        '.$nombre.'
        '.$direccion.'
        Telf.'.$telefono.'           '.$pagina;
        
        $pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
        $pdf->SetFont('times', 'N', $pdfFontSizeMain);
        $pdf->MultiCell($marginSubTitle, 5, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell($subtitle, 5, $txt, 0, 'C', 0, 1, '', '', true);

        $tbl = '

        <div>
            <br>
            <font><b> FECHA:&nbsp;</b>'.$fecha.'</font><br>
            <font><b> RAZON SOCIAL/NOMBRE:&nbsp;</b>'.$nombre_rsocial.'</font><br>
            <font><b> CI/NIT/Cod. Cliente:&nbsp;</b>'.$ci_nit.'</font><br>
        </div> ';

        $tbl1 = '
          <table cellpadding="3" border="1">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px"> N&ordm; </th>
                <th width="'.$cantidadWidth.'px"> cantidad </th>
                <th width="'.$descripcionWidth.'px"> Descricion</th>
                <th width="'.$precioWidth.'px"> Precio (Bs.) </th>
                    <th width="'.$precioWidth.'px"> Importe (Bs.) </th>

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
            $tbl3 = '<br>
            <table>
            <tr>
                <td width="440">
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
          ';

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_Cotizacion.pdf', 'I');
    }
}
