<?php
/*
  Modificado: Brayan Janco Cahuana Fecha:14/09/2021, Codigo: GAN-MS-A4-028
  Descripcion: Se modifico para crear la funcion generar_pdf_venta para obtener un pdf de tcpdf
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Pedro Rodrigo Beltran Poma.   Fecha:29/08/2022,   Codigo: GAN-SC-M5-405,
  Descripcion: Se modifico la funcion add_garantia para adecuarla a la logica de M_venta.
  */
defined('BASEPATH') OR exit('No direct script access allowed');

class C_venta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('venta/M_venta','venta');
        $this->load->library('Pdf_venta');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $ubicacion = $this->session->userdata('ubicacion');
            $data['lst_pedidos'] = $this->venta->get_lst_pedido_lote($ubicacion);
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'venta/lista_pedidos';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function confirmacion_venta() {
        if ($this->session->userdata('login')) {
            $data['ubicacion'] = $ubicacion = $this->session->userdata('ubicacion');

            $log['permisos'] = $this->session->userdata('permisos');
            $data['id_lote'] = $id_lote = $this->input->post('lote');
            $data['factura'] = $factura = $this->input->post('factura');
            $data['cliente'] = $cliente = $this->input->post('cliente');
            $data['lst_conf_pedidos'] =$productos= $this->venta->get_conf_pedido($id_lote);
            $data['total_pedido'] =$total_venta= $this->venta->get_precio_total($id_lote, $ubicacion);
            if ($factura == 1) {
                /* Cargar los productos y reedirigir a venta facturada */
                $venta=$this->venta->update_venta($id_lote);
              //  $resp = $this->venta->agregarproductos_ventafacturada($productos);
                if ($venta) {
                    $this->session->set_userdata('total_caja', $total_venta);
                    $this->session->set_userdata('cliente_caja', $cliente);
                    redirect('venta_facturada');
                }
                
            }
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['contenido'] = 'venta/venta';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function eliminar_venta(){
        $id_lote = $this->input->post('lote');
        $lst_conf_pedidos=$this->venta->get_conf_pedido($id_lote);
        $id_vent= $lst_conf_pedidos[0]->id_venta;
        $data=$this->venta->eliminar_confirmar_venta($id_vent);
        echo json_encode($data);
    }

    public function add_garantia(){
        if ($this->input->post('id_cliente') == '') {
            $cliente = 0;
        } else {
            $cliente = $this->input->post('id_cliente');
        }

        $data = array(
            'id_venta' => $this->input->post('id_venta'),
            'id_producto' => $this->input->post('id_producto'),
            'id_cliente' => $cliente,
            'serie' => $this->input->post('serie_gar'),
            'detalle' => $this->input->post('detalle_gar'),
            'fecfin' => $this->input->post('fecha_gar'),
            'usucre' => $this->session->userdata('usuario')
        );
        $gar_insert = $this->venta->insert_garantia($data);
        // GAN-SC-M5-405, 29/08/2022, PBeltran
        $vValor=0;
        foreach ($gar_insert as $row){
            $vValor = $row->ovalor;
        }
          if ($vValor == 1) {
        // Fin GAN-SC-M5-405, 29/08/2022, PBeltran
              $this->session->set_flashdata('success','Garantia insertada exitosamente.');
          } else {
              $this->session->set_flashdata('error','Error al insertar Garantia.');
          }
        redirect('venta');
    }

    public function generar_pdf_venta($id_lote){
        
        // $id_lote = $this->input->post('id_lote');
        $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
        // $lst_conf_pedidos = $this->venta->get_conf_pedido($id_lote);
        $lst_conf_pedidos = $this->venta->get_conf_cobrado($id_lote);
        $id_vent= $lst_conf_pedidos[0]->id_venta;
        $logo= $this->general->get_ajustes("logo");
        $consi = $this->general->get_ajustes("consideracion");
        
        $nota_venta = $this->venta->get_lst_nota_venta($usr,$id_vent);
        // var_dump($nota_venta);exit();
        $lst_nota_venta= $nota_venta[0]->fn_nota_venta;
         
        $lstas_nota_venta= json_decode($lst_nota_venta);

        $ajustes = $this->general->get_ajustes("logo");
        $ajuste = json_decode($ajustes->fn_mostrar_ajustes);
        $logo = $ajuste->logo;

        $ajuste = json_decode($consi->fn_mostrar_ajustes);
        $consideracion = $ajuste->consideracion;

        $id_usuario = $this->session->userdata('id_usuario');

        $usuario = $this->session->userdata('usuario');
        $fecha = $lstas_nota_venta->fecha;
        $nombre_rsocial = $lstas_nota_venta->nombre_rsocial;
        $ci_nit = $lstas_nota_venta->ci_nit;
        $lst_pedidos = $lstas_nota_venta->pedidos;
        $total = $lstas_nota_venta->total;
        $pagado = $lstas_nota_venta->pagado;
        $cambio = $lstas_nota_venta->cambio;
        $saldo = $lstas_nota_venta->saldo;
        $nombre = $lstas_nota_venta->nombre;
        $direccion = $lstas_nota_venta->direccion;
        $pagina = $lstas_nota_venta->pagina;
        $telefono = $lstas_nota_venta->telefono;
        $codigo = $lstas_nota_venta->codigo;
        $codigo_vent = $lstas_nota_venta->cod_venta;
        $tipo_venta = $lstas_nota_venta->tipo_venta;
        $hora = $lstas_nota_venta->hora;
        $id_lote = $lstas_nota_venta->id_lote;


        $id_papel = $this->general->get_papel_size($id_usuario);
        if ($id_papel[0]->oidpapel == 1304) {
            // tamaño carta
            $marginTitle = 100;
            $marginTitleBotton = 15;
            $marginSubTitle = 200;
            $marginSubBotton = 5;
            $subtitle = 65;
            $pdfMarginLeft = 15;
            $pdfMarginRight = 15;
            $pdfFontSizeData= PDF_FONT_SIZE_DATA;
            $pdfSize = PDF_PAGE_FORMAT;
            $pdfFontSizeMain = 15;
            $imageSizeN= 15;
            $imageSizeM= 20;
            $imageSizeX = 45;
            $imageSizeY = 15;
            $numeroWidth = 30;
            $cantidadWidth = 75;
            $descripcionWidth = 300;
            $precioWidth = 80;
            $espacioWidth = 435;
            $titulosWidth = 80;
            $importesWidth = 125;
            $footer=true;
            $datos = '
            <table cellspacing="1" cellpadding="3" border="0">
                <tr>
                    <td align="left">
                    <font><b>RAZON SOCIAL/NOMBRE: </b>' . $nombre_rsocial . '</font><br>
                    <font><b>FECHA: </b>' . $fecha . ' ' . $hora . '</font><br>
                    <font><b>NRO DE VENTA: </b>' . $id_lote . '</font>        
                    </td>
                    <td align="left">
                    <font><b>SUCURSAL: </b>' . $nombre . '</font><br>
                    <font><b>USUARIO: </b>' . $usuario . '</font> 
                    </td>
                    <td align="left">
                    <font><b> CI/NIT/Cod. Cliente: </b>' . $ci_nit . '</font><br>
                    <font><b> CODIGO DE VENTA: </b>' . $codigo_vent . '</font><br>
                    <font><b> TIPO DE VENTA: </b>' . $tipo_venta . '</font><br>
                    </td>
                    
                </tr>
            </table> ';
        } else {
            $dim = 80;
            $dim = $dim + (count($lstas_nota_venta->pedidos) * 10) + 30;
            $pdfSize = array(80, $dim);
            $pdfFontSizeMain = 9;
            $pdfFontSizeData = 9;
            $pdfMarginLeft = 5;
            $pdfMarginRight = 7;
            $imageSizeM = 5;
            $imageSizeN = 5;
            $imageSizeX = 25;
            $imageSizeY = 15;
            $marginTitle = 30;
            $marginTitleBotton = 2;
            $marginSubTitle = 30;
            $marginSubBotton = 17;
            $subtitle = 30;
            $numeroWidth = 20;
            $cantidadWidth = 30;
            $descripcionWidth = 100;
            $precioWidth = 40;
            $espacioWidth = 80;
            $titulosWidth = 70;
            $importesWidth = 115;
            $footer = false;
            $datos = '
            <div>
                <br>
                <font><b> FECHA:&nbsp;</b>' . $fecha . ' ' . $hora . '</font><br>
                <font><b> NRO DE VENTA:&nbsp;</b>' . $id_lote . '</font><br>
                <font><b> RAZON SOCIAL/NOMBRE:&nbsp;</b>' . $nombre_rsocial . '</font><br>
                <font><b> CI/NIT/Cod. Cliente:&nbsp;</b>' . $ci_nit . '</font><br>
                <font><b> CODIGO DE VENTA:&nbsp;</b>' . $codigo_vent . '</font><br>
            </div> ';
        }

        $pdf = new Pdf_venta(PDF_PAGE_ORIENTATION, PDF_UNIT,  $pdfSize, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('-');
        $pdf->SetTitle('Nota de venta');
        $pdf->SetSubject('Nota de venta');

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
        $pdf->AddPage('P',  $pdfSize);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $image_file = 'assets/img/icoLogo/'.$logo;

		$pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
        $pdf->MultiCell(0, 0, '', 0, 'C', 0, 1, '', '', true);

        $html = '<span style="text-align:right;">Direccion: ' . $direccion . ' <br/> Telf: ' . $telefono . '</span>';
        $pdf->SetFont('times', 'N', $pdfFontSizeData);
        $pdf->writeHTML($html, true, 0, true, true);

        $pdf->SetFont('times', 'B', $pdfFontSizeMain);

		$titulo='NOTA DE VENTA';
        
        $pdf->Cell(0, $marginTitleBotton, $titulo, 0, true, 'C', 0, '', 1, true, 'M', 'M');
        $pdf->SetFont('times', 'N', $pdfFontSizeData);
		$tbl = $datos;

        $tbl1 = '
        <table cellpadding="3">
            <tr align="center" style="font-weight: bold" bgcolor="#E5E6E8">
                <th width="'.$numeroWidth.'px" border="1"> # </th>
                <th width="'.$cantidadWidth.'px" border="1"> Cantidad </th>
                <th width="' . $cantidadWidth . 'px" border="1"> Unidad </th>
                <th width="'.$descripcionWidth.'px" border="1"> Descripcion</th>
                <th width="'.$precioWidth.'px" border="1"> Precio (Bs.) </th>
                <th width="'.$precioWidth.'px" border="1"> Importe (Bs.) </th>
            </tr> ';

            $nro=0;
            $tbl2 = '';
            foreach ($lst_pedidos as $ped):
              $nro++;
              $tbl2 = $tbl2.'
                <tr>
                  <td align="center" border="1">'.$nro.'</td>
                  <td align="center" border="1">'.$ped->cantidad.'</td>
                  <td align="center" border="1">' . $ped->unidad . '</td>
                  <td border="1">'.$ped->descripcion.'</td>
                  <td align="center" border="1">'.$ped->precio.'</td>
                  <td align="center" border="1">'.$ped->importe.'</td>
                </tr>';
            endforeach;
            $tbl3 = '
                <tr>
                    <td width="' . $espacioWidth . 'px"  rowspan = "3">
                    </td>
                    <td width="' . $titulosWidth . 'px">
                        <font><b> TOTAL:</b></font>
                    </td>
                    <td width="' . $importesWidth . 'px" align= "right">
                        <font>' . $total . '</font>
                    </td>
                </tr>
                <tr>
                    <td width="' . $titulosWidth . 'px">
                        <font><b> PAGADO:</b></font>
                    </td>
                    <td width="' . $importesWidth . 'px" align= "right">
                        <font>' . $total . '</font>
                    </td>
                </tr>
                <tr>
                    <td width="' . $titulosWidth . 'px">
                        <font><b> CAMBIO:</b></font>
                    </td>
                    <td width="' . $importesWidth . 'px" align= "right">
                        <font>0.00Bs.</font>
                    </td>
                </tr>
        </table>
        <div style="text-align:center;">
          ' . $consideracion . '
        </div>';

        $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');
        ob_end_clean();
        $pdf_ruta = $pdf->Output('Reporte_nota_venta.pdf', 'I');
    }
    


    public function confirmar_venta(){
        $id_ubicacion = $this->session->userdata('ubicacion');
        $id_lote = $this->input->post('id_lote');

        $total = $this->venta->get_precio_total($id_lote,$id_ubicacion);
        $ven_update = $this->venta->confirmar_venta($id_lote, $total);
        if ( $ven_update > 0 ) {
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('resp' => 'ok', 'id_lote' => $id_lote)));
		} else {
			$this->output->set_status_header(401);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('resp' => 'error')));
		}
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

                    $this->load->view('venta/form_pedido', $data);
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
}
