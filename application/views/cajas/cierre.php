<?php
/* 
  ---------------------------------------------------------------------------------------------
  Modificado:  Noemi Rosio Vera Velasquez Fecha:24/07/2023, Codigo: GAN-MS-B0-0553
  Descripcion: Se comenta el script bootstrap.min.js, para que se pueda activar las funciones de perfil y notificaciones
  */

?>

<script>
    $(document).ready(function() {
        activarMenu('menu15_3');

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
                <li class="active">Cierre</li>
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
                    <h3 class="text-primary">Listado de cierres
                        <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario(<?php echo ($usrid) ?>)"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nuevo Cierre</button>
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
                                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                        <div class="form-group form-floating">
                                                            <div class="input-group date" id="datePickerApertura">
                                                                <div class="input-group-content" id="c_fecha_cierre">
                                                                    <input type="text" class="form-control" name="fecha_cierre" id="fecha_cierre" onchange="validar()" value="">
                                                                    <label for="fecha_cierre">Fecha de cierre</label>
                                                                </div>
                                                                <span class="input-group-addon"><i class="fa fa-calendar" id="ic_fecha"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="display: flex;">
                                                        <div class="form-group floating-label" id="c_monto">
                                                            <input type="number" class="form-control" name="id_monto_cierre" id="id_monto_cierre" min="0" step=".01" readonly>
                                                            <label for="lb_monto">Monto de cierre en Bs</label>
                                                        </div>
                                                        <div>
                                                            <h3>Bs</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="display: flex;">
                                                        <div class="form-group floating-label" id="c_monto_chica">
                                                            <input type="number" class="form-control" name="id_monto_chica" id="id_monto_chica" min="1" value="1" step=".01">
                                                            <label for="id_monto_chica">Monto caja chica en Bs</label>
                                                            <div id="lb_caja_chica" style="color: #FA5600"></div>
                                                        </div>
                                                        <div>
                                                            <h3>Bs</h3>
                                                        </div>
                                                    </div>
                                                </div>   
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
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
                                            <button type="button" class="btn btn-flat btn-primary ink-reaction" name="btn" onclick="registrar(1)" id="btn_edit" value="edit" disabled>Modificar Cierre</button>
                                            <button type="button" class="btn btn-flat btn-primary ink-reaction" name="btn" onclick="registrar(0)" id="btn_add" value="add">Registrar Cierre</button>
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
                                        <th>Monto a entregar</th>
                                        <th>Monto caja chica</th>
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
                                            <td><?= $item->ochica ?> Bs.</td>
                                            <td>
                                                <button type="button" title="Editar" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="editar(<?= $item->oidcaja ?>,<?= $item->oencargado ?>,<?= $item->omonto ?>,<?= $item->ochica ?>, <?php echo '\''.$item->ofecha.'\'' ?>)"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                                <button type="button" title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(<?= $item->oidcaja ?>)"><i class="fa fa-trash-o fa-lg"></i></button>
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
    var monto_cierre=0;
    var monto_cierre_edit=0;
    $("#id_monto_chica").keyup(function() {
        var caja=document.querySelector('#id_caja').value;
      
        if(caja==-1){
            var valor = document.querySelector('#id_monto_chica').value;

            if (valor == 0){
                var mensaje = 'El monto en caja no puede ser cero.';
                $("#lb_caja_chica").html(mensaje);
            }else{
                var monto=monto_cierre - valor;
                $('#id_monto_cierre').val(monto);
                $("#lb_caja_chica").html('');
            }
        
        }else{
            var valorb = document.querySelector('#id_monto_chica').value;
           
            if (valorb == 0){
                var mensaje = 'El monto en caja no puede ser cero.';
                $("#lb_caja_chica").html(mensaje);
            }else{
                var chica=monto_cierre_edit - valorb;
                $('#id_monto_cierre').val(chica);
                $("#lb_caja_chica").html('');
            }
        }
    })
    function editar(idcaja, idencargado, monto,chica, fecha) {
        document.getElementById("fecha_cierre").disabled = true;
        document.getElementById("ic_fecha").style.display = "none";
        $('#btn_add').attr("disabled", true);
        $('#btn_edit').attr("disabled", false);
        $("#titulo").text("Modificar Cierre");
        document.getElementById("form_registro").style.display = "block";
        $('#form_apertura')[0].reset();
        document.getElementById("btn_update").style.display = "none";

        $('#id_caja').val(idcaja);
        $('#usuario').val(idencargado).trigger('change');
        $('#fecha_cierre').val(fecha);
        $('#id_monto_cierre').val(monto);
        monto_cierre_edit=monto+chica;
        $('#id_monto_chica').val(chica);
    }

    function eliminar(id) {
        var titulo = 'ELIMINAR CIERRE';
        var mensaje = '<div> Esta seguro que desea Eliminar el cierre </div>';
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
                        url: "<?php echo site_url('cajas/C_cierre/dlt_cierre') ?>/" + id,
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
        document.getElementById("fecha_cierre").disabled = false;
        document.getElementById("ic_fecha").style.display = "block";
        $('#btn_edit').attr("disabled", true);
        $('#btn_add').attr("disabled", false);
        $('#usuario').val(usrid).trigger('change');
        $("#titulo").text("Registrar Cierre");
       // $('#form_apertura')[0].reset();
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


    function cerrar_formulario() {
        document.getElementById("form_registro").style.display = "none";
        //$('#form_apertura')[0].reset();
        document.getElementById("list").innerHTML = '';
    }

    function update_formulario() {
        //$('#form_apertura')[0].reset();
        document.getElementById("list").innerHTML = '';
        $('#btn_edit').attr("disabled", true);
        $('#btn_add').attr("disabled", false);
    }

    function validar() {
        var fec = document.getElementById("fecha_cierre").value;
        console.log(fec);
        $.ajax({
            url: "<?php echo site_url('datos_cierre') ?>",
            type: "POST",
            data:{
                fecha:fec,
            },
            success: function(data) {
                var json = JSON.parse(data);
                console.log(json);
                monto_cierre=json[0].omonto_total;
                if(monto_cierre==0){
                    $('#id_monto_cierre').val(0);
                    $('#id_monto_chica').val(0);
                }else{
                    $('#id_monto_cierre').val((monto_cierre)-1.0);
                    $('#id_monto_chica').val(1);
                }
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
        
        fec = fec.split("/");
        if (parseInt(fec[0], 10) < anio) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La fecha de cierre no puede ser una anio pasado',
            })
            $('[name="fecha_cierre"]').val(fecha_actual);
        } else if (parseInt(fec[1], 10) < mes) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La fecha de cierre no puede ser una fecha pasada',
            })
            $('[name="fecha_cierre"]').val(fecha_actual);
        } else if (parseInt(fec[2], 10) < dia) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La fecha de cierre no puede ser una fecha pasada',
            })
            $('[name="fecha_cierre"]').val(fecha_actual);
        }
    }

    function registrar(msg) {
        fecha_cierre = document.getElementById("fecha_cierre").value.trim();
        monto_cierre = document.getElementById("id_monto_cierre").value;
        monto_chica = document.getElementById("id_monto_chica").value;
        usuario_cierre = document.getElementById("usuario").value;
        id_caja = document.getElementById("id_caja").value;

        if (fecha_cierre != "" && monto_cierre != "" && usuario_cierre != "") {
            const dataToSend = {
                btn: msg,
                fecha_cierre: fecha_cierre,
                monto_cierre: monto_cierre,
                monto_chica: monto_chica,
                usuario_cierre: usuario_cierre,
                id_caja: id_caja
            };
            $.ajax({
                url: "<?php echo site_url('cajas/C_cierre/registrar_cierre') ?>",
                type: "POST",
                datatype: "json",
                data: dataToSend,
                success: function(respuesta) {
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
                            if (msg == 0) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se registro con exito',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href =
                                            "<?php echo base_url(); ?>cierre";
                                    } else {}
                                })
                                location.href = "<?php echo base_url(); ?>cierre";
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se modifico con exito',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href =
                                            "<?php echo base_url(); ?>cierre";
                                    } else {}
                                })
                                location.href = "<?php echo base_url(); ?>cierre";
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