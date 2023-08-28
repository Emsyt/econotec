<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha: 26/05/2023, Codigo: GAN-DPR-B1-0499
Descripcion: Se elimino los productos de prueba y en su lugar se envió un mensaje con la cantidad de menús creados.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha: 26/05/2023, Codigo: GAN-MS-B3-0501
Descripcion: Se implemento un progress-bar para ver el cuanto tarda en obtener la información, su progreso esta en 
función del tamaño de datos que se solicita por Ajax.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha: 26/05/2023, Codigo: GAN-MS-B1-0502
Descripcion: La imágenes ahora pertenecen a cada producto, si un producto que no tiene imagen se carga sin_imagen.jpg.
Los productos no disponibles ahora tienen una marca de agua encima.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha: 09/06/2023, Codigo: GAN-MS-M0-0512
Descripcion: Se agrego el campo cantidad disponible y cantidad solicitada, validando que lo solicitado no sea menor a cero
ni mayor a lo solicitado.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha: 12/06/2023, Codigo: GAN-MS-M0-0513
Descripcion: Al seleccionar una mesa ahora muestra las mesas creadas en administracion.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha: 14/06/2023, Codigo: GAN-MS-M4-0517
Descripcion: Se creo la funcion table() para listar las ventas en estado PENDIENTE.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha:26/06/2023,  GAN-MS-M0-0524
Descripcion: Se implemento la funcionalidad para editar la cantidad de un pedido.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha:28/06/2023,  GAN-MS-M4-0525
Descripcion: Se mejoro la manera en como se selecciona un producto y al eliminar ya no se sale del pedido.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha:03/07/2023,  GAN-MS-M4-0529
Descripcion: Se implemento la funcionalidad para finalizar e imprimir pedido.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Ignacio Laquis Camargo Fecha:13/07/2023,  GAN-MS-M3-0531
Descripcion: Se corrigio el error de las cantidades al agregar productos al detalle del pedido.
*/
?>
<script>
  $(document).ready(function() {
    activarMenu('menu5', 5);
    $(".table_oculto").hide();
    document.cookie = "categoria_cookie = ;";
  });
</script>
<style>
  .disabledbutton {
    pointer-events: none !important;
    opacity: 0.4 !important;
  }
</style>
<!-- BEGIN CONTENT-->
<div id="content">
  <section>
    <div class="section-header">
      <ol class="breadcrumb">
        <li><a href="#">Venta</a></li>
        <li class="active">Venta Gráfica</li>
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
        <div class="col-md-8" id="ventana_0">
          <div class="card card-bordered style-primary">
            <div class="card-head style-default">
              <div class="col-md-3" id="ventana1" style="text-align: center; padding: 10px;">
                <button type="button" style="margin: 0px;" class="btn btn-primary ink-reaction btn-sm " onclick="new_category()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Cargar Lista</button>
              </div>
              <div class="col-md-9" id="ventana2" style="padding: 0px; border-left: 1px solid #dee2e6;">
                <div class="col-md-6 padre" style="">
                  <h4 class="text-ultra-bold hijo" style="color:#655e60;" id="titulo_venta"> VENTA GRÁFICA </h4>
                </div>
                <div class="col-md-6" style="padding-right: 0px;">
                  <form class="form-inline">
                    <input class="form-control mr-sm-2" type="search" id="id_search" placeholder="Buscar" aria-label="Search" onkeyup="buscar_prod()" style="width: 64%;">
                    <button class="btn " type="submit">Buscar</button>
                  </form>
                </div>
              </div>
            </div>

            <div class="card-body style-default-bright" style="padding: 0px;">
              <div class="col-md-3" id="ventana1_1" style="padding: 10px; text-align: center;">
                <div id="menu">
                </div>
              </div>
              <div class="col-md-9 border-left" id="ventana2_1" style="padding: 10px; ">
                <!-- GAN-MS-B3-0501, 26/05/23 ILaquis -->
                <div class="form-group" id="process" style="display:none;">
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120" style="">
                    </div>
                  </div>
                </div>
                <!-- FIN GAN-MS-B3-0501, 26/05/23 ILaquis -->
                <!-- GAN-DPR-B1-0499, 26/05/23 ILaquis -->
                <div id="img_productos" style="overflow-y: scroll; height: 500px; padding: 0px;;">
                  <?php
                  $cantidad_menus = count($lst_menus);
                  if ($cantidad_menus == 0) :
                  ?>
                    <b>SIN MENÚS</b>
                  <?php
                  else :
                  ?>
                    <b><?= $cantidad_menus ?> MENÚS DISPONIBLES</b>
                  <?php
                  endif;
                  ?>
                </div>
                <!-- FIN GAN-DPR-B1-0499, 26/05/23 ILaquis -->
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4" id="detalles">
          <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
          <div class="card card-bordered style-primary">
            <div class="card-head style-primary">
              <header><button type="button" class="btn btn-primary ink-reaction btn-sm " onclick="cambiarClase()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp;</button> Detalle de pedidos realizados</header>
            </div>

            <div class="card-body style-default-bright" style="height: 540px;">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label for="c_codigo">CI/NIT</label>
                      <input type="number" name="nit" id="nit" style="width: 90%;">
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="form-group">
                      <label for="c_codigo">Nombre/Razon Social</label>
                      <input type="text" name="nit" id="nit" style="width: 100%;">
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-responsive" style="overflow-y: scroll; height: 300px;">
                <table id="datatabl" class="table table-striped ">
                  <thead>
                    <tr>
                      <th class="table_oculto">NRO</th>
                      <th>PRODUCTOS</th>
                      <th class="table_oculto">CANTIDAD</th>
                      <th class="table_oculto">PRECIO UNIDAD</th>
                      <th>TOTAL</th>
                      <th width=" 10px;"></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <!-- GAN-MS-M0-0513, 12/06/23 ILaquis -->
              <div class="row" style="text-align: center;">
                <br>
                <br>
                <br>
                <button type="button" class="btn btn-primary ink-reaction btn-sm " onclick="modal_guardar_ticket()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Seleccionar Mesa</button>
                <!-- FIN GAN-MS-M0-0513, 12/06/23 ILaquis -->
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<!-- AÑADIR CATEGORIA -->
<!-- GAN-MS-B1-0500, 26/05/23 ILaquis -->
<div class="modal align-middle" id="new_category">
  <div class="modal-dialog modal-dialog-centered" id="cat_tamaño">
    <div class="modal-content">

      <div class="modal-header">
        <div id="lista_menus">
        </div>
        <br>
        <button type="button" class="btn btn-primary ink-reaction btn-sm" onclick="nueva_lts_menu()"><span class="pull-right"><i class="fa fa-plus"></i></span></button>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="cate">
            <form class="form form-validate" novalidate="novalidate" name="form_lts_menu" id="form_lts_menu">
              <div class="row">
                <div class="  col-xs-12 col-sm-12 col-md-8 col-lg-8">
                  <div class="form-group floating-label" id="c_categoria">
                    <input type="text" class="form-control" name="categoria" id="categoria" onchange="return mayuscula(this);" required>
                    <label for="categoria">Nombre Menú:</label>
                  </div>
                </div>
                <div class="  col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <br>
                </div>
              </div>
              <div class="row">
                <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12" id="conten">
                  <div id="div_select_categoria" style="display:none;">
                    <label>Categorías: </label><br>
                    <button type="button" id="id_categorias" class="btn btn-primary ink-reaction btn-sm " onclick="check_colors()"><i class="fa fa-plus"></i></button>
                  </div>
                  <div id="categorias_menu">
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" id="new_cat" style="display: none;">
            <div class="row">
              <div class="form col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="form-group">
                  <select class="form-control select2-list" id="category" name="category">
                    <?php foreach ($lst_categorias as $cat) {  ?>
                      <option value="<?php echo $cat->id_categoria ?>" <?php echo set_select('category', $cat->id_categoria) ?>> <?php echo $cat->descripcion ?></option>
                    <?php  } ?>
                  </select>
                  <label for="category">Categoría:</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor">
                <div class="form col-xs-12 col-sm-12 col-md-2 col-lg-2" id="colors">
                  <div class="squaredThree">
                    <input type="checkbox" value="#C2495D" id="squaredThree" class="micheck" onclick="seleccionado()" class="micheck" checked />
                    <label for="squaredThree" style="background: #C2495D;"></label>
                  </div>
                </div>

              </div>
            </div>
            <br><br>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
                <button type="button" class="btn btn-primary ink-reaction btn-sm " onclick="guardar_cat()">Guardar</button> &nbsp; &nbsp;
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="modal-footer" style="text-align:center">
        <button class="btn btn-info" data-dismiss="modal" id="cargar_menu_cat" onclick="cargar_categoria()">Continuar</button>
        <button class="btn btn-info" data-dismiss="modal" id="crear_menu_cat" onclick="crear_lts_menu()">Crear menú</button>
      </div>

    </div>
  </div>
