
<?php 
/*----------------------------------------------------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha: 05/08/21, Codigo: GAN-009
Descripcion: Se aumento en ingresos y gastos el prefijo Bs. y se cambio el formato de numero a los indicadores de ingresos y egresos.

  -------------------------------------------------------------------------------
  Modificado: Fabian Alejandro Candia Alvizuri Fecha:015/11/2021, Codigo: GAN-MS-A1-073
  Descripcion: Se modifico el valor de ingresos del dashboard

  -------------------------------------------------------------------------------
  Modificado: Fabian Alejandro Candia Alvizuri Fecha:016/11/2021, Codigo: GAN-PN-A4-089
  Descripcion: Se modifico el valor de gasto del dashboard

 ------------------------------------------------------------------------------
  Modificado: karen quispe chavez fecha 23/06/2022 Codigo :GAN-MS-A6-277
  Descripcion : se inserto en el  dahsboard  un scroll 
  -------------------------------------------------------------------------------------
  Modificado: Jade Piza           fecha: 26/05/2023              Codigo:GAN-DPR-B7-0498
  Descripcion: se corrigio el responsive del DASHBOARD
  --------------------------------------------------------------------------------------------------------

  */
?>

<div id="Layer1" style="width:auto; height:700px; overflow-y: scroll;">

<div class="col-lg-12">
		<h4>INDICADORES DEL MES DE <?php echo strtoupper($mes);?></h4>
	</div>

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body no-padding">
          <div class="alert alert-callout alert-success no-margin" style="background-color: #e8fad4;">
            <h1 class="pull-right text-success" style="margin-top: 0px;"><i class="fa fa-plus-circle fa-2x"></i></h1>
            <strong class="text-xl"> Bs. <?php echo ($monto_ingreso); ?> Ingresos</strong><br/>
            <span class="opacity-50">Monto total mes de <?php echo $mes;?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body no-padding">
          <div class="alert alert-callout alert-danger no-margin" style="background-color: #fad5d4;">
            <h1 class="pull-right text-danger" style="margin-top: 0px;"><i class="fa fa-minus-circle fa-2x"></i></h1>
            <strong class="text-xl"> Bs. <?php echo ($monto_gasto); ?> Gastos</strong><br/>
            <span class="opacity-50">Monto total mes de <?php echo $mes;?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body no-padding">
          <div class="alert alert-callout alert-info no-margin" style="background-color: #d4f6fa;">
            <h1 class="pull-right text-info" style="margin-top: 0px;"><i class="fa fa-money fa-2x"></i></h1>
            <strong class="text-xl"> <?php echo $datos_ind->ventas; ?> Ventas</strong><br/>
            <span class="opacity-50">Monto total mes de <?php echo $mes;?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Exiten 3 tipo de indicadores de productos: en stock, agotados y registrados -->
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body no-padding">
          <div class="alert alert-callout alert-success no-margin" style="background-color: #e8fad4;">
            <h1 class="pull-right text-success" style="margin-top: 0px;"><i class="fa fa-shopping-cart fa-2x"></i></h1>
            <strong class="text-xl"> <?php echo $datos_ind->productos; ?> Productos en Stock</strong><br/>
            <span class="opacity-50">Total de productos</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body no-padding">
          <div class="alert alert-callout alert-danger no-margin" style="background-color: #fad5d4;">
            <h1 class="pull-right text-danger" style="margin-top: 0px;"><i class="fa fa-remove fa-2x"></i></h1>
            <strong class="text-xl"> <?php echo $datos_ind->productos_agotados; ?> Productos Agotados</strong><br/>
            <span class="opacity-50">Total de productos</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body no-padding">
          <div class="alert alert-callout alert-info no-margin" style="background-color: #d4f6fa;">
            <h1 class="pull-right text-info" style="margin-top: 0px;"><i class="fa fa-list fa-2x"></i></h1>
            <strong class="text-xl"> <?php echo $datos_ind->total_productos; ?> Productos Registrados</strong><br/>
            <span class="opacity-50">Total de productos</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin de indicares productos-->

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-body no-padding">
          <div class="alert alert-callout alert-warning no-margin" style="background-color: #faf1d4;">
            <h1 class="pull-right text-warning" style="margin-top: 0px;"><i class="fa fa-user-secret fa-2x"></i></h1>
            <strong class="text-xl"> <?php echo $datos_ind->clientes; ?> Clientes</strong><br/>
            <span class="opacity-50">Clientes nuevos del mes de <?php echo $mes;?> </span>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- END INDICADORES -->

</div>
 