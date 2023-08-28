<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Alison Paola Pari Pareja Fecha:18/11/2022   GAN-MS-A7-0111,
Descripcion: Se Realizo el frontend del registro de garantias
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:18/11/2022   GAN-DPR-A7-0121,
Descripcion: Se usuaron las funciones para el listado de ventas para garantia
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:09/12/2022   GAN-MS-A5-0177,
Descripcion: Se Realizo y/o modifico el funcionamiento garantia ejecucion, registro y retorno 
considerando ya el numero de serie

*/
?>
<?php if (in_array("smod_reg_gar", $permisos)) { ?>
    <style>
        .modalbody {
            padding: 5%;
        }

        .div1 {
            overflow: auto;
            height: 100px;
        }

        .div1 table {
            width: 100%;
            background-color: lightgray;
        }
    </style>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        var f = new Date();
        fecha_actual = f.getFullYear() + "/" + (f.getMonth() + 1) + "/" + f.getDate();
        $(document).ready(function() {
            activarMenu('menu12', 1);
            $('[name="fecha_inicial"]').val(fecha_actual);
            $('[name="fecha_fin"]').val(fecha_actual);

            var fecha = new Date(); //Fecha actual
            var mes = fecha.getMonth()+1; //obteniendo mes
            var dia = fecha.getDate(); //obteniendo dia
            var ano = fecha.getFullYear(); //obteniendo año
            if(dia<10)
                dia='0'+dia; //agrega cero si es menor de 10
            if(mes<10)
                mes='0'+mes //agrega cero si es menor de 10
            document.getElementById('fecha_garan').value=ano+"-"+mes+"-"+dia;
            buscar();
        });
    </script>

    <script>
        function enviar(destino) {
            document.form_busqueda.action = destino;
            document.form_busqueda.submit();
        }
    </script>

    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Garant&iacute;a</a></li>
                    <li class="active">Listado de Ventas para Garant&iacute;a</li>
                </ol>
            </div>
            <?php if ($this->session->flashdata('success')) { ?>
                <script>
                window.onload = function mensaje() {
                    swal.fire(" ", "<?php echo $this->session->flashdata('success'); ?>", "success");
                }
                </script>
                <?php } else if ($this->session->flashdata('error')) { ?>
                <script>
                window.onload = function mensaje() {
                    swal.fire(" ", "<?php echo $this->session->flashdata('error'); ?>", "error");
                }
                </script>
             <?php } ?>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <form class="form" name="form_busqueda" id="form_busqueda" method="post" target="_blank">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-right">
                                            <img style="height: 65px;" src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes);
                                                                                                print($obj->{'logo'}); ?>">
                                        </div>

                                        <div class="col-xs-9 col-sm-9 col-md-7 col-lg-7 text-center">
                                            <h5 class="text-ultra-bold" style="color:#655e60;"> EMPRESA <?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                                                                                                        print_r($obj->{'titulo'}); ?> </h5>
                                            <h5 class="text-ultra-bold" style="color:#655e60;"> LISTADO DE VENTAS PARA GARANTIA</h5>
                                        </div>

                                        <div class="col-xs-9 col-sm-9 col-md-3 col-lg-3">
                                            <h6 class="text-ultra-bold text-default-light">Usuario: <?php echo $usuario; ?></h6>
                                            <h6 class="text-ultra-bold text-default-light">Fecha: <?php echo $fecha_imp; ?></h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="text-align: center;">
                                            <br>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
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
                                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                    <br>
                                                    <p>AL</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                                    <div class="form-group">
                                                        <div class="input-group date" id="demo-date-val">
                                                            <div class="input-group-content">
                                                                <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" readonly="" required>
                                                                <label for="fecha_fin">Fecha Final</label>
                                                            </div>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <button class="btn ink-reaction btn-raised btn-primary" id="Buscar" name="Buscar" type="button" onclick="buscar();">Generar Listado</button><br><br>
                                                <div class="form-group" id="process" style="display:none;">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="120" style="">
                                                        </div>

                                                    </div>
                                                    <div class="status"></div>
                                                </div>
                                                <br>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="tabla">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Nª</th>
                                                        <th width="16%">C&oacute;digo de venta</th>
                                                        <th width="16%">Cliente</th>
                                                        <th width="16%">Total</th>
                                                        <th width="16%">Fecha</th>
                                                        <th width="15%">Hora</th>
                                                        <th width="15%">Vendedor</th>
                                                        <th width="15%">Fecha de validez</th>
                                                        <th width="15%">Estado</th>
                                                        <th width="16%">Acciones</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- END CONTENT -->
