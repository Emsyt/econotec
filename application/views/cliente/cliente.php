<?php
/*
-----------------------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:11/08/2021, Codigo: GAN-013,
Descripcion: Se adiciono en el modulo de clientes en la tabla listado de clientes se aumento el campo de movil el cual sera el telefono de nuestro cliente,
 finalmente se agrego un icono de whatsapp el cual nos direccionara a hablar con el cliente respectivo
-------------------------------------------------------------------------------------------------
Modificado: Daniel Castillo Quispe                                           Fecha:05/03/2022
Descripcion: Se cambió la manera de registro/modificación de un cliente. Ahora se genera un código de cliente si el CI ingresado en vacío o 0.
             También se impide el registro de un usuario con el CI repetido.
             Además, filtró el reporte de clientes para que sólo se muestren los registros en estado ELABORADO y ELIMINADO
-------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
Descripcion: se modifico el datatable para insertar el limit del modelo
-----------------------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:20/04/2022, Codigo: GAN-MS-M6-173,
Descripcion: Se modifico el submit del formulario para que este muestre los mensajes de alerta
asi como tambien se corrigieron los swal por swal.fire para que los mismos muestren las alertas
que les corresponda.
-----------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Fecha:26/04/2022, Codigo: GAN-MS-A5-196,
Descripcion: Se agrego la opción de seleccionar una ubicación en el mapa al momento de registrar un cliente,se agregao un botón para poder visualizar 
la ubicación de cada cliente en el mapa y se creo un botón para poder compartirse la ubicación.
-----------------------------------------------------------------------------------------------
Modificado: Richard Hector Orihuela G. Fecha:23/06/2022, Codigo: GAN-MS-A3-284,
Descripcion: Se agrego un textarea para el area de dirección para registrar cliente.
-----------------------------------------------------------------------------------------------
Modificado: Alvaro Ruben Gonzales Vilte Fecha:09/12/2022, Codigo: GAN-MS-A1-0176,
Descripcion: Se agrego un textarea para la descripcion del cliente.
*/
?>
<?php if (in_array("mod_cli", $permisos)) { ?>
  <script>
    var conf_facturacion;
    var cod_excepcion;
    $(document).ready(function() {
      activarMenu('menu3');
      // Recupera el valor si la facturacion esta activa y la almacena en una variable
      conf_facturacion = JSON.parse('<?php echo json_encode($conf_facturacion) ?>');
      conf_facturacion = conf_facturacion[0].fn_confirmar_facturacion;
    });
  </script>

  <style>
    hr {
      margin-top: 0px;
    }

    #div_verificar_nit {
      padding-top: 16px;
      display: flex;
      justify-content: left;
      align-items: center;
    }
  </style>

  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-TiHcf7Cdybfe5Nb7H-pC75LStjn4plY"></script>
  <script src="<?= base_url(); ?>assets/libs/leaflet/leaflet.js"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Cliente</a></li>
          <li class="active">Clientes</li>
        </ol>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="text-primary">Listado de Clientes
              <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nuevo Cliente</button>
            </h3>
            <hr>
          </div>
        </div>

        <div class="row" style="display: none;" id="form_registro">
          <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
            <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_cliente" id="form_cliente" method="post">
                  <input type="hidden" name="id_cliente" id="id_cliente" value="0">
                  <div class="card">
                    <div class="card-head style-primary">
                      <div class="tools">
                        <div class="btn-group">
                          <a class="btn btn-icon-toggle" onclick="update_formulario()"><i class="md md-refresh"></i></a>
                          <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                        </div>
                      </div>
                      <header id="titulo"></header>
                    </div>

                    <!-- Datos de la ubicación actual -->
                    <input type="hidden" id="latitud" placeholder="Latitud" name="latitud" style="position:absolute;left:10px;bottom:100px;z-index:999;">
                    <input type="hidden" id="longitud" placeholder="Longitud" name="longitud" style="position:absolute;left:10px;bottom:120px;z-index:999;">
                    <input type="hidden" id="dir" placeholder="DIR" name="dir" style="position:absolute;left:10px;bottom:140px;z-index:999;">
                    <input type="hidden" id="direc_flag" name="direc_flag" style="position:absolute;left:10px;bottom:140px;z-index:999;">
                    <input type="hidden" id="latitud2" placeholder="Latitud" name="latitud2" style="position:absolute;left:10px;bottom:100px;z-index:999;">
                    <input type="hidden" id="longitud2" placeholder="Longitud" name="longitud2" style="position:absolute;left:10px;bottom:120px;z-index:999;">
                    <input type="hidden" id="dir2" placeholder="DIR" name="dir2" style="position:absolute;left:10px;bottom:140px;z-index:999;">


                    <!-- Datos de la ubicacion modificada -->
                    <input type="hidden" id="Latitude" name="Latitude" placeholder="Latitude">
                    <input type="hidden" id="Longitude" name="Longitude" placeholder="Longitude">

                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <div class="form-group floating-label" id="c_doc_identidad">
                              <select class="form-control select2-list" id="doc_identidad" name="doc_identidad" required>
                                <?php foreach ($lst_documentos as $lts) {  ?>
                                  <option value="<?php echo $lts->id_catalogo ?>"> <?php echo $lts->descripcion ?></option>
                                <?php  } ?>
                              </select>
                              <label for="docs_identidad">Tipo documento</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4" id="id_doc">
                          <div class="form-group">
                            <div class="form-group floating-label" id="c_documento">
                              <input type="text" class="form-control" name="documento" id="documento">
                              <label for="documento">Documento</label>
                              <input type="hidden" class="form-control" name="codigoExcepcion" id="codigoExcepcion" value="0">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4" id="div_complemento">
                          <div class="form-group">
                            <div class="form-group floating-label" id="c_complemento">
                              <input type="text" class="form-control" name="complemento" id="complemento">
                              <label for="complemento">Complemento</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2" id="div_verificar_nit" style="display:none">
                          <div class="form-group">
                            <button type="button" class="btn btn-primary ink-reaction btn-sm" onclick="comprobar_documento()">Verificar Nit</button>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_nombres">
                            <input type="text" class="form-control" name="nombres" id="nombres" onchange="return mayuscula(this);" required>
                            <label for="nombres">Nombres</label>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_apellidos">
                            <input type="text" class="form-control" name="apellidos" id="apellidos" onchange="return mayuscula(this);">
                            <label for="apellidos">Apellidos</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_correo">
                            <input type="text" class="form-control" name="correo" id="correo">
                            <label for="correo">Correo</label>
                          </div>
                        </div>
                        <div class="col-sm-6" id="div_movil">
                          <div class="form-group floating-label" id="c_movil">
                            <input type="number" onKeyPress="if(this.value.length==8) return false;" class="form-control" name="movil" id="movil">
                            <label for="movil">Movil</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_descripcion">
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                            <label for="descripcion">Descripción</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_direccion">
                            <textarea class="form-control" name="direccion" id="direccion" rows="3"></textarea>
                            <label for="direccion">Dirección</label>
                          </div>
                        </div>

                      </div>
                      <div class="col-md-12">
                        <!-- mapa -->
                        <div class="panel-body">
                          <div id="mapa1">

                          </div>

                        </div>

                      </div>
                    </div>

                    <div class="card-actionbar">
                      <div class="card-actionbar-row">
                        <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="gestionar_cliente('MODIFICADO');" name="btn" id="btn_edit" value="edit" disabled>Modificar Cliente</button>
                        <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="gestionar_cliente('REGISTRADO');" name="btn" id="btn_add" value="add">Registrar Cliente</button>
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
                  <table id="datatable_cli" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Nro</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>CI/NIT/Cod. Cliente</th>
                        <th>Tipo documento</th>
                        <th>Estado</th>
                        <th>Tel&eacute;fono M&oacute;vil</th>
                        <th>Descripción</th>
                        <th>Correo</th>
                        <th>Direcci&oacute;n</th>
                        <th>Acci&oacute;n</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- Modal ver mapa -->
  <div class="modal fade" id="ver_mapa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <p class="h3" style="margin: 0px">UBICACIÓN</p>
        </div>
        <div class="modal-body">
          <!-- mapa -->

          <div class="panel-body">
            <div id="mapa">

            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="guardar_ubi_modal('MODIFICADO');">Guardar</button>
        </div>
        <input type="hidden" id="id_cliente_modal" name="id_cliente_modal" placeholder="id_cliente_modal">
        <input type="hidden" id="nombres_modal" name="nombres_modal" placeholder="nombres_modal">
        <input type="hidden" id="apellidos_modal" name="apellidos_modal" placeholder="apellidos_modal">
        <input type="hidden" id="ci_modal" name="ci_modal" placeholder="ci_modal">
        <input type="hidden" id="movil_modal" name="movil_modal" placeholder="movil_modal">
        <input type="hidden" id="direccion_modal" name="direccion_modal" placeholder="direccion_modal">
      </div>
    </div>
  </div>
  </div>
  <!-- END CONTENT -->

  <script>
    function locate() {
      navigator.geolocation.getCurrentPosition(initialize, fail);
    }

    function initialize(position) {
      document.getElementById('mapa1').innerHTML = "<div id='map' style='min-height:33rem;'></div>";
      var curLocation = 0;

      //direccion guardada
      const dir_start = document.getElementById("dir").value;
      console.log("dir start: " + dir_start);
      if (dir_start.length > 9) {
        console.log("ya hay dir");
        lat = document.getElementById("latitud").value;
        lon = document.getElementById("longitud").value;
        curLocation = [lat, lon];
      } else {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        curLocation = [lat, lon];

      }
      console.log("dir inicio: " + curLocation[0]);
      $("#latitud").val(curLocation[0]);
      $("#longitud").val(curLocation[1]);
      // use below if you have a model
      // var curLocation = [@Model.Location.Latitude, @Model.Location.Longitude];


      var map = L.map('map').setView(curLocation, 16);

      L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
      }).
      addTo(map);

      map.attributionControl.setPrefix(false);

      var marker = new L.marker(curLocation, {
        draggable: 'true'
      }).addTo(map).bindPopup("<b> Ubicaci&#243;n </b>").openPopup();;

      marker.on('dragend', function(event) {
        var position = marker.getLatLng();
        marker.setLatLng(position, {
          draggable: 'true'
        }).
        bindPopup(position).update();
        $("#latitud").val(position.lat);
        $("#longitud").val(position.lng);
        console.log("dir inicio: " + position.lat);
        console.log("dir inicio: " + position.lng);

      });

      $("#latitud, #longitud").change(function() {
        var position = [parseInt($("#latitud").val()), parseInt($("#longitud").val())];
        marker.setLatLng(position, {
          draggable: 'true'
        }).
        bindPopup(position).update();
        map.panTo(position);
      });

      map.addLayer(marker);
    }

    function locate2() {
      navigator.geolocation.getCurrentPosition(initialize2, fail);
    }

    function initialize2(position) {
      document.getElementById('mapa').innerHTML = "<div id='map2' style='min-height:40rem;'></div>";
      var curLocation = 0;

      //direccion guardada
      const dir_start = document.getElementById("dir2").value;
      console.log("dir start: " + dir_start);
      if (dir_start.length > 9) {
        console.log("ya hay dir");
        lat = document.getElementById("latitud2").value;
        lon = document.getElementById("longitud2").value;
        curLocation = [lat, lon];
      } else {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        curLocation = [lat, lon];

      }
      console.log("dir inicio: " + curLocation[0]);
      $("#latitud2").val(curLocation[0]);
      $("#longitud2").val(curLocation[1]);
      // use below if you have a model
      // var curLocation = [@Model.Location.Latitude, @Model.Location.Longitude];


      var map = L.map('map2').setView(curLocation, 16);

      L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
      }).
      addTo(map);

      map.attributionControl.setPrefix(false);

      var marker = new L.marker(curLocation, {
        draggable: 'true'
      }).addTo(map).bindPopup("<b> Ubicaci&#243;n </b>").openPopup();;

      marker.on('dragend', function(event) {
        var position = marker.getLatLng();
        marker.setLatLng(position, {
          draggable: 'true'
        }).
        bindPopup(position).update();
        $("#latitud2").val(position.lat);
        $("#longitud2").val(position.lng);
        console.log("dir inicio: " + position.lat);
        console.log("dir inicio: " + position.lng);

      });

      $("#latitud2, #longitud2").change(function() {
        var position = [parseInt($("#latitud2").val()), parseInt($("#longitud2").val())];
        marker.setLatLng(position, {
          draggable: 'true'
        }).
        bindPopup(position).update();
        map.panTo(position);
      });

      map.addLayer(marker);
    }
    $(document).ready(function() {
      $('#datatable_cli').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive': true,
        "language": {
          "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
        },
        'serverMethod': 'post',
        'ajax': {
          'url': '<?= base_url() ?>cliente/C_cliente/lista_cliente'
        },

        'columns': [{
            data: 'nro'
          },
          {
            data: 'nombre_rsocial'
          },

          {
            data: 'apellidos_sigla'
          },
          {
            data: 'nit_ci'
          },
          {
            data: 'tipo_documento'
          },
          {
            data: 'apiestado'
          },
          {
            data: 'movil',
            render: function(data, type, row) {
              // console.log(row);
              if (row['movil'] != 0 && row['movil'] != null) {
                return '<div style="text-align: right;">' + row['movil'] + '&nbsp&nbsp<a title="Mandar mensaje" href="https://api.whatsapp.com/send?phone=' + row['movil'] + '"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/240px-WhatsApp.svg.png" width="35" height="35"></a></div>';
              } else {
                return '';
              }
            }
          },
          {
            data: 'descripcion'
          },
          {
            data: 'correo'
          },
          {
            data: 'direccion',
            render: function(data, type, row) {
              if (row['direccion'] != 0 && row['direccion'] != null) {
                return '<div style="text-align: right;">' + row['direccion'] + '&nbsp&nbsp<a class="btn ink-reaction btn-floating-action btn-xs btn-info" title="Compartir ubicacion" href="https://maps.google.com/?q=' + row['latitud'] + ',' + row['longitud'] + '"><i class="fa fa-map-marker" ></i></a></div> ';
              } else {
                return '';
              }
            }
          },

          {
            data: 'apiestado',
            render: function(data, type, row) {
              if (row['apiestado'] == "ELABORADO") {
                return '<div style="text-align: center;"><button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" title="Editar cliente" onclick="editar_cliente(' + row['id_personas'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Inactivar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_cliente(\'' + row['id_personas'] + '\',\'' + row['apiestado'] + '\');"><i class="fa fa-trash-o fa-lg"></i></button> <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-primary" data-toggle="modal" data-target="#ver_mapa" title="Editar ubicacion" onclick="ver_mapa(' + row['id_personas'] + ')"><i class="fa fa-map-marker"></i></button></div> ';
              } else {
                return '<div style="text-align: center;"><button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" title="Editar cliente" onclick="editar_cliente(' + row['id_personas'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Activar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="eliminar_cliente(\'' + row['id_personas'] + '\',\'' + row['apiestado'] + '\')"><i class="fa fa-trash-o fa-lg"></i></button> <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-primary" data-toggle="modal" data-target="#ver_mapa" title="Editar ubicacion" onclick="ver_mapa(' + row['id_personas'] + ')"><i class="fa fa-map-marker" ></i></button></div> ';
              }
            }
          }
        ],
        "dom": 'C<"clear">lfrtip',
        "colVis": {
          "buttonText": "Columnas"
        },
      });

    });


    // Registra y edita un cliente en la base de datos
    function gestionar_cliente(cad) {
      if ($('#form_cliente').valid()) {
        var formData = new FormData($('#form_cliente')[0]);
        formData.append('valid_docs', true);
        formData.append('valid_excep', false);
        $.ajax({
          type: "POST",
          url: "<?= base_url() ?>cliente/C_cliente/C_gestionar_cliente/" + cad,
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
                text: cad + ' EXITOSAMENTE',
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
                confirmButtonText: 'ACEPTAR'
              })
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
          }
        });
      }
    }

    // Valida y activa datos necesarios segun el tipo de documento
    $("#doc_identidad").change(function() {
      var tipo = $(this).val();
      var classes = 'col-md-3';

      if (tipo == 1334) {
        $('#div_complemento').show();
        $('#div_verificar_nit').hide();
      } else if (tipo == 1338) {
        $('#div_complemento').hide();
        if (conf_facturacion == 't') {
          $('#div_verificar_nit').show();
        } else {
          classes = 'col-md-5';
        }
      } else {
        $('#div_complemento').hide();
        $('#div_verificar_nit').hide();
        classes = 'col-md-5';
      }
      $('#div_movil').removeClass().addClass(classes);
      $('#complemento').val('').trigger('change');
      $('#documento').val('').trigger('change');
      $('#codigoExcepcion').val('0').trigger('change');
    });

    // En caso de que se coloquen los valores 99001,99002,99003 el input de documento adquirira alguno de los valores  
    let fromJS = false;
    const inputElement = document.querySelector("#documento");

    inputElement.addEventListener("input", function() {
      if (!fromJS) {
        let nombre = $('#nombres').val();
        switch (this.value) {
          case "99001":
            $('#nombres').val('CONTROL TRIBUTARIO').trigger('change');
            // Acción común
            $('#codigoExcepcion').val('1').trigger('change');
            break;
          case "99002":
            $('#nombres').val('VENTAS MENORES DEL DÍA').trigger('change');
            // Acción común
            $('#codigoExcepcion').val('1').trigger('change');
            break;
          case "99003":
            // Acción común
            if (nombre == 'CONTROL TRIBUTARIO' || nombre == 'VENTAS MENORES DEL DÍA') {
              $('#nombres').val('').trigger('change');
            }
            $('#codigoExcepcion').val('1').trigger('change');
            break;
          default:
            if (nombre == 'CONTROL TRIBUTARIO' || nombre == 'VENTAS MENORES DEL DÍA') {
              $('#nombres').val('').trigger('change');
            }
            $('#codigoExcepcion').val('0').trigger('change');
            break;
        }
      }
    });


    function comprobar_documento() {
      var documento = document.getElementById("documento").value;
      $.ajax({
        url: "<?= site_url() ?>cliente/C_cliente/verificar_nit",
        type: "POST",
        data: {
          documento: documento
        },
        success: function(resp) {
          var c = JSON.parse(resp);
          console.log(c)
          if (c.success == true) {
            response = JSON.parse(c.response);
            transaccion = response.RespuestaVerificarNit.transaccion;
            if (transaccion) {
              Swal.fire({
                icon: 'success',
                title: response.RespuestaVerificarNit.mensajesList.descripcion,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR'
              })
            }else{
              Swal.fire({
                  icon: 'warning',
                  title: response.RespuestaVerificarNit.mensajesList.descripcion,
                  text: 'Registrar como Nit invalido?',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'ACEPTAR',
                  showCancelButton: true,
                  cancelButtonText: 'CANCELAR',
                  cancelButtonColor: '#d33',
                }).then((result) => {
                    document.getElementById('complemento').value = '';
                  if (!result.isConfirmed) {
                    document.getElementById('documento').value = '';
                    $('#codigoExcepcion').val('0').trigger('change');
                  }else{
                    $('#codigoExcepcion').val('1').trigger('change');
                  }
                })
            }
            console.log(response.RespuestaVerificarNit.transaccion)
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: c.error,
              confirmButtonColor: '#d33',
              confirmButtonText: 'ACEPTAR'
            })
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }

    function ver_mapa(id_cli) {

      $.ajax({
        url: "<?php echo site_url('cliente/C_cliente/datos_cliente') ?>/" + id_cli,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          $('[name="id_cliente_modal"]').val(data.id_personas);
          $('[name="nombres_modal"]').val(data.nombre_rsocial);
          $('[name="apellidos_modal"]').val(data.apellidos_sigla);
          $('[name="ci_modal"]').val(data.nit_ci);
          $('[name="movil_modal"]').val(data.movil);
          $('[name="direccion_modal"]').val(data.direccion);
          $('#latitud2').val(data.latitud);
          $('#longitud2').val(data.longitud);
          $('[name="dir2"]').val(data.latitud + " , " + data.longitud);
          locate2();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }

    function guardar_ubi_modal(cad) {
      var nombre = document.getElementById("nombres_modal").value;
      var apellido = document.getElementById("apellidos_modal").value;
      var ci = document.getElementById("ci_modal").value;
      var movil = document.getElementById("movil_modal").value;
      var direccion = document.getElementById("direccion_modal").value;
      var id_cliente = document.getElementById("id_cliente_modal").value;
      var latitud = document.getElementById("latitud2").value;
      var longitud = document.getElementById("longitud2").value;
      var btn = cad;
      var array = [nombre, apellido, ci, movil, direccion, id_cliente, latitud, longitud, btn];
      $.ajax({
        url: "<?= site_url() ?>cliente/C_cliente/add_update_cliente",
        type: "POST",
        data: {
          array: array
        },
        success: function(resp) {
          var c = JSON.parse(resp);
          if (c[0].oboolean == 't') {
            Swal.fire({
              icon: 'success',
              text: cad + ' EXITOSAMENTE',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'ACEPTAR'
            })
            location.reload();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: c[0].omensaje,
              confirmButtonColor: '#d33',
              confirmButtonText: 'ACEPTAR'
            })
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }

    function formulario() {
      $("#titulo").text("Registrar Cliente");
      document.getElementById("form_registro").style.display = "block";
      locate();
    }

    function cerrar_formulario() {
      document.getElementById("form_registro").style.display = "none";
    }

    function update_formulario() {
      $('#form_cliente')[0].reset();
      $('#btn_edit').attr("disabled", true);
      $('#btn_add').attr("disabled", false);
    }

    function editar_cliente(id_cli) {
      $("#titulo").text("Modificar Cliente");
      document.getElementById("form_registro").style.display = "block";
      $('#form_cliente')[0].reset();

      $('#btn_edit').attr("disabled", false);
      $('#btn_add').attr("disabled", true);

      let elementos = ['c_nombres', 'c_apellidos', 'c_ci', 'c_movil', 'c_direccion', 'c_descripcion'];

      elementos.forEach(function(elemento) {
        $("#" + elemento).removeClass("floating-label");
      });

      $.ajax({
        url: "<?php echo site_url('cliente/C_cliente/datos_cliente') ?>/" + id_cli,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          console.log(data)
          if (!data || typeof data !== "object") {
            alert("No se recibieron datos válidos del servidor");
            return;
          }
          let documento = data.nit_ci;
          let complemento = '';
          if (data.id_documento == "1334") {
            if (documento) {
              let partes = documento.split("-");
              documento = partes[0];
              complemento = partes[1] || '';
            } else {
              documento = '';
            }
          }

          $('[name="id_cliente"]').val(data.id_personas);
          $('[name="doc_identidad"]').val(data.id_documento).trigger('change');
          $('[name="nombres"]').val(data.nombre_rsocial);
          $('[name="apellidos"]').val(data.apellidos_sigla);
          $('[name="documento"]').val(documento).trigger('change');
          $('[name="complemento"]').val(complemento).trigger('change');
          $('[name="correo"]').val(data.correo).trigger('change');
          $('[name="movil"]').val(data.movil);
          $('[name="direccion"]').val(data.direccion);
          $('[name="descripcion"]').val(data.descripcion);
          $('#latitud').val(data.latitud);
          $('#longitud').val(data.longitud);
          $('[name="dir"]').val(data.latitud + " , " + data.longitud);
          locate();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
      location.href = "#top";
    }

    function eliminar_cliente(id_cli, estado) {
      if (estado == 'ELABORADO') {
        var titulo = 'ELIMINAR REGISTRO';
        var mensaje = '<div>Esta seguro que desea Eliminar el registro</div>';
      } else {
        var titulo = 'HABILITAR REGISTRO';
        var mensaje = '<div>Esta seguro que desea Habilitar el registro</div>';
      }
      BootstrapDialog.show({
        title: titulo,
        message: $(mensaje),
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialog) {
            var $button = this;
            $button.disable();
            window.location = '<?= base_url() ?>cliente/C_cliente/dlt_cliente/' + id_cli + '/' + estado;
          }
        }, {
          label: 'Cancelar',
          action: function(dialog) {
            dialog.close();
          }
        }]
      });
    }

    function fail() {
      alert('navigator.geolocation falló, puede que no esté soportado');
    }
  </script>
<?php } else {
  redirect('inicio');
} ?>