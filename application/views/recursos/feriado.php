<?php
 /*
  -------------------------------------------------------------------------------------------------------
  -- Creado: Jhonatan Nestor Romero Condori                                            Fecha:03/07/202 --
  -- Modulo: recursos/feriado           Proyecto: ECOGAN                     Actividad:GAN-FCL-B3-0318 -- 
  -- Descripcion: se creo el modulo feriado y funciones para que realize un ABM.                       --
  -------------------------------------------------------------------------------------------------------
  */
  ?>
 <?php if (in_array("smod_recur_feri", $permisos)) { ?>
   <script>
     $(document).ready(function() {
       activarMenu('menu16', 3);

       $('#codigo_mar').on('blur', function() {
         var text_cod = $(this).val();
         $.post("<?= base_url() ?>recursos/C_feriado/add_update_feriado", {
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
           <li><a href="#">Recursos</a></li>
           <li class="active">Feriado</li>
         </ol>
       </div>

       <?php if ($this->session->flashdata('success')) { ?>
         <script>
           window.onload = function mensaje() {
            swal.fire(" ", "<?php echo $this->session->flashdata('success'); ?>", "success");
           }
         </script>
       <?php } else if ($this->session->flashdata('error')) { ?>
         <script>
           window.onload = function mensaje() {
             swal.fire(" ", "<?php echo $this->session->flashdata('error'); ?>", "error");
           }
         </script>
       <?php } ?>
            
       <div class="section-body">
         <div class="row">
           <div class="col-lg-12">
             <h3 class="text-primary">Listado de Feriados
               <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus" ></i></span> &nbsp; Nuevo feriado</button>
             </h3>
             <hr>
           </div>
         </div>

         <div class="row" style="display: none;" id="form_registro">
           <div class="col-sm-4 col-md-5 col-lg-6 col-lg-offset-1">
             <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
             <div class="row">
               <div class="col-md-12 col-md-offset-5">
                 <form class="form form-validate" novalidate="novalidate" name="form_feriado" id="form_feriado" enctype="multipart/form-data" method="post" action="<?= site_url() ?>recursos/C_feriado/add_update_feriado">
                   <input type="hidden" name="id_feriado" id="id_feriado">
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
                         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                           <div class="row">
                             <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                               <div class="form-group floating-label" id="c_fech_fer">
                                <label for="fecha_feriado">Fecha</label>
                                 <input type="date" class="form-control" name="fecha_feriado" value="<?php echo date("Y-m-d");?>" id="fecha_feriado" onchange="return mayuscula(this);" required>
                                 <div id="result-error"></div>
                                 
                              
                               </div>
                               
                             </div>

                             <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                               <div class="form-group floating-label" id="c_descr_feriado">
                                 <input type="text" class="form-control" name="descr_feriado" id="descr_feriado" onchange="return mayuscula(this);" required>
                            
                                 <label for="descr_feriado">Descripcion</label>
                               </div>
                             </div>
                           </div>
                                                                                     
                           <div class="row">
                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                               <div class="form-group">
                                 <div style="padding-top: 9px;">
                                   <label class="radio-inline radio-styled">
                                     <input type="radio" class="ambito0" name="ambito" id="ambito" value="0" checked=""><span style="font-size: 16px;">Nac&iacute;onal</span>
                                   </label>
                                   <label class="radio-inline radio-styled">
                                     <input type="radio" class="ambito1" name="ambito" id="ambito" value="1"><span style="font-size: 16px;">Departamental</span>
                                   </label>
                                 </div>
                                 <label for="ambito">Amb&iacute;to</label>
                               </div>
                             </div>
                           </div>

                          
                         </div>
                               <tr>
                                 <td><output id="list"></output></td>
                               </tr>
                         
                       </div>
                     </div>

                     <div class="card-actionbar">
                       <div class="card-actionbar-row">
                         <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Feriado</button>
                         <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add" onclick="habilitar_tablaf()">Registrar Feriado</button>
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
                <div id="tablaf">
                <div class="table-responsive">
                   <table id="datatable_feriado" class="table table-striped table-bordered">
                     <thead>
                       <tr>
                         <th>Nro</th>
                         <th>Fecha</th>
                         <th>Descripcion</th>
                         <th>Ambito</th>
                         <th>Estado</th>
                         <th>Acciones</th>
                        
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
   </div>
   <!-- END BASE -->
    
     
        


   <script>
    //Habilitacion del Datatable
    $(document).ready(function(){
      
      
      habilitar_tablaf();
    

    });

   function habilitar_tablaf() {
    

    //var id_feriado = document.getElementById('id_feriado').value;
    //console.log(id_feriado);
    document.getElementById("tablaf").innerHTML = '';
    document.getElementById("tablaf").innerHTML = '<div class="table-responsive">' +
        '<table id="datatable_feriado" class="table table-striped table-bordered">' +
        '<thead>' +
        '<tr>' +
        '<th>Nro</th>' +
        '<th>Fecha</th>' +
        '<th>Descripcion</th>' +
        '<th>Ambito</th>' +
        '<th>Estado</th>' +
        '<th>Acciones</th>' +
        '</tr>' +
        '</thead>' +
        '</table>' +
        ' </div>';

    $.ajax({
        url: "<?php echo site_url('recursos/C_feriado/listar_registro_feriado') ?>",
        type: "POST",
        dataType: "JSON",
     
        success: function(data) {
            //alert(JSON.stringify(data));
            console.log(data);
           var t = $('#datatable_feriado').DataTable({
                "data": data,
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

                "aoColumns": [
                  {"mData": "oidferiado"},
                  {"mData": "ofecha"},
                  {"mData": "odescripcion"},
                 // {"mData": "oambito"},
                 
                 {
                      "mData": "oambito",
                        render: function(data, type, row) {

                          if (row['oambito'] == 0) {
                            return '<p>Nac&iacute;onal</p>';
                                }
                          else {
                          return '<p>Departamental</p>';
                                  }

                                }
                  },

                  {"mData": "oapiestado"},

                  {
                      
                        "mdata": "oapiestado",
                        render: function(data, type, row) {

                          if (row["oapiestado"] == "ELABORADO") {
                            return ' <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_feriado(' + row['oidferiado'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Inactivar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_feriado(' + row['oidferiado'] + ',\'' + row["oapiestado"] + '\')"><i class="fa fa-trash-o fa-lg"></i></button>';
                          } else {
                            return '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_feriado(' + row['oidferiado'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Activar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="eliminar_feriado(' + row['oidferiado'] + ',\'' + row["oapiestado"] + '\')"><i class="fa fa-trash-o fa-lg"></i></button>';
                          }
                        }
           
                    },


                ],
                "dom": 'C<"clear">lfrtip',
                "colVis": {
                    "buttonText": "Columnas"
                },
                "drawCallback": function() {
                    //alert("La tabla se está recargando"); 
                    var api = this.api();
                    var table = api.table();

                }
            });

        },
        error: function(jqXHR, textStatus, errorThrown) {
            //var json = jqXHR;
            //var json2 = textStatus;
            //var json3 = errorThrown;

            /*const object1 = {
              a:jqXHR,
              b:textStatus,
              c:errorThrown
            };*/
            
           // alert('Error ajax'+ JSON.stringify(object1));
            alert('Error ajax');
        }
    });
}

     function formulario() {
       $("#titulo").text("Registrar Feriado");
       $('#form_feriado')[0].reset();
       document.getElementById("list").innerHTML = '';
       document.getElementById("form_registro").style.display = "block";
       document.getElementById("btn_update").style.display = "block";
     }

     function cerrar_formulario() {
       document.getElementById("form_registro").style.display = "none";
       $('#form_feriado')[0].reset();
       document.getElementById("list").innerHTML = '';
     }

     function update_formulario() {
       $('#form_feriado')[0].reset();
       document.getElementById("list").innerHTML = '';
       $('#btn_edit').attr("disabled", true);
       $('#btn_add').attr("disabled", false);
     }

     function editar_feriado(id_fer) {
       $("#titulo").text("Modificar Feriado");
       document.getElementById("form_registro").style.display = "block";
       $('#form_feriado')[0].reset();
       document.getElementById("btn_update").style.display = "none";
       $('#btn_edit').attr("disabled", false);
       $('#btn_add').attr("disabled", true);

       $("#c_fech_fer").removeClass("floating-label");
       $("#c_descr_feriado").removeClass("floating-label");
       //$("#c_tiempo_gar").removeClass("floating-label");

       $.ajax({
         url: "<?php echo site_url('recursos/C_feriado/datos_feriado') ?>/" + id_fer,
         type: "POST",
         dataType: "JSON",
         success: function(data) {
          //alert(JSON.stringify(data));
           $('[name="id_feriado"]').val(data.id_feriado);
           $('#fecha_feriado').val(data.fecha);
           //alert(data.descripcion);
           $('#descr_feriado').val(data.descripcion);
           
           if (data.ambito == "1") {
            //alert(data.ambito);
             //$('input[value=1]:checked').val();
             $('.ambito1').prop("checked", true);
             $('.ambito0').prop("checked", false);
           } else {
             //$('input[value=0]:checked').val();
             $('.ambito1').prop("checked", false);
             $('.ambito0').prop("checked", true);
           }


         },
         
         error: function(jqXHR, textStatus, errorThrown) {
          /*const object1 = {
              a:jqXHR,
              b:textStatus,
              c:errorThrown
            };
            
        alert('Error ajax'+ JSON.stringify(object1));*/
         alert('Error ajax');
         }
       });
     }

     function eliminar_feriado(id_fer, estado) {
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
             window.location = '<?= base_url() ?>recursos/C_feriado/dlt_feriado/' + id_fer + '/' + estado;
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

   


 <?php } else {
    redirect('inicio');
  } ?>