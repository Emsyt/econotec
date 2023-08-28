<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creado: Gary German Valverde Quisbert Fecha:24/07/2023   GAN-MS-A3-0182,
Descripcion: Se realizo la implementacion del modulo IMPORTAR CARACTERISTICAS,

*/
?>
<?php if (in_array("smod_imp", $permisos)) { ?>
    <script>
        $(document).ready(function() {
            activarMenu('menu2', 7);
            listar_archivos();
        });
    </script>


    <script src="<?= base_url(); ?>assets/libs/sweetalert-master/sweetalert.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <li><a href="#">Productos</a></li>
                    <li class="active">Importar caracteristicas</li>
                </ol>
            </div>



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
                        <div class="text-divider visible-xs"><span>Formulario de Registro de Importación</span></div>
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
                                                <div class="col-sm-12">
                                                    <div class="form-group floating-label" id="c_sigla">
                                                        <input class="" type="file" name="archivo" id="getFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required onchange="lts_opciones_select()" />
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
                                                            <select class="form-control select2-list" id="c_cod_prod" name="c_cod_prod" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_cod_prod">Codigo de producto</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_m01" name="c_m01" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_m01">Medida 01</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_m02" name="c_m02" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_m02">Medida 02</label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_m03" name="c_m03" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_m03">Medida 03</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_m04" name="c_m04" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_m04">Medida 04</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_m05" name="c_m05" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_m05">Medida 05</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_m06" name="c_m06" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_m06">Medida 06</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_m07" name="c_m07" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_m07">Medida 07</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_desc_precioa" name="c_desc_precioa" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_desc_precioa">Descripcion Precio A</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_desc_preciob" name="c_desc_preciob" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_desc_preciob">Descripcion Precio B</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_desc_precioc" name="c_desc_precioc" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_desc_precioc">Descripcion Precio C</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_precioa" name="c_precioa" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_precioa">Precio A</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_preciob" name="c_preciob" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_preciob">Precio B</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <select class="form-control select2-list" id="c_precioc" name="c_precioc" required>
                                                                <option value="0">&nbsp;</option>
                                                            </select>
                                                            <label for="c_precioc">Precio C</label>
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
                                                    <span id="nota">Click <a style="color: blue;" href="<?= base_url() ?>assets/docs/productos/formato_de_ejemplo_importacion_productos.xlsx" download="formato_de_ejemplo_importacion_productos.xlsx">aqui</a> para descargar formato de ejemplo.</span><br>
                                                    <span id="nota" style="color: red;">*Considerar que todos los campos son obligatorios.</span>
                                                </div>
                                                <a id="submitButton" class="btn btn-flat btn-primary ink-reaction" onclick="addDatos()">Cargar</a>
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
                                                <th width="25%">Nombre Archivo</th>
                                                <th width="35%">Fecha</th>
                                                <th width="35%">Estado</th>
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

        function listar_archivos() {
            $.ajax({
                url: '<?= site_url() ?>lst_archivos',
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
                                    "mData": "archivo"
                                },
                                {
                                    "mData": "fecha_revision"
                                },
                                {
                                    "mData": "apiestado"
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

    <script language="JavaScript">
        function addDatos() {
            let ruta = document.getElementById("ruta").value;
            let rawname = document.getElementById("rawname").value;

            if (rawname == "x.x") {
                errorfile = document.getElementById('error-file');
                errorfile.style.display = '';
                return;
            }
            let c_cod_prod = document.getElementById("c_cod_prod").value;
            let c_m01 = document.getElementById("c_m01").value;
            let c_m02 = document.getElementById("c_m02").value;
            let c_m03 = document.getElementById("c_m03").value;
            let c_m04 = document.getElementById("c_m04").value;
            let c_m05 = document.getElementById("c_m05").value;
            let c_m06 = document.getElementById("c_m06").value;
            let c_m07 = document.getElementById("c_m07").value;
            let c_desc_precioa = document.getElementById("c_desc_precioa").value;
            let c_desc_preciob = document.getElementById("c_desc_preciob").value;
            let c_desc_precioc = document.getElementById("c_desc_precioc").value;
            let c_precioa = document.getElementById("c_precioa").value;
            let c_preciob = document.getElementById("c_preciob").value;
            let c_precioc = document.getElementById("c_precioc").value;

            console.log(ruta);
            console.log(rawname);
            console.log(c_cod_prod);
            console.log(c_m01);
            console.log(c_m02);
            console.log(c_m03);
            console.log(c_m04);
            console.log(c_m05);
            console.log(c_m06);
            console.log(c_m07);
            console.log(c_desc_precioa);
            console.log(c_desc_preciob);
            console.log(c_desc_precioc);
            console.log(c_precioa);
            console.log(c_preciob);
            console.log(c_precioc);


            $.ajax({
                url: '<?= site_url() ?>add_datos_car',
                type: "post",
                datatype: "json",
                data: {
                    c_cod_prod: c_cod_prod,
                    c_m01: c_m01,
                    c_m02: c_m02,
                    c_m03: c_m03,
                    c_m04: c_m04,
                    c_m05: c_m05,
                    c_m06: c_m06,
                    c_m07: c_m07,
                    c_desc_precioa: c_desc_precioa,
                    c_desc_preciob: c_desc_preciob,
                    c_desc_precioc: c_desc_precioc,
                    c_precioa: c_precioa,
                    c_preciob: c_preciob,
                    c_precioc: c_precioc,
                    ruta: ruta,
                    rawname: rawname
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
                    var data = JSON.parse(data);
                    console.log(data[0].oboolean);
                    if (data[0].oboolean == 't') {
                        Swal.fire({
                            icon: 'success',
                            text: "Archivo recepcionado correctamente",
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ACEPTAR'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            } else {
                                location.reload();
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data[0].omensaje,
                        })
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
            var lts_c_cod_prod = $("#c_cod_prod");
            var lts_c_m01 = $("#c_m01");
            var lts_c_m02 = $("#c_m02");
            var lts_c_m03 = $("#c_m03");
            var lts_c_m04 = $("#c_m04");
            var lts_c_m05 = $("#c_m05");
            var lts_c_m06 = $("#c_m06");
            var lts_c_m07 = $("#c_m07");
            var lts_c_desc_precioa = $("#c_desc_precioa");
            var lts_c_desc_preciob = $("#c_desc_preciob");
            var lts_c_desc_precioc = $("#c_desc_precioc");
            var lts_c_precioa = $("#c_precioa");
            var lts_c_preciob = $("#c_preciob");
            var lts_c_precioc = $("#c_precioc");


            let vector = [
                ["cod_prod", "c_cod_prod"],
                ["MEDIDA1", "c_m01"],
                ["MEDIDA2", "c_m02"],
                ["MEDIDA3", "c_m03"],
                ["MEDIDA4", "c_m04"],
                ["MEDIDA5", "c_m05"],
                ["MEDIDA6", "c_m06"],
                ["MEDIDA7", "c_m07"],
                ["precio_a", "c_desc_precioa"],
                ["precio_b", "c_desc_preciob"],
                ["precio_c", "c_desc_precioc"],
                ["descripcion_a", "c_precioa"],
                ["descripcion_b", "c_preciob"],
                ["descripcion_c", "c_precioc"]
            ];

            $.ajax({
                type: "POST",
                url: '<?= site_url() ?>producto/C_importar/datos_producto_excel',
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
                        lts_c_cod_prod.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_m01.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_m02.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_m03.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_m04.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_m05.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_m06.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_m07.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_desc_precioa.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_desc_preciob.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_desc_precioc.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_precioa.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_preciob.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                        lts_c_precioc.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
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
                    }
                    document.getElementById("columns").style.display = "block";

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function vaciar_selects() {
            let vector = ["c_cod_prod", "c_m01", "c_m02", "c_m03", "c_m04", "c_m05", "c_m06",
                "c_m07", "c_desc_precioa", "c_desc_preciob", "c_desc_precioc", "c_precioa", "c_preciob", "c_precioc"
            ];
            for (let i = 0; i < vector.length; i++) {
                var select = document.getElementById(vector[i]),
                    length = select.options.length;
                while (length--) {
                    select.remove(length);
                }
                $("#" + vector[i]).append('<option value="0">&nbsp;</option>');
            }
        }
    </script>
<?php } else {
    redirect('inicio');
} ?>