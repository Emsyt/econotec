<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:18/11/2022   GAN-MS-A7-0111,
Descripcion: Se Realizo el frontend del retorno de garantias
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:18/11/2022   GAN-DPR-A7-0121,
Descripcion: Se Realizo el frontend del retorno de garantias con el combo para el 
proveedor y la tabla con checkbox
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:09/12/2022   GAN-MS-A5-0177,
Descripcion: Se Realizo y/o modifico el funcionamiento garantia ejecucion, registro y retorno 
considerando ya el numero de serie
*/
?>
<?php if (in_array("smod_ret_gar", $permisos)) { ?>
    <style>
  hr {
    margin-top: 0px;
  }

  .select2-container .select2-choice>.select2-chosen {
    white-space: normal;
  }

  /* BSINKA, 29/06/2021, ECOGAN-MS-M4-033 */
  .text-medium, strong {
    font-weight: bold;
  }
  /* FIN BSINKA, 29/06/2021, ECOGAN-MS-M4-033 */
</style>
<!-- BEGIN CONTENT-->
<div id="content">
  <section>
    <div class="section-header">
      <ol class="breadcrumb">
        <li><a href="#">Garantias</a></li>
        <li class="active">Retorno</li>
      </ol>
    </div>

    <!-- <?php if ($this->session->flashdata('success')) { ?>
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
    <?php } ?> -->

    <div class="section-body">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
          <form class="form form-validate" novalidate="novalidate" name="form_provision" id="form_provision">
            <div class="card">
              <div class="card-head style-primary">
                <header>Proveedor</header>
              </div>
              <input type="hidden" id="c_ids_lotes" name="c_ids_lotes">
              <div class="card-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label">
                      <select class="form-control select2-list" id="proveedor" name="proveedor" required="">
                        <?php foreach ($proveedores as $prov) {  ?>
                          <option value="<?php echo $prov->id_personas ?>" <?php echo set_select('proveedor', $prov->id_personas) ?>> <?php echo $prov->proveedor ?></option>
                        <?php  } ?>
                      </select>
                      <label for="proveedor">Seleccione Proveedor</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-actionbar">
                <div class="card-actionbar-row">
                  <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="retorno();" name="btn_prov" id="btn_prov">Buscar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
          <div class="card card-bordered style-primary">
            <div class="card-body style-default-bright">
              <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                  <thead>
                    <tr>
                      <th style="width: 10%; text-align: center;">Nro</th>
                      <th>Producto</th>
                      <th>Observacion</th>
                      <th>Archivo</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                      <th>Accion</th>
                    </tr>
                  </thead>

                  <tbody>
                    
                  </tbody>
                </table>

                <!-- BEGIN HORIZONTAL FORM -->
                <!-- BSINKA, 29/06/2021, ECOGAN-MS-M4-033 -->
                <div class="row">
                  <div class="col-lg-10 col-lg-offset-1">
                    <form class="form-horizontal form-validate" novalidate="novalidate" name="conf_provision" id="conf_provision" method="post">
                      
                      <div class="row" style="text-align: right; border-top: 0; padding-top: 20px">
                        <div class="col-lg-12">
                          <button type="button" class="btn ink-reaction btn-raised btn-primary" name="btn" id="btn_conf_prov" onclick="realizar_retorno();">Enviar a garantia</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- FIN BSINKA, 29/06/2021, ECOGAN-MS-M4-033 -->
                <!-- END HORIZONTAL FORM -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   $(document).ready(function() {
      retorno();
  });
  function retorno() {
    var id_proveedor=document.getElementById("proveedor").value;
        $.ajax({
            url: '<?= base_url() ?>get_retorno',
            type: "post",
            datatype: "json",
            data:{
              id_proveedor:id_proveedor
            },
            success: function(data) {
                var data = JSON.parse(data);
                //console.log(data);
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
                            "mData": "ocod_prod"
                        },
                        {
                            "mData": "oobservacion"
                        },
                        {
                            "mData": "oarchivo"
                        },
                        {
                            "mData": "ousucre"
                        },
                        {
                            "mData": "oapiestado"
                        },
                        {
                        render: function(data, type, row) {
                            //console.log(row);
                            if(row['oapiestado'] == 'RETORNADO'){
                            var a = `
                            <input type="checkbox" disabled value="${row.oidretorno}" name="id_lotes" id="estado">
                                    `;
                              }else{
                                var a = `
                            <input type="checkbox" value="${row.oidretorno}" name="id_lotes" id="estado">
                                    `;
                              }

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

function realizar_retorno() {
    var array = "";
    var ids_lotes = document.getElementsByName('id_lotes');
    console.log(ids_lotes);
    for (let i = 0; i < ids_lotes.length; i++) {
        if (ids_lotes[i].checked) {
            array = array + ids_lotes[i].value + ",";
        }

    }
    array = array.substr(0, array.length - 1);
    $("#c_ids_lotes").val("[" + array + "]");
    var lotes="[" + array + "]";
    console.log(array);
    if (array.length == 0) {
      Swal.fire({
                  icon: 'error',
                  text: "Por favor, seleccione al menos un registro",
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'ACEPTAR'
                });
    }else{
      $.ajax({
            url: '<?= base_url() ?>realizar_retorno',
            type: "post",
            datatype: "json",
            data:{
              lotes:lotes
            },
            success: function(data) {
                var data = JSON.parse(data);
                console.log(data);
                if(data[0].oboolean == 't'){
                  Swal.fire({
                  icon: 'success',
                  text: "Garantia enviada correctamente al proveedor",
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'ACEPTAR'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload();
                    }
                  });
                }else{
                  Swal.fire({
                  icon: 'error',
                  text: data[0].omensaje,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'ACEPTAR'
                });
                }
               

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }

}
</script>
<!-- END CONTENT -->
<?php } else {
    redirect('inicio');
} ?>