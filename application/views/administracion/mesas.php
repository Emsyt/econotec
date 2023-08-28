<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Ignacio Laquis Camargo Fecha:30/05/2023, Codigo: GAN-MS-M0-0504,
Descripcion: Se creo la vista del ABM llamado Mesas, un formulario de registro, modificacion y eliminacion de mesas 
-------------------------------------------------------------------------------------------------------------------------------
 */
?>
<?php if (in_array("smod_mesas", $permisos)) { ?>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      activarMenu('menu8', 4);
      listar_mesas();
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
          <li><a href="#">Administraci&oacute;n</a></li>
          <li class="active">Mesas</li>
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
            <h3 class="text-primary">Listado de Mesas
              <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nueva Mesa</button>
            </h3>
            <hr>
          </div>
        </div>

        <div class="row" style="display: none;" id="form_registro">
          <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
            <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_proveedor" id="form_proveedor" method="post" action="<?= site_url() ?>administracion/C_mesas/add_update_mesa">
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
                          <div class="form-group floating-label" id="c_responsable">
                            <select class="form-control select2-list" id="usuario" name="usuario" required>
                              <option value=""></option>

                              <?php foreach ($lst_usuarios as $usu) {  ?>
                                <option value="<?php echo $usu->id_usuario ?>" <?php echo set_select('usuario', $usu->id_usuario) ?>>
                                  <?php echo strtoupper($usu->nombre . ' ' . $usu->paterno . ' ' . $usu->materno) ?></option>
                              <?php } ?>
                            </select>
                            <label for="usuario">Seleccione Responsable</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group floating-label" id="c_mesa">
                            <input type="text" class="form-control" name="mesa" id="mesa" required>
                            <input type="hidden" class="form-control" name="id_mesa" id="id_mesa">
                            <label for="sigla">Mesa</label>
                          </div>
                        </div>
                      </div>

                      <div class="card-actionbar">
                        <div class="card-actionbar-row">
                          <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Mesa</button>
                          <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add">Registrar Mesa</button>
                        </div>
                      </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="text-divider visible-xs"><span>Listado de Mesas</span></div>
          <div class="card card-bordered style-primary">
            <div class="card-body style-default-bright">
              <div class="table-responsive">
                <table id="datatable_ubi" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nro</th>
                      <th>Ubicaci&oacute;n</th>
                      <th>Responsable</th>
                      <th>Mesa</th>
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
  </div>
  <!-- END CONTENT -->
  <script>
    function formulario() {
      $("#titulo").text("Registrar Mesa");
      document.getElementById("form_registro").style.display = "block";
    }

    function cerrar_formulario() {
      document.getElementById("form_registro").style.display = "none";
    }

    function update_formulario() {
      $('#form_proveedor')[0].reset();
      $('#btn_edit').attr("disabled", true);
      $('#btn_add').attr("disabled", false);
    }

    function listar_mesas() {
      $.ajax({
        url: '<?= base_url() ?>administracion/C_mesas/lista_mesas',
        type: "post",
        datatype: "json",

        success: function(data) {
          var data = JSON.parse(data);
          var t = $('#datatable_ubi').DataTable({
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
            "order": [[2, 'asc']],
            "aoColumns": [
              {"mData": "nro"},
              {"mData": "ubicacion"},
              {"mData": "responsable"},
              {"mData": "nro_mesa"},
              {
                "mRender": function(data, type, row, meta) {
                  var a = `                                                                          
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick=" editar_mesas(${row.id_mesa})" title ="Modificar"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick=" eliminar_mesa(${row.id_mesa})" title ="Eliminar" ><i class="fa fa-trash-o"></i></button></div>`;
                  return a;
                }
              },

            ],
            "dom": 'C<"clear">lfrtip',
            "colVis": {
              "buttonText": "Columnas"
            }
          });

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }

    function editar_mesas(id_mesa) {
      $("#titulo").text("Modificar Ubicacion");
      document.getElementById("form_registro").style.display = "block";
      $('#form_proveedor')[0].reset();

      $('#btn_edit').attr("disabled", false);
      $('#btn_add').attr("disabled", true);

      $("#c_responsable").removeClass("floating-label");
      $("#c_mesa").removeClass("floating-label");

      $.ajax({
        url: "<?php echo site_url('administracion/C_mesas/datos_mesa') ?>/" + id_mesa,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (!data || typeof data !== "object") {
            alert("No se recibieron datos válidos del servidor");
            return;
          }
          /* let documento = data.nit_ci;
          let complemento = '';
          if (data.id_documento == "1334") {
              if (documento) {
                  let partes = documento.split("-");
                  documento = partes[0];
                  complemento = partes[1] || '';
              } else {
                  documento = '';
              }
          } */
          $('[name="id_mesa"]').val(id_mesa);
          $('[name="usuario"]').val(data[0].id_responsable).trigger('change');
          $('[name="mesa"]').val(data[0].nro_mesa);
          locate();

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
      location.href = "#top";
    }

    function eliminar_mesa(id_mesa) {

      var titulo = 'ELIMINAR REGISTRO';
      var mensaje = '<div>Esta seguro que desea Eliminar el registro</div>';

      BootstrapDialog.show({
        title: titulo,
        message: $(mensaje),
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialog) {

            dialog.close();

            $.ajax({
              url: '<?= base_url() ?>administracion/C_mesas/dlt_mesas/' + id_mesa,
              type: "post",
              datatype: "json",

              success: function(data) {
                var data = JSON.parse(data);

                if (data[0].oboolean == 't') {
                  Swal.fire({
                    icon: 'success',
                    text: "La ubicacion se ha eliminado correctamente",
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
                    text: 'Error',

                  })
                }


              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
              }
            });

          }
        }, {
          label: 'Cancelar',
          action: function(dialog) {
            dialog.close();
          }
        }]
      });
    }
  </script>
<?php } else {
  redirect('inicio');
} ?>