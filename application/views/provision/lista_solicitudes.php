<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:14/04/2022, Codigo:GAN-FR-A5-157
  Descripcion: se cambiaron los nombres/titulos segun lo acordado en la reunion
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:19/04/2022, Codigo:GAN-FR-A0-165
  Descripcion: se implemento la parte funcional de Solicitudes realizadas
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:29/04/2022, Codigo:GAN-BA-A7-215
  Descripcion: se implemento el checkbox de prioridad el cual solo vera el administrador 
  ademas se añadio el campo de prioridad en la tabla.
  ------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha: 15/9/2022,   Codigo: GAN-MS-A1-460
  Descripcion: Se cambio los nombres de tienda solicitante y beneficiada por sucursal 
  solicitante y beneficiada en la tabla con id= datatable1.
  ------------------------------------------------------------------------------
  Modificado: Kevin Gerardo Alcon Lazarte  Fecha: 17/02/2023,   Codigo:   GAN-MS-B0-0288
  Descripcion: Se añadio una funcion cok () para poder limpiar la cokies
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Aguirre  Fecha: 20/03/2023,   Codigo: GAN-MS-M1-0251
  Descripcion: Se envia fecha con la que se hizo en solicitud de producto seleccionada.
  ------------------------------------------------------------------------------
  Modificado: Ayrton Jhonny Guevara Montaño  Fecha: 11/05/0202,   Codigo: GAN-MS-B1-046
  Descripcion: Se agregaron las columnas de tipo y cliente 
  ------------------------------------------------------------------------------
