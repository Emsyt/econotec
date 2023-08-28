<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: karen quispe chavez Fecha:01/08/2022, Codigo: GAN-MS-A1-333,
Descripcion: Se creo la vista para poder mostrar la tabla de pedidos 
---------------------------------------------------------------------
Modificacion: karen quispe chavez Fecha:16/08/2022, Codigo: GAN-MS-A1-333,
Descripcion: Se creo la la funcion para poder cambiar estados al recepcionar pedidos
---------------------------------------------------------------------

 */
?>
<?php if (in_array("smod_rep_soli", $permisos)) { ?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    activarMenu('menu9', 4);

});
</script>
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
                <li><a href="#">Provisi&oacute;n</a></li>
                <li class="active">Recepci&oacute;n de Pedidos</li>
            </ol>
        </div>

        <?php if ($this->session->flashdata('success')) { ?>
        <script>
        window.onload = function mensaje() {
            swal(" ", "<?php echo $this->session->flashdata('success'); ?>", "success");
        }
        </script>
        <?php } else if($this->session->flashdata('error')){ ?>
        <script>
        window.onload = function mensaje() {
            swal(" ", "<?php echo $this->session->flashdata('error'); ?>", "error");
        }
        </script>
        <?php } ?>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                <h3 class="text-primary">Recepci&oacute;n  Nro. <?php echo $nro ?> de <?php echo $ode ?> a <?php echo $oa ?>
                  
                    <hr>
                </div>
            </div>


            <div class="row">

                <div class="col-md-12">
                    <div class="text-divider visible-xs"><span>Listado de Pedidos</span></div>
                    <div class="card card-bordered style-primary">
                        <div class="card-body style-default-bright">
                            <div class="table-responsive">

                                <table id="datatable" class="table table-striped table-bordered" ALIGN="center">
                                    <thead>
                                        <tr>
                                       
                                                <!-- <th> <input type="checkbox" id="select_all_existent"> </th> -->
                                           
                                            <th>Producto</th>
                                            <th>Unidad</th>
                                            <th>Cantidad Solicitada</th>
                                            <th>Solicitado</th>
                                            <th>Estado</th>
                                            <th>Acci&oacute;n</th>

                                        </tr>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" style="text-align: right; border-top: 0; padding-top: 20px">
                                                <button type="button" title="Volver"
                                                    class="btn btn-default ink-reaction btn-raised"
                                                    onclick="volver()"><i class="fa fa-mail-reply fa-lg"></i>
                                                    &nbsp;&nbsp;Volver</button>
                                                <button type="button" id="confirm" 
                                                    class="btn btn-primary ink-reaction btn-raised">Confirmar</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    </thead>

                                    <tbody>

                                       
                                    </tbody>
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
function volver() {
    history.go(-1);
}

$(document).ready(function() {
    var idlote = <?php echo ($id_lote); ?>;
    $.ajax({
        url: "<?= site_url() ?>provision/C_recepcion_pedidos/lst_solicitud_recepcion/",
        type: "post",
        data: {
            idlote: idlote
        },
        success: function(data) {
            var data = JSON.parse(data);
            
         
            var cont = 0;
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
                    targets: 0,
                    //  className: 'select-checkbox',
                    orderable: false,
                }],
                order: [
                    [1, 'asc']
                ],
                "aoColumns": [
                    {
                        "mData": "oproducto"
                    },
                    {
                        "mData": "ounidad"
                    },
                    {
                        /*"mRender": function(data, type, row, meta) {
                           
                            var b = `
                            <input type="number" name="cantidadped" id="cantidadped${row.oidmovimiento}"
                                                    value="${row.ocantidad_solicitada}" min="0" onchange="validar(${row.ocantidad_solicitada},${row.oidmovimiento})">
                                    `;
                            return b;
                        },*/
                        "mData": "ocantidad_solicitada",
			                render: function(data, type, row){
				                return '<input style="width:80px;" type="text" name="cantidad_soli" id="cantidad_soli" class="cant_soli" value= '+ data + '><p style="display:none;" id="soli">'+ data +'</p>'; 
			                 }
                    },
                    {
                        "mData": "osolicitado"
                    },
                    {
                        "mData": "oestado"
                    },

                    {
                        "mRender": function(data, type, row, meta) {
                            var a = `
                                    <input type="checkbox" name="checkbox" id="checkbox${cont}" value="${row.oidmovimiento}" onclick="inhabilitar(${row.oidmovimiento},${cont})">
                                    `;
                            return a;
                        }
                    }
                ],
                "dom": 'C<"clear">lfrtip',
                "colVis": {
                    "buttonText": "Columnas"
                },
            });

            $('#cantidadped').change(function() {
                cantidad= document.getElementById("cantidadped").value;
              console.log(123);

             });
            // $('#select_all_existent').change(function() {
            //   var cells = t.cells().nodes();
            //   $(cells).find(':checkbox').prop('checked', $(this).is(':checked'));

            // });
            $("#confirm").click(function() {
           
              var cells = t.cells().nodes();
              var array = [];
              var array2 = [];
              //var cantidad = $("#cantidadped").value;
              for (var i = 0; i < data.length; i++) {
                if ($(cells).find(':checkbox')[i].checked) {
                  array.push($(cells).find(':checkbox')[i].value);
                  array2.push($(cells).find(':text')[i].value); 
                }
              }
              //console.log(typeof(array2));
              console.log(array2);
              //console.log(cantidad);
              console.log('espacio2');
              console.log(array);
              if (array.length === 0) {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Debe elegir por lo menos un producto!',
                })
              } else {
                $.ajax({
                      url: '<?= site_url() ?>provision/C_recepcion_pedidos/cambia_estado',
                      type: "post",
                      datatype: "json",
                      data: {
                        array: array,
                        array2: array2
                      },
                      success: function(data) {
                       // document.cookie = "array = " + JSON.stringify(array) + ";";
                      //  location.reload();
                      console.log(data);
                      }
                     
                    });
                    history.go(-1);
                    Swal.fire({
                    icon: 'success',
                    title: 'Producto recepcionado exitosamente',
                    confirmButtonText: 'aceptar'
                   })
              }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
        }
    });
});

function validar(cantidad,movimiento) {
    var cant=document.getElementById("cantidadped"+movimiento).value;
    console.log(cant);
    if (cant > cantidad) {
        $("#cantidadped"+movimiento).val(cantidad).trigger('change');
    }

}

function inhabilitar(id_mov, cont) {
   
    if ($('#checkbox'+cont).prop('checked') ) {
        document.getElementById("cantidadped"+id_mov).readOnly = true;
    }else{
        document.getElementById("cantidadped"+id_mov).readOnly = false;
    }
}
</script>
<?php } else {redirect('inicio');}?>
