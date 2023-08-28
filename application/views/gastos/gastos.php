<?php
/*
  ------------------------------------------------------------------------------
  Creador: Fabian Candia Alvizuri Fecha 22/02/2021, Codigo: GAN-FR-M3-030
  Descripcion: Se realizo el frontend de las páginas 105 a 108 del branch de Design 

 ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:24/09/2021, GAN-MS-M6-035
  Descripcion: Se realizaron la modificacion de para la creacion de funciones de las páginas 105 a 108 
  -------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
  Descripcion: se modifico el datatable para insertar el limit del modelo
    -------------------------------------------------------------------------------------------------------
  Modificado: Wilson Huanca Callisaya Fecha:17/02/2023, Codigo: GAN-MS-B0-0280
  Descripcion: se adicionó  en id="datatable_gasto" los campos total y fecha 
 

*/
?>
<?php if (in_array("mod_gast", $permisos)) { ?>
  <script>
    $(document).ready(function() {
      activarMenu('menu7');
    });
  </script>

  <style>
    hr {
      margin-top: 0px;
    }
  </style>

  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Gastos</a></li>
          <li class="active">Gastos</li>
        </ol>
      </div>



      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="text-primary">Listado de Gastos
              <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nuevo Gasto</button>
            </h3>
            <hr>
          </div>
        </div>

        <div class="row" style="display: none;" id="form_registro">
          <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
            <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_cliente" id="form_cliente" method="post" action="<?= site_url() ?>gastos/C_gastos/add_gastos">
                  <input type="hidden" name="id_gastos" id="id_gastos">
                  <div class="card">
                    <div class="card-head style-primary">
                      <div class="tools">
                        <div class="btn-group">
                          <a id="btn_update" class="btn btn-icon-toggle" onclick="update_formulario()"><i class="md md-refresh"></i></a>
                          <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                        </div>
                      </div>
                      <header id="titulo"></header>
                    </div>
                    <input type="hidden" name="id_gast" value="">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group floating-label" id="c_descripcion">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                            <label for="descripcion">Descripcion del gasto</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group floating-label" id="c_monto">
                            <input type="number" class="form-control" name="monto" id="monto" required>
                            <label for="monto">Monto Unitario del gasto</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group floating-label" id="c_cantidad">
                            <input type="number" class="form-control" name="cantidad" id="cantidad" required>
                            <label for="cantidad">Cantidad</label>
                          </div>
                        </div>
                      </div>
                      <!-- /* GAN-MS-B5-0448 GValverde */ -->
                      <div class="alert alert-danger" id="apertura_error" style="display: none;"></div>
                      <!-- /* FIN GAN-MS-B5-0448 GValverde */ -->
                    </div>

                    <div class="card-actionbar">
                      <div class="card-actionbar-row">
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Gasto</button>
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add">Guardar Gasto</button>
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
            <div class="text-divider visible-xs"><span>Listado de Gastos</span></div>
            <div class="card card-bordered style-primary">
              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table id="datatable_gasto" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Nro</th>
                        <th>Descripcion Gasto</th>
                        <th>Monto Unit. del gasto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Fecha</th>
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

  <script>
    $(document).ready(function() {
      $('#datatable_gasto').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive': true,
        "language": {
          "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
        },
        'serverMethod': 'post',
        'ajax': {
          'url': '<?= base_url() ?>gastos/C_gastos/lista_gastos'
        },

        'columns': [

          {
            data: 'onro'
          },
          {
            data: 'odescripcion'
          },
          {
            data: 'omonto_uni'
          },
          {
            data: 'ocantidad'
          },
          {
            data: 'ototal'
          },
          {
            data: 'ofeccre'
          },
          {
            data: 'ocantidad',
            render: function(data, type, row) {

              return '   <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_gasto(' + row['oidgasto'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Activar" class="btn ink-reaction btn-floating-action btn-xs btn-danger " onclick="eliminar_gasto(' + row['oidgasto'] + ')"><i class="fa fa-trash-o fa-lg"></i></button>';

            }

          }

        ],
        "dom": 'C<"clear">lfrtip',
        "colVis": {
          "buttonText": "Columnas"
        },
      });

    });

    function formulario() {
      $("#titulo").text("Registrar Gasto");
      $('#form_cliente')[0].reset();
      document.getElementById("form_registro").style.display = "block";
      document.getElementById("btn_update").style.display = "block";
      /* GAN-MS-B5-0448 GValverde */
      $('#btn_add').attr("disabled", false);
      $('#btn_edit').attr("disabled", true);
      var fechahoy = obtener_fecha();
      $.ajax({
        url: "<?php echo site_url('C_inicio/verificar_apertura_caja') ?>/" + fechahoy,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          console.log(data);
          if (data["oboolean"] == 'f') {
            document.getElementById('apertura_error').style.display = "block";
            document.getElementById('apertura_error').innerHTML = "<i class='fa fa-exclamation-circle' style='color:red;'></i>    " 
            +data["omensaje"] + 
            "<a class='btn btn-flat btn-info' href='<?= base_url(); ?>apertura'>apertura de caja</a>";
            $('#btn_add').attr("disabled", true);
          } else {
            document.getElementById('apertura_error').style.display = "none";
            document.getElementById('apertura_error').innerHTML = "";
            $('#btn_add').attr("disabled", false);
          }
        }
      });
      /* FIN GAN-MS-B5-0448 GValverde */
    }

    function cerrar_formulario() {
      document.getElementById("form_registro").style.display = "none";
    }

    function update_formulario() {
      $('#form_gastos')[0].reset();
      $('#btn_edit').attr("disabled", true);
      $('#btn_add').attr("disabled", false);
    }

    function editar_gasto(id_gasto) {
      console.log(id_gasto);
      $("#titulo").text("Modificar Categoría");
      document.getElementById("form_registro").style.display = "block";
      $('#form_cliente')[0].reset();
      document.getElementById("btn_update").style.display = "none";
      $('#btn_edit').attr("disabled", false);
      $('#btn_add').attr("disabled", true);
      $("#c_descripcion").removeClass("floating-label");
      $("#c_monto").removeClass("floating-label");
      $("#c_cantidad").removeClass("floating-label");

      $.ajax({
        url: "<?php echo site_url('gastos/C_gastos/datos_gasto') ?>/" + id_gasto,
        type: "POST",
        dataType: "JSON",
        success: function(data) {

          console.log(data);

          $('[name="descripcion"]').val(data.descripcion);
          $('[name="monto"]').val(data.monto);
          $('[name="cantidad"]').val(data.cantidad);
          $('[name="id_gast"]').val(data.id_gasto);

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error get data from ajax');
        }
      });
    }

    /* GAN-MS-B5-0448 GValverde */
    function obtener_fecha() {
      var esteMomento = new Date();
      var fecha = esteMomento.toLocaleDateString();
      var partesFecha = fecha.split("/");
      var dia = partesFecha[0];
      var mes = partesFecha[1];
      var anio = partesFecha[2];
      dia = dia.padStart(2, "0");
      mes = mes.padStart(2, "0");
      return fechaFormateada = dia + "-" + mes + "-" + anio;
    }
    /*FIN  GAN-MS-B5-0448 GValverde */

    function eliminar_gasto(id_gasto) {

      var titulo = 'ELIMINAR GASTO';
      var mensaje = '<div>Esta seguro que desea Eliminar el Gasto</div>';

      BootstrapDialog.show({
        title: titulo,
        message: $(mensaje),
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialog) {
            var $button = this;
            $button.disable();
            window.location = '<?= base_url() ?>gastos/C_gastos/dlt_gasto/' + id_gasto;
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