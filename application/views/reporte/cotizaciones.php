<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Pedro Rodrigo Beltran Poma Fecha:24/10/2022, GAN-MS-A6-0071,
Descripcion: Se Realizo el frontend del modulo para la visualizacion de cotizaciones
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma Fecha: 28/10/2022 GAN-MS-A6-0079
Descripcion: Se agrego el campo observaciones en el en la tabla principal y ajustes a los nombres de lo headers.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma Fecha: 28/10/2022 GAN-MS-A6-0080
Descripcion: Se modifico el historial de la cotizacion para mostrar la fecha de validez.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha: 24/11/2022 GAN-MS-A7-0134
Descripcion: Se modifico la funcion de cargar_cotizacion para que este pueda validar los productos en inventarios.
*/
?>
<?php if (in_array("smod_rep_cot", $permisos)) { ?>
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
            activarMenu('menu6', 10);
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
                    <li><a href="#">Reportes</a></li>
                    <li class="active">Listado de Cotizaciones</li>
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
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_listado_cotizacion')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_listado_cotizacion')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
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
                                            <h5 class="text-ultra-bold" style="color:#655e60;"> LISTADO DE COTIZACIONES </h5>
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
                                    </div>
                                    <div id="tabla">
                                        <div class="table-responsive">
                                            <table id="datatable_lst_venta" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="16%">C&oacute;digo de venta</th>
                                                        <th width="16%">Cliente</th>
                                                        <th width="16%">Total</th>
                                                        <th width="16%">Fecha</th>
                                                        <th width="15%">Hora</th>
                                                        <th width="16%">Acciones</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

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

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                '<th width="16%">Cliente</th>' +
                '<th width="16%">Total</th>' +
                '<th width="16%">Fecha Cotizacion</th>' +
                '<th width="15%">Fecha Validez</th>' +
                '<th width="15%">Observaciones</th>' +
                '<th width="15%">Ubicacion</th>' +
                '<th width="15%">Usucre</th>' +
                '<th width="15%">CotizacionID</th>' +
                '<th width="16%">Acciones</th>'
            '</tr>' +
            '</thead>' +
            '</table>' +
            ' </div>';

            $('#datatable_lst_venta').DataTable({
                'responsive': true,
                'searching': true,
                "info": false,
                "language": {
                    "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                },
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= base_url() ?>lst_listado_cotizacion',
                    "data": {
                        "selc_frep": selc_frep,
                        "selc_finrep": selc_finrep
                    },
                },
                'columns': [{
                        data: 'pidlote',
                        render: function(data, type, row, meta) {
                            let numb = meta.row + 1;
                            return '<span id="">' + numb + '</span>';
                        }
                    },
                    {
                        data: "pcliente"
                    },
                    {
                        data: 'ptotal'
                    },
                    {
                        data: 'pfeccre'
                    },
                    {
                        data: "pfecvali"
                    },
                    {
                        data: "pobservaciones"
                    },
                    {
                        data: "pidubicacion",
                        visible: false
                    },
                    {
                        data: "pusucre",
                        visible: false
                    },
                    {
                        data: "pidcotizacion",
                        visible: false
                    },
                    {
                        render: function(data, type, row) {
                            //console.log(row);
                            var a = `
                                        <form class="form" name="nota_venta" id="nota_venta" method="post" target="_blank" action="<?php echo site_url('pdf_nota_cotizacion') ?>">
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="historial_coti(${row.pidubicacion},${row.pidlote},\'${row.pusucre}\');" data-toggle="modal" data-target="#historial"><i class="fa fa-list"></i></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_cotizacion(${row.pidubicacion},${row.pidlote},\'${row.pusucre}\');" ><i class="fa fa-trash-o"></i></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="cargar_cotizacion(${row.pidubicacion},${row.pidlote},\'${row.pusucre}\');"><i class="fa fa-check"></i></button>
                                        <input type="hidden" name="id_venta" value="${row.pidcotizacion}">
                                        <button type="submit" class="btn ink-reaction btn-floating-action btn-xs btn-info active"><i class="fa fa-print"></i></button>
                                        </form>
                                    `;
                            return a;
                        }
                    },

                ],
            });
        }

        function historial_coti(idubicacion, idlote, usucre) {
            console.log(idubicacion);
            $.ajax({
                url: "<?php echo site_url('reporte/C_reporte_cotizacion/historial_cotizacion') ?>",
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
                        '<tr>' +
                        '<td><b>Fecha Validez: </b>' + js.fechavali + '</td>' +
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

        function eliminar_cotizacion(idubicacion, idlote, usucre) {
            Swal.fire({
                icon: 'warning',
                title: "¿Esta seguro de Anular la cotizacion?",
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
                denyButtonText: 'CANCELAR',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('reporte/C_reporte_cotizacion/get_eliminar_cotizacion') ?>",
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
                                        title: 'Se Anulo con exito la cotizacion',
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

        function cargar_cotizacion(idubicacion, idlote, usucre) {
            Swal.fire({
                icon: 'warning',
                title: "¿Quiere Cargar esta cotizacion?",
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
                denyButtonText: 'CANCELAR',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('reporte/C_reporte_cotizacion/verificar_productos') ?>",
                        type: "POST",
                        data: {
                            idubicacion: idubicacion,
                            idlote: idlote,
                            usucre: usucre,
                        },
                        success: function(data) {

                            var json = JSON.parse(data);
                            console.log(json);
                            $.each(json, function(j, itemv) {
                                if (itemv.oboolean == 'f') {
                                    Swal.fire({
                                        icon: 'error',
                                        text: itemv.omensaje,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ACEPTAR',
                                    })
                                } else {
                                    $.ajax({
                                        url: "<?php echo site_url('reporte/C_reporte_cotizacion/get_cargar_cotizacion') ?>",
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
                                                        title: 'Se cargo los productos de la cotizacion con exito',
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
    </script>


<?php } else {
    redirect('inicio');
} ?>