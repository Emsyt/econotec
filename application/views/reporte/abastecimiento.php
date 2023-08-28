<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:07/09/2021, Codigo: GAN-MS-M5-025,
Descripcion: Se Realizo el frontend del maquetado V9.0 del branch de design de las paginas 73
----------------------------------------------------------------------------------------
Modificado: Jose Daniel Luna Flores  Fecha: 28/11/2022 Codigo:GAN-MS-M6-0140
Descripcion: Se modifico la interfaz para retorne el nuevo campo id_lote en la tabla de reporte y en la generación de excel y pdf      
----------------------------------------------------------------------------------------
Modificado: Gary German Valverde  Fecha: 30/06/2023 Codigo:GAN-MS-A6-0528
Descripcion: Se modifico la interfaz para mostrar el proveedor +  
 */
?>

<?php if (in_array("smod_rep_abast", $permisos)) { ?>
<script type="text/javascript">
  var f = new Date();
  fechap_inicial = f.getFullYear()+ "/" +(f.getMonth() +1)+ "/" +f.getDate();
  fechap_fin = f.getFullYear()+ "/" +(f.getMonth() +1)+ "/" +f.getDate();
  var id_ubi ="6";

  $(document).ready(function(){
    activarMenu('menu6',3);
    $('[name="fecha_inicial"]').val(fechap_inicial);
    $('[name="fecha_fin"]').val(fechap_fin);
    $('[name="ubi_trabajo"]').val(id_ubi);
    buscar_abastecimiento();

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
					<li class="active">Compras</li>
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
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_abastecimiento')"><img src="<?= base_url()?>assets/img/icoLogo/pdf.png"/></button>
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_abastecimiento')"><img src="<?= base_url()?>assets/img/icoLogo/excel.png"/></button>
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
                                    <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE COMPRAS </h5>
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
                                            <option value="<?php echo $ubi->oidubicacion ?>" <?php echo set_select('ubi_trabajo', $ubi->oidubicacion)?>> <?php echo $ubi->oubicacion ?></option>
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
                                        <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" onclick="buscar_abastecimiento()" type="button">Generar Reporte</button><br><br>

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
                                        <th width="5%">N&deg;</th>
                                        <th width="5%">Nro Lote</th>
                                        <th width="10%">Producto</th>
                                        <th width="10%">Proveedor</th> <!--  G.Valverde GAN-MS-A6-0528 -->
                                        <th width="10%">Destino</th>
                                        <th width="5%">Cantidad</th>
                                        <th width="7%">Unidad</th>
                                        <th width="8%">Precio Compra</th>
                                        <th width="8%">Precio Venta</th>
                                        <th width="8%">Fecha</th>
                                        <th width="8%">Estado</th>
                                        <th width="5%">Acción</th>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function buscar_abastecimiento(){
            cod_ubicacion = document.getElementById("ubi_trabajo");
            var selc_ubi = cod_ubicacion.options[cod_ubicacion.selectedIndex].value;
            var selc_frep = document.getElementById("fecha_inicial").value;
            var selc_finrep = document.getElementById("fecha_fin").value;

            $.ajax({
                url:'<?= site_url() ?>lst_reporte_abastecimiento',
                type:"post",
                datatype:"json",
                data:{
                    selc_ubi,selc_ubi,
                    selc_frep:selc_frep,
                    selc_finrep,selc_finrep
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
  var delayInMilliseconds = 200;

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
                        var t=$('#datatable3').DataTable({
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
                                { "mData": "oidabastecimiento" },
                                //INICIO J.LUNA, 28/11/2022, GAN-MS-M6-0140//
                                { "mData": "oidlote" },
                                //FIN J.LUNA, 28/11/2022, GAN-MS-M6-0140//
                                { "mData": "oproducto" },
                                { "mData": "oprovedor" }, // G.Valverde GAN-MS-A6-0528
                                { "mData": "odestino" },
                                { "mData": "ocantidad" },
                                { "mData": "ounidad" },
                                { "mData": "opreciocompra" },
                                { "mData": "oprecioventa" },
                                { "mData": "ofecha" },
                                { "mData": "oestado",render: function (data, type, row) 
                                {
                                    if(data=="PAGADO")
                                    {
                                        return '<p style="color:green;">'+data+'</p>';

                                    }
                                    else
                                    {
                                        return '<p style="color:red;">'+data+'</p>';
                                    }
                                }
                                },
                                {
                                "mRender": function(data, type, row, meta) {
                                    var a = `
                                        <button type="button" title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger " onclick="eliminar_abastecimiento(\'${row.oidabastecimiento}\');"><i class="fa fa-trash-o"></i></button>
                                    `;
                                    return a;
                                }
                                },
                                
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
        };
 
    </script>
    <script>
        function eliminar_abastecimiento(id){
            Swal.fire({
                text: "¿Está seguro de eliminar el abastecimiento?, asegurese que los productos no se han puesto a la venta.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('reporte/C_reporte_abastecimiento/eliminar_abast') ?>",
                        type: "POST",
                        data: {
                        dato1: id,
                        },
                        success: function(respuesta) {
                            var js = JSON.parse(respuesta);
                            $.each(js, function(i, item) {
                                if(item.oboolean == "f"){
                                    Swal.fire({
                                    icon: 'error',
                                    text: item.omensaje,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                    }).then((result) => {
                                        buscar_abastecimiento();
                                    })
                                
                                }else{
                                    Swal.fire({
                                    icon: 'success',
                                    text: item.omensaje,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                    }).then((result) => {
                                        buscar_abastecimiento();
                                    })
                                }
                        });
                    },
                        error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax');
                    }
                    });
                }
            })
        }
    </script>

<?php } else {redirect('inicio');}?>
