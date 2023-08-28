<?php
/*
------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert Fecha:28/09/2022, Codigo: GAN-MS-B9-0002
Descripcion: Se cambio los flashdata por TempData para no perder datos de sesion y mostrar alerta al usuario
------------------------------------------------------------------------------
*/
?>
<script>
  $(document).ready(function(){
      activarMenu('menu0',0);
      activarMenuHeader('menuHeader2');
  });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
	    <div class="section-header">
        <ol class="breadcrumb">
          <li>Configuraci&oacute;n</li>
          <li class="active">Cambio de contrase&ntilde;a</li>
        </ol>
      </div>
      <!-- GAN-MS-B9-0002 GaryValverde 28-09-2022 -->
      <?php if ($this->session->tempdata('success')) { ?>
        <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                text: "<?php echo $this->session->tempdata('success') ?>",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ACEPTAR'
            })

        });</script>
      <?php } else if($this->session->tempdata('error')){ ?>
        <script> 
        $(document).ready(function() {
            Swal.fire({
                icon: 'error',
                text: "<?php echo $this->session->tempdata('error'); ?>",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ERROR'
            })

        });</script>
      <?php }
      $this->session->unset_tempdata('success');
      $this->session->unset_tempdata('error'); ?>
      <!-- fin GAN-MS-B9-0002 GaryValverde 28-09-2022 -->

  	  <div class="section-body">
      <!-- BEGIN INVERSED FORM -->
  		  <div class="row"><br>
  		  	<div class="col-md-6 col-lg-offset-3">
  		  	  <form class="form form-validate floating-label" novalidate="novalidate" name="form_pass" id="form_pass" method="post" action="<?= base_url(); ?>perfil/C_password/update_pass">
  		  	  	<div class="card style-default-dark">
  		  	  	  <div class="card-head" style="border-bottom-style: solid; border-width: 1px">
  		  	  	  	<header>Cambiar Contrase&ntilde;a</header>
  		  	  	  </div>

  		  	  	  <div class="card-body form-inverse">
					        <div class="col-md-10 col-md-offset-1">
  		  	  	  	  <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-unlock fa-2x"></span></span>
                        <div class="input-group-content">
                          <input type="text" class="form-control" name="password" id="password" required>
                          <label for="password">Contrase&ntilde;a Actual</label>
                        </div>
                      </div>

                      <div class="control-group error">
	                      <div align="center">
	                        <label class="control-label" style="color:#de5050">
	                          <strong><?php if (isset($error))echo  $error; ?></strong>
	                        </label>
	                      </div>
	                    </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-unlock-alt fa-2x"></span></span>
                        <div class="input-group-content">
                          <input type="password" class="form-control" name="password1" id="password1"  required="" data-rule-minlength="6">
                          <label for="password1">Contrase&ntilde;a Nueva</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-repeat fa-2x"></span></span>
                        <div class="input-group-content">
                          <input type="password" class="form-control" name="passwordrepeat" id="passwordrepeat" data-rule-equalto="#password1" required="">
                          <label for="passwordrepeat">Confirmar Nueva Contrase&ntilde;a</label>
                        </div>
                      </div>
                    </div>
					        </div>
                </div>

  		  	  	  <div class="card-actionbar">
  		  	  	  	<div class="card-actionbar-row">
  		  	  	  		<button type="submit" class="btn btn-flat btn-default-light ink-reaction">Registrar Nueva Contrase&ntilde;a</button>
  		  	  	  	</div>
  		  	  	  </div>
              </div>
            </form>
          </div>
        </div>
      <!-- END INVERSED FORM -->
      </div>
    </section>
  </div>
  <!-- END CONTENT -->
