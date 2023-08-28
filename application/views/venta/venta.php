<?php
/*
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:14/09/2021, Codigo: GAN-MS-A1-012
  Descripcion: Se modifico botton finalizar venta para que pueda abrir un modal 
  el cual permitira generar un pdf o no

  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:20/09/2021, Codigo: GAN-MS-M0-032
  Descripcion: Se ajusto el modal confirmarV para una mejor visualizacion la cual
  permite generar un pdf nota venta
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:22/03/2022, Codigo: GAN-MS-M5-135
  Descripcion: se modifico la funcion enviar para que se cierre el modal despues de imprimir el pdf
  */
?>
<?php if (in_array("smod_cobr_caj", $permisos)) { ?>
  <style>
    #ConfirmarV .modal-dialog {
      -webkit-transform: translate(0, -50%);
      -o-transform: translate(0, -50%);
      transform: translate(0, -50%);
      top: 50%;
      margin: 0 auto;
    }
  </style>
  <script>
    $(document).ready(function() {
      activarMenu('menu5', 2);
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
            document.getElementById('apertura_error').innerHTML = "<i class='fa fa-exclamation-circle' style='color:red;'></i>    " +
              data["omensaje"] +
              "<a class='btn btn-flat btn-info' href='<?= base_url(); ?>apertura'>apertura de caja</a>";
            $('#btn_conf_venta').attr("disabled", true);
          } else {
            document.getElementById('apertura_error').style.display = "none";
            document.getElementById('apertura_error').innerHTML = "";
            $('#btn_conf_venta').attr("disabled", false);
          }
        }
      });
      /* FIN GAN-MS-B5-0448 GValverde */
    });
  </script>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Venta</a></li>
          <li class="active">Confirmaci&oacute;n</li>
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
          <div class="col-md-12">
            <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
            <div class="card card-bordered style-primary">
              <div class="card-head style-primary">
                <header>Detalle de pedidos realizados </header>
              </div>

              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table class="table table-striped ">
                    <thead class="thead-dark">
                      <tr>
                        <th>Acci&oacute;n</th>
                        <th>N&deg;</th>
                        <th>Cliente</th>
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php $nro = 0;
                      foreach ($lst_conf_pedidos as $cped) {
                        $nro++; ?>
                        <tr>
                          <td style="width: 10%" align="center">
                            <button type="button" title="Registrar Garantia" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="add_garantia('<?php echo $cped->id_venta ?>', '<?php echo $cped->id_producto ?>', '<?php echo $cped->id_personas ?>')"><i class="fa fa-certificate fa-lg"></i></button>
                          </td>
                          <td><?php echo $nro ?></td>
                          <td><?php echo $cped->cliente ?></td>
                          <td><?php echo $cped->factura ?></td>
                          <td><?php echo $cped->fecha ?></td>
                          <td><?php echo $cped->hora ?></td>
                          <td><?php echo $cped->producto ?></td>
                          <td><?php echo $cped->cantidad ?></td>
                          <td style="text-align: right;"><?php echo $cped->precio ?></td>
                        </tr>
                      <?php }  ?>
                    </tbody>

                    <tfoot>
                      <tr>
                        <th colspan="8" style="text-align: right; font-size: 16px;">Precio Total</th>
                        <th style="text-align: right; font-size: 16px;"><?php echo $total_pedido; ?> </th>
                      </tr>
                      <tr>
                        <th colspan="10">
                          <!-- /* GAN-MS-B5-0448 GValverde */ -->
                          <div class="alert alert-danger" id="apertura_error" style="display: none;"></div>
                          <!-- /* FIN GAN-MS-B5-0448 GValverde */ -->
                        </th>
                      </tr>
                      <tr>
                        <td colspan="8" style="text-align: right; border-top: 0; padding-top: 20px">
                          <form class="form" name="conf_pedido2" id="conf_pedido2" method="post" action="<?= site_url() ?>venta/C_venta/confirmar_venta">
                            <input type="hidden" name="id_lote2" value="<?php echo $id_lote ?>">
                            <button type="button" class="btn btn-default ink-reaction btn-raised" onclick="volver()"><span class="pull-left"><i class="fa fa-mail-reply fa-lg"></i></span> &nbsp;&nbsp;&nbsp; Volver </button> &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn ink-reaction btn-raised btn-primary" data-toggle="modal" data-target="#ConfirmarV" id="btn_conf_venta"> Confirmar Venta</button>
                          </form>
                        </td>
                      </tr>
                    </tfoot>
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

  <!-- BEGIN FORM MODAL MARKUP -->
  <div class="modal fade" name="modal_garantia" id="modal_garantia" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="formModalLabel">A&ntilde;adir Garant&iacute;a</h4>
        </div>

        <form class="form" role="form" name="form_garantia" id="form_garantia" method="post" action="<?= site_url() ?>generar_venta">
          <input type="hidden" name="id_venta" id="id_venta">
          <input type="hidden" name="id_producto" id="id_producto">
          <input type="hidden" name="id_cliente" id="id_cliente">
          <div class="modal-body">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="form-group floating-label">
                  <input type="text" class="form-control" name="serie_gar" id="serie_gar" onchange="return mayuscula(this);" required>
                  <label for="serie_gar">Serie</label>
                </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group floating-label">
                  <div class="input-group date" id="demo-date">
                    <div class="input-group-content">
                      <input type="text" class="form-control" name="fecha_gar" id="fecha_gar" readonly="" required>
                      <label for="fecha_gar">Fecha</label>
                    </div>
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group floating-label">
                  <textarea class="form-control autosize" name="detalle_gar" id="detalle_gar" onchange="return mayuscula(this);" rows="1" required="" aria-required="true"> </textarea>
                  <label for="detalle_gar">Caracter&iacute;sticas</label>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END FORM MODAL MARKUP -->

  <!-- Modal Imprimir recibo-->
  <div class="modal fade" id="ConfirmarV" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width:450px;">
      <div class="modal-content">
        <div class="modal-header">
          <center>
            <h3 class="modal-title">IMPRIMIR RECIBO!!</h3>
          </center>
        </div>
        <div class="modal-body">
          <center>
            <img src="<?= base_url() ?>assets/img/icoLogo/imp.png" width="100px" height="100px" alt="Avatar" class="image"><br><br>
            <font size="3">Desea recibir un recibo de la compra?</font>
          </center>
        </div>
        <div class="modal-footer">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
              <form class="form" name="conf_pedido_pdf" id="conf_pedido_pdf" method="post">
                <input type="hidden" name="id_lote" value="<?php echo $id_lote ?>">
                <button type="submit" class="btn btn-primary">Si</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="enviar('<?= site_url() ?>venta/C_venta/confirmar_venta')">No</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function add_garantia(id_ven, id_prod, id_cli) {
      $('#form_garantia')[0].reset();
      $('[name="id_venta"]').val(id_ven);
      $('[name="id_producto"]').val(id_prod);
      $('[name="id_cliente"]').val(id_cli);
      $('#modal_garantia').modal('show');
    }

    function volver() {
      location.href = "<?php echo base_url(); ?>venta";
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
  </script>

  <script>
    $(document).on('ready', function() {
      $('form#conf_pedido_pdf').on('submit', function(e) {
        e.preventDefault();
        var lote = $('[name="id_lote"]').val();
        var popUp = window.open('', '_blank');
        $.ajax({
          url: '<?= site_url() ?>venta/C_venta/confirmar_venta',
          type: 'POST',
          data: {
            id_lote: lote
          },
          success: function(respuesta) {
            console.log(respuesta.id_lote);
            if (respuesta.resp == 'ok') {
              window.location.href = "<?= site_url() ?>venta";
              popUp.location.href = '<?= site_url() ?>venta/C_venta/generar_pdf_venta/' + respuesta.id_lote;
            }
          }
        });
      });
    });
  </script>
<?php } else {
  redirect('inicio');
} ?>