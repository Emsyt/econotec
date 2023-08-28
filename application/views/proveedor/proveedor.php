<?php
  /*
  -------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
  Descripcion: se modifico el datatable para insertar el limit del modelo 
      -------------------------------------------------------------------------------------------------------
  Modificado: Gary German Valverde Quibsert Fecha:01/09/2022, Codigo: GAN-MS-A1-426
  Descripcion: se modifico el la funcion de formulario() corrigiendo el bug de rescatar de datos
      -------------------------------------------------------------------------------------------------------
  Modificado: Ariel Ramos Paucara Fecha: 24/02/2023, Codigo: GAN-MS-B5-0284
  Descripcion: Se adiciono un campo telefono movil en el formulario
  */
?>
<?php if (in_array("mod_prov", $permisos)) { ?>
<script>
  $(document).ready(function(){
      activarMenu('menu4');
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
              <li><a href="#">Proveedor</a></li>
              <li class="active">Proveedores</li>
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
            <h3 class="text-primary">Listado de Proveedores
            <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nuevo Proveedor</button>
            </h3>
            <hr>
          </div>
        </div>

        <div class="row" style="display: none;" id="form_registro">
          <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
            <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <form class="form form-validate" novalidate="novalidate" name="form_proveedor" id="form_proveedor" method="post" action="<?= site_url() ?>proveedor/C_proveedor/add_update_proveedor">
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

                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_razon_social">
                            <input type="text" class="form-control" name="razon_social" id="razon_social" onchange="return mayuscula(this);" required>
                            <label for="razon_social">Raz&oacute;n social</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_tel_movil">
                            <input type="text" onKeyPress="return numero(event) && limitarLongitud(event)" class="form-control" name="tel_movil" id="tel_movil">
                            <label for="tel_movil">Teléfono móvil</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_sigla">
                            <input type="text" class="form-control" name="sigla" id="sigla" onchange="return mayuscula(this);">
                            <label for="sigla">Sigla</label>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group floating-label" id="c_nit">
                            <input type="number" class="form-control" name="nit" id="nit">
                            <label for="nit">NIT</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card-actionbar">
                      <div class="card-actionbar-row">
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Proveedor</button>
                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add">Registrar Proveedor</button>
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
                  
                  <table id="datatable_prov" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Nª</th>
                        <th>Raz&oacute;n Social</th>
                        <th>Sigla</th>
                        <th>NIT</th>
                        <th>Teléfono móvil</th>
                        <th>Estado</th>
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
  <!-- END CONTENT -->


<script>
   $(document).ready(function(){
    $('#datatable_prov').DataTable({
          'processing': true,
          'serverSide': true,
          'responsive':true,
          "language": {
    "url": "<?= base_url()?>assets/plugins/datatables_es/es-ar.json" },
          'serverMethod': 'post',
          'ajax': {
             'url':'<?=base_url()?>proveedor/C_proveedor/lista_proveedores'
          },
          
          'columns': [
             { data: 'apiestado' ,render: function (data, type, row){

                    return row['nro'];
                  
                  }
              },
             { data: 'nombre_rsocial' },
             { data: 'apellidos_sigla' },
             { data: 'nit_ci' },
            //  { data: 'movil' },
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
             { data: 'apiestado' },
            
             { data: 'apiestado' ,render: function (data, type, row){

                if (row['apiestado']=="ELABORADO") 
                {
                  return ' <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_proveedor('+row['id_personas']+')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Inactivar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_proveedor('+row['id_personas']+',\''+row['apiestado']+'\')"><i class="fa fa-trash-o fa-lg"></i></button>';
                }
                else
                {
                  return '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_proveedor('+row['id_personas']+')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Activar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="eliminar_proveedor('+row['id_personas']+',\''+row['apiestado']+'\')"><i class="fa fa-trash-o fa-lg"></i></button>';
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
  function formulario(){
     // GAN-MS-A1-426, 01-09-2022, Gary German Valverde Quisbert
     $('#form_proveedor')[0].reset();
    $('#btn_edit').attr("disabled", true);
    $('#btn_add').attr("disabled", false);
    // FIN GAN-MS-A1-426, 01-09-2022, Gary German Valverde Quisbert
    $("#titulo").text("Registrar Proveedor");
    document.getElementById("form_registro").style.display = "block";
  }

  function cerrar_formulario(){
    document.getElementById("form_registro").style.display = "none";
  }

  function update_formulario(){
    $('#form_proveedor')[0].reset();
    $('#btn_edit').attr("disabled", true);
    $('#btn_add').attr("disabled", false);
  }

  function editar_proveedor(id_prov){
    $("#titulo").text("Modificar Proveedor");
    document.getElementById("form_registro").style.display = "block";
    $('#form_proveedor')[0].reset();

    $('#btn_edit').attr("disabled", false);
    $('#btn_add').attr("disabled", true);

    $("#c_razon_social").removeClass("floating-label");
    $("#c_sigla").removeClass("floating-label");
    $("#c_nit").removeClass("floating-label");
    $("#c_tel_movil").removeClass("floating-label");

    $.ajax({
        url : "<?php echo site_url('proveedor/C_proveedor/datos_proveedor')?>/" + id_prov,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id_proveedor"]').val(data.id_personas);
            $('[name="razon_social"]').val(data.nombre_rsocial);
            $('[name="tel_movil"]').val(data.movil);
            $('[name="sigla"]').val(data.apellidos_sigla);
            $('[name="nit"]').val(data.nit_ci);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error al obtener datos de ajax');
        }
    });
  }

    function eliminar_proveedor(id_prov, estado) {
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
            action: function (dialog) {
                var $button = this;
                $button.disable();
                window.location = '<?= base_url() ?>proveedor/C_proveedor/dlt_proveedor/'+id_prov+'/'+estado;
            }
          }, {
          label: 'Cancelar',
          action: function (dialog) {
              dialog.close();
          }
      }]
    });
  }
  function limitarLongitud(event) {
    if (event.target.value.length >= 8) {
      return false;
    }
    return true;
  }
</script>
<?php } else {redirect('inicio');}?>
