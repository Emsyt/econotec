<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Melvin Salvador Cussi Callisaya Fecha:12/04/2022, Codigo: GAN-MS-A4-149,
Descripcion: se agrego unos checkbox a la lista para que estos se puedan seleccionar cuales seran aprobados
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:19/04/2022, Codigo:GAN-FR-A0-165
Descripcion: se implemento la parte funcional de la confirmación de PEDIDOS DE PRODUCTOS.
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:19/04/2022, Codigo:GAN-MS-M3-169
Descripcion: se implemento la impresion de pdf al momento de confirmar las solicitudes.
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:27/04/2022, Codigo:GAN-MS-A6-194
Descripcion: se adiciono el combo para la seleccion de transporte.
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:27/04/2022, Codigo:GAN-MS-A5-193
Descripcion: se adiciono el campo de estado al datatable.
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:27/04/2022, Codigo:GAN-MS-A7-195
Descripcion: se modifico el alert para que este tenga la opcion de cancelar antes de finalizar.
------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:27/04/2022, Codigo:GAN-MS-A7-205
Descripcion: se agrego el campo de fecha al confirmar las solicitudes de productos
------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma Fecha:16/09/2022, Codigo:GAN-FR-A1-461
Descripcion: se cambio a un input la cantidad solicitada y se agrego su validacion.
------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma Fecha:19/09/2022, Codigo:GAN-MS-A1-466
Descripcion: se modifico el ajax para enviar la cantidad del producto modificada al controlador.
------------------------------------------------------------------------------
Modificado: Kevin Gerardo Alcon Lazarte Fecha:15/02/2023, Codigo:GAN-MS-B3-0277
Descripcion: Se agrego lineas de comandos para devolver las cookie en la funcion confirmar
------------------------------------------------------------------------------
Modificado: Oscar Laura Aguirre  Fecha: 17/02/2023,   Codigo: GAN-MS-B3-0292
Descripcion: Al momento de finalizar o imprimir la vista se  direcciono a la tabla de solicitudes.
------------------------------------------------------------------------------
Modificado: Oscar Laura Aguirre  Fecha: 20/03/2023,   Codigo: GAN-MS-M1-0251
Descripcion: Se modifico la fecha para sea la misma fecha con la que se hizo en solicitud de producto.
*/
?>
<?php if (in_array("smod_sol_prod", $permisos)) { ?>
  <style>
    hr {
      margin-top: 0px;
    }

    .select2-container .select2-choice>.select2-chosen {
      white-space: normal;
    }

    .swal2-popup {
      font-size: 1.3rem !important;
      font-family: 'Times New Roman', Times, serif;
    }

    .error-message {
      color: red;
      font-size: 14px;
      font-weight: bold;
    }

    .success-message {
      color: green;
      font-size: 14px;
      font-weight: bold;
    }
  </style>
  <script>
    $(document).ready(function() {
      activarMenu('menu9', 3);
    });
  </script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
  <script src="//cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="//cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>
  <script type="text/javascript">
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

    function condicionStock() {
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
  </script>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Provisi&oacute;n</a></li>
          <li class="active">Aprobaci&oacute;n de Productos</li>
          <li class="active"><?php echo $solicitante ?></li>
        </ol>
      </div>
      <form name="form_accion" id="form_accion" target="_blank" method="post" action="<?= site_url() ?>provision/C_solicitud/generar_pdf">
        <input type="hidden" name="array" id="array">
        <input type="hidden" name="array2" id="array2">
        <input type="hidden" name="id_transporte" id="id_transporte">
        <input type="hidden" name="fec" id="fec">
      </form>
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
          <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
          <div class="card card-bordered style-primary">
            <div class="card-body style-default-bright">
              <div class="row">
                <div class="table-responsive">
                  <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
                    <div class=" col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
                    <div class="form floating-label col-xs-12 col-sm-12 col-md-3 col-lg-3" id="c_transporte" style="text-align: center;">
                      <select class="form-control select2-list" name="transporte" id="transporte" onchange="sel();">
                        <?php foreach ($lst_transportes as $tran) { ?>
                          <option value="<?php echo $tran->oidtransporte ?>"> <?php echo $tran->otransporte ?> </option>
                        <?php } ?>
                      </select>
                      <label for="transporte">SELECCIONE TRANSPORTE</label>
                    </div>
                    <div class="form-group floating-label col-xs-12 col-sm-12 col-md-3 col-lg-3" style="text-align: center;">
                      <div class="input-group date" id="demo-date-val">
                        <div class="input-group-content">
                          <input type="hidden" name="fecha" id="fecha">
                          <input style="text-align: center;" type="text" class="form-control" name="fec_entrega" id="fec_entrega" onchange="validar()" readonly="readonly" required>
                        </div>
                        <span class="input-group-addon" id="cal"><i class="fa fa-calendar"></i></span>
                      </div>
                      <small for="fec_entrega">Fecha de Entrega</small>
                    </div>
                  </div>
                  <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <hr>
                    <?php if ($tipo == 'DISTRIBUIDOR') {?>
                      <div class="row">
                      <div class=" col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <h4>Tipo de solicitud: <strong><?php echo $tipo ?></strong></h4>
                        <input type="hidden" name="telf" id="telf">
                      </div>
                      <div class=" col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <select class="form-control select2-list" id="proveedor" name="proveedor" required>
                          <option value=""></option>
                          <?php foreach ($proveedores as $prove) {  ?>
                            <option value="<?php echo $prove->id_personas ?>" <?php echo set_select('proveedor', $prove->proveedor) ?>> <?php echo $prove->proveedor ?></option>
                          <?php  } ?>
                        </select>
                        <span id="error_num_prov" style="display: none;" class="error-message">¡Proveedor sin número de celular!</span>
                        <span id="succes_num_prov" style="display: none;" class="success-message">¡Proveedor con número de celular!</span>
                      </div>
                      <div class=" col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <button class="btn ink-reaction btn-raised btn-success" onclick="enviar_whats(<?php $lote ?>)" id="enviar_sol" name="enviar_sol" type="button" disabled>
                          Enviar a proveedor <i class="fa fa-whatsapp"></i>
                        </button>
                      </div>
                    </div>
                    <?php } else{ ?>
                      <div class="row">
                      <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h4>Tipo de solicitud: <strong><?php echo $tipo ?></strong></h4>
                        <input type="hidden" name="telf" id="telf">
                      </div>
                    </div>
                    <?php } ?>
                    
                    <br>
                    <hr>
                  </div>
                  <table class="table table-striped" id="datatable3">

                    <thead>
                      <tr>
                        <th><input type="checkbox" id="select_all_existent"></th>
                        <th style="width:30%">Producto</th>
                        <th>Unidad</th>
                        <th>Cantidad Solicitada</th>
                        <th>Cantidad en Almacen</th>
                        <th>Estado</th>
                        <th>Solicitado por</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <td colspan="6" style="text-align: right; border-top: 0; padding-top: 20px">
                          <button type="button" title="Volver" class="btn btn-default ink-reaction btn-raised" onclick="volver()"><i class="fa fa-mail-reply fa-lg"></i> &nbsp;&nbsp;Volver</button>
                        </td>
                        <td colspan="1" style="text-align: right; border-top: 0; padding-top: 20px">
                          <button type="button" id="confirm" class="btn btn-primary ink-reaction btn-raised">Confirmar</button>
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


  <script>
    function enviar_whats(id_lote) {
      var telefono_proveedor = document.getElementById('telf').value;
      console.log(id_lote);
      console.log(telefono_proveedor);
      $.ajax({
        url: "<?php echo site_url('provision/C_solicitud/set_msg_whatsapp') ?>/" + telefono_proveedor,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          var link = data[0].omensaje;
          window.open(link, "_blank");
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error get data from ajax');
        }
      });
    }

    $(document).ready(function() {
      /* Inicio Oscar Laura Aguirre GAN-MS-M1-0251 */
      var ff = new Date('<?php echo $ofechaent ?>');
      var f = new Date(ff.getFullYear(), ff.getMonth(), ff.getDate() + 1);
      /* FIN Oscar Laura Aguirre GAN-MS-M1-0251 */
      fecha_actual = f.getFullYear() + "/";
      if ((f.getMonth() + 1) < 10) {
        fecha_actual = fecha_actual + "0" + (f.getMonth() + 1) + "/";
      } else {
        fecha_actual = fecha_actual + (f.getMonth() + 1) + "/";
      }
      if (f.getDate() < 10) {
        fecha_actual = fecha_actual + "0" + f.getDate();
      } else {
        fecha_actual = fecha_actual + f.getDate();
      }
      document.getElementById("fec_entrega").value = fecha_actual;
      document.getElementById("fec").value = fecha_actual;
      $("#id_transporte").val(<?php echo $lst_transportes[0]->oidtransporte ?>).trigger('change');
      var x = 0;
      $.ajax({
        url: "<?= site_url() ?>provision/C_solicitud/get_lst_solicitud/",
        type: "post",
        datatype: "json",
        success: function(data) {
          // console.log(data);
          // console.log(data.length);
          // //Inicio GAN-MS-B3-0277 KGAL
          // if(data.length <=2){document.cookie = "lote = ;";
          //                     document.cookie = "solicitante = ;";
          //                     location.href = "<?php echo base_url(); ?>solicitud";
          //                     console.log("ya no hay datos que mostrar en la tabla");}
          // //FIN GAN-MS-B3-0277 KGAL
          var data = JSON.parse(data);
          var cont = 0;
          var t = $('#datatable3').DataTable({
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
            "aoColumns": [{
                "mRender": function(data, type, row, meta) {
                  var a = `
                                    <input type="checkbox" name="checkbox" id="checkbox${cont}" value="${row.oidmovimiento}" >
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
                "mData": "ocantidad_solicitada",
                render: function(data, type, row) {
                  // INICIO ,GAN-MS-B5-0252, ALKG
                  return '<input style="width:80px;" type="text" name="cantidad_soli" id="cantidad_soli" oninput= "validarCantidad(' + row.odisponible + ',' + row.ocantidad_solicitada + ', this.value )" class="cant_soli" value= ' + data + '><p style="display:none;" id="soli">' + data + '</p>';
                  // FIN ,GAN-MS-B5-0252, ALKG
                }
              },
              {
                "mData": "odisponible",
              },
              {
                "mData": "oestado"
              },
              {
                "mData": "osolicitado"
              },
              {
                "mRender": function(data, type, row, meta) {
                  cont++;
                  var a = `
                                    <div class="col text-center">
                                    <button type="button"  title="Rechazar Solicitud" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="rechazar_producto('${row.oidmovimiento}')"><i class="fa fa-times fa-lg"></i></button>
                                    </div>
                                    `;
                  return a;
                },
              }
            ],
            "dom": 'C<"clear">lfrtip',
            "colVis": {
              "buttonText": "Columnas"
            },
          });

          $('#select_all_existent').change(function() {
            var cells = t.cells().nodes();
            $(cells).find(':checkbox').prop('checked', $(this).is(':checked'));

          });

          $('#proveedor').change(function() {
            var id_prov = $(this).val();
            $.ajax({
              url: "<?php echo site_url('provision/C_solicitud/get_telf_proveedor') ?>/" + id_prov,
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                console.log(data);
                try {
                  document.getElementById('error_num_prov').style.display = 'none';
                  $("#telf").val(data[0].movil);
                  var button = document.getElementById('enviar_sol');
                  button.disabled = false;

                } catch (error) {
                  document.getElementById('error_num_prov').style.display = 'block';
                  var button = document.getElementById('enviar_sol');
                  button.disabled = true;
                }

              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
              }
            });
          });


          $("#confirm").click(function() {
            var tran = document.getElementById("id_transporte").value;
            var fec_entrega = document.getElementById("fec_entrega").value;
            var cells = t.cells().nodes();
            var array = [];
            var array2 = [];
            for (var i = 0; i < data.length; i++) {
              if ($(cells).find(':checkbox')[i].checked) {
                array.push($(cells).find(':checkbox')[i].value);
                array2.push($(cells).find(':text')[i].value);
              }
            }
            console.log(typeof(array2));
            console.log(array2)
            console.log('espacio');
            console.log(array);
            if (array.length === 0) {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe elegir por lo menos un producto!',
              })
            } else {
              Swal.fire({
                title: 'ORDEN DE PEDIDO',
                text: 'Seleccione la acción a realizar',
                icon: 'info',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#8BC34A',
                cancelButtonColor: '#d33',
                denyButtonColor: '#3FC3EE',
                confirmButtonText: 'Finalizar',
                denyButtonText: `Imprimir`,
                cancelButtonText: 'Cancelar',
              }).then((result) => {
                if (result.isDenied) {
                  $('[name="array"]').val(JSON.stringify(array));
                  $('[name="array2"]').val(JSON.stringify(array2));
                  document.getElementById("form_accion").submit();
                  location.reload();
                } else if (result.isConfirmed) {
                  $.ajax({
                    url: '<?= site_url() ?>provision/C_solicitud/confirmar_lote',
                    type: "post",
                    datatype: "json",
                    data: {
                      tran: tran,
                      array: array,
                      array2: array2,
                      fec_entrega: fec_entrega
                    },
                    success: function(data) {
                      document.cookie = "array = " + JSON.stringify(array);
                      location.reload();
                    }
                  });
                }
                /*  INICIO Oscar L., GAN-MS-B3-0292  */
                volver()
                /*  FIN GAN-MS-B3-0292  */
              })
            }
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
          console.log("error en ajax  finalizar");
        }



      });
    });

    function validar() {
      var f = new Date();
      fecha_actual = f.getFullYear() + "/";
      if ((f.getMonth() + 1) < 10) {
        fecha_actual = fecha_actual + "0" + (f.getMonth() + 1) + "/";
      } else {
        fecha_actual = fecha_actual + (f.getMonth() + 1) + "/";
      }
      if (f.getDate() < 10) {
        fecha_actual = fecha_actual + "0" + f.getDate();
      } else {
        fecha_actual = fecha_actual + f.getDate();
      }
      var fec = document.getElementById("fec_entrega").value;
      fec.split("")
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
      }
    }

    function sel() {
      var tran = document.getElementById("transporte").value;
      $("#id_transporte").val(tran).trigger('change');
    }

    function finalizar(array, array2) {
      $.ajax({
        url: '<?= site_url() ?>provision/C_solicitud/confirmar_lote',
        type: "post",
        datatype: "json",
        data: {
          array: array,
          array2: array2
        },
        success: function(data) {
          location.reload();
        }
      });
    }

    function rechazar_producto(id_mov, ubi_mov) {
      BootstrapDialog.show({
        title: 'RECHAZAR PRODUCTO',
        message: '<div>Esta seguro que desea <b>rechazar</b> el <b>producto</b> de la lista de solicitud a almacenes.</div>',
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialog) {
            var $button = this;
            $button.disable();
            window.location = '<?= base_url() ?>provision/C_solicitud/dlt_producto/' + id_mov;
          }
        }, {
          label: 'Cancelar',
          action: function(dialog) {
            dialog.close();
          }
        }]
      });
    }

    function volver() {
      document.cookie = "lote = ;";
      document.cookie = "solicitante = ;";
      location.href = "<?php echo base_url(); ?>solicitud";
    }

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
    //INICIO ,GAN-MS-B5-0252, ALKG
    function validarCantidad(odisponible2, ocantidad_solicitada2, data2) {
      data2 = parseInt(data2);
      var boton = document.getElementById("confirm");
      if (data2 > odisponible2) {
        boton.disabled = true;
        Swal.fire('La cantidad solicitada de excede al inventario del Almacen')
      } else {
        boton.disabled = false;
      }
    }
    //FIN ,GAN-MS-B5-0252, ALKG
  </script>

  <script type="text/javascript">
    function setInputFilter(textbox, inputFilter, errMsg) {
      ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop", "focusout"].forEach(function(event) {
        for (var i = 0; i < textbox.length; i++) {

          textbox[i].addEventListener(event, function(e) {
            if (inputFilter(this.value)) {

              if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                this.classList.remove("input-error");
                this.setCustomValidity("");
              }
              this.oldValue = this.value;
              this.oldSelectionStart = this.selectionStart;
              this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {

              this.classList.add("input-error");
              this.setCustomValidity(errMsg);
              this.reportValidity();
              this.value = this.oldValue;
              this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {

              this.value = "";
            }
          });
        }
      });
    }
    $('body').ajaxComplete(function() {
      setInputFilter(document.getElementsByClassName("cant_soli"), function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) >= 1);
      }, "Ingrese un número mayor a 0 y no mayor a la cantidad en Almancen.");

    });
  </script>
<?php } else {
  redirect('inicio');
} ?>