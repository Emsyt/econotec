<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------------------------
 * Modificado: Heidy Soliz Santos Fecha: 20/04/2021, Codigo:SYSGAM-001
 * Descripcion: Se modifico para que se pueda acceder a la vista pedido por codigo
 * -------------------------------------------------------------------------------------------------
 * Modificado: Brayan Janco Cahuana Fecha:17/08/2021, Codigo: GAN-FR-A4-018,
 * Descripcion: Se modifico para que se pueda acceder a la vista conversion paq/unid.
 * -------------------------------------------------------------------------------------------------
 * Modificado: Brayan Janco Cahuana Fecha:07/09/2021, Codigo: GAN-MS-A3-026,
 * Descripcion: Se modifico para que se pueda acceder a la vista abastecimiento y gastos.
 * -------------------------------------------------------------------------------------------------
 * Modificado: Brayan Janco Cahuana Fecha:14/09/2021, Codigo: GAN-MS-A4-028,
 * Descripcion: Se modifico para que se pueda acceder a la funcion que genera pdf tanto para
 * confirmacion de ventas y pedidos por codigo
 * -------------------------------------------------------------------------------------------------
 * Modificado: Brayan Janco Cahuana Fecha:27/09/2021, Codigo: GAN-MS-A4-038,
 * Descripcion: Se modifico para que se pueda acceder a la funcion generar_cotizacion que genera pdf.
 * -------------------------------------------------------------------------------------------------
 * Modificado: Brayan Janco Cahuana Fecha:11/11/2021, Codigo: GAN-MS-A5-078,
 * Descripcion: Se modifico para que se pueda acceder a la vista de reporte de creditos y tambien tambien se pueda acceder a las funciones que permiter generar pdf y excel
 * -------------------------------------------------------------------------------------------------
 * Modificado: Brayan Janco Cahuana Fecha:17/11/2021, GAN-MS-A4-092,
 * Descripcion: Se modifico para que se pueda acceder a la vista listado de ventas y tambien tambien se pueda acceder a las funciones que permiter generar pdf y excel
 * -------------------------------------------------------------------------------------------------
 * Modificado: Brayan Janco Cahuana Fecha:19/11/2021, Codigo: GAN-MS-A3-079,
 * Descripcion: Se modifico para que se pueda acceder a la funciones de reporte de ventas.
 *------------------------------------------------------------------------------
 *Modificado: Melvin Salvador Cussi Callisaya Fecha:22/03/2022, Codigo:GAN-MS-M6-136
 *Descripcion: se agrego la ruta para acceder a la funcion de pdf en el modelo listado_ventas
 *------------------------------------------------------------------------------
 *Modificado: Gabriela Mamani Choquehuanca Fecha:24/06/2022, Codigo:GAN-MS-A5-275,
 *Descripcion: Se modifico para que se pueda acceder a la vista C_ubicaciones.
 *------------------------------------------------------------------------------
 *Modificado: Melani Alisson Cusi Burgoa Fecha:02/09/2022, Codigo:GAN-FR-A1-433
 *Descripcion: Se modifico para que se pueda acceder a la vista C_permiso.
 *------------------------------------------------------------------------------
 *Modificado: Gary German Valverde Quisbert Fecha:16/09/2022, Codigo:GAN-MS-A1-462
 *Descripcion: Se agrego las rutas para los reportes de produccion
 *------------------------------------------------------------------------------
 *Modificado: Denilson Santander Rios Fecha:21/09/2022, Codigo:GAN-MS-A1-463
 *Descripcion: Se agrego rutas para acceder a la vista C_cierre_venta
 * -------------------------------------------------------------------------------------------------
 * Modificado: Deivit Pucho Aguilar Fecha: 26-04-2022, Codigo:GAN-FR-A1-483
 * Descripcion: Se creo una ruta para acceder a C_contizaciones del modulo de ventas.
 *  * -------------------------------------------------------------------------------------------------
 * Modificado: Luis Fabricio Pari Wayar: 04-10-2022, Codigo:GAN-MS-M4-0019
 * Descripcion: Se creo una ruta para acceder a C_inicial.
 *-----------------------------------------------------------------------------------------------------
 * Modificado: Pedro Rodrigo Beltran Poma Fecha: 27/10/2022 GAN-MS-A6-0071
 * Descripcion: Se agrego rutas para el modulo reporte_cotizacion
 *-----------------------------------------------------------------------------------------------------
 * Modificado: Alison Paola Pari Pareja Fecha: 17/11/2022 GAN-MS-A4-0061
 * Descripcion: Se agrego rutas para el modulo reporte_movimiento
 *-----------------------------------------------------------------------------------------------------
 * Modificado: Alison Paola Pari Pareja Fecha: 18/11/2022 GAN-MS-A7-0111
 * Descripcion: Se agrego rutas para el modulo de garantias
 *-----------------------------------------------------------------------------------------------------
 * Modificado: Kelly Ayde Gutierrez Condori Fecha: 21/11/2022 GAN-MS-A7-0125
 * Descripcion: Se agrego rutas para el modulo de garantias
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Adamary Margell Uchani Mamani Fecha: 22/11/2022 SAM-MS-A7-0001
 * Descripcion: Se creo modulo activos y submodulo de registro de activos
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Melani Alisson Cusi Burgoa Fecha:22/11/2022, Codigo:SAM-MS-A7-0002
 * Descripcion: Se creo el submodulo de listado de activos
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Keyla Paola Usnayo Aguilar Fecha:22/11/2022, Codigo:SAM-MS-A7-0003
 * Descripcion: Se creo el submodulo de bitacora de activos
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Melani Alisson Cusi Burgoa Fecha:24/11/2022, Codigo:SAM-MS-A7-0005
 * Descripcion: Se creo las rutas para crear pdf y excel del modulo activos/listado
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Alison Paola Pari Pareja Fecha:28/11/2022, Codigo:GAN-MS-A7-0142
 * Descripcion: Se creo las rutas para el submodulo items
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Alvaro Gonzales Vilte Fecha:14/12/2022, Codigo:GAN-DPR-A5-0180
 * Descripcion: Se creo las rutas para el modulo de cajas
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Ignacio Laquis Camargo Fecha:26/04/2022, Codigo:GAN-MS-B0-0439
 * Descripcion: Se elimino la ruta cierre_ventas, direccion a C_cierre_venta del Modulo Cierre de Ventas
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Dotnara Isabel Condori Fecha:09/05/2023, Codigo:GAN-DPR-B0-0446
 * Descripcion: Se creo las rutas para el submodulo rutas 
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Ayrton Jhonny Guevara Montaño Fecha:11/05/2023, Codigo:GAN-MS-B0-0455
 * Descripcion: Se creo las rutas para el submodulo de reporte de compras por consignacion 
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Ayrton Jhonny Guevara Montaño Fecha:19/05/2023, Codigo: GAN-DPR-B5-0478
 * Descripcion: Se creo la ruta para el submodulo de tickets en el modulo de promociones
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Ignacio Laquis Camargo Fecha:30/05/2023, Codigo: GAN-MS-M0-0504
 * Descripcion: Se creo la ruta para el submodulo de mesas en el modulo de administracion
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Ignacio Laquis Camargo Fecha:03/07/2023, Codigo: GAN-MS-M4-0529
 * Descripcion: Se creo la ruta para generar reporte pdf de un pedido del submodulo Venta Grafica en el modulo de Ventas
 * -------------------------------------------------------------------------------------------------------------------------------
 * Modificado: Ignacio Laquis Camargo Fecha:21/07/2023, Codigo: GAN-MS-A6-0549
 * Descripcion: Se creo la ruta para el submodulo Recepcion de Comandas en el modulo de Ventas
 * -------------------------------------------------------------------------------------------------------------------------------
 *
 */
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


