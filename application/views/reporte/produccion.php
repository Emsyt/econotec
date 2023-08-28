<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Gary German Valverde Quisbert Fecha:16/09/2022, Codigo: GAN-MS-A1-462,
Descripcion: Se recreo frontend del maquetado en su ultima version del branch de design donde este ya cuenta con exportar en pdf, excel y su progress bar.
------------------------------------------------------------------------------
Modificado: Wilson Huanca Callisaya Fecha: 09/02/2023   Actividad: GAN-MS-B0-0203      
Descripcion : Se medificó las descripciones de las tablas usadon acronimos.  
 */
?>
<?php if (in_array("smod_rep_prod", $permisos)) { ?>
<input type="hidden" name="ubicacion" id="ubicacion" value="<?php echo $id_ubicacion ?>">

<script type="text/javascript">
    
    var f = new Date();
    fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();

    $(document).ready(function() {
        activarMenu('menu6', 8);
        $('[name="fecha_inicial"]').val(fecha_actual);
        $('[name="fecha_fin"]').val(fecha_actual);
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
                <li class="active">Producción</li>
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
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_produccion')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_produccion')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
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
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE PRODUCCIÓN</h5>
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
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="datatable3" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="4%">N&deg;</th>
                                                    <th width="4%">ID LOTE</th>
                                                    <th width="10%">PROD. INGRESADOS</th>
                                                    <th width="7%">FECHA DE INGRESO</th>
                                                    <th width="5%">HR. DE INGRESO</th>
                                                    <th width="5%">USUARIO DE INGRESO</th>
                                                    <th width="7%">UBI. INICIAL INGRESO</th>
                                                    <th width="7%">UBI. DESTINO INGRESO</th>
                                                    <th width="8%">PROD. DE SALIDA</th> 
                                                    <th width="6%">FECHA DE SALIDA</th>
                                                    <th width="5%">HR. DE SALIDA</th>
                                                    <th width="5%">USUARIO DE SALIDA</th>
                                                    <th width="7%">UBI. DESTINO SALIDA</th>
                                                    <th width="5%">HR. DE PRODUCCIÓN</th>
                                                    <th width="5%">ESTADO MOVIMIENTO</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th width="4%"></th>
                                                    <th width="4%"></th>
                                                    <th width="10%"></th>
                                                    <th width="7%"></th>
                                                    <th width="5%"></th>
                                                    <th width="5%"></th>
                                                    <th width="7%""></th>
                                                    <th width="7%"></th>
                                                    <th width="8%"></th> 
                                                    <th width="6%"></th>
                                                    <th width="5%"></th>
                                                    <th width="5%"></th>
                                                    <th width="7%"></th>
                                                    <th width="5%"></th>
                                                    <th width="5%"></th>
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
        var fecha_inicial = document.getElementById("fecha_inicial").value;
        var fecha_fin = document.getElementById("fecha_fin").value;
        $.ajax({
            url: '<?= base_url() ?>reporte/C_reporte_produccion/lst_reporte_produccion',
            type: "post",
            datatype: "json",
            data: {
                fecha_inicial: fecha_inicial,
                fecha_fin: fecha_fin
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
                                "mData": "nro"
                            },
                            {
                                "mData": "id_lote"
                            },
                            {
                                "mData": "productos_ingreso"
                            },
                            {
                                "mData": "fecha_ingreso"
                            },
                            {
                                "mData": "hora_ingreso"
                            },
                            {
                                "mData": "usuario_ingreso"
                            },
                            {
                                "mData": "ubicacion_inicial_ingreso"
                            },
                            {
                                "mData": "ubicacion_destino_ingreso"
                            },
                            {
                                "mData": "productos_salida"
                            },
                            {
                                "mData": "fecha_salida"
                            },
                            {
                                "mData": "hora_salida"
                            },
                            {
                                "mData": "usuario_salida"
                            },
                            {
                                "mData": "ubicacion_destino_salida"
                            },
                            {
                                "mData": "horas_produccion"
                            },
                            {
                                "mData": "estado_movimiento"
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
