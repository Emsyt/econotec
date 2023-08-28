 <?php
  /*
  -------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
  Descripcion: se modifico el datatable para insertar el limit del modelo
  */
  ?>
 <?php if (in_array("smod_marc", $permisos)) { ?>
   <script>
     $(document).ready(function() {
       activarMenu('menu2', 2);

       $('#codigo_mar').on('blur', function() {
         var text_cod = $(this).val();
         $.post("<?= base_url() ?>producto/C_marca/func_auxiliares", {
           accion: 'val_codigo',
           text_cod: text_cod
         }, function(data) {
           if (data > 0) {
             $('#c_codigo_mar').addClass('has-error');
             $('#codigo_mar').attr("aria-invalid", "true");
             $('#result-error').html('<span id="codigo_mar-error" class="help-block">Este código ya existente.</span>');
             document.getElementById('btn_add').disabled = true;
           } else {
             $('#result-error').html('');
             document.getElementById('btn_add').disabled = false;
           }
         });
       });
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
           <li><a href="#">Productos</a></li>
           <li class="active">Marcas</li>
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
             <h3 class="text-primary">Listado de Marcas
               <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nueva Marca</button>
             </h3>
             <hr>
           </div>
         </div>

         <div class="row" style="display: none;" id="form_registro">
           <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
             <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
             <div class="row">
               <div class="col-md-10 col-md-offset-1">
                 <form class="form form-validate" novalidate="novalidate" name="form_marca" id="form_marca" enctype="multipart/form-data" method="post" action="<?= site_url() ?>producto/C_marca/add_update_marca">
                   <input type="hidden" name="id_marca" id="id_marca">
                   <input type="hidden" name="imagen" id="imagen">

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
                         <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                           <div class="row">
                             <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                               <div class="form-group floating-label" id="c_codigo_mar">
                                 <input type="text" class="form-control" name="codigo_mar" id="codigo_mar" onchange="return mayuscula(this);" required>
                                 <div id="result-error"></div>
                                 <label for="codigo_mar">C&oacute;digo</label>
                               </div>
                             </div>

                             <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                               <div class="form-group floating-label" id="c_marca">
                                 <input type="text" class="form-control" name="marca" id="marca" onchange="return mayuscula(this);" required>
                                 <label for="marca">Marca</label>
                               </div>
                             </div>
                           </div>

                           <div class="row">
                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                               <div class="form-group">
                                 <div style="padding-top: 9px;">
                                   <label class="radio-inline radio-styled">
                                     <input type="radio" name="garantia" id="garantia" value="0" checked=""><span style="font-size: 16px;">Sin Garant&iacute;a &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                   </label>
                                   <label class="radio-inline radio-styled">
                                     <input type="radio" name="garantia" id="garantia" value="1"><span style="font-size: 16px;">Con Garant&iacute;a en Bolivia</span>
                                   </label>
                                 </div>
                                 <label for="garantia">Garant&iacute;a</label>
                               </div>
                             </div>
                           </div>

                           <div class="row">
                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                               <div class="form-group floating-label" id="c_tiempo_gar">
                                 <div class="input-group">
                                   <span class="input-group-addon"><i class="fa fa-certificate fa-lg"></i></span>
                                   <div class="input-group-content">
                                     <input type="text" class="form-control" name="tiempo_gar" id="tiempo_gar" data-rule-number="true">
                                     <label for="tiempo_gar">Tiempo de Garant&iacute;a</label>
                                   </div>
                                   <span class="input-group-addon">a&ntilde;os</span>
                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>

                         <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                           <center>
                             <table style="width: 80%; height: 180px; border: 3px solid #eb0038; margin-bottom: 5px;">
                               <tr>
                                 <td><output id="list"></output></td>
                               </tr>
                             </table>
                             <label class="btn btn-primary btn-sm btn-file ink-reaction btn-raised">
                               Seleccionar Imagen<input style="display: none;" type="file" id="files" name="img_marca" class="form-control" />
                             </label>
                           </center>
                         </div>
                       </div>
                     </div>

                     <div class="card-actionbar">
                       <div class="card-actionbar-row">
                         <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Marca</button>
                         <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add">Registrar Marca</button>
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


                   <table id="datatable_marca" class="table table-striped table-bordered">
                     <thead>
                       <tr>
                         <th>Nro</th>
                         <th>C&oacute;digo</th>
                         <th>Marca</th>
                         <th>Garant&iacute;a</th>
                         <th>Tiempo Garant&iacute;a</th>
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
   </div>
   <!-- END BASE -->


   <script>
     $(document).ready(function() {
       $('#datatable_marca').DataTable({
         'processing': true,
         'serverSide': true,
         'responsive': true,
         'destroy': true,
         "language": {
           "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
         },
         'serverMethod': 'post',
         'ajax': {
           'url': '<?= base_url() ?>ltsmarcas'
         },

         'columns': [{
             data: 'codigo',
             render: function(data, type, row) {
               return row['nro'];

             }
           },
           {
             data: 'codigo'
           },
           {
             data: 'descripcion'
           },
           {
             data: 'garantia',
             render: function(data, type, row) {

               if (row['garantia'] == 1) {
                 return '<p>CON GARANT&Iacute;A EN BOLIVIA</p>';
               } else {
                 return '<p>SIN GARANT&Iacute;A</p>';
               }

             }
           },
           {
             data: 'tiempo_garantia'
           },
           {
             data: 'apiestado'
           },
           {
             data: 'apiestado',
             render: function(data, type, row) {

               if (row['apiestado'] == "ELABORADO") {
                 return ' <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_marca(' + row['id_marca'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Inactivar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_marca(' + row['id_marca'] + ',\'' + row['apiestado'] + '\')"><i class="fa fa-trash-o fa-lg"></i></button>';
               } else {
                 return '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_marca(' + row['id_marca'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Activar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="eliminar_marca(' + row['id_marca'] + ',\'' + row['apiestado'] + '\')"><i class="fa fa-trash-o fa-lg"></i></button>';
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

     function formulario() {
       $("#titulo").text("Registrar Marca");
       $('#form_marca')[0].reset();
       document.getElementById("list").innerHTML = '';
       document.getElementById("form_registro").style.display = "block";
       document.getElementById("btn_update").style.display = "block";
     }

     function cerrar_formulario() {
       document.getElementById("form_registro").style.display = "none";
       $('#form_marca')[0].reset();
       document.getElementById("list").innerHTML = '';
     }

     function update_formulario() {
       $('#form_marca')[0].reset();
       document.getElementById("list").innerHTML = '';
       $('#btn_edit').attr("disabled", true);
       $('#btn_add').attr("disabled", false);
     }

     function editar_marca(id_mar) {
       $("#titulo").text("Modificar Marca");
       document.getElementById("form_registro").style.display = "block";
       $('#form_marca')[0].reset();
       document.getElementById("btn_update").style.display = "none";
       $('#btn_edit').attr("disabled", false);
       $('#btn_add').attr("disabled", true);

       $("#c_marca").removeClass("floating-label");
       $("#c_codigo_mar").removeClass("floating-label");
       $("#c_tiempo_gar").removeClass("floating-label");

       $.ajax({
         url: "<?php echo site_url('producto/C_marca/datos_marca') ?>/" + id_mar,
         type: "POST",
         dataType: "JSON",
         success: function(data) {
           $('[name="id_marca"]').val(data.id_marca);
           $('[name="codigo_mar"]').val(data.codigo);
           $('[name="marca"]').val(data.descripcion);
           var selec_garantia = data.garantia
           if (selec_garantia == 0) {
             $('input:radio[name=garantia]:nth(0)').attr('checked', true);
           } else if (selec_garantia == 1) {
             $('input:radio[name=garantia]:nth(1)').attr('checked', true);
           };

           $('[name="tiempo_gar"]').val(data.tiempo_garantia);

           if (data.imagen == null || data.imagen == '') {
             dato = '<p style="text-align: center; font-family: impact; font-size: 20px; color: #2196f3;"> Sin Imagen </p>';
             document.getElementById("list").innerHTML = dato;
           } else {
             dato = '<img src="<?php echo base_url(); ?>assets/img/marcas/' + data.imagen + '" class="img-responsive">';
             document.getElementById("list").innerHTML = dato;
           };
           $('[name="imagen"]').val(data.imagen);

         },
         error: function(jqXHR, textStatus, errorThrown) {
           alert('Error get data from ajax');
         }
       });
     }

     function eliminar_marca(id_mar, estado) {
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
           action: function(dialog) {
             var $button = this;
             $button.disable();
             window.location = '<?= base_url() ?>producto/C_marca/dlt_marca/' + id_mar + '/' + estado;
           }
         }, {
           label: 'Cancelar',
           action: function(dialog) {
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
             document.getElementById("list").innerHTML = ['<img class="img-responsive" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
           };
         })(f);
         reader.readAsDataURL(f);
       }
     }
     document.getElementById('files').addEventListener('change', archivo, false);
   </script>
 <?php } else {
    redirect('inicio');
  } ?>