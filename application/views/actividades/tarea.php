<?php
/*
    ------------------------------------------------------------------------------
    Creador: Alvaro Ruben Gonzales Vilte  Fecha 07/12/2022, Codigo: GAN-MS-A6-0168,
    Descripcion: Se agrego una seccion de materiales en el modulo de tareas 
     ------------------------------------------------------------------------------
    Creador: Alvaro Ruben Gonzales Vilte  Fecha 08/12/2022, Codigo: GAN-MS-A6-0171,
    Descripcion: Funcionamiento del registro y modificacion de los materiales
    ------------------------------------------------------------------------------
    Modificado: Oscar Laura Aguirre Fecha: 16/02/2023 Codigo: GAN-MS-B0-0283
    Descripcion: Se cambio el texto de la caja de buscar que esta con SEARCH a BUSCAR en español
*/

?>
<script>
  $(document).ready(function() {

    activarMenu('menu13_1');


    var x = 1;
    var MaxInputs = 100; //maximum input boxes allowed
    var FieldCount = 0; //to keep track of text box added
    var numerador = 1;
    var FieldCount2 = 0; //to keep track of text box added
    var numerador2 = 1;

    //Begin contenedor 1
    $('#agregarCampo1').click(function(e) { //on add input button click

      if (x <= MaxInputs) { //max input box allowed
        FieldCount++; //text box added increment
        numerador++;
        $('#contenedor1').append('<div class="row">\
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">\
                    <div class="form-group">\
                        <div class="input-group input-group-lg">\
                            <div class="input-group-content">\
                                <div class="col-10">\
                                    <div class="form-group form-floating" id="c_personal' + FieldCount + '">\
                                        <select class="form-control select2-list" name="tarea[]" id="personal' + FieldCount + '" >\
                                         <option value=""></option>\
                                      <?php foreach ($empleado as $emp) {  ?>\
                                        <option value="<?php echo $emp->id_empleado ?>"> <?php echo $emp->nombre . ' ' . $emp->paterno . ' ' . $emp->materno . ' - ' . $emp->ci ?></option>\
                                      <?php  } ?>\
                                        </select>\
                                        <label for="personal">Seleccione Personal</label>\
                                        </div>\
                                    </div>\
                                </div>\
                            <div class="input-group-btn">\
                                <button type="button" class="btn btn-floating-action btn-danger"  id="eliminarContenedor1"><i class="fa fa-trash"></i></button>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>');
        $(".select2-list").select2({
          allowClear: true,
          language: "es"
        });

        x++;

      }
      $('#contador').val(FieldCount).trigger('change');
      $('#numerador').val(numerador).trigger('change');
      return false;
    });

    $("body").on("click", "#eliminarContenedor1", function(e) { //user click on remove text
      if (x > 1) {
        var e = $(this).parent('div').parent('div').parent('div').parent('div').parent('div');
        e.remove();
        x--; //decrement textbox
        numerador--;
        $('#numerador').val(numerador).trigger('change');
      }
      return false;
    });

    $('#agregarCampo2').click(function(e) { //on add input button click

      if (x <= MaxInputs) { //max input box allowed
        FieldCount2++; //text box added increment
        numerador2++;
        // alert("Ingreso contenedor1: " + FieldCount)

        //add input box

        $('#contenedor2').append('<div class="row">\
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">\
      <div class="form-group">\
          <div class="input-group input-group-lg">\
              <div class="input-group-content">\
                  <div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">\
                      <div class="form-group form-floating" id="c_producto' + FieldCount2 + '">\
                          <select class="form-control select2-list" name="producto[]" onchange="actualizar(this,\'' +
          "lable_produc" + FieldCount2 + '\')" id="producto' + FieldCount2 + '" >\
                          <option value=" "></option>\
                          <?php foreach ($productos as $pro) {  ?>\
                              <option value="<?php echo $pro->oidproducto ?>" > <?php echo $pro->oproducto ?></option>\
                          <?php  } ?>\
                          </select>\
                          <label for="producto">Seleccione Material</label>\
                          </div>\
                      </div>\
                      <div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">\
                          <div class="form-group form-floating" id="c_cantidad' + FieldCount2 + '">\
                              <input type="number" class="form-control" name="cantidad[]" id="cantidad' + FieldCount2 + '" min="1" >\
                              <label id="label_cantidad' + FieldCount2 + '" for="cantidad">Cantidad</label>\
                          </div>\
                      </div>\
                  </div>\
              <div class="input-group-btn">\
                  <button type="button" class="btn btn-floating-action btn-danger"  id="eliminarContenedor2"><i class="fa fa-trash"></i></button>\
              </div>\
          </div>\
      </div>\
  </div>\
</div>');


        $(".select2-list").select2({
          allowClear: true,
          language: "es"
        });

        x++; //text box increment
      }
      $('#contador2').val(FieldCount2).trigger('change');
      $('#numerador2').val(numerador2).trigger('change');
      return false;
    });

    $("body").on("click", "#eliminarContenedor2", function(e) { //user click on remove text
      if (x > 1) {
        var e = $(this).parent('div').parent('div').parent('div').parent('div').parent('div');
        e.remove();
        x--; //decrement textbox
        numerador2--;
        $('#numerador2').val(numerador2).trigger('change');
      }
      return false;
    });


  });
