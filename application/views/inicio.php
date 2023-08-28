<?php if (in_array("dashboard", $permisos)) { ?>
<script type="text/javascript">
  $(document).ready(function(){
      activarMenu('menu1',0);
  });
</script>

<script>
  $(document).ready(function(){
    var f = new Date();
    var mes = f.getMonth() +1;

      if (mes <= 9) { var mesActual = "0"+mes; } else { var mesActual = mes; }

    var fecmes = f.getFullYear()+ "/" + mesActual + "/01";
    $('[name="fecmes"]').val(fecmes);
    cambiar_consulta();
  });
</script>

<script type="text/javascript">
  function cambiar_consulta(){
      var selc_fmes = document.getElementById("fecmes").value;

    $.post("<?= base_url() ?>C_inicio/func_auxiliares", {accion: 'indic_inicio', selc_fmes : selc_fmes}, function(data){
        $('#AjaxIndInicio').html(data);
    });

    $.post("<?= base_url() ?>C_inicio/func_auxiliares", {accion: 'graf_inicio', selc_fmes : selc_fmes}, function(data){
        $('#AjaxGrafInicio').html(data);
    });
 }
</script>



  <!-- BEGIN CONTENT-->
  <div id="content">
  	<section>
  	  <div class="section-header">
        <ol class="breadcrumb">
          <li>Dashboard</li>
          <li class="active">SISTEMA DE VENTAS COMPRAS E INVENTARIOS</li>
        </ol>
      </div>

  	  <div class="section-body">
        <div class="row">
          <div class="col-lg-9">
          	<form class="form-horizontal">
          		<div class="card">
          			<div class="card-head style-primary">
          				<header>Selecci&oacute;n de Filtro</header>
          			</div>
          			<div class="card-body">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                      <div class="form-group ">
                        <label for="Firstname5" class="col-sm-4 control-label">Selector de Mes</label>
                        <div class="col-sm-8">
                        <div class="input-group date" id="demo-date-month">
                          <div class="input-group-content">
                            <input type="text" class="form-control" name="fecmes" id="fecmes" readonly="" required>
                          </div>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                      <button type="button" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" onclick="cambiar_consulta();">Buscar consulta</button>
                    </div>
                  </div>
          			</div><!--end .card-body -->
          		</div><!--end .card -->
          	</form>

            <div id="AjaxGrafInicio"></div>
          </div>

          <div class="col-lg-3">
            <div id="AjaxIndInicio"></div>
          </div>
        </div>
  	  </div>
  	</section>
  </div>
  <!-- END CONTENT -->
</div>
<?php } else {redirect('inicial');}?>