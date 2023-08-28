<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha:22/11/2022   SAM-MS-A7-0002,
Descripcion: Se Realizo la view de listado bitacora activos
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Melani Alisson Cusi Burgoa Fecha:24/11/2022  SAM-MS-A7-0005,
Descripcion: Se creo la funcion para general EXCEL Y PDF
*/
?>
<?php if (in_array("smod_list_act", $permisos)) { ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/jquery-ui.css">
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            activarMenu('menu14', 2);
            // GAN-MS-M0-0349 Flavio Abdon
            var codigo = [];
            $.ajax({
                url: "<?php echo site_url('activos/C_listado/lts_codigos_bitacora') ?>",
                type: "POST",
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    console.log(json)
                    codigo = Object.values(json);
                    const items = codigo.map(function(codigo) {
                        return codigo.ocodigobitacora;
                    });
                    $("#cod_prod").autocomplete({
                        source: items
                    });
                }
            });
            // Fin GAN-MS-M0-0349
        });
    </script>

    <script>
        function enviar(destino) {
            var codigo_producto = document.getElementById('cod_prod').value;
            console.log(codigo_producto);
            if(codigo_producto != ""){
                console.log(destino);
                document.form_busqueda.action = destino;
                document.form_busqueda.target = '_blank';
                document.form_busqueda.submit();
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: "Por favor ingrese un código",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                })
            }
            
        }
    </script>

    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Activos</a></li>
                    <li class="active">Listado</li>
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

                    });
                </script>
            <?php } else if ($this->session->flashdata('error')) { ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            icon: 'error',
                            text: "<?php echo $this->session->flashdata('error'); ?>",
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ERROR'
                        })

                    });
                </script>
            <?php } ?>
            <div class="section-body" id="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-10  col-md-offset-2 col-lg-8 col-lg-offset-2">
                        <form class="form" onsubmit="return false;" name="form_busqueda" id="form_busqueda" method="post">
                            <div class="form card">
                                <div class="card-head style-primary">
                                    <header>Busqueda por C&oacute;digo de un Producto </header>
                                    <div class="tools">
                                        <div class="btn-group">
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-default-light" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>listado_pdf')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                            <button type="button" class="btn ink-reaction btn-floating-action btn-default-light" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>listado_excel')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group floating-label col-xs-12 col-sm-10 col-md-9 col-lg-9">
                                            <input type="text" class="form-control" name="cod_prod" id="cod_prod">
                                            <label for="cod_prod">Buscar por C&oacute;digo</label>
                                    </div>
                                    <div class="form-group floating-label col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                        <button type="button" class="btn btn-primary" onclick="habilitar_tabla()"><i class="fa fa-search"></i> BUSCAR</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row" id="listado">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-divider visible-xs"><span>Listado de Ventas</span></div>
                    <div class="card card-bordered style-primary">
                        <div class="card-body style-default-bright">
                            <div id="tabla">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="5%">Nª</th>
                                                <th width="19%">Usuario</th>
                                                <th width="19%">Fecha Asignación</th>
                                                <th width="19%">Fecha Devolución</th>
                                                <!-- <th width="10%">Km Inicio</th>
                                                <th width="10%">Km Final</th>
                                                <th width="10%">Km Recorrido</th> -->
                                                <th width="19%">Motivo</th>
                                                <!-- <th width="10%">Destino</th> -->
                                                <!-- <th width="5%">Gasolina</th> -->
                                                <th width="19%">Estado</th>
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
    <!--  Datatables JS-->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- SUM()  Datatables-->
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>

    <script>

        function habilitar_tabla() {            
            var codigo_producto = document.getElementById('cod_prod').value;
            console.log(codigo_producto);
            if(codigo_producto != ""){
                document.getElementById("tabla").innerHTML = '';
                document.getElementById("tabla").innerHTML = '<div class="table-responsive">' +
                    '<table id="datatable" class="table table-bordered table-hover">' +
                    '<thead>' +
                    '<tr>'+
                        '<th width="5%">Nª</th>'+
                        '<th width="15%">Usuario</th>'+
                        '<th width="10%">Fecha Asignación</th>'+
                        '<th width="10%">Fecha devolución</th>'+
                        // '<th width="10%">Km Inicio</th>'+
                        // '<th width="10%">Km Final</th>'+
                        // '<th width="10%">Km Recorrido</th>'+
                        '<th width="15%">Motivo</th>'+
                        // '<th width="10%">Destino</th>'+
                        // '<th width="5%">Gasolina</th>'+
                        '<th width="15%">Estado</th>'+
                    '</tr>'+

                    '</thead>' +
                    '</table>' +
                    ' </div>';

                $.ajax({
                    url: "<?php echo site_url('activos/C_listado/mostrar_listado_producto_cod') ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        codigo_producto: codigo_producto
                    },
                    success: function(data) {
                        data2 = data[0];
                        if(data2 != null && data2 != ""){
                            
                            var t = $('#datatable').DataTable({
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
                            "order": [
                                [1, 'dec']
                            ],
                            "aoColumns": [{
                                    "mData": "onum"
                                },
                                {
                                    "mData": "ousuario"
                                },
                                {
                                    "mData": "ofecha_salida"
                                },
                                {
                                    "mData": "ofecha_regreso"
                                },
                                {
                                    "mData": "omotivo"
                                },
                                {
                                    "mData": "oestado"
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
                        }
                        else{
                            Swal.fire({
                                icon: 'error',
                                title: "No existen datos con el código ingresado!",
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ACEPTAR',
                            })
                        }
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });

            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: "Por favor ingrese un código",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                })
            }
            
        }
    </script>

<?php } else {
    redirect('inicio');
} ?>