</div>
<!-- FIN GAN-MS-B1-0500, 26/05/23 ILaquis -->
<!-- END CONTENT -->
<!-- MODAL ASIGNAR MESA -->
<div class="modal align-middle" id="modalGuardarTicket">
  <div class="modal-dialog modal-dialog-centered" id="cat_tamaño_mesas">
    <div class="modal-content">
      <center>
        <div class="modal-header">

          <h5 class="modal-title">MESAS</h5>
          <button class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <br><br>

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="id_mesas">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="mesa_1" style="display: none;">
              <center>
                <h3>DETALLE DE PEDIDOS</h3>
              </center>
              <div class="table-responsive" style="overflow-y: scroll; height: 300px;">
                <table id="datatable_detalle_mesa" class="table table-striped ">
                  <thead>
                    <tr>
                      <th>NRO</th>
                      <th>PRODUCTOS</th>
                      <th>CANTIDAD</th>
                      <th>PRECIO UNIDAD</th>
                      <th>TOTAL</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>

          <!-- GAN-MS-M0-0524, 26/06/23 ILaquis -->
          <div class="row" style="display: none;" id="form_registro">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
              <div class="row">
                <div class="col-md-10 col-md-offset-1">
                  <form class="form form-validate" novalidate="novalidate" name="form_pedido" id="form_pedido" method="post" action="<?= site_url() ?>venta/C_venta_grafica/update_pedido">
                    <input type="hidden" name="id_proveedor" id="id_proveedor">
                    <div class="card">

                      <div class="card-head style-primary">
                        <div class="tools">
                          <div class="btn-group">
                            <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                          </div>
                        </div>
                        <header id="titulo"></header>
                      </div>

                      <div class="card-body">
                        <input type="hidden" class="form-control" name="id_venta" id="id_venta">
                        <div class="form-group floating-label" id="c_cant_pedido">
                          <input type="number" class="form-control" name="cant_pedido" id="cant_pedido" onchange="cantidad_pedido()">
                          <label for="cant_pedido">Cantidad del Pedido</label>
                          <div id="msjcantpedido" style="color: #f44336"></div>
                        </div>

                        <div class="card-actionbar">
                          <div class="card-actionbar-row">
                            <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit_pedido" value="edit">Modificar Pedido</button>
                          </div>
                        </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- FIN GAN-MS-M0-0524, 26/06/23 ILaquis -->
        </div>
        <!-- GAN-MS-M4-0529, 03/07/23 ILaquis -->
        <div class="modal-footer" style="text-align:center">
          <button id="btn_asignarPedido" style="display: none;" onclick="asignar_pedido()" class="btn btn-primary" data-dismiss="modal">ASIGNAR PEDIDO</button>
          <button type="submit" id="btnFinalizar" style="display: none;" class="btn btn-primary " onclick="finalizar();">FINALIZAR</button>
          <div class="row" style="display: block;" id="form_pdf_pedido">
            <form class="form" name="conf_pedido" id="conf_pedido" method="post" target="_blank" action="<?= site_url() ?>generar_pdf_pedido">
              <output id="idventa"></output>
            </form>
          </div>
          <!-- FIN GAN-MS-M4-0529, 03/07/23 ILaquis -->
        </div>
      </center>
    </div>
  </div>
</div>
<!-- END CONTENT -->
<!-- MODAL PRODUCTO -->
<div class="modal align-middle" id="MyModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <center>
        <div class="modal-header">

          <label class="switch"><input id="check" type="checkbox" onclick="cambio_switch()" checked><span class="slider round"></span></label>

          <h3 class="modal-title" id="title_p"><b>PRODUCTO</b></h3>
          <button class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <!-- GAN-MS-B3-0502, 29/05/23 ILaquis -->
          <div id="contenedor-imagen" class="contenedor-imagen" style="position:relative; width: 180px; display: inline-block;">
            <img id="id_img_producto" src="" alt="Foto del usuario" width="100%" height="130" />
            <div id="marca-de-agua"" class=" marca-de-agua" style="position: absolute;top: 0; left: 0;width: 100%; height: 100%; background-image: url('<?= base_url() . 'assets/img/productos/no_disponible.png' ?>'); background-repeat: repeat; opacity: 0.50; background-size: 100%; display:none;"></div>
            <div style="position:absolute; top:0; left:0; padding-top: 5px; padding-left: 5px;">
              <img border="0" id="img_check" src="https://freeiconshop.com/wp-content/uploads/edd/checkmark-flat.png" width="35" height="35" />
            </div>
          </div>
          <!-- GAN-MS-B3-0502, 29/05/23 ILaquis -->
          <br><br>
          <input type="hidden" id="id_prod">
          <input type="hidden" id="id_categoria">
          <input type="hidden" id="nombre_categoria">
          <!-- GAN-MS-M0-0512, 09/06/23 ILaquis -->
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
              <div class="form-group">
                <label for="cant_almacen">Cantidad Disponible</label>
                <input type="number" class="form-control" name="cant_almacen" id="cant_almacen" readonly="">
              </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
              <div class="form-group">
                <label for="cantidad_sol">Cantidad a solicitar</label>
                <input type="number" name="cantidad_sol" id="cantidad_sol" onchange="cantidad_solicitada()" class="form-control" autofocus>
                <div id="msjcaltidadsol" style="color: #f44336"></div>
              </div>
            </div>
          </div>
          <!-- FIN GAN-MS-M0-0512, 09/06/23 ILaquis -->
        </div>


        <div class="modal-footer" style="text-align:center">
          <button class="btn btn-info" data-dismiss="modal" onclick="agregar_producto()" id="btn_add_sol">Continuar</button>
        </div>
      </center>
    </div>
  </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script>
  $(document).ready(function() {
    tabla();
    $('#cantidad_sol').on('input', function() {
      cantidad_solicitada();
    });

    $('#cantidad_sol').on('keydown', function(event) {
      if (event.keyCode === 13) {
        var cant_sol = parseInt($('#cantidad_sol').val());
        var cant_alm = parseInt($('#cant_almacen').val());

        if (cant_sol > cant_alm || cant_sol < 0) {
          event.preventDefault();
        } else {
          agregar_producto();
          $('#MyModal').modal('hide');
        }
      }
    });
  });

  function cerrar_formulario() {
    document.getElementById("form_registro").style.display = "none";
  }