*/
?>
<?php if (in_array("smod_sol_realiz", $permisos)) { ?>
  <style>
    /* The switch - the box around the slider */
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
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
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
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
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }

    .swal2-popup {
      font-size: 1.3rem !important;
      font-family: 'Times New Roman', Times, serif;
    }
  </style>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    var f = new Date();
    fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
    $(document).ready(function() {
      activarMenu('menu9', 3);
      $('[name="fec_entrega"]').val(fecha_actual);
    });
  </script>

  <script>
    function cantidad_almacen() {
      id_producto = document.getElementById("producto");
      var selc_prod = id_producto.options[id_producto.selectedIndex].value;

      $.post("<?= base_url() ?>provision/C_almacen/func_auxiliares", {
        accion: 'cantidad_almacen',
        selc_prod: selc_prod
      }, function(data) {
        $("#c_cant_almacen").removeClass("floating-label");
        var cant_alm = parseInt(data);
        $('[name="cant_almacen"]').val(cant_alm);

        if (cant_alm <= 0) {
          var mensaje = 'No existe disponibilidad del producto en Almacen, por favor realice una nueva compra del producto.';
          $("#msjalmacen").html(mensaje);
          $('#btn_add_sol').attr("disabled", true);
        } else {
          $("#msjalmacen").html('');
          $('#btn_add_sol').attr("disabled", false);
        }
      });
    }

    function cantidad_solicitada() {
      var cant_sol = parseInt(document.getElementById("cantidad_sol").value);
      var cant_alm = parseInt(document.getElementById("cant_almacen").value);

      if (cant_sol > cant_alm) {
        var mensaje = 'La cantidad solicitdad excede a la exitente en almacenes, por favor realice una nueva compra del producto.';
        $("#msjcaltidadsol").html(mensaje);
        $('#btn_add_sol').attr("disabled", true);
      } else {
        if (cant_sol < 1) {
          var mensaje = 'La cantidad debe ser mayor a 0. No se puede realizar solicitudes con cantidades iguales 0, ingrese una cantidad mayor a 0';
          $("#msjcaltidadsol").html(mensaje);
          $('#btn_add_sol').attr("disabled", true);
        } else {
          $("#msjcaltidadsol").html("");
          $('#btn_add_sol').attr("disabled", false);
        }
      }

    }
    //Inicio GAN-MS-B0-0288 KGAL
    function cok() {
      document.cookie = "lote = ;";
      document.cookie = "solicitante = ;";
      document.cookie = "tipo = ;";
    }
    //Fin GAN-MS-B0-0288 KGAL
  </script>
  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Provisi&oacute;n</a></li>
          <li class="active">Aprobaci&oacute;n de Solicitudes de Productos</li>
        </ol>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
            <div class="card card-bordered style-primary">
              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table class="table table-striped" id="datatable1">
                    <thead>
                      <tr>
                        <th>N&deg;</th>
                        <th>Sucursal Despachante</th>
                        <th>Sucursal Beneficiada</th>
                        <th>Solicitante</th>
                        <!--GAN-MS-B1-0462 Ayrton Guevara 11/05/2023-->
                        <th>Tipo</th>
                        <th>Cliente</th>
                        <!-- FIN GAN-MS-B1-0462 Ayrton Guevara 11/05/2023-->
                        <th>Fecha</th>
                        <th>Prioridad</th>
                        <th>Acci&oacute;n</th>
                        <?php if ($rol[0]->id_rol == 0) { ?>
                          <th>Priorizar</th>
                        <?php } ?>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      foreach ($lst_lotes as $sol) { ?>
                        <tr>
                          <td><?php echo $sol->onro ?></td>
                          <td><?php echo $sol->ode ?></td>
                          <td><?php echo $sol->oa ?></td>
                          <td><?php echo $sol->osolicitante ?></td>
                          <!--GAN-MS-B1-0462 Ayrton Guevara 11/05/2023-->
                          <td><?php echo $sol->otipo ?></td>
                          <td><?php echo $sol->ocliente ?></td>
                          <!--FIN GAN-MS-B1-0462 Ayrton Guevara 11/02/2023-->
                          <td><?php echo $sol->ofecha ?></td>
                          <td>
                            <div id="estado<?php echo $sol->olote ?>"><?php echo $sol->oprioridad ?></div>
                          </td>
                          <td align="center">
                            <form name="form_accion" method="post" action="<?= site_url() ?>conf_solicitud">
                              <input type="hidden" name="lote" value="<?php echo $sol->olote ?>">
                              <input type="hidden" name="tipo" value="<?php echo $sol->otipo ?>">
                              <input type="hidden" name="solicitante" value="<?php echo $sol->ode ?>">
                              <!-- Inicio Oscar Laura Aguirre GAN-MS-M1-0251  -->
                              <input type="hidden" name="ofechaent" value="<?php echo $sol->ofecha ?>">
                              <!-- FIN Oscar Laura Aguirre GAN-MS-M1-0251  -->
                              <!-- Inicio GAN-MS-B0-0288 KGAL -->
                              <button type="submit" title="Productos Solicitados" class="btn btn-info ink-reaction btn-raised" name="btn_cobro" onclick="cok()"><i class="fa fa-cart-arrow-down fa-lg"></i> &nbsp;&nbsp;Ver Pedidos</button>
                              <!-- FIN GAN-MS-B0-0288 KGAL -->
                            </form>
                          </td>
                          <?php if ($rol[0]->id_rol == 0) {
                            if ($sol->oprioridad == "URGENTE") {
                          ?>
                              <td align="center">
                                <label class="switch">
                                  <input id="switch<?php echo $sol->olote ?>" type="checkbox" onclick="priorizar('<?php echo $sol->olote ?>')" value="true" checked>
                                  <span class="slider"></span>
                                </label>
                              </td>
                            <?php } else {
                            ?>
                              <td align="center">
                                <label class="switch">
                                  <input id="switch<?php echo $sol->olote ?>" type="checkbox" onclick="priorizar('<?php echo $sol->olote ?>')" value="false">
                                  <span class="slider"></span>
                                </label>
                              </td>
                            <?php }
                            ?>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                    </tbody>
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
    function priorizar(olote) {
      if (document.getElementById("switch" + olote).value == "false") {
        $("#switch" + olote).val("true").trigger("change");
      } else {
        $("#switch" + olote).val("false").trigger("change");
      }
      $.ajax({
        url: "<?php echo site_url('provision/c_solicitud/priorizar') ?>",
        type: "POST",
        accepts: "JSON",
        data: {
          olote: olote,
          oestado: document.getElementById("switch" + olote).value
        },
        success: function(data) {
          data = JSON.parse(data);
          if (data[0].oboolean == 't') {
            if (document.getElementById("switch" + olote).value == "true") {
              document.getElementById("estado" + olote).innerHTML = "<td>URGENTE</td>";
            } else {
              document.getElementById("estado" + olote).innerHTML = "<td>EN ESPERA</td>";
            }
          } else {
            if (document.getElementById("switch" + olote).value == "false") {
              $("#switch" + olote).val("true").trigger("change");
              $("#switch" + olote).prop("checked", true);
            } else {
              $("#switch" + olote).prop("checked", false);
              $("#switch" + olote).val("false").trigger("change");
            }
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data[0].omensaje,
              confirmButtonText: 'Ok'
            }).then(() => {
              location.reload();
            })
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }
  </script>
<?php } else {
  redirect('inicio');
} ?>