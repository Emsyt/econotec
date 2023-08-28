<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: Keyla Paola Usnayo Aguilar Fecha: 22/11/2022, Codigo: SAM-MS-A7-0003,
Descripcion: Creacion del Controlador View de bitacora de activos
------------------------------------------------------------------------------
Modificado: Oscar Laura Aguirre    Fecha: 27/02/2023   Codigo: GAN-DPR-B3-0308
Descripcion : agrego una tabla con buscador, paginacion y se agregos las columnas 
Nro , usuario, fecha asignacion, fecha devolucion, motivo ,estado y tambien
se cambio el nombre de listado de bitacoras a historico de activos
*/
?>
<?php if (in_array("smod_bit", $permisos)) { ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/jquery-ui.css">
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var today = new Date();
            var day = today.getDate();
            var month = today.getMonth() + 1;
            var year = today.getFullYear();
            var fecha_actual = year + '/' + month + '/' + day;
            document.getElementById("fecha_salida").value = fecha_actual;


            activarMenu('menu14', 3);

            var codigo = [];
            $.ajax({
                url: "<?php echo site_url('garantias/C_ejecucion/lts_codigos_venta') ?>",
                type: "POST",
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    console.log(json)
                    codigo = Object.values(json);
                    const items = codigo.map(function(codigo) {
                        return codigo.ocodigoventa;
                    });
                    $("#id_venta").autocomplete({
                        source: items
                    });
                }
            });
        });
    </script>
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Activos</a></li>
                    <li class="active">Historico de Activos</li>
                </ol>
            </div>
            <?php if ($this->session->flashdata('success')) { ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            icon: 'success',
                            text: "<?php echo $this->session->flashdata('success'); ?>",
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ACEPTAR'
                        })

                    });
                </script>
            <?php } else if ($this->session->flashdata('error')) { ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            icon: 'error',
                            text: "<?php echo $this->session->flashdata('error'); ?>",
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ERROR'
                        })

                    });
                </script>
            <?php } ?>
            <div class="section-body" id="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="text-primary">Historico de Activos
                            <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp;
                                Historico de Activos</button>
                        </h3>
                        <hr>
                    </div>
                </div>

            </div>

            <div class="section-body" style="display: none;" id="form_registro">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-10  col-md-offset-2 col-lg-8 col-lg-offset-2">
                        <div class="form card">
                            <div class="card-head style-primary">
                                <header>Registro de Bitacora</header>
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row col-md-10 col-md-offset-1">
                                    <form class="form form-validate" novalidate="novalidate" name="form_bitacora" id="form_bitacora" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="id_bitacora" id="id_bitacora" value="0">


                                </div>


                                <div class="card-body" style="padding-bottom: 0px">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group floating-label">
                                                    <select class="form-control select2-list" id="usuario" name="usuario" required>
                                                        <option value=""></option>
                                                        <?php foreach ($usuarios as $usr) {  ?>
                                                            <option value="<?php echo $usr->id_empleado ?>" <?php echo set_select('usuario', $usr->id_empleado) ?>>
                                                                <?php echo $usr->id_empleado . ' - ' . $usr->nombre . ' ' . $usr->paterno . ' ' . $usr->materno ?>
                                                            </option>
                                                        <?php  } ?>
                                                    </select>
                                                    <label for="categoria">Seleccione Usuario</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group floating-label">
                                                    <select class="form-control select2-list" id="producto" name="producto" required>
                                                        <option value=""></option>
                                                        <?php foreach ($productos as $prod) {  ?>
                                                            <option value="<?php echo $prod->oidproducto ?>" <?php echo set_select('producto', $prod->oidproducto) ?>>
                                                                <?php echo $prod->oidproducto . ' - ' . $prod->oproducto ?>
                                                            </option>
                                                        <?php  } ?>
                                                    </select>
                                                    <label for="categoria">Seleccione Producto</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- fecha -->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <div class="input-group date" id="demo-date">
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control" name="fecha_salida" id="fecha_salida" required>
                                                            <label for="fecha_salida">Fecha Salida</label>
                                                        </div>
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <div class="input-group date" id="demo-date-val">
                                                        <div class="input-group-content">
                                                            <input type="text" class="form-control" name="fecha_retorno" id="fecha_retorno" readonly="" required>
                                                            <label for="fecha_retorno">Fecha Retorno</label>
                                                        </div>
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group floating-label" id="c_producto">
                                                    <input type="number" class="form-control" name="km_inicio" id="km_inicio" required>
                                                    <label for="km_inicio">Kilometros de salida</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group floating-label" id="c_producto">
                                                    <input type="number" class="form-control" name="km_final" id="km_final" required>
                                                    <label for="km_final">Kilometros de retorno</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group floating-label" id="c_producto">
                                                    <input type="number" class="form-control" name="km_recorrido" id="km_recorrido" required>
                                                    <label for="km_recorrido">Kilometros recorridos</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group floating-label" id="c_producto">
                                                    <input type="number" class="form-control" name="gasolina" id="gasolina" required>
                                                    <label for="gasolina">Gasolina</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group floating-label" id="c_producto">
                                                    <input type="text" class="form-control" name="motivo" id="motivo" required>
                                                    <label for="motivo">Motivo</label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group floating-label" id="c_producto">
                                                    <input type="text" class="form-control" name="destino" id="destino" required>
                                                    <label for="destino">Destino</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-actionbar">
                                        <div class="card-actionbar-row">
                                            <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" onclick="agregar_modifi_bitacora(1)" disable>Modificar Bitacora</button>
                                            <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add" onclick="agregar_modifi_bitacora(0)">Registrar Bitacora</button>
                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="row" id="listado">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-divider visible-xs"><span>Listado de Ventas</span></div>
            <div class="card card-bordered style-primary">
                <div class="card-body style-default-bright">
                    <div id="tabla">
                        <div class="table-responsive">
                            <!-- INICIO Oscar L., GAN-DPR-B3-0308 -->
                            <table id="datatableprod" class=" table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%"> Nro</th>
                                        <th width="20%"> Usuario</th>
                                        <th width="20%">Fecha asignacion</th>
                                        <th width="20%">Fecha devolucion</th>
                                        <th width="20%">Motivo</th>
                                        <th width="15%">Estado</th>
                                    </tr>
                                </thead>
                            </table>
                            <!-- FIN GAN-DPR-B3-0308 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--INICIO MODAL PARA LA ECUCIÓN DE GARANTÍA-->
    <div class="modal fade" name="modalEjecucion" id="modalEjecucion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header style-primary">
                    <h4 class="modal-title" id="exampleModalLabel">EJECUTAR GARANTÍA</h4>
                </div>
                <!--<input type="text" name="id_curso" id="id_curso" value="">-->
                <div class="modal-body">
                    <table>
                        <tr>
                            <td><b>Cliente: </b>
                                <font id="cliente_v"></font>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Codigo de venta: </b>
                                <font id="codigo_v"></font>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Fecha: </b>
                                <font id="fecha_v"></font>
                            </td>
                        </tr>
                    </table>
                    <p align="Center"><b>DETALLE</b></p>
                    <div style=" overflow:scroll; height:300px;">
                        <table id="producto_modal" style="width:100%" class=" table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td width="200"><b>Producto</b></td>
                                    <td width="100" align="center"><b>Cantidad</b></td>
                                    <td width="100" align="center"><b>Precio Unitario</b></td>
                                    <td width="100" align="center"><b>Sub Total</b></td>
                                    <td width="100" align="center"><b>Acción</b></td>
                                </tr>
                            </thead>
                            <tbody id="DataResult">
                            </tbody>

                        </table>

                    </div>
                    <form id="form_garantia" name="form_garantia" class="form form-validate" novalidate="novalidate" enctype="multipart/form-data" method="post" action="<?= site_url() ?>garantias/C_ejecucion/realizar_ejecucion">
                        <p align="Center"><b>DATOS PARA LA EJECUCIÓN DE LA GARANTÍA</b></p>
                        <input type="hidden" id="cd_ventas" name="cd_ventas">
                        <input type="hidden" id="c_ids_producto" name="c_ids_producto">
                        <div class="row">
                            <div class="form col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="c_codigo">
                                    <textarea type="text" class="form-control" name="observaciones" id="observaciones"></textarea>
                                    <label for="producto">Observaciones</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input style="display: block;" type="file" id="files" name="photo" class="form-control" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="realizar_ejecucion()">REALIZAR
                        EJECUCIÓN</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>

                </div>
            </div>
        </div>
    </div>
    <!--FIN MODAL PARA LA ECUCIÓN DE GARANTÍA-->
    </div>
    </section>
    </div>
    <!--  Datatables JS-->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- SUM()  Datatables-->
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
    <!-- INICIO Oscar L., GAN-DPR-B3-0308 -->
    <script>
        $(document).ready(function() {
            var valor = '';
            $('#datatableprod').DataTable({
                'processing': true,
                'serverSide': true,
                'responsive': true,
                "language": {
                    "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                },
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= base_url() ?>lstproductos'
                },
                'columns': [{
                        data: 'pnro'
                    },
                    {
                        data: 'pcategoria'
                    },
                    {
                        data: 'pmarca'
                    },
                    {
                        data: 'pidprod',
                    },
                    {
                        data: 'pcodigo'
                    },
                    {
                        data: 'pcodigo_alt',
                        render: function(data, type, row) {

                            if (data == null || data == '') {
                                return '<p>SIN ASIGNAR</p>';
                            } else {
                                return data;
                            }

                        }
                    }
                ]
            });
        });
    </script>
    <!-- FIN GAN-DPR-B3-0308 -->
    <script type="text/javascript">
        function agregar_modifi_bitacora(msg) {
            if (msg == 0) {
                msg = 'add';
            } else {
                msg = 'edit';
            }
            var id_activo = document.getElementById("id_bitacora").value;
            var id_producto = $('#producto').val();
            var id_usuario = $('#usuario').val();
            var fecha_salida = $('#fecha_salida').val();
            var fecha_retorno = $('#fecha_retorno').val();
            var km_inicio = $('#km_inicio').val();
            var km_final = $('#km_final').val();
            var km_recorrido = $('#km_recorrido').val();
            var destino = $('#destino').val();
            var motivo = $('#motivo').val();
            var gasolina = $('#gasolina').val();

            console.log(id_producto);
            console.log(id_usuario);
            console.log(fecha_salida);
            console.log(fecha_retorno);
            console.log(km_inicio);
            console.log(km_final);
            console.log(km_recorrido);
            console.log(destino);
            console.log(motivo);
            console.log(gasolina);

            if (id_producto != "" && id_usuario != "") {
                $.ajax({
                    url: "<?php echo site_url('activos/C_bitacora/add_edit_bitacora') ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        btn: msg,
                        usuario: id_usuario,
                        id_producto: id_producto,
                        fecha_salida: fecha_salida,
                        fecha_retorno: fecha_retorno,
                        km_inicio: km_inicio,
                        km_final: km_final,
                        km_recorrido: km_recorrido,
                        destino: destino,
                        motivo: motivo,
                        gasolina: gasolina
                    },
                    success: function(respuesta) {

                        console.log(respuesta);
                        var json = JSON.parse(respuesta);
                        $.each(json, function(i, item) {
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
                                    title: 'Se registro con exito',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href =
                                            "<?php echo base_url(); ?>bitacora";
                                    } else {
                                        location.href =
                                            "<?php echo base_url(); ?>bitacora";
                                    }
                                })
                            }
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax -no sirve');
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: "Por favor termine de llenar todos los campos",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                })
            }

        }

        function formulario() {
            /*$("#titulo").text("Registrar Producto");
            $('#form_producto')[0].reset();
            var x = document.getElementById("c_precio");
            x.style.display = "none";
            $('#precio').removeAttr("required");
            document.getElementById("list").innerHTML = '';*/
            document.getElementById("form_registro").style.display = "block";
            console.log('si presiona')
            /*document.getElementById("btn_update").style.display = "block";
            $('#btn_edit').attr("disabled", true);
            $('#btn_add').attr("disabled", false);*/
        }

        function cerrar_formulario() {
            document.getElementById("form_registro").style.display = "none";
            /*$('#form_producto')[0].reset();
            /*document.getElementById("list").innerHTML = '';*/
        }

        function realizar_ejecucion() {
            var array = "";
            var ids_prod = document.getElementsByName('productos_v');
            console.log(ids_prod);
            for (let i = 0; i < ids_prod.length; i++) {
                if (ids_prod[i].checked) {
                    array = array + ids_prod[i].value + ",";
                }

            }
            array = array.substr(0, array.length - 1);
            $("#c_ids_producto").val("[" + array + "]");
            console.log(array);
            if (array.length != 0) {
                document.form_garantia.submit();
            }
        }

        function habilitar_tabla() {
            var codigo_venta = document.getElementById('id_venta').value;
            console.log(codigo_venta);
            document.getElementById("tabla").innerHTML = '';
            document.getElementById("tabla").innerHTML = '<div class="table-responsive">' +
                '<table id="datatable" class="table table-bordered table-hover">' +
                '<thead>' +
                '<tr>' +
                '<th width="5%">Nª</th>' +
                '<th width="16%">C&oacute;digo de venta</th>' +
                '<th width="16%">Cliente</th>' +
                '<th width="16%">Total</th>' +
                '<th width="16%">Fecha</th>' +
                '<th width="15%">Hora</th>' +
                '<th width="15%">Vendedor</th>' +
                '<th width="16%">Acciones</th>' +
                '</tr>' +

                '</thead>' +
                '</table>' +
                ' </div>';

            $.ajax({
                url: "<?php echo site_url('garantias/C_ejecucion/mostrar_venta_garantia') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    codigo_venta: codigo_venta
                },
                success: function(data) {

                    console.log(data);
                    var t = $('#datatable').DataTable({
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
                            [1, 'dec']
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
                                "mData": "ototal"
                            },
                            {
                                "mData": "ofecha"
                            },
                            {
                                "mData": "ohora"
                            },

                            {
                                "mData": "ousucre"
                            },

                            {
                                render: function(data, type, row) {
                                    let val =
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" title="Ejecutar Garantía" onclick="abrir_modal(\'' +
                                        row.ocodigo + '\',' + row.oidubicacion + ',' + row.olote +
                                        ',\'' + row.ousucre +
                                        '\')"><i class="fa fa-book" aria-hidden="true"></i></button>';
                                    return val;
                                }
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

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function abrir_modal(cod_venta, ubicacion, lote, usuario) {
            console.log(cod_venta, ubicacion, lote, usuario);
            $.ajax({
                url: "<?php echo site_url('garantias/C_ejecucion/validar_garantia') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    cod_venta: cod_venta
                },
                success: function(data) {

                    console.log(data);
                    if (data[0].oboolean == 't') {
                        $("#cliente_v").html('');
                        $("#codigo_v").html('');
                        $("#fecha_v").html('');
                        $.ajax({
                            url: "<?php echo site_url('garantias/C_ejecucion/datos_venta') ?>",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                ubicacion: ubicacion,
                                lote: lote,
                                usuario: usuario,
                            },
                            success: function(respons) {
                                console.log(respons);
                                $("#cliente_v").html(respons.cliente);
                                $("#codigo_v").html(respons.codigo);
                                $("#fecha_v").html(respons.fecha);
                                $("#cd_ventas").val(respons.codigo);
                                var js = respons.productos;
                                var html = '';
                                var i;
                                for (i = 0; i < js.length; i++) {
                                    html += '<tr>' +
                                        '<td>' + js[i].producto + '</td>' +
                                        '<td align="center">' + js[i].cantidad + '</td>' +
                                        '<td align="center">' + js[i].precio + '</td>' +
                                        '<td align="center">' + js[i].sub_total + '</td>' +
                                        '<td align="center"><input type="checkbox" id="producto_' + js[
                                            i].id_producto + '" name="productos_v" value="' + js[i]
                                        .id_producto + '"></td>' +
                                        '</tr>';
                                }
                                $('#DataResult').html(html);
                                $('#modalEjecucion').modal('show');

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error get data from ajax');
                            }
                        });

                    } else {
                        Swal.fire({
                            icon: 'warning',
                            text: data[0].omensaje,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ACEPTAR',
                        })
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });


        }
    </script>

<?php } else {
    redirect('inicio');
} ?>