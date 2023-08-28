<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:28/11/2022   GAN-MS-A7-0142,
Descripcion: Se Realizo la vista y funcionamiento del submodulo items, con el selector y la tabla
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Aliso Paola Pari Pareja Fecha:29/11/2022, GAN-MS-A7-0145
Descripcion: Se adiciono funcionalidad al boton de registrar series y su validacion
------------------------------------------------------------------------------
*/
?>
<?php if (in_array("smod_items", $permisos)) { ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/jquery-ui.css">
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            activarMenu('menu2', 5);

        });
    </script>
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Productos</a></li>
                    <li class="active">Items</li>
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
                                    <header>Listado de lotes con garantia</header>
                                </div>
                                <div class="card-body">
                                    <div class="form-group floating-label col-xs-12 col-sm-10 col-md-9 col-lg-9">
                                        <select class="form-control select2-list" id="id_lote" name="id_lote" required>
                                            <?php foreach ($lotes as $lot) {  ?>
                                                <option value="<?php echo $lot->oid_lote ?>" <?php echo set_select('id_lote', $lot->oid_lote) ?>>
                                                    <?php echo $lot->odetalle ?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                    <div class="form-group floating-label col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                        <button type="button" class="btn btn-primary" onclick="habilitar_tabla()"><i class="fa fa-search"></i> BUSCAR</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <form id="form_pdf" name="form_pdf" method="post" action="<?= site_url() ?>registro_serie">
                <input type="hidden" name="idlote1" id="idlote1">
                <input type="hidden" name="id_provision1" id="id_provision1">
                <input type="hidden" name="id_producto1" id="id_producto1">
                <input type="hidden" name="cant_serie1" id="cant_serie1">
            </form> 
            <div class="row">
                <div class="col-md-12">
                    <div class="text-divider visible-xs"><span>Detalle de lote</span></div>
                    <div class="card card-bordered style-primary">
                        <div class="card-body style-default-bright">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%">Nª</th>
                                            <th width="16%">Nro de lote</th>
                                            <th width="16%">Nro Producto</th>
                                            <th width="16%">Producto</th>
                                            <th width="16%">Cantidad</th>
                                            <th width="16%">Accion</th>
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

    <!-- Modal -->
<div class="modal fade bd-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel"><b>Generar Serie</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form">
        <div class="col-12">
            <font id="mensaje_cantidad"></font>
            <br>
            <br>
            <font><b>Cantidad a Generar:</b></font>
            <br>
            <input type="number" id="cant_generar">
            <br>
            <br>
            <font><b>Iniciar generado desde el Número:</b></font>
            <br>
            <input type="number" id="cant_inicio" value="1">
            <br>

            <input type="hidden" name="provision2" id="provision2">
                <input type="hidden" name="lote2" id="lote2">
                <input type="hidden" name="producto2" id="producto2">
        </div>
                                             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" onclick="generar_serie()">Generar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-sm" id="modal_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel"><b>GENERAR PDF</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form_pdf" name="form_pdf" method="post" target="_blank" action="<?= site_url() ?>pdf_serie">
      <div class="modal-body form">
        <div class="col-12">
                <input type="hidden" name="provision1" id="provision1">
                <input type="hidden" name="lote1" id="lote1">
                <input type="hidden" name="producto1" id="producto1">
                <font><b>Nº Copias:</b></font>
                <br>
                <input type="number" id="cant_copias" name="cant_copias"value="1">  
        </div>
                                             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Generar PDF</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <!--  Datatables JS-->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- SUM()  Datatables-->
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>

    <script>
        $("#cant_generar").change(function(){
            console.log(cantidad_max);
            var cant = document.getElementById('cant_generar').value;
            if (cant >= cantidad_max) {
                $("#cant_generar").val(cantidad_max);
            }else if(cant <= 0 ){
                $("#cant_generar").val(1);
            }
        });

        $("#cant_inicio").change(function(){
            console.log(cantidad_max);
            var cant = document.getElementById('cant_inicio').value;
            if (cant > 999999999999999999) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Se supero el rango maximo, 999999999999999999',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                    showCancelButton: true,
                    cancelButtonText: 'CANCELAR'
                })
                $("#cant_inicio").val(1);
            }else if(cant <= 0 ){
                $("#cant_inicio").val(1);
            }
        });

        function habilitar_tabla() {
            var id_lote = document.getElementById("id_lote").value;
        $.ajax({
            url: '<?= base_url() ?>mostrar_lotes_garantia',
            type: "post",
            datatype: "json",
            data: {
                id_lote: id_lote,
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
                    "aoColumns": [{
                            "mData": "onro"
                        },
                        {
                            "mData": "oid_lote"
                        },
                        {
                            "mData": "oid_producto"
                        },
                        {
                            "mData": "odescripcion"
                        },
                        {
                            "mData": "ocantidad"
                        },
                        {
                        render: function(data, type, row) {
                            var a = `
                            <form id="form_registro" name="form_registro" method="post" action="<?= site_url() ?>registro_serie">
                                <input type="hidden" name="idlote" id="idlote">
                                <input type="hidden" name="id_provision" id="id_provision">
                                <input type="hidden" name="id_producto" id="id_producto">
                                <input type="hidden" name="cantidad" id="cantidad">
                                <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="validar_cantidad(${row.oid_provision},${row.oid_lote},${row.oid_producto},${row.ocantidad})" title="Registrar serie"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="generar_automatico(${row.oid_provision},${row.oid_lote},${row.oid_producto},${row.ocantidad})" title="Generar Automatico"><i class="fa fa-magic"></i></button>  
                                <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="generar_pdf(${row.oid_provision},${row.oid_lote},${row.oid_producto})" title="Generar PDF"><i class="fa fa-file-pdf-o"></i></button>
                            </form>    
                                    `;
                           
                            return a;
                        }
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
function validar_cantidad(id_provision,id_lote,id_producto,cantidad){
    document.getElementById("id_provision").value=id_provision;
    document.getElementById("idlote").value=id_lote;
    document.getElementById("id_producto").value=id_producto;
    document.getElementById("cantidad").value=cantidad;
    $.ajax({
            url: '<?= base_url() ?>validar_cantidad_serie',
            type: "post",
            datatype: "json",
            data: {
                id_provision:id_provision,
                id_lote: id_lote,
                id_producto: id_producto,
            },
            success: function(data) {
                var js = JSON.parse(data);
                if (js[0].oboolean == 'f') {
                    Swal.fire({
                        icon: 'error',
                        text: js[0].omensaje,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ACEPTAR',
                        showCancelButton: true,
                        cancelButtonText: 'CANCELAR'
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title:  js[0].omensaje,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ACEPTAR',
                        showCancelButton: true,
                        cancelButtonText: 'CANCELAR'
                    }).then(function(result){
                        if(result.isConfirmed){
                            document.getElementById("form_registro").submit();
                        }

                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
   
}
var cantidad_max = 0;
function generar_automatico(id_provision,id_lote,id_producto,cant_total){
    console.log(id_provision,id_lote,id_producto)
    $("#provision2").val(id_provision);
    $("#lote2").val(id_lote);
    $("#producto2").val(id_producto);
    $.ajax({
            url: '<?= base_url() ?>producto/C_items/validar_cantidad_serie',
            type: "post",
            datatype: "json",
            data: {
                id_provision:id_provision,
                id_lote: id_lote,
                id_producto: id_producto,
            },
            success: function(data) {
                var js = JSON.parse(data);
                console.log(js);
                if (js[0].oboolean == 'f') {
                    Swal.fire({
                        icon: 'error',
                        text: js[0].omensaje,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ACEPTAR',
                        showCancelButton: true,
                        cancelButtonText: 'CANCELAR'
                    })
                } else {
                    if (js[0].ocantfantante == '0') {
                        Swal.fire({
                        icon: 'warning',
                        title: js[0].omensaje,
                        confirmButtonText: 'ACEPTAR',
                        }) 
                    }else{
                        var inicio_cant = parseInt(js[0].ocantregistrados, 10) + 1;
                        cantidad_max=parseInt(js[0].ocantfantante, 10);
                        $("#cant_generar").val(cantidad_max);
                        $("#mensaje_cantidad").html(js[0].omensaje);
                        $('#exampleModal').modal('show');
                    }


                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
   
}

function generar_serie(){

    id_provision = document.getElementById('provision2').value;
    id_lote = document.getElementById('lote2').value;
    id_producto = document.getElementById('producto2').value;
    cantidad = document.getElementById('cant_generar').value;
    inicio = document.getElementById('cant_inicio').value;
    console.log(id_provision,id_lote,id_producto,cantidad,inicio);

    $('#exampleModal').modal('hide')
    $.ajax({
            url: '<?= base_url() ?>producto/C_items/verificar_generado_serie',
            type: "post",
            datatype: "json",
            data: {
                id_provision:id_provision,
                id_lote: id_lote,
                id_producto: id_producto,
                cantidad:cantidad,
                inicio:inicio,
            },
            success: function(data) {
                var js = JSON.parse(data);
                console.log(js);
                if (js[0].oboolean == 'f') {
                    Swal.fire({
                        icon: 'error',
                        text: js[0].omensaje,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ACEPTAR',
                        showCancelButton: true,
                        cancelButtonText: 'CANCELAR'
                    })
                } else {
                    $.ajax({
                        url: '<?= base_url() ?>producto/C_items/generar_serie_item',
                        type: "post",
                        datatype: "json",
                        data: {
                            id_provision:id_provision,
                            id_lote: id_lote,
                            id_producto: id_producto,
                            cantidad:cantidad,
                            inicio:inicio,
                        },
                        success: function(data) {
                            var js = JSON.parse(data);
                            console.log(js);
                            if (js[0].oboolean == 'f') {
                                Swal.fire({
                                    icon: 'error',
                                    text: js[0].omensaje,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                    showCancelButton: true,
                                    cancelButtonText: 'CANCELAR'
                                })
                            } else {
                                
                                Swal.fire({
                                    icon: 'success',
                                    title:  'Se ha realizado el registro de los items con exito',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                    showCancelButton: true,
                                    cancelButtonText: 'CANCELAR'
                                }).then(function(result){
                                    window.location = '<?= base_url() ?>items';
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error al obtener datos de ajax');
                        }
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
}

function generar_pdf(id_provision,id_lote,id_producto){
    console.log(id_provision,id_lote,id_producto);

    $("#provision1").val(id_provision);
    $("#lote1").val(id_lote);
    $("#producto1").val(id_producto);
    $('#modal_pdf').modal('show');
}
    </script>

<?php } else {
    redirect('inicio');
} ?>