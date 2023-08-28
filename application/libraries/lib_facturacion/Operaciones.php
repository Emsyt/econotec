<?php
/**
 * Clase Operaciones
 * Contiene métodos y propiedades necesarios para la interacción con el servicio de Facturación Operaciones del SIAT.
 */
class Operaciones
{
    // Propiedades públicas de la clase
    public $token;
    public $codigoAmbiente;
    public $codigoSistema;
    public $nit;
    public $codigoSucursal;
    public $codigoModalidad;
    public $cuis;
    public $cufd;

    // Constantes con las URL de los servicios SOAP
    const wsdlPruebas ="https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionOperaciones?wsdl";
    const wsdlOficial ="https://siatrest.impuestos.gob.bo/v2/FacturacionOperaciones?wsdl";
    
    // Variable para almacenar el cliente SOAP, inicialmente es nulo
    private $cachedSoapClient = null;

    /**
     * Constructor de la clase
     * @param $facturacion Array que contiene los datos de configuración de facturación del contribuyente
     */
    function __construct($facturacion){
        $this->token            = isset($facturacion[0]->cod_token) ? $facturacion[0]->cod_token : '';
        $this->codigoAmbiente   = isset($facturacion[0]->cod_ambiente) ? $facturacion[0]->cod_ambiente : '';
        $this->codigoSistema    = isset($facturacion[0]->cod_sistema) ? $facturacion[0]->cod_sistema : '';
        $this->nit              = isset($facturacion[0]->nit) ? $facturacion[0]->nit : '';
        $this->codigoSucursal   = isset($facturacion[0]->cod_sucursal) ? $facturacion[0]->cod_sucursal : '';
        $this->codigoModalidad  = isset($facturacion[0]->cod_modalidad) ? $facturacion[0]->cod_modalidad : '';
        $this->codigoPuntoVenta = isset($facturacion[0]->cod_punto_venta) ? $facturacion[0]->cod_punto_venta : '';
        $this->cuis             = isset($facturacion[0]->cod_cuis) ? $facturacion[0]->cod_cuis : '';
        $this->cufd             = isset($facturacion[0]->cod_cufd) ? $facturacion[0]->cod_cufd : '';
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
     * Método para consultar el punto de venta.
     * @return array Respuesta del servicio en formato JSON
     */
    function consultaPuntoVenta($cuis = null){
        try{
            // Se crea un array con los datos necesarios para la solicitud de Consulta Punto Venta
            $data = array(
                'SolicitudConsultaPuntoVenta' => array(
                    'codigoAmbiente'        => $this->codigoAmbiente,
                    'codigoSistema'         => $this->codigoSistema,
                    'codigoSucursal'        => $this->codigoSucursal,
                    'nit'                   => $this->nit
                )
            );

            // Validar si se proporcionó el parámetro $cuis
            if ($cuis !== null) {
                $data['SolicitudConsultaPuntoVenta']['cuis'] = $cuis;
            } else {
                $data['SolicitudConsultaPuntoVenta']['cuis'] = $this->cuis;
            }

            // Se establece la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la consulta de un Punto Venta
            $respons = $client->consultaPuntoVenta($data);
            // Se devuelve la respuesta como JSON
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la solicitud de Consulta Punto Venta: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para registrar un Punto Venta.
     * @return array Respuesta del servicio en formato JSON
     */
    function registroPuntoVenta($cuis = null, $codigoTipoPuntoVenta, $descripcion, $nombrePuntoVenta){
        try{
            // Se crea un array con los datos necesarios para registrar un Punto Venta
            $data = array(
                'SolicitudRegistroPuntoVenta' => array(
                    'codigoAmbiente'        => $this->codigoAmbiente,
                    'codigoModalidad'       => $this->codigoModalidad,
                    'codigoSistema'         => $this->codigoSistema,
                    'codigoSucursal'        => $this->codigoSucursal,
                    'codigoTipoPuntoVenta'  => $codigoTipoPuntoVenta,
                    'cuis'                  => $cuis,
                    'descripcion'           => $descripcion,
                    'nit'                   => $this->nit,
                    'nombrePuntoVenta'      => $nombrePuntoVenta
                )
            );
            // Se establece la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza el registro de un Punto Venta
            $respons = $client->registroPuntoVenta($data);
            // Se devuelve la respuesta como JSON
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la solicitud de registro de Punto Venta: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para registrar Eventos Significativos.
     * @return array Respuesta del servicio en formato JSON
     */
    function registroEventoSignificativo($arrayEvento){
        try{
            // Se crea un array con los datos necesarios para registrar Eventos Significativos
            $data = array(
                'SolicitudEventoSignificativo' => array(
                    'descripcion'           => $arrayEvento['descripcion'],
                    'cuis'                  => $this->cuis,
                    'codigoAmbiente'        => $this->codigoAmbiente,
                    'codigoPuntoVenta'      => $this->codigoPuntoVenta,
                    'cufdEvento'            => $arrayEvento['cufdEvento'],
                    'codigoSistema'         => $this->codigoSistema,
                    'nit'                   => $this->nit,
                    'codigoSucursal'        => $this->codigoSucursal,
                    'codigoMotivoEvento'    => $arrayEvento['codigoMotivoEvento'],
                    'cufd'                  => $arrayEvento['cufd'],
                    'fechaHoraInicioEvento' => $arrayEvento['fechaHoraInicioEvento'],
                    'fechaHoraFinEvento'    => $arrayEvento['fechaHoraFinEvento'],
                ),
            );
            // Se establece la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza el registro de Eventos Significativos
            $respons = $client->registroEventoSignificativo($data);
            // Se devuelve la respuesta como JSON
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la solicitud de registro de Eventos Significativos: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }
    
    /**
     * Método para cierre de un Punto Venta.
     * @return array Respuesta del servicio en formato JSON
     */
    function cierrePuntoVenta($codPuntoVentaEliminar, $cuisEliminar){
        try{
            // Se crea un array con los datos necesarios para registrar Eventos Significativos
            $data = array(
                'SolicitudCierrePuntoVenta' => array (
                    'codigoAmbiente'   => $this->codigoAmbiente,
                    'codigoPuntoVenta' => $codPuntoVentaEliminar,
                    'codigoSistema'    => $this->codigoSistema,
                    'codigoSucursal'   => $this->codigoSucursal,//$this->punto_venta->get_cod_sucursal($id_ubicacion),
                    'cuis'             => $cuisEliminar,
                    'nit'              => $this->nit,
                )
            );
            // Se establece la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza el cierre de un Punto Venta
            $respons = $client->cierrePuntoVenta($data);
            // Se devuelve la respuesta como JSON
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la solicitud de cierre de Punto Venta: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }
   
}
