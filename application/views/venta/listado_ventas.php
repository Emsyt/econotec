<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:17/11/2021, GAN-MS-A4-092,
Descripcion: Se Realizo el frontend del maquetado V9.0 del branch de design de las paginas 79
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Daniel Castillo Quispe Fecha: 05/03/2021
Descripcion: Se agregó el total de la ventas y el total de ingresos al reporte
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:22/03/2022, Codigo:GAN-MS-M5-135
Descripcion: se agrego una funcion send para que al momento de imprimir el modal se cierre 
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:22/03/2022, Codigo:GAN-MS-M6-136
Descripcion: se agrego el boton respectivo para la impresion de nota de venta
------------------------------------------------------------------------------
Modificado: Saul Imanol Quiroga Castrillo Fecha:07/08/2022, Codigo:GAN-MS-A1-340
Descripcion: agregadas la funciones respectivas para el modulo de entregas
------------------------------------------------------------------------------
Modificado: Luis Fabricio Pari Wayar Fecha:06/09/2022, Codigo:GAN-MS-A1-430
Descripcion: Se agrego el campo HORA necesario para obtener la hora de venta en la tabla 
------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert Fecha:14/10/2022, Codigo:GAN-MS-A0-0046
Descripcion: Se mejoro el renderizado del boton entrega para los colores 
------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:11/05/2023, Codigo:GAN-MS-M4-0460
Descripcion: Se agrego una nueva columna llamada Venta que muestra si la venta es con o sin factura 
*/
?>
<?php if (in_array("smod_list_vent", $permisos)) { ?>
    <style>
        .modalbody {
            padding: 5%;
        }

        .div1 {
            overflow: auto;
            height: 100px;
        }

        .div1 table {
            width: 100%;
            background-color: lightgray;
        }
    </style>
    <script type="text/javascript">
        var f = new Date();
        fechap_inicial = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
        fechap_fin = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
        var id_cli = "-1";

        $(document).ready(function() {
            activarMenu('menu5', 4);
            $('[name="fecha_inicial"]').val(fechap_inicial);
            $('[name="fecha_fin"]').val(fechap_fin);
            buscar();
            //$('[name="cli_trabajo"]').val(id_cli);
        });
    </script>

    <script>
        function enviar(destino) {
            document.form_busqueda.action = destino;
            document.form_busqueda.submit();
        }
    </script>

    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Venta</a></li>
                    <li class="active">Listado de Ventas</li>
                </ol>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <form class="form" name="form_busqueda" id="form_busqueda" method="post" target="_blank">
                            <div class="card">
                                <div class="card-head style-default-light" style="padding: 10px">
                                    <div class="tools">
                                        <div class="btn-group">
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_listado_ventas')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_listado_ventas')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-right">
                                            <img style="height: 65px;" src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes);
                                                                                                print($obj->{'logo'}); ?>">
                                        </div>

                                        <div class="col-xs-9 col-sm-9 col-md-7 col-lg-7 text-center">
                                            <h5 class="text-ultra-bold" style="color:#655e60;"> EMPRESA <?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                                                                                                        print_r($obj->{'titulo'}); ?> </h5>
                                            <h5 class="text-ultra-bold" style="color:#655e60;"> LISTADO DE VENTAS </h5>
                                        </div>

                                        <div class="col-xs-9 col-sm-9 col-md-3 col-lg-3">
                                            <h6 class="text-ultra-bold text-default-light">Usuario: <?php echo $usuario; ?></h6>
                                            <h6 class="text-ultra-bold text-default-light">Fecha: <?php echo $fecha_imp; ?></h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="text-align: center;">
                                            <br>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                                    <div class="form-group">
                                                        <div class="input-group date" id="demo-date">
                                                            <div class="input-group-content">
                                                                <input type="text" class="form-control" name="fecha_inicial" id="fecha_inicial" readonly="" required>
                                                                <label for="fecha_inicial">Fecha Inicial</label>
                                                            </div>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                    <br>
                                                    <p>AL</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                                    <div class="form-group">
                                                        <div class="input-group date" id="demo-date-val">
                                                            <div class="input-group-content">
                                                                <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" readonly="" required>
                                                                <label for="fecha_fin">Fecha Final</label>
                                                            </div>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" type="button" onclick="buscar();">Generar Listado</button><br><br>
                                                <div class="form-group" id="process" style="display:none;">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120" style="">
                                                        </div>

                                                    </div>
                                                    <div class="status"></div>
                                                </div>
                                                <br>
                                            </div>

                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="text-align: center;">
                                            <br><br><br>
                                            <h4 class="text-ultra-bold" style="color:#655e60;">Total:</h4>
                                            <h4 id="total_venta" class="text-ultra-bold" style="color:#655e60;"></h4>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="text-align: center;">
                                            <br><br><br>
                                            <h4 class="text-ultra-bold" style="color:#655e60;">Total Ingresos:</h4>
                                            <h4 id="total_ingreso" class="text-ultra-bold" style="color:#655e60;"></h4>
                                        </div>
                                    </div>
                                    <!-- GAN-MS-A0-0046 Gary Valverde 13/10/2022 -->
                                    <div id="tabla">
                                        <div class="table-responsive">
                                            <table id="datatable_lst_venta" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Nª</th>
                                                        <th width="16%">C&oacute;digo de venta</th>
                                                        <th width="16%">Cliente</th>
                                                        <th width="16%">Total</th>
                                                        <th width="16%">Fecha</th>
                                                        <th width="15%">Hora</th>
                                                        <th width="15%">Venta</th>
                                                        <th width="16%">Acciones</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- FIN GAN-MS-A0-0046 Gary Valverde 13/10/2022 -->

                                    <div><br> </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- END CONTENT -->

    <!-- Modal Imprimir recibo-->
    <div class="modal fade" id="historial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h3 class="text-ultra-bold" style="color:#655e60;"><b>HISTORIAL</b></h3>
                    </center>
                </div>
                <div id="modalbody" style="padding-left: 50px; padding-right: 50px; margin-top: 10px; overflow-x: auto;">

                </div>
                <div id="modalfooter">

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Imprimir entrega-->
    <div class="modal fade" id="entrega" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h3 class="text-ultra-bold" style="color:#655e60;"><b>Reporte de entrega</b></h3>
                    </center>
                </div>
                <div id="modalbodyE" style="padding-left: 50px; padding-right: 50px; margin-top: 10px; overflow-x: auto;">

                </div>
                <div id="modalfooterE">

                </div>
            </div>
        </div>
    </div>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        //GAN-MS-A0-0046 Gary Valverde 13/10/2022
        function buscar() {
            var selc_frep = document.getElementById("fecha_inicial").value;
            var selc_finrep = document.getElementById("fecha_fin").value;
            selc_frep = selc_frep.replace('/', '-');
            selc_frep = selc_frep.replace('/', '-');
            selc_finrep = selc_finrep.replace('/', '-');
            selc_finrep = selc_finrep.replace('/', '-');

            document.getElementById("tabla").innerHTML = '';
            document.getElementById("tabla").innerHTML = '<div class="table-responsive">' +
                '<table id="datatable_lst_venta" class="table table-striped table-bordered">' +
                '<thead>' +
                '<tr>' +
                '<th width="5%">Nª</th>' +
                '<th width="16%">C&oacute;digo de venta</th>' +
                '<th width="13%">Cliente</th>' +
                '<th width="13%">Total</th>' +
                '<th width="13%">Fecha</th>' +
                '<th width="10%">Hora</th>' +
                '<th width="13%">Venta</th>' +
                '<th width="16%">Acciones</th>'
            '</tr>' +
            '</thead>' +
            '</table>' +
            ' </div>';

            $('#datatable_lst_venta').DataTable({
                'processing': true,
                'serverSide': true,
                'responsive': true,
                "language": {
                    "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                },
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= base_url() ?>lst_listado_ventas',
                    "data": {
                        "selc_frep": selc_frep,
                        "selc_finrep": selc_finrep
                    },
                },
                'columns': [{
                        data: 'onro'
                    },
                    {
                        data: 'ocodigo'
                    },
                    {
                        data: "ocliente"
                    },
                    {
                        data: 'ototal'
                    },
                    {
                        data: 'ofecha'
                    },
                    {
                        data: "ohora"
                    },
                    {
                        data: "otipo"
                    },
                    {
                        render: function(data, type, row) {
                            //console.log(row);
                            var a = `
                                        <form class="form" name="nota_venta" id="nota_venta" method="post" target="_blank" action="<?php echo site_url('pdf_nota_venta') ?>">
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="historial_venta(${row.oidubicacion},${row.olote},\'${row.ousucre}\');" data-toggle="modal" data-target="#historial"><i class="fa fa-list"></i></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_venta(${row.oidubicacion},${row.olote},\'${row.ousucre}\');" ><i class="fa fa-trash-o"></i></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="cargar_venta(${row.oidubicacion},${row.olote},\'${row.ousucre}\');"><i class="fa fa-refresh"></i></button>
                                        <input type="hidden" name="id_venta" value="${row.oidventa}">
                                        <button type="submit" class="btn ink-reaction btn-floating-action btn-xs btn-info active"><i class="fa fa-print"></i></button>
                                        <button type="button" id="Btn_Entrega${row.nrorow}" class="btn ink-reaction btn-floating-action btn-xs " onclick="reporte_entrega(${row.oidventa},${row.olote},\'${row.ousucre}\',${row.oidubicacion});" data-toggle="modal" data-target="#entrega"><i class="fa fa-truck"></i></button>
                                        </form>
                                    `;
                            $.ajax({

                                url: "<?php echo site_url('venta/C_listado_ventas/get_lst_entregas') ?>",
                                type: "POST",
                                data: {
                                    dato1: row.oidventa,
                                    dato2: row.olote,
                                },
                                success: function(respuesta) {
                                    let esEntregado = true;
                                    var js = JSON.parse(respuesta);
                                    try {
                                        var identrega = js[0][0].id_entrega;
                                    } catch (error) {
                                        var identrega = null;
                                    }
                                    if (identrega != null) {
                                        for (var i = 0; i < js[0].length; i++) {
                                            if (js[0][i].apiestado == "ENTREGANDOSE") esEntregado = false;
                                        }
                                        if (esEntregado) {
                                            $(`#Btn_Entrega${row.nrorow}`).addClass("btn-success");
                                        } else {
                                            $(`#Btn_Entrega${row.nrorow}`).addClass("btn-warning");
                                        }
                                    } else {
                                        $(`#Btn_Entrega${row.nrorow}`).addClass("btn-danger");
                                    }
                                }
                            });
                            return a;
                        }
                    },

                ],
            });
            //fin GAN-MS-A0-0046 Gary Valverde 13/10/2022
            $.ajax({
                url: '<?= base_url() ?>ingresos_reporte_ventas',
                type: "post",
                datatype: "json",
                data: {
                    selc_frep: selc_frep,
                    selc_finrep: selc_finrep
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    document.getElementById("total_venta").innerHTML = data[0].ototal;
                    document.getElementById("total_ingreso").innerHTML = data[0].ototal_ingreso;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function historial_venta(idubicacion, idlote, usucre) {
            console.log(idubicacion);
            $.ajax({
                url: "<?php echo site_url('venta/C_listado_ventas/historial_venta') ?>",
                type: "POST",
                data: {
                    dato1: idubicacion,
                    dato2: idlote,
                    dato3: usucre,
                },
                success: function(respuesta) {
                    console.log(respuesta);
                    var js = JSON.parse(respuesta);
                    let prod = js.productos;
                    let histo = js.historial;
                    modalbody.innerHTML = "";
                    modalbody.innerHTML = modalbody.innerHTML +
                        '<table>' +
                        '<tr>' +
                        '<td><b>Cliente: </b>' + js.cliente + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td><b>Codigo de venta: </b>' + js.codigo + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td><b>Fecha: </b>' + js.fecha + '</td>' +
                        '</tr>' +
                        '</table>' +
                        '<p align="Center"><b>DETALLE</b></p>' +
                        '<div class="div1">' +
                        '<table id="producto_modal" style="width:100%" >' +
                        '</table>' +
                        '<table>' +
                        '<tr>' +
                        '<td width="400"><b>Total: </b></td>' +
                        '<td width="100" align="center"><b>' + js.total + '</b></td>' +
                        '</tr>' +
                        '</table>' +
                        '</div>'

                    producto_modal.innerHTML = '<tr>' +
                        '<td width="200"><b>Producto</b></td>' +
                        '<td width="100" align="center"><b>Cantidad</b></td>' +
                        '<td width="100" align="center"><b>Precio Unitario</b></td>' +
                        '<td width="100" align="center"><b>Sub Total</b></td>' +
                        '</tr>'
                    for (var i = 0; i < prod.length; i++) {
                        producto_modal.innerHTML = producto_modal.innerHTML +
                            '<tr>' +
                            '<td width="200">' + prod[i].producto + '</td>' +
                            '<td width="100" align="center">' + prod[i].cantidad + '</td>' +
                            '<td width="100" align="center">' + prod[i].precio + '</td>' +
                            '<td width="100" align="center">' + prod[i].sub_total + '</td>' +
                            '</tr>'
                    }

                    modalfooter.innerHTML = "";
                    modalfooter.innerHTML = modalfooter.innerHTML +
                        '<div style="text-align: center; margin:20px;">' +
                        '<form class="form" name="historial_venta1" id="historial_venta1" method="post" target="_blank" action="<?= site_url() ?>pdf_historial_ventas">' +
                        '<input type="hidden" name="id_lote" value="' + idlote + '">' +
                        '<input type="hidden" name="usucre" value="' + usucre + '">' +
                        '<input type="hidden" name="idubicacion" value="' + idubicacion + '">' +
                        '<button type="button" onclick="send()" class="btn ink-reaction btn-raised btn-primary" title="PDF" formtarget="_blank">Imprimir Historial</button>' +
                        '</form>' +
                        '</div>'
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function send() {
            $('#historial').modal('hide');
            document.historial_venta1.submit();
        }

        function eliminar_venta(idubicacion, idlote, usucre) {
            Swal.fire({
                icon: 'warning',
                title: "¿Esta seguro de Anular la venta?",
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
                denyButtonText: 'CANCELAR',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('venta/C_listado_ventas/get_eliminar_venta') ?>",
                        type: "POST",
                        data: {
                            dato1: idubicacion,
                            dato2: idlote,
                            dato3: usucre,
                        },
                        success: function(respuesta) {
                            var js = JSON.parse(respuesta);
                            $.each(js, function(i, item) {
                                if (item.oboolean == 'f') {
                                    Swal.fire({
                                        icon: 'error',
                                        text: item.omensaje,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ACEPTAR',
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Se Anulo con exito la venta',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ACEPTAR',
                                    })
                                }
                            })
                            buscar();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error al obtener datos de ajax');
                        }
                    });
                }
            })

        }

        function cargar_venta(idubicacion, idlote, usucre) {
            Swal.fire({
                icon: 'warning',
                title: "¿Quiere Cargar esta venta nuevamente?",
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
                denyButtonText: 'CANCELAR',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('venta/C_listado_ventas/get_cargar_venta') ?>",
                        type: "POST",
                        data: {
                            dato1: idubicacion,
                            dato2: idlote,
                            dato3: usucre,
                        },
                        success: function(respuesta) {
                            var js = JSON.parse(respuesta);
                            $.each(js, function(i, item) {
                                if (item.oboolean == 'f') {
                                    Swal.fire({
                                        icon: 'error',
                                        text: item.omensaje,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ACEPTAR',
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Se cargo los productos de la venta con exito',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ACEPTAR',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.cookie = "Cliente = " + item.ocliente + ";";
                                            location.href = "<?php echo base_url(); ?>pedidoCodigo";
                                        } else {
                                            document.cookie = "Cliente = " + item.ocliente + ";";
                                            location.href = "<?php echo base_url(); ?>pedidoCodigo";
                                        }
                                    })

                                }
                            })
                            buscar();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error al obtener datos de ajax');
                        }
                    });
                }
            })

        }

        function getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function reporte_entrega(pIdVenta, pIdLote, pUsucre, pIdUbicacion) {
            let contadorFinalizado = 0;
            let esProductosEntregandose = false;
            modalbodyE.innerHTML = "";
            modalbodyE.innerHTML += '<center><h1>Cargando datos espere...</h1></center> ';
            modalfooterE.innerHTML = "";
            $.ajax({
                url: "<?php echo site_url('venta/C_listado_ventas/get_lst_entregas') ?>",
                type: "POST",
                data: {
                    dato1: pIdVenta,
                    dato2: pIdLote,
                },
                success: function(respuesta) {
                    //console.log(respuesta);
                    var js = JSON.parse(respuesta);
                    //console.log(js[0][0].id_entrega);
                    //verifica si ya se registraron los productos en la tabla mov_entrega
                    try {
                        var identrega = js[0][0].id_entrega;
                    } catch (error) {
                        var identrega = null;
                    }

                    if (identrega == null) {
                        $.ajax({
                            url: "<?php echo site_url('venta/C_listado_ventas/historial_venta') ?>",
                            type: "POST",
                            data: {
                                dato1: pIdUbicacion,
                                dato2: pIdLote,
                                dato3: pUsucre,
                            },
                            success: function(respuesta) {
                                //console.log("resp: "+respuesta);
                                var jsprod = JSON.parse(respuesta);
                                let prod = jsprod.productos;
                                for (var i = 0; i < prod.length; i++) {
                                    $.ajax({
                                        url: "<?php echo site_url('venta/C_listado_ventas/add_prod_entregas') ?>",
                                        type: "POST",
                                        data: {
                                            dato1: pIdVenta,
                                            dato2: pIdLote,
                                            dato3: prod[i].producto,
                                            dato4: prod[i].cantidad,
                                        },
                                        success: function(respuesta) {
                                            contadorFinalizado++;
                                            if (contadorFinalizado >= prod.length) {
                                                mostrarProductos(pIdUbicacion, pIdLote, pUsucre, pIdVenta);
                                            }

                                        }
                                    });
                                }
                            }
                        });
                    } else {
                        $.ajax({
                            url: "<?php echo site_url('venta/C_listado_ventas/historial_venta') ?>",
                            type: "POST",
                            data: {
                                dato1: pIdUbicacion,
                                dato2: pIdLote,
                                dato3: pUsucre,
                            },
                            success: function(respuesta) {
                                console.log(respuesta);
                                var jsprod = JSON.parse(respuesta);
                                let prod = js[0];
                                modalbodyE.innerHTML = "";
                                modalbodyE.innerHTML +=
                                    '<table>' +
                                    '<tr>' +
                                    '<td><b>Cliente: </b>' + jsprod.cliente + '</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<td><b>Codigo de venta: </b>' + jsprod.codigo + '</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<td><b>Fecha: </b>' + jsprod.fecha + '</td>' +
                                    '</tr>' +
                                    '</table>' +
                                    `<p align="Center"><b>DETALLE</b></p><b>Entregar Todos:  </b><input type="checkbox"  id="cambiarEstado" onChange="cambiarProductoEstado(${prod.length})">` +
                                    '<div class="div1">' +
                                    '<table id="producto_modalE" style="width:100%" >' +
                                    '</table>' +
                                    '</div>';

                                producto_modalE.innerHTML = '<tr>' +
                                    '<td width="300"><b>Producto</b></td>' +
                                    '<td width="50" align="center"><b>Total</b></td>' +
                                    '<td width="200" align="center"><b>Por Entregar</b></td>' +
                                    '<td width="100" align="center"><b>Entregado</b></td>' +
                                    '<td width="400" align="center"><b>Confirmar Entrega</b></td>' +
                                    '</tr>';

                                for (var i = 0; i < prod.length; i++) {
                                    if (prod[i].apiestado == "ENTREGANDOSE") {
                                        esProductosEntregandose = true;
                                        producto_modalE.innerHTML +=
                                            '<tr>' +
                                            '<td width="200">' + prod[i].producto + '</td>' +
                                            '<td width="150" align="center">' + prod[i].total + '</td>' +
                                            '<td width="100" align="center">' + (prod[i].total - prod[i].cantidad_ent) + '</td>' +
                                            '<td width="100" align="center"><input type="number"   style="width:70%"  id="cantidad_Adicionada' + i + '" value="' + (prod[i].total - prod[i].cantidad_ent) + '" onchange="validarCantidadE(' + (prod[i].total - prod[i].cantidad_ent) + ',' + i + ')"></td>' +
                                            '<td width="100" align="center"><input type="checkbox" id="esEntregado' + i + '"></td>' +
                                            '<td width="" align="center"><input type="hidden" id="id_Producto' + i + '" value="' + prod[i].id_entrega + '"></td>' +
                                            '<td width="" align="center"><input type="hidden" id="total_P' + i + '" value="' + prod[i].total + '"></td>' +
                                            '<td width="" align="center"><input type="hidden" id="Nombre_P' + i + '" value="' + prod[i].producto + '"></td>' +
                                            '<td width="" align="center"><input type="hidden" id="cant_Entregada' + i + '" value="' + prod[i].cantidad_ent + '"></td>' +
                                            '</tr>';
                                    } else {
                                        producto_modalE.innerHTML +=
                                            '<tr>' +
                                            '<td width="200">' + prod[i].producto + '</td>' +
                                            '<td width="100" align="center">' + prod[i].total + '</td>' +
                                            '<td width="100" align="center">' + (prod[i].total - prod[i].cantidad_ent) + '</td>' +
                                            '<td width="400" align="center"><b>Producto ya entregado</b></td>' +
                                            '</tr>';
                                    }
                                };

                                if (esProductosEntregandose) {
                                    modalfooterE.innerHTML = "";
                                    modalfooterE.innerHTML +=
                                        '<div style="text-align: center; margin:20px;">' +
                                        '<form class="form" name="historial_venta1" id="historial_venta1" method="post" target="_blank" action="<?= site_url() ?>pdf_historial_ventas">' +
                                        '<input type="hidden" name="id_lote" value="' + pIdLote + '">' +
                                        '<input type="hidden" name="usucre" value="' + pUsucre + '">' +
                                        '<input type="hidden" name="idubicacion" value="' + pIdUbicacion + '">' +
                                        `<button type="button" onclick="guardar_datos_entrega(${prod.length},)" class="btn ink-reaction btn-raised btn-primary" title="Aceptar">Guardar Cambios</button>` +
                                        '<button type="button" onclick="send()" class="btn ink-reaction btn-raised btn-primary" title="PDF" formtarget="_blank">Imprimir Historial</button>' +
                                        '</form>' +
                                        '</div>'

                                } else {
                                    modalfooterE.innerHTML = "";
                                    modalfooterE.innerHTML +=
                                        '<div style="text-align: center; margin:20px;">' +
                                        '<form class="form" name="historial_venta1" id="historial_venta1" method="post" target="_blank" action="<?= site_url() ?>pdf_historial_ventas">' +
                                        '<input type="hidden" name="id_lote" value="' + pIdLote + '">' +
                                        '<input type="hidden" name="usucre" value="' + pUsucre + '">' +
                                        '<input type="hidden" name="idubicacion" value="' + pIdUbicacion + '">' +
                                        '<button type="button" onclick="send()" class="btn ink-reaction btn-raised btn-primary" title="PDF" formtarget="_blank">Imprimir Historial</button>' +
                                        '</form>' +
                                        '</div>'
                                }
                            },
                            /* GAN-SC-M4-0047 Gary Valverde 14-10-2022 */
                            error: function(jqXHR, textStatus, errorThrown) {
                                modalbodyE.innerHTML = "";
                                modalbodyE.innerHTML += '<center><h1 style="color:#E9CC26">ADVERTENCIA:</h1><h1>El lote no contiene productos</h1></center> ';
                            }
                            /* fin GAN-SC-M4-0047 Gary Valverde 14-10-2022 */
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function guardar_datos_entrega(pCantidadProductos) {
            //BEGIN MODAL SWAL 
            let iconSwal = "info";
            let tittleSwal = "Información";
            let textSwal = "Ningún producto fue seleccionado para su entrega."
            //END MODAL SWAL

            let contadorFinalizado = 0;
            modalfooterE.innerHTML = "<center><h1>Guardando datos espere...</h1></center>";
            for (var i = 0; i < pCantidadProductos; i++) {
                contadorFinalizado++;
                let productoValido = document.getElementById('cantidad_Adicionada' + i);
                if (productoValido != null) {
                    productoEntregado = document.getElementById('esEntregado' + i).checked;
                    if (productoEntregado) {
                        //BEGIN MODAL SWAL 
                        iconSwal = "success";
                        tittleSwal = "Completado!!!";
                        textSwal = "Los productos fueron entregados."
                        //END MODAL SWAL               
                        let cant_Entregada = document.getElementById('cant_Entregada' + i).value;
                        let id_producto = document.getElementById('id_Producto' + i).value;
                        let total_P = document.getElementById('total_P' + i).value;
                        let Nombre_P = document.getElementById('Nombre_P' + i).value;
                        let cantidad_Adicionada = document.getElementById('cantidad_Adicionada' + i).value;
                        let apiestado = "ENTREGANDOSE";
                        let cantidadRestante = total_P - (cant_Entregada + cantidad_Adicionada);
                        let cantidadTotalEntregada = parseInt(cant_Entregada) + parseInt(cantidad_Adicionada);
                        if (cantidadRestante <= 0) apiestado = "ENTREGADO";
                        $.ajax({
                            url: "<?php echo site_url('venta/C_listado_ventas/upd_prod_entregas') ?>",
                            type: "POST",
                            data: {
                                dato1: id_producto,
                                dato2: cantidadTotalEntregada,
                                dato3: apiestado,
                            },
                            success: function(respuesta) {
                                if (contadorFinalizado >= pCantidadProductos) {
                                    $('#entrega').modal('hide');
                                    Swal.fire({
                                        icon: iconSwal,
                                        title: tittleSwal,
                                        text: textSwal,
                                        confirmButtonColor: '#d33',
                                        confirmButtonText: 'ACEPTAR'
                                    });
                                }
                            }
                        });
                    } else {
                        if (contadorFinalizado >= pCantidadProductos) {
                            $('#entrega').modal('hide');
                            Swal.fire({
                                icon: iconSwal,
                                title: tittleSwal,
                                text: textSwal,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'ACEPTAR'
                            });
                        }
                    }
                } else {
                    if (contadorFinalizado >= pCantidadProductos) {
                        $('#entrega').modal('hide');
                        Swal.fire({
                            icon: iconSwal,
                            title: tittleSwal,
                            text: textSwal,
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        });
                    }
                }
            }
        }

        function validarCantidadE(pCantMax, pIdCantidad) {
            let cantidadIntroducida = document.getElementById('cantidad_Adicionada' + pIdCantidad).value;
            cantidadIntroducida.trim();

            if (cantidadIntroducida == null || cantidadIntroducida == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Introduzca una cantidad valida',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ACEPTAR'
                });
                document.getElementById('cantidad_Adicionada' + pIdCantidad).value = pCantMax;
            }

            if (cantidadIntroducida < 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Introduzca una cantidad mayor o igual a cero',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ACEPTAR'
                });
                document.getElementById('cantidad_Adicionada' + pIdCantidad).value = pCantMax;
            }

            if (cantidadIntroducida > pCantMax) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Introduzca una cantidad menor o igual que los productos restantes por entregar',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ACEPTAR'
                });
                document.getElementById('cantidad_Adicionada' + pIdCantidad).value = pCantMax;
            }
        }

        function mostrarProductos(pIdUbicacion, pIdLote, pUsucre, pIdVenta) {
            $.ajax({
                url: "<?php echo site_url('venta/C_listado_ventas/get_lst_entregas') ?>",
                type: "POST",
                data: {
                    dato1: pIdVenta,
                    dato2: pIdLote,
                },
                success: function(respuesta) {
                    var js = JSON.parse(respuesta);
                    $.ajax({
                        url: "<?php echo site_url('venta/C_listado_ventas/historial_venta') ?>",
                        type: "POST",
                        data: {
                            dato1: pIdUbicacion,
                            dato2: pIdLote,
                            dato3: pUsucre,
                        },
                        success: function(respuesta) {
                            var jsprod = JSON.parse(respuesta);
                            let prod = js[0];
                            modalbodyE.innerHTML = "";
                            modalbodyE.innerHTML +=
                                '<table>' +
                                '<tr>' +
                                '<td><b>Cliente: </b>' + jsprod.cliente + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td><b>Codigo de venta: </b>' + jsprod.codigo + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td><b>Fecha: </b>' + jsprod.fecha + '</td>' +
                                '</tr>' +
                                '</table>' +
                                `<p align="Center"><b>DETALLE</b></p><b>Entregar Todos:  </b><input type="checkbox" id="cambiarEstado" onChange="cambiarProductoEstado(${prod.length})">` +
                                '<div class="div1">' +
                                '<table id="producto_modalE" style="width:100%" >' +
                                '</table>' +
                                '</div>';

                            producto_modalE.innerHTML = '<tr>' +
                                '<td width="300"><b>Producto</b></td>' +
                                '<td width="50" align="center"><b>Total</b></td>' +
                                '<td width="200" align="center"><b>Por Entregar</b></td>' +
                                '<td width="100" align="center"><b>Entregado</b></td>' +
                                '<td width="400" align="center"><b>Confirmar Entrega</b></td>'
                            '</tr>';

                            for (var i = 0; i < prod.length; i++) {
                                if (prod[i].apiestado == "ENTREGANDOSE") {
                                    esProductosEntregandose = true;
                                    producto_modalE.innerHTML +=
                                        '<tr>' +
                                        '<td width="200">' + prod[i].producto + '</td>' +
                                        '<td width="150" align="center">' + prod[i].total + '</td>' +
                                        '<td width="100" align="center">' + (prod[i].total - prod[i].cantidad_ent) + '</td>' +
                                        '<td width="100" align="center"><input type="number" style="width:70%" id="cantidad_Adicionada' + i + '" value="' + (prod[i].total - prod[i].cantidad_ent) + '" onchange="validarCantidadE(' + (prod[i].total - prod[i].cantidad_ent) + ',' + i + ')"></td>' +
                                        '<td width="100" align="center"><input type="checkbox" id="esEntregado' + i + '"></td>' +
                                        '<td width="" align="center"><input type="hidden" id="id_Producto' + i + '" value="' + prod[i].id_entrega + '"></td>' +
                                        '<td width="" align="center"><input type="hidden" id="total_P' + i + '" value="' + prod[i].total + '"></td>' +
                                        '<td width="" align="center"><input type="hidden" id="Nombre_P' + i + '" value="' + prod[i].producto + '"></td>' +
                                        '<td width="" align="center"><input type="hidden" id="cant_Entregada' + i + '" value="' + prod[i].cantidad_ent + '"></td>' +
                                        '</tr>';
                                } else {
                                    producto_modalE.innerHTML +=
                                        '<tr>' +
                                        '<td width="200">' + prod[i].producto + '</td>' +
                                        '<td width="100" align="center">' + prod[i].total + '</td>' +
                                        '<td width="100" align="center">' + (prod[i].total - prod[i].cantidad_ent) + '</td>' +
                                        '<td width="400" align="center"><b>Producto ya entregado</b></td>' +
                                        '</tr>';
                                }
                            };

                            modalfooterE.innerHTML = "";
                            modalfooterE.innerHTML +=
                                '<div style="text-align: center; margin:20px;">' +
                                '<form class="form" name="historial_venta1" id="historial_venta1" method="post" target="_blank" action="<?= site_url() ?>pdf_historial_ventas">' +
                                '<input type="hidden" name="id_lote" value="' + pIdLote + '">' +
                                '<input type="hidden" name="usucre" value="' + pUsucre + '">' +
                                '<input type="hidden" name="idubicacion" value="' + pIdUbicacion + '">' +
                                `<button type="button" onclick="guardar_datos_entrega(${prod.length},)" class="btn ink-reaction btn-raised btn-primary" title="Aceptar">Guardar Cambios</button>` +
                                '<button type="button" onclick="send()" class="btn ink-reaction btn-raised btn-primary" title="PDF" formtarget="_blank">Imprimir Historial</button>' +
                                '</form>' +
                                '</div>'
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function cambiarProductoEstado(pCantidadProductos) {
            let estadotodo = document.getElementById('cambiarEstado').checked;
            for (var i = 0; i < pCantidadProductos; i++) {
                let productoValido = document.getElementById('cantidad_Adicionada' + i);
                if (productoValido != null) {
                    document.getElementById('esEntregado' + i).checked = estadotodo;
                }
            }
        }
    </script>


<?php } else {
    redirect('inicio');
} ?>