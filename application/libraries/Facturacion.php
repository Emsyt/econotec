<?php

// Definimos la ruta donde se encuentran nuestras clases de la librería
$directory = dirname(__FILE__) . '/lib_facturacion/';

// Si no se ha definido la constante BASEPATH, salimos del script
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Incluimos todas las clases necesarias para nuestra librería
require_once $directory . 'Operaciones.php';
require_once $directory . 'Codigos.php';
require_once $directory . 'Sincronizacion.php';
require_once $directory . 'FacturacionCompraVenta.php';
require_once $directory . 'DocumentoAjuste.php';
require_once $directory . 'GeneradorCuf.php';
require_once $directory . 'GeneradorXml.php';
require_once $directory . 'FuncionesAux.php';
require_once $directory . 'ConvertidorLetras.php';

// Creamos la clase principal de nuestra librería
class Facturacion
{
    public function __construct()
    {
        // Aquí podemos inicializar variables o hacer cualquier otra cosa que necesitemos al momento de instanciar nuestra clase
    }
}
