<?php
/*
------------------------------------------------------------------------------
Modificado: Heidy Soliz Santos Fecha:8/06/2021, Codigo: GAM-025
Descripcion: Se modifico para poner una ayuda en el input cantidad
------------------------------------------------------------------------------
Modificado: Heidy Soliz Santos Fecha:28/06/2021, Codigo: GAM-030,
Descripcion: Se modifico el formulario insertando el precio de venta para guardar el formulario  y mostrarlo
------------------------------------------------------------------------------
Modificado: Blanca Sinka Colmena Fecha:29/06/2021, Codigo: ECOGAN-MS-M4-033,
Descripcion: Se modifico el número de decimales en los precios y se adiciono la columna de Destino
------------------------------------------------------------------------------
Modificado: Luis Andres Cachaga Leuca Fecha:7/7/2021, Codigo: GAN-MS-A4-001,
Descripcion: Se modifico los campos de precios para que el scroll llegue hasta 2 decimales y minimo sea de 0.01
------------------------------------------------------------------------------
Modificado: Luis Andres Cachaga Leuca Fecha:08/07/2021, Codigo: GAN-MS-A1-003,
Descripcion: Se modifico la tabla de los precios para que muestre hasta 4 decimales
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:11/11/2021, Codigo: GAN-MS-A6-083,
Descripcion: Se modifico al modulo de ECOGAN , ABASTECIMIENTO para recuperar
            los valores de precios de compra y de venta de acuerdo a lo 
            explicado en la reunion
------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:14/04/2021, Codigo: GAN-MS-A0-156,
Descripcion: Se añadio el campo Fecha_vencimiento en el form
------------------------------------------------------------------------------
Modificado: Keyla Paola Usnayo Aguilar Fecha:15/09/2022, Codigo: GAN-MS-A1-464,
Descripcion: Se modifco para que se muestre Unidad por defecto dentro del select en el registro de compra, 
y se modifico las palabras Abastecimiento por Compra
------------------------------------------------------------------------------
Modificado: Keyla Paola Usnayo Aguilar Fecha:28/09/2022, Codigo: GAN-MS-A1-487,
Descripcion: Se añadio la funcion de dato_unidad() para mostrar la selección que se hizo en el select de 
unidad en la tabla de compras
------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma Fecha:27/09/2022, Codigo: GAN-MS-A1-0006,
Descripcion: Se modifico la validacion de precio comprar para permitir valores desde 0 y se añadio un identificar 
en la descripcion del producto con el texto "Bonificacion".
------------------------------------------------------------------------------
Modificado: Alvaro Ruben Gonzales Vilte Fecha:25/11/2022, Codigo: GAN-DPR-A7-0133
Descripcion: Se agrego en la interfaz de usuario un switch para determinar SIN IVA - CON IVA
------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha:28/11/2022, Codigo: GAN-MS-A6-0139
Descripcion: Se modifico el formulario de registro de producto para que guarde los datos del switch de IVA y de GARANTIA
----------------------------------------------------------------------------------------
Modificado: Jose Daniel Luna Flores  Fecha: 28/11/2022 Codigo:GAN-MS-M6-0140
Descripcion: Se modifico la interfaz para retorne el nuevo campo id_lote en la tabla de compras   
----------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja  Fecha: 29/12/2022 Codigo:GAN-MS-A7-0188
Descripcion: Se modifico el modulo de provision para incluir el ingreso de diferentes precios de venta
----------------------------------------------------------------------------------------
Modificado: Kevin Gerardo Alcon Lazarte  Fecha: 09/02/2023 Codigo:GAN-MS-B0-0247
Descripcion: Se agrego el prefijo Bs en  el sub modulo de compras y se cambio de total a Total(al contado)
----------------------------------------------------------------------------------------
Modificado: Briyan Julio Torrez Vargas  Fecha: 15/02/2023            Codigo:GAN-MS-B1-0276
Descripcion: Se trabajo el alert, y se configuro el btn agregar producots a la compra de forma que no se envie varias veces
----------------------------------------------------------------------------------------
Modificado: Kevin Gerardo Alcon Lazarte  Fecha: 28/03/2023 Codigo:GAN-DPR-M1-0373
Descripcion: Se agrego las funciones de editas y cokkie
----------------------------------------------------------------------------------------
Modificado: Kevin Gerardo Alcon Lazarte  Fecha: 05/04/2023 Codigo:GAN-MS-M4-0391
Descripcion: Se edito las funciones editar y editar_fila 
----------------------------------------------------------------------------------------
Modificado: Ayrton Jhonny Guevara Montaño  Fecha: 26/04/2023 Codigo:GAN-MS-B1-0437
Descripcion: Se añadio la opcion de pago por consignacion en la lista de radio buttons
----------------------------------------------------------------------------------------
Modificado: Jade Piza                      Fecha: 09/06/2023 Codigo:GAN-DPR-B3-0506
Descripcion:se ordeno los botones del listado de registro en la forma de pago.
---------------------------------------------------------------------------------------- 
Modificado: Edely Mireya Tito Loredo  Fecha: 25/07/2023 Codigo:GAN-MS-B1-0556
Descripcion:se realizo la conversion a float de los valores de precio_compra y precio_venta.
--------------------------------------------------------------------------------------------------------
Modificado:  Noemi Rosio Vera Velasquez Fecha:26/07/2023, Codigo: GAN-MS-B4-0563
Descripcion: Agregar datos en la parte de validacion de fecha en los if internos de mes y año y ademas de que llame los datos(fecha de vencimiento) recibido de la base de datos al editar un registro de compra
*/
?>

