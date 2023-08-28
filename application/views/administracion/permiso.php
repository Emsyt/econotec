<?php
/*A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha: 02/09/2022, Codigo: GAN-FR-A1-433,
Descripcion: Creacion de la View permiso.
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha: 09/09/2022, Codigo: GAN-FR-A1-433,
Descripcion: Edición de la View permiso.
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha: 13/09/2022, Codigo: GAN-MS-A1-451,
Descripcion: Edición de la View permiso para incorporar funcionalidad.
*/
?>
<?php if (in_array("smod_perm", $permisos)) { ?>
<style>
#div1 {
     overflow:scroll;
     height:300px;
}
</style>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function(){
      activarMenu('menu8_6');
      listar_roles();
  });
</script>
<style>
  hr {
    margin-top: 0px;
  }
</style>
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20rem; }
  .toggle.ios .toggle-handle { border-radius: 20rem; }
</style>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
          <ol class="breadcrumb">
            <li><a href="#">Administraci&oacute;n</a></li>
            <li class="active">Permisos</li>
          </ol>
      </div>

      <?php if ($this->session->flashdata('success')) { ?>
        <script> 
          window.onload = function mensaje(){ 
            swal(" ","<?php echo $this->session->flashdata('success'); ?>","success"); 
          } 
        </script>
      <?php } else if($this->session->flashdata('error')){ ?>
        <script> 
          window.onload = function mensaje(){ 
            swal(" ","<?php echo $this->session->flashdata('error'); ?>","error"); 
          } 
        </script>
      <?php } ?>

      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="text-primary">Listado de Roles Usuario
              <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()">
                <span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nuevo Rol
              </button>
            </h3>
            <hr>
          </div>
        </div>

        <div class="row" style="display: none;" id="form_registro">
          <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
            <div class="text-divider visible-xs">
              <span>Formulario de Registro</span>
            </div>
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_permiso" id="form_permiso" method="post">
                  <input type="hidden" name="id_rol" id="id_rol" value="0">
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
                      <div class="row" >
                        <div class="col-sm-4">
                          <div class="form-group floating-label" id="c_sigla">
                            <input type="text" class="form-control" name="sigla" id="sigla" onchange="return mayuscula(this);" required>
                            <div id="result-error"></div>
                            <label for="sigla">Sigla del Rol</label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group floating-label" id="c_descripcion">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" onchange="return mayuscula(this);" required>
                            <div id="result-error"></div>
                            <label for="descripcion">Descripción Rol</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <input type="hidden" class="form-control" name="contador" id="contador" value="0">
                        <div id="div1" class="table-responsive">
                          <h5>Listado de permisos</h5> 
                          <table id="datatable_permisos_rol" class="table table-striped table-bordered">
                              <thead>
                                  <tr>
                                      <th>Descripción</th>
                                      <th>Habilitado</th>
                                  </tr>
                              </thead>
                              <tbody id="DataResult">                                
                              </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-actionbar">
                      <div class="card-actionbar-row">
                        <button type="button" class="btn btn-flat btn-primary ink-reaction" 
                                name="btn" id="btn_edit" value="edit" 
                                onclick="agregar_editar_permiso_rol(1)">Modificar Permiso</button>
                        <button type="button" class="btn btn-flat btn-primary ink-reaction" 
                                name="btn" id="btn_add" value="add" 
                                onclick="agregar_editar_permiso_rol(0)">Registrar Permiso</button>
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
            <div class="text-divider visible-xs"><span>Listado de Unidades</span></div>
              <div class="card card-bordered style-primary">
                <div class="card-body style-default-bright">
                  <div class="table-responsive">
                    <table id="datatable_roles" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                              <th>Descripcion</th>
                              <th>Estado</th>
                              <th>Usuario ultima modificacion</th>
                              <th>Fecha ultima modificacion</th>
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
      </div>
    </section>
  </div>
  <!-- END CONTENT -->


