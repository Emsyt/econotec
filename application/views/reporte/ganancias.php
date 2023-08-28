<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Gary German Valverde Quisbert Fecha:16/09/2022, Codigo: GAN-MS-A1-462,
Descripcion: Se recreo frontend del maquetado en su ultima version del branch de design donde este ya cuenta con exportar en pdf, excel y su progress bar.
 */
?>
<?php if (in_array("smod_rep_ganc", $permisos)) { ?>
    <input type="hidden" name="ubicacion" id="ubicacion" value="<?php echo $id_ubicacion ?>">

    <script type="text/javascript">
        var f = new Date();
        fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();

        $(document).ready(function() {
            activarMenu('menu6', 9);
            $('[name="fecha_inicial"]').val(fecha_actual);
            $('[name="fecha_fin"]').val(fecha_actual);
            cambiar_consulta();
        });
    </script>

    <script>
        function enviar(destino) {
            console.log(destino);
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
                    <li class="active">Ganancias</li>
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
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_ganancias')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_ganancias')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
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
                                            <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE GANANACIAS</h5>
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
                                                <!--  <thead>
                                                    <tr>
                                                        <th width="10%">N&deg;</th>
                                                        <th width="40%">DETALLE</th>
                                                        <th width="10%">FECHA</th>
                                                        <th width="10%">HORA</th>
                                                        <th width="10%">CANTIDAD</th>
                                                        <th width="10%">MONTO UNITARIO</th>
                                                        <th width="10%">MONTO TOTAL</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th width="10%"></th>
                                                        <th width="40%"></th>
                                                        <th width="10%"></th>
                                                        <th width="10%"></th>
                                                        <th width="10%"></th>
                                                        <th width="10%"></th>
                                                        <th width="10%"></th>
                                                    </tr>
                                                </tfoot> -->
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
            console.log(fecha_inicial);
            console.log(fecha_fin);
            $.ajax({
                url: '<?= base_url() ?>reporte/C_reporte_ganancias/lst_reporte_ganancias',
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
                    var total = 0;
                    if (data.responce == "success") {
                        var t = $('#datatable3').DataTable({

                            "data": data.posts,
                            "responsive": false,
                            "bPaginate": false,
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

                            ],
                            "aoColumns": [{
                                    "mData": "fila"
                                },
                                {
                                    "mData": "fila"
                                },
                                {
                                    "mData": "detalle"
                                },
                                {
                                    "mData": "fecha"
                                },
                                {
                                    "mData": "cantidad"
                                },
                                {
                                    "mData": "monto_unitario",
                                },
                                {
                                    "mData": "monto_total"
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
                            },
                            "rowCallback": function(row, data) {
                                if (data["monto_total"] == '0') {
                                    $('td:eq(6)', row).addClass('valor_cero');
                                }
                                if (data["detalle"] == 'INGRESOS') {
                                    $(row).addClass('title_ingresos');
                                }
                                if (data["detalle"] == 'EGRESOS') {
                                    $(row).addClass('title_egresos');
                                }
                                if (data["detalle"] == 'DESCRIPCIÓN INGRESOS') {
                                    $(row).addClass('sub_title_ingresos');
                                }
                                if (data["detalle"] == 'DESCRIPCIÓN EGRESOS') {
                                    $(row).addClass('sub_title_egresos');
                                }
                                if (data["fila"] == ">") {
                                    $(row).addClass('split_cells');
                                }
                                if (data["fila"] == "=") {
                                    $('td:eq(5)', row).addClass('total');
                                    $('td:eq(6)', row).addClass('valor_mayor');
                                }
                                if (data["fila"] == "-") {
                                    $(row).addClass('results_title');
                                }
                                try {
                                    total = parseFloat(data["monto_total"]);
                                } catch {}
                                console.log(total);
                                if (total < 0) {
                                    console.log("entro menor");
                                    $('td:eq(6)', row).addClass('valor_menor');
                                } else {
                                    if (data["fila"] == ".") {
                                        $('td:eq(6)', row).addClass('valor_mayor');
                                    }

                                }
                            },
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
    </script>
    <style>
        .split_cells {
            background-color: #FFFFFF !important;
        }

        .total {
            background-color: #737373 !important;
            color: white;
        }

        .valor_mayor {
            background-color: #C3F7B9 !important;
        }
        .valor_cero {
            background-color: #FFFCB2 !important;
        }

        .valor_menor {
            background-color: #F18585 !important;
        }

        .title_ingresos {
            font-size: 20px;
            font-weight: bold;
            background-color: #5CD3E5 !important;
            color: white;
        }

        .title_egresos {
            font-size: 20px;
            font-weight: bold;
            background-color: #FFB194 !important;
            color: white;
        }

        .sub_title_ingresos {
            background-color: #D9F7F1 !important;
        }

        .sub_title_egresos {
            background-color: #FDE3D9 !important;
        }

        .results {
            background-color: #E5CFEC !important;
        }

        .results_title {
            font-size: 15px;
            font-weight: bold;
            background-color: #E5CFEC !important;
        }
    </style>
<?php } else {
    redirect('inicio');
} ?>