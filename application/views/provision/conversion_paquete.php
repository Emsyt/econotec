<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:17/08/2021, Codigo: GAN-FR-A4-018,
Descripcion: Se Realizo el frontend del maquetado del branch de design de las paginas 14 a 18
------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja  Fecha:21/04/2022, Codigo: GAN-MS-A3-182,
Descripcion: Se habilitaron los combos y la tabla para hacer la conversion de acuerdo a las 
funciones dadas
------------------------------------------------------------------------------------------
Modificado: wilson Huanca Callisaya  Fecha:23/02/2023, Codigo: GAN-MS-B3-0258,
Descripcion: se hizo el control de cantidad maxima del origen y destino
------------------------------------------------------------------------------------------
Modificado: wilson Huanca Callisaya  Fecha:24/02/2023, Codigo:GAN-MS-B3-0304,
Descripcion: se modifico el tamanio del  requared del input de cantidad con la ayuda de media query
 media query al 
 ------------------------------------------------------------------------------------------
Modificado: Flavio Abdon Condori Vela  Fecha:11/04/2023, Codigo:GAN-MS-M4-0390,
Descripcion: Se corregió que al cambiar la ubicacion de origen el select de los productos 
no se pueda manipular hasta que carguen todos los productos. 
tambien que el select de los productos cargue de acuerdo a la ubicacion de origen que se seleccione
y limpiar el texto de la cantidad anterior cuando se cambie de ubicacion. 
------------------------------------------------------------------------------------------
Modificado: Dotnara Isabel Condori Condori  Fecha:09/05/2023, Codigo:GAN-MS-B0-0458,
Descripcion: al cambiar una ubicacion se borre la cantidad del producto seleccionado anteriormente
 ------------------------------------------------------------------------------------------
*/
?>

<?php if (in_array("smod_conv_paq_unid", $permisos)) { ?>
  <script>
    $(document).ready(function () {
      activarMenu('menu9', 4);
    });
  </script>

  <style>
    hr {
      margin-top: 0px;
    }

    @media (min-width: 1200px) and (max-width: 1700px) {
      .has-error .help-block {
        font-size: 1rem;
      }
    }
  </style>
  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Provisi&oacute;n</a></li>
          <li class="active">Conversion de Paquetes a Unidades</li>
        </ol>
      </div>

      <?php if ($this->session->flashdata('success')) { ?>
        <script> window.onload = function mensaje() { swal(" ", "<?php echo $this->session->flashdata('success'); ?>", "success"); } </script>
      <?php } else if ($this->session->flashdata('error')) { ?>
          <script> window.onload = function mensaje() { swal(" ", "<?php echo $this->session->flashdata('error'); ?>", "error"); } </script>
      <?php } ?>

      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="text-primary">Listado de Conversion de Paquetes a Unidades
              <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span
                  class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nueva Conversion</button>
            </h3>
            <hr>
          </div>
        </div>

        <div class="row" style="display: none;" id="form_registro">
          <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
            <div class="text-divider visible-xs"><span>Formulario de Paquetes</span></div>
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_marca" id="form_marca" method="post"
                  action="">
                  <div class="card">
                    <div class="card-head style-primary">
                      <div class="tools">
                        <div class="btn-group">
                          <a id="btn_update" class="btn btn-icon-toggle" onclick="update_formulario()"><i
                              class="md md-refresh"></i></a>
                          <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                        </div>
                      </div>
                      <header id="titulo"></header>
                    </div>

                    <div class="card-body">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-3">
                          <div class="form-group floating-label">
                            <select class="form-control select2-list" id="ubiorigen" name="ubiorigen"
                              onchange="getproducto_ori();" required>
                              <option value=""></option>
                              <?php foreach ($lst_ubicaciones as $ubi) { ?>
                                <option value="<?php echo $ubi->oidubicacion ?>" <?php echo set_select('productoorigen', $ubi->oidubicacion) ?>> <?php echo $ubi->oubicacion ?></option>
                              <?php } ?>
                            </select>
                            <label for="productoorigen">Seleccione Ubicacion de Origen</label>
                          </div>
                        </div>
                        <div id="productos">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6" id="input_prod">
                          <div class="form-group floating-label">
                            <select class="form-control select2-list" id="prod_origen" name="prod_origen" required
                              disabled>
                              <option value=""></option>
                            </select>
                            <label for="serie_gar">Seleccione Producto de Origen</label>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-3">
                          <div class="form-group floating-label" id= "c_cantidadIngreso">
                            <input type="number" class="form-control" name="cantorigen" id="cantorigen" min="1"  required>
                            <label for="cantorigen" id = "label_cantidad0">Seleccione Cantidad de Origen</label>
                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-3">
                          <div class="form-group floating-label" id="c_cant_origen">
                            <select class="form-control select2-list" id="ubidestino" name="ubidestino"
                              onchange="getproducto_dest();" required>
                              <option value=""></option>
                              <?php foreach ($lst_ubicaciones as $ubi) { ?>
                                <option value="<?php echo $ubi->oidubicacion ?>" <?php echo set_select('productodestino', $ubi->oidubicacion) ?>> <?php echo $ubi->oubicacion ?></option>
                              <?php } ?>
                            </select>
                            <label for="productodestino">Seleccione Ubicacion de Destino</label>
                          </div>
                        </div>
                        <div id="productos_dest">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6" id="input_prod_dest">
                          <div class="form-group floating-label">
                            <select class="form-control select2-list" id="prod_destino" name="prod_destino" required
                              disabled>

                            </select>
                            <label for="serie_gar">Seleccione Producto de Destino</label>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-3">
                          <div class="form-group floating-label" id="c_cant_destino">
                            <input type="number" class="form-control" name="cantdestino" id="cantdestino" min="1" required>
                            <label for="ci" id = "label_cantidad1" >Seleccione Cantidad de Destino</label>
                          </div>
                        </div>

                      </div>

                      <td><output id="list"></output></td>
                    </div>
                    <div class="card-actionbar">
                      <div class="card-actionbar-row">
                        <button type="button" class="btn btn-flat btn-primary ink-reaction" data-toggle="modal"
                          data-target="#exampleModalCenter" id = "btn_guardarConver">Guardar Conversion</button>

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
            <div class="text-divider visible-xs"><span>Listado de Paquetes</span></div>
            <div class="card card-bordered style-primary">
              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table id="datatable1" class="table table-striped table-bordered">
                    <thead>
                      <tr>

                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Producto de Origen</th>
                        <th>Cantidad de Origen</th>
                        <th>Producto de Destino</th>
                        <th>Cantidad de Destino</th>
                        <th>Fecha</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($lst_conversiones as $conv) { ?>
                        <tr>

                          <td>
                            <?php echo $conv->oorigen ?>
                          </td>
                          <td>
                            <?php echo $conv->odestino ?>
                          </td>
                          <td>
                            <?php echo $conv->oprodorigen ?>
                          </td>
                          <td>
                            <?php echo $conv->ocantorigen ?>
                          </td>
                          <td>
                            <?php echo $conv->oproddest ?>
                          </td>
                          <td>
                            <?php echo $conv->ocantdest ?>
                          </td>
                          <td>
                            <?php echo $conv->ofecha ?>
                          </td>
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
  </div>
  <!-- END BASE -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">CONVERTIR?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <div class="modal-body">
          <center>
            <P>Estas Seguro de Convertir el Producto?</P>
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="registrar_conv()">Aceptar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    function formulario() {
      $("#titulo").text("Conversor de Unidades");
      $('#form_marca')[0].reset();
      document.getElementById("list").innerHTML = '';
      document.getElementById("form_registro").style.display = "block";
      document.getElementById("btn_update").style.display = "block";
      
      document.getElementById("cantorigen").disabled = "true";
      document.getElementById("cantdestino").disabled = "true";
    }

    function cerrar_formulario() {
      document.getElementById("form_registro").style.display = "none";
      $('#form_marca')[0].reset();
      document.getElementById("list").innerHTML = '';
    }

    

    function update_formulario() {
      $('#form_marca')[0].reset();
      document.getElementById("list").innerHTML = '';
      $('#btn_edit').attr("disabled", true);
      $('#btn_add').attr("disabled", false);
    }
    function getproducto_ori() {
      var ubi = document.getElementById("ubiorigen").value;
      // GAN-MS-M4-0390 INICIO FLAVIO. A
      // $('[name="productoorigen"]').val(null).trigger('change');
      $('#productoorigen').empty();
      // GAN-MS-M4-0390 Fin 
      if (ubi != '') {

        var ubi = document.getElementById("ubiorigen").value;

        $.ajax({
          url: '<?= site_url() ?>provision/C_conversion_paquete/get_ubiproducto',
          type: "post",
          datatype: "json",
          data: {
            ubicacion: ubi
          },
          success: function (data) {
            var data = JSON.parse(data);
            var prod = ' <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">\
                                              <div class="form-group floating-label">\
                                              <label id="lab2" style="display: none" for="producto">Seleccione Producto de Origen</label>\
                                                <select class="form-control select2-list" id="productoorigen" name="productoorigen" onchange="hide();" required="">\
                                                  <option value=""></option>';
            for (var i = 0; i < data.length; i++) {
              prod = prod + "<option value=" + data[i].oidproducto + " > " + data[i].oproducto + "</option>";
            }
            prod = prod + '</select>\
                                            <label id="lab" for="productoorigen">Seleccione Producto de Origen</label>\
                                          </div>\
                                        </div>\
                                      </div>';
            document.getElementById("productos").innerHTML = prod;

            $('#productoorigen').select2();
            document.getElementById("input_prod").style.display = "none";
            // GAN-MS-B0-0458 INICIO DConsori
            document.getElementById("label_cantidad0").innerText = "Seleccione Cantidad de Origen";
            document.getElementById("cantorigen").value = "none";
            document.getElementById("cantorigen").disabled = true;
            // GAN-MS-B0-0458 FIN DConsori

          },
          error: function (jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos');
          }
        });
      } else {
        $("#productoorigen").prop('disabled', true);
      }

    }
    function hide() {
      document.getElementById("lab").style.display = "none";
      document.getElementById("lab2").style.display = "block";

      let numeroSolo = sacarNumero("productoorigen");

      //label
      document.getElementById("label_cantidad0").innerText = "Can. Máx. Disp.: " + numeroSolo;
      document.getElementById("cantorigen").max = numeroSolo;
      //input
      // GAN-MS-M4-0390 INICIO Flavio A.
      document.getElementById("cantorigen").disabled = "";
      document.getElementById("cantorigen").value = "";
      // GAN-MS-M4-0390 FIN Flavio A.
      ButtonDisable(numeroSolo, "cantorigen");

    }

    function sacarNumero(id) {
      let selectElement = document.getElementById(id);
      let selectedOption = selectElement.options[selectElement.selectedIndex];
      let selectedText = selectedOption.text;
      let partes = selectedText.split('-');
      let numero = partes[partes.length - 1].trim();
      let numeroSoloFun = parseInt(numero.match(/\d+/)[0]);
      return numeroSoloFun;

    }


    function ButtonDisable(unidad, idInput) {
      let inputNumber = document.getElementById(idInput);
      let buttonConver = document.getElementById("btn_guardarConver");
      inputNumber.addEventListener("change", () => {

        inputNumber.value = parseInt(inputNumber.value);


        if (inputNumber.value <= unidad && inputNumber.value > 0) {
          buttonConver.disabled = false;
        } else {

          buttonConver.disabled = true;
        }
      });
    }

    function getproducto_dest() {
      var ubi = document.getElementById("ubidestino").value;
      // GAN-MS-M4-0390 INICIO FLAVIO A.
      // $('[name="productodestino"]').val(null).trigger('change');
      $('#productodestino').empty();
      // GAN-MS-M4-0390 FIN
      if (ubi != '') {


        var ubi = document.getElementById("ubidestino").value;

        $.ajax({
          url: '<?= site_url() ?>provision/C_conversion_paquete/get_ubiproducto',
          type: "post",
          datatype: "json",
          data: {
            ubicacion: ubi
          },
          success: function (data) {
            var data = JSON.parse(data);

            var prod = ' <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">\
                                              <div class="form-group floating-label">\
                                              <label id="lab4" style="display: none" for="producto">Seleccione Producto de Destino</label>\
                                                <select class="form-control select2-list" id="productodestino" name="productodestino" onchange="hide1();" required="">\
                                                  <option value=""></option>';
            for (var i = 0; i < data.length; i++) {
              prod = prod + "<option value=" + data[i].oidproducto + "> " + data[i].oproducto + "</option>";
            }
            prod = prod + '</select>\
                                            <label id="lab3" for="productodestino">Seleccione Producto de Destino</label>\
                                          </div>\
                                        </div>\
                                      </div>';
            document.getElementById("productos_dest").innerHTML = prod;
            $('#productodestino').select2();
            document.getElementById("input_prod_dest").style.display = "none";
            // GAN-MS-B0-0458 INICIO DConsori
            document.getElementById("label_cantidad0").innerText = "Seleccione Cantidad de Destino";
            document.getElementById("cantdestino").value = "none";
            document.getElementById("cantdestino").disabled = true;
            // GAN-MS-B0-0458 FIN DConsori
          },
          error: function (jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos');
          }
        });
      } else {
        $("#productodestino").prop('disabled', true);
      }


    }
    function hide1() {
      document.getElementById("lab3").style.display = "none";
      document.getElementById("lab4").style.display = "block";

      let numeroSoloDestino = sacarNumero("productodestino");
      //label
      document.getElementById("label_cantidad1").innerText = "Can. Máx. Disp.: " + numeroSoloDestino;
      document.getElementById("cantdestino").max = numeroSoloDestino;
      //input
      // GAN-MS-M4-0390 INICIO FLAVIO
      document.getElementById("cantdestino").disabled = "";
      document.getElementById("cantdestino").value = "";
      // GAN-MS-M4-0390 FIN 
      ButtonDisable(numeroSoloDestino, "cantdestino");
    }
    function registrar_conv() {
      var ubi_origen = document.getElementById("ubiorigen").value;
      var ubi_destino = document.getElementById("ubidestino").value;
      var producto_origen = document.getElementById("productoorigen").value;
      var producto_destino = document.getElementById("productodestino").value;
      var cant_origen = document.getElementById("cantorigen").value;
      var cant_destino = document.getElementById("cantdestino").value;


      $.ajax({
        url: "<?php echo site_url('provision/C_conversion_paquete/registrar_conversion') ?>",
        type: "POST",
        data: {
          ubi_origen: ubi_origen,
          ubi_destino: ubi_destino,
          producto_origen: producto_origen,
          producto_destino: producto_destino,
          cant_origen: cant_origen,
          cant_destino: cant_destino
        },

        success: function (data) {
          location.reload();
        }
      });

    }

  </script>
<?php } else {
  redirect('inicio');
} ?>