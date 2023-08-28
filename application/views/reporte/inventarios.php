<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:29/11/2021, Codigo: GAN-MS-A7-107,
Descripcion: Se actualizo frontend del maquetado en su ultima version del branch de design donde este ya cuenta con exportar en pdf, excel y su progress bar.
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert Fecha:20/09/2021, Codigo: GAN-MS-A1-467,
Descripcion: Se corrigio el bud de ajax, declarando bien las columnas de la tabla
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Melani Alisson Cusi Burgoa Fecha:05/12/2022, Codigo: GAN-MS-A3-0157,
Descripcion: Se agrego un contador de productos con ayuda de la funcion fn_reporte_contador
------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha:09/12/2022, Codigo: GAN-MS-A1-0174,
Descripcion: Se modifico la funcion de cambiar_consulta para la agrecacion de nuevos valores
 */
?>
<?php if (in_array("smod_rep_inv", $permisos)) { ?>
  <input type="hidden" name="ubicacion" id="ubicacion" value="<?php echo $id_ubicacion ?>">

  <script type="text/javascript">
    var f = new Date();
    fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
    var id_ubi = $("#ubicacion").val();

    $(document).ready(function() {
      activarMenu('menu6', 2);
      $('[name="ubi_trabajo"]').val(0);
      cambiar_consulta();
    });
  </script>

  <script>
    function enviar(destino) {
      document.form_busqueda.action = destino;
      document.form_busqueda.submit();
    }
  </script>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Reportes</a></li>
          <li class="active">Inventarios</li>
        </ol>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <form class="form" name="form_busqueda" id="form_busqueda" method="post" target="_blank">
              <div class="card">
                <div class="card-head style-default-light">
                  <div class="tools">
                    <div class="btn-group">
                      <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_inventarios')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                      <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_inventarios')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <br>
                  <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-right">
                      <img style="height: 65px;" src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes);
                                                                          print($obj->{'logo'}); ?>">
                    </div>

                    <div class="col-xs-9 col-sm-9 col-md-7 col-lg-7 text-center">
                      <h5 class="text-ultra-bold" style="color:#655e60;"> EMPRESA <?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                                                                                  print_r($obj->{'titulo'}); ?> </h5>
                      <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE INVENTARIOS</h5>
                    </div>

                    <div class="col-xs-9 col-sm-9 col-md-3 col-lg-3">
                      <h6 class="text-ultra-bold text-default-light">Usuario: <?php echo $usuario; ?>
                      </h6>
                      <h6 class="text-ultra-bold text-default-light">Fecha: <?php echo $fecha_imp; ?>
                      </h6>
                    </div>
                  </div><br>
                  <div class="row" style="text-align: center;">
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1" style="text-align: center;">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" style="text-align: center;">
                      <br>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-content">
                              <select class="form-control select2-list" id="ubi_trabajo" name="ubi_trabajo" required>
                                <option value="0">TODOS</option>
                                <?php foreach ($ubicaciones as $ubi) {  ?>
                                  <option value="<?php echo $ubi->id_ubicacion ?>" <?php echo set_select('ubi_trabajo', $ubi->id_ubicacion) ?>> <?php echo $ubi->descripcion ?></option>
                                <?php } ?>
                              </select>
                              <label for="ubi_trabajo">Ubicaci&oacute;n de Trabajo</label>
                              <div class="form-control-line"></div>
                            </div>
                            <div class="input-group-btn">
                              <button class="btn btn-floating-action btn-primary" type="button" onclick="cambiar_consulta();"><i class="fa fa-search"></i></button>
                            </div>
                          </div>

                        </div>
                      </div>
                      <br>
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-md-6">
                          <h4 class="text-ultra-bold" style="text-align: left; color:#655e60;" id="cantidad_total">CANTIDAD PRODUCTOS:</h4>
                        </div>
                        <div class="col-md-6">
                          <h4 class="text-ultra-bold" style="text-align: left; color:#655e60;" id="costo_total">COSTO TOTAL:</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="tabla" style="margin: 3%;">
                  <div class="table-responsive">
                    <table id="datatable_stock" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Nª</th>
                          <th>Categoria</th>
                          <th>Marca</th>
                          <th>C&oacute;digo</th>
                          <th>Producto</th>
                          <th>Costo Unit. (Bs.)</th>
                          <th>Costo Total (Bs.)</th>
                          <th>Precio Unit. (Bs.)</th>
                          <th>Ubicaci&oacute;n</th>
                          <th>Cantidad</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>

          </div>
          </form>

        </div>
      </div>

  </div>
  </section>
  </div>
  <!-- END CONTENT -->

  <script type="text/javascript">
    function cambiar_consulta() {

      var cod_ubicacion = document.getElementById("ubi_trabajo");
      cod_ubicacion = cod_ubicacion.options[cod_ubicacion.selectedIndex].value;

      document.getElementById("tabla").innerHTML = '';
      document.getElementById("tabla").innerHTML = '<div class="table-responsive">' +
        '<table id="datatable_stock" class="table table-striped table-bordered">' +
        '<thead>' +
        '<tr>' +
        '<th>Nª</th>' +
        '<th>Categoria</th>' +
        '<th>Marca</th>' +
        '<th>C&oacute;digo</th>' +
        '<th>Producto</th>' +
        '<th>Costo Unit. (Bs.)</th>' +
        '<th>Costo Total (Bs.)</th>' +
        '<th>Precio Unit. (Bs.)</th>' +
        '<th>Ubicaci&oacute;n</th>' +
        '<th>Cantidad</th>'
      '</tr>' +
      '</thead>' +
      '</table>' +
      ' </div>';
      console.log(cod_ubicacion);


      $('#datatable_stock').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive': true,
        "language": {
          "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
        },
        'serverMethod': 'post',
        'ajax': {
          'url': '<?= base_url() ?>reporte/C_reporte_inventarios/lst_reporte_inventarios/' + cod_ubicacion,
        },
        'columns': [{
            data: 'pnro'
          },
          {
            data: 'pcategoria'
          },
          {
            data: 'pmarca'
          },
          {
            data: 'pcodigo'
          },                    
          {
            data: "pproducto"
          },
          {
            data: 'pcosto_uni'
          },
          {
            data: 'pcosto_total'
          },
          {
            data: 'pprecio'
          },
          {
            data: 'pubicacion'
          },
          {
            data: "pcantidad"
          },

        ]
      });
      
      $.ajax({
            url: '<?= base_url() ?>reporte/C_reporte_inventarios/cantidad_productos',
            type: "post",
            datatype: "json",
            data: {
                selc_ubi: cod_ubicacion
            },
            success: function(data) {
                var data = JSON.parse(data);
                console.log(data);
                document.getElementById("cantidad_total").innerHTML = "CANTIDAD PRODUCTOS: "+data[0].sum;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
      
        $.ajax({
            url: '<?= base_url() ?>reporte/C_reporte_inventarios/costo_total',
            type: "post",
            datatype: "json",
            data: {
                selc_ubi: cod_ubicacion
            },
            success: function(data) {
                var data = JSON.parse(data);
                console.log(data);
                document.getElementById("costo_total").innerHTML = "COSTO TOTAL: "+data[0].sum + " Bs.";
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