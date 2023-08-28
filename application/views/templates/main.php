<?php
/* 
  ---------------------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha: 20/04/2021, Codigo:SYSGAM-001
  Descripcion: Se modifico el menu venta para que se pueda acceder a la vista pedido por codigo
  ---------------------------------------------------------------------------------------------
  Modificado: Luis Andres Cachaga Leuca Fecha: 11/07/2021, Codigo:GAN-MS-A6-004
  Descripcion: Se agrego un campo para las notificaciones se excluyen los permisos
  ---------------------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:17/08/2021, Codigo: GAN-FR-A4-018,
  Descripcion: Se modifico el menu provision para que se pueda acceder a la vista conversion paq/unid.
  ---------------------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:07/09/2021, Codigo: GAN-MS-A3-026,
  Descripcion: Se modifico el menu reportes para que se pueda acceder a la vista abastecimiento y gastos.
  ---------------------------------------------------------------------------------------------
  Modificado: Fabian Alejandro Candia Alvizuri Fecha:23/09/2021, Codigo: GAN-FR-M3-030,
  Descripcion: Se agrego al menu el campo gastos para que se pueda acceder a la vista
  ---------------------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:11/11/2021, Codigo: GAN-MS-A5-078,
  Descripcion: Se agrego al menu el campo reporte de creditos para que se pueda acceder a la vista
  ---------------------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:17/11/2021, GAN-MS-A4-092,
  Descripcion: Se agrego al menu el campo listado de venta para que se pueda acceder a la vista
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:14/04/2022, Codigo:GAN-FR-A5-157
  Descripcion: se cambiaron los nombres/titulos segun lo acordado en la reunion
  ------------------------------------------------------------------------------
  Modificado: Saul Imanol Quiroga Castrillo Fecha:07/06/2022, Codigo:GAN-MS-M1-268
  Descripcion: se elimino el show modal de notificaciones alojado en la funcion visto, se agrego data-toggle y data-target en las notificaciones para su visualizacion
  ------------------------------------------------------------------------------
  Modificado: Gabriela Mamani Choquehuanca Fecha:24/06/2022,  Codigo:GAN-MS-A5-275,
  Descripcion: Se adiciono en al BEGIN ADMINISTRACION el campo de Ubicaciones  para que se pueda acceder a la vista
  ------------------------------------------------------------------------------
  Modificado: Ronaldo Alcon Fecha:22/06/2022, Codigo:GAN-MS-A5-280
  Descripcion: Se modifico la parte de notificaciones, con un scroll que permita mover las notificaciones
  ------------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa Fecha:02/09/2022, Codigo:GAN-FR-A1-433
  Descripcion: Se modifico el menu administracion para que se pueda acceder a la vista permiso.
  ------------------------------------------------------------------------------
  Modificado: Keyla Paola Usnayo Aguilar Fecha:15/09/2022, Codigo:GAN-MS-A1-464
  Descripcion: Se cambio Abastecimiento por Compras
  ------------------------------------------------------------------------------
  Modificado: Denilson Santander Rio Fecha:21/09/2022, Codigo:GAN-MS-A1-463
  Descripcion: Se modifico el menu ventas para acceder a cierre_venta
  ------------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma Fecha:22/09/2022, Codigo:GAN-MS-A1-477
  Descripcion: Se agrego las verificaciones de permisos a promociones y gastos.
  ------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar Fecha:26/09/2022, Codigo:GAN-FR-A1-483
  Descripcion: Se agrego nuevo modulo en lista llamado cotizaciones.
  ------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar Fecha:06/10/2022, Codigo:GAN-MS-M2-0033
  Descripcion: Se modifico el campo del titulo para no redireccionar al dashboard
  y en el menu validar que si un usuario no tiene permisos DASHBOARD no tenga esa opcion.
  ------------------------------------------------------------------------------
  Modificado: Alvaro Ruben Gonzales Vilte Fecha:13/10/2022, Codigo:GAN-DPR-B5-0043
  Descripcion: Se modifico el modulo de notificaciones en el despliegue de la
  notificacion para poner el indicador de la prioridad de la misma
  ------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar Fecha:14/10/2022, Codigo:GAN-MS-M0-0048
  Descripcion: Se modifico la opcion de dashboard en el menu para que se redirecciones a INICIO
  si es que ese usuario tiene permiso de dashboard
  ------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar Fecha:19/10/2022, Codigo:GAN-DPR-M6-0060
  Descripcion: Se modifico el menu provision para que se pueda acceder a la vista envio de producto.
  -------------------------------------------------------------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma Fecha: 26/10/2022 GAN-MS-A6-0071
  Descripcion: Se agrego el menu para el modulo reporte cotizaciones
  -------------------------------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha: 09/11/2022 GAN-MS-A0-0097
  Descripcion: Se normalizo el funcionamiento del modulo de permisos para los accesos del menu del sistema
-------------------------------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha: 17/11/2022 GAN-MS-A4-0061
  Descripcion: Se creo el sub modulo reporte de movimiento y se adicionaron los permisos
  -------------------------------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha: 18/11/2022 GAN-MS-A7-0111
  Descripcion: Se creo modulo garantias y submodulos
-------------------------------------------------------------------------------------------------------------------------------
  Modificado: Kelly Ayde Gutierrez Condori Fecha: 21/11/2022 GAN-MS-A7-0125
  Descripcion: Se creo modulo actividades y submodulos
-------------------------------------------------------------------------------------------------------------------------------
  Modificado: Adamary Margell Uchani Mamani Fecha: 22/11/2022 SAM-MS-A7-0001
  Descripcion: Se creo modulo activos y submodulo de registro de activo
-------------------------------------------------------------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa Fecha:22/11/2022, Codigo:SAM-MS-A7-0002
  Descripcion: Se creo el submodulo de listado de activos
-------------------------------------------------------------------------------------------------------------------------------
Modificado:  Keyla Paola Usnayo Aguilar Fecha:22/11/2022, Codigo:SAM-MS-A7-0003
Descripcion: Se creo el submodulo de bitacoras de activos  
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:28/11/2022, Codigo:GAN-MS-A7-0142
Descripcion: Se creo el sub modulo en el modulo de PRODUCTOS que se llama ITEMS
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Jose Daniel Luna Flores Fecha: 02/12/2022, Codigo:GAN-MS-M5-0154
Descripcion: Se modifico la visualizacion de cabecera aumentando la ubicacion del usuario logueado  
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alvaro Gonzales Vilte Fecha: 13/12/2022, Codigo:GAN-SC-A6-0179
Descripcion: Se agrego el modulo de CAJAS con los submodulos de apertura, flujo, cierre
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Kevin Gerardo Alcon Lazarte Fecha: 16/02/2023, Codigo:GAN-MS-B0-0288
Descripcion: Se agrego la funcion coki() para porder visualizar las tablas en aprobar_solicitud.php
------------------------------------------------------------------------------
Modificado: Oscar Laura Aguirre    Fecha: 27/02/2023   Codigo: GAN-DPR-B3-0308
Descripcion : se modifico el nombre de Bitacora a historico
------------------------------------------------------------------------------
Modificado: Oscar Laura Aguirre    Fecha: 28/02/2023   Codigo: GAN-MS-B3-0313
Descripcion : se agrego un nuvo modulo de recursos humanos y sus sub modulos, 
asistencia, biometrico,planillas, feriados,vacaciones,beneficios,desvinculacion, file personal
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo    Fecha: 26/0242023,   Codigo: GAN-MS-B0-0439
Descripcion: Del BEGIN MENUBAR se elimino Cierre Ventas del menu Ventas, que estaba entre Listado de Ventas y Cotizaciones
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Dotnara Isabel Condori Fecha:09/05/2023, Codigo:GAN-DPR-B0-0446
Descripcion: Se creo las rutas para el submodulo rutas  y el modulo de distribucion y tambien se hizo el cambio de icono de distribucion y de provicion
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ayrton Jhonny Guevara Montaño Fecha:11/05/2023, Codigo:GAN-MS-B0-0455
Descripcion: Se creo las rutas para el submodulo de reporte de compras por consignacion 
------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------
Modificado: Dotnara Isabel condori Condori Fecha:12/05/2023, Codigo:GAN-MS-B1-0463
Descripcion: se modifico el nombre de los id de los menus para que se activen de
manera adecuada al seleccionarse rutas
------------------------------------------------------------------------------------------------------------------------------
Modificado: Ayrton Jhonny Guevara Montaño Fecha:19/05/2023, Codigo: GAN-DPR-B5-0478
Descripcion: Se creo la ruta para el submodulo de tickets en el modulo de promociones
------------------------------------------------------------------------------------------------------------------------------
Modificado:Ignacio Laquis Camargo Fecha:30/05/2023, Codigo: GAN-MS-M0-0504
Descripcion: Se creo la ruta para el submodulo de mesas en el modulo de administracion
------------------------------------------------------------------------------------------------------------------------------
Modificado:Ignacio Laquis Camargo Fecha:21/07/2023, Codigo: GAN-MS-A6-0549
Descripcion: Se creo la ruta para el submodulo de Recepcion de Comandas en el modulo de Ventas
------------------------------------------------------------------------------------------------------------------------------
*/

