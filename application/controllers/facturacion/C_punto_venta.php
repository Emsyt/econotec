<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_punto_venta extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Facturacion');
        $this->load->model('facturacion/M_punto_venta', 'punto_venta');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $this->session->userdata('id_usuario');
            $data['fecha_imp'] = date('Y-m-d H:i:s');

            $data['lst_sucursales'] = $this->punto_venta->M_listar_sucursales_activos();
            $data['lst_tipo_venta'] = $this->punto_venta->listar_tipo_venta();
            $data['lst_ubicaciones'] = $this->punto_venta->listar_ubicaciones();

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'facturacion/punto_venta';

            $data['chatUsers'] = $this->general->chat_users($usr);
            $data['getUserDetails'] = $this->general->get_user_details($usr);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    public function C_generar_lista_actividades()
    {

        $id_facturacion = $this->input->post('id_facturacion');
        $cod_punto_venta = $this->input->post('cod_punto_venta');
        $id_sucursal = $this->input->post('id_sucursal');
        $data = $this->punto_venta->M_generar_lista_actividades($id_facturacion, $id_sucursal, $cod_punto_venta);
        echo json_encode($data);
    }

    public function C_agregar_actividad()
    {
        $id_facturacion     = $this->input->post('id_facturacion_act');
        $id_sucursal        = $this->input->post('id_sucursal_act');
        $cod_punto_venta    = $this->input->post('cod_punto_venta_act');
        $cod_actividad      = $this->input->post('actividad');


        $array_actividad = array(
            'cod_actividad'     => $cod_actividad,
            'id_facturacion'    => $id_facturacion,
            'id_sucursal'       => $id_sucursal,
            'cod_punto_venta'   => $cod_punto_venta,
        );
        
        $data = $this->punto_venta->M_agregar_actividad(json_encode($array_actividad));
        echo json_encode($data);
    }

    public function C_consultar_punto_venta()
    {
        $id_sucursal        = $this->input->post('id_sucursal');
        $facturacion        = $this->punto_venta->M_informacion_facturacion($id_sucursal);
        $Operaciones        = new Operaciones($facturacion);
        $cuis               = $this->punto_venta->M_datos_cuis(0, $id_sucursal);
        $cuis               = $cuis[0]->cuis;
        $respons            = $Operaciones->consultaPuntoVenta($cuis);
        $success            = $respons['success'];
        if ($success) {
            $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            if ($response->RespuestaConsultaPuntoVenta->transaccion) {
                $data = array(
                    (object) array(
                        'oboolean' => 't',
                        'omensaje' => $response,
                    )
                );
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaConsultaPuntoVenta->mensajesList->descripcion,
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
        echo json_encode($data);
    }

    public function C_gestionar_punto_venta_existente()
    {
        $codigoPuntoVenta = $this->input->post('codigoPuntoVenta');
        $id_sucursal = $this->input->post('id_sucursal');
        $array = array(
            "id_sucursal" => $id_sucursal,
            "codigoPuntoVenta" => $this->input->post('codigoPuntoVenta'),
            "nombrePuntoVenta" => $this->input->post('nombrePuntoVenta'),
            "tipoPuntoVenta"   => $this->input->post('tipoPuntoVenta'),
        );
        $data = $this->punto_venta->M_gestionar_punto_venta_existente(json_encode($array));
        // if ($data[0]->oboolean == 't') {
        //     $data = $this->C_registrar_cuis($codigoPuntoVenta);
        //     if ($data[0]->oboolean == 't') {
        //         $data = $this->C_generar_cufd($codigoPuntoVenta);
        //     }
        // }
        echo json_encode($data);
    }


    function C_registrar_cuis($codigoPuntoVenta)
    {

        $facturacion    = $this->punto_venta->M_informacion_facturacion();
        $id_facturacion = $facturacion[0]->id_facturacion;
        $Codigos        = new Codigos($facturacion);
        $respons        = $Codigos->solicitudCuis($codigoPuntoVenta);
        $success        = $respons['success'];
        if ($success) {
            $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            $codigo         = $response->RespuestaCuis->codigo; // Accede al valor del código
            $fechaVigencia  = $response->RespuestaCuis->fechaVigencia; // Accede al valor del código
            $array = array(
                "id_punto_venta" => $codigoPuntoVenta,
                "id_facturacion" => $id_facturacion,
                "codigo"         => $codigo,
                "fechaVigencia"  => $fechaVigencia,
            );
            $data = $this->punto_venta->M_registrar_cuis(json_encode($array));
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

    public function C_lst_punto_venta()
    {
        $id_sucursal = $this->input->post('id_sucursal');
        $data = $this->punto_venta->M_listar_punto_venta($id_sucursal);
        echo json_encode($data);
    }

    //----
    public function listar_punto_venta_ubicaciones()
    {
        $data = $this->punto_venta->listar_punto_venta_ubicaciones();
        echo json_encode($data);
    }
    public function C_nom_ubicacion()
    {
        $id_ubicacion = $this->input->post('id_ubicacion');
        $data = $this->punto_venta->M_nom_ubicacion($id_ubicacion);
        echo json_encode($data);
    }

    public function cierrePuntoVenta()
    {
        $cod_punto_venta = $this->input->post('cod_punto_venta');
        $id_sucursal = $this->input->post('id_sucursal');
        // Libreria Facturacion - Codigos
        $facturacion    = $this->punto_venta->M_informacion_facturacion($id_sucursal);
        $Operaciones    = new Operaciones($facturacion);

        $cuis               = $this->punto_venta->M_datos_cuis(0, $id_sucursal);
        $cuis               = $cuis[0]->cuis;

        $respons  = $Operaciones->cierrePuntoVenta($cod_punto_venta, $cuis);
        $success                = $respons['success'];
        if ($success) {
            $response           = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            if ($response->RespuestaCierrePuntoVenta->transaccion) {
                $data = $this->punto_venta->eliminar_punto_venta($facturacion[0]->id_facturacion, $cod_punto_venta, $id_sucursal);
                if ($data[0]->fn_eliminar_punto_venta == 't') {
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
                            'omensaje' => 'Error al anular la factura en la bd.',
                        )
                    );
                }
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
        echo json_encode($data);
    }

    public function registrarCierrePuntoVenta()
    {

        $id_facturacion = $this->input->post('id_facturacion');
        $cod_punto_venta = $this->input->post('cod_punto_venta');
        $id_sucursal = $this->input->post('id_sucursal');
        $data = $this->punto_venta->eliminar_punto_venta($id_facturacion, $cod_punto_venta, $id_sucursal);
        echo json_encode($data);
    }

    public function eliminar_ubicacion_punto_venta()
    {
        $id_ubicacion = $this->input->post('id_ubicacion');
        $data = $this->punto_venta->M_eliminar_ubicacion_punto_venta($id_ubicacion);
        echo json_encode($data);
    }

    public function C_registrar_ubicacion_punto_venta($cad)
    {
        $ubicacion = $this->input->post('ubicacion');
        $idSucursal = $this->input->post('lt_sucursal');
        $codigoPuntoVenta = $this->input->post('punto_venta');
        $data = $this->punto_venta->M_registrar_ubicacion_punto_venta($ubicacion, $idSucursal, $codigoPuntoVenta);

        echo json_encode($data);
    }
    public function get_ubicacion()
    {
        $id_ubicacion = $this->input->post('id_ubicacion');
        $data = $this->punto_venta->get_ubicacion($id_ubicacion);
        echo json_encode($data);
    }

    public function add_update_punto_venta()
    {

        // Datos Obtenidos.
        $id_sucursal            = $this->input->post('idsucursal');
        $descripcion            = $this->input->post('descripcion');
        $nombrePuntoVenta       = $this->input->post('nombre');
        $codigoTipoPuntoVenta   = $this->input->post('tipo_venta');

        // Libreria Facturacion - Codigos
        $facturacion            = $this->punto_venta->M_informacion_facturacion($id_sucursal);
        $id_facturacion = $facturacion[0]->id_facturacion;
        $Operaciones            = new Operaciones($facturacion);

        $cuis                   = $this->punto_venta->M_datos_cuis(0, $id_sucursal);
        $cuis                   = $cuis[0]->cuis;

        $respons                = $Operaciones->registroPuntoVenta($cuis, $codigoTipoPuntoVenta, $descripcion, $nombrePuntoVenta);
        $success                = $respons['success'];
        if ($success) {
            $response           = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            $codigoPuntoVenta   = $response->RespuestaRegistroPuntoVenta->codigoPuntoVenta; // Accede al valor del código
            $data               = $this->punto_venta->M_registrar_punto_venta($codigoPuntoVenta, $codigoTipoPuntoVenta, $id_facturacion, $id_sucursal, $descripcion, $nombrePuntoVenta);
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $respons['error'],
                )
            );
        }
        echo json_encode($data);
    }

    function C_generar_cuis()
    {

        $id_facturacion = $this->input->post('id_facturacion');
        $id_punto_venta = $this->input->post('id_punto_venta');
        $id_sucursal = $this->input->post('id_sucursal');

        $facturacion    = $this->punto_venta->M_informacion_facturacion($id_sucursal);
        $Codigos            = new Codigos($facturacion);
        $respons            = $Codigos->solicitudCuis($id_punto_venta);
        $success            = $respons['success'];
        if ($success) {
            $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            $codigo         = $response->RespuestaCuis->codigo; // Accede al valor del código
            $fechaVigencia  = $response->RespuestaCuis->fechaVigencia; // Accede al valor del código
            $array = array(
                "id_punto_venta" => $id_punto_venta,
                "id_facturacion" => $id_facturacion,
                "id_sucursal"    => $id_sucursal,
                "codigo"         => $codigo,
                "fechaVigencia"  => $fechaVigencia,
            );
            $data = $this->punto_venta->M_registrar_cuis(json_encode($array));
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $respons['error'],
                )
            );
        }

        echo json_encode($data);
    }

    function C_generar_cufd()
    {
        // Valores
        date_default_timezone_set('America/La_Paz');
        $feccre         = date('Y-m-d H:i:s.v');
        $id_facturacion = $this->input->post('id_facturacion');
        $id_punto_venta = $this->input->post('id_punto_venta');
        $id_sucursal    = $this->input->post('id_sucursal');
        $cod_cuis       = $this->input->post('cod_cuis');


        $facturacion    = $this->punto_venta->M_informacion_facturacion($id_sucursal);
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
                $data = $this->punto_venta->M_registrar_cufd($json_cufd);
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
        echo json_encode($data);
    }

    function registrar_cuis()
    {
        $array = array(
            "id_punto_venta" => $this->input->post('id_punto_venta'),
            "id_facturacion" => $this->input->post('id_facturacion'),
            "codigo"         => $this->input->post('codigo'),
            "fechaVigencia"  => $this->input->post('fechaVigencia')
        );
        $data = $this->punto_venta->registrar_cuis(json_encode($array));
        echo json_encode($data);
    }

    function C_verificador_eventos()
    {

        // Obtener los datos de estado de eventos
        $datos_estado       = $this->punto_venta->M_fn_datos_estado_eventos();
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
            $data = $this->punto_venta->M_registrar_estado_evento_inicio($codigo_punto_venta, $id_facturacion, $id_sucursal, $cod_evento_significativo, $descripcion_evento);
        } elseif ($cod_contingencia != '0' && $data[0]->oboolean == 't') {
            // Caso 3: Con contingencia y comunicación recuperada
            $cod_evento_significativo = 0; // Codigo de estado en linea.
            $descripcion_evento = '';
            $data = $this->punto_venta->M_registrar_estado_evento_inicio($codigo_punto_venta, $id_facturacion, $id_sucursal, $cod_evento_significativo, $descripcion_evento);
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

        echo json_encode($data);
    }

    function C_empaquetar_validar_facturas($id_evento, $id_facturacion, $id_sucursal, $codigo_punto_venta)
    {

        $datos_evento = $this->punto_venta->M_datos_fecha_evento($id_evento);
        $codigoRecepcion = $datos_evento[0]->codigo;
        $fechaHoraInicio = $datos_evento[0]->fecini;
        $fechaHoraFin    = $datos_evento[0]->fecfin;

        $tipofacturadocumento = 1;
        $codigodocumentosector = 1;

        $lts_data = $this->punto_venta->M_lts_reporte_facturas($fechaHoraInicio, $fechaHoraFin, $tipofacturadocumento, $codigodocumentosector, $id_facturacion, $id_sucursal, $codigo_punto_venta);
        if (count($lts_data) !== 0) {
            $data = $this->C_emitir_paquete($id_evento, $codigoRecepcion, $codigodocumentosector, $lts_data, $id_facturacion, $id_sucursal, $codigo_punto_venta);
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 't',
                    'omensaje' => '',
                )
            );
        }

        $tipofacturadocumento = 1;
        $codigodocumentosector = 41;

        $lts_data = $this->punto_venta->M_lts_reporte_facturas($fechaHoraInicio,$fechaHoraFin,$tipofacturadocumento,$codigodocumentosector, $id_facturacion, $id_sucursal, $codigo_punto_venta);
        if (count($lts_data) !== 0) {
            $data = $this->C_emitir_paquete($id_evento, $codigoRecepcion, $codigodocumentosector, $lts_data, $id_facturacion, $id_sucursal, $codigo_punto_venta);
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 't',
                    'omensaje' => '',
                )
            );
        }
        $this->punto_venta->M_validar_paquete('VALIDADA',$id_evento);
        return $data;
    }

    function C_emitir_paquete($id_evento, $codigoRecepcionEvento, $codigoDocumentoSector, $tabla, $id_facturacion, $id_sucursal, $codigo_punto_venta)
    {

        $facturacion = $this->punto_venta->M_datos_facturacion();

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

            $this->punto_venta->M_facturas_empaquetadas($id_evento, json_encode($array_facturas));
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
                            $data               = $this->punto_venta->M_validar_empaquetados($codigoRecepcion,$id_evento, $id_facturacion, $id_sucursal, $codigo_punto_venta);
                        } else {
                            $data = array(
                                (object) array(
                                    'oboolean' => 'f',
                                    'omensaje' => $response->RespuestaServicioFacturacion->codigoDescripcion,
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
                            'omensaje' => $response->RespuestaServicioFacturacion->codigoDescripcion,
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
        }else {
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

            $this->punto_venta->M_facturas_empaquetadas($id_evento, json_encode($array_facturas));
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
                            $data               = $this->punto_venta->M_validar_empaquetados($codigoRecepcion,$id_evento, $id_facturacion, $id_sucursal, $codigo_punto_venta);
                        } else {
                            $data = array(
                                (object) array(
                                    'oboolean' => 'f',
                                    'omensaje' => $response->RespuestaServicioFacturacion->codigoDescripcion,
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
                            'omensaje' => $response->RespuestaServicioFacturacion->codigoDescripcion,
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

    function C_registrar_evento_fin($id_facturacion, $id_sucursal, $cod_punto_venta)
    {

        $datos_estado_evento = $this->punto_venta->M_datos_evento('PRE-ANULADO', $id_facturacion, $id_sucursal, $cod_punto_venta);

        $codigoMotivoEvento = $datos_estado_evento[0]->cod_evento;
        $descripcion        = $datos_estado_evento[0]->descripcion;

        $fechaHoraInicioEvento = $datos_estado_evento[0]->feccre;
        $fechaHoraInicioEvento = str_replace(' ', 'T', $fechaHoraInicioEvento);

        $fechaHoraFinEvento     = $datos_estado_evento[0]->fecmod;
        $fechaHoraFinEvento     = str_replace(' ', 'T', $fechaHoraFinEvento);

        $facturacion = $this->punto_venta->M_datos_facturacion();

        $this->C_generar_cufd_evento($id_facturacion, $cod_punto_venta, $id_sucursal, $facturacion[0]->cod_cuis);

        $cufdEvento = $this->punto_venta->M_datos_cufd($cod_punto_venta, $id_sucursal, 'PRE-ACTIVO');
        $cufdActivo = $this->punto_venta->M_datos_cufd($cod_punto_venta, $id_sucursal, 'ACTIVO');

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

                $data = $this->punto_venta->M_registrar_evento($json);
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
        $facturacion    = $this->punto_venta->M_informacion_facturacion($id_sucursal);
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
                $data = $this->punto_venta->M_registrar_cufd($json_cufd);
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


    function C_registrar_inicio_evento($codigopuntoventa, $idfacturacion, $idsucursal, $codigoevento, $descripcion)
    {
        $estado = $this->control->M_registrar_estado_evento($codigopuntoventa, $idfacturacion, $idsucursal, $codigoevento, $descripcion);
        echo json_encode($estado);
    }





    function C_verificar_conexion_impuestos($validador_pruebas, $id_sucursal)
    {
        if ($validador_pruebas == 't') {
            $facturacion    = $this->punto_venta->M_informacion_facturacion($id_sucursal);
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


    function C_generar_catalogo()
    {

        $id_facturacion = $this->input->post('id_facturacion');
        $id_punto_venta = $this->input->post('id_punto_venta');
        $id_sucursal    = $this->input->post('id_sucursal');

        $facturacion    = $this->punto_venta->M_credenciales_facturacion($id_punto_venta, $id_sucursal);
        $Codigos        = new Sincronizacion($facturacion);

        $resultados = array();

        $resultados['idfacturacion'] = $id_facturacion;
        $resultados['idsucursal'] = $id_sucursal;
        $resultados['codpuntoventa'] = $id_punto_venta;

        $sincronizarActividades  = $Codigos->sincronizarActividades();
        if ($sincronizarActividades['success']) {
            $response       = json_decode($sincronizarActividades['response']);
            if ($response->RespuestaListaActividades->transaccion) {
                $resultados['sincronizarActividades'] = $sincronizarActividades['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaActividades->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarActividades['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarFechaHora  = $Codigos->sincronizarFechaHora();
        if ($sincronizarFechaHora['success']) {
            $response       = json_decode($sincronizarFechaHora['response']);
            if ($response->RespuestaFechaHora->transaccion) {
                $resultados['sincronizarFechaHora'] = $sincronizarFechaHora['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaFechaHora->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarFechaHora['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarListaActividadesDocumentoSector  = $Codigos->sincronizarListaActividadesDocumentoSector();
        if ($sincronizarListaActividadesDocumentoSector['success']) {
            $response       = json_decode($sincronizarListaActividadesDocumentoSector['response']);
            if ($response->RespuestaListaActividadesDocumentoSector->transaccion) {
                $resultados['sincronizarListaActividadesDocumentoSector'] = $sincronizarListaActividadesDocumentoSector['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaActividadesDocumentoSector->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarListaActividadesDocumentoSector['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarListaLeyendasFactura  = $Codigos->sincronizarListaLeyendasFactura();
        if ($sincronizarListaLeyendasFactura['success']) {
            $response       = json_decode($sincronizarListaLeyendasFactura['response']);
            if ($response->RespuestaListaParametricasLeyendas->transaccion) {
                $resultados['sincronizarListaLeyendasFactura'] = $sincronizarListaLeyendasFactura['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricasLeyendas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarListaLeyendasFactura['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarListaMensajesServicios  = $Codigos->sincronizarListaMensajesServicios();
        if ($sincronizarListaMensajesServicios['success']) {
            $response       = json_decode($sincronizarListaMensajesServicios['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarListaMensajesServicios'] = $sincronizarListaMensajesServicios['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarListaMensajesServicios['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarListaProductosServicios  = $Codigos->sincronizarListaProductosServicios();
        if ($sincronizarListaProductosServicios['success']) {
            $response       = json_decode($sincronizarListaProductosServicios['response']);
            if ($response->RespuestaListaProductos->transaccion) {
                $resultados['sincronizarListaProductosServicios'] = $sincronizarListaProductosServicios['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaProductos->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarListaProductosServicios['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaEventosSignificativos  = $Codigos->sincronizarParametricaEventosSignificativos();
        if ($sincronizarParametricaEventosSignificativos['success']) {
            $response       = json_decode($sincronizarParametricaEventosSignificativos['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaEventosSignificativos'] = $sincronizarParametricaEventosSignificativos['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaEventosSignificativos['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaMotivoAnulacion  = $Codigos->sincronizarParametricaMotivoAnulacion();
        if ($sincronizarParametricaMotivoAnulacion['success']) {
            $response       = json_decode($sincronizarParametricaMotivoAnulacion['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaMotivoAnulacion'] = $sincronizarParametricaMotivoAnulacion['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaMotivoAnulacion['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaPaisOrigen  = $Codigos->sincronizarParametricaPaisOrigen();
        if ($sincronizarParametricaPaisOrigen['success']) {
            $response       = json_decode($sincronizarParametricaPaisOrigen['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaPaisOrigen'] = $sincronizarParametricaPaisOrigen['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaPaisOrigen['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaTipoDocumentoIdentidad  = $Codigos->sincronizarParametricaTipoDocumentoIdentidad();
        if ($sincronizarParametricaTipoDocumentoIdentidad['success']) {
            $response       = json_decode($sincronizarParametricaTipoDocumentoIdentidad['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaTipoDocumentoIdentidad'] = $sincronizarParametricaTipoDocumentoIdentidad['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaTipoDocumentoIdentidad['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaTipoDocumentoSector  = $Codigos->sincronizarParametricaTipoDocumentoSector();
        if ($sincronizarParametricaTipoDocumentoSector['success']) {
            $response       = json_decode($sincronizarParametricaTipoDocumentoSector['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaTipoDocumentoSector'] = $sincronizarParametricaTipoDocumentoSector['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaTipoDocumentoSector['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaTipoEmision  = $Codigos->sincronizarParametricaTipoEmision();
        if ($sincronizarParametricaTipoEmision['success']) {
            $response       = json_decode($sincronizarParametricaTipoEmision['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaTipoEmision'] = $sincronizarParametricaTipoEmision['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaTipoEmision['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaTipoHabitacion  = $Codigos->sincronizarParametricaTipoHabitacion();
        if ($sincronizarParametricaTipoHabitacion['success']) {
            $response       = json_decode($sincronizarParametricaTipoHabitacion['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaTipoHabitacion'] = $sincronizarParametricaTipoHabitacion['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaTipoHabitacion['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaTipoMetodoPago  = $Codigos->sincronizarParametricaTipoMetodoPago();
        if ($sincronizarParametricaTipoMetodoPago['success']) {
            $response       = json_decode($sincronizarParametricaTipoMetodoPago['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaTipoMetodoPago'] = $sincronizarParametricaTipoMetodoPago['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaTipoMetodoPago['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaTipoMoneda  = $Codigos->sincronizarParametricaTipoMoneda();
        if ($sincronizarParametricaTipoMoneda['success']) {
            $response       = json_decode($sincronizarParametricaTipoMoneda['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaTipoMoneda'] = $sincronizarParametricaTipoMoneda['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaTipoMoneda['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaTipoPuntoVenta  = $Codigos->sincronizarParametricaTipoPuntoVenta();
        if ($sincronizarParametricaTipoPuntoVenta['success']) {
            $response       = json_decode($sincronizarParametricaTipoPuntoVenta['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaTipoPuntoVenta'] = $sincronizarParametricaTipoPuntoVenta['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaTipoPuntoVenta['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaTiposFactura  = $Codigos->sincronizarParametricaTiposFactura();
        if ($sincronizarParametricaTiposFactura['success']) {
            $response       = json_decode($sincronizarParametricaTiposFactura['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaTiposFactura'] = $sincronizarParametricaTiposFactura['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaTiposFactura['error'],
                )
            );
            return $data;
            exit();
        }

        $sincronizarParametricaUnidadMedida  = $Codigos->sincronizarParametricaUnidadMedida();
        if ($sincronizarParametricaUnidadMedida['success']) {
            $response       = json_decode($sincronizarParametricaUnidadMedida['response']);
            if ($response->RespuestaListaParametricas->transaccion) {
                $resultados['sincronizarParametricaUnidadMedida'] = $sincronizarParametricaUnidadMedida['response'];
            } else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        } else {
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaUnidadMedida['error'],
                )
            );
            return $data;
            exit();
        }

        $data = $this->punto_venta->M_gestionar_catalogo_facturacion(json_encode($resultados));
        echo json_encode($data);
    }
}
