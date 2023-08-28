<?php
class M_catalogos extends CI_Model {

    public function insert_Actividades($response){
        $query = $this->db->query("INSERT INTO public.cat_catalogo
        (catalogo, codigo, descripcion, apiestado, usucre, feccre, usumod, fecmod)
        VALUES('cat_sincronizacion', 'Actividades', '$response', 'ELABORADO', 'admin');
        ");
        return $this->db->affected_rows();
      }


    public function catalogos($SolicitudSincronizacion,$valor) {
        //*******************************************************************************
    // Pruebas de Autorización de Sistemas -COMPUTARIZADA EN LÍNEA
    // El Presente documento esta enfocado a las etapas con punto de venta 0
    //*******************************************************************************


    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiI2MDEwMDMwTHBaIiwiY29kaWdvU2lzdGVtYSI6IjcyMzZBQTYzRkIwN0FENjZCM0FDQ0E3Iiwibml0IjoiSDRzSUFBQUFBQUFBQURNek1EUXdNRFl3TURRREFJdm1EbllLQUFBQSIsImlkIjoxMDgxMDM4LCJleHAiOjE2NjYzMTA0MDAsImlhdCI6MTY2MzgxMjA3MCwibml0RGVsZWdhZG8iOjYwMTAwMzAwMTYsInN1YnNpc3RlbWEiOiJTRkUifQ.GWpVfO1ZoOR34U6m4uRG_34GIskbrtEkkT6Ph7sR9lxwyssYVvvH_OlQIAWDpGjMon1w0NdRH2mSktT9gBn-Gg';

    // Servicios para consumir
    // wsdl 1
    //$wsdl ="https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";
    // wsdl 2
    $wsdl ="https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionSincronizacion?wsdl";
    
    $client = new \SoapClient($wsdl, [
        'stream_context' => stream_context_create([
        'http'=> [
        'header' => "apikey: TokenApi $token"
        ]
        ]),
        'cache_wsdl' => WSDL_CACHE_NONE,
        'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
    ]);


    // ****************************************************************
    //	PARA TODOS LOS CASOS SE REALIZA LA SOLICITUD DE SINCONIZACION
    // ****************************************************************

        if ($valor==1) {
            // =========================================================
            //	Etapa II - Sincronización de Catálogos Prueba- 2 - wsdl 2
            // =========================================================
            //  LISTADO TOTAL DE ACTIVIDADES
            $respons = $client->sincronizarActividades($SolicitudSincronizacion);
        }elseif ($valor==2) {
            // =========================================================
            //	Etapa II - Sincronización de Catálogos Prueba- 4 - wsdl 2
            // =========================================================
            //  FECHA Y HORA ACTUAL
            $respons = $client->sincronizarFechaHora($SolicitudSincronizacion);
        }elseif ($valor==3) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 6 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE ACTIVIDADES DOCUMENTO SECTOR
    $respons = $client->sincronizarListaActividadesDocumentoSector($SolicitudSincronizacion);
        }elseif ($valor==4) {

    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 8 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE LEYENDAS DE FACTURAS
    $respons = $client->sincronizarListaLeyendasFactura($SolicitudSincronizacion);
        }elseif ($valor==5) {

    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 10 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE MENSAJES DE SERVICIOS
    $respons = $client->sincronizarListaMensajesServicios($SolicitudSincronizacion);
        }elseif ($valor==6) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 12 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE PRODUCTOS Y SERVICIOS
    $respons = $client->sincronizarListaProductosServicios($SolicitudSincronizacion);
        }elseif ($valor==7) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 14 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE EVENTOS SIGNIFICATIVOS
    $respons = $client->sincronizarParametricaEventosSignificativos($SolicitudSincronizacion);
        }elseif ($valor==8) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 16 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE MOTIVO DE ANULACIÓN
    $respons = $client->sincronizarParametricaMotivoAnulacion($SolicitudSincronizacion);
        }elseif ($valor==9) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 18 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE PAÍSES
    $respons = $client->sincronizarParametricaPaisOrigen($SolicitudSincronizacion);
        }elseif ($valor==10) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 20 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE TIPOS DE DOCUMENTO DE IDENTIDAD
    $respons = $client->sincronizarParametricaTipoDocumentoIdentidad($SolicitudSincronizacion);
        }elseif ($valor==11) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 22 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE TIPOS DE DOCUMENTO SECTOR
    $respons = $client->sincronizarParametricaTipoDocumentoSector($SolicitudSincronizacion);
        }elseif ($valor==12) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 24 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE TIPO EMISIÓN
    $respons = $client->sincronizarParametricaTipoEmision($SolicitudSincronizacion);
        }elseif ($valor==13) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 26 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE TIPO HABITACIÓN
    $respons = $client->sincronizarParametricaTipoHabitacion($SolicitudSincronizacion);
        }elseif ($valor==14) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 28 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE MÉTODO DE PAGO
    $respons = $client->sincronizarParametricaTipoMetodoPago($SolicitudSincronizacion);

        }elseif ($valor==15) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 30 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE TIPOS DE MONEDA
    $respons = $client->sincronizarParametricaTipoMoneda($SolicitudSincronizacion);

        }elseif ($valor==16) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 32 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE TIPOS DE PUNTO DE VENTA
    $respons = $client->sincronizarParametricaTipoPuntoVenta($SolicitudSincronizacion);

        }elseif ($valor==17) {
    // =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 34 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE TIPOS DE FACTURA
    $respons = $client->sincronizarParametricaTiposFactura($SolicitudSincronizacion);

        }elseif ($valor==18) {
// =========================================================
    //	Etapa II - Sincronización de Catálogos Prueba- 36 - wsdl 2
    // =========================================================
    //  LISTADO TOTAL DE UNIDAD DE MEDIDA
    $respons = $client->sincronizarParametricaUnidadMedida($SolicitudSincronizacion);

        }

      
    return json_encode($respons);
    }

}
