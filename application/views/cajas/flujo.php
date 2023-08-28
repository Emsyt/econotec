<?php
/* 
  ---------------------------------------------------------------------------------------------
  Modificado:  Noemi Rosio Vera Velasquez Fecha:24/07/2023, Codigo: GAN-MS-B0-0553
  Descripcion: Se comenta el script bootstrap.min.js, para que se pueda activar las funciones de perfil y notificaciones
  */

?>

<script>
   $(document).ready(function() {
      activarMenu('menu15_2');
   })
</script>

<style>
   hr {
      margin-top: 0px;
   }
</style>

<script src="<?= base_url(); ?>assets/libs/leaflet/leaflet.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<!-- //GAN-MS-B0-0553 24/07/2023 NVera. -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script> -->
<!-- //Fin GAN-MS-B0-0553 24/07/2023 NVera. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>

<!-- BEGIN CONTENT-->
<div id="content">
   <section>
      <div class="section-header">
         <ol class="breadcrumb">
            <li><a href="#">Cajas</a></li>
            <li class="active">Flujo</li>
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
               <h3 class="text-primary">Listado de flujo
               </h3>
               <h3 class="text-primary">
                  <button type="button" class="btn btn-success ink-reaction btn-sm pull-left" onclick="formulario('ingreso')"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Ingreso Extra </button>
                  <button type="button" class="btn btn-danger ink-reaction btn-sm pull-right" onclick="formulario('gasto')"><span class="pull-left"><i class="fa fa-minus"></i></span> &nbsp; Gasto Extra </button>
               </h3>
               <br> <br>
               <hr>
            </div>
         </div>

         <div class="row" style="display: none;" id="form_registro">
            <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
               <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
               <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                     <form class="form form-validate" novalidate="novalidate" name="form_flujo" id="form_flujo" method="post">
                        <input type="hidden" name="id_flujo" id="tipo_flujo" value="0">

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
                                       <div class="col-xs-6 col-sm-5 col-md-3 col-lg-3" style="display: flex;">
                                          <div class="form-group floating-label" id="c_monto">
                                             <input type="number" class="form-control" name="id_monto" id="id_monto" min="0" onchange="validarprecio()" step=".01">
                                             <label for="id_monto">Monto en Bs</label>
                                             <div id="valormonto" style="color: #FA5600"></div>
                                          </div>
                                          <div>
                                             <h3>Bs</h3>
                                          </div>
                                       </div>
                                       <div class="col-sm-5">
                                          <div class="form-group floating-label" id="c_descripcion">
                                             <textarea class="form-control" name="descripcion" id="id_descripcion" rows="1" style="resize: none;"></textarea>
                                             <label for="descripcion">Descripcion</label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                 <center>
                                    <table style="width: 0%; height: 0px; border: 0px solid #eb0038; margin-bottom: 5px;">
                                       <tr>
                                          <td><output id="list"></output></td>
                                       </tr>
                                    </table>
                                 </center>
                              </div>
                           </div>
                        </div>

                        <div class="card-actionbar">
                           <div class="card-actionbar-row">
                              <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="registrar()" name="btn" id="btn_add" value="add">Registrar flujo</button>
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
                              <th>Fecha</th>
                              <th>Descripcion</th>
                              <th>Entrada</th>
                              <th>Salida</th>
                              <th>Saldo actual</th>
                           </tr>
                        </thead>
                        <?php $nro = 1 ?>
                        <?php $saldo = 0 ?>
                        <?php foreach ($items as $item) : ?>
                           <?php $saldo = $saldo + $item->entrada ?>
                           <?php $saldo = $saldo - $item->salida ?>
                           <tbody>
                              <tr>
                                 <td><?= $nro ?></td>
                                 <td><?= $item->fecha ?></td>
                                 <td><?= $item->descripcion ?></td>
                                 <?php
                                    if($nro==1){
                                       echo "<td style='background-color: rgb(102, 255, 153);'>".$item->entrada." Bs.</td>";
                                    }else{
                                       echo "<td>".$item->entrada." Bs.</td>";
                                    }
                                 ?>
                                 <td><?= $item->salida." Bs." ?> </td>
                                 <?php
                                  if(count($items)==$nro)
                                    {
                                       echo "<td style='background-color: rgb(252, 98, 122);'>".$saldo." Bs.</td>";

                                    }else{
                                       echo "<td>".$saldo." Bs.</td>";
                                    }
                                 ?>
                                 
                              </tr>
                           </tbody>
                           <?php $nro++; ?>
                        <?php endforeach; ?>
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
   function formulario(tipo) {
      if ('ingreso' == tipo) {
         $('#btn_edit').attr("disabled", true);
         $('#btn_add').attr("disabled", false);
         $("#titulo").text("Registrar Ingreso");
         $('#form_flujo')[0].reset();
         document.getElementById("list").innerHTML = '';
         document.getElementById("form_registro").style.display = "block";
         document.getElementById("btn_update").style.display = "block";

         $('#tipo_flujo').val(1);
      } else {
         $('#btn_edit').attr("disabled", true);
         $('#btn_add').attr("disabled", false);
         $("#titulo").text("Registrar Gasto");
         $('#form_flujo')[0].reset();
         document.getElementById("list").innerHTML = '';
         document.getElementById("form_registro").style.display = "block";
         document.getElementById("btn_update").style.display = "block";
         $('#tipo_flujo').val(-1);
      }
   }

   function validarprecio() {
      monto = document.getElementById("id_monto").value;

      if (monto < 0) {

         var mensaje = 'El monto no debe ser menor a 0';
         $("#valormonto").html(mensaje);

      } else {

         $("#valormonto").html('');
      }
   }

   function cerrar_formulario() {
      document.getElementById("form_registro").style.display = "none";
      $('#form_flujo')[0].reset();
      document.getElementById("list").innerHTML = '';
   }

   function update_formulario() {
      $('#form_flujo')[0].reset();
      document.getElementById("list").innerHTML = '';
      $('#btn_edit').attr("disabled", true);
      $('#btn_add').attr("disabled", false);
   }

   function registrar() {
      descripcion = document.getElementById("id_descripcion").value;
      monto = document.getElementById("id_monto").value;
      tipo = document.getElementById("tipo_flujo").value;

      if (descripcion != "" && monto != "") {
         const dataToSend = {
            tipo: tipo,
            monto: monto,
            descripcion: descripcion,
         };
         $.ajax({
            url: "<?php echo site_url('cajas/C_flujo/registrar') ?>",
            type: "POST",
            datatype: "json",
            data: dataToSend,
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
                              "<?php echo base_url(); ?>flujo";
                        } else {}
                     })
                     location.href = "<?php echo base_url(); ?>flujo";
                  }
               })
            },
            error: function(jqXHR, textStatus, errorThrown) {
               alert('Error al obtener datos de ajax2');
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
   }
</script>