<?php
/* ------------------------------------------------------------------------------
  Modificado: Maribel Teran Arispe Fecha:24/05/2021, Codigo:GAM-020
  Descripcion: se modifico la columna ESTADO de ELIMINADO-ELABORADO a DESHABILITADO y HABILITADO
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos  Fecha:04/06/2021, Codigo:GAM -025
  Descripcion: se modifico  tipo de select a select2 en masrca y producto
  --------------------------------------------------------------------------
  Modificado: Jonathan Cabezas Gazcon Fecha:15/11/2021 Codigo: GAN-MS-A1-075
  Descripcion: Se modifico la tabla de productos para mostrar el precio y poder editarlo
  --------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:08/03/2022, Codigo: GAN-MS-A1-123
  Descripcion: Se modifico el formulario para que al momento de  editar esta devuelva los valores correspondientes,
  tambien se agrego dos nuevos inputs los cuales son precio compra y precio venta
  --------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:06/05/2022, Codigo: GAN-FR-M3-227
  Descripcion: se modifico el modulo para que este muestre el codigo de barras del producto
  que corresponda asi como tambien se agrego la opcion de imprimirlo en pdf
   --------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:27/06/2022, Codigo: GAN-FR-A6-278
  Descripcion: Se añadio la columa min. existencias a la tabla y su funcionalidad.
    --------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:19/07/2022, Codigo: 
  Descripcion: Se añadio la columa Codigo Alt. a la tabla y su funcionalidad.
    --------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar Fecha:13/09/2022, Codigo: GAN-MS-A1-447: 
  Descripcion: Se modifico la funcion CambioPrecio para que el valor del precio
  sea mayor o igual a 0 y que el nuevo valor no acepte valores negativos.
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:4/10/2022, Codigo: GAN-MS-A2-0009
  Descripcion: se añadio el campo unidad en la tabla principal y tambien en los formularios de registro y modificacion
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:14/10/2022, Codigo: GAN-MS-A1-0051
  Descripcion: se añadio el boton y modal par modificar, registrar y eliminar el precio del producto
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:21/10/2022, Codigo: GAN-MS-A1-0051
  Descripcion: se añadio las funciones para la creacion, modificacion y eliminacion de precios en cat_precios 
  tambien se añadio el modal para mostrar los precios y sus respectivos popups de confirmacion
  --------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma  Fecha:21/10/2022, Codigo: GAN-MS-A1-0064
  Descripcion: se corrigio el datatableprecios para mostrar correctamente la descripcion.
  --------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa  Fecha:21/10/2022, Codigo: GAN-MS-M0-0065
  Descripcion: Se corrigio el aspecto visual del modulo de productos al editar y registrar
  --------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar  Fecha:25/10/2022, Codigo: GAN-MS-A1-0069
  Descripcion: Se modifico el campo de texto Codigo Alternativo para que sea validado si ya existe uno igual
  --------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar  Fecha:31/10/2022, Codigo: GAN-MS-A3-0084
  Descripcion: Se modifico la validacion para que se deshaabilite el boton si ya existen datos registrados
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:16/11/2022,  GAN-CV-A4-0107GAN-MS-A7-0164
  Descripcion: Se modifico la funcion editar_producto para la obtencion del precio
  ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:02/12/2022,  GAN-MS-A7-0164
  Descripcion: Se anadio un switch garantia al registrar o editar un producto
  ------------------------------------------------------------------------------
  Modificado: Henry Quispe Huayta Fecha:06/02/2023,  GAN-MS-B0-0219
  Descripcion: Se adiciono la validacion al momento de registrar un nuevo producto
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Aguirre Fecha: 10/02/2023 Codigo: GAN-MS-B0-0213
  Descripcion: Se modifico la funcion ver_imagen para que aga una verificacion 
  con nombres string null.
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Aguirre Fecha: 20/04/2023 Codigo: GAN-MS-M4-0418
  Descripcion: se modifico para que envie el id_prodcuto en lugar del codigo de 
  esta manera pueda mostrar los precios.
  ------------------------------------------------------------------------------
Modificado: Ayrton Jhonny Guevara Montaño  Fecha: 16/05/2023 Codigo:GAN-MS-B5-0470
  Descripcion: Se modifico la condicional de la tabla para el hallazgo del tipo de unidad
  correspondiente ya que se cambio de funcion
----------------------------------------------------------------------------------------
  Modificado: Dotnara Condori Condori Fecha: 19/05/2023 Codigo: GAN-DPR-B1-0484
  Descripcion: se agrego nuevos campos de adicionales 
  ------------------------------------------------------------------------------
  Modificado: Dotnara Condori Condori Fecha: 22/05/2023 Codigo: GAN-DPR-B1-0484
  Descripcion: se corrigio el error de agregar y eliminar adicionales
  ------------------------------------------------------------------------------
----------------------------------------------------------------------------------------
-- Modificado: Dotnara Isable  Condori           Fecha:24/05/2023,  GAN-MS-B1-0487    --
-- Descripcion: Realizar el funcionamiento del guardado de caracteristcas Adicionales --
-- de un nuevo producto                                                               --
----------------------------------------------------------------------------------------
-- Modificado: Dotnara Isable  Condori           Fecha:29/05/2023,  GAN-MS-B1-0495    --
-- Descripcion: Realizar del modal de adicionales                                     --
----------------------------------------------------------------------------------------
-- Modificado: Dotnara Isable  Condori           Fecha:14/06/2023,  GAN-MS-B1-0487    --
-- Descripcion: Se agrego el editar y eliminar adicionales                            --
----------------------------------------------------------------------------------------
*/
?>

