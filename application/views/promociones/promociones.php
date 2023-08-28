<?php 
/*
    ------------------------------------------------------------------------------
    Creador: Fabian Candia Alvizuri Fecha 22/02/2021, Codigo: GAN-FR-M3-036,
    Descripcion: Se realizo el frontend de las páginas 94 a 104 del branch de Design 
    ------------------------------------------------------------------------------
    Modificado: Fabian Candia Alvizrui Fecha:05/10/2021, Codigo: GAN-FR-A2-036,
    Descripcion: Se realizo la modificacion para que funcione el boton de aumento de productos
    ------------------------------------------------------------------------------
    Modificado: Fabian Candia Alvizuri Fecha:13/10/2021, GAN-MS-A5-041
    Descripcion: Se realizaron la modificacion para la creacion de funciones de las páginas 94 a 103
    ------------------------------------------------------------------------------
    Modificado: Fabian Candia Alvizuri Fecha:14/10/2021, GAN-MS-A5-041
    Descripcion: Se modifico el select de productos para que muestre los productos disponibles
    ------------------------------------------------------------------------------
    Modificado: Fabian Candia Alvizuri Fecha:21/10/2021, GAN-MS-A5-041
    Descripcion: Se realizo los cambios necesarios para que funcione el despliegue de los elementos del producto
    ------------------------------------------------------------------------------
    Modificado: Fabian Candia Alvizuri Fecha:03/11/2021, GAN-MS-A7-060
    Descripcion: Se realizo los cambios necesarios para que al momento de editar pueda recuperar los datos de producto y cantidad
    ------------------------------------------------------------------------------
    Modificado: Brayan Janco Cahuana Fecha:10/11/2021, Codigo: GAN-MS-A1-071
    Descripcion: Se realizo la modificacion en la funcion editar_promocion para que no muestre un producto extra.
    ------------------------------------------------------------------------------
    Modificado: Brayan Janco Cahuana Fecha:23/11/2021, Codigo: GAN-MS-A5-097
    Descripcion: Se realizo la modificacion donde se agrego el campo de stock en el registro y edicion de promocion
    ------------------------------------------------------------------------------
    Modificado: Melvin Salvador Cussi Callisaya Fecha:29/11/2021, GAN-MS-A7-105
    Descripcion: Se soluciono el error de decremento de stock con la creacion de dos vectores para garantizar el envio de productos
    ------------------------------------------------------------------------------
    Modificado: Melvin Salvador Cussi Callisaya Fecha:29/11/2021, GAN-MS-A7-106 
    Descripcion: Se soluciono el error de ajax con la anterior solucion al asegurar el envio de productos
    -------------------------------------------------------------------------------------------------------
    Modificado: Alison Paola Pari Pareja Fecha:13/04/2022, Codigo: GAN-MS-M3-144
    Descripcion: se modifico el datatable para insertar el limit del modelo

*/

?>
<?php if (in_array("smod_prom_desc", $permisos)) { ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    activarMenu('menu11', 1);


    var x = 1;
    var MaxInputs = 100; //maximum input boxes allowed
    var FieldCount = 0; //to keep track of text box added
    var numerador = 1;

    //Begin contenedor 1
    $('#agregarCampo1').click(function(e) { //on add input button click

        if (x <= MaxInputs) { //max input box allowed
            FieldCount++; //text box added increment
            numerador++;
            // alert("Ingreso contenedor1: " + FieldCount)

            //add input box

            $('#contenedor1').append('<div class="row">\
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">\
                    <div class="form-group">\
                        <div class="input-group input-group-lg">\
                            <div class="input-group-content">\
                                <div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">\
                                    <div class="form-group form-floating" id="c_producto' + FieldCount +
                '">\
                                        <select class="form-control select2-list" name="producto[]" onchange="actualizar(this,\'' +
                "lable_produc" + FieldCount + '\')" id="producto' +
                FieldCount + '" >\
                                        <option value=" "></option>\
                                        <?php foreach ($productos as $pro) {  ?>\
                                            <option value="<?php echo $pro->oidproducto ?>" > <?php echo $pro->oproducto ?></option>\
                                        <?php  } ?>\
                                        </select>\
                                        <label for="producto">Seleccione Producto</label>\
                                        </div>\
                                    </div>\
                                    <div class="col-xs-12 col-sm-4 col-md-5 col-lg-5">\
                                        <div class="form-group form-floating" id="c_cantidad' + FieldCount + '">\
                                            <input type="number" class="form-control" name="cantidad[]" id="cantidad' +
                FieldCount + '" min="1" >\
                                            <label id="lable_produc' + FieldCount + '" for="cantidad">Cantidad</label>\
                                        </div>\
                                    </div>\
                                </div>\
                            <div class="input-group-btn">\
                                <button type="button" class="btn btn-floating-action btn-danger"  id="eliminarContenedor1"><i class="fa fa-trash"></i></button>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>');


            $(".select2-list").select2({
                allowClear: true,
                language: "es"
            });

            x++; //text box increment
        }
        $('#contador').val(FieldCount).trigger('change');
        $('#numerador').val(numerador).trigger('change');
        return false;
    });

    $("body").on("click", "#eliminarContenedor1", function(e) { //user click on remove text
        if (x > 1) {
            var e = $(this).parent('div').parent('div').parent('div').parent('div').parent('div');
            e.remove();
            x--; //decrement textbox
            numerador--;
            $('#numerador').val(numerador).trigger('change');
        }
        return false;
    });
});
</script>

