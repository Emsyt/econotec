<?php
/*
-------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:28/04/2023, Codigo: 
Descripcion: Se modifico la funcion C_enviar_correo para obtener los datos del servidor de correo desde la db
*/
defined('BASEPATH') or exit('No direct script access allowed');

class C_anulacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Facturacion');
        $this->load->model('facturacion/M_anulacion', 'anulacion');
        $this->load->helper(array('email'));
        $this->load->library(array('email'));
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $this->session->userdata('id_usuario');
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
            $data['contenido'] = 'facturacion/anulacion';

            $data['chatUsers'] = $this->general->chat_users($usr);
            $data['getUserDetails'] = $this->general->get_user_details($usr);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    public function C_listado_facturas_recepcionadas() {
        $fecha_inicial  = $this->input->post('fecha_inicial');
        $fecha_fin      = $this->input->post('fecha_fin');
        $tipofactura    = $this->input->post('tipofactura');
        $data           = $this->anulacion->M_listado_facturas_recepcionadas($fecha_inicial, $fecha_fin, $tipofactura);
        echo json_encode($data);
    }

    
    public function C_anular_factura(){

        $cuf                    = $this->input->post('cuf');
        $codigoDocumentoSector  = $this->input->post('codigoDocumentoSector');
        $codigoMotivo           = $this->input->post('tipoanulacion');
        $correo                 = $this->input->post('correo');
        $numeroFactura          = $this->input->post('nrofactura');
        $rsocial                = $this->input->post('rsocial');
        $facturacion            = $this->anulacion->M_datos_facturacion();

        if ($codigoDocumentoSector != '24') {
            $codigoDocumentoSector      = ($codigoDocumentoSector == '1') ? '1' : '41';
            $FacturacionCompraVenta     = new FacturacionCompraVenta($facturacion);
            $respons        = $FacturacionCompraVenta->solicitudAnulacionFactura($cuf,$codigoMotivo,$codigoDocumentoSector);
            $success        = $respons['success'];
            if ($success) {
                $response       = json_decode($respons['response']);
                if ($response->RespuestaServicioFacturacion->transaccion) {
                    $data = $this->anulacion->M_actualizar_estado_factura($cuf);
                    if ($data[0]->oboolean == 't') {
                        $tituloContenido = "Anulación de Factura";
                        $data = $this->C_enviar_correo($correo,$numeroFactura,$cuf,$rsocial,$tituloContenido);
                    }
                }else {
                    $data = array(
                        (object) array(
                            'oboolean' => 'f',
                            'omensaje' => $response->RespuestaServicioFacturacion->mensajesList->descripcion,
                        )
                    );
                }
            }else{
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $respons['error'],
                    )
                );
            }
        } else {
            $DocumentoAjuste    = new DocumentoAjuste($facturacion);
            $respons            = $DocumentoAjuste->solicitudAnulacionDocumentoAjuste($cuf,$codigoMotivo);
            $success            = $respons['success'];
            if ($success) {
                $response       = json_decode($respons['response']);
                if ($response->RespuestaServicioFacturacion->transaccion) {
                    $data = $this->anulacion->M_actualizar_estado_factura($cuf);
                    if ($data[0]->oboolean == 't') {
                        $tituloContenido = "Anulación Nota de Crédito/Débito";
                        $data = $this->C_enviar_correo($correo,$numeroFactura,$cuf,$rsocial,$tituloContenido);
                    }
                }else {
                    $data = array(
                        (object) array(
                            'oboolean' => 'f',
                            'omensaje' => $response->RespuestaServicioFacturacion->mensajesList->descripcion,
                        )
                    );
                }
            }else{
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $respons['error'],
                    )
                );
            }
        }
        echo json_encode($data);
    }

    public function C_enviar_correo($correo,$numeroFactura,$cuf,$rsocial,$tituloContenido){

        $rsocial            = $this->anulacion->M_recuperar_nombre($rsocial);
        $rsocial            = $rsocial[0]->nombre_rsocial;
        $nitEmisor          = $this->anulacion->M_nit_emisor();
        $nitEmisor          = $nitEmisor[0]->nit;

        $qr = 'https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=' . $nitEmisor . '&cuf=' . $cuf . '&numero=' . $numeroFactura . '&t=2';

         //Datos del servidor SMTP
         $serv_mail=$this->general->datos_smtp();
         $host=$serv_mail[0]->smtp_host;
         $port=$serv_mail[0]->smtp_port;
         $user=$serv_mail[0]->smtp_user;
         $pass=$serv_mail[0]->smtp_pass;
         $empresa=$serv_mail[0]->descripcion;
         ///////
        $this->load->library('email');
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => $host,
            'smtp_port' => $port,
            'smtp_user' => $user,
            'smtp_pass' => $pass,
            'smtp_crypto' => 'tls',
            'send_multipart' => FALSE,
            'wordwrap' => TRUE,
            'smtp_timeout' => '400',
            'validate' => true,
            // 'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline' => "\r\n",
            'crlf' => "\r\n"
        );
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $xml_open = simplexml_load_file(FCPATH . 'assets/facturasxml/' . $cuf . '.xml');

        $subtituloContenido = "Estimado cliente: " . $rsocial;
        $textoContenido     = " <p>La factura Nº " . $numeroFactura . " con el código de Autorización: '" . $cuf . "' fue anulada, Como medida de seguridad se le envia el enlace de la Administración Tributaria para su propia verificación:</p>";
        $tituloRuta         = "CONSULTAR FACTURA";
        $sedeFooter         = "CASA MATRIZ";
        $puntoVentaFooter   = $xml_open->cabecera->codigoPuntoVenta;
        $ubicacionFooter    = $xml_open->cabecera->direccion;
        $telefonoFooter     = $xml_open->cabecera->telefono;
        $municipioFooter    = $xml_open->cabecera->municipio;

        //Datos de estilo
        $color = "rgb(0,121,58)";

        // Formato HTML correo

        $body = "
    <div class='card' style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);overflow: hidden; margin-left:25px;margin-right:50px;'>
      <div class='header' style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);overflow: hidden;'>
          <div class='title' style=' padding:1px;
          margin-bottom:20px;
          border-bottom: 6px solid " . $color . "; padding: 1px;'>
            <h1 style='text-align: center;font-family:Verdana;'>
            " . $tituloContenido . "
            </h1>
          </div>
      </div>
      <div class='subtitle' style='padding: 10px;
          font-weight: bold;
          font-family:Calibri;
          font-size:20px;'>
          " . $subtituloContenido . "
      </div>
      <div class='content' style='padding-left: 10px;
          font-family:Calibri;
          font-size:17px;'>
          " . $textoContenido . "
      </div>
      <div class='contentcenter' style=' width: max-content;
          margin: 0 auto;
          font-family:Calibri;
          font-size:17px;'>
          <a class='empresa' style='display: flex;
            justify-content: center;
            text-align: center;
            font-size:20px;
            color:" . $color . ";'
            href='" . $qr . "'>
            " . $tituloRuta . "
          </a>
      </div>
      <div class='fotter' style='
          margin-top:50px;
          justify-content: center;
          text-align: center;
          background-color: rgb(217, 219, 218);
          padding: 10px;
          font-family:Calibri;
          font-size:12px;'>
          <p style='padding: 0;margin:1px;'>" . $sedeFooter . "</p>
          <p style='padding: 0;margin:1px;'>No. Punto de Venta: " . $puntoVentaFooter . "</p>
          <p style='padding: 0;margin:1px;'>" . $ubicacionFooter . "</p>
          <p style='padding: 0;margin:1px;'>Telefono: " . $telefonoFooter . "</p>
          <p style='padding: 0;margin:1px;'>" . $municipioFooter . "</p>
      </div>
    </div>
  ';
    ";

        $this->email->message($body);
        $this->email->set_mailtype('html');
        $this->email->from($user, $empresa);
        $this->email->to($correo);
        $this->email->subject('Factura');
        if ($this->email->send()) {
            $data = array(
                (object) array(
                    'oboolean' => 't',
                    'omensaje' => '',
                )
            );
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => 'Lo sentimos, no se pudo enviar la factura al correo electrónico especificado.',
                )
            );
        }
        return $data;
    }
}
