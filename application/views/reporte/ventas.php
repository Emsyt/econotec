<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:19/11/2021, Codigo: GAN-MS-A3-079,
Descripcion: Se recreo frontend del maquetado en su ultima version del branch de design donde este ya cuenta con exportar en pdf, excel y su progress bar.
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Ariel Ramos Paucara Fecha:20/04/2023, Codigo: GAN-MS-A0-0426,
Descripcion: Se añadio el campo codigo para mostrar en la tabla
 */
?>
<?php if (in_array("smod_rep_vent", $permisos)) { ?>

<input type="hidden" name="ubicacion" id="ubicacion" value="<?php echo $id_ubicacion ?>">

<script type="text/javascript">
    var f = new Date();
    fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
    var id_ubi = $("#ubicacion").val();

    $(document).ready(function() {
        activarMenu('menu6', 1);
        $('[name="fecha_inicial"]').val(fecha_actual);
        $('[name="fecha_fin"]').val(fecha_actual);
        $('[name="ubi_trabajo"]').val(id_ubi);
        cambiar_consulta();
        // total();
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
                <li class="active">Ventas</li>
            </ol>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form class="form" name="form_busqueda" id="form_busqueda" method="post" target="_blank">
                        <div class="card">
                            <div class="card-head style-default-light">
                                <div class="tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_ventas')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_ventas')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
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
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE VENTAS</h5>
                                    </div>

                                    <div class="col-xs-9 col-sm-9 col-md-3 col-lg-3">
                                        <h6 class="text-ultra-bold text-default-light">Usuario: <?php echo $usuario; ?>
                                        </h6>
                                        <h6 class="text-ultra-bold text-default-light">Fecha: <?php echo $fecha_imp; ?>
                                        </h6>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="text-align: center;">
                                        <br>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <select class="form-control select2-list" id="ubi_trabajo" name="ubi_trabajo" required>
                                                    <?php foreach ($ubicaciones as $ubi) {  ?>
                                                        <option value="<?php echo $ubi->id_ubicacion ?>" <?php echo set_select('ubi_trabajo', $ubi->id_ubicacion) ?>>
                                                            <?php echo $ubi->descripcion ?></option>
                                                    <?php  } ?>
                                                </select>
                                                <label for="ubi_trabajo">Ubicaci&oacute;n de Trabajo</label>
                                            </div>
                                        </div>
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
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div>
                                                <div class="form-group">
                                                    <select class="form-control select2-list" id="tventa" name="tipo" required>
                                                        <option value="0">TODOS<i style="color: #006400; " class="fa fa-money fa-2x"></i>
                                                        </option>
                                                        <option value="1279">EFECTIVO<i style="color: #006400; " class="fa fa-money fa-2x"></i>
                                                        </option>
                                                        <option value="1280">TARJETA<i style="color: #000000; " class="fa fa-credit-card fa-2x"></i>
                                                        </option>
                                                        <option value="1324">CODIGO QR<i style="color: #000000; " class="fa fa-qrcode fa-2x"></i>
                                                        </option>
                                                        <option value="1281">DEUDA<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">

                                                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                                            </svg>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" type="button" onclick="cambiar_consulta()">Generar Reporte</button>
                                            <br><br>

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
                                        <h4 class="text-ultra-bold" style="color:#655e60;">Costo Total:</h4>
                                        <h4 id="costo_total" class="text-ultra-bold" style="color:#655e60;"></h4>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="text-align: center;">
                                        <br><br><br>
                                        <h4 class="text-ultra-bold" style="color:#655e60;">Utilidad Bruta:</h4>
                                        <h4 id="utilidad_bruta" class="text-ultra-bold" style="color:#655e60;"></h4>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="datatable3" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5%">N&deg;</th>
                                                    <th width="10%">VENDEDOR</th>
                                                    <th width="10%">CLIENTE</th>
                                                    <th width="15%">DESCRIPCIÓN PRODUCTO</th>
                                                    <th width="15%">CÓDIGO PRODUCTO</th>
                                                    <th width="3%">CANTIDAD PRODUCTOS</th>
                                                    <th width="10%">PRECIO UNITARIO</th>
                                                    <th width="10%">PRECIO VENTA</th>
                                                    <th width="10%">PRECIO COMPRA</th>
                                                    <th width="10%">UTILIDAD BRUTA</th>
                                                    <th width="10%">FECHA</th> 
                                                    <th width="10%">TIPO VENTA</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th width="5%"></th>
                                                    <th width="10%"></th>
                                                    <th width="10%"></th>
                                                    <th width="15%"></th>
                                                    <th width="15%"></th>
                                                    <th width="3%"></th>
                                                    <th width="10%"></th>
                                                    <th width="10%"></th>
                                                    <th width="10%"></th>
                                                    <th width="10%"></th>
                                                    <th width="10%"></th>
                                                    <th width="10%"></th>
                                                </tr>
                                            </tfoot>
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
<!-- END CONTENT -->
<!--  Datatables JS-->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- SUM()  Datatables-->
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>

<script type="text/javascript">
    function cambiar_consulta() {
        cod_ubicacion = document.getElementById("ubi_trabajo");
        var selc_ubi = cod_ubicacion.options[cod_ubicacion.selectedIndex].value;
        var fecha_ini = document.getElementById("fecha_inicial").value;
        var fecha_fin = document.getElementById("fecha_fin").value;
        var tventa = document.getElementById("tventa").value;

        $.ajax({
            url: '<?= base_url() ?>reporte/C_reporte_ventas/lst_reporte_ventas',
            type: "post",
            datatype: "json",
            data: {
                selc_ubi: selc_ubi,
                fecha_ini: fecha_ini,
                fecha_fin: fecha_fin,
                tipo: tventa
            },

            xhr: function() {
                //upload Progress
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //update progressbar
                        $(".progress-bar").css("width", +percent + "%");
                        $(".status").text(percent + "%");
                        if (percent >= 100) {
                            $(".status").text(percent + "%");
                            var delayInMilliseconds = 200;

                            setTimeout(function() {
                                //your code to be executed after 1 second
                                $('#process').css('display', 'none');
                                $('.progress-bar').css('width', '0%');
                                percent == 0;
                            }, delayInMilliseconds);
                        }
                    }, true);
                }
                return xhr;
            },
            beforeSend: function() {
                $('#process').css('display', 'block');
            },
            success: function(data) {
                var data = JSON.parse(data);
                if (data.responce == "success") {
                    var t = $('#datatable3').DataTable({
                        "data": data.posts,
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
                            [1, 'dec']
                        ],
                        "aoColumns": [{
                                "mData": "onro"
                            },
                            {
                                "mData": "ovendedor"
                            },
                            {
                                "mData": "ocliente"
                            },
                            {
                                "mData": "oproducto"
                            },
                            {
                                "mData": "ocodigo"
                            },
                            {
                                "mData": "ocantidad"
                            },
                            {
                                "mData": "oprecio"
                            },
                            {
                                "mData": "ototal"
                            },
                            {
                                "mData": "ototal_compra"
                            },
                            {
                                "mData": "outilidad"
                            },
                            {
                                "mData": "ofecha"
                            },
                            {
                                "mData": "otipoventa"
                            },

                        ],
                        "dom": 'C<"clear">lfrtip',
                        "colVis": {
                            "buttonText": "Columnas"
                        },
                        "drawCallback": function() {
                            //alert("La tabla se está recargando"); 
                            var api = this.api();
                            var table = api.table();
                            let total_costo = (api.column(5, {
                                page: 'current'
                            }).data().sum()).toFixed(2);
                            let Utilidad_bruta = (api.column(6, {
                                page: 'current'
                            }).data().sum()).toFixed(2);
                            $(api.column(5).footer()).html(
                                'Total: ' + total_costo
                            );
                            $(api.column(6).footer()).html(
                                'Total: ' + Utilidad_bruta
                            )
                        }
                    });
                    t.on('order.dt search.dt', function() {
                        t.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });

        $.ajax({
            url: '<?= base_url() ?>reporte/C_reporte_ventas/totales_reporte_ventas',
            type: "post",
            datatype: "json",
            data: {
                selc_ubi: selc_ubi,
                fecha_ini: fecha_ini,
                fecha_fin: fecha_fin,
                tipo: tventa
            },
            success: function(data) {
                var data = JSON.parse(data);
                document.getElementById("costo_total").innerHTML = data[0].total;
                document.getElementById("utilidad_bruta").innerHTML = data[0].utilidad;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }

    function total() {
        $('#datatable3').DataTable({
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(6)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(6, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(6).footer()).html(
                    '$' + pageTotal + ' ( $' + total + ' total)'
                );
            }
        });
    }
</script>
<?php } else {redirect('inicio');}?>
