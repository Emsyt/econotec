<?php

class GeneradorCuf
{
    public $Nit;
    public $CodigoSucursal;
    public $CodigoModalidad;
    public $CodigoEmision;
    public $TipoFactura;
    public $TipoDocumentoSector;
    public $CodigoPuntoVenta;
    public $CodigoControl;

    /*  Crear el array $DatosCuf con los datos de entrada
        $DatosCuf = array(
            'Nit'                 => 'Nit',
            'CodigoSucursal'      => 'CodigoSucursal',
            'CodigoModalidad'     => 'CodigoModalidad',
            'CodigoEmision'       => 'CodigoEmision',
            'TipoFactura'         => 'TipoFactura',
            'TipoDocumentoSector' => 'TipoDocumentoSector',
            'CodigoPuntoVenta'    => 'CodigoPuntoVenta',
            'CodigoControl'       => 'CodigoControl'
        );
    */
    function __construct($DatosCuf)
    {
        // Verificar si se ha proporcionado un array válido
        if (is_array($DatosCuf)) {
            // Asignar los datos del array a las propiedades
            $this->Nit                  = isset($DatosCuf['Nit']) ? str_pad($DatosCuf['Nit'], 13, "0", STR_PAD_LEFT) : '';
            $this->CodigoSucursal       = isset($DatosCuf['CodigoSucursal']) ? str_pad($DatosCuf['CodigoSucursal'], 4, "0", STR_PAD_LEFT) : '';
            $this->CodigoModalidad      = isset($DatosCuf['CodigoModalidad']) ? $DatosCuf['CodigoModalidad'] : '';
            $this->CodigoEmision        = isset($DatosCuf['CodigoEmision']) ? $DatosCuf['CodigoEmision'] : '';
            $this->TipoFactura          = isset($DatosCuf['TipoFactura']) ? $DatosCuf['TipoFactura'] : '';
            $this->TipoDocumentoSector  = isset($DatosCuf['TipoDocumentoSector']) ? str_pad($DatosCuf['TipoDocumentoSector'], 2, "0", STR_PAD_LEFT) : '';
            $this->CodigoPuntoVenta     = isset($DatosCuf['CodigoPuntoVenta']) ? str_pad($DatosCuf['CodigoPuntoVenta'], 4, "0", STR_PAD_LEFT) : '';
            $this->CodigoControl        = isset($DatosCuf['CodigoControl']) ? $DatosCuf['CodigoControl'] : '';
        }
    }

