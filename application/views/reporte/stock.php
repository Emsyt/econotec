<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:26/04/2022, Codigo: GAN-MS-A5-198,
Descripcion: Se actualizo frontend del maquetado en su ultima version del branch de design donde este ya cuenta con exportar en pdf, excel y su progress bar.
 */
?>
<?php if (in_array("smod_rep_ajst_stock", $permisos)) { ?>


<script type="text/javascript">
    var f = new Date();
    fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();

    $(document).ready(function() {
        activarMenu('menu6', 7);
        $('[name="fecha_inicial"]').val(fecha_actual);
        $('[name="fecha_fin"]').val(fecha_actual);
        $('[name="ubi_trabajo"]').val('');
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
                <li><a href="#">Reportes</a></li>
                <li class="active">Ajuste de Stock</li>
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
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_stock')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_stock')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
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
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE AJUSTE DE STOCK</h5>
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
                                            <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" type="button" onclick="generar_reporte()">Generar Reporte</button>
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
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5%">N&deg;</th>
                                                    <th width="15%">USUARIO</th>
                                                    <th width="20%">OBSERVACIÓN</th>
                                                    <th width="15%">FECHA / HORA</th>
                                                    <th width="15%">STOCK ANTERIOR</th>
                                                    <th width="15%">STOCK MOVIDO</th>
                                                    <th width="15%">STOCK ACTUAL</th>
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
<!-- END CONTENT -->
<!--  Datatables JS-->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- SUM()  Datatables-->
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>

<script type="text/javascript">
    function generar_reporte() {
        cod_ubicacion = document.getElementById("ubi_trabajo");
        var ubi_trabajo = cod_ubicacion.options[cod_ubicacion.selectedIndex].value;
        var fecha_inicial = document.getElementById("fecha_inicial").value;
        var fecha_fin = document.getElementById("fecha_fin").value;
        $.ajax({
            url: '<?= base_url() ?>reporte/C_reporte_stock/lst_reporte_stock',
            type: "post",
            datatype: "json",
            data: {
                ubi_trabajo: ubi_trabajo,
                fecha_inicial: fecha_inicial,
                fecha_fin: fecha_fin,
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
                    "order": [
                        [1, 'dec']
                    ],
                    "aoColumns": [{
                            "mData": "onro"
                        },
                        {
                            "mData": "ousuario"
                        },
                        {
                            "mData": "oobservacion"
                        },
                        {
                            "mData": "ofechahora"
                        },
                        {
                            "mData": "oanterior"
                        },
                        {
                            render: function(data, type, row) {
                                let movido=parseInt(row.oposterior)-parseInt(row.oanterior);
                                return movido+"";
                            }
                        },
                        {
                            "mData": "oposterior"
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
</script>
<?php } else {redirect('inicio');}?>