<style>
hr {
    margin-top: 0px;
}
</style>


<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="#">Promociones</a></li>
                <li class="active">Promociones y descuentos</li>
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
        <?php } else if($this->session->flashdata('error')){ ?>
        <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "<?php echo $this->session->flashdata('error'); ?>",
                confirmButtonColor: '#d33',
                confirmButtonText: 'ACEPTAR'
            })

        });
        </script>
        <?php } ?>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="text-primary">Listado de promociones
                        <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right"
                            onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp;
                            Nueva Promocion</button>
                    </h3>
                    <hr>
                </div>
            </div>
            <input type="hidden" class="form-control" name="contador" id="contador" value="0">
            <div class="row" style="display: none;" id="form_registro">
                <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
                    <div class="text-divider visible-xs"><span>Registrar nueva promocion</span></div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <form class="form form-validate" novalidate="novalidate" name="form_promociones"
                                id="form_promociones" method="post">
                                <input type="hidden" name="id_promocion" id="id_promocion">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <a id="btn_update" class="btn btn-icon-toggle"
                                                    onclick="update_formulario()"><i class="md md-refresh"></i></a>
                                                <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i
                                                        class="md md-close"></i></a>
                                            </div>
                                        </div>
                                        <header id="titulo"></header>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group floating-label" id="c_nombre">
                                                    <input type="text" class="form-control" name="nombre" id="nombre"
                                                        required>
                                                    <label for="nombre">Nombre de promocion: </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group floating-label" id="c_codigo">
                                                    <input type="text" class="form-control" name="codigo" id="codigo"
                                                        onchange="return mayuscula(this);" required>
                                                    <label for="codigo">Nuevo Cod. Promocion: </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group floating-label" id="c_precio">
                                                    <input type="number" class="form-control" name="precio" id="precio"
                                                        min="0" pattern="^[0-9]+" required>
                                                    <label for="precio">Precio promocion: </label>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group form-floating">
                                                    <div class="input-group date" id="demo-date-val">
                                                        <div class="input-group-content" id="c_fecha_limite">
                                                            <input type="text" class="form-control" name="fecha_limite"
                                                                id="fecha_limite" readonly="" required>
                                                            <label for="fecha_limite">Fecha limite</label>
                                                        </div>
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="form-group floating-label" id="c_stock">
                                                    <input type="number" class="form-control" name="stock" id="stock"
                                                        min="0" pattern="^[0-9]+" required>
                                                    <label for="stock">Stock Habilitado: </label>
                                                </div>
                                            </div>
                                        </div>
                                        <form name="form_productos" id="form_productos">
                                            <div id="productos">
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <h3 class="text-on-pannel text-light">Productos</h3>
                                                        <div id="contenedor1">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="form-group">
                                                                        <div class="input-group input-group-lg">
                                                                            <div class="input-group-content">
                                                                                <div
                                                                                    class="col-xs-12 col-sm-4 col-md-5 col-lg-5">
                                                                                    <div class="form-group form-floating"
                                                                                        id="c_producto0">
                                                                                        <select
                                                                                            class="form-control select2-list"
                                                                                            name="producto[]"
                                                                                            id="producto0"
                                                                                            onchange="actualizar(this,'label_cantidad')">
                                                                                            <option value=" "></option>
                                                                                            <?php foreach ($productos as $pro) {  ?>
                                                                                            <option
                                                                                                value="<?php echo $pro->oidproducto ?>">
                                                                                                <?php echo $pro->oproducto ?>
                                                                                            </option>
                                                                                            <?php  } ?>
                                                                                        </select>
                                                                                        <label for="producto">Seleccione
                                                                                            Producto</label>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-xs-12 col-sm-4 col-md-5 col-lg-5">
                                                                                    <div class="form-group floating-label"
                                                                                        id="c_cantidad0">
                                                                                        <input type="number"
                                                                                            class="form-control"
                                                                                            name="cantidad[]"
                                                                                            id="cantidad0" min="1">
                                                                                        <label id="label_cantidad"
                                                                                            for="cantidad">Cantidad</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="input-group-btn">
                                                                                <button type="button"
                                                                                    class="btn btn-floating-action btn-success"
                                                                                    id="agregarCampo1"><i
                                                                                        class="fa fa-plus"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="card-actionbar">
                                            <div class="card-actionbar-row">
                                                <input type="hidden" name="btnid" id="btnid" value="0" />
                                                <button type="button" class="btn btn-flat btn-primary ink-reaction"
                                                    name="btn" id="btn_edit" value="edit"
                                                    onclick="agregar_promo(1)">Modificar Promocion</button>
                                                <button type="button" class="btn btn-flat btn-primary ink-reaction"
                                                    name="btn" id="btn_add" value="add"
                                                    onclick="agregar_promo(0)">Agregar promocion </button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="text-divider visible-xs"><span>Listado de Gastos</span></div>
        <div class="card card-bordered style-primary">
            <div class="card-body style-default-bright">
                <div class="table-responsive">
                    <table id="datatable_promo" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Codigo Promocion</th>
                                <th>Nombre promocion</th>
                                <th>Precio Promocion </th>
                                <th>Fecha Limite</th>
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
</div>
</section>
</div>


