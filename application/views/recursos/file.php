<?php
/*
------------------------------------------------------------------------------
Creador: Ariel Ramos Paucara  Fecha 02/03/2023, Codigo: GAN-DPR-B7-0315
Descripcion: Se creo el frontend del sub modulo File Personal  
------------------------------------------------------------------------------
Modificacion: Ariel Ramos Paucara Fecha 15/03/2023, Codigo: GAN-MS-M0-0357
Descripcion: se agregaron todas las funcionalidades correspondientes segun codigo de actividad GAN-MS-M6-242
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 23/03/2023, Codigo: GAN-MS-M4-0368
Descripcion: Se relizo la vista de informacion personal para mostrar y modificar datos personales
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 25/03/2023, Codigo: GAN-MS-M4-0376
Descripcion: Se realizar la previsualizacion y edicion de la imagen del usuario.
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 07/04/2023, Codigo: GAN-MS-B5-0387 
Descripcion: Se agrego el campo expedido del carnet y tambien la misma funcionalidad 
que los campos del formulario.
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 13/04/2023, Codigo: GAN-MS-M0-0407
Descripcion: se agrego el segundo step del modulo file personal de formacion academica
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 22/04/2023, Codigo: GAN-MS-M4-0421
Descripcion: Se modifico el WIZARD 2 para que cuando se aga un registro se 
mantenga en el mismo WIZARD 2 y no se dirija a otro.
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 22/04/2023, Codigo: GAN-MS-M5-0435
Descripcion: Se implemento el modulo de recursos humanos para el caso de File Personal 
en el wizard de Cursos y tambien se implemento la funcionalidad de que se carque en el mismo wizard
*/


