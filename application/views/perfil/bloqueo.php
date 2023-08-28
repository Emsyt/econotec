<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Sistema de ventas, compras e inventarios	</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Sistema de Inventarios">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
      <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/icoLogo/iconoEmpresa.ico')?>" />
      <!-- <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/> -->

      <!-- BOOTSTRAP -->
      <link type="text/css" rel="stylesheet" href="<?= base_url();?>assets/css/<?php print json_decode($thema->fn_mostrar_ajustes)->{'tema'} ?>/bootstrap.css?1422792965" />
      <link type="text/css" rel="stylesheet" href="<?= base_url();?>assets/css/<?php print json_decode($thema->fn_mostrar_ajustes)->{'tema'} ?>/materialadmin.css?1425466319" />

      <!-- ICONOS -->
      <link type="text/css" rel="stylesheet" href="<?= base_url();?>assets/css/<?php print json_decode($thema->fn_mostrar_ajustes)->{'tema'} ?>/font-awesome.min.css?1422529194" />
      <link type="text/css" rel="stylesheet" href="<?= base_url();?>assets/css/<?php print json_decode($thema->fn_mostrar_ajustes)->{'tema'} ?>/material-design-iconic-font.min.css?1421434286" />
    <!-- BEGIN STYLESHEETS -->
  </head>

  <body class="menubar-hoverable header-fixed">
    <!-- BEGIN LOCKED SECTION -->
    <section class="section-account">
    	<div class="img-backdrop" style="background-image: url('<?= base_url('assets/img/backgrounds/img_perfil.jpg') ?>')"></div>
    	<div class="spacer"></div>
    	<div class="card contain-xs style-transparent">
    	  <div class="card-body">
    	  	<div class="row">
      		  <div class="col-sm-12">
        			<?php $foto = $this->session->userdata('foto');
        			if (empty($foto)) { ?>
        			  <img class="img-circle" src="<?php echo base_url('assets/img/personal/default-user.png'); ?>" alt="" />
        			<?php } else { ?>
        			  <img class="img-circle" src="<?php echo base_url(); ?>assets/img/personal/<?php echo $foto?>" alt="" />
        			<?php } ?>
        			<h2><?php echo ucwords(strtolower($this->session->userdata('nombre'))) ?></h2>
        			<form class="form" accept-charset="utf-8" name="form_login" method="post" action="<?= base_url('perfil/C_bloqueo/verificar_password'); ?>">
        			  <div class="form-group floating-label">
        			  	<div class="input-group">
        			  	  <div class="input-group-content">
        			  		<input type="password" id="password" class="form-control" name="password">
        			  		<label for="password">Contraseña</label>
        			  		<p class="help-block"><a href="<?= base_url('logout'); ?>">¿No es <?php echo ucwords(strtolower($this->session->userdata('nombre'))) ?>?</a></p>
        			  	  </div>

        			  	  <div class="input-group-btn">
        			  		<button type="submit" class="btn btn-floating-action btn-primary"><i class="fa fa-unlock"></i></button>
        			  	  </div>
        			  	</div>

      				    <p class="clearfix"> </p>
      				    <p class="clearfix"> </p>
      				    <div class="control-group error">
      				      <div align="right">
      				  	    <label class="control-label" style="color:red">
                      <strong><?php if (isset($error))echo  $error; ?></strong>
                      </label>
      				      </div>
                  </div>
        			  </div>
        			</form>
      		  </div>
    	  	</div>
    	  </div>
    	</div>
    </section>
    <!-- END LOCKED SECTION -->
  </body>
