<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: Adamary Margel Uchani Mamani Fecha: 22/11/2022, Codigo: SAM-MS-A7-0001,
Descripcion: Creacion del Controlador View de registro de activos
-------------------------------------------------------------------------------------------------------------------------------

*/
?>
<?php if (in_array("smod_reg_act", $permisos)) { ?>
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/jquery-ui.css">
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      activarMenu('menu17', 7);
      listar_sucursales();
    });
  </script>

  <div id="content">
    <section>
      <div class="section-header">
        <ol class="breadcrumb">
          <li><a href="#">Facturacion</a></li>
          <li class="active">Registro de Sucursales</li>
        </ol>
      </div>
      <!-- GAN-DPR-B2-0300  Inicio-->
      <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
      <div class="modal fade" id="devolucionModal" tabindex="-1" role="dialog" aria-labelledby="devolucionModalLabel" aria-hidden="true">
        <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
              <h5 class="modal-title" id="tituloModal"></h5>
              <h5 class="modal-title" visible="false" id="codigo_activoModal"></h5>
              <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
                <label for="formModal">Motivo</label>
                <textarea class="form-control" id="motivoModal" rows="3"></textarea>
                <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
              <button type="button" class="btn btn-primary" onClick="guardar_devolucion()">Guardar</button>
              <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
            </div>
          </div>
        </div>
      </div>
      <!--  GAN-DPR-B2-0300 fin-->
      <div class="section-body" id="container">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="text-primary">Listado de Sucursales
              <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp;
                Nueva Sucursal</button>
            </h3>
            <hr>
          </div>
        </div>



        <div class="row" style="display: none;" id="form_registro">
          <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
            <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_sucursal" id="form_sucursal" method="post">
                  <input type="hidden" name="id_sucursal" id="id_sucursal" value="0">
                  <div class="card">
                    <div class="card-head style-primary">
                      <div class="tools">
                        <div class="btn-group">
                          <a id="btn_update" class="btn btn-icon-toggle" onclick="update_formulario()"><i class="md md-refresh"></i></a>
                          <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                        </div>
                      </div>
                      <header id="titulo"></header>
                    </div>

                    <div class="card-body">
                      <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                          <div class="form-group floating-label" id="c_producto">
                            <input type="number" class="form-control" name="cod_sucursal" id="cod_sucursal" required>
                            <label for="cod_sucursal">Cód. Sucursal</label>
                          </div>
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                          <div class="form-group floating-label" id="c_producto">
                            <input type="text" class="form-control" name="name_sucursal" id="name_sucursal" required>
                            <label for="name_sucursal">Nombre Sucursal</label>
                          </div>
                        </div>
                      </div>
                      <div class="card-actionbar">
                        <div class="card-actionbar-row">
                          <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="agregar_modifi_sucursal('MODIFICADO')" name="btn" id="btn_edit" value="add">Modificar Sucursal</button>
                          <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="agregar_modifi_sucursal('REGISTRADO')" name="btn" id="btn_add" value="edit">Agregar Sucursal</button>
                        </div>
                      </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" id="listado">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="text-divider visible-xs"><span>Listado de Sucursales</span></div>
          <div class="card card-bordered style-primary">
            <div class="card-body style-default-bright">
              <div id="tabla">
                <div class="table-responsive">
                  <table id="datatable" class=" table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th width="10%">Nª</th>
                        <th width="20%">Código Sucursal</th>
                        <th width="30%">Nombre de Sucursal</th>
                        <th width="20%">Estado</th>
                        <th width="20%">Acción</th>
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
  <script>
    //PARA ABRIR EL FORMULARIO
    function formulario() {
      $("#titulo").text("Registrar Sucursal");
      $('#form_sucursal')[0].reset();
      document.getElementById("form_registro").style.display = "block";
      document.getElementById("btn_update").style.display = "block";
      //$('[name="id_activo"]').val("");
      $('[name="activo"]').val(null).trigger('change');
      $('[name="id_usuario_registro"]').val(null).trigger('change');
      $('#btn_edit').attr("disabled", true);
      $('#btn_add').attr("disabled", false);
    }
    //ACTUALIZAR FORMULARIO
    function update_formulario() {
      $('[name="activo"]').val(null).trigger('change');
      $('[name="id_usuario_registro"]').val(null).trigger('change');
    }

    //PARA CERRAR EL FORMUALRIO DE SUCURSAL
    function cerrar_formulario() {
      document.getElementById("form_registro").style.display = "none";
    }


    function agregar_modifi_sucursal(cad) {
      console.log(cad);
      if ($('#form_sucursal').valid()) {
        var formData = new FormData($('#form_sucursal')[0]);
        let loadingSwal = Swal.fire({
          title: 'Cargando...',
          allowOutsideClick: false,
          showConfirmButton: false,
          onBeforeOpen: () => {
            Swal.showLoading();
          }
        });
        $.ajax({
          type: "POST",
          url: "<?= base_url() ?>facturacion/C_sucursal/C_agregar_modifi_sucursal/" + cad,
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function() {
            loadingSwal;
          },
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
          },
          complete: function() {
            loadingSwal.close();
          }
        });
        $('.swal2-container').click(function(e) {
          e.stopPropagation();
        });
      }
    }

    function listar_sucursales() {
      $.ajax({
        url: '<?= base_url() ?>facturacion/C_sucursal/C_lista_sucursal',
        type: "post",
        datatype: "json",
        success: function(data) {
          var c = JSON.parse(data);
          console.log(c);

          $('#datatable').DataTable({
            "data": c,
            "responsive": true,
            "language": {
              "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
            },
            "destroy": true,
            "columnDefs": [{
              "searchable": false,
              "orderable": false,
              "targets": 0
            }],
            "order": [
              [0, 'asc']
            ],
            "aoColumns": [{
                "mData": "nro"
              },
              {
                "mData": "cod_sucursal"
              },
              {
                "mData": "descripcion"
              },
              {
                "mData": "apiestado"
              },
              {
                "mData": "apiestado",
                render: function(data, type, row) {
                  if (row["apiestado"] == "ELABORADO") {
                    return '<div style="text-align: center;"><button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" title="Editar sucursal" onclick="editar_sucursal(' + row['id_sucursal'] + ',' + row['cod_sucursal'] + ',\'' + row['descripcion'] + '\')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Inactivar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="anular_sucursal(' + row['id_sucursal'] + ');"><i class="fa fa-trash-o fa-lg"></i></button></div> ';
                  } else {
                    return '<div style="text-align: center;"><button type="button" title="Activar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="reactivar_sucursal(' + row['id_sucursal'] + ');"><i class="fa fa-trash-o fa-lg"></i></button></div> ';
                  }
                }
              }


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

    };


    function editar_sucursal(id_sucursal, cod_sucursal, descripcion) {
      $("#titulo").text("Editar Sucursal");
      $('#form_sucursal')[0].reset();

      document.getElementById("form_registro").style.display = "block";
      document.getElementById("btn_update").style.display = "block";

      $('#id_sucursal').val(id_sucursal).trigger('change');
      $('#cod_sucursal').val(cod_sucursal).trigger('change');
      $('#name_sucursal').val(descripcion).trigger('change');

      $('#btn_edit').attr("disabled", false);
      $('#btn_add').attr("disabled", true);

    }

    function anular_sucursal(id_sucursal) {
      $.ajax({
        url: "<?php echo site_url('facturacion/C_sucursal/C_anular_sucursal') ?>",
        type: "POST",
        datatype: "json",
        data: {
          id_sucursal: id_sucursal,
        },
        success: function(respuesta) {
          var json = JSON.parse(respuesta);
          console.log(json);
          $.each(json, function(i, item) {
            if (item.oboolean != 't') {
              Swal.fire({
                icon: 'error',
                text: item.omensaje,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
              });
            } else {
              Swal.fire({
                icon: 'success',
                title: 'La sucursal se anulo con exito',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload();
                } else {
                  location.reload();
                }
              })
            }
          })
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax -no sirve');
        }
      });
    }

    function reactivar_sucursal(id_sucursal) {
      $.ajax({
        url: "<?php echo site_url('facturacion/C_sucursal/C_reactivar_sucursal') ?>",
        type: "POST",
        datatype: "json",
        data: {
          id_sucursal: id_sucursal,
        },
        success: function(respuesta) {
          var json = JSON.parse(respuesta);
          console.log(json);
          $.each(json, function(i, item) {
            if (item.oboolean != 't') {
              Swal.fire({
                icon: 'error',
                text: item.omensaje,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
              });
            } else {
              Swal.fire({
                icon: 'success',
                title: 'La sucursal se activo con exito',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload();
                } else {
                  location.reload();
                }
              })
            }
          })
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error al obtener datos de ajax -no sirve');
        }
      });
    }
  </script>

<?php } else {
  redirect('inicio');
} ?>