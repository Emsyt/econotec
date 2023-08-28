<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:18/11/2022   GAN-MS-A7-0111,
Descripcion: Se Realizo el frontend de ejecucion de garantias
-------------------------------------------------------------------------------------------------------------------------------
Creador: Adamary Margell Uchani Mamani Fecha:18/11/2022   GAN-DPR-A4-0114,
Descripcion: Se realizo el diseño de ejecucion de garantias
*/
?>
<?php if (in_array("smod_ejec_gar", $permisos)) { ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/jquery-ui.css">
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            activarMenu('menu12', 2);

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
                    <li><a href="#">Garant&iacute;a</a></li>
                    <li class="active">Ejecución</li>
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
                    <div class="col-xs-12 col-sm-10 col-md-10  col-md-offset-2 col-lg-8 col-lg-offset-2">
                            <div class="form card">
                                <div class="card-head style-primary">
                                    <header>Registro de Ejecución de la Garantía</header>
                                </div>
                                <div class="card-body">
                                    <div class="form-group floating-label col-xs-12 col-sm-10 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" name="id_venta" id="id_venta">
                                            <label for="id_venta">Buscar Venta</label>
                                    </div>
                                    <div class="form-group floating-label col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                        <button type="button" class="btn btn-primary" onclick="habilitar_tabla()"><i class="fa fa-search"></i> BUSCAR VENTA</button>
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
                                    <table id="datatable" class=" table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="5%">Nª</th>
                                                <th width="16%">C&oacute;digo de venta</th>
                                                <th width="16%">Cliente</th>
                                                <th width="16%">Total</th>
                                                <th width="16%">Fecha</th>
                                                <th width="15%">Hora</th>
                                                <th width="15%">Vendedor</th>
                                                <th width="16%">Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
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
                                <input type="hidden" id="c_ids_venta" name="c_ids_venta">
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

    <script>
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
            $("#c_ids_venta").val("[" + array + "]");
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
                                    let val = '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" title="Ejecutar Garantía" onclick="abrir_modal(\'' + row.ocodigo + '\',' + row.oidubicacion + ',' + row.olote + ',\'' + row.ousucre + '\')"><i class="fa fa-book" aria-hidden="true"></i></button>';
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
                                        '<td align="center"><input type="checkbox" id="producto_' + js[i].id_venta + '" name="productos_v" value="' + js[i].id_venta + '"></td>' +
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