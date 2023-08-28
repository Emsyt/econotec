
<?php if (in_array("smod_vent_caj", $permisos)) { ?>
<script>
  function precio_total() {
    var pre_ref = document.getElementById("precio_ref").value;
    var cantidad = document.getElementById("cantidad").value;
    var precio_total = parseFloat(cantidad * pre_ref);
    document.getElementById('pre_total').value = precio_total;
  }

  function validar_precio() {
    var pre_ref = document.getElementById("precio_ref").value;
    var cantidad = document.getElementById("cantidad").value;
    var precio_total = document.getElementById("pre_total").value;

    var descuento = (0,2* (pre_ref*cantidad) + (pre_ref*cantidad));

    if (precio_total < descuento ) {
      $("#msjprecio").html("El precio a vender es muy bajo");
      document.getElementById("msjcarnet").style.color = "red";
      document.getElementById("msjcarnet").style.fontSize = "14px";
    } else{
      $("#msjprecio").html("");
    }
  }
</script>

<?php if ($this->session->flashdata('success')) { ?>
  <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('success'); ?>","success"); } </script>
<?php } else if($this->session->flashdata('error')){ ?>
  <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('error'); ?>","error"); } </script>
<?php } ?>

<form class="form form-validate" novalidate="novalidate" name="form_pedido" id="form_pedido" method="post" action="<?= site_url() ?>venta/C_pedido/add_pedido">
  <input type="hidden" name="id_producto" value="<?php echo $id_prod; ?>">
  <div class="card">
    <div class="card-body no-padding">
      <ul class="list">
        <li class="tile">
          <a class="tile-content">
            <div class="tile-icon"><i class="md md-business "></i></div>
            <div class="tile-text">
              Cantidad en Tienda
              <small class="pull-right text-bold opacity-75" style="font-size: 16px; padding-right: 20px;"> <?php echo $producto->c_sucursal; ?> </small>
            </div>
          </a>
        </li>
        <li class="divider-inset"></li>

        <li class="tile">
          <a class="tile-content">
            <div class="tile-icon"><i class="fa fa-building-o"></i></div>
            <div class="tile-text">
              Cantidad en Almacen
              <small class="pull-right text-bold opacity-75" style="font-size: 16px; padding-right: 20px;"> <?php echo $producto->c_almacen; ?> </small>
            </div>
          </a>
        </li>
        <li class="divider-inset"></li>

        <li class="tile">
          <a class="tile-content">
            <div class="tile-icon"><i class="fa fa-money"></i></div>
            <div class="tile-text">
              Precio Referencial /Unidad (Bs.)
              <small class="pull-right text-bold opacity-75" style="font-size: 16px; padding-right: 20px;"> <?php echo $producto->precio_unidad; ?> </small>
              <input type="hidden" class="form-control" name="precio_ref" id="precio_ref" value="<?php echo $producto->precio_unidad; ?>">
            </div>
          </a>
        </li>
        <li class="divider-inset"></li>

        <li class="tile">
          <a class="tile-content">
            <div class="tile-icon"><i class="fa fa-cart-plus"></i></div>
            <div class="tile-text">
              <div class="col-xs-7 col-sm-7 col-md-9 col-lg-9" style="padding-left: 0px; ">
                Cantidad
              </div>

              <div class="col-xs-5 col-sm-5 col-md-3 col-lg-3" style="padding-left: 0px;">
                <small class="pull-right text-bold opacity-75" style="font-size: 16px; padding-right: 10px;">
                  <input type="text" class="form-control" name="cantidad" id="cantidad" data-rule-number="true" required="" onchange="precio_total()" style="height: 24px; text-align: right;">
                </small>
              </div>
            </div>
          </a>
        </li>
        <li class="divider-inset"></li>

        <li class="tile">
          <a class="tile-content">
            <div class="tile-icon"><i class="fa fa-money"></i></div>
            <div class="tile-text">
              <div class="col-xs-7 col-sm-7 col-md-9 col-lg-9" style="padding-left: 0px; ">
                Precio Total
              </div>

              <div class="col-xs-5 col-sm-5 col-md-3 col-lg-3" style="padding-left: 0px;">
                <small class="pull-right text-bold opacity-75" style="font-size: 16px; padding-right: 10px;">
                  <input type="text" class="form-control" name="pre_total" id="pre_total" data-rule-number="true" required="" onchange="validar_precio()" style="height: 24px; text-align: right;">
                </small>
              </div>

              <strong><div id="msjprecio" style="padding-top: 30px"></div></strong>
            </div>
          </a>
        </li>
        <li class="divider-inset"></li>

        <li class="tile">
          <a class="tile-content">
            <div class="tile-icon"><i class="fa fa-user"></i></div>
            <div class="tile-text">
              <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-left: 0px; ">
                Seleccionar Cliente
              </div>

              <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7" style="padding-left: 0px;">
                <small class="pull-right text-bold opacity-75" style="font-size: 16px; padding-right: 10px;">
                  <select class="form-control select2-list" id="cliente" name="cliente" required style="height: 24px;">
                    <?php foreach ($clientes as $cli) {  ?>
                    <option value="<?php echo $cli->id_personas ?>" <?php echo set_select('cliente', $cli->id_personas)?>> <?php echo $cli->cliente ?></option>
                    <?php  } ?>
                  </select>
                </small>
              </div>
            </div>
          </a>
        </li>
        <li class="divider-inset"></li>

        <li class="tile">
          <a class="tile-content">
            <div class="tile-icon"><i class="fa fa-file-text-o"></i></div>
            <div class="tile-text">
              <div class="col-xs-7 col-sm-7 col-md-11 col-lg-11" style="padding-left: 0px; ">
                Pedido con Factura
              </div>

              <div class="col-xs-5 col-sm-5 col-md-1 col-lg-1" style="padding-left: 0px;">
                <small class="pull-right text-bold" style=" opacity: 1;">
                  <div class="checkbox checkbox-styled">
                    <label style="padding-top: 0px; padding-bottom: 0px;">
                      <input type="checkbox" name="factura" id="factura" value="1" >
                      <span></span>
                    </label>
                  </div>
                </small>
              </div>
            </div>
          </a>
        </li>

        <li class="tile">
          <a class="tile-content ink-reaction">
            <div class="tile-icon"></div>
            <div class="tile-text">
              <small class="pull-right" style="opacity: 1;">
                <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add">Agregar producto a la venta </button>
              </small>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</form>
<?php } else {redirect('inicio');}?>
