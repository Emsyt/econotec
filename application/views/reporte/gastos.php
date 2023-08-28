<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:07/09/2021, Codigo: GAN-MS-A3-026,
Descripcion: Se Realizo el frontend del maquetado V9.0 del branch de design de las paginas 79
 */
?>
<?php if (in_array("smod_rep_gast", $permisos)) { ?>

<script type="text/javascript">
  var f = new Date(); 
  fechap_inicial = f.getFullYear()+ "/" +(f.getMonth() +1)+ "/" +f.getDate();
  fechap_fin = f.getFullYear()+ "/" +(f.getMonth() +1)+ "/" +f.getDate();
  var id_ubi ="PAGADO";

  $(document).ready(function(){
    activarMenu('menu6',4);
    $('[name="fecha_inicial"]').val(fechap_inicial);
    $('[name="fecha_fin"]').val(fechap_fin);
    $('[name="ubi_trabajo"]').val(id_ubi);
  });
</script>

<script>
  function enviar(destino){
    document.form_busqueda.action= destino;
    document.form_busqueda.submit();
  }
</script>

	<!-- BEGIN CONTENT-->
	<div id="content">
		<section>
			<div class="section-header">
				<ol class="breadcrumb">
					<li><a href="#">Reportes</a></li>
					<li class="active">Gastos</li>
				</ol>
			</div>

            <?php if ($this->session->flashdata('success')) { ?>
                <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('success'); ?>","success"); } </script>
            <?php } else if($this->session->flashdata('error')){ ?>
                <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('error'); ?>","error"); } </script>
            <?php } ?>

			<div class="section-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <form class="form" name="form_busqueda" id="form_busqueda" method="post" target="_blank">
                            <div class="card">
                            <div class="card-head style-default-light" style="padding: 10px">
                                <div class="tools">
                                <div class="btn-group">
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_gastos')"><img src="<?= base_url()?>assets/img/icoLogo/pdf.png"/></button>
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_gastos')"><img src="<?= base_url()?>assets/img/icoLogo/excel.png"/></button>                                   
                                </div>
                                </div>
                            </div>
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-right">
                                    <img style="height: 65px;" src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes); print($obj->{'logo'});?>" >
                                    </div>

                                    <div class="col-xs-9 col-sm-9 col-md-7 col-lg-7 text-center"> 
                                    <h5 class="text-ultra-bold" style="color:#655e60;"> EMPRESA <?php $obj = json_decode($titulo->fn_mostrar_ajustes); print_r($obj->{'titulo'});?> </h5>
                                    <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE GASTOS </h5>
                                    </div>

                                    <div class="col-xs-9 col-sm-9 col-md-3 col-lg-3">
                                    <h6 class="text-ultra-bold text-default-light">Usuario: <?php echo $usuario; ?></h6>
                                    <h6 class="text-ultra-bold text-default-light">Fecha: <?php echo $fecha_imp; ?></h6>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="text-align: center;">
                                    <br>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                        <select class="form-control select2-list" id="ubi_trabajo" name="ubi_trabajo" required>
                                            <option value=""></option>
                                            <?php foreach ($ubicaciones as $ubi) {  ?>
                                            <option value="<?php echo $ubi->oestado ?>" <?php echo set_select('ubi_trabajo', $ubi->oestado)?>> <?php echo $ubi->oestado ?></option>
                                            <?php  } ?>
                                        </select>
                                        <label for="ubi_trabajo">Ubicaci&oacute;n de Trabajo</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                        <div class="form-group">
                                            <div class="input-group date" id="demo-date">
                                            <div class="input-group-content">
                                                <input type="text" class="form-control" name="fecha_inicial" id="fecha_inicial" readonly="" required>
                                                <label for="fecha_inicial">Fecha Inicial</label>
                                            </div>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <br>  
                                        <p>AL</p>
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                        <div class="form-group">
                                            <div class="input-group date" id="demo-date-val">
                                            <div class="input-group-content">
                                                <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" readonly="" required>
                                                <label for="fecha_fin">Fecha Final</label>
                                            </div>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" type="button">Generar Reporte</button><br><br>
                                        <div class="form-group" id="process" style="display:none;">
              <div class="progress">
                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120" style="">
               </div>
               
              </div>
              <div class="status"></div>
           </div>
       <br>
                                    </div>

                                    </div>

                                </div>
                                <div class="table-responsive">
                                <table id="datatable3" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>N&deg;</th>
                                        <th>Detalle</th>
                                        <th>Monto Total</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                </table>
                                </div>
                                <div><br> </div>
                            </div>
                        </form>
 
                        
                    </div>
                </div>
			</div>
		</section>
	</div>
	<!-- END CONTENT -->

    <script>
        $(document).on("click","#Buscar", function(e){
            cod_ubicacion = document.getElementById("ubi_trabajo");
            var selc_ubi = cod_ubicacion.options[cod_ubicacion.selectedIndex].value;
            var selc_frep = document.getElementById("fecha_inicial").value;
            var selc_finrep = document.getElementById("fecha_fin").value;

            $.ajax({
                url:'<?= site_url() ?>lst_reporte_gastos',
                type:"post",
                datatype:"json",
                data:{
                    selc_ubi:selc_ubi,
                    selc_frep:selc_frep,
                    selc_finrep:selc_finrep
                },
                xhr: function(){
  var xhr = $.ajaxSettings.xhr();
  if (xhr.upload) {
  xhr.upload.addEventListener('progress', function(event) {
var percent = 0;
var position = event.loaded || event.position;
var total = event.total;
if (event.lengthComputable)
{
percent = Math.ceil(position / total * 100);
}
//update progressbar
$(".progress-bar").css("width", + percent +"%");
if(percent>=100)
{
  var delayInMilliseconds = 230;

setTimeout(function() {
  $('#process').css('display', 'none');
    $('.progress-bar').css('width', '0%');
    percent==0;
}, delayInMilliseconds);
}

}, true);
}
return xhr;
},
                beforeSend:function()
         {
          $('#process').css('display', 'block');
         },
                    success: function(data){

                    var data = JSON.parse(data);
                    if(data.responce == "success"){
                        var t = $('#datatable3').DataTable({
                            "data": data.posts,
                            "responsive": true,
                            "language": {
                            "url": "<?= base_url()?>assets/plugins/datatables_es/es-ar.json"
                            },
                            "destroy": true,
                            "columnDefs": [ {
                                "searchable": false,
                                "orderable": false,
                                "targets": 0
                            } ],
                            "order": [[ 1, 'asc' ]],
                            "aoColumns": [
                                { "mData": "onro" },
                                { "mData": "odetalle" },
                                { "mData": "omonto_total" },
                                { "mData": "ofecha" },
                                { "mData": "oestado" },
                                
                            ],
                            "dom": 'C<"clear">lfrtip',
                            "colVis": {
                              "buttonText": "Columnas"
                            }
                        });
                        t.on( 'order.dt search.dt', function () {
                            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                                cell.innerHTML = i+1;
                            } );
                        } ).draw();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
                }
            });
        
        


 });
        
    </script>


<?php } else {redirect('inicio');}?>