?>
<?php if (in_array("smod_recur_file_pers", $permisos)) { ?>
    <script>
        $(document).ready(function() {
            activarMenu('menu16', 8);
        });
    </script>
    <script src="<?= base_url(); ?>assets/libs/leaflet/leaflet.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        hr {
            margin-top: 0px;
        }

        .tab-content>.tab-pane {
            visibility: visible;
        }

        .nav>li>a:hover,
        .nav>li>a:focus {
            background-color: transparent;
        }
    </style>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Recursos Humanos</a></li>
                    <li class="active">File Personal</li>
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
                    <div class="col-md-12">
                        <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
                        <div class="card card-bordered style-primary">
                            <div class="card-body style-default-bright">

                                <!-- SmartWizard html -->
                                <div id="smartwizard">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#step-1">
                                                <div class="num">1</div>
                                                Información Personal
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#step-2">
                                                <span class="num">2</span>
                                                Formación Academica
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#step-3">
                                                <span class="num">3</span>
                                                Cursos
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " href="#step-4">
                                                <span class="num">4</span>
                                                Experiencia Laboral
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- INICIO Oscar Laura Aguirre GAN-MS-M4-0368 -->
                                                    <form class="form form-validate" name="form_user_file" id="form_user_file" novalidate="novalidate" enctype="multipart/form-data" method="post" action="<?= site_url() ?>recursos/C_file/actualizar_fil_per2">
                                                        <input type="hidden" name="foto" id="foto">
                                                        <div class="card">
                                                            <div class="card-head style-primary">
                                                                <header id="titulo">INFORMACIÓN PERSONAL</header>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_nombre">
                                                                            <input type="text" class="form-control" name="nombre_p" id="nombre_p" onchange="return mayuscula(this);" required>
                                                                            <label for="nombre_p">Nombres(s)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_pri_ape">
                                                                            <input type="text" class="form-control" name="pri_ape" id="pri_ape" onchange="return mayuscula(this);" required>
                                                                            <label for="pri_ape">Primer Apellido</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_sec_ape">
                                                                            <input type="text" class="form-control" name="sec_ape" id="sec_ape" onchange="return mayuscula(this);">
                                                                            <label for="sec_ape">Segundo Apellido</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <div class="input-group date" id="demo-date-val2">
                                                                                <div class="input-group-content" id="c_fecha_naci">
                                                                                    <input type="text" class="form-control" name="fecha_n" id="fecha_n" readonly="" required>
                                                                                    <label for="fecha_n" class="control-label" id="label_fecha_naci">Fecha Nacimiento</label>
                                                                                    <span id="error_fecha_n" class="text-danger"></span>
                                                                                </div>
                                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_lug_naci">
                                                                            <input type="text" class="form-control" name="lug_naci" id="lug_naci" onchange="return mayuscula(this);" required>
                                                                            <label for="lug_naci" class="control-label">Lugar de Nacimiento</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_ciu_residencia">
                                                                            <select class="form-control select2-list" id="id_residencia0" name="id_residencia0" required>
                                                                                <option value="">&nbsp;</option>
                                                                                <!--Inicio,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                                                                <?php foreach ($residencia as $resi) { ?>
                                                                                    <option value="<?php echo $resi->oidresidencia ?>" <?php echo set_select('id_residencia0', $resi->oresidencia) ?>>
                                                                                        <?php echo $resi->oresidencia ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                                <!--Fin,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                                                            </select>
                                                                            <label for="id_residencia0">Ciudad de residencia</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_dir_domi">
                                                                            <input type="text" class="form-control" name="dir_domi" id="dir_domi" onchange="return mayuscula(this);" required>
                                                                            <label for="dir_domi">Direcci&oacute;n Domicilio</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_celular">
                                                                            <input type="text" data-rule-number="true" data-rule-minlength="5" class="form-control" name="celular_p" id="celular_p" required>
                                                                            <label for="celular_p">Celular</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_telefono">
                                                                            <input type="text" data-rule-number="true" data-rule-minlength="4" class="form-control" name="telefono_p" id="telefono_p" required>
                                                                            <label for="telefono_p">Teléfono</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_nacionalidad">
                                                                            <select class="form-control select2-list" id="id_nacionalidad0" name="id_nacionalidad0" required>
                                                                                <option value=""></option>
                                                                                <!--Inicio,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                                                                <?php foreach ($nacionalidad as $nac) { ?>
                                                                                    <option value="<?php echo $nac->oidnacionalidad ?>" <?php echo set_select('id_nacionalidad0', $nac->onacionalidad) ?>>
                                                                                        <?php echo $nac->onacionalidad ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                                <!--Fin,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                                                            </select>
                                                                            <label for="id_nacionalidad0">Nacionalidad</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_ced_identidad">
                                                                            <input type="text" class="form-control" data-rule-number="true" data-rule-minlength="6" name="ced_identidad" id="ced_identidad" required>
                                                                            <label for="ced_identidad">C&eacute;dula de Identidad</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <!-- Inicio Oscar Laura Aguirre GAN-MS-B5-0387 -->
                                                                        <div class="form-group floating-label" id="c_expedido">
                                                                            <select class="form-control select2-list" name="expedido" id="expedido" required>
                                                                                <option value="">&nbsp;</option>
                                                                                <?php foreach ($departamentos as $depto) { ?>
                                                                                    <option value="<?php echo $depto->id_departamento ?>" <?php echo set_select('expedido', $depto->id_departamento) ?>> <?php echo $depto->nombre ?> </option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <label for="expedido">Expedido</label>
                                                                        </div>
                                                                        <!-- Inicio Oscar Laura Aguirre GAN-MS-B5-0387 -->
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_genero">
                                                                            <select class="form-control select2-list" id="id_genero" name="id_genero" required>
                                                                                <option value="">&nbsp;</option>
                                                                                <!--Inicio,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                                                                <?php foreach ($genero as $gen) { ?>
                                                                                    <option value="<?php echo $gen->oidgenero ?>" <?php echo set_select('id_genero', $gen->ogenero) ?>>
                                                                                        <?php echo $gen->ogenero ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                                <!--Fin,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                                                            </select>
                                                                            <label for="id_genero">G&eacute;nero</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_civil">
                                                                            <select class="form-control select2-list" id="id_ecivil" name="id_ecivil" required>
                                                                                <option value="">&nbsp;</option>
                                                                                <!--Inicio,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                                                                <?php foreach ($civil as $civ) { ?>
                                                                                    <option value="<?php echo $civ->oidcivil ?>" <?php echo set_select('id_ecivil', $civ->ocivil) ?>>
                                                                                        <?php echo $civ->ocivil ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                                <!--Fin,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                                                            </select>
                                                                            <label for="id_ecivil">Estado Civil</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group floating-label" id="c_califi">
                                                                            <input type="text" class="form-control" data-rule-number="true" name="califi" id="califi" required>
                                                                            <label for="califi">Calificaci&oacute;n</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="demo-date-val3">
                                                                                        <div class="input-group-content" id="c_fec_vin">
                                                                                            <input type="text" class="form-control" name="fec_vin" id="fec_vin" readonly="" required>
                                                                                            <label for="fec_vin" class="control-label" id="label_fec_vin">Fecha Vinculaci&oacute;n</label>
                                                                                            <span id="error_fec_vin" class="text-danger"></span>
                                                                                        </div>
                                                                                        <span class="input-group-addon" id="icono_fecha_fec_vin"><i class="fa fa-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="picker-fecha-inicio">
                                                                                        <div class="input-group-content" id="c_fec_des">
                                                                                            <input type="text" class="form-control" name="fec_des" id="fec_des" readonly="" required>
                                                                                            <label for="fec_des" class="control-label" id="label_fec_des">Fecha Desvinculaci&oacute;n</label>
                                                                                            <span id="error_fec_des" class="text-danger"></span>
                                                                                        </div>
                                                                                        <span class="input-group-addon" id="icono_fecha_fec_des"><i class="fa fa-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group floating-label" id="c_cor_ele">
                                                                                    <input type="email" class="form-control" name="cor_ele" id="cor_ele">
                                                                                    <label for="cor_ele">Correo Electr&oacute;nico</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group floating-label" id="c_cargo">
                                                                                    <input type="text" class="form-control" name="cargo_p" id="cargo_p" required>
                                                                                    <label for="cargo_p">Cargo</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="align-items: center">
                                                                        <!-- <div class="row"> -->
                                                                        <center>
                                                                            <div class="row" style=" display: flex;">
                                                                                <div class="col-sm-4" style="display: flex; text-align: center; overflow: hidden; align-items: center; justify-content: center;">
                                                                                    <table style="width: 110px; height: 110px;">
                                                                                        <tr>
                                                                                            <td><output id="list"></output></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-sm-8" style="color: red; flex-direction: column; overflow: hidden; display: flex; justify-content: center; align-items: center; height: 110px; width: auto;">
                                                                                    <label class="btn btn-primary btn-sm btn-file ink-reaction btn-raised" style="display: flex; align-items: center; justify-content: center;">
                                                                                        Seleccionar Fotograf&iacute;a<input style="display: none" type="file" id="sub_archivo" name="sub_archivo" accept="image/*" class="form-control" />
                                                                                    </label>
                                                                                    <div id="error-message" style="display:none; color:red">Debe seleccionar una imagen.</div>
                                                                                </div>
                                                                            </div>
                                                                        </center>
                                                                    </div>
                                                                    <!-- Fin Oscar Laura Aguirre GAN-MS-M4-0376 -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <!-- Fin Oscar Laura Aguirre GAN-MS-M4-0368 -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form class="form form-validate" novalidate="novalidate" name="" id="" method="post" action="">
                                                        <div class="card">
                                                            <div class="card-head style-primary">
                                                                <div class="tools">
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-default" data-toggle="modal" data-target="#modal_estudios">Agregar Estudios</a>
                                                                    </div>
                                                                </div>
                                                                <header id="titulo">FORMACIÓN ACADÉMICA</header>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="text-divider visible-xs"><span>Listado Formacion Academica</span></div>
                                                                        <div class="card-body style-default-bright">
                                                                            <table id="datatable_id" class="table table-striped table-bordered" style="width: 100%; height: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Nro</th>
                                                                                        <th>Universidad</th>
                                                                                        <th>Nivel_acad</th>
                                                                                        <th>Certificacion</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- INICIO Oscar Laura Aguirre GAN-MS-M5-0435 -->
                                                    <form class="form form-validate" novalidate="novalidate" name="" id="" method="post" action="">
                                                        <div class="card">
                                                            <div class="card-head style-primary">
                                                                <div class="tools">
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-default" data-toggle="modal" data-target="#modal_cursos">Agregar Cursos</a>
                                                                    </div>
                                                                </div>
                                                                <header id="titulo">CURSOS</header>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="text-divider visible-xs"><span>Listado de Cursos</span></div>
                                                                        <div class="card-body style-default-bright">
                                                                            <table id="datatable_curso" class=" table table-striped table-bordered" style="width: 100%; height: 100%;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Nª</th>
                                                                                        <th>Universidad</th>
                                                                                        <th>Tipo Capacitacion</th>
                                                                                        <th>Fecha</th>
                                                                                        <th>Duracion</th>
                                                                                        <th>Acciones</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <!-- FIN Oscar Laura Aguirre GAN-MS-M5-0435 -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form class="form form-validate" novalidate="novalidate" name="" id="" method="post" action="">
                                                        <div class="card">
                                                            <div class="card-head style-primary">
                                                                <div class="tools">
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-default" data-toggle="modal" data-target="#modal_experiencia">Agregar Experiencia Laboral</a>
                                                                    </div>
                                                                </div>
                                                                <header id="titulo">EXPERIENCIA LABORAL</header>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="text-divider visible-xs"><span>Listado Experiencia Laboral</span></div>
                                                                        <div class="card-body style-default-bright">
                                                                            <div id="tabla">
                                                                                <div class="table-responsive">
                                                                                    <table id="datatable" class=" table table-striped table-bordered">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th width="7%">Nª</th>
                                                                                                <th width="31%">Nombre Empresa</th>
                                                                                                <th width="31%">Cargo</th>
                                                                                                <th width="31%">Funcion</th>
                                                                                                <th width="31%">Fecha Inicio</th>
                                                                                                <th width="31%">Fecha Fin</th>
                                                                                                <th width="31%">Acciones</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>1</td>
                                                                                                <td>2</td>
                                                                                                <td>3</td>
                                                                                                <td>4</td>
                                                                                                <td>5</td>
                                                                                                <td>6</td>
                                                                                                <td>7</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Include optional progressbar HTML -->
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <!-- END CONTENT -->

    <!-- BEGIN FORM MODAL ESTUDIOS -->
    <div class="modal fade" name="modal_estudios" id="modal_estudios" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="formModalLabel">FORMULARIO: FORMACIÓN ACADÉMICA</h3>
                </div>
                <form class="form form-validate" name="form_formacion_academica" id="form_formacion_academica" name="form_user_file" novalidate="novalidate" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="c_uni_inst">
                                    <input type="text" class="form-control" name="uni_inst" id="uni_inst" onchange="return mayuscula(this);" required>
                                    <label for="sigla">Universidad / Institución</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="c_niv_acad">
                                    <select class="form-control select2-list" id="id_nacademico" name="id_nacademico" required>
                                        <option value="">&nbsp;</option>
                                        <!--Inicio,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                        <?php foreach ($nacademico as $naca) { ?>
                                            <option value="<?php echo $naca->oidnacademico ?>">
                                                <?php echo $naca->onacademico ?>
                                            </option>
                                        <?php } ?>
                                        <!--Fin,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                    </select>
                                    <label for="id_nacademico">Nivel Académico</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="c_cer_acre_pos">
                                    <select class="form-control select2-list" id="id_certificacion" name="id_certificacion" required>
                                        <option value="">&nbsp;</option>
                                        <?php foreach ($certificacion as $cer) { ?>
                                            <option value="<?php echo $cer->oidcertificacion ?>">
                                                <?php echo $cer->ocertificacion ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <label for="id_certificacion">Certificación que acredita el/la postulante</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group date" id="demo-date-val">
                                        <div class="input-group-content" id="c_fecha_emi_cer">
                                            <input type="text" class="form-control" name="fecha_emi_cer" id="fecha_emi_cer" readonly="" required>
                                            <label for="fecha_emi_cer" class="col-sm-4 control-label" id="">Fecha de Emisión del Certificado</label>
                                            <span id="error_fecha_emi_cer" class="text-danger"></span>
                                        </div>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- <div class="form-group floating-label" id=""> -->
                                <div class="form-group" id="">
                                    <input type="file" class="form-control" name="sub_arch" id="sub_arch">
                                    <!-- <label for="">Subir Archivo</label> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END FORM MODAL ESTUDIOS -->

    <!-- BEGIN FORM MODAL CURSOS -->
    <div class="modal fade" name="modal_cursos" id="modal_cursos" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="formModalLabel">FORMULARIO: (SEMINARIOS, CURSOS O TALLERES)</h3>
                </div>
                <!-- INICIO Oscar Laura Aguirre GAN-MS-M5-0435 -->
                <form class="form form-validate" name="form_semi_cur_tall" id="form_semi_cur_tall" novalidate="novalidate" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="id_con_uni_inst_aus">
                                    <input type="text" class="form-control" name="id_uni_inst_aus" id="id_uni_inst_aus" onchange="return mayuscula(this);" required>
                                    <label for="sigla">Universidad/Institución Auspiciadora</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label">
                                    <select class="form-control select2-list" id="id_capacitacion" name="id_capacitacion" required>
                                        <option value="">&nbsp;</option>
                                        <!--Inicio,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                        <?php foreach ($capacitacion as $cap) { ?>
                                            <option value="<?php echo $cap->oidcapacitacion ?>">
                                                <?php echo $cap->ocapacitacion ?>
                                            </option>
                                        <?php } ?>
                                        <!--Fin,Ariel Ramos Paucara, 15/03/2023 ,GAN-MS-M0-0357-->
                                    </select>
                                    <label for="id_capacitacion">Tipo de capacitación</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="id_con_id_nom_cur_sem_tal">
                                    <input type="text" class="form-control" name="id_nom_cur_sem_tal" id="id_nom_cur_sem_tal" onchange="return mayuscula(this);" required>
                                    <label for="sigla">Nombre del Curso/Seminario/Taller</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div style="padding-top: 9px;">
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="id_participacion" id="id_participacion" value="0" checked=""><span style="font-size: 16px;">Participación:</span>
                                        </label>
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="id_aprobacion" id="id_aprobacion" value="1"><span style="font-size: 16px;">Aprobación:</span>
                                        </label>
                                    </div>
                                    <label for="garantia">Certificado Obtenido</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group date" id="demo-val_emi-val3">
                                        <div class="input-group-content" id="id_con_fecha_emi_cer">
                                            <input type="text" class="form-control" name="id_fecha_emi_cer" id="id_fecha_emi_cer" readonly="" required>
                                            <label for="fec_vin" class="control-label" id="label_fec_vin">Fecha Vinculaci&oacute;n</label>
                                            <span id="error_id_fecha_emi_cer" class="text-danger"></span>
                                        </div>
                                        <span class="input-group-addon" id="icono_fecha_fec_vin"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="id_con_dur_hor_aca">
                                    <input type="text" class="form-control" name="id_dur_hor_aca" id="id_dur_hor_aca" onchange="return mayuscula(this);" required>
                                    <label for="sigla">Duración (Horas Académicas)</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="id_con_arch_curso">
                                    <input type="file" class="form-control" name="id_arch_curso" id="id_arch_curso">
                                    <label for="id_arch_curso">Subir Archivo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
                <!-- FIN Oscar Laura Aguirre GAN-MS-M5-0435 -->
            </div>
        </div>
    </div>
    <!-- END FORM MODAL CURSOS -->

    <!-- BEGIN FORM MODAL EXPERIENCIA LABORAL -->
    <div class="modal fade" name="modal_experiencia" id="modal_experiencia" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="formModalLabel">FORMULARIO: EXPERIENCIA LABORAL</h3>
                </div>
                <form class="form" role="form" name="" id="" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="">
                                    <input type="text" class="form-control" name="" id="" onchange="return mayuscula(this);">
                                    <label for="sigla">Nombre de la Entidad o Empresa</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="">
                                    <input type="text" class="form-control" name="" id="" onchange="return mayuscula(this);">
                                    <label for="sigla">Cargo Desempeñado</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="">
                                    <textarea class="form-control" name="" id="" rows="3"></textarea>
                                    <label for="descripcion">Función(es) Desarrollada(s) (Resumen):</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div style="padding-top: 9px;">
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="" id="" value="0" checked=""><span style="font-size: 16px;">Pública:</span>
                                        </label>
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="" id="" value="1"><span style="font-size: 16px;">Privada:</span>
                                        </label>
                                    </div>
                                    <label for="garantia">Institución</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group date" id="demo-date-val">
                                        <div class="input-group-content" id="">
                                            <input type="text" class="form-control" name="" id="" readonly="" required>
                                            <label for="" class="col-sm-4 control-label" id="">Fecha Inicio</label>
                                        </div>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group date" id="demo-date-val">
                                        <div class="input-group-content" id="">
                                            <input type="text" class="form-control" name="" id="" readonly="" required>
                                            <label for="" class="col-sm-4 control-label" id="">Fecha Culminación</label>
                                        </div>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group floating-label" id="">
                                    <input type="file" class="form-control" name="" id="">
                                    <label for="">Subir Archivo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnGuardar" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END FORM MODAL EXPERIENCIA LABORAL -->
    <!--  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
    <!--  Datatables JS-->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- SUM()  Datatables-->
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
    <script type="text/javascript">
        // $(document).ready(function() {



        $('#smartwizard').smartWizard({
            selected: 0, // Initial selected step, 0 = first step
            theme: 'dots', // theme for the wizard, related css need to include for other than basic theme
            justified: true, // Nav menu justification. true/false
            autoAdjustHeight: true, // Automatically adjust content height
            backButtonSupport: true, // Enable the back button support
            enableUrlHash: true, // Enable selection of the step based on url hash
            transition: {
                animation: 'none', // Animation effect on navigation, none|fade|slideHorizontal|slideVertical|slideSwing|css(Animation CSS class also need to specify)
                speed: '400', // Animation speed. Not used if animation is 'css'
                easing: '', // Animation easing. Not supported without a jQuery easing plugin. Not used if animation is 'css'
                prefixCss: '', // Only used if animation is 'css'. Animation CSS prefix
                fwdShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on forward direction
                fwdHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on forward direction
                bckShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on backward direction
                bckHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on backward direction
            },
            toolbar: {
                position: 'bottom', // none|top|bottom|both
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                extraHtml: '' // Extra html to show on toolbar
            },
            anchor: {
                enableNavigation: true, // Enable/Disable anchor navigation 
                enableNavigationAlways: false, // Activates all anchors clickable always
                enableDoneState: true, // Add done state on visited steps
                markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
                enableDoneStateNavigation: true // Enable/Disable the done state navigation
            },
            keyboard: {
                keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                keyLeft: [37], // Left key code
                keyRight: [39] // Right key code
            },
            lang: { // Language variables for button
                next: 'Siguiente',
                previous: 'Atras'
            },
            disabledSteps: [], // Array Steps disabled
            errorSteps: [], // Array Steps error
            warningSteps: [], // Array Steps warning
            hiddenSteps: [], // Hidden steps
            getContent: null // Callback function for content loading
        });
        /* INICIO Oscar Laura Aguirre GAN-MS-M4-0368 */
        $('#nombre_p').prop("required", true);
        $('#pri_ape').prop("required", true);
        $('#fecha_n').prop("required", true);
        $('#lug_naci').prop("required", true);
        $('#id_residencia0').prop("required", true);
        $('#dir_domi').prop("required", true);
        $('#celular_p').prop("required", true);
        $('#telefono_p').prop("required", true);
        $('#id_nacionalidad').prop("required", true);
        $('#ced_identidad').prop("required", true);
        /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
        $('#expedido').prop("required", true);
        /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
        $('#id_genero').prop("required", true);
        $('#id_ecivil').prop("required", true);
        // $('#sub_archivo').prop("required", true);
        // $('#list').prop("required", true);
        $('#cargo_p').prop("required", true);
        $('#fec_vin').prop("required", true);
        $('#fec_des').prop("required", true);
        $('#califi').prop("required", true);
        $("#c_nombre").removeClass("floating-label");
        $("#c_pri_ape").removeClass("floating-label");
        $("#c_lug_naci").removeClass("floating-label");
        $("#c_ciu_residencia").removeClass("floating-label");
        $("#c_dir_domi").removeClass("floating-label");
        $("#c_celular").removeClass("floating-label");
        $("#c_telefono").removeClass("floating-label");
        $("#c_nacionalidad").removeClass("floating-label");
        $("#c_ced_identidad").removeClass("floating-label");
        /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
        $("#c_expedido").removeClass("floating-label");
        /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
        $("#c_genero").removeClass("floating-label");
        $("#c_civil").removeClass("floating-label");
        // $("#c_sub_archivo").removeClass("floating-label");
        $("#c_cargo").removeClass("floating-label");
        $("#c_califi").removeClass("floating-label");

        $.ajax({
            url: "<?php echo site_url('recursos/C_file/mostrar_usuario') ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                console.log(data[0]);
                if (data[0].materno != "" && data[0].materno != null) {
                    $("#c_sec_ape").removeClass("floating-label");
                }
                if (data[0].correo != "" && data[0].correo != null) {
                    $("#c_cor_ele").removeClass("floating-label");
                }
                $('[name="nombre_p"]').val(data[0].nombre);
                $('[name="pri_ape"]').val(data[0].paterno);
                $('[name="sec_ape"]').val(data[0].materno);
                let fn = '';
                if (data[0].fec_nacimiento === null || data[0].fec_nacimiento === '') {
                    fn = data[0].fec_nacimiento;
                } else {
                    fn = data[0].fec_nacimiento.replace(/-/g, '/');
                }
                $('[name="fecha_n"]').val(fn);
                $('[name="lug_naci"]').val(data[0].lugar_nac);
                $('[name="id_residencia0"]').val(data[0].ciudad_rec).trigger('change');
                $('[name="dir_domi"]').val(data[0].dir_dom);
                $('[name="celular_p"]').val(data[0].celular);
                $('[name="telefono_p"]').val(data[0].telefono);
                $('[name="id_nacionalidad0"]').val(data[0].nacionalidad).trigger('change');
                $('[name="ced_identidad"]').val(data[0].carnet);
                /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
                $('[name="expedido"]').val(data[0].id_departamento).trigger('change');
                /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
                if (data[0].genero + '' === '1') {
                    $('[name="id_genero"]').val('1379').trigger('change');
                } else {
                    $('[name="id_genero"]').val('1380').trigger('change');
                }
                /* let inputFile = document.getElementById('sub_archivo');
                inputFile.value = null; */
                $('[name="cor_ele"]').val(data[0].correo);
                $('[name="id_ecivil"]').val(data[0].est_civ).trigger('change');
                $('[name="foto"]').val(data[0].foto);
                if (data[0].foto == null || data[0].foto == '') {
                    /* display: flex; align-items: center;  */
                    dato = '<p style="display: flex; align-items: center; text-align: start; font-family: impact; font-size: 20px; color: #696969;"> Sin Foto </p>';
                    document.getElementById("list").innerHTML = dato;
                    $('#sub_archivo').prop("required", true);
                } else {
                    dato = '<img src="<?php echo base_url(); ?>assets/img/personal/' + data[0].foto + '" class="img-responsive" style="width: 100px; height: 100px; margin-bottom: 5px;"> ';
                    document.getElementById("list").innerHTML = dato;
                }
                $('[name="cargo_p"]').val(data[0].cargo);
                // $('[name="fec_vin"]').val(((data[0].fecvin).replace(/-/g, '/')));   // <-- mostrar con barra
                // $('[name="fec_des"]').val((data[0].fecdesv).replace(/-/g, '/'));   //  
                let fv = '';
                let fd = '';
                if (data[0].fecvin === null || data[0].fecvin === '') {
                    fv = data[0].fecvin;
                } else {
                    fv = data[0].fecvin.replace(/-/g, '/');
                }
                if (data[0].fecdesv === null || data[0].fecdesv === '') {
                    fd = data[0].fecdesv;
                } else {
                    fd = data[0].fecdesv.replace(/-/g, '/');
                }
                $('[name="fec_vin"]').val(fv); /* leaflex google apis */
                $('[name="fec_des"]').val(fd);
                $('[name="califi"]').val(data[0].cas);
                $('#fecha_n').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy/mm/dd",
                    language: "es",
                    minDate: 0
                });
                $('#fec_vin').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy/mm/dd",
                    language: "es",
                    minDate: 0
                });
                $('#fec_des').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy/mm/dd ",
                    language: "es",
                    minDate: 0
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
        $('#demo-date-val2').click(function() {
            $('#fecha_n').datepicker('show');
        });
        $('#fecha_n').on('change', function() {
            $('#fecha_n').datepicker('hide');
        });

        $('#demo-date-val3').click(function() {
            $('#fec_vin').datepicker('show');
        });
        $('#fec_vin').on('change', function() {
            $('#fec_vin').datepicker('hide');
        });
        // muestra el calendario
        $('#picker-fecha-inicio').click(function() {
            $('#fec_des').datepicker('show');
        });
        // oculta el calendario
        $('#fec_des').on('change', function() {
            $('#fec_des').datepicker('hide');
        });
        $('#demo-date-val_emi').click(function() {
            $('#id_fecha_emi_cer').datepicker('show');
        });
        $('#id_fecha_emi_cer').on('change', function() {
            $('#id_fecha_emi_cer').datepicker('hide');
        });
        // sirve para quitar la letra roja de error cuando se hace click en la fecha
        /* $('#fecha_n').on('focus', function() {
            $('#error_fecha_n').text('');
        }); */
        // sirve para quitar la letra roja de error cuando se cambia el valor de la fecha
        $('#fecha_n').on('change', function() {
            $('#error_fecha_n').text('');
        });
        $('#fec_vin').on('change', function() {
            $('#error_fec_vin').text('');
        });
        $('#fec_des').on('change', function() {
            $('#error_fec_des').text('');
        });
        $('#fecha_emi_cer').on('change', function() {
            $('#error_fecha_emi_cer').text('');
        });
        $('#id_fecha_emi_cer').on('change', function() {
            $('#error_id_fecha_emi_cer').text('');
        });
        // });
        $(document).ready(function() {
            $('#id_fecha_emi_cer').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: "yyyy/mm/dd",
                language: "es",
                minDate: 0
            });
            $('[name="id_fecha_emi_cer"]').val(null);
        })
        // });
    </script>
    <script>
        /* Inicio Oscar Laura Aguirre GAN-MS-M4-0376 */
        $("#smartwizard").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
            /*if (stepDirection === 'forward' && nextStepIndex === 1) {
                if (document.getElementById('cargo_p').value === '') {
                    console.log("El campo 'cargo_p' está vacío");
                }
                if (document.getElementById('ced_identidad').value === '') {
                    console.log("El campo 'ced_identidad' está vacío");
                }
                if (document.getElementById('expedido').value === '') {
                    console.log("El campo 'expedido' está vacío");
                }
                if (document.getElementById('califi').value === '') {
                    console.log("El campo 'califi' está vacío");
                }
                if (document.getElementById('celular_p').value === '') {
                    console.log("El campo 'celular_p' está vacío");
                }
                if (document.getElementById('id_residencia0').value === '') {
                    console.log("El campo 'id_residencia0' está vacío");
                }
                if (document.getElementById('dir_domi').value === '') {
                    console.log("El campo 'dir_domi' está vacío");
                }
                if (document.getElementById('id_ecivil').value === '') {
                    console.log("El campo 'id_ecivil' está vacío");
                }
                if (document.getElementById('id_residencia0').value === '') {
                    console.log("El campo 'id_residencia0' está vacío");
                }
                if (document.getElementById('fecha_n').value === '') {
                    console.log("El campo 'fecha_n' está vacío");
                }
                if (document.getElementById('fec_des').value === '') {
                    console.log("El campo 'fec_des' está vacío");
                }
                if (document.getElementById('fec_vin').value === '') {
                    console.log("El campo 'fec_vin' está vacío");
                }
                if (document.getElementById('foto').value === '') {
                    console.log("El campo 'foto' está vacío");
                }
                if (document.getElementById('id_genero').value === '') {
                    console.log("El campo 'id_genero' está vacío");
                }
                if (document.getElementById('lug_naci').value === '') {
                    console.log("El campo 'lug_naci' está vacío");
                }
                if (document.getElementById('id_nacionalidad0').value === '') {
                    console.log("El campo 'id_nacionalidad0' está vacío");
                }
                if (document.getElementById('nombre_p').value === '') {
                    console.log("El campo 'nombre_p' está vacío");
                }
                if (document.getElementById('pri_ape').value === '') {
                    console.log("El campo 'pri_ape' está vacío");
                }
                if (document.getElementById('telefono_p').value === '') {
                    console.log("El campo 'telefono_p' está vacío");
                }
            } */

            if ((document.getElementById('cargo_p').value === '' ||
                    document.getElementById('ced_identidad').value === '' ||
                    document.getElementById('expedido').value === '' ||
                    document.getElementById('califi').value === '' ||
                    document.getElementById('celular_p').value === '' ||
                    document.getElementById('id_residencia0').value === '' ||
                    // document.getElementById('cor_ele').value === '' ||
                    document.getElementById('dir_domi').value === '' ||
                    document.getElementById('id_ecivil').value === '' ||
                    document.getElementById('fecha_n').value === '' ||
                    document.getElementById('fec_des').value === '' ||
                    document.getElementById('fec_vin').value === '' ||
                    document.getElementById('foto').value === '' ||
                    document.getElementById('id_genero').value === '' ||
                    document.getElementById('lug_naci').value === '' ||
                    // document.getElementById('sec_ape').value === '' ||
                    document.getElementById('id_nacionalidad0').value === '' ||
                    document.getElementById('nombre_p').value === '' ||
                    document.getElementById('pri_ape').value === '' ||
                    document.getElementById('telefono_p').value === '') &&
                (stepDirection === 'forward' && nextStepIndex === 1)) {

                $('#form_user_file').submit();

                if ((document.getElementById('sub_archivo').value === '' && document.getElementById('foto').value === '') ||
                    (document.getElementById('sub_archivo').value === null && document.getElementById('foto').value === null)) {
                    var j = document.getElementById('error-message');
                    j.style.display = "block";
                }

                if (document.getElementById('fecha_n').value === '' || document.getElementById('fecha_n').value === null) {
                    $('#error_fecha_n').text('Por favor, ingrese una fecha.');
                } else {
                    $('#error_fecha_n').text('');
                }
                if (document.getElementById('fec_des').value === '' || document.getElementById('fec_des').value === null) {
                    $('#error_fec_des').text('Por favor, ingrese una fecha.');
                } else {
                    $('#error_fec_des').text('');
                }
                if (document.getElementById('fec_vin').value === '' || document.getElementById('fec_vin').value === null) {
                    $('#error_fec_vin').text('Por favor, ingrese una fecha.');
                } else {
                    $('#error_fec_vin').text('');
                }
                e.preventDefault()
            } else {

                if (stepDirection === 'forward' && nextStepIndex === 1) {

                    const nombre_pdocument = document.getElementById('nombre_p').value.trim() + '';
                    const pri_apedocument = document.getElementById('pri_ape').value.trim() + '';
                    const sec_apedocument = document.getElementById('sec_ape').value.trim() + '';
                    const fecha_ndocument = document.getElementById('fecha_n').value + '';
                    const lug_nacidocument = document.getElementById('lug_naci').value.trim() + '';
                    const id_residencia0document = document.getElementById('id_residencia0').value + '';
                    const dir_domidocument = document.getElementById('dir_domi').value.trim() + '';
                    const celular_pdocument = document.getElementById('celular_p').value + '';
                    const telefono_pdocument = document.getElementById('telefono_p').value + '';
                    const id_nacionalidad0document = document.getElementById('id_nacionalidad0').value + '';
                    const ced_identidaddocument = document.getElementById('ced_identidad').value + '';
                    const expedido = document.getElementById('expedido').value + '';
                    let id_genero = '1';
                    if (document.getElementById('id_genero').value === '1379') {
                        id_genero = '1';
                    }
                    if (document.getElementById('id_genero').value === '1380') {
                        id_genero = '2';
                    }
                    const cor_ele = document.getElementById('cor_ele').value.trim();
                    const id_ecivil = document.getElementById('id_ecivil').value;
                    const foto = document.getElementById('foto').value;
                    let sub_archivo = '';
                    if (document.getElementById('sub_archivo').value.replace(/^.*[\\\/]/, '') === '' || document.getElementById('sub_archivo').value.replace(/^.*[\\\/]/, '') === null) {
                        sub_archivo = foto;
                    } else {
                        sub_archivo = document.getElementById('sub_archivo').value.replace(/^.*[\\\/]/, '');
                    }
                    const cargo_p = document.getElementById('cargo_p').value.trim();
                    const fec_vin = document.getElementById('fec_vin').value;
                    const fec_des = document.getElementById('fec_des').value;
                    const califi = document.getElementById('califi').value.trim();

                    $.ajax({
                        url: "<?php echo site_url('recursos/C_file/mostrar_usuario') ?>",
                        type: "POST",
                        dataType: "JSON",
                        success: function(data) {
                            if (cargo_p != data[0].cargo ||
                                ced_identidaddocument != data[0].carnet ||
                                expedido != data[0].id_departamento ||
                                califi != data[0].cas ||
                                celular_pdocument != data[0].celular ||
                                id_residencia0document != data[0].ciudad_rec ||
                                cor_ele != data[0].correo ||
                                dir_domidocument != data[0].dir_dom ||
                                id_ecivil != data[0].est_civ ||
                                fecha_ndocument.replace(/[/]/g, '-').trim() != data[0].fec_nacimiento ||
                                fec_des.replace(/[/]/g, '-').trim() != data[0].fecdesv ||
                                fec_vin.replace(/[/]/g, '-').trim() != data[0].fecvin ||
                                sub_archivo != data[0].foto ||
                                id_genero != data[0].genero ||
                                lug_nacidocument != data[0].lugar_nac ||
                                sec_apedocument != data[0].materno ||
                                id_nacionalidad0document != data[0].nacionalidad ||
                                nombre_pdocument != data[0].nombre ||
                                pri_apedocument != data[0].paterno ||
                                telefono_pdocument != data[0].telefono) {
                                // const sw = confirm("Quieres modifcar los cambios ?");
                                Swal.fire({
                                    title: '¿Quieres guardar los cambios en el formulario?',
                                    icon: 'question',
                                    showCancelButton: true,
                                    /*  backdrop: true, 
                                    allowOutsideClick: false, */ // <- este codigo evita que el usuario cierre el cuadro dialogo si apreta fuera de la ventana de dialogo
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, Guardar cambios!',
                                    cancelButtonText: 'No, cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        $('#form_user_file').submit();
                                    } else if (result.dismiss === Swal.DismissReason.cancel) {

                                        let inputFile = document.getElementById('sub_archivo');
                                        inputFile.value = null;

                                        if (data[0].materno != "" && data[0].materno != null) {
                                            $("#c_sec_ape").removeClass("floating-label");
                                        }
                                        if (data[0].correo != "" && data[0].correo != null) {
                                            $("#c_cor_ele").removeClass("floating-label");
                                        }
                                        $('[name="nombre_p"]').val(data[0].nombre);
                                        $('[name="pri_ape"]').val(data[0].paterno);
                                        $('[name="sec_ape"]').val(data[0].materno);
                                        // $('[name="fecha_n"]').val(data[0].fec_nacimiento);
                                        $('#fecha_n').datepicker('setDate', data[0].fec_nacimiento);
                                        $('[name="lug_naci"]').val(data[0].lugar_nac);
                                        if (data[0].ciudad_rec === null || data[0].ciudad_rec === '') {
                                            $('#id_residencia0').prop("required", false);
                                        }
                                        if (data[0].nacionalidad === null || data[0].nacionalidad === '') {
                                            $('#id_nacionalidad0').prop("required", false);
                                        }
                                        if (data[0].est_civ === null || data[0].est_civ === '') {
                                            $('#id_ecivil').prop("required", false);
                                        }
                                        /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
                                        if (data[0].id_departamento === null || data[0].id_departamento === '') {
                                            $('#expedido').prop("required", false);
                                        }
                                        /* FIN Oscar Laura Aguirre GAN-MS-B5-0387 */
                                        if (data[0].genero === null || data[0].genero === '') {
                                            $('#id_genero').prop("required", false);
                                        }
                                        $('[name="id_residencia0"]').val(data[0].ciudad_rec).trigger('change');
                                        $('[name="dir_domi"]').val(data[0].dir_dom);
                                        $('[name="celular_p"]').val(data[0].celular);
                                        $('[name="telefono_p"]').val(data[0].telefono);
                                        $('[name="id_nacionalidad0"]').val(data[0].nacionalidad).trigger('change');
                                        $('[name="ced_identidad"]').val(data[0].carnet);
                                        /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
                                        $('[name="expedido"]').val(data[0].id_departamento).trigger('change');
                                        /* FIN Oscar Laura Aguirre GAN-MS-B5-0387 */
                                        if (data[0].genero + '' === '1') {
                                            $('[name="id_genero"]').val('1379').trigger('change');
                                        } else {
                                            $('[name="id_genero"]').val('1380').trigger('change');
                                        }
                                        $('[name="cor_ele"]').val(data[0].correo);
                                        $('[name="id_ecivil"]').val(data[0].est_civ).trigger('change');
                                        $('[name="foto"]').val(data[0].foto);
                                        if (data[0].foto == null || data[0].foto == '') {
                                            dato = '<p style="text-align: start; font-family: impact; font-size: 20px; color: #696969;"> Sin Foto </p>';
                                            document.getElementById("list").innerHTML = dato;
                                            $('#sub_archivo').prop("required", true);
                                        } else {
                                            dato = '<img src="<?php echo base_url(); ?>assets/img/personal/' + data[0].foto + '" class="img-responsive" style="width: 100px; height: 100px; margin-bottom: 5px;"> ';
                                            document.getElementById("list").innerHTML = dato;
                                        }
                                        $('[name="cargo_p"]').val(data[0].cargo);
                                        $('#fec_vin').datepicker('setDate', data[0].fecvin);
                                        $('#fec_des').datepicker('setDate', data[0].fecdesv);
                                        $('[name="califi"]').val(data[0].cas);
                                    }
                                })
                            } else {
                                // e.preventDefault();
                                let inputFile = document.getElementById('sub_archivo');
                                inputFile.value = null;

                                if (data[0].materno != "" && data[0].materno != null) {
                                    $("#c_sec_ape").removeClass("floating-label");
                                }
                                if (data[0].correo != "" && data[0].correo != null) {
                                    $("#c_cor_ele").removeClass("floating-label");
                                }
                                $('[name="nombre_p"]').val(data[0].nombre);
                                $('[name="pri_ape"]').val(data[0].paterno);
                                $('[name="sec_ape"]').val(data[0].materno);
                                // $('[name="fecha_n"]').val(data[0].fec_nacimiento);
                                $('#fecha_n').datepicker('setDate', data[0].fec_nacimiento);
                                $('[name="lug_naci"]').val(data[0].lugar_nac);
                                if (data[0].ciudad_rec === null || data[0].ciudad_rec === '') {
                                    $('#id_residencia0').prop("required", false);
                                }
                                if (data[0].nacionalidad === null || data[0].nacionalidad === '') {
                                    $('#id_nacionalidad0').prop("required", false);
                                }
                                if (data[0].est_civ === null || data[0].est_civ === '') {
                                    $('#id_ecivil').prop("required", false);
                                }
                                /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
                                if (data[0].id_departamento === null || data[0].id_departamento === '') {
                                    $('#expedido').prop("required", false);
                                }
                                /* FIN Oscar Laura Aguirre GAN-MS-B5-0387 */
                                if (data[0].genero === null || data[0].genero === '') {
                                    $('#id_genero').prop("required", false);
                                }
                                $('[name="id_residencia0"]').val(data[0].ciudad_rec).trigger('change');
                                $('[name="dir_domi"]').val(data[0].dir_dom);
                                $('[name="celular_p"]').val(data[0].celular);
                                $('[name="telefono_p"]').val(data[0].telefono);
                                $('[name="id_nacionalidad0"]').val(data[0].nacionalidad).trigger('change');
                                $('[name="ced_identidad"]').val(data[0].carnet);
                                /* Inicio Oscar Laura Aguirre GAN-MS-B5-0387 */
                                $('[name="expedido"]').val(data[0].id_departamento).trigger('change');
                                /* FIN Oscar Laura Aguirre GAN-MS-B5-0387 */
                                if (data[0].genero + '' === '1') {
                                    $('[name="id_genero"]').val('1379').trigger('change');
                                } else {
                                    $('[name="id_genero"]').val('1380').trigger('change');
                                }
                                $('[name="cor_ele"]').val(data[0].correo);
                                $('[name="id_ecivil"]').val(data[0].est_civ).trigger('change');
                                $('[name="foto"]').val(data[0].foto);
                                if (data[0].foto == null || data[0].foto == '') {
                                    dato = '<p style="text-align: start; font-family: impact; font-size: 20px; color: #696969;"> Sin Foto </p>';
                                    document.getElementById("list").innerHTML = dato;
                                    $('#sub_archivo').prop("required", true);
                                } else {
                                    dato = '<img src="<?php echo base_url(); ?>assets/img/personal/' + data[0].foto + '" class="img-responsive" style="width: 100px; height: 100px; margin-bottom: 5px;"> ';
                                    document.getElementById("list").innerHTML = dato;
                                }
                                $('[name="cargo_p"]').val(data[0].cargo);
                                $('#fec_vin').datepicker('setDate', data[0].fecvin);
                                $('#fec_des').datepicker('setDate', data[0].fecdesv);
                                $('[name="califi"]').val(data[0].cas);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error get data from ajax');
                        }
                    });
                } else {
                    return true
                }
            }
        });
        /* Fin Oscar Laura Aguirre GAN-MS-M4-0376 */
        /* INICIO Oscar Laura Aguirre GAN-MS-M0-0407*/
        $(document).ready(function() {
            var valor = '';
            $('#datatable_id').DataTable({
                'processing': true,
                'serverSide': true,
                'responsive': true,
                "language": {
                    "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                },
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= base_url() ?>lstformacademic',
                },
                'columns': [{
                        data: 'oid_formacion'
                    },
                    {
                        data: 'ouniversidad'
                    },
                    {
                        data: "onivel_acad"
                    },
                    {
                        data: 'ocertificacion'
                    }
                ],
                'initComplete': function(settings, json) {
                    // Obtener la altura de la tabla y establecerla como la altura del paso 2 de SmartWizard
                    var tablaAltura = $('#datatable_id').height();
                    $('#smartwizard').smartWizard('fixHeight', 2, tablaAltura);
                },
                "error": function(xhr, error, thrown) {
                    console.log('Ajax error: ', error);
                }
            });
            $('#datatable_id').on('draw.dt', function() {
                var tablaAltura = $('#datatable_id').height();
                $('#smartwizard').smartWizard('fixHeight', 2, tablaAltura);
            });

        });

        /* Fin Oscar Laura Aguirre GAN-MS-M0-0407 */
    </script>
    <!-- INICIO Oscar Laura Aguirre GAN-MS-M0-0407-->
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
                        document.getElementById("list").innerHTML = ['<img class="img-responsive" src="', e.target.result, '" style="width:100px; height: 100px; margin-bottom: 5px;" title="', escape(theFile.name), '"/>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
            }
            var j = document.getElementById('error-message');
            j.style.display = "none";
        }
        document.getElementById('sub_archivo').addEventListener('change', archivo, false);
    </script>
    <script>
        $(document).ready(function() {
            $('#form_formacion_academica').submit(function(event) {
                // event.preventDefault();
                var formData = new FormData(this);
                console.log(document.getElementById('fecha_emi_cer').value, 'FECHAAA');
                if (document.getElementById('fecha_emi_cer').value === '' || document.getElementById('fecha_emi_cer').value === null) {
                    $('#error_fecha_emi_cer').text('Por favor, ingrese una fecha.');
                } else {
                    $('#error_fecha_emi_cer').text('');
                }
                $.ajax({
                    url: 'recursos/C_file/registrar_formacion_academic',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                    },
                    error: function(xhr, status, error) {
                        console.log('Se ha producido un error al enviar los datos.');
                    }
                });
            });
        });
    </script>
    <!-- FIN Oscar Laura Aguirre GAN-MS-M0-0407 -->
    <!-- INICIO Oscar Laura Aguirre GAN-MS-M5-0435 -->
    <script>
        $(document).ready(function() {

            $('#form_semi_cur_tall').submit(function(event) {
                var formData = new FormData(this);
                if (document.getElementById('id_fecha_emi_cer').value === '' || document.getElementById('id_fecha_emi_cer').value === null) {
                    $('#error_id_fecha_emi_cer').text('Por favor, ingrese una fecha.');
                } else {
                    $('#error_id_fecha_emi_cer').text('');
                }
                $.ajax({
                    url: 'recursos/C_file/registrar_curso',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response, 'RESULTADOOOO');
                    },
                    error: function(xhr, status, error) {
                        console.log('Se ha producido un error al enviar los datos.');
                    }
                });
            });
        });
        $(document).ready(function() {
            var valor = '';
            $('#datatable_curso').DataTable({
                'processing': true,
                'serverSide': true,
                'responsive': true,
                "language": {
                    "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                },
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= base_url() ?>lstcurs',
                },
                'columns': [{
                        data: 'onro'
                    },
                    {
                        data: 'oinstitucion'
                    },
                    {
                        data: 'otipo_capa'
                    },
                    {
                        data: 'ofec_emi_cert'
                    },
                    {
                        data: 'oduracion'
                    },
                    {
                        data: null
                    }
                ],
                'initComplete': function(settings, json) {
                    // Obtener la altura de la tabla y establecerla como la altura del paso 2 de SmartWizard
                    var tablaAltura = $('#datatable_curso').height();
                    $('#smartwizard').smartWizard('fixHeight', 2, tablaAltura);
                }
            });
            $('#datatable_curso').on('draw.dt', function() {
                var tablaAltura = $('#datatable_curso').height();
                $('#smartwizard').smartWizard('fixHeight', 2, tablaAltura);
            });

        });

        $(document).ready(function() {
            $('input[type=radio][name=id_participacion], input[type=radio][name=id_aprobacion]').change(function() {
                if ($(this).attr('name') === 'id_participacion' && $(this).is(':checked')) {
                    $('#id_aprobacion').prop('checked', false);
                } else if ($(this).attr('name') === 'id_aprobacion' && $(this).is(':checked')) {
                    $('#id_participacion').prop('checked', false);
                }
            });
        });
    </script>
    <!-- FIN Oscar Laura Aguirre GAN-MS-M5-0435 -->
<?php } else {
    redirect('inicio');
} ?>