<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_eventos_sin_linea extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->library('Factu');
        $this->load->helper(array('email'));
        $this->load->library(array('email'));
        $this->load->model('facturacion/M_eventos_sin_linea','eventos'); 
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
            $data['contenido'] = 'facturacion/eventos_sin_linea';
            //$data['eventos'] = $this->eventos->get_eventos();
            $data['chatUsers'] = $this->general->chat_users($usr);
            $data['getUserDetails'] = $this->general->get_user_details($usr);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

     function eventos_fuera_de_linea(){

        $codigoMotivoEvento=$this->input->post('codigo');

        $descripcion = $this->input->post('evento');
        $descripcion= trim($descripcion);
        
        $fechaHoraInicio = $this->input->post('fecha_inicial');
        $fechaHoraInicioEvento = str_replace(" ", "T", trim($fechaHoraInicio)).':00.000';

        date_default_timezone_set('America/La_Paz');
        $seg= date(':s.v');
        $fechaHoraFin = $this->input->post('fecha_fin');
        $fechaHoraFinEvento = str_replace(" ", "T", trim($fechaHoraFin)).$seg;

        $datos_punto_venta=$this->eventos->get_codigos_siat();
        $datos_faturacion=$this->eventos->fn_datos_facturacion(); 
        
        $cufdActivo = $this->eventos->get_cufd($datos_punto_venta[0]->codigo_punto_venta,'ACTIVO');
        $feccre=$cufdActivo[0]->feccre;
        $fecvenc=$cufdActivo[0]->fecvenc;

        if (($fechaHoraInicioEvento >= $feccre) && ($fecvenc > $fechaHoraInicio)){
            $this->generar_cufd();
        }
         

        $cufdEvento = $this->eventos->get_cufd($datos_punto_venta[0]->codigo_punto_venta,'PRE-ACTIVO');
        $cufdActivo = $this->eventos->get_cufd($datos_punto_venta[0]->codigo_punto_venta,'ACTIVO');

        $SolicitudEvento = array(
            'SolicitudEventoSignificativo' => array (
                'descripcion'           => trim($descripcion),
                'cuis'                  => $datos_punto_venta[0]->cuis,
                'codigoAmbiente'        => $datos_faturacion[0]->codigo_ambiente,
                'codigoPuntoVenta'      => $datos_punto_venta[0]->codigo_punto_venta,
                'cufdEvento'            => $cufdEvento[0]->cufd,
                'codigoSistema'         => $datos_faturacion[0]->codigo_sistema,
                'nit'                   => $datos_faturacion[0]->nit,
                'codigoSucursal'        => 0,
                'codigoMotivoEvento'    => $codigoMotivoEvento,
                'cufd'                  => $cufdActivo[0]->cufd,
                'fechaHoraInicioEvento' => $fechaHoraInicioEvento,
                'fechaHoraFinEvento'    => $fechaHoraFinEvento,
            ),
        );
        echo $this->eventos->eventos($SolicitudEvento);
    }

    function registro_evento(){
        $datos_punto_venta=$this->eventos->get_codigos_siat();
        $cufdEvento = $this->eventos->get_cufd($datos_punto_venta[0]->codigo_punto_venta,'PRE-ACTIVO');
        $cufdEvento =$cufdEvento->id_cufd;
        $array = array(
            "id_tipo_evento" => $this->input->post('codigo'),
            "codigo" => $this->input->post('codg'),
            "fecini" => $this->input->post('fecha_inicial'),
            "fecfin" => $this->input->post('fecha_fin'),
            "tipo_contigencia" => 1,
            "id_cufd"=> $cufdEvento,
        );
        $json = json_encode($array);
        //json fin
        $idlogin = $this->session->userdata('id_usuario');
        $resp = $this->eventos->fn_registrar_evento($idlogin,$json);
        echo json_encode($resp);
    }
    function listar_eventos(){
        $resp = $this->eventos->get_lst_eventos();
        echo json_encode($resp);
    }
    
    function C_reporte_factura_realizadas(){
        $fechaHoraInicio = $this->input->post('fecha_inicial');
        $fechaHoraFin = $this->input->post('fecha_fin');
        $tipo = $this->input->post('tipo');
        $id_facturacion = $this->input->post('id_facturacion');
        $id_sucursal = $this->input->post('id_sucursal');
        $cod_punto_venta = $this->input->post('cod_punto_venta');
        $id_evento = $this->input->post('id_evento');

        if ($tipo=='1') {
            $tipofacturadocumento = '1';
            $codigodocumentosector = '1';
        }elseif($tipo=='2'){
            $tipofacturadocumento = '1';
            $codigodocumentosector = '41';
        }
        $resp = $this->eventos->M_reporte_factura_realizadas($fechaHoraInicio,$fechaHoraFin,$tipofacturadocumento,$codigodocumentosector, $id_facturacion, $id_sucursal, $cod_punto_venta, $id_evento);
        echo json_encode($resp);
    }

    function emitirpaq(){

        $facturacion = $this->eventos->datos_facturacion();

        //$datos_punto_venta=$this->eventos->get_codigos_siat();
        //$datos_faturacion=$this->eventos->fn_datos_facturacion(); 
        $tipo = $this->input->post('tipo');
        $id_evento = $this->input->post('id_evento');
        if ($tipo=='1') {
            $tipoFacturaDocumento = '1';
            $codigoDocumentoSector = '1';
        }elseif($tipo=='2'){
            $tipoFacturaDocumento = '1';
            $codigoDocumentoSector = '41';
        }

        $codigoAmbiente         = $facturacion[0]->cod_ambiente;
        $codigoEmision          = $facturacion[0]->cod_emision;
        $codigoSistema          = $facturacion[0]->cod_sistema;
        $codigoSucursal         = $facturacion[0]->cod_sucursal;
        $codigoModalidad        = $facturacion[0]->cod_modalidad;
        $cuis                   = $facturacion[0]->cod_cuis;
        $codigoPuntoVenta       = $facturacion[0]->cod_punto_venta;
        $nit                    = $facturacion[0]->nit;
        $cufd                   = $facturacion[0]->cod_cufd;

        $evento = $this->input->post('desc');
        $codigo = $this->input->post('codigo');
        $tabla = $this->input->post('tabla');
        $tabla = json_decode($tabla);
        $nro=0;
        $files = glob(FCPATH.'assets/facturasfirmadasxml/tar/*.xml');
        $ruta = FCPATH.'assets/facturasfirmadasxml/tar/*.xml';
        
        // vaciamos la carpeta tar
        $files = glob(FCPATH.'assets/facturasfirmadasxml/tar/*.xml'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
        }
        // vaciamos la carpeta tar
        $files = glob(FCPATH.'assets/facturasfirmadasxml/targz/*.tar'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
        }
        // guardamos nuevos valores a la carpeta tar
        $array_facturas=array();
        foreach($tabla as $value){
            $nro++;
            $archivo = $value->archivo;
            $array_facturas[] = $value->id_factura;
            //$this->enviar_correo($value->id_factura);
            $from = FCPATH.'assets/facturasfirmadasxml/'.$archivo;
            $to = FCPATH.'assets/facturasfirmadasxml/tar/'.$archivo;
            copy($from, $to);

        }
        $tarfile = "assets/facturasfirmadasxml/targz/comprimido.tar";
        $pd = new \PharData($tarfile);
        
        $pd->buildFromDirectory( FCPATH.'assets/facturasfirmadasxml/tar');
        //$pd->compress(\Phar::GZ);
        $path= FCPATH.'assets/facturasfirmadasxml/targz/comprimido.tar';
        
        $data = file_get_contents($path); 
        
        $gz= gzencode($data,9); 
        $hash = hash('sha256', $gz);

        date_default_timezone_set('America/La_Paz');
        $feccre= date('Y-m-d H:i:s.v');
        $feccre = str_replace(" ", "T", $feccre);
        
        
        $this->eventos->fn_facturas_empaquetadas($id_evento,json_encode($array_facturas));

    
        $SolicitudServicio = array(
            'SolicitudServicioRecepcionPaquete' => array (
                'descripcion'           => $evento,
                'codigoAmbiente'        => $codigoAmbiente,
                'codigoEmision'         => 2,
                'codigoSistema'         => $codigoSistema,
                'codigoRecepcionEvento' => $codigo,
                'hashArchivo'           => $hash,
                'archivo'               => $gz,
                'codigoSucursal'        => $codigoSucursal,
                'cantidadFacturas'      => $nro,
                'codigoModalidad'       => $codigoModalidad,
                'cuis'                  => $cuis,
                'codigoPuntoVenta'      => $codigoPuntoVenta,
                'fechaEnvio'            => $feccre,
                'tipoFacturaDocumento'  => $tipoFacturaDocumento,
                'nit'                   => $nit,
                'codigoEvento'          => $codigo,
                'codigoDocumentoSector' => $codigoDocumentoSector,
                'cufd'                  => $cufd,
                                
            ),
        );
    

        $respons= $this->eventos->emision_paquetes($SolicitudServicio,$facturacion[0]->cod_token);

        echo $respons;
        // echo json_encode($array_facturas);

    }
    function validarPaquete(){
        $facturacion = $this->eventos->datos_facturacion();

        //$datos_punto_venta=$this->eventos->get_codigos_siat();
        //$datos_faturacion=$this->eventos->fn_datos_facturacion(); 
        $cod_tipo = $this->input->post('cod_tipo');
        if ($cod_tipo=='1') {
            $tipoFacturaDocumento = '1';
            $codigoDocumentoSector = '1';
        }elseif($cod_tipo=='2'){
            $tipoFacturaDocumento = '1';
            $codigoDocumentoSector = '41';
        }

        $codigoAmbiente         = $facturacion[0]->cod_ambiente;
        $codigoEmision          = $facturacion[0]->cod_emision;
        $codigoSistema          = $facturacion[0]->cod_sistema;
        $codigoSucursal         = $facturacion[0]->cod_sucursal;
        $codigoModalidad        = $facturacion[0]->cod_modalidad;
        $cuis                   = $facturacion[0]->cod_cuis;
        $codigoPuntoVenta       = $facturacion[0]->cod_punto_venta;
        $nit                    = $facturacion[0]->nit;
        $cufd                   = $facturacion[0]->cod_cufd;

        $codigoRecepcion = $this->input->post('codigoRecepcion');

        $SolicitudValidacionServicio = array(
        'SolicitudServicioValidacionRecepcionPaquete' => array (
            'codigoAmbiente'        => $codigoAmbiente,
            'codigoEmision'         => 2,
            'codigoSistema'         => $codigoSistema,
            'codigoSucursal'        => $codigoSucursal,
            'codigoModalidad'       => $codigoModalidad,
            'codigoRecepcion'       => $codigoRecepcion,
            'cuis'                  => $cuis,
            'codigoPuntoVenta'      => $codigoPuntoVenta,
            'tipoFacturaDocumento'  => $tipoFacturaDocumento,
            'nit'                   => $nit,
            'codigoDocumentoSector' => $codigoDocumentoSector,
            'cufd'                  => $cufd,

        ),
        );
        $respons_validacion= $this->eventos->validacion_paquetes($SolicitudValidacionServicio,$facturacion[0]->cod_token);
        echo $respons_validacion;
    }
    function registro_paquete_validado(){
        $codigoDescripcion = $this->input->post('codigoDescripcion');
        $codigoRecepcion = $this->input->post('codigoRecepcion');
        $id_evento = $this->input->post('id_evento');
        $this->eventos->validar_paquete($codigoDescripcion,$id_evento);
        $data = $this->eventos->fn_validar_empaquetados($codigoRecepcion,$id_evento);

        // $tabla = $this->input->post('tabla');
        // $tabla = json_decode($tabla);
        // foreach($tabla as $value){
        //     $id_factura = $value->id_factura;
        //     $this->eventos->validar_factura($id_factura);
        // }
        echo json_encode($data);
    }
    function generar_cufd(){
        // Valores
        date_default_timezone_set('America/La_Paz');
        $feccre= date('Y-m-d H:i:s.v');

        $datos_punto_venta=$this->eventos->get_cuis();
        $datos_faturacion=$this->eventos->fn_datos_facturacion();

        $SolicitudCufd = array(
            'SolicitudCufd' => array (
                'cuis'             => $datos_punto_venta[0]->cuis,
                'codigoAmbiente'   => $datos_faturacion[0]->codigo_ambiente,
                'codigoPuntoVenta' => $datos_punto_venta[0]->codigo_punto_venta,
                'codigoSistema'    => $datos_faturacion[0]->codigo_sistema,
                'nit'              => $datos_faturacion[0]->nit,
                'codigoSucursal'   => 0,
                'codigoModalidad'  => $datos_faturacion[0]->codigo_modalidad,
            ),
        );
        //print_r($SolicitudCufd);
        $respons = $this->eventos->generar_cufd($SolicitudCufd);
        //$respons = json_decode(json_encode($respons));
        //var_dump( $datos_faturacion);
        $fechaVigencia=str_replace('-04:00', '', $respons->fechaVigencia);
        $array_cufd = array(
            'codpuntoventa' => $datos_punto_venta[0]->codigo_punto_venta,
            'cufd' => $respons->codigo,
            'idfacturacion' => $datos_faturacion[0]->id_facturacion,
            'codcontrol' => $respons->codigoControl,
            'direccion' => $respons->direccion,
            'feccre' => $feccre,
            'fecvenc' => $fechaVigencia,
        );
        $json_cufd=json_encode($array_cufd);
        $this->eventos->fn_registrar_cufd($json_cufd);
        //print_r($json_cufd); 
    }
    function registro_envio_paquete(){
        $codigoRecepcion = $this->input->post('codigoRecepcion');
        $codigoDescripcion = $this->input->post('codigoDescripcion');
        $id_evento = $this->input->post('id_evento');
        $tipo = $this->input->post('tipo');
        $this->eventos->registro_envio_paquete($codigoRecepcion,$codigoDescripcion,$id_evento,$tipo);
    }


}