<?php if (in_array("smod_prod", $permisos)) { ?>
    <script>
        var adescripcion = new Array();

        var codigoPrincipal = null;
        var codigoSecundario = null;
        var descripcionProducto = null;

        var conveniancecount = 0;
        $(document).ready(function() {
            activarMenu('menu2', 3);
            // DCondori 24-05-2023 GAN-MS-B1-0487
            let count = document.getElementById("count0").value ? document.getElementById("count0").value : 0;
            $('#agregarCampo1').click(function(e) {
                count = document.getElementById("count0").value ? document.getElementById("count0").value : 0;
                count++;
                document.getElementById("count0").value = count;

                $('#contenedor1').append('<div class="row" id="count' + count + '" >\
                        <div class="col-xs-10 col-sm-10 col-md-5 col-lg-5">\
                            <div class="form-group floating-label" id="c_tipo' + count + '">\
                                <input type="text" class="form-control" name="tipo' + count + '" id="tipo' + count + '" onchange="">\
                                <div id="result-error"></div>\
                                <label for="codigo">Tipo</label>\
                            </div>\
                        </div>\
                        <div class="col-xs-10 col-sm-10 col-md-5 col-lg-5">\
                            <div class="form-group floating-label" id="c_detalle' + count + '">\
                                <input type="text" class="form-control" name="detalle' + count + '" id="detalle' + count + '" onchange="">\
                                <div id="error-codigo-alt"></div>\
                                <label for="codigo_alt">Detalle</label>\
                            </div>\
                        </div>\
                        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">\
                            <div class="form-group floating-label" id="c_codigo_alt">\
                            <button id="button' + count + '" type="button" class="eliminarContenedor1 btn btn-floating-action btn-danger" onclick"eliminarcontenedor()"><i class="fa fa-trash"></i></button>\
                            </div>\
                        </div>\
                    </div>');
                $('#c_tipo' + count).removeClass('floating-label');
                $('#c_detalle' + count).removeClass('floating-label');
                return count;
            });
            $("body").on("click", ".eliminarContenedor1", function(e) {
                var divContenedor = $(this).closest('.row');
                divContenedor.remove();
            });
            var contadorPrecio = 0;
            var x = 1;
            var MaxInputs = 100; //maximum input boxes allowed
            var FieldCount = 0; //to keep track of text box added
            var numerador = 1;

            //GAN-MS-A3-0084 31/10/2022 LPari
            $('#codigo').on('blur', function() {
                var text_cod = $(this).val();
                $.post("<?= base_url() ?>producto/C_producto/func_auxiliares", {
                    accion: 'val_codigo',
                    text_cod: text_cod
                }, function(data) {
                    $('#result-error').html('');

                    if (data > 0) {
                        if (text_cod.length > 0) {
                            $('#result-error').html(
                                '<span id="codigo-error" class="help-block">Este código ya es existente.</span>'
                            );
                        } else {
                            $('#codigo').attr("aria-invalid", "true");
                        }
                        $('#c_codigo').addClass('has-error');
                        document.getElementById('btn_add').disabled = true;
                        codigoPrincipal = false;
                    } else {
                        if (codigoSecundario === null || codigoSecundario === true) {
                            document.getElementById('btn_add').disabled = false;
                        } else if (codigoSecundario === false) {
                            document.getElementById('btn_add').disabled = true;
                        }
                        console.log('error codigo secundario', codigoSecundario);

                        $('#result-error').html('');
                        codigoPrincipal = true;
                    }
                });
            });
            //GAN-DPR-B1-0484 19/05/2023 DCondori
            $('#codigo_alt').on('blur', function() {
                var text_cod_alt = $(this).val();
                $.post("<?= base_url() ?>producto/C_producto/validacion_cod_alt", {
                    accion: 'val_codigo_alt',
                    text_cod_alt: text_cod_alt
                }, function(data) {
                    $('#error-codigo-alt').html('');
                    if (text_cod_alt.length > 0) {
                        if (data > 0) {
                            $('#c_codigo_alt').addClass('has-error');
                            $('#codigo_alt').attr("aria-invalid", "true");
                            $('#error-codigo-alt').html(
                                '<span id="codigo_alt-error" class="help-block">Este código para alternativo ya es existente.</span>'
                            );
                            document.getElementById('btn_add').disabled = true;
                            codigoSecundario = false;
                        } else {
                            if (codigoPrincipal) {
                                document.getElementById('btn_add').disabled = false;
                            } else {
                                document.getElementById('btn_add').disabled = true;
                            }
                            console.log('error codigo principal', codigoPrincipal);
                            $('#error-codigo-alt').html('');
                            codigoSecundario = true;
                        }
                    } else {
                        if (codigoPrincipal) {
                            document.getElementById('btn_add').disabled = false;
                        } else {
                            document.getElementById('btn_add').disabled = true;
                        }
                        $('#error-codigo-alt').html('');
                        codigoSecundario = null;
                    }

                });
            });
            //Fin GAN-MS-A3-0084 31/10/2022 LPari

            $('#producto').on('blur', function() {
                var text_descripcion = $(this).val();
                $.post("<?= base_url() ?>producto/C_producto/validacion_descripcion", {
                    accion: 'val_descripcion',
                    text_descripcion: text_descripcion
                }, function(data) {
                    $('#error-producto').html('');
                    if (text_descripcion.length > 0) {
                        if (data > 0) {
                            $('#c_producto').addClass('has-error');
                            $('#producto').attr("aria-invalid", "true");
                            $('#error-producto').html(
                                '<span id="producto-error" class="help-block">Este producto ya existe.</span>'
                            );
                            document.getElementById('btn_add').disabled = true;
                            descripcionProducto = false;
                        } else {
                            if (!descripcionProducto) {
                                document.getElementById('btn_add').disabled = false;
                            } else {
                                document.getElementById('btn_add').disabled = true;
                            }
                            $('#error-producto').html('');
                            descripcionProducto = null;
                        }
                    }
                });
            });

        });
    </script>

    <style>
        hr {
            margin-top: 0px;
        }

        textarea {
            resize: none;
        }
    </style>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Productos</a></li>
                    <li class="active">Productos</li>
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
                        <h3 class="text-primary">Listado de Productos
                            <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp;
                                Nuevo Producto</button>
                        </h3>
                        <hr>
                    </div>
                </div>

                <input type="hidden" class="form-control" name="contador" id="contador" value="0">
                <div class="row" style="display: none;" id="form_registro">
                    <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
                        <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
                        <div class="row col-md-10 col-md-offset-1">
                            <form class="form form-validate" novalidate="novalidate" name="form_producto" id="form_producto" enctype="multipart/form-data" method="post" action="<?= site_url() ?>producto/C_producto/add_update_producto">
                                <input type="hidden" name="id_producto" id="id_producto">
                                <input type="hidden" name="imagen" id="imagen">
                                <input type="hidden" name="count0" id="count0" value="0">
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

                                    <div class="card-body" style="padding-bottom: 0px">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_categoria">
                                                            <select class="form-control select2-list" id="categoria" name="categoria" required>
                                                                <option value=""></option>
                                                                <?php foreach ($categorias as $cat) {  ?>
                                                                    <option value="<?php echo $cat->id_categoria ?>" <?php echo set_select('categoria', $cat->id_categoria) ?>>
                                                                        <?php echo $cat->descripcion ?></option>
                                                                <?php  } ?>
                                                            </select>
                                                            <label for="categoria">Seleccione Categor&iacute;a</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_marca">
                                                            <select class="form-control select2-list" id="marca" name="marca" required>
                                                                <option value=""></option>
                                                                <?php foreach ($marcas as $mar) {  ?>
                                                                    <option value="<?php echo $mar->id_marca ?>" <?php echo set_select('marca', $mar->id_marca) ?>>
                                                                        <?php echo $mar->descripcion ?></option>
                                                                <?php  } ?>
                                                            </select>
                                                            <label for="marca">Seleccione Marca</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_codigo">
                                                            <input type="text" class="form-control" name="codigo" id="codigo" onchange="return mayuscula(this);" required>
                                                            <div id="result-error"></div>
                                                            <label for="codigo">C&oacute;digo</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_codigo_alt">
                                                            <input type="text" class="form-control" name="codigo_alt" id="codigo_alt" onchange="return mayuscula(this);">
                                                            <!--GAN-MS-A1-0069 25/10/2022 LPari-->
                                                            <div id="error-codigo-alt"></div>
                                                            <!--Fin GAN-MS-A1-0069 25/10/2022 LPari-->
                                                            <label for="codigo_alt">C&oacute;digo Alternativo</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group floating-label" id="c_producto">
                                                            <input type="text" class="form-control" name="producto" id="producto" onchange="return mayuscula(this);" required>
                                                            <div id="error-producto"></div>
                                                            <label for="producto">Producto</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FAC-MS-M4-0003 Gary Valverde  15-03-2023 -->
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_codsin">
                                                            <select class="form-control select2-list" id="codsin" name="codsin">
                                                                <option value=""></option>
                                                                <?php foreach ($codsim as $cod) {  ?>
                                                                    <option value="<?php echo $cod->out_codprod ?>" <?php echo set_select('codsin', $cod->out_codprod) ?>> <?php echo $cod->out_descripcion ?></option>
                                                                <?php  } ?>
                                                            </select>
                                                            <label for="codsin">Seleccione Codigo SIN</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_unidades">
                                                            <select class="form-control select2-list" id="unidades" name="unidades" >
                                                                <option value=""></option>
                                                                <?php foreach ($unidades as $uni) {  ?>
                                                                    <option value="<?php echo $uni->out_codclas ?>" <?php echo set_select('unidades', $uni->out_codclas) ?>> <?php echo $uni->out_descripcion ?></option>
                                                                <?php  } ?>
                                                            </select>
                                                            <label for="unidades">Seleccione unidad</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--FAC-MS-M4-0003 FIN Gary Valverde 15-03-2023-->


                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                                        <div class="form-group floating-label" id="c_caracteristica">
                                                            <textarea class="form-control" name="caracteristica" id="caracteristica" onchange="return mayuscula(this);" rows="2" required="" aria-required="true"> </textarea>
                                                            <label for="caracteristica">Caracter&iacute;sticas</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                        <div class="form-group floating-label" id="c_con_garantia">
                                                            <input type="checkbox" class="form-control" name="con_garantia" id="con_garantia" data-toggle="toggle" data-width="175" data-on="Con Garantia" data-off="Sin Garantia">
                                                            <input type="text" class="form-control" id="garantia" name="garantia" value="unidad" style="color: #FA5600; display:none;"></input>
                                                            <input type="hidden" id="guarantee" name="guarantee" value="false">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-24 col-sm-24 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_con_garantia">
                                                            <input type="checkbox" class="form-control" name="con_adicionales" id="con_adicionales" data-toggle="toggle" data-width="175" data-on="adicionales" data-off="Sin Adicionales" onchange="ActivarAdicional(event)">
                                                            <input type="text" class="form-control" id="adicional" name="adicional" value="unidad" style="color: #FA5600; display:none;"></input>
                                                            <input type="hidden" id="adicionall" name="adicionall" value="false">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="adicional0" style="display:none;">
                                                    <div class="col-xs-10 col-sm-10 col-md-5 col-lg-5">
                                                        <div class="form-group floating-label" id="c_tipo0">
                                                            <input type="text" class="form-control" name="tipo0" id="tipo0" onchange="">
                                                            <div id="result-error"></div>
                                                            <label for="codigo">Tipo</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-10 col-sm-10 col-md-5 col-lg-5">
                                                        <div class="form-group floating-label" id="c_codigo_alt">
                                                            <input type="text" class="form-control" name="detalle0" id="detalle0" onchange="">
                                                            <div id="error-codigo-alt"></div>
                                                            <label for="codigo_alt">Detalle</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                                                        <div class="form-group floating-label" id="c_codigo_alt">
                                                        <button type="button" class="btn btn-floating-action btn-success" id="agregarCampo1" ><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="contenedor1"></div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_precio">
                                                            <input type="number" class="form-control" name="precio" id="precio" required step=".01" onblur="Cambiar()">
                                                            <input type="hidden" name="precio_antiguo" id="precio_antiguo">
                                                            <label for="precio">Precio</label>
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
                                                    Seleccionar Imagen<input style="display: none;" type="file" id="files" name="img_producto" class="form-control" />
                                                </label>
                                            </center>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-actionbar">
                                    <div class="card-actionbar-row">
                                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Producto</button>
                                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add">Registrar Producto</button>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
                    <div class="card card-bordered style-primary">
                        <div class="card-body style-default-bright">
                            <div class="table-responsive">
                                <table id="datatableprod" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nª</th>
                                            <th>Categor&iacute;as</th>
                                            <th>Marca</th>
                                            <th style="display: none;">codigo Producto</th>
                                            <th>C&oacute;digo</th>
                                            <th>C&oacute;digo Alt.</th>
                                            <th>Garant&iacute;a</th>
                                            <th>Producto</th>
                                            <th>Caracter&iacute;stica</th>
                                            <th>Precio</th>
                                            <th>Min. Existencia</th>
                                            <th>Unidad</th>
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
    <!-- Modal barcode-->
    <div class="modal fade" id="modal_barcode" tabindex="-1" role="dialog" aria-labelledby="modal_barcodeTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:400px;" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #79AF3A;">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                <center>
                                    <h3 class="text-primary" id="exampleModalLongTitle" style="color:white;">Código de
                                        Barras</h3>
                                </center>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <br><br>

                </div>
                <form class="form" name="form_barcode" id="form_barcode" method="post" target="_blank" action="<?php echo site_url('producto/C_producto/pdf') ?>">
                    <div class="modal-body">
                        <center>
                            <svg id="barcode" name="barcode"></svg>

                            <input type="hidden" class="form-control" name="id_barcode" id="id_barcode">
                            <input type="hidden" class="form-control" name="barcode_special" id="barcode_special" </center>
                    </div>
                    <div class="modal-footer">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row" align="left">
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group floating-label mr-auto" id="c_barcode">
                                        <input type="number" class="form-control" name="cantidad_barcode" id="cantidad_barcode" min="1" required>
                                        <label for="cantidad_barcode">Cantidad</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1" style="padding-top: 10px;">
                                    <button type="submit" title="Imprimir" class="btn ink-reaction btn-floating-action btn-xl btn-info"><i class="fa fa-print fa-lg"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- BEGIN SIMPLE MODAL IMAGEN -->
    <div class="modal fade" id="imagenModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Ver Imagen</h4>
                </div>
                <div class="modal-body">
                    <center>
                        <output id="verImagen"></output>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END SIMPLE MODAL IMAGEN -->
    <!-- MODAL CAMBIO VALOR -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Cambiar de Precio? </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="textopre"></h5>
                    <p id="number" style="display: none;"></p>
                    <p id="identificador" style="display: none;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnNocambiar" class="btn btn-secondary" onclick="var dato = $('#number').text(); Nocambio(dato)">No Cambiar</button>
                    <button type="button" id="btnSicambiar" class="btn btn-primary" onclick="var prod = $('#identificador').text();  SiCambio(prod)">Si cambiar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL CAMBIO VALOR -->
    <!-- MODAL CAMBIO EXISTENCIAS -->
    <div class="modal fade" id="modalExistencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Cambiar minimo umbral de existencias? </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="textoprex"></h5>
                    <p id="number_ex" style="display: none;"></p>
                    <p id="identificador_ex" style="display: none;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnNocambiarx" class="btn btn-secondary" onclick="var dato = $('#number_ex').text(); Nocambioexis(dato)">No Cambiar</button>
                    <button type="button" id="btnSicambiarx" class="btn btn-primary" onclick="var prod = $('#identificador_ex').text(); Sicambioexis(prod)">Si cambiar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL CAMBIO EXISTENCIAS -->
    <!-- MODAL CAMBIO UNIDAD -->
    <div class="modal fade" id="modalUnidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Cambiar el tipo de Unidad? </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="textouni"></h5>
                    <p id="number_uni" style="display: none;"></p>
                    <p id="identificador_uni" style="display: none;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnNocambiaruni" class="btn btn-secondary" onclick="var dato = $('#number_uni').text(); NocambioUni(dato)">No Cambiar</button>
                    <button type="button" id="btnSicambiaruni" class="btn btn-primary" onclick="var prod = $('#identificador_uni').text();  SicambioUni(prod)">Si cambiar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL CAMBIO UNIDAD -->


    <!--  MODAL PRECIOS 2-->
    <div class="modal fade" id="modalPrecios2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Lista de Precios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group floating-label" id="c_nombre1">
                                <input type="text" class="form-control" name="nombre" id="nombre1">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="datatableprecios">
                        <thead>
                            <tr>
                                <th>IDProducto</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div class="append" id="addme"></div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="btnid" id="btnid" value="0" />
                    <button type="submit" class="btn btn-success" onclick="agregarForm()" id="btnAgre1">Agregar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="removerElementos()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--  END MODAL PRECIOS 2-->

    <!--  MODAL ADICIONALES-->
    <!-- GAN-MS-B1-0495, 29/05/2023 DCondori -->
    <div class="modal fade" id="modalAdicionales" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Lista de Adicionales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group floating-label" id="c_nombre2">
                                <input type="text" class="form-control" name="nombre" id="nombre2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="datatableadicionales">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Descripcion</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- FIN GAN-MS-B1-0495, 29/05/2023 DCondori -->
    <!--  END MODAL ADICIONALES-->

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function ActivarAdicional(event) {
            var adicional1 = document.getElementById("adicional0");
            //FIN DCondori 24-05-2023 GAN-MS-B1-0487
            var nuevoEstado = event.target.checked;
            var contenedor1 = document.getElementById("contenedor1");
            var nuevoEstado2 = event.target.checked;
            if (nuevoEstado && nuevoEstado2) {
                adicional1.style.display = "block";
                contenedor1.style.display = "block";
            } else {
                adicional1.style.display = "none";
                contenedor1.style.display = "none";
                $('#contenedor1').empty();
                document.getElementById("count0").value = 0;
            }
        }
        //GAN-DPR-B1-0484 19/05/2023 DCondori
        $(function() {
            $('#con_garantia').change(function() {
                if ($(this).prop('checked')) {
                    $("#guarantee").val('true');
                } else {
                    $("#guarantee").val('false');
                }
            })
        })
        $(document).ready(function() {
            var valor = '';
            $('#datatableprod').DataTable({
                'processing': true,
                'serverSide': true,
                'responsive': true,
                "language": {
                    "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                },
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= base_url() ?>lstproductos'
                },
                'columns': [{
                        data: 'pnro'
                    },
                    {
                        data: 'pcategoria'
                    },
                    {
                        data: 'pmarca'
                    },
                    {
                        data: 'pidprod',
                        visible: false
                    },
                    {
                        data: 'pcodigo'
                    },
                    {
                        data: 'pcodigo_alt',
                        render: function(data, type, row) {

                            if (data == null || data == '') {
                                return '<p>SIN ASIGNAR</p>';
                            } else {
                                return data;
                            }

                        }
                    },
                    {
                        data: 'pgarantia'
                    },
                    {
                        data: 'pproducto',
                        render: function(data, type, row) {
                            return '<p id=' + row['pidprod'] + '>' + data + '</p>';
                        }
                    },
                    {
                        data: 'pcara'
                    },
                    {
                        data: 'pprecio',
                        render: function(data, type, row) {
                            return '<input style="width:70px;" type="number" name="price" id="precio' +
                                row['pnro'] + '" step="0.01" onchange="CambioPrecio(' + row['pnro'] +
                                ',' + row['pidprod'] + ')" value= ' + data +
                                ' ><p style="display:none;" id="odlvalue' + row['pnro'] + '">' + data +
                                '</p>';
                        }
                    },
                    {
                        data: 'pstock',
                        render: function(data, type, row) {
                            return '<input style="width:70px;" type="number" name="stock" id="existencia' +
                                row['pnro'] + '" step="1" onchange="CambioExistencia(' + row['pnro'] +
                                ',' + row['pidprod'] + ')" value="' + data +
                                '" ><p style="display:none;" id="odlvaluex' + row['pnro'] + '">' +
                                data + '</p>';
                        }
                    },
                    {
                        data: 'punidad',
                        render: function(data, type, row, meta) {
                            //Ayrton Guevara 16/05/2023 GAN-MS-B5-0470
                            if (data == undefined) {
                                return '<select class="form-control select2-list" name="unidad_tipo" id="unidad_tipo' +
                                    row['pnro'] + '" onchange="CambioUnidad(' + row['pnro'] + ',' + row[
                                        'pidprod'] + ')" onmouseover="CambioUnidad2(' + row['pnro'] +
                                    ',' + row['pidprod'] +
                                    ')"><?php foreach ($unidades as $uni) { ?><option  value="<?php echo $uni->out_codclas ?>" <?php "UNIDAD (BIENES)" == $uni->out_descripcion ? print "selected" : ''; ?> ><?php echo $uni->out_descripcion ?></option><?php } ?></select>'
                            //FIN Ayrton Guevara 16/05/2023 GAN-MS-B5-0470

                            } else {
                                var $select = $(
                                    '<select class="form-control select2-list" name="unidad_tipo" id="unidad_tipo' +
                                    row['pnro'] + '" onchange="CambioUnidad(' + row['pnro'] + ',' +
                                    row['pidprod'] + ')" onmouseover="CambioUnidad2(' + row[
                                        'pnro'] + ',' + row['pidprod'] +
                                    ')"><?php foreach ($unidades as $uni) { ?><option  value="<?php echo $uni->out_codclas ?>"><?php echo $uni->out_descripcion ?></option><?php } ?></select>'
                                );
                                $select.find('option[value="' + data + '"]').attr('selected',
                                    'selected');
                                return $select[0].outerHTML

                            }

                        }
                    },
                    {
                        data: 'pestado',
                        render: function(data, type, row) {

                            if (data == 'ELABORADO') {
                                return '<p>HABILITADO</p>';
                            } else {
                                return '<p>DESHABILITADO</p>';
                            }

                        }
                    },
                    {
                        data: 'pimagen',
                        render: function(data, type, row) {
                            var info = "'" + data + "'";
                            var ipro = "'" + row['pidprod'] + "'";
                            /*INICIO Oscar Laura Aguirre GAN-MS-M4-0418 */
                            var pcod = "'" + row.pidprod + "'";
                            /*FIN Oscar Laura Aguirre GAN-MS-M4-0418 */
                            var pprod = "'" + row.pproducto + "'";
                            var estpro = "'" + row['pestado'] + "'";
                            console.log(pcod, 'pcod');
                            console.log(row, 'row');
                            var txt =
                                '<button type="button" title="Ver Imagen" class="btn ink-reaction btn-floating-action btn-xs btn-success" name="btn_imagen" onclick="ver_imagen(' +
                                // INICIO Oscar L. GAN-MS-B0-0213
                                info + ', ' + ipro +
                                // FIN GAN-MS-B0-0213
                                ')"><i class="fa fa-picture-o fa-lg"></i></button>\
              <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_producto(' +
                                row['pidprod'] +
                                ')"><i class="fa fa-pencil-square-o fa-lg"></i></button>';
                            if (row['pestado'] == "ELABORADO") {
                                txt = txt +
                                    '<button type="button" title="Inactivar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_producto(' +
                                    ipro + ',' + estpro +
                                    ')"><i class="fa fa-minus-square-o fa-lg"></i></button>';
                            } else {
                                txt = txt +
                                    '<button type="button" title="Activar" class="btn ink-reaction btn-floating-action btn-xs btn-success" onclick="eliminar_producto(' +
                                    ipro + ',' + estpro +
                                    ')"><i class="fa fa-plus-square fa-lg"></i></button>';
                            }
                            txt = txt +
                                '<button type="button" title="C&oacute;digo de Barras" class="btn ink-reaction btn-floating-action btn-xs btn-warning" name="btn_pdf" onclick="generarpdf(\'' +
                                row.pcodigo + '\')"><i class="fa fa-bars fa-lg"></i></button>'
                            txt = txt +
                                '<button type="button" title="Precio" class="btn ink-reaction btn-floating-action btn-xs btn-success" name="btn_precio" onclick="modificar_precio2(' +
                                pcod + ',' + pprod + ')"><i class="fa fa-dollar fa-lg"></i></button>'
                            // GAN-MS-B1-0495, 29/05/2023 DCondori
                            txt = txt +
                                '<button type="button" title="Adicionales" class="btn ink-reaction btn-floating-action btn-xs btn-warning" name="btn_adicionales" onclick="modificar_adicionales(' +
                                pcod + ',' + pprod + ')"><i class="fa fa-gears fa-lg"></i></button>'
                            // FIN GAN-MS-B1-0495, 29/05/2023 DCondori
                            return txt;
                        }
                    }
                ]
            });
        });

        var antiguovalor;
        var nuevovalor;
        var antiguostock;
        var nuevostock;
        var antiguaunidad;
        var nuevaunidad;
        var previous;

        function generarpdf(cod) {
            var invalidchar = '';
            var b = true;
            for (var i = 0; i < cod.length; i++) {
                if (!(/^([a-zA-Z0-9_-])/.test(cod[i]))) {
                    if (!/[!#$%&()*+,-./:;<=>?@[\]^_{|}~]/g.test(cod[i])) {
                        b = false;
                        invalidchar = invalidchar + cod[i];
                    }
                }
            }
            if (b) {
                JsBarcode("#barcode", cod);
                $("#id_barcode").val(cod).trigger('change');
                $('#modal_barcode').modal('show');
            } else {
                if (invalidchar.length == 1) {
                    var msg = 'El código contiene el siguiente caractere especial [' + invalidchar +
                        '] que no es apto para la generación de códigos de barras, por favor revise el código';
                } else {
                    var msg = 'El código contiene los siguientes caracteres especiales [' + invalidchar +
                        '] que no son aptos para la generación de códigos de barras, por favor revise el código';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Código Inválido',
                    text: msg
                })
            }

        }

        function CambioPrecio(numero, id) {
            //alert($(this).parents("tr").find("td:eq(2)").data());
            //alert($("table").find('tbody tr').length);
            //alert($(this).parents("tr").find("td").eq(2)  val());
            //alert($(this).children("td").length);
            //alert($('#precio'+numero).attr("id").val());
            antiguovalor = $('#odlvalue' + numero).text();

            if (antiguovalor >= 0) {
                var producto = $('#' + id).text();

                // var textoprod = "<span style='color:#ff0000'>"+ producto.toUpperCase()+"</span>";

                nuevovalor = $('#precio' + numero).val(); //$('#precio').val();
                if (nuevovalor > 0) {
                    $('#textopre').text("Se cambiara el precio del producto " + producto.toUpperCase() + " de " + antiguovalor
                        .toUpperCase() + " a " + nuevovalor.toUpperCase() + " esta de acuerdo?");
                    $('#number').text(numero);
                    $('#identificador').text(id);

                    //alert('se cambiara el precio de ' + antiguovalor+ ' por el valor de '+nuevovalor);
                    $('#btnSicambiar').css('display', '');
                    $('#btnNocambiar').text("No Cambiar");
                } else {
                    $('#textopre').text("El producto debe tener un valor mayor a cero");
                    $('#number').text(numero);
                    $('#identificador').text(id);
                    $('#btnSicambiar').css('display', 'none');
                    $('#btnNocambiar').text("Aceptar");
                }
                //$('#exampleModal').modal('toggle')
                $('#exampleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                })
            } else {
                var producto = $('#' + id).text();
                //nuevovalor =  $('#precio'+numero).val();//$('#precio').val();
                $('#textopre').text("El producto " + producto.toUpperCase() +
                    " no cuenta con un ingreso a inventario en provision registre en el modulo de abastecimiento ");
                $('#number').text(numero);
                $('#identificador').text(id);
                $('#btnSicambiar').css('display', 'none');
                $('#btnNocambiar').text("Aceptar");
                //alert('se cambiara el precio de ' + antiguovalor+ ' por el valor de '+nuevovalor);
                $('#exampleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                })
            }



            //alert("workea");

        }
        //$("#exampleModal").click(function(){
        //      $("#exampleModal").modal('toggle')
        //});


        function Nocambio(num) {
            $('#precio' + num).val(antiguovalor);
            $('#exampleModal').modal('hide');

        }

        function SiCambio(id_prod) {
            //alert(id)
            var newprecio = nuevovalor;
            window.location = "<?php echo site_url('producto/C_producto/change_price') ?>/" + id_prod + '/' + newprecio;
        }

        function CambioExistencia(numero, id) {
            antiguostock = $('#odlvaluex' + numero).text();
            var producto = $('#' + id).text();
            nuevostock = $('#existencia' + numero).val(); //$('#precio').val();
            $('#textoprex').text("Se cambiara el minimo umbral de existencias del producto " + producto.toUpperCase() + " de " +
                antiguostock.toUpperCase() + " a " + nuevostock.toUpperCase() + " esta de acuerdo?");
            $('#number_ex').text(numero);
            $('#identificador_ex').text(id);

            $('#btnSicambiarx').css('display', '');
            $('#btnNocambiarx').text("No Cambiar");
            //$('#exampleModal').modal('toggle')
            $('#modalExistencia').modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        function Nocambioexis(num) {
            $('#existencia' + num).val(antiguostock);
            $('#modalExistencia').modal('hide');

        }

        function Sicambioexis(id_prod) {

            var newstock = nuevostock;
            window.location = "<?php echo site_url('producto/C_producto/change_exis') ?>/" + id_prod + '/' + newstock;

        }
        // -- --------
        function CambioUnidad(numero, id) {
            var seleccionado = $('#unidad_tipo' + numero);
            antiguaunidad = $('#unidad_tipo' + numero).children("option").filter(":selected").text()
            //var producto = $( "#myselect+ option:selected" ).text();
            var producto = $('#' + id).text();
            //nuevaunidad = $('#unidad_tipo' + numero).val(); //$('#precio').val();
            nuevaunidad = $('#unidad_tipo' + numero).find(":selected").val();
            $('#textouni').text("Se cambiara el tipo de unidad del producto a " + antiguaunidad.toUpperCase() +
                " esta de acuerdo?");
            $('#number_uni').text(numero);
            $('#identificador_uni').text(id);

            $('#btnSicambiaruni').css('display', '');
            $('#btnNocambiaruni').text("No Cambiar");
            //$('#exampleModal').modal('toggle')
            $('#modalUnidad').modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        function NocambioUni(num) {
            //$('#unidad_tipo' + num).val(antiguaunidad);
            //$('#unidad_tipo' + num).children("option").filter(":selected").attr("selected","selected");
            $('#unidad_tipo' + num).val(previous).change();
            $('#modalUnidad').modal('hide');

        }

        function SicambioUni(id_prod) {

            var newunit = nuevaunidad;
            console.log(id_prod);
            window.location = "<?php echo site_url('producto/C_producto/change_unit') ?>/" + id_prod + '/' + newunit;

        }
        // -----------------------------------------------------

        function CambioUnidad2(numero, id) {
            $('#unidad_tipo' + numero).mouseover(function() {
                // Store the current value on focus, before it changes

                previous = this.value;
                console.log(previous);
            }).change(function() {
                // Do soomething with the previous value after the change

            });

        }

        // ------------ Cambio de precios ---------------


        function eliminar_precio(id_precio) {
            //var pcodigo = document.getElementById("btnid").value;
            //var pdescc = document.getElementById("precioprod'+id+'").value;
            var titulo = 'ELIMINAR REGISTRO';
            var mensaje = '<div>Esta seguro que desea Eliminar el registro</div>';

            BootstrapDialog.show({
                title: titulo,
                message: $(mensaje),
                buttons: [{
                    label: 'Aceptar',
                    cssClass: 'btn-primary',
                    action: function(dialog) {
                        var $button = this;
                        $button.disable();
                        window.location = '<?= base_url() ?>producto/C_producto/dlt_precios/' + id_precio;
                    }
                }, {
                    label: 'Cancelar',
                    action: function(dialog) {
                        dialog.close();
                    }
                }]
            });
        }

        function agregarForm() {
            //"<h3>This is the text which has been inserted by JS</h3>";

            let id_prodd = $('#btnid').val();
            $('#btnAgre1').prop('disabled', true);
            console.log("id producto " + id_prodd);
            document.getElementById("addme").innerHTML +=
                '<div id="contenedor2">\
            <form class="form form-validate" novalidate="novalidate" name="form_precio" id="form_precio" enctype="multipart/form-data" method="post" action="<?= site_url() ?>producto/C_producto/add_precio">\
              	    <input type="hidden" name="id_producto1" id="id_producto1">\
		    <div class="row">\
			    <hr class="divider">\
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">\
			    <div class="form-group">\
				<div class="input-group input-group-lg">\
				    <div class="input-group-content">\
					<div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">\
					    <div class="form-group form-floating" id="c_descrip0">\
						<input type="text" class="form-control" name="descripcion"\
						    id="descripcionprod" value="">\
						<label for="producto">Descripcion</label>\
					    </div>\
					</div>\
					<div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">\
					    <div class="form-group floating-label" id="c_preci0">\
						<input type="number" class="form-control" name="precio"\
						    id="precioprod0" min="1">\
						<label id="label_cantidad" for="cantidad">Precio</label>\
					    </div>\
					</div>\
				    </div>\
				    <div class="input-group-btn">\
					<button type="submit" class="btn btn-success"\
					    id="registrar1">Registrar</button>\
				    </div>\
				</div>\
			    </div>\
			</div>\
		    </div>\
		</form>\
		</div>';
            $('#id_producto1').val(id_prodd);


        }

        function removerElementos() {
            const myNode = document.getElementById("addme");
            myNode.innerHTML = '';
        }

        function modificar_precio2(id, nombrep) {
            $('#modalPrecios2').modal({
                backdrop: 'static',
                keyboard: false
            })
            //document.getElementById("form_precios").reset();
            document.getElementById("nombre1").value = nombrep;
            $('#btnAgre1').removeAttr('disabled');

            $(document).ready(function() {
                var s = $('#datatableprecios').length;
                console.log("existe..." + s);
                $('#datatableprecios').DataTable({
                    'destroy': true,
                    'processing': true,
                    'serverSide': true,
                    'responsive': true,
                    paging: false,
                    ordering: false,
                    info: false,
                    searching: false,
                    "language": {
                        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                    },
                    'serverMethod': 'post',
                    'ajax': {
                        'url': "<?php echo site_url('producto/C_producto/precios') ?>/" + id
                    },
                    'columns': [{
                            data: 'pidprecio',
                            visible: false
                        },
                        {
                            data: 'pdescripcion',
                            render: function(data, type, row, meta) {
                                return '<input style="width:150px;" class="form-control" type="text" name="description" id="descripp' +
                                    meta.row + '"  onchange="CambioPrecioPr2(' + row.pidprecio + ',' +
                                    meta.row + ')" value= "' + data +
                                    '" ><p style="display:none;" id="">' + data + '</p>';
                            }

                        },
                        {
                            data: 'pprecio',
                            render: function(data, type, row, meta) {
                                return '<input style="width:70px;" class="form-control" type="number" name="price" id="preciop' +
                                    meta.row + '" step="0.01" onchange="CambioPrecioPr(' + row
                                    .pidprecio + ',' + row.pprecio + ',' + meta.row + ')" value= ' +
                                    data + ' ><p style="display:none;" id="odlvalue' + meta.row + '">' +
                                    data + '</p>';
                            }
                        },
                        {
                            data: 'pusucre',
                            render: function(data, type, row) {
                                var pcod = "'" + row.pidprecio + "'";
                                var txt =
                                    '<button type="button" title="Ver Imagen" class="btn ink-reaction btn-floating-action btn-xs btn-danger" name="btn_imagen" onclick="eliminar_precio(' +
                                    pcod + ')"><i class="fa fa-trash "></i></button>'
                                return txt;
                            }
                        }
                    ]
                });

                $('#btnid').val(id);
            });
        }
        // GAN-MS-B1-0495, 29/05/2023 DCondori
        function modificar_adicionales(id, nombrep) {
            $('#modalAdicionales').modal({
                backdrop: 'static',
                keyboard: false
            })
            document.getElementById("nombre2").value = nombrep;
            $('#btnAgre1').removeAttr('disabled');
            $(document).ready(function() {
                var s = $('#datatableadicionales').length;
                $('#datatableadicionales').DataTable({
                    'destroy': true,
                    'processing': true,
                    'serverSide': true,
                    'responsive': true,
                    paging: false,
                    ordering: false,
                    info: false,
                    searching: false,
                    "language": {
                        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                    },
                    'serverMethod': 'post',
                    'ajax': {
                        'url': "<?php echo site_url('producto/C_producto/list_adicionales') ?>/" + id
                    },
                    'columns': [
                        {
                            data: 'dtipo',
                            render: function(data, type, row, meta) {
                                return '<input style="width:150px;" class="form-control" type="text" name="dtipo" id="dtipo' +
                                    meta.row + '"  onchange="CambioPrecioPr2(' + row.pidprecio + ',' +
                                    meta.row + ')" value= "' + data +
                                    '" ><p style="display:none;" id="">' + data + '</p>';
                            }
                        },
                        {
                            data: 'ddetalle',
                            render: function(data, type, row, meta) {
                                return '<input style="width:70px;" class="form-control" type="text" name="ddetalle" id="ddetalle' +
                                    meta.row + '" step="0.01" onchange="CambioPrecioPr(' + row
                                    .pidprecio + ',' + row.pprecio + ',' + meta.row + ')" value= ' +
                                    data + ' ><p style="display:none;" id="odlvalue' + meta.row + '">' +
                                    data + '</p>';
                            }
                        },
                    ]
                });
                $('#btnid').val(id);
            });
        }
        //FIN GAN-MS-B1-0495, 29/05/2023 DCondori

        function CambioPrecioPr(idprecio, precio, numero) {
            var titulo = 'MODIFICAR REGISTRO';
            var mensaje = '<div>Esta seguro que desea Modificar el registro</div>';
            var nuevoprecio = $('#preciop' + numero).val();
            var descrip = $('#descripp' + numero).val();
            console.log("descripcion " + descrip);

            BootstrapDialog.show({
                title: titulo,
                message: $(mensaje),
                buttons: [{
                    label: 'Aceptar',
                    cssClass: 'btn-primary',
                    action: function(dialog) {
                        var $button = this;
                        $button.disable();
                        window.location = '<?= site_url() ?>producto/C_producto/mod_precio/' + idprecio +
                            '/' + descrip + '/' + nuevoprecio;
                    }
                }, {
                    label: 'Cancelar',
                    action: function(dialog) {
                        dialog.close();
                    }
                }]
            });

        }

        function CambioPrecioPr2(idprecio, numero) {
            var titulo = 'MODIFICAR REGISTRO';
            var mensaje = '<div>Esta seguro que desea Modificar el registro</div>';
            var precio = $('#preciop' + numero).val();
            var descrip = $('#descripp' + numero).val();

            BootstrapDialog.show({
                title: titulo,
                message: $(mensaje),
                buttons: [{
                    label: 'Aceptar',
                    cssClass: 'btn-primary',
                    action: function(dialog) {
                        var $button = this;
                        $button.disable();
                        window.location = '<?= site_url() ?>producto/C_producto/mod_precio/' + idprecio +
                            '/' + descrip + '/' + precio;
                    }
                }, {
                    label: 'Cancelar',
                    action: function(dialog) {
                        dialog.close();
                    }
                }]
            });

        }
        //------------------------------------------------------
        function formulario() {
            $("#titulo").text("Registrar Producto");
            $('#form_producto')[0].reset();
            var x = document.getElementById("c_precio");
            x.style.display = "none";
            $('#precio').removeAttr("required");
            document.getElementById("list").innerHTML = '';
            document.getElementById("form_registro").style.display = "block";
            document.getElementById("btn_update").style.display = "block";
            $('#btn_edit').attr("disabled", true);
            $('#btn_add').attr("disabled", false);
        }

        function cerrar_formulario() {
            document.getElementById("form_registro").style.display = "none";
            $('#form_producto')[0].reset();
            document.getElementById("list").innerHTML = '';
        }

        function update_formulario() {
            $('#form_producto')[0].reset();
            document.getElementById("list").innerHTML = '';
            $('#btn_edit').attr("disabled", true);
            $('#btn_add').attr("disabled", false);
        }

        function Cambiar() {
            var valor_actual = document.getElementById("precio").value;
            var valor_antiguo = document.getElementById("precio_antiguo").value;
        }

        function editar_producto(id_prod) {
            var x = document.getElementById("c_precio");
            x.style.display = "block";
            $('#precio').prop("required", true);
            $("#titulo").text("Modificar Producto");
            document.getElementById("form_registro").style.display = "block";
            $('#form_producto')[0].reset();
            document.getElementById("btn_update").style.display = "none";
            $('#btn_edit').attr("disabled", false);
            $('#btn_add').attr("disabled", true);

            $("#c_categoria").removeClass("floating-label");
            $("#c_unidad").removeClass("floating-label");
            $("#c_marca").removeClass("floating-label");
            $("#c_producto").removeClass("floating-label");
            $("#c_codigo").removeClass("floating-label");
            $("#c_codigo_alt").removeClass("floating-label");
            $("#c_caracteristica").removeClass("floating-label");

            $.ajax({
                url: "<?php echo site_url('producto/C_producto/datos_producto') ?>/" + id_prod,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    // GAN-MS-B1-0495, 14/06/2023 DCondori
                    let caracteristicas = data.caracteristicas.aaData;
                    let precio = data.precio;
                    data = data.datos;

                    $('[name="id_producto"]').val(data.id_producto);
                    $('[name="categoria"]').val(data.id_categoria).trigger('change');
                    $('[name="marca"]').val(data.id_marca).trigger('change');
                    // -- RB
                    $('[name="unidades"]').val(data.id_unidad).trigger('change');
                    $('[name="codsin"]').val(data.codigo_sin).trigger('change');
                    $('[name="codigo"]').val(data.codigo);
                    $('[name="codigo_alt"]').val(data.codigo_alt);
                    $('[name="producto"]').val(data.descripcion);
                    $('[name="caracteristica"]').val(data.caracteristica);
                    var adicional = document.getElementById("con_adicionales");
                    if(caracteristicas.length > 0){
                        $("#adicionall").val('true');
                        adicional.checked = true;
                        $("#con_adicionales").val("true").trigger("change");

                        var count = 0;
                        caracteristicas
                        for (var j = 0; j < caracteristicas.length; j++) {
                            if(j !== 0 ){
                                count++;
                                document.getElementById("count0").value = count;
                                $('#contenedor1').append('<div class="row" id="count' + count + '" >\
                                    <div class="col-xs-10 col-sm-10 col-md-5 col-lg-5">\
                                        <div class="form-group floating-label" id="c_tipo' + count + '">\
                                            <input type="text" class="form-control" name="tipo' + count + '" id="tipo' + count + '" onchange="">\
                                            <div id="result-error"></div>\
                                            <label for="codigo">Tipo</label>\
                                        </div>\
                                    </div>\
                                    <div class="col-xs-10 col-sm-10 col-md-5 col-lg-5">\
                                        <div class="form-group floating-label" id="c_detalle' + count + '">\
                                            <input type="text" class="form-control" name="detalle' + count + '" id="detalle' + count + '" onchange="">\
                                            <div id="error-codigo-alt"></div>\
                                            <label for="codigo_alt">Detalle</label>\
                                        </div>\
                                    </div>\
                                    <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">\
                                        <div class="form-group floating-label" id="c_codigo_alt">\
                                        <button id="button' + count + '" type="button" class="eliminarContenedor1 btn btn-floating-action btn-danger" onclick"eliminarcontenedor()"><i class="fa fa-trash"></i></button>\
                                        </div>\
                                    </div>\
                                </div>');
                                $('#c_tipo' + count).removeClass('floating-label');
                                $('#c_detalle' + count).removeClass('floating-label');
                                $('#tipo'+ count).val(caracteristicas[j].dtipo);
                                $('#detalle'+ count).val(caracteristicas[j].ddetalle);
                            }else{
                                $('#tipo'+ j).val(caracteristicas[j].dtipo);
                                // $('#detalle0').val(caracteristicas[j].dtipo);
                                $('[name="detalle0"]').val(caracteristicas[j].ddetalle);
                            }
                        }
                    }else{
                        $("#adicionall").val('false');
                        adicional.checked = false;
                        $("#con_adicionales").val("false").trigger("change");
                    }
                    // FIN GAN-MS-B1-0495, 14/06/2023 DCondori
                    var garantia = document.getElementById("con_garantia");
                    //console.log(garantia.checked=true);
                    if (data.garantia == 't') {
                        $("#guarantee").val('true');
                        garantia.checked = true;
                        $("#con_garantia").val("true").trigger("change");
                        //$("#con_garantia").prop("checked", true);
                    } else {
                        $("#guarantee").val('false');
                        garantia.checked = false;
                        $("#con_garantia").val("false").trigger("change");
                    };

                    if (precio != null) {
                        $('[name="precio"]').val(precio).trigger('change');
                        $('[name="precio_antiguo"]').val(precio).trigger('change');
                    } else {
                        $('[name="precio"]').val(0).trigger('change');
                        $('[name="precio_antiguo"]').val(0).trigger('change');
                    }

                    if (data.imagen == null || data.imagen == '') {
                        dato =
                            '<p style="text-align: center; font-family: impact; font-size: 20px; color: #2196f3;"> Sin Imagen </p>';
                        document.getElementById("list").innerHTML = dato;
                    } else {
                        dato = '<img src="<?php echo base_url(); ?>assets/img/productos/' + data.imagen +
                            '" class="img-responsive">';
                        document.getElementById("list").innerHTML = dato;
                    };
                    $('[name="imagen"]').val(data.imagen);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function eliminar_producto(id_prod, estado) {
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
                        window.location = '<?= base_url() ?>producto/C_producto/dlt_producto/' + id_prod +
                            '/' + estado;
                    }
                }, {
                    label: 'Cancelar',
                    action: function(dialog) {
                        dialog.close();
                    }
                }]
            });
        }

        // INICIO Oscar L., GAN-MS-B0-0213
        function ver_imagen(nom_imagen, id_imagen_verificar) {
            $('#imagenModal').modal('show');
            console.log(id_imagen_verificar, 'este es el nuevo codigo')
            if (nom_imagen == null || nom_imagen == '' || nom_imagen == "null") {
                dato = '<img src="<?php echo base_url(); ?>assets/img/productos/sin_imagen.jpg" class="img-responsive">';
                document.getElementById("verImagen").innerHTML = dato;
            } else {

                $.ajax({
                    url: "assets/img/productos/" + nom_imagen,
                    type: 'HEAD',
                    error: function() {
                        console.log("El archivo no existe.");
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/cambiar_null_a_imagenes_sin_archivos_fisicos') ?>",
                            type: "POST",
                            data: {
                                dato1: id_imagen_verificar,
                            },
                            success: function(respuesta) {
                                console.log(respuesta);
                                dato = '<img src="<?php echo base_url(); ?>assets/img/productos/sin_imagen.jpg" class="img-responsive">';
                                document.getElementById("verImagen").innerHTML = dato;
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax3', jqXHR);
                            }
                        });
                    },
                    success: function() {
                        console.log('el archivo existe')
                        dato = '<img src="<?php echo base_url(); ?>assets/img/productos/' + nom_imagen + '" class="img-responsive">';
                        document.getElementById("verImagen").innerHTML = dato;
                    }
                });
            }
            //  FIN GAN-MS-B0-0213

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
                        document.getElementById("list").innerHTML = ['<img class="img-responsive" src="', e.target
                            .result, '" title="', escape(theFile.name), '"/>'
                        ].join('');
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