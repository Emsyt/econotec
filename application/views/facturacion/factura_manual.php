<?php
/*
      Creador: Alison Paola Pari Fecha:07/06/2022, facturacion
      Descripcion:Se creo y modifico la vista factura_manual a semejanza de la vista V_pedido_codigo 
      para realizar el registro de facturas manuales y almacenar el xml generado
      ------------------------------------------------------------------------------
      Modificacion: Alison Paola Pari Fecha:14/07/2022, GAN-MS-A1-308
      Descripcion: Se realizo la funcionalidad del registro de factura manual de acuerdo al evento
      selecionado
  
  */
?>

<style>
  #finalizar_venta .modal-dialog {
    -webkit-transform: translate(0, -50%);
    -o-transform: translate(0, -50%);
    transform: translate(0, -50%);
    top: 50%;
    margin: 0 auto;
  }
</style>
<script>
  var cont_pedido = $("#contador").val();
  $(document).ready(function() {
    activarMenu('menu17', 5);
    let username = getCookie("Cliente");
    if (username != null) {
      document.getElementById("nit").value = username;
      valor_nit = document.getElementById("nit").value;
      if (valor_nit != "" && valor_nit != null) {
        agregar_nombre();
      }
    }
    var metodo_pago = '<?php echo $metodo_pago ?>';
    console.log(metodo_pago)


  });
</script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
  ;
  jQuery.noConflict();
  (function($) {
    $(document).ready(function(e) {
      var baseForm = $("#base_form");
      baseForm.on("keydown", "#id_producto", function(evt) {
        var charCode = evt.keyCode || e.which;
        if (charCode == 9 || charCode == 13) {
          evt.preventDefault();
          baseForm.submit();
        }
      });
    });
  })(jQuery);
</script>
<script>
  function enviar(destino) {
    document.conf_pedido.action = destino;
    document.conf_pedido.submit();
  }
  $('#finalizar_venta').on('hidden.bs.modal', function() {
    window.location.reload(true);
  })
</script>
<style>
  hr {
    margin-top: 0px;
  }

  .select2-container .select2-choice>.select2-chosen {
    white-space: normal;
  }

  .novedades i {
    background-color: #ffffff;
    border-color: #ffffff;
    color: #eb0038;
    text-align: center;
    line-height: 50px;

  }

  .formulario {
    display: block;
    width: 80%;
    height: 35px;
    padding: 4.5px 14px;
    font-size: 13px;
    line-height: 1.846153846;
    color: #0c0c0c;
    background-color: #ffffff;
    background-image: none;
    border: 2px solid rgba(12, 12, 12, 0.12);
    border-radius: 2px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    border-color: #eb0038;

  }
</style>

<!-- BEGIN CONTENT-->
<div id="content">
  <section>
    <div class="section-header">
      <ol class="breadcrumb">
        <li><a href="#">Venta</a></li>
        <li class="active">Venta R&aacute;pida</li>
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
            <div class="card-body style-default-bright">
            <div class="row" style="width: 1200px;">
              <label>Documento &nbsp;&nbsp;&nbsp;&nbsp;</label>
              <label>CI/NIT/Cod. Cliente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <label id="l_complemento" style="display: inline-block;">Complemento &nbsp;&nbsp;</label>
              <label>Nombre/Razon Social</label></br>
              <!-- cambiandode de number a text-->
              <div class="row">
                <div class="col-md-1">
                  <select class="form-control select2-list" id="docs_identidad" name="docs_identidad" style="width: 70px;" onchange="tipo_doc()" required>
                    <?php foreach ($docs_identidad as $doc) {  ?>
                      <option value="<?php echo $doc->codigo ?>"> <?php echo $doc->descripcion ?></option>
                    <?php  } ?>
                  </select>
                </div>

                <input type="hidden" name="codigoExcepcion" id="codigoExcepcion" value="0">
                <input type="text" name="nit" id="nit" onkeypress="comprobar_documento()" style="border:1px solid #c7254e; margin-right: 10px;">
                <input type="text" name="complemento" id="complemento" style="border:1px solid #c7254e; width: 75px; display: inline-block; margin-right: 15px;">
                <input name="razonSocial" id="razonSocial" type="text" onkeypress="onkeypress_nit_razonSocial()" style="border:1px solid #c7254e; width: 30%;"> <button data-toggle="modal" data-target="#finalizar_venta">...</button></br>

              </div>
              <label for="evento">Seleccione el evento significativo</label>
                <select class="form-control select2-list" id="evento" name="evento" required style="border:1px solid #c7254e;width:80%;">
                    <?php foreach ($eventos as $evt) {  ?>
                        <option value="<?php echo $evt->id_evento ?>" <?php echo set_select('evento', $evt->id_evento) ?>>
                            <?php echo $evt->evento ?></option>
                    <?php  } ?>
                </select>
              </br>
              </div>
              </br>
              <div class="table-responsive">
                <table id="datatable3" class="table table-striped table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Cantidad</th>
                      <th>Precio Unidad</th>
                      <th>Precio Total</th>
                      <th>Acci&oacute;n</th>
                    </tr>
                  </thead>
                  <tr>
                    <td>
                      <form method="post" id="base_form" onsubmit=" return listar(this);">
                        <input type="text" class="formulario" size="1" style="width : 200px" maxlength="50" name="id_producto" id="id_producto">
                      </form>
                    </td>
                    <td style="width: 30%">
                      <form method="post" id="form_nombre" onsubmit=" return listar1(this);">
                        <input type="text" class="formulario" size="1" style="width : 400px" maxlength="5000" name="nombre_producto" id="nombre_producto" onkeydown="onkeydown_nombre_producto()">
                      </form>
                    </td>
                    <td style="width: 5%">1</td>
                    <td style="width: 10%"></td>
                    <td style="width: 10%"></td>
                    <td style="width: 16%" align="center"></td>
                  </tr>
                  <tbody id="con">
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="5" style="text-align: right;">
                        <font size=4>Total</font>
                      </th>
                      <th style="text-align: right;" size=4>

                        <font id="total" size=4><?php echo $total ?></font>
                        <input type="hidden" id="total_venta" name="total_venta">
                      </th>
                    </tr>
                    <tr>
                      <th colspan="5" style="text-align: right;">
                        <font size=4>Descuento</font>
                      </th>
                      <th style="text-align: right;" size=4>
                        <input type="number" style="text-align: right; font-size: 18px;  width: 100%;" id="descuento" name="descuento" min="0.00" onkeydown="validadesc()" value="0.00">
                      </th>
                    </tr>
                    <tr id="tr_gifcard" style="display: none;">
                      <th colspan="5" style="text-align: right;">
                        <font size=4>Monto Giftcard</font>
                      </th>
                      <th style="text-align: right;">
                        <input type="number" style="text-align: right; font-size: 18px;  width: 100%;" id="gifcar" name="gifcar" value="0.00" onkeydown="calcular_cambio()">
                      </th>
                    </tr>
                    <tr id="tr_tarjeta" style="display: none;">
                      <th colspan="5" style="text-align: right;">
                        <font size=4>Numero Tarjeta</font>
                      </th>
                      <th style="text-align: right;">
                        <input type="number" style="text-align: right; font-size: 18px;  width: 100%;" id="nro_tarjeta" name="tarjeta" onchange="verificar_tarjeta()">
                      </th>
                    </tr>
                    <tr id="tr_tarjeta2" style="display: none;">
                      <th colspan="5" style="text-align: right;">
                        <font size=4>Monto Tarjeta</font>
                      </th>
                      <th style="text-align: right;">
                        <input type="number" style="text-align: right; font-size: 18px;  width: 100%;" id="monto_tarjeta" name="monto_tarjeta" value="0.00" onkeydown="calcular_cambio()">
                      </th>
                    </tr>
                    <tr id="tr_otros" style="display: none;">
                      <th colspan="5" style="text-align: right;">
                        <font size=4>Monto otros</font>
                      </th>
                      <th style="text-align: right;">
                        <input type="number" style="text-align: right; font-size: 18px;  width: 100%;" id="monto_otros" name="monto_otros" value="0.00" onkeydown="calcular_cambio()">
                      </th>
                    </tr>
                    <tr id="tr_efectivo" style="display: table-row;">
                      <th colspan="5" style="text-align: right;">
                        <font size=4>Efectivo</font>
                      </th>
                      <td>
                        <!-- <form id="miForm" onsubmit="return myFunction(this)"> -->
                        <input type="number" name="pagado" id="pagado" style="text-align: right; font-size: 18px;  width: 100%;" value="0.00" onkeydown="calcular_cambio()">
                        <!-- </form> -->
                      </td>
                    </tr>
                    <tr id="tr_tasa" style="display: none;">
                      <th colspan="5" style="text-align: right;">
                        <font size=4>Monto Tasa</font>
                      </th>
                      <th style="text-align: right;">
                        <input type="number" style="text-align: right; font-size: 18px;  width: 100%;" id="monto_tasa" name="monto_tasa" value="0.00">
                      </th>
                    </tr>
                    <tr>
                      <th colspan="5" style="text-align: right;">
                      </th>
                      <td>
                        <div style="margin-top: 10px;">
                          <input type="checkbox" id="efectivo" name="contact" value="efectivo" title="Al contado" onclick="mostrar_tr()" checked>
                          <label for="efectivo" title="Al contado"><i style="color: #006400; " class="fa fa-money fa-2x"></i></label>&nbsp;&nbsp;

                          <input type="checkbox" id="tarjeta" name="contact" value="tarjeta" title="Con tarjeta" onclick="mostrar_tr()">
                          <label for="tarjeta" title="Con tarjeta "><i style="color: #000000; " class="fa fa-credit-card fa-2x"></i></label>&nbsp;&nbsp;


                          <input type="checkbox" id="tarQR" name="contact" value="tarQR" title="Con codigoQR" onclick="mostrar_tr()">
                          <label for="tarQR" title="Con codigoQR"><i style="color: #000000; " class="fa fa-qrcode fa-2x"></i></label>
                          </br>

                          <input type="checkbox" id="tareg" name="contact" value="tareg" title="Con giftcard" onclick="mostrar_tr()">
                          <label for="tareg" title="Con giftcard "><i style="color: #000000; " class="glyphicon glyphicon-gift fa-2x"></i></label>&nbsp;&nbsp;

                          <input type="checkbox" id="deuda" name="contact" value="deuda" title="A deuda" onclick="mostrar_tr()">
                          <label for="deuda" title="A deuda">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">

                              <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z" />
                            </svg>
                          </label></br>
                        </div>
                        <div class="form form-group">
                          <select class="form-control select2-list" id="tipo_documento" name="tipo_documento" onclick="mostrar_tr1()" required>
                            <?php foreach ($metodo_pago as $met) {  ?>
                              <option value="<?php echo $met->oidtipo ?>"> <?php echo $met->otipo ?></option>
                            <?php  } ?>
                          </select>
                        </div>


                      </td>
                    </tr>

                    <tr>
                      <th colspan="5" style="text-align: right;">
                        <font id="cam" size=4>Cambio</font>
                      </th>
                      <th style="text-align: right;">
                        <font id="cambio" name="cambio" size=4></font>
                        <input type="hidden" id="cambio_venta" name="cambio_venta">
                      </th>
                    </tr>

                    </tfoot-->
                </table>
                <div class="modal-footer">
                  <button type="onclick" id="btnFinalizar" class="btn btn-primary " onclick="finalizar_venta();">Finalizar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ver Imagen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center>
          <output id="verImagen"></output>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="finalizar_venta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width:450px;">
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <h3 class="modal-title">TIPO DE FACTURA!!</h3>
        </center>
      </div>
      <div class="modal-body">
        <center>
          <img src="<?= base_url() ?>assets/img/icoLogo/imp.png" width="100px" height="100px" alt="Avatar" class="image"><br><br>
          <font size="3">NO olvide imprimir la factura!!!</font>
        </center>
      </div>
      <div class="modal-footer">
        <center>
          <form class="form" name="conf_pedido" id="conf_pedido" method="post" target="_blank" action="<?= site_url() ?>generar_venta_codigo_manual">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <select class="form-control select2-list" id="tipofactura" name="tipofactura" onchange="mostrar_tasa()" required>
                  <option value="1">FACTURA COMPRA-VENTA</option>
                  <option value="41">FACTURA COMPRA VENTA TASAS</option>
                </select>
                <output id="idventa"></output>
                <div id="valores" style="display: none;">
                  <input type="text" name="rsocial" id="rsocial">
                  <input type="text" name="complement" id="complement">
                  <input type="text" name="id_venta_pdf" id="id_venta_pdf">
                  <input type="text" name="pagado_pdf" id="pagado_pdf">
                  <input type="text" name="descuento_pdf" id="descuento_pdf">
                  <input type="text" name="giftc_pdf" id="giftc_pdf">
                  <input type="text" name="cuf" id="cuf">
                  <input type="text" name="fechaEnvio" id="fechaEnvio">
                  <input type="text" name="monto_tasa_pdf" id="monto_tasa_pdf">
                </div>
              </div>
              <div style="display: none;">
                <button type="button" class="btn ink-reaction btn-raised btn-primary" onclick="enviar()">Si</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="finalizar_compra()">Salir</button>
              </div>
            </div>
          </form>
        </center>
      </div>
    </div>
  </div>