<?php if (in_array("smod_comp", $permisos)) { ?>
  <input type="hidden" name="contador" id="contador" value="<?php echo $contador ?>">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    var cont_provision = $("#contador").val();
    $(document).ready(function() {
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
              $('#btn_conf_prov').attr("disabled", true);
          } else {
            document.getElementById('apertura_error').style.display = "none";
            document.getElementById('apertura_error').innerHTML = "";
          }
        }
      });
      /* FIN GAN-MS-B5-0448 GValverde */

      console.log("<?php echo $this->session->flashdata('success'); ?>");
      activarMenu('menu9', 1);
      var count = 0;
      $('#agregarCampo1').click(function(e) {

        document.getElementById("count").value = count;

        $('#contenedor1').append('<div class="row" id="cont' + count + '">\
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="display: flex;">\
                      <div class="form-group floating-label" id="c_descripcion' + count + '">\
                          <input type="text" class="form-control" name="descripcion' + count + '" id="descripcion' + count + '" required="">\
                          <label for="descripcion' + count + '">Descripcion</label>\
                        </div>\
                    </div>\
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="display: flex;">\
                      <div class="form-group floating-label" id="c_precio_venta' + count + '">\
                        <input type="number" class="form-control" name="precio_venta' + count + '" id="precio_venta' + count + '" min="0.01" required="" step=".01">\
                        <label for="precio_venta' + count + '">Precio Venta en Bs</label>\
                        <div id="val_precioventa' + count + '" style="color: #FA5600"></div>\
                        </div>\
                        <div><h3>Bs</h3></div>\
                    </div>\
              <button id="button' + count + '" type="button" class="eliminarContenedor1 btn btn-floating-action btn-danger" onclick"eliminarcontenedor()"><i class="fa fa-trash"></i></button>\
            </div>');
        $('#c_descripcion' + count).removeClass('floating-label');
        $('#c_precio_venta' + count).removeClass('floating-label');
        count++;
        return count;
      });
      $("body").on("click", ".eliminarContenedor1", function(e) {
        var e = $(this).parent('div');
        e.remove();
      });

      hab_botones(cont_provision);
      $(".select2-list").select2({
        allowClear: true,
        language: "es"
      });
    });
  </script>

  <script type="text/javascript">
    function hab_botones(cont_provision) {

      if (cont_provision == 0) {
        $('#btn_conf_prov').attr("disabled", true);
      } else {
        $('#btn_conf_prov').attr("disabled", false);
      }
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
              $('#btn_conf_prov').attr("disabled", true);
          } else {
            document.getElementById('apertura_error').style.display = "none";
            document.getElementById('apertura_error').innerHTML = "";
          }
        }
      });
      /* FIN GAN-MS-B5-0448 GValverde */
    }

    function pago() {
      var selec_pago = $("input:radio[name='forma_pago']:checked").val();
      if (selec_pago == 'total') {
        $('#monto_deuda').attr("disabled", true);
        $('#monto_deuda').attr("onfocus", false);
        document.getElementById('monto_deuda').required = false;
        document.getElementById('monto_deuda').value = '';
      } else if (selec_pago == 'parcial') {
        $('#monto_deuda').attr("disabled", false);
        $('#monto_deuda').attr("onfocus", true);
        document.getElementById('monto_deuda').required = true;
      } else if (selec_pago == 'deuda') {
        $('#monto_deuda').attr("disabled", true);
        $('#monto_deuda').attr("onfocus", false);
        document.getElementById('monto_deuda').required = false;
        document.getElementById('monto_deuda').value = '';
        //Ayrton Guevara M. 26/04/2023 GAN-MS-B1-0437
      } else if (selec_pago == 'consignacion') {
        $('#monto_deuda').attr("disabled", true);
        $('#monto_deuda').attr("onfocus", false);
        document.getElementById('monto_deuda').value = '';
        //Fin Ayrton Guevara M. 26/04/2023 GAN-MS-B1-0437
      }
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

    function deuda() {
      var total_pago = parseInt(document.getElementById("monto_total").value);
      var deuda = document.getElementById("monto_deuda").value;

      if (deuda == "" || deuda == null) {
        var mensaje = 'Este campo es obligatorio.';
        $("#msjdeuda").html(mensaje);
        $('#btn_conf_prov').attr("disabled", true);
        alert('campo vacio')
      } else {
        if (total_pago < parseInt(deuda)) {
          var mensaje = 'El campo debe ser menor al total.';
          $("#msjdeuda").html(mensaje);
          $('#btn_conf_prov').attr("disabled", true);
        } else {
          if (parseInt(deuda) <= 0) {
            var mensaje = 'La cantidad debe ser mayor a 0.';
            $("#msjdeuda").html(mensaje);
            $('#btn_conf_prov').attr("disabled", true);
          } else {
            $("#msjdeuda").html("");
            $('#btn_conf_prov').attr("disabled", false);
          }
        }
      }
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
              $('#btn_conf_prov').attr("disabled", true);
          } else {
            document.getElementById('apertura_error').style.display = "none";
            document.getElementById('apertura_error').innerHTML = "";
          }
        }
      });
      /* FIN GAN-MS-B5-0448 GValverde */
    }

    function precio_total() {
      var disp_tienda = parseInt(document.getElementById("cant_tienda").value);
      var pre_ref = document.getElementById("precio_ref").value;
      var cantidad = parseInt(document.getElementById("cantidad").value);

      if (cantidad <= 0) {
        var mensaje = 'La cantidad debe ser mayor a 0.';
        $("#msjcantidad").html(mensaje);
        document.getElementById("msjcantidad").style.color = "red";
        document.getElementById("msjcantidad").style.fontSize = "12px";
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
          document.getElementById('pre_total').value = precio_total;
          $('#btn_add_prod').attr("disabled", false);
        }
      }

    }

    function validar_precio() {
      var pre_ref = document.getElementById("precio_ref").value;
      var cantidad = document.getElementById("cantidad").value;
      var precio_total = document.getElementById("pre_total").value;
      var descuento = (0, 2 * (pre_ref * cantidad) + (pre_ref * cantidad));

      if (precio_total < descuento) {
        $("#msjprecio").html("El precio a vender es muy bajo");
        document.getElementById("msjprecio").style.color = "red";
        document.getElementById("msjprecio").style.fontSize = "14px";
      } else {
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

    /* BSINKA, 29/06/2021, ECOGAN-MS-M4-033 */
    .text-medium,
    strong {
      font-weight: bold;
    }

    /* FIN BSINKA, 29/06/2021, ECOGAN-MS-M4-033 */
  </style>
  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Provisi&oacute;n</a></li>
          <li class="active">Compras</li>
        </ol>
      </div>
      <?php if ($this->session->flashdata('success')) { ?>
        <script>
          window.onload = function mensaje() {
            swal.fire(" ", "<?php echo $this->session->flashdata('success'); ?>", "success");
          }
        </script>
      <?php } else if ($this->session->flashdata('error')) { ?>
        <script>
          window.onload = function mensaje() {
            swal.fire(" ", "<?php echo $this->session->flashdata('error'); ?>", "error");
          }
        </script>
      <?php } ?>
      <div class="section-body">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
            <form class="form form-validate" novalidate="novalidate" name="form_provision" id="form_provision" method="post" action="<?= site_url() ?>provision/C_provision/add_compra" onsubmit="disableSubmitButton()">
              <div class="card">
                <div class="card-head style-primary">
                  <header>Registro de Compra </header>
                </div>
                <input type="hidden" name="count" id="count" value="0">
                <input type="hidden" name="provision" id="provision">
                <div class="card-body">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                      <div class="form-group floating-label">
                        <select class="form-control select2-list" id="proveedor" name="proveedor" required="" onchange="recupera()">
                          <option value=""></option>
                          <?php foreach ($proveedores as $prov) {  ?>
                            <option value="<?php echo $prov->id_personas ?>" <?php echo set_select('proveedor', $prov->id_personas) ?>> <?php echo $prov->proveedor ?></option>
                          <?php  } ?>
                        </select>
                        <label for="proveedor">Seleccione Proveedor</label>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                      <div class="form-group floating-label">
                        <select class="form-control select2-list" id="producto" name="producto" required="" onchange="recupera()">
                          <option value=""></option>
                          <?php foreach ($productos as $prod) {  ?>
                            <option value="<?php echo $prod->id_producto ?>" <?php echo set_select('producto', $prod->id_producto) ?>> <?php echo $prod->productos ?></option>
                          <?php } ?>
                        </select>
                        <label for="producto">Seleccione Producto</label>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="display: flex;">
                      <div class="form-group floating-label" id="c_codigo_mar">
                        <input type="number" class="form-control" name="cantidad" id="cantidad" min="1" onclick="unidades()" required="">
                        <label for="cantidad">Cantidad</label>

                        <div align="left" id="msjdeuda" style="color: #006400">En caso de que el producto a abastecer sea de venta por cantidades menores a la unidad, poner en la unidad mínima ejemplo mililitros, gramos,centimetros,etc</div>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                      <div id="cantidad1" style="color: #000000">
                        <div class="form-group floating-label" id="c_unidad">
                          <select class="form-control select2-list" name="id_unidad0" id="id_unidad0" onchange="dato_unidad();" required>
                            <?php foreach ($unidad as $uni) { ?>
                              <option value="<?php echo $uni->oidunidades ?>" <?php "Unidad" == $uni->ounidad ? print 'selected="selected"' : ''; ?>>
                                <?php echo $uni->ounidad ?>
                              </option>
                            <?php } ?>
                          </select>
                          <label for="unidad0">Unidad</label>
                        </div>
                        <input type="text" class="form-control" id="tipo_unidad" name="tipo_unidad" value="UNIDAD" style="color: #FA5600; display:none;"></input>
                      </div>
                    </div>

                  </div>

                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="display: flex;">
                      <div class="form-group floating-label" id="c_codigo_mar">
                        <input type="number" class="form-control" name="precio_compra" id="precio_compra" min="0" onchange="validarprecio()" required="" step=".01">
                        <label for="precio_compra">Precio Compra en Bs</label>
                      </div>
                      <div>
                        <h3>Bs</h3>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                      <div class="form-group floating-label" id="c_con_sin_iva">
                        <input type="checkbox" class="form-control" name="con_sin_iva" id="con_sin_iva" data-toggle="toggle" data-on="Con IVA" data-off="Sin IVA">
                        <input type="text" class="form-control" id="tipo_precio" name="tipo_precio" value="unidad" style="color: #FA5600; display:none;"></input>
                        <input type="hidden" id="iva" name="iva" value="false">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="display: flex;">
                      <div class="form-group floating-label" id="c_codigo_mar">
                        <input type="text" class="form-control" value="Precio general" name="descripcion" id="descripcion" disabled required="">
                        <label for="descripcion">Descripcion</label>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="display: flex;">
                      <div class="form-group floating-label" id="c_codigo_mar">
                        <input type="number" class="form-control" name="precio_venta" id="precio_venta" min="0.01" onchange="validarprecio()" required="" step=".01">
                        <label for="precio_venta">Precio Venta en Bs</label>
                        <div id="precioventa" style="color: #FA5600"></div>
                      </div>
                      <div>
                        <h3>Bs</h3>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="display: flex;">
                      <button type="button" class="btn btn-floating-action btn-success" id="agregarCampo1"><i class="fa fa-plus"></i></button>
                    </div>
                  </div>
                  
                  <div id="contenedor1"></div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                      <div class="form-group floating-label">
                        <select class="form-control select2-list" id="des_provision" name="des_provision" required="">
                          <option value=""></option>
                          <?php foreach ($destinos as $des) {  ?>
                            <option value="<?php echo $des->id_ubicacion_out ?>" <?php echo set_select('des_provision', $des->id_ubicacion_out) ?>> <?php echo $des->descripcion ?></option>
                          <?php  } ?>
                        </select>
                        <label for="des_provision">Seleccione Destino de Compra</label>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                      <div class="form-group form-floating">
                        <div class="input-group date" id="demo-date-val">
                          <div class="input-group-content" id="c_fecha_limite">
                            <input type="text" class="form-control" name="fecha_vencimiento" id="fecha_vencimiento" onchange="validar()" readonly="" required="">
                            <label for="fecha_vencimiento">Fecha de vencimiento</label>
                          </div>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="card-actionbar">
                  <div class="card-actionbar-row">
                    <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add_compra" value="add">Agregar producto(s) a la compra </button>
                    <!-- <button type="button" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add_añadir" onclick="añadir_fila(edit_listar_lote)" value="add">Añadir producto al lote</button> -->
                  </div>
                  <div class="card-actionbar-row">
                    <button type="button" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add_editar" onclick="editar_fila()" value="add">Editar producto de la compra </button>
                  </div>
                  <!-- Inicio ALKG 27/03/2023 GAN-DPR-M1-0373 -->
                  <div class="card-actionbar-row">
                    <!-- <button type="button" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add_editar" onclick="editar_fila(edit_lote)" value="add">Editar producto de la compra </button> -->
                  </div>
                  <!-- Fin ALKG 27/03/2023 GAN-DPR-M1-0373 -->
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
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width: 15%; text-align: center;">Acci&oacute;n</th>
                        <th>Nro Lote</th>
                        <th>Producto</th>
                        <th>Destino</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <!-- Inicio K.G Alcon , 09/02/2023, GAN-MS-B0-0247-->
                        <th>Precio de Compra Bs</th>
                        <th>Precio de Venta Bs</th>
                        <!-- Fin K.G Alcon , 09/02/2023, GAN-MS-B0-0247-->
                      </tr>
                    </thead>

                    <tbody>
                      <?php foreach ($lst_compras as $com) { ?>
                        <tr>
                          <!-- BSINKA, 29/06/2021, ECOGAN-MS-M4-033 -->
                          <?php if ($com->descripcion == 'TOTAL') { ?>
                            <td> </td>
                            <td> <strong class="text-primary-dark"> <?php echo $com->id_lote ?> </strong> </td>
                            <td> <strong class="text-primary-dark"> <?php echo $com->descripcion ?> </strong> </td>
                            <td> <strong class="text-primary-dark"> <?php echo $com->destino ?> </strong> </td>
                            <td> <strong class="text-primary-dark"> <?php echo $com->cantidad ?> </strong> </td>
                            <td> <strong class="text-primary-dark"> <?php echo $com->unidad ?> </strong> </td>
                            <!-- Inicio K.G Alcon , 09/02/2023, GAN-MS-B0-0247-->
                            <td style="text-align: left;"> <strong class="text-primary-dark"> <?php echo $com->precio ?> Bs </strong> </td>
                            <td style="text-align: left;"> <strong class="text-primary-dark"> <?php echo $com->precio_venta ?> Bs </strong> </td>
                            <!-- Fin K.G Alcon , 09/02/2023, GAN-MS-B0-0247-->
                          <?php } else { ?>
                            <td align="center">
                              <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_provision('<?php echo $com->id_provision ?>')"><i class="fa fa-trash-o"></i></button>
                              <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="editar_provision('<?php echo $com->id_provision ?>','<?php echo $com->id_lote ?>','<?php echo $com->destino ?>')"><i class="fa fa-pencil"></i></button>
                              <!-- <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" onclick="agregar_provision('<?php echo $com->id_provision ?>','<?php echo $com->id_lote ?>')"><i class="fa fa-plus"></i></button> -->
                            </td>
                            <!-- INICIO J.LUNA, 28/11/2022, GAN-MS-M6-0140 -->
                            <td><?php echo $com->id_lote ?></td>
                            <!-- FIN J.LUNA, 28/11/2022, GAN-MS-M6-0140 -->
                            <!-- PBeltran, 27/09/2022, GAN-MS-A1-0006 -->
                            <td><?php if ($com->precio == '0') {
                                  echo ($com->descripcion . "  (<b style='color:green;'>Bonificación</b>)");
                                } else {
                                  echo $com->descripcion;
                                } ?></td>
                            <!-- FIN PBeltran, 27/09/2022, GAN-MS-A1-0006 -->
                            <td><?php echo $com->destino ?></td>
                            <td><?php echo $com->cantidad ?></td>
                            <td><?php echo $com->unidad ?></td>
                            <td style="text-align: left;"><?php echo $com->precio ?> Bs</td>
                            <td style="text-align: left;"><?php echo $com->precio_venta ?> Bs</td>
                          <?php } ?>
                          <!-- FIN BSINKA, 29/06/2021, ECOGAN-MS-M4-033 -->
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <!-- BEGIN HORIZONTAL FORM -->
                  <!-- BSINKA, 29/06/2021, ECOGAN-MS-M4-033 -->
                  <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">
                      <form class="form-horizontal form-validate" novalidate="novalidate" name="conf_provision" id="conf_provision" method="post" action="<?= site_url() ?>provision/C_provision/confirmar_provision">
                        <input type="hidden" name="monto_total" id="monto_total" value="<?php echo $monto_total ?>">
                        <div class="row">
                          <div class="col-sm-9">
                            <div class="form-group">
                              <label for="Firstname5" class="col-sm-2 control-label">Forma de Pago:</label>
                              <div class="col-sm-10">
                                <label class="radio-inline radio-styled">&nbsp;
                                  <!-- Inicio K.G Alcon , 09/02/2023, GAN-MS-B0-0247-->
                                  <input type="radio" name="forma_pago" id="forma_pago" value="total" onchange="pago()" checked=""><span>Total(Al Contado)</span>
                                  <!-- Fin K.G Alcon , 09/02/2023,GAN-MS-B0-0247 -->
                                </label>
                                <label class="radio-inline radio-styled">
                                  <input type="radio" name="forma_pago" id="forma_pago" value="parcial" onchange="pago()"><span>Parcial</span>
                                </label>
                                <!--Ayrton Guevara M. 26/04/2023 GAN-MS-B1-0437-->
                                <label class="radio-inline radio-styled">
                                  <input type="radio" name="forma_pago" id="forma_pago" value="consignacion" onchange="pago()"><span>En Consignaci&oacute;n</span>
                                </label>
                                <!--Fin Ayrton Guevara M. 26/04/2023 GAN-MS-B1-0437-->
                                <label class="radio-inline radio-styled">
                                  <input type="radio" name="forma_pago" id="forma_pago" value="deuda" onchange="pago()"><span>A Deuda   </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="Lastname5" class="col-sm-5 control-label">Cantidad a Cuenta:</label>
                              <div class="col-sm-7">
                                <div class="input-group">
                                  <div class="input-group-content">
                                    <input type="number" class="form-control" id="monto_deuda" name="monto_deuda" onchange="deuda()" disabled="">
                                    <div class="form-control-line"></div>
                                  </div>
                                  <span class="input-group-addon">Bs.</span>
                                </div>
                                <div id="msjdeuda" style="color: #f44336"></div>
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="row">
                          <!-- /* GAN-MS-B5-0448 GValverde */ -->
                          <div class="alert alert-danger" id="apertura_error" style="display: none;"></div>
                          <!-- /* FIN GAN-MS-B5-0448 GValverde */ -->
                        </div>
                        <div class="row" style="text-align: right; border-top: 0; padding-top: 20px">
                          <div class="col-lg-12">
                            <button type="submit" class="btn ink-reaction btn-raised btn-primary" name="btn" id="btn_conf_prov" value="conf">Confirmar Provisi&oacute;n</button>
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
  <!-- END CONTENT -->
  <!--INICIO:::GAN-MS-B1-0276-->
  <script>
    document.cookie = "id_lote_cookie = ;";
    // document.cookie = "id_listar_lote";
    var edit_lote = '';
    var edit_prov = '';
    var botonComp = document.getElementById("btn_add_añadir");
    botonComp.style.display = "none";
    var boton = document.getElementById("btn_add_editar");
    boton.style.display = "none";

    function disableSubmitButton() {
      var submitButton = document.getElementById("btn_add_compra");
      var form = document.getElementById("form_provision");
      if (form.checkValidity() && !submitButton.disabled) {
        submitButton.disabled = true;
        return true;
      } else {
        return false;
      }
    }
  </script>
  <!--FIN:::GAN-MS-B1-0276-->
  <script>
    $(function() {
      $('#con_sin_iva').change(function() {
        if ($(this).prop('checked')) {
          $("#iva").val('true');
        } else {
          $("#iva").val('false');
        }
      })
    })

    function validar() {
      var f = new Date();
      fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
      var anio = f.getFullYear();
      var mes = (f.getMonth() + 1);
      var dia = f.getDate();
      var fec = document.getElementById("fecha_vencimiento").value;
      fec = fec.split("/");
      if (parseInt(fec[0], 10) < anio) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'La fecha de vencimiento no puede ser una fecha pasada',
        })
        $('[name="fecha_vencimiento"]').val(fecha_actual);
      } 
      //GAN-MS-B4-0563 26/07/2023 NVera.
      else if (parseInt(fec[0], 10) == anio && parseInt(fec[1], 10) < mes) { 
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'La fecha de vencimiento no puede ser una fecha pasada',
        })
        $('[name="fecha_vencimiento"]').val(fecha_actual);
      } 
      else if (parseInt(fec[0], 10) == anio && parseInt(fec[1], 10) == mes && parseInt(fec[2], 10) < dia) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'La fecha de vencimiento no puede ser una fecha pasada',
        })
        $('[name="fecha_vencimiento"]').val(fecha_actual);
      }
      //Fin GAN-MS-B4-0563 26/07/2023 NVera.
    }

    function validarprecio() {

      precio_compra = document.getElementById("precio_compra").value;
      precio_venta = document.getElementById("precio_venta").value;

      if (precio_compra > precio_venta) {

        var mensaje = 'El precio de venta es menor al precio de compra.';
        $("#precioventa").html(mensaje);

      } else {

        $("#precioventa").html('');
      }

    }

    function dato_unidad() {
      var lista = document.getElementById("id_unidad0");
      var texto = lista.options[lista.selectedIndex].text;
      var isChecked = $('#miCheckbox').prop('checked');
      if (texto != 'Unidad') {
        var mensaje = 'lote';
        $("#tipo_precio").html(mensaje);
        $("#tipo_precio").val(mensaje);
        $("#tipo_unidad").val(texto);

      } else {
        //console.log(texto);
        var mensaje = 'unidad';
        var unidad = 'UNIDAD'
        // $("#tipo_precio").html(cheked);  //esto esta modificado pero revizar
        $('#tipo_precio').html(isChecked);
        $("#tipo_precio").val(mensaje);
        $("#tipo_unidad").val(unidad);
      }
    }

    function unidades() {
      /*
      const radios = document.getElementsByName('tipo_precio');
      for (var i = 0; i <  radios.length; i++) {
          if (radios[i].checked) {
          var mensaje =  '(' + radios[i].value + ')';
          
          $("#cantidad1").html(mensaje);
          break;
          }
       }
       */
    }

    function recupera() {
      var prov = document.getElementById("proveedor").value;
      var prod = document.getElementById("producto").value;
      if (prod != "") {
        //console.log(prov+"-"+prod);
        $.ajax({
          url: "<?php echo site_url('provision/C_provision/recuperar_precio') ?>",
          type: "POST",
          data: {
            prov: prov,
            prod: prod
          },
          success: function(data) {
            var obj = JSON.parse(data);
            var valores = obj[0].fn_recuperar_precio_abastecimiento;

            var val = JSON.parse(valores);

            //$('#precio_compra').val(val['precio_compra']).trigger('change');
            //$('#precio_venta').val(val['precio_venta']).trigger('change');
            $('#precio_compra').val(parseFloat(val['precio_compra'])).trigger('change');
            $('#precio_venta').val(parseFloat(val['precio_venta'])).trigger('change');

          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
          }
        });
      }
    }

    function eliminar_provision(id_prov) {
      BootstrapDialog.show({
        title: 'ELIMINAR PROVISION',
        message: '<div>Esta seguro que desea <b>eliminar</b> el <b>producto</b> del abastecimiento</div>',
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialog) {
            var $button = this;
            $button.disable();
            window.location = '<?= base_url() ?>provision/C_provision/dlt_provision/' + id_prov;
          }
        }, {
          label: 'Cancelar',
          action: function(dialog) {
            dialog.close();
          }
        }]
      });
    }

    function editar_provision(id_prov, id_lote, destino) {
      var boton = document.getElementById("btn_add_editar");
      boton.style.display = "block";
      var botonComp = document.getElementById("btn_add_compra");
      botonComp.style.display = "none";
      editar(id_lote, id_prov);
    }
    //Inicio ALKG 27/03/2023 GAN-DPR-M1-0373
    function getCookie(cname) {
      let name = cname + "=";
      let ca = document.cookie.split(';');
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    document.cookie = "id_lote_cookie";
    // document.cookie = "id_ubicacion_ubi";
    // var edit_lote = getCookie("id_lote_cookie");
    // var edit_ubi = document.cookie.split(';').find(cookie => cookie.trim().startsWith('id_ubicacion_ubi=')).split('=')[1];
    // if (edit_lote != "" && edit_ubi!= "") {
    //   console.log("si esta funcionando el id:"+edit_lote);
    //   console.log("si esta funcionando el id:"+edit_ubi);
    //   editar(edit_lote,edit_ubi);
    // }else {var boton = document.getElementById("btn_add_editar");
    //       boton.style.display = "none";}

    // if (document.cookie.indexOf("id_lote_cookie=") >= 0 && document.cookie.split('=')[1].length > 0){  
    // var edit_lote = document.cookie.split(';').find(cookie => cookie.trim().startsWith('id_lote_cookie=')).split('=')[1];
    // var edit_ubi = document.cookie.split(';').find(cookie => cookie.trim().startsWith('id_ubicacion_ubi=')).split('=')[1];
    // // console.log("si esta funcionando el id:"+edit_lote);
    // editar(edit_lote,edit_ubi);
    // }
    // document.cookie = "id_lote_cookie = ;";
    // document.cookie = "id_ubicacion_ubi = ;";
    var boton = document.getElementById("btn_add_editar");
    boton.style.display = "none";

    //Inicio KGAL GAN-MS-M4-0391
    function editar(id_lote, id_prov) {
      var edit_lote = id_lote;
      var edit_prov = id_prov;
      document.cookie = "id_lote_cookie=" + edit_lote;
      Swal.fire({
        icon: 'warning',
        title: "Recuerde que el precio de compra y venta funciona internamente,y que la fecha no puede ser una pasada",
        showDenyButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ACEPTAR',
        denyButtonText: 'CANCELAR',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?php echo site_url('provision/C_provision/get_edit') ?>" + '/' + id_lote + '/' + id_prov,
            type: "POST",
            success: function(data) {
              var obj = JSON.parse(data);
              console.log(obj);
              $('#provision').val(obj[0].id_provision).trigger('change');
              $('#proveedor').val(obj[0].id_persona).trigger('change');
              $('#producto').val(obj[0].id_producto).trigger('change');
              $('#cantidad').val(obj[0].cantidad).trigger('change');
              $('#id_unidad0').val(obj[0].id_unidad).trigger('change');
              // $('#precio_compra').val(obj[0].precio_compra).trigger('change');
              // $('#precio_venta').val(obj[0].precio_venta).trigger('change');
              $('#des_provision').val(obj[0].id_ubicacion).trigger('change');
              var fechaActual = $.datepicker.formatDate('dd/mm/yy', new Date());
              //GAN-MS-B4-0563 26/07/2023 NVera.
              /* $('#fecha_vencimiento').val(fechaActual).trigger('change'); */
              $('#fecha_vencimiento').val(obj[0].fecha_vencimiento).trigger('change');
              //Fin GAN-MS-B4-0563 26/07/2023 NVera.
              var boton = document.getElementById("btn_add_compra");
              boton.style.display = "none";
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error al obtener datos de ajax');
            }
          });
        } else {
          var botonEdit = document.getElementById("btn_add_editar");
          botonEdit.style.display = "none";
          var boton = document.getElementById("btn_add_compra");
          boton.style.display = "Block";
        }
      });
    }

    function editar_fila() {
      var edit_lote2 = getCookie("id_lote_cookie");
      var botonEdit = document.getElementById("btn_add_compra");
      botonEdit.style.display = "none";
      if ($('#form_provision').valid()) {
        var formData = new FormData($('#form_provision')[0]);
        $.ajax({
          type: "POST",
          url: "<?= base_url() ?>provision/C_provision/editar/" + edit_lote2,
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function(resp) {
            console.log(resp);
            console.log(JSON.parse(resp));
            var c = JSON.parse(resp);
            if (c[0].oboolean == 't') {
              Swal.fire({
                icon: 'success',
                text: ' SE MODIFICO EXITOSAMENTE',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR'
              }).then(function(result) {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: c[0].omensaje,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ACEPTAR',
              })
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
          }
        });
      }
      var botonEdit = document.getElementById("btn_add_compra");
      botonComp.style.display = "block";
      var botonEdit = document.getElementById("btn_add_editar");
      botonEdit.style.display = "none";
      document.cookie = "id_lote_cookie = ;";
    }

    var edit_listar_lote = getCookie("id_listar_lote");
    var edito = edit_listar_lote;
    console.log("este es el lote antes de que:" + edit_listar_lote);
    console.log("este es el editar:" + edito);

    // if(edito !== ""){
    //   console.log("Si esta llegando el lote de listar:"+edito);
    //   document.cookie = "id_listar_lote = ;";
    //   var botonEdit = document.getElementById("btn_add_añadir");
    //   botonEdit.style.display = "block";
    //   var boton = document.getElementById("btn_add_editar");
    //   boton.style.display = "none";
    //   var botonComp = document.getElementById("btn_add_compra");
    //   botonComp.style.display = "none";
    // }

    // function añadir_fila(edit_listar_lote = getCookie("id_listar_lote")){
    //   console.log("si entro el edito en añadir_fila:"+edit_listar_lote);
    //   var formData = new FormData($('#form_provision')[0]);   
    //   if ($('#form_provision').valid()) {
    //     $.ajax({
    //       type: "POST",
    //       url: "<?= base_url() ?>provision/C_provision/agregar_compra2/" + edit_listar_lote,
    //       data: formData,
    //       cache: false,
    //       contentType: false,
    //       processData: false,
    //       success: function(resp) {
    //         console.log(resp);
    //         console.log(JSON.parse(resp));
    //         var c = JSON.parse(resp);
    //         if (c[0].oboolean == 't') {
    //           Swal.fire({
    //             icon: 'success',
    //             text: ' SE AÑADIO EXITOSAMENTE',
    //             confirmButtonColor: '#3085d6',
    //             confirmButtonText: 'ACEPTAR'
    //           }).then(function(result) {
    //             location.reload();
    //           });
    //         } else {
    //           Swal.fire({
    //             icon: 'error',
    //             title: 'Oops.... comuniquese con el administrador',
    //             text: c[0].omensaje,
    //             confirmButtonColor: '#d33',
    //             confirmButtonText: 'ACEPTAR'
    //           })
    //         }
    //       },
    //       error: function(jqXHR, textStatus, errorThrown) {
    //         alert('Error al obtener datos de ajax');
    //       }
    //     });
    //   }
    //   // edito = "";
    // }

    // function agregar_provision(id_prov,id_lote){
    //   document.cookie = "id_listar_lote=" + id_lote;
    //   var edit_listar_lote = getCookie("id_listar_lote");
    //   var edito = edit_listar_lote;
    //   console.log("Si esta guardando el lote en agregar provicion:"+edito);
    //   var botonEdit = document.getElementById("btn_add_añadir");
    //   botonEdit.style.display = "block";
    //   var botonComp = document.getElementById("btn_add_compra");
    //   botonComp.style.display = "none";
    // }
    //FIN ALKG 27/03/2023 GAN-DPR-M1-0373
    //FIN KGAL 05/04/2023 GAN-MS-M4-0391
  </script>
<?php } else {
  redirect('inicio');
} ?>