<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Heidy Soliz Santos Fecha:29/06/2021, Codigo: GAM-031,
Descripcion: Se modifico para reducir  a dos decimales en el modulo de pedidos por caja
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha:05/08/2021, Codigo: GAN-010,
Descripcion: Se modifico la funcion datos pedido para que pueda mostrar una imagen y ademas se añadio 
una etiqueta lista en el form_producto para la imagen
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha:27/09/2021, Codigo: GAN-MS-A4-038,
Descripcion: Se modifico para agregar un boton que permite la impresion de cotizacion
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha:25/11/2021, Codigo: GAN-MS-A6-102,
Descripcion: Se modifico la funcion precio total para que esta pueda recibir datos con decimales
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Daniel Castillo Quispe                  Fecha: 05/03/2022
Descripcion: Ahora la opción de imprimir, también se muestra en el modal de guardar el pedido.
             También se evitó que se abra una nueva ventana al guardar el pedido luego de imprimir la nota de venta.
             Además, se armó los nombres de los clientes en el combo para que muestre también el ci/nit/codigo.
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:22/03/2022, Codigo:GAN-MS-M5-135
Descripcion: se modifico la funcion enviar para que se cierre el modal despues de imprimir el pdf
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:14/04/2022, Codigo:GAN-FR-A5-157
Descripcion: se cambiaron los nombres/titulos segun lo acordado en la reunion
------------------------------------------------------------------------------
Modificado: Keyla Paola Usnayo Aguilar Fecha:09/09/2022, Codigo:GAN-MS-A1-437
Descripcion: se agrego y corrigio la funcion datos_pedido() para que muestre los campos de cantidad almacen y cantidad sucursal 
------------------------------------------------------------------------------
Modificado: Keyla Paola Usnayo Aguilar Fecha:09/09/2022, Codigo:GAN-MS-A1-444
Descripcion: se quitaron los componentes que mostraban la cantidad en almacen y la cantidad en tienda para simplemente 
mostrar cantidad en sucursal simplificando los otros dos campos 
------------------------------------------------------------------------------
Modificado: Keyla Paola Usnayo Aguilar Fecha:13/09/2022, Codigo:GAN-MS-A1-452
Descripcion: Se modifico la función datos_pedido() para que por defecto la cantidad para una pedido sea de 1 
*/
?>
<?php if (in_array("smod_vent_caj", $permisos)) { ?>
  <input type="hidden" name="contador" id="contador" value="<?php echo $contador ?>">

  <script>
    var cont_pedido = $("#contador").val();
    $(document).ready(function() {
      activarMenu('menu5', 1);
      hab_botones(cont_pedido);

      /* GAN-MS-B5-0448 GValverde */
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
            $('#btn_pedido').attr("disabled", true);
            $('#btn_imp').attr("disabled", true);
          } else {
            document.getElementById('apertura_error').style.display = "none";
            document.getElementById('apertura_error').innerHTML = "";
          }
        }
      });
      /* FIN GAN-MS-B5-0448 GValverde */
    });
  </script>

  <script>
    function hab_botones(cont_pedido) {
      if (cont_pedido == 0) {
        $('#btn_adicional').attr("disabled", true);
        $('#btn_pedido').attr("disabled", true);
        $('#btn_imp').attr("disabled", true);
        $('#btn_siguiente').attr("disabled", false);
      } else {
        $('#btn_adicional').attr("disabled", false);
        $('#btn_pedido').attr("disabled", false);
        $('#btn_imp').attr("disabled", false);
        $('#btn_siguiente').attr("disabled", false);
      }
    }

    function cambiar_consulta() {
      id_producto = document.getElementById("producto");
      var selc_prod = id_producto.options[id_producto.selectedIndex].value;
      if (selc_prod == "" || selc_prod == null) {
        $("#msjproducto").html("Debe seleccionar un produto");
        document.getElementById("msjproducto").style.color = "red";
        document.getElementById("msjproducto").style.fontSize = "12px";
      } else {
        $("#msjproducto").html("");
        $.post("<?= base_url() ?>venta/C_pedido/func_auxiliares", {
          accion: 'form_pedido',
          selc_prod: selc_prod
        }, function(data) {
          $('#AjaxFormPedido').html(data);
        });
      };
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

    function datos_pedido() {
      $('#form_pedido')[0].reset();
      id_producto = document.getElementById("producto");
      var selc_prod = id_producto.options[id_producto.selectedIndex].value;

      if (selc_prod == "" || selc_prod == null) {
        $("#msjproducto").html("Debe seleccionar un produto");
        document.getElementById("msjproducto").style.color = "red";
        document.getElementById("msjproducto").style.fontSize = "12px";
      } else {
        $("#msjcantidad").html("");
        $("#msjproducto").html("");
        $.ajax({
          url: "<?php echo site_url('venta/C_pedido/datos_producto') ?>/" + selc_prod,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            $('[name="id_producto"]').val(data.id_producto);
            $('[name="pre_compra"]').val(data.precio_compra);
            $('[name="cant_sucursal"]').val(data.c_sucursal).trigger('change');
            $('[name="cantidad"]').val("1");

            var precio = data.precio_unidad;
            numb = parseFloat(precio).toFixed(2);
            $('[name="precio_ref"]').val(numb);
            $('[name="precio_uni"]').val(numb);
            $('[name="pre_total"]').val(numb);
            $("#precio").html(numb);
            if (data.imagen == null || data.imagen == '') {
              dato = '<div align="center"><img src="<?php echo base_url(); ?>assets/img/productos/sin_imagen.jpg" class="img-responsive"></div>';
            } else {
              dato = '<div align="center"><img src="<?php echo base_url(); ?>assets/img/productos/' + data.imagen + '" class="img-responsive"></div>';
            };
            $("#ver_imagen").html(dato);
            $('[name="id_unidad"]').val(data.id_unidad);
            document.getElementById("formulario_pedido").style.display = "block";
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
          }
        });
      };
    }

    function precio_total() {
      var disp_tienda = parseFloat(document.getElementById("cant_sucursal").value);
      var pre_ref = document.getElementById("precio_uni").value;
      var cantidad = parseFloat(document.getElementById("cantidad").value);

      if (cantidad <= 0) {
        var mensaje = 'La cantidad debe ser mayor a 0.';
        $("#msjcantidad").html(mensaje);
        document.getElementById("msjcantidad").style.color = "red";
        document.getElementById("msjcantidad").style.fontSize = "14px";
        document.getElementById('pre_total').value = '';
        $('#btn_add_prod').attr("disabled", true);
      } else {
        if (cantidad > disp_tienda) {
          var mensaje = 'No existe la cantidad disponible en la tienda. Por favor realice la solicitud a almacenes.';
          $("#msjcantidad").html(mensaje);
          document.getElementById("msjcantidad").style.color = "red";
          document.getElementById("msjcantidad").style.fontSize = "14px";
          document.getElementById('pre_total').value = '';
          $('#btn_add_prod').attr("disabled", true);

        } else {
          $("#msjcantidad").html("");
          var precio_total = parseFloat(cantidad * pre_ref);
          precio_total = precio_total.toFixed(2);
          document.getElementById('pre_total').value = precio_total;
          $('#btn_add_prod').attr("disabled", false);
        }
      }

    }

    function validar_precio() {
      var pre_ref = document.getElementById("precio_ref").value;
      var pre_uni = document.getElementById("precio_uni").value;
      var cantidad = document.getElementById("cantidad").value;
      var precio_total = document.getElementById("pre_total").value;
      //var descuento = (0, 2 * (pre_ref * cantidad) + (pre_ref * cantidad)); 
      //var descuento = ((pre_uni *cantidad) - (0.2*(pre_uni * cantidad)));
      var descuento = cantidad * (pre_uni - (0.15 * pre_uni));
      if (precio_total < descuento) {
        $("#msjprecio").html("El precio a vender es muy bajo");
        document.getElementById("msjprecio").style.color = "red";
        document.getElementById("msjprecio").style.fontSize = "14px";
      } else if ((precio_total >= descuento)) {
        $("#msjprecio").html("");
      }
    }
  </script>

  <style>
    hr {
      margin-top: 0px;
    }

    .select2-container .select2-choice>.select2-chosen {
      white-space: normal;
    }
  </style>

  <script>
    function enviar(destino) {
      if ($("#btnGuardar").is(":hidden")) {
        $('#modal_garantia').modal('hide');
      }
      if ('<?= site_url() ?>generar_cotizacion' == destino) {
        document.form_garantia.target = "_blank";
        document.form_garantia.action = destino;
        document.form_garantia.submit();
      } else {
        document.form_garantia.target = "";
        document.form_garantia.action = destino;
        document.form_garantia.submit();
      }
    }
  </script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Venta</a></li>
          <li class="active">Venta en Caja</li>
        </ol>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <form class="form form-validate" novalidate="novalidate" name="form_producto" id="form_producto" method="post" action="">
              <?php $id_ubicacion = $this->session->userdata('ubicacion'); ?>
              <input type="hidden" name="id_ubicacion" value="<?php echo $id_ubicacion; ?>">
              <div class="card">
                <div class="card-head style-default-light">
                  <header>Selecci&oacute;n de Filtro </header>
                </div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group floating-label">
                        <div class="input-group">
                          <div class="input-group-content">
                            <select class="form-control select2-list" id="producto" name="producto">
                              <option value=""></option>
                              <?php foreach ($productos as $prod) {  ?>
                                <option value="<?php echo $prod->id_producto ?>" <?php echo set_select('producto', $prod->id_producto) ?>> <?php echo $prod->productos ?></option>
                              <?php  } ?>
                            </select>
                            <label for="producto">Producto</label>
                            <div id="msjproducto"></div>
                            <div class="form-control-line"></div>
                          </div>
                          <div class="input-group-btn">
                            <button class="btn btn-floating-action btn-primary" type="button" onclick="datos_pedido();"><i class="fa fa-search"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div style="display: none;" id="formulario_pedido">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
              <form class="form form-validate" novalidate="novalidate" name="form_pedido" id="form_pedido" method="post" action="<?= site_url() ?>venta/C_pedido/add_pedido">
                <input type="hidden" name="id_producto" id="id_producto">
                <div class="card">
                  <div class="card-body no-padding">
                    <ul class="list">
                      <center>
                        <li class="tile" id="ver_imagen">
                        </li>
                      </center>
                      <li class="tile" type="hidden">
                        <input type="hidden" name="id_unidad" id="id_unidad">
                        <a class="tile-content">
                          <div class="tile-icon"><i class="md md-business "></i></div>
                          <div class="tile-text">
                            Cantidad en Sucursal
                            <small class="pull-right text-bold opacity-75" style="font-size: 16px; padding-right: 20px;" id="tienda"> </small>
                            <b><input style="text-align:right; background-color:transparent; border:0; color:#868384;" type="number" name="cant_sucursal" id="cant_sucursal" disabled></b>
                          </div>
                        </a>
                      </li>
                      <li class="divider-inset"></li>

                      <li class="tile">
                        <a class="tile-content">
                          <div class="tile-icon"><i class="fa fa-money"></i></div>
                          <div class="tile-text">
                            Precio ref. por unidad (Bs.)
                            <small class="pull-right text-bold opacity-75" style="font-size: 16px; padding-right: 20px;" id="precio"> </small>
                            <input type="hidden" name="precio_ref" id="precio_ref">
                            <input type="hidden" name="pre_compra" id="pre_compra">
                          </div>
                        </a>
                      </li>
                      <li class="divider-inset"></li>

                      <li class="tile">
                        <a class="tile-content">
                          <div class="tile-icon"><i class="fa fa-cart-plus"></i></div>
                          <div class="tile-text">
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="padding-left: 0px; ">
                              Cantidad
                            </div>

                            <div class="col-xs-8 col-sm-8 col-md-9 col-lg-9">
                              <small class="pull-right opacity-75" style="font-size: 16px; padding-right: 10px;">
                                <input type="number" class="form-control" name="cantidad" id="cantidad" min="0" required="" onchange="precio_total()" style="height: 24px; text-align: right; font-weight: bold;">
                              </small>
                            </div>
                            <strong>
                              <div id="msjcantidad" style="padding-top: 30px"></div>
                            </strong>
                          </div>
                        </a>
                      </li>
                      <li class="divider-inset"></li>

                      <li class="tile">
                        <a class="tile-content">
                          <div class="tile-icon"><i class="fa fa-cart-plus"></i></div>
                          <div class="tile-text">
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" style="padding-left: 0px; ">
                              Precio Unid.
                            </div>

                            <div class="col-xs-8 col-sm-8 col-md-9 col-lg-9">
                              <small class="pull-right opacity-75" style="font-size: 16px; padding-right: 10px;">
                                <input type="number" class="form-control" name="precio_uni" id="precio_uni" min="0" required="" onchange="precio_total()" style="height: 24px; text-align: right; font-weight: bold;">
                              </small>
                            </div>
                            <strong>
                              <div id="msjprecio_uni" style="padding-top: 30px"></div>
                            </strong>
                          </div>
                        </a>
                      </li>
                      <li class="divider-inset"></li>

                      <li class="tile">
                        <a class="tile-content">
                          <div class="tile-icon"><i class="fa fa-money"></i></div>
                          <div class="tile-text">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding-left: 0px; ">
                              Precio Total
                            </div>

                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="padding-left: 0px;">
                              <small class="pull-right opacity-75" style="font-size: 16px; padding-right: 10px;">
                                <input type="number" class="form-control" name="pre_total" id="pre_total" min="0" data-rule-number="true" required="" onchange="validar_precio()" style="height: 24px; text-align: right; font-weight: bold;">
                              </small>
                            </div>

                            <strong>
                              <div id="msjprecio" style="padding-top: 30px"></div>
                            </strong>
                          </div>
                        </a>
                      </li>

                      <li class="tile">
                        <a class="tile-content ink-reaction">
                          <div class="tile-icon"></div>
                          <div class="tile-text" style="padding-top: 0px;">
                            <small class="pull-right" style="opacity: 1;">
                              <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add_prod" value="add">Agregar producto a pedido </button>
                            </small>
                          </div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
            <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
            <div class="card card-bordered style-primary">
              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table id="datatable3" class="table">
                    <thead>
                      <tr>
                        <th>Acci&oacute;n</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Precio</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php foreach ($lst_pedidos as $ped) { ?>
                        <tr>
                          <td style="width: 10%" align="center">
                            <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_pedido('<?php echo $ped->id_venta ?>')"><i class="fa fa-trash-o"></i></button>
                          </td>
                          <td><?php echo $ped->producto ?></td>
                          <td><?php echo $ped->cantidad ?></td>
                          <td><?php echo $ped->unidad ?></td>
                          <td style="text-align: right;"><?php echo $ped->precio ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="4" style="text-align: right;">Precio total de pedidos realizados</th>
                        <th style="text-align: right;"><?php echo $total_pedido; ?></th>
                      </tr>
                      <tr>
                        <td>
                          <!-- /* GAN-MS-B5-0448 GValverde */ -->
                          <div class="alert alert-danger" id="apertura_error" style="display: none;"></div>
                          <!-- /* FIN GAN-MS-B5-0448 GValverde */ -->
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5" style="text-align: right; border-top: 0; padding-top: 20px">
                          <button type="button" class="btn ink-reaction btn-raised btn-primary" id="btn_pedido" onclick="add_garantia(0)">Confirmar Pedido</button> &nbsp;&nbsp;&nbsp;
                          <button type="button" class="btn btn-default ink-reaction btn-raised" onclick="add_cotizacion(0)" id="btn_imp"><span class="pull-left"><i class="fa fa-print fa-lg"></i></span> </button>&nbsp;&nbsp;&nbsp;
                          <button type="button" class="btn btn-default ink-reaction btn-raised" onclick="siguiente()" id="btn_siguiente"><span class="pull-left"><i class="fa fa-mail-forward fa-lg"></i></span> </button>
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
          <h4 class="modal-title" id="formModalLabel">A&ntilde;adir Informaci&oacute;n Adicional</h4>
        </div>

        <form class="form" role="form" name="form_garantia" id="form_garantia" method="post">
          <input type="hidden" name="id_lote" id="id_lote" value="01">
          <div class="modal-body">

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="form-group floating-label">
                  <select class="form-control select2-list" id="cliente" name="cliente" required>
                    <?php foreach ($clientes as $cli) {  ?>
                      <option value="<?php echo $cli->id_personas ?>" <?php echo set_select('cliente', $cli->id_personas) ?>> <?php echo $cli->cliente ?></option>
                    <?php  } ?>
                  </select>
                  <label for="serie_gar">Seleccione Cliente</label>
                </div>
              </div>


              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group floating-label">
                  <div class="checkbox checkbox-styled">
                    <label>
                      <input type="checkbox" name="factura" id="factura" value="1">
                      <span> Pedido con Factura </span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btnGuardar" class="btn btn-primary" onclick="enviar('<?= site_url() ?>venta/C_pedido/confirmar_pedido')">Guardar</button>
            <button type="button" id="btncotizar" class="btn btn-primary" onclick="enviar('<?= site_url() ?>generar_cotizacion')">Imprimir</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END FORM MODAL MARKUP -->

  <script>
    function add_garantia(id_lote) {
      $('#form_garantia')[0].reset();
      $('[name="id_lote"]').val(id_lote);
      $('#modal_garantia').modal('show');
      $('#btncotizar').show();
      $('#btnGuardar').show();
    }

    function add_cotizacion(id_lote) {
      $('#form_garantia')[0].reset();
      $('[name="id_lote"]').val(id_lote);
      $('#modal_garantia').modal('show');
      $('#btncotizar').show();
      $('#btnGuardar').hide();
    }

    function siguiente() {
      location.href = "<?php echo base_url(); ?>venta";
    }
  </script>

  <script>
    function eliminar_pedido(id_ped) {
      BootstrapDialog.show({
        title: 'ELIMINAR PEDIDO',
        message: '<div>Esta seguro que desea <b>eliminar</b> el <b>producto</b> del pedido</div>',
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialog) {
            var $button = this;
            $button.disable();
            window.location = '<?= base_url() ?>venta/C_pedido/dlt_pedido/' + id_ped;
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