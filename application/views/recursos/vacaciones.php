<?php
/*
    ------------------------------------------------------------------------------
    Creador: Alison Paola Pari Pareja  Fecha 01/03/2023, Codigo: GAN-DPR-B9-0319,
    Descripcion: Se creo el frontend del sub modulo de vacaciones 
     ------------------------------------------------------------------------------
*/

?>
<?php if (in_array("smod_recur_vaca", $permisos)) { ?>
<script>
  $(document).ready(function() {

    activarMenu('menu16_4');
  });
</script>

<style>
  hr {
    margin-top: 0px;
  }
  h5 {
  display: inline-block;
  }
  
</style>
<script src="<?= base_url(); ?>assets/libs/leaflet/leaflet.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- BEGIN CONTENT-->
<div id="content">
  <section>
    <div class="section-header">
      <ol class="breadcrumb">
        <li><a href="#">Recursos Humanos</a></li>
        <li class="active">Vacaciones</li>
      </ol>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="text-primary">Listado de Solicitudes
            <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp; Nueva Solicitud</button>
          </h3>
          <hr>
        </div>
      </div>
      <div class="row" style="display: none;" id="form_registro">
       `<div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
          <div class="text-divider visible-xs"><span>Formulario de Solicitud de Vacacion</span></div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form class="form form-validate" novalidate="novalidate" name="form_vacaciones" id="form_vacaciones" method="post">
                         <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a id="btn_update" class="btn btn-icon-toggle" onclick="update_formulario()"><i class="md md-refresh"></i></a>
                                        <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header id="titulo"></header>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <div class="input-group date" id="demo-date">
                                          <div class="input-group-content">
                                              <input type="text" class="form-control" name="fecha_inicial" id="fecha_inicial" readonly="" required>
                                              <label for="fecha_inicial">Fecha Inicial</label>
                                          </div>
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <div class="input-group date" id="demo-date-val">
                                          <div class="input-group-content">
                                              <input type="text" class="form-control" name="fecha_final" id="fecha_final" readonly="" required>
                                              <label for="fecha_final">Fecha Final</label>
                                          </div>
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group" id="c_calculo">
                                        <input type="text" class="form-control" name="calculo" id="calculo" disabled value="5">
                                        <label for="calculo">Dias calculados</label>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group" id="c_saldo">
                                        <input type="text" class="form-control" name="saldo" id="saldo" disabled value="25">
                                        <label for="saldo">Saldo de vacaciones</label>
                                      </div>
                                    </div>
                                </div>   
                                <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group floating-label" id="c_motivo">
                                        <input type="text" class="form-control" name="motivo" id="motivo">
                                        <label for="motivo">Motivo</label>
                                      </div>
                                  </div>
                                </div>
                            </div>
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="registrar(1)" name="btn" id="btn_edit" value="edit" disabled>Modificar Solicitud</button>
                                    <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="registrar(0)" name="btn" id="btn_add" value="add">Registrar Solicitud</button>
                                </div>
                            </div>
                        </div>                                
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
        <div class="card card-bordered style-primary">
          <div class="card-body style-default-bright">
            <div class="row">
              <div class="col-md-4">
                <h5 class="text-ultra-bold" style="color:#655e60;">Dias de vacacion: </h5><h5> 20</h5>
              </div>
              <div class="col-md-4">
                <h5 class="text-ultra-bold" style="color:#655e60;">Dias de vacacion CAS: </h5><h5> 10</h5>
              </div>
              <div class="col-md-4">
                <h5 class="text-ultra-bold" style="color:#655e60;">Dias de totales de vacacion: </h5><h5> 30</h5>
              </div>
            </div>
            <div class="table-responsive">
              <table id="datatable_vacaciones" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Nro</th>
                    <th>Nombre</th>
                    <th>Periodo</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Accion</th>
                  </tr>
                </thead>

                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>JOSE</td>
                      <td>01-02-2023 AL 05-02-2023</td>
                      <td>5 Dias</td>
                      <td>PENDIENTE</td>
                      <td>
                        <button type="button" title="Editar" class="btn ink-reaction btn-floating-action btn-xs btn-info"><i class="fa fa-pencil-square-o fa-lg"></i></button>

                        <button type="button" title="Eliminar" class="btn ink-reaction btn-floating-action btn-xs btn-danger"><i class="fa fa-trash-o fa-lg"></i></button>
                      </td>
                    </tr>
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

</div>
<!-- END CONTENT -->
<script>
  $(document).ready(function() {
    // INICIO Oscar L. GAN-MS-B0-0283
    $('#datatable_vacaciones').DataTable({
      "language": {
        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
      },
    });
  });
  function formulario() {
    $("#titulo").text("Registrar Solicitud de Vacacion");
    document.getElementById("form_registro").style.display = "block";
    $('#form_vacaciones')[0].reset();
    $('#btn_edit').attr("disabled", true);
    $('#btn_add').attr("disabled", false);
  }
</script>
<?php } else {
    redirect('inicio');
  } ?>