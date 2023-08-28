<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:14/12/2022   GAN-MS-A3-0182,
Descripcion: Se realizo la implementacion del modulo IMPORTAR , para que todos los datos que se suban a la tabla ope_importacion

*/
?>
<?php if (in_array("smod_imp", $permisos)) { ?>
<script>
    $(document).ready(function() {
        activarMenu('menu2', 4);
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
                <li class="active">Importar</li>
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
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
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
                                        </div>

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
                                                        <select class="form-control select2-list" id="c_categoria" name="c_categoria" required>
                                                            <option value="0">&nbsp;</option>
                                                        </select>
                                                        <label for="c_categoria">Categoria</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <select class="form-control select2-list" id="c_marca" name="c_marca" required>
                                                            <option value="0">&nbsp;</option>
                                                        </select>
                                                        <label for="c_marca">Marca</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <select class="form-control select2-list" id="c_codigo" name="c_codigo" required>
                                                            <option value="0">&nbsp;</option>
                                                        </select>
                                                        <label for="c_codigo">Cód. Producto</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <select class="form-control select2-list" id="c_codigo_alt" name="c_codigo_alt" required>
                                                            <option value="0">&nbsp;</option>
                                                        </select>
                                                        <label for="c_codigo_alt">Cód. Alt. Producto</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <select class="form-control select2-list" id="c_producto" name="c_producto" required>
                                                            <option value="0">&nbsp;</option>
                                                        </select>
                                                        <label for="c_producto">Producto</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <select class="form-control select2-list" id="c_caracteristica" name="c_caracteristica" required>
                                                            <option value="0">&nbsp;</option>
                                                        </select>
                                                        <label for="c_caracteristica">Caracteristica</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <select class="form-control select2-list" id="c_cantidad" name="c_cantidad" required>
                                                            <option value="0">&nbsp;</option>
                                                        </select>
                                                        <label for="c_cantidad">Cantidad</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <select class="form-control select2-list" id="c_precio_compra" name="c_precio_compra" required>
                                                            <option value="0">&nbsp;</option>
                                                        </select>
                                                        <label for="c_precio_compra">Precio compra</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <select class="form-control select2-list" id="c_precio_venta" name="c_precio_venta" required>
                                                            <option value="0">&nbsp;</option>
                                                        </select>
                                                        <label for="c_precio_venta">Precio venta</label>
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
                                                <span id="nota" >Click <a style="color: blue;" href="<?= base_url() ?>assets/docs/productos/formato_de_ejemplo_importacion_productos.xlsx" download="formato_de_ejemplo_importacion_productos.xlsx">aqui</a> para descargar formato de ejemplo.</span><br>
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
            let id_ubicacion = document.getElementById("ubi_trabajo").value;
            
            if (rawname=="x.x") {    
                errorfile = document.getElementById('error-file');            
                errorfile.style.display = '';
                return;
            }
            let c_categoria = document.getElementById("c_categoria").value;
            let c_marca = document.getElementById("c_marca").value;
            let c_codigo = document.getElementById("c_codigo").value;
            let c_codigo_alt = document.getElementById("c_codigo_alt").value;
            let c_producto = document.getElementById("c_producto").value;
            let c_caracteristica = document.getElementById("c_caracteristica").value;
            let c_cantidad = document.getElementById("c_cantidad").value;
            let c_precio_compra = document.getElementById("c_precio_compra").value;
            let c_precio_venta = document.getElementById("c_precio_venta").value;

            console.log(ruta);
            console.log(rawname);
            console.log(id_ubicacion);
            console.log(c_categoria);
            console.log(c_marca);
            console.log(c_codigo);
            console.log(c_codigo_alt);
            console.log(c_producto);
            console.log(c_caracteristica);
            console.log(c_cantidad);
            console.log(c_precio_compra);
            console.log(c_precio_venta);
            

            $.ajax({
                url: '<?= site_url() ?>add_datos',
                type: "post",
                datatype: "json",
                data: {
                    c_categoria:c_categoria,
                    c_marca:c_marca,
                    c_codigo:c_codigo,
                    c_codigo_alt:c_codigo_alt,
                    c_producto:c_producto,
                    c_caracteristica:c_caracteristica,
                    c_cantidad:c_cantidad,
                    c_precio_compra:c_precio_compra,
                    c_precio_venta:c_precio_venta,
                    ruta:ruta,
                    rawname:rawname,
                    id_ubicacion:id_ubicacion
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
                    if(data[0].oboolean=='t'){  
                        Swal.fire({
                        icon: 'success',
                        text: "Archivo recepcionado correctamente",
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ACEPTAR'
                        }).then((result) => {
                            if (result.isConfirmed) {
                            location.reload();
                            } else{
                            location.reload();
                            }
                        })
                    }else{
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
        var lts_categoria = $("#c_categoria");
        var lts_marca = $("#c_marca");
        var lts_codigo = $("#c_codigo");
        var lts_codigo_alt = $("#c_codigo_alt");
        var lts_producto = $("#c_producto");
        var lts_caracteristica = $("#c_caracteristica");
        var lts_cantidad = $("#c_cantidad");
        var lts_precio_compra = $("#c_precio_compra");
        var lts_precio_venta = $("#c_precio_venta");

        let vector = [
            ["Categoria", "c_categoria"],
            ["Marca", "c_marca"],
            ["Codigo_Producto", "c_codigo"],
            ["Codigo_Alternativo", "c_codigo_alt"],
            ["Nombre_Producto", "c_producto"],
            ["Descripcion_Producto", "c_caracteristica"],
            ["Cantidad_en_Stock", "c_cantidad"],
            ["Precio_Unitario_de_Compra", "c_precio_compra"],
            ["Precio_Unitario_de_Venta", "c_precio_venta"]
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
                    lts_categoria.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                    lts_marca.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                    lts_codigo.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                    lts_codigo_alt.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                    lts_producto.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                    lts_caracteristica.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                    lts_cantidad.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                    lts_precio_compra.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
                    lts_precio_venta.append('<option value="' + v.columna + '">' + (v.texto).toUpperCase() + '</option>');
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
        let vector = ["c_categoria", "c_marca", "c_codigo", "c_codigo_alt","c_producto", "c_caracteristica", "c_cantidad",
            "c_precio_compra", "c_precio_venta"];
        for (let i = 0; i < vector.length; i++) {
            var select = document.getElementById(vector[i]),
                length = select.options.length;
            while (length--) {
                select.remove(length);
            }
            $("#"+vector[i]).append('<option value="0">&nbsp;</option>');
        }
    }
</script>
<?php } else {redirect('inicio');}?>
