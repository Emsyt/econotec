<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_configuracion extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->library('Facturacion');
        $this->load->model('facturacion/M_configuracion', 'control');
    }

    public function index(){
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $this->session->userdata('id_usuario');
            $data['fecha_imp'] = date('Y-m-d H:i:s');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'facturacion/configuracion';

            $data['chatUsers'] = $this->general->chat_users($usr);
            $data['getUserDetails'] = $this->general->get_user_details($usr);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    function C_datos_sistema(){
        $data = $this->control->M_datos_sistema();
        echo json_encode($data);
    }

    function C_gestionar_sistema($btn){
        if($this->input->post('modalidad')==1){
            //Si es facturacion electronica se subiran los certificados
            $config['allowed_types'] = 'pem|crt|p12';
            $config['max_size'] = 0; // Puedes establecer un tamaño máximo en bytes, o 0 para deshabilitar la restricción de tamaño.
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] =TRUE;
            $this->load->library('upload', $config);
            // Verificar si se están enviando archivos
            if (!empty($_FILES['archivo_crt']['name'][0])) {
                // Obtener la cantidad de archivos seleccionados
                $extension_crt = $_FILES['archivo_crt']['name'][0];
                $destination = './assets/llaves/' . $extension_crt;
                move_uploaded_file($_FILES['archivo_crt']['tmp_name'][0], $destination);
            }
            if (!empty($_FILES['archivo_pk']['name'][0])) {
                // Obtener la cantidad de archivos seleccionados
                $extension_pk = $_FILES['archivo_pk']['name'][0];
                $destination = './assets/llaves/' . $extension_pk;
                move_uploaded_file($_FILES['archivo_pk']['tmp_name'][0], $destination);
            }
            /* Modificar el nombre en la base de datos */
            $this->control->M_modifcar_crt_pk($extension_crt,$extension_pk);
        }
        //Asignar el valor a la variable $id_cliente utilizando la función ternaria
        $id_facturacion = ($btn == 'add') ? 0 : $this->input->post('id_facturacion');


        $facturacion = array(
            (object) array(
                'cod_token'         => $this->input->post('token'),
                'cod_ambiente'      => $this->input->post('ambiente'),
                'cod_sistema'       => $this->input->post('codigo'),
                'nit'               => $this->input->post('nit'),
                'cod_sucursal'      => 0,
                'cod_modalidad'     => $this->input->post('modalidad'),
            )
        );
        // Antes de guardar verificamos la conexion y solicitud de datos como el CUIS
        $Codigos        = new Codigos($facturacion);
        $puntoVentaInicial  = 0;
        $respons        = $Codigos->solicitudCuis($puntoVentaInicial);
        $success        = $respons['success'];
        if ($success) {
            $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            if ($response->RespuestaCuis->transaccion || $response->RespuestaCuis->mensajesList->codigo == '980') {
                //Agrupar las variables relacionadas en un arreglo
                $data = array(
                    'id_facturacion'    => $id_facturacion,
                    'nit'               => $this->input->post('nit'),
                    'cod_sistema'       => $this->input->post('codigo'),
                    'cod_ambiente'      => $this->input->post('ambiente'),
                    'cod_modalidad'     => $this->input->post('modalidad'),
                    'cod_emision'       => 1,
                    'cod_token'         => $this->input->post('token'),
                    'cod_cafc'          => $this->input->post('cafc'),
                    'cafc_ini'          => $this->input->post('cafc_ini'),
                    'cafc_fin'          => $this->input->post('cafc_fin'),
                    'cod_cafc_tasas'    => $this->input->post('cafc_tasas'),
                    'cafc_tasas_ini'    => $this->input->post('cafc_tasas_ini'),
                    'cafc_tasas_fin'    => $this->input->post('cafc_tasas_fin'),
                    'smtp_host'         => $this->input->post('smtp_host'),
                    'smtp_port'         => $this->input->post('smtp_port'),
                    'smtp_user'         => $this->input->post('smtp_user'),
                    'smtp_pass'         => $this->input->post('smtp_pass')
                );

                $data = $this->control->M_gestionar_sistema(json_encode($data));
                if ($data[0]->oboolean == 't' && $btn == 'add') {
                    $sucursal       = $this->control->M_sucursal_inicial();
                    $id_sucursal    = $sucursal[0]->id_sucursal;
                    $data = $this->C_registrar_cuis($id_sucursal);
                    if ($data[0]->oboolean == 't') {
                        $data = $this->C_generar_cufd($id_sucursal);
                        if ($data[0]->oboolean == 't') {
                            $data = $this->C_sincronizar_catalogos($id_sucursal);
                        }
                    }
                }
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaCuis->mensajesList->descripcion,
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

        
        echo json_encode($data);
    }

    function C_registrar_cuis($id_sucursal){
        $facturacion    = $this->control->M_informacion_facturacion($id_sucursal);
        $id_facturacion = $facturacion[0]->id_facturacion;
        $Codigos        = new Codigos($facturacion);
        $puntoVentaInicial  = 0;
        $respons        = $Codigos->solicitudCuis($puntoVentaInicial);
        $success        = $respons['success'];
        if ($success) {
            $response       = json_decode($respons['response']); // Convierte el JSON en un objeto PHP
            $codigo         = $response->RespuestaCuis->codigo; // Accede al valor del código
            $fechaVigencia  = $response->RespuestaCuis->fechaVigencia; // Accede al valor del código
            $array = array(
                "id_punto_venta" => 0,
                "id_facturacion" => $id_facturacion,
                "id_sucursal"    => $id_sucursal,
                "codigo"         => $codigo,
                "fechaVigencia"  => $fechaVigencia,
            );
            $data = $this->control->M_registrar_cuis(json_encode($array));
        }else{
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $respons['error'],
                )
            );
        }
        return $data;
    }

    function C_generar_cufd($id_sucursal){
        // Valores
        date_default_timezone_set('America/La_Paz');
        $feccre         = date('Y-m-d H:i:s.v');
        $facturacion    = $this->control->M_informacion_facturacion($id_sucursal);
        $datos_cuis     = $this->control->M_datos_iniciales_cuis($id_sucursal);        
        $Codigos        = new Codigos($facturacion);
        $respons        = $Codigos->solicitudCufd($datos_cuis[0]->cod_cuis,$datos_cuis[0]->cod_punto_venta);
        $success        = $respons['success'];
        if ($success) {
            //$respons      = json_decode(json_encode($respons));
            $response       = json_decode($respons['response']);
            if ($response->RespuestaCufd->transaccion) {
                $array_cufd = array(
                    'codpuntoventa' => $datos_cuis[0]->cod_punto_venta,
                    'cufd'          => $response->RespuestaCufd->codigo,
                    'idfacturacion' => $facturacion[0]->id_facturacion,
                    'idsucursal'    => $id_sucursal,
                    'codcontrol'    => $response->RespuestaCufd->codigoControl,
                    'direccion'     => $response->RespuestaCufd->direccion,
                    'feccre'        => $feccre,
                    'fecven'        => $response->RespuestaCufd->fechaVigencia,
                );
                $json_cufd = json_encode($array_cufd);
                $data = $this->control->fn_registrar_cufd($json_cufd);
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaCufd->mensajesList->descripcion,
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
        return $data;
    }


    function C_sincronizar_catalogos($id_sucursal){

        $facturacion    = $this->control->M_credenciales_facturacion(0,$id_sucursal);
        $Codigos        = new Sincronizacion($facturacion);

        $resultados = array();

        $resultados['idfacturacion'] = $facturacion[0]->id_facturacion;
        $resultados['idsucursal'] = $id_sucursal;
        $resultados['codpuntoventa'] = 0;

        $sincronizarActividades  = $Codigos->sincronizarActividades();
        if ($sincronizarActividades['success']) {
            $response       = json_decode($sincronizarActividades['response']);
            if ($response->RespuestaListaActividades->transaccion) {
                $resultados['sincronizarActividades'] = $sincronizarActividades['response'];
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaActividades->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaFechaHora->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaActividadesDocumentoSector->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricasLeyendas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaProductos->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
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
            }else {
                $data = array(
                    (object) array(
                        'oboolean' => 'f',
                        'omensaje' => $response->RespuestaListaParametricas->mensajesList->descripcion,
                    )
                );
                return $data;
                exit();
            }
        }else{
            $data = array(
                (object) array(
                    'oboolean' => 'f',
                    'omensaje' => $sincronizarParametricaUnidadMedida['error'],
                )
            );
            return $data;
            exit();
        }

        $data = $this->control->M_gestionar_catalogo_facturacion(json_encode($resultados));
        return $data;
    }


}
