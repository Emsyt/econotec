<?php
/* 
  -------------------------------------------------------------------------------------------------------
  Modificado:  Noemi Rosio Vera Velasquez Fecha:24/07/2023, Codigo: GAN-MS-B0-0553
  Descripcion: Se comenta el script bootstrap.min.js, para que se pueda activar las funciones de perfil y notificaciones
  */

?>

<script>
    $(document).ready(function() {
        activarMenu('menu15_1');
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
                <li class="active">Apertura</li>
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
                    <h3 class="text-primary">Listado de aperturas
                        <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario(<?php echo ($usrid) ?>)"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nueva Apertura</button>
                    </h3>
                    <hr>
                </div>
            </div>

            <div class="row" style="display: none;" id="form_registro">
                <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
                    <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <form class="form form-validate" novalidate="novalidate" name="form_apertura" id="form_apertura" method="post">
                                <input type="hidden" name="name_caja" id="id_caja" value="-1">

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
                                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                                        <div class="form-group form-floating">
                                                            <div class="input-group date" id="datePickerApertura">
                                                                <div class="input-group-content" id="c_fecha_apertura">
                                                                    <input type="text" class="form-control" name="fecha_apertura" id="fecha_apertura" onchange="validar()" value="" readonly>
                                                                    <label for="fecha_apertura">Fecha de apertura</label>
                                                                </div>
                                                                <span class="input-group-addon"><i class="fa fa-calendar" id="ic_fecha"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="display: flex;">
                                                        <div class="form-group floating-label" id="c_monto">
                                                            <input type="number" class="form-control" name="id_monto" id="id_monto" min="0" onchange="validarprecio()" step=".01" required>
                                                            <label for="id_monto">Monto en Bs</label>
                                                            <div id="valormonto" style="color: #FA5600">.</div>
                                                        </div>
                                                        <div>
                                                            <h3>Bs</h3>
                                                        </div>
                                                    </div>
                                                </div>   
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                              <div class="form-group floating-label">
                                                                    <select class="form-control select2-list" id="usuario" name="usuario" required>
                                                                        <option value="">Seleccione Usuario</option>
                                                                        <?php foreach ($lista_usuarios as $usr) {  ?>
                                                                            <option value="<?php echo $usr->id_usuario ?>" <?php echo set_select('usuario', $usr->id_usuario) ?>> <?php echo $usr->nombre . ' ' . $usr->paterno . ' ' . $usr->materno ?></option>
                                                                        <?php  } ?>
                                                                    </select>
                                                                    <label for="usuario">Usuario</label>
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
                                    <div class="card-actionbar">
                                        <div class="card-actionbar-row">
                                            <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="registrar(1)" name="btn" id="btn_edit" value="edit" disabled>Modificar Apertura</button>
                                            <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="registrar(0)" name="btn" id="btn_add" value="add">Registrar Apertura</button>
                                        </div>
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
                                        <th>Encargado</th>
                                        <th>Monto</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <?php $nro = 1 ?>
                                <?php foreach ($items as $item) : ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $nro ?></td>
                                            <td><?= $item->ofecha ?></td>
                                            <td><?= $item->onombre ?></td>
                                            <td><?= $item->omonto ?> Bs.</td>
                                            <td>
                                                <button type="button" title="Editar" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar(<?= $item->oidcaja ?>,<?= $item->oencargado ?>,<?= $item->omonto ?>, <?php echo '\''.$item->ofecha.'\'' ?>)"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                            <?php if ($item->ocierre=='si') {?>
                                                <button type="button" disabled title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(<?= $item->oidcaja ?>)"><i class="fa fa-trash-o fa-lg"></i></button>
                                            <?php }else {?>
                                                <button type="button" title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(<?= $item->oidcaja ?>)"><i class="fa fa-trash-o fa-lg"></i></button>
                                            <?php }?>
                                            </td>
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
    function editar(idcaja, idencargado, saldo, fecha) {
        document.getElementById("fecha_apertura").disabled = true;
        document.getElementById("ic_fecha").style.display = "none";
        $('#btn_add').attr("disabled", true);
        $('#btn_edit').attr("disabled", false);
        $("#titulo").text("Modificar Apertura");
        document.getElementById("form_registro").style.display = "block";
        $('#form_apertura')[0].reset();
        document.getElementById("btn_update").style.display = "none";

        $('#id_caja').val(idcaja);
        $('#usuario').val(idencargado).trigger('change');
        $('#fecha_apertura').val(fecha);
        $('#id_monto').val(saldo);

    }

    function eliminar(id) {
        var titulo = 'ELIMINAR APERTURA';
        var mensaje = '<div> Esta seguro que desea Eliminar la apertura </div>';
        BootstrapDialog.show({
            title: titulo,
            message: $(mensaje),
            buttons: [{
                label: 'Aceptar',
                cssClass: 'btn-primary',
                action: function(dialog) {
                    var $button = this;
                    $button.disable();
                    $.ajax({
                        url: "<?php echo site_url('cajas/C_apertura/dlt_apertura') ?>/" + id,
                        type: "POST",
                        // dataType: "JSON",
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Se elimino con éxito',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ACEPTAR',
                            }).then((result) => {
                                location.reload();
                            })
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error get data from ajax');
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

    function formulario(usrid) {
        // alert(usrid)
        document.getElementById("fecha_apertura").disabled = false;
        document.getElementById("ic_fecha").style.display = "block";
        $('#btn_edit').attr("disabled", true);
        $('#btn_add').attr("disabled", false);
        $('#usuario').val(usrid).trigger('change');
        $("#titulo").text("Registrar Apertura");
        
        document.getElementById("list").innerHTML = '';
        document.getElementById("form_registro").style.display = "block";
        document.getElementById("btn_update").style.display = "block";

        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var optComponent = {
            format: 'yyyy-mm-dd',
            container: '#datePickerApertura',
            orientation: 'auto top',
            todayHighlight: true,
            autoclose: true
        };
        // COMPONENT
        $('#datePickerApertura').datepicker(optComponent);
        $('#datePickerApertura').datepicker('setDate', today);
    }

    // function validarprecio() {

    //     monto = document.getElementById("id_monto").value;

    //     if (monto < 0) {

    //         var mensaje = 'El monto no debe ser menor a 0';
    //         $("#valormonto").html(mensaje);

    //     } else {

    //         $("#valormonto").html('');
    //     }

    // }

    function cerrar_formulario() {
        document.getElementById("form_registro").style.display = "none";
        $('#form_apertura')[0].reset();
        document.getElementById("list").innerHTML = '';
    }

    function update_formulario() {
        $('#form_apertura')[0].reset();
        document.getElementById("list").innerHTML = '';
        $('#btn_edit').attr("disabled", true);
        $('#btn_add').attr("disabled", false);
    }

    function validar() {
        var fec = document.getElementById("fecha_apertura").value;
        console.log(fec);
        $.ajax({
            url: "<?php echo site_url('datos_apertura') ?>",
            type: "POST",
            data:{
                fecha:fec,
            },
            success: function(data) {
                var json = JSON.parse(data);
                console.log(json);
                monto_apertura=json[0].omonto_saldo;
                
                $('#id_monto').val(monto_apertura);
                $('#c_monto').removeClass('floating-label');
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
        var f = new Date();
        fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
        var anio = f.getFullYear();
        var mes = (f.getMonth() + 1);
        var dia = f.getDate();
        var fec = document.getElementById("fecha_apertura").value;
        fec = fec.split("/");
        if (parseInt(fec[0], 10) < anio) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La fecha de apertura no puede ser un anio pasado',
            })
            $('[name="fecha_apertura"]').val(fecha_actual);
        } else if (parseInt(fec[1], 10) < mes) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La fecha de apertura no puede ser una fecha pasada',
            })
            $('[name="fecha_apertura"]').val(fecha_actual);
        } else if (parseInt(fec[2], 10) < dia) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La fecha de apertura no puede ser una fecha pasada',
            })
            $('[name="fecha_apertura"]').val(fecha_actual);
        }
    }

    function registrar(msg) {
        fecha_aper = document.getElementById("fecha_apertura").value.trim();
        monto_aper = document.getElementById("id_monto").value;
        usuario_aper = document.getElementById("usuario").value;
        id_caja = document.getElementById("id_caja").value;
        if (fecha_aper != "" && monto_aper != "" && usuario_aper != "") {
            const dataToSend = {
                btn: msg,
                fecha_aper: fecha_aper,
                monto_aper: monto_aper,
                usuario_aper: usuario_aper,
                id_caja: id_caja
            };
            $.ajax({
                url: "<?php echo site_url('cajas/C_apertura/registrar_apertura') ?>",
                type: "POST",
                datatype: "json",
                data: dataToSend,
                success: function(respuesta) {
                    console.log(respuesta);
                    var json = JSON.parse(respuesta);
                    $.each(json, function(i, item) {
                        if (item.oboolean == 'f') {
                            document.getElementById("id_monto").value=item.omonto;
                            Swal.fire({
                                icon: 'error',
                                text: item.omensaje,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ACEPTAR',
                            })
                        } else {
                            if (msg == 0) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se registro con exito',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href =
                                            "<?php echo base_url(); ?>apertura";
                                    } else {}
                                })
                                location.href = "<?php echo base_url(); ?>apertura";
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se modifico con exito',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href =
                                            "<?php echo base_url(); ?>apertura";
                                    } else {}
                                })
                                location.href = "<?php echo base_url(); ?>apertura";
                            }
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