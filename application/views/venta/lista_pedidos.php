<?php 
/* 
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:14/04/2022, Codigo:GAN-FR-A5-157
  Descripcion: se cambiaron los nombres/titulos segun lo acordado en la reunion
*/
?>
<?php if (in_array("smod_cobr_caj", $permisos)) { ?>
<script>
  $(document).ready(function(){
      activarMenu('menu5',2);
  });
</script>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
          <ol class="breadcrumb">
              <li><a href="#">Venta</a></li>
              <li class="active">Cobro en Caja</li>
          </ol>
      </div>

      <?php if ($this->session->flashdata('success')) { ?>
        <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('success'); ?>","success"); } </script>
      <?php } else if($this->session->flashdata('error')){ ?>
        <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('error'); ?>","error"); } </script>
      <?php } ?>

      <div class="section-body">
        <div class="row">
          <div class="col-md-12">
            <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
            <div class="card card-bordered style-primary">
              <div class="card-head style-primary">
                <header>Detalle de pedidos realizados</header>
              </div>

              <div class="card-body style-default-bright">
                <div class="table-responsive">
                  <table id="datatable3" class="table table-striped ">
                    <thead>
                      <tr>
                        <th>N&deg;</th>
                        <th>Lote</th>
                        <th>Factura</th>
                        <th>Cliente</th>
                        <th>Productos</th>
                        <th>Vendido por</th>
                        <th>Acci&oacute;n</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php $nro = 0;
                      foreach ($lst_pedidos as $ped)
                      {  $nro++; ?>
                        <tr>
                          <td><?php echo 'Pedido '.$nro ?></td>
                          <td><?php echo $ped->id_lote ?></td>
                          <td><?php echo ($ped->factura == 1) ? 'Con Factura':'Sin Factura' ?></td>
                          <td><?php echo $ped->cliente ?></td>
                          <td><?php echo $ped->productos ?></td>
                          <td><?php echo $ped->vendedor ?></td>
                          <td align="center">
                            <form name="form_accion" method="post" action="<?= site_url() ?>conf_venta">
                              <input type="hidden" name="lote" value="<?php echo $ped->id_lote?>">
                              <input type="hidden" name="factura" value="<?php echo $ped->factura?>">
                              <input type="hidden" name="cliente" value="<?php echo $ped->cliente?>">
                              <button type="submit" title="Confirmar Venta" class="btn ink-reaction btn-floating-action btn-xs btn-success" name="btn_cobro"><i class="fa fa-money fa-lg"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;
                              <button type="button" title="Eliminar Venta" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_venta('<?php echo $ped->id_lote?>')"><i class="fa fa-trash-o fa-lg"></i></button>
                            </form>
                          </td>
                        </tr>
                      <?php }  ?>
                    </tbody>
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

<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" name="modal_garantia" id="modal_garantia" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">A&ntilde;adir Garant&iacute;a</h4>
      </div>

      <form class="form" role="form" name="form_garantia" id="form_garantia" method="post" action="<?= site_url() ?>venta/C_venta/add_garantia">
        <input type="hidden" name="id_venta" id="id_venta">
        <input type="hidden" name="id_producto" id="id_producto">
        <input type="hidden" name="id_cliente" id="id_cliente">
          <div class="modal-body">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
              <div class="form-group floating-label">
                <input type="text" class="form-control" name="serie_gar" id="serie_gar" onchange="return mayuscula(this);" required>
                <label for="serie_gar">Serie</label>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
              <div class="form-group floating-label">
                <div class="input-group date" id="demo-date">
                  <div class="input-group-content">
                    <input type="text" class="form-control" name="fecha_gar" id="fecha_gar" readonly="" required>
                    <label for="fecha_gar">Fecha</label>
                  </div>
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="form-group floating-label">
                <textarea class="form-control autosize" name="detalle_gar" id="detalle_gar" onchange="return mayuscula(this);" rows="1" required="" aria-required="true"> </textarea>
                <label for="detalle_gar">Caracter&iacute;sticas</label>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END FORM MODAL MARKUP -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function add_garantia(id_ven,id_prod,id_cli){
    $('#form_garantia')[0].reset();
    $('[name="id_venta"]').val(id_ven);
    $('[name="id_producto"]').val(id_prod);
    $('[name="id_cliente"]').val(id_cli);
    $('#modal_garantia').modal('show');
  }
  function eliminar_venta(id_lote){
    $.ajax({
      url: "<?php echo site_url('venta/C_venta/eliminar_venta') ?>",
      type: "POST",
      data: {
        lote: id_lote
      },
      success: function(resp) {
        var c = JSON.parse(resp);
        $.each(c, function(i, item) {
          if (item.oboolean == 't') {
            Swal.fire({
              icon: 'success',
              text: 'LA ELIMINACION SE REALIZO SATISFACTORIAMENTE',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'ACEPTAR'
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            })
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: item.omensaje,
              confirmButtonColor: '#d33',
              confirmButtonText: 'ACEPTAR'
            })
          }
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error al obtener datos de ajax');
      }
    });
  }
</script>
<?php } else {redirect('inicio');}?>
