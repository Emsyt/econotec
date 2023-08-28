<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Dotnara Isabel condori Condori Fecha:12/05/2023, Codigo:GAN-MS-B1-0463
  Descripcion: se creo el controlador de Rutas que contiene un dropdown con 
  distribuidores y un mapa
------------------------------------------------------------------------------ 
  Modificado: Alison Paola Pari Pareja Fecha:18/05/2023, Codigo:GAN-MS-A1-0481
  Descripcion: Se implemento la funcionalidad de mostrar los marcadores de las ubicaciones
  de los clientes de acuerdo a la ubicacion seleccionada
------------------------------------------------------------------------------ 
  Modificado: Alison Paola Pari Pareja Fecha:04/06/2023, Codigo:GAN-MS-M0-0530
  Descripcion: Se anadio el boton de Cobrar cuando el marcador este en estado Entregado
------------------------------------------------------------------------------ 
*/
?>
<?php if (in_array("smod_rutas", $permisos)) { ?>
  <input type="hidden" name="contador" id="contador" value="<?php echo $contador ?>">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="<?= base_url(); ?>assets/libs/leaflet/leaflet.js"></script>
  <style>
    #etiquetas {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 1000;
    }
  </style>
  <script>
    var map;
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

      var cont_solicitud = $("#contador").val();
      activarMenu('menu18', 1);
      map = L.map('map').setView([-16.493696, -68.1388431], 15);
      L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
      }).
      addTo(map);
      verificarUsuario();
    });

    function verificarUsuario() {
      var cargoUser = document.getElementById('cargo_user').value;
      console.log("Cargo input : " + cargoUser);
      if (cargoUser == 'DISTRIBUIDOR') {
        <?php foreach ($distribuidores as $dis) {  ?>
          value = "<?php echo $dis->id_ubicacion ?>"
          console.log("id ubi: " + value);
          $('[name="distribuidores"]').val(value).trigger('change');
          $('[name="distribuidores"]').find('option[value="0"]').remove();

        <?php
        } ?>
      }
    }
  </script>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Distribuci&oacute;n</a></li>
          <li class="active">Rutas</li>
        </ol>
      </div>
      <?php
      if ($this->session->userdata('cargo') == 'ADMINISTRADOR' or $this->session->userdata('cargo') == 'DISTRIBUIDOR') {
      ?>
        <div class="section-body" id="container">
          <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
              <div class="form-group floating-label">
              </div>
              <form class="form form-validate" novalidate="novalidate" name="form_solicitud" id="form_solicitud" method="post" action="<?= site_url() ?>provision/C_almacen/add_solicitud">
                <div class="card justify-content-center">
                  <div class="card-head style-primary">
                    <header>Lista de Distribuidores</header>
                  </div>
                  <input type="hidden" id="cargo_user" name="cargo_user" value="<?php echo $this->session->userdata('cargo') ?>">
                  <div style="padding-left:5%" class="card-body justify-content-center" id="container2">
                    <div class="row justify-content-center">
                      <div class="form-group floating-label col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        <select class="form-control select2-list" id="distribuidores" name="distribuidores">
                          <option value="0"> TODOS</option>
                          <?php
                          foreach ($distribuidores as $dis) {  ?>
                            <option value="<?php echo $dis->id_ubicacion ?>" <?php echo set_select('ubi_ini', $dis->id_ubicacion) ?>>
                              <?php echo $dis->descripcion ?></option>
                          <?php } ?>
                        </select>
                        <label for="distribuidores">Seleccionar distribuidor</label>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                        <div class="input-group">
                          <button class="btn btn-floating-action btn-primary" type="button" onclick="cambiar_consulta()">
                            <i class="fa fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card card-bordered style-primary">
                  <div class="card-body style-default-bright">
                    <div id='map' style='min-height:42rem;'>
                    <div id='etiquetas' style="background-color: #ffffff; padding:5px;">
                        <label>
                          <i class="fa fa-circle" aria-hidden="true" style="color: red;"></i>
                          SOLICITADO
                        </label><br>
                        <label>
                          <i class="fa fa-circle" aria-hidden="true" style="color: orange;"></i>
                          ACEPTADO
                        </label><br>
                        <label>
                          <i class="fa fa-circle" aria-hidden="true" style="color: green;"></i>
                          ENTREGADO
                        </label><br>
                        <label>
                          <i class="fa fa-circle" aria-hidden="true" style="color: pink;"></i>
                          COBRADO
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      } else {
      ?>
        <div class="section-body" id="container">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
              <div class="alert alert-danger" role="alert">
                <h3>No tiene permisos para ver los distribuidores</h3>
                <p>
                  <a class='btn btn-flat btn-info' href='<?= base_url(); ?>inicio'>Ir al inicio</a>
                </p>
              </div>
            </div>
          </div>
        </div>

      <?php
      }
      ?>


  </div>
  <script>
    var cont=false;
    var markers=[];
    function cambiar_consulta() {
      var marker;
      
      if(cont){
        for (var i = 0; i < markers.length; i++) {
        map.removeLayer(markers[i]);
        }
      }
      markers = [];
      var selectDistribuidor = $('[name="distribuidores"]');
      var id_ubicacion = selectDistribuidor.val();
      var text_ubicacion = selectDistribuidor.find('option:selected').text().trim();

      //alert("Aqui se busca la ubicación: " + id_ubicacion + " - " + text_ubicacion);
    $.ajax({
        url: "<?= site_url() ?>distribucion/C_rutas/cargar_marcadores",
        type: "POST",
        data: {
          id_ubicacion: id_ubicacion
        },
        success: function(resp) {
          //console.log(resp);
          var c = JSON.parse(resp);
          console.log(c);
          //console.log(c.length);
          if(c.length==0){
            cont=false;
          }else{
            cont=true;
          }
          for (i = 0; i < c.length; i++) {
            
            var lat =  c[i].olatitud;
            var lon =  c[i].olongitud;
          curLocation = [lat, lon];
          
          //map.attributionControl.setPrefix(false);
          if(c[i].oapiestado=='SOLICITUD'){
            marker = new L.marker(curLocation, {
              icon: L.AwesomeMarkers.icon({icon: 'truck', prefix: 'fa', markerColor: 'red'})
            }).addTo(map).bindPopup("<b> SOLICITUD </b>");
          }else{
            if(c[i].oapiestado=='ACEPTADO'){
              marker = new L.marker(curLocation, {
                icon: L.AwesomeMarkers.icon({icon: 'truck', prefix: 'fa', markerColor: 'orange'})
              }).addTo(map).bindPopup("<b> ACEPTADO </b>");
            }else{
              if(c[i].oapiestado=='ENTREGADO'){
                marker = new L.marker(curLocation, {
                  icon: L.AwesomeMarkers.icon({icon: 'truck', prefix: 'fa', markerColor: 'green'})
                }).addTo(map).bindPopup('<button class="btn btn-warning" style="background-color: pink; color:black;" type="button" onclick="cobrar(\'' + c[i].olote + '\')">COBRAR</button>');
              }else{
                if(c[i].oapiestado=='COBRADO'){
                marker = new L.marker(curLocation, {
                  icon: L.AwesomeMarkers.icon({icon: 'truck', prefix: 'fa', markerColor: 'pink'})
                }).addTo(map).bindPopup('<b> COBRADO </b>');
                }
              }
            }
          }
          markers.push(marker);
          map.addLayer(marker);
          }
          //console.log(markers);
          
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax');
        }
      });
    }
  function cobrar(id_lote){
    console.log(id_lote);
    Swal.fire({
        icon: 'warning',
        title: "¿Desea realizar el cobro del pedido?",
        showDenyButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ACEPTAR',
        denyButtonText: 'CANCELAR',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "<?= site_url() ?>distribucion/C_rutas/cobrar",
              type: "POST",
              data: {
                id_lote: id_lote
              },
              success: function(resp) {
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
              }
          });
          location.reload();
        }
    })
   
  }
  </script>
  <!-- END CONTENT -->
<?php } else {
  redirect('inicio');
} ?>