?>

<script>
    $(document).ready(function() {
        function miFuncion() {
            //console.log("ejecutando miFuncion()");
            var esteMomento = new Date();
            var fecha = esteMomento.toLocaleDateString();
            var partesFecha = fecha.split("/");
            var dia = partesFecha[0];
            var mes = partesFecha[1];
            var anio = partesFecha[2];
            dia = dia.padStart(2, "0");
            mes = mes.padStart(2, "0");
            var fechaFormateada = dia + "-" + mes + "-" + anio;
            var hora = (esteMomento.getHours()).toString();
            console.log(hora.length);
            hora = hora.padStart(2, "0");
            console.log("Hora: "+hora);
            $.ajax({
                url: "<?php echo site_url('C_inicio/verificar_hora') ?>/" + hora + '/' + fechaFormateada,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    if (data["oboolean"] == "f") {
                        if (data["odateorhour"] == 1) {
                            document.getElementById("errorhora").style.display = "block";
                            document.getElementById("errorhora").title = data["omensaje"];
                        }
                        if (data["odateorhour"] == 2) {
                            document.getElementById("errorfecha").style.display = "block";
                            document.getElementById("errorfecha").title = data["omensaje"];
                        }
                    } else {
                        document.getElementById("errorfecha").style.display = "none";
                        document.getElementById("errorhora").style.display = "none";
                    }
                }
            });
        }

        miFuncion(); // llamada a la función
    });

    function visto(id_notificacion, notificacion, prioridad) {
        $('#text_modal').html(notificacion);
        $('#prioridad_modal').text(prioridad);
        if (prioridad == 'BAJA') {
            $('#prioridad_modal').css('color', 'green');
        } else if (prioridad == 'MEDIA') {
            $('#prioridad_modal').css('color', 'orange');
        } else {
            $('#prioridad_modal').css('color', 'red');
        }
        $.ajax({
            url: "<?php echo site_url('C_inicio/leer_notificacion') ?>/" + id_notificacion,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $("#NumNotificaciones").load(" #NumNotificaciones");
                $("#notifications").load(" #notifications");
            }
        });
    }
    //Inicio GAN-MS-B0-0288,16/02/2023, KGAL
    function coki() {
        document.cookie = "lote = ;";
        document.cookie = "solicitante = ;";
        location.href = "<?php echo base_url(); ?>solicitud";
    }
    //Fin GAN-MS-B0-0288,16/02/2023, KGAL
