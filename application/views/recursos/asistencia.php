<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:03/03/2023, Codigo: GAN-DPR-M6-0335,
Descripcion: Se diseño el frontend del sub mudulo de asistencia.
 */
?>
<?php if (in_array("smod_recur_asis", $permisos)) { ?>

<input type="hidden" name="ubicacion" id="ubicacion" value="<?php echo $id_ubicacion ?>">

<script type="text/javascript">
    var f = new Date();
    fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
    var id_ubi = $("#ubicacion").val();

    $(document).ready(function() {
        activarMenu('menu16', 1);
        $('[name="fecha_inicial"]').val(fecha_actual);
        $('[name="fecha_fin"]').val(fecha_actual);
        $('[name="ubi_trabajo"]').val(id_ubi);

    });
</script>

<script>
    function enviar(destino) {
        document.form_busqueda.action = destino;
        document.form_busqueda.submit();
    }
</script>

<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="#">Recursos</a></li>
                <li class="active">Asistencia</li>
            </ol>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form class="form" name="form_busqueda" id="form_busqueda" method="post" target="_blank">
                        <div class="card">
                            <div class="card-head style-default-light">
                                <div class="tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="PDF" formtarget="_blank" onclick="enviar('<?= site_url() ?>pdf_reporte_ventas')"><img src="<?= base_url() ?>assets/img/icoLogo/pdf.png" /></button>
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-primary" title="EXCEL" formtarget="_blank" onclick="enviar('<?= site_url() ?>excel_reporte_ventas')"><img src="<?= base_url() ?>assets/img/icoLogo/excel.png" /></button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <br>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-right">
                                        <img style="height: 65px;" src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes);
                                                                                            print($obj->{'logo'}); ?>">
                                    </div>

                                    <div class="col-xs-9 col-sm-9 col-md-7 col-lg-7 text-center">
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> EMPRESA <?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                                                                                                    print_r($obj->{'titulo'}); ?> </h5>
                                        <h5 class="text-ultra-bold" style="color:#655e60;"> REPORTE DE ASISTENCIA</h5>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="text-align: center;">
                                        <br>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <select class="form-control select2-list" id="usuario" name="usuario" required>
                                                    <?php foreach ($lista_usuarios as $usr) {  ?>
                                                        <option value="<?php echo $usr->id_usuario ?>" <?php echo set_select('usuario', $usr->id_usuario) ?>> <?php echo $usr->nombre . ' ' . $usr->paterno . ' ' . $usr->materno ?></option>
                                                    <?php  } ?>
                                                </select>
                                                <label for="ubi_trabajo">Usuario</label>
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
                                            <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" type="button">Generar Reporte</button>
                                            <br><br>

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
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="text-align: center;">
                                        <br><br><br>
                                        <h5 class="text-ultra-bold" style="color:#655e60;">TOTAL MINUTOS ACUMULADOS:</h5>
                                        <h5 id="min_acumulados" class="text-ultra-bold" style="color:#655e60;"></h5>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="datatable3" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5%">N&deg;</th>
                                                    <th width="10%">FECHA</th>
                                                    <th width="10%">HORA DE INGRESO</th>
                                                    <th width="10%">TIEMPO DE RETRASO INGRESO</th>
                                                    <th width="10%">HORA DE SALIDA</th>
                                                    <th width="10%">TIEMPO DE RETRASO SALIDA</th>
                                                    <th width="10%">TOTAL RETRASO</th>
                                                    <th width="10%">TIPO DE HORARIO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td>1</td>
                                                <td>02-03-2023</td>
                                                <td>07:58</td>
                                                <td>0 min</td>
                                                <td>17:50</td>
                                                <td>10 min</td>
                                                <td>10 min</td>
                                                <td>REGULAR</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div><br> </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
<!-- END CONTENT -->
<!--  Datatables JS-->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- SUM()  Datatables-->
<script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>

<script type="text/javascript">
</script>
<?php } else {redirect('inicio');}?>