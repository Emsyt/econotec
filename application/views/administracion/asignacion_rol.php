<?php
/*  -------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
  Descripcion: se modifico el datatable para insertar el limit del modelo
  -------------------------------------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa Fecha:22/09/2022, Codigo: GAN-MS-A1-478
  Descripcion: se quito un input tipo hidden id_usurestriccion ya que existian dos y se elimino
  el post del formulario ya que no existia esa direccion de controlador
  -------------------------------------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa Fecha:06/10/2022, Codigo: GAN-MS-B5-0032
  Descripcion: Se cambio select 2, al momento de cambiar el rol y en el sub modulo de roles.
  -------------------------------------------------------------------------------------------------------
  Agregado: Edely Mireya Tito Loredo Fecha:21/07/2023, Codigo: GAN-MS-B0-0547
  Descripcion: Se agrego una funcion script para que cada vez que se cambie la selección del usuario, 
  se ejecute la función recuperar_datos_per.
  -------------------------------------------------------------------------------------------------------
  Modificado: Edely Mireya Tito Loredo Fecha:21/07/2023, Codigo: GAN-MS-B0-0547
  Descripcion: Se elimino el boton de lupa para el input de datos de usuario ya que este ya no tiene funcionalidad
  por la funcion agregada arriba.
  -------------------------------------------------------------------------------------------------------
  Modificado: Edely Mireya Tito Loredo Fecha:24/07/2023, Codigo: GAN-MS-B0-0547
  Descripcion: Se modifico el tamaño del input para la seleccion de usuario.
  -------------------------------------------------------------------------------------------------------
*/
?>
<?php if (in_array("smod_usu", $permisos)) { ?>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function recuperar_datos_per() {
      usr = document.getElementById("usuario");
      var id_usr = usr.options[usr.selectedIndex].value;
      $.ajax({
        url: "<?php echo site_url('administracion/C_usuario/datos_persona') ?>/" + id_usr,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
          if (data != null) {
            $('[name="id_usuario"]').val(data.id_usuario);
            $('[name="expedido"]').val(data.id_departamento);
            ci = data.carnet + ' ' + data.expedido;
            $('[name="ci"]').val(ci);
            $('[name="nombre"]').val(data.nombre);
            $('[name="ap_paterno"]').val(data.paterno);
            if (data.materno == null) {
              ap_materno = '';
            } else {
              ap_materno = data.materno;
            }
            $('[name="ap_materno"]').val(ap_materno);
            $('[name="login"]').val(data.login);
          } else {
            alert("Numero de Carnet no encontrado");
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          alert('Debe seleccionar un Usuario');
        }
      });
    }
  </script>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Administraci&oacute;n</a></li>
          <li class="active">Usuarios</li>
        </ol>
      </div>

      <?php if ($this->session->flashdata('success')) { ?>
        <script> window.onload = function mensaje() { swal.fire(" ", "<?php echo $this->session->flashdata('success'); ?>", "success"); } </script>
      <?php } else if ($this->session->flashdata('error')) { ?>
          <script> window.onload = function mensaje() { swal.fire(" ", "<?php echo $this->session->flashdata('error'); ?>", "error"); } </script>
        <?php } ?>

      <div class="section-body">
        <div class="row"><br>
          <div class="col-sm-4 col-md-3 col-lg-2">
            <ul class="nav nav-pills nav-stacked nav-icon">
              <li><small>PERSONAL -
                  <?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                  print_r($obj->{'titulo'}); ?>
                </small></li>
              <li><a href="<?= base_url() ?>usuarios"><span class="glyphicon glyphicon-blackboard"></span>
                  <p>Registro de Usuario</p>
                </a></li>
              <li class="active"><a href="<?= base_url() ?>asignacion_rol"><span class="glyphicon glyphicon-copy"></span>
                  <p>Asignaci&oacute;n de Rol</p>
                </a></li>
            </ul>
          </div>

          <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
            <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_reg_oge" id="form_asig_rol"
                  method="post" action="<?= site_url() ?>administracion/C_usuario/add_rol">
                  <input type="hidden" name="id_usuario" id="id_usuario">
                  <div class="card">
                    <div class="card-head style-primary">
                      <header>Asignaci&oacute;n de Rol</header>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group ">
                            <select class="form-control select2-list" id="usuario" name="usuario" required>
                              <option value="">Seleccione Usuario</option>
                              <?php foreach ($usuarios as $usr) { ?>
                                <option value="<?php echo $usr->id_usuario ?>" <?php echo set_select('usuario', $usr->id_usuario) ?>> <?php echo $usr->nombre . ' ' . $usr->paterno . ' ' . $usr->materno ?>
                                </option>
                              <?php } ?>
                            </select>
                            <label for="usuario">Usuario</label>
                            <div class="form-control-line"></div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                            <input type="text" class="form-control" name="nombre" id="nombre" readonly>
                            <label for="nombre">Nombres</label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <input type="text" class="form-control" name="ap_paterno" id="ap_paterno" readonly>
                            <label for="ap_paterno">Apellido Paterno</label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <input type="text" class="form-control" name="ap_materno" id="ap_materno" readonly>
                            <label for="ap_materno">Apellido Materno</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          <div class="form-group">
                            <input type="text" class="form-control" name="ci" id="ci" readonly>
                            <label for="ci">Carnet de Identidad</label>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <input type="text" class="form-control" name="login" id="login" readonly>
                            <label for="login">Login Usuario</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <select class="form-control select2-list" id="rol_usuario" name="rol_usuario" required>
                              <option value="">&nbsp;</option>
                              <?php foreach ($rol_usuario as $rol) { ?>
                                <option value="<?php echo $rol->id_rol ?>" <?php echo set_select('rol_usuario', $rol->id_rol) ?>> <?php echo $rol->descripcion ?></option>
                              <?php } ?>
                            </select>
                            <label for="rol_usuario">Permiso</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-actionbar">
                      <div class="card-actionbar-row">
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn">Registrar
                          Rol</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-divider visible-xs"><span>Listado de Registro</span></div>
            <div class="card card-bordered style-primary">
              <div class="card-head">
                <header>Detalle de Usuarios</header>
              </div>

              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table id="datatable_roles" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Nª</th>
                        <th>Login</th>
                        <th>Nombre Completo</th>
                        <th>Carnet de Identidad</th>
                        <th>Permiso</th>
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

    //GAN-MS-B0-0547, 21/07/2023 ETito
    $(document).ready(function () {
      $('#usuario').change(function () {
        recuperar_datos_per();
      });
    });
    // FIN GAN-MS-B0-0547, 21/07/2023 ETito

    $(document).ready(function () {
      $('#datatable_roles').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive': true,
        "language": {
          "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
        },
        'serverMethod': 'post',
        'ajax': {
          'url': '<?= base_url() ?>administracion/C_usuario/lista_rol'
        },

        'columns': [
          {
            data: 'login', render: function (data, type, row) {

              return row['nro'];

            }
          },
          { data: 'login' },
          {
            data: 'nombre', render: function (data, type, row) {

              return '' + row['nombre'] + ' ' + row['paterno'] + ' ' + row['materno'] + '';

            }
          },
          { data: 'carnet' },
          { data: 'descripcion' },
          { data: 'apiestado' },
          {
            data: 'apiestado', render: function (data, type, row) {


              return '  <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_rol(' + row['id_usurestriccion'] + ')"><i class="fa fa-pencil"></i></button> <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_rol(' + row['id_usurestriccion'] + ')"><i class="fa fa-trash-o"></i></button>';

            }
          }
        ],
        "dom": 'C<"clear">lfrtip',
        "colVis": {
          "buttonText": "Columnas"
        },
      });

    });
    function editar_rol(id_usres) {
      $('#form_editar')[0].reset();
      $('.form-group').removeClass('has-error');
      $('.help-block').empty();

      $.ajax({
        url: "<?php echo site_url('administracion/C_usuario/datos_usuariores') ?>/" + id_usres,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
          $('[name="id_usurestriccion"]').val(data.id_usurestriccion).trigger('change');
          $('[name="rol_usuario_mod"]').val(data.id_rol).trigger('change');
          $('[name="estado_usr_mod"]').val(data.apiestado).trigger('change');
          $('[name="proyecto_mod"]').val(data.id_proyecto).trigger('change');

          $('#modal_rol').modal('show');
          $('.modal-title').text('Modificar Rol de Usuario');
        },
        error: function (jqXHR, textStatus, errorThrown) {
          alert('Error get data from ajax');
        }
      });
    }
  </script>

  <!-- BEGIN FORM MODAL -->
  <div class="modal fade" name="modal_rol" id="modal_rol" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form" role="form" name="form_editar" id="form_editar" method="post">
          <input type="hidden" name="id_usuario" id="id_usuario">
          <input type="hidden" name="id_usurestriccion" id="id_usurestriccion">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="formModalLabel">Modificar Usuario</h4>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-sm-7">
                <div class="form-group">
                  <select class="form-control select2-list" id="rol_usuario_mod" name="rol_usuario_mod" required>
                    <option value="">&nbsp;</option>
                    <?php foreach ($rol_usuario as $rol) { ?>
                      <option value="<?php echo $rol->id_rol ?>" <?php echo set_select('rol_usuario', $rol->id_rol) ?>> <?php echo $rol->descripcion ?></option>
                    <?php } ?>
                  </select>
                  <label for="rol_usuario_mod">Permiso</label>
                </div>
              </div>
              <div class="col-sm-5">
                <div class="form-group">
                  <select class="form-control" name="estado_usr_mod" id="estado_usr_mod">
                    <option value="">&nbsp;</option>
                    <option value="ELABORADO"> ACTIVO </option>
                    <option value="INACTIVO"> INACTIVO</option>
                  </select>
                  <label for="estado_usr">Estado</label>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" id="btnGuardar" onclick="guardar_mod()" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END FORM MODAL -->

  <script>
    function guardar_mod() {
      $('#btnSave').text('Guardando...');
      $('#btnSave').attr('disabled', true);
      var url = "<?php echo site_url('administracion/C_usuario/editar_usuariores/') ?>";

      $.ajax({
        url: url,
        type: "POST",
        data: $('#form_editar').serialize(),
        dataType: "JSON",
        success: function (data) {
          if (data.status) {
            swal.fire(" ", "Registro Modificado exitosamente", "success");
            $('#modal_usuario').modal('hide');
            reload_table();
          }
          else {
            for (var i = 0; i < data.inputerror.length; i++) {
              $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
              $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
            }
          }
          $('#btnSave').text('Guardar'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable
        },
        error: function (jqXHR, textStatus, errorThrown) {
          alert('Error adding / update data');
          $('#btnSave').text('Guardar'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable
        }
      });
    }

    function reload_table() {
      location.reload(null, false);
    }

    function eliminar_rol(id_usres) {
      BootstrapDialog.show({
        title: 'Eliminar Usuario',
        message: $('<div>Esta seguro que desea eliminar el registro</div>'),
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function (dialog) {
            var $button = this;
            $button.disable();
            window.location = '<?= base_url() ?>administracion/C_usuario/dlt_usuariores/' + id_usres;
          }
        }, {
          label: 'Cancelar',
          action: function (dialog) {
            dialog.close();
          }
        }]
      });
    }
  </script>
<?php } else {
  redirect('inicio');
} ?>