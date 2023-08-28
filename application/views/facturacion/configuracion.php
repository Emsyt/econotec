<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:29/06/2022, Codigo: Facturacion Computarizada,
Descripcion: Se Realizo el frontend para las configuraciones necesarias para la facturacion computarizada
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Gabriela Mamani Choquehuanca Fecha:20/07/2022, Codigo: GAN-MS-A1-314,
Descripcion: Se modifico en su totalidad la vista,ademas se crearon las funciones de mostrardatos,valores y valores1;
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Gabriela Mamani Choquehuanca Fecha:21/07/2022, Codigo: GAN-MS-A1-314,
Descripcion: Se añadio la funcion formulario;
 -------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:28/04/2023, Codigo: 
Descripcion: Se anadieron 4 campos para la configuracion de datos para el servidor de correo , tanto para la recuperacion
de datos , guardado y registro
 -------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:06/06/2023, Codigo: GM-ECOGAN-MS-A6-0007
Descripcion: Se anadio que cuando se seleccione electronica se habilite un boton para subir los certificados digitales 
  */
?>
<style>
  textarea {
    resize: none;
  }
</style>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
  $(document).ready(function() {
    activarMenu('menu17', 6);
    datos_sistema();
    validar_tipo();
  });

  function validar_tipo() {
    var tipo = document.getElementById('modalidad').value;
    if (tipo == 1) {
      document.getElementById("cert").style.display = "block";
      $('#archivo_crt').prop('required', true);
      $('#archivo_pk').prop('required', true);
    } else {
      document.getElementById("cert").style.display = "none";
      $('#archivo_crt').removeAttr('required');
      $('#archivo_pk').removeAttr('required');
    }
  }
</script>

<style>
  .toggle.ios,
  .toggle-on.ios,
  .toggle-off.ios {
    border-radius: 20rem;
  }

  .toggle.ios .toggle-handle {
    border-radius: 20rem;
  }

  .password-icon {
    float: right;
    position: relative;
    margin: -25px 10px 0 0;
    cursor: pointer;
    z-index: 10;
  }
</style>