</div>




<script>
  //Script movimiento entre inputs con flechas direccionales
  //para habilitar añadir al input objetivo el valor class="move"
  $(document).ready(function() {
    $(document).keydown(
      function(e) {
        if (e.keyCode == 39) {
          console.log("39");
          $(".move:focus").next().focus();
        }
        if (e.keyCode == 37) {
          $(".move:focus").prev().focus();
          console.log("37");
        }
      }
    );
  });
  //fin de script 
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

  function eliminar(id_venta) {
    $.ajax({
      url: "<?php echo site_url('facturacion/C_factura_manual/dlt_pedido') ?>",
      type: "POST",
      data: {
        buscar: id_venta
      },
      success: function(respuesta) {
        if (respuesta) {
          $.ajax({
            url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_produc') ?>",
            type: "POST",
            success: function(respuesta) {
              var json = JSON.parse(respuesta);
              con.innerHTML = '';
              let total = 0.000;
              for (var i = 0; i < json.length; i++) {
                let num = parseFloat(json[i].oprecio);
                total = total + num;
                var id = json[i].oidventa;
                var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                con.innerHTML = con.innerHTML +
                  '<tr>' +
                  '<td>' + json[i].ocodigo + '</td>' +
                  '<td>' + json[i].onombre + '</td>' +
                  '<td>' +
                  '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                  '</td>' +
                  '</td>' +
                  '<td>' +
                  '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                  '</td>' +
                  '<td>' +
                  '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                  '</td>' +
                  '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                  '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
                  '<td style="width: 10%" align="center">' +
                  '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
                  '<label>&nbsp;&nbsp;&nbsp;</label>' +
                  '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                  '</td>' +
                  '</form>' +
                  '</tr>'
              }
              total = total.toFixed(2);
              $("#total").html(total);
              $('#total_venta').val(total).trigger('change');
              $('#pagado').val("0.00").trigger('change');
              $('#cambio_venta').val("").trigger('change');
              $("#cambio").html("");
              const inpPassword = document.getElementById('id_producto');
              inpPassword.focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error al obtener datos de ajax');
            }
          });
        } else {
          alert(respuesta.omensaje);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }
</script>
<script>
  function enviar() {
    var id_venta = document.getElementById('id_venta2').value;
    var pagado = document.getElementById('pagado2').value;
    var cambio = document.getElementById('cambio_venta').value;
    var gifcar = document.getElementById('giftc').value;
    var tipofactura = document.getElementById('tipofactura').value;
    console.log(id_venta, pagado, tipofactura);
    $.ajax({
      url: '<?= base_url() ?>facturacion/C_factura_manual/registrar_factura',
      type: "POST",
      dataType: "JSON",
      data: {
        id_venta: id_venta,
        pagado: pagado,
        tipofactura: tipofactura,
        gifcar: gifcar,
        cambio: cambio,
      },
      success: function(respuesta) {

        console.log(respuesta);

        resources = JSON.parse(respuesta.resources);
        fechaEnvio = resources.fechaEnvio;
        cuf = resources.cuf;

        transaccion = respuesta.transaccion;
        if (transaccion) {
          Swal.fire({
            icon: 'success',
            title: 'PENDIENTE',
            text: 'La Factura se guardo correctamente',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ACEPTAR',
          }).then((result) => {
            $('#fechaEnvio').val(fechaEnvio).trigger('change');
            $('#cuf').val(cuf).trigger('change');
            document.getElementById("conf_pedido").submit();
          })
        } else {
          data = JSON.parse(respuesta.respons);
          var resp = data.RespuestaServicioFacturacion.transaccion;
          console.log(resp);
          if (resp == false) {
            Swal.fire({
              icon: 'warning',
              title: data.RespuestaServicioFacturacion.codigoDescripcion,
              text: data.RespuestaServicioFacturacion.mensajesList.descripcion + ', reintentar?',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'ACEPTAR',
            }).then((result) => {
              enviar();
            })
          } else {
            Swal.fire({
              icon: 'success',
              title: data.RespuestaServicioFacturacion.codigoDescripcion,
              text: 'La Factura se envío correctamente',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'ACEPTAR',
            }).then((result) => {
              $('#fechaEnvio').val(fechaEnvio).trigger('change');
              $('#cuf').val(cuf).trigger('change');
              document.getElementById("conf_pedido").submit();
              location.href = "<?php echo base_url(); ?>pedidoCodigo";
            })
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
    //document.getElementById("conf_pedido").submit();
    document.cookie = "Cliente = ;";
    //window.location.reload();
  }

  function finalizar_compra() {
    document.cookie = "Cliente = ;";
    window.location.reload();
  }
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--js para la funccion final-->
<script>
  function finalizar() {
    razonSocial = document.getElementById("razonSocial").value.trim();
    valor_nit = document.getElementById("nit").value;
    dato = document.getElementById("pagado").value;
    dato2 = document.getElementById("gifcar").value;
    total = document.getElementById("total_venta").value;
    cambio = document.getElementById("cambio_venta").value;
    descuento = document.getElementById("descuento").value;
    var tipo = "";
    var id_tipo;
    var total2;
    if ($("#efectivo").is(':checked')) {
      tipo = "Contado";
    } else if ($("#tarjeta").is(':checked')) {
      tipo = "Tarjeta";
    } else if ($("#tareg").is(':checked')) {
      tipo = "Tarjeta";
    } else {
      tipo = "A Deuda";
    }
    if (tipo == "Tarjeta" || tipo == "Contado") {
      total2 = parseFloat(dato, 10) + parseFloat(dato2, 10) - parseFloat(cambio, 10);
      total2 = total2 + parseFloat(descuento, 10);
    } else {
      total2 = parseFloat(dato, 10) + parseFloat(cambio, 10);
      total2 = total2 - parseFloat(descuento, 10);
    }
    total2 = total2.toFixed(2);
    console.log(total2 + "-" + total);
    if (total2 != total) {
      Swal.fire({
        icon: 'error',
        title: 'Sucedio un error',
        text: 'Se realizó un cambio inesperado en el monto pagado o en el descuento. Vuelva a realizar el cálculo, por favor',
        confirmButtonColor: '#d33',
        confirmButtonText: 'ACEPTAR'
      });
    } else {
      if (tipo == "A Deuda" && ((valor_nit == "" || valor_nit == null || valor_nit == " ") || (razonSocial == "" || razonSocial == null || razonSocial == " "))) {
        Swal.fire({
          icon: 'error',
          title: 'Sucedio un error',
          text: 'No se puede finalizar sin CI/NIT/Cod. Cliente o Nombre/Razon Social',
          confirmButtonColor: '#d33',
          confirmButtonText: 'ACEPTAR'
        });
      } else {
        if ((valor_nit !== "" && razonSocial === "")) {

          Swal.fire({
            icon: 'error',
            title: 'Sucedio un error',
            text: 'Los datos del cliente deben estar completos o vacios',
            confirmButtonColor: '#d33',
            confirmButtonText: 'ACEPTAR'
          });
        } else {
          var newMessage = "";
          if (descuento <= total) {
            $.ajax({
              url: "<?php echo site_url('facturacion/C_factura_manual/verifica_cliente') ?>",
              type: "POST",
              data: {
                valor_nit: valor_nit
              },
              success: function(result) {
                var r = JSON.parse(result);
                r = r[0]["fn_verifica_cliente"];
                if ((r == "f") && (razonSocial !== "")) {
                  $.ajax({
                    url: "<?php echo site_url('facturacion/C_factura_manual/registrar') ?>",
                    type: "POST",
                    data: {
                      valor_nit: valor_nit,
                      razonSocial: razonSocial
                    },
                    success: function(reg) {
                      var res = JSON.parse(reg);
                      if (res[0]["oboolean"] == "f") {
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: res[0]["omensaje"],
                          confirmButtonColor: '#d33',
                          confirmButtonText: 'ACEPTAR'
                        })
                      } else {
                        valor_nit = res[0]["oci"];
                        $('#nit').val(valor_nit);
                        if (valor_nit !== "") {
                          newMessage = ", SE REGISTRO EL CLIENTE SATISFACTORIAMENTE"
                        }
                        $.ajax({
                          url: "<?php echo site_url('facturacion/C_factura_manual/lst_tipo_venta') ?>",
                          type: "POST",
                          success: function(resp) {
                            var c = JSON.parse(resp);

                            if ($("#efectivo").is(':checked')) {
                              tipo = "Contado";
                            } else if ($("#tarjeta").is(':checked')) {
                              tipo = "Tarjeta";
                            } else if ($("#tareg").is(':checked')) {
                              tipo = "Tarjeta";
                            } else {
                              tipo = "A Deuda";
                            }
                            for (var i = 0; i < c.length; i++) {
                              if (c[i].otipo == tipo) {
                                id_tipo = c[i].oidtipo;
                              }
                            }
                            if (dato != null && dato >= 0 && dato != "" && total >= 0 && total != null && total != "" && cambio >= 0 && cambio != null && cambio != "") {
                              $.ajax({
                                url: "<?php echo site_url('facturacion/C_factura_manual/relizar_cobro') ?>",
                                type: "POST",
                                data: {
                                  valor_nit: valor_nit,
                                  tipo: id_tipo
                                },
                                success: function(resp) {
                                  var c = JSON.parse(resp);
                                  $.each(c, function(i, item) {
                                    if (item.oestado == 't') {
                                      Swal.fire({
                                        icon: 'success',
                                        text: 'PEDIDO REALIZADO' + newMessage,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ACEPTAR'
                                      }).then((result) => {
                                        if (result.isConfirmed) {
                                          jQuery.noConflict();
                                          dato = '<input type="hidden" id="id_venta2" name="id_venta" value="' + item.idventa + '"><input type="hidden" id="pagado2" name="pagado" value="' + dato + '"><input type="hidden" name="descuento" id="descuento" value="' + descuento + '"><input type="hidden" name="giftc" id="giftc" value="' + dato2 + '"><input type="hidden" name="fechaEnvio" id="fechaEnvio"><input type="hidden" name="cuf" id="cuf">';
                                          document.getElementById("idventa").innerHTML = dato;
                                          //$('#finalizar_venta').modal('show');
                                          enviar();
                                        }
                                      })

                                    } else {
                                      Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: item.omensaje,
                                        confirmButtonColor: '#d33',
                                        confirmButtonText: 'ACEPTAR'
                                      })
                                    }
                                  });
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                  alert('Error al obtener datos de ajax');
                                }
                              });
                            } else {
                              if (total == 0) {
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Sucedio un error',
                                  text: 'Agrege al menos un producto para realizar la venta',
                                  confirmButtonColor: '#d33',
                                  confirmButtonText: 'ACEPTAR'
                                });
                              } else if (dato < 0) {
                                $('#pagado').val("0.00").trigger('change');
                                $('#cambio_venta').val("").trigger('change');
                                $("#cambio").html("");
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Sucedio un error',
                                  text: 'El pago no puede tener valor negativo',
                                  confirmButtonColor: '#d33',
                                  confirmButtonText: 'ACEPTAR'
                                });
                              } else {
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Sucedio un error',
                                  text: 'Agrege un monto pago para su venta',
                                  confirmButtonColor: '#d33',
                                  confirmButtonText: 'ACEPTAR'
                                });
                              }

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
                } else {
                  $.ajax({
                    url: "<?php echo site_url('facturacion/C_factura_manual/lst_tipo_venta') ?>",
                    type: "POST",
                    success: function(resp) {
                      var c = JSON.parse(resp);

                      if ($("#efectivo").is(':checked')) {
                        tipo = "Contado";
                      } else if ($("#tarjeta").is(':checked')) {
                        tipo = "Tarjeta";
                      } else if ($("#tareg").is(':checked')) {
                        tipo = "Tarjeta";
                      } else {
                        tipo = "A Deuda";
                      }
                      for (var i = 0; i < c.length; i++) {
                        if (c[i].otipo == tipo) {
                          id_tipo = c[i].oidtipo;
                        }
                      }
                      if (dato != null && dato >= 0 && dato != "" && total >= 0 && total != null && total != "" && cambio >= 0 && cambio != null && cambio != "") {
                        $.ajax({
                          url: "<?php echo site_url('facturacion/C_factura_manual/relizar_cobro') ?>",
                          type: "POST",
                          data: {
                            valor_nit: valor_nit,
                            tipo: id_tipo
                          },
                          success: function(resp) {
                            var c = JSON.parse(resp);
                            $.each(c, function(i, item) {
                              if (item.oestado == 't') {
                                Swal.fire({
                                  icon: 'success',
                                  text: 'PEDIDO REALIZADO',
                                  confirmButtonColor: '#3085d6',
                                  confirmButtonText: 'ACEPTAR'
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    jQuery.noConflict();
                                    dato = '<input type="hidden" id="id_venta2" name="id_venta" value="' + item.idventa + '"><input type="hidden" id="pagado2" name="pagado" value="' + dato + '"><input type="hidden" name="descuento" id="descuento" value="' + descuento + '"><input type="hidden" name="giftc" id="giftc" value="' + dato2 + '"><input type="hidden" name="fechaEnvio" id="fechaEnvio"><input type="hidden" name="cuf" id="cuf">';
                                    document.getElementById("idventa").innerHTML = dato;
                                    //$('#finalizar_venta').modal('show');
                                    enviar();
                                  }
                                })
                              } else {
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: item.omensaje,
                                  confirmButtonColor: '#d33',
                                  confirmButtonText: 'ACEPTAR'
                                })
                              }
                            });
                          },
                          error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error al obtener datos de ajax');
                          }
                        });
                      } else {
                        if (total == 0) {
                          Swal.fire({
                            icon: 'error',
                            title: 'Sucedio un error',
                            text: 'Agrege al menos un producto para realizar la venta',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                          });
                        } else if (dato < 0) {
                          $('#pagado').val("0.00").trigger('change');
                          $('#cambio_venta').val("").trigger('change');
                          $("#cambio").html("");
                          Swal.fire({
                            icon: 'error',
                            title: 'Sucedio un error',
                            text: 'El pago no puede tener valor negativo',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                          });
                        } else {
                          Swal.fire({
                            icon: 'error',
                            title: 'Sucedio un error',
                            text: 'Agrege un monto pago para su venta',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                          });
                        }
                        if (descuento < 0) {
                          Swal.fire({
                            icon: 'error',
                            title: 'Sucedio un error',
                            text: 'El descuento no puede ser negativo, intente otravez porfavor.',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                          });
                        }

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
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Sucedio un error',
              text: 'El descuento supera el total a pagar, se lo actualizara con el descuento maximo.',
              confirmButtonColor: '#d33',
              confirmButtonText: 'ACEPTAR'
            });
          }

        }

      }
    }

    var tipo;
    if ($("#deuda").is(':checked')) {
      tipo = 0;
    } else {
      tipo = 1;
    }



  }

  function finalizar_venta() {

    var razonSocial     = document.getElementById("razonSocial").value.trim();
    var valor_nit       = document.getElementById("nit").value;
    var complemento     = document.getElementById("complemento").value;
    var total_venta     = document.getElementById("total_venta").value;
    var descuento       = document.getElementById("descuento").value;
    var pago_efectivo   = document.getElementById("pagado").value;
    var pago_gift       = document.getElementById("gifcar").value;
    var pago_tarjeta    = document.getElementById("monto_tarjeta").value;
    var pago_otros      = document.getElementById("monto_otros").value;
    var monto_tasa      = document.getElementById('monto_tasa').value;
    var tipofactura     = document.getElementById('tipofactura').value;
    var evento          = document.getElementById("evento");
        evento          = evento.options[evento.selectedIndex].value;
    var docs_identidad  = document.getElementById("docs_identidad");
        docs_identidad  = docs_identidad.options[docs_identidad.selectedIndex].value;
    var codigoExcepcion = document.getElementById("codigoExcepcion").value;
    var nro_tarjeta     = document.getElementById("nro_tarjeta").value;
    var tipo_documento  = document.getElementById("tipo_documento");
        tipo_documento  = tipo_documento.options[tipo_documento.selectedIndex].value;


    if ((valor_nit !== "" && razonSocial === "")) {
      Swal.fire({
        icon: 'error',
        title: 'Sucedio un error',
        text: 'Los datos del cliente deben estar completos o vacios',
        confirmButtonColor: '#d33',
        confirmButtonText: 'ACEPTAR'
      });
    } else {
      var newMessage = "";
      if (valor_nit == "" && razonSocial == "") {
        valor_nit = 777;
        razonSocial = "SIN NOMBRE";
      }
      $.ajax({
        url: "<?php echo site_url('facturacion/C_factura_manual/verifica_cliente') ?>",
        type: "POST",
        data: {
          valor_nit: valor_nit
        },
        success: function(result) {
          var r = JSON.parse(result);
          r = r[0]["fn_verifica_cliente"];
          if ((r == "f") && (razonSocial !== "")) {
            $.ajax({
              url: "<?php echo site_url('facturacion/C_factura_manual/registrar') ?>",
              type: "POST",
              data: {
                valor_nit: valor_nit,
                razonSocial: razonSocial,
                complemento: complemento,
                codigoExcepcion: codigoExcepcion,
                docs_identidad: docs_identidad,
              },
              success: function(reg) {
                var res = JSON.parse(reg);
                if (res[0]["oboolean"] == "f") {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: res[0]["omensaje"],
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ACEPTAR'
                  })
                } else {
                  valor_nit = res[0]["oci"];
                  $('#nit').val(valor_nit);
                  if (valor_nit !== "") {
                    newMessage = ", SE REGISTRO EL CLIENTE SATISFACTORIAMENTE"
                  }
                  console.log(newMessage);
                  //========== registrar_factura

                  $.ajax({
                    url: '<?= base_url() ?>facturacion/C_factura_manual/registrar_factura',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                      razonSocial: razonSocial,
                      valor_nit: valor_nit,
                      complemento: complemento,
                      total_venta: total_venta,
                      descuento: descuento,
                      pago_efectivo: pago_efectivo,
                      pago_tarjeta: pago_tarjeta,
                      pago_gift: pago_gift,
                      pago_otros: pago_otros,
                      tipofactura: tipofactura,
                      tipo_documento: tipo_documento,
                      nro_tarjeta: nro_tarjeta,
                      codigoExcepcion: codigoExcepcion,
                      monto_tasa: monto_tasa,
                      docs_identidad: docs_identidad,
                      evento: evento,
                    },
                    success: function(respuesta) {

                      console.log(respuesta);

                      resources = JSON.parse(respuesta.resources);
                      fechaEnvio = resources.fechaEnvio;
                      cuf = resources.cuf;
                      id_venta = respuesta.idventa;
                      console.log(id_venta)
                      transaccion = respuesta.transaccion;
                      if (transaccion) {
                        Swal.fire({
                          icon: 'success',
                          title: 'PENDIENTE',
                          text: 'La Factura se guardo correctamente',
                          confirmButtonColor: '#3085d6',
                          confirmButtonText: 'ACEPTAR',
                        }).then((result) => {
                          $('#fechaEnvio').val(fechaEnvio).trigger('change');
                          $('#cuf').val(cuf).trigger('change');
                          $('#rsocial').val(razonSocial).trigger('change');
                          $('#complement').val(complemento).trigger('change');
                          $('#id_venta_pdf').val(id_venta).trigger('change');
                          $('#monto_tasa_pdf').val(monto_tasa).trigger('change');
                          document.getElementById("conf_pedido").submit();
                          location.href = "<?php echo base_url(); ?>pedidoCodigo";
                        })
                      } else {
                        data = JSON.parse(respuesta.respons);
                        var resp = data.RespuestaServicioFacturacion.transaccion;
                        console.log(resp);
                        if (resp == false) {
                          Swal.fire({
                            icon: 'warning',
                            title: data.RespuestaServicioFacturacion.codigoDescripcion,
                            text: data.RespuestaServicioFacturacion.mensajesList.descripcion + ', reintentar?',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ACEPTAR',
                          }).then((result) => {
                            if (result.isConfirmed) {
                              finalizar_venta();
                            }
                          })
                        } else {
                          Swal.fire({
                            icon: 'success',
                            title: data.RespuestaServicioFacturacion.codigoDescripcion,
                            text: 'La Factura se envío correctamente',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ACEPTAR',
                          }).then((result) => {
                            $('#fechaEnvio').val(fechaEnvio).trigger('change');
                            $('#cuf').val(cuf).trigger('change');
                            $('#rsocial').val(razonSocial).trigger('change');
                            $('#complement').val(complemento).trigger('change');
                            $('#id_venta_pdf').val(id_venta).trigger('change');
                            $('#monto_tasa_pdf').val(monto_tasa).trigger('change');
                            document.getElementById("conf_pedido").submit();
                            location.href = "<?php echo base_url(); ?>factura_manual";
                          })
                        }
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
          } else {
            //========== registrar_factura
            $.ajax({
              url: '<?= base_url() ?>facturacion/C_factura_manual/registrar_factura',
              type: "POST",
              dataType: "JSON",
              data: {
                razonSocial: razonSocial,
                valor_nit: valor_nit,
                complemento: complemento,
                total_venta: total_venta,
                descuento: descuento,
                pago_efectivo: pago_efectivo,
                pago_tarjeta: pago_tarjeta,
                pago_gift: pago_gift,
                pago_otros: pago_otros,
                tipofactura: tipofactura,
                tipo_documento: tipo_documento,
                nro_tarjeta: nro_tarjeta,
                codigoExcepcion: codigoExcepcion,
                monto_tasa: monto_tasa,
                docs_identidad: docs_identidad,
                evento: evento,
              },
              success: function(respuesta) {

                console.log(respuesta);

                resources = JSON.parse(respuesta.resources);
                fechaEnvio = resources.fechaEnvio;
                cuf = resources.cuf;
                id_venta = respuesta.idventa;
                console.log(id_venta)
                transaccion = respuesta.transaccion;
                if (transaccion) {
                  Swal.fire({
                    icon: 'success',
                    title: 'PENDIENTE',
                    text: 'La Factura se guardo correctamente',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                  }).then((result) => {
                    $('#fechaEnvio').val(fechaEnvio).trigger('change');
                    $('#cuf').val(cuf).trigger('change');
                    $('#rsocial').val(razonSocial).trigger('change');
                    $('#complement').val(complemento).trigger('change');
                    $('#id_venta_pdf').val(id_venta).trigger('change');
                    $('#monto_tasa_pdf').val(monto_tasa).trigger('change');
                    document.getElementById("conf_pedido").submit();
                    location.href = "<?php echo base_url(); ?>pedidoCodigo";
                  })
                } else {
                  data = JSON.parse(respuesta.respons);
                  var resp = data.RespuestaServicioFacturacion.transaccion;
                  console.log(resp);
                  if (resp == false) {
                    Swal.fire({
                      icon: 'warning',
                      title: data.RespuestaServicioFacturacion.codigoDescripcion,
                      text: data.RespuestaServicioFacturacion.mensajesList.descripcion + ', reintentar?',
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'ACEPTAR',
                    }).then((result) => {
                      if (result.isConfirmed) {
                        finalizar_venta();
                      }
                    })
                  } else {
                    Swal.fire({
                      icon: 'success',
                      title: data.RespuestaServicioFacturacion.codigoDescripcion,
                      text: 'La Factura se envío correctamente',
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'ACEPTAR',
                    }).then((result) => {
                      $('#fechaEnvio').val(fechaEnvio).trigger('change');
                      $('#cuf').val(cuf).trigger('change');
                      $('#rsocial').val(razonSocial).trigger('change');
                      $('#complement').val(complemento).trigger('change');
                      $('#id_venta_pdf').val(id_venta).trigger('change');
                      $('#monto_tasa_pdf').val(monto_tasa).trigger('change');
                      document.getElementById("conf_pedido").submit();
                      location.href = "<?php echo base_url(); ?>factura_manual";
                    })
                  }
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

    document.cookie = "Cliente = ;";

  }
</script>
<script>
  const inpPassword = document.getElementById('id_producto');
  setTimeout(() => {
    inpPassword.focus();
  }, 300);
</script>
<!--js para buscar el ci de un cliente-->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-1.12.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/jquery-ui.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var nombres = [];
    $.ajax({
      url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_nit') ?>",
      type: "POST",
      success: function(respuesta) {
        var json = JSON.parse(respuesta);
        nombres = Object.values(json);
        const items = nombres.map(function(nombres) {
          return nombres.nit_ci;
        });
        $("#nit").autocomplete({
          source: items,
          select: function(event, item) {
            $.ajax({
              url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_nombre') ?>",
              type: "POST",
              data: {
                buscar: item.item.value
              },
              success: function(resp) {
                var c = JSON.parse(resp);
                //complemento = c.complemento;
                console.log(c);
                razonSocial = c[0].razon_social;
                complemento = c[0].complemento;
                let nombre = razonSocial;
                nombre = nombre.replace('&amp;', '&');
                nombre = nombre.replace('&lt;', '<');
                nombre = nombre.replace('&gt;', '>');
                nombre = nombre.replace('&apos;', "'" );
                nombre = nombre.replace('&quot;', '"');
                codigoExcepcion = c[0].cod_excepcion;
                $("#docs_identidad").val(c[0].cod_documento).trigger('change');
                $("#razonSocial").val(nombre).trigger('change');
                $("#nit").val(c[0].num_documento).trigger('change');
                $("#complemento").val(complemento).trigger('change');
                $("#codigoExcepcion").val(codigoExcepcion).trigger('change');
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
              }
            });
          }
        });
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var nit = [];
    $.ajax({
      url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_lts_nombre') ?>",
      type: "POST",
      success: function(respuesta) {
        var json = JSON.parse(respuesta);
        nit = Object.values(json);
        const items = nit.map(function(nit) {
          return nit.cliente + "-" + nit.ci;
        });
        $("#razonSocial").autocomplete({
          source: items,
          select: function(event, item) {
            $.ajax({
              url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_nit_usuario') ?>",
              type: "POST",
              data: {
                buscar: item.item.value
              },
              success: function(resp) {
                $("#nit").val(resp);
                var nom = "";
                for (var i = 0; i < item.item.value.length; i++) {
                  if (item.item.value.charAt(i) == "-") {
                    break;
                  } else {
                    nom = nom + item.item.value.charAt(i);
                  }
                }
                $("#razonSocial").val(nom);
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
              }
            });
          }
        });
      }
    });
  });
</script>
<script>
  function agregar_nombre() {
    // valor_nit = document.getElementById("nit").value;
    // $.ajax({
    //   url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_nombre') ?>",
    //   type: "POST",
    //   data: {
    //     buscar: valor_nit
    //   },
    //   success: function(resp) {
    //     var c = JSON.parse(resp);
    //     $.each(c, function(i, item) {
    //       $("#razonSocial").val(item.fn_recuperar_cliente);
    //     });
    //   },
    //   error: function(jqXHR, textStatus, errorThrown) {
    //     alert('Error al obtener datos de ajax');
    //   }
    // });
  }
</script>

<!--js para buscar codigo-->
<script type="text/javascript">
  $(document).ready(function() {
    var codigo = [];
    $.ajax({
      url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_codigo') ?>",
      type: "POST",
      success: function(respuesta) {
        var json = JSON.parse(respuesta);
        codigo = Object.values(json);
        const items = codigo.map(function(codigo) {
          return codigo.codigo;
        });
        $("#id_producto").autocomplete({
          source: items
        });
      }
    });
  });
</script>
<!--js para modificar el pago-->
<script>
  function myFunction(form) {

    total = parseFloat(document.getElementById("total_venta").value);

    descuento = parseFloat(document.getElementById("descuento").value);

    pago = parseFloat(form.pagado.value);
    tarjeta = parseFloat(document.getElementById("monto_tarjeta").value);
    giftcard = parseFloat(document.getElementById("gifcar").value);
    otros = parseFloat(document.getElementById("monto_otros").value);

    pago = (parseFloat(pago + tarjeta + giftcard + otros)).toFixed(2);
    console.log(pago);

    var tdes = total - descuento;

    tipo = document.getElementById("tipo_documento");
    var tipo = tipo.options[tipo.selectedIndex].value;

    console.log(tipo);
    if (total > 0 && tdes > 0) {
      $.ajax({
        url: "<?php echo site_url('facturacion/C_factura_manual/calcular_cambio') ?>",
        type: "POST",
        data: {
          pagado: pago,
          id_tipo: id_tipo,
          descuento: descuento
        },
        success: function(resp) {
          var c = JSON.parse(resp);
          console.log(c);
          // $.each(c, function(i, item) {
          //   let omonto = (parseFloat(item.omonto)).toFixed(2);
          //   let ocambio_saldo = (parseFloat(item.ocambio_saldo)).toFixed(2);
          //   let ototal = (parseFloat(item.ototal)).toFixed(2);
          //   $("#pagado").val(omonto);
          //   $("#cambio").html(ocambio_saldo);
          //   $('#cambio_venta').val(ocambio_saldo).trigger('change');
          //   $("#total").html(ototal);
          // });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }

  }

  function calcular_cambio() {

    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if (charCode == 9 || charCode == 13) {
      console.log(2);
      var pago_efectivo = parseFloat(document.getElementById("pagado").value);
      var pago_gift = parseFloat(document.getElementById("gifcar").value);
      var pago_tarjeta = parseFloat(document.getElementById("monto_tarjeta").value);
      var pago_otros = parseFloat(document.getElementById("monto_otros").value);
      var descuento = parseFloat(document.getElementById("descuento").value);
      console.log(pago_gift);
      total = parseFloat(document.getElementById("total_venta").value);

      if (pago_efectivo == '' || pago_efectivo < 0.00) {
        document.getElementById('pagado').value = '0.00';
      }
      if (pago_gift == '' || pago_gift < 0.00) {
        document.getElementById('gifcar').value = '0.00';
      }
      if (pago_tarjeta == '' || pago_tarjeta < 0.00) {
        document.getElementById('monto_tarjeta').value = '0.00';
      }
      if (pago_otros == '' || pago_otros < 0.00) {
        document.getElementById('monto_otros').value = '0.00';
      }

      console.log(pago_efectivo + ' aa');

      pago = (parseFloat(pago_efectivo + pago_gift + pago_tarjeta + pago_otros));
      console.log(pago);

      var tdes = total - descuento;

      tipo = document.getElementById("tipo_documento");
      var tipo = tipo.options[tipo.selectedIndex].value;

      console.log(tipo);

      if (total > 0 && tdes > 0) {
        $.ajax({
          url: "<?php echo site_url('facturacion/C_factura_manual/calcular_cambio') ?>",
          type: "POST",
          data: {
            pagado: pago,
            id_tipo: tipo,
            descuento: descuento
          },
          success: function(resp) {
            var c = JSON.parse(resp);
            console.log(c);
            $.each(c, function(i, item) {
              descuento = parseFloat(document.getElementById("descuento").value).toFixed(2);
              document.getElementById('descuento').value = descuento;
              document.getElementById('descuento_pdf').value = descuento;
              pago_efectivo = parseFloat(document.getElementById("pagado").value).toFixed(2);
              document.getElementById('pagado').value = pago_efectivo;
              document.getElementById('pagado_pdf').value = pago;
              pago_gift = parseFloat(document.getElementById("gifcar").value).toFixed(2);
              document.getElementById('gifcar').value = pago_gift;
              document.getElementById('giftc_pdf').value = pago_gift;
              pago_tarjeta = parseFloat(document.getElementById("monto_tarjeta").value).toFixed(2);
              document.getElementById('monto_tarjeta').value = pago_tarjeta;
              pago_otros = parseFloat(document.getElementById("monto_otros").value).toFixed(2);
              document.getElementById('monto_otros').value = pago_otros;

              let ocambio_saldo = (parseFloat(item.ocambio_saldo)).toFixed(2);
              let ototal = (parseFloat(item.ototal)).toFixed(2);
              $("#cambio").html(ocambio_saldo);
              $('#cambio_venta').val(ocambio_saldo).trigger('change');
              $("#total").html(ototal);

            });
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
          }
        });
      }

    }


    //else if (pago >= tdes && $("#deuda").is(':checked')) {
    //   Swal.fire({
    //     icon: 'error',
    //     title: 'Oops...',
    //     text: 'Debe ingresar un valor menor al total',
    //     confirmButtonColor: '#d33',
    //     confirmButtonText: 'ACEPTAR'
    //   })
    // } else if (pago >= tdes && ($("#efectivo").is(':checked') || $("#tarjeta").is(':checked') || $("#tareg").is(':checked')) && total != 0) {
    //   $.ajax({
    //     url: "<?php echo site_url('facturacion/C_factura_manual/calcular_cambio') ?>",
    //     type: "POST",
    //     data: {
    //       pagado: pago,
    //       id_tipo: id_tipo,
    //       descuento: descuento
    //     },
    //     success: function(resp) {
    //       var c = JSON.parse(resp);
    //       $.each(c, function(i, item) {
    //         let omonto = (parseFloat(item.omonto)).toFixed(2);
    //         let ocambio_saldo = (parseFloat(item.ocambio_saldo)).toFixed(2);
    //         let ototal = (parseFloat(item.ototal)).toFixed(2);
    //         if ($("#tareg").is(':checked')) {
    //           let monto_total = (parseFloat(form.pagado.value)).toFixed(2);
    //           $("#pagado").val(monto_total);
    //           let giftcard_total = giftcard.toFixed(2);
    //           $("#gifcar").val(giftcard_total);
    //         } else {
    //           $("#pagado").val(omonto);
    //         }
    //         $("#cambio").html(ocambio_saldo);
    //         $('#cambio_venta').val(ocambio_saldo).trigger('change');
    //         $("#total").html(ototal);
    //       });
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {
    //       alert('Error al obtener datos de ajax');
    //     }
    //   });
    // } else if (total == 0) {
    //   Swal.fire({
    //     icon: 'error',
    //     title: 'Oops...',
    //     text: 'Debe ingresar un producto para continuar con la venta',
    //     confirmButtonColor: '#d33',
    //     confirmButtonText: 'ACEPTAR'
    //   })
    // } else {
    //   Swal.fire({
    //     icon: 'error',
    //     title: 'Oops...',
    //     text: 'Debe ingresar un valor mayor ó igual al total',
    //     confirmButtonColor: '#d33',
    //     confirmButtonText: 'ACEPTAR'
    //   })
    // }

    // $.ajax({
    //   url: "<?php echo site_url('facturacion/C_factura_manual/lst_tipo_venta') ?>",
    //   type: "POST",
    //   success: function(resp) {
    //     var c = JSON.parse(resp);
    //     console.log(c);
    //     if ($("#efectivo").is(':checked')) {
    //       tipo = tipo+"Contado";
    //     } else if ($("#tarjeta").is(':checked')) {
    //       tipo = tipo+"Tarjeta";
    //     } else if ($("#tareg").is(':checked')) {
    //       tipo = tipo+"Tarjeta";
    //     } else {
    //       tipo = tipo+"A Deuda";
    //     }

    //     // for (var i = 0; i < c.length; i++) {
    //     //   if (c[i].otipo == tipo) {
    //     //     id_tipo = c[i].oidtipo;
    //     //   }
    //     // }
    //     // if (pago < tdes && $("#deuda").is(':checked')) {
    //     //   $.ajax({
    //     //     url: "<?php echo site_url('facturacion/C_factura_manual/calcular_cambio') ?>",
    //     //     type: "POST",
    //     //     data: {
    //     //       pagado: pago,
    //     //       id_tipo: id_tipo,
    //     //       descuento: descuento
    //     //     },
    //     //     success: function(resp) {
    //     //       var c = JSON.parse(resp);
    //     //       $.each(c, function(i, item) {
    //     //         let omonto = (parseFloat(item.omonto)).toFixed(2);
    //     //         let ocambio_saldo = (parseFloat(item.ocambio_saldo)).toFixed(2);
    //     //         let ototal = (parseFloat(item.ototal)).toFixed(2);
    //     //         $("#pagado").val(omonto);
    //     //         $("#cambio").html(ocambio_saldo);
    //     //         $('#cambio_venta').val(ocambio_saldo).trigger('change');
    //     //         $("#total").html(ototal);
    //     //       });
    //     //     },
    //     //     error: function(jqXHR, textStatus, errorThrown) {
    //     //       alert('Error al obtener datos de ajax');
    //     //     }
    //     //   });
    //     // } else if (pago >= tdes && $("#deuda").is(':checked')) {
    //     //   Swal.fire({
    //     //     icon: 'error',
    //     //     title: 'Oops...',
    //     //     text: 'Debe ingresar un valor menor al total',
    //     //     confirmButtonColor: '#d33',
    //     //     confirmButtonText: 'ACEPTAR'
    //     //   })
    //     // } else if (pago >= tdes && ($("#efectivo").is(':checked') || $("#tarjeta").is(':checked') || $("#tareg").is(':checked')) && total != 0) {
    //     //   $.ajax({
    //     //     url: "<?php echo site_url('facturacion/C_factura_manual/calcular_cambio') ?>",
    //     //     type: "POST",
    //     //     data: {
    //     //       pagado: pago,
    //     //       id_tipo: id_tipo,
    //     //       descuento: descuento
    //     //     },
    //     //     success: function(resp) {
    //     //       var c = JSON.parse(resp);
    //     //       $.each(c, function(i, item) {
    //     //         let omonto = (parseFloat(item.omonto)).toFixed(2);
    //     //         let ocambio_saldo = (parseFloat(item.ocambio_saldo)).toFixed(2);
    //     //         let ototal = (parseFloat(item.ototal)).toFixed(2);
    //     //         if ($("#tareg").is(':checked')) {
    //     //           let monto_total = (parseFloat(form.pagado.value)).toFixed(2);
    //     //           $("#pagado").val(monto_total);
    //     //           let giftcard_total = giftcard.toFixed(2);
    //     //           $("#gifcar").val(giftcard_total);
    //     //         } else {
    //     //           $("#pagado").val(omonto);
    //     //         }
    //     //         $("#cambio").html(ocambio_saldo);
    //     //         $('#cambio_venta').val(ocambio_saldo).trigger('change');
    //     //         $("#total").html(ototal);
    //     //       });
    //     //     },
    //     //     error: function(jqXHR, textStatus, errorThrown) {
    //     //       alert('Error al obtener datos de ajax');
    //     //     }
    //     //   });
    //     // } else if (total == 0) {
    //     //   Swal.fire({
    //     //     icon: 'error',
    //     //     title: 'Oops...',
    //     //     text: 'Debe ingresar un producto para continuar con la venta',
    //     //     confirmButtonColor: '#d33',
    //     //     confirmButtonText: 'ACEPTAR'
    //     //   })
    //     // } else {
    //     //   Swal.fire({
    //     //     icon: 'error',
    //     //     title: 'Oops...',
    //     //     text: 'Debe ingresar un valor mayor ó igual al total',
    //     //     confirmButtonColor: '#d33',
    //     //     confirmButtonText: 'ACEPTAR'
    //     //   })
    //     // }
    //   },
    //   error: function(jqXHR, textStatus, errorThrown) {
    //     alert('Error al obtener datos de ajax');
    //   }
    // });

    //return false;
  }
</script>

<!--js para buscar nombre de un producto-->
<script type="text/javascript">
  $(document).ready(function() {
    var nombre = [];
    $.ajax({
      url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_producto') ?>",
      type: "POST",
      success: function(respuesta) {
        var json = JSON.parse(respuesta);
        codigo = Object.values(json);
        const items = codigo.map(function(codigo) {
          return codigo.descripcion;
        });
        $("#nombre_producto").autocomplete({
          source: items
        });
      }
    });
  });
</script>

<!--js validar-->
<script type="text/javascript">
  document.getElementById("deuda").onclick = function() {
    validar()
  };

  function validar() {
    valor = document.getElementById("razonSocial").value;
    valor1 = document.getElementById("nit").value;
    if (valor == null || valor.length == 0 || valor1 == null || valor1.length == 0) {
      Swal.fire({
        icon: 'error',
        title: 'Debes ingresar un cliente',
        text: item.omensaje,
        confirmButtonColor: '#d33',
        confirmButtonText: 'ACEPTAR'
      });
    }
  }
</script>

<!--Para mostrar la tabla-->
<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
      url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_produc') ?>",
      type: "POST",
      success: function(respuesta) {
        var json = JSON.parse(respuesta);
        con.innerHTML = '';
        let total = 0.000;
        for (var i = 0; i < json.length; i++) {
          let num = parseFloat(json[i].oprecio);
          total = total + num;
          var id = json[i].oidventa;
          var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
          var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
          con.innerHTML = con.innerHTML +
            '<tr>' +
            '<td>' + json[i].ocodigo + '</td>' +
            '<td>' + json[i].onombre + '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
            '</td>' +
            '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
            '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
            '</td>' +
            '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
            '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
            '<td style="width: 10%" align="center">' +
            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
            '<label>&nbsp;&nbsp;&nbsp;</label>' +
            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
            '</td>' +
            '</form>' +
            '</tr>'
        }
        total = total.toFixed(2);
        $("#total").html(total);
        $('#total_venta').val(total).trigger('change');
        $('#pagado').val("0.00").trigger('change');
        $('#cambio_venta').val("").trigger('change');
        $("#cambio").html("");
        const inpPassword = document.getElementById('id_producto');
        inpPassword.focus();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  });
</script>

<!--js listar-->
<script type="text/javascript">
  function listar() {
    let con = document.getElementById('con');
    let codigo = document.getElementById("id_producto").value;
    $.ajax({
      url: "<?php echo site_url('facturacion/C_factura_manual/datos_producto') ?>",
      type: "POST",
      data: {
        buscar: codigo
      },
      success: function(respuesta) {
        var json = JSON.parse(respuesta);
        con.innerHTML = '';
        let total = 0.000;
        for (var i = 0; i < json.length; i++) {
          let num = parseFloat(json[i].oprecio);
          total = total + num;
          var id = json[i].oidventa;
          var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
          var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
          con.innerHTML = con.innerHTML +
            '<tr>' +
            '<td>' + json[i].ocodigo + '</td>' +
            '<td>' + json[i].onombre + '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
            '</td>' +
            '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
            '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
            '</td>' +
            '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
            '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
            '<td style="width: 10%" align="center">' +
            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
            '<label>&nbsp;&nbsp;&nbsp;</label>' +
            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
            '</td>' +
            '</form>' +
            '</tr>'
        }
        total = total.toFixed(2);
        $("#total").html(total);
        document.getElementById("base_form").reset();
        $('#total_venta').val(total).trigger('change');
        $('#pagado').val("0.00").trigger('change');
        $('#cambio_venta').val("").trigger('change');
        $("#cambio").html("");
        document.getElementById("cantidad0").select();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: 'error',
          title: 'Sucedio un error con el producto seleccionado',
          text: 'por favor revise inventarios y abastecimiento',
          confirmButtonColor: '#d33',
          confirmButtonText: 'ACEPTAR'
        });
        document.getElementById("base_form").reset();
      }
    });
    return false;
  }
</script>

<!--js listar nombre-->
<script type="text/javascript">
  function listar1() {
    let con = document.getElementById('con');
    var codigo = document.getElementById("nombre_producto").value;
    $.ajax({
      url: "<?php echo site_url('facturacion/C_factura_manual/datos_nombre') ?>",
      type: "POST",
      data: {
        buscar: codigo
      },
      success: function(respuesta) {
        var json = JSON.parse(respuesta);
        console.log(respuesta);
        con.innerHTML = '';
        let total = 0.000;
        for (var i = 0; i < json.length; i++) {
          let num = parseFloat(json[i].oprecio);
          total = total + num;
          var id = json[i].oidventa;
          var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
          var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
          con.innerHTML = con.innerHTML +
            '<tr>' +
            '<td>' + json[i].ocodigo + '</td>' +
            '<td>' + json[i].onombre + '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
            '</td>' +
            '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
            '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
            '</td>' +
            '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
            '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
            '<td style="width: 10%" align="center">' +
            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
            '<label>&nbsp;&nbsp;&nbsp;</label>' +
            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
            '</td>' +
            '</form>' +
            '</tr>'
        }
        total = total.toFixed(2);
        $("#total").html(total);
        document.getElementById("form_nombre").reset();
        $('#total_venta').val(total).trigger('change');
        $('#pagado').val("0.00").trigger('change');
        $('#cambio_venta').val("").trigger('change');
        $("#cambio").html("");
        document.getElementById("cantidad0").select();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: 'error',
          title: 'Sucedio un error con el producto seleccionado',
          text: 'por favor revise inventarios y abastecimiento',
          confirmButtonColor: '#d33',
          confirmButtonText: 'ACEPTAR'
        });
        document.getElementById("form_nombre").reset();
      }
    });
    return false;
  }
</script>

<script>
  function onkeydown_precio_uni(msg, idventa, dato) {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if (charCode == 9 || charCode == 13) {
      $.ajax({
        url: "<?php echo site_url('facturacion/C_factura_manual/verificar_cambio_precio') ?>",
        type: "POST",
        data: {
          dato1: idventa,
          dato2: msg.value
        },
        success: function(respuesta) {
          var js = JSON.parse(respuesta);
          $.each(js, function(i, item) {
            if (item.oboolean == 'f') {
              Swal.fire({
                icon: 'warning',
                text: item.omensaje,
                title: "¿Desea Continuar con el Cambio de Precio?",
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
                denyButtonText: 'CANCELAR',
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "<?php echo site_url('facturacion/C_factura_manual/cambio_precio_uni') ?>",
                    type: "POST",
                    data: {
                      dato3: idventa,
                      dato4: msg.value
                    },
                    success: function(respuesta) {
                      var json = JSON.parse(respuesta);
                      con.innerHTML = '';
                      let total = 0.000;
                      for (var i = 0; i < json.length; i++) {
                        let num = parseFloat(json[i].oprecio);
                        total = total + num;
                        var id = json[i].oidventa;
                        var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                        var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                        con.innerHTML = con.innerHTML +
                          '<tr>' +
                          '<td>' + json[i].ocodigo + '</td>' +
                          '<td>' + json[i].onombre + '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                          '</td>' +
                          '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                          '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
                          '<td style="width: 10%" align="center">' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
                          '<label>&nbsp;&nbsp;&nbsp;</label>' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                          '</td>' +
                          '</form>' +
                          '</tr>'
                      }
                      total = total.toFixed(2);
                      $("#total").html(total);
                      $('#total_venta').val(total).trigger('change');
                      $('#pagado').val("0.00").trigger('change');
                      $('#cambio_venta').val("").trigger('change');
                      $("#cambio").html("");
                      document.getElementById("precio" + dato).focus();
                      document.getElementById("precio" + dato).select();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                      Swal.fire({
                        icon: 'error',
                        title: 'Sucedio un error',
                        text: 'por favor revise los datos',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'ACEPTAR'
                      });
                    }
                  });

                } else {
                  $.ajax({
                    url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_produc') ?>",
                    type: "POST",
                    success: function(respuesta) {
                      var json = JSON.parse(respuesta);
                      con.innerHTML = '';
                      let total = 0.000;
                      for (var i = 0; i < json.length; i++) {
                        let num = parseFloat(json[i].oprecio);
                        total = total + num;
                        var id = json[i].oidventa;
                        var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                        var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                        con.innerHTML = con.innerHTML +
                          '<tr>' +
                          '<td>' + json[i].ocodigo + '</td>' +
                          '<td>' + json[i].onombre + '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                          '</td>' +
                          '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                          '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
                          '<td style="width: 10%" align="center">' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
                          '<label>&nbsp;&nbsp;&nbsp;</label>' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                          '</td>' +
                          '</form>' +
                          '</tr>'
                      }
                      total = total.toFixed(2);
                      $("#total").html(total);
                      $('#total_venta').val(total).trigger('change');
                      $('#pagado').val("0.00").trigger('change');
                      $('#cambio_venta').val("").trigger('change');
                      $("#cambio").html("");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                      alert('Error al obtener datos de ajax');
                    }
                  });
                }
              })
            } else {
              $.ajax({
                url: "<?php echo site_url('facturacion/C_factura_manual/cambio_precio_uni') ?>",
                type: "POST",
                data: {
                  dato3: idventa,
                  dato4: msg.value
                },
                success: function(respuesta) {
                  var json = JSON.parse(respuesta);
                  con.innerHTML = '';
                  let total = 0.000;
                  for (var i = 0; i < json.length; i++) {
                    let num = parseFloat(json[i].oprecio);
                    total = total + num;
                    var id = json[i].oidventa;
                    var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                    var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                    con.innerHTML = con.innerHTML +
                      '<tr>' +
                      '<td>' + json[i].ocodigo + '</td>' +
                      '<td>' + json[i].onombre + '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                      '</td>' +
                      '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                      '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                      '</td>' +
                      '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                      '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
                      '<td style="width: 10%" align="center">' +
                      '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
                      '<label>&nbsp;&nbsp;&nbsp;</label>' +
                      '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                      '</td>' +
                      '</form>' +
                      '</tr>'
                  }
                  total = total.toFixed(2);
                  $("#total").html(total);
                  $('#total_venta').val(total).trigger('change');
                  $('#pagado').val("0.00").trigger('change');
                  $('#cambio_venta').val("").trigger('change');
                  $("#cambio").html("");
                  document.getElementById("precio" + dato).focus();
                  document.getElementById("precio" + dato).select();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Sucedio un error',
                    text: 'por favor revise los datos',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ACEPTAR'
                  });
                }
              });
            }
          });

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }
  }
</script>

<script>
  function onkeydown_cant(msg, idventa) {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if (charCode == 9 || charCode == 13) {
      $.ajax({
        url: "<?php echo site_url('facturacion/C_factura_manual/verificar_cambio_precio_total') ?>",
        type: "POST",
        data: {
          dato1: idventa,
          dato2: msg.value
        },
        success: function(respuesta) {
          var js = JSON.parse(respuesta);
          $.each(js, function(i, item) {
            if (item.oboolean == 'f') {
              Swal.fire({
                icon: 'warning',
                text: item.omensaje,
                title: "¿Desea Continuar con el Cambio de Precio?",
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
                denyButtonText: 'CANCELAR',
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "<?php echo site_url('facturacion/C_factura_manual/cambiar_precio') ?>",
                    type: "POST",
                    data: {
                      dato1: idventa,
                      dato2: msg.value
                    },
                    success: function(respuesta) {
                      var json = JSON.parse(respuesta);
                      con.innerHTML = '';
                      let total = 0.000;
                      for (var i = 0; i < json.length; i++) {
                        let num = parseFloat(json[i].oprecio);
                        total = total + num;
                        var id = json[i].oidventa;
                        var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                        var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                        con.innerHTML = con.innerHTML +
                          '<tr>' +
                          '<td>' + json[i].ocodigo + '</td>' +
                          '<td>' + json[i].onombre + '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                          '</td>' +
                          '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                          '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
                          '<td style="width: 10%" align="center">' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
                          '<label>&nbsp;&nbsp;&nbsp;</label>' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                          '</td>' +
                          '</form>' +
                          '</tr>'
                      }
                      total = total.toFixed(2);
                      $("#total").html(total);
                      $('#total_venta').val(total).trigger('change');
                      $('#cambio_venta').val("").trigger('change');
                      $("#cambio").html("");
                      document.getElementById("pagado").focus();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                      Swal.fire({
                        icon: 'error',
                        title: 'Sucedio un error',
                        text: 'por favor revise los datos',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'ACEPTAR'
                      });
                    }
                  });
                } else {
                  $.ajax({
                    url: "<?php echo site_url('facturacion/C_factura_manual/mostrar_produc') ?>",
                    type: "POST",
                    success: function(respuesta) {
                      var json = JSON.parse(respuesta);
                      con.innerHTML = '';
                      let total = 0.000;
                      for (var i = 0; i < json.length; i++) {
                        let num = parseFloat(json[i].oprecio);
                        total = total + num;
                        var id = json[i].oidventa;
                        var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                        var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                        con.innerHTML = con.innerHTML +
                          '<tr>' +
                          '<td>' + json[i].ocodigo + '</td>' +
                          '<td>' + json[i].onombre + '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                          '</td>' +
                          '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                          '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
                          '<td style="width: 10%" align="center">' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
                          '<label>&nbsp;&nbsp;&nbsp;</label>' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                          '</td>' +
                          '</form>' +
                          '</tr>'
                      }
                      total = total.toFixed(2);
                      $("#total").html(total);
                      $('#total_venta').val(total).trigger('change');
                      $('#pagado').val("0.00").trigger('change');
                      $('#cambio_venta').val("").trigger('change');
                      $("#cambio").html("");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                      alert('Error al obtener datos de ajax');
                    }
                  });
                }
              })
            } else {
              $.ajax({
                url: "<?php echo site_url('facturacion/C_factura_manual/cambiar_precio') ?>",
                type: "POST",
                data: {
                  dato1: idventa,
                  dato2: msg.value
                },
                success: function(respuesta) {
                  var json = JSON.parse(respuesta);
                  con.innerHTML = '';
                  let total = 0.000;
                  for (var i = 0; i < json.length; i++) {
                    let num = parseFloat(json[i].oprecio);
                    total = total + num;
                    var id = json[i].oidventa;
                    var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                    var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                    con.innerHTML = con.innerHTML +
                      '<tr>' +
                      '<td>' + json[i].ocodigo + '</td>' +
                      '<td>' + json[i].onombre + '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                      '</td>' +
                      '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                      '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                      '</td>' +
                      '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                      '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
                      '<td style="width: 10%" align="center">' +
                      '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
                      '<label>&nbsp;&nbsp;&nbsp;</label>' +
                      '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                      '</td>' +
                      '</form>' +
                      '</tr>'
                  }
                  total = total.toFixed(2);
                  $("#total").html(total);
                  $('#total_venta').val(total).trigger('change');
                  $('#cambio_venta').val("").trigger('change');
                  $("#cambio").html("");
                  document.getElementById("pagado").focus();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Sucedio un error',
                    text: 'por favor revise los datos',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ACEPTAR'
                  });
                }
              });
            }
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }
  }
</script>
<script>
  function onkeypress_nit_razonSocial() {
    if (event.key === 'Enter') {
      // document.getElementById("id_producto").focus();
      // document.getElementById("id_producto").select();
    }
  };

  function onkeydown_nombre_producto() {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if (charCode == 9) {
      let con = document.getElementById('con');
      var codigo = document.getElementById("nombre_producto").value;
      $.ajax({
        url: "<?php echo site_url('facturacion/C_factura_manual/datos_nombre') ?>",
        type: "POST",
        data: {
          buscar: codigo
        },
        success: function(respuesta) {
          var json = JSON.parse(respuesta);
          con.innerHTML = '';
          let total = 0.000;
          for (var i = 0; i < json.length; i++) {
            let num = parseFloat(json[i].oprecio);
            total = total + num;
            var id = json[i].oidventa;
            var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
            var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
            con.innerHTML = con.innerHTML +
              '<tr>' +
              '<td>' + json[i].ocodigo + '</td>' +
              '<td>' + json[i].onombre + '</td>' +
              '<td>' +
              '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
              '</td>' +
              '</td>' +
              '<td>' +
              '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
              '</td>' +
              '<td>' +
              '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
              '</td>' +
              '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
              '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
              '<td style="width: 10%" align="center">' +
              '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
              '<label>&nbsp;&nbsp;&nbsp;</label>' +
              '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
              '</td>' +
              '</form>' +
              '</tr>'
          }
          total = total.toFixed(2);
          $("#total").html(total);
          document.getElementById("form_nombre").reset();
          $('#total_venta').val(total).trigger('change');
          $('#pagado').val("0.00").trigger('change');
          $('#cambio_venta').val("").trigger('change');
          $("#cambio").html("");
          document.getElementById("nombre_producto").focus();
          document.getElementById("nombre_producto").select();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: 'error',
            title: 'Sucedio un error con el producto seleccionado',
            text: 'por favor revise inventarios y abastecimiento',
            confirmButtonColor: '#d33',
            confirmButtonText: 'ACEPTAR'
          });
          document.getElementById("form_nombre").reset();
        }
      });
    }
  }
</script>
<script>
  function onkeydown_cantidad(msg, idventa, dato) {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    console.log(charCode);
    if (charCode == 9 || charCode == 13 || charCode == 39) {
      $.ajax({
        url: "<?php echo site_url('facturacion/C_factura_manual/verifica_cantidad') ?>",
        type: "POST",
        data: {
          dato1: idventa,
          dato2: msg.value
        },
        success: function(respuesta) {
          var js = JSON.parse(respuesta);
          $.each(js, function(i, item) {
            if (item.oboolean == 'f') {
              Swal.fire({
                icon: 'info',
                text: item.omensaje,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
              }).then((result) => {
                $.ajax({
                  url: "<?php echo site_url('facturacion/C_factura_manual/cantidad_producto') ?>",
                  type: "POST",
                  data: {
                    dato1: idventa,
                    dato2: msg.value
                  },
                  success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    con.innerHTML = '';
                    let total = 0.000;
                    for (var i = 0; i < json.length; i++) {

                      let num = parseFloat(json[i].oprecio);
                      total = total + num;
                      var id = json[i].oidventa;
                      var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                      var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                      con.innerHTML = con.innerHTML +
                        '<tr>' +
                        '<td>' + json[i].ocodigo + '</td>' +
                        '<td>' + json[i].onombre + '</td>' +
                        '<td>' +
                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                        '</td>' +
                        '</td>' +
                        '<td>' +
                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                        '</td>' +
                        '<td>' +
                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                        '</td>' +
                        '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                        '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
                        '<td style="width: 10%" align="center">' +
                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                        '</td>' +
                        '</form>' +
                        '</tr>'
                    }
                    total = total.toFixed(2);
                    $("#total").html(total);
                    $('#total_venta').val(total).trigger('change');
                    $('#pagado').val("0.00").trigger('change');
                    $('#cambio_venta').val("").trigger('change');
                    $("#cambio").html("");
                    document.getElementById("id_producto").focus();
                    document.getElementById("id_producto").select();
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                  }
                });
              })
            } else {
              $.ajax({
                url: "<?php echo site_url('facturacion/C_factura_manual/cantidad_producto') ?>",
                type: "POST",
                data: {
                  dato1: idventa,
                  dato2: msg.value
                },
                success: function(respuesta) {
                  var json = JSON.parse(respuesta);
                  con.innerHTML = '';
                  let total = 0.000;
                  for (var i = 0; i < json.length; i++) {

                    let num = parseFloat(json[i].oprecio);
                    total = total + num;
                    var id = json[i].oidventa;
                    var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                    var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                    con.innerHTML = con.innerHTML +
                      '<tr>' +
                      '<td>' + json[i].ocodigo + '</td>' +
                      '<td>' + json[i].onombre + '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                      '</td>' +
                      '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                      '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' + i + '" id="precio' + i + '" value="' + precio_total + '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                      '</td>' +
                      '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                      '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa + '"></input>' +
                      '<td style="width: 10%" align="center">' +
                      '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' + json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' + '</button>' +
                      '<label>&nbsp;&nbsp;&nbsp;</label>' +
                      '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' + json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                      '</td>' +
                      '</form>' +
                      '</tr>'
                  }
                  total = total.toFixed(2);
                  $("#total").html(total);
                  $('#total_venta').val(total).trigger('change');
                  $('#pagado').val("0.00").trigger('change');
                  $('#cambio_venta').val("").trigger('change');
                  $("#cambio").html("");
                  document.getElementById("id_producto").focus();
                  document.getElementById("id_producto").select();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error al obtener datos de ajax');
                }
              });
            }
          });

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }
  }
</script>
<!--js validar-->
<script type="text/javascript">
  $(document).ready(function() {
    $("#deuda").click(function() {
      valor = document.getElementById("razonSocial").value;
      valor1 = document.getElementById("nit").value;
      pago = document.getElementById("pagado").value;

      if (valor == null || valor.length == 0 || valor1 == null || valor1.length == 0) {
        //alert('Debe ingresar el cliente');
        document.getElementById("miForm").reset();
        //document.getElementById("deuda").value = "";
        document.getElementById("pagado").value = pago;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Debe ingresar el cliente',
          confirmButtonColor: '#d33',
          confirmButtonText: 'ACEPTAR'
        })
      } else {
        document.getElementById("cam").innerHTML = "Saldo";
        $('#pagado').val("0.00").trigger('change');
        $('#cambio_venta').val("").trigger('change');
        $("#cambio").html("");
      }

    });
    // $("#efectivo").click(function() {
    //   document.getElementById("cam").innerHTML = "Cambio";
    //   $('#pagado').val("0.00").trigger('change');
    //   $('#cambio_venta').val("").trigger('change');
    //   $("#cambio").html("");
    // });
    // $("#tarjeta").click(function() {
    //   document.getElementById("cam").innerHTML = "Cambio";
    //   $('#pagado').val("0.00").trigger('change');
    //   $('#cambio_venta').val("").trigger('change');
    //   $("#cambio").html("");
    // });
  });
</script>

<script type="text/javascript">
  function ver_imagen(oimagen) {
    if (oimagen == null || oimagen == '' || oimagen == "null") {
      dato = '<img src="<?php echo base_url(); ?>assets/img/productos/sin_imagen.jpg" class="img-responsive">';
      document.getElementById("verImagen").innerHTML = dato;
    } else {
      dato = '<img src="<?php echo base_url(); ?>assets/img/productos/' + oimagen + '" class="img-responsive">';
      document.getElementById("verImagen").innerHTML = dato;
    };
  };
</script>

<script type="text/javascript">
  function limpiar() {
    var nom = document.getElementById("nit").value;
    var nit = document.getElementById("razonSocial").value;
    if (nom == "") {
      $('#razonSocial').val("").trigger('change');
    }
    if (nit == "") {
      $('#nit').val("").trigger('change');
    }
  }

  function validadesc() {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    console.log(charCode);
    if (charCode == 9 || charCode == 13 || charCode == 39) {
      let total = document.getElementById("total_venta").value;
      total = (parseFloat(total)).toFixed(2);
      let descuento = document.getElementById("descuento").value;
      descuento = (parseFloat(descuento)).toFixed(2);

      console.log(descuento);
      console.log(total);

      if (Math.floor(descuento * 100) > Math.floor(total * 100)) {
        $('#descuento').val(total).trigger('change');
        console.log(3)
      } else if (Math.floor(descuento * 100) < 0.00) {
        $('#descuento').val('0.00').trigger('change');
        console.log(4)
      } else {
        $('#descuento').val(descuento).trigger('change');
        console.log(5)
      }
    }


  }

  function comprobar_documento() {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if (charCode == 9 || charCode == 13) {
      tipo_documento = document.getElementById("docs_identidad");
      var tipo = tipo_documento.options[tipo_documento.selectedIndex].value;
      if (tipo == 5) {
        var nit = document.getElementById('nit').value;
        let timerInterval;
        if (nit != "") {
          Swal.fire({
            title: 'Vericando Nit...',
            timer: 100000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          });
          $.ajax({
            url: '<?= base_url() ?>facturacion/C_factura_manual/verificar_nit',
            type: "POST",
            dataType: "JSON",
            data: {
              nit: nit,
            },
            success: function(data) {
              console.log(data);
              var resp = data.RespuestaVerificarNit.transaccion;
              console.log(resp);
              if (resp == false) {
                Swal.fire({
                  icon: 'warning',
                  title: data.RespuestaVerificarNit.mensajesList.descripcion,
                  html: 'Desea autorizar el registro de una factura con NIT inválido',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'ACEPTAR',
                  showCancelButton: true,
                  cancelButtonText: 'CANCELAR',
                  cancelButtonColor: '#d33',
                }).then((result) => {
                  if (result.isConfirmed) {
                    document.getElementById('codigoExcepcion').value = '1';
                  } else {
                    document.getElementById('codigoExcepcion').value = '0';
                  }
                })
              } else {
                Swal.fire({
                  icon: 'success',
                  title: data.RespuestaVerificarNit.mensajesList.descripcion,
                  text: 'Conforme a normativa vigente el proceso de verificación de NIT del Sistema Informático de Facturación autorizado.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'ACEPTAR',
                }).then((result) => {
                  document.getElementById('codigoExcepcion').value = '0';
                })


              }

            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error al obtener datos de ajax');
            }
          });
        }
      }
    }
  }

  function mostrar_tr() {

    console.log(document.getElementsByName('contact'));
    //efectivo tarjeta tarQR tareg deuda
    // gifcar nro_tarjeta pagado
    valor = document.getElementById('efectivo');
    if (valor.checked) {
      document.getElementById('tr_efectivo').style.display = "table-row";
    } else {
      document.getElementById('tr_efectivo').style.display = "none";
      //valor.value = 0.00;
      document.getElementById('gifcar').value = '0.00';
    }

    valor = document.getElementById('tarjeta');
    if (valor.checked) {
      document.getElementById('tr_tarjeta').style.display = "table-row";
      document.getElementById('tr_tarjeta2').style.display = "table-row";
    } else {
      document.getElementById('tr_tarjeta').style.display = "none";
      document.getElementById('tr_tarjeta2').style.display = "none";
      document.getElementById('monto_tarjeta').value = '0.00';
      document.getElementById('nro_tarjeta').value = '';
      //valor.value = 0.00;
    }

    valor = document.getElementById('tareg');
    if (valor.checked) {
      document.getElementById('tr_gifcard').style.display = "table-row";
    } else {
      document.getElementById('tr_gifcard').style.display = "none";
      document.getElementById('pagado').value = '0.00';
      //valor.value = 0.00;
    }


    // for (i = 0; valorActivo.length; i++) {
    //   if (valorActivo[i].checked)

    //     console.log(valorActivo[i]);

    // }
    // if (valorActivo == 'tareg') {
    //   document.getElementById('tr_gifcard').style.display = "table-row";
    // }else if(valorActivo == 'tarjeta') {
    //   document.getElementById('tr_tarjeta').style.display = "table-row";
    // } else {
    //   document.getElementById('tr_gifcard').style.display = "none";
    // }
    // document.getElementById('gifcar').value = 0;
  }

  function mostrar_tr1() {
    let valor = document.getElementById('tipo_documento').value;


    //efectivo tarjeta tarQR tareg deuda
    // 1949 = Efectivo
    if (valor == '1949') {
      document.getElementById("efectivo").checked = true;
      document.getElementById("tarjeta").checked = false;
      document.getElementById("tarQR").checked = false;
      document.getElementById("tareg").checked = false;
      document.getElementById("deuda").checked = false;
      document.getElementById('tr_otros').style.display = "none";
    } else if (valor == '1950') {
      document.getElementById("efectivo").checked = false;
      document.getElementById("tarjeta").checked = true;
      document.getElementById("tarQR").checked = false;
      document.getElementById("tareg").checked = false;
      document.getElementById("deuda").checked = false;
      document.getElementById('tr_otros').style.display = "none";
    } else if (valor == '1975') {
      document.getElementById("efectivo").checked = false;
      document.getElementById("tarjeta").checked = false;
      document.getElementById("tarQR").checked = false;
      document.getElementById("tareg").checked = true;
      document.getElementById("deuda").checked = false;
      document.getElementById('tr_otros').style.display = "none";
    } else {
      document.getElementById("efectivo").checked = false;
      document.getElementById("tarjeta").checked = false;
      document.getElementById("tarQR").checked = false;
      document.getElementById("tareg").checked = false;
      document.getElementById("deuda").checked = false;
      document.getElementById('tr_otros').style.display = "table-row";
    }



    mostrar_tr()
  }

  function modaltipoFactura() {
    //$('#finalizar_venta').modal('show');
    console.log(2);
  }

  function tipo_doc() {
    tipo_documento = document.getElementById("docs_identidad");
    var tipo = tipo_documento.options[tipo_documento.selectedIndex].value;
    if (tipo == 1) {
      document.getElementById('l_complemento').style.display = "inline-block";
      document.getElementById('complemento').style.display = "inline-block";
    }else {
      document.getElementById('l_complemento').style.display = "none";
      document.getElementById('complemento').style.display = "none";
    }
    $('#nit').val('').trigger('change');
    $('#razonSocial').val('').trigger('change');
    $('#complemento').val('').trigger('change');
    $('#codigoExcepcion').val('0').trigger('change');
  }

  function tipo_otros_doc() {
    var otros_documentos = document.getElementById("otros_documentos");
    otros_documentos = otros_documentos.options[otros_documentos.selectedIndex].value;
    if (otros_documentos == 99001) {
      $('#nit').val(otros_documentos).trigger('change');
      $('#razonSocial').val('').trigger('change');
    } else if (otros_documentos == 99002) {
      $('#nit').val(otros_documentos).trigger('change');
      $('#razonSocial').val('Control Tributario').trigger('change');
    } else {
      $('#nit').val(otros_documentos).trigger('change');
      $('#razonSocial').val('VENTAS MENORES DEL DÍA').trigger('change');
    }
  }

  function getCardType(cardNo) {
    var cards = {
      "American Express": /^3[47][0-9]{13}$/,
      "Mastercard": /^5[1-5][0-9]{14}$/,
      "Visa": /^4[0-9]{12}(?:[0-9]{3})?$/
    };

    for (var card in cards) {
      if (cards[card].test(cardNo)) {
        return card;
      }
    }
    return undefined;
  }

  function verificar_tarjeta() {
    if ($('#nro_tarjeta').val().trim() != '') {
      var value = $('#nro_tarjeta').val().trim();
      var cardType = getCardType(value);
      if (!cardType) {
        Swal.fire({
          icon: 'warning',
          title: 'Error',
          text: 'La tarjeta es invalida',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'ACEPTAR',
        }).then((result) => {
          document.getElementById('nro_tarjeta').value = '';
        })
      } else {
        Swal.fire({
          icon: 'success',
          title: 'Exito',
          text: 'La tarjeta introducida es correcta' + ', tipo: ' + cardType,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'ACEPTAR',
        }).then((result) => {
          new_tarjeta = value.substring(0, 4) + Array(value.length - 8).join("0") + value.substring(value.length - 4);
          document.getElementById('nro_tarjeta').value = new_tarjeta;
        })

        //$(this).val(Array(value.length-4).join("X")+value.substring(value.length-4));
      }
    }

  };

  function mostrar_tasa() {
    tipofactura = document.getElementById("tipofactura");
    var tipo = tipofactura.options[tipofactura.selectedIndex].value;
    if (tipo == 41) {
      document.getElementById('tr_tasa').style.display = "table-row";
      $('#monto_tasa').val('0.00').trigger('change');
    } else {
      document.getElementById('tr_tasa').style.display = "none";
      $('#monto_tasa').val('0.00').trigger('change');
    }
  }
</script>