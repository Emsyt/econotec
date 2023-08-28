<?php
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: karen quispe chavez Fecha:01/08/2022, Codigo: GAN-MS-A1-333,
Descripcion: Se creo la vista del ABM llamado recepcion de pedidos, el cual muestra su respectivo formulario 
-------------------------------------------------------------------------------------------------------------------------------

 */
?>
<?php if (in_array("smod_rep_soli", $permisos)) { ?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    activarMenu('menu9', 4);
   
});
</script>
<style>
hr {
    margin-top: 0px;
}
</style>
<!-- BEGIN CONTENT-->
<div id="content">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li><a href="#">Provisi&oacute;n</a></li>
                <li class="active">Recepci&oacute;n de Pedidos</li>
            </ol>
        </div>

        <?php if ($this->session->flashdata('success')) { ?>
        <script>
        window.onload = function mensaje() {
            swal(" ", "<?php echo $this->session->flashdata('success'); ?>", "success");
        }
        </script>
        <?php } else if($this->session->flashdata('error')){ ?>
        <script>
        window.onload = function mensaje() {
            swal(" ", "<?php echo $this->session->flashdata('error'); ?>", "error");
        }
        </script>
        <?php } ?>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="text-primary">Recepci&oacute;n de Pedidos
                    </h3>
                    <hr>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                <div class="text-divider visible-xs"><span>Listado de Recepci&oacute;n de Pedidos</span></div>
                    <div class="card card-bordered style-primary">
                        <div class="card-body style-default-bright">
                            <div class="table-responsive">
                                <table id="datatable1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>

                                            <th>Nro</th>
                                            <th>Ubicaci&oacute;n despachante</th>
                                            <th>Ubicaci&oacute;n solicitante</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Accion </th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php
                    foreach ($listar_recepciones as $sol) { ?>
                      <tr>
                        <td><?php echo $sol->onro ?></td>
                        <td><?php echo $sol->ode ?></td>
                        <td><?php echo $sol->oa ?></td>
                     
                        <td><?php echo $sol->ofecha ?></td>
                        <td>
                          <div id="estado<?php echo $sol->olote ?>"><?php echo $sol->apiestado ?></div>
                        </td>
                        <td align="center">
                        <form name="form_accion" id="id_rec"  method="post" action="<?= site_url() ?>provision/C_recepcion_pedidos/lista_pedidos">
                             <input type="hidden"  name="id_lote" id="id_lote" value="<?php echo ($sol->olote)?>" >
                             <input type="hidden"  name="nro" id="nro" value="<?php echo ( $sol->onro)?>" >
                             <input type="hidden"  name="ode" id="ode" value="<?php echo ($sol->ode)?>" >
                             <input type="hidden"  name="oa" id="oa" value="<?php echo ($sol->oa)?>" >
                             <button type="submit" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick=" " title ="ver pedidos" ><i class="fa fa-eye"></i></button>
                             <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar_recepcion(<?php echo ($sol->olote)?>)" title ="Eliminar" ><i class="fa fa-trash-o"></i></button>
                       </form>
                        
                        </td>
                     
                      </tr>
                    <?php } ?>
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


<script>

function eliminar_recepcion(id_lote) {

    var titulo = 'ELIMINAR REGISTRO';
    var mensaje = '<div>Esta seguro que desea Eliminar el registro</div>';

    BootstrapDialog.show({
        title: titulo,
        message: $(mensaje),
        buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialog) {

                dialog.close();

                $.ajax({
                    url: '<?=base_url()?>provision/C_recepcion_pedidos/dlt_recepcion/' +
                        id_lote,
                    type: "post",
                    datatype: "json",

                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data[0].oboolean == 't') {
                            Swal.fire({
                                icon: 'success',
                                text: "La recepcion se ha eliminado correctamente",
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'ACEPTAR'
                            }).then((result) => {

                                if (result.isConfirmed) {
                                    location.reload();
                                } else {
                                    location.reload();
                                }
                            })

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Error',

                            })
                        }


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax');
                    }
                });

            }
        }, {
            label: 'Cancelar',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
}
</script>
<?php } else {redirect('inicio');}?>
