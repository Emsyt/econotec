<?php
/* 
------------------------------------------------------------------------------------------
Creador: Kevin Gerardo Alcon Lazarte Fecha:28/03/2023, Codigo:GAN-DPR-M1-0373 ,
Creacion:Se creo la vista listar_abastecimiento
----------------------------------------------------------------------------------------

 */

?>

<?php if (in_array("smod_abastecimiento", $permisos)) { ?>
    <script type="text/javascript">
    var f = new Date();
    fechap_inicial = f.getFullYear()+ "/" +(f.getMonth() +1)+ "/" +f.getDate();
    fechap_fin = f.getFullYear()+ "/" +(f.getMonth() +1)+ "/" +f.getDate();
    var id_ubi ="6";

    $(document).ready(function(){
    activarMenu('menu9',8);
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
					<li><a href="#">Provicion</a></li>
					<li class="active">Listado Compras</li>
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
                                </div>
                            </div>
                                
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-right">
                                    <img style="height: 65px;" src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes); print($obj->{'logo'});?>" >
                                    </div>

                                    <div class="col-xs-9 col-sm-9 col-md-7 col-lg-7 text-center"> 
                                    <h5 class="text-ultra-bold" style="color:#655e60;"> EMPRESA <?php $obj = json_decode($titulo->fn_mostrar_ajustes); print_r($obj->{'titulo'});?> </h5>
                                    <h5 class="text-ultra-bold" style="color:#655e60;"> LISTADO DE COMPRAS</h5>
                                    </div>

                                    <div class="col-xs-9 col-sm-9 col-md-3 col-lg-3">
                                    <h6 class="text-ultra-bold text-default-light">Usuario:<?php echo $usuario; ?></h6>
                                    <h6 class="text-ultra-bold text-default-light">Fecha: <?php echo $fecha_imp; ?></h6>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="text-align: center;">
                                    <br>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                        <h5  for="ubi_trabajo">Seleccione una fecha</h5>
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
                                        <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" onclick="buscar_abastecimiento()" type="button">Generar Listado</button><br><br>

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
                                    <!-- <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div> -->
                                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1">
                                    <div class="table-responsive">
                                <table id="datatable3" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="10%">N&deg;</th>
                                        <th width="15%">Id_lote</th>
                                        <th width="15%">Cantidad</th>
                                        <!--<th width="12%">Producto</th>
                                        <th width="12%">Destino</th>
                                        <th width="5%">Cantidad</th>
                                        <th width="10%">Unidad</th> -->
                                        <th width="15%">Fecha</th>
                                        <!-- <th width="10%">Precio Venta</th>
                                        <th width="10%">Fecha</th> -->
                                        <!-- <th width="10%">Estado</th> -->
                                        <th width="20%">Acción</th>
                                    </tr>
                                    </thead>
                                    </table>
                                    </div>
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
<!-- MODAL -->
    <div class="modal fade" name="modal_compra" id="modal_compra" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form" role="form" name="form_editar" id="form_editar" method="post" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="formModalLabel">Lista de compras</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive" style="margin:10px; overflow-y: scroll;">
                                <table id="datatable_compra" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <!-- <th width="5%">N&deg;</th> -->
                                            <th width="10%">Lote</th>
                                            <th width="15%">Producto</th>
                                            <th width="10%">Destino</th>
                                            <th width="10%">Cantidad</th>
                                            <th width="10%">Unidad</th>
                                            <th width="10%">Precio de compra</th>
                                            <th width="10%">Precio de venta</th>
                                            <th width="15%">Fecha</th>
                                            <th width="10%">Estado</th>                                           
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div><br> </div>
                    </div>
                </div>

                <div class="modal-footer">
                    
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function buscar_abastecimiento(){
            // cod_ubicacion = document.getElementById("ubi_trabajo");
            // var selc_ubi = cod_ubicacion.options[cod_ubicacion.selectedIndex].value;
            var selc_frep = document.getElementById("fecha_inicial").value;
            var selc_finrep = document.getElementById("fecha_fin").value;

            $.ajax({
                url:'<?= site_url() ?>provision/C_listar_abastecimiento/lst_reporte_abastecimiento',
                type:"post",
                datatype:"json",
                data:{
                    // selc_ubi,selc_ubi,
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
                            "order": [[ 0, 'asc' ]],
                            "aoColumns": [
                                // { "mData": "oidabastecimiento" },
                                { "mData": "onro" },
                                { "mData": "olote" },
                                { "mData": "ocantidad" }, 
                                { "mData": "ofecha" },
                                // { "mData": "oproducto" },
                                // { "mData": "odestino" },
                                // { "mData": "ocantidad" },
                                // { "mData": "ounidad" },
                                // { "mData": "opreciocompra" },
                                // { "mData": "oprecioventa" },
                                // { "mData": "ofecha" },
                                // { "mData": "oestado",render: function (data, type, row) 
                                // {
                                //     if(data=="PAGADO")
                                //     {
                                //         return '<p style="color:green;">'+data+'</p>';

                                //     }
                                //     else
                                //     {
                                //         return '<p style="color:red;">'+data+'</p>';
                                //     }
                                // }
                                // },
                                // {
                                // "mRender": function(data, type, row, meta) {
                                //     var a = `
                                //         <button type="button" title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger " onclick="eliminar_abastecimiento(\'${row.oidabastecimiento}\');"><i class="fa fa-trash-o"></i></button>
                                //     `;
                                //     return a;
                                // }
                                // },
                                // //
                                // {
                                // "mRender": function(data, type, row, meta) {
                                //     var b = `
                                //         <button type="button" title="Editar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="editar_abastecimiento(\'${row.oidabastecimiento}\');"><i class="fa fa-pencil"></i></button>
                                //     `;
                                //     return b;
                                // }
                                // },
                                // // <button type="button" title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_abastecimiento(\'${row.oidabastecimiento}\');"><i class="fa fa-trash-o"></i></button>
                                {
                                "mRender": function(data, type, row, meta) {
                                var actions = `
                                <div class="btn-group">
                                <button type="button" title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_abastecimiento(\'${row.oidlote}\');"><i class="fa fa-trash-o"></i></button>
                                <button type="button" title="Editar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="editar_abastecimiento(\'${row.oidlote}\');"><i class="fa fa-pencil"></i></button>
                                <button type="button" title="Historial" class="btn ink-reaction btn-floating-action btn-xs  btn-primary" onclick="Historial(\'${row.oidlote}\');"><i class="fa fa-list"></i></button>
                                </div>
                                `;
                                // <button type="button" title="Añadir" class="btn ink-reaction btn-floating-action btn-xs  btn-warning" onclick="Añadir_lote(\'${row.oidlote}\');"><i class="fa fa-plus"></i></button>
                                return actions;
                                }
                                },
                            ],
                            "dom": 'C<"clear">lfrtip',
                            "colVis": {
                            "buttonText": "Columnas"
                            } 
                        });
                        
                    }
                    console.log(data);
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
                text: "¿Está seguro de eliminar todo el abastecimiento(lote)?, asegurese que los productos no se han puesto a la venta.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('provision/C_listar_abastecimiento/eliminar_abast') ?>",
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

        function editar_abastecimiento(id_lote){
        var contador;
        var veri= false;
        $.ajax({
                type: "POST",
                url: "<?php echo site_url('provision/C_listar_abastecimiento/get_solicitud') ?>",
                dataType: "json",
                success: function(respuesta) {
                    var contador = respuesta[0].ocontador;
                    if (contador == 1) {
                        Swal.fire({
                                    icon: 'warning',
                                    title: "¿Quiere editar este lote? ,se le redireccionara a compras",
                                    showDenyButton: true,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                    denyButtonText: 'CANCELAR',
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                    $.ajax({
                                    url: "<?php echo site_url('provision/C_listar_abastecimiento/editar_abastecimiento_lotes') ?>",
                                    type: "POST",
                                    data: {
                                    dato1: id_lote,
                                    },
                                    success: function(respuesta) {
                                    console.log(respuesta);
                                    location.href = "<?php echo base_url(); ?>provision";
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                    alert('Error al obtener datos de ajax');
                                    }
                                    });
                                    }
                                    });
                                    console.log("No hay solicitudes para este usuario");
                    } else if (contador == 2) {
                                    Swal.fire({
                                    icon: 'warning',
                                    title: "EN ESTE MOMENTO SE TIENE UNA COMPRA PENDIENTE, POR FAVOR FINALICE LA COMPRA, PARA EDITAR OTRO LOTE",
                                    showDenyButton: true,
                                    confirmButtonColor: '#3085d6',
                                    });
                            }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
        });
        }

        function mostrarAlerta(mensaje) {
        var alerta = document.createElement("div");
        alerta.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Oops!</strong> ' + mensaje + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        document.body.appendChild(alerta);
        }

        function Historial(id_lote){
            $('#modal_compra').modal('show');
            console.log(id_lote);
            $.ajax({
                url: "<?php echo site_url('provision/C_listar_abastecimiento/historial_compra') ?>",
                type: "POST",
                data: {
                    dato1: id_lote,
                },
                success: function(respuesta) {
                    console.log(respuesta);
                    var js = JSON.parse(respuesta);
                    $('#datatable_compra').DataTable({
                    "data": js,
                    "responsive": true,
                    "language": {
                        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                    },
                    "destroy": true,
                    "columnDefs": [{
                        "searchable": true,
                        "orderable": false,
                        "targets": 0
                    }],

                    "aoColumns": [{
                            "mData": "oidlote"
                        },
                        {
                            "mData": "oproducto"
                        },
                        {
                            "mData": "odestino"
                        },
                        {
                            "mData": "ocantidad"
                        },
                        {
                            "mData": "ounidad"
                        },
                        {
                            "mData": "opreciocompra"
                        },
                        {
                            "mData": "oprecioventa"
                        },
                        {
                            "mData": "ofecha"
                        },
                        {
                            "mData": "oestado"
                        },
                    ],
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Columnas"
                    },
                });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        
        }

        function getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        
        document.cookie = "id_listar_lote";
        // function Añadir_lote(id_lote){
        // document.cookie = "id_listar_lote=" + id_lote;
        // var edit_listar_lote = getCookie("id_listar_lote");
        // console.log("se esta guardando este lote :"+edit_listar_lote);
        // Swal.fire({
        // icon: 'warning',
        // title: "¿Quiere añadir una compra a este lote? ,se le redireccionara a compras",
        // showDenyButton: true,
        // confirmButtonColor: '#3085d6',
        // confirmButtonText: 'ACEPTAR',
        // denyButtonText: 'CANCELAR',
        // }).then((result) => {
        //     if (result.isConfirmed) {
                
        //         $.ajax({
        //         url: "<?php echo site_url('provision/C_listar_abastecimiento/editar_abastecimiento_lotes') ?>",
        //         type: "POST",
        //         data: {
        //             dato1: id_lote,
        //         },
        //         success: function(respuesta) {
        //             console.log(respuesta);
        //         location.href = "<?php echo base_url(); ?>provision";
        //         },
        //         error: function(jqXHR, textStatus, errorThrown) {
        //             alert('Error al obtener datos de ajax');
        //         }
        //     });
        //     }

        // });
        // } 
        
    </script>

<?php } else {redirect('inicio');}?>
