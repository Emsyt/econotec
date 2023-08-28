<?php
/*
  Creador: Deivit Pucho Aguilar Fecha:26/09/2022, Codigo:GAN-FR-A1-483
  Descripcion:Se crea el controlador C_contizaciones. 
  ---------------------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha: 3/10/2022,  Codigo:GAN-CV-A1-0018
  Descripcion: Se modifico la funcion pdf_generar_venta.
  ---------------------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha: 4/10/2022,  Codigo:GAN-MS-A0-0029
  Descripcion: Se modifico la funcion pdf_generar_venta.
  -----------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana fecha 11/10/2022 Codigo: GAN-MS-A4-0101
  Descripcion: Se modifico la funcion generar_pdf_venta_codigo(), donde se corregio el texto de la observacion es muy largo se  sobrepone sobre los otros datos
  ---------------------------------------------------------------------------------------------
  Modificado: Briyan Julio Torrez Vargas  Fecha: 03/02/2023,  Codigo: GAN-MS-B0-0214
  Descripcion: Se adiciono la función get_fecha_validez(), que retorna la fecha_validez desde la bd
  
  */
defined('BASEPATH') or exit('No direct script access allowed');

class C_cotizaciones extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('venta/M_cotizaciones', 'cotizaciones');
    $this->load->library('Pdf');
  }

  public function index()
  {
    if ($this->session->userdata('login')) {
      $log['permisos'] = $this->session->userdata('permisos');
      $usr = $this->session->userdata('usuario');
      $data['producto'] = $this->cotizaciones->mostrar();
      $data['contador'] = $this->cotizaciones->contador_pedidos($usr);
      $data['lib'] = 0;
      $data['datos_menu'] = $log;
      $data['cantidadN'] = $this->general->count_notificaciones();
      $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
      $data['titulo'] = $this->general->get_ajustes("titulo");
      $data['thema'] = $this->general->get_ajustes("tema");
      $data['descripcion'] = $this->general->get_ajustes("descripcion");
      $data['contenido'] = 'venta/cotizaciones';
      $usrid = $this->session->userdata('id_usuario');
      $data['chatUsers'] = $this->general->chat_users($usrid);
      $data['getUserDetails'] = $this->general->get_user_details($usrid);
      $this->load->view('templates/estructura', $data);
    } else {
      redirect('logout');
    }
  }
  public function mostrar_produc()
  {
    $data = $this->cotizaciones->mostrar();;
    echo json_encode($data);
  }
  public function lst_tipo_venta()
  {
    $data = $this->cotizaciones->listar_tipos_venta();
    echo json_encode($data);
  }
  public function datos_producto()
  {
    $id_producto = $this->input->post('buscar');
    $observaciones = $this->input->post('observacion');
    $fecha_val = $this->input->post('fec_val');
    $data = $this->cotizaciones->get_datos_producto($id_producto,trim($observaciones),$fecha_val);
    echo json_encode($data);
  }
  public function cantidad_producto()
  {
    $id_venta = $this->input->post('dato1');
    $cantidad = $this->input->post('dato2');
    $data = $this->cotizaciones->cantidad_producto($id_venta, $cantidad);
    echo json_encode($data);
  }
  public function cambiar_precio()
  {
    $id_venta = $this->input->post('dato1');
    $monto = $this->input->post('dato2');
    $data = $this->cotizaciones->cambiar_precio($id_venta, $monto);
    echo json_encode($data);
  }
  public function verificar_cambio_precio()
  {
    $id_venta = $this->input->post('dato1');
    $monto = $this->input->post('dato2');
    $data = $this->cotizaciones->verificar_cambio_precio($id_venta, $monto);
    echo json_encode($data);
  }
  public function verificar_cambio_precio_total()
  {
    $id_venta = $this->input->post('dato1');
    $monto = $this->input->post('dato2');
    $data = $this->cotizaciones->verificar_cambio_precio_total($id_venta, $monto);
    echo json_encode($data);
  }
  public function verifica_cantidad()
  {
    $id_venta = $this->input->post('dato1');
    $cantidad = $this->input->post('dato2');
    $data = $this->cotizaciones->verifica_cantidad($id_venta, $cantidad);
    echo json_encode($data);
  }
  public function cambio_precio_uni()
  {
    $id_venta = $this->input->post('dato3');
    $monto = $this->input->post('dato4');
    $data = $this->cotizaciones->cambio_precio_uni($id_venta, $monto);
    echo json_encode($data);
  }
  public function dlt_pedido()
  {
    $id_ped = $this->input->post("buscar");
    $ped_delete = $this->cotizaciones->delete_pedido($id_ped);
    echo json_encode($ped_delete);
  }
  public function calcular_cambio()
  {
    $id_tipo = $this->input->post('id_tipo');
    $pagado = $this->input->post('pagado');
    $cambio = $this->cotizaciones->calcular_cambio($id_tipo,$pagado);
    echo json_encode($cambio);
  }
  public function relizar_cobro()
  {
    $id_venta = $this->cotizaciones->mostrar();
    $id_vent = $id_venta[0]->oidventa;
    $nit = $this->input->post('valor_nit')."";
    $tipo = $this->input->post('tipo');
    $obs = $this->input->post('obs');
    $cobro = $this->cotizaciones->realizar_cobro($tipo,$nit,$obs);
    $array_cobro = array(
      'oestado' => $cobro[0]->oestado,
      'omensaje' => $cobro[0]->omensaje,
      'idventa'=> $id_vent,
    );
    echo "[".json_encode($array_cobro)."]";
  }
  public function mostrar_nit()
  {
    $nit = $this->cotizaciones->mostrar_nit();
    echo json_encode($nit);
  }
  public function verifica_cliente()
  {
    $nit = $this->input->post('valor_nit')."";
    $valor = $this->cotizaciones->verifica_cliente($nit);
    echo json_encode($valor);
  }
  public function registrar()
  {
    $id_ubi = $this->session->userdata('ubicacion');
    $id=$this->session->userdata('id_usuario');
    $nit = $this->input->post('valor_nit')."";
    $razonSocial = $this->input->post('razonSocial')."";
    $valor = $this->cotizaciones->registrar($id,$nit,$razonSocial,$id_ubi);
    echo json_encode($valor);
  }
  public function mostrar_lts_nombre()
  {
    $nombre = $this->cotizaciones->mostrar_lts_nombre();
    echo json_encode($nombre);
  }
  public function mostrar_nit_usuario()
  {
    $band=0;
    $cad="";
    $nit = $this->input->post('buscar');
    for($i=0; $i<strlen($nit) ;$i++){
      if($nit[$i]=="-"){
        $band=1;
      }
      if($band==1){
        $cad="".$cad."".$nit[$i]."";
      }
    }
    echo( substr($cad,1) );
  }
  public function mostrar_codigo()
  {
    $codigo = $this->cotizaciones->mostrar_codigo();
    echo json_encode($codigo);
  }
  public function mostrar_nombre()
  {
    $nit = $this->input->post('buscar');
    $nombre = $this->cotizaciones->mostrar_nombre($nit);
    echo json_encode($nombre);
  }
  public function mostrar_producto()
  {
    $nombre = $this->cotizaciones->mostrar_producto();
    echo json_encode($nombre);
  }
  //GAN-MS-M4-0063 21/10/2020 DPucho
  public function datos_nombre()
  {
    $nombre = $this->input->post('buscar');
    $observaciones = $this->input->post('observacion');
    $fecha_val = $this->input->post('fec_val');
    $data= $this->cotizaciones->get_datos_nombre($nombre,$observaciones,$fecha_val);
    echo json_encode($data);
  }
  //FIN GAN-MS-M4-0063 21/10/2020 DPucho
  //GAN-CV-A1-0018 3/10/2022 DPucho
  public function generar_pdf_venta_codigo()
  {
    $id_venta = $this->input->post('id_cotizacion');
    $nota_venta = $this->cotizaciones->get_lst_nota_venta($id_venta,6);
    $lst_nota_venta= $nota_venta[0]->fn_nota_cotizacion;
    $lstas_nota_venta= json_decode($lst_nota_venta);
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
            $precioWidth = 107;
            $espacioWidth = 422;
            $titulosWidth = 107;
            $importesWidth = 107;
            $observacionesWidth = 636;
            $footer=true;
        } else {
            $dim=80;
            $dim=$dim+(count($lstas_nota_venta->pedidos)*10);
            $dim=$dim+50;
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
            $espacioWidth = 105;
            $titulosWidth = 70;
            $importesWidth = 60;
            $footer=false;
        }

    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, $pdfSize, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('-');
    $pdf->SetTitle('Nota de cotizacion');
    $pdf->SetSubject('Nota de cotizacion');

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

    $pdf->SetFont('times', '',$pdfFontSizeData, '', true);
    $pdf->AddPage('P', $pdfSize);

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $fecha = $lstas_nota_venta->fecha;
    // $fecha = $this->input->post('fecMes');
    $observaciones = $lstas_nota_venta->observacion;
    
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

    $image_file = 'assets/img/icoLogo/'.$logo;

		$pdf->Image($image_file, $imageSizeM, $imageSizeN, $imageSizeX, $imageSizeY, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

		$pdf->SetFont('times', 'B', $pdfFontSizeMain);

		$titulo='        NOTA DE COTIZACION - '.$codigo;
		$txt='        '.$nombre.'
        '.$direccion.'
        '.$telefono.'           '.$pagina;
		
		$pdf->MultiCell($marginTitle, 5, $titulo, 0, 'C', 0, 1, '', '', true);
		$pdf->SetFont('times', 'N', $pdfFontSizeMain);
		$pdf->MultiCell($marginSubTitle, 5, '', 0, 'C', 0, 0, '', '', true);
		$pdf->MultiCell($subtitle, 5, $txt, 0, 'C', 0, 1, '', '', true);

    $tbl = '

    <div>
        <br>
        <font><b> FECHA VALIDA HASTA:&nbsp;</b>'.$fecha.'</font><br>
        <font><b> RAZON SOCIAL/NOMBRE:&nbsp;</b>'.$nombre_rsocial.'</font><br>
        <font><b> CI/NIT/Cod. Cliente:&nbsp;</b>'.$ci_nit.'</font><br>
    </div> ';

    $tbl1 = '
      <table cellpadding="3">
        <tr align="center" style="font-weight: bold;" bgcolor="#E5E6E8" >
            <th width="'.$numeroWidth.'px" border="1"> # </th>
            <th width="'.$cantidadWidth.'px" border="1"> Cantidad </th>
            <th width="'.$descripcionWidth.'px" border="1"> Descrición</th>
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
              <td border="1">'.$ped->descripcion.'</td>
              <td align="center" border="1">'.$ped->precio.'</td>
              <td align="center" border="1">'.$ped->importe.'</td>
            </tr>';
        endforeach;
          $tbl3 = '
          <tr>
            <td width="'.$espacioWidth.'px">
            </td>
            <td width="'.$titulosWidth.'px" align= "center" border="1" style="font-weight: bold;" bgcolor="#E5E6E8">
              <font><b>TOTAL:</b></font>
            </td>
            <td width="'.$importesWidth.'px" align="center" border="1">
              <font>'.$total.'</font>
            </td>
          </tr>
          <tr>
            <td width="'.$observacionesWidth.'px"><font><b>OBSERVACIONES:&nbsp;</b>'.$observaciones.'</font><br>
            </td>
          </tr>
      </table>
        ';
        

    $pdf->writeHTML($tbl.$tbl1.$tbl2.$tbl3, true, false, false, false, '');

    ob_end_clean();
    $pdf_ruta = $pdf->Output('Reporte_nota_venta.pdf', 'I');
    
  }
  //GAN-CV-A1-0018 3/10/2022 DPucho

  public function mostrar_stock_total()
  {
    $codigo = $this->input->post('dato1');
    $data = $this->cotizaciones->mostrar_stock_total($codigo);
    echo json_encode($data);
  }

  public function get_fecha_validez(){
    $fecha = $this->cotizaciones->get_fecha_validez();
    echo json_encode($fecha, true);
  }
}
