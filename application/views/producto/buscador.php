<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: Gary German Valverde Quisbert Fecha:22/05/2023   ,
Descripcion: Se Realizo la vista y funcionamiento del submodulo buscador
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert Fecha:14/06/2023   ,
Descripcion: Se agrego la funcionalidad de agregar a la venta y ver las caracteristicas
-------------------------------------------------------------------------------------------------------------------------------
*/
?>
<?php if (in_array("smod_buscador", $permisos)) { ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/jquery-ui.css">
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            activarMenu('menu2', 6);
        });
    </script>
    <style>
        .floating-notification {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            background-color: #28a745;
            /* Color verde */
            border: 1px solid #1e7e34;
            /* Color verde más oscuro */
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: opacity 0.3s ease-in-out;
        }

        .notification-text {
            color: #ffffff;
            /* Texto en color blanco */
            font-weight: bold;
        }

        #param_equi[disabled] {
            text-decoration: line-through;
            color: red;
        }
    </style>
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Productos</a></li>
                    <li class="active">Buscador</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12  col-md-offset-2 col-lg-8 col-lg-offset-2">
                    <div class="form card">
                        <div class="card-head style-primary">
                            <header>Buscador de productos</header>
                        </div>
                        <form class="form form-validate" novalidate="novalidate" name="form_producto" id="form_producto" enctype="multipart/form-data">
                            <div class="card-body" style="padding-bottom: 0px">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Caracteres check - Medidas check-->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                                <div class="form-group floating-label" id="c_producto">
                                                    <input type="text" class="form-control" name="producto" id="producto" onchange="return mayuscula(this);" required>
                                                    <label for="caracter">Caracteres a buscar</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group floating-label" id="c_medidas">
                                                    <input type="text" class="form-control" name="medidas" id="medidas" onchange="return mayuscula(this);" required>
                                                    <label for="producto">Medidas</label>
                                                    <span style="color:rgb(136,198,133);">Ejemplo: 1.5*6*3.1</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                <!-- <div class="form-group floating-label">
                                                    <select class="form-control select2-list" id="tipo_medidas" name="tipo_medidas" required="" onchange="habilitarRango()">
                                                        <option value="0">Preciso</option>
                                                        <option value="1">Rango</option>
                                                    </select>
                                                    <label for="proveedor">Tipo de busq. de medidas</label>
                                                </div> -->
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="tipo_medidas" id="tipo_medidas" onchange="cambiarTipoMedida()">
                                                    <label class="form-check-label" for="tipo_medidas">Preciso</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                <div class="form-group floating-label" id="c_param_equi">
                                                    <input type="number" class="form-control" name="param_equi" id="param_equi" onchange="return mayuscula(this);" value="1.5">
                                                    <label for="param_equi">Equivalencia</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label>Opciones de similitud de búsqueda:</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="opc_cod" id="opc_cod">
                                                    <label class="form-check-label" for="opc_cod">Código de fabrica</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="opc_codalt" id="opc_codalt">
                                                    <label class="form-check-label" for="opc_codalt">Código original</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="opc_prod" id="opc_prod" checked>
                                                    <label class="form-check-label" for="opc_prod">Producto</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="opc_desc" id="opc_desc">
                                                    <label class="form-check-label" for="opc_desc">Aplicación</label>
                                                </div>
                                            </div>

                                            <script>
                                                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                                                checkboxes.forEach(checkbox => {
                                                    checkbox.addEventListener('click', function() {
                                                        checkboxes.forEach(cb => {
                                                            if (cb !== this) {
                                                                cb.checked = false;
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>


                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group floating-label align-items-center justify-content-center" style="display: flex; justify-content: center; align-items: center;">
                                                    <button type="button" class="btn btn-primary" onclick="buscar()"><i class="fa fa-search"></i> BUSCAR</button>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group" id="process" style="display:none;">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120" style="">
                                                </div>

                                            </div>
                                            <div class="status" style="display: flex; justify-content: center; align-items: center;"></div>

                                        </div>
                                    </div>

                                </div>
                                <!-- <div class="card-footer" style="display: flex; justify-content: flex-end; align-items: flex-end;">
                                    <div class="form-group floating-label">
                                        <button type="button" class="btn btn-primary" onclick="buscar()"><i class="fa fa-search"></i> BUSCAR</button>
                                    </div>
                                </div> -->
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <a class='btn  btn-primary' href='<?= base_url(); ?>venta_facturada' target="_blank">Venta facturada <i class="fa fa-arrow-right"></i></a>
                    <br><br>
                    <a class='btn  btn-primary' href='<?= base_url(); ?>pedidoCodigo' target="_blank">Venta rapida <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- Alerta -->
            <div id="divAlert" class="alert alert-success" role="alert" style="display: none;width: 100%">
                <h4><strong>Exito!</strong> El producto se agrego a la venta.</h4>
            </div>
            <div id="floatingNotification" style="display: none;" class="floating-notification">
                <span class="notification-text">¡Se agrego el producto a la venta!</span>
            </div>

            <!-- Tabla -->
            <div class="row">
                <div class="col-md-12">
                    <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
                    <div class="card card-bordered style-primary">
                        <div class="card-body style-default-bright">
                            <div class="table-responsive">
                                <table id="datatableprod" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>C&oacute;digo interno</th>                                            
                                            <th>C&oacute;digo de fabrica</th>
                                            <th>Descripci&oacute;n</th>
                                            <th>C&oacute;digo original</th>
                                            <th>Stock</th>
                                            <th>Precio</th>
                                            <th>Caracter&iacute;stica</th>
                                            <th>Acci&oacute;n</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <!-- Modal adicionales -->
    <!-- GAN-MS-B1-0495, 29/05/2023 DCondori -->
    <div class="modal fade" id="modalAdicionales" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Lista de Adicionales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group floating-label" id="c_nombre2">
                                <input type="text" class="form-control" name="nombre" id="nombre2">
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="datatableadicionales">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Descripcion</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal precios -->
    <div class="modal fade" id="modalPrecios" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Lista de Precios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="datatableprecios">
                        <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Precios</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal stock -->
    <div class="modal fade" id="modalStock" tabindex="-1" role="dialog" style="padding: 3px;" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="padding: 3px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Stock en sucursales</h5>
                </div>
                <div class="modal-body-precios" style="padding: 3px;">

                    <table id="datatablestock" class="table table-striped" style="padding: 3px;">
                        <thead>
                            <tr>
                                <th>Ubicacion</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


    <!--  Datatables JS-->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- SUM()  Datatables-->
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>

    <script>
        function cambiarTipoMedida() {
            var tipomedidas_check = document.getElementById('tipo_medidas');
            if (tipomedidas_check.checked) {
                var input = document.getElementById('param_equi').disabled = true;
            } else {
                var input = document.getElementById('param_equi').disabled = false;
            }
        }

        function buscar() {
            var producto = document.getElementById("producto").value;
            var param_equi = document.getElementById("param_equi").value;

            var tipo_medidas_check = document.getElementById('tipo_medidas');
            var tipo_medidas = tipo_medidas_check.checked ? true : false;

            var cb_cod = document.getElementById('opc_cod');
            var opc_cod = cb_cod.checked ? true : false;

            var cb_codalt = document.getElementById('opc_codalt');
            var opc_codalt = cb_codalt.checked ? true : false;

            var cb_prod = document.getElementById('opc_prod');
            var opc_prod = cb_prod.checked ? true : false;

            var cb_desc = document.getElementById('opc_desc');
            var opc_desc = cb_desc.checked ? true : false;

            var medidas = document.getElementById('medidas').value;

            $.ajax({
                url: '<?= site_url() ?>lst_productos_buscador',
                type: "post",
                datatype: "json",
                data: {
                    producto: producto,
                    medidas: medidas,
                    param_equi: param_equi,
                    opc_cod: opc_cod,
                    opc_codalt: opc_codalt,
                    opc_prod: opc_prod,
                    opc_desc: opc_desc,
                    tipo_medidas: tipo_medidas
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
                                var delayInMilliseconds = 5000;

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
                    console.log(data);
                    if (data.responce == "success") {
                        var t = $('#datatableprod').DataTable({
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
                                },
                                {
                                    "targets": 6, // Índice de la columna "ostock"
                                    "createdCell": function(cell, cellData, rowData, rowIndex, colIndex) {
                                        if (cellData == 0) {
                                            $(cell).css('background-color', 'rgb(255,180,180)'); // Pintar la celda en rojo
                                        }
                                    }
                                }
                            ],
                            "order": [
                                [1, 'asc']
                            ],
                            "aoColumns": [{
                                    "mData": "oid_producto"
                                },
                                {
                                    "mData": "ocodigo"
                                },
                                {
                                    "mData": "odescripcion"
                                },
                                {
                                    "mData": "ocodigo_alt"
                                },
                                {
                                    "mData": "ostock"
                                },
                                {
                                    "mData": "oprecio"
                                },
                                {
                                    "mData": "oextras",
                                    "mRender": function(data, type, row, meta) {
                                        if (data == null) {
                                            return '<span style="color: red;">SIN CARACTERISTICAS</span>';
                                        } else {
                                            return data;
                                        }
                                    }
                                },
                                {
                                    "mRender": function(data, type, row, meta) {
                                        var a = `
                                            <button type="button" title="Agregar producto a la venta" class="btn btn-primary ink-reaction btn-floating-action btn-xs" onclick="agregarVenta(this, '${row.ocodigo}')"><i class="fa fa-shopping-cart" aria-hidden="true"></i></button> 
                                            <button type="button" title="Adicionales" class="btn ink-reaction btn-floating-action btn-xs btn-warning" name="btn_adicionales" data-toggle="modal" data-target="#modalAdicionales" onclick="modificar_adicionales('${row.oid_producto}')"><i class="fa fa-gears fa-lg"></i></button>
                                            <button type="button" title="Ver todos los precios" class="btn ink-reaction btn-floating-action btn-xs btn-success" name="btn_precios" data-toggle="modal" data-target="#modalPrecios" onclick="ver_precios('${row.oid_producto}')" ><i class="fa fa-dollar fa-lg"></i></button>
                                            <button type="button" title="Ver stock en todas las sucursales" class="btn ink-reaction btn-floating-action btn-xs btn-danger" name="btn_stock" data-toggle="modal" data-target="#modalStock" onclick="ver_stock('${row.oid_producto}')"><i class="fa fa-archive"></i></button>`;
                                        return a;
                                    }
                                }
                            ]
                        });

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function agregarVenta(button, codigoProd) {
            button.disabled = true;

            var notification = document.getElementById('floatingNotification');
            notification.style.display = 'block';
            setTimeout(function() {
                notification.style.display = 'none';
                button.disabled = false;
            }, 3000);
            $.ajax({
                url: "<?php echo site_url('venta/C_venta_facturada/datos_producto') ?>",
                type: "POST",
                data: {
                    buscar: codigoProd
                },
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    console.log(json);
                    button.disabled = false;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sucedio un error con el producto seleccionado',
                        text: 'por favor revise inventarios y abastecimiento',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'ACEPTAR'
                    });
                    button.disabled = false;
                }
            });
        }

        /* GAN-MS-B1-0495, 29/05/2023 DCondori */
        function modificar_adicionales(id, nombrep) {
            $('#btnAgre1').removeAttr('disabled');
            $(document).ready(function() {
                var s = $('#datatableadicionales').length;
                $('#datatableadicionales').DataTable({
                    'destroy': true,
                    'processing': true,
                    'serverSide': true,
                    'responsive': true,
                    paging: false,
                    ordering: false,
                    info: false,
                    searching: false,
                    "language": {
                        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                    },
                    'serverMethod': 'post',
                    'ajax': {
                        'url': "<?php echo site_url('producto/C_producto/list_adicionales') ?>/" + id
                    },
                    'columns': [{
                            data: 'dtipo',
                            render: function(data, type, row, meta) {
                                return '<input style="width:150px;" class="form-control" type="text" name="dtipo" id="dtipo' +
                                    meta.row + '"  onchange="CambioPrecioPr2(' + row.pidprecio + ',' +
                                    meta.row + ')" value= "' + data +
                                    '" ><p style="display:none;" id="">' + data + '</p>';
                            }
                        },
                        {
                            data: 'ddetalle',
                            render: function(data, type, row, meta) {
                                return '<input style="width:70px;" class="form-control" type="text" name="ddetalle" id="ddetalle' +
                                    meta.row + '" step="0.01" onchange="CambioPrecioPr(' + row
                                    .pidprecio + ',' + row.pprecio + ',' + meta.row + ')" value= ' +
                                    data + ' ><p style="display:none;" id="odlvalue' + meta.row + '">' +
                                    data + '</p>';
                            }
                        },
                    ]
                });
                $('#btnid').val(id);
            });
        }

        function ver_precios(id_producto) {
            $.ajax({
                url: '<?= site_url() ?>list_precios_buscador',
                type: "post",
                datatype: "json",
                data: {
                    id_prod: id_producto
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if (data.responce == "success") {
                        var t = $('#datatableprecios').DataTable({
                            "data": data.posts,
                            "responsive": true,
                            "searching": false,
                            "paging": false,
                            "info": false,
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
                                [1, 'asc']
                            ],
                            "aoColumns": [{
                                    "mData": "descripcion"
                                },
                                {
                                    "mData": "precio"
                                }
                            ]
                        });

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function ver_stock(id_producto) {
            $.ajax({
                url: '<?= site_url() ?>lst_stock_sucursales',
                type: "post",
                datatype: "json",
                data: {
                    id_prod: id_producto
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if (data.responce == "success") {
                        var t = $('#datatablestock').DataTable({
                            "data": data.posts,
                            "responsive": true,
                            "searching": false,
                            "paging": false,
                            "info": false,
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
                                [1, 'asc']
                            ],
                            "aoColumns": [{
                                    "mData": "oubicacion"
                                },
                                {
                                    "mData": "ostock"
                                }
                            ]
                        });

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }
    </script>

<?php } else {
    redirect('inicio');
} ?>