<script>
 $(document).ready(function(){
      $('#datatable_promo').DataTable({
          'processing': true,
          'serverSide': true,
          'responsive':true,
          "language": {
    "url": "<?= base_url()?>assets/plugins/datatables_es/es-ar.json" },
          'serverMethod': 'post',
          'ajax': {
             'url':'<?=base_url()?>promociones/C_promociones/lista_promociones'
          },
          
          'columns': [
             { data: 'onombre' ,render: function (data, type, row){

                return row['onro'];
             }
            },

             { data: 'ocodigo' },
             { data: 'onombre'},
             { data: 'oprecio' },
             { data: 'ofechalimite' },
          
             { data: 'ofechalimite' ,render: function (data, type, row){

                  return ' <button type="button" title="Editar" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar_promocion('+row['oidpromocion']+')"><i class="fa fa-pencil-square-o fa-lg"></i></button> <button type="button" title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_promocion('+row['oidpromocion']+')"><i class="fa fa-trash-o fa-lg"></i></button>';
                  
                }
               
              }
        
          ],
          "dom": 'C<"clear">lfrtip',
          "colVis": {
                        "buttonText": "Columnas"
                    },
        });
     
     });
function formulario() {
    $("#titulo").text("Registrar nueva promocion");
    $('#form_promociones')[0].reset();
    document.getElementById("form_registro").style.display = "block";
    document.getElementById("btn_update").style.display = "block";
    $('#btn_edit').attr("disabled", true);
    $('#btn_add').attr("disabled", false);
}

function cerrar_formulario() {
    document.getElementById("form_registro").style.display = "none";
}

function update_formulario() {
    $('#form_promociones')[0].reset();
}

function agregar_promocion() {

    var hoy = new Date();

    const fechaActual = hoy.getFullYear() + "/" + (hoy.getMonth() + 1) + "/" + hoy.getDate();
    const fecha_limite = $('#fecha_limite').val();


    if (fecha_limite >= fechaActual) {
        var titulo = 'REGISTRAR';
        var mensaje = '<div><i class="fa fa-check btn-success"></i></div>';
    } else {
        var titulo = 'ADVERTENCIA!!!';
        var mensaje = '<div>No pude agregar productos que no esten con la fecha actual!!! </div>';
    }
    BootstrapDialog.show({
        title: titulo,
        message: $(mensaje)
    });
}

