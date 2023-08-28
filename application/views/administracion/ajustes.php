<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Milena Rojas Fecha:22/03/2022, Codigo: GAN-MS-A5-134,
Descripcion: Se actualizo frontend del nuevo modulo de ajustes.
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Milena Rojas Fecha:21/04/2022, Codigo: GAN-MS-A4-178,
Descripcion: Se aiionó la opcion de tamaño de impresion.
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: karen quispe chavez  Fecha:24/06/2022, Codigo: GAN-MS-A5-289
Descripcion: Eliminar en el modulo de ajustes , el min. umbral de existencias, con esto tambien preaparar un script para 
cambiar el estado de ese valor a ANULADO en cat_catalogo, asi mimos crear tres campos en el formulario 
para el registro de NIT , RAZON SOCIAL Y TELEFONO , los mismos que deben ser corregidos para su correcto funcionamiento
------------------------------------------------------------------------------
  Modificado: karen quispe chavez fecha 27/06/2022 Codigo :GAN-MS-A5-289
  Descripcion : se aumento  un 3 nuevos campos para la tabla razon social, telefono y nit para mostrarlos respectivamente 
  asi mismo se modifico la funcion fn_mostrar_ajustes para que muestre estos
  ------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar      Fecha: 31/10/2022       Codigo: GAN-MS-A7-0086
  Descripcion : se añadio estilo centreado a la tabla que muestra la imagen. 
  ------------------------------------------------------------------------------
  Modificado: Jose Daniel Luna Flores Fecha: 24/11/2022   Actividad: GAN-MS-A6-0132      
  Descripcion : Se aumento el nuevo campo para la tabla iva       
  ------------------------------------------------------------------------------
  Modificado: Jose Daniel Luna Flores Fecha: 08/02/2023   Actividad: GAN-MS-B0-0230      
  Descripcion : Nuevo campo agregado "nro de de dias de cotización"
  ------------------------------------------------------------------------------
  Modificado: Flavio Abdon Condori Vela Fecha: 18/02/2023   Actividad: GAN-FCL-B5-0267    
  Descripcion : Nuevo checkbox activar o desactivar
 */
?>
<?php if (in_array("smod_ajust", $permisos)) { ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function(){
      activarMenu('menu8',2);
      // Recuperar el valor de mostrar_chat
      var mst_msg = "";
      mst_chat = '<?php $obj = json_decode($mostrar_chat->fn_mostrar_ajustes); print_r($obj->{'mostrar_chat'});?>';
      if(mst_chat == "true"){
        $('#mostrarChat').bootstrapToggle('on');
      }
      else{
        $('#mostrarChat').bootstrapToggle('off');
      }
  });
</script>
<script>
const input = document.getElementById('files')

input.addEventListener('change', (event) => {
  const target = event.target
  	if (target.files && target.files[0]) {
      const maxAllowedSize = 5 * 1024 * 1024;
      if (target.files[0].size > maxAllowedSize) {
       	target.value = 'Archivo muy pesado, ingrese una imagen más pequeña'
      }
  }
})
</script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
        $('#consideracion').summernote();
    });
  </script>

