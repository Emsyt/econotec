<?php
/*
    -------------------------------------------------------------------------------
    Creador: Deivit Pucho Aguilar Fecha:26/09/2022, Codigo:GAN-FR-A1-483
    Descripcion:Creacion de la vista cotizaciones.
    -------------------------------------------------------------------------------
    Modificado: Melani Alisson Cusi Burgoa  Fecha:02/12/2022, Codigo: GAN-PN-M6-0163
    Descripcion: Se modifico la fec_validez al cargar la vista.
    -------------------------------------------------------------------------------
    Modificado: Briyan Julio Torrez Vargas  Fecha: 03/02/2023,  Codigo: GAN-MS-B0-0214
    Descripción: Se elimino la función fecha validez ya que se trae desde la bd
    -------------------------------------------------------------------------------
    Modificado: Ariel Ramos Paucara  Fecha: 11/04/2023,  Codigo: GAN-MS-M0-0411
    Descripción: Se corrigió las cajas de texto nit, razón social, fecha y observaciones en la parte del front para tamaños móvil.  
*/
?>
<?php if (in_array("smod_cotz", $permisos)) { ?>
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
  $(document).ready(function () {
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('venta/C_cotizaciones/get_fecha_validez')?>",
      success: function (response) {
        let data = JSON.parse(response);
        let fecha_validez = data[0].fn_get_fecha_validez;
        fecha_validez = fecha_validez.split("-");
        let fechaString = fecha_validez[0]+"/"+fecha_validez[1]+"/"+fecha_validez[2];
        $('#fec_validez').datepicker({
          format: "yyyy/mm/dd" 
        }).datepicker("setDate", fechaString);
      }
    });
  });
</script>
<script>
  var cont_pedido = $("#contador").val();
  $(document).ready(function() {
    activarMenu('menu5_6');
    let username = getCookie("Cliente");
    if (username != null) {
      document.getElementById("nit").value = username;
      valor_nit = document.getElementById("nit").value;
      if (valor_nit != "" && valor_nit != null) {
        agregar_nombre();
      }
    }


  });

</script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
  ;
  //jQuery.noConflict();
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
    .contenedor-flexbox {
    display: flex; /*Convertimos al menú en flexbox*/
    /*justify-content: space-between; /*Con esto le indicamos que margine todos los items que se encuentra adentro hacia la derecha e izquierda*/
    align-items: baseline; /*con esto alineamos de manera vertical*/
    }
</style>
<!-- Inicio Ariel Ramos GAN-MS-M0-0411 -->
<style>
    @media only screen and (max-width: 827px) {
      .contenedor-flexbox {
            flex-direction: column;
        }
        .contenedor-flexbox > div {
            width: 100% !important;
            margin-bottom: 10px;
            display: block;
        }
        .contenedor-flexbox > div > input {
            width: 100% !important;
        }
        div#demo-date {
            width: 100% !important;
        }
        .obs {
            width: 100% !important;
        }
        .obs > textarea {
            width: 100% !important;
        }
    }
