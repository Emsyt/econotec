<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:27/04/2022, Codigo: GAN-FR-M6-210,
Descripcion: Se Implemento un nuevo submódulo, en el que se pueda visualiza el logo de la empresa y la versión actual.
 */
?>
<?php if (in_array("smod_inf", $permisos)) { ?>

<script type="text/javascript">
    $(document).ready(function() {
        activarMenu('menu8', 3);

    });
</script>


<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="#">Administracion</a></li>
                <li class="active">Información</li>
            </ol>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="card" style="height: 100%;">
                        <div class="card-body">
                            <br>
                            <div class="row">
                                <div class="row" style="text-align: center;">
                                    <img style="height: 100px;" src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes);
                                                                                        print($obj->{'logo'}); ?>">
                                </div>
                                <div class="row" style="text-align: center;">
                                    <h4 class="text-ultra-bold" style="color:#655e60;"> SISTEMA ECOGAN</h4>
                                    <h5 class="text-ultra-bold" style="color:#655e60;"> VERSIÓN <?php echo $version->descripcion ?></h5>
                                    <i class="fa fa-cog fa-spin fa-4x fa-fw"></i>
                                </div>
                            </div><br>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- END CONTENT -->
<?php } else {redirect('inicio');}?>