<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" name="garantia" id="garantia" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="formModalLabel">Registrar Garant&iacute;a</h4>
      </div>

      <form class="form form-validate" novalidate="novalidate" name="form_garantia" id="form_garantia"
           enctype="multipart/form-data" method="post" action="<?= site_url() ?>registrar_garantia">
        <input type="hidden" name="id_lote" id="id_lote">
          <div class="modal-body">
          <div class="row">
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="form-group floating-label" id="float_fecha">
                         <input type="date" class="form-control" name="fecha_garan" id="fecha_garan" required>
                        <label for="label_fecha" id="label_fecha">Fecha</label>
                    
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="form-group floating-label">
                <textarea class="form-control autosize" name="caracteristica" id="caracteristica" rows="1" required="" aria-required="true"> </textarea>
                <label for="detalle_gar">Caracter&iacute;sticas</label>
              </div>
            </div>
          </div>
          <div>

          </div class="form-group">
            <label class="btn btn-primary btn-sm btn-file ink-reaction btn-raised">
                Seleccionar Imagen<input style="display: none;" type="file"
                    id="img_gar" name="img_gar" class="form-control" />
            </label>
          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" id="btnGuardar" class="btn btn-primary">Registrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END FORM MODAL MARKUP -->
<script>
function buscar() {
    var fecha_inicial = document.getElementById("fecha_inicial").value;
    var fecha_fin = document.getElementById("fecha_fin").value;
        $.ajax({
            url: '<?= base_url() ?>get_lst_garantias1',
            type: "post",
            datatype: "json",
            data: {
                fecha_inicial: fecha_inicial,
                fecha_fin: fecha_fin,
            },
            xhr: function() {
                //upload Progress
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //update progressbar
                        $(".progress-bar").css("width", +percent + "%");
                        $(".status").text(percent + "%");
                        if (percent >= 100) {
                            $(".status").text(percent + "%");
                            var delayInMilliseconds = 200;

                            setTimeout(function() {
                                //your code to be executed after 1 second
                                $('#process').css('display', 'none');
                                $('.progress-bar').css('width', '0%');
                                percent == 0;
                            }, delayInMilliseconds);
                        }
                    }, true);
                }
                return xhr;
            },
            beforeSend: function() {
                $('#process').css('display', 'block');
            },
            success: function(data) {
                var data = JSON.parse(data);
                $('#datatable').DataTable({
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
                    "aoColumns": [{
                            "mData": "onro"
                        },
                        {
                            "mData": "ocodigo"
                        },
                        {
                            "mData": "ocliente"
                        },
                        {
                            "mData": "ototal"
                        },
                        {
                            "mData": "ofecha"
                        },
                        {
                            "mData": "ohora"
                        },
                        {
                            "mData": "ousucre"
                        },
                        {
                            "mData": "ofecha_val"
                        },
                        {
                            "mData": "oestado"
                        },
                        {
                        render: function(data, type, row) {
                            //console.log(row);
                            if(row['oestado'] == 'REGISTRADO'){
                            var a = `
                                        <button type="button" disabled class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="reg_garantia(${row.olote});" data-toggle="modal" data-target="#garantia"><i class="fa fa-list"></i></button>
                                        
                                    `;
                            }else{
                                var a = `
                                        <button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="reg_garantia(${row.olote});" data-toggle="modal" data-target="#garantia"><i class="fa fa-list"></i></button>
                                        
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

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });

}
function reg_garantia(id_lote){

//$('#fecha_garan').datepicker();
// $("#form").find(".fecha_gar").datepicker('destroy').removeAttr('id');
//      cloneRow = $("#form").clone().removeClass('fila-base').appendTo("#tabla tbody");
//      cloneRow.find("td:eq(0) input").datepicker();

$('#float_fecha').removeClass("floating-label");

document.getElementById("id_lote").value=id_lote;
}
</script>

<?php } else {
    redirect('inicio');
} ?>