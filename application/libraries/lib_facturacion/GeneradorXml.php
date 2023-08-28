<?php

class GeneradorXml
{

    function __construct() {

    }

    function CompraVentaComputarizada($data,$lst_productos){
        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================
        
        $nombreRazonSocial =str_replace("'", "&apos;", $data['nombreRazonSocial']);
        $nombreRazonSocial =str_replace('"', "&quot;", $nombreRazonSocial);

        $nitEmisor                      = $data['nitEmisor'];
        $razonSocialEmisor              = $data['razonSocialEmisor'];
        $municipio                      = $data['municipio'];
        $telefono                       = $data['telefono'];
        $numeroFactura                  = $data['numeroFactura'];
        $cuf                            = $data['cuf'];
        $cufd                           = $data['cufd'];
        $cafc                           = $data['cafc'];
        $codigoSucursal                 = $data['codigoSucursal'];
        $direccion                      = $data['direccion'];
        $codigoPuntoVenta               = $data['codigoPuntoVenta'];
        $fechaEmision                   = $data['fechaEmision'];
        $nombreRazonSocial              = $this->xmlEscape($nombreRazonSocial);
        $codigoTipoDocumentoIdentidad   = $data['docs_identidad'];
        $numeroDocumento                = $data['numeroDocumento'];
        $complemento                    = $data['complemento'];
        $codigoCliente                  = $data['cod_cliente'];
        $codigoMetodoPago               = $data['codigoMetodoPago'];
        $numeroTarjeta                  = $data['numeroTarjeta'];
        $montoTotal                     = str_replace(',', '', $data['montoTotal']);
        $montoTotalSujetoIva            = str_replace(',', '',$data['montoTotalSujetoIva']);
        $codigoMoneda                   = '1';
        $tipoCambio                     = '1';
        $montoTotalMoneda               = str_replace(',', '', $data['montoTotalMoneda']);
        $montoGiftCard                  = str_replace(',', '', $data['montoGiftCard']);
        if ($montoGiftCard==0) {
            $$montoGiftCard1='';
        }else{
            $montoGiftCard1=$montoGiftCard;
        }
        $descuentoAdicional=str_replace(',', '', $data['descuentoAdicional']);
        $codigoExcepcion=$data['codigoExcepcion'];
        if ($codigoExcepcion=='0') {
            $codigoExcepcion='';
        }
        $usuario=$data['usuario'];
        $codigoDocumentoSector='1';
        $leyenda = $data['leyenda'];
        $estadoEmision=false;
        $numTarjeta = true;
        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================
        

        $dom = new DomDocument('1.0', 'UTF-8');
        $dom->xmlStandalone = true;

        $root  = $dom->appendChild($dom->createElement('facturaComputarizadaCompraVenta'));

        // Appending attr1 and attr2 to the root element
        $attr = $dom->createAttribute('xmlns:xsi');
        $attr->appendChild($dom->createTextNode('http://www.w3.org/2001/XMLSchema-instance'));
        $root->appendChild($attr);

        $attr = $dom->createAttribute('xsi:noNamespaceSchemaLocation');
        $attr->appendChild($dom->createTextNode('facturaComputarizadaCompraVenta.xsd'));
        $root->appendChild($attr);

        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================

        //add NodeA element to Root
        $nodeA = $dom->createElement('cabecera');
        $root->appendChild($nodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nitEmisor',$nitEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('razonSocialEmisor',$razonSocialEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('municipio',$municipio);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('telefono',$telefono);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroFactura',$numeroFactura);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cuf',$cuf);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('cufd',$cufd);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoSucursal',$codigoSucursal);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('direccion',$direccion);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoPuntoVenta',$codigoPuntoVenta);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('fechaEmision',$fechaEmision);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nombreRazonSocial',$nombreRazonSocial);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoTipoDocumentoIdentidad',$codigoTipoDocumentoIdentidad);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroDocumento',$numeroDocumento);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('complemento',$complemento);
        $nodeA->appendChild($subnodeA);
        if ($complemento == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoCliente',$codigoCliente);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoMetodoPago',$codigoMetodoPago);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroTarjeta',$numeroTarjeta);
        $nodeA->appendChild($subnodeA);
        if ($numeroTarjeta == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotal',$montoTotal);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotalSujetoIva',$montoTotalSujetoIva);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoMoneda',$codigoMoneda);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('tipoCambio',$tipoCambio);
        $nodeA->appendChild($subnodeA);

        $subnodeA = $dom->createElement('montoTotalMoneda',$montoTotalMoneda);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoGiftCard',$montoGiftCard1);
        $nodeA->appendChild($subnodeA);
        if ($montoGiftCard==0) {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }


        $subnodeA = $dom->createElement('descuentoAdicional',$descuentoAdicional);
        $nodeA->appendChild($subnodeA);

        $subnodeA = $dom->createElement('codigoExcepcion',$codigoExcepcion);
        $nodeA->appendChild($subnodeA);
        if ($codigoExcepcion == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cafc',$cafc);
        $nodeA->appendChild($subnodeA);
        if ($cafc=='') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }

        //add NodeA element to Root
        $subnodeA = $dom->createElement('leyenda',$leyenda);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('usuario',$usuario);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoDocumentoSector', $codigoDocumentoSector);
        $nodeA->appendChild($subnodeA);

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================

        foreach($lst_productos as $prod):
            

            $numeroSerie = '';
            $numeroImei = '';
            if (number_format($prod->odescuento,2) == 0.00) {
                $precioUnitario = number_format($prod->oprecio_venta,2);
            }else{
                $precioUnitario = number_format($prod->oprecio_real,2);
            }

            //add NodeB element to Root
            $NodeB = $dom->createElement('detalle');
            $root->appendChild($NodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_econimica);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('descripcion',$prod->odescripcion);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('cantidad',$prod->ocantidad);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('precioUnitario',str_replace(',', '', $precioUnitario));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('montoDescuento',str_replace(',', '', number_format($prod->odescuento,2)));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('subTotal',str_replace(',', '', number_format($prod->ototal,2)));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('numeroSerie',$numeroSerie);
            $NodeB->appendChild($subnodeB);
            if ($numeroSerie == '') {
                $attr = $dom->createAttribute('xsi:nil');
                $attr->appendChild($dom->createTextNode('true'));
                $subnodeB->appendChild($attr);
            }
            //add NodeA element to Root
            $subnodeB = $dom->createElement('numeroImei',$numeroImei);
            $NodeB->appendChild($subnodeB);
            if ($numeroImei == '') {
                $attr = $dom->createAttribute('xsi:nil');
                $attr->appendChild($dom->createTextNode('true'));
                $subnodeB->appendChild($attr);
            }  

        endforeach;


        $dom->formatOutput = true; // set the formatOutput attribute of domDocument to true

        // save XML as string or file
        $test1 = $dom->saveXML(); // put string in test1
        $dom->save(FCPATH.'assets/facturasxml/'.$cuf.'.xml');
        return $test1;
    }

    function CompraVentaElectronica($data,$lst_productos){
        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================
        
        $nombreRazonSocial =str_replace("'", "&apos;", $data['nombreRazonSocial']);
        $nombreRazonSocial =str_replace('"', "&quot;", $nombreRazonSocial);

        $nitEmisor                      = $data['nitEmisor'];
        $razonSocialEmisor              = $data['razonSocialEmisor'];
        $municipio                      = $data['municipio'];
        $telefono                       = $data['telefono'];
        $numeroFactura                  = $data['numeroFactura'];
        $cuf                            = $data['cuf'];
        $cufd                           = $data['cufd'];
        $cafc                           = $data['cafc'];
        $codigoSucursal                 = $data['codigoSucursal'];
        $direccion                      = $data['direccion'];
        $codigoPuntoVenta               = $data['codigoPuntoVenta'];
        $fechaEmision                   = $data['fechaEmision'];
        $nombreRazonSocial              = $this->xmlEscape($nombreRazonSocial);
        $codigoTipoDocumentoIdentidad   = $data['docs_identidad'];
        $numeroDocumento                = $data['numeroDocumento'];
        $complemento                    = $data['complemento'];
        $codigoCliente                  = $data['cod_cliente'];
        $codigoMetodoPago               = $data['codigoMetodoPago'];
        $numeroTarjeta                  = $data['numeroTarjeta'];
        $montoTotal                     = str_replace(',', '', $data['montoTotal']);
        $montoTotalSujetoIva            = str_replace(',', '', $data['montoTotalSujetoIva']);
        $codigoMoneda                   = '1';
        $tipoCambio                     = '1';
        $montoTotalMoneda               = str_replace(',', '', $data['montoTotalMoneda']);
        $montoGiftCard                  = str_replace(',', '', $data['montoGiftCard']);
        if ($montoGiftCard==0) {
            $$montoGiftCard1='';
        }else{
            $montoGiftCard1=$montoGiftCard;
        }
        $descuentoAdicional=str_replace(',', '', $data['descuentoAdicional']);
        $codigoExcepcion=$data['codigoExcepcion'];
        if ($codigoExcepcion=='0') {
            $codigoExcepcion='';
        }
        $usuario=$data['usuario'];
        $codigoDocumentoSector='1';
        $leyenda = $data['leyenda'];

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================

        $dom = new DomDocument('1.0', 'UTF-8');
        $dom->xmlStandalone = true;

        $root  = $dom->appendChild($dom->createElement('facturaElectronicaCompraVenta'));

        // Appending attr1 and attr2 to the root element
        $attr = $dom->createAttribute('xmlns:xsi');
        $attr->appendChild($dom->createTextNode('http://www.w3.org/2001/XMLSchema-instance'));
        $root->appendChild($attr);

        $attr = $dom->createAttribute('xsi:noNamespaceSchemaLocation');
        $attr->appendChild($dom->createTextNode('facturaElectronicaCompraVenta.xsd'));
        $root->appendChild($attr);

        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================

        //add NodeA element to Root
        $nodeA = $dom->createElement('cabecera');
        $root->appendChild($nodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nitEmisor',$nitEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('razonSocialEmisor',$razonSocialEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('municipio',$municipio);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('telefono',$telefono);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroFactura',$numeroFactura);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cuf',$cuf);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('cufd',$cufd);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoSucursal',$codigoSucursal);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('direccion',$direccion);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoPuntoVenta',$codigoPuntoVenta);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('fechaEmision',$fechaEmision);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nombreRazonSocial',$nombreRazonSocial);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoTipoDocumentoIdentidad',$codigoTipoDocumentoIdentidad);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroDocumento',$numeroDocumento);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('complemento',$complemento);
        $nodeA->appendChild($subnodeA);
        if ($complemento == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoCliente',$codigoCliente);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoMetodoPago',$codigoMetodoPago);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroTarjeta',$numeroTarjeta);
        $nodeA->appendChild($subnodeA);
        if ($numeroTarjeta == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotal',$montoTotal);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotalSujetoIva',$montoTotalSujetoIva);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoMoneda',$codigoMoneda);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('tipoCambio',$tipoCambio);
        $nodeA->appendChild($subnodeA);

        $subnodeA = $dom->createElement('montoTotalMoneda',$montoTotalMoneda);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoGiftCard',$montoGiftCard1);
        $nodeA->appendChild($subnodeA);
        if ($montoGiftCard==0) {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }


        $subnodeA = $dom->createElement('descuentoAdicional',$descuentoAdicional);
        $nodeA->appendChild($subnodeA);

        $subnodeA = $dom->createElement('codigoExcepcion',$codigoExcepcion);
        $nodeA->appendChild($subnodeA);
        if ($codigoExcepcion == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cafc',$cafc);
        $nodeA->appendChild($subnodeA);
        if ($cafc=='') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }

        //add NodeA element to Root
        $subnodeA = $dom->createElement('leyenda',$leyenda);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('usuario',$usuario);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoDocumentoSector', $codigoDocumentoSector);
        $nodeA->appendChild($subnodeA);

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================

        foreach($lst_productos as $prod):

            $numeroSerie = '';
            $numeroImei = '';
            if (number_format($prod->odescuento,2) == 0.00) {
                $precioUnitario = number_format($prod->oprecio_venta,2);
            }else{
                $precioUnitario = number_format($prod->oprecio_real,2);
            }

            //add NodeB element to Root
            $NodeB = $dom->createElement('detalle');
            $root->appendChild($NodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_econimica);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('descripcion',$prod->odescripcion);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('cantidad',$prod->ocantidad);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('precioUnitario',str_replace(',', '', $precioUnitario));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('montoDescuento',str_replace(',', '', number_format($prod->odescuento,2)));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('subTotal',str_replace(',', '', number_format($prod->ototal,2)));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('numeroSerie',$numeroSerie);
            $NodeB->appendChild($subnodeB);
            if ($numeroSerie == '') {
                $attr = $dom->createAttribute('xsi:nil');
                $attr->appendChild($dom->createTextNode('true'));
                $subnodeB->appendChild($attr);
            }
            //add NodeA element to Root
            $subnodeB = $dom->createElement('numeroImei',$numeroImei);
            $NodeB->appendChild($subnodeB);
            if ($numeroImei == '') {
                $attr = $dom->createAttribute('xsi:nil');
                $attr->appendChild($dom->createTextNode('true'));
                $subnodeB->appendChild($attr);
            }  

        endforeach;

        $dom->formatOutput = true; // set the formatOutput attribute of domDocument to true
        // save XML as string or file
        $test1 = $dom->saveXML(); // put string in test1
        $dom->save(FCPATH.'assets/facturasxml/'.$cuf.'.xml');
        return $test1;
    }

    function CompraVentaTasas($data,$lst_productos,$montoTasa){
        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================
        
        $nombreRazonSocial =str_replace("'", "&apos;", $data['nombreRazonSocial']);
        $nombreRazonSocial =str_replace('"', "&quot;", $nombreRazonSocial);

        $nitEmisor                      = $data['nitEmisor'];
        $razonSocialEmisor              = $data['razonSocialEmisor'];
        $municipio                      = $data['municipio'];
        $telefono                       = $data['telefono'];
        $numeroFactura                  = $data['numeroFactura'];
        $cuf                            = $data['cuf'];
        $cufd                           = $data['cufd'];
        $cafc                           = $data['cafc'];
        $codigoSucursal                 = $data['codigoSucursal'];
        $direccion                      = $data['direccion'];
        $codigoPuntoVenta               = $data['codigoPuntoVenta'];
        $fechaEmision                   = $data['fechaEmision'];
        $nombreRazonSocial              = $this->xmlEscape($nombreRazonSocial);
        $codigoTipoDocumentoIdentidad   = $data['docs_identidad'];
        $numeroDocumento                = $data['numeroDocumento'];
        $complemento                    = $data['complemento'];
        $codigoCliente                  = $data['cod_cliente'];
        $codigoMetodoPago               = $data['codigoMetodoPago'];
        $numeroTarjeta                  = $data['numeroTarjeta'];
        $montoTotal                     = str_replace(',', '', $data['montoTotal']);
        $montoTotalSujetoIva            = str_replace(',', '',$data['montoTotalSujetoIva']);
        $codigoMoneda                   = '1';
        $tipoCambio                     = '1';
        $montoTotalMoneda               = str_replace(',', '', $data['montoTotalMoneda']);
        $montoGiftCard                  = str_replace(',', '', $data['montoGiftCard']);
        if ($montoGiftCard==0) {
            $$montoGiftCard1='';
        }else{
            $montoGiftCard1=$montoGiftCard;
        }
        $descuentoAdicional=str_replace(',', '', $data['descuentoAdicional']);
        $codigoExcepcion=$data['codigoExcepcion'];
        if ($codigoExcepcion=='0') {
            $codigoExcepcion='';
        }
        $usuario=$data['usuario'];
        $codigoDocumentoSector='41';
        $montoTasa = $montoTasa;
        if ($montoTasa==0) {
            $$montoTasa='';
        }else{
            $montoTasa=(float)$montoTasa;
            
        }
        $leyenda = $data['leyenda'];
        $estadoEmision=false;
        $numTarjeta = true;
        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================
        

        $dom = new DomDocument('1.0', 'UTF-8');
        $dom->xmlStandalone = true;

        $root  = $dom->appendChild($dom->createElement('facturaComputarizadaCompraVentaTasas'));

        // Appending attr1 and attr2 to the root element
        $attr = $dom->createAttribute('xmlns:xsi');
        $attr->appendChild($dom->createTextNode('http://www.w3.org/2001/XMLSchema-instance'));
        $root->appendChild($attr);

        $attr = $dom->createAttribute('xsi:noNamespaceSchemaLocation');
        $attr->appendChild($dom->createTextNode('facturaComputarizadaCompraVentaTasas.xsd'));
        $root->appendChild($attr);

        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================

        //add NodeA element to Root
        $nodeA = $dom->createElement('cabecera');
        $root->appendChild($nodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nitEmisor',$nitEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('razonSocialEmisor',$razonSocialEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('municipio',$municipio);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('telefono',$telefono);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroFactura',$numeroFactura);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cuf',$cuf);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('cufd',$cufd);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoSucursal',$codigoSucursal);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('direccion',$direccion);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoPuntoVenta',$codigoPuntoVenta);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('fechaEmision',$fechaEmision);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nombreRazonSocial',$nombreRazonSocial);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoTipoDocumentoIdentidad',$codigoTipoDocumentoIdentidad);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroDocumento',$numeroDocumento);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('complemento',$complemento);
        $nodeA->appendChild($subnodeA);
        if ($complemento == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoCliente',$codigoCliente);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoMetodoPago',$codigoMetodoPago);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroTarjeta',$numeroTarjeta);
        $nodeA->appendChild($subnodeA);
        if ($numeroTarjeta == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotal',$montoTotal);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotalSujetoIva',$montoTotalSujetoIva);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoMoneda',$codigoMoneda);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('tipoCambio',$tipoCambio);
        $nodeA->appendChild($subnodeA);

        $subnodeA = $dom->createElement('montoTotalMoneda',$montoTotalMoneda);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoGiftCard',$montoGiftCard1);
        $nodeA->appendChild($subnodeA);
        
        if ($montoGiftCard==0) {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }

        $subnodeA = $dom->createElement('montoTasa',$montoTasa);
        $nodeA->appendChild($subnodeA);
        if ($montoTasa == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        



        $subnodeA = $dom->createElement('descuentoAdicional',$descuentoAdicional);
        $nodeA->appendChild($subnodeA);

        $subnodeA = $dom->createElement('codigoExcepcion',$codigoExcepcion);
        $nodeA->appendChild($subnodeA);
        if ($codigoExcepcion == '') {
        $attr = $dom->createAttribute('xsi:nil');
        $attr->appendChild($dom->createTextNode('true'));
        $subnodeA->appendChild($attr);
        }
        

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cafc',$cafc);
        $nodeA->appendChild($subnodeA);
        if ($cafc=='') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }

        //add NodeA element to Root
        $subnodeA = $dom->createElement('leyenda',$leyenda);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('usuario',$usuario);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoDocumentoSector', $codigoDocumentoSector);
        $nodeA->appendChild($subnodeA);

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================

        foreach($lst_productos as $prod):
            
            
            $numeroSerie = '';
            $numeroImei = '';
            if (number_format($prod->odescuento,2) == 0.00) {
                $precioUnitario = number_format($prod->oprecio_venta,2);
            }else{
                $precioUnitario = number_format($prod->oprecio_real,2);
            }

            //add NodeB element to Root
            $NodeB = $dom->createElement('detalle');
            $root->appendChild($NodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_econimica);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
             $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('descripcion',$prod->odescripcion);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('cantidad',$prod->ocantidad);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('precioUnitario',str_replace(',', '', $precioUnitario));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('montoDescuento',str_replace(',', '', number_format($prod->odescuento,2)));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('subTotal',str_replace(',', '', number_format($prod->ototal,2)));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('numeroSerie',$numeroSerie);
            $NodeB->appendChild($subnodeB);
            if ($numeroSerie == '') {
                $attr = $dom->createAttribute('xsi:nil');
                $attr->appendChild($dom->createTextNode('true'));
                $subnodeB->appendChild($attr);
            }
            //add NodeA element to Root
            $subnodeB = $dom->createElement('numeroImei',$numeroImei);
            $NodeB->appendChild($subnodeB);
            if ($numeroImei == '') {
                $attr = $dom->createAttribute('xsi:nil');
                $attr->appendChild($dom->createTextNode('true'));
                $subnodeB->appendChild($attr);
            }
                       
        endforeach;


        $dom->formatOutput = true; // set the formatOutput attribute of domDocument to true
        
        // save XML as string or file
        $test1 = $dom->saveXML(); // put string in test1
        $dom->save(FCPATH.'assets/facturasxml/'.$cuf.'.xml');
        return $test1;
    }

    function CompraVentaElectronicaTasas($data,$lst_productos,$montoTasa){
        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================
        $nombreRazonSocial =str_replace("'", "&apos;", $data['nombreRazonSocial']);
        $nombreRazonSocial =str_replace('"', "&quot;", $nombreRazonSocial);

        $nitEmisor                      = $data['nitEmisor'];
        $razonSocialEmisor              = $data['razonSocialEmisor'];
        $municipio                      = $data['municipio'];
        $telefono                       = $data['telefono'];
        $numeroFactura                  = $data['numeroFactura'];
        $cuf                            = $data['cuf'];
        $cufd                           = $data['cufd'];
        $cafc                           = $data['cafc'];
        $codigoSucursal                 = $data['codigoSucursal'];
        $direccion                      = $data['direccion'];
        $codigoPuntoVenta               = $data['codigoPuntoVenta'];
        $fechaEmision                   = $data['fechaEmision'];
        $nombreRazonSocial              = $this->xmlEscape($nombreRazonSocial);
        $codigoTipoDocumentoIdentidad   = $data['docs_identidad'];
        $numeroDocumento                = $data['numeroDocumento'];
        $complemento                    = $data['complemento'];
        $codigoCliente                  = $data['cod_cliente'];
        $codigoMetodoPago               = $data['codigoMetodoPago'];
        $numeroTarjeta                  = $data['numeroTarjeta'];
        $montoTotal                     = str_replace(',', '', $data['montoTotal']);
        $montoTotalSujetoIva            = str_replace(',', '', $data['montoTotalSujetoIva']);
        $codigoMoneda                   = '1';
        $tipoCambio                     = '1';
        $montoTotalMoneda               = str_replace(',', '', $data['montoTotalMoneda']);
        $montoGiftCard                  = str_replace(',', '', $data['montoGiftCard']);
        if ($cafc=='') {
            $cafc='';
        }else{
            $cafc='1415842E81D0E';
        }
        if ($montoGiftCard==0) {
            $$montoGiftCard1='';
        }else{
            $montoGiftCard1=$montoGiftCard;
        }
        $descuentoAdicional=str_replace(',', '', $data['descuentoAdicional']);
        $codigoExcepcion=$data['codigoExcepcion'];
        if ($codigoExcepcion=='0') {
            $codigoExcepcion='';
        }
        $usuario=$data['usuario'];
        $codigoDocumentoSector='41';
        $montoTasa = $montoTasa;
        if ($montoTasa==0) {
            $$montoTasa='';
        }else{
            $montoTasa=(float)$montoTasa;
            
        }
        $leyenda = $data['leyenda'];

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================
        
        $dom = new DomDocument('1.0', 'UTF-8');
        $dom->xmlStandalone = true;

        $root  = $dom->appendChild($dom->createElement('facturaElectronicaCompraVentaTasas'));

        // Appending attr1 and attr2 to the root element
        $attr = $dom->createAttribute('xmlns:xsi');
        $attr->appendChild($dom->createTextNode('http://www.w3.org/2001/XMLSchema-instance'));
        $root->appendChild($attr);

        $attr = $dom->createAttribute('xsi:noNamespaceSchemaLocation');
        $attr->appendChild($dom->createTextNode('facturaElectronicaCompraVentaTasas.xsd'));
        $root->appendChild($attr);

        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================

        //add NodeA element to Root
        $nodeA = $dom->createElement('cabecera');
        $root->appendChild($nodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nitEmisor',$nitEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('razonSocialEmisor',$razonSocialEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('municipio',$municipio);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('telefono',$telefono);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroFactura',$numeroFactura);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cuf',$cuf);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('cufd',$cufd);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoSucursal',$codigoSucursal);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('direccion',$direccion);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoPuntoVenta',$codigoPuntoVenta);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('fechaEmision',$fechaEmision);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nombreRazonSocial',$nombreRazonSocial);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoTipoDocumentoIdentidad',$codigoTipoDocumentoIdentidad);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroDocumento',$numeroDocumento);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('complemento',$complemento);
        $nodeA->appendChild($subnodeA);
        if ($complemento == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoCliente',$codigoCliente);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoMetodoPago',$codigoMetodoPago);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroTarjeta',$numeroTarjeta);
        $nodeA->appendChild($subnodeA);
        if ($numeroTarjeta == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotal',$montoTotal);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotalSujetoIva',$montoTotalSujetoIva);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoMoneda',$codigoMoneda);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('tipoCambio',$tipoCambio);
        $nodeA->appendChild($subnodeA);

        $subnodeA = $dom->createElement('montoTotalMoneda',$montoTotalMoneda);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoGiftCard',$montoGiftCard1);
        $nodeA->appendChild($subnodeA);
        
        if ($montoGiftCard==0) {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }

        $subnodeA = $dom->createElement('montoTasa',$montoTasa);
        $nodeA->appendChild($subnodeA);
        if ($montoTasa == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }
        



        $subnodeA = $dom->createElement('descuentoAdicional',$descuentoAdicional);
        $nodeA->appendChild($subnodeA);

        $subnodeA = $dom->createElement('codigoExcepcion',$codigoExcepcion);
        $nodeA->appendChild($subnodeA);
        if ($codigoExcepcion == '') {
        $attr = $dom->createAttribute('xsi:nil');
        $attr->appendChild($dom->createTextNode('true'));
        $subnodeA->appendChild($attr);
        }
        

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cafc',$cafc);
        $nodeA->appendChild($subnodeA);
        if ($cafc=='') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }

        //add NodeA element to Root
        $subnodeA = $dom->createElement('leyenda',$leyenda);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('usuario',$usuario);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoDocumentoSector', $codigoDocumentoSector);
        $nodeA->appendChild($subnodeA);

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================

        foreach($lst_productos as $prod):
            
            $numeroSerie = '';
            $numeroImei = '';
            if (number_format($prod->odescuento,2) == 0.00) {
                $precioUnitario = number_format($prod->oprecio_venta,2);
            }else{
                $precioUnitario = number_format($prod->oprecio_real,2);
            }

            //add NodeB element to Root
            $NodeB = $dom->createElement('detalle');
            $root->appendChild($NodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_econimica);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
             $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('descripcion',$prod->odescripcion);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('cantidad',$prod->ocantidad);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('precioUnitario',str_replace(',', '', $precioUnitario));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('montoDescuento',str_replace(',', '', number_format($prod->odescuento,2)));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('subTotal',str_replace(',', '', number_format($prod->ototal,2)));
            $NodeB->appendChild($subnodeB);

            //add NodeA element to Root
            $subnodeB = $dom->createElement('numeroSerie',$numeroSerie);
            $NodeB->appendChild($subnodeB);
            if ($numeroSerie == '') {
                $attr = $dom->createAttribute('xsi:nil');
                $attr->appendChild($dom->createTextNode('true'));
                $subnodeB->appendChild($attr);
            }
            //add NodeA element to Root
            $subnodeB = $dom->createElement('numeroImei',$numeroImei);
            $NodeB->appendChild($subnodeB);
            if ($numeroImei == '') {
                $attr = $dom->createAttribute('xsi:nil');
                $attr->appendChild($dom->createTextNode('true'));
                $subnodeB->appendChild($attr);
            }
                       
        endforeach;
        
        $dom->formatOutput = true; // set the formatOutput attribute of domDocument to true
        // save XML as string or file
        $test1 = $dom->saveXML(); // put string in test1
        $dom->save(FCPATH.'assets/facturasxml/'.$cuf.'.xml');
        return $test1;
    }

    function NotaElectronicaCreditoDebito($data,$lst_productos){
        
        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================
        $nombreRazonSocial =str_replace("'", "&apos;", $data['nombreRazonSocial']);
        $nombreRazonSocial =str_replace('"', "&quot;", $nombreRazonSocial);

        $nitEmisor                      = $data['nitEmisor'];
        $razonSocialEmisor              = $data['razonSocialEmisor'];
        $municipio                      = $data['municipio'];
        $telefono                       = $data['telefono'];
        $numeroNotaCreditoDebito        = $data['numeroNotaCreditoDebito'];
        $cuf                            = $data['cuf'];
        $cufd                           = $data['cufd'];
        $codigoSucursal                 = $data['codigoSucursal'];
        $direccion                      = $data['direccion'];
        $codigoPuntoVenta               = $data['codigoPuntoVenta'];
        $fechaEmision                   = $data['fechaEmision'];
        $nombreRazonSocial              = $this->xmlEscape($nombreRazonSocial);
        $codigoTipoDocumentoIdentidad   = $data['codigoTipoDocumentoIdentidad'];
        $numeroDocumento                = $data['numeroDocumento'];
        $complemento                    = $data['complemento'];
        $codigoCliente                  = $data['codigoCliente'];
        $numeroFactura                  = $data['numeroFactura'];
        $numeroAutorizacionCuf          = $data['numeroAutorizacionCuf'];
        $fechaEmisionFactura            = $data['fechaEmisionFactura'];
        $montoTotalOriginal             = $data['montoTotalOriginal'];
        $montoTotalDevuelto             = $data['montoTotalDevuelto'];
        $montoDescuentoCreditoDebito    = $data['montoDescuentoCreditoDebito'];
        $montoEfectivoCreditoDebito     = $data['montoEfectivoCreditoDebito'];
        $codigoExcepcion                = $data['codigoExcepcion'];
        $usuario                        = $data['usuario'];
        $leyenda = $data['leyenda'];
        $codigoDocumentoSector          = '24';

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================
        

        $dom = new DomDocument('1.0', 'UTF-8');
        $dom->xmlStandalone = true;

        $root  = $dom->appendChild($dom->createElement('notaFiscalElectronicaCreditoDebito'));

        // Appending attr1 and attr2 to the root element
        $attr = $dom->createAttribute('xmlns:xsi');
        $attr->appendChild($dom->createTextNode('http://www.w3.org/2001/XMLSchema-instance'));
        $root->appendChild($attr);

        $attr = $dom->createAttribute('xsi:noNamespaceSchemaLocation');
        $attr->appendChild($dom->createTextNode('/creditoDebito/notaElectronicaCreditoDebito.xsd'));
        $root->appendChild($attr);

        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================

        //add NodeA element to Root
        $nodeA = $dom->createElement('cabecera');
        $root->appendChild($nodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nitEmisor',$nitEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('razonSocialEmisor',$razonSocialEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('municipio',$municipio);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('telefono',$telefono);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroNotaCreditoDebito',$numeroNotaCreditoDebito);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cuf',$cuf);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('cufd',$cufd);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoSucursal',$codigoSucursal);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('direccion',$direccion);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoPuntoVenta',$codigoPuntoVenta);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('fechaEmision',$fechaEmision);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nombreRazonSocial',$nombreRazonSocial);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoTipoDocumentoIdentidad',$codigoTipoDocumentoIdentidad);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroDocumento',$numeroDocumento);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('complemento',$complemento);
        $nodeA->appendChild($subnodeA);
        if ($complemento == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoCliente',$codigoCliente);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroFactura',$numeroFactura);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroAutorizacionCuf',$numeroAutorizacionCuf);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('fechaEmisionFactura',$fechaEmisionFactura);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotalOriginal',$montoTotalOriginal);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotalDevuelto',$montoTotalDevuelto);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoDescuentoCreditoDebito',$montoDescuentoCreditoDebito);
        $nodeA->appendChild($subnodeA);
        
        $subnodeA = $dom->createElement('montoEfectivoCreditoDebito',$montoEfectivoCreditoDebito);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoExcepcion',$codigoExcepcion);
        $nodeA->appendChild($subnodeA);
        if ($codigoExcepcion == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }


        //add NodeA element to Root
        $subnodeA = $dom->createElement('leyenda',$leyenda);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('usuario',$usuario);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoDocumentoSector', $codigoDocumentoSector);
        $nodeA->appendChild($subnodeA);

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================

        // SOLO PARA LAS NOTAS  DE CREDITO DEBITO SE HARA LA DEVOLUCION DE TODOS LOS PRODUCTOS
        foreach($lst_productos as $prod):
            $cat_devuelto = $prod->ocantidad;
            if ($cat_devuelto == 0) {
                //add NodeB element to Root
                $NodeB = $dom->createElement('detalle');
                $root->appendChild($NodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_economica);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('descripcion',$prod->oproducto);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('cantidad',$prod->ocant_original);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('precioUnitario',$prod->oprecio_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('montoDescuento',$prod->odescuento_original);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('subTotal',$prod->sub_total_real);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoDetalleTransaccion','1');
                $NodeB->appendChild($subnodeB);
            }else {
                //add NodeB element to Root
                $NodeB = $dom->createElement('detalle');
                $root->appendChild($NodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_economica);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('descripcion',$prod->oproducto);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('cantidad',$prod->ocant_original);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('precioUnitario',$prod->oprecio_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('montoDescuento',$prod->odescuento_original);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('subTotal',$prod->sub_total_real);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoDetalleTransaccion','1');
                $NodeB->appendChild($subnodeB);


                //add NodeB element to Root
                $NodeB = $dom->createElement('detalle');
                $root->appendChild($NodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_economica);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('descripcion',$prod->oproducto);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('cantidad',$prod->ocantidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('precioUnitario',$prod->oprecio_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('montoDescuento',$prod->descuento_devolucion);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('subTotal',$prod->osub_total);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoDetalleTransaccion','2');
                $NodeB->appendChild($subnodeB);
            }

        endforeach;
        $dom->formatOutput = true; // set the formatOutput attribute of domDocument to true

        // save XML as string or file
        $test1 = $dom->saveXML(); // put string in test1
        $dom->save(FCPATH.'assets/facturasxml/'.$cuf.'.xml');
        return $test1;
    }

    function NotaCreditoDebito($data,$lst_productos){
        
        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================
        $nombreRazonSocial =str_replace("'", "&apos;", $data['nombreRazonSocial']);
        $nombreRazonSocial =str_replace('"', "&quot;", $nombreRazonSocial);

        $nitEmisor                      = $data['nitEmisor'];
        $razonSocialEmisor              = $data['razonSocialEmisor'];
        $municipio                      = $data['municipio'];
        $telefono                       = $data['telefono'];
        $numeroNotaCreditoDebito        = $data['numeroNotaCreditoDebito'];
        $cuf                            = $data['cuf'];
        $cufd                           = $data['cufd'];
        $codigoSucursal                 = $data['codigoSucursal'];
        $direccion                      = $data['direccion'];
        $codigoPuntoVenta               = $data['codigoPuntoVenta'];
        $fechaEmision                   = $data['fechaEmision'];
        $nombreRazonSocial              = $this->xmlEscape($nombreRazonSocial);
        $codigoTipoDocumentoIdentidad   = $data['codigoTipoDocumentoIdentidad'];
        $numeroDocumento                = $data['numeroDocumento'];
        $complemento                    = $data['complemento'];
        $codigoCliente                  = $data['codigoCliente'];
        $numeroFactura                  = $data['numeroFactura'];
        $numeroAutorizacionCuf          = $data['numeroAutorizacionCuf'];
        $fechaEmisionFactura            = $data['fechaEmisionFactura'];
        $montoTotalOriginal             = $data['montoTotalOriginal'];
        $montoTotalDevuelto             = $data['montoTotalDevuelto'];
        $montoDescuentoCreditoDebito    = $data['montoDescuentoCreditoDebito'];
        $montoEfectivoCreditoDebito     = $data['montoEfectivoCreditoDebito'];
        $codigoExcepcion                = $data['codigoExcepcion'];
        $usuario                        = $data['usuario'];
        $leyenda = $data['leyenda'];
        $codigoDocumentoSector          = '24';

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================
        

        $dom = new DomDocument('1.0', 'UTF-8');
        $dom->xmlStandalone = true;

        $root  = $dom->appendChild($dom->createElement('notaFiscalComputarizadaCreditoDebito'));

        // Appending attr1 and attr2 to the root element
        $attr = $dom->createAttribute('xmlns:xsi');
        $attr->appendChild($dom->createTextNode('http://www.w3.org/2001/XMLSchema-instance'));
        $root->appendChild($attr);

        $attr = $dom->createAttribute('xsi:noNamespaceSchemaLocation');
        $attr->appendChild($dom->createTextNode('notaFiscalComputarizadaCreditoDebito.xsd'));
        $root->appendChild($attr);

        // =====================================================================================
        //                                         CABECERA
        // =====================================================================================

        //add NodeA element to Root
        $nodeA = $dom->createElement('cabecera');
        $root->appendChild($nodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nitEmisor',$nitEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('razonSocialEmisor',$razonSocialEmisor);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('municipio',$municipio);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('telefono',$telefono);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroNotaCreditoDebito',$numeroNotaCreditoDebito);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('cuf',$cuf);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('cufd',$cufd);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoSucursal',$codigoSucursal);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('direccion',$direccion);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoPuntoVenta',$codigoPuntoVenta);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('fechaEmision',$fechaEmision);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('nombreRazonSocial',$nombreRazonSocial);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoTipoDocumentoIdentidad',$codigoTipoDocumentoIdentidad);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroDocumento',$numeroDocumento);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('complemento',$complemento);
        $nodeA->appendChild($subnodeA);
        if ($complemento == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoCliente',$codigoCliente);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroFactura',$numeroFactura);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('numeroAutorizacionCuf',$numeroAutorizacionCuf);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('fechaEmisionFactura',$fechaEmisionFactura);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotalOriginal',$montoTotalOriginal);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoTotalDevuelto',$montoTotalDevuelto);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('montoDescuentoCreditoDebito',$montoDescuentoCreditoDebito);
        $nodeA->appendChild($subnodeA);
        
        $subnodeA = $dom->createElement('montoEfectivoCreditoDebito',$montoEfectivoCreditoDebito);
        $nodeA->appendChild($subnodeA);
        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoExcepcion',$codigoExcepcion);
        $nodeA->appendChild($subnodeA);
        if ($codigoExcepcion == '') {
            $attr = $dom->createAttribute('xsi:nil');
            $attr->appendChild($dom->createTextNode('true'));
            $subnodeA->appendChild($attr);
        }


        //add NodeA element to Root
        $subnodeA = $dom->createElement('leyenda',$leyenda);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('usuario',$usuario);
        $nodeA->appendChild($subnodeA);

        //add NodeA element to Root
        $subnodeA = $dom->createElement('codigoDocumentoSector', $codigoDocumentoSector);
        $nodeA->appendChild($subnodeA);

        // =====================================================================================
        //                                         DETALLE
        // =====================================================================================

        // SOLO PARA LAS NOTAS  DE CREDITO DEBITO SE HARA LA DEVOLUCION DE TODOS LOS PRODUCTOS
        foreach($lst_productos as $prod):
            $cat_devuelto = $prod->ocantidad;
            if ($cat_devuelto == 0) {
                //add NodeB element to Root
                $NodeB = $dom->createElement('detalle');
                $root->appendChild($NodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_economica);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('descripcion',$prod->oproducto);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('cantidad',$prod->ocant_original);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('precioUnitario',$prod->oprecio_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('montoDescuento',$prod->odescuento_original);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('subTotal',$prod->sub_total_real);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoDetalleTransaccion','1');
                $NodeB->appendChild($subnodeB);
            }else {
                //add NodeB element to Root
                $NodeB = $dom->createElement('detalle');
                $root->appendChild($NodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_economica);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('descripcion',$prod->oproducto);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('cantidad',$prod->ocant_original);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('precioUnitario',$prod->oprecio_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('montoDescuento',$prod->odescuento_original);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('subTotal',$prod->sub_total_real);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoDetalleTransaccion','1');
                $NodeB->appendChild($subnodeB);


                //add NodeB element to Root
                $NodeB = $dom->createElement('detalle');
                $root->appendChild($NodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('actividadEconomica',$prod->oactividad_economica);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProductoSin',$prod->ocodigo_sin);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoProducto',$prod->ocodigo);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('descripcion',$prod->oproducto);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('cantidad',$prod->ocantidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('unidadMedida',$prod->oid_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('precioUnitario',$prod->oprecio_unidad);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('montoDescuento',$prod->descuento_devolucion);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('subTotal',$prod->osub_total);
                $NodeB->appendChild($subnodeB);

                //add NodeA element to Root
                $subnodeB = $dom->createElement('codigoDetalleTransaccion','2');
                $NodeB->appendChild($subnodeB);
            }

        endforeach;
        $dom->formatOutput = true; // set the formatOutput attribute of domDocument to true

        // save XML as string or file
        $test1 = $dom->saveXML(); // put string in test1
        $dom->save(FCPATH.'assets/facturasxml/'.$cuf.'.xml');
        return $test1;
    }
    
    function xmlEscape($string) {
        return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }
   
}