</script>

<style>
  hr {
    margin-top: 0px;
  }
</style>
<script src="<?= base_url(); ?>assets/libs/leaflet/leaflet.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- BEGIN CONTENT-->
<div id="content">
  <section>
    <div class="section-header">
      <ol class="breadcrumb">
        <li><a href="#">Tarea</a></li>
        <li class="active">Tareas</li>
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
        <div class="col-lg-12">
          <h3 class="text-primary">Listado de Tareas
            <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nueva Tarea</button>
          </h3>
          <hr>
        </div>
      </div>
      <input type="hidden" class="form-control" name="contador" id="contador" value="0">
      <input type="hidden" class="form-control" name="contador2" id="contador2" value="0">
      <div class="row" style="display: none;" id="form_registro">
        <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
          <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <form class="form form-validate" novalidate="novalidate" name="form_tarea" id="form_tarea" method="post">
                <input type="hidden" name="id_cliente" id="id_cliente" value="0">
                <div class="card">
                  <div class="card-head style-primary">
                    <div class="tools">
                      <div class="btn-group">
                        <a class="btn btn-icon-toggle" id="btn_update" onclick="update_formulario()"><i class="md md-refresh"></i></a>
                        <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                      </div>
                    </div>
                    <header id="titulo"></header>
                  </div>

                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group floating-label" id="c_descripcion_tarea">
                          <textarea class="form-control" name="descripcion_tarea" id="descripcion_tarea" rows="3" style="resize: none;"></textarea>
                          <label for="descripcion_tarea">Descripcion Tarea</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 col-sm-6">
                        <div class="form-group form-floating" id="c_fecha_inicio_tarea">
                          <div class="input-group date" id="picker-fecha-inicio">
                            <div class="input-group-content">
                              <input type="text" class="form-control" name="fecha_inicio_tarea" id="fecha_inicio_tarea" readonly="" required>
                              <label for="fecha_inicio_tarea">Fecha Inicio Tarea</label>
                            </div>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-6 col-sm-6">
                        <div class="form-group form-floating" id="c_fecha_fin_tarea">
                          <div class="input-group date" id="picker-fecha-fin">
                            <div class="input-group-content">
                              <input type="text" class="form-control" name="fecha_fin_tarea" id="fecha_fin_tarea" readonly="" required>
                              <label for="fecha_fin_tarea">Fecha Fin Tarea</label>
                            </div>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 col-sm-12">
                        <div class="form-group floating-label" id="c_cliente">
                          <select class="form-control select2-list" id="cliente" name="cliente" required>
                            <option value=""></option>
                            <?php foreach ($clientes as $cli) {  ?>
                              <option value="<?php echo $cli->id_cliente ?>"> <?php echo $cli->nombre . ' ' . $cli->apellido . ' - ' . $cli->ci ?></option>
                            <?php  } ?>
                          </select>
                          <label for="categoria">Seleccione Cliente</label>
                        </div>
                      </div>
                    </div>
                    <form name="form_personals" id="form_personals">
                      <div id="personals">
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <h3 class="text-on-pannel text-light">Personal</h3>
                            <div id="contenedor1">
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                  <div class="form-group">
                                    <div class="input-group input-group-lg">
                                      <div class="input-group-content">
                                        <div class="col-10">
                                          <div class="form-group form-floating" id="c_personal0">
                                            <select class="form-control select2-list" name="personal[]" id="personal0">
                                              <option value=""></option>
                                              <?php foreach ($empleado as $emp) {  ?>
                                                <option value="<?php echo $emp->id_empleado ?>"> <?php echo $emp->nombre . ' ' . $emp->paterno . ' ' . $emp->materno . ' - ' . $emp->ci ?></option>
                                              <?php  } ?>
                                            </select>
                                            <label for="personal">Seleccione
                                              Personal</label>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="input-group-btn">
                                        <button type="button" class="btn btn-floating-action btn-success" id="agregarCampo1"><i class="fa fa-plus"></i></button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </form>

                    <form name="form_productos" id="form_productos">
                      <div id="productos">
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <h3 class="text-on-pannel text-light">Materiales</h3>
                            <div id="contenedor2">
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                  <div class="form-group">
                                    <div class="input-group input-group-lg">
                                      <div class="input-group-content">
                                        <div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">
                                          <div class="form-group form-floating" id="c_producto0">
                                            <select class="form-control select2-list" name="producto[]" id="producto0" onchange="actualizar(this,'label_cantidad')">
                                              <option value=" "></option>
                                              <?php foreach ($productos as $pro) {  ?>
                                                <option value="<?php echo $pro->oidproducto ?>">
                                                  <?php echo $pro->oproducto ?>
                                                </option>
                                              <?php  } ?>
                                            </select>
                                            <label for="producto">Seleccione Material</label>
                                          </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">
                                          <div class="form-group floating-label" id="c_cantidad0">
                                            <input type="number" class="form-control" name="cantidad[]" id="cantidad0" min="1">
                                            <label id="label_cantidad0" for="cantidad">Cantidad</label>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="input-group-btn">
                                        <button type="button" class="btn btn-floating-action btn-success" id="agregarCampo2"><i class="fa fa-plus"></i></button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>

                    <div class="row">
                      <div class="col-12 col-sm-12">
                        <div class="form-group floating-label" id="c_estado">
                          <select class="form-control select2-list" id="estado" name="estado" required>
                            <option value="PROCESO">PROCESO</option>
                            <option value="CONCLUIDO">CONCLUIDO</option>
                            <option value="PENDIENTE" selected>PENDIENTE</option>
                            <option value="PAUSA">PAUSA</option>
                          </select>
                          <label for="categoria">Seleccione Estado</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-actionbar">
                  <div class="card-actionbar-row">
                    <input type="hidden" name="btnid" id="btnid" value="0" />
                    <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="agregar_promo(1)" name="btn" id="btn_edit" value="edit" disabled>Modificar Tarea</button>
                    <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="agregar_promo(0)" name="btn" id="btn_add" value="add">Registrar Tarea</button>
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
        <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
        <div class="card card-bordered style-primary">
          <div class="card-body style-default-bright">
            <div class="table-responsive">
              <table id="datatable_tarea" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Nro</th>
                    <th>Descripcion Tarea</th>
                    <th>Fecha Inicio Tarea</th>
                    <th>Fecha Fin Tarea</th>
                    <th>Cliente</th>
                    <th>Empleados</th>
                    <th>Acci&oacute;n</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <?php $nro = 1 ?>

                <?php foreach ($tareas as $tarea) : ?>

                  <tbody>
                    <tr>
                      <td><?= $nro ?></td>
                      <td><?= $tarea->odescripcion ?></td>
                      <td><?= $tarea->ofecini ?></td>
                      <td><?= $tarea->ofecfin ?></td>
                      <td><?= $tarea->ocliente ?></td>
                      <td><?php
                          $separador = ',';
                          $tarea_usuario = $tarea->ousuarios;
                          $arrady_tarea = explode($separador, $tarea_usuario);
                          foreach ($arrady_tarea as $empleado_tarea) :
                            echo "$empleado_tarea<br>";
                          endforeach;
                          ?>
                      </td>
                      <td>
                        <button type="button" title="Editar" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_tarea(<?= $tarea->oidactividad ?>)"><i class="fa fa-pencil-square-o fa-lg"></i></button>

                        <button type="button" title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_tarea(<?= $tarea->oidactividad ?>)"><i class="fa fa-trash-o fa-lg"></i></button>
                      </td>
                      <?php
                      switch ($tarea->oestado) {
                        case "PROCESO":
                          echo "<td style='background-color:#fdfd93;text-shadow: 1px 1px 1px #6e6868; color:#ef5350;'>$tarea->oestado</td>";
                          break;
                        case "CONCLUIDO":
                          echo "<td style='background-color:#7cdb7c;text-shadow: 1px 1px 1px #6e6868; color:#fff'>$tarea->oestado</td>";
                          break;
                        case "PENDIENTE":
                          echo "<td style='background-color:#ef5350;text-shadow: 1px 1px 1px #6e6868; color:#fff'>$tarea->oestado</td>";
                          break;
                        case "PAUSA":
                          echo "<td style='background-color:#5959b7;text-shadow: 1px 1px 1px #6e6868; color:#fff'>$tarea->oestado</td>";
                          break;
                        default:
                          echo "";
                      }
                      ?>
                    </tr>
                  </tbody>
                  <?php $nro++; ?>
                <?php endforeach; ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</section>
</div>

</div>
<!-- END CONTENT -->
<script>
  function vaciar() {

    $('#eliminarContenedor1').trigger('click');

  }

  function editar_tarea(id_tarea) {
    vaciar();
    $("#titulo").text("Modificar Tarea");
    document.getElementById("form_registro").style.display = "block";
    $('#form_tarea')[0].reset();
    document.getElementById("btn_update").style.display = "none";
    $('#btn_edit').attr("disabled", false);
    $('#btn_add').attr("disabled", true);

    $("#c_descripcion_tarea").removeClass("floating-label");
    $("#c_cliente").removeClass("floating-label");
    $("#c_estado").removeClass("floating-label");
    $("#c_personal0").removeClass("form-floating");
    $("#c_fecha_inicio_tarea").removeClass("form-floating");
    $("#c_fecha_fin_tarea").removeClass("form-floating");
    $("#c_producto0").removeClass("form-floating");
    $("#c_cantidad0").removeClass("form-floating");
    $.ajax({
      url: "<?php echo site_url('actividades/C_tarea/datos_tarea') ?>/" + id_tarea,
      type: "POST",
      dataType: "JSON",
      success: function(data) {

        $('#btnid').val(data[0].oidactividad);
        $('#descripcion_tarea').val(data[0].odescripcion);
        $('#fecha_inicio_tarea').val(data[0].ofecini);
        $('#fecha_fin_tarea').val(data[0].ofecfin);
        $('#estado').val(data[0].oestado).trigger('change');
        $('#cliente').val(data[0].oidcliente).trigger('change');

        var personal = new Array();
        var obj = data[0].oidusuarios.split(',');
        var c = document.getElementById("contador").value;
        var i = 0;

        while (c-- > 0) {
          $('#eliminarContenedor1').trigger('click');
        }

        i = 0;
        var y = document.getElementById("contador").value;

        if (obj.length == 1) {
          $('#personal' + 0).val(obj[0]).trigger('change');
        } else {
          while (i < obj.length - 1) {
            if (i > 0) {
              $('#agregarCampo1').trigger('click');
            }
            if (y >= 0) {
              $('#personal' + 0).val(obj[0]).trigger('change');
            }
            $('#personal' + y).val(obj[i]).trigger('change');
            i++;
            y++;
          }
          if (i > 0) {
            $('#agregarCampo1').trigger('click');
          }
          $('#personal' + y).val(obj[i]).trigger('change');
        }

        // materiales
        var productos = new Array();
        var obj = data[0].idsmateriales.split(',');
        var c = document.getElementById("contador2").value;
        var i = 0;

        while (c-- > 0) {
          $('#eliminarContenedor2').trigger('click');
        }

        i = 0;
        var y = document.getElementById("contador2").value;

        if (obj.length == 1) {
          $('#producto' + 0).val(obj[0]).trigger('change');
        } else {
          while (i < obj.length - 1) {
            if (i > 0) {
              $('#agregarCampo2').trigger('click');
            }
            if (y >= 0) {
              $('#producto' + 0).val(obj[0]).trigger('change');
            }
            $('#producto' + y).val(obj[i]).trigger('change');
            i++;
            y++;
          }
          if (i > 0) {
            $('#agregarCampo2').trigger('click');
          }
          $('#producto' + y).val(obj[i]).trigger('change');
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function eliminar_tarea(id_tarea) {
    var titulo = 'ELIMINAR TAREA';
    var mensaje = '<div> Esta seguro que desea Eliminar la tarea </div>';
    BootstrapDialog.show({
      title: titulo,
      message: $(mensaje),
      buttons: [{
        label: 'Aceptar',
        cssClass: 'btn-primary',
        action: function(dialog) {
          var $button = this;
          $button.disable();
          Swal.fire({
            icon: 'success',
            title: 'Se elimino con exito',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ACEPTAR',
          }).then((result) => {})
          window.location = '<?= base_url() ?>actividades/C_tarea/dlt_tarea/' +
            id_tarea;
        }
      }, {
        label: 'Cancelar',
        action: function(dialog) {
          dialog.close();
        }
      }]
    });
  }

  function agregar_promo(msg) {
    if (msg == 0) {
      msg = 'add';
    } else {
      msg = 'edit';
    }
    descripcion_tarea = document.getElementById("descripcion_tarea").value;
    fecha_inicio_tarea = document.getElementById("fecha_inicio_tarea").value.trim();
    fecha_fin_tarea = document.getElementById("fecha_fin_tarea").value;
    cliente = document.getElementById("cliente").value;
    estado = document.getElementById("estado").value;
    personal = document.getElementById("personal0").value;
    contador = document.getElementById("contador").value;
    btnid = document.getElementById("btnid").value;

    producto = document.getElementById("producto0").value;
    cant_producto = document.getElementById("cantidad0").value;
    contador2 = document.getElementById("contador2").value;

    var b = 0;
    if (personal != " ") {
      pers = Array();
      prod = Array();
      cant = Array();
      pers.push(personal);
      prod.push(producto);
      cant.push(cant_producto);
      for (var i = 1; i <= contador; i++) {
        personal = document.getElementById("personal" + i);
        console.log('this', personal);
        if (personal != null) {
          personal = personal.value;
          if (personal != " ") {
            pers.push(personal);
          } else {
            b = 1;
          }
        }
      }
      for (var i = 1; i <= contador2; i++) {
        producto = document.getElementById("producto" + i);
        cant_producto = document.getElementById("cantidad" + i);
        console.log('this', producto);
        if (producto != null) {
          producto = producto.value;
          cant_producto = cant_producto.value;
          if (producto != " ") {
            prod.push(producto);
            cant.push(cant_producto);
          } else {
            b = 1;
          }
        }
      }
      if (b == 0) {
        if (descripcion_tarea != "" && fecha_inicio_tarea != "" && fecha_fin_tarea != "" && cliente != "" && personal != "") {
          const dataToSend = {
            btn: msg,
            btnid: btnid,
            descripcion: descripcion_tarea,
            fecini: fecha_inicio_tarea,
            fecfin: fecha_fin_tarea,
            idcliente: cliente,
            estado: estado,
            'pers': JSON.stringify(pers),
            'prod': JSON.stringify(prod),
            'cant': JSON.stringify(cant)
          };
          $.ajax({
            url: "<?php echo site_url('actividades/C_tarea/add_update_tarea') ?>",
            type: "POST",
            datatype: "json",
            data: dataToSend,
            success: function(respuesta) {
              console.log(respuesta);
              var json = JSON.parse(respuesta);
              $.each(json, function(i, item) {
                if (item.oboolean == 'f') {
                  Swal.fire({
                    icon: 'error',
                    text: item.omensaje,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                  })
                } else {
                  Swal.fire({
                    icon: 'success',
                    title: 'Se registro con exito',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                  }).then((result) => {
                    if (result.isConfirmed) {
                      location.href =
                        "<?php echo base_url(); ?>tarea";
                    } else {}
                  })
                  location.href = "<?php echo base_url(); ?>tarea";
                }
              })
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error al obtener datos de ajax2');
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: "Por favor termine de llenar todos los campos",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ACEPTAR',
          })
        }
      } else {
        Swal.fire({
          icon: 'error',
          title: "Por favor termine de llenar todos los campos",
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'ACEPTAR',
        })
      }
    } else {
      Swal.fire({
        icon: 'error',
        title: "Por favor inserte al menos 1 producto",
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ACEPTAR',
      })
    }
  }

  $(document).ready(function() {
    // INICIO Oscar L. GAN-MS-B0-0283
    $('#datatable_tarea').DataTable({
      "language": {
        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
      },
    });
    // FIN GAN-MS-B0-0283
    $('#picker-fecha-inicio').datepicker({
      autoclose: true,
      todayHighlight: true,
      format: "mm/dd/yyyy",
      language: "es",
      minDate: 0
    });

    $('#picker-fecha-fin').datepicker({
      autoclose: true,
      todayHighlight: true,
      format: "mm/dd/yyyy",
      language: "es",
      minDate: 0
    });
  });

  function formulario() {
    $("#titulo").text("Registrar Tarea");
    document.getElementById("form_registro").style.display = "block";
    $('#form_tarea')[0].reset();
    $('#btn_edit').attr("disabled", true);
    $('#btn_add').attr("disabled", false);
    var c = document.getElementById("contador").value;
    while (c-- > 0) {
      $('#eliminarContenedor1').trigger('click');
    }
    $('#picker-fecha-inicio').datepicker('setDate', 'today');
    $('#picker-fecha-fin').datepicker('setDate', 'today');
  }

  function cerrar_formulario() {
    document.getElementById("form_registro").style.display = "none";
  }

  function update_formulario() {
    $('#form_tarea')[0].reset();
    $('#btn_edit').attr("disabled", true);
    $('#btn_add').attr("disabled", false);
  }

  function actualizar(opcion, producto) {
    $.ajax({
      url: "<?php echo site_url('actividades/C_tarea/calcular_stock') ?>",
      type: "POST",
      datatype: "json",
      data: {
        id_producto: opcion.value,
      },
      success: function(respuesta) {
        var json = JSON.parse(respuesta);
        document.getElementById(producto).innerText = "Cantidad maxima disponible: " + json;
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });

  }
</script>