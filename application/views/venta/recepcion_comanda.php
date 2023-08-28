<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Ignacio Laquis Camargo Fecha:21/07/2023, GAN-MS-A6-0549,
Descripcion: Se creo el controlador del submodulo Recepcion de Comandas del modulo Ventas.
-------------------------------------------------------------------------------------------------------------------------------
 */
?>
<?php if (in_array("smod_rec_com", $permisos)) { ?>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      activarMenu('menu5', 10);
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
          <li><a href="#">Ventas</a></li>
          <li class="active">Recepci&oacute;n de Comandas</li>
        </ol>
      </div>

      <?php if ($this->session->flashdata('success')) { ?>
        <script>
          window.onload = function mensaje() {
            swal(" ", "<?php echo $this->session->flashdata('success'); ?>", "success");
          }
        </script>
      <?php } else if ($this->session->flashdata('error')) { ?>
        <script>
          window.onload = function mensaje() {
            swal(" ", "<?php echo $this->session->flashdata('error'); ?>", "error");
          }
        </script>
      <?php } ?>

      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="text-primary">Listado de Mesas
            </h3>
            <hr>
          </div>
        </div>

        <!-- MESAS-->
        <div class="row">
          <div class="col-lg-3">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body no-padding">
                  <div class="alert alert-callout alert-success no-margin" style="background-color: #e8fad4;">
                    <h1 class="pull-right text-success" style="margin-top: 0px;"></h1>
                    <strong class="text-xl">MESA 1</strong><br />
                    <span class="opacity-50">DESOCUPADO</span><br />
                    <span class="opacity-50">SIN COMANDA</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body no-padding">
                  <a href="#" onclick="lts_comanda()">
                    <div id="mesa_comanda" class="alert alert-callout alert-danger no-margin" style="background-color: #fad5d4;">
                      <h1 class="pull-right text-danger" style="margin-top: 0px;"></h1>
                      <strong class="text-xl">MESA 2</strong><br />
                      <span id="estado" class="opacity-50">OCUPADO</span><br />
                      <span id="comandas" class="opacity-50">CON COMANDA</span>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body no-padding">
                  <div class="alert alert-callout alert-info no-margin" style="background-color: #d4f6fa;">
                    <h1 class="pull-right text-info" style="margin-top: 0px;"></h1>
                    <strong class="text-xl">MESA 3</strong><br />
                    <span class="opacity-50">OCUPADO</span><br />
                    <span class="opacity-50">SIN COMANDA</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- DETALLE-->
        <div class="row">
          <div class="col-md-12">
            <div class="text-divider visible-xs"><span>Listado de Mesas</span></div>
            <div class="card card-bordered style-primary">
              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table id="datatable_comanda" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th><input type="checkbox" id="select_all_existent"></th>
                        <th>Nro</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Característica</th>
                        <th>Entregado</th>
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
  <!-- END CONTENT -->
  <script>
    var data = [{
        "nro": 1,
        "oproducto": "Producto 1",
        "ocantidad": 1,
        "ocaracteristica": "Con fideo",
      },
      {
        "nro": 2,
        "oproducto": "Producto 2",
        "ocantidad": 2,
        "ocaracteristica": "Con arroz",
      },
      // Puedes agregar más objetos aquí si es necesario
    ];

    function lts_comanda() {
      var cont = 0;
      var t = $('#datatable_comanda').DataTable({
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
              cont++;
              var a = `<input type="checkbox" name="checkbox" id="checkbox${cont}" value="${cont}" onclick="cambiar_estado(${cont})">`;
              return a;
            }
          },
          {
            "mData": "nro"
          },
          {
            "mData": "oproducto"
          },
          {
            "mData": "ocantidad"
          },
          {
            "mData": "ocaracteristica"
          },
          {
            "mRender": function(data, type, row, meta) {
              var a = `
                                    <div class="col text-center">
                                    <button name="btnEstado" id="btnEstado${cont}" type="button"  title="Sin Entregar" class="btn ink-reaction btn-floating-action btn-xs btn-danger">
                                    <i class="fa fa-times fa-lg"></i></button>
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
        // Cambiar el color del div mesa_comanda
        $('#mesa_comanda').css('background-color', '#d4f6fa');

        var mesaComanda = $('#mesa_comanda');
        mesaComanda.removeClass('alert-danger').addClass('alert-info');
        mesaComanda.find('#comandas').text('SIN COMANDA');
      });
    }

    function cambiar_estado(cont) {
      console.log(cont);
      const btnEstado = $('#btnEstado' + cont);
      btnEstado.removeClass('btn-danger').addClass('btn-success');
      btnEstado.find('i').removeClass('fa-times').addClass('fa-check');
      btnEstado.attr('title', 'Entregado');
    }
  </script>
<?php } else {
  redirect('inicio');
} ?>