    /**
     * Método para obtener Cuf generado mas la fecha actual
     * @return array del cuf y fecha
     */
    public function generarCuf($Nrofactura)
    {
        date_default_timezone_set("America/La_Paz");

        // Obtener la fecha y hora actual con microtime en la zona horaria de "America/La_Paz"
        $microtime = microtime(true);
        $fecha = DateTime::createFromFormat('U.u', $microtime, new DateTimeZone('UTC'));
        $fecha->setTimezone(new DateTimeZone('America/La_Paz'));
        $fecha = $fecha->format("YmdHisv");

        // Longitud requerida en FECHA/HORA y NÚMERO DE FACTURA
        $fecha = str_pad($fecha, 17, "0", STR_PAD_LEFT);
        $Nrofactura = str_pad($Nrofactura, 10, "0", STR_PAD_LEFT);

        // Verificar longitud de nit
        if (strlen($this->Nit) != 13) {
            return ['success' => false, 'error' => "La longitud del NIT no es menor ó igual a 13 caracteres para el generado del CUF."];
        }

        // Verificar longitud de la fecha
        if (strlen($fecha) != 17) {
            return ['success' => false, 'error' => "La longitud de la FECHA no es menor ó igual a 17 caracteres para el generado del CUF."];
        }

        // Verificar longitud de la sucursal
        if (strlen($this->CodigoSucursal) != 4) {
            return ['success' => false, 'error' => "La longitud de la SUCURSAL no es menor ó igual a 4 caracteres para el generado del CUF."];
        }

        // Verificar longitud de la modalidad
        if (strlen($this->CodigoModalidad) != 1) {
            return ['success' => false, 'error' => "La longitud del MODALIDAD no es igual a 1 caracter para el generado del CUF."];
        }

        // Verificar longitud de la emision
        if (strlen($this->CodigoEmision) != 1) {
            return ['success' => false, 'error' => "La longitud de la EMISION no es igual a 1 caracter para el generado del CUF."];
        }

        // Verificar longitud del tipo factura
        if (strlen($this->TipoFactura) != 1) {
            return ['success' => false, 'error' => "La longitud de la TIPO FACTURA / DOCUMENTO AJUSTE no es igual a 1 caracter para el generado del CUF."];
        }

        // Verificar longitud del tipo documento sector
        if (strlen($this->TipoDocumentoSector) != 2) {
            return ['success' => false, 'error' => "La longitud de la TIPO DOCUMENTO SECTOR no es menor ó igual a 2 caracteres para el generado del CUF."];
        }

        // Verificar longitud del numero de factura
        if (strlen($Nrofactura) != 10) {
            return ['success' => false, 'error' => "La longitud del NÚMERO DE FACTURA no es menor ó igual a 10 caracteres para el generado del CUF."];
        }

        // Verificar longitud de la emision
        if (strlen($this->CodigoPuntoVenta) != 4) {
            return ['success' => false, 'error' => "La longitud del PUNTO DE VENTA no es menor ó igual a 4 caracteres para el generado del CUF."];
        }

        // Generar cadena para el CUF
        $cadena = $this->Nit . $fecha . $this->CodigoSucursal . $this->CodigoModalidad . $this->CodigoEmision . $this->TipoFactura . $this->TipoDocumentoSector . $Nrofactura . $this->CodigoPuntoVenta . "";
        $valMod11 = $this->Modulo11($cadena);
        $cadena .= $valMod11 . "";

        // Verificar longitud de la emision
        if (strlen($cadena) != 54) {
            return ['success' => false, 'error' => "La longitud total del CUF no es igual a 54 caracteres para el generado del CUF."];
        }

        // Convertir a base 16
        $base16 = $this->convBase($cadena);

        // Generar CUF final
        $cuf = $base16 . $this->CodigoControl;

        // Obtener fecha y hora de envío en formato requerido
        $fechaEnvio = $fecha;
        $fechaEnvio = substr_replace($fechaEnvio, '-', 4, 0);
        $fechaEnvio = substr_replace($fechaEnvio, '-', 7, 0);
        $fechaEnvio = substr_replace($fechaEnvio, 'T', 10, 0);
        $fechaEnvio = substr_replace($fechaEnvio, ':', 13, 0);
        $fechaEnvio = substr_replace($fechaEnvio, ':', 16, 0);
        $fechaEnvio = substr_replace($fechaEnvio, '.', 19, 0);

        $data = array(
            'success' => true,
            'cuf' => strtoupper($cuf),
            'fecha' => $fechaEnvio
        );
        return $data;
    }



