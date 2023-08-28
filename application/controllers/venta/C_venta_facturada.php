<?php
/*
  Creador: Heidy Soliz Santos Fecha:20/04/2021, Codigo:SYSGAM-001
  Metodo: index
  Descripcion:Se crea la funcion index para mostrar la vista de pedido por codigo
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:27/04/2021, Codigo:SYSGAM-003
  Descripcion:Se modifico para crear la funcion datos_producto para obtener el nombre la cantidad y el precio
    ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:30/04/2021, Codigo:SYSGAM-005
  Descripcion:Se modifico cambiar la cantidad con la funcion cantidad_producto
  -------------------------------------------------------------------------------
   Modificado: Heidy Soliz Santos Fecha:05/05/2021, Codigo:SYSGAM-007
  Descripcion:Se modifico para mostrar la tabla producto
   ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:06/05/2021, Codigo: SYSGAM-008
  Descripcion:Se modifico para implementar la funcion que calcula el cambio y para realizar la compra  tambien se modifico la funcion index para implemetar el caculo de cambio
------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:11/05/2021, Codigo: SYSGAM-009
  Descripcion: Se modifico para corregir  el error
  -----------------------------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:26/05/2021, Codigo:  GAM -011
  Descripcion: Se modifico para hacer la busqueda de nit como en el maquetado
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:8/06/2021, Codigo: GAM-027
  Descripcion: Se modifico para crear la funcion mostrar codigo
   ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:15/06/2021, Codigo: GAM-028
  Descripcion: Se modifico para completar el nombre del producto
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:07/07/2021, Codigo: GAM-032
  Descripcion: Se modifico para que el cliente no desaparesca
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:14/09/2021, GAN-MS-A4-028
  Descripcion: Se modifico para crear la funcion generar_pdf_venta_codigo
  para obtener un pdf de tcpdf
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:23/09/2021, GAN-MS-A1-033
  Descripcion: Se realizaron la modificacion de la funcion relizar_cobro para que esta devuelva un idventa necesaria para imprimir pdf, tambien se añadio la funcion cambiar precio.
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:05/11/2021, GAN-MS-A4-063
  Descripcion: Se realizaron la creacion de la funcion verifica_cantidad que permite verificar el tamaño del stock del producto.
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:12/11/2021,  GAN-MS-A1-080
  Descripcion: Se Realizo la modificacion en pedidos por codigo para que al momento de cantidad se pueda cambiar a cantidades decimales
  ------------------------------------------------------------------------------
  Modificado: Milena Rojas Fecha:29/06/2022, facturacion
  Descripcion: Se adicionó las funciones para enviar las facturas al servicio de impuestos nacionales
     ------------------------------------------------------------------------------
  Modificado: karen quispe chavez fecha 20/07/2022 Codigo :GAN-MS-A1-312
   Descripcion :se Realizo el analisis y cambio de la razon de calculo del vuelto en el caso de la venta rapida considerando descuentos
  -------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:28/04/2023, Codigo: 
  Descripcion: Se modifico la funcion enviar_correo para obtener los datos del servidor de correo desde la db
   -------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja      Fecha: 15/05/2023     Codigo: GAN-MS-A6-0467
  Descripcion : Se añadieron las funciones mostrar_stock_total y mostrar_precios_total 
    */
defined('BASEPATH') or exit('No direct script access allowed');

