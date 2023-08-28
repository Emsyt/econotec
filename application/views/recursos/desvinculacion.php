<?php
/*
    ------------------------------------------------------------------------------
    Creador: Alison Paola Pari Pareja  Fecha 09/03/2023, Codigo: GAN-DPR-M4-0348,
    Descripcion: Se creo el frontend del sub modulo de desvinculacion 
     ------------------------------------------------------------------------------
*/

?>
<?php if (in_array("smod_recur_desvin", $permisos)) { ?>
<script>
  $(document).ready(function() {

    activarMenu('menu16_7');
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
        <li class="active">Desvinculacion</li>
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
          <div class="text-divider visible-xs"><span>Formulario de Solicitud de Desvinculacion</span></div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form class="form form-validate" novalidate="novalidate" name="form_desvinculacion" id="form_desvinculacion" method="post">
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
                                    <div class="col-md-5">
                                      <div class="form-group">
                                        <div class="input-group date" id="demo-date">
                                          <div class="input-group-content">
                                              <input type="text" class="form-control" name="fecha_inicial" id="fecha_inicial" readonly="" required>
                                              <label for="fecha_inicial">Fecha de Salida</label>
                                          </div>
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group floating-label" id="c_sigla">
                                            <input class="" type="file" name="archivo" id="getFile" accept=".doc,.docx,.pdf" required />
                                            <span id="error-file" style="color: blue;">Seleccione la carta de desvinculacion</span>
                                        </div>
                                    </div>
                                </div>   
                                <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group floating-label" id="c_motivo">
                                        <input type="text" class="form-control" name="motivo" id="motivo">
                                        <label for="motivo">Razon de desvinculacion</label>
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
      <div class="row" style="display: none;" id="form_solicitud">
       `<div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
          <div class="text-divider visible-xs"><span>Solicitud de Desvinculacion</span></div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form class="form form-validate" novalidate="novalidate" name="form_solicitud" id="form_solicitud" method="post">
                         <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a id="btn_update" class="btn btn-icon-toggle" onclick="update_formulario()"><i class="md md-refresh"></i></a>
                                        <a class="btn btn-icon-toggle" onclick="cerrar_formulario()"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header id="titulo_sol"></header>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                      <div class="form-group">
                                        <div class="input-group date" id="demo-date">
                                          <div class="input-group-content">
                                              <input type="text" class="form-control" name="fecha_inicial" id="fecha_inicial" readonly="" required value="15/03/2023">
                                              <label for="fecha_inicial">Fecha de Salida</label>
                                          </div>
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                      </div>
                                    </div>
                                </div>   
                                <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group floating-label" id="c_nombre">
                                        <input type="text" class="form-control" name="nombre" id="nombre" value="JOSE PEREZ" disabled>
                                        <label for="nombre">Nombre del empleado</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group" id="c_doc">
                                        <a style="color: blue; cursor:pointer;">carta.docx</a>
                                        <label for="doc">Carta de desvinculacion: </label>
                                      </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group" id="c_tipo">
                                        <select class="form-control select2-list" id="usuario" name="usuario" required>
                                           <option value="">Renuncia</option>
                                           <option value="">Despido</option>
                                           <option value="">Jubilacion</option>
                                        </select>
                                        <label for="mRadio">Tipo de desvinculacion</label>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group floating-label" id="c_razon_sal">
                                        <input type="text" class="form-control" name="razon_sal" id="razon_sal" value="Encontre otro trabajo">
                                        <label for="razon_sal">Razon de salida</label>
                                      </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group floating-label" id="c_comentarios">
                                        <input type="text" class="form-control" name="comentarios" id="comentarios">
                                        <label for="comentarios">Comentarios</label>
                                      </div>
                                  </div>
                                </div>
                            </div>
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button type="button" class="btn btn-flat btn-primary ink-reaction" onclick="registrar(1)" name="btn" id="btn_edit_sol" value="edit" disabled>Modificar Solicitud</button>
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
        <div class="card card-bordered style-primary" id="tabla_desvinculacion">
          <div class="card-body style-default-bright" >
            <div class="table-responsive">
              <table id="datatable_desvinculacion" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Nro</th>
                    <th>Nombre</th>
                    <th>Fecha de solicitud de salida</th>
                    <th>Razon</th>
                    <th>Estado</th>
                    <th>Accion</th>
                  </tr>
                </thead>

                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>JOSE PEREZ</td>
                      <td>15-03-2023</td>
                      <td>Encontre otro trabajo</td>
                      <td>PENDIENTE</td>
                      <td>
                        <button type="button" title="Ver solicitud" class="btn ink-reaction btn-floating-action btn-xs btn-info"onclick="ver_solicitud()"><i class="fa fa-list"></i></button>
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
    <div class="row">
      <div class="col-md-12">
        <div class="text-divider visible-xs"><span>Solicitud</span></div>
        <div class="card card-bordered style-primary"  id="tabla_solicitud">
          <div class="card-body style-default-bright">
            <div class="table-responsive">
              <table id="datatable_solicitud" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Calculo de pago final</th>
                    <th>Adeudos</th>
                    <th>Dias de vacaciones no utilizados</th>
                    <th>Activos pendientes</th>
                    <th>Accion</th>
                  </tr>
                </thead>

                  <tbody>
                    <tr>
                      <td>8000</td>
                      <td>0</td>
                      <td>15</td>
                      <td>NINGUNO</td>
                      <td>
                        <button type="button" title="Confirmar" class="btn ink-reaction btn-floating-action btn-xs btn-success"><i class="fa fa-check fa-lg"></i></button>

                        <button type="button" title="Rechazar" class="btn ink-reaction btn-floating-action btn-xs btn-danger"><i class="fa fa-times fa-lg"></i></button>
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
    $('#datatable_desvinculacion').DataTable({
      "language": {
        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
      },
    });
    $('#datatable_solicitud').DataTable({
      "language": {
        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
      },
    });
    document.getElementById("tabla_solicitud").style.display = "none";
  });
  function formulario() {
    $("#titulo").text("Registrar Solicitud de Desvinculacion");
    document.getElementById("form_registro").style.display = "block";
    document.getElementById("tabla_solicitud").style.display = "none";
    $('#form_desvinculacion')[0].reset();
    $('#btn_edit').attr("disabled", true);
    $('#btn_add').attr("disabled", false);
  }
  function ver_solicitud(){
    $("#titulo_sol").text("Solicitud de Desvinculacion");
    document.getElementById("form_solicitud").style.display = "block";
    document.getElementById("form_registro").style.display = "none";
    document.getElementById("tabla_desvinculacion").style.display = "none";
    document.getElementById("tabla_solicitud").style.display = "block";
    $('#btn_edit_sol').attr("disabled", false);
  }
</script>
<?php } else {
    redirect('inicio');
  } ?>