    /**
     * Método para obtener Cuf generado mas la fecha anterior
     * @return array del cuf y fecha
     */
    public function generarCufManual($Nrofactura, $FechaAntigua)
    {
        date_default_timezone_set("America/La_Paz");

        // Remover caracteres especiales de la fecha antigua
        $fecha = str_replace(array('-', ':', '.', ' '), '', $FechaAntigua);
        $fecha = str_replace('T', '', $fecha);

        // Longitud requerida en FECHA/HORA y NÚMERO DE FACTURA
        $fecha = str_pad($fecha, 17, "0", STR_PAD_LEFT);
        $Nrofactura = str_pad($Nrofactura, 10, "0", STR_PAD_LEFT); 

        // Verificar longitud de nit
        if (strlen($this->Nit) != 13) {
            return ['success' => false, 'error' => "La longitud del NIT no es menor ó igual a 13 caracteres para el generado del CUF."];
        }

        // Verificar longitud de la fecha
        if (strlen($fecha) != 17) {
            return ['success' => false, 'error' => "La longitud de la FECHA no es menor ó igual a 17 caracteres para el generado del CUF."];
        }

        // Verificar longitud de la sucursal
        if (strlen($this->CodigoSucursal) != 4) {
            return ['success' => false, 'error' => "La longitud de la SUCURSAL no es menor ó igual a 4 caracteres para el generado del CUF."];
        }

        // Verificar longitud de la modalidad
        if (strlen($this->CodigoModalidad) != 1) {
            return ['success' => false, 'error' => "La longitud del MODALIDAD no es igual a 1 caracter para el generado del CUF."];
        }

        // Verificar longitud de la emision
        if (strlen($this->CodigoEmision) != 1) {
            return ['success' => false, 'error' => "La longitud de la EMISION no es igual a 1 caracter para el generado del CUF."];
        }

        // Verificar longitud del tipo factura
        if (strlen($this->TipoFactura) != 1) {
            return ['success' => false, 'error' => "La longitud de la TIPO FACTURA / DOCUMENTO AJUSTE no es igual a 1 caracter para el generado del CUF."];
        }

        // Verificar longitud del tipo documento sector
        if (strlen($this->TipoDocumentoSector) != 2) {
            return ['success' => false, 'error' => "La longitud de la TIPO DOCUMENTO SECTOR no es menor ó igual a 2 caracteres para el generado del CUF."];
        }

        // Verificar longitud del numero de factura
        if (strlen($Nrofactura) != 10) {
            return ['success' => false, 'error' => "La longitud del NÚMERO DE FACTURA no es menor ó igual a 10 caracteres para el generado del CUF."];
        }

        // Verificar longitud de la emision
        if (strlen($this->CodigoPuntoVenta) != 4) {
            return ['success' => false, 'error' => "La longitud del PUNTO DE VENTA no es menor ó igual a 4 caracteres para el generado del CUF."];
        }

        // Generar cadena para el CUF
        $cadena = $this->Nit . $fecha . $this->CodigoSucursal . $this->CodigoModalidad . $this->CodigoEmision . $this->TipoFactura . $this->TipoDocumentoSector . $Nrofactura . $this->CodigoPuntoVenta . "";
        $valMod11 = $this->Modulo11($cadena);
        $cadena .= $valMod11 . "";

        // Verificar longitud de la emision
        if (strlen($cadena) != 54) {
            return ['success' => false, 'error' => "La longitud total del CUF no es igual a 54 caracteres para el generado del CUF."];
        }

        // Convertir a base 16
        $base16 = $this->convBase($cadena);

        // Generar CUF final
        $cuf = $base16 . $this->CodigoControl;

        // Obtener fecha y hora de envío en formato requerido
        $fechaEnvio = str_replace(' ', 'T', $FechaAntigua);

        $data = array(
            'success' => true,
            'cuf' => strtoupper($cuf),
            'fecha' => $fechaEnvio
        );
        return $data;
    }


    private function Modulo11($pCadena)
    {
        $vDigito = $this->calcularDigitosModulo11($pCadena, 1, 9, false);
        return $vDigito;
    }

    private function calcularDigitosModulo11($input, $num_digitos, $limit, $x10)
    {
        $mult   = null; 
        $sum    = null; 
        $i      = null; 
        $n      = null; 
        $digit  = null;

        if (!$x10) $num_digitos = 1;

        for ($n = 1; $n <= $num_digitos; $n++) {
            $sum = 0; $mult = 2;
            $input_arr = str_split($input); // Convert string to an array
            for ($i = (strlen($input) - 1); $i >= 0; $i--) {
                $sum = $sum + ($mult * $input_arr[$i]); // Use array to fetch digits
                $mult = $mult + 1;
                if ($mult > $limit){
                    $mult = 2;
                } 
            }

            if ($x10) {
                $digit = (($sum * 10) % 11) % 10;
            } else {
                $digit = $sum % 11;
            }
            if ($digit == 10) {
                $input = $input."1";
            }
            if ($digit == 11) {
                $input = $input."0";
            }
            if ($digit < 10) {
                $input = $input.$digit;
            }
        }
        return substr($input, -1);
    }

    private function convBase($str)
    {
        $dec = str_split($str);
        $sum = array();
        $hex = array();

        while (count($dec)) {
            $s = 1 * array_shift($dec);
            for ($i = 0; $s || $i < count($sum); $i++) {
                $x = 0;
                if (isset($sum[$i])) {
                    $x = $sum[$i];
                }
                $s += $x * 10;
                $sum[$i] = $s % 16;
                $s = ($s - $sum[$i]) / 16;
            }
        }

        while (count($sum)) {
            $t = array_pop($sum);
            $t = dechex($t);
            $hex[] = $t;
        }

        return implode("", $hex);
    }
}