</script>
<style>
    .btn i {
        margin-right: 5px;
    }

    .fechahora {
        display: block;
    }


    @media screen and (max-width:600px) {

        /* Cuando este en movil */
        .fechahora {
            display: none;
        }
    }

    @media screen and (min-width:600px) {

        /* Cuando este en movil */
        .fa-clock-o {
            display: none;
        }
    }
</style>
<!-- BEGIN HEADER-->
<header id="header">
    <div class="headerbar">
        <div class="headerbar-left">
            <ul class="header-nav header-nav-options">
                <li class="header-nav-brand">
                    <div class="brand-holder">
                        <!--GAN-MS-M2-0033 Fecha:06/10/2022 LPari-->
                        <?php if (in_array("dashboard", $permisos)) { ?>
                            <a href="<?= base_url(); ?>inicio">
                                <span class="text-lg text-bold" style="color:#00793a"><?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                                                                                        print_r($obj->{'titulo'}); ?></span></a>
                        <?php } else { ?>
                            <a href="<?= base_url(); ?>inicial">
                                <span class="text-lg text-bold" style="color:#00793a"><?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                                                                                        print_r($obj->{'titulo'}); ?></span></a>
                        <?php } ?>
                        <!--Fin GAN-MS-M2-0033 Fecha:06/10/2022 LPari-->
                    </div>
                </li>
                <li>
                    <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!-- RELOJ -->

        <div class="headerbar-right">
            <!-- se implemento la campana de las notificaciones el foreach para leer las notificaciones y un echo de la cantidad que se muestra en caso de que exista notificaciones y una etiqueta a para modificar el estado de la notificacion a leido-->

            <ul class="header-nav header-nav-options">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
                        <i class="fa fa-clock-o"></i>
                    </a>
                    <ul class="dropdown-menu animation-expand">
                        <li class="dropdown-header">
                            <!-- Combo de reloj -->
                            <i id="errorfecha" class="fa fa-exclamation-circle" style="color:red;float:left; padding-right: 5px; display:none;" title="La fecha no coincide con la zona horaria de la base de datos"></i>
                            <div id="fechamodal" style="font-size: 15px;color:#585755;"></div>
                            <i id="errorhora1" class="fa fa-exclamation-circle" style="color:red;float:left; padding-right: 5px; display:none;" title="La hora no coincide con la zona horaria de la base de datos"></i>
                            <div id="relojmodal1" style="font-size: 15px;color:#585755;"></div>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="fechahora" style="width:100px">
                        <i id="errorfecha" class="fa fa-exclamation-circle" style="color:red;float:left; padding-right: 5px; display:none;" title="La fecha no coincide con la zona horaria de la base de datos"></i>
                        <div id="fecha"></div>
                        <i id="errorhora" class="fa fa-exclamation-circle" style="color:red;float:left; padding-right: 5px; display:none;" title="La hora no coincide con la zona horaria de la base de datos"></i>
                        <div id="reloj"></div>
                    </div>
                    <script>
                        function actualizarReloj() {
                            var fecha = new Date();
                            var horas = formatoDosDigitos(fecha.getHours());
                            var minutos = formatoDosDigitos(fecha.getMinutes());
                            var segundos = formatoDosDigitos(fecha.getSeconds());
                            var tiempo = horas + ":" + minutos + ":" + segundos;
                            var esteMomento = new Date();
                            var fecha = esteMomento.toLocaleDateString();
                            var partesFecha = fecha.split("/");
                            var dia = partesFecha[0];
                            var mes = partesFecha[1];
                            var anio = partesFecha[2];
                            dia = dia.padStart(2, "0");
                            mes = mes.padStart(2, "0");
                            var fechaFormateada = dia + "/" + mes + "/" + anio;
                            document.getElementById('fecha').innerHTML = fechaFormateada;
                            document.getElementById("reloj").textContent = tiempo;
                        }

                        function actualizarRelojModal() {
                            var fecha = new Date();
                            var horas = formatoDosDigitos(fecha.getHours());
                            var minutos = formatoDosDigitos(fecha.getMinutes());
                            var segundos = formatoDosDigitos(fecha.getSeconds());
                            var tiempo = horas + ":" + minutos + ":" + segundos;
                            var esteMomento = new Date();
                            var fecha = esteMomento.toLocaleDateString();
                            var partesFecha = fecha.split("/");
                            var dia = partesFecha[0];
                            var mes = partesFecha[1];
                            var anio = partesFecha[2];
                            dia = dia.padStart(2, "0");
                            mes = mes.padStart(2, "0");
                            var fechaFormateada = dia + "/" + mes + "/" + anio;
                            document.getElementById('fechamodal1').innerHTML = fechaFormateada;
                            document.getElementById("relojmodal1").textContent = tiempo;
                        }

                        function formatoDosDigitos(numero) {
                            return (numero < 10 ? "0" : "") + numero;
                        }

                        setInterval(actualizarReloj, 1000);
                        //setInterval(actualizarRelojModal, 1000);
                    </script>
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0);" class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
                        <i class="fa fa-bell"></i><sup class="badge style-danger" id="NumNotificaciones"> <?php foreach ($cantidadN as $cantidad) {
                                                                                                                echo $cantidad->ocantnotificaciones;
                                                                                                            } ?> </sup>
                    </a>
                    <ul class="dropdown-menu animation-expand">
                        <li class="dropdown-header"><?php foreach ($cantidadN as $cantidad) {
                                                        echo $cantidad->ocantnotificaciones;
                                                    } ?> Mensajes de Notificaci&oacuten</li>
                        <li class="lista_notificaciones">
                            <div id="notifications" style="height:57vh; overflow-y:scroll; min-width: 250px;">
                                <table class="table table-hover" id="notifi">
                                    <thead>
                                        <tr class="alert">
                                            <th>Nro</th>
                                            <th>Detalles</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div id="data_notifications">
                                            <?php $nro = 0;
                                            foreach ($lst_noti as $notificacion) {
                                                $nro++;
                                                if ($notificacion->prioridad == 'ALTA') {
                                                    $alert = 'alert-danger';
                                                }
                                                if ($notificacion->prioridad == 'MEDIA') {
                                                    $alert = 'alert-warning';
                                                }
                                                if ($notificacion->prioridad == 'BAJA') {
                                                    $alert = 'alert-success';
                                                }
                                            ?>
                                                <tr class="selected; alert alert-callout <?php echo $alert ?>">
                                                    <td><?php echo $nro;
                                                        $id_notificacion = $notificacion->oidnotificacion;
                                                        $text_notificacion = $notificacion->odetallenotif;
                                                        $prioridad_notificacion = $notificacion->prioridad;
                                                        ?></td><!-- se agrego el data-toggle y data-target-->
                                                    <td><button name="notificacion" class="button-notificacion" data-toggle="modal" data-target="#modal_notificaciones" onclick="visto(<?php echo $id_notificacion ?>,'<?php echo $text_notificacion ?>','<?php echo $prioridad_notificacion ?>')">
                                                            <?php echo $text_notificacion ?></button></td>
                                                    <td><i class="glyphicon glyphicon-check"></i></td>
                                                </tr>
                                            <?php }  ?>
                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
            <ul class="header-nav header-nav-profile">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                        <?php $foto = $this->session->userdata('foto');
                        if (empty($foto)) { ?>
                            <img src="<?php echo base_url('assets/img/personal/default-user.png'); ?>" alt="" />
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>assets/img/personal/<?php echo $foto ?>" alt="" />
                        <?php } ?>
                        <span class="profile-info">
                            <?php echo $this->session->userdata('nombre') ?>
                            <small><?php echo $this->session->userdata('cargo') ?></small>
                            <!-- INICIO JLuna 02/12/2022 GAN-MS-M5-0154-->
                            <strong>
                                <font color="green"><?php echo $this->session->userdata('name_ubicacion') ?></font>
                            </strong>
                            <!-- FIN JLuna 02/12/2022 GAN-MS-M5-0154-->
                        </span>
                    </a>
                    <ul class="dropdown-menu animation-dock">
                        <li class="dropdown-header">Configuraci&oacute;n</li>
                        <li id="menuHeader1"><a href="<?= base_url(); ?>perfil">Mi perfil</a></li>
                        <li id="menuHeader2"><a href="<?= base_url(); ?>cambio_password">Cambiar Contrase&ntilde;a</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?= base_url(); ?>bloquo_sesion"><i class="fa fa-fw fa-lock"></i> Bloquear</a></li>
                        <li><a href="<?= base_url(); ?>logout"><i class="fa fa-fw fa-power-off text-danger"></i> Cerrar
                                sesi&oacute;n</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- END HEADER-->
