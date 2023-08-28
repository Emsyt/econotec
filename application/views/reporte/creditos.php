<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:11/11/2021, Codigo: GAN-MS-A5-078,
Descripcion: Se Realizo el frontend del maquetado en su ultima version del branch de design
 */
?>
<?php if (in_array("smod_rep_vent_cred", $permisos)) { ?>
<style>
    .modalbody{
        padding:5%;
    }

    .div1 {
     overflow:auto;
     height:100px;

    }
    .div1 table {
        width:100%;
        background-color:lightgray;
    }

    
</style>
<script type="text/javascript">
  var f = new Date(); 
  fechap_inicial = f.getFullYear()+ "/" +(f.getMonth() +1)+ "/" +f.getDate();
  fechap_fin = f.getFullYear()+ "/" +(f.getMonth() +1)+ "/" +f.getDate();
  var id_cli ="-1";

  $(document).ready(function(){
    activarMenu('menu6',5);
    $('[name="fecha_inicial"]').val(fechap_inicial);
    $('[name="fecha_fin"]').val(fechap_fin);
    //$('[name="cli_trabajo"]').val(id_cli);
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
					<li class="active">Creditos</li>
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
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_creditos')"><img src="<?= base_url()?>assets/img/icoLogo/pdf.png"/></button>
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_creditos')"><img src="<?= base_url()?>assets/img/icoLogo/excel.png"/></button>                                   
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
                                    <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE VENTAS POR CREDITO </h5>
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
                                        <select class="form-control select2-list" id="cli_trabajo" name="cli_trabajo" required>
                                            <option value="">Todos los Clientes</option>
                                            <?php foreach ($cliente as $cli) {  ?>
                                            <option value="<?php echo $cli->id_personas ?>" <?php echo set_select('cli_trabajo', $cli->id_personas)?>> <?php echo $cli->cliente ?></option>
                                            <?php  } ?>
                                        </select>
                                        <label for="cli_trabajo">Cliente</label>
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
                                    <br>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                        <select class="form-control select2-list" id="cli_estado" name="cli_estado" required>
                                            <option value="">Todos los estados</option>
                                            <option value="PENDIENTE">PENDIENTE</option>
                                            <option value="PAGADO">PAGADO</option>
                                        </select>
                                        <label for="cli_estado">Estado</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" type="button">Generar Reporte</button><br><br>
                                        <div class="form-group" id="process" style="display:none;">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120">
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
                                        <th>Razon Social</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Pagado</th>
                                        <th>Saldo</th>
                                        <th>Estado</th>
                                        <th>Pagar</th>
                                        <th>Accion</th>
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

<!-- Modal Imprimir recibo-->
<div class="modal fade" id="historial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"style="">
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <h3 class="text-ultra-bold" style="color:#655e60;"><b>HISTORIAL</b></h3>
        </center>
      </div>
      <div id="modalbody" style="padding-left: 50px; padding-right: 50px; margin-top: 10px;">

      </div>
      <div id="modalfooter">
        
      </div>
    </div>
  </div>
</div>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on("click","#Buscar", function(e){
        cli_trabajo = document.getElementById("cli_trabajo");
        var selc_cli = cli_trabajo.options[cli_trabajo.selectedIndex].value;

        cli_estado = document.getElementById("cli_estado");
        var selc_cli_estado = cli_estado.options[cli_estado.selectedIndex].value;

        var selc_frep = document.getElementById("fecha_inicial").value;
        var selc_finrep = document.getElementById("fecha_fin").value;

        $.ajax({
            url:'<?= site_url() ?>lst_reporte_creditos',
            type:"post",
            datatype:"json",
            data:{
                selc_cli:selc_cli,
                selc_cli_estado:selc_cli_estado,
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
                        if (event.lengthComputable){
                            percent = Math.ceil(position / total * 100);
                        }      
                        //update progressbar
                        $(".progress-bar").css("width", + percent +"%");
                        if(percent>=100){
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
                            { "mData": "orazonsocial" },
                            { "mData": "ofecha" },
                            { "mData": "ototal" },
                            { "mData": "opagado" },
                            { "mData": "osaldo" },
                            { "mData": "oestado" },
                            {
                            "mRender": function(data, type, row, meta) {
                                if(row.oestado!="PAGADO"){
                                    var a = `
                                    <input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni${row.onro}" id="precio_uni${row.onro}" value="${row.osaldo}" onkeydown="onkeydown_pagar(this,${row.olote},\'${row.ousucre}\',${row.oidcliente})"  >
                                    `;
                                }else{
                                    var a = `
                                    <input type="number" style="border:0px solid #c7254e; width : 100px" min="0" name="precio_uni${row.onro}" id="precio_uni${row.onro}" value="${row.osaldo}" onkeydown="onkeydown_pagar(this,${row.olote},\'${row.ousucre}\',${row.oidcliente})"   disabled>
                                    `;
                                }
                                return a;
                            }
                            },
                            {
                            "mRender": function(data, type, row, meta) {
                                var a = `
                                    <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="historial_deuda(${row.olote},\'${row.ousucre}\',${row.oidcliente});" data-toggle="modal" data-target="#historial"><i class="fa fa-list"></i></button>
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
    });

    function onkeydown_pagar(msg, idlote, usucre, idcliente){
        var e = event || evt;
        var charCode = e.which || e.keyCode;
        if (charCode == 9 || charCode == 13) {
            
            $.ajax({
                url: "<?php echo site_url('reporte/C_reporte_creditos/pagar_deuda') ?>",
                type: "POST",
                data: {
                dato1: idlote,
                dato2: usucre,
                dato3: idcliente,
                dato4: msg.value
                },
                success: function(respuesta) {
                var js = JSON.parse(respuesta);
                $.each(js, function(i, item) {
                if (item.oboolean == 'f') {
                    Swal.fire({
                    icon: 'info',
                    text: item.omensaje,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                    });
                } 
                cli_trabajo = document.getElementById("cli_trabajo");
                var selc_cli = cli_trabajo.options[cli_trabajo.selectedIndex].value;

                cli_estado = document.getElementById("cli_estado");
                var selc_cli_estado = cli_estado.options[cli_estado.selectedIndex].value;

                var selc_frep = document.getElementById("fecha_inicial").value;
                var selc_finrep = document.getElementById("fecha_fin").value;

                $.ajax({
                    url:'<?= site_url() ?>lst_reporte_creditos',
                    type:"post",
                    datatype:"json",
                    data:{
                        selc_cli:selc_cli,
                        selc_cli_estado:selc_cli_estado,
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
                                if (event.lengthComputable){
                                    percent = Math.ceil(position / total * 100);
                                }      
                                //update progressbar
                                $(".progress-bar").css("width", + percent +"%");
                                if(percent>=100){
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
                                    { "mData": "orazonsocial" },
                                    { "mData": "ofecha" },
                                    { "mData": "ototal" },
                                    { "mData": "opagado" },
                                    { "mData": "osaldo" },
                                    { "mData": "oestado" },
                                    {
                                    "mRender": function(data, type, row, meta) {
                                        if(row.oestado!="PAGADO"){
                                            var a = `
                                            <input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni${row.onro}" id="precio_uni${row.onro}" value="${row.osaldo}" onkeydown="onkeydown_pagar(this,${row.olote},\'${row.ousucre}\',${row.oidcliente})"  >
                                            `;
                                        }else{
                                            var a = `
                                            <input type="number" style="border:0px solid #c7254e; width : 100px" min="0" name="precio_uni${row.onro}" id="precio_uni${row.onro}" value="${row.osaldo}" onkeydown="onkeydown_pagar(this,${row.olote},\'${row.ousucre}\',${row.oidcliente})"   disabled>
                                            `;
                                        }
                                        return a;
                                    }
                                    },
                                    {
                                    "mRender": function(data, type, row, meta) {
                                        var a = `
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="historial_deuda(${row.olote},\'${row.ousucre}\',${row.oidcliente});" data-toggle="modal" data-target="#historial"><i class="fa fa-list"></i></button>
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
            });
                
            },
                error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
            });
            
        }
    }

    function historial_deuda(idlote, usucre, idcliente){
        $.ajax({
            url: "<?php echo site_url('reporte/C_reporte_creditos/historial_deuda') ?>",
            type: "POST",
            data: {
            dato1: idlote,
            dato2: usucre,
            dato3: idcliente,
            },
            success: function(respuesta) {
            var js = JSON.parse(respuesta);
            let prod=js.productos;
            let histo=js.historial;
            modalbody.innerHTML = "";
            modalbody.innerHTML = modalbody.innerHTML +
            '<table>'+
            '<tr>' +
                '<td><b>Cliente: </b>' + js.cliente + '</td>' +
            '</tr>'+
            '<tr>' +
                '<td><b>Fecha: </b>' + js.fecha + '</td>' +
            '</tr>'+
            '<tr>' +
                '<td><b>Monto Total Adeudado: </b>' + js.total + '</td>' +
            '</tr>'+
            '<tr>' +
                '<td><b>Pagado hasta la fecha: </b>' + js.pagado + '</td>' +
            '</tr>'+
            '<tr>' +
                '<td><b>Saldo: </b>' + js.saldo + '</td>' +
            '</tr>'+
            '</table>'+
             '<p align="Center"><b>DETALLE</b></p>'+
            '<div class="div1">'+
            '<table id="producto_modal" style="width:100%" >'+
            '</table>'+
            '<table>'+
            '<tr>' +
                '<td width="400"><b>Total: </b></td>' +
                '<td width="100"><b>' + js.total + '</b></td>' +
            '</tr>'+
            '</table>'+
            '</div>'+
            '<p align="Center" style="margin-top: 10px; "><b>HISTORIAL</b></p>'+
            '<div class="div1">'+
            '<table id="historial_modal" style="width:100%">'+
            '</table>'+
            '</div>'
            
            producto_modal.innerHTML = '<tr>' +
                '<td width="400"><b>Producto</b></td>' +
                '<td width="100"><b>Precio</b></td>' +
                '</tr>'
            for (var i = 0; i < prod.length; i++) {
                producto_modal.innerHTML = producto_modal.innerHTML +
                '<tr>' +
                '<td width="400">' + prod[i].producto + '</td>' +
                '<td width="100">' + prod[i].precio + '</td>' +
                '</tr>'
            }

            historial_modal.innerHTML = '<tr>' +
                '<td><b>Fecha</b></td>' +
                '<td><b>Monto</b></td>' +
                '<td><b>Saldo</b></td>' +
                '</tr>'
            for (var i = 0; i < histo.length; i++) {
                historial_modal.innerHTML = historial_modal.innerHTML +
                '<tr>' +
                '<td>' + histo[i].fecha + '</td>' +
                '<td>' + histo[i].monto + '</td>' +
                '<td>' + histo[i].saldo + '</td>' +
                '</tr>'
            }  

            modalfooter.innerHTML = "";
            modalfooter.innerHTML = modalfooter.innerHTML +
            '<div style="text-align: center; margin:20px;">'+
            '<form class="form" name="historial_cliente" id="historial_cliente" method="post" action="<?= site_url() ?>pdf_reporte_historial">'+
              '<input type="hidden" name="id_lote" value="'+idlote+'">'+
              '<input type="hidden" name="usucre" value="'+usucre+'">'+
              '<input type="hidden" name="idcliente" value="'+idcliente+'">'+
              '<button type="submit" class="btn ink-reaction btn-raised btn-primary" title="PDF" formtarget="_blank">Imprimir Historial</button>'+
            '</form>'+
            '</div>'
        },
            error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
        }
        });
    }
</script>


<?php } else {redirect('inicio');}?>