<!DOCTYPE html>
<div id="content">
  <section>
      <div class="section-header">
          <ol class="breadcrumb">
            <li><a href="#">Administraci&oacute;n</a></li>
            <li class="active">Ajustes</li>
          </ol>
      </div>
      <?php if ($this->session->flashdata('success')) { ?>
        <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                text: "<?php echo $this->session->flashdata('success'); ?>",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR'
            })

        });</script>
      <?php } else if($this->session->flashdata('error')){ ?>
        <script> 
        $(document).ready(function() {
            Swal.fire({
                icon: 'error',
                text: "<?php echo $this->session->flashdata('error'); ?>",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ERROR'
            })

        });</script>
      <?php } ?>
      <form class="form form-validate" novalidate="novalidate" name="" id="" enctype="multipart/form-data" method="post" action="<?= site_url() ?>administracion/C_ajustes/add_update_ajustes">           
        <div class="card">
          <div class="card-head style-primary">
            <header>Ajustes</header>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <center>
                  <table style="width: 65%; height: 200px; border: 3px solid #eb0038; margin-top: 30px; margin-bottom: 5px;">
                    <tr>
                      <td style="text-align:center"><output id="list" ><img src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes); print($obj->{'logo'});?>" style="max-width: 100%;"></output></td>
                    </tr>
                  </table>
                  <label class="btn btn-primary btn-sm btn-file ink-reaction btn-raised">
                      Seleccionar Icono<input style="display: none" type="file" id="files" name="photo" class="form-control"/>
                  </label>
                </center>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_logo">
                      <input type="hidden" class="form-control" name="logo" id="logo" value='<?php $obj = json_decode($logo->fn_mostrar_ajustes); print_r($obj->{'logo'});?>'>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_sistema_titulo">
                      <input type="text" class="form-control" name="sistema_titulo" id="sistema_titulo" onkeypress="return soloLetras(event)"
                      value='<?php $obj = json_decode($titulo->fn_mostrar_ajustes); print_r($obj->{'titulo'});?>'  
                      required data-rule-minlength="4">
                      <label for="sistema_titulo">Titulo del Sistema</label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_descripcion">
                      <input type="text" class="form-control" name="descripcion" id="descripcion" 
                      value='<?php $obj = json_decode($descripcion->fn_mostrar_ajustes); print_r($obj->{'descripcion'}); ?>'>
                      <label for="descripcion">Descripcion</label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_descripcion">
                 
                   <input type="text" class="form-control" name="nit" id="nit" value='<?php $obj = json_decode($nit->fn_mostrar_ajustes); print_r($obj->{'nit'});
                      ?>'>
                      <label for="nit">NIT </label>
                    </div>
                  </div>
                </div>
                <!-- INICIO GAN-MS-A6-0132 24/11/2022 JLuna-->
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_descripcion">
                 
                   <input type="number" class="form-control" name="iva" id="iva" value='<?php $obj = json_decode($iva->fn_mostrar_ajustes); print_r($obj->{'iva'});
                      ?>'>
                      <label for="iva">IVA (%)</label>
                    </div>
                  </div>
                </div>
                <!-- FIN GAN-MS-A6-0132 24/11/2022 JLuna-->
                <!-- INICIO GAN-MS-B0-0230 -->
                
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label">
                      <input type="number" class="form-control" name="dias_validez" id="dias_validez" value='<?php $obj = json_decode($validez->fn_mostrar_ajustes); print_r($obj->{'validez'});?>'>
                      <label for="dias_validez">Numero de dias de validez de cotización</label>
                    </div>
                  </div>
                </div>
              
                <!-- FIN GAN-MS-B0-0230 -->
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_descripcion">  
                    </br>
                      <textarea id="consideracion" name="consideracion"><?php $obj = json_decode($consideracion->fn_mostrar_ajustes); print_r($obj->{'consideracion'});?></textarea> 
      
                      <label for="consideracion">Consideración  </label>                         
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_descripcion">
                  
                   <input type="text" class="form-control" name="razon_social"  id="razon_social" value='<?php $obj = json_decode($razon_social->fn_mostrar_ajustes); print_r($obj->{'razon_social'});
                      ?>'>
                      <label for="razon_social">Razon Social  </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_descripcion">
                  
                   <input type="text" class="form-control" name="direccion"  id="direccion" value='<?php $obj = json_decode($direccion->fn_mostrar_ajustes); print_r($obj->{'direccion'});
                      ?>'>
                      <label for="direccion">Direccion  </label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_descripcion">
                  
                   <input type="text" class="form-control" name="telefono"  id="telefono" value='<?php $obj = json_decode($telefono->fn_mostrar_ajustes); print_r($obj->{'telefono'});
                      ?>'>
                      <label for="telefono">Telefono  </label>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_descripcion">
                    <label for="mostrarChat")>Mostrar Chat </label>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" id="mostrarChat" name="mostrarChat" value="true">
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_sistema_titulo">
                    <select class="form-control select2-list" onChange="select_thema()" id="thema" name="thema">
                      <?php $obj = json_decode($theme_list[0]->fn_mostrar_temas);
                      foreach($obj as $value){ ?>
                        <option class="<?php echo ($value->tema); ?>" value="<?php echo ($value->tema); ?>" 
                          <?php json_decode($thema->fn_mostrar_ajustes)->{'tema'} ==  $value->tema ? print ' selected="selected"' : ''; ?> 
                          class="<?php echo ($value->tema); ?>">
                          <?php echo ($value->tema);?> 
                        </option>
                        <?php } ?></select>
                      <label for="sistema_titulo">Thema</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group floating-label" id="c_sistema_impresion">
                      <select class="form-control select2-list" id="impresion" name="impresion">
                        <?php 
                        // GAN-MS-B1-0469, 15/05/2023 ILaquis.
                        foreach($tipo_impresion as $value){ ?>  
                        <option value="<?php echo $value->oidpapel ?>" <?php $value->oidpapel  ==  $id_papel[0]->oidpapel ? print ' selected="selected"' : ''; ?>><?php echo $value->onombre ?></option>
                        <?php } 
                        // GAN-MS-B1-0469, 15/05/2023 ILaquis.
                        ?>                        
                      </select>
                      <label for="sistema_impresion">Tamaño Impresi&oacute;n</label>
                    </div>
                  </div>
                </div>               
                
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
              <div class="row">
              <div class="card-actionbar">
                  <div class="card-actionbar-row">
                    <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit">Guardar Cambios</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
  </section>
</div>
<script>

function soloLetras(e) {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
      especiales = [8, 37, 39, 46];
  
      tecla_especial = false
      for(var i in especiales) {
          if(key == especiales[i]) {
              tecla_especial = true;
              break;
          }
      }
  
      if(letras.indexOf(tecla) == -1 && !tecla_especial)
          return false;
  }
  
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