$route['default_controller'] = 'C_login';


//Login
$route['login'] = 'C_login';
$route['logout'] = 'C_login/logout';
$route['errorrol'] = 'C_login/errorrol';
$route['error'] = 'C_login/error';
$route['verficar'] = 'C_login/verificar_usuario';


//Inicio
$route['inicio'] = 'C_inicio';
//GAN-MS-M4-0019 - 04/10/2022 LPari
$route['inicial'] = 'C_inicial';
//FIN GAN-MS-M4-0019 - 04/10/2022 LPari

//Perfil
$route['perfil'] = 'perfil/C_perfil';
$route['cambio_password'] = 'perfil/C_password';
$route['error_password'] = 'perfil/C_password/error';
$route['bloquo_sesion'] = 'perfil/C_bloqueo';
$route['error_desbloqueo'] = 'perfil/C_bloqueo/error_desbloqueo';


//Produccion
$route['produccion'] = 'produccion/C_produccion';
$route['salida_produccion'] = 'produccion/C_salida_produccion';


//Provision
$route['provision'] = 'provision/C_provision';
$route['almacen'] = 'provision/C_almacen';
$route['solicitud'] = 'provision/C_solicitud';

$route['envio'] = 'provision/C_envio';

$route['conf_solicitud'] = 'provision/C_solicitud/confirmacion_solicitud';
$route['conversion'] = 'provision/C_conversion_paquete';
$route['stock'] = 'provision/C_stock';
$route['lst_stock'] = 'provision/C_stock/get_lst_stock';
$route['recepciones'] = 'provision/C_recepcion_pedidos';
//Inicio GAN-DPR-B5-0373 ALKG 23/03/2023
$route['listar_compras'] = 'provision/C_listar_abastecimiento';
//FIN GAN-DPR-B5-0373 ALKG  23/03/2023