class C_venta_facturada extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('venta/M_venta_facturada', 'ventaFacturada');
    $this->load->library('Pdf');
    $this->load->library('Ciqrcode');
    $this->load->library('Facturacion');
    $this->load->helper(array('email'));
    $this->load->library(array('email'));
    $this->load->helper('url');
  }

  public function index()
  {
    if ($this->session->userdata('login')) {
      $log['permisos'] = $this->session->userdata('permisos');
      $usr = $this->session->userdata('usuario');
      $data['producto'] = $this->ventaFacturada->mostrar();
      $data['contador'] = $this->ventaFacturada->contador_pedidos($usr);
      $data['metodo_pago'] = $this->ventaFacturada->listar_tipos_venta();
      $data['docs_identidad'] = $this->ventaFacturada->lts_docs_identidad();
      $data['cod_estado'] = $this->ventaFacturada->M_cod_estado();
      $data['lib'] = 0;
      $data['datos_menu'] = $log;
      $data['cantidadN'] = $this->general->count_notificaciones();
      $data['lst_noti'] = $this->general->lst_notificacion();
      $data['titulo'] = $this->general->get_ajustes("titulo");
      $data['thema'] = $this->general->get_ajustes("tema");
      $data['descripcion'] = $this->general->get_ajustes("descripcion");
      $data['contenido'] = 'venta/venta_facturada';
      $usrid = $this->session->userdata('id_usuario');
      $data['chatUsers'] = $this->general->chat_users($usrid);
      $data['getUserDetails'] = $this->general->get_user_details($usrid);
      $this->load->view('templates/estructura', $data);
    } else {
      redirect('logout');
    }
  }

  public function C_estado_facturacion()
  {
    $data = $this->ventaFacturada->M_fn_datos_estado_eventos();
    echo json_encode($data);
  }


  /*Inicio*/
  public function C_verificar_ubi_facturacion()
  {
    $data = $this->ventaFacturada->M_verificar_ubi_facturacion();
    if ($data[0]->oboolean == 't') {
      $data = $this->C_verificador_eventos();
    }

    echo json_encode($data);
  }

  function C_verificador_eventos()
  {

    // Obtener los datos de estado de eventos
    $datos_estado       = $this->ventaFacturada->M_fn_datos_estado_eventos();
    $validador_pruebas  = $datos_estado[0]->validador_pruebas;
    $codigo_punto_venta = $datos_estado[0]->codigo_punto_venta;
    $id_sucursal        = $datos_estado[0]->id_sucursal;
    $cod_contingencia   = $datos_estado[0]->cod_contingencia;
    $id_facturacion     = $datos_estado[0]->id_facturacion;
    // Verificar la conexión de impuestos
    $data = $this->C_verificar_conexion_impuestos($validador_pruebas, $id_sucursal);

    if ($cod_contingencia == '0' && $data[0]->oboolean == 't') {
      // Caso 1: Sin contingencia y con comunicación establecida
      $data = array(
        (object) array(
          'oboolean' => 't',
          'omensaje' => 'CON COMUNICACION',
        )
      );
    } elseif ($cod_contingencia == '0' && $data[0]->oboolean == 'f') {
      // Caso 2: Sin contingencia y se pérdio la comunicación
      $cod_evento_significativo = 2; // Codigo de Inaccesibilidad al Servicio Web de la Administración Tributaria.
      $descripcion_evento = 'INACCESIBILIDAD AL SERVICIO WEB DE LA ADMINISTRACION TRIBUTARIA';
      $data = $this->ventaFacturada->M_registrar_estado_evento_inicio($codigo_punto_venta, $id_facturacion, $id_sucursal, $cod_evento_significativo, $descripcion_evento);
    } elseif ($cod_contingencia != '0' && $data[0]->oboolean == 't') {
      // Caso 3: Con contingencia y comunicación recuperada
      $cod_evento_significativo = 0; // Codigo de estado en linea.
      $descripcion_evento = '';
      $data = $this->ventaFacturada->M_registrar_estado_evento_inicio($codigo_punto_venta, $id_facturacion, $id_sucursal, $cod_evento_significativo, $descripcion_evento);
      $data = $this->C_registrar_evento_fin($id_facturacion, $id_sucursal, $codigo_punto_venta);

      if ($data[0]->oboolean == 't') {
        $id_evento = $data[0]->omensaje;
        $data = $this->C_empaquetar_validar_facturas($id_evento, $id_facturacion, $id_sucursal, $codigo_punto_venta);
      }
    } elseif ($cod_contingencia != '0' && $data[0]->oboolean == 'f') {
      // Caso 4: Con contingencia y comunicación aún perdida
      $data = array(
        (object) array(
          'oboolean' => 'f',
          'omensaje' => 'COMUNICACION AUN PERDIDA',
        )
      );
    }

    return $data;
  }

  function C_verificar_conexion_impuestos($validador_pruebas, $id_sucursal)
  {
    if ($validador_pruebas == 't') {
      $facturacion    = $this->ventaFacturada->M_informacion_facturacion($id_sucursal);
      $data = $this->C_verificar_conexion($facturacion);
    } else {
      $data = array(
        (object) array(
          'oboolean' => 'f',
          'omensaje' => 'SIN COMUNICACION',
        )
      );
    }

    return $data;
  }

  function C_verificar_conexion($facturacion)
  {
    $Codigos                        = new Codigos($facturacion);
    $verificarComunicacionCodigos   = $Codigos->verificarComunicacion();

    if ($verificarComunicacionCodigos['success']) {
      $response       = json_decode($verificarComunicacionCodigos['response']);
      if ($response->RespuestaComunicacion->transaccion) {
        $data = array(
          (object) array(
            'oboolean' => 't',
            'omensaje' => $response->RespuestaComunicacion->mensajesList->descripcion,
          )
        );
      } else {
        $data = array(
          (object) array(
            'oboolean' => 'f',
            'omensaje' => $response->RespuestaComunicacion->mensajesList->descripcion,
          )
        );
        return $data;
        exit();
      }
    } else {
      $data = array(
        (object) array(
          'oboolean' => 'f',
          'omensaje' => 'No se pudo conectar con el sistema de facturacion - Codigos',
        )
      );
      return $data;
      exit();
    }

    $FacturacionCompraVenta                       = new FacturacionCompraVenta($facturacion);
    $verificarComunicacionFacturacionCompraVenta  = $FacturacionCompraVenta->verificarComunicacion();

    if ($verificarComunicacionFacturacionCompraVenta['success']) {
      $response       = json_decode($verificarComunicacionFacturacionCompraVenta['response']);
      if ($response->return->transaccion) {
        $data = array(
          (object) array(
            'oboolean' => 't',
            'omensaje' => 'COMUNICACION EXITOSA',
          )
        );
      } else {
        $data = array(
          (object) array(
            'oboolean' => 'f',
            'omensaje' => 'SIN COMUNICACION',
          )
        );
        return $data;
        exit();
      }
    } else {
      $data = array(
        (object) array(
          'oboolean' => 'f',
          'omensaje' => 'No se pudo conectar con el sistema de facturacion - FacturacionCompraVenta',
        )
      );
      return $data;
      exit();
    }

    $Operaciones                       = new Operaciones($facturacion);
    $verificarComunicacionOperaciones  = $Operaciones->verificarComunicacion();

    if ($verificarComunicacionOperaciones['success']) {
      $response       = json_decode($verificarComunicacionOperaciones['response']);
      if ($response->return->transaccion) {
        $data = array(
          (object) array(
            'oboolean' => 't',
            'omensaje' => $response->return->mensajesList->descripcion,
          )
        );
      } else {
        $data = array(
          (object) array(
            'oboolean' => 'f',
            'omensaje' => $response->return->mensajesList->descripcion,
          )
        );
        return $data;
        exit();
      }
    } else {
      $data = array(
        (object) array(
          'oboolean' => 'f',
          'omensaje' => 'No se pudo conectar con el sistema de facturacion - Operaciones',
        )
      );
      return $data;
      exit();
    }

    $Sincronizacion                       = new Sincronizacion($facturacion);
    $verificarComunicacionSincronizacion  = $Sincronizacion->verificarComunicacion();

    if ($verificarComunicacionSincronizacion['success']) {
      $response       = json_decode($verificarComunicacionSincronizacion['response']);
      if ($response->return->transaccion) {
        $data = array(
          (object) array(
            'oboolean' => 't',
            'omensaje' => $response->return->mensajesList->descripcion,
          )
        );
      } else {
        $data = array(
          (object) array(
            'oboolean' => 'f',
            'omensaje' => $response->return->mensajesList->descripcion,
          )
        );
        return $data;
        exit();
      }
    } else {
      $data = array(
        (object) array(
          'oboolean' => 'f',
          'omensaje' => 'No se pudo conectar con el sistema de facturacion - Sincronizacion',
        )
      );
      return $data;
      exit();
    }

    return $data;
  }

  function C_registrar_evento_fin($id_facturacion, $id_sucursal, $cod_punto_venta)
  {

    $datos_estado_evento = $this->ventaFacturada->M_datos_evento('PRE-ANULADO', $id_facturacion, $id_sucursal, $cod_punto_venta);

    $codigoMotivoEvento = $datos_estado_evento[0]->cod_evento;
    $descripcion        = $datos_estado_evento[0]->descripcion;

    $fechaHoraInicioEvento = $datos_estado_evento[0]->feccre;
    $fechaHoraInicioEvento = str_replace(' ', 'T', $fechaHoraInicioEvento);

    $fechaHoraFinEvento     = $datos_estado_evento[0]->fecmod;
    $fechaHoraFinEvento     = str_replace(' ', 'T', $fechaHoraFinEvento);

    $facturacion = $this->ventaFacturada->M_datos_facturacion();

    $this->C_generar_cufd_evento($id_facturacion, $cod_punto_venta, $id_sucursal, $facturacion[0]->cod_cuis);

    $cufdEvento = $this->ventaFacturada->M_datos_cufd($cod_punto_venta, $id_sucursal, 'PRE-ACTIVO');
    $cufdActivo = $this->ventaFacturada->M_datos_cufd($cod_punto_venta, $id_sucursal, 'ACTIVO');

    $arrayEvento = array(
      'descripcion'           => trim($descripcion),
      'cuis'                  => $facturacion[0]->cod_cuis,
      'codigoPuntoVenta'      => $cod_punto_venta,
      'cufdEvento'            => $cufdEvento[0]->cod_cufd,
      'codigoMotivoEvento'    => $codigoMotivoEvento,
      'cufd'                  => $cufdActivo[0]->cod_cufd,
      'fechaHoraInicioEvento' => $fechaHoraInicioEvento,
      'fechaHoraFinEvento'    => $fechaHoraFinEvento,
    );

    $Operaciones                = new Operaciones($facturacion);
    $respons                    = $Operaciones->registroEventoSignificativo($arrayEvento);

    $success        = $respons['success'];
    if ($success) {
      //$respons      = json_decode(json_encode($respons));
      $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
      if ($response->RespuestaListaEventos->transaccion) {
        $codigoRecepcion  = $response->RespuestaListaEventos->codigoRecepcionEventoSignificativo;
        $idCufdEvento = $cufdEvento[0]->id_cufd;
        $array = array(
          "id_tipo_evento" => $codigoMotivoEvento,
          "codigo" => $codigoRecepcion,
          "fecini" => $fechaHoraInicioEvento,
          "fecfin" => $fechaHoraFinEvento,
          "tipo_contigencia" => 1,
          "id_cufd" => $idCufdEvento,
          "id_facturacion" => $id_facturacion,
          "id_sucursal" => $id_sucursal,
          "cod_punto_venta" => $cod_punto_venta,
        );

        $json = json_encode($array);

        $data = $this->ventaFacturada->M_registrar_evento($json);
      } else {
        $data = array(
          (object) array(
            'oboolean' => 'f',
            'omensaje' => $response->RespuestaListaEventos->mensajesList->descripcion,
          )
        );
      }
    } else {
      $data = array(
        (object) array(
          'oboolean' => 'f',
          'omensaje' => $respons['error'],
        )
      );
    }

    return $data;
  }

  function C_generar_cufd_evento($id_facturacion, $id_punto_venta, $id_sucursal, $cod_cuis)
  {
    // Valores
    date_default_timezone_set('America/La_Paz');
    $feccre         = date('Y-m-d H:i:s.v');
    $facturacion    = $this->ventaFacturada->M_informacion_facturacion($id_sucursal);
    $Codigos        = new Codigos($facturacion);
    $respons        = $Codigos->solicitudCufd($cod_cuis, $id_punto_venta);
    $success        = $respons['success'];
    if ($success) {
      //$respons      = json_decode(json_encode($respons));
      $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
      if ($response->RespuestaCufd->transaccion) {
        $array_cufd = array(
          'codpuntoventa' => $id_punto_venta,
          'cufd'          => $response->RespuestaCufd->codigo,
          'idfacturacion' => $id_facturacion,
          'idsucursal'    => $id_sucursal,
          'codcontrol'    => $response->RespuestaCufd->codigoControl,
          'direccion'     => $response->RespuestaCufd->direccion,
          'feccre'        => $feccre,
          'fecven'        => $response->RespuestaCufd->fechaVigencia,
        );
        $json_cufd = json_encode($array_cufd);
        $data = $this->ventaFacturada->M_registrar_cufd($json_cufd);
      } else {
        $data = array(
          (object) array(
            'oboolean' => 'f',
            'omensaje' => $response->RespuestaCufd->mensajesList->descripcion,
          )
        );
      }
    } else {
      $data = array(
        (object) array(
          'oboolean' => 'f',
          'omensaje' => $respons['error'],
        )
      );
    }
    return $data;
  }

  function C_empaquetar_validar_facturas($id_evento, $id_facturacion, $id_sucursal, $codigo_punto_venta)
  {

    $datos_evento = $this->ventaFacturada->M_datos_fecha_evento($id_evento);
    $codigoRecepcion = $datos_evento[0]->codigo;
    $fechaHoraInicio = $datos_evento[0]->fecini;
    $fechaHoraFin    = $datos_evento[0]->fecfin;

    // parte 1
    $tipofacturadocumento = 1;
    $codigodocumentosector = 1;

    $lts_data = $this->ventaFacturada->M_lts_reporte_facturas($fechaHoraInicio, $fechaHoraFin, $tipofacturadocumento, $codigodocumentosector, $id_facturacion, $id_sucursal, $codigo_punto_venta);
    if (count($lts_data) !== 0) {
      $data = $this->C_emitir_paquete($id_evento, $codigoRecepcion, $codigodocumentosector, $lts_data, $id_facturacion, $id_sucursal, $codigo_punto_venta);
    } else {
      $data = array(
        (object) array(
          'oboolean' => 't',
          'omensaje' => 'No se cuenta facturas que validar',
        )
      );
    }
    $this->ventaFacturada->M_validar_paquete('VALIDADA', $id_evento);
    return $data;
  }

  function C_emitir_paquete($id_evento, $codigoRecepcionEvento, $codigoDocumentoSector, $tabla, $id_facturacion, $id_sucursal, $codigo_punto_venta)
  {

    $facturacion = $this->ventaFacturada->M_datos_facturacion();

    if ($facturacion[0]->cod_modalidad == '1') {

      $descripcion_evento = 'INACCESIBILIDAD AL SERVICIO WEB DE LA ADMINISTRACION TRIBUTARIA';

      $nro    = 0;
      $files  = glob(FCPATH . 'assets/facturasfirmadasxml/tar/*.xml');

      // vaciamos la carpeta tar
      $files = glob(FCPATH . 'assets/facturasfirmadasxml/tar/*.xml'); //obtenemos todos los nombres de los ficheros
      foreach ($files as $file) {
        if (is_file($file))
          unlink($file); //elimino el fichero
      }
      // vaciamos la carpeta tar
      $files = glob(FCPATH . 'assets/facturasfirmadasxml/targz/*.tar'); //obtenemos todos los nombres de los ficheros
      foreach ($files as $file) {
        if (is_file($file))
          unlink($file); //elimino el fichero
      }

      // guardamos nuevos valores a la carpeta tar
      $array_facturas = array();
      foreach ($tabla as $value) {
        $nro++;
        $archivo = $value->archivo;
        $array_facturas[] = $value->id_factura;
        $from = FCPATH . 'assets/facturasfirmadasxml/' . $archivo;
        $to = FCPATH . 'assets/facturasfirmadasxml/tar/' . $archivo;
        copy($from, $to);
      }

      $tarfile = "assets/facturasfirmadasxml/targz/comprimido.tar";
      $pd = new \PharData($tarfile);

      $pd->buildFromDirectory(FCPATH . 'assets/facturasfirmadasxml/tar');
      //$pd->compress(\Phar::GZ);
      $path = FCPATH . 'assets/facturasfirmadasxml/targz/comprimido.tar';

      date_default_timezone_set('America/La_Paz');
      $feccre = date('Y-m-d H:i:s.v');
      $feccre = str_replace(" ", "T", $feccre);

      $this->ventaFacturada->M_facturas_empaquetadas($id_evento, json_encode($array_facturas));
      $FacturacionCompraVenta   = new FacturacionCompraVenta($facturacion);
      $respons                  = $FacturacionCompraVenta->recepcionPaqueteFactura($descripcion_evento, $codigoRecepcionEvento, $nro, $path, $feccre, $codigoDocumentoSector);
      $success                  = $respons['success'];
      if ($success) {
        $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
        if ($response->RespuestaServicioFacturacion->transaccion) {
          $codigoRecepcion  = $response->RespuestaServicioFacturacion->codigoRecepcion;
          $respons             = $FacturacionCompraVenta->validacionRecepcionPaqueteFactura($codigoRecepcion, $codigoDocumentoSector);
          $success                  = $respons['success'];
          if ($success) {
            $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            if ($response->RespuestaServicioFacturacion->transaccion) {
              $codigoRecepcion  = $response->RespuestaServicioFacturacion->codigoRecepcion;
              $data               = $this->ventaFacturada->M_validar_empaquetados($codigoRecepcion, $id_evento, $codigoDocumentoSector, $id_facturacion, $id_sucursal, $codigo_punto_venta);
            } else {
              $data = array(
                (object) array(
                  'oboolean' => 'f',
                  'omensaje' => $response->RespuestaServicioFacturacion,
                )
              );
            }
          } else {
            $data = array(
              (object) array(
                'oboolean' => 'f',
                'omensaje' => $respons['error'],
              )
            );
          }
        } else {
          $data = array(
            (object) array(
              'oboolean' => 'f',
              'omensaje' => $response->RespuestaServicioFacturacion,
            )
          );
        }
      } else {
        $data = array(
          (object) array(
            'oboolean' => 'f',
            'omensaje' => $respons['error'],
          )
        );
      }
    } else {
      $descripcion_evento = 'INACCESIBILIDAD AL SERVICIO WEB DE LA ADMINISTRACION TRIBUTARIA';

      $nro    = 0;
      $files  = glob(FCPATH . 'assets/facturasxml/tar/*.xml');

      // vaciamos la carpeta tar
      $files = glob(FCPATH . 'assets/facturasxml/tar/*.xml'); //obtenemos todos los nombres de los ficheros
      foreach ($files as $file) {
        if (is_file($file))
          unlink($file); //elimino el fichero
      }
      // vaciamos la carpeta tar
      $files = glob(FCPATH . 'assets/facturasxml/targz/*.tar'); //obtenemos todos los nombres de los ficheros
      foreach ($files as $file) {
        if (is_file($file))
          unlink($file); //elimino el fichero
      }

      // guardamos nuevos valores a la carpeta tar
      $array_facturas = array();
      foreach ($tabla as $value) {
        $nro++;
        $archivo = $value->archivo;
        $array_facturas[] = $value->id_factura;
        $from = FCPATH . 'assets/facturasxml/' . $archivo;
        $to = FCPATH . 'assets/facturasxml/tar/' . $archivo;
        copy($from, $to);
      }

      $tarfile = "assets/facturasxml/targz/comprimido.tar";
      $pd = new \PharData($tarfile);

      $pd->buildFromDirectory(FCPATH . 'assets/facturasxml/tar');
      //$pd->compress(\Phar::GZ);
      $path = FCPATH . 'assets/facturasxml/targz/comprimido.tar';

      date_default_timezone_set('America/La_Paz');
      $feccre = date('Y-m-d H:i:s.v');
      $feccre = str_replace(" ", "T", $feccre);

      $this->ventaFacturada->M_facturas_empaquetadas($id_evento, json_encode($array_facturas));
      $FacturacionCompraVenta   = new FacturacionCompraVenta($facturacion);
      $respons                  = $FacturacionCompraVenta->recepcionPaqueteFactura($descripcion_evento, $codigoRecepcionEvento, $nro, $path, $feccre, $codigoDocumentoSector);
      $success                  = $respons['success'];
      if ($success) {
        $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
        if ($response->RespuestaServicioFacturacion->transaccion) {
          $codRecepcion  = $response->RespuestaServicioFacturacion->codigoRecepcion;
          $respons             = $FacturacionCompraVenta->validacionRecepcionPaqueteFactura($codRecepcion, $codigoDocumentoSector);
          $success                  = $respons['success'];
          if ($success) {
            $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            if ($response->RespuestaServicioFacturacion->transaccion) {
              $codigoRecepcion  = $response->RespuestaServicioFacturacion->codigoRecepcion;
              $data               = $this->ventaFacturada->M_validar_empaquetados($codigoRecepcion, $id_evento, $codigoDocumentoSector, $id_facturacion, $id_sucursal, $codigo_punto_venta);
            } else {
              $data = array(
                (object) array(
                  'oboolean' => 'f',
                  'omensaje' => $response->RespuestaServicioFacturacion,
                )
              );
            }
          } else {
            $data = array(
              (object) array(
                'oboolean' => 'f',
                'omensaje' => $respons['error'],
              )
            );
          }
        } else {
          $data = array(
            (object) array(
              'oboolean' => 'f',
              'omensaje' => $response->RespuestaServicioFacturacion,
            )
          );
        }
      } else {
        $data = array(
          (object) array(
            'oboolean' => 'f',
            'omensaje' => $respons['error'],
          )
        );
      }
    }
    return $data;
  }
  /*Fin*/
  public function mostrar_produc()
  {
    $data = $this->ventaFacturada->mostrar();
    echo json_encode($data);
  }
  public function lst_tipo_venta()
  {
    $data = $this->ventaFacturada->listar_tipos_venta();
    echo json_encode($data);
  }
  public function datos_producto()
  {
    $id_producto = $this->input->post('buscar');
    $data = $this->ventaFacturada->get_datos_producto($id_producto);
    echo json_encode($data);
  }
  public function cantidad_producto()
  {
    $id_venta = $this->input->post('dato1');
    $cantidad = $this->input->post('dato2');
    $data = $this->ventaFacturada->cantidad_producto($id_venta, $cantidad);
    echo json_encode($data);
  }
  public function cambiar_precio()
  {
    $id_venta = $this->input->post('dato1');
    $monto = $this->input->post('dato2');
    $data = $this->ventaFacturada->cambiar_precio($id_venta, $monto);
    echo json_encode($data);
  }
  public function verificar_cambio_precio()
  {
    $id_venta = $this->input->post('dato1');
    $monto = $this->input->post('dato2');
    $data = $this->ventaFacturada->verificar_cambio_precio($id_venta, $monto);
    echo json_encode($data);
  }
  public function verificar_cambio_precio_total()
  {
    $id_venta = $this->input->post('dato1');
    $monto = $this->input->post('dato2');
    $data = $this->ventaFacturada->verificar_cambio_precio_total($id_venta, $monto);
    echo json_encode($data);
  }
  public function verifica_cantidad()
  {
    $id_venta = $this->input->post('dato1');
    $cantidad = $this->input->post('dato2');
    $data = $this->ventaFacturada->verifica_cantidad($id_venta, $cantidad);
    echo json_encode($data);
  }
  public function cambio_precio_uni()
  {
    $id_venta = $this->input->post('dato3');
    $monto = $this->input->post('dato4');
    $data = $this->ventaFacturada->cambio_precio_uni($id_venta, $monto);
    echo json_encode($data);
  }
  public function dlt_pedido()
  {
    $id_ped = $this->input->post("buscar");
    $ped_delete = $this->ventaFacturada->delete_pedido($id_ped);
    echo json_encode($ped_delete);
  }
  public function calcular_cambio()
  {
    $descuento = $this->input->post('descuento');
    $id_tipo = $this->input->post('id_tipo');
    $pagado = $this->input->post('pagado');
    $cambio = $this->ventaFacturada->calcular_cambio($id_tipo, $pagado, $descuento);
    echo json_encode($cambio);
  }
  public function mostrar_stock_total()
  {
    $codigo = $this->input->post('dato1');
    $data = $this->ventaFacturada->mostrar_stock_total($codigo);
    echo json_encode($data);
  }
  public function mostrar_precios_total()
  {
    $codigo = $this->input->post('dato1');
    $data = $this->ventaFacturada->mostrar_precios_total($codigo);
    echo json_encode($data);
  }
  public function relizar_cobro()
  {
    $id_venta = $this->ventaFacturada->mostrar();
    $id_vent = $id_venta[0]->oidventa;
    $nit = $this->input->post('valor_nit') . "";
    $tipo = $this->input->post('tipo');
    $cobro = $this->ventaFacturada->realizar_cobro($tipo, $nit);
    $array_cobro = array(
      'oestado' => $cobro[0]->oestado,
      'omensaje' => $cobro[0]->omensaje,
      'idventa' => $id_vent,
    );
    echo "[" . json_encode($array_cobro) . "]";
  }
  public function mostrar_nit()
  {
    $nit = $this->ventaFacturada->mostrar_nit();
    echo json_encode($nit);
  }
  public function verifica_cliente()
  {
    $nit = $this->input->post('valor_nit') . "";
    $valor = $this->ventaFacturada->verifica_cliente($nit);
    echo json_encode($valor);
  }
  public function C_registrar_cliente()
  {

    $docs_identidad = $this->input->post('docs_identidad');
    $id_documento = $this->ventaFacturada->M_id_documento($docs_identidad);

    //Agrupar las variables relacionadas en un arreglo
    $data = array(
      'id_cliente'    => 0,
      'nombres'       => $this->input->post('razonSocial'),
      'apellidos'     => '',
      'tipo_documento' => $id_documento[0]->id_catalogo,
      'documento'     => $this->input->post('valor_nit'),
      'valid_docs'    => 'false',
      'valid_excep'   => 'false',
      'correo'        => '',
      'movil'         => '',
      'direccion'     => '',
      'descripcion'   => '',
      'latitud'       => '0',
      'longitud'      => '0',
      'id_ubicacion'  => $this->session->userdata('ubicacion'),
    );

    $data = $this->ventaFacturada->M_registrar_cliente(json_encode($data));

    echo json_encode($data);
  }
  public function mostrar_lts_nombre()
  {
    $nombre = $this->ventaFacturada->mostrar_lts_nombre();
    echo json_encode($nombre);
  }
  public function mostrar_nit_usuario()
  {

    $nit = $this->input->post('buscar');

    $partes = explode("-", $nit, 2);
    $partes[0] = trim($partes[0]);
    $partes[1] = trim($partes[1]);

    $data = $this->ventaFacturada->mostrar_datos_cliente($partes[1]);

    echo json_encode($data);
  }
  public function mostrar_nit_usuario_nom()
  {

    $nombre = $this->input->post('buscar');

    $data = $this->ventaFacturada->mostrar_datos_cliente_nom($nombre);

    echo json_encode($data);
  }
  public function mostrar_codigo()
  {
    $codigo = $this->ventaFacturada->mostrar_codigo();
    echo json_encode($codigo);
  }
  public function mostrar_nombre()
  {
    $nit = $this->input->post('buscar');
    // $nombre = $this->ventaFacturada->mostrar_nombre($nit);
    // $complemento = $this->ventaFacturada->mostrar_complemento($nit);
    // $cod_excepcion = $this->ventaFacturada->mostrar_cod_excepcion($nit);
    // echo json_encode(array('nombre'=>$nombre,'complemento'=>$complemento,'cod_excepcion'=>$cod_excepcion));

    $data = $this->ventaFacturada->mostrar_datos_cliente($nit);
    echo json_encode($data);
  }
  public function mostrar_producto()
  {
    $nombre = $this->ventaFacturada->mostrar_producto();
    echo json_encode($nombre);
  }
  public function datos_nombre()
  {
    $nombre = $this->input->post('buscar');
    $data = $this->ventaFacturada->get_datos_nombre($nombre);
    echo json_encode($data);
  }

  function get_parametricas_cmb()
  {
    $id_venta         = $this->ventaFacturada->get_parametricas_cmb();
    print_r($id_venta);
  }


  function obtenerPorcentaje($cantidad, $total)
  {
    $porcentaje = ((float)$cantidad * 100) / $total; // Regla de tres
    $porcentaje = round($porcentaje, 0);  // Quitar los decimales
    return $porcentaje;
  }

  // function verificar_nit()
  // {

  //   $id_usuario = $this->session->userdata('id_usuario');
  //   //$datos_punto_venta=$this->ventaFacturada->get_codigos_siat($id_usuario);
  //   $nitVerificar = $this->input->post('nit');

  //   //$codigo = new Codigos($token,$codigoAmbiente,$codigoSistema,$nit,$codigoSucursal,$codigoModalidad);
  //   $facturacion    = $this->ventaFacturada->datos_facturacion();
  //   $lib_Codigo     = new Codigos($facturacion);


  //   $codigoPuntoVenta   = $facturacion[0]->cod_punto_venta;
  //   $cuis               = $facturacion[0]->cod_cuis;

  //   echo $lib_Codigo->solicitud_verificar_nit($cuis, $codigoPuntoVenta, $nitVerificar);
  // }

  function registrar_factura()
  {
    date_default_timezone_set('America/La_Paz');

    $usuario          = $this->session->userdata('usuario');
    $id_venta         = $this->ventaFacturada->id_venta($usuario);
    $id_venta         = $id_venta[0]->id_venta;
    $descuento        = $this->input->post('descuento');
    $pago_efectivo    = $this->input->post('pago_efectivo');
    $pago_tarjeta     = $this->input->post('pago_tarjeta');
    $pago_gift        = $this->input->post('pago_gift');
    $pago_otros       = $this->input->post('pago_otros');
    $montoTasa        = $this->input->post('monto_tasa');
    $numeroTarjeta    = $this->input->post('nro_tarjeta');

    $datos = array(
      'idventa'        => $id_venta,
      'efectivo'       => $pago_efectivo,
      'tarjeta'        => $pago_tarjeta,
      'gift'           => $pago_gift,
      'otros'          => $pago_otros,
      'descuento'      => $descuento
    );

    $datos_venta        = $this->ventaFacturada->datos_venta(json_encode($datos));


    $lstas_datos_venta  = json_decode($datos_venta[0]->fn_datos_venta);

    // valores que se deberian recuperar con el documento de identidad
    $nombre_rsocial   = $this->input->post('razonSocial');
    $ci_nit_completo           = $this->input->post('valor_nit');
    $complemento      = $this->input->post('complemento');
    $codigoExcepcion  = $this->input->post('codigoExcepcion');
    $docs_identidad   = $this->input->post('docs_identidad');
    $lst_pedidos      = $lstas_datos_venta->pedidos;
    $datos            = $this->ventaFacturada->datos_cliente($ci_nit_completo);
    $correo           = $datos[0]->correo;
    $ci_nit           = $datos[0]->nit_ci;
    $cod_cliente      = $datos[0]->cod_cliente;

    // no se deberia guardar nada si no hay correo;
    if (!$correo) {
      $correo = 'No se asigno un correo electronico';
    }

    $nitEmisor            = $lstas_datos_venta->nit_emisor;
    $razonSocialEmisor    = $lstas_datos_venta->rsocial_emisor;
    $municipio            = $lstas_datos_venta->municipio;
    $telefono             = $lstas_datos_venta->telefonoSucursal;
    $direccion            = $lstas_datos_venta->direccion;
    $tipofactura              = $this->input->post('tipofactura');
    $tipofacturadocumento   = '1';
    $codigodocumentosector  = '1';
    if ($tipofactura != 1) {
      $codigodocumentosector = '41';
    }

    $nfactura           = $this->ventaFacturada->nro_factura($id_venta);
    $nfactura           = $nfactura[0]->id_lote;
    $facturacion        = $this->ventaFacturada->datos_facturacion();
    $leyenda            = $this->ventaFacturada->M_lista_leyendas_facturacion();
    // Obtenemos un índice aleatorio de la tabla $leyenda
    $randomIndex = array_rand($leyenda);
    // Utilizamos el índice aleatorio para obtener el elemento correspondiente
    $descripcionleyenda = $leyenda[$randomIndex]->odescripcionleyenda;

    $codigoPuntoVenta   = $facturacion[0]->cod_punto_venta;
    $codigo_control     = $facturacion[0]->cod_control;
    $nit                = $facturacion[0]->nit;
    $codigoSucursal     = $facturacion[0]->cod_sucursal;
    $codigoModalidad    = $facturacion[0]->cod_modalidad;
    $codigoAmbiente     = $facturacion[0]->cod_ambiente;

    $codigoEmision      = $this->ventaFacturada->M_cod_estado();

    if ($codigoEmision[0]->cod_estado == '0') {
      $codigo_emision = 1;
    } else {
      $codigo_emision = 2;
    }

    $DatosCuf = array(
      'Nit'                 => $nit,
      'CodigoSucursal'      => $codigoSucursal,
      'CodigoModalidad'     => $codigoModalidad,
      'CodigoEmision'       => $codigo_emision,
      'TipoFactura'         => $tipofacturadocumento,
      'TipoDocumentoSector' => $codigodocumentosector,
      'CodigoPuntoVenta'    => $codigoPuntoVenta,
      'CodigoControl'       => $codigo_control,
    );

    $codigoCuf = new GeneradorCuf($DatosCuf);
    $ArrayCuf = $codigoCuf->generarCuf($nfactura);
    $success = $ArrayCuf['success'];
    if ($success) {

      $cuf                = $ArrayCuf['cuf'];
      $fechaEnvio         = $ArrayCuf['fecha'];
      $cufd               = $facturacion[0]->cod_cufd;
      $cuf                = $ArrayCuf['cuf'];
      $fechaEnvio         = $ArrayCuf['fecha'];
      $fechaHora          = str_replace(' ', 'T', date('Y-m-d H:i:s.v'));
      $nombre_rsocial     = $nombre_rsocial ?? "SIN NOMBRE";
      $ci_nit             = $ci_nit ?? 777;

      $codigoMetodoPago   = $this->input->post('tipo_documento');
      $codigoMetodoPago   = $this->ventaFacturada->MetodoPago($codigoMetodoPago);

      $codigoMetodoPago   = $codigoMetodoPago[0]->codigo;
      $Cabecera_Array = array(
        'cod_cliente'         => $cod_cliente,
        'nitEmisor'           => $nitEmisor,
        'razonSocialEmisor'   => $razonSocialEmisor,
        'municipio'           => $municipio,
        'telefono'            => $telefono,
        'direccion'           => $direccion,
        'numeroFactura'       => $nfactura,
        'cuf'                 => $cuf,
        'cufd'                => $cufd,
        'cafc'                => '',
        'codigoSucursal'      => $codigoSucursal,
        'codigoPuntoVenta'    => $codigoPuntoVenta,
        'fechaEmision'        => $fechaEnvio,
        'nombreRazonSocial'   => $nombre_rsocial,
        'numeroDocumento'     => $ci_nit,
        'complemento'         => $complemento,
        'codigoExcepcion'     => $codigoExcepcion,
        'docs_identidad'      => $docs_identidad,
        'numeroTarjeta'       => $numeroTarjeta,
        'codigoMetodoPago'    => $codigoMetodoPago,
        'montoTotal'          => number_format(($lstas_datos_venta->subTotal), 2),
        'montoTotalSujetoIva' => number_format(($lstas_datos_venta->total - $montoTasa), 2),
        'montoTotalMoneda'    => number_format(($lstas_datos_venta->subTotal), 2),
        'montoGiftCard'       => number_format($lstas_datos_venta->gift_card, 2),
        'descuentoAdicional'  => number_format($lstas_datos_venta->descuento, 2),
        'usuario'             => $usuario,
        'leyenda'             => $descripcionleyenda
      );

      $xml = new GeneradorXml();
      if ($codigoModalidad == 2) {
        if ($codigodocumentosector == '1') {
          $factura_XML = $xml->CompraVentaComputarizada($Cabecera_Array, $lst_pedidos);
        } else {
          $factura_XML = $xml->CompraVentaTasas($Cabecera_Array, $lst_pedidos, $montoTasa);
        }
      } else {
        if ($codigodocumentosector == '1') {
          $factura_XML = $xml->CompraVentaElectronica($Cabecera_Array, $lst_pedidos);
        } else {
          $factura_XML = $xml->CompraVentaElectronicaTasas($Cabecera_Array, $lst_pedidos, $montoTasa);
        }
      }

      $facturacion_ubicacion = $this->ventaFacturada->datos_ubicacion_facturacion();

      $namefactura = $cuf . '.xml';
      $FacturacionCompraVenta = new FacturacionCompraVenta($facturacion);
      if ($codigo_emision == 1) {
        $tipo   = $this->input->post('tipo_documento');
        $ci_nit = $ci_nit . '';
        $factura_XML = '';
        if ($codigoModalidad == 2) {
          $rutaXml = FCPATH . 'assets/facturasxml/' . $cuf . '.xml';
          $respons      = $FacturacionCompraVenta->solicitudRecepcionFactura($rutaXml, $fechaHora, $codigodocumentosector);
          $success      = $respons['success'];
          $response     = json_decode($respons['response']);
          $respons      = ($response);
        } else {
          $rutaXml = FCPATH . 'assets/facturasfirmadasxml/' . $cuf . '.xml';
          $llaves       = $this->ventaFacturada->M_llaves();
          $privateKey   = $llaves[0]->oprivatekey;
          $publicKey    = $llaves[0]->opublickey;
          $dirs = array(
            'nombreArchivo' => $cuf,
            'privateKeyPem' => $privateKey,
            'publicKeyPem'  => $publicKey,
          );


          $respons      = $FacturacionCompraVenta->firmadorFacturaElectronicaPruebas($dirs);

          $respons      = $FacturacionCompraVenta->solicitudRecepcionFactura($rutaXml, $fechaHora, $codigodocumentosector);
          $success      = $respons['success'];
          $response     = json_decode($respons['response']);
          $respons      = ($response);
        }
        $codigoRecepcion = $respons->RespuestaServicioFacturacion->codigoRecepcion;
        if ($codigoRecepcion) {
          $val = array(
            'id_lote'           => $nfactura,
            'cuf'               => $cuf,
            'codigoRecepcion'   => $codigoRecepcion,
            'namefactura'       => $namefactura,
            'xmlfactura'        => $factura_XML,
            'nombre_rsocial'    => str_replace("'", "''", $nombre_rsocial),
            'numero_documento'  => $ci_nit_completo,
            'correo'            => $correo,
            'total'             => str_replace(',', '', number_format(($lstas_datos_venta->subTotal), 2)),
            'tipofacturadocumento' => $tipofacturadocumento,
            'codigodocumentosector' => $codigodocumentosector,
            'fechaHora'         => $fechaHora,
            'estado'            => 'ACEPTADO',
            'id_facturacion'    => $facturacion[0]->id_facturacion,
            'id_sucursal'       => $facturacion_ubicacion[0]->id_sucursal,
            'cod_punto_venta'   => $facturacion_ubicacion[0]->codigo_punto_venta,
          );
          $cobro  = $this->ventaFacturada->realizar_cobro($tipo, $ci_nit_completo);
          $val = $this->ventaFacturada->M_registrar_factura(json_encode($val));
        }
        $transaccion = false;
      } else {
        $tipo    = $this->input->post('tipo_documento');
        $ci_nit  = $ci_nit . '';
        $factura_XML = '';
        $codigoRecepcion = 'SIN LINEA';

        if ($codigoModalidad != 2) {
          $llaves       = $this->ventaFacturada->M_llaves();
          $privateKey   = $llaves[0]->oprivatekey;
          $publicKey    = $llaves[0]->opublickey;
          $dirs = array(
            'nombreArchivo' => $cuf,
            'privateKeyPem' => $privateKey,
            'publicKeyPem'  => $publicKey,
          );
          $respons      = $FacturacionCompraVenta->firmadorFacturaElectronicaPruebas($dirs);
        };

        $val = array(
          'id_lote'         => $nfactura,
          'cuf'             => $cuf,
          'codigoRecepcion' => $codigoRecepcion,
          'namefactura'     => $namefactura,
          'xmlfactura'      => $factura_XML,
          'nombre_rsocial'  => str_replace("'", "''", $nombre_rsocial),
          'numero_documento' => $ci_nit_completo,
          'correo'          => $correo,
          'total'           => str_replace(',', '', number_format(($lstas_datos_venta->subTotal), 2)),
          'tipofacturadocumento' => $tipofacturadocumento,
          'codigodocumentosector' => $codigodocumentosector,
          'fechaHora' => $fechaHora,
          'estado' => 'PENDIENTE',
          'id_facturacion'    => $facturacion[0]->id_facturacion,
          'id_sucursal'       => $facturacion_ubicacion[0]->id_sucursal,
          'cod_punto_venta'   => $facturacion_ubicacion[0]->codigo_punto_venta,
        );

        $val = $this->ventaFacturada->M_registrar_factura(json_encode($val));
        $cobro   = $this->ventaFacturada->realizar_cobro($tipo, $ci_nit_completo);
        $respons = "SIN CONEXION";
        $transaccion = true;
      }
      $data = array(
        'idventa' => $id_venta,
        'transaccion' => $transaccion,
        'cobro' => json_encode($cobro),
        'val' => json_encode($val),
        'respons'   => json_encode($respons),
        'resources' => json_encode(array('fechaEnvio' => $fechaEnvio, 'cuf' => $cuf)),
      );
    } else {
      $data = array(
        (object) array(
          'oboolean' => 'f',
          'omensaje' => $ArrayCuf['error'],
        )
      );
    }
    echo json_encode($data);
  }

  function pdf_facturacion()
  {
    //===============================================================================
    //  RECUPERAMOS VALORES DE LA VISTA
    //===============================================================================
    $cuf                    = $this->input->post('cuf');
    $xml_open               = simplexml_load_file(FCPATH . 'assets/facturasxml/' . $cuf . '.xml');

    $nitEmisor              = $xml_open->cabecera->nitEmisor . '';
    $numeroFactura          = $xml_open->cabecera->numeroFactura . '';
    $municipio              = $xml_open->cabecera->municipio . '';
    $fechaEmision           = $xml_open->cabecera->fechaEmision . '';
    $nombreRazonSocial      = $xml_open->cabecera->nombreRazonSocial . '';
    $nombreRazonSocial      = $this->xmlEscape($nombreRazonSocial);
    $numeroDocumento        = $xml_open->cabecera->numeroDocumento . '';
    $complemento            = $xml_open->cabecera->complemento . '';
    if ($complemento != '') {
      $docmuentoCompleto = $numeroDocumento . '-' . $complemento;
    } else {
      $docmuentoCompleto = $numeroDocumento;
    }
    $datos_cliente          = $this->ventaFacturada->mostrar_datos_cliente($docmuentoCompleto);
    $codigoCliente          = $xml_open->cabecera->codigoCliente . '';
    $codigoDocumentoSector  = $xml_open->cabecera->codigoDocumentoSector . '';
    $montoTotal             = $xml_open->cabecera->montoTotal . '';
    $descuentoAdicional     = $xml_open->cabecera->descuentoAdicional . '';
    $subTotal               = $montoTotal + $descuentoAdicional;
    $montoGiftCard          = $xml_open->cabecera->montoGiftCard . '';
    $leyenda                = $xml_open->cabecera->leyenda . '';
    $facturacion            = $this->ventaFacturada->datos_facturacion();
    $codigoEmision          = $this->ventaFacturada->M_cod_estado();
    $codigoEmision          = $codigoEmision[0]->cod_estado;
    $montoGiftCard          = $montoGiftCard == '' ? '0.00' : $montoGiftCard;
    $montoTasa              = $xml_open->cabecera->montoTasa !== null ? $xml_open->cabecera->montoTasa . '' : '0.00';
    $repGrafica             = $codigoEmision != '0' ? 'Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido fuera de línea, verifique su envío con su proveedor o en la página web <u>www.impuestos.gob.bo</u>' : 'Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una Modalidad de Facturación en Línea';
    $id_usuario             = $this->session->userdata('id_usuario');
    $id_papel               = $this->general->get_papel_size($id_usuario);
    $codigoAmbiente         = $facturacion[0]->cod_ambiente;
    $codigoModalidad        = $facturacion[0]->cod_modalidad;

    if ($id_papel[0]->oidpapel == 1304) {
      $numeroWidth = 100;
      $cantidadWidth = 62;
      $descripcionWidth = 190;
      $precioWidth = 70;
      $descuentowidth = 72;
      $widthtext2 = 70;
      $widthtotal = 330;
      $qrxy = 100;
      $footer = true;

      $montoTotalSujetoIva  = $xml_open->cabecera->montoTotalSujetoIva . '';
      $montoPagar    = $montoTotalSujetoIva + $montoTasa;

      $txtl =  $xml_open->cabecera->razonSocialEmisor . "\n" .
        'CASA MATRIZ' . "\n" .
        'No. Punto de Venta ' . $xml_open->cabecera->codigoPuntoVenta . "\n" .
        $xml_open->cabecera->direccion . "\n" .
        'Telefono: ' . $xml_open->cabecera->telefono . "\n" .
        $xml_open->cabecera->municipio;

      if ($codigoAmbiente == 1) {
        $kodenya = 'https://siat.impuestos.gob.bo/consulta/QR?nit=' . $nitEmisor . '&cuf=' . $cuf . '&numero=' . $numeroFactura . '&t=2';
      } else {
        $kodenya = 'https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=' . $nitEmisor . '&cuf=' . $cuf . '&numero=' . $numeroFactura . '&t=2';
      }


      $file = 'assets/img/facturas/' . $cuf . '.png';
      QRcode::png(
        $kodenya,
        $outfile = $file,
        $level = QR_ECLEVEL_H,
        $size = 6,
        $margin = 2
      );

      $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('-');

      $titulofactura          = "FACTURA";
      $facsubtitle            = "(Con Derecho A Crédito Fiscal)";

      $pdf->SetTitle("FACTURA");
      $pdf->SetSubject("FACTURA");
      $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
      $pdf->setFooterData(array(0, 75, 146), array(0, 75, 146));
      $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'B', 8));
      $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, 'B', PDF_FONT_SIZE_DATA));
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      $pdf->SetMargins(15, 20, 15);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(15);

      $pdf->SetAutoPageBreak($footer, PDF_MARGIN_BOTTOM);
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      $pdf->setFontSubsetting(true);

      $pdf->setPrintHeader(true);
      $pdf->setPrintFooter(true);

      $pdf->SetFont('helvetica', '', PDF_FONT_SIZE_DATA, '', true);
      $pdf->AddPage('P', PDF_PAGE_FORMAT);

      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter($footer);


      $ajustes            = $this->general->get_ajustes("logo");
      $ajuste             = json_decode($ajustes->fn_mostrar_ajustes);
      $logo               = $ajuste->logo;


      $image_file = 'assets/img/icoLogo/' . $logo;

      $pdf->Image($image_file, 15, 10, 35, 10, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
      $left_column = '<table>
      <tr>
        <td width="300px"></td>
        <td width="100px"><b>NIT:</b></td>
        <td width="100px" align="left">' . $nitEmisor . '</td>
      </tr>
      <tr>
        <td width="300px"></td>
        <td width="100px"><b>Factura N°:</b></td>
        <td width="100px" align="left">' . $numeroFactura . '</td>
      </tr>
      <tr>
        <td width="300px"></td>
        <td width="100px"><b>Cod. Autorización:</b></td>
        <td width="100px" align="left">' . $cuf . '</td>
      </tr>
      </table>';
      $right_column = null;
      $pdf->writeHTML($left_column . $right_column, true, false, false, false, '');
      $pdf->MultiCell(0, 0, $txtl, 0, 'L', 0, 1, '', '', true);
      $pdf->SetFont('helvetica', 'N', 8);
      $pdf->MultiCell(180, 5, "FACTURA", 0, 'C', 0, 1, '', '', true);
      $pdf->MultiCell(180, 5,  $facsubtitle, 0, 'C', 0, 0, '', '', true);


      $tbl = '
      <div>
      <br><br><br>
      <table>
      <tr>
        <td width="140px"><b>FECHA:</b></td>
        <td width="300px">' . str_replace('T', ' ', substr($fechaEmision, 0, -7)) . '</td>
        <td width="82px" align="right"><b>CI/NIT/CEX:    </b></td>
        <td width="100px">' . $numeroDocumento . ' ' . $complemento . '</td>
      </tr>
      <tr>
        <td width="140px"><b>NOMBRE/RAZON SOCIAL:&nbsp;</b></td>
        <td width="300px">' . strtoupper($nombreRazonSocial) . '</td>
        <td width="82px" align="right"><b>COD. CLIENTE:    </b></td>
        <td width="100px">' . $codigoCliente . '</td>
      </tr>
      </table>
      </div>
          ';


      $tbl1 = '
        <table cellpadding="3">
          <tr align="center" style="font-weight: bold;" bgcolor="#E5E6E8">
              <th width="' . $numeroWidth . 'px" border="1"> CÓDIGO PRODUCTO / SERVICIO </th>
              <th width="' . $cantidadWidth . 'px" border="1"> CANTIDAD</th>
              <th width="' . $precioWidth . 'px" border="1"> UNIDAD DE MEDIDA </th>
              <th width="' . $descripcionWidth . 'px" border="1"> DESCRIPCIÓN </th>
              <th width="' . $precioWidth . 'px" border="1"> PRECIO UNITARIO </th>
              <th width="' . $descuentowidth . 'px" border="1"> DESCUENTO </th>
              <th width="' . $precioWidth . 'px" border="1"> SUBTOTAL </th>
          </tr> ';
      $nro = 0;
      $tbl2 = '';
      $unidades         = $this->ventaFacturada->get_parametricas_cmb();
      foreach ($xml_open->detalle as $ped) {
        $nro++;
        $out_descripcion = '';
        foreach ($unidades as $item) {
          if ($item->out_codclas == $ped->unidadMedida) {
            $out_descripcion = $item->out_descripcion;
            break;
          }
        }
        $tbl2 = $tbl2 . '
          <tr>
              <td align="center" border="1">' . $ped->codigoProducto . '</td>
              <td align="center" border="1">' . $ped->cantidad . '</td>
              <td align="center" border="1">' . $out_descripcion . '</td>
              <td border="1">' . $ped->descripcion . '</td>
              <td align="right" border="1">' . $ped->precioUnitario . '&nbsp;&nbsp;&nbsp;</td>
              <td align="right" border="1">' . $ped->montoDescuento . '&nbsp;&nbsp;&nbsp;</td>
              <td align="right" border="1">' . $ped->subTotal . '&nbsp;&nbsp;&nbsp;</td>
          </tr>';
      }
      $convertir = new ConvertidorLetras();
      $letras = $convertir->convertir(number_format(($montoPagar), 2));
      $val = $subTotal - $descuentoAdicional - $montoGiftCard - $montoTasa;
      $cero = '';
      if ($val < 1) {
        $cero = 'CERO';
      }

      $tasas = '';
      if ($codigoDocumentoSector == '41') {
        $tasas = '<tr >
          <td width="' . $widthtotal . '">
          </td>
          <td width="210" align="left"><font><b>MONTO TASA Bs.</b></font></td>
          <td width="88" align="right"><font>' . number_format(($montoTasa), 2) . '&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          </tr>';
      }

      $tbl3 = '</table><br>
          <table>
          <tr>
              <td width="' . $widthtotal . '"></td>
              <td width="210"  align="left">SUBTOTAL Bs.</td>
              <td width="88" align="right">' . number_format($subTotal, 2) . '&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
              <td width="' . $widthtotal . '"></td>
              <td width="210" align="left">DESCUENTO Bs.</td>
              <td width="88" align="right">' . number_format($descuentoAdicional, 2) . '&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
              <td width="' . $widthtotal . '" ></td>
              <td width="210" align="left">TOTAL Bs.</td>
              <td width="88" align="right">' . number_format(($montoTotal), 2) . '&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
              <td width="' . $widthtotal . '">
              </td>
              <td width="210" align="left">MONTO GIFT CARD Bs.</td>
              <td width="88" align="right">' . $montoGiftCard . '&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr >
              <td width="' . $widthtotal . '">
              </td>
              <td width="210" align="left"><b>MONTO A PAGAR Bs.</b></td>
              <td width="88" align="right"><font>' . number_format(($montoPagar), 2) . '&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          </tr>
          ' . $tasas . '
          <tr >
              <td width="' . $widthtotal . '">
              </td>
              <td width="210" align="left"><font><b>IMPORTE BASE CRÉDITO FISCAL Bs.</b></font></td>
              <td width="88" align="right"><font>' . number_format(($montoTotalSujetoIva), 2) . '&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          </tr>
          <tr>
            <td width="500">
            Son: ' . $cero . $letras . '
            </td>
          </tr>
        </table>
        
        ';

      $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');

      $footerText = '<br><table width="100%">
        <tr align="center">
            <td width="80%"><br><b>ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE
            ACUERDO A LEY</b>
            </td>         
            <td rowspan="3"  width="18%" align="right">
            <img src="' . $file . '" width="' . $qrxy . '" height="' . $qrxy . '">
            </td>
        </tr>
        <tr>
            <td align="center" width="80%"><br><br>' . $leyenda . '
            </td>
        </tr>
        <tr>
            <td align="center" width="80%"><br><br>"' . $repGrafica . '"
            </td>
        </tr>
      </table>';
      $pdf->writeHTML($footerText, true, false, false, false, '');


      ob_end_clean();
      $pdf_ruta = $pdf->Output(FCPATH . './assets/facturaspdf/factura_' . $numeroFactura . '.pdf', 'FI');
    } else {


      $dim1 = 210;
      $dim = $dim1 + (count($xml_open->detalle) * 10) + 210;


      //    tamaño carta
      $numeroWidth = 100;
      $cantidadWidth = 62;
      $descripcionWidth = 190;
      $precioWidth = 70;
      $descuentowidth = 72;
      $widthtext2 = 50;
      $widthtotal = 330;
      $qrxy = 100;
      $footer = true;

      $montoTotalSujetoIva  = $xml_open->cabecera->montoTotalSujetoIva . '';
      $montoPagar    = $montoTotalSujetoIva + $montoTasa;

      if ($codigoAmbiente == 1) {
        $kodenya = 'https://siat.impuestos.gob.bo/consulta/QR?nit=' . $nitEmisor . '&cuf=' . $cuf . '&numero=' . $numeroFactura . '&t=1';
      } else {
        $kodenya = 'https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=' . $nitEmisor . '&cuf=' . $cuf . '&numero=' . $numeroFactura . '&t=1';
      }
      $file = 'assets/img/facturas/' . $cuf . '.png';
      QRcode::png(
        $kodenya,
        $outfile = $file,
        $level = QR_ECLEVEL_H,
        $size = 6,
        $margin = 2
      );
      $medidas = array(80, $dim);
      $pdf = new Pdf(PDF_PAGE_ORIENTATION, 'mm', $medidas, true, 'UTF-8', false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('-');

      $pdf->SetTitle("FACTURA");
      $pdf->SetSubject("FACTURA");
      $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
      $pdf->setFooterData(array(0, 75, 146), array(0, 75, 146));
      $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, 'B', 8));
      $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, 'B', PDF_FONT_SIZE_DATA));
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      $pdf->SetMargins(5, 10, 5);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(15);

      $pdf->SetAutoPageBreak($footer, PDF_MARGIN_BOTTOM);
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      $pdf->setFontSubsetting(true);

      $pdf->setPrintHeader(true);
      $pdf->setPrintFooter(true);

      $pdf->SetFont('helvetica', '', PDF_FONT_SIZE_DATA, '', true);
      $pdf->AddPage('P', $medidas);

      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter($footer);

      $txtl = '       ' . $xml_open->cabecera->razonSocialEmisor . '
      CASA MATRIZ' . '
  No. Punto de Venta ' . $xml_open->cabecera->codigoPuntoVenta . '
