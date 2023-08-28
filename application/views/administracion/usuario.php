<?php 
/*  
  -------------------------------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:08/03/2022, Codigo: GAN-MS-A1-122
  Descripcion: se modifico el formulario de registro de usuarios en el modulo de administracion/usuarios
  para que los campos Materno, Genero, Fecha de Nacimiento, DIreccion, Telefono,Correo institucional, Cargo 
  no sean obligatorios
  -------------------------------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:14/03/2022, Codigo: GAN-MS-A6-130
  Descripcion: se modifico el formulario de registro de usuarios en el modulo de administracion/usuarios
  para que los campos no sean obligatorios al momento de editar
  -------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
  Descripcion: se modifico el datatable para insertar el limit del modelo
  -------------------------------------------------------------------------------------------------------
  Modificado: Richard Hector Orihuela Gil Fecha:29/07/2022, Codigo: GAN-MS-A1-327
  Descripcion: correcion del modulo de usuarios, En cuanto a la eliminacion de usuarios
  -------------------------------------------------------------------------------------------------------
  Modificado: Dotnara Isabel Condori Condori Fecha:06/06/2023, Codigo: GAN-MS-B0-0508
  Descripcion: se modifico el formato del input de fecha de nacimiento a  DD/MM/AAAA
*/
?>
<?php if (in_array("smod_usu", $permisos)) { ?>
<script>
  // GAN-MS-B0-0508, 06/06/2023 DCondori
  $(document).ready(function(){
      activarMenu('menu8',1);
    // FIN GAN-MS-B0-0508, 06/06/2023 DCondori
  });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function validar_ci(){
    id_usr = document.getElementById("id_usuario").value;
    nro_ci = document.getElementById("nro_carnet").value;
    $.post("<?= base_url() ?>administracion/C_usuario/fn_auxiliares", {accion: 'validar_unico', nro_ci : nro_ci}, function(data){
        if (id_usr == "") {
            if (data == 1) {
              $("#msjcarnet").html("Número de C.I. duplicado ingrese otro C.I.");
              document.getElementById("nro_carnet").style.borderColor = "red";
              document.getElementById("msjcarnet").style.color = "red";
              document.getElementById("msjcarnet").style.fontSize = "12px";
              document.getElementById('btn_add').disabled = true;
            } else if (data == 0) {
              $("#msjcarnet").html("");
              document.getElementById("nro_carnet").style.borderColor = "";
              document.getElementById('btn_add').disabled = false;
            }
        } else{
            if (data == 1) {
              $("#msjcarnet").html("");
              document.getElementById("nro_carnet").style.borderColor = "";
              document.getElementById('btn_edit').disabled = false;
            } else if (data > 1) {
              $("#msjcarnet").html("Número de C.I. duplicado");
              document.getElementById("nro_carnet").style.borderColor = "red";
              document.getElementById("msjcarnet").style.color = "red";
              document.getElementById("msjcarnet").style.fontSize = "12px";
              document.getElementById('btn_edit').disabled = true;
            }
        };
    })
  }
</script>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
          <ol class="breadcrumb">
            <li><a href="#">Administraci&oacute;n</a></li>
            <li class="active">Usuarios</li>
          </ol>
      </div>

      <?php if ($this->session->flashdata('success')) { ?>
        <script> window.onload = function mensaje(){ swal.fire(" ","<?php echo $this->session->flashdata('success'); ?>","success"); } </script>
      <?php } else if($this->session->flashdata('error')){ ?>
        <script> window.onload = function mensaje(){ swal.fire(" ","<?php echo $this->session->flashdata('error'); ?>","error"); } </script>
      <?php } ?>

      <div class="section-body">
        <div class="row"><br>
          <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
            <ul class="nav nav-pills nav-stacked nav-icon">
                <li><small>PERSONAL - <?php $obj = json_decode($titulo->fn_mostrar_ajustes); print_r($obj->{'titulo'});?></small></li>
                <li class="active"><a href="<?= base_url() ?>usuarios"><span class="glyphicon glyphicon-blackboard"></span><p>Registro de Usuario</p></a></li>
                <li><a href="<?= base_url() ?>asignacion_rol"><span class="glyphicon glyphicon-copy"></span><p>Asignaci&oacute;n de Rol</p></a></li>
            </ul>
          </div>

          <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
            <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <form class="form form-validate" novalidate="novalidate" name="form_usuario" id="form_usuario" enctype="multipart/form-data" method="post" action="<?= site_url() ?>administracion/C_usuario/add_update_usuario">
                    <input type="hidden" name="id_usuario" id="id_usuario">
                    <input type="hidden" name="usr_cre" id="usr_cre">
                    <input type="hidden" name="login" id="login">
                    <input type="hidden" name="foto" id="foto">
                    <div style="display: none;">
                    <input type="password" name="password" id="password">
                    </div>
                    <div class="card">
                      <div class="card-head style-primary">
                        <header>Registro de Personal</header>
                      </div>

                      <div class="card-body">
                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <center>
                              <table style="width: 85%; height: 230px; border: 3px solid #eb0038; margin-top: 30px; margin-bottom: 5px;">
                                <tr>
                                  <td><output id="list" ></output></td>
                                </tr>
                              </table>
                              <label class="btn btn-primary btn-sm btn-file ink-reaction btn-raised">
                                  Seleccionar Fotograf&iacute;a<input style="display: none" type="file" id="files" name="photo" class="form-control"/>
                              </label>
                            </center>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="c_nombre">
                                  <input type="text" class="form-control" name="nombre" id="nombre" onchange="return mayuscula(this);" required data-rule-minlength="3">
                                  <label for="nombre">Nombre</label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="c_paterno">
                                  <input type="text" class="form-control" name="ap_paterno" id="ap_paterno" onchange="return mayuscula(this);" required data-rule-minlength="4">
                                  <label for="ap_paterno">Apellido Paterno</label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="c_materno">
                                  <input type="text" class="form-control" name="ap_materno" onchange="return mayuscula(this);" id="ap_materno">
                                  <label for="ap_materno">Apellido Materno</label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="form-group floating-label" id="c_carnet">
                                  <input type="text" class="form-control" name="nro_carnet" id="nro_carnet" required data-rule-minlength="6" onchange="validar_ci()">
                                  <label>Nro. Carnet de Identidad  </label>
                                  <div id="msjcarnet"></div>
                                </div>
                              </div>

                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="form-group floating-label" id="c_expedido">
                                  <select class="form-control select2-list" name="expedido" id="expedido" required>
                                      <option value="">&nbsp;</option>
                                      <?php foreach ($departamentos as $depto) { ?>
                                      <option value="<?php echo $depto->id_departamento ?>" <?php echo set_select('expedido', $depto->id_departamento)?>> <?php echo $depto->nombre ?> </option>
                                      <?php } ?>
                                  </select>
                                  <label for="expedido">Expedido</label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group floating-label" id="c_genero">
                                  <select class="form-control select2-list" name="genero" id="genero" >
                                    <option value=""></option>
                                    <option value="1">FEMENINO</option>
                                    <option value="2">MASCULINO</option>
                                  </select>
                                  <label for="genero">G&eacute;nero:</label>
                                </div>
                              </div>

                              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                              <!-- GAN-MS-B0-0508, 06/06/2023 DCondori -->
                                <div class="form-group floating-label" id="float_fecha">
                                  <input type="date" class="form-control" name="fec_nacimiento" id="fec_nacimiento"  >
                                  <label for="fec_nacimiento">Fecha de Nacimiento</label>
                                </div>
                                <!-- FIN GAN-MS-B0-0508, 06/06/2023 DCondori -->
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="form-group floating-label" id="c_direccion">
                              <input type="text" class="form-control" name="direccion" id="direccion" onchange="return mayuscula(this);">
                              <label for="direccion">Direcci&oacute;n</label>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="form-group floating-label" id="c_telefono">
                              <input type="text" class="form-control" name="telefono" id="telefono" data-rule-number="true" >
                              <label for="telefono">Tel&eacute;fono</label>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group floating-label" id="c_correo">
                              <input type="email" class="form-control" name="correo" id="correo" >
                              <label for="correo">Correo Institucional</label>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group floating-label" id="c_ubi_trabajo">
                              <select class="form-control select2-list" id="ubi_trabajo" name="ubi_trabajo" required>
                                <option value=""></option>
                                <?php foreach ($ubicaciones as $ubi) {  ?>
                                <option value="<?php echo $ubi->id_ubicacion ?>" <?php echo set_select('ubi_trabajo', $ubi->id_ubicacion)?>> <?php echo $ubi->descripcion ?></option>
                                <?php  } ?>
                              </select>
                              <label for="ubi_trabajo">Seleccione Ubicaci&oacute;n de Trabajo</label>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group floating-label" id="c_cargo">
                              <input type="text" class="form-control" name="cargo" id="cargo" onchange="return mayuscula(this);" data-rule-minlength="5">
                              <label for="cargo">Cargo</label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="card-actionbar">
                        <div class="card-actionbar-row">
                          <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Usuario</button>
                          <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add">Registrar Usuario</button>
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
          <div class="text-divider visible-xs"><span>Listado de Registro</span></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card card-bordered style-primary">
              <div class="card-head">
                <header>Detalle de Usuarios</header>
              </div>
              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table id="datatable_usu" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Nª</th>
                        <th>Login</th>
                        <th>Nombre Completo</th>
                        <th>Carnet de Identidad</th>
                        <th>Correo Institucional</th>
                        <th>Tel&eacute;fono</th>
                        <th>Ubicaci&oacute;n de Trabajo</th>
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
  <!-- END CONTENT-->
</div>
<!-- END BASE -->

<script>
   $(document).ready(function(){
     $('#datatable_usu').DataTable({
          'processing': true,
          'serverSide': true,
          'responsive':true,
          "language": {
    "url": "<?= base_url()?>assets/plugins/datatables_es/es-ar.json" },
          'serverMethod': 'post',
          'ajax': {
             'url':'<?=base_url()?>administracion/C_usuario/lista_usuarios'
          },
          
          'columns': [
             { data: 'login' ,render: function (data, type, row){

              return row['nro'];

              }

              },
             { data: 'login' },
             { data: 'nombre',render: function (data, type, row){

              return ''+row['nombre']+' '+row['paterno']+' '+row['materno']+'';

              }

              },
             { data: 'carnet' ,render: function (data, type, row){

              return ''+row['carnet']+' '+row['expedido']+''; //+row['apiestado']+'';

              }
             },
             { data: 'correo' },
             { data: 'telefono' },
             { data: 'ubicacion' },
             { data: 'ubicacion' ,render: function (data, type, row){
                if (row['apiestado']=="ELABORADO") 
                {
                  return ' <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_usuario('+row['id_usuario']+')"><i class="fa fa-pencil"></i></button> <button type="button" title="Inactivar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_usuario('+row['id_usuario']+',\''+row['apiestado']+'\')"><i class="fa fa-trash-o fa-lg"></i></button>';
                }
                else
                {
                  return '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_usuario('+row['id_usuario']+')"><i class="fa fa-pencil"></i></button> <button type="button" title="Activar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="eliminar_usuario('+row['id_usuario']+',\''+row['apiestado']+'\')"><i class="fa fa-trash-o fa-lg"></i></button>';
                }
                  //return '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_usuario('+row['id_usuario']+')"><i class="fa fa-pencil"></i></button> <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_usuario('+row['id_usuario']+')"><i class="fa fa-trash-o"></i></button>';
                  
                }
               
              }
        
          ],
          "dom": 'C<"clear">lfrtip',
          "colVis": {
                        "buttonText": "Columnas"
                    },
        });
       
     });
  function editar_usuario(id_usr){
    $('#form_usuario')[0].reset();

    $('#btn_edit').attr("disabled", false);
    $('#btn_add').attr("disabled", true);

    $("#c_nombre").removeClass("floating-label");
    $("#c_paterno").removeClass("floating-label");
    $("#c_materno").removeClass("floating-label");
    $("#c_carnet").removeClass("floating-label");
    $("#c_expedido").removeClass("floating-label");
    $("#c_direccion").removeClass("floating-label");
    $("#c_nacimiento").removeClass("floating-label");
    $("#c_telefono").removeClass("floating-label");
    $("#c_correo").removeClass("floating-label");
    $("#c_ubi_trabajo").removeClass("floating-label");
    $("#c_cargo").removeClass("floating-label");
    $("#c_genero").removeClass("floating-label");
    
    document.getElementById("nombre").required = false;
    document.getElementById("ap_paterno").required = false;
    document.getElementById("nro_carnet").required = false;
    document.getElementById("expedido").required = false;
    document.getElementById("ubi_trabajo").required = false;

    $.ajax({
        url : "<?php echo site_url('administracion/C_usuario/datos_usuario')?>/" + id_usr,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {console.log(data);
            $('[name="id_usuario"]').val(data.id_usuario);
            $('[name="login"]').val(data.login);
            $('[name="nombre"]').val(data.nombre);
            $('[name="ap_paterno"]').val(data.paterno);
            $('[name="ap_materno"]').val(data.materno);
            $('[name="nro_carnet"]').val(data.carnet);
            $('[name="expedido"]').val(data.id_departamento).trigger('change');
            $('[name="direccion"]').val(data.direccion);
            $fec=data.fec_nacimiento;
            if($fec!="" && $fec!=" " && $fec!=null){
              $('[name="fec_nacimiento"]').val(data.fec_nacimiento).trigger('change');
            }
            $('[name="telefono"]').val(data.telefono);
            $('[name="correo"]').val(data.correo);
            $('[name="genero"]').val(data.genero).trigger('change');
            $('[name="ubi_trabajo"]').val(data.id_proyecto).trigger('change');
            $('[name="cargo"]').val(data.cargo);
            $('[name="password"]').val(data.password);
            if (data.foto == null || data.foto == '') {
              dato = '<p style="text-align: center; font-family: impact; font-size: 20px; color: #2196f3;"> Sin Fotografia </p>';
              document.getElementById("list").innerHTML = dato;
            } else{
                dato = '<img src="<?php echo base_url(); ?>assets/img/personal/'+data.foto+'" class="img-responsive">';
                document.getElementById("list").innerHTML = dato;
            };
            $('[name="foto"]').val(data.foto);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
  }


  function eliminar_usuario(id_usr, estado) {
    if(estado == 'ELABORADO'){
      var titulo = 'ELIMINAR USUARIO';
      var mensaje = '<div>Esta seguro que desea Eliminar el registro</div>'
    } else {
      var titulo = 'HABILITAR USUARIO';
      var mensaje = '<div>Esta seguro que desea Habilitar el registro</div>'
    }

    BootstrapDialog.show({
      title: titulo,
      message: $(mensaje),
      buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
            action: function (dialog) {
                var $button = this;
                $button.disable();
                window.location = '<?= base_url() ?>administracion/C_usuario/dlt_usuario/'+id_usr+'/'+estado;
            }
          }, {
          label: 'Cancelar',
          action: function (dialog) {
              dialog.close();
          }
      }]
    });
  }
</script>

<script>
  function archivo(evt) {
    var files = evt.target.files;
    for (var i = 0, f; f = files[i]; i++) {
      if (!f.type.match('image.*')) {
          continue;
      }
      var reader = new FileReader();
      reader.onload = (function(theFile) {
        return function(e) {
          document.getElementById("list").innerHTML = ['<img class="img-responsive" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
        };
      })(f);
      reader.readAsDataURL(f);
    }
  }
  document.getElementById('files').addEventListener('change', archivo, false);
</script>
<?php } else {redirect('inicio');}?>