<!-- BEGIN CONTENT-->
<div id="content">
  <section>
    <div class="section-header">
      <ol class="breadcrumb">
        <li><a href="#">Facturaci&oacute;n</a></li>
        <li class="active">Configuracion</li>
      </ol>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <form class="form form-validate" novalidate="novalidate" enctype="multipart/form-data" name="form_configuracion" id="form_configuracion" method="post" action="<?= site_url() ?>facturacion/C_configuracion/add_update_facturacion">
            <div class="card">
              <div class="card-head style-primary">
                <header>Configuraci&oacute;n de sistemas inform&aacute;ticos de facturaci&oacute;n</header>
              </div>
              <div class="card-body">
                <div class="col-md-12">
                  <div class="row">
                    <input type="hidden" class="form-control" name="id_facturacion" id="id_facturacion">
                    <div class="col-md-6">
                      <div class="form-group floating-label" id="c_codigo">
                        <input type="text" class="form-control" name="codigo" id="codigo" required>
                        <label for="codigo">Codigo de Sistema</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group floating-label" id="c_nit">
                        <input type="text" class="form-control" name="nit" id="nit" required>
                        <label for="nit">NIT</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <select class="form-control select2-list" id="ambiente" name="ambiente" required>
                          <option value="2">PRUEBAS</option>
                          <option value="1">PRODUCCIÓN</option>
                        </select>
                        <label for="ambiente">Tipo Ambiente</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <select class="form-control select2-list" id="modalidad" name="modalidad" required onchange="validar_tipo()">
                          <option value="1">ELECTRÓNICA EN LÍNEA</option>
                          <option value="2">COMPUTARIZADA EN LÍNEA</option>
                        </select>
                        <label for="modalidad">Tipo Modalidad</label>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <div class="floating-label" id="c_cafc">
                              <input type="text" class="form-control" name="cafc" id="cafc">
                              <label for="cafc">CAFC - Factura Compra Venta</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <div class="floating-label" id="c_cafc_ini">
                              <input type="number" class="form-control" name="cafc_ini" id="cafc_ini">
                              <label for="cafc_ini">Rango Inicial</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <div class="floating-label" id="c_cafc_fin">
                              <input type="number" class="form-control" name="cafc_fin" id="cafc_fin">
                              <label for="cafc_fin">Rango final</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <div class="floating-label" id="c_cafc_tasas">
                              <input type="text" class="form-control" name="cafc_tasas" id="cafc_tasas">
                              <label for="cafc_tasas">CAFC - Factura Compra Venta Tasas</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <div class="floating-label" id="c_cafc_tasas_ini">
                              <input type="number" class="form-control" name="cafc_tasas_ini" id="cafc_tasas_ini">
                              <label for="cafc_tasas_ini">Rango Inicial</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <div class="floating-label" id="c_cafc_tasas_fin">
                              <input type="number" class="form-control" name="cafc_tasas_fin" id="cafc_tasas_fin">
                              <label for="cafc_tasas_fin">Rango final</label>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group floating-label" id="c_token">
                        <textarea class="form-control" name="token" id="token" rows="4"></textarea>
                        <label for="token">Token</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group floating-label" id="c_host">
                        <input type="text" class="form-control" name="smtp_host" id="smtp_host" required>
                        <label for="smtp_host">Smtp Host</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group floating-label" id="c_port">
                        <input type="text" class="form-control" name="smtp_port" id="smtp_port" required>
                        <label for="smtp_port">Smtp Port</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group floating-label" id="c_user">
                        <input type="text" class="form-control" name="smtp_user" id="smtp_user" required>
                        <label for="smtp_user">Smtp User</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group floating-label" id="c_pass">
                        <input type="password" class="form-control" name="smtp_pass" id="smtp_pass" required>
                        <label for="smtp_pass">Smtp Pass</label>
                        <span class="fa fa-fw fa-eye password-icon show-password" style="color:#a6cded;" id="password-icon" onclick="prev_password()"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row" id="cert">
                    <div class="col-sm-6">
                      <div class="form-group floating-label" id="c_pk">
                        <label for="">Seleccione su certificado/s digital (".pem", ".crt", ".p12")</label>
                        <input class="" type="file" name="archivo_crt[]" id="archivo_crt" required onchange="validarArchivos_crt()" multiple />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group floating-label" id="c_pk">
                        <label for="">Seleccione su firma digital (".pem", ".crt", ".p12")</label>
                        <input class="" type="file" name="archivo_pk[]" id="archivo_pk" required onchange="validarArchivos_pk()" multiple />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-actionbar">
                <div class="card-actionbar-row" style="display: block;" id="form1">
                  <button type="button" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" onclick="gestionar_sistema(this)">Guardar Cambios</button>
                  <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="formulario()"> Nueva Configuracion</button>
                </div>
                <div class="row" style="display: none;" id="form_registro12">
                  <div class="card-actionbar">
                    <div class="card-actionbar-row">
                      <button type="button" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add" onclick="gestionar_sistema(this)">Registrar Configuracion</button>
                    </div>
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