// GAN-DPR-B0-0446 Fecha:09/05/2023 DCondori
//Distribucion
$route['rutas'] = 'distribucion/C_rutas';
// Fin GAN-DPR-B0-0446 Fecha:09/05/2023 DCondori

//Producto
$route['categoria'] = 'producto/C_categoria';
$route['marca'] = 'producto/C_marca';
$route['producto'] = 'producto/C_producto';
$route['lstproductos'] = 'producto/C_producto/products';
$route['importar'] = 'producto/C_importar';
$route['importar_car'] = 'producto/C_importar_car';
$route['add_datos'] = 'producto/C_importar/add_datos';
$route['add_datos_car'] = 'producto/C_importar_car/add_datos';
$route['lst_archivos'] = 'producto/C_importar/lst_archivos';
$route['items'] = 'producto/C_items';
$route['mostrar_lotes_garantia'] = 'producto/C_items/mostrar_lotes_garantia';
$route['validar_cantidad_serie'] = 'producto/C_items/validar_cantidad_serie';
$route['registro_serie'] = 'producto/C_items/registro_serie';
$route['listar_series'] = 'producto/C_items/listar_series';
$route['add_edit_serie'] = 'producto/C_items/add_edit_serie';
$route['recuperar_serie'] = 'producto/C_items/recuperar_serie';
$route['eliminar_serie'] = 'producto/C_items/eliminar_serie';
$route['buscador'] = 'producto/C_buscador';
$route['lst_productos_buscador'] = 'producto/C_buscador/lst_productos';
$route['list_precios_buscador'] = 'producto/C_buscador/list_precios';
$route['lst_stock_sucursales'] = 'producto/C_buscador/lst_stock_sucursales';

$route['pdf_serie'] = 'producto/C_items/pdf_serie';
//Marca
$route['ltsmarcas'] = 'producto/C_marca/lista_marca';

//Activos
$route['registro_activo'] = 'activos/C_registro';
$route['listado'] = 'activos/C_listado';
$route['bitacora'] = 'activos/C_bitacora';
$route['listado_pdf'] = 'activos/C_listado/generar_pdf_listado';
$route['listado_excel'] = 'activos/C_listado/generar_excel_listado';

//Clientes
$route['cliente'] = 'cliente/C_cliente';


//Proveedores
$route['proveedor'] = 'proveedor/C_proveedor';


//Venta
$route['pedido'] = 'venta/C_pedido';
$route['generar_cotizacion'] = 'venta/C_pedido/generar_pdf_cotizacion';

