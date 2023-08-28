<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Gabriela Mamani Choquehuanca Fecha:25/07/2022, Codigo: GAN-MS-A1-317,
Descripcion: Se creo la vista del ABM llamado unidades, el cual muestra el formulario de registro , edicion y eliminacion de unidades
 */
?>
<?php if (in_array("smod_uni", $permisos)) { ?>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      activarMenu('menu8', 5);
      listar_unidades();
    });
  </script>
  <style>
    hr {
      margin-top: 0px;
    }
  </style>
  <style>
    .toggle.ios,
    .toggle-on.ios,
    .toggle-off.ios {
      border-radius: 20rem;
    }

    .toggle.ios .toggle-handle {
      border-radius: 20rem;
    }
  </style>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Administraci&oacute;n</a></li>
          <li class="active">Unidades</li>
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
            <h3 class="text-primary">Listado de Unidades
              <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nueva Unidad</button>
            </h3>
            <hr>
          </div>
        </div>
        <div class="row" style="display: none;" id="form_registro">
          <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
            <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_proveedor" id="form_proveedor" method="post" action="<?= site_url() ?>administracion/C_unidades/add_update_unidades">
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
                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_codigo">
                            <input type="text" class="form-control" name="codigo" id="codigo" required>
                            <input type="hidden" class="form-control" name="id_ubicacion" id="id_ubicacion">
                            <label for="sigla">Codigo</label>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_descripcion">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                            <input type="hidden" class="form-control" name="apiestado" id="apiestado">
                            <label for="sigla">Descripcion</label>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="card-actionbar">
                      <div class="card-actionbar-row">
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Unidad</button>
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add">Registrar Unidad</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="text-divider visible-xs"><span>Listado de Unidades</span></div>
            <div class="card card-bordered style-primary">
              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table id="datatable_ubi" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>Codigo</th>
                        <th>Descripcion </th>
                        <th>Estado</th>
                        <th>Acci&oacute;n</th>
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

      $("#titulo").text("Registrar Unidad");
      document.getElementById("form_registro").style.display = "block";
      $('#form_proveedor')[0].reset();
      $('#btn_edit').attr("disabled", true);
      $('#btn_add').attr("disabled", false);
    }

    function cerrar_formulario() {
      document.getElementById("form_registro").style.display = "none";
    }

    function update_formulario() {
      $('#form_proveedor')[0].reset();
      $('#btn_edit').attr("disabled", true);
      $('#btn_add').attr("disabled", false);
    }

    function listar_unidades() {
      $.ajax({
        url: '<?= base_url() ?>administracion/C_unidades/lista_unidades',
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
            "order": [],
            "aoColumns": [{
                "mData": "onro"
              },
              {
                "mData": "ocodigo"
              },
              {
                "mData": "odescripcion"
              },
              {
                "mData": "oapiestado"
              },
              {
                "mRender": function(data, type, row, meta) {
                  if (row['otipo'] == 'USUARIO') {
                    if (row['oapiestado'] == "ELABORADO") {
                      return '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" title="Modificar" onclick="editar_unidad(' + row['oid_unidad'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Inactivar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_unidad(\'' + row['id_catalogo'] + '\',\'' + row['apiestado'] + '\');"><i class="fa fa-trash-o fa-lg"></i></button> ';
                    } else {
                      return '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" title="Modificar" onclick="editar_unidad(' + row['oid_unidad'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Activar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="eliminar_unidad(\'' + row['id_catalogo'] + '\',\'' + row['apiestado'] + '\')"><i class="fa fa-trash-o fa-lg"></i></button>  ';
                    }
                  } else {
                    return '<p>POR IMPUESTOS</p>'
                  }

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


    function editar_unidad(id_catalogo) {

      $("#titulo").text("Modificar Unidad");
      document.getElementById("form_registro").style.display = "block";
      $('#form_proveedor')[0].reset();

      $('#btn_edit').attr("disabled", false);
      $('#btn_add').attr("disabled", true);

      $("#c_id_ubicacion").removeClass("floating-label");
      $("#c_codigo").removeClass("floating-label");
      $("#c_descripcion").removeClass("floating-label");


      $.ajax({
        url: "<?php echo site_url('administracion/C_unidades/datos_unidad') ?>/" + id_catalogo,
        type: "POST",
        dataType: "JSON",
        success: function(data)

        {
          $('[name="id_ubicacion"]').val(id_catalogo);
          $('[name="codigo"]').val(data[0].codigo);
          $('[name="descripcion"]').val(data[0].descripcion);
          $('[name="apiestado"]').val(data[0].apiestado);


        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }

    function eliminar_unidad(id_cli, estado) {
      if (estado == 'ELABORADO') {
        var titulo = 'ELIMINAR UNIDAD';
        var mensaje = '<div>Esta seguro que desea Eliminar la Unidad</div>';
      } else {
        var titulo = 'HABILITAR UNIDAD';
        var mensaje = '<div>Esta seguro que desea Habilitar la Unidad</div>';
      }
      BootstrapDialog.show({
        title: titulo,
        message: $(mensaje),
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialog) {
            var $button = this;
            $button.disable();
            window.location = "<?php echo site_url('administracion/C_unidades/dlt_unidades') ?>/" + id_cli + '/' + estado;
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