</style>
<!-- Fin Ariel Ramos GAN-MS-M0-0411 -->
<!-- BEGIN CONTENT-->
<div id="content">
  <section>
    <div class="section-header">
      <ol class="breadcrumb">
        <li><a href="#">Venta</a></li>
        <li class="active">Cotizaciones</li>
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
                <div class="contenedor-flexbox">
                    <div style="width: 17%;">
                        <label>CI/NIT/Cod. Cliente </label><br>
                        <input type="number"  min= "0"  name="nit" id="nit" onkeypress="onkeypress_nit_razonSocial()" style="border:1px solid #c7254e;">
                    </div>
                    <div style="width: 30%;">
                        <label>Nombre/Razon Social </label><br>
                        <input name="razonSocial" id="razonSocial" type="text" onkeypress="onkeypress_nit_razonSocial()" style="border:1px solid #c7254e; width: 80%;">
    
                    </div>
                    
                    <div class="form-group" style="width: 30%;">
                        <label >Fecha </label><br>
                        <div class="input-group date" id="demo-date"  style="width: 50%;">
                            <div class="input-group-content">
                                <input id="fec_validez" type="text" class="form-control fec" readonly="" required>
                            </div>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>

                </div>
                <div class="obs" style="width: 60%;">
                        <label>Observaciones</label><br>
                        <textarea class="form-control" id="area_observaciones" rows="3" style="width:80%"></textarea>
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
                    <td style="width: 5%">
                      <form method="post" id="base_form" onsubmit=" return listar(this);">
                        <input type="text" class="formulario" size="1" style="width : 150px" maxlength="50" name="id_producto" id="id_producto">
                      </form>
                    </td>
                    <td style="width: 30%">
                      <form method="post" id="form_nombre" onsubmit=" return listar1(this);">
                        <input type="text" class="formulario" size="1" style="width : 550px" maxlength="5000" name="nombre_producto" id="nombre_producto" onkeydown="onkeydown_nombre_producto()">
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
                    
                    </tfoot-->
                </table>
                <div class="modal-footer">
                  <button type="submit" id="btnFinalizar" class="btn btn-primary " onclick="finalizar();">Finalizar</button>
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
<!-- Modal info stock -->
<div class="modal fade" id="infoStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ver Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Locación</th>
            <th scope="col">Cantidad</th>
          </tr>
        </thead>
        <tbody id="tstock">
        </tbody>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clear_modal()">Cerrar</button>
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
          <h3 class="modal-title">IMPRIMIR COTIZACION!!</h3>
        </center>
      </div>
      <div class="modal-body">
        <center>
          <img src="<?= base_url() ?>assets/img/icoLogo/imp.png" width="100px" height="100px" alt="Avatar" class="image"><br><br>
          <font size="3">Desea recibir un recibo de la compra?</font>
        </center>
      </div>
      <div class="modal-footer">
        <center>
          <form class="form" name="conf_pedido" id="conf_pedido" method="post" target="_blank" action="<?= site_url() ?>pdf_cotizacion">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <output id="idventa"></output>
              </div>
              <button type="button" class="btn ink-reaction btn-raised btn-primary" onclick="enviar()">Si</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="finalizar_compra()">Salir</button>
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
      url: "<?php echo site_url('venta/C_cotizaciones/dlt_pedido') ?>",
      type: "POST",
      data: {
        buscar: id_venta
      },
      success: function(respuesta) {
        if (respuesta) {
          $.ajax({
            url: "<?php echo site_url('venta/C_cotizaciones/mostrar_produc') ?>",
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
                  '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                  '</td>' +
                  '</td>' +
                  '<td>' +
                     '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
                  '<label>&nbsp;&nbsp;&nbsp;</label>' +
                  '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                  '</td>' +
                  '</form>' +
                  '</tr>'
              }
              total = total.toFixed(2);
              $("#total").html(total);
              $('#total_venta').val(total).trigger('change');
              $('#pagado').val("").trigger('change');
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
    document.getElementById("conf_pedido").submit();
    document.cookie = "Cliente = ;";
    window.location.reload();
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
    dato = 2;
    total = document.getElementById("total_venta").value;
    let obs = document.getElementById("area_observaciones").value;
    obs = obs.replace(/\n/g, "<br />");
    cambio = 1;
    var tipo = "";
    var id_tipo="Contado";
    var total2 = 1;
    
    total2=total2.toFixed(2);
    console.log(total2 + "-" + total);

   
          var newMessage = "";
          $.ajax({
            url: "<?php echo site_url('venta/C_cotizaciones/verifica_cliente') ?>",
            type: "POST",
            data: {
              valor_nit: valor_nit
            },
            success: function(result) {
              var r = JSON.parse(result);
              r = r[0]["fn_verifica_cliente"];
              if ((r == "f") && (razonSocial !== "")) {
                $.ajax({
                  url: "<?php echo site_url('venta/C_cotizaciones/registrar') ?>",
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
                        text: "int1",
                        // text: res[0]["omensaje"],
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
                        url: "<?php echo site_url('venta/C_cotizaciones/lst_tipo_venta') ?>",
                        type: "POST",
                        success: function(resp) {
                          var c = JSON.parse(resp);

                          if ($("#efectivo").is(':checked')) {
                            tipo = "Contado";
                          } else if ($("#tarjeta").is(':checked')) {
                            tipo = "Tarjeta";
                          } else if ($("#tarQR").is(':checked')) {
                            tipo = "QR";
                          }else{
                            tipo = "A Deuda";
                          }
                          for (var i = 0; i < c.length; i++) {
                            if (c[i].otipo == tipo) {
                              id_tipo = c[i].oidtipo;
                            }
                          }
                          if (dato != null && dato >= 0 && dato != "" && total >= 0 && total != null && total != "" && cambio >= 0 && cambio != null && cambio != "") {
                            console.log(tipo);
                            $.ajax({
                              url: "<?php echo site_url('venta/C_cotizaciones/relizar_cobro') ?>",
                              type: "POST",
                              data: {
                                valor_nit: valor_nit,
                                tipo: id_tipo,
                                obs:obs
                              },
                              success: function(resp) {
                                var c = JSON.parse(resp);
                                console.log(c);
                                $.each(c, function(i, item) {
                                  if (item.oestado == 't') {
                                    Swal.fire({
                                      icon: 'success',
                                      title: 'PEDIDO REALIZADO' + newMessage,
                                      text:'IMPRIMIR COTIZACION',
                                      showCancelButton: true,
                                      confirmButtonColor: '#3085d6',
                                      cancelButtonColor: '#d33',
                                      confirmButtonText: 'ACEPTAR'
                                    }).then((result) => {
                                      if (result.isConfirmed) {
                                        //jQuery.noConflict();
                                        dato = '<input type="hidden" name="id_cotizacion" value="' + item.idventa + '"><input type="hidden" name="pagado" value="' + dato + '">';
                                        document.getElementById("idventa").innerHTML = dato;
                                        document.getElementById("conf_pedido").submit();
                                        document.cookie = "Cliente = ;";
                                        window.location.reload();
                                        //$('#finalizar_venta').modal('show');
                                      }else{
                                        document.cookie = "Cliente = ;";
                                        window.location.reload();
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
                              });};
                           

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
                  url: "<?php echo site_url('venta/C_cotizaciones/lst_tipo_venta') ?>",
                  type: "POST",
                  success: function(resp) {
                    var c = JSON.parse(resp);

                    if ($("#efectivo").is(':checked')) {
                      tipo = "Contado";
                    } else if ($("#tarjeta").is(':checked')) {
                      tipo = "Tarjeta";
                    } else if ($("#tarQR").is(':checked')) {
                      tipo = "QR";
                    }else{
                      tipo = "A Deuda";
                    }
                    for (var i = 0; i < c.length; i++) {
                      if (c[i].otipo == tipo) {
                        id_tipo = c[i].oidtipo;
                      }
                    }
                    if (dato != null && dato >= 0 && dato != "" && total >= 0 && total != null && total != "" && cambio >= 0 && cambio != null && cambio != "") {
                      console.log(tipo);
                      $.ajax({
                        url: "<?php echo site_url('venta/C_cotizaciones/relizar_cobro') ?>",
                        type: "POST",
                        data: {
                          valor_nit: valor_nit,
                          tipo: id_tipo,
                          obs:obs
                        },
                        success: function(resp) {
                          var c = JSON.parse(resp);
                          $.each(c, function(i, item) {
                            // if (item.oestado == 't') {
                              Swal.fire({
                                icon: 'success',
                                title: 'PEDIDO REALIZADO',
                                text:'IMPRIMIR COTIZACION',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ACEPTAR'
                              }).then((result) => {
                                if (result.isConfirmed) {
                                  //jQuery.noConflict();
                                        dato = '<input type="hidden" name="id_cotizacion" value="' + item.idventa + '"><input type="hidden" name="pagado" value="' + dato + '">';
                                        document.getElementById("idventa").innerHTML = dato;
                                        document.getElementById("conf_pedido").submit();
                                        document.cookie = "Cliente = ;";
                                  window.location.reload();
                                  //$('#finalizar_venta').modal('show');
                                }else{
                                  document.cookie = "Cliente = ;";
                                  window.location.reload();
                                }
                              })
                           
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
                        $('#pagado').val("").trigger('change');
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

    var tipo;
    if ($("#deuda").is(':checked')) {
      tipo = 0;
    } else {
      tipo = 1;
    }



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
      url: "<?php echo site_url('venta/C_cotizaciones/mostrar_nit') ?>",
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
              url: "<?php echo site_url('venta/C_cotizaciones/mostrar_nombre') ?>",
              type: "POST",
              data: {
                buscar: item.item.value
              },
              success: function(resp) {
                var c = JSON.parse(resp);
                $.each(c, function(i, item) {
                  $("#razonSocial").val(item.fn_recuperar_cliente);
                });
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
      url: "<?php echo site_url('venta/C_cotizaciones/mostrar_lts_nombre') ?>",
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
              url: "<?php echo site_url('venta/C_cotizaciones/mostrar_nit_usuario') ?>",
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
    valor_nit = document.getElementById("nit").value;
    $.ajax({
      url: "<?php echo site_url('venta/C_cotizaciones/mostrar_nombre') ?>",
      type: "POST",
      data: {
        buscar: valor_nit
      },
      success: function(resp) {
        var c = JSON.parse(resp);
        $.each(c, function(i, item) {
          $("#razonSocial").val(item.fn_recuperar_cliente);
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }
</script>

<!--js para buscar codigo-->
<script type="text/javascript">
  $(document).ready(function() {
    var codigo = [];
    $.ajax({
      url: "<?php echo site_url('venta/C_cotizaciones/mostrar_codigo') ?>",
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
    pago = parseFloat(form.pagado.value);
    total = parseFloat(document.getElementById("total_venta").value);
    var tipo = "";
    var id_tipo;
    $.ajax({
      url: "<?php echo site_url('venta/C_cotizaciones/lst_tipo_venta') ?>",
      type: "POST",
      success: function(resp) {
        var c = JSON.parse(resp);

        if ($("#efectivo").is(':checked')) {
          tipo = "Contado";
        } else if ($("#tarjeta").is(':checked')) {
          tipo = "Tarjeta";
        } else if ($("#tarQR").is(':checked')) {
          tipo = "QR";
        }else{
          tipo = "A Deuda";
        }
        for (var i = 0; i < c.length; i++) {
          if (c[i].otipo == tipo) {
            id_tipo = c[i].oidtipo;
          }
        }
        if (pago < total && $("#deuda").is(':checked')) {
          $.ajax({
            url: "<?php echo site_url('venta/C_cotizaciones/calcular_cambio') ?>",
            type: "POST",
            data: {
              pagado: pago,
              id_tipo: id_tipo
            },
            success: function(resp) {
              var c = JSON.parse(resp);
              $.each(c, function(i, item) {
                let omonto = (parseFloat(item.omonto)).toFixed(2);
                let ocambio_saldo = (parseFloat(item.ocambio_saldo)).toFixed(2);
                let ototal = (parseFloat(item.ototal)).toFixed(2);
                $("#pagado").val(omonto);
                $("#cambio").html(ocambio_saldo);
                $('#cambio_venta').val(ocambio_saldo).trigger('change');
                $("#total").html(ototal);
              });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error al obtener datos de ajax');
            }
          });
        } else if (pago >= total && $("#deuda").is(':checked')) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debe ingresar un valor menor al total',
            confirmButtonColor: '#d33',
            confirmButtonText: 'ACEPTAR'
          })
        } else if (pago >= total && ($("#efectivo").is(':checked') || $("#tarjeta").is(':checked')) || $("#tarQR").is(':checked') && total != 0) {
          $.ajax({
            url: "<?php echo site_url('venta/C_cotizaciones/calcular_cambio') ?>",
            type: "POST",
            data: {
              pagado: pago,
              id_tipo: id_tipo
            },
            success: function(resp) {
              var c = JSON.parse(resp);
              $.each(c, function(i, item) {
                let omonto = (parseFloat(item.omonto)).toFixed(2);
                let ocambio_saldo = (parseFloat(item.ocambio_saldo)).toFixed(2);
                let ototal = (parseFloat(item.ototal)).toFixed(2);
                $("#pagado").val(omonto);
                $("#cambio").html(ocambio_saldo);
                $('#cambio_venta').val(ocambio_saldo).trigger('change');
                $("#total").html(ototal);
              });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error al obtener datos de ajax');
            }
          });
        } else if (total == 0) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debe ingresar un producto para continuar con la venta',
            confirmButtonColor: '#d33',
            confirmButtonText: 'ACEPTAR'
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debe ingresar un valor mayor ó igual al total',
            confirmButtonColor: '#d33',
            confirmButtonText: 'ACEPTAR'
          })
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });

    return false;
  }
</script>

<!--js para buscar nombre de un producto-->
<script type="text/javascript">
  $(document).ready(function() {
    var nombre = [];
    $.ajax({
      url: "<?php echo site_url('venta/C_cotizaciones/mostrar_producto') ?>",
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
      url: "<?php echo site_url('venta/C_cotizaciones/mostrar_produc') ?>",
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
            '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
            '</td>' +
            '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
            '<label>&nbsp;&nbsp;&nbsp;</label>' +
            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
            '</td>' +
            '</form>' +
            '</tr>'
        }
        total = total.toFixed(2);
        $("#total").html(total);
        $('#total_venta').val(total).trigger('change');
        $('#pagado').val("").trigger('change');
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
    let obs = '';
    let fec_validez = document.getElementById("fec_validez").value;
    console.log(fec_validez);
    $.ajax({
      url: "<?php echo site_url('venta/C_cotizaciones/datos_producto') ?>",
      type: "POST",
      data: {
        buscar: codigo,
        observacion: obs,
        fec_val: fec_validez
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
            '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
            '</td>' +
            '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
            '<label>&nbsp;&nbsp;&nbsp;</label>' +
            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
            '</td>' +
            '</form>' +
            '</tr>'
        }
        total = total.toFixed(2);
        $("#total").html(total);
        document.getElementById("base_form").reset();
        $('#total_venta').val(total).trigger('change');
        $('#pagado').val("").trigger('change');
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
    codigo = codigo.split('//');
    codigo =  codigo[0];
    let obs = document.getElementById("area_observaciones").value;
    let fec_validez = document.getElementById("fec_validez").value;
    $.ajax({
      url: "<?php echo site_url('venta/C_cotizaciones/datos_nombre') ?>",
      type: "POST",
      data: {
        buscar: codigo,
        observacion: obs,
        fec_val: fec_validez
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
            '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
            '</td>' +
            '</td>' +
            '<td>' +
            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
            '<label>&nbsp;&nbsp;&nbsp;</label>' +
            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
            '</td>' +
            '</form>' +
            '</tr>'
        }
        total = total.toFixed(2);
        $("#total").html(total);
        document.getElementById("form_nombre").reset();
        $('#total_venta').val(total).trigger('change');
        $('#pagado').val("").trigger('change');
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
<!--js precio inicial-->
<script>
  function onkeydown_precio_uni(msg, idventa, dato) {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if (charCode == 9 || charCode == 13 || charCode == null) {
      $.ajax({
        url: "<?php echo site_url('venta/C_cotizaciones/verificar_cambio_precio') ?>",
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
                    url: "<?php echo site_url('venta/C_cotizaciones/cambio_precio_uni') ?>",
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
                          '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
                          '<label>&nbsp;&nbsp;&nbsp;</label>' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                          '</td>' +
                          '</form>' +
                          '</tr>'
                      }
                      total = total.toFixed(2);
                      $("#total").html(total);
                      $('#total_venta').val(total).trigger('change');
                      $('#pagado').val("").trigger('change');
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
                    url: "<?php echo site_url('venta/C_cotizaciones/mostrar_produc') ?>",
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
                          '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
                          '<label>&nbsp;&nbsp;&nbsp;</label>' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                          '</td>' +
                          '</form>' +
                          '</tr>'
                      }
                      total = total.toFixed(2);
                      $("#total").html(total);
                      $('#total_venta').val(total).trigger('change');
                      $('#pagado').val("").trigger('change');
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
                url: "<?php echo site_url('venta/C_cotizaciones/cambio_precio_uni') ?>",
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
                      '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                      '</td>' +
                      '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
                      '<label>&nbsp;&nbsp;&nbsp;</label>' +
                      '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                      '</td>' +
                      '</form>' +
                      '</tr>'
                  }
                  total = total.toFixed(2);
                  $("#total").html(total);
                  $('#total_venta').val(total).trigger('change');
                  $('#pagado').val("").trigger('change');
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
<!--js precio total-->
<script>
  function onkeydown_cant(msg, idventa) {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if (charCode == 9 || charCode == 13) {
      $.ajax({
        url: "<?php echo site_url('venta/C_cotizaciones/verificar_cambio_precio_total') ?>",
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
                    url: "<?php echo site_url('venta/C_cotizaciones/cambiar_precio') ?>",
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
                          '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
                          '<label>&nbsp;&nbsp;&nbsp;</label>' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
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
                    url: "<?php echo site_url('venta/C_cotizaciones/mostrar_produc') ?>",
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
                          '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                          '</td>' +
                          '</td>' +
                          '<td>' +
                          '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
                          '<label>&nbsp;&nbsp;&nbsp;</label>' +
                          '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                          '</td>' +
                          '</form>' +
                          '</tr>'
                      }
                      total = total.toFixed(2);
                      $("#total").html(total);
                      $('#total_venta').val(total).trigger('change');
                      $('#pagado').val("").trigger('change');
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
                url: "<?php echo site_url('venta/C_cotizaciones/cambiar_precio') ?>",
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
                      '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                      '</td>' +
                      '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
                      '<label>&nbsp;&nbsp;&nbsp;</label>' +
                      '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
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
      document.getElementById("id_producto").focus();
      document.getElementById("id_producto").select();
    }
  };
  
  $("#nit").keyup(function () {
    
    var valor = $(this).prop("value");

    if (valor < 0)
        $(this).prop("value", " ");
    })


  function onkeydown_nombre_producto() {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if (charCode == 9) {
      let con = document.getElementById('con');
      var codigo = document.getElementById("nombre_producto").value;
      $.ajax({
        url: "<?php echo site_url('venta/C_cotizaciones/datos_nombre') ?>",
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
              '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
              '</td>' +
              '</td>' +
              '<td>' +
              '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
              '<label>&nbsp;&nbsp;&nbsp;</label>' +
              '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
              '</td>' +
              '</form>' +
              '</tr>'
          }
          total = total.toFixed(2);
          $("#total").html(total);
          document.getElementById("form_nombre").reset();
          $('#total_venta').val(total).trigger('change');
          $('#pagado').val("").trigger('change');
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
<!--js cambiar cantidad-->
<script>
  function onkeydown_cantidad(msg, idventa, dato) {
    var e = event || evt;
    var charCode = e.which || e.keyCode;
    if (charCode == 9 || charCode == 13 || charCode == null) {
      $.ajax({
        url: "<?php echo site_url('venta/C_cotizaciones/verifica_cantidad') ?>",
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
                  url: "<?php echo site_url('venta/C_cotizaciones/cantidad_producto') ?>",
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
                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                        '</td>' +
                        '</td>' +
                        '<td>' +
                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                        '</td>' +
                        '</form>' +
                        '</tr>'
                    }
                    total = total.toFixed(2);
                    $("#total").html(total);
                    $('#total_venta').val(total).trigger('change');
                    $('#pagado').val("").trigger('change');
                    $('#cambio_venta').val("").trigger('change');
                    $("#cambio").html("");
                    document.getElementById("id_producto").focus();
                    document.getElementById("id_producto").select();
                  },
                  
                  error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax1');
                  }
                });
              })
            } else {
              console.log(idventa);
              console.log(msg.value);
              $.ajax({
                url: "<?php echo site_url('venta/C_cotizaciones/cantidad_producto') ?>",
                type: "POST",
                data: {
                  dato1: idventa,
                  dato2: msg.value
                },
                success: function(respuesta) {
                  var json = JSON.parse(respuesta);
                  console.log(json);
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
                      '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' + i + '" id="cantidad' + i + '" value="' + json[i].ocantidad + '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                      '</td>' +
                      '</td>' +
                      '<td>' +
                      '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' + i + '" id="precio_uni' + i + '" value="' + precio_unidad + '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
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
                      '<label>&nbsp;&nbsp;&nbsp;</label>' +
                      '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(' + json[i].ocodigo + ')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                      '</td>' +
                      '</form>' +
                      '</tr>'
                  }
                  total = total.toFixed(2);
                  $("#total").html(total);
                  $('#total_venta').val(total).trigger('change');
                  $('#pagado').val("").trigger('change');
                  $('#cambio_venta').val("").trigger('change');
                  $("#cambio").html("");
                  document.getElementById("id_producto").focus();
                  document.getElementById("id_producto").select();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error al obtener datos de ajax2');
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
        $('#pagado').val("").trigger('change');
        $('#cambio_venta').val("").trigger('change');
        $("#cambio").html("");
      }

    });
    $("#efectivo").click(function() {
      document.getElementById("cam").innerHTML = "Cambio";
      $('#pagado').val("").trigger('change');
      $('#cambio_venta').val("").trigger('change');
      $("#cambio").html("");
    });
    $("#tarjeta").click(function() {
      document.getElementById("cam").innerHTML = "Cambio";
      $('#pagado').val("").trigger('change');
      $('#cambio_venta').val("").trigger('change');
      $("#cambio").html("");
    });
    $("#tarQR").click(function() {
      document.getElementById("cam").innerHTML = "Cambio";
      $('#pagado').val("").trigger('change');
      $('#cambio_venta').val("").trigger('change');
      $("#cambio").html("");
    });
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
</script>

<script type="text/javascript">
function mostrar_stock(codigo){
  var contenido = document.getElementById("tstock");
  $.ajax({
          url: "<?php echo site_url('venta/C_cotizaciones/mostrar_stock_total') ?>",
          type: "POST",
          data: {
            dato1: codigo
          },
          success: function(respuesta) {
            var json = JSON.parse(respuesta);
            console.log(json);
            contenido.innerHTML = '';
            for (var i = 0; i < json.length; i++) {

              contenido.innerHTML = contenido.innerHTML +
          '<tr>' +
            '<th scope="row">' + i + '</th>' +
            '<td>'+ json[i].odescripcion + '</td>' +
            '<td>' + json[i].ocantidad + '</td>' +
          '</tr>'
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax2');
          }

  });
}
</script>
<script type="text/javascript">

function clear_modal(){
  var contenido = document.getElementById("tstock");
  contenido.innerHTML = '';
}
</script>

<?php } else {redirect('inicio');}?>
