<?php
/*A
    -------------------------------------------------------------------------------------------------------------------------------
    Creacion: Melvin Salvador Cussi Callisaya Fecha 23/05/2022, Codigo: GAN-MS-A5-235
    Descripcion: se realizo el modulo de produccion segun actividad GAN-MS-A5-235
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Melvin Salvador Cussi Callisaya Fecha 23/06/2022, Codigo: GAN-MS-M6-242
    Descripcion: se agregaron todas las funcionalidades correspondientes segun codigo de actividad GAN-MS-M6-242
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Alison Paola Pari Pareja   Fecha:11/08/2022   Actividad:GAN-MS-A1-337
    Descripcion: se realizaron modificaciones y correcciones en produccion
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Melani Alisson Cusi Burgoa   Fecha:27/09/2022   Actividad:GAN-MS-B9-0003
    Descripcion: Se realizo el cargado de la fecha y hora actual en fecmes y hora.
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Kevin Gerardo Alcon Lazarte   Fecha:10/02/2023   Actividad:GAN-MS-B0-0237
    Descripcion: Se valido la entrada de datos del Id=cantidad0 para que solo acepte valores enteros y no asi decimales
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Kevin Gerardo Alcon Lazarte   Fecha:17/03/2023 Actividad:GAN-MS-M0-0350
    Descripcion: Se modifico y agrego partes de este modulo para que se pueda editar correctamente su funcionamiento
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Alison Paola Pari Pareja   Fecha:23/03/2023 Actividad:GAN-MS-A3-0366
    Descripcion: Se corrigio la secuencia de cargado de los inputs select al editar un ingreso para no generar productos en blanco
    y el cargado infinito
    -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Flavio Abdon Condori Vela   Fecha:23/03/2023 Actividad:GAN-FCL-B2-0375
    Descripcion: Se modifico la vista, al momento de ingresar o recargar la pagina en el modulo este no muestrea el boton nuevo 
    ingreso y el formulario esta visible, solo en el caso de que en el formulario se de click al cerrar este 
    se muestra el boton nuevo ingreso
*/
?>
<?php if (in_array("smod_ing_prod", $permisos)) { ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        var f = new Date();
        var h = new Date();
        fechaActual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
        horaActual = h.getHours() + ":" + h.getMinutes();
        var count = 0;
        $(document).ready(function() {
            activarMenu('menu10', 1);
            
            $('#boton_nuevo_ingreso').hide();
            

            $('#agregarCampo1').click(function(e) {
                count++;
                document.getElementById("count0").value = count;

                $('#contenedor1').append('<div class="row" id="cont' + count + '">\
                    <div class="col-md-3">\
                        <div class="form-group" id="c_procedencia' + count + '">\
                            <select class="form-control select2-list" name="id_procedencia' + count +
                    '" id="id_procedencia' + count + '"  onchange="getproducto_ubi(' + count + ')" required>\
                                <option value="">&nbsp;</option>\
                                <?php foreach ($ubicacion as $ubic) { ?>\
                                    <option value="<?php echo $ubic->oidubicacion ?>">\
                                        <?php echo $ubic->oubicacion ?> </option>\
                                <?php } ?>\
                            </select>\
                            <label for="id_procedencia' + count + '">Seleccione Procedencia</label>\
                        </div>\
                    </div>\
                    <div id="productos' + count + '"></div>\
                    <div class="col-md-3" id="input_prod' + count + '">\
                        <div class="form-group" id="c_prod">\
                            <select class="form-control select2-list" name="id_prod" id="id_prod" required disabled>\
                                <option value="">&nbsp;</option>\
                            </select>\
                            <label for="producto' + count + '">Seleccione Producto</label>\
                        </div>\
                    </div>\
                    <div class="col-md-3">\
                        <div class="form-group" id="c_cantidad' + count + '">\
                            <input type="number" class="form-control" id="cantidad' + count + '" name="cantidad' +
                    count + '" required min="1" onchange="this.value = parseInt(this.value);">\
                            <label for="cantidad' + count + '" id="label_cantidad' + count + '">Cantidad</label>\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group" id="c_unidad' + count + '">\
                            <select class="form-control select2-list" name="id_unidad' + count + '" id="id_unidad' +
                    count + '"  required>\
                                <option value="">&nbsp;</option>\
                                <?php foreach ($unidad as $uni) { ?>\
                                    <option value="<?php echo $uni->oidunidades ?>"> <?php echo $uni->ounidad ?>\
                                    </option>\
                                <?php } ?>\
                            </select>\
                            <label for="id_unidad' + count + '">Unidad</label>\
                        </div>\
                    </div>\
            <button id="button' + count + '" type="button" class="eliminarContenedor1 btn btn-floating-action btn-danger" onclick"eliminarcontenedor()"><i class="fa fa-trash"></i></button>\
            </div>');

                $(".select2-list").select2({
                    allowClear: true,
                    language: "es"
                });
                return count;
            });
            $("body").on("click", ".eliminarContenedor1", function(e) {
                var e = $(this).parent('div');
                e.remove();
            });
            if (!horaActual) {
                horaActual = h.getHours() + ":" + h.getMinutes();
            } else {
                if (!fechaActual) {
                    fechaActual = h.getHours() + ":" + h.getMinutes();
                    $('[id="fecmes"]').val(fechaActual);
                    $('[id="hora"]').val(horaActual);
                } else {
                    $('[id="fecmes"]').val(fechaActual);
                    $('[id="hora"]').val(horaActual);
                }
            }
        });
        
    </script>
    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Producci&oacute;n</a></li>
                    <li class="active">Ingreso</li>
                </ol>
            </div>
            <?php if ($this->session->flashdata('success')) { ?>
                <script>
                    window.onload = function mensaje() {
                        swal.fire({
                            icon: 'success',
                            title: "<?php echo $this->session->flashdata('success'); ?>",
                            confirmButtonText: 'Continuar'
                        });
                    }
                </script>
            <?php } else if ($this->session->flashdata('error')) { ?>
                <script>
                    window.onload = function mensaje() {
                        swal.fire({
                            icon: 'error',
                            title: "<?php echo $this->session->flashdata('error'); ?>",
                            confirmButtonText: 'Aceptar'
                        });
                    }
                </script>
            <?php } ?>
            <div class="section-body">
                <div class="row" id = "boton_nuevo_ingreso">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="nuevo_form()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp;
                            Nuevo Ingreso</button><br>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <form class="form form-validate" novalidate="novalidate" name="registro_ingreso" id="registro_ingreso" enctype="multipart/form-data" method="POST" action="<?= site_url() ?>produccion/C_produccion/add_produccion">
                            <input type="hidden" name="id_lote" id="id_lote" value="0">
                            <input type="hidden" name="count0" id="count0" value="0">
                            <div class="card">
                                <div class="card-head style-primary">
                                    <div class="tools">
                                        <div class="btn-group">
                                            <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                                        </div>
                                    </div>
                                    <header id="titulo">Registro de Ingreso </header>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group floating-label" id="c_procedencia">
                                                <select class="form-control select2-list" name="id_procedencia0" id="id_procedencia0" onchange="getproducto_ubi(0);" required>
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach ($ubicacion as $ubic) { ?>
                                                        <option value="<?php echo $ubic->oidubicacion ?>">
                                                            <?php echo $ubic->oubicacion ?> </option>
                                                    <?php } ?>
                                                </select>
                                                <label for="id_procedencia0">Seleccione Procedencia</label>
                                            </div>
                                        </div>
                                        <div id="productos0"></div>
                                        <div class="col-md-3" id="input_prod0">
                                            <div class="form-group floating-label" id="c_prod">
                                                <select class="form-control select2-list" name="id_prod" id="id_prod" required disabled>
                                                    <option value="">&nbsp;</option>
                                                </select>
                                                <label for="producto0">Seleccione Producto</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 form">
                                            <!--Inicio,K.G Alcon Lazarte, 10/02/2023 ,GAN-MS-B0-0237-->
                                            <div class="form-group floating-label" id="c_cantidad">
                                                <input type="number" class="form-control" id="cantidad0" min="1" name="cantidad0" onchange="this.value = parseInt(this.value);" required>
                                                <label for="cantidad0" id="label_cantidad0">Cantidad</label>
                                            </div>
                                            <!--Fin,K.G Alcon Lazarte, 10/02/2023 ,GAN-MS-B0-0237-->
                                        </div>
                                        <div class="col-md-2 form">
                                            <div class="form-group floating-label" id="c_unidad">
                                                <select class="form-control select2-list" name="id_unidad0" id="id_unidad0" required>
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach ($unidad as $uni) { ?>
                                                        <option value="<?php echo $uni->oidunidades ?>">
                                                            <?php echo $uni->ounidad ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <label for="unidad0">Unidad</label>
                                            </div>
                                        </div>
                                        <?php $x = 0; ?>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-floating-action btn-primary" id="agregarCampo1"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div id="contenedor1"></div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group floating-label" id="c_destino">
                                                <select class="form-control select2-list" name="destino" id="destino" required>
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach ($ubicacion as $ubic) { ?>
                                                        <option value="<?php echo $ubic->oidubicacion ?>">
                                                            <?php echo $ubic->oubicacion ?> </option>
                                                    <?php } ?>
                                                </select>
                                                <label for="destino">Seleccione Destino</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <div class="input-group date" id="demo-date-val">
                                                <div class="input-group-content" id="c_fecha">
                                                    <input type="text" class="form-control" name="fecmes" id="fecmes" readonly="" required>
                                                    <label for="fecmes" class="col-sm-4 control-label" id="fecha">Fecha</label>
                                                </div>
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="time" class="form-control gx-w-100" id="hora" name="hora">
                                            <label for="hora"></label>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary ink-reaction btn-sm pull-right" name="btn" id="btn" value="add"><span class="pull-left"><i class="  "></i></span>Agregar</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-divider visible-xs"><span>Listado de Paquetes</span></div>
                                <div class="card card-bordered style-primary">
                                    <div class="card-body style-default-bright">
                                        <div class="table-responsive">
                                            <table id="datatable3" class="table table-striped table-bordered">
                                                <thead>
                                                    <th>Acci&oacute;n</th>
                                                    <th>Nº de lote</th>
                                                    <th>Destino</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($lst_ingreso as $ing) {
                                                        if ($ing != null) {
                                                    ?>
                                                            <tr>
                                                                <td align="center">
                                                                    <button type="button" id="btn_conf" title="Confirmar ingreso" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="confirmar_ingreso('<?php echo $ing->olote ?>')"><i class="fa fa-book fa-lg"></i></button>
                                                                    <button type="button" id="btn_edit" title="Editar ingreso" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_ingreso('<?php echo $ing->olote ?>')"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                                                    <button type="button" id="btn_delete" title="Eliminar ingreso" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_ingreso('<?php echo $this->session->userdata('usuario') ?>','<?php echo $ing->olote ?>')"><i class="fa fa-trash-o fa-lg"></i></button>
                                                                    <button type="button" id="btn_show" title="Detalle de ingreso" class="btn ink-reaction btn-floating-action btn-xs btn-warning" onclick="mostrar_detalle('<?php echo $ing->olote ?>')"><i class="fa fa-book fa-lg"></i></button>
                                                                <td><?php echo $ing->olote ?></td>
                                                                <td><?php echo $ing->odestino ?></td>
                                                                <td><?php echo $ing->ofecha ?></td>
                                                                <td><?php echo $ing->ohora ?></td>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" style="margin: 10px" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="confirmar()"><span class=""><i class="  "></i></span> &nbsp; Confirmar todo</button>
                <form class="form" name="form_barcode" id="form_barcode" method="post" target="_blank" action="<?php echo site_url('produccion/C_produccion/pdf_detalle_produccion') ?>">
                    <button type="submit" style="margin: 10px" class="btn btn-primary ink-reaction btn-sm pull-right">&nbsp; Imprimir Detalle</button>
                </form>
            </div>
    </div>


    <div class="row">
        <div id="AjaxTblVentas"> </div>
    </div>
    </div>

    </section>
    </div>
    <!-- END CONTENT -->
    <div class="modal fade" id="detalleLote" tabindex="-1" role="dialog" aria-labelledby="detalleLoteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header p-3 mb-2 bg-primary text-white">
                    <h2 class="modal-title" id="detalleLoteLabel" style="text-align: center;"> DETALLES DE PRODUCCION </h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="cerrar_formulario()">

                    </button>
                </div>
                <div class="modal-body">
                    <table id="tabla" class="table table-striped table-bordered">
                        <thead>
                            <th style="width: 10%;">Ubicacion</th>
                            <th style="width: 40%;">Producto</th>
                            <th style="width: 10%;">Cantidad</th>
                            <th style="width: 10%;">Unidad</th>
                            <th style="width: 25%;">Fecha</th>
                            <th style="width: 15%;">Hora</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <form class="form" name="lote_prod" id="lote_prod" method="post" target="_blank" action="<?php echo site_url('produccion/C_produccion/pdf_lote_produccion') ?>">
                        <input type="hidden" class="form-control gx-w-100" id="lote_detalle" name="lote_detalle">
                        <button type="submit" id="btnSicambiar" class="btn btn-primary">Imprimir</button>
                        <button type="button" id="btnNocambiar" class="btn btn-secondary" onclick="cerrar_modal()">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    //INICIO GAN-MS-M0-0350
    var product = false;
    var arrayproducto = [];
    var canti = [];
    //FIN GAN-MS-M0-0350
        function mostrar_detalle(id_lote) {
            $('#lote_detalle').val(id_lote);
            $('#detalleLote').modal('show');
            $.ajax({
                url: "<?= base_url() ?>produccion/C_produccion/get_lote_ingreso",
                type: "POST",
                data: {
                    id_lote: id_lote
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    var t = $('#tabla').DataTable({
                        data: data,
                        responsive: true,
                        language: {
                            url: "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                        },
                        destroy: true,
                        columnDefs: [{
                            searchable: false,
                            orderable: false,
                            bSortable: false,
                            targets: [0]
                        }],
                        aoColumns: [{
                                mData: "oubicacion",
                            },
                            {
                                mData: "oproducto",
                            },
                            {
                                mData: "ocantidad",
                            },
                            {
                                mData: "ounidad",
                            },
                            {
                                mData: "ofecha",
                            },
                            {
                                mData: "ohora",
                            }
                        ],
                        aaSorting: [],
                        dom: 'C<"clear">lfrtip',
                        colVis: {
                            "buttonText": "Columnas"
                        }
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function cerrar_formulario() {
            document.getElementById("registro_ingreso").style.display = "none";
            $('#boton_nuevo_ingreso').show();
        }

        function nuevo_form() {
            $('#boton_nuevo_ingreso').hide();

            $("#titulo").text("Registrar Ingreso");
            document.getElementById('contenedor1').innerHTML = '';
            document.getElementById("registro_ingreso").style.display = "block";
            document.getElementById("registro_ingreso").reset();
            $('#registro_ingreso')[0].reset();
            product = false;
            document.getElementById("input_prod0").style.display = "block";
            document.getElementById("producto0").style.display = "none";
            $('#id_procedencia0').val('').trigger("change");
            $('#id_producto0').val('').trigger("change");
            document.getElementById("label_cantidad0").innerText = "Cantidad";
            $('#cantidad0').val('').trigger("change");
            $('#id_unidad0').val('').trigger("change");
            $('#destino').val('').trigger("change");
            $('#fecmes').val('').trigger("change");
            $('#hora').val('').trigger("change");
            $('#id_lote').val(0).trigger('change');
            var lote = document.getElementById("id_lote").value;
            console.log(lote);
            console.log(count);
        }

        function getproducto_ubi(count) {
            console.log("estoy en buscar todos los producto del paso 2");
            if (count > 0) {

                $('#c_cantidad' + count).removeClass('floating-label');
                $('#c_unidad' + count).removeClass("floating-label");
                $('#c_procedencia' + count).removeClass("floating-label");
            }
            console.log("este es el count:" + count);
            var ubi = document.getElementById("id_procedencia" + count).value;
            if (ubi != '') {

                $.ajax({
                    url: "<?php echo site_url('produccion/C_produccion/get_ubiproducto') ?>",
                    type: "post",
                    datatype: "json",
                    data: {
                        ubicacion: ubi
                    },
                    success: function(data) {
                        var data = JSON.parse(data);
                        var prod = ' <div class="col-md-3" id="producto0">\
                            <div class="form-group floating-label" id="c_producto' + count + '">\
                            <label id="lab2" style="display: none" for="producto">Seleccione Producto</label>\
                            <select class="form-control select2-list" id="id_producto' + count + '" name="id_producto' + count + '" onchange="hide(this,\'' +
                            "label_cantidad" + count + '\',' + count + ');" required="">\
                                <option value=""></option>';
                        for (var i = 0; i < data.length; i++) {
                            prod = prod + "<option value=" + data[i].oidproducto + " > " + data[i].oproducto + "</option>";
                        }      
                        prod = prod + '</select>\
                        <label id="lab" for="id_producto' + count + '">Seleccione Producto</label>\
                        </div>\
                    </div>\
                    </div>';
                        document.getElementById("productos" + count).innerHTML = prod;
                        $('#id_producto' + count).select2();
                        document.getElementById("input_prod" + count).style.display = "none";
                        $('#c_producto' + count).removeClass("floating-label");
                        console.log("terminar de cargar el select")
                        if (product) {
                            console.log("se activa el onchange al editar")
                            var id = document.getElementById("id_lote").value;
                            $.ajax({
                                    url: "<?php echo site_url('produccion/C_produccion/datos_ingreso') ?>/" + id,
                                    type: "POST",
                                    dataType: "JSON",
                                    success: function(data) {
                                        var producto;
                                        var cantidad;
                                        var unidad;
                                        
                                        var obj = JSON.parse(data.fn_recuperar_entrada);

                                        cantidad = obj.productos[count].cantidad;
                                        unidad = obj.productos[count].id_unidad;
                                        producto= obj.productos[count].id_producto;
                                        
                                        document.getElementById("label_cantidad"+ count).innerText = "Cantidad";
                                        $("#cantidad" + count).val(cantidad).trigger('change');
                                        $("#id_unidad" + count).val(unidad).trigger('change');
                                        console.log("ants de cambiar el producto")
                                        $("#id_producto" + count).val(producto).trigger('change');
                                        console.log("este es el producto:"+producto);
                                        
                                        //FIN KGAL 17/03/2023 GAN-MS-M0-0350
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        alert('Error al obtener datos de ajax');
                                    }
                                });
                            }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos');
                    }
                });
                
            } else {
            }
        }
        
        function hide(id_producto, cantidad, count) {
            document.getElementById("lab").style.display = "none";
            document.getElementById("lab2").style.display = "block";
            console.log(id_producto.value);
            console.log(cantidad);
            console.log(count);
            //INICIO KGAL GAN-MS-M0-0350
            var ubi = document.getElementById("id_procedencia" + count).value;
            //FIN KGAL GAN-MS-M0-0350
            if (ubi != '') {
                console.log(ubi);
                $('#c_cantidad').removeClass('floating-label');
                $.ajax({
                    url: "<?php echo site_url('produccion/C_produccion/calcular_stock_ubi') ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        id_producto: id_producto.value,
                        id_ubicacion: ubi
                    },
                    success: function(respuesta) {
                        var json = JSON.parse(respuesta);
                        document.getElementById(cantidad).innerText = "Cantidad maxima disponible: " + json;
                        document.getElementById("cantidad" + count).max = json;
                        var cant = document.getElementById("count0").value;;
                        if (cant == count) {
                            console.log('acabo');
                            swal.close()
                        }
                    }
                });
            }
        }
        //   function validar_cantidad(count) {

        //     var ubi = document.getElementById("id_procedencia"+count).value;
        //     var prod = document.getElementById("id_producto"+count).value;
        //     var cant = document.getElementById("cantidad"+count).value;
        //     console.log(ubi);
        //     console.log(prod);
        //     console.log(cant);
        //     $.ajax({
        //         url: "<?php echo site_url('produccion/C_produccion/calcular_stock_ubi') ?>",
        //         type: "POST",
        //         datatype: "json",
        //         data: {
        //             id_producto: prod,
        //             id_ubicacion: ubi
        //         },
        //         success: function(respuesta) {
        //             var json = JSON.parse(respuesta);
        //             console.log(json);
        //             // if(cant>json){
        //             //     console.log('es mayor')
        //             //     $('#btn').attr("disabled", true);
        //             // }else{
        //             //     $('#btn').attr("disabled", true);
        //             // }

        //         }
        //     });
        //   }

        function confirmar() {
            Swal.fire({
                icon: 'question',
                title: '¿Desea confirmar el ingreso a produccion?',
                showCancelButton: true,
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var x = '<?php echo json_encode($lst_ingreso); ?>';
                    x = JSON.parse(x);
                    if (x.length > 0) {
                        $.ajax({
                            url: "<?php echo site_url('produccion/C_produccion/confirmar_ingreso') ?>",
                            type: "POST",
                            dataType: "JSON",
                            success: function(data) {
                                if (data[0].fn_confirmar_ingreso == 't') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Confirmado con exito!',
                                        confirmButtonText: 'Continuar'
                                    })
                                    setTimeout(() => 5000);
                                    location.reload();
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax');
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'debe tener al menos un producto',
                        })
                    }
                }
            })

        }

        function confirmar_ingreso(id_lote) {
            Swal.fire({
                icon: 'question',
                title: '¿Desea confirmar el ingreso a produccion?',
                showCancelButton: true,
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "<?php echo site_url('produccion/C_produccion/confirmar_ingreso_fila') ?>/" + id_lote,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data) {
                            if (data[0].fn_confirmar_ingreso_fila == 't') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Confirmado con exito!',
                                    confirmButtonText: 'Continuar'
                                })
                                setTimeout(() => 5000);
                                location.reload();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error al obtener datos de ajax');
                        }
                    });

                }
            })

        }

        function cerrar_modal() {
            $('#detalleLote').modal('hide');
        }
        function editar_ingreso(id) {
            $("#titulo").text("Modificar Ingreso");
            //se resetean los valores de count para que no se sumen al mismo cuando se vuelva a editar otro 
            document.getElementById("count0").value=0;
            count=0;
            document.getElementById("registro_ingreso").style.display = "block";
            Swal.fire({
                title: '<strong>Cargando datos espere por favor...</strong>',
                html: '<img src="<?= base_url() ?>assets/img/icoLogo/loader.gif" width="50" height="50">',
                allowOutsideClick: false,
                confirmButtonText: 'Cancelar',
                confirmButtonColor: '#6459DD',
            });
            document.getElementById('contenedor1').innerHTML = ''; 
            $("#id_procedencia0").select2("val", "");
            $("#destino").select2("val", "");
            $("#id_producto0").select2("val", "");
            $("#id_unidad0").select2("val", "");            
            document.getElementById("label_cantidad" + 0).innerText = "Cantidad";
            document.getElementById("registro_ingreso").reset();
            product = true;
            $.ajax({
                url: "<?php echo site_url('produccion/C_produccion/datos_ingreso') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    var obj = JSON.parse(data.fn_recuperar_entrada);
                    console.log(obj);
                    $('#id_lote').val(obj.lote).trigger('change');
                    $('#destino').val(obj.id_destino).trigger('change');
                    $('#fecmes').val(obj.fecha).trigger('change');
                    $('#hora').val(obj.hora).trigger('change');

                    var procedencia;
                    
                    console.log('tamano del length:')
                    console.log(obj.productos.length);

                    if (obj.productos.length >= 1) {
                        procedencia = obj.productos[0].id_procedencia;
                        console.log('fuera del for');
                        $("#id_procedencia" + 0).val(procedencia).trigger('change');
                        console.log("ya termino el editar del registro 0");

                        for (i = 1; i < obj.productos.length; i++) {
                            $('#agregarCampo1').trigger('click');
                            procedencia = obj.productos[i].id_procedencia;
                            let num = document.getElementById("count0").value;
                            console.log('dentro del for de procedencia');
                            $("#id_procedencia" + num).val(procedencia).trigger('change');
                            console.log("ya termino el editar del registro"+i);
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function eliminar_ingreso(login, id) {
            var titulo = 'ELIMINAR REGISTRO';
            var mensaje = '<div>Esta seguro que desea Eliminar el registro</div>';
            BootstrapDialog.show({
                title: titulo,
                message: mensaje,
                buttons: [{
                    label: 'Aceptar',
                    cssClass: 'btn-primary',
                    action: function(dialog) {
                        var $button = this;
                        $button.disable();
                        window.location = '<?= base_url() ?>produccion/C_produccion/dlt_ingreso/' + login +
                            '/' + id;
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