' . $xml_open->cabecera->direccion . '
    Telefono: ' . $xml_open->cabecera->telefono . '
     ' . $xml_open->cabecera->municipio . '';

      // $image_file = 'assets/img/icoLogo/' . $logo;

      // $pdf->Image($image_file, 15, 10, 35, 10, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
      $left_column = '
      <table>
        <tr>
            <td width="240px" align="center"><b>FACTURA</b></td>
        </tr> 
        <tr>
            <td width="240px" align="center"><b>CON DERECHO A CRÉDITO FISCAL</b><br></td>
        </tr> 
        <tr>
            <td width="240px" align="center">' . $xml_open->cabecera->razonSocialEmisor . '</td>
        </tr> 
        <tr>
            <td width="240px" align="center">CASA MATRIZ</td>
        </tr> 
        <tr>
            <td width="240px" align="center">No. Punto de Venta ' . $xml_open->cabecera->codigoPuntoVenta . '</td>
        </tr> 
        <tr>
            <td width="240px" align="center">' . $xml_open->cabecera->direccion . '</td>
        </tr> 
        <tr>
            <td width="240px" align="center">Telefono: ' . $xml_open->cabecera->telefono . '</td>
        </tr> 
        <tr>
            <td width="240px" align="center">' . $xml_open->cabecera->municipio . '<br></td>
        </tr> 
        <tr>
            <td width="240px" align="center"><b>NIT:</b></td>
        </tr> 
        <tr>
            <td width="240px" align="center">' . $nitEmisor . '</td>
        </tr> 
        <tr>
            <td width="240px" align="center"><b>Factura N°:</b></td>
        </tr> 
        <tr>
            <td width="240px" align="center">' . $numeroFactura . '</td>
        </tr> 
        <tr>
            <td width="240px" align="center"><b>Cod. Autorización:</b></td>
        </tr> 
        <tr>
            <td width="240px" align="center">' . $cuf . '<br></td>
        </tr> 
        <tr>
            <td width="118px" align="right"><b> NOMBRE/RAZON SOCIAL:&nbsp;</b></td>
            <td width="4px" align="right"></td>
            <td width="118px" align="left">' . strtoupper($nombreRazonSocial) . '</td>
        </tr> 
        <tr>
            <td width="118px" align="right"><b> CI/NIT/CEX:&nbsp;</b></td>
            <td width="4px" align="right"></td>
            <td width="118px" align="left">' . $numeroDocumento . ' ' . $complemento . '</td>
        </tr> 
        <tr>
            <td width="118px" align="right"><b> COD. CLIENTE:&nbsp;</b></td>
            <td width="4px" align="right"></td>
            <td width="118px" align="left">' . $codigoCliente . '</td>
        </tr> 
        <tr>
            <td width="118px" align="right"><b> LUGAR Y FECHA DE EMISION:&nbsp;</b></td>
            <td width="4px" align="right"></td>
            <td width="118px" align="left">' . $municipio . ', ' . str_replace('T', ' ', substr($fechaEmision, 0, -7)) . '<br></td>
        </tr> 
      </table>';
      $right_column = null;
      $pdf->writeHTML($left_column . $right_column, true, false, false, false, '');
      $pdf->SetFont('helvetica', 'N', 8);

      $tbl = '';
      $tbl1 = '
      <table>
        <tr align="center" style="font-weight: bold;" bgcolor="#E5E6E8">
            <th width="240px"><b>DETALLE</b></th>
        </tr> ';
      $nro = 0;
      $tbl2 = '';
      $unidades         = $this->ventaFacturada->get_parametricas_cmb();
      foreach ($xml_open->detalle as $ped) :
        $nro++;
        $out_descripcion = '';
        foreach ($unidades as $item) {
          if ($item->out_codclas == $ped->unidadMedida) {
            $out_descripcion = $item->out_descripcion;
            break;
          }
        }
        $tbl2 = $tbl2 . '
        <tr>
            <td align="left" width="240px">' . $ped->codigoProducto . ' - ' . $ped->descripcion . '</td>
        </tr>
        <tr>
            <td align="left" width="240px">  Unidad de Medida: ' . $out_descripcion . '</td>
        </tr>
        <tr>
        <td align="left" width="140px">' . $ped->cantidad . 'x' . $ped->precioUnitario . '-' . $ped->montoDescuento . '</td>
        <td align="right" width="100px">' . $ped->subTotal . '</td>
        </tr>
        ';
      endforeach;
      $convertir = new ConvertidorLetras();
      $letras = $convertir->convertir(number_format(($montoPagar), 2));
      $val = $subTotal - $descuentoAdicional - $montoGiftCard - $montoTasa;
      $cero = '';
      if ($val < 1) {
        $cero = 'CERO';
      }
      $tasas = '';
      if ($codigoDocumentoSector == '41') {
        $tasas = '
          <tr >
            <td width="140px"align="right">(-) MONTO TASA Bs.</td>
            <td width="100px" align="right"><font>' . number_format(($montoTasa), 2) . '</font></td>
          </tr>';
      }

      $tbl3 = '</table><br><br>
        <table>
        <tr>
            <td width="140px" align="right">SUBTOTAL Bs.</td>
            <td width="100px" align="right">' . number_format($subTotal, 2) . '</td>
        </tr>
        <tr>
            <td width="140px" align="right">DESCUENTO Bs.</td>
            <td width="100px" align="right">' . number_format($descuentoAdicional, 2) . '</td>
        </tr>
        <tr>
            <td width="140px" align="right">TOTAL Bs.</td>
            <td width="100px" align="right">' . number_format(($montoTotal), 2) . '</td>
        </tr>
        <tr>
            <td width="140px" align="right">MONTO GIFT CARD Bs.</td>
            <td width="100px" align="right">' . $montoGiftCard . '</td>
        </tr>
        <tr >
            <td width="140px"align="right"><b>MONTO A PAGAR Bs.</b></td>
            <td width="100px" align="right"><font>' . number_format(($montoPagar), 2) . '</font></td>
        </tr>
        ' . $tasas . '
        <tr >
            <td width="140px" align="right"><font><b>IMPORTE BASE CRÉDITO FISCAL Bs.</b></font></td>
            <td width="100px" align="right"><font>' . number_format(($montoTotalSujetoIva), 2) . '</font></td>
        </tr>
        <tr>
          <td width="240px"><br>
          <br>
          Son: ' . $cero . $letras . '
          </td>
        </tr>
      </table>
      
      ';

      $pdf->writeHTML($tbl . $tbl1 . $tbl2 . $tbl3, true, false, false, false, '');

      $footerText = '<br><table>
      <tr align="center">
          <td width="240px"><br><b>ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE
          ACUERDO A LEY</b>
          </td>         
      </tr>
      <tr>
          <td align="center" width="240px"><br><br>' . $leyenda . '
          </td>
      </tr>
      <tr>
          <td align="center" width="240px"><br><br>"' . $repGrafica . '"
          </td>
      </tr>
      <tr>
        <td align="center" width="240px"><br><br><img src="' . $file . '" width="' . $qrxy . '" height="' . $qrxy . '">
        </td>
      </tr>
    </table>';
      $pdf->writeHTML($footerText, true, false, false, false, '');


      ob_end_clean();
      $pdf_ruta = $pdf->Output(FCPATH . './assets/facturaspdf/factura_' . $numeroFactura . '.pdf', 'FI');
    }
    $correo = $datos_cliente[0]->correo;
    $cod_estado = $this->ventaFacturada->cod_estado();
    //$titulo     = $this->ventaFacturada->titulo();
    $cod_estado = $cod_estado[0]->cod_estado;
    //$titulo     = $titulo[0]->otitulo;
    if ($cod_estado == 0 || $cod_estado == 2) {
      if ($correo != '') {
        $this->enviar_correo($correo, $numeroFactura, $cuf, $codigoModalidad);
      }
    }
    exit();
  }

  public function enviar_correo($correo, $numeroFactura, $cuf, $codigoModalidad)
  {
    //Datos del servidor SMTP
    $serv_mail = $this->general->datos_smtp();
    $host = $serv_mail[0]->smtp_host;
    $port = $serv_mail[0]->smtp_port;
    $user = $serv_mail[0]->smtp_user;
    $pass = $serv_mail[0]->smtp_pass;
    $empresa = $serv_mail[0]->descripcion;
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
    $xml_open               = simplexml_load_file(FCPATH . 'assets/facturasxml/' . $cuf . '.xml');

    //Datos del contenido
    $imagenRuta = "https://images.freeimages.com/vhq/images/previews/214/generic-logo-140952.png";
    if ($codigoModalidad == 1) {
      $tituloContenido = "Facturación Electrónica";
    } else {
      $tituloContenido = "Facturación Computarizada";
    }

    $subtituloContenido = "Estimado cliente:";
    $textoContenido = " <p>Adjunto le hacemos llegar el documento con el detalle de la transacción de compra que realizó.</p> <p>Documentos en formatos PDF y XML.</p>";
    $empresaFooter = $xml_open->cabecera->razonSocialEmisor;
    $sedeFooter = "CASA MATRIZ";
    $puntoVentaFooter = $xml_open->cabecera->codigoPuntoVenta;
    $ubicacionFooter = $xml_open->cabecera->direccion;
    $telefonoFooter = $xml_open->cabecera->telefono;
    $municipioFooter = $xml_open->cabecera->municipio;

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
          <p>Agradecemos su preferencia.</p>
          <p class='empresa' style='display: flex;
            justify-content: center;
            text-align: center;
            font-size:20px;
            color:" . $color . ";'>
            " . $empresaFooter . "
          </p>
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

    // Configurar los encabezados del correo electrónico
    $this->email->set_mailtype('html');
    //email content
    //$htmlContent = '<h1>Enviando correo de prueba</h1>';
    //$htmlContent .= '<p>Prueba.</p>';
    $this->email->from($user, $empresa);
    // $this->email->from('work.soporte.oso@gmail.com', 'DAO SYSTEMS');
    $this->email->to($correo);
    $this->email->subject('Factura');
    $this->email->attach(FCPATH . 'assets/facturaspdf/factura_' . $numeroFactura . '.pdf');
    if ($codigoModalidad == 1) {
      $this->email->attach(FCPATH . 'assets/facturasfirmadasxml/' . $cuf . '.xml');
    } else {
      $this->email->attach(FCPATH . 'assets/facturasxml/' . $cuf . '.xml');
    }
    $this->email->send();
  }



  function xmlEscape($string)
  {
    return str_replace(array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), array('&', '<', '>', '\'', '"'), $string);
  }
}