<script>
  function validarArchivos_crt() {
    var input_crt = document.getElementById('archivo_crt');
    var file_crt = input_crt.files;

    if (file_crt.length > 1) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Solo debe ingresar 1 archivo.',
        confirmButtonColor: '#d33',
        confirmButtonText: 'ACEPTAR'
      });
      input_crt.value = '';
      return false;
    } else {
      return true;
    }
  }

  function validarArchivos_pk() {
    var input_pk = document.getElementById('archivo_pk');
    var files_pk = input_pk.files;

    if (files_pk.length > 1) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Solo debe ingresar 1 archivo.',
        confirmButtonColor: '#d33',
        confirmButtonText: 'ACEPTAR'
      });
      input_pk.value = '';
      return false;
    } else {
      return true;
    }
  }

  function prev_password() {
    let showPassword = document.querySelector('.show-password');
    let password = document.getElementById('smtp_pass');
    if (password.type === "text") {
      password.type = "password";
      showPassword.classList.remove('fa-eye-slash');
    } else {
      password.type = "text";
      showPassword.classList.toggle("fa-eye-slash");
    }
  }

  function datos_sistema() {
    $.ajax({
      url: '<?= base_url() ?>facturacion/C_configuracion/C_datos_sistema',
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data.length > 0) {
          $('#id_facturacion').val(data[0].id_facturacion).trigger('change');
          $('#codigo').val(data[0].cod_sistema).trigger('change');
          $('#nit').val(data[0].nit).trigger('change');
          $('#ambiente').val(data[0].cod_ambiente).trigger('change');
          $('#modalidad').val(data[0].cod_modalidad).trigger('change');
          $('#cafc').val(data[0].cod_cafc).trigger('change');
          $('#cafc_ini').val(data[0].cafc_ini).trigger('change');
          $('#cafc_fin').val(data[0].cafc_fin).trigger('change');
          $('#cafc_tasas').val(data[0].cod_cafc_tasas).trigger('change');
          $('#cafc_tasas_ini').val(data[0].cafc_tasas_ini).trigger('change');
          $('#cafc_tasas_fin').val(data[0].cafc_tasas_fin).trigger('change');
          $('#estado').val(data[0].cod_emision).trigger('change');
          $('#token').val(data[0].cod_token).trigger('change');
          $('#smtp_host').val(data[0].smtp_host).trigger('change');
          $('#smtp_port').val(data[0].smtp_port).trigger('change');
          $('#smtp_user').val(data[0].smtp_user).trigger('change');
          $('#smtp_pass').val(data[0].smtp_pass).trigger('change');
        } else {
          formulario();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  };
  // Registra y edita un sistema de facturacion en la base de datos
  function gestionar_sistema(val) {

    var input_crt = document.getElementById('archivo_crt');
    var input_pk = document.getElementById('archivo_pk');
    var files_crt = input_crt.files;
    var files_pk = input_pk.files;
    var validExtensions = [".pem", ".crt", ".p12"];
    var valid = true;

    console.log(files_crt);
    for (var i = 0; i < files_crt.length; i++) {
      var fileName = files_crt[i].name;
      var fileExtension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();
      var fileName_pk = files_pk[i].name;
      var fileExtension_pk = fileName_pk.substring(fileName_pk.lastIndexOf('.')).toLowerCase();

      if (validExtensions.indexOf(fileExtension) === -1 || validExtensions.indexOf(fileExtension_pk) === -1) {
        valid = false;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Solo se permiten archivos de extension .pem ,.crt o .p12.',
          confirmButtonColor: '#d33',
          confirmButtonText: 'ACEPTAR'
        });
        input_crt.value = '';
        input_pk.value = '';
        break;
      }
    }
    var tipo = document.getElementById('modalidad').value;
    if ((valid) || (tipo == 2)) {

      if ($('#form_configuracion').valid()) {
        var formData = new FormData($('#form_configuracion')[0]);
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
          url: "<?= base_url() ?>facturacion/C_configuracion/C_gestionar_sistema/" + val.value,
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function() {
            loadingSwal;
          },
          success: function(resp) {
            var c = JSON.parse(resp);
            console.log(c);
            if (c[0].oboolean == 't') {
              Swal.fire({
                icon: 'success',
                title: 'El agregado o modificación se realizó con éxito',
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
  };



  function formulario() {

    document.getElementById("form_registro12").style.display = "block";

    document.getElementById("form1").style.display = "none";
    $('#form_configuracion')[0].reset();
  }
</script>