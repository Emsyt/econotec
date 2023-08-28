<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Gabriela Mamani Choquehuanca Fecha:24/06/2022, Codigo: GAN-MS-A5-275,
Descripcion: Se creo la vista del ABM llamado Ubicaciones, el cual muestra el formulario de registro de ubicaciones 
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Gabriela Mamani Choquehuanca Fecha:27/06/2022, Codigo: GAN-MS-A4-290,
Descripcion: Se creo la vista del listado de Ubicaciones, el cual muestra la listado del registro de ubicaciones
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Gabriela Mamani Choquehuanca Fecha:27/06/2022, Codigo: GAN-MS-A4-291,
Descripcion: Se creo la vista para  eliminar y modificar los registros  del listado de Ubicaciones
---------------------------------------------------------------------------------------------------------------------------
Modificado: Jade Piza  fecha: 10/05/2023  Codigo: GAN-MS-B1-0457,
Descripcion: se realizó el funcionamiento del módulo ubicaciones donde las coordenadas ya se guardan
y se puede editar además que en la lista ya se muestra dirección y el punto de ubicacion
-------------------------------------------------------------------------------------------------------------------
 */
?>
<?php if (in_array("smod_ubi", $permisos)) { ?>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      $(document).ready(function(){
          activarMenu('menu8',4);
          listar_ubicaciones();
      });
    </script>
    <style>
      hr {
        margin-top: 0px;
      }
    </style>
    
    <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
          <ol class="breadcrumb">
          <li><a href="#">Administraci&oacute;n</a></li>
              <li class="active">Ubicaciones</li>
          </ol>
      </div>

      <?php if ($this->session->flashdata('success')) { ?>
        <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('success'); ?>","success"); } </script>
      <?php } else if($this->session->flashdata('error')){ ?>
        <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('error'); ?>","error"); } </script>
      <?php } ?>

      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="text-primary">Listado de Ubicaciones
            <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nueva Ubicacion</button>
            </h3>
            <hr>
          </div>
        </div>

        <div class="row" style="display: none;" id="form_registro">
          <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
            <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_proveedor" id="form_proveedor" method="post" action="<?= site_url() ?>administracion/C_ubicaciones/add_update_ubicacion">
                  <input type="hidden" name="id_proveedor" id="id_proveedor">
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
                        <div class="col-sm-12">
                          <div class="form-group floating-label" id="c_razon_social">
                            <select class="form-control select2-list" id="ubi_ini" name="ubi_ini"  required>
                              <option value=""></option>
                                <?php foreach ($lst_ubicacion as $ubi) {  ?>
                                 <option value="<?php echo $ubi->id_catalogo?>" <?php echo set_select('ubi_ini', $ubi->id_catalogo) ?>>
                                <?php echo strtoupper($ubi->descripcion ) ?></option>
                              <?php } ?>
                            </select>
                            <label for="producto">Seleccione Tipo Ubicacion</label>
                          </div>
                        </div>
                      </div>
                   
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_codigo">
                            <input type="text" class="form-control" name="codigo" id="codigo" required>
                            <input type="hidden" class="form-control" name="id_ubicacion" id="id_ubicacion">
                            <label for="sigla">Codigo</label>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_descripcion">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" required >
                            <label for="sigla">Descripcion</label>
                          </div>
                        </div>
                        
                        

                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_direccion">
                            <input type="text" class="form-control" name="direccion" id="direccion" >
                            <label for="sigla">Direccion</label>
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
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Ubicacion</button>
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add">Registrar Ubicacion</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="text-divider visible-xs"><span>Listado de Ubicaciones</span></div>
          <div class="card card-bordered style-primary">
            <div class="card-body style-default-bright">
              <div class="table-responsive">
                <table id="datatable_ubi" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nro</th>
                      <th>Codigo</th>
                      <th>Ubicacion</th>
                      <th>Descripcion </th>
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
    </section>
  </div>
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
          <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="guardar_ubi_modal('MODIFICADO');">Guardar Nueva Ubicación</button>
        </div>
        <input type="hidden" id="id_ubicaciones_modal" name="id_ubicaciones_modal" placeholder="id_ubicaciones_modal">
        <input type="hidden" id="codigo_modal" name="codigo_modal" placeholder="codigo_modal">
        <input type="hidden" id="id_catalogo_modal" name="id_catalogo_modal" placeholder="id_catalogo_modal">
        <input type="hidden" id="ubicacion_modal" name="ubicacion_modal" placeholder="ubicacion_modal">
        <input type="hidden" id="descripcion_modal" name="descripcion_modal" placeholder="descripcion_modal">
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
    
    function ver_mapa(id_ubi) {
      $.ajax({
        url : "<?php echo site_url('administracion/C_ubicaciones/datos_ubicacion')?>/" + id_ubi,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          console.log(data);
          $('[name="id_ubicaciones_modal"]').val(data[0].id_ubicacion);
          $('[name="codigo_modal"]').val(data[0].codigo);
          $('[name="id_catalogo_modal"]').val(data[0].id_catalogo);
          $('[name="descripcion_modal"]').val(data[0].descripcion);
          $('[name="direccion_modal"]').val(data[0].direccion);
          $('#latitud2').val(data[0].latitud);
          $('#longitud2').val(data[0].longitud);
          $('[name="dir2"]').val(data[0].latitud + " , " + data[0].longitud);
          locate2();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }
    function guardar_ubi_modal(btn) {
      console.log("entra en funcion");
      var codigo = document.getElementById("codigo_modal").value;
      var id_catalogo = document.getElementById("id_catalogo_modal").value;
      var descripcion = document.getElementById("descripcion_modal").value;
      var direccion = document.getElementById("direccion_modal").value;
      var id_ubicaciones = document.getElementById("id_ubicaciones_modal").value;
      var latitud = document.getElementById("latitud2").value;
      var longitud = document.getElementById("longitud2").value;
      var array = [id_ubicaciones, id_catalogo, codigo, descripcion, direccion, latitud, longitud, btn];
      console.log(array);
      $.ajax({
        url: "<?= site_url() ?>administracion/C_ubicaciones/add_update_ubi_modal",
        type: "POST",
        data: {
          array: array
        },
        success: function(resp) {
          var c = JSON.parse(resp);
          console.log(c);
          if (c[0].oboolean == 't') {
            Swal.fire({
              icon: 'success',
              text: btn +' EXITOSAMENTE',
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

  
    function formulario(){
      $("#titulo").text("Registrar Ubicacion");
      document.getElementById("form_registro").style.display = "block";
      locate();
    }

    function cerrar_formulario(){
      document.getElementById("form_registro").style.display = "none";
    }

    function update_formulario(){
      $('#form_proveedor')[0].reset();
      $('#btn_edit').attr("disabled", true);
      $('#btn_add').attr("disabled", false);
    }

    function listar_ubicaciones(){
      $.ajax({
              url:'<?=base_url()?>administracion/C_ubicaciones/lista_ubicacion1',
              type:"post",
              datatype:"json",
            
              success: function(data){
                  var data = JSON.parse(data);
                  
  
                      var t = $('#datatable_ubi').DataTable({
                          "data": data,
                          "responsive": true,
                          "language": {
                          "url": "<?= base_url()?>assets/plugins/datatables_es/es-ar.json"
                          },
                          "destroy": true,
                          "columnDefs": [ {
                              "searchable": false,
                              "orderable": false,
                              "targets": 0
                          } ],
                          "order": [[ 1, 'asc' ]],
                          "aoColumns": [
                              { "mData": "nro" },
                              { "mData": "codigo" },
                              { "mData": "catalogo" },
                              { "mData": "descripcion" },
                              { "mData": "direccion"},
                              { 
                              "mRender": function(data, type, row, meta) {                 
                                  var a = `                                                                          
                                      <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick=" editar_ubicaciones(${row.id_ubicacion})" title ="Modificar"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                      <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick=" eliminar_proveedor(${row.id_ubicacion})" title ="Eliminar" ><i class="fa fa-trash-o"></i></button>
                                      <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-primary" data-toggle="modal" data-target="#ver_mapa" title="Editar ubicacion" onclick="ver_mapa(${row.id_ubicacion})"><i class="fa fa-map-marker"></i></button></div>`;
                                  return a;
                              }
                              },
                              
                          ],
                          "dom": 'C<"clear">lfrtip',
                          "colVis": {
                              "buttonText": "Columnas"
                          }
                      });
                  
              },
              error: function(jqXHR, textStatus, errorThrown) {
              alert('Error al obtener datos de ajax');
              }
          });
    }

    function editar_ubicaciones(id_ubi){
      $("#titulo").text("Modificar Ubicacion");
      document.getElementById("form_registro").style.display = "block";
      $('#form_proveedor')[0].reset();

      $('#btn_edit').attr("disabled", false);
      $('#btn_add').attr("disabled", true);

      $("#c_razon_social").removeClass("floating-label");
      $("#c_codigo").removeClass("floating-label");
      $("#c_descripcion").removeClass("floating-label");
      $("#c_direccion").removeClass("floating-label");

      $.ajax({
          url : "<?php echo site_url('administracion/C_ubicaciones/datos_ubicacion')?>/" + id_ubi,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
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
            $('[name="id_ubicacion"]').val(id_ubi);

              $('[name="ubi_ini"]').val(data[0].id_catalogo).trigger('change');
              $('[name="codigo"]').val(data[0].codigo);
              $('[name="descripcion"]').val(data[0].descripcion);
              $('[name="direccion"]').val(data[0].direccion);
              $('[name="area"]').val(data[0].direccion);
              $('#latitud').val(data[0].latitud);
              $('#longitud').val(data[0].longitud);
              $('[name="dir"]').val(data[0].latitud + " , " + data[0].longitud);
              locate();

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error al obtener datos de ajax');
          }
      });
      location.href = "#top";
    }

    function eliminar_proveedor(id_ubi) {
      
        var titulo = 'ELIMINAR REGISTRO';
        var mensaje = '<div>Esta seguro que desea Eliminar el registro</div>';
      
      BootstrapDialog.show({
        title: titulo,
        message: $(mensaje),
        buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
              action: function (dialog) {
              
                dialog.close();
        
            $.ajax({
              url:'<?=base_url()?>administracion/C_ubicaciones/dlt_ubicaciones/'+id_ubi,
              type:"post",
              datatype:"json",
            
              success: function(data){
                  var data = JSON.parse(data);
              
                  if(data[0].oboolean=='t'){
                    Swal.fire({
                    icon: 'success',
                    text: "La ubicacion se ha eliminado correctamente",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR'
                  }).then((result) => {
                    
                      if (result.isConfirmed) {
                      location.reload();
                      } else{
                        location.reload();
                      }
                    })
                  
                  }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error',
                    
                    })
                  }
          
                  
              },
              error: function(jqXHR, textStatus, errorThrown) {
              alert('Error al obtener datos de ajax');
              }
          });

              }
            }, {
            label: 'Cancelar',
            action: function (dialog) {
                dialog.close();
            }
        }]
      });
    }

    function fail() {
      alert('navigator.geolocation falló, puede que no esté soportado');
    }

  </script>
<?php } else {redirect('inicio');}?>
