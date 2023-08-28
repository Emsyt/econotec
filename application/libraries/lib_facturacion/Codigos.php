<?php
/**
 * Clase Codigos
 * Contiene métodos y propiedades necesarios para la interacción con el servicio de Facturación Codigos del SIAT.
 */
class Codigos
{
    // Propiedades públicas de la clase
    public $token;
    public $codigoAmbiente;
    public $codigoSistema;
    public $nit;
    public $codigoSucursal;
    public $codigoModalidad;
    public $codigoPuntoVenta;
    public $cuis;
    
    // Constantes con las URL de los servicios SOAP
    const wsdlPruebas ="https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";
    const wsdlOficial ="https://siatrest.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";
    
    // Variable para almacenar el cliente SOAP, inicialmente es nulo
    private $cachedSoapClient = null;

    /**
     * Constructor de la clase
     * @param $facturacion Array que contiene los datos de configuración de facturación del contribuyente
     */
    function __construct($facturacion) {
        $this->token            = isset($facturacion[0]->cod_token) ? $facturacion[0]->cod_token : '';
        $this->codigoAmbiente   = isset($facturacion[0]->cod_ambiente) ? $facturacion[0]->cod_ambiente : '';
        $this->codigoSistema    = isset($facturacion[0]->cod_sistema) ? $facturacion[0]->cod_sistema : '';
        $this->nit              = isset($facturacion[0]->nit) ? $facturacion[0]->nit : '';
        $this->codigoSucursal   = isset($facturacion[0]->cod_sucursal) ? $facturacion[0]->cod_sucursal : '0';
        $this->codigoModalidad  = isset($facturacion[0]->cod_modalidad) ? $facturacion[0]->cod_modalidad : '';
        $this->codigoPuntoVenta = isset($facturacion[0]->cod_punto_venta) ? $facturacion[0]->cod_punto_venta : '0';
        $this->cuis             = isset($facturacion[0]->cod_cuis) ? $facturacion[0]->cod_cuis : '';
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
     * Método para solicitar el CUIS (Código Único de Identificación de la solicitud)
     * Este método utiliza la conexión SOAP para solicitar el CUIS para una solicitud de facturación.
     * @return array Respuesta del servicio en formato JSON
     */
    function solicitudCuis($codigoPuntoVenta = null){
        try{
            // Se crea un array con los datos necesarios para la solicitud de CUIS
            $data = array(
                'SolicitudCuis' => array (
                    'codigoAmbiente'   => $this->codigoAmbiente,
                    'codigoSistema'    => $this->codigoSistema,
                    'nit'              => $this->nit,
                    'codigoSucursal'   => $this->codigoSucursal,
                    'codigoModalidad'  => $this->codigoModalidad,
                ),
            );

            // Validar si se proporcionó el parámetro $codigoPuntoVenta
            if ($codigoPuntoVenta !== null) {
                $data['SolicitudCuis']['codigoPuntoVenta'] = $codigoPuntoVenta;
            } else {
                $data['SolicitudCuis']['codigoPuntoVenta'] = $this->codigoPuntoVenta;
            }

            // Se establece la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la solicitud de CUIS
            $respons = $client->cuis($data);
            // Se devuelve la respuesta como JSON
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la solicitud de CUIS: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }
    
    /**
     * Método para solicitar CUFD
     * Este método utiliza la conexión SOAP para solicitar CUFD
     * @return array Respuesta del servicio en formato JSON
     */
    function solicitudCufd($cuis = null, $codigoPuntoVenta = null) {
        try {
            // Se crea un array con los datos necesarios para la solicitud de CUFD
            $data = array(
                'SolicitudCufd' => array (
                    'codigoAmbiente'   => $this->codigoAmbiente,
                    'codigoSistema'    => $this->codigoSistema,
                    'nit'              => $this->nit,
                    'codigoSucursal'   => $this->codigoSucursal,
                    'codigoModalidad'  => $this->codigoModalidad,
                ),
            );
    
            // Validar si se proporcionó el parámetro $cuis
            if ($cuis !== null) {
                $data['SolicitudCufd']['cuis'] = $cuis;
            } else {
                $data['SolicitudCufd']['cuis'] = $this->cuis;
            }

            // Validar si se proporcionó el parámetro $codigoPuntoVenta
            if ($codigoPuntoVenta !== null) {
                $data['SolicitudCufd']['codigoPuntoVenta'] = $codigoPuntoVenta;
            } else {
                $data['SolicitudCufd']['codigoPuntoVenta'] = $this->codigoPuntoVenta;
            }
                
            // Se establece la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la solicitud de CUFD
            $respons = $client->cufd($data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la solicitud de CUFD: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }
    
    
    /**
     * Método para solicitar la verificaciÓn del nit
     * Este método utiliza la conexión SOAP para solicitar VERIFICACIÓN NIT
     * @return array Respuesta del servicio en formato JSON
     */
    function solicitudVerificarNit($nitParaVerificacion){
        try {
            // Se crea un array con los datos necesarios para la solicitud de VERIFICACIÓN NIT
            $data = array(
                'SolicitudVerificarNit' => array (
                    'codigoAmbiente'        => $this->codigoAmbiente,
                    'codigoModalidad'       => $this->codigoModalidad,
                    'codigoSistema'         => $this->codigoSistema,
                    'codigoSucursal'        => $this->codigoSucursal,
                    'cuis'                  => $this->cuis,
                    'codigoPuntoVenta'      => $this->codigoPuntoVenta,
                    'nit'                   => $this->nit,
                    'nitParaVerificacion'   => $nitParaVerificacion,
                ),
            );
            // Se establece la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la solicitud de VERIFICACIÓN NIT
            $respons = $client->verificarNit($data);
            // Se devuelve la respuesta como JSON, junto con un booleano indicando éxito
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la solicitud de verificación de NIT: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }
    
}