function editar_promocion(id_promocion) {
    vaciar();
    $("#titulo").text("Modificar Promocion");
    document.getElementById("form_registro").style.display = "block";
    $('#form_promociones')[0].reset();
    document.getElementById("btn_update").style.display = "none";
    $('#btn_edit').attr("disabled", false);
    $('#btn_add').attr("disabled", true);

    $("#c_nombre").removeClass("floating-label");
    $("#c_codigo").removeClass("floating-label");
    $("#c_precio").removeClass("floating-label");
    $("#c_fecha_limite").removeClass("form-floating");
    $("#c_stock").removeClass("floating-label");

    $("#c_producto0").removeClass("form-floating");
    $("#c_cantidad0").removeClass("floating-label");

    $.ajax({
        url: "<?php echo site_url('promociones/C_promociones/datos_promocion')?>/" + id_promocion,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            $('#btnid').val(id_promocion);
            $('#nombre').val(data.nombre);
            $('#codigo').val(data.codigo);
            $('#precio').val(data.precio);
            $('#fecha_limite').val(data.fecha_limite);
            $('#stock').val(data.stock);

            var producto = new Array();
            var cantidad = new Array();
            var obj = JSON.parse(JSON.stringify(data.productos));
            var c = document.getElementById("contador").value;
            var i = 0;
            while (c-- > 0) {
                $('#eliminarContenedor1').trigger('click');
            }
            i = 0;
            var y = document.getElementById("contador").value;
            if (obj.length == 1) {
                $('#producto' + 0).val(obj[0].id_producto).trigger('change');
                $('#cantidad' + 0).val(obj[0].cantidad).trigger('change');
            } else {
                while (i < obj.length - 1) {
                    if (i > 0) {
                        $('#agregarCampo1').trigger('click');
                    }
                    if (y >= 0) {
                        $('#producto' + 0).val(obj[0].id_producto).trigger('change');
                        $('#cantidad' + 0).val(obj[0].cantidad).trigger('change');
                    }
                    $('#producto' + y).val(obj[i].id_producto).trigger('change');
                    $('#cantidad' + y).val(obj[i].cantidad).trigger('change');
                    i++;
                    y++;
                }
                if (i > 0) {
                    $('#agregarCampo1').trigger('click');
                }
                $('#producto' + y).val(obj[i].id_producto).trigger('change');
                $('#cantidad' + y).val(obj[i].cantidad).trigger('change');
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function vaciar() {

    $('#eliminarContenedor1').trigger('click');

}


function eliminar_promocion(id_promocion) {
    var titulo = 'ELIMINAR PROMOCION';
    var mensaje = '<div> Esta seguro que desea Eliminar la promocion </div>';
    BootstrapDialog.show({
        title: titulo,
        message: $(mensaje),
        buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialog) {
                var $button = this;
                $button.disable();
                window.location = '<?= base_url() ?>promociones/C_promociones/dlt_promocion/' +
                    id_promocion;
            }
        }, {
            label: 'Cancelar',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
}

function agregar_promo(msg) {
    if (msg == 0) {
        msg = 'add';
    } else {
        msg = 'edit';
    }
    btnid = document.getElementById("btnid").value;
    nombre = document.getElementById("nombre").value.trim();
    codigo = document.getElementById("codigo").value.trim();
    precio = document.getElementById("precio").value;
    stock = document.getElementById("stock").value;
    fecha_limite = document.getElementById("fecha_limite").value;

    contador = document.getElementById("contador").value;
    producto = document.getElementById("producto0").value;
    cantidad = document.getElementById("cantidad0").value;
    var b = 0;
    if (producto != " " && cantidad != "") {
        prod = Array();
        cant = Array();
        prod.push(producto);
        cant.push(cantidad);
        for (var i = 1; i <= contador; i++) {
            producto = document.getElementById("producto" + i);
            cantidad = document.getElementById("cantidad" + i);
            if(producto !=null && cantidad !=null){
                producto=producto.value;
                cantidad=cantidad.value;
                if (producto != " " && cantidad != "") {
                    prod.push(producto);
                    cant.push(cantidad);
                } else {
                    b = 1;
                }   
            }
        }
        if (b == 0) {
            if (nombre != "" && codigo != "" && precio != "" && stock != "" && fecha_limite != "" && nombre != null &&
                codigo !=
                null && precio != null && stock != null && fecha_limite != null) {
                $.ajax({
                    url: "<?php echo site_url('promociones/C_promociones/add_update_promocion2') ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        btn: msg,
                        btnid: btnid,
                        nombre: nombre,
                        codigo: codigo,
                        precio: precio,
                        stock: stock,
                        fecha_limite: fecha_limite,
                        'prod': JSON.stringify(prod),
                        'cant': JSON.stringify(cant)
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
                                            "<?php echo base_url(); ?>promociones";
                                    } else {
                                        location.href =
                                            "<?php echo base_url(); ?>promociones";
                                    }
                                })
                            }
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax');
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
        } else {
            Swal.fire({
                icon: 'error',
                title: "Por favor termine de llenar todos los campos",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR',
            })
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: "Por favor inserte al menos 1 producto",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ACEPTAR',
        })
    }
}

function actualizar(opcion, producto) {
    $.ajax({
        url: "<?php echo site_url('promociones/C_promociones/calcular_stock') ?>",
        type: "POST",
        datatype: "json",
        data: {
            id_producto: opcion.value,
        },
        success: function(respuesta) {
            var json = JSON.parse(respuesta);
            document.getElementById(producto).innerText = "Cantidad maxima disponible: " + json;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error al obtener datos de ajax');
        }
    });

}
</script>
<?php } else {redirect('inicio');}?>