$route['venta'] = 'venta/C_venta';
$route['conf_venta'] = 'venta/C_venta/confirmacion_venta';
$route['generar_venta'] = 'venta/C_venta/generar_pdf_venta';

$route['pedidoCodigo'] = 'venta/C_pedidoCodigo';
$route['generar_venta_cod'] = 'venta/C_pedidoCodigo/generar_pdf_venta_codigo';
//GAN-FR-A1-483 26-09-2022 DPucho
$route['cotizaciones'] = 'venta/C_cotizaciones';
$route['pdf_cotizacion'] = 'venta/C_cotizaciones/generar_pdf_venta_codigo';
//fin GAN-FR-A1-483 26-09-2022 DPucho
// GAN-MS-M4-0529 03-07-2023 ILaquis
$route['generar_pdf_pedido'] = 'venta/C_venta_grafica/generar_pdf_pedido';
// FIN GAN-MS-M4-0529 03-07-2023 ILaquis

$route['listado_ventas'] = 'venta/C_listado_ventas';
$route['lst_listado_ventas'] = 'venta/C_listado_ventas/lst_listado_ventas';
$route['ingresos_reporte_ventas'] = 'venta/C_listado_ventas/ingresos_reporte_ventas';
$route['pdf_historial_ventas'] = 'venta/C_listado_ventas/generar_pdf_historial_ventas';
$route['pdf_listado_ventas'] = 'venta/C_listado_ventas/generar_pdf_listado_ventas';
$route['excel_listado_ventas'] = 'venta/C_listado_ventas/generar_excel_listado_ventas';
$route['pdf_nota_venta'] = 'venta/C_listado_ventas/generar_pdf_cotizacion';

$route['venta_facturada'] = 'venta/C_venta_facturada';
$route['generar_venta_codigo'] = 'venta/C_venta_facturada/pdf_facturacion';
$route['listado_factura'] = 'venta/C_listado_facturas';

$route['venta_grafica'] = 'venta/C_venta_grafica';
// GAN-MS-A6-0549 21-07-2023 ILaquis
$route['recepcion_comanda'] = 'venta/C_recepcion_comanda';
// FIN GAN-MS-A6-0549 21-07-2023 ILaquis

//Facturacion
$route['sucursal'] = 'facturacion/C_sucursal';
$route['punto_venta'] = 'facturacion/C_punto_venta';
$route['evento_offline'] = 'facturacion/C_eventos_sin_linea';
$route['evento_contingencia'] = 'facturacion/C_eventos_contigencia';
$route['anulacion_factura'] = 'facturacion/C_anulacion';
$route['factura_manual'] = 'facturacion/C_factura_manual';
$route['factura_configuracion'] = 'facturacion/C_configuracion';

//Actividades
$route['tarea'] = 'actividades/C_tarea';
//Cajas
$route['apertura'] = 'cajas/C_apertura';
$route['datos_apertura'] = 'cajas/C_apertura/datos_apertura';
$route['flujo'] = 'cajas/C_flujo';
$route['cierre'] = 'cajas/C_cierre';
$route['datos_cierre'] = 'cajas/C_cierre/datos_cierre';
$route['registrar_cierre'] = 'cajas/C_cierre/registrar_cierre';
//Garantias
$route['registro_garantia'] = 'garantias/C_registro_garantia';
$route['get_lst_garantias1'] = 'garantias/C_registro_garantia/get_lst_garantias1';
$route['registrar_garantia'] = 'garantias/C_registro_garantia/registrar_garantia';
$route['ejecucion'] = 'garantias/C_ejecucion';
$route['retorno'] = 'garantias/C_retorno';
$route['get_retorno'] = 'garantias/C_retorno/get_retorno';
$route['realizar_retorno'] = 'garantias/C_retorno/realizar_retorno';

//Promociones
$route['promociones'] = 'promociones/C_promociones';
//Ayrton Guevara 19/05/2023 GAN-DPR-B5-0478
$route['tickets'] = 'promociones/C_ticket';
$route['pdf_tickets'] = 'promociones/C_ticket/generar_pdf_ticket';
$route['pdf_reporte_abast_pagar'] = 'promociones/C_ticket/generar_pdf_ticket';

