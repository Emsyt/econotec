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
Modificado: Alison Paola Pari Pareja Fecha:25/07/2022, Codigo:
Descripcion: Se agrego el boton para enviar la factura por correo electronico
-------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert Fecha:24/05/2023, Codigo: GAN-MS-A5-0494
Descripcion: Se modifico la funcion enviar_correo para la validacion del correo electronico
*/
?>
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
                <li class="active">Listado de Facturas</li>
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
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> LISTADO DE FACTURAS </h5>
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
                                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120">
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
                                <div class="table-responsive">
                                    <table id="datatable3" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="5%">N&deg;</th>
                                                <th width="15%">Codigo de Ventas</th>
                                                <th width="15%">Cliente</th>
                                                <th width="19%">Correo</th>
                                                <th width="12%">Total</th>
                                                <th width="12%">Fecha</th>
                                                <th width="12%">Nota de Crédito/Débito</th>
                                                <th width="22%">Accion</th>
                                            </tr>
                                        </thead>
                                    </table>
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
<!-- Modal nota debito-->
<div class="modal fade bd-example-modal-lg" id="NotaDebito" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header card card-head style-primary">
                <center>
                    <h3 class="text-ultra-bold"><b>Emisión Nota de Crédito/Débito</b></h3>
                </center>
            </div>
            <div id="modal-body" style="padding-left: 20px; padding-right: 20px; margin-top: 10px; overflow-x: auto;">
                <div class="container-fluid form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group floating-label" id="c_cliente">
                                <input type="text" class="form-control" name="cliente" id="cliente" disabled>
                                <label for="cliente">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form form-group  floating-label" id="c_fecha">
                                <input type="text" class="form-control" name="fecha" id="fecha" disabled>
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form form-group  floating-label" id="c_total">
                                <input type="text" class="form-control" name="total" id="total" disabled>
                                <label for="total"> Monto Total Bs.</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group floating-label" id="c_cuf">
                                <input type="text" class="form-control" name="cuf" id="cuf" disabled>
                                <label for="cuf">Codigo de Autorización</label>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" style="overflow-y: 300px;">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">Nro</th>
                                    <th width="50%">Producto</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="10%">Precio Unitario</th>
                                    <th width="10%">Descuento</th>
                                    <th width="10%">Sub Total</th>
                                    <th width="5%">Accion</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div id="modal-footer" style="text-align: right; padding-right: 20px;  margin-top: 10px; margin-bottom: 10px;">
                <form class="form" name="form_nota_credito" id="form_nota_credito" method="post" target="_blank" action="<?php echo site_url('venta/C_listado_facturas/pdf_factura') ?>">
                    <input name="id_lote1" id="id_lote1" type="hidden">
                    <input name="cuf_pdf" id="cuf_pdf" type="hidden">
                    <input name="fecha_pdf" id="fecha_pdf" type="hidden">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn_emitir_nota" name="btn_emitir_nota" onclick="emitir_nota()">Emitir</button>
                </form>
            </div>

        </div>
    </div>
</div>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function buscar() {

        var selc_frep = document.getElementById("fecha_inicial").value;
        var selc_finrep = document.getElementById("fecha_fin").value;
        $.ajax({
            url: '<?= site_url() ?>venta/C_listado_facturas/C_listado_facturas',
            type: "post",
            datatype: "json",
            data: {
                selc_frep: selc_frep,
                selc_finrep: selc_finrep
            },
            success: function(data) {
                var data = JSON.parse(data);
                console.log(data);

                $('#datatable3').DataTable({
                    "data": data,
                    "responsive": true,
                    "language": {
                        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                    },
                    "destroy": true,
                    "columnDefs": [{
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }],
                    "order": [
                        [1, 'desc']
                    ],
                    "aoColumns": [{
                            "mData": "onro"
                        },
                        {
                            "mData": "ocodigo"
                        },
                        {
                            "mData": "ocliente"
                        },
                        {
                            "mData": "ocorreo",
                            render: function(data, type, row) {
                                if (data == null || data == '') {
                                    return '<p>SIN CORREO</p>';

                                } else {
                                    return '<p>' + data + '</p>';
                                }
                            }
                        },
                        {
                            "mData": "ototal"
                        },
                        {
                            "mData": "ofecha"
                        },
                        {
                            "mRender": function(data, type, row, meta) {
                                var response = `
                                    <button type="button" class="btn btn-primary ink-reaction btn-sm" onclick="nota_debito(${row.oidubicacion},${row.olote},\'${row.ousucre}\')">Nota de Crédito/Débito</button>
                                `;
                                return response;
                            }
                        },
                        {
                            "mRender": function(data, type, row, meta) {
                                var a = `
                                    <form class="form" name="nota_venta" id="nota_venta" method="post" target="_blank" action="<?php echo site_url('pdf_nota_venta') ?>">
                                    <button title="Historial de venta" type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="historial_venta(${row.oidubicacion},${row.olote},\'${row.ousucre}\');" data-toggle="modal" data-target="#historial"><i class="fa fa-list"></i></button>
                                    <input type="hidden" name="id_venta" value="${row.oidventa}">
                                    <a title="Imprimir venta" class="btn ink-reaction btn-floating-action btn-xs btn-warning active" href="./assets/facturaspdf/factura_${row.olote}.pdf" download="factura_${row.olote}.pdf"><i class="fa fa-print"></i></a>
                                    <a title="Imprimir Nota Debito" class="btn ink-reaction btn-floating-action btn-xs btn-primary active" href="./assets/facturaspdf/Nota_debito_${row.olote}002.pdf" download="Nota_debito_${row.olote}002.pdf"><i class="fa fa-print"></i></a>
                                    <button title="PDF COMPRA VENTA" type="button" class="btn ink-reaction btn-floating-action btn-xs btn-primary" onclick="mandar_al_correo(\'${row.ocorreo}\',${row.oidventa},${row.olote})"><i class="fa fa-envelope"></i></button>
                                    </form>
                                `;
                                return a;
                            }
                        },

                    ],
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Columnas"
                    }
                });


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });

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
    var resp = '';

    function mandar_al_correo(correo, id_venta, id_lote) {

        /* GAN-MS-A5-0494 GValverde */
        if (correo == null || correo == 'null' || correo == '') {
            alert("Sin correo electronico");
            return; 
        }
        /* fin  GAN-MS-A5-0494 GValverde */
        $.ajax({
            url: "<?php echo site_url('venta/C_listado_facturas/enviar_correo') ?>",
            type: "POST",
            data: {
                correo: correo,
                id_venta: id_venta,
                id_lote: id_lote,
            },
            success: function(respuesta) {
                var json = JSON.parse(respuesta);
                resp = json;
                alert(resp);
            }
        });
    }

    function mandar_al_correo_nota(correo, id_venta, id_lote) {


        $.ajax({
            url: "<?php echo site_url('venta/C_listado_facturas/enviar_correo_nota') ?>",
            type: "POST",
            data: {
                correo: correo,
                id_venta: id_venta,
                id_lote: id_lote,
            },
            success: function(respuesta) {
                var json = JSON.parse(respuesta);
                resp = json;
                alert(resp);
            }
        });

    }

    function historial_venta(idubicacion, idlote, usucre) {
        $.ajax({
            url: "<?php echo site_url('venta/C_listado_facturas/historial_venta') ?>",
            type: "POST",
            data: {
                dato1: idubicacion,
                dato2: idlote,
                dato3: usucre,
            },
            success: function(respuesta) {
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
                    url: "<?php echo site_url('venta/C_listado_facturas/get_eliminar_venta') ?>",
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
                    url: "<?php echo site_url('venta/C_listado_facturas/get_cargar_venta') ?>",
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

    function nota_debito(idubicacion, idlote, usucre) {
        $.ajax({
            url: "<?php echo site_url('venta/C_listado_facturas/C_nota_credito_debito') ?>",
            type: "POST",
            data: {
                idubicacion: idubicacion,
                idlote: idlote,
                usucre: usucre,
            },
            success: function(respuesta) {
                console.log(respuesta)
                var js = JSON.parse(respuesta);
                data = js.data;

                var data = JSON.parse(data);
                console.log(js);
                let prod = js.productos;
                let gift = js.gift;

                if (gift != '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No es posible realizar La Nota Devito - Credito Con productos pagados con GiftCart proceda a realizar la anulacion',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ACEPTAR',
                    })
                } else {
                    $('#NotaDebito').modal('show');
                    $('[name="cliente"]').val(data.cliente).trigger('change');
                    $('[name="fecha"]').val(data.fecha).trigger('change');
                    $('[name="cuf"]').val(data.cuf).trigger('change');
                    $('[name="total"]').val(data.total).trigger('change');
                    $('[name="btn_emitir_nota"]').val(idlote).trigger('change');
                    $('[name="id_lote1"]').val(idlote).trigger('change');

                    $('#datatable').DataTable({
                        "data": prod,
                        "responsive": true,
                        "language": {
                            "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                        },
                        "destroy": true,
                        "columnDefs": [{
                                "searchable": false,
                                "orderable": false,
                                "targets": 0
                            },
                            {
                                "width": "5%",
                                "targets": 0
                            },
                        ],
                        "order": [
                            [0, 'asc']
                        ],
                        "aoColumns": [{
                                "mData": "onro"
                            },
                            {
                                "mData": "oproducto"
                            },
                            {
                                "mRender": function(data, type, row, meta) {
                                    var a = `
                            <input type="number" id="cantidad_${row.onro}" style="width: 80px" min="0" max="${row.ocantidad}" value="${row.ocantidad}" onchange="cambiar_cantidad_nota_debito(this,'cantidad_${row.onro}',${row.oid_venta},${idlote})">
                            `;
                                    return a;
                                }
                            },
                            {
                                "mData": "oprecio_unidad"
                            },
                            {
                                "mData": "odescuento"
                            },
                            {
                                "mData": "osub_total"
                            },
                            {
                                "mRender": function(data, type, row, meta) {
                                    var a = `
                            <button id="anular_producto" title="Anular Producto" type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_prod(${row.oid_venta},${idlote})"><i class="fa fa-trash-o"></i></button>
                            `;
                                    return a;
                                }
                            }
                        ],
                    });
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }

    function eliminar_prod(idventa, idlote) {
        console.log(idlote);
        Swal.fire({
            icon: 'warning',
            title: '¿Se desea eliminar el producto?',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ACEPTAR',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url('venta/C_listado_facturas/eliminar_prod') ?>",
                    type: "POST",
                    data: {
                        dato: idventa,
                    },
                    success: function(respuesta) {
                        var js = JSON.parse(respuesta);
                        console.log(js);
                        lts_nota_credito_debito(idlote);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax');
                    }
                });
            }
        })

    }

    function lts_nota_credito_debito(idlote) {
        $.ajax({
            url: "<?php echo site_url('venta/C_listado_facturas/lts_nota_credito_debito') ?>",
            type: "POST",
            data: {
                dato: idlote,
            },
            success: function(respuesta) {
                var js = JSON.parse(respuesta);
                $('#datatable').DataTable({
                    "data": js,
                    "responsive": true,
                    "language": {
                        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                    },
                    "destroy": true,
                    "columnDefs": [{
                            "searchable": false,
                            "orderable": false,
                            "targets": 0
                        },
                        {
                            "width": "5%",
                            "targets": 0
                        },
                    ],
                    "order": [
                        [0, 'asc']
                    ],
                    "aoColumns": [{
                            "mData": "onro"
                        },
                        {
                            "mData": "oproducto"
                        },
                        {
                            "mRender": function(data, type, row, meta) {
                                var a = `
                                    <input type="number" id="cantidad_${row.onro}" style="width: 80px" min="0" max="${row.ocantidad}" value="${row.ocantidad}" onchange="cambiar_cantidad_nota_debito(this,'cantidad_${row.onro}',${row.oid_venta},${idlote})">
                                `;
                                return a;
                            }
                        },
                        {
                            "mData": "oprecio_unidad"
                        },
                        {
                            "mData": "odescuento"
                        },
                        {
                            "mData": "osub_total"
                        },
                        {
                            "mRender": function(data, type, row, meta) {
                                var a = `
                                <button id="anular_producto" title="Anular Producto" type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_prod(${row.oid_venta},${idlote})"><i class="fa fa-trash-o"></i></button>
                                `;
                                return a;
                            }
                        }
                    ],
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }

    function cambiar_cantidad_nota_debito(val, idrow, idventa, idlote) {
        let cantidad = document.getElementById(idrow).value;
        console.log(val.value);
        Swal.fire({
            icon: 'warning',
            title: 'Cambio de cantidad',
            text: 'Desea cambiar la cantidad a ' + cantidad,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ACEPTAR',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url('venta/C_listado_facturas/C_cambiar_cantidad_nota_debito') ?>",
                    type: "POST",
                    data: {
                        idventa: idventa,
                        cantidad: cantidad,
                    },
                    success: function(respuesta) {
                        var js = JSON.parse(respuesta);
                        console.log(js);
                        if (js[0].oboolean == 't') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Exito',
                                text: 'Se cambio la cantidad con Exito',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ACEPTAR',
                            }).then((result) => {
                                lts_nota_credito_debito(idlote);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: js[0].omensaje,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ACEPTAR',
                            }).then((result) => {
                                lts_nota_credito_debito(idlote);
                            });
                        }

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax');
                    }
                });
            }
        });


    }

    function emitir_nota() {
        let id_lote = document.getElementById('btn_emitir_nota').value;
        console.log(id_lote);
        $.ajax({
            url: "<?php echo site_url('venta/C_listado_facturas/C_emitir_nota') ?>",
            type: "POST",
            data: {
                dato: id_lote,
            },
            success: function(respuesta) {
                var js = JSON.parse(respuesta);
                if (js[0].oboolean == 't') {
                    $('[name="cuf_pdf"]').val(js[0].ocuf).trigger('change');
                    $('[name="fecha_pdf"]').val(js[0].ofecha).trigger('change');
                    Swal.fire({
                        icon: 'success',
                        title: js[0].omensaje,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ACEPTAR'
                    }).then(function(result) {
                        document.getElementById("form_nota_credito").submit();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: js[0].omensaje,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'ACEPTAR'
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }
</script>