</script>
<script>
  // GAN-MS-M4-0529, 03/07/2023 ILaquis.
  function finalizar() {
    var radios = document.getElementsByName('id_mesa');
    var radioValue;

    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) {
        radioValue = radios[i].value;
        break;
      }
    }
    var id_mesa = radioValue;

    $.ajax({
      url: '<?= site_url() ?>venta/C_venta_grafica/realizar_cobro',
      type: "POST",
      data: {
        id_mesa: id_mesa,
      },
      success: function(data) {
        tabla_detalle_mesa(id_mesa);
        document.getElementById("form_pdf_pedido").style.display = "block";
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }
  // FIN GAN-MS-M4-0529, 03/07/2023 ILaquis.
  // GAN-MS-M0-0524, 26/06/2023 ILaquis.
  function eliminar_pedido(id_venta, id_prod, id_mesa) {
    $.ajax({
      url: '<?= base_url() ?>venta/C_venta_grafica/dlt_venta/' + id_venta,
      type: "post",
      datatype: "json",
      data: {
        ubicacion: 1
      },
      success: function(data) {
        // GAN-MS-M4-0525, 28/06/2023 ILaquis.
        tabla_detalle_mesa(id_mesa);
        // FIN GAN-MS-M4-0525, 28/06/2023 ILaquis.
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos');
      }
    });
  }

  function editar_pedido(id_venta, id_producto, id_mesa) {
    $("#titulo").text("Modificar Cantidad del Pedido");
    document.getElementById("form_registro").style.display = "block";
    $('#form_pedido')[0].reset();

    $.ajax({
      url: '<?= site_url() ?>venta/C_venta_grafica/datos_pedido',
      type: "POST",
      data: {
        id_venta: id_venta,
        id_producto: id_producto,
        id_mesa: id_mesa,
      },
      success: function(data) {
        var cantidad = JSON.parse(data)[0].cantidad;
        $('[name="cant_pedido"]').val(cantidad);
        $('[name="id_venta"]').val(id_venta);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }

  $('#form_pedido').submit(function(e) {
    e.preventDefault();
    var form = this;
    $.ajax({
      url: $(form).attr('action'),
      method: $(form).attr('method'),
      data: new FormData(form),
      processData: false,
      dataType: 'json',
      contentType: false,
      success: function(data) {
        cerrar_formulario();
        $('#modalGuardarTicket').modal('hide');
      },
      error: function(xhr, status, error) {
        console.error('Error en Registrar Pago: ' + error);
      }
    });
  });

  function cantidad_pedido() {
    var cant_pedido = parseInt(document.getElementById("cant_pedido").value);
    if (cant_pedido <= 0) {
      var mensaje = 'La cantidad solicitada debe ser mayor a 0.';
      $("#msjcantpedido").html(mensaje);
      $('#btn_edit_pedido').attr("disabled", true);
    } else {
      $("#msjcantpedido").html("");
      $('#btn_edit_pedido').attr("disabled", false);
    }
  }
  // FIN GAN-MS-M0-0524, 26/06/2023 ILaquis.
  // GAN-MS-M0-0512, 09/06/2023 ILaquis.
  function asignar_pedido() {
    var radios = document.getElementsByName('id_mesa');
    var id_mesa = '';

    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) {
        id_mesa = radios[i].value;
        break;
      }
    }

    $.ajax({
      url: '<?= site_url() ?>venta/C_venta_grafica/asignar_mesa',
      type: "post",
      data: {
        id_mesa: id_mesa
      },
      success: function(data) {
        tabla();
        tabla_detalle_mesa(id_mesa);
        // GAN-MS-M4-0542, 20/07/2023 ILaquis.
        Swal.fire({
          icon: 'success',
          title: 'PEDIDO ASIGNADO',
          text: 'IMPRIMIR',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ACEPTAR'
        }).then((
          result
        ) => {
          if (result
            .isConfirmed
          ) {
            dato =
              '<input type="hidden" name="id_mesa_pedido" id="id_mesa_pedido" value="' + id_mesa + '">';
            document
              .getElementById(
                "idventa"
              )
              .innerHTML =
              dato;
            document
              .getElementById(
                "conf_pedido"
              )
              .submit();
          }
        })
        // FIN GAN-MS-M4-0542, 20/07/2023 ILaquis.
      },
      error: function(jqXHR, textStatus, errorThrown) {
        // GAN-MS-M4-0542, 20/07/2023 ILaquis.
        Swal.fire({
          icon: 'success',
          title: 'PEDIDO ASIGNADO',
          text: 'IMPRIMIR',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ACEPTAR'
        }).then((
          result
        ) => {
          if (result
            .isConfirmed
          ) {
            dato =
              '<input type="hidden" name="id_mesa_pedido" id="id_mesa_pedido" value="' + id_mesa + '">';
            document
              .getElementById(
                "idventa"
              )
              .innerHTML =
              dato;
            document
              .getElementById(
                "conf_pedido"
              )
              .submit();
          }
        })
        // FIN GAN-MS-M4-0542, 20/07/2023 ILaquis.
      }
    });
  }
  // FIN GAN-MS-M0-0512, 09/06/2023 ILaquis.
  // GAN-MS-M0-0512, 09/06/2023 ILaquis.
  function cantidad_solicitada() {
    var cant_sol = parseInt(document.getElementById("cantidad_sol").value);
    var cant_alm = parseInt(document.getElementById("cant_almacen").value);

    if (isNaN(cant_sol) || cant_sol !== parseFloat(document.getElementById("cantidad_sol").value)) {
      var mensaje = 'La cantidad solicitada debe ser un número entero.';
      $("#msjcaltidadsol").html(mensaje);
      $('#btn_add_sol').attr("disabled", true);
    } else {
      if (cant_sol > cant_alm) {
        var mensaje = 'La cantidad solicitada no debe exceder a la cantidad disponible.';
        $("#msjcaltidadsol").html(mensaje);
        $('#btn_add_sol').attr("disabled", true);
      } else if (cant_sol < 1) {
        var mensaje = 'La cantidad solicitada debe ser mayor a 0.';
        $("#msjcaltidadsol").html(mensaje);
        $('#btn_add_sol').attr("disabled", true);
      } else {
        $("#msjcaltidadsol").html("");
        $('#btn_add_sol').attr("disabled", false);
      }
    }
  }
  // FIN GAN-MS-M0-0512, 09/06/2023 ILaquis.

  // GAN-MS-B1-0500, 26/05/2023 ILaquis.
  function new_category() {

    var elemento = document.getElementById("cate");
    var tamaño = document.getElementById("cat_tamaño");

    if (elemento.className == "col-xs-12 col-sm-12 col-md-12 col-lg-12") {
      elemento.className = "col-xs-12 col-sm-12 col-md-7 col-lg-7"
      tamaño.className = "modal-dialog modal-dialog-centered modal-lg";
    } else {
      tamaño.className = "modal-dialog modal-dialog-centered ";
      elemento.className = "col-xs-12 col-sm-12 col-md-12 col-lg-12"
    }

    document.getElementById("categoria").value = "";
    document.getElementById("conten").innerHTML = "";
    var elemento = document.getElementById("cate");
    var tamaño = document.getElementById("cat_tamaño");
    if (elemento.className == "col-xs-12 col-sm-12 col-md-12 col-lg-12") {
      elemento.className = "col-xs-12 col-sm-12 col-md-7 col-lg-7"
      tamaño.className = "modal-dialog modal-dialog-centered modal-lg";
      document.getElementById("new_cat").style.display = "none";
    } else {
      tamaño.className = "modal-dialog modal-dialog-centered ";
      elemento.className = "col-xs-12 col-sm-12 col-md-7 col-lg-7"
      document.getElementById("new_cat").style.display = "none";
    }

    $('#new_category').modal('show');
    $.ajax({
      url: '<?= site_url() ?>venta/C_venta_grafica/listar_menus',
      type: "post",
      success: function(data) {
        var data = JSON.parse(data);
        var elemento = '';
        var contenido = '';
        for (var i = 0; i < data.length; i++) {
          elemento = '<button type="button" class="btn btn-info ink-reaction btn-sm" id="menu' + data[i].oidmenu + '" onclick="cargar_menu(' + data[i].oidmenu + ',\'' + data[i].omenu + '\')"><span class="pull-left">' + data[i].omenu + '</span></button> |';
          elemento = elemento + '<button type="button" class="btn btn-danger ink-reaction btn-sm " id="btn_eliminar_menu" onclick="eliminar_menu(' + data[i].oidmenu + ')"><span class="pull-left"><i class="fa fa-trash-o"></i></span></button>';
          contenido = contenido + elemento;
        }
        document.getElementById("lista_menus").innerHTML = contenido;
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos');
      }
    });
  }
  // FIN GAN-MS-B1-0500, 26/05/2023 ILaquis.

  function check_colors() {
    var elemento = document.getElementById("cate");
    var tamaño = document.getElementById("cat_tamaño");

    if (elemento.className == "col-xs-12 col-sm-12 col-md-12 col-lg-12") {
      elemento.className = "col-xs-12 col-sm-12 col-md-7 col-lg-7"
      tamaño.className = "modal-dialog modal-dialog-centered modal-lg";
      document.getElementById("new_cat").style.display = "block";
    } else {
      tamaño.className = "modal-dialog modal-dialog-centered ";
      elemento.className = "col-xs-12 col-sm-12 col-md-12 col-lg-12"
      document.getElementById("new_cat").style.display = "none";
    }

    document.getElementById("contenedor").innerHTML =
      '<div class="form col-xs-12 col-sm-12 col-md-2 col-lg-2" id="colors">' +
      '<div class="squaredThree">' +
      '<input type="checkbox" value="#C2495D" id="squaredThree11" onclick="seleccionado(11)" class="micheck" name="check" checked />' +
      '<label for="squaredThree" style="background: #C2495D;"></label>' +
      '</div>' +
      '</div>';

    let colores = ["#FDE277", "#B5E8AD", "#FD9BC1", "#964472", "#3B4263", "#FE5B5E", "#95D4F5", "#CF6EB5", "#413F4A", "#789E6F", "#A0AAA9"]
    var color;
    for (let index = 0; index < colores.length; index++) {
      color = $('<div class="form col-xs-12 col-sm-12 col-md-2 col-lg-2">' +
        '<div class="squaredThree">' +
        '<input type="checkbox" value="' + colores[index] + '" id="squaredThree' + index + '" onclick="seleccionado(' + index + ')" class="micheck"  name="check" />' +
        '<label for="squaredThree' + index + '"  style="background: ' + colores[index] + ';"></label>' +
        '</div>' +
        '</div>');
      $(color).insertBefore("#colors");
    }
  }


  function seleccionado(valor) {
    //var x = document.getElementById("squaredThree0").checked;
    //console.log(x);
    for (var i = 0; i < 12; i++) {
      if (valor != i) {
        document.getElementById("squaredThree" + i).checked = false;
      } else {
        document.getElementById("squaredThree" + i).checked = true;
      }
    };
  }

  function guardar_cat() {
    categ = document.getElementById("category");
    var selc_categ = categ.options[categ.selectedIndex].value;
    var color;
    for (var i = 0; i < 12; i++) {
      if (document.getElementById("squaredThree" + i).checked) {
        color = document.getElementById("squaredThree" + i).value;
      }
    };

    let categoria_cookie = getCookie("categoria_cookie");
    let x = "";
    if (categoria_cookie != "") {
      x = categoria_cookie + "-";
    }
    document.cookie = "categoria_cookie = " + x + selc_categ + "," + color + ";";
    lts_categoria();


  }

  function lts_categoria() {
    let categorias = getCookie("categoria_cookie");
    let parts = categorias.split("-");
    let lts_cat = JSON.parse('<?php echo json_encode($lst_categorias) ?>');
    let val;

    document.getElementById("conten").innerHTML =
      '<label >Categorias: </label><br>' +
      '<button type="button" id="id_categorias" class="btn btn-info ink-reaction btn-sm " onclick="check_colors()"><i class="fa fa-plus"></i></button>';

    for (let index = 0; index < parts.length; index++) {
      var element = parts[index];
      let cat = element.split(",");
      for (let i = 0; i < lts_cat.length; i++) {
        if (lts_cat[i].id_categoria == cat[0]) {
          val = lts_cat[i].descripcion;
        }
      }
      btn_cat = $('<input type="button" class="btn ink-reaction btn-sm" value="' + val + '" style="width: 150px;  height: 45px; text-align: center; white-space: normal; color: white; margin-right: 5px; margin-bottom: 5px; background:' + cat[1] + '; ">');
      $(btn_cat).insertBefore("#id_categorias");
    }

  }

  // GAN-MS-B3-0501, 26/05/2023 ILaquis.
  function crear_lts_menu() {
    let nombre = document.getElementById("categoria").value;
    let categorias = getCookie("categoria_cookie");
    $.ajax({
      url: "<?php echo site_url('venta/C_venta_grafica/registrar_menu') ?>",
      type: "POST",
      data: {
        nombre: nombre,
        categorias: categorias,
      },
      success: function(respuesta) {

        var js = JSON.parse(respuesta);
        console.log(js);
        if (js[0].oboolean == 't') {
          Swal.fire({
            icon: 'success',
            text: 'Se realizó el regristro con éxito',
          })
        } else {
          Swal.fire({
            icon: 'error',
            text: js[0].omensaje,
          })
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }
  // FIN GAN-MS-B3-0501, 26/05/2023 ILaquis.

  // GAN-MS-B3-0501, 26/05/2023 ILaquis.
  function cargar_categoria() {
    let id_menu = document.getElementById("cargar_menu_cat").value;

    $.ajax({
      url: "<?php echo site_url('venta/C_venta_grafica/get_categorias_menu') ?>",
      type: "POST",
      data: {
        id_menu: id_menu,
      },
      success: function(respuesta) {
        var js = JSON.parse(respuesta);
        console.log(js);
        let con = document.getElementById("menu").innerHTML = '<input id="btn_todosProductos" type="button" class="btn ink-reaction btn-sm" value="TODOS LOS PRODUCTOS" onclick="all_productos(' + id_menu + ')" style="width: 150px;  height: 45px; text-align: center; white-space: normal; color: white; margin-right: 5px; margin-bottom: 5px;  background:#0C84E4; ">';

        for (let i = 0; i < js.length; i++) {
          con = document.getElementById("menu").innerHTML = con + '<input type="button" class="btn ink-reaction btn-sm" value="' + js[i].oitemlista + '" onclick="createimg(' + js[i].oidcategoria + ',\'' + js[i].oitemlista + '\')" style="width: 150px;  height: 45px; text-align: center; white-space: normal; color: white; margin-right: 5px; margin-bottom: 5px;  background:' + js[i].ocolor + '; ">';
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }
  // FIN GAN-MS-B3-0501, 26/05/2023 ILaquis.


  function cargar_menu(id_menu, nom_menu) {
    $('#categoria').val(nom_menu).trigger('change');
    $('#cargar_menu_cat').val(id_menu).trigger('change');
    document.getElementById("cargar_menu_cat").style.display = "block";
    document.getElementById("crear_menu_cat").style.display = "none";
    // $('#btn_eliminar_menu').val(id_menu);
    $.ajax({
      url: "<?php echo site_url('venta/C_venta_grafica/get_categorias_menu') ?>",
      type: "POST",
      data: {
        id_menu: id_menu,
      },
      success: function(respuesta) {
        var js = JSON.parse(respuesta);
        console.log(js);
        document.getElementById("conten").innerHTML =
          '<label >Categorias: </label><br>' +
          '<button type="button" style="display:none;" id="id_categorias" class="btn btn-info ink-reaction btn-sm " onclick="check_colors()"><i class="fa fa-plus"></i></button><div id="categorias_menu"></div>';

        for (let i = 0; i < js.length; i++) {
          btn_cat = $('<button type="button" class="btn ink-reaction btn-sm" style="width: 150px;  height: 45px; text-align: center; white-space: normal; color: white; margin-right: 5px; margin-bottom: 5px; background:' + js[i].ocolor + '; ">' + js[i].oitemlista + '</button>');
          btn_cat.appendTo("#categorias_menu");
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }

  // GAN-MS-B3-0501, 26/05/2023 ILaquis.
  function all_productos(id_menu) {
    $('#img_productos').empty();
    $('.progress-bar').css('width', '0%');
    document.getElementById("titulo_venta").innerHTML = 'TODOS LOS PRODUCTOS';
    document.getElementById("img_productos").innerHTML = '';
    $.ajax({
      url: '<?= site_url() ?>venta/C_venta_grafica/listar_all_productos_categoria',
      type: "post",
      data: {
        id_menu: id_menu,
      },
      success: function(data) {
        var data = JSON.parse(data);
        $('#process').css('display', 'block');
        var BASE_URL = '<?= base_url() ?>' + 'assets/img/productos/';

        for (var i = 0; i < data.length; i++) {
          let con = document.getElementById("img_productos").innerHTML;
          var estado;
          var stock;
          if (data[i].oestado == 'HABILITADO') {
            estado = 'https://freeiconshop.com/wp-content/uploads/edd/checkmark-flat.png';
          } else {
            estado = 'https://freeiconshop.com/wp-content/uploads/edd/cross-flat.png';
          }
          if (data[i].ostock <= 0) {
            estado = 'https://freeiconshop.com/wp-content/uploads/edd/cross-flat.png';
            stock = 0;
          } else {
            stock = data[i].ostock;
          }
          nom_prod = (data[i].onombreprod).toUpperCase();
          // GAN-MS-B1-0502, 26/05/2023 ILaquis.
          if (data[i].oimagen == null) {
            var URL = '<img src="' + BASE_URL + 'sin_imagen.jpg" alt="Foto del usuario" width="80%" height="100" />';
          } else {
            var URL = '<img src="' + BASE_URL + data[i].oimagen + '" alt="Foto del usuario" width="80%" height="100" />';
          }
          // GAN-MS-M4-0525, 28/06/2023 ILaquis.
          con = document.getElementById("img_productos").innerHTML = con +
            '<div id="img_prod' + i + '" name="aaaa" value="' + nom_prod + '"  style="position:relative; width: 180px; margin-right: 10px; display: inline-block;" onclick="go(\'' + data[i].oimagen + '\',\'' + nom_prod + '\',\'' + data[i].oestado + '\',' + id_menu + ',\'' + '' + '\',' + stock + ',' + data[i].oidproducto + ')">' +
            '<figure style="position: relative;">' + URL +
            '<figcaption>' + nom_prod + '</figcaption>' +
            '</figure>' +
            '<div style="position:absolute; top:0; left:0; padding-top: 5px; padding-left: 5px;">' +
            '<img border="0" src="' + estado + '" width="35" height="35" />' +
            '</div>' +
            '<div style="position:absolute; top:0; left:0; padding-top: 5px; padding-left: 140px;" >' +
            '<label class="center" style="font-size:20px; color:#FFFFFF">' + stock + '</label>' +
            '</div>' +
            '</div>';
          // FIN GAN-MS-M4-0525, 28/06/2023 ILaquis.
          // FIN GAN-MS-B1-0502, 26/05/2023 ILaquis.
          setTimeout(function() {
            progress += increment;
            $('.progress-bar').css('width', progress + '%');
            if (progress >= 100) {
              $('#process').css('display', 'none');
              $('.progress-bar').css('width', 0 + '%');
            }
          }, 200 * i);
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos');
      },
      xhr: function() {
        var xhr = $.ajaxSettings.xhr();
        if (xhr.upload) {
          xhr.upload.addEventListener('progress', function(event) {
            var percent = 0;
            var position = event.loaded || event.position;
            var total = event.total;
            if (event.lengthComputable) {
              percent = Math.ceil(position / total * 100);
            }
            //update progressbar
            $("#container").addClass("disabledbutton");
            $(".progress-bar").css("width", +percent + "%");
            if (percent >= 100) {
              var delayInMilliseconds = 5500;

              setTimeout(function() {
                $('#process').css('display', 'none');
                $('.progress-bar').css('width', '0%');
                $("#container").removeClass("disabledbutton");
                percent == 0;
              }, delayInMilliseconds);
            }
          }, true);
        }
        return xhr;
      },
      beforeSend: function() {
        $('#process').css('display', 'block');
      },
    });
  }
  // FIN GAN-MS-B3-0501, 26/05/2023 ILaquis.

  // GAN-MS-B3-0501, 26/05/2023 ILaquis.
  function createimg(nro, val) {
    $('#img_productos').empty();
    document.getElementById("titulo_venta").innerHTML = val.toUpperCase();
    document.getElementById("img_productos").innerHTML = '';

    $.ajax({
      url: '<?= site_url() ?>venta/C_venta_grafica/listar_productos_categoria',
      type: "post",
      datatype: "json",
      data: {
        id_categoria: nro,
      },
      success: function(data) {
        var data = JSON.parse(data);
        $('#process').css('display', 'block');
        var BASE_URL = '<?= base_url() ?>' + 'assets/img/productos/';

        for (var i = 0; i < data.length; i++) {
          let con = document.getElementById("img_productos").innerHTML;
          var estado;
          var stock;
          if (data[i].oestado == 'HABILITADO') {
            estado = 'https://freeiconshop.com/wp-content/uploads/edd/checkmark-flat.png';
          } else {
            estado = 'https://freeiconshop.com/wp-content/uploads/edd/cross-flat.png';
          }
          if (data[i].ostock <= 0) {
            estado = 'https://freeiconshop.com/wp-content/uploads/edd/cross-flat.png';
            stock = 0;
          } else {
            stock = data[i].ostock;
          }
          nom_prod = (data[i].onombreprod).toUpperCase();
          // GAN-MS-B1-0502, 26/05/2023 ILaquis.
          if (data[i].oimagen == null) {
            var URL = '<img src="' + BASE_URL + 'sin_imagen.jpg" alt="Foto del usuario" width="80%" height="100" />';
          } else {
            var URL = '<img src="' + BASE_URL + data[i].oimagen + '" alt="Foto del usuario" width="80%" height="100" />';
          }
          // GAN-MS-M4-0525, 28/06/2023 ILaquis.
          con = document.getElementById("img_productos").innerHTML = con +
            '<div id="img_prod' + i + '" name="aaaa" value="' + nom_prod + '"  style="position:relative; width: 180px; margin-right: 10px; display: inline-block;" onclick="go(\'' + data[i].oimagen + '\',\'' + nom_prod + '\',\'' + data[i].oestado + '\',' + nro + ',\'' + val + '\',' + stock + ',' + data[i].oidproducto + ')">' +
            '<figure style="position: relative;">' + URL +
            '<figcaption>' + nom_prod + '</figcaption>' +
            '</figure>' +
            '<div style="position:absolute; top:0; left:0; padding-top: 5px; padding-left: 5px;">' +
            '<img border="0" src="' + estado + '" width="35" height="35" />' +
            '</div>' +
            '<div style="position:absolute; top:0; left:0; padding-top: 5px; padding-left: 140px;" >' +
            '<label class="center" style="font-size:20px; color:#FFFFFF">' + stock + '</label>' +
            '</div>' +
            '</div>';
          // FIN GAN-MS-M4-0525, 28/06/2023 ILaquis.
          // FIN GAN-MS-B1-0502, 26/05/2023 ILaquis.
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos');
      },
      xhr: function() {
        var xhr = $.ajaxSettings.xhr();
        if (xhr.upload) {
          xhr.upload.addEventListener('progress', function(event) {
            var percent = 0;
            var position = event.loaded || event.position;
            var total = event.total;
            if (event.lengthComputable) {
              percent = Math.ceil(position / total * 100);
            }
            //update progressbar
            $("#container").addClass("disabledbutton");
            $(".progress-bar").css("width", +percent + "%");
            if (percent >= 100) {
              var delayInMilliseconds = 5500;

              setTimeout(function() {
                $('#process').css('display', 'none');
                $('.progress-bar').css('width', '0%');
                $("#container").removeClass("disabledbutton");
                percent == 0;
              }, delayInMilliseconds);
            }
          }, true);
        }
        return xhr;
      },
      beforeSend: function() {
        $('#process').css('display', 'block');
      },
    });
  }
  // FIN GAN-MS-B3-0501, 26/05/2023 ILaquis.

  // GAN-MS-M0-0513, 12/06/2023 ILaquis.
  function modal_guardar_ticket() {
    var btnAsignarPedido = document.getElementById('btn_asignarPedido');
    btnAsignarPedido.style.display = 'none';
    cerrar_formulario();
    // Obtén el elemento padre donde se agregarán los nuevos divs
    const idMesas = document.getElementById('id_mesas');
    idMesas.innerHTML = "";

    $.ajax({
      url: '<?= site_url() ?>venta/C_venta_grafica/lista_mesas',
      type: "post",
      success: function(data) {
        var data = JSON.parse(data);
        for (var i = 0; i < data.length; i++) {
          // Crea el nuevo div
          const nuevoDiv = document.createElement('div');
          nuevoDiv.style.position = 'relative';
          nuevoDiv.style.width = '180px';
          nuevoDiv.style.display = 'inline-block';

          // Agrega el contenido del nuevo div
          nuevoDiv.innerHTML =
            '<figure style="position: relative;">\
              <img src="https://img.freepik.com/vector-gratis/pareja-teniendo-cena-romantica-juntos-hombre-mujer-sentados-mesa-bebiendo-vino-comiendo-platos-restaurante_575670-1045.jpg?w=2000" alt="Foto del usuario" width="100%" height="130" />\
            <figcaption>' + data[i].nro_mesa + '</figcaption>\
            </figure>\
            <input onclick="detalle_mesa(' + data[i].id_mesa + ')" id="id_mesa_' + data[i].id_mesa + '" name="id_mesa" type="radio" value="' + data[i].id_mesa + '">\
            <label for="id_mesa_' + data[i].id_mesa + '">' + data[i].nro_mesa + '</label>\
            <div style="position:absolute; top:0; left:0; padding-top: 5px; padding-left: 5px;">\
              <img border="0" src="https://freeiconshop.com/wp-content/uploads/edd/checkmark-flat.png" width="35" height="35" />\
            </div>';

          // Agrega el nuevo div al elemento padre
          idMesas.appendChild(nuevoDiv);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos');
      }
    });
    $('#datatable_detalle_mesa tbody').empty();
    $('#modalGuardarTicket').modal('show');
  }

  function detalle_mesa(id_mesa) {
    var elemento = document.getElementById("id_mesas");
    var tamaño = document.getElementById("cat_tamaño_mesas");
    var btnAsignarPedido = document.getElementById('btn_asignarPedido');
    btnAsignarPedido.style.display = 'block';

    if (elemento.className == "col-xs-12 col-sm-12 col-md-12 col-lg-12") {
      elemento.className = "col-xs-12 col-sm-12 col-md-12 col-lg-12"
      tamaño.className = "modal-dialog modal-dialog-centered modal-lg";
      tabla_detalle_mesa(id_mesa);
      document.getElementById("mesa_1").style.display = "block";
    } else {
      tamaño.className = "modal-dialog modal-dialog-centered";
      elemento.className = "col-xs-12 col-sm-12 col-md-12 col-lg-12"
      document.getElementById("mesa_1").style.display = "none";
      var tbody = document.getElementById("datatable_detalle_mesa").getElementsByTagName("tbody")[0];
      tbody.innerHTML = "";
    }
  }

  function tabla_detalle_mesa(id_mesa) {
    $.ajax({
      url: "<?php echo site_url('venta/C_venta_grafica/get_lst_detalle_mesa') ?>",
      type: "POST",
      data: {
        id_mesa: id_mesa
      },
      success: function(respuesta) {
        var js = JSON.parse(respuesta);
        console.log(js);
        var t = $('#datatable_detalle_mesa').DataTable({
          "data": js,
          "responsive": true,
          "language": {
            "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
          },
          searching: false,
          "destroy": true,
          "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
          }, ],
          "order": [
            [1, 'dec']
          ],
          "aoColumns": [{
              "mRender": function(data, type, row, meta) {
                var a = ``;
                return a;
              }
            },
            {
              "mData": "onombre"
            },
            {
              "mData": "ocantidad"
            },
            {
              "mData": "oprecio"
            },
            {
              "mData": "ototal"
            },
            {
              "mRender": function(data, type, row, meta) {
                var a = `<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_pedido('${row.oidventa}','${row.ocodigo}','${id_mesa}')"><i class="fa fa-pencil-square-o"></i></button>`;
                // GAN-MS-M4-0525, 28/06/2023 ILaquis.
                var b = `<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_pedido('${row.oidventa}','${row.ocodigo}','${id_mesa}')"><i class="fa fa-trash-o"></i></button>`;
                // FIN GAN-MS-M4-0525, 28/06/2023 ILaquis.
                return a + b;
              }
            },
          ],

        });
        t.on('order.dt search.dt', function() {
          t.column(0, {
            search: 'applied',
            order: 'applied'
          }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
          });
        }).draw();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }
  // FIN GAN-MS-M0-0513, 12/06/2023 ILaquis.

  function modal_new() {
    document.getElementById("cantidad_sol").focus();
    $('#MyModal').modal('show');

  }

  function bucle(id_prod, x) {
    let con = document.getElementById("img_productos").innerHTML;
    x = x.toUpperCase();
    var estado = '';
    var cantidad;
    console.log(js);
    if (js[0].id_estado == 1307) {
      estado = 'https://freeiconshop.com/wp-content/uploads/edd/checkmark-flat.png';
    } else {
      estado = 'https://freeiconshop.com/wp-content/uploads/edd/cross-flat.png';
    }
    if (js[0].cantidad <= 0) {
      estado = 'https://freeiconshop.com/wp-content/uploads/edd/cross-flat.png';
      cantidad = 0;
    } else {
      cantidad = js[0].cantidad;
    }
  }
  // GAN-MS-B3-0502, 29/05/2023 ILaquis.
  function go(img, x, estado, id_menu, nombre, stock, id_prod) {
    if (estado == 'HABILITADO' && stock > 0) {
      document.getElementById('cantidad_sol').value = '';
      document.getElementById('cant_almacen').value = '';
      $("#msjcaltidadsol").html("");
      var imgStr = img.toString();
      $('#title_p').html(x);
      $('#id_prod').val(id_prod);
      $('#nombre_categoria').val(nombre);
      $('#id_categoria').val(id_menu);
      var BASE_URL = '<?= base_url() ?>' + 'assets/img/productos/';
      var imgElement = document.getElementById('id_img_producto');
      if (imgStr === "null") {
        var URL = BASE_URL + 'sin_imagen.jpg';
      } else {
        var URL = BASE_URL + imgStr;
      }
      imgElement.src = URL;
      if (estado == 'HABILITADO') {
        document.getElementById("check").checked = true;
        $('#marca-de-agua').hide();
      } else {
        document.getElementById("check").checked = false;
        $('#marca-de-agua').show();
      }
      $('#cant_almacen').val(stock);
      $('#cantidad_sol').find('[autofocus]').focus();
      $('#MyModal').modal('show');
      $(this).find('#cantidad_sol').focus();
    }
  }
  // FIN GAN-MS-B3-0502, 29/05/2023 ILaquis.

  $("#MyModal").on('shown.bs.modal', function() {
    //document.getElementById("cantidad_sol").focus();
    var textbox = document.getElementById("cantidad_sol");
    textbox.focus();
    //console.log(textbox.scrollIntoView(true));
    //$('#cantidad_sol').focus();
    //$(this).find('#cantidad_sol').focus();
  });

  function showModal(card) {
    $("#" + card).show();
    $(".modal").addClass("show");
  }

  function closeModal() {
    $(".modal").removeClass("show");
    setTimeout(function() {
      $(".modal .modal-card").hide();
    }, 300);
  }

  function loading(status, tag) {
    if (status) {
      $("#loading .tag").text(tag);
      showModal("loading");
    } else {
      closeModal();
    }
  }

  $(document).ready(function() {



    // -> Modal

    // Abrir el inspector de archivos

    $(document).on("click", "#add-photo", function() {
      $("#add-new-photo").click();
    });

    // -> Abrir el inspector de archivos

    // Cachamos el evento change

    $(document).on("change", "#add-new-photo", function() {

      var files = this.files;
      var element;
      var supportedImages = ["image/jpeg", "image/png", "image/gif"];
      var seEncontraronElementoNoValidos = false;

      for (var i = 0; i < files.length; i++) {
        element = files[i];

        if (supportedImages.indexOf(element.type) != -1) {
          createPreview(element);
        } else {
          seEncontraronElementoNoValidos = true;
        }
      }

      if (seEncontraronElementoNoValidos) {
        showMessage("Se encontraron archivos no validos.");
      } else {
        showMessage("Todos los archivos se subieron correctamente.");
      }

    });

    // -> Cachamos el evento change

    // Eliminar previsualizaciones

    $(document).on("click", "#Images .image-container", function(e) {
      //$(this).parent().remove();

      $('#MyModal').modal('show');

    });

    // -> Eliminar previsualizaciones

  });

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
</script>
<script>
  function cambiarClase() {
    var elemento = document.getElementById("detalles");
    var ventana_0 = document.getElementById("ventana_0");
    var ventana1 = document.getElementById("ventana1");
    var ventana1_1 = document.getElementById("ventana1_1");
    var ventana2 = document.getElementById("ventana2");
    var ventana2_1 = document.getElementById("ventana2_1");

    if (elemento.className == "col-md-4") {
      elemento.className = "col-md-9";
      document.getElementById("ventana2").style.display = "none";
      document.getElementById("ventana2_1").style.display = "none";
      ventana1_1.className = "col-md-12";
      ventana1.className = "col-md-12";
      ventana_0.className = "col-md-3";
      $('.table_oculto').show();
    } else {
      elemento.className = "col-md-4";
      document.getElementById("ventana2").style.display = "block";
      document.getElementById("ventana2_1").style.display = "block";
      ventana1_1.className = "col-md-3";
      ventana1.className = "col-md-3";
      ventana_0.className = "col-md-8";
      $('.table_oculto').hide();

    }
  }
  // GAN-MS-B3-0502, 29/05/2023 ILaquis.
  function cambio_switch() {
    let valor = document.getElementById("check");
    let id_prod = document.getElementById('id_prod').value;
    let num;
    if ($(valor).is(':checked')) {
      document.getElementById("img_check").src = "https://freeiconshop.com/wp-content/uploads/edd/checkmark-flat.png";
      $('#marca-de-agua').hide();
      num = 1;
    } else {
      document.getElementById("img_check").src = 'https://freeiconshop.com/wp-content/uploads/edd/cross-flat.png';
      $('#marca-de-agua').show();
      num = 0;
    }
    $.ajax({
      url: "<?php echo site_url('venta/C_venta_grafica/cambiar_estado_producto') ?>",
      type: "POST",
      data: {
        id_prod: id_prod,
        num: num,
      },
      success: function(respuesta) {
        var js = JSON.parse(respuesta);
        console.log(js);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }
  // FIN GAN-MS-B3-0502, 29/05/2023 ILaquis.
  function agregar_producto() {
    let id_prod = document.getElementById('id_prod').value;
    let id_categoria = document.getElementById('id_categoria').value;
    let nombre_categoria = document.getElementById('nombre_categoria').value;
    let cantidad = document.getElementById('cantidad_sol').value;
    $.ajax({
      url: "<?php echo site_url('venta/C_venta_grafica/mostrar_producto_grafico') ?>",
      type: "POST",
      data: {
        id_prod: id_prod,
        cantidad: cantidad,
      },
      success: function(data) {
        tabla();
        if (nombre_categoria === '') {
          all_productos(id_categoria);
        } else {
          createimg(id_categoria, nombre_categoria);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }

  // GAN-MS-M4-0517, 14/06/2023 ILaquis.
  function tabla() {
    $.ajax({
      url: "<?php echo site_url('venta/C_venta_grafica/get_lst_venta') ?>",
      type: "POST",
      success: function(respuesta) {
        var js = JSON.parse(respuesta);
        var t = $('#datatabl').DataTable({
          "data": js,
          "responsive": true,
          "language": {
            "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
          },
          searching: false,
          "destroy": true,
          "columnDefs": [{
              "searchable": false,
              "orderable": false,
              "targets": 0
            },
            {
              targets: 0,
              className: 'table_oculto'
            },
            {
              targets: 2,
              className: 'table_oculto'
            },
            {
              targets: 3,
              className: 'table_oculto'
            },
          ],
          "order": [
            [1, 'dec']
          ],
          "aoColumns": [{
              "mRender": function(data, type, row, meta) {
                var a = ``;
                return a;
              }
            },
            {
              "mData": "onombre"
            },
            {
              "mData": "ocantidad"
            },
            {
              "mData": "oprecio"
            },
            {
              "mData": "ototal"
            },
            {
              "mRender": function(data, type, row, meta) {
                var a = `<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_solicitud('${row.oidventa}','${row.ocodigo}')"><i class="fa fa-trash-o"></i></button>`;
                return a;
              }
            },

          ],

        });
        t.on('order.dt search.dt', function() {
          t.column(0, {
            search: 'applied',
            order: 'applied'
          }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
          });
        }).draw();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        var dataTable = $('#datatabl').DataTable();
        dataTable.clear().draw();
      }
    });
  }

  function eliminar_solicitud(id_sol, id_prod) {
    $.ajax({
      url: '<?= base_url() ?>venta/C_venta_grafica/dlt_venta/' + id_sol,
      type: "post",
      datatype: "json",
      data: {
        ubicacion: 1
      },
      success: function(data) {
        tabla();
        let btnTodosProductos = document.querySelector('#btn_todosProductos');
        if (btnTodosProductos) {
          btnTodosProductos.click();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos');
      }
    });
  }
  // FIN GAN-MS-M4-0517, 14/06/2023 ILaquis.

  function eliminar_menu(id_menu) {
    Swal.fire({
      title: "Desea eliminar de la lista de menús?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Continuar'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo site_url('venta/C_venta_grafica/eliminar_menu') ?>",
          type: "POST",
          data: {
            id_menu: id_menu,
          },
          success: function(respuesta) {
            var js = JSON.parse(respuesta);
            if (js[0].oboolean == "t") {
              window.location.reload(true);
            }

          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
          }
        });
      }
    })
    console.log(id_menu);

  }

  function nueva_lts_menu() {
    document.getElementById("cargar_menu_cat").style.display = "none";
    document.getElementById("crear_menu_cat").style.display = "block";

    $('#categoria').val('').trigger('change');
    document.getElementById("conten").innerHTML =
      '<label >Categorias: </label><br>' +
      '<button type="button" style="display:block;" id="id_categorias" class="btn btn-info ink-reaction btn-sm " onclick="check_colors()"><i class="fa fa-plus"></i></button>';
  }

  function buscar_prod() {
    let nombre = document.getElementById("id_search").value;
    nombre = nombre.toUpperCase();
    let img_productos = document.getElementsByName('aaaa');
    console.log('------');
    for (let i = 0; i < img_productos.length; i++) {
      let aa = img_productos[i].getAttribute('value');
      console.log(aa);
      let x = aa.indexOf(nombre);
      console.log(x);
      if (x > -1) {
        let a2 = img_productos[i].getAttribute('id');
        document.getElementById(a2).style.display = "inline-block";
      } else {
        let a2 = img_productos[i].getAttribute('id');
        document.getElementById(a2).style.display = "none";
      }
    }

    //;

    let id_prod_m = $('#id_prod_m').html();

    //console.log(id_prod_m.search(nombre));

  }
</script>
<style>
  /* ->Estilos generales */


  /* Body */


  /* ->Body */


  /* Imágenes */
  img {
    position: relative;
  }

  figure figcaption {
    position: absolute;
    top: 90px;
    padding-right: 20px;
    align-content: center;
    padding-left: 20px;
    text-align: center;
    width: 100%;
    height: 40px;
    vertical-align: middle;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.4);
    color: #fff;
    font-size: 12px;
    font-weight: bold;
    opacity: 1;
  }

  figure figcaption2 {
    position: absolute;
    top: 90px;
    padding-right: 20px;
    align-content: center;
    padding-left: 20px;
    text-align: center;
    width: 100%;
    height: 40px;
    vertical-align: middle;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.4);
    color: #fff;
    font-size: 12px;
    font-weight: bold;
    opacity: 1;
  }

  figure {
    margin: 0 0 1rem
  }

  .figure {
    display: inline-block
  }


  .container {
    width: 100%;
    height: 100%;
    padding-right: 5px;
    padding-left: 5px;
    margin-right: auto;
    margin-left: auto
  }


  div.scroll {
    margin: 4px, 4px;
    padding: 4px;
    background-color: #08c708;
    width: 100%;
    overflow: auto;
    white-space: nowrap;
  }

  /*check de colores*/

  .squaredThree {
    width: 40px;
    position: relative;
    margin: 20px auto;
  }

  .squaredThree label {
    color: #0C84E4;
    width: 40px;
    height: 40px;
    cursor: pointer;
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 4px;
    -webkit-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.5), 0px 1px 0px rgba(255, 255, 255, 0.4);
    box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.5), 0px 1px 0px rgba(255, 255, 255, 0.4);
  }

  .squaredThree label:after {
    content: '';
    width: 22px;
    height: 8px;
    position: absolute;
    top: 12px;
    left: 8px;
    border: 3px solid #fcfff4;
    border-top: none;
    border-right: none;
    background: transparent;
    opacity: 0;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  .squaredThree label:hover::after {
    opacity: 0.3;
  }

  .squaredThree input[type=checkbox] {
    visibility: hidden;
  }

  .squaredThree input[type=checkbox]:checked+label:after {
    opacity: 1;
  }

  .border-left {
    border-left: 1px solid #dee2e6;
  }

  /*SDDS */
  .eye {
    position: absolute;
    height: 200px;
    width: 200px;
    top: 40px;
    left: 40px;
    z-index: 1;
  }

  .heaven {
    position: absolute;
    height: 300px;
    width: 300px;
    z-index: -1;
  }

  .aa {
    display: inline-block;
  }

  /* Para el diseño del switch (check) */
  .switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 17px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 13px;
    width: 13px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(13px);
    -ms-transform: translateX(13px);
    transform: translateX(13px);
  }

  .slider.round {
    border-radius: 17px;
  }

  .slider.round:before {
    border-radius: 50%;
  }

  /* center label */

  .center {
    background: #2196F3;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 35px;
    width: 35px;
    border-radius: 100%;
  }
</style>