//Gastos
$route['gastos'] = 'gastos/C_gastos';

//recursos humanos
$route['file'] = 'recursos/C_file';
$route['feriado'] = 'recursos/C_feriado';
$route['vacaciones'] = 'recursos/C_vacaciones';
$route['file_personal'] = 'recursos/C_file';
$route['planilla'] = 'recursos/C_planilla';
$route['asistencia'] = 'recursos/C_asistencia';
$route['biometrico'] = 'recursos/C_biometrico';
$route['importar_biometrico'] = 'recursos/C_biometrico/datos_biometrico_excel';
$route['importar_biometrico_dat'] = 'recursos/C_biometrico/datos_biometrico_dat';
$route['add_biometrico'] = 'recursos/C_biometrico/add_biometrico';
$route['add_biometrico_dat'] = 'recursos/C_biometrico/add_biometrico_dat';
$route['lst_archivos_biometrico'] = 'recursos/C_biometrico/lst_archivos_biometrico';
$route['desvinculacion'] = 'recursos/C_desvinculacion';
$route['lstformacademic'] = 'recursos/C_file/lstformacionacademica';
$route['lstcurs'] = 'recursos/C_file/lstcursos';

//Administracion
$route['usuarios'] = 'administracion/C_usuario';
$route['asignacion_rol'] = 'administracion/C_usuario/asignacion_rol';
$route['ajustes'] = 'administracion/C_ajustes';
$route['informacion'] = 'administracion/C_informacion';
$route['ubicaciones'] = 'administracion/C_ubicaciones';
$route['unidades'] = 'administracion/C_unidades';
$route['permiso'] = 'administracion/C_permiso';
$route['mesas'] = 'administracion/C_mesas';


//Reportes
$route['reporte_ventas'] = 'reporte/C_reporte_ventas';
$route['lst_reporte_ventas'] = 'reporte/C_reporte_ventas/lst_reporte_ventas';
$route['pdf_reporte_ventas'] = 'reporte/C_reporte_ventas/generar_pdf_ventas';
$route['excel_reporte_ventas'] = 'reporte/C_reporte_ventas/generar_excel_ventas';

$route['reporte_inventarios'] = 'reporte/C_reporte_inventarios';
$route['pdf_reporte_inventarios'] = 'reporte/C_reporte_inventarios/generar_pdf_inventarios';
$route['excel_reporte_inventarios'] = 'reporte/C_reporte_inventarios/generar_excel_inventarios';

$route['reporte_abastecimiento'] = 'reporte/C_reporte_abastecimiento';
$route['lst_reporte_abastecimiento'] = 'reporte/C_reporte_abastecimiento/lst_reporte_abastecimiento';
$route['pdf_reporte_abastecimiento'] = 'reporte/C_reporte_abastecimiento/generar_pdf_abastecimiento';
$route['excel_reporte_abastecimiento'] = 'reporte/C_reporte_abastecimiento/generar_excel_abastecimiento';

$route['reporte_gastos'] = 'reporte/C_reporte_gastos';
$route['lst_reporte_gastos'] = 'reporte/C_reporte_gastos/lst_reporte_gastos';
$route['pdf_reporte_gastos'] = 'reporte/C_reporte_gastos/generar_pdf_gastos';
$route['excel_reporte_gastos'] = 'reporte/C_reporte_gastos/generar_excel_gastos';

$route['reporte_creditos'] = 'reporte/C_reporte_creditos';
$route['lst_reporte_creditos'] = 'reporte/C_reporte_creditos/lst_reporte_creditos';
$route['pdf_reporte_creditos'] = 'reporte/C_reporte_creditos/generar_pdf_creditos';
$route['pdf_reporte_historial'] = 'reporte/C_reporte_creditos/generar_pdf_historial';
$route['excel_reporte_creditos'] = 'reporte/C_reporte_creditos/generar_excel_creditos';