<!-- Modal -->
<div class="modal fade modal-notificacion" id="modal_notificaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">NOTIFICACI&Oacute;N</h4>
            </div>
            <div class="modal-body">
                <div id="text_modal"></div>
                <p></p>
                Prioridad: <span id="prioridad_modal"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN BASE-->
<div id="base">
    <!-- BEGIN OFFCANVAS LEFT -->
    <div class="offcanvas">
    </div>
    <!-- END OFFCANVAS LEFT -->

    <!-- BEGIN MENUBAR-->
    <div id="menubar" class="menubar-inverse animate">
        <div class="menubar-scroll-panel">
            <!-- BEGIN MAIN MENU -->
            <ul id="main-menu" class="gui-controls">
                <!-- BEGIN INICIO -->

                <!--GAN-MS-M0-0048 Fecha:14/10/2022 LPari-->
                <?php if (in_array("dashboard", $permisos)) { ?>
                    <li>
                        <a href="<?= base_url(); ?>inicio" id="menu1">
                            <div class="gui-icon"><i class="fa fa-home fa-lg"></i></div>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                <?php } ?>
                <!--Fin GAN-MS-M0-0048 Fecha:14/10/2022 LPari-->

                <!-- END INICIO -->

                <!-- BEGIN PRODUCCION -->
                <?php if (in_array("mod_produc", $permisos)) { ?>
                    <li class="gui-folder">
                        <a id="menu10">
                            <div class="gui-icon"><i class="glyphicon glyphicon-object-align-vertical"></i></div>
                            <span class="title">Producci&oacute;n</span>
                        </a>
                        <ul>
                            <?php if (in_array("smod_ing_prod", $permisos)) { ?>
                                <li>
                                    <a id="menu10_1" href="<?= base_url(); ?>produccion">
                                        <span class="title">Ingreso</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_sal_prod", $permisos)) { ?>
                                <li>
                                    <a id="menu10_2" href="<?= base_url(); ?>salida_produccion">
                                        <span class="title">Salida</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <!-- END PRODUCCION -->

                <!-- BEGIN PROVISION -->
                <?php if (in_array("mod_prov", $permisos)) { ?>
                    <li class="gui-folder">
                        <a id="menu9">
                            <!--GAN-DPR-B0-0446 Fecha:09/05/2023 DCondori-->
                            <div class="gui-icon"><i class="fa fa-warehouse"></i></div>
                            <!--Fin GAN-DPR-B0-0446 Fecha:06/05/2023 DCondori-->
                            <span class="title">Provisi&oacute;n </span>
                        </a>
                        <ul>
                            <?php if (in_array("smod_comp", $permisos)) { ?>
                                <li>
                                    <a id="menu9_1" href="<?= base_url(); ?>provision">
                                        <span class="title">Compras</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_sol_prod", $permisos)) { ?>
                                <li>
                                    <a id="menu9_2" href="<?= base_url(); ?>almacen">
                                        <span class="title">Solicitud de Productos</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_sol_realiz", $permisos)) { ?>
                                <li>
                                    <a id="menu9_3" href="<?= base_url(); ?>solicitud">
                                        <!-- Inicio GAN-MS-B0-0288,16/02/2023, KGAL-->
                                        <span class="title" onclick="coki()">Solicitudes Realizadas</span>
                                        <!-- Fin GAN-MS-B0-0288, 16/02/2023 ,KGAL-->
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_rep_soli", $permisos)) { ?>
                                <li>
                                    <a id="menu9_4" href="<?= base_url(); ?>recepciones">
                                        <span class="title">Recepción de solicitudes</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_env_prod", $permisos)) { ?>
                                <li>
                                    <a id="menu9_5" href="<?= base_url(); ?>envio">
                                        <span class="title">Envio de producto</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_conv_paq_unid", $permisos)) { ?>
                                <li>
                                    <a id="menu9_6" href="<?= base_url(); ?>conversion">
                                        <span class="title">Conversion Paq/Unid.</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_stock", $permisos)) { ?>
                                <li>
                                    <a id="menu9_7" href="<?= base_url(); ?>stock">
                                        <span class="title">Stock</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <!-- INICIO GAN-DPR-B5-0373 ALKG 23/03/2023 -->
                            <?php if (in_array("smod_abastecimiento", $permisos)) { ?>
                                <li>
                                    <a id="menu9_8" href="<?= base_url(); ?>listar_compras">
                                        <span class="title">Listado de Compras</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <!-- FIN  GAN-DPR-B5-0373 ALKG 23/03/2023 -->
                        </ul>
                    </li>
                <?php } ?>
                <!-- END PROVISION -->

            <!--GAN-DPR-B0-0446 Fecha:09/05/2023 DCondori-->
                <!-- BEGIN DISTRIBUCION -->
                <?php if (in_array("mod_distribucion", $permisos)) { ?>
                    <li class="gui-folder">
                        <a id="menu18">
                            <div class="gui-icon">
                                <i class="fa fa-truck"></i>
                            </div>
                            <span class="title">Distribuci&oacute;n  </span>
                        </a>
                        <ul>
                            <?php if (in_array("smod_rutas", $permisos)) { ?>
                                <li>
                                    <a id="menu18_1" href="<?= base_url(); ?>rutas">
                                        <span class="title">Rutas</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_hist", $permisos)) { ?>
                                <li>
                                    <a id="menu18_2" href="<?= base_url(); ?>historial">
                                        <span class="title">Historial</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <!-- END DISTRIBUCION -->
            <!--Fin GAN-DPR-B0-0446 Fecha:09/05/2023 DCondori-->

                <!-- BEGIN PRODUCTOS -->
                <?php if (in_array("mod_prod", $permisos)) { ?>
                    <li class="gui-folder">
                        <a id="menu2">
                            <div class="gui-icon"><i class="fa fa-shopping-cart"></i></div>
                            <span class="title">Productos</span>
                        </a>
                        <ul>
                            <?php if (in_array("smod_cat", $permisos)) { ?>
                                <li>
                                    <a id="menu2_1" href="<?= base_url(); ?>categoria">
                                        <span class="title">Categor&iacute;as</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_marc", $permisos)) { ?>
                                <li>
                                    <a id="menu2_2" href="<?= base_url(); ?>marca">
                                        <span class="title">Marcas</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_prod", $permisos)) { ?>
                                <li>
                                    <a id="menu2_3" href="<?= base_url(); ?>producto">
                                        <span class="title">Productos</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_imp", $permisos)) { ?>
                                <li>
                                    <a id="menu2_4" href="<?= base_url(); ?>importar">
                                        <span class="title">Importar</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_items", $permisos)) { ?>
                                <li>
                                    <a id="menu2_5" href="<?= base_url(); ?>items">
                                        <span class="title">Items</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_buscador", $permisos)) { ?>
                                <li>
                                    <a id="menu2_6" href="<?= base_url(); ?>buscador">
                                        <span class="title">Buscador</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_imp_car", $permisos)) { ?>
                                <li>
                                    <a id="menu2_4" href="<?= base_url(); ?>importar_car">
                                        <span class="title">Importar caracteristicas</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <!-- END PRODUCTOS -->

                <!-- BEGIN ACTIVOS -->
                <?php if (in_array("mod_activos", $permisos)) { ?>
                    <li class="gui-folder">
                        <a id="menu14">
                            <div class="gui-icon"><i class="fa fa-archive" aria-hidden="true"></i></div>
                            <span class="title">Activos</span>
                        </a>
                        <ul>
                            <?php if (in_array("smod_reg_act", $permisos)) { ?>
                                <li>
                                    <a id="menu14_1" href="<?= base_url(); ?>registro_activo">
                                        <span class="title">Registro</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <ul>
                            <?php if (in_array("smod_list_act", $permisos)) { ?>
                                <li>
                                    <a id="menu14_2" href="<?= base_url(); ?>listado">
                                        <span class="title">Listado</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <ul>
                            <?php if (in_array("smod_bit", $permisos)) { ?>
                                <li>
                                    <a id="menu14_3" href="<?= base_url(); ?>bitacora">
                                        <!-- INICIO Oscar L., GAN-DPR-B3-0308 -->
                                        <span class="title">Historico</span>
                                        <!-- FIN GAN-DPR-B3-0308 -->
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <!-- END ACTIVOS -->

                <!-- BEGIN CLIENTES -->
                <?php if (in_array("mod_cli", $permisos)) { ?>
                    <li>
                        <a id="menu3" href="<?= base_url(); ?>cliente">
                            <div class="gui-icon"><i class="fa fa-user-secret"></i></div>
                            <span class="title">Clientes</span>
                        </a>
                    </li>
                <?php } ?>
                <!-- END CLIENTES  -->

                <!-- BEGIN PROVEEDORES -->
                <?php if (in_array("mod_prov", $permisos)) { ?>
                    <li>
                        <a id="menu4" href="<?= base_url(); ?>proveedor">
                            <div class="gui-icon"><i class="fa fa-users"></i></div>
                            <span class="title">Proveedores</span>
                        </a>
                    </li>
                <?php } ?>
                <!-- END PROVEEDORES  -->

                <!-- BEGIN VENTAS -->
                <?php if (in_array("mod_venta", $permisos)) { ?>
                    <li class="gui-folder">
                        <a id="menu5">
                            <div class="gui-icon"><i class="fa fa-money"></i></div>
                            <span class="title">Ventas</span>
                        </a>
                        <ul>
                            <?php if (in_array("smod_vent_caj", $permisos)) { ?>
                                <li><a id="menu5_1" href="<?= base_url(); ?>pedido"><span class="title">Venta en Caja
                                        </span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_cobr_caj", $permisos)) { ?>
                                <li><a id="menu5_2" href="<?= base_url(); ?>venta"><span class="title">Cobro en Caja </span></a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_vent_rap", $permisos)) { ?>
                                <li><a id="menu5_3" href="<?= base_url(); ?>pedidoCodigo"><span class="title">Venta
                                            R&aacute;pida </span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_list_vent", $permisos)) { ?>
                                <li><a id="menu5_4" href="<?= base_url(); ?>listado_ventas"><span class="title">Listado de
                                            Ventas </span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_cotz", $permisos)) { ?>
                                <li><a id="menu5_6" href="<?= base_url(); ?>cotizaciones"><span class="title">Cotizaciones
                                        </span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_vent_fact", $permisos)) { ?>
                                <li><a id="menu5_7" href="<?= base_url(); ?>venta_facturada"><span class="title">Venta Facturada
                                        </span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_list_fact", $permisos)) { ?>
                                <li><a id="menu5_8" href="<?= base_url(); ?>listado_factura"><span class="title">Listado de Facturas
                                        </span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_vent_graf", $permisos)) { ?>
                                <li><a id="menu5_9" href="<?= base_url(); ?>venta_grafica"><span class="title">Venta Grafica
                                        </span></a></li>
                            <?php } ?>
                            <!--GAN-MS-A6-0549 21-07-2023 ILaquis-->
                            <?php if (in_array("smod_rec_com", $permisos)) { ?>
                                <li><a id="menu5_10" href="<?= base_url(); ?>recepcion_comanda"><span class="title">Recepcion de Comandas
                                        </span></a></li>
                            <?php } ?>
                            <!--FIN GAN-MS-A6-0549 21-07-2023 ILaquis-->
                        </ul>
                    </li>
                <?php } ?>
                <!-- END VENTAS -->

                <!-- BEGIN FACTURACION -->
                <?php if (in_array("mod_fact", $permisos)) { ?>
                    <li class="gui-folder">
                        <a id="menu17">
                            <div class="gui-icon"><i class="fa fa-money"></i></div>
                            <span class="title">Facturación</span>
                        </a>
                        <ul>
                            <?php if (in_array("smod_fact_sucur", $permisos)) { ?>
                                <li><a id="menu17_7" href="<?= base_url(); ?>sucursal"><span class="title">Sucursal
                                        </span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_fact_puntv", $permisos)) { ?>
                                <li><a id="menu17_1" href="<?= base_url(); ?>punto_venta"><span class="title">Punto de Venta
                                        </span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_fact_event_offline", $permisos)) { ?>
                                <li><a id="menu17_2" href="<?= base_url(); ?>evento_offline"><span class="title">Eventos Fuera de Linea</span></a>
                                </li>
                            <?php } ?>
                            <?php if (in_array("smod_fact_event_cont", $permisos)) { ?>
                                <li><a id="menu17_3" href="<?= base_url(); ?>evento_contingencia"><span class="title">Eventos de Contingencia</span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_fact_anul", $permisos)) { ?>
                                <li><a id="menu17_4" href="<?= base_url(); ?>anulacion_factura"><span class="title">Anulacion de Facturas</span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_fact_manu", $permisos)) { ?>
                                <li><a id="menu17_5" href="<?= base_url(); ?>factura_manual"><span class="title">Registro Facturas Manuales</span></a></li>
                            <?php } ?>
                            <?php if (in_array("smod_fact_conf", $permisos)) { ?>
                                <li><a id="menu17_6" href="<?= base_url(); ?>factura_configuracion"><span class="title">Configuración
                                        </span></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <!-- END FACTURACION -->

                <!-- BEGIN CAJAS -->
                <?php if (in_array("mod_cajas", $permisos)) { ?>
                    <li class="gui-folder">
                        <a id="menu15">
                            <div class="gui-icon"><i class="glyphicon glyphicon-inbox"></i></div>
                            <span class="title">Cajas</span>
                        </a>
                    <?php } ?>
                    <ul>
                        <?php if (in_array("smod_caja_apertura", $permisos)) { ?>
                            <li><a id="menu15_1" href="<?= base_url(); ?>apertura"><span class="title">Apertura</span></a></li>
                        <?php } ?>

                        <?php if (in_array("smod_caja_flujo", $permisos)) { ?>
                            <li><a id="menu15_2" href="<?= base_url(); ?>flujo"><span class="title">Flujo</span></a></li>
                        <?php } ?>

                        <?php if (in_array("smod_caja_cierre", $permisos)) { ?>
                            <li><a id="menu15_3" href="<?= base_url(); ?>cierre"><span class="title">Cierre</span></a></li>
                        <?php } ?>
                    </ul>
                    </li>

                    <!-- END CAJAS -->

                    <!-- BEGIN ACTIVIDADES -->
                    <?php if (in_array("mod_actividades", $permisos)) { ?>
                        <li class="gui-folder">
                            <a id="menu13">
                                <div class="gui-icon"><i class="glyphicon glyphicon-stats"></i></div>
                                <span class="title">Actividades</span>
                            </a>
                        <?php } ?>
                        <ul>
                            <?php if (in_array("smod_tar_act", $permisos)) { ?>
                                <li><a id="menu13_1" href="<?= base_url(); ?>tarea"><span class="title">Tarea</span></a></li>

                            <?php }
                            ?>
                        </ul>
                        </li>

                        <!-- END ACTIVIDADES -->

                        <!-- BEGIN GARANTIAS -->
                        <?php if (in_array("mod_garantia", $permisos)) { ?>
                            <li class="gui-folder">
                                <a id="menu12">
                                    <div class="gui-icon"><i class="fa fa-money"></i></div>
                                    <span class="title">Garant&iacute;as</span>
                                </a>
                                <ul>
                                    <?php if (in_array("smod_reg_gar", $permisos)) { ?>
                                        <li><a id="menu12_1" href="<?= base_url(); ?>registro_garantia"><span class="title">Registro
                                                </span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_ejec_gar", $permisos)) { ?>
                                        <li><a id="menu12_2" href="<?= base_url(); ?>ejecucion"><span class="title">Ejecuci&oacute;n</span></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array("smod_ret_gar", $permisos)) { ?>
                                        <li><a id="menu12_3" href="<?= base_url(); ?>retorno"><span class="title">Retorno</span></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- END GARANTIAS -->

                        <!-- BEGIN REPORTES -->
                        <?php if (in_array("mod_rep", $permisos)) { ?>
                            <li class="gui-folder">
                                <a id="menu6">
                                    <div class="gui-icon"><i class="fa fa-bar-chart"></i></div>
                                    <span class="title">Reportes</span>
                                </a>

                                <ul>
                                    <?php if (in_array("smod_rep_vent", $permisos)) { ?>
                                        <li><a id="menu6_1" href="<?= base_url(); ?>reporte_ventas"><span class="title">Reporte de
                                                    Ventas</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_rep_inv", $permisos)) { ?>
                                        <li><a id="menu6_2" href="<?= base_url(); ?>reporte_inventarios"><span class="title">Reporte de
                                                    Inventarios</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_rep_abast", $permisos)) { ?>
                                        <li><a id="menu6_3" href="<?= base_url(); ?>reporte_abastecimiento"><span class="title">Reporte
                                                    de Compras</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_rep_gast", $permisos)) { ?>
                                        <li><a id="menu6_4" href="<?= base_url(); ?>reporte_gastos"><span class="title">Reporte de
                                                    Gastos</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_rep_vent_cred", $permisos)) { ?>
                                        <li><a id="menu6_5" href="<?= base_url(); ?>reporte_creditos"><span class="title">Reporte de
                                                    Ventas a Credito</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_rep_abast_pag", $permisos)) { ?>
                                        <li><a id="menu6_6" href="<?= base_url(); ?>reporte_abast_pagar"><span class="title">Reporte de
                                                    Compras por Pagar</span></a></li>
                                    <?php } ?>
                                        <!--GAN-MS-B0-0455 Ayrton Guevara 11/05/2023-->
                                    <?php if (in_array("smod_rep_abast_cons", $permisos)) { ?>
                                        <li><a id="menu6_12" href="<?= base_url(); ?>reporte_abast_consig"><span class="title">Reporte de
                                                    Compras por Consignaci&oacute;n</span></a></li>
                                    <?php } ?>
                                        <!--GAN-MS-B0-0455 Ayrton Guevara 11/05/2023-->
                                    <?php if (in_array("smod_rep_ajst_stock", $permisos)) { ?>
                                        <li><a id="menu6_7" href="<?= base_url(); ?>reporte_stock"><span class="title">Reporte de Ajuste
                                                    de Stock</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_rep_prod", $permisos)) { ?>
                                        <li><a id="menu6_8" href="<?= base_url(); ?>reporte_produccion"><span class="title">Reporte de
                                                    Producci&oacute;n</span></a></li>
                                    <?php } ?>
                                    <!-- GAN-MS-A0-0057 Gary Valverde 19-10-2022 -->
                                    <?php if (in_array("smod_rep_ganc", $permisos)) { ?>
                                        <li><a id="menu6_9" href="<?= base_url(); ?>reporte_ganancias"><span class="title">Reporte de
                                                    Ganancias</span></a></li>
                                    <?php } ?>
                                    <!-- fin GAN-MS-A0-0057 Gary Valverde 19-10-2022 -->

                                    <!-- GAN-MS-A6-0071 PBeltran 26-10-2022 -->
                                    <?php if (in_array("smod_rep_cot", $permisos)) { ?>
                                        <li><a id="menu6_10" href="<?= base_url(); ?>reporte_cotizacion"><span class="title">Reporte de
                                                    Cotizaciones</span></a></li>
                                    <?php } ?>
                                    <!-- FIN GAN-MS-A6-0071 PBeltran 26-10-2022 -->
                                    <?php if (in_array("smod_rep_mov", $permisos)) { ?>
                                        <li><a id="menu6_11" href="<?= base_url(); ?>reporte_movimiento"><span class="title">Reporte de
                                                    Movimiento</span></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- END REPORTES -->

                        <!-- BEGIN PROMOCIONES -->
                        <?php if (in_array("mod_prom", $permisos)) { ?>
                            <li class="gui-folder">
                                <a id="menu11">
                                    <div class="gui-icon"><i class="fa fa-ticket"></i></div>
                                    <span class="title">Promociones</span>
                                </a>

                                <ul>
                                    <?php if (in_array("smod_prom_desc", $permisos)) { ?>
                                        <li><a id="menu11_1" href="<?= base_url(); ?>promociones"><span class="title">Promociones y
                                                    descuentos</span></a></li>
                                    <?php } ?>
                                    <!--GAN-MS-B5-0455 Ayrton Guevara 19/05/2023-->
                                    <?php if (in_array("smod_prom_tick", $permisos)) { ?>
                                        <li><a id="menu11_2" href="<?= base_url(); ?>tickets"><span class="title">Tickets</span></a></li>
                                    <?php } ?>
                                    <!--GAN-MS-B5-0455 Ayrton Guevara 19/05/2023-->
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- END PROMOCIONES -->


                        <!-- BEGIN GASTOS -->

                        <?php if (in_array("mod_gast", $permisos)) { ?>
                            <li>
                                <a id="menu7" href="<?= base_url() ?>gastos">
                                    <div class="gui-icon"><i class="fa fa-dollar"></i></div>
                                    <span class="title">Gastos</span>
                                </a>
                            </li>
                        <?php } ?>
                        <!-- END GASTOS -->

                        <!-- Inicio Oscar Laura Aguirre GAN-MS-B3-0313,28/02/2023, -->
                        <!-- BEGIN RECURSOS HUMANOS -->
                        <?php if (in_array("mod_rec_hum", $permisos)) { ?>
                            <li class="gui-folder">
                                <a id="menu16">
                                    <div class="gui-icon"><i class="fa fa-user"></i></div>
                                    <span class="title">Recursos Humanos</span>
                                </a>
                                <ul>
                                    <?php if (in_array("smod_recur_asis", $permisos)) { ?>
                                        <li><a id="menu16_1" href="<?= base_url(); ?>asistencia"><span class="title">Asistencia</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_recur_bio", $permisos)) { ?>
                                        <li><a id="menu16_2" href="<?= base_url(); ?>biometrico"><span class="title">Biometrico</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_recur_plan", $permisos)) { ?>
                                        <li><a id="menu16_3" href="<?= base_url(); ?>planilla"><span class="title">Planillas</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_recur_feri", $permisos)) { ?>
                                        <li><a id="menu16_4" href="<?= base_url(); ?>feriado"><span class="title">Feriados</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_recur_vaca", $permisos)) { ?>
                                        <li><a id="menu16_5" href="<?= base_url(); ?>vacaciones"><span class="title">Vacaciones</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_recur_bene", $permisos)) { ?>
                                        <li><a id="menu16_6" href="<?= base_url(); ?>reporte_creditos"><span class="title">Beneficios</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_recur_desvin", $permisos)) { ?>
                                        <li><a id="menu16_7" href="<?= base_url(); ?>desvinculacion"><span class="title">Desvinculacion</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_recur_file_pers", $permisos)) { ?>
                                        <li><a id="menu16_8" href="<?= base_url(); ?>file_personal"><span class="title">File Personal</span></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- END RECURSOS HUMANOS -->
                        <!-- Fin GAN-MS-B3-0313,16/02/2023 -->

                        <!-- BEGIN ADMINISTRACION -->
                        <?php if (in_array("mod_adm", $permisos)) { ?>
                            <li class="gui-folder">
                                <a class="menu" id="menu8">
                                    <div class="gui-icon"><i class="md md-settings"></i></div>
                                    <span class="title">Administraci&oacute;n</span>
                                </a>

                                <ul>
                                    <?php if (in_array("smod_usu", $permisos)) { ?>
                                        <li><a href="<?= base_url() ?>usuarios" id="menu8_1"><span class="title">Usuario</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_ajust", $permisos)) { ?>
                                        <li><a href="<?= base_url() ?>ajustes" id="menu8_2"><span class="title">Ajustes</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_inf", $permisos)) { ?>
                                        <li><a href="<?= base_url() ?>informacion" id="menu8_3"><span class="title">información</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_ubi", $permisos)) { ?>
                                        <li><a href="<?= base_url() ?>ubicaciones" id="menu8_4"><span class="title">Ubicaciones</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_uni", $permisos)) { ?>
                                        <li><a href="<?= base_url() ?>unidades" id="menu8_5"><span class="title">Unidades</span></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array("smod_perm", $permisos)) { ?>
                                        <li><a href="<?= base_url() ?>permiso" id="menu8_6"><span class="title">Permisos</span></a></li>
                                    <?php } ?>
                                    <?php if (in_array("smod_mesas", $permisos)) { ?>
                                        <li><a href="<?= base_url() ?>mesas" id="menu8_6"><span class="title">Mesas</span></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- END ADMINISTRACION -->
            </ul>
            <!-- END MAIN MENU -->
            <div class="menubar-foot-panel" style="text-align: center">
                <small class="no-linebreak hidden-folded">
                    <span class="opacity-75">Copyright &copy; 2023</span>
                </small>
            </div>
        </div>
        <!--end .menubar-scroll-panel-->
    </div>
    <!--end #menubar-->
    <!-- END MENUBAR -->
