<script>
  $(document).ready(function(){
      activarMenu('menu0',0);
      activarMenuHeader('menuHeader1');
  });
</script>

  <!-- BEGIN CONTENT-->
  <div id="content">
  	<!-- BEGIN PROFILE HEADER -->
  	<section class="full-bleed">
  	  <div class="section-body style-default-dark force-padding text-shadow">
  	  	<div class="img-backdrop" style="background-image: url('<?= base_url('assets/img/backgrounds/img_perfil.jpg') ?>')"></div>
  	  	<div class="overlay overlay-shade-top stick-top-left height-3"></div>
  	  	<div class="row">
  	  	  <div class="col-md-3 col-xs-5">
  	  	    <div class="centrar">
	  	  	  	<?php $foto = $this->session->userdata('foto');
	            if (empty($foto)) { ?>
	              <img style="width: 140px; height: 140px" class="img-circle border-white border-xl img-responsive auto-width" src="<?php echo base_url('assets/img/personal/default-user.png'); ?>" alt="" />
	            <?php } else { ?>
	              <img style="width: 140px; height: 140px" class="img-circle border-white border-xl img-responsive auto-width" src="<?php echo base_url(); ?>assets/img/personal/<?php echo $foto?>" alt=""/>
	            <?php } ?>
			      </div>
  	  	  	<h3 style="text-align:center"><?php echo $this->session->userdata('nombre') ?><br/><small style="color:#fff"><?php echo $this->session->userdata('cargo') ?></small></h3>
  	  	  </div>
  	  	</div>
  	  </div>
  	</section>
  	<!-- END PROFILE HEADER  -->
  	<section>
  	  <div class="section-body no-margin">
		    <div class="row">
  	  	  <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
  	  	  	<div class="card card-underline style-default-dark">
  	  	  	  <div class="card-head">
  	  	  		<header class="opacity-75"><small>Informaci&oacute;n Personal</small></header>
  	  	  	  </div>

  	  	  	  <div class="card-body no-padding">
      	  			<ul class="list">
      	  			  <li class="tile">
      	  			  	<a class="tile-content ink-reaction">
      	  			  	  <div class="tile-icon">
      	  			  	  	<i class="md md-account-circle"></i>
      	  			  	  </div>
      	  			  	  <div class="tile-text">
      	  			  	  	<small>Nombres y Apellidos</small>  <?php echo $usuario->nombre.' '.$usuario->paterno.' '.$usuario->materno; ?>
      	  			  	  </div>
      	  			  	</a>
      	  			  </li>
      	  			  <li class="divider-inset"></li>
      	  			  <li class="tile">
      	  			  	<a class="tile-content ink-reaction">
      	  			  	  <div class="tile-icon">
      	  			  	  	<i class="md md-picture-in-picture"></i>
      	  			  	  </div>
      	  			  	  <div class="tile-text">
      	  			  	  	<small>Carnet de Identidad</small> <?php echo $usuario->carnet.' '.$usuario->departamento; ?>
      	  			  	  </div>
      	  			  	</a>
      	  			  </li>
      	  			  <li class="divider-inset"></li>
      	  			  <li class="tile">
      	  			  	<a class="tile-content ink-reaction">
      	  			  	  <div class="tile-icon">
      	  			  	  	<i class="fa fa-venus-mars"></i>
      	  			  	  </div>
      	  			  	  <div class="tile-text">
      	  			  	  	<small>G&eacute;nero</small> <?php if ($usuario->genero == 1) { ?>
      	  			  	  		FEMENINO
      	  			  	  	<?php } else { ?>
      	  			  	  		MASCULINO
      	  			  	  	<?php } ?>
      	  			  	  </div>
      	  			  	</a>
      	  			  </li>
      	  			  <li class="divider-inset"></li>
      	  			  <li class="tile">
      	  			  	<a class="tile-content ink-reaction">
      	  			  	  <div class="tile-icon">
      	  			  	  	<i class="md md-event"></i>
      	  			  	  </div>
      	  			  	  <div class="tile-text">
      	  			  	  	<small>Fecha de Nacimiento</small>
                        <?php
                          setlocale(LC_ALL,"es_ES");
                          echo strftime("%d de %B de %Y", strtotime($usuario->fec_nacimiento));
                        ?>
      	  			  	  </div>
      	  			  	</a>
      	  			  </li>
      	  			  <li class="divider-inset"></li>
      	  			  <li class="tile">
      	  			  	<a class="tile-content ink-reaction">
      	  			  	  <div class="tile-icon">
      	  			  	  	<i class="md md-location-on"></i>
      	  			  	  </div>
      	  			  	  <div class="tile-text">
      	  			  	  	<small>Direcci&oacute;n</small> <?php echo $usuario->direccion; ?>
      	  			  	  </div>
      	  			  	</a>
      	  			  </li>
      	  			  <li class="divider-inset"></li>
      	  			  <li class="tile">
      	  			  	<a class="tile-content ink-reaction">
      	  			  	  <div class="tile-icon">
      	  			  	  	<i class="fa fa-phone"></i>
      	  			  	  </div>
      	  			  	  <div class="tile-text">
      	  			  	  	<small>Tel&eacute;fono</small> (+591) <?php echo $usuario->telefono; ?>
      	  			  	  </div>
      	  			  	</a>
      	  			  </li>
      	  			</ul>
  	  	  	  </div>
  	  	  	</div>

  	  	  	<div class="card card-underline style-default-dark">
  	  	  	  <div class="card-head">
  	  	  		<header class="opacity-75"><small>Informaci&oacute;n con respecto a la Empresa</small></header>
  	  	  	  </div>

  	  	  	  <div class="card-body no-padding">
      	  			<ul class="list">
                  <li class="tile">
                    <a class="tile-content ink-reaction">
                      <div class="tile-icon">
                        <i class="md md-location-on"></i>
                      </div>
                      <div class="tile-text">
                        <small>Sucursal</small> <?php echo $usuario->ubicacion; ?>
                      </div>
                    </a>
                  </li>
      	  			  <li class="divider-inset"></li>
      	  			  <li class="tile">
      	  			  	<a class="tile-content ink-reaction">
      	  			  	  <div class="tile-icon">
      	  			  	  	<i class="md md-work"></i>
      	  			  	  </div>
      	  			  	  <div class="tile-text">
      	  			  	  	<small>Cargo</small> <?php echo $usuario->cargo; ?>
      	  			  	  </div>
      	  			  	</a>
      	  			  </li>
      	  			  <li class="divider-inset"></li>
      	  			  <li class="tile">
      	  			  	<a class="tile-content ink-reaction">
      	  			  	  <div class="tile-icon">
      	  			  	  	<i class="md md-email"></i>
      	  			  	  </div>
      	  			  	  <div class="tile-text">
      	  			  	  	<small>Correo Institucional</small> <?php echo $usuario->correo; ?>
      	  			  	  </div>
      	  			  	</a>
      	  			  </li>
      	  			</ul>
  	  	  	  </div>
  	  	  	</div>
  	  	  </div>
  	  	</div>
  	  </div>
  	</section>
  </div>
  <!-- END CONTENT -->