<script>
  function formulario(){
    $("#titulo").text("Registrar Rol");
    document.getElementById("form_registro").style.display = "block";
    $('#form_permiso')[0].reset();
    $('#btn_edit').attr("disabled", true);
    $('#btn_add').attr("disabled", false);
    listar_permisos();
  }

  function cerrar_formulario(){
    $('#form_permiso')[0].reset();
    document.getElementById("form_registro").style.display = "none";
  }

  function update_formulario(){
    $("#titulo").text("Registrar Rol");
    document.getElementById("form_registro").style.display = "block";
    $('#form_permiso')[0].reset();
    $('#btn_edit').attr("disabled", true);
    $('#btn_add').attr("disabled", false);
    listar_permisos();
  }

  function listar_roles(){
    $.ajax({
            url:'<?=base_url()?>administracion/C_permiso/lista_roles',
            type:"post",
            datatype:"json",
            
            success: function(data){
                var data = JSON.parse(data);
                    var t = $('#datatable_roles').DataTable({
                        "data": data,
                        "responsive": true,
                        "language": {
                        "url": "<?= base_url()?>assets/plugins/datatables_es/es-ar.json"
                        },
                        "destroy": true,
                        "columnDefs": [ {
                            "searchable": true,
                            "orderable": true,
                            "targets": 0
                        } ],
                        "order": [[ 1, 'asc' ]],
                        "aoColumns": [
                            { "mData": "odescripcion" },
                            { "mData": "oestado" },
                            { "mData": "ousuariomod" },
                            { "mData": "ofechamod" },
                            {
                            "mRender": function(data, type, row, meta) {
                          
                                var a = `  
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick=" eliminar_rol(${row.oidrol})" title ="Eliminar" ><i class="fa fa-trash-o"></i></button>
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick=" editar_rol(${row.oidrol})" title ="Modificar"><i class="fa fa-pencil-square-o fa-lg"></i></button> `;
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

  function listar_permisos(){
    $.ajax({
            url:'<?=base_url()?>administracion/C_permiso/lista_permisos',
            type:"post",
            datatype:"json",
            
            success: function(data){
                var cont = 0;
                var data = JSON.parse(data);
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                  html += '<tr>' +
                    '<td>' + data[i].odetalle + '</td>' +
                    '<td><input type="checkbox" value="' + data[i].odescripcion + '" name="checkboxmod" id="estado' + cont + '"></td>' +
                    '</tr>';
                    cont++;
                }
                $('#DataResult').html(html);
                document.getElementById("contador").value = cont;
            },
            error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
            }
        });
  }

  function listar_permisos_rol(id_rol){
    $.ajax({
            url : "<?php echo site_url('administracion/C_permiso/lista_permisos_rol')?>/" + id_rol,
            type:"post",
            datatype:"json",
            
            success: function(data){
                var cont = 0;
                var data = JSON.parse(data);
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                  if((data[i].oboolean) == 't'){
                    html += '<tr>' +
                    '<td>' + data[i].odetalle + '</td>' +
                    '<td><input type="checkbox" value="' + data[i].odescripcion + '" name="checkboxmod" id="estado' + cont + '" checked></td>' +
                    '</tr>';
                    cont++;

                  }else{
                    html += '<tr>' +
                    '<td>' + data[i].odetalle + '</td>' +
                    '<td><input type="checkbox" value="' + data[i].odescripcion + '" name="checkboxmod" id="estado' + cont + '"></td>' +
                    '</tr>';
                    cont++;
                  }
                }
                $('#DataResult').html(html);
                document.getElementById("contador").value = cont;
            },
            error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
            }
        });
  }

  function editar_rol(id_rol){
    $("#titulo").text("Modificar Rol");
    document.getElementById("form_registro").style.display = "block";
    $('#form_permiso')[0].reset();

    $('#btn_edit').attr("disabled", false);
    $('#btn_add').attr("disabled", true);

    $("#c_sigla").removeClass("floating-label");
    $("#c_descripcion").removeClass("floating-label");

    $.ajax({
        url : "<?php echo site_url('administracion/C_permiso/datos_rol')?>/" + id_rol,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
          $('[name="id_rol"]').val(id_rol);

            $('[name="sigla"]').val(data[0].sigla);
            $('[name="descripcion"]').val(data[0].descripcion);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error al obtener datos de ajax');
        }
    });

    listar_permisos_rol(id_rol);
  }

  function eliminar_rol(id_rol) {
      var titulo = 'ELIMINAR ROL';
      var mensaje = '<div>¿Esta seguro que desea Eliminar el ROL?</div>';
    
    BootstrapDialog.show({
      title: titulo,
      message: $(mensaje),
      buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
            action: function (dialog) {
              dialog.close();
          $.ajax({
            url:'<?=base_url()?>administracion/C_permiso/delete_roles/'+id_rol,
            type:"post",
            datatype:"json",
          
            success: function(data){
                var data = JSON.parse(data);
            
                if(data[0].oestado=='t'){
                  Swal.fire({
                  icon: 'success',
                  text: "El ROL se ha eliminado correctamente",
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

  function agregar_editar_permiso_rol(msg) {
    if (msg == 0) {
        msg = 'add';
    } else {
        msg = 'edit';
    }
    sigla = document.getElementById("sigla").value.trim();
    descripcion = document.getElementById("descripcion").value.trim();
    idrol = document.getElementById("id_rol").value;
    contador = document.getElementById("contador").value.trim();

    descrip = Array();
    apiesta = Array();
    
    var b = 0;
    if (sigla != " " && descripcion != " " && contador != "") {
        for (var i = 0; i < contador; i++) {
            des = document.getElementById("estado" + i);
            est = document.getElementById("estado" + i);
            if(des !=null && est !=null){
              des=des.value;
              est=est.checked;
              descrip.push(des);
              apiesta.push(est);  
            } 
            else {
              b = 1;
            }
        }
        if (b == 0) {
            if (sigla != "" && descripcion != "") {
                $.ajax({
                    url: "<?php echo site_url('administracion/C_permiso/add_update_roles') ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        btn: msg,
                        idrol: idrol, 
                        sigla: sigla,
                        descripcion: descripcion,
                        'descrip': JSON.stringify(descrip),
                        'apiesta': JSON.stringify(apiesta)
                    },
                    success: function(respuesta) {
                        console.log(respuesta);
                        var json = JSON.parse(respuesta);
                        $.each(json, function(i, item) {
                            if (item.oboolean == 'f') {
                                Swal.fire({
                                    icon: 'error',
                                    text: item.omensaje,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se registro con exito',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href =
                                            "<?php echo base_url(); ?>permiso";
                                    } else {
                                        location.href =
                                            "<?php echo base_url(); ?>permiso";
                                    }
                                })
                            }
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax -no sirve');
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: "Por favor termine de llenar todos los campos",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                })
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: "Por favor termine de llenar todos los campos",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
            })
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: "Por favor seleccione al menos 1 select",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ACEPTAR',
        })
    }
  }
</script>
<?php } else {redirect('inicio');}?>
