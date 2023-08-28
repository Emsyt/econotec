<?php
/*
  ------------------------------------------------------------------------------
  Creado: Luis Fabricio Pari Wayar   Fecha:19/10/2022, Codigo:GAN-DPR-M6-0060
  Descripcion: Se creo la Vista de "envio de productos" 
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Agurire Fecha:10/02/2023, Codigo: GAN-MS-B0-0254
  Descripcion: se agrego get_lst_ubicacion en el modelo para que pueda obtener una lista de ubicaciones
  menos la que es del usuario logueado.
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha: 18/05/2023, Codigo: GAN-MS-B1-0477
  Descripcion: Se realizo el mantenimiento de esta vista para que el sub modulo Envio entre en funcionamiento de manera sincronica con su correspondiente controlador y modelo.
*/
?>
<?php if (in_array("smod_env_prod", $permisos)) { ?>
  <input type="hidden" name="contador" id="contador" value="<?php echo $contador ?>">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      var f = new Date();
      fecha_actual = f.getFullYear() + "-";
      if ((f.getMonth() + 1) < 10) {
        fecha_actual = fecha_actual + "0" + (f.getMonth() + 1) + "-";
      } else {
        fecha_actual = fecha_actual + (f.getMonth() + 1) + "-";
      }
      if (f.getDate() < 10) {
        fecha_actual = fecha_actual + "0" + f.getDate();
      } else {
        fecha_actual = fecha_actual + f.getDate();
      }
      document.getElementById("fec_entrega").value = fecha_actual;
      document.getElementById("fec").value = fecha_actual;

      var cont_solicitud = $("#contador").val();
      activarMenu('menu9', 5);
      hab_botones(cont_solicitud);
      $('#btn_conf_sol').attr("disabled", true);
    });
  </script>

  <script>
    function hab_botones(cont_solicitud) {
      if (cont_solicitud == 0) {
        $('#btn_conf_sol').attr("disabled", true);
      } else {
        $('#btn_conf_sol').attr("disabled", false);
      }
    }

    function cantidad_almacen() {
      id_producto = document.getElementById("producto");
      var selc_prod = id_producto.options[id_producto.selectedIndex].value;
      ubi_ini = document.getElementById("ubi_ini").value;
      $.post("<?= base_url() ?>provision/C_envio/func_auxiliares", {
        accion: 'cantidad_almacen',
        selc_prod: selc_prod,
        ubi_ini: ubi_ini
      }, function(data) {
        var data = JSON.parse(data);
        if (data != "") {
          $("#c_cant_almacen").removeClass("floating-label");
          var cant_alm = parseInt(data[0].fn_cantidad_producto_ubicacion);
          $('[name="cant_almacen"]').val(cant_alm);
          if (cant_alm <= 0) {
            var mensaje =
              'No existe disponibilidad del producto en Almacen, por favor realice una nueva compra del producto.';
            $("#msjalmacen").html(mensaje);
            $('#btn_add_sol').attr("disabled", true);
          } else {
            $("#msjalmacen").html('');
            $('#btn_add_sol').attr("disabled", false);
          }
        }
      });
    }

    function cantidad_solicitada() {
      var cant_sol = parseInt(document.getElementById("cantidad_sol").value);
      var cant_alm = parseInt(document.getElementById("cant_almacen").value);

      if (cant_sol > cant_alm) {
        var mensaje =
          'La cantidad solicitdad excede a la exitente en almacenes, por favor realice una nueva compra del producto.';
        $("#msjcaltidadsol").html(mensaje);
        $('#btn_add_sol').attr("disabled", true);
      } else {
        if (cant_sol < 1) {
          var mensaje =
            'La cantidad debe ser mayor a 0. No se puede realizar solicitudes con cantidades iguales 0, ingrese una cantidad mayor a 0';
          $("#msjcaltidadsol").html(mensaje);
          $('#btn_add_sol').attr("disabled", true);
        } else {
          $("#msjcaltidadsol").html("");
          $('#btn_add_sol').attr("disabled", false);
        }
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

    .disabledbutton {
      pointer-events: none !important;
      opacity: 0.4 !important;
    }
  </style>
  <div class="modal fade" name="modal_fecha" id="modal_fecha" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header card style-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 style="text-align: center;" class="modal-title" id="formModalLabel">INGRESE LA FECHA DE ENTREGA</h4>
        </div>
        <div class="modal-body">
          <div class="form-group floating-label">
            <div class="input-group-content col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
              <label for="fec_entrega">Fecha de Entrega</label>
              <input style="text-align: center;" type="date" class="form-control" name="fec_entrega" id="fec_entrega" onchange="validar()">
            </div>
          </div>
        </div>
        <br><br>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="button" id="btnGuardar" onclick="enviar()" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Envio de producto</a></li>
          <li class="active">Solicitud de Envio</li>
        </ol>
      </div>
      <div class="section-body" id="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
            <form class="form form-validate" novalidate="novalidate" name="form_solicitud" id="form_solicitud" method="post" action="<?= site_url() ?>provision/C_envio/add_solicitud">
              <div class="card">
                <div class="card-head style-primary">
                  <header>Registro de Envio de Productos</header>
                </div>
                <div class="card-body" id="container2">
                  <div class="form-group floating-label col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <select class="form-control select2-list" id="ubi_ini" name="ubi_ini" onchange="show();" required>
                      <option value=""></option>
                      <!-- INICIO Oscar L., GAN-MS-B0-0254  -->
                      <?php foreach ($ubicacion as $ubi) {  ?>
                        <option value="<?php echo $ubi->id_ubicacion ?>" <?php echo set_select('ubi_ini', $ubi->id_ubicacion) ?>>
                          <?php echo $ubi->descripcion ?></option>
                      <?php } ?>
                      <!-- FIN GAN-MS-B0-0254  -->
                    </select>
                    <label for="producto">Seleccione Ubicacion a Enviar</label>
                    <div class="form-group" id="process" style="display:none;">
                      <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120" style="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" name="lista" id="lista">
                  <input type="hidden" name="id_mod" id="id_mod" value="0">
                  <div id="lst" style="display: block"> <!-- ILaquis  -->
                    <div id="productos">
                    </div>

                    <div class="row">
                      <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="form-group floating-label" id="c_cant_almacen">
                          <input type="number" class="form-control" name="cant_almacen" id="cant_almacen" readonly="">
                          <label for="cant_almacen">Cantidad Disponible</label>
                          <div id="msjalmacen" style="color: #f44336"></div>
                        </div>
                      </div>

                      <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="form-group floating-label">
                          <input type="number" class="form-control" name="cantidad_sol" id="cantidad_sol" onchange="cantidad_solicitada()" required="">
                          <label for="cantidad_sol">Cantidad a enviar</label>
                          <div id="msjcaltidadsol" style="color: #f44336"></div>
                        </div>
                      </div>


                    </div>

                    <div class="card-actionbar">
                      <div class="card-actionbar-row">
                        <button type="button" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add_sol" onclick="validar_producto()" value="add">Agregar producto(s) a envio </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
          <div class="card card-bordered style-primary">
            <div class="card-body style-default-bright">
              <div class="table-responsive">
                <table class="table table-striped" id="tabla">
                  <thead>
                    <tr>
                      <th width: 5%>Acci&oacute;n</th>
                      <th>Producto</th>
                      <th>Unidad</th>
                      <th>Cantidad Enviada</th>
                      <th>Estado</th>
                      <th>Cantidad Disponible</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <form class="form form-validate" novalidate="novalidate" name="conf_solicitud" id="conf_solicitud" method="post" action="<?= site_url() ?>provision/C_envio/confirmar_solicitud">
                      <input type="hidden" name="fec" id="fec">
                      <input type="hidden" name="sel_ubi" id="sel_ubi">
                      <tr>
                        <td colspan="5" style="text-align: right; border-top: 0; padding-top: 20px">
                          <button type="button" class="btn ink-reaction btn-raised btn-primary" name="btn" id="btn_conf_sol" onclick="mostrar();" value="conf">Confirmar Envio</button> &nbsp;&nbsp;&nbsp;
                        </td>
                      </tr>
                    </form>
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
  <script>
    function validar_producto() {
      if (document.getElementById('cantidad_sol').value < 0) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'La cantidad solicitada no puede ser menor a 0',
        })
      } else {
        if (parseFloat(document.getElementById('cant_almacen').value) < parseFloat(document.getElementById(
            'cantidad_sol').value)) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La cantidad solicitada no puede ser mayor a la cantidad en almacen',
          })
        } else {
          registrar();
          limpiar();
        }
      }
    }
    //GAN-MS-A1-465 21/09/2022 DPucho
    function limpiar() {
      document.getElementById('producto').selectedIndex = 0;
      document.getElementById('cantidad_sol').value = '';
      document.getElementById('cant_almacen').value = '';
    }
    //fin GAN-MS-A1-465 21/09/2022 DPucho
    function registrar() {
      $.ajax({
        url: "<?= site_url() ?>provision/C_envio/add_solicitud",
        type: "POST",
        accepts: "JSON",
        data: $('#form_solicitud').serialize(),
        success: function(data) {
          data = JSON.parse(data);
          if (data[0].oboolean == 't') {
            if (data[0].omodificado != "") {
              Swal.fire({
                icon: 'success',
                title: data[0].omodificado,
                confirmButtonText: 'Aceptar',
              })
            } else {
              Swal.fire({
                icon: 'success',
                title: 'Producto adicionado exitosamente',
                confirmButtonText: 'Aceptar',
              })
            }
            var ubi = document.getElementById("ubi_ini").value;
            $.ajax({
              url: "<?= site_url() ?>provision/C_envio/get_lst_solicitud/",
              type: "post",
              datatype: "json",
              data: {
                ubicacion: ubi
              },
              success: function(data) {
                tabla(data);
                cantidad_almacen();
                if (ubi != '') {
                  id_producto = document.getElementById("producto").value;
                  $('[name="sel_ubi"]').val(ubi).trigger('change');
                  $.ajax({
                    // GAN-MS-B1-0471, 17/05/2023 ILaquis.
                    url: '<?= site_url() ?>provision/C_envio/get_prod',
                    // FIN GAN-MS-B1-0471, 17/05/2023 ILaquis.
                    type: "post",
                    datatype: "json",
                    data: {
                      ubicacion: ubi
                    },
                    success: function(data) {
                      build_select(data);
                      $("#producto").val(id_producto).trigger("change");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                      alert('Error al obtener datos');
                    }
                  });

                }
              },
              //GAN-MS-A1-476 21/09/2022 DPucho
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
                    $("#container2").addClass("disabledbutton");
                    $(".progress-bar").css("width", +percent + "%");
                    if (percent >= 100) {
                      var delayInMilliseconds = 0; //ILaquis

                      setTimeout(function() {
                        $('#process').css('display', 'none');
                        $('.progress-bar').css('width', '0%');
                        $("#container2").removeClass("disabledbutton");
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
              //fin GAN-MS-A1-476 21/09/2022 DPucho
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
              }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data[0].omensaje,
              confirmButtonText: 'ok',
            })
          }

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }

    function mostrar() {
      var text = JSON.parse(document.getElementById("lista").value.trim());
      if (text.length != 0) {
        $('#modal_fecha').modal('show');
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'no existe ningun producto',
        })
      }
    }

    function enviar() {
      $('#modal_fecha').modal('hide');
      document.getElementById("conf_solicitud").submit();
    }

    function validar() {
      var f = new Date();
      fecha_actual = f.getFullYear() + "-";
      if ((f.getMonth() + 1) < 10) {
        fecha_actual = fecha_actual + "0" + (f.getMonth() + 1) + "-";
      } else {
        fecha_actual = fecha_actual + (f.getMonth() + 1) + "-";
      }
      if (f.getDate() < 10) {
        fecha_actual = fecha_actual + "0" + f.getDate();
      } else {
        fecha_actual = fecha_actual + f.getDate();
      }
      var fec = document.getElementById("fec_entrega").value;
      if (fec != "") {
        if (fec < fecha_actual) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La fecha de entrega no puede ser una fecha pasada.',
          })
          document.getElementById("fec_entrega").value = fecha_actual;
          document.getElementById("fec").value = fecha_actual;
        } else {
          document.getElementById("fec").value = document.getElementById("fec_entrega").value;
        }
      } else {
        document.getElementById("fec").value = "";
      }

    }

    function build_select(data) {
      document.getElementById("productos").innerHTML = "";
      var data = JSON.parse(data);
      var prod = '<div class="row">\
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">\
                            <hr>\
                            <div class="form-group floating-label">\
                            <label id="lab2" style="display: none" for="producto">Seleccione Producto</label>\
                              <select class="form-control select2-list" id="producto" name="producto" onchange="hide();cantidad_almacen();" required="">\
                                <option value=""></option>';
      for (var i = 0; i < data.length; i++) {
        prod = prod + "<option value=" + data[i].oidproducto + "> " + data[i].oproducto +
          "</option>";
      }
      prod = prod + '</select>\
                          <label id="lab" for="producto">Seleccione Producto</label>\
                        </div>\
                      </div>\
                    </div>';
      document.getElementById("productos").innerHTML = prod;
      $('#producto').select2();
      document.getElementById("lst").style.display = "block";
    }

    function show() {
      $('#btn_conf_sol').attr("disabled", false);
      $('[name="producto"]').val(null).trigger('change');
      $('[name="cant_almacen"]').val(null).trigger('change');
      $('[name="cantidad_sol"]').val(null).trigger('change');

      var ubi = document.getElementById("ubi_ini").value;
      if (ubi != '') {
        $('[name="sel_ubi"]').val(ubi).trigger('change');
        $.ajax({
          // GAN-MS-B1-0471, 17/05/2023 ILaquis.
          url: '<?= site_url() ?>provision/C_envio/get_prod',
          // FIN GAN-MS-B1-0471, 17/05/2023 ILaquis.
          type: "post",
          datatype: "json",
          data: {
            ubicacion: ubi
          },
          success: function(data) {
            build_select(data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos');
          },

        });
      }
      $.ajax({
        url: "<?= site_url() ?>provision/C_envio/get_lst_solicitud/",
        type: "post",
        datatype: "json",
        data: {
          ubicacion: ubi
        },
        success: function(data) {
          tabla(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        },
        //GAN-MS-A1-476 21/09/2022 DPucho
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
                var delayInMilliseconds = 0; //ILaquis

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
        //fin GAN-MS-A1-476 21/09/2022 DPucho
      });
    }

    function tabla(data) {
      document.getElementById("lista").value = data;
      var data = JSON.parse(data);
      var t = $('#tabla').DataTable({
        "data": data,
        "responsive": true,
        "language": {
          "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
        },
        "destroy": true,
        "columnDefs": [{
          "searchable": false,
          "orderable": false,
          targets: 0,
          className: 'select-checkbox',
          orderable: false,
        }],
        order: [
          [1, 'asc']
        ],
        "columns": [{
            "width": "5%"
          },
          null,
          null,
          null,
          null
        ],
        "aoColumns": [{
            "mRender": function(data, type, row, meta) {
              var a = `
                        <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_solicitud('${row.oidmovimiento}','${row.oidproducto}')"><i class="fa fa-trash-o"></i></button>
                                    `;
              return a;
            }
          },
          {
            "mData": "oproducto"
          },
          {
            "mData": "ounidad"
          },
          {
            "mData": "osolicitado"
          },
          {
            "mData": "oestado"
          },
          {
            "mData": "oexistente"
          },
        ],
        "dom": 'C<"clear">lfrtip',
        "colVis": {
          "buttonText": "Columnas"
        },
      });
    }

    function hide() {
      document.getElementById("lab").style.display = "none";
      document.getElementById("lab2").style.display = "block";
    }

    function eliminar_solicitud(id_sol, id_prod) {
      var ubi = document.getElementById("ubi_ini").value;
      BootstrapDialog.show({
        title: 'ELIMINAR PROVISION',
        message: '<div>Esta seguro que desea <b>eliminar</b> el <b>producto</b> de la solicitud a almacenes</div>',
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialog) {
            var $button = this;
            $button.disable();
            $.ajax({
              url: '<?= base_url() ?>provision/C_envio/dlt_solicitud/' + id_sol,
              type: "post",
              datatype: "json",
              data: {
                ubicacion: ubi
              },
              success: function(data) {
                var data = JSON.parse(data);
                if (data[0].oboolean == 't') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Se elimino el producto exitosamente',
                  })
                  $.ajax({
                    url: "<?= site_url() ?>provision/C_envio/get_lst_solicitud/",
                    type: "post",
                    datatype: "json",
                    data: {
                      ubicacion: ubi
                    },
                    success: function(data) {
                      tabla(data);
                      cantidad_almacen();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                      alert('Error al obtener datos de ajax');
                    }
                  });
                  if (ubi != '') {
                    $('[name="sel_ubi"]').val(ubi).trigger('change');
                    $.ajax({
                      // GAN-MS-B1-0471, 17/05/2023 ILaquis.
                      url: '<?= site_url() ?>provision/C_envio/get_prod',
                      // FIN GAN-MS-B1-0471, 17/05/2023 ILaquis.
                      type: "post",
                      datatype: "json",
                      data: {
                        ubicacion: ubi
                      },
                      success: function(data) {
                        build_select(data);
                        $("#producto").val(id_prod).trigger("change");
                      },
                      error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos');
                      }
                    });

                  }
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data[0].omensaje,
                  })
                }
                dialog.close();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos');
              }
            });

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