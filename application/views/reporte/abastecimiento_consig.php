<?php
/* 
-----------------------------------------------------------------------------------------------
Creador: Ayrton Jhonny Guevara Montaño Fecha:11/05/2023, Codigo: GAN-MS-B0-0455,
Descripcion: Se Realizo el frontend del reporte de compras por consignacion cojuntamente con su
modal y su funcion de pago
-----------------------------------------------------------------------------------------------
 */
?>
<?php if (in_array("smod_rep_abast_cons", $permisos)) { ?>
<style>
    .modalbody {
        padding: 5%;
    }

    .div1 {
        overflow: auto;
        height: 100px;
    }

    .div1 table {
        width: 100%;
        background-color: lightgray;
    }
</style>
<script type="text/javascript">
    var f = new Date();
    fechap_inicial = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
    fechap_fin = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
    var id_cli = "-1";

    $(document).ready(function() {
        activarMenu('menu6', 12);
        $('[name="fecha_inicial"]').val(fechap_inicial);
        $('[name="fecha_fin"]').val(fechap_fin);
        //$('[name="cli_trabajo"]').val(id_cli);
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
                <li class="active">Compras por Consignaci&oacute;n</li>
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
                <div class="col-md-10 col-md-offset-1">
                    <form class="form" name="form_busqueda" id="form_busqueda" method="post" target="_blank">
                        <div class="card">
                            <div class="card-head style-default-light" style="padding: 10px">
                                <div class="tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_abast_consig')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_abast_consig')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-right">
                                        <img style="height: 65px;" src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes);
                                                                                            print($obj->{'logo'}); ?>">
                                    </div>

                                    <div class="col-xs-9 col-sm-9 col-md-7 col-lg-7 text-center">
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> EMPRESA <?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                                                                                                    print_r($obj->{'titulo'}); ?> </h5>
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE COMPRAS
                                            POR CONSIGNACI&Oacute;N </h5>
                                    </div>

                                    <div class="col-xs-9 col-sm-9 col-md-3 col-lg-3">
                                        <h6 class="text-ultra-bold text-default-light">Usuario: <?php echo $usuario; ?>
                                        </h6>
                                        <h6 class="text-ultra-bold text-default-light">Fecha: <?php echo $fecha_imp; ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="text-align: center;">
                                        <br>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <select class="form-control select2-list" id="cli_trabajo" name="cli_trabajo" required>
                                                    <option value="">Todos los Proveedores</option>
                                                    <?php foreach ($proveedores as $prov) {  ?>
                                                        <option value="<?php echo $prov->id_personas ?>" <?php echo set_select('proveedor', $prov->id_personas) ?>>
                                                            <?php echo $prov->proveedor ?></option>
                                                    <?php  } ?>
                                                </select>
                                                <label for="cli_trabajo">Proveedor</label>
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
                                        <br>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" onclick="Buscar_abastecimiento()" type="button">Generar
                                                Reporte</button><br><br>
                                            <div class="form-group" id="process" style="display:none;">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120">
                                                    </div>
                                                </div>
                                                <div class="status"></div>
                                            </div>
                                            <br>
                                        </div>
                                    </div>

                                </div>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>N&deg;</th>
                                                <th>id_lote</th>
                                                <th>Cantidad</th>
                                                <th>Fecha</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div><br> </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- END CONTENT -->
<!--modal de lotes-->
<div class="modal fade" name="modal_lote" id="modal_lote" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form" role="form" name="form_editar" id="form_editar" method="post" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">Lista de productos de la consignaci&oacute;n</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive" style="margin:10px; overflow-y: scroll;">
                                <table id="datatable_compra" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <!-- <th width="5%">N&deg;</th> -->
                                            <th width="10%">Lote</th>
                                            <th width="15%">Producto</th>
                                            <th width="10%">Destino</th>
                                            <th width="10%">Cantidad adquirida</th>
                                            <th width="10%">Cantidad devoluci&oacute;n</th>
                                            <th width="10%">Unidad</th>
                                            <th width="10%">Precio de compra</th>
                                            <th width="10%">Precio de venta</th>
                                            <th width="15%">Fecha</th>
                                            <th width="10%">Estado</th>                                           
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <button type="button" title="Pagar" class="btn ink-reaction btn-raised  btn-info" style="float:right;" onclick=pagar()>PAGAR</button>
                        </div>
                        <div><br> </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function Buscar_abastecimiento() {
        cli_trabajo = document.getElementById("cli_trabajo");
        var selc_cli = cli_trabajo.options[cli_trabajo.selectedIndex].value;

        /*cli_estado = document.getElementById("cli_estado");
        var selc_cli_estado = cli_estado.options[cli_estado.selectedIndex].value;
        */
        var selc_frep = document.getElementById("fecha_inicial").value;
        var selc_finrep = document.getElementById("fecha_fin").value;

        $.ajax({
            url: '<?= site_url() ?>lst_reporte_abast_consig',
            type: "post",
            datatype: "json",
            data: {
                selc_prov: selc_cli,
                selc_frep: selc_frep,
                selc_finrep: selc_finrep
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
                            var delayInMilliseconds = 230;
                            setTimeout(function() {
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
                    $('#datatable').DataTable({
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
                                "mData": "orow_number"
                            },
                            {
                                "mData": "oid_lote"
                            },
                            {
                                "mData": "ocantidad"
                            },
                            {
                                "mData": "ofecha"
                            },
                            {
                                mRender: function(data, type, row, meta) {
                                var actions = `<div class="btn-group">
                                <button type="button" title="Historial" class="btn ink-reaction btn-floating-action btn-xs  btn-primary" onclick="Historial(\'${row.oid_lote}\');"><i class="fa fa-list"></i>
                                </button>`;
                                return actions;
                                },
                            },

                        ],
                    });

                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    };

    function Historial(id_lote){
            $('#modal_lote').modal('show');
            console.log(id_lote);
            $.ajax({
                url: "<?php echo site_url('provision/C_listar_abastecimiento/historial_compra') ?>",
                type: "POST",
                data: {
                    dato1: id_lote,
                },
                success: function(respuesta) {
                    console.log(respuesta);
                    var js = JSON.parse(respuesta);
                    $('#datatable_compra').DataTable({
                    "data": js,
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
                    "aoColumns": [{
                            //"mData": "oidlote"
                            "mRender": function(data, type, row, meta) {
                                    var a = `
                                    <input type="number" style="border:0px solid #c7254e; width : 100px" name="idlote${row.oidlote}" id="idlote${row.oidlote}" value="${row.oidlote}" disambled>
                                    `;
                                    return a;
                                }
                        },
                        {
                            "mData": "oproducto"
                        },
                        {
                            "mData": "odestino"
                        },
                        {
                            //"mData": "ocantidad"
                            "mRender": function(data, type, row, meta) {
                                cantidad = row.ocantidad;
                                    var a = `
                                    <input type="number" style="border:1px solid #c7254e; width : 100px" min="0" max="${row.ocantidad}" name="precio_uni${row.oidprovision}" id="precio_uni${row.oidprovision}" value="${row.ocantidad}">
                                    `;
                                    $(document).on('change', '#precio_uni'+row.oidprovision, function(){
                                    var cantidad2 = row.ocantidad - $(this).val();
                                    $('#precio2_uni'+row.oidprovision).val(cantidad2);
                                    });
                                    return a;
                                }
                        },
                        {
                            //"mData": "ocantidad"
                            "mRender": function(data, type, row, meta) {
                                    cantidad2 = row.ocantidad - $('#precio_uni'+row.oidprovision).val();
                                    var a = `
                                    <input type="number" style="border:0px solid #c7254e; width : 100px" min="0" max="${row.ocantidad}" name="precio2_uni${row.oidprovision}" id="precio2_uni${row.oidprovision}" value="${cantidad2}" disabled>
                                    `;
                                    return a;
                                }
                        },
                        {
                            "mData": "ounidad"
                        },
                        {
                            "mData": "opreciocompra"
                        },
                        {
                            "mData": "oprecioventa"
                        },
                        {
                            "mData": "ofecha"
                        },
                        {
                            "mData": "oestado"
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
        };


        function pagar() {
            var tabla = document.getElementById('datatable_compra');
            var filas = tabla.getElementsByTagName('tr');
            var datos = [];
                for (var i = 1; i < filas.length; i++) {
                var celdas = filas[i].getElementsByTagName('td');
                var fila = {};
                    fila.lote = celdas[0].querySelector('input').value;
                    fila.cantidadadquirida = celdas[3].querySelector('input').value;
                    fila.cantidadaddevuelta = celdas[4].querySelector('input').value;
                    console.log(fila.cantidadaddevuelta);
                    //controlando que la cantidad devuelta no sea menor a 0
                    if (fila.cantidadaddevuelta < 0){
                        $('#modal_lote').modal('hide'); 
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'La cantidad a devolver no puede exceder a la cantidad de la consignación',
                        })
                        return;
                    }
                    if (fila.cantidadaddevuelta === null) {
                        fila.cantidadaddevuelta = 0;
                    }
                datos.push(fila);
                }
            // Convertir el arreglo de datos en una cadena JSON
            var json = JSON.stringify(datos);
            Swal.fire({
                    text: '¿Desea Continuar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?php echo site_url('reporte/C_reporte_abast_consig/pagar_deuda') ?>",
                            type: "POST",
                            data: { 
                                json: json
                                },
                            dataType: 'json',
                            success: function(respuesta) { 
                                $('#modal_lote').modal('hide'); 
                                var js = respuesta;
                                $.each(js.posts, function(i, item) {
                                    if (item.oboolean == 't') {
                                        Swal.fire({
                                            icon: 'info',
                                            text: 'Registro realizado con exito',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'ACEPTAR',
                                        });
                                    }
                                    Buscar_abastecimiento();
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax');
                            }
                        });
                    }
                })
        };

</script>
<?php } else {redirect('inicio');}?>
