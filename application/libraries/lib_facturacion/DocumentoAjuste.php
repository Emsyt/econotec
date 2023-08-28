<?php
/**
 * Clase DocumentoAjuste
 * Contiene métodos y propiedades necesarios para la interacción con el servicio de Facturación Operaciones del SIAT.
 */
class DocumentoAjuste
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
    public $cufd;
    public $codigoEmision;
    
    // Constantes con las URL de los servicios SOAP
    const wsdlPruebas ="https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionDocumentoAjuste?wsdl";
    const wsdlOficial ="https://siatrest.impuestos.gob.bo/v2/ServicioFacturacionDocumentoAjuste?wsdl";
    
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
                    'cod_modalidad'     => 'codigoModalidad',
                    'cod_punto_venta'   => 'codigoPuntoVenta',
                    'cod_cuis'          => 'cuis',
                    'cod_cufd'          => 'cufd',
                    'cod_emision'       => 'codigoEmision',
                )
            );
        */
        $this->token            = isset($facturacion[0]->cod_token) ? $facturacion[0]->cod_token : '';
        $this->codigoAmbiente   = isset($facturacion[0]->cod_ambiente) ? $facturacion[0]->cod_ambiente : '';
        $this->codigoSistema    = isset($facturacion[0]->cod_sistema) ? $facturacion[0]->cod_sistema : '';
        $this->nit              = isset($facturacion[0]->nit) ? $facturacion[0]->nit : '';
        $this->codigoSucursal   = isset($facturacion[0]->cod_sucursal) ? $facturacion[0]->cod_sucursal : '';
        $this->codigoModalidad  = isset($facturacion[0]->cod_modalidad) ? $facturacion[0]->cod_modalidad : '';
        $this->codigoPuntoVenta = isset($facturacion[0]->cod_punto_venta) ? $facturacion[0]->cod_punto_venta : '';
        $this->cuis             = isset($facturacion[0]->cod_cuis) ? $facturacion[0]->cod_cuis : '';
        $this->cufd             = isset($facturacion[0]->cod_cufd) ? $facturacion[0]->cod_cufd : '';
        $this->codigoEmision    = isset($facturacion[0]->cod_emision) ? $facturacion[0]->cod_emision : '';

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
     * Método para la recepcion de un Documento Ajuste.
     * Para la rutaArchivoXml tambien se debe añadir el nombre del archivo mas extension. Ej: ./facturasXML/factura.xml
     * El codigoEmision se establece en 1, al estar en linea.
     * El tipoFacturaDocumento se estable en 3 para el caso de un Documento Ajuste
     * El codigoDocumentoSector se estable en 24 para el caso de un Documento Ajuste
     * @return array Respuesta del servicio en formato JSON
     */
    function solicitudRecepcionDocumentoAjuste($rutaArchivoXml,$fechaEnvio){
        try{
            $contenidoXml   = file_get_contents($rutaArchivoXml);
            $gz = gzencode($contenidoXml, 9);
            $hashArchivo = hash('sha256', $gz);
            // Se crea un array con los datos necesarios para la recepcion de una Factura
            $data = array(
                'SolicitudServicioRecepcionDocumentoAjuste' => array (
                    'codigoAmbiente'        => $this->codigoAmbiente,
                    'codigoEmision'         => 1,
                    'archivo'               => $gz,
                    'codigoSistema'         => $this->codigoSistema,
                    'hashArchivo'           => $hashArchivo,
                    'codigoSucursal'        => $this->codigoSucursal,
                    'codigoModalidad'       => $this->codigoModalidad,
                    'cuis'                  => $this->cuis,
                    'codigoPuntoVenta'      => $this->codigoPuntoVenta,
                    'fechaEnvio'            => $fechaEnvio,
                    'tipoFacturaDocumento'  => 3,
                    'nit'                   => $this->nit,
                    'codigoDocumentoSector' => 24,
                    'cufd'                  => $this->cufd,
                ),
            );

            // Se establece la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la recepcion de Documento Ajuste
            $respons = $client->recepcionDocumentoAjuste($data);
            // Se devuelve la respuesta como JSON
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la solicitud de Recepcion Documento Ajuste: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }

    /**
     * Método para la anulacion de un Documento Ajuste.
     * Para la rutaArchivoXml tambien se debe añadir el nombre del archivo mas extension. Ej: ./facturasXML/factura.xml
     * El codigoEmision se establece en 1, al estar en linea.
     * El tipoFacturaDocumento se estable en 3 para el caso de un Documento Ajuste
     * El codigoDocumentoSector se estable en 24 para el caso de un Documento Ajuste
     * @return array Respuesta del servicio en formato JSON
     */
    function solicitudAnulacionDocumentoAjuste($cuf, $codigoMotivo){
        try{

            // Se crea un array con los datos necesarios para la anulacion de un Documento Ajuste
            $data = array(
                'SolicitudServicioAnulacionDocumentoAjuste' => array (
                    'cuis'                  => $this->cuis,
                    'codigoAmbiente'        => $this->codigoAmbiente,
                    'codigoEmision'         => 1,
                    'codigoPuntoVenta'      => $this->codigoPuntoVenta,
                    'codigoSistema'         => $this->codigoSistema,
                    'nit'                   => $this->nit,
                    'codigoSucursal'        => $this->codigoSucursal,
                    'codigoMotivo'          => $codigoMotivo,
                    'codigoModalidad'       => $this->codigoModalidad,
                    'tipoFacturaDocumento'  => 3,
                    'codigoDocumentoSector' => 24,
                    'cuf'                   => $cuf,
                    'cufd'                  => $this->cufd
                ),
            );
            // Se establece la conexión SOAP
            $client = self::Conexion_SOAP();
            // Se realiza la anulacion de un Documento Ajuste
            $respons = $client->anulacionDocumentoAjuste($data);
            // Se devuelve la respuesta como JSON
            return array('success' => true, 'response' => json_encode($respons));
        } catch (SoapFault $sf) {
            // Capturar errores específicos de la conexión SOAP
            return array('success' => false, 'error' => 'Error en la solicitud de Anulacion de un Documento Ajuste: '.$sf->getMessage());
        } catch (Exception $e) {
            // Capturar otros errores generales
            return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
        }
    }


    /**
     * Método para el firmado de una Nota Credito Debito.
     * @return array Respuesta del servicio en formato JSON
     */
    function firmadorDocumentoAjuste($dirs){
        /*
        Crear el arreglo $dirs con las rutas de los archivos y directorios
        $dirs = array(
            'xmlSinFirmar' => '/ruta/al/xmlSinFirmar.xml',
            'xmlGuardado' => '/ruta/al/xmlGuardado.xml',
            'rutaLibreria' => '/ruta/a/la/libreria/python',
            'archivoFirmador' => '/ruta/al/archivo/firmador.py',
            'privateKey' => '/ruta/a/la/privateKey.pem',
            'publicKey' => '/ruta/a/la/publicKey.pem'
        );
        */
        $xmlSinFirmar       = $dirs['xmlSinFirmar'];
        $xmlGuardado        = $dirs['xmlGuardado'];
        $rutaLibreria       = $dirs['rutaLibreria'];
        $archivoFirmador    = $dirs['archivoFirmador'];
        $privateKey         = $dirs['privateKey'];
        $publicKey          = $dirs['publicKey'];
    
        // Verificar si los archivos y directorios existen
        if (file_exists($archivoFirmador) && 
            file_exists($xmlSinFirmar) && 
            file_exists($privateKey) && 
            file_exists($publicKey)) {
            try {
                $resultado = shell_exec("$rutaLibreria $archivoFirmador $xmlSinFirmar $privateKey $publicKey $xmlGuardado");
                $resultado = json_decode($resultado,true);

                // Validar el resultado del comando
                if ($resultado['success'] !== null && $resultado['success'] !== false) {
                    return array('success' => true, 'response' => '');
                }else{
                    return array('success' => false, 'error' => 'Error en el firmado del Documento Ajuste.');
                }
            } catch (Exception $e) {
                // Manejar la excepción en caso de que shell_exec() falle
                return array('success' => false, 'error' => 'Ocurrió un error: '.$e->getMessage());
            }
    
        } else {
            // Manejar el caso de archivos/directorios faltantes
            return array('success' => false, 'error' => 'No se encontro la ruta de uno de los archivos.');
        }
    }
    
   
}
