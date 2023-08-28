<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: Adamary Margel Uchani Mamani Fecha: 22/11/2022, Codigo: SAM-MS-A7-0001,
Descripcion: Creacion del Controlador View de registro de activos
-------------------------------------------------------------------------------------------------------------------------------
Creador: Adamary Margel Uchani Mamani Fecha: 24/11/2022, Codigo: SAM-MS-A7-0007,
Descripcion: Creacion de registros y la funcion del  AVM de activos
-------------------------------------------------------------------------------------------------------------------------------
Creador: Flavio Abdon Condori Vela Fecha: 10/2/2023, Codigo: GAN-MS-B0-0261,
Descripcion: Se modifico la fecha de asignacion por defecto por la fecha del dia de hoy,
y al momento de editar desaparece el formulario de buscar, y se debe recupera el valor del usuario para la edicion
-------------------------------------------------------------------------------------------------------------------------------
Creador: Oscar Laura Aguirre Fecha: 17/03/2023, Codigo: GAN-MS-B5-0299
Descripcion: Se agrego dos columnas la primera es la del codigo de cada producto y la segunda es el de el estado
-------------------------------------------------------------------------------------------------------------------------------
Creador: Flavio Abdon Condori Vela  Fecha: 21/03/2023, Codigo: GAN-DPR-B2-0300
Descripcion: Se agrego un boton de devolución en la tabla que muestra los registros
-------------------------------------------------------------------------------------------------------------------------------
Creador: Flavio Abdon Condori Vela  Fecha: 28/03/2023, Codigo: GAN-MS-M0-0364
Descripcion: Se añadió la funcionalidad al boton devolución.
*/
?>
<?php if (in_array("smod_reg_act", $permisos)) { ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/jquery-ui.css">
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // GAN-MS-B5-0295: Cargar el id de usuario en el combobox de busqueda
            $('[name="id_usuario"]').val(<?php echo $this->session->userdata('id_usuario'); ?>).trigger('change');
            // fin cargar id de usuario

            activarMenu('menu14', 1);

            var f = new Date();
            fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();

            //$('[name="fecha_asignacion"]').val(fecha_actual);
        });
        //GAN-MS-B2-0296: validar que no se pueda ingresar fechas mayores a la actual cuando se registre o modifique un activo
        function validarf() {
            var f = new Date();
            fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
            var anio = f.getFullYear();
            var mes = (f.getMonth() + 1);
            var dia = f.getDate();
            var fec = document.getElementById("fecha_asignacion").value;
            fec = fec.split("/");
            if (parseInt(fec[0], 10) > anio) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'La fecha de asignacion no puede ser una fecha mayor que la actual',
                })
                $('[name="fecha_asignacion"]').val(fecha_actual);
            } else if (parseInt(fec[1], 10) > mes) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'La fecha de asignacion no puede ser una fecha mayor que la actual',
                })
                $('[name="fecha_asignacion"]').val(fecha_actual);
            } else if (parseInt(fec[2], 10) > dia) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'La fecha de asignacion no puede ser una fecha mayor que la actual',
                })
                $('[name="fecha_asignacion"]').val(fecha_actual);
            }
        }

        //fin  
    </script>

    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Activos</a></li>
                    <li class="active">Registro de Activos</li>
                </ol>
            </div>
            <!-- GAN-DPR-B2-0300  Inicio-->
            <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
            <div class="modal fade" id="devolucionModal" tabindex="-1" role="dialog" aria-labelledby="devolucionModalLabel" aria-hidden="true">
            <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
                    <h5 class="modal-title" id="tituloModal"></h5>
                    <h5 class="modal-title" visible="false" id="codigo_activoModal"></h5>
                    <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
                        <label for="formModal">Motivo</label>
                        <textarea class="form-control" id="motivoModal" rows="3"></textarea>
                        <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
                    <button type="button" class="btn btn-primary" onClick="guardar_devolucion()">Guardar</button>
            <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
                </div>
                </div>
            </div>
            </div>
            <!--  GAN-DPR-B2-0300 fin-->
            <div class="section-body" id="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="text-primary">Listado de Activos
                            <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp;
                                Nuevo Activo</button>
                        </h3>
                        <hr>
                    </div>
                </div>
                <div class="row col-xs-12 col-sm-10 col-md-10  col-md-offset-2 col-lg-8 col-lg-offset-2" id="form_busqueda_activo">
                    <div class="form card">
                        <div class="card-head style-primary">
                            <header>Búsqueda de Activos</header>
                        </div>
                        <div class="card-body">
                            <div class="form-group floating-label col-xs-12 col-sm-10 col-md-9 col-lg-9">
                                <select class="form-control select2-list" id="id_usuario" name="id_usuario" required>
                                    <?php foreach ($usuarios as $usuario) {  ?>
                                        <option value="<?php echo $usuario->id_usuario ?>" <?php echo set_select('usuario', $usuario->id_usuario) ?>>
                                            <?php echo $usuario->id_usuario . ' - ' . $usuario->nombre_usu ?></option>
                                    <?php  } ?>
                                </select>
                                <label for="id_venta">Buscar Usuarios</label>
                            </div>
                            <div class="form-group floating-label col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                <button type="button" class="btn btn-primary" onclick="habilitar_tabla()"><i class="fa fa-search"></i> BUSCAR</button>
                            </div>

                        </div>
                        <div class="card-actionbar">

                        </div>
                    </div>
                </div>



                <div class="row" style="display: none;" id="form_registro">
                    <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
                        <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <form class="form form-validate" novalidate="novalidate" name="form_activo" id="form_activo" method="post">
                                    <input type="hidden" name="id_activo" id="id_activo" value="0">
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
                                                <div class="col-sm-6">
                                                    <div class="form-group floating-label" id="c_activo">
                                                        <select class="form-control select2-list" id="activo" name="activo" required>
                                                            <option value=""></option>
                                                            <?php foreach ($productos as $producto) {  ?>
                                                                <option value="<?php echo $producto->oidproducto ?>" <?php echo set_select('producto', $producto->oidproducto) ?>>
                                                                    <?php echo $producto->oproducto ?></option>
                                                            <?php  } ?>
                                                        </select>
                                                        <label for="nombres">Activo</label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group form-floating" id="c_fecha_asignacion">
                                                        <div class="input-group date" id="demo-date-val">
                                                            <div class="input-group-content" id="c_fecha_asignacion">
                                                                <input type="text" class="form-control" name="fecha_asignacion" id="fecha_asignacion" onchange="validarf()" readonly="" required>
                                                                <label id="label_fecha_asignacion" for="label_fecha_asignacion">Fecha Asignación</label>
                                                            </div>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group floating-label">
                                                        <select class="form-control select2-list" id="id_usuario_registro" name="id_usuario_registro" required>
                                                            <option value=""></option>
                                                            <?php foreach ($usuarios as $usuario) {  ?>
                                                                <option value="<?php echo $usuario->id_usuario ?>" <?php echo set_select('usuario', $usuario->id_usuario) ?>>
                                                                    <?php echo $usuario->id_usuario . '  ' . $usuario->nombre_usu ?></option>
                                                            <?php  } ?>
                                                        </select>
                                                        <label for="usuario_reg"> Usuario</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="input-group-content" id="c_fecha_asignacion">
                                            <label id="label_id_producto"
                                                                for="label_fecha_asignacion">Id Producto-Revision</label>
                                            <input type="text" class="form-control"
                                                                name="id_producto" id="id_producto"
                                                                readonly="" required>
                                        </div> -->

                                            <div class="card-actionbar">
                                                <div class="card-actionbar-row">

                                                    <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="agregar_modifi_activo(1)" name="btn" id="btn_edit" value="add">Modificar Activo</button>

                                                    <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="agregar_modifi_activo(0)" name="btn" id="btn_add" value="edit">Agregar Activo</button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="listado">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-divider visible-xs"><span>Listado de Activos</span></div>
                    <div class="card card-bordered style-primary">
                        <div class="card-body style-default-bright">
                            <div id="tabla">
                                <div class="table-responsive">
                                    <table id="datatable" class=" table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="10%">Nª</th>
                                                <!-- Inicio Oscar Laura Aguirre GAN-MS-B5-0299 -->
                                                <th width="10%">codigo</th>
                                                <!-- Fin Oscar Laura Aguirre GAN-MS-B5-0299 -->
                                                <th width="30%">Activo</th>
                                                <th width="20%">Fecha de Asignaci&oacute;n</th>
                                                <!-- Inicio Oscar Laura Aguirre GAN-MS-B5-0299 -->
                                                <th width="20%">estado</th>
                                                <!-- Fin Oscar Laura Aguirre GAN-MS-B5-0299 -->
                                                <th width="10%">Acciones</th>
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
        //PARA ABRIR EL FORMULARIO
        function formulario() {
            document.getElementById("form_busqueda_activo").style.display = "none";
            $("#titulo").text("Registrar Activos");
            $('#form_activo')[0].reset();
            document.getElementById("form_registro").style.display = "block";
            document.getElementById("btn_update").style.display = "block";
            //$('[name="id_activo"]').val("");
            $('[name="activo"]').val(null).trigger('change');
            $('[name="id_usuario_registro"]').val(null).trigger('change');
            $('[name="fecha_asignacion"]').val(fecha_actual);
            $('#btn_edit').attr("disabled", true);
            $('#btn_add').attr("disabled", false);
        }
        //ACTUALIZAR FORMULARIO
        function update_formulario() {
            $('[name="activo"]').val(null).trigger('change');
            $('[name="id_usuario_registro"]').val(null).trigger('change');
            $('[name="fecha_asignacion"]').val(fecha_actual);
        }

        //PARA CERRAR EL FORMUALRIO DE ACTIVOS
        function cerrar_formulario() {
            document.getElementById("form_registro").style.display = "none";
            document.getElementById("form_busqueda_activo").style.display = "block";
        }

        function habilitar_tabla() {
            var id_usuario = document.getElementById('id_usuario').value;
            console.log(id_usuario);
            document.getElementById("tabla").innerHTML = '';
            document.getElementById("tabla").innerHTML = '<div class="table-responsive">' +
                '<table id="datatable" class="table table-bordered table-hover">' +
                '<thead>' +
                '<tr>' +
                '<th width="10%">Nª</th>' +
                /* Inicio Oscar Laura Aguirre GAN-MS-B5-0299 */
                '<th width="10%">Codigo</th>' +
                /* Fin Oscar Laura Aguirre  GAN-MS-B5-0299*/
                '<th width="30%">Activo</th>' +
                '<th width="20%">Fecha de Asignaci&oacute;n</th>' +
                /* Inicio Oscar Laura Aguirre GAN-MS-B5-0299 */
                '<th width="20%">Estado</th>' +
                /* Fin Oscar Laura Aguirre GAN-MS-B5-0299 */
                '<th width="10%">Acciones</th>' +
                '</tr>' +
                '</thead>' +
                '</table>' +
                ' </div>';

            $.ajax({
                url: "<?php echo site_url('activos/C_registro/listar_registro_activos') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    id_usuario: id_usuario
                },
                success: function(data) {

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

                        "aoColumns": [{
                                "mData": "nro"
                            },
                            /* Inicio Oscar Laura Aguirre GAN-MS-B5-0299 */
                            {
                                "mData": "codigo"
                            },
                            /* Fin Oscar Laura Aguirre GAN-MS-B5-0299 */
                            {
                                "mData": "descripcion"
                            },
                            {
                                "mData": "fecha_asignacion"
                            },
                            /* Inicio Oscar Laura Aguirre GAN-MS-B5-0299 */
                            {
                                "mData": "apiestado"
                            },
                            /* Fin Oscar Laura Aguirre GAN-MS-B5-0299 */
                            {
                                render: function(data, type, row) {
                                    if (row['apiestado'] == "ELABORADO") {
                                        return '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="recuperar_activo(' +
                                            row['id_activo'] + ')"><i class="fa fa-pencil-square-o fa-lg"></i></button>     <button type="button" title="Desactivar Registro" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_activo(' +
                                            row['id_activo'] + ')"><i class="fa fa-trash-o fa-lg "></i></button>            '+
                                            // <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
                                            '<button type="button"  title="Devolución activo" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#devolucionModal" onclick="cargar_modal(' +
                                            row['id_activo'] + ')"><i class="fa fa-reply fa-lg"></i></button> ';
                                            // <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
                                    } else {
                                        return '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="no_recuperar_activo()"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Activar Registro" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick=""><i class="fa fa-trash-o fa-lg "></i></button>';
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
                    alert('Error get data from ajax');
                }
            });
        }

        function agregar_modifi_activo(msg) {
            if (msg == 0) {
                msg = 'add';
            } else {
                msg = 'edit';
            }
            var id_activo = document.getElementById("id_activo").value;
            var id_usuario = document.getElementById("id_usuario_registro").value;
            var activo = document.getElementById("activo").value;
            var fecha_asignacion = document.getElementById("fecha_asignacion").value;

            console.log(id_activo + "," + id_usuario + "," + activo + "," + fecha_asignacion);

            if (activo != "" && fecha_asignacion != "" && id_usuario !="") {
                $.ajax({
                    url: "<?php echo site_url('activos/C_registro/aggre_modi_activo') ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        btn: msg,
                        id_usuario: id_usuario,
                        id_activo: id_activo,
                        activo: activo,
                        fecha_asignacion: fecha_asignacion
                    },
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
                                            "<?php echo base_url(); ?>registro_activo";
                                    } else {
                                        location.href =
                                            "<?php echo base_url(); ?>registro_activo";
                                    }
                                })
                            }
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax -no sirve');
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

        function recuperar_activo(id_acti) {
            console.log(id_acti);
            $("#titulo").text("Modificar Activo");
            document.getElementById("form_registro").style.display = "block";
            document.getElementById("form_busqueda_activo").style.display = "none";
            document.getElementById("btn_update").style.display = "none";
            $('#form_activo')[0].reset();

            $('#btn_edit').attr("disabled", false);
            $('#btn_add').attr("disabled", true);

            $("#c_activo").removeClass("floating-label");
            $("#c_fecha_asignacion").removeClass("floating-label");

            $.ajax({
                url: "<?php echo site_url('activos/C_registro/recuperar_registro_activos') ?>/" + id_acti,
                type: "post",
                dataType: "json",
                success: function(data) {
                    data_activo = data[0].fn_recuperar_activo;
                    data_fin_activo = JSON.parse(data_activo);
                    console.log(data_fin_activo);

                    $('[name="id_activo"]').val(id_acti);
                    // $('[name="id_producto"]').val(data_fin_activo.nombre_producto).trigger('change');
                    $('[name="id_usuario_registro"]').val(data_fin_activo.id_usuario).trigger('change');
                    $('[name="activo"]').val(data_fin_activo.id_producto).trigger('change');
                    $('[name="fecha_asignacion"]').val(data_fin_activo.fecha_asignacion).trigger('change');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }
        // <!-- GAN-MS-M0-0364 Inicio Flavio A.C.V -->
        function cargar_modal(id_acti) {
            console.log(id_acti);
            document.getElementById("codigo_activoModal").style.display = "none";
    
            $("#tituloModal").text("");
            document.getElementById("motivoModal").value = "";

            $.ajax({
                url: "<?php echo site_url('activos/C_registro/recuperar_registro_activos') ?>/" + id_acti,
                type: "post",
                dataType: "json",
                success: function(data) {
                    data_activo = data[0].fn_recuperar_activo;
                    data_fin_activo = JSON.parse(data_activo);
                    console.log(data_fin_activo);
                    $("#tituloModal").text("Devolución Activo: "+data_fin_activo.nombre_producto);
                    $("#codigo_activoModal").text(id_acti);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        
        }

        function guardar_devolucion(){
            var id_activo = document.getElementById("codigo_activoModal").innerHTML;
            var motivo_devolucion = document.getElementById("motivoModal").value;
            console.log(id_activo+","+ motivo_devolucion);

            if(motivo_devolucion != ""){
                $.ajax({
                    url: "<?php echo site_url('activos/C_registro/guardar_devolucion') ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        id_activo: id_activo,
                        motivo_devolucion : motivo_devolucion
                    },
                    success: function(respuesta) {
                        var json = JSON.parse(respuesta);
                        $.each(json, function(i, item) {
                            if (item.oboolean != 't') {
                                Swal.fire({
                                    icon: 'error',
                                    text: item.omensaje,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        } else {
                                            location.reload();
                                        }
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
                                            "<?php echo base_url(); ?>registro_activo";
                                    } else {
                                        location.href =
                                            "<?php echo base_url(); ?>registro_activo";
                                    }
                                })
                            }
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax -no sirve');
                    }
                });
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: "Por favor termine de llenar el motivo de devolución",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ACEPTAR',
                })
            }
        }
        // <!-- GAN-MS-M0-0364 Fin Flavio A.C.V -->
        

        function no_recuperar_activo() {
            Swal.fire({
                icon: 'info',
                text: "El activo no se puede editar por su estado ANULADO",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR'
            });
        }

        function eliminar_activo(id_acti) {
            console.log(id_acti);
            var titulo = 'ELIMINAR ACTIVO';
            var mensaje = '<div>¿Esta seguro que desea eliminar el Activo?</div>';

            BootstrapDialog.show({
                title: titulo,
                message: $(mensaje),
                buttons: [{
                    label: 'Aceptar',
                    cssClass: 'btn-primary',
                    action: function(dialog) {
                        dialog.close();
                        $.ajax({
                            url: '<?= base_url() ?>activos/C_registro/eliminar_activos/' + id_acti,
                            type: "post",
                            datatype: "json",
                            success: function(data) {
                                var data = JSON.parse(data);
                                console.log(data);
                                if (data) {
                                    Swal.fire({
                                        icon: 'success',
                                        text: "El activo se ha eliminado correctamente",
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ACEPTAR'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        } else {
                                            location.reload();
                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops... no se pudo eliminar el Activo',
                                        text: 'Error',
                                    })
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax');
                            }
                        });
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