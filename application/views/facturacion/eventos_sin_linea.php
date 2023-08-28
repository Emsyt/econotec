<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:26/04/2022, Codigo: GAN-MS-A5-198,
Descripcion: Se actualizo frontend del maquetado en su ultima version del branch de design donde este ya cuenta con exportar en pdf, excel y su progress bar.
 */
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.0.0/css/bootstrap-datetimepicker.min.css">


<script type="text/javascript">
    var f = new Date();
    fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate() + " " + f.getHours() + ":" + f.getMinutes();

    $(document).ready(function() {
        activarMenu('menu17', 2);
        $('[name="fecha_inicial"]').val(fecha_actual);
        $('[name="fecha_fin"]').val(fecha_actual);

    });
</script>

<script>
    function enviar(destino) {
        document.form_stock.action = destino;
        document.form_stock.submit();
    }
</script>

<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="#">Facturacion</a></li>
                <li class="active">Eventos</li>
            </ol>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form class="form" name="form_stock" id="form_stock" method="post" target="_blank">
                        <div class="card">
                            <div class="card-head style-default-light">
                                <div class="tools">
                                    <div class="btn-group">
                                        <!-- <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_stock')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_stock')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button> -->
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <br>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-right">
                                        <img style="height: 65px;" src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes);
                                                                                            print($obj->{'logo'}); ?>">
                                    </div>

                                    <div class="col-xs-9 col-sm-9 col-md-7 col-lg-7 text-center">
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> EMPRESA <?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                                                                                                    print_r($obj->{'titulo'}); ?> </h5>
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> REGISTRO DE EVENTOS SIGNIFICATIVOS FUERA DE LINEA</h5>
                                    </div>
                                    <!-- 
                                    <div class="col-xs-9 col-sm-9 col-md-3 col-lg-3">
                                        <h6 class="text-ultra-bold text-default-light">Usuario: <?php echo $usuario; ?>
                                        </h6>
                                        <h6 class="text-ultra-bold text-default-light">Fecha: <?php echo $fecha_imp; ?>
                                        </h6>
                                    </div> -->
                                </div><br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="text-align: center;">
                                        <br>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class='col-xs-12 col-sm-12 col-md-5 col-lg-5'>
                                                <div class="form-group">
                                                    <div class='input-group date' id='datetimepicker1'>
                                                        <div class="input-group-content">
                                                            <input type='text' class="form-control" name="fecha_inicial" id="fecha_inicial" required>
                                                            <label for="fecha_inicial">Fecha Inicial del evento</label>

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
                                                    <div class="input-group date" id='datetimepicker2'>
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" required>
                                                            <label for="fecha_fin">Fecha Final del evento</label>
                                                        </div>
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" type="button" onclick="registrar_evento()">Listar eventos Significativos</button>
                                            <br><br>

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
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5%">N&deg;</th>
                                                    <th width="15%">EVENTO</th>
                                                    <th width="20%">FECHA INICIAL</th>
                                                    <th width="20%">FECHA FINAL</th>
                                                    <th width="15%">CODIGO</th>
                                                    <th width="10%">ACCION</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div><br> </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
<!-- BEGIN FORM MODAL -->
<div class="modal fade" name="modal_paq" id="modal_paq" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form" role="form" name="form_editar" id="form_editar" method="post" action="<?= site_url() ?>facturacion/C_eventos_sin_linea/emitirpaq">
                <input type="hidden" name="id_event" id="id_event">
                <input type="hidden" name="desc" id="desc">
                <input type="hidden" name="codigo" id="codigo">
                <input type="hidden" name="fecini" id="fecini">
                <input type="hidden" name="fecfin" id="fecfin">
                <input type="hidden" name="idfacturacion" id="idfacturacion">
                <input type="hidden" name="idsucursal" id="idsucursal">
                <input type="hidden" name="codpuntoventa" id="codpuntoventa">
                <input type="hidden" name="tabla" id="tabla">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">Lista de Facturas Aceptadas</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <select class="form-control select2-list" id="tipo_factura" name="tipo_factura" onchange="tipo_facturacion()" required>
                                    <option value="1">FACTURA COMPRA-VENTA</option>
                                    <option value="2">FACTURA COMPRA VENTA TASAS</option>
                                </select>
                                <label for="tipo_factura">Tipo de Factura</label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive" style="margin:10px; overflow-y: scroll;">
                                <table id="datatable_paq" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <!-- <th width="5%">N&deg;</th> -->
                                            <th width="40%">RAZÓN SOCIAL</th>
                                            <th width="10%">MONTO</th>
                                            <th width="30%">FECHA DE CREACION</th>
                                            <th width="20%">ESTADO</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div><br> </div>
                    </div>
                </div>

                <div class="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END FORM MODAL -->
