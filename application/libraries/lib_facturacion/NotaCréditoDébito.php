<?php

class NotaCréditoDébito
{
    public $token;
    public $codigoAmbiente;
    public $codigoEmision;
    public $codigoSistema;
    public $nit;
    public $codigoSucursal;
    public $codigoModalidad;
    public $codigoPuntoVenta;
    public $cuis;
    public $cufd;
    
    // Servicios SOAP
    const wsdlPruebas ="https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionCompraVenta?wsdl";
    const wsdlOficial ="https://siatrest.impuestos.gob.bo/v2/ServicioFacturacionCompraVenta?wsdl";
    
    private $cachedSoapClient = null;

    function __construct($facturacion) {
        $this->token            = $facturacion[0]->cod_token;
        $this->codigoAmbiente   = $facturacion[0]->cod_ambiente;
        $this->codigoEmision    = $facturacion[0]->cod_emision;
        $this->codigoSistema    = $facturacion[0]->cod_sistema;
        $this->nit              = $facturacion[0]->nit;
        $this->codigoSucursal   = $facturacion[0]->cod_sucursal;
        $this->codigoModalidad  = $facturacion[0]->cod_modalidad;
        $this->codigoPuntoVenta = $facturacion[0]->cod_punto_venta;
        $this->cuis             = $facturacion[0]->cod_cuis;
        $this->cufd             = $facturacion[0]->cod_cufd;
    }

    function Conexion_SOAP() {
        if ($this->cachedSoapClient !== null) {
            return $this->cachedSoapClient;
        }
    
        $wsdl = $this->codigoAmbiente == '2' ? self::wsdlPruebas : self::wsdlOficial;
    
        $options = [
            'stream_context' => stream_context_create([
                'http' => [
                    'header' => "apikey: TokenApi $this->token"
                ]
            ]),
            'cache_wsdl' => WSDL_CACHE_NONE,
            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
        ];
       
        $this->cachedSoapClient = new \SoapClient($wsdl, $options);
        return $this->cachedSoapClient;
    }

    function recepcionFactura($cuis,$cufd,$archivo,$hashArchivo,$fechaEnvio,$tipoFacturaDocumento,$codigoDocumentoSector){
        $data = array(
            'SolicitudServicioRecepcionFactura' => array (
                'codigoAmbiente'        => $this->codigoAmbiente,
                'codigoEmision'         => $this->codigoEmision,
                'archivo'               => $archivo,
                'codigoSistema'         => $this->codigoSistema,
                'hashArchivo'           => $hashArchivo,
                'codigoSucursal'        => $this->codigoSucursal,
                'codigoModalidad'       => $this->codigoModalidad,
                'cuis'                  => $cuis,
                'codigoPuntoVenta'      => $this->codigoPuntoVenta,
                'fechaEnvio'            => $fechaEnvio,
                'tipoFacturaDocumento'  => $tipoFacturaDocumento,
                'nit'                   => $this->nit,
                'codigoDocumentoSector' => $codigoDocumentoSector,
                'cufd'                  => $cufd,
            ),
        );
        $client = self::Conexion_SOAP();
        $respons = $client->recepcionFactura($data);
        return json_encode($respons);
    }

    function firmadorNotaCréditoDébito($nombreArchivo,$privateKey,$publicKey){
        $XmlSinFirmar   = FCPATH . 'assets/facturasxml/' . $nombreArchivo . '.xml';
        $rutaGuardado   = FCPATH . 'assets/facturasfirmadasxml/' . $nombreArchivo . '.xml';
        $privateKey     = FCPATH . 'assets/llaves/' . $privateKey;
        $publicKey      = FCPATH . 'assets/llaves/' . $publicKey;
        $firmadorpy     = FCPATH . 'application/libraries/lib_facturacion/firmadorpy.py';
        $resultado      = exec("python $firmadorpy $XmlSinFirmar $privateKey $publicKey $rutaGuardado");
    }
    
   
}