$route['reporte_abast_pagar'] = 'reporte/C_reporte_abast_pagar';
$route['lst_reporte_abast_pagar'] = 'reporte/C_reporte_abast_pagar/lst_reporte_abast_pagar';
$route['pdf_reporte_abast_pagar'] = 'reporte/C_reporte_abast_pagar/generar_pdf_abast_pagar';
$route['pdf_reporte_historial_abast_pagar'] = 'reporte/C_reporte_abast_pagar/generar_pdf_historial_abast_pagar';
$route['excel_reporte_abast_pagar'] = 'reporte/C_reporte_abast_pagar/generar_excel__abast_pagar';

/*GAN-MS-B0-0455 Ayrton Guevara 02/05/2023*/
$route['reporte_abast_consig'] = 'reporte/C_reporte_abast_consig';
$route['lst_reporte_abast_consig'] = 'reporte/C_reporte_abast_consig/lst_reporte_abast_consig';
$route['pdf_reporte_abast_consig'] = 'reporte/C_reporte_abast_consig/generar_pdf_abast_consig';
//$route['pdf_reporte_historial_abast_consig'] = 'reporte/C_reporte_abast_consig/generar_pdf_historial_abast_consig';
//$route['excel_reporte_abast_consig'] = 'reporte/C_reporte_abast_consig/generar_excel_abast_consig';
/*FIN GAN-MS-B0-0455 Ayrton Guevara 02/05/2023*/

$route['reporte_stock'] = 'reporte/C_reporte_stock';
$route['pdf_reporte_stock'] = 'reporte/C_reporte_stock/generar_pdf_stock';
$route['excel_reporte_stock'] = 'reporte/C_reporte_stock/generar_excel_stock';

/* GAN-MS-A1-462 Gary Valverde 16-09-2022 */
$route['reporte_produccion'] = 'reporte/C_reporte_produccion';
$route['lst_reporte_produccion'] = 'reporte/C_reporte_produccion/lst_reporte_produccion';
$route['pdf_reporte_produccion'] = 'reporte/C_reporte_produccion/generar_pdf_produccion';
$route['excel_reporte_produccion'] = 'reporte/C_reporte_produccion/generar_excel_produccion';
/*FIN GAN-MS-A1-462 Gary Valverde 16-09-2022 */

/* GAN-MS-A0-0057 Gary Valverde 19-10-2022 */
$route['reporte_ganancias'] = 'reporte/C_reporte_ganancias';
$route['lst_reporte_ganancias'] = 'reporte/C_reporte_ganancias/lst_reporte_ganancias';
$route['pdf_reporte_ganancias'] = 'reporte/C_reporte_ganancias/generar_pdf_ganancias';
$route['excel_reporte_ganancias'] = 'reporte/C_reporte_ganancias/generar_excel_ganancias';
/*FIN GAN-MS-A0-0057 Gary Valverde 19-10-2022 */

// GAN-MS-A6-71, PBeltran 27/10/2022
$route['reporte_cotizacion'] = 'reporte/C_reporte_cotizacion';
$route['lst_listado_cotizacion'] = 'reporte/C_reporte_cotizacion/lst_listado_cotizacion';
$route['reporte_cotizacion'] = 'reporte/C_reporte_cotizacion';
$route['pdf_nota_cotizacion'] = 'reporte/C_reporte_cotizacion/generar_pdf_cotizacion';
$route['pdf_listado_cotizacion'] = 'reporte/C_reporte_cotizacion/generar_pdf_listado_cotizacion';
$route['excel_listado_cotizacion'] = 'reporte/C_reporte_cotizacion/generar_excel_listado_cotizacion';
//FIN GAN-MS-A6-71, PBeltran 27/10/2022

$route['reporte_movimiento'] = 'reporte/C_reporte_movimiento';
$route['lst_reporte_movimiento'] = 'reporte/C_reporte_movimiento/lst_reporte_movimiento';
$route['pdf_reporte_movimiento'] = 'reporte/C_reporte_movimiento/generar_pdf_movimiento';
$route['excel_reporte_movimiento'] = 'reporte/C_reporte_movimiento/generar_excel_movimiento';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