<!-- END CONTENT -->
<!--  Datatables JS-->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- SUM()  Datatables-->
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>



<script type="text/javascript">
    function tipo_facturacion(id_facturacion = null, id_sucursal = null, cod_punto_venta = null, fecha_inicial = null, fecha_fin = null, id_evento = null ) {
        if (id_facturacion == null) {
            id_facturacion = document.getElementById('idfacturacion').value;
        }
        if (id_sucursal == null) {
            id_sucursal = document.getElementById('idsucursal').value;
        }
        if (cod_punto_venta == null) {
            cod_punto_venta = document.getElementById('codpuntoventa').value;
        }
        if (fecha_inicial == null) {
            fecha_inicial = document.getElementById('fecini').value;
        }
        if (fecha_fin == null) {
            fecha_fin = document.getElementById('fecfin').value;
        }
        if (id_evento == null) {
            id_evento = document.getElementById('id_event').value;
        }
        cod = document.getElementById("tipo_factura");
        var tipo = cod.options[cod.selectedIndex].value;
        console.log(tipo, fecha_fin, fecha_inicial);
        $.ajax({
            url: '<?= base_url() ?>facturacion/C_eventos_sin_linea/C_reporte_factura_realizadas',
            type: "post",
            datatype: "json",
            data: {
                fecha_inicial: fecha_inicial,
                fecha_fin: fecha_fin,
                tipo: tipo,
                id_facturacion: id_facturacion,
                id_sucursal: id_sucursal,
                cod_punto_venta: cod_punto_venta,
                id_evento:id_evento,
            },

            success: function(data) {
                console.log(data);
                $("#tabla").val(data);
                var data = JSON.parse(data);
                $('#datatable_paq').DataTable({
                    "data": data,
                    "responsive": true,
                    "language": {
                        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                    },
                    "destroy": true,
                    "columnDefs": [{
                        "searchable": true,
                        "orderable": false,
                        "targets": 0
                    }],

                    "aoColumns": [{
                            "mData": "razon_social"
                        },
                        {
                            "mData": "monto"
                        },
                        {
                            "mData": "feccre"
                        },
                        {
                            "mData": "apiestado"
                        },


                    ],
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Columnas"
                    },
                });

            },

            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }

    $(document).ready(function() {
        $.ajax({
            url: '<?= base_url() ?>facturacion/C_eventos_sin_linea/listar_eventos',
            type: "post",
            datatype: "json",
            success: function(data) {
                var data = JSON.parse(data);
                $('#datatable').DataTable({
                    "data": data,
                    "responsive": true,
                    "language": {
                        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                    },
                    "destroy": true,
                    "columnDefs": [{
                        "searchable": true,
                        "orderable": false,
                        "targets": 0
                    }],

                    "aoColumns": [{
                            "mData": "nro"
                        },
                        {
                            "mData": "evento"
                        },
                        {
                            "mData": "fecini"
                        },
                        {
                            "mData": "fecfin"
                        },
                        {
                            "mData": "apiestado"
                        },
                        {
                            "mRender": function(data, type, row, meta) {
                                var a = `
                                    <button title="Lista Facturas Evento"  type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="abrirmodal(${row.id_facturacion},${row.id_sucursal},${row.cod_punto_venta},\'${row.fecini}\',\'${row.fecfin}\',\'${row.evento}\',\'${row.codigo}\',${row.id_evento})"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                    `;

                                return a;
                            }
                        },

                    ],
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Columnas"
                    },
                });

            },

            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });

    });

    function abrirmodal(id_facturacion, id_sucursal, cod_punto_venta, fecha_inicial, fecha_fin, evento, codigo, id_evento) {
        $("#id_event").val(id_evento);
        $("#codigo").val(codigo);
        $("#desc").val(evento);
        $("#fecini").val(fecha_inicial);
        $("#fecfin").val(fecha_fin);
        $("#idfacturacion").val(id_facturacion);
        $("#idsucursal").val(id_sucursal);
        $("#codpuntoventa").val(cod_punto_venta);
        tipo_facturacion(id_facturacion, id_sucursal, cod_punto_venta, fecha_inicial, fecha_fin, id_evento);
        $('#modal_paq').modal('show');
    }
    $(function() {
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm '
        });
    });
    $(function() {
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm ',

        });
    });

</script>