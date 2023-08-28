<?php
/*
  -------------------------------------------------------------------------------
  Creador: Alison Paola Pari Pareja Fecha:29/11/2022, Codigo: GAN-MS-A7-0145
  Descripcion: Se creo la vista y funcionamiento del registro de series
  -------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:30/11/2022, Codigo: GAN-MS-A5-0160
  Descripcion: Se modifico para que al registrar o modificar no pueda ingresarse una serie duplicada
  -------------------------------------------------------------------------------
  */
?>
<?php if (in_array("smod_items", $permisos)) { ?>

<script>
  $(document).ready(function(){
      activarMenu('menu2',5);
      lista();
      document.getElementById("serie").focus();
  });
  
</script>

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
          <ol class="breadcrumb">
              <li><a href="#">Items</a></li>
              <li class="active">Registro de series</li>
              <!-- <button style="text-align:right;" type="button" class="btn btn-default ink-reaction btn-raised" onclick="volver()"><span class="pull-left"><i class="fa fa-mail-reply fa-lg"></i></span> Volver </button> -->

          </ol>
      </div>

      <?php if ($this->session->flashdata('success')) { ?>
        <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('success'); ?>","success"); } </script>
      <?php } else if($this->session->flashdata('error')){ ?>
        <script> window.onload = function mensaje(){ swal(" ","<?php echo $this->session->flashdata('error'); ?>","error"); } </script>
      <?php } ?>

      <div class="section-body">
          <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-10  col-md-offset-2 col-lg-8 col-lg-offset-2">
                    <div class="form card">
                        <div class="card-head style-primary">
                            <header>Registro de Series</header>
                            
                        </div>
                        <div class="card-body">
                            <div class="form-group floating-label col-xs-12 col-sm-10 col-md-9 col-lg-9">
                                    <input type="text" class="form-control" onkeypress="guardar(event);" name="serie" id="serie">
                                    
                            </div>
                            <div class="form-group floating-label col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                <button type="button" id="btn" value="0" class="btn btn-primary" onclick="add_serie()">REGISTRAR</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card card-bordered style-primary">
              <div class="card-head style-primary">
                <header id="series">Series registradas</header>
              </div>
              <input type="hidden" id="lote" name="lote" value="<?php echo $lote ?>">
              <input type="hidden" id="provision" name="provision" value="<?php echo $provision ?>">
              <input type="hidden" id="producto" name="producto" value="<?php echo $producto ?>">
              <input type="hidden" id="cant" name="cant" value="<?php echo $cant ?>">
              <div class="card-body style-default-bright">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                              <th>N&deg;</th>
                              <th width="60%">Serie</th>
                              <th>Estado</th>
                              <th>Accion</th>
                            </tr>
                        </thead>
                         
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
 function lista() {
        var id_lote = document.getElementById("lote").value;
        var id_producto = document.getElementById("producto").value;
        var id_provision = document.getElementById("provision").value;
        $.ajax({
            url: '<?= base_url() ?>listar_series',
            type: "post",
            datatype: "json",
            data: {
                id_provision:id_provision,
                id_lote: id_lote,
                id_producto: id_producto,
            },
            success: function(data) {
                var data = JSON.parse(data);
                table=$('#datatable').DataTable({
                    "data": data,
                    "responsive": true,
                    "language": {
                        "url": "<?= base_url() ?>assets/plugins/datatables_es/es-ar.json"
                    },
                    "destroy": true,
                    "columnDefs": [{
                        "searchable": true,
                        "orderable": false,
                        "targets": 0
                    }],
                    "aoColumns": [
                        {
                            "mData": "onro"
                        },
                        {
                            "mData": "ocodigo"
                        },
                        {
                            "mData": "oestado"
                        },
                        {
                        render: function(data, type, row) {
                          if(row['oestado'] == 'COBRADO'){
                            var a = `
                                <button type="button" disabled class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="recuperar(${row.oiditem})" title="Registrar serie"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                <button type="button" disabled class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(${row.oiditem})" title="Generar Automatico"><i class="fa fa-trash-o fa-lg"></i></button>  
                              
                                    `;
                          }else{
                            var a = `
                                <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="recuperar(${row.oiditem})" title="Registrar serie"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(${row.oiditem})" title="Generar Automatico"><i class="fa fa-trash-o fa-lg"></i></button>  
                              
                                    `;
                          }
                            return a;
                        }
                        },

                    ],
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Columnas"
                    },
                });
                 var info = table.page.info();
                 var count = info.recordsTotal;
                 var cant = document.getElementById("cant").value;
                 $("#series").text("Series registradas: "+count+"/"+cant);
                 if (count==cant){
                  $('#btn').attr("disabled", true);
                  $('#serie').attr("disabled", true);
                 }
                 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
    }
  function volver(){
    location.href="<?php echo base_url();?>venta";
  }
  function add_serie(){
   
    var btn = document.getElementById("btn").value;
    var id_lote = document.getElementById("lote").value;
    var id_producto = document.getElementById("producto").value;
    var id_provision = document.getElementById("provision").value;
    var serie = document.getElementById("serie").value;
   console.log(btn);
   console.log(id_lote);
   console.log(id_producto);
   console.log(id_provision);
   console.log(serie);
    $.ajax({
            url: '<?= base_url() ?>add_edit_serie',
            type: "post",
            datatype: "json",
            data: {
                btn:btn,
                id_provision:id_provision,
                id_lote: id_lote,
                id_producto: id_producto,
                serie:serie,
            },
            success: function(data) {
              var dat = JSON.parse(data);
              if (dat[0].oboolean == 'f') {
                    Swal.fire({
                        icon: 'error',
                        text: dat[0].omensaje,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ACEPTAR',
                        showCancelButton: true,
                        cancelButtonText: 'CANCELAR'
                    })
                } else {
                  location.reload();
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
  }
  function guardar(e) {
    if (e.keyCode === 13 ) {
      add_serie();
    }
  }
  function recuperar(id_item) {
    $('#btn').attr("disabled", false);
    $('#serie').attr("disabled", false);
    $.ajax({
            url: '<?= base_url() ?>recuperar_serie',
            type: "post",
            datatype: "json",
            data: {
              id_item:id_item,
            },
            success: function(data) {
              var data = JSON.parse(data);
              var json = JSON.parse(data);
              console.log(json);
              $("#btn").text("MODIFICAR");
              document.getElementById("serie").value=json.Serie;
              document.getElementById("btn").value=json.id_item;
              document.getElementById("lote").value=json.id_lote;
              document.getElementById("producto").value=json.id_producto;
              document.getElementById("provision").value=json.id_provision;

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
  }
  function eliminar(id_item){
      var titulo = 'ELIMINAR REGISTRO';
      var mensaje = '<div>Esta seguro que desea Eliminar el registro?</div>';
   
    BootstrapDialog.show({
      title: titulo,
      message: $(mensaje),
      buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
            action: function (dialog) {
                var $button = this;
                $button.disable();
                $.ajax({
                  url: '<?= base_url() ?>eliminar_serie',
                  type: "post",
                  datatype: "json",
                  data: {
                    id_item:id_item,
                  },
                  success: function(data) {
                    location.reload();
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      alert('Error al obtener datos de ajax');
                  }
              });
            }
          }, {
          label: 'Cancelar',
          action: function (dialog) {
              dialog.close();
          }
      }]
    });
    
  }
</script>
<?php } else {redirect('inicio');}?>
