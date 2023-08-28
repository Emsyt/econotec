<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creado: Alison Paola Pari Pareja Fecha:07/03/2023   GAN-DPR-M0-0340,
Descripcion: Se creo el diseño frontend del sub modulo de biometrico y el reconocimiento de las columnas al cargar un archivo

*/
?>
<?php if (in_array("smod_recur_bio", $permisos)) { ?>
    <script>
        var f = new Date();
        fechap_inicial = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
        fechap_fin = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
        $(document).ready(function() {
            activarMenu('menu16', 2);
            listar_archivos();
            $('[name="fecha_inicial"]').val(fechap_inicial);
            $('[name="fecha_final"]').val(fechap_fin);

        });
    </script>


    <script src="<?= base_url(); ?>assets/libs/sweetalert-master/sweetalert.min.js"></script>
    <style>
        hr {
            margin-top: 0px;
        }
    </style>
    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Recursos</a></li>
                    <li class="active">Biometrico</li>
                </ol>
            </div>

            <?php if ($this->session->flashdata('success')) { ?>
                <script>
                    window.onload = function mensaje() {
                        swal(" ", "<?php echo $this->session->flashdata('success'); ?>", "success");
                    }
                </script>
            <?php } else if ($this->session->flashdata('error')) { ?>
                <script>
                    window.onload = function mensaje() {
                        swal(" ", "<?php echo $this->session->flashdata('error'); ?>", "error");
                    }
                </script>
            <?php } ?>

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="text-primary">Listado de Importación
                            <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nuevo Cargado</button>
                        </h3>
                        <hr>
                    </div>
                </div>

                <div class="row" style="display: none;" id="form_registro">
                    <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
                        <div class="text-divider visible-xs"><span>Formulario de Registro de Importación de Biometrico</span></div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <form class="form form-validate" name="form_importar" id="form_importar" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id_proveedor" id="id_proveedor">
                                    <div class="card">
                                        <div class="card-head style-primary">
                                            <div class="tools">
                                                <div class="btn-group">
                                                    <a class="btn btn-icon-toggle" onclick="update_formulario()"><i class="md md-refresh"></i></a>
                                                    <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                                                </div>
                                            </div>
                                            <header id="titulo"></header>
                                        </div>

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-4">
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="input-group date" id="demo-date-val">
                                                            <div class="input-group-content">
                                                                <input type="text" class="form-control" name="fecha_final" id="fecha_final" readonly="" required>
                                                                <label for="fecha_final">Fecha Final</label>
                                                            </div>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group floating-label" id="c_sigla">
                                                        <input class="" type="file" name="archivo" accept="dat, .dat, |.dat" id="getFile" required onchange="lst_opciones_select_dat()" />
                                                        <span id="error-file" style="color: red;display:none;">Seleccione un archivo</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="process_doc" style="display:none;">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120" style="">
                                                    </div>
                                                </div>
                                                <div class="status"></div>
                                            </div>
                                            <div class="row" id="columns" style="display: none;">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_usuario" name="c_usuario" required>
                                                                <option value="null">&nbsp;</option>
                                                            </select>
                                                            <label for="c_usuario">CI</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_fecha" name="c_fecha" required>
                                                                <option value="null">&nbsp;</option>
                                                            </select>
                                                            <label for="c_fecha">Fecha</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_hora" name="c_hora" required>
                                                                <option value="null">&nbsp;</option>
                                                            </select>
                                                            <label for="c_hora">Hora</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_dato1" name="c_dato1" required>
                                                                <option value="null">&nbsp;</option>
                                                            </select>
                                                            <label for="c_dato1">Dato 1</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_dato2" name="c_dato2" required>
                                                                <option value="null">&nbsp;</option>
                                                            </select>
                                                            <label for="c_dato2">Dato 2</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_dato3" name="c_dato3" required>
                                                                <option value="null">&nbsp;</option>
                                                            </select>
                                                            <label for="c_dato3">Dato 3</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_dato4" name="c_dato4" required>
                                                                <option value="null">&nbsp;</option>
                                                            </select>
                                                            <label for="c_dato4">Dato 4</label>
                                                        </div>
                                                    </div>
                                                    <input value="x.x" type="hidden" class="form-control" name="rawname" id="rawname">
                                                    <input type="hidden" class="form-control" name="ruta" id="ruta">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="process" style="display: none;margin: 3%;">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120" style="padding:10%;">
                                                </div>
                                            </div>
                                            <div class="status"></div>
                                        </div>
                                        <div class="card-actionbar">
                                            <div class="card-actionbar-row">
                                                <div class="col-sm-10" style="text-align:left;">
                                                    <span id="nota">Click <a style="color: blue;" href="<?= base_url() ?>assets/docs/recursos/formato_de_ejemplo_importacion_biometrico.xlsx" download="formato_de_ejemplo_importacion_productos.xlsx">aqui</a> para descargar formato de ejemplo.</span><br>
                                                    <span id="nota" style="color: red;">*Considerar que todos los campos son obligatorios.</span>
                                                </div>
                                                <a id="submitButton" onclick="cargar_datos_dat()" class="btn btn-flat btn-primary ink-reaction">Cargar</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 ">
                        <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
                        <div class="card card-bordered style-primary">
                            <div class="card-body style-default-bright">

                                <div class="form-group" id="process" style="display:none;">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120" style="">
                                        </div>
                                    </div>
                                    <div class="status"></div>
                                </div>
                                <div class="table-responsive" id="vista1">
                                    <table id="datatable_archivos" class="table select table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">Nº</th>
                                                <th width="30%">Nombre Archivo</th>
                                                <th width="20%">Fecha</th>
                                                <th width="20%">Estado</th>
                                                <th width="20%">Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- END CONTENT -->


    <script>
        function formulario() {
            $("#titulo").text("Cargar Archivo");
            document.getElementById("form_registro").style.display = "block";
        }

        function cerrar_formulario() {
            document.getElementById("form_registro").style.display = "none";
        }

        function update_formulario() {
            $('#form_importar')[0].reset();
            $('#btn_edit').attr("disabled", true);
            $('#btn_add').attr("disabled", false);
        }
    </script>

    <script language="JavaScript">
        function cargar_biometrico() {

            var formulario = document.getElementById("form_importar");
            var formData = new FormData(formulario);

            var fecha_inicial = formData.get("fecha_inicial");
            var fecha_final = formData.get("fecha_final");
            var c_usuario = formData.get("c_usuario");
            var c_fecha = formData.get("c_fecha");
            var c_hora_ingreso = formData.get("c_hora_ingreso");
            var c_hora_salida = formData.get("c_hora_salida");
            var rawname = formData.get("rawname");
            var ruta = formData.get("ruta");

            $.ajax({
                url: '<?= site_url() ?>add_biometrico',
                type: "post",
                datatype: "json",
                data: {
                    fecha_inicial,
                    fecha_final,
                    c_usuario,
                    c_fecha,
                    c_hora_ingreso,
                    c_hora_salida,
                    rawname,
                    ruta
                },
                xhr: function() {
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
                            if (percent >= 100) {
                                var delayInMilliseconds = 99999;
                                $('#submitButton').attr('disabled', true);
                                setTimeout(function() {
                                    $('#submitButton').attr('disabled', true);
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
                    $('.progress-bar').css('width', '0%');
                    $('#process').css('display', 'none');
                    $('#submitButton').attr('disabled', true);
                    //console.log(data);
                    if (data) {
                        location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al enviar los datos');
                }
            });
        }

        function lst_opciones_select_dat() {
            document.getElementById("columns").style.display = "none";
            document.getElementById("error-file").style.display = "none";
            var formData = new FormData($('#form_importar')[0]);
            vaciar_selects();
            var lts_usuario = $("#c_usuario");
            var lts_fecha = $("#c_fecha");
            var lst_hora = $("#c_hora");
            var lst_dato1 = $("#c_dato1");
            var lst_dato2 = $("#c_dato2");
            var lst_dato3 = $("#c_dato3");
            var lst_dato4 = $("#c_dato4");

            let vector = [
                ["1", "c_usuario"],
                ["2", "c_fecha"],
                ["3", "c_hora"],
                ["4", "c_dato1"],
                ["5", "c_dato2"],
                ["6", "c_dato3"],
                ["7", "c_dato4"]
            ];

            $.ajax({
                type: "POST",
                url: '<?= site_url() ?>importar_biometrico_dat',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                xhr: function() {
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
                            if (percent >= 100) {
                                var delayInMilliseconds = 230;
                                setTimeout(function() {
                                    $('#process_doc').css('display', 'none');
                                    $('.progress-bar').css('width', '0%');
                                    percent == 0;
                                }, delayInMilliseconds);
                            }
                        }, true);
                    }
                    return xhr;
                },
                beforeSend: function() {
                    $('#process_doc').css('display', 'block');
                },
                success: function(resp) {
                    var obj = JSON.parse(resp);
                    var opciones = ["CI", "FECHA", "HORA", "DATO 1", "DATO 2", "DATO 3", "DATO 4"]

                    $('#ruta').val(obj.ruta);
                    $('#rawname').val(obj.rawname);
                    $(obj.variables_encontradas).each(function(i, v) { // indice, valor
                        lts_usuario.append('<option value="' + "var" + i + '">' + opciones[i] + ": Primer Dato:" + (v[0]).toUpperCase() + '</option>');
                        lts_fecha.append('<option value="' + "var" + i + '">' + opciones[i] + ": Primer Dato:" + (v[0]).toUpperCase() + '</option>');
                        lst_hora.append('<option value="' + "var" + i + '">' + opciones[i] + ": Primer Dato:" + (v[0]).toUpperCase() + '</option>');
                        lst_dato1.append('<option value="' + "var" + i + '">' + opciones[i] + ": Primer Dato:" + (v[0]).toUpperCase() + '</option>');
                        lst_dato2.append('<option value="' + "var" + i + '">' + opciones[i] + ": Primer Dato:" + (v[0]).toUpperCase() + '</option>');
                        lst_dato3.append('<option value="' + "var" + i + '">' + opciones[i] + ": Primer Dato:" + (v[0]).toUpperCase() + '</option>');
                        lst_dato4.append('<option value="' + "var" + i + '">' + opciones[i] + ": Primer Dato:" + (v[0]).toUpperCase() + '</option>');
                    });


                    /* Ordernar campos en selects */
                    for (let i = 0; i < opciones.length; i++) {
                        let val = vector[i];
                        //$('[name="c_usuario"]').val(0).trigger('change');
                        $('[name="' + val[1] + '"]').val("var" + i).trigger('change');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }

            });
            document.getElementById("columns").style.display = "block";
        }

        function cargar_datos_dat() {
            var formulario = document.getElementById("form_importar");
            var formData = new FormData(formulario);

            var c_usuario = formData.get("c_usuario");
            var c_fecha = formData.get("c_fecha");
            var c_hora = formData.get("c_hora");
            var c_dato1 = formData.get("c_dato1");
            var c_dato2 = formData.get("c_dato2");
            var c_dato3 = formData.get("c_dato3");
            var c_dato4 = formData.get("c_dato4");

            var rawname = formData.get("rawname");
            var ruta = formData.get("ruta");

            $.ajax({
                url: '<?= site_url() ?>add_biometrico_dat',
                type: "post",
                datatype: "json",
                data: {
                    c_usuario,
                    c_fecha,
                    c_hora,
                    c_dato1,
                    c_dato2,
                    c_dato3,
                    c_dato4,
                    rawname,
                    ruta
                },
                xhr: function() {
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
                            if (percent >= 100) {
                                var delayInMilliseconds = 99999;
                                $('#submitButton').attr('disabled', true);
                                setTimeout(function() {
                                    $('#submitButton').attr('disabled', true);
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
                    $('.progress-bar').css('width', '0%');
                    $('#process').css('display', 'none');
                    $('#submitButton').attr('disabled', true);
                    //console.log(data);
                    if (data) {
                        location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al enviar los datos');
                }
            });
        }

        function lts_opciones_select() {
            document.getElementById("columns").style.display = "none";
            document.getElementById("error-file").style.display = "none";
            var formData = new FormData($('#form_importar')[0]);
            vaciar_selects();
            var lts_usuario = $("#c_usuario");
            var lts_fecha = $("#c_fecha");
            var lts_hora_ingreso = $("#c_hora_ingreso");
            var lts_hora_salida = $("#c_hora_salida");

            let vector = [
                ["Usuario", "c_usuario"],
                ["Fecha", "c_fecha"],
                ["Hora_ingreso", "c_hora_ingreso"],
                ["Hora_salida", "c_hora_salida"]
            ];

            $.ajax({
                type: "POST",
                url: '<?= site_url() ?>importar_biometrico',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                xhr: function() {
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
                            if (percent >= 100) {
                                var delayInMilliseconds = 230;
                                setTimeout(function() {
                                    $('#process_doc').css('display', 'none');
                                    $('.progress-bar').css('width', '0%');
                                    percent == 0;
                                }, delayInMilliseconds);
                            }
                        }, true);
                    }
                    return xhr;
                },
                beforeSend: function() {
                    $('#process_doc').css('display', 'block');
                },
                success: function(resp) {
                    var obj = JSON.parse(resp);
                    $('#ruta').val(obj.ruta);
                    $('#rawname').val(obj.rawname);
                    $(obj.lista).each(function(i, v) { // indice, valor
                        lts_usuario.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_fecha.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_hora_ingreso.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_hora_salida.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                    });

                    for (let i = 0; i < vector.length; i++) {
                        let val = vector[i];
                        $('[name="' + val[1] + '"]').val(0).trigger('change');
                    }
                    let x = obj.encontrados;
                    if (x) {

                        for (let i = 0; i < x.length; i++) {
                            for (let j = 0; j < vector.length; j++) {
                                let val = vector[j]
                                let text = val[0]
                                if (x[i].nombre == text) {
                                    $('[name="' + val[1] + '"]').val(x[i].valor).trigger('change');
                                }
                            }
                        }
                    } else {
                        console.log("no encontrados");
                    }
                    document.getElementById("columns").style.display = "block";

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function vaciar_selects() {
            let vector = ["c_usuario", "c_fecha", "c_hora", "c_dato1", "c_dato2", "c_dato3", "c_dato4"];
            for (let i = 0; i < vector.length; i++) {
                var select = document.getElementById(vector[i]),
                    length = select.options.length;
                while (length--) {
                    select.remove(length);
                }
                $("#" + vector[i]).append('<option value="0">&nbsp;</option>');
            }
        }

        function listar_archivos() {
            $.ajax({
                url: '<?= site_url() ?>lst_archivos_biometrico',
                type: "post",
                datatype: "json",
                success: function(data) {
                    var data = JSON.parse(data);

                    if (data.responce == "success") {
                        var t = $('#datatable_archivos').DataTable({
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
                            "order": [],
                            "aoColumns": [{
                                    "mData": "nro"
                                },
                                {
                                    "mData": "nombrearchivo"
                                },
                                {
                                    "mData": "fecha"
                                },
                                {
                                    "mData": "apiestado"
                                },
                                {
                                    "mRender": function(data, type, row, meta) {

                                        var a = `
                                        <button type="button" title="Descargar EXCEL" class="btn btn-info ink-reaction btn-floating-action btn-xs" onclick="descargar_archivo('${row.archivo}','<?= site_url() ?>excel_archivo')"><i class="fa fa-download" aria-hidden="true"></i></button>
                                        <button type="button" title="Descargar TXT" class="btn btn-info ink-reaction btn-floating-action btn-xs" onclick="descargar_archivo('${row.archivo}','<?= site_url() ?>excel_archivo')"><i class="fa fa-download" aria-hidden="true"></i></button>
                                        <button type="button" title="Descargar DATA" class="btn btn-info ink-reaction btn-floating-action btn-xs" onclick="descargar_archivo('${row.archivo}','<?= site_url() ?>excel_archivo')"><i class="fa fa-download" aria-hidden="true"></i></button>
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
        };
    </script>
<?php } else {
    redirect('inicio');
} ?>