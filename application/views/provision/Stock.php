<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: Milena Rojas Fecha:11/04/2022, Codigo: GAN-FR-A5-143,
Descripcion: Crear un nuevo submódulo en el Módulo de Provisión
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Kevin mauricio Larrazabal Calle     Fecha:1/09/2022, Codigo: GAN-MS-A1-429,
Descripcion: Correccion de bug en provicion stock en el modal para modificar cantidades
------------------------------------------------------------------------------------------------------------------------------
Modificado: Deivit Pucho Aguilar  Fecha:01/09/2022, Codigo: GAN-MS-A1-427
Descripcion: Se modifico function cambiar_consulta para que se pueda ordenar cantidad en orden ascendente y descendente
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Kevin mauricio Larrazabal Calle     Fecha:1/09/2022, Codigo: GAN-MS-A1-440,
Descripcion: realizar confirmacion de cambio en stock con la tecla enter
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana                Fecha:15/09/2022, Codigo: GAN-MS-A1-439,
Descripcion: Se modifico la funcion cambiar_consulta para  insertar el limit del modelo en el datatable
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert                Fecha:27/09/2022, Codigo: GAN-MS-M0-0008,
Descripcion: Se agrego que cuando la cantidad sea cero, la fila se pinte de rojo
*/

?>
<?php if (in_array("smod_stock", $permisos)) { ?>
  <script>
    $(document).ready(function() {
      activarMenu('menu9', 6);
    });
  </script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Center the loader */
    #loader {
      position: absolute;
      left: 50%;
      top: 50%;
      z-index: 1;
      width: 50px;
      height: 50px;
      margin: -76px 0 0 -76px;
      border: 8px solid #f3f3f3;
      border-radius: 50%;
      border-top: 8px solid #8bc34a;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
      0% {
        -webkit-transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
      }
    }

    /* GAN-MS-M0-0008 Gary Valverde 27-09-2022 */
    .red {
      background-color: #F57F7F !important;
    }
    /* fin GAN-MS-M0-0008 Gary Valverde 27-09-2022 */

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    /* Add animation to "page content" */
    .animate-bottom {
      position: relative;
      -webkit-animation-name: animatebottom;
      -webkit-animation-duration: 1s;
      animation-name: animatebottom;
      animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
      from {
        bottom: -100px;
        opacity: 0
      }

      to {
        bottom: 0px;
        opacity: 1
      }
    }

    @keyframes animatebottom {
      from {
        bottom: -100px;
        opacity: 0
      }

      to {
        bottom: 0;
        opacity: 1
      }
    }

    #myDiv {
      display: none;
      text-align: center;
    }
  </style>
  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Provision</a></li>
          <li class="active">Stock</li>
        </ol>
      </div>

      <?php if ($this->session->flashdata('success')) { ?>
        <script>
          $(document).ready(function() {
            Swal.fire({
              icon: 'success',
              text: "<?php echo $this->session->flashdata('success'); ?>",
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'ACEPTAR'
            })

          });
        </script>
      <?php } else if ($this->session->flashdata('error')) { ?>
        <script>
          $(document).ready(function() {
            Swal.fire({
              icon: 'error',
              text: "<?php echo $this->session->flashdata('error'); ?>",
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'ERROR'
            })

          });
        </script>
      <?php } ?>

      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="text-primary">Stock</h3>
          </div>
        </div>
      </div>

      <hr>
      <div id="loader" style="display:none"></div>
      <div class="row">
        <div class="col-md-12">
          <div class="text-divider visible-xs"><span>Listado del Stock</span></div>
          <div class="card card-bordered style-primary">
            <div class="card-body style-default-bright">
              <br>
              <div class="row">
                <center>
                  <div class="form col-md-4">
                    <div class="form-group">
                      <select class="form-control select2-list" id="ubi_trabajo" name="ubi_trabajo" required>
                        <option value="0">TODOS</option>
                        <?php foreach ($ubicaciones as $ubi) {  ?>
                          <option value="<?php echo $ubi->id_ubicacion ?>" <?php echo set_select('ubi_trabajo', $ubi->id_ubicacion) ?>> <?php echo $ubi->descripcion ?></option>
                        <?php } ?>
                      </select>
                      <label for="ubi_trabajo" style="padding-right: 3%;">Seleccione Ubicación</label>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="input-group-btn">
                      <button class="btn btn-floating-action btn-primary" type="button" onclick="cambiar_consulta()"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </center>
              </div>
              <br>
              <div id="tabla">
                <div class="table-responsive">
                  <!--  GAN-MS-M0-0008 GaryValverde 27-09-2022-->
                  <table id="datatable_stock" class="table table-bordered table-hover">
                    <!-- FIN GAN-MS-M0-0008 GaryValverde 27-09-2022 -->
                    <thead>
                      <tr>
                        <th>Nª</th>
                        <th>C&oacute;digo</th>
                        <th>C&oacute;digo Alt.</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Ubicaci&oacute;n</th>
                        <th>Cantidad</th>
                      </tr>
                    </thead>
                  </table>
                </div>
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
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Cambiar Cantidad? </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <div class="modal-body">
          <h5 id="textopre"></h5>
          <p id="number" style="display:none;"></p>
          <p id="identificador" style="display:none;"></p>
          <p id="idubicacion" style="display:none;"></p>
          <div id="cambioCantidad" class="form-group" style="display:none;">
            <!-- GAN-MS-A1-440   Fecha:8/09/2022 KLarrazabal -->

            <textarea id="descripcion" class="form-control" onkeydown="if (event.keyCode == 13)document.getElementById('btnGuardar').click()" rows="3" required></textarea>

            <!-- GAN-MS-A1-440  Fecha:8/09/2022 KLarrazabal -->
            <p style="font-size:0.8em; color:red;" id="descripciondown"></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSicambiar" class="btn btn-primary" onclick="var prod = $('#identificador').text();  SiCambio(prod)">Si cambiar</button>
          <button type="button" id="btnGuardar" class="btn btn-primary" onclick="var prod = $('#identificador').text(); var idubi = $('#idubicacion').text(); var description = $('#descripcion').val();  GuardarCambio(prod, idubi, description)" style="display: none;">Guardar</button>
          <button type="button" id="btnNocambiar" class="btn btn-secondary" onclick="var dato = $('#identificador').text(); var idubi = $('#idubicacion').text(); Nocambio(dato, idubi)">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">
    var nuevovalor;
    var antiguovalor;

    function cambiar_consulta() {

      var cod_ubicacion = document.getElementById("ubi_trabajo");
      cod_ubicacion = cod_ubicacion.options[cod_ubicacion.selectedIndex].value;

      document.getElementById("tabla").innerHTML = '';
      document.getElementById("tabla").innerHTML = '<div class="table-responsive">' +
        /* GAN-MS-M0-0008 GaryValverde 27-09-2022 */
        '<table id="datatable_stock" class="table table-bordered table-hover">' +
        /* FIN GAN-MS-M0-0008 GaryValverde 27-09-2022 */
        '<thead>' +
        '<tr>' +
        '<th>Nª</th>' +
        '<th>C&oacute;digo</th>' +
        '<th>C&oacute;digo Alt.</th>' +
        '<th>Producto</th>' +
        '<th>Precio</th>' +
        '<th>Ubicaci&oacute;n</th>' +
        '<th>Cantidad</th>'
      '</tr>' +
      '</thead>' +
      '</table>' +
      ' </div>';


      $('#datatable_stock').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive': true,
        "language": {
          "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
        },
        'serverMethod': 'post',
        'ajax': {
          'url': '<?= base_url() ?>provision/C_stock/get_lst_stock/' + cod_ubicacion,
        },
        'columns': [{
            data: 'pnro'
          },
          {
            data: 'pcodigo'
          },
          {
            data: "pcodigo_alt",
            render: function(data, type, row) {

              if (data == null || data == '') {
                return '<p>SIN ASIGNAR</p>';
              } else {
                return data;
              }

            }
          },
          {
            data: "pproducto",
            render: function(data, type, row) {
              return '<p id="' + row['pid_producto'] + row['pid_ubicacion'] + '">' + data + '</p>';
            }
          },
          {
            data: 'pprecio'
          },
          {
            data: 'pubicacion'
          },
          {
            data: "pcantidad",
            render: function(data, type, row) {
              return '<input style="width:70px;" min="0" type="number" name="cantidad" id="cantidad' + row['pid_producto'] + row['pid_ubicacion'] + '" step="1" onchange="CambioPrecio(' + data + ',\'' + row['pid_producto'] + '\',' + row['pid_ubicacion'] + ' )" value= ' + data + ' > <p style="font-size:0em; color:red;" id="odlvalue' + row['pid_producto'] + row['pid_ubicacion'] + '">' + data + '</p>';
            }
          },
        ],
        //GAN-MS-M0-0008 GaryValverde 27-09-2022
        "rowCallback": function(row, data, index) {
          if (data["pcantidad"] == 0) {
            $(row).addClass('red');
          }
        }
        //fin GAN-MS-M0-0008 GaryValverde 27-09-2022
      });
    }

    $("#cantidad").keyup(function(event) {
      if (event.keyCode === 13) {
        $("#cambioCantidad").click();

      }

    });

    function CambioPrecio(cantidad, id, id_ubi) {

      var idproducto = id.toString() + id_ubi.toString();
      nuevovalor = $('#cantidad' + idproducto).val();

      if (nuevovalor !== "" && nuevovalor >= 0) {
        antiguovalor = cantidad;
        var producto = $('#' + idproducto).text();
        var textoprod = "<span style='color:#ff0000'>" + producto + "</span>";
        $('#textopre').text("Se ajustará el stock del producto " + producto + " a " + nuevovalor + ", ¿Está de acuerdo?");
        $('#number').text(cantidad);
        $('#identificador').text(id);
        $('#idubicacion').text(id_ubi);
        $('#btnSicambiar').css('display', '');
        $('#btnNocambiar').text("No Cambiar");
        //$('#exampleModal').modal('toggle')
        $('#exampleModal').modal({
          backdrop: 'static',
          keyboard: false
        })

      } else {
        $('#odlvalue' + idproducto).html('Ingrese un número mayor 0');
      }

    }
    // GAN-MS-A1-429   Fecha:1/09/2022 KLarrazabal
    function SiCambio(id_prod) {
      var newprecio = nuevovalor;
      $('#textopre').text("¿Por qué se va cambiar la cantidad del producto?");
      document.getElementById("cambioCantidad").style.display = "block";
      $('#descripcion').focus();
      document.getElementById("btnSicambiar").style.display = "none";
      document.getElementById("btnGuardar").style.display = "inline-block";
      document.getElementById("descripcion").style.display = "inline-block";
      document.getElementById('descripcion').value = '';
      $('#descripcion').focus();

    }

    function Nocambio(num, idubi) {
      $('#cantidad' + num.toString() + idubi.toString()).val(antiguovalor);
      $('#exampleModal').modal('hide');
      document.getElementById("cambioCantidad").style.display = "none";
      document.getElementById("btnSicambiar").style.display = "inline-block";
      document.getElementById("btnGuardar").style.display = "none";
      document.getElementById('descripcion').value = '';
      $('#descripcion').focus();

    }

    function GuardarCambio(id_prod, id_ubi, descripcion) {
      descripcion2 = document.getElementById("descripcion").value;
      if (!descripcion2 || /^\s*$/.test(descripcion2)) {
        $('#descripciondown').html('Ingrese descripción por favor');
        $('#descripcion').focus();

      } else {
        var newprecio = nuevovalor;
        descripcion = descripcion.replace(/\s*$/, " ");
        // window.location =  "<?php echo site_url('provision/C_stock/change_cantidad') ?>/" + id_prod+'/'+newprecio+'/'+id_ubi+'/'+descripcion;
        $('#exampleModal').modal('hide');
        $.ajax({
          url: '<?php echo site_url('provision/C_stock/change_cantidad_1') ?>',
          type: "post",
          datatype: "json",
          data: {
            valor_1: id_prod,
            valor_2: newprecio,
            valor_3: id_ubi,
            valor_4: descripcion
          },
          success: function(data) {
            var data = JSON.parse(data);

            if (data[0].oboolean == "t") {
              Swal.fire({
                icon: 'success',
                title: "Registro modificado exitosamente",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
              })
              document.getElementById('descripcion').value = '';

            }

          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
          }
        });
        document.getElementById("btnGuardar").style.display = "none";
        document.getElementById("descripcion").style.display = "none";

      }
      //FIN GAN-MS-A1-429   Fecha:1/09/2022 KLarrazabal

    }
  </script>

<?php } else {
  redirect('inicio');
} ?>