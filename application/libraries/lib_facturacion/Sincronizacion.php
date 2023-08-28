<?php
/**
 * Clase Sincronizacion
 * Contiene métodos y propiedades necesarios para la interacción con el servicio de Facturación Sincronizacion del SIAT.
 */
class Sincronizacion
{
    // Propiedades públicas de la clase
    public $data;
    public $token;
    public $codigoAmbiente;

    // Constantes con las URL de los servicios SOAP
    const wsdlPruebas ="https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionSincronizacion?wsdl";
    const wsdlOficial ="https://siatrest.impuestos.gob.bo/v2/FacturacionSincronizacion?wsdl";

    // Variable para almacenar el cliente SOAP, inicialmente es nulo
    private $cachedSoapClient = null;

    /**
     * Constructor de la clase
     * @param $facturacion Array que contiene los datos de configuración de facturación del contribuyente
     */
    function __construct($facturacion) {
        /*
            $facturacion = array(
                (object) array(
                    'cod_token'         => 'token',
                    'cod_ambiente'      => 'codigoAmbiente',
                    'cod_sistema'       => 'codigoSistema',
                    'nit'               => 'nit',
                    'cod_sucursal'      => 'codigoSucursal',
                    'cod_punto_venta'   => 'codigoPuntoVenta',
                    'cod_cuis'          => 'cuis',
                )
            );
        */
        $this->token            = isset($facturacion[0]->cod_token) ? $facturacion[0]->cod_token : '';
        $this->codigoAmbiente   = isset($facturacion[0]->cod_ambiente) ? $facturacion[0]->cod_ambiente : '';
        $this->data = array(
            'SolicitudSincronizacion' => array (
                'codigoAmbiente'   => isset($facturacion[0]->cod_ambiente) ? $facturacion[0]->cod_ambiente : '',
                'codigoSistema'    => isset($facturacion[0]->cod_sistema) ? $facturacion[0]->cod_sistema : '',
                'nit'              => isset($facturacion[0]->nit) ? $facturacion[0]->nit : '',
                'codigoSucursal'   => isset($facturacion[0]->cod_sucursal) ? $facturacion[0]->cod_sucursal : '',
                'codigoPuntoVenta' => isset($facturacion[0]->cod_punto_venta) ? $facturacion[0]->cod_punto_venta : '',
                'cuis'             => isset($facturacion[0]->cod_cuis) ? $facturacion[0]->cod_cuis : '',
            ),
        );
    }

    /**
     * Método para obtener el cliente SOAP
     * @return \SoapClient Cliente SOAP
     */
    private function Conexion_SOAP() {
        // Si el cliente ya existe, lo retorna directamente
        if ($this->cachedSoapClient !== null) {
            return $this->cachedSoapClient;
        }
        
        // Si no existe, se determina la URL del servicio dependiendo del ambiente
        $wsdl = $this->codigoAmbiente == '2' ? self::wsdlPruebas : self::wsdlOficial;
    
        // Opciones para el cliente SOAP
        $options = [
            'stream_context' => stream_context_create([
                'http' => [
                    'header' => "apikey: TokenApi $this->token"
                ]
            ]),
            'cache_wsdl' => WSDL_CACHE_NONE,
            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
        ];
        // Se crea el cliente SOAP y se almacena en la variable cachedSoapClient
        $this->cachedSoapClient = new \SoapClient($wsdl, $options);
        return $this->cachedSoapClient;
    }

    /**
     * Método para verificar la conexión con el servicio de Facturación SIAT
     * @return array Respuesta del servicio en formato JSON
     */
    function verificarComunicacion(){
        try{
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la llamada al método verificarComunicacion
            $respons = $client->verificarComunicacion();
            // Se devuelve la respuesta como JSON
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la comunicación con Impuestos Nacionales: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar actividades.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarActividades(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de actividades
            $respons = $client->sincronizarActividades($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de actividades: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar fecha y hora.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarFechaHora(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de fecha y hora
            $respons = $client->sincronizarFechaHora($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Fecha y Hora: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }
    
    /**
     * Método para sincronizar lista de actividades del documento sector.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarListaActividadesDocumentoSector(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de la lista de actividades del documento sector
            $respons = $client->sincronizarListaActividadesDocumentoSector($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Documento Sector: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar lista de leyendas de factura.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarListaLeyendasFactura(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de la lista de leyendas de factura
            $respons = $client->sincronizarListaLeyendasFactura($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Lista de Leyendas Factura: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar lista de mensajes de servicios.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarListaMensajesServicios(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de la lista de mensajes de servicios
            $respons = $client->sincronizarListaMensajesServicios($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Lista de Mensajes Servicios: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar lista de productos y servicios.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarListaProductosServicios(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de la lista de productos y servicios
            $respons = $client->sincronizarListaProductosServicios($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Lista de Productos Servicios: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }    

    /**
     * Método para sincronizar parametricas de eventos significativos.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaEventosSignificativos(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de eventos significativos
            $respons = $client->sincronizarParametricaEventosSignificativos($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Eventos Significativos: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar parametricas de motivo anulacion.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaMotivoAnulacion(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de motivo anulacion
            $respons = $client->sincronizarParametricaMotivoAnulacion($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Motivo Anulacion: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar parametricas de pais origen.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaPaisOrigen(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de pais origen
            $respons = $client->sincronizarParametricaPaisOrigen($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Pais Origen: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }    

    /**
     * Método para sincronizar parametricas de tipo documento identidad.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaTipoDocumentoIdentidad(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de tipo documento identidad
            $respons = $client->sincronizarParametricaTipoDocumentoIdentidad($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Tipo Documento Identidad: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    } 

    /**
     * Método para sincronizar parametricas de tipo documento sector.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaTipoDocumentoSector(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de tipo documento sector
            $respons = $client->sincronizarParametricaTipoDocumentoSector($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Tipo Documento Sector: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar parametricas de tipo emision.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaTipoEmision(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de tipo emision
            $respons = $client->sincronizarParametricaTipoEmision($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Tipo Emision: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar parametricas de tipo habitacion.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaTipoHabitacion(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de tipo habitacion
            $respons = $client->sincronizarParametricaTipoHabitacion($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Tipo Habitacion: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar parametricas de tipo metodo pago.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaTipoMetodoPago(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de tipo metodo pago
            $respons = $client->sincronizarParametricaTipoMetodoPago($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Tipo Metodo Pago: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar parametricas de tipo moneda.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaTipoMoneda(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de tipo moneda
            $respons = $client->sincronizarParametricaTipoMoneda($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Tipo Moneda: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar parametricas de tipo punto venta.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaTipoPuntoVenta(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de tipo punto venta
            $respons = $client->sincronizarParametricaTipoPuntoVenta($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Tipo Punto Venta: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar parametricas de tipos factura.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaTiposFactura(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de tipos factura
            $respons = $client->sincronizarParametricaTiposFactura($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Tipos Factura: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para sincronizar parametricas de unidad de medida.
     * @return array Respuesta del servicio en formato JSON
     */
    function sincronizarParametricaUnidadMedida(){
        try {
            // Se obtiene la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la sincronización de las parametricas de unidad de medida
            $respons = $client->sincronizarParametricaUnidadMedida($this->data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la sincronización de Parametricas de Unidad Medida: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }
}
