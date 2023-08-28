<?php
/* ------------------------------------------------------------------------------
Creador: Ayrton Jhonny Guevara Montaño Fecha:19/05/2023, Codigo: GAN-DPR-B5-0478
Descripcion: Se creo la vista de un submodulo de tickets en el modulo de promociones
    ------------------------------------------------------------------------------
  Modificado: Ayrton Jhonny Guevara Montaño Fecha:19/05/2023, Codigo: GAN-MS-B1-0486
  Descripcion: Se agrego la funcion de imprimir tickets en un pdf
    ------------------------------------------------------------------------------
  Modificado: Ayrton Jhonny Guevara Montaño Fecha:19/05/2023, Codigo: GAN-MS-M0-0492
  Descripcion: Se ingreso un toogle para repetir los tickets segun la cantidad de columnas
  y para ello se desabilito las filas
    ------------------------------------------------------------------------------
  Modificado: Ayrton Jhonny Guevara Montaño Fecha:25/05/20023 Codigo:GAN-MS-B7-0496
  Descripcion: Se añadio la funcion filcolrecomendado() para que existan sugerencias
  de filas o columnas cuando su contraparte es ingresada - tambien se hizo el calculo
  de el numero de filas si se elige la opcion de repeticion
*/
?>
*/
?>

<?php if (in_array("smod_prom_tick", $permisos)) { ?>
    <script>
        var adescripcion = new Array();
        $(document).ready(function() {
            activarMenu('menu11', 2);
        });
        function repe(){
            var toggle = document.getElementById("con_repeticion");
            var element = document.getElementById("NFilas");
            var Nfin = document.getElementById("NFinal").value;
            var Nini = document.getElementById("NInicial").value;
            var Nrango = document.getElementById("Rango").value;
            var tipo = $("input[type=radio][name=tipo]:checked").val();
            var res1;
            if(toggle.checked){
                element.disabled = true;
                element.removeAttribute("required"); 
                res1=(tipo == "incremental") ? Math.ceil(((Nfin-Nini)+1)/Nrango) : Math.ceil(((Nini-Nfin)+1)/Nrango);
                //element.defaultValue= res1;
                $('#NFilas').val(res1).trigger('change');
            } else {
                element.disabled = false;  
                element.setAttribute("required", "");
            }
        }
    </script>
    <style>
        hr {
            margin-top: 0px;
        }

        textarea {
            resize: none;
        }
    </style>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Promociones</a></li>
                    <li class="active">Tickets</li>
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
                    <div class="col-lg-12">
                        <h3 class="text-primary">Listado de Tickets
                            <button type="button" class="btn btn-primary ink-reaction btn-sm pull-right" onclick="formulario()"><span class="pull-left"><i class="fa fa-plus"></i></span> &nbsp;
                                Nueva Configuraci&oacute;n</button>
                        </h3>
                        <hr>
                    </div>
                </div>

                <input type="hidden" class="form-control" name="contador" id="contador" value="0">
                <div class="row" style="display: none;" id="form_registro">
                    <div class="col-sm-8 col-md-9 col-lg-10 col-lg-offset-1">
                        <div class="text-divider visible-xs"><span>Formulario de Registro</span></div>

                        <div class="row col-md-10 col-md-offset-1">
                        <form class="form form-validate" novalidate="novalidate" name="form_ticket" id="form_ticket" enctype="multipart/form-data" method="post" action="<?= site_url() ?>promociones/C_ticket/add_update_ticket">
                            <!--<form class="form form-validate" novalidate="novalidate" name="form_ticket" id="form_ticket" enctype="multipart/form-data" method="post" action="<?= site_url() ?>promociones/C_ticket/add_update_ticket">
                            <form class="form" role="form" name="form_editar" id="form_editar" method="post" >-->
                                <input type="hidden" name="id_ticket" id="id_ticket">
                                    <!--??id_tiket???-->
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

                                    <div class="card-body" style="padding-bottom: 0px">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group floating-label" id="c_NInicial">
                                                            <input class="form-control select2-list" id="NInicial" name="NInicial" type="number" required>
                                                            <label for="categoria">Numero Inicial</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group floating-label" id="c_NFinal">
                                                            <input class="form-control select2-list" id="NFinal" name="NFinal" type="number" required>
                                                            <label for="marca">Numero Final</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group floating-label" id="c_rango"><!--??-->
                                                            <input type="number" class="form-control" name="Rango" id="Rango" min="1" required>
                                                            <label for="codigo">Rango</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_Tipo"><!--??-->
                                                            <label for="Firstname5" class="col-sm-2 control-label">Tipo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <div class="col-sm-10">
                                                                <label class="radio-inline radio-styled">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="radio" name="tipo" id="tipo" value="incremental" ><span>Incremental</span>
                                                                </label>
                                                                <label class="radio-inline radio-styled">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="radio" name="tipo" id="tipo" value="decremental" ><span>Decremental</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_repeticion">
                                                            <input type="checkbox" class="form-control" name="con_repeticion" id="con_repeticion" data-toggle="toggle" data-width="175" data-on="ConRepeticion" data-off="SinRepeticion" onchange="repe()">
                                                            <input type="text" class="form-control" id="repeticion" name="repeticion" value="unidad" style="color: #FA5600; display:none;">
                                                            <input type="hidden" id="repeticionn" name="repeticionn" value="false">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_NFilas">
                                                            <input type="number" class="form-control" name="NFilas" id="NFilas" min="1" onchange="filcolrecomendado()" required>
                                                            <label for="producto">Numero de Filas</label>
                                                            <div align="left" id="msfilas" style="color: #006400"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_NColumnas">
                                                        <input type="number" class="form-control" name="NColumnas" id="NColumnas" min="1" max="7" onchange="filcolrecomendado()"required>
                                                            <label for="producto">Numero de Columnas</label>
                                                            <div align="left" id="mscolumnas" style="color: #006400"></div>
                                                        </div>
                                                        
                                                    </div>
                                                    <!--Ayrton Internileado-->
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_Interlineado">
                                                            <input type="number" class="form-control" name="interlineado" id="interlineado" min="0.00">
                                                            <label for="producto">Espacio Interlineado</label>
                                                            <div align="left" id="mscolumnas" style="color: #006400">Expresado en cent&iacute;metros</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group floating-label" id="c_Interlineado">
                                                            <select class="form-control select2-list" name="THoja" id="THoja">
                                                            <option value="carta" selected>Carta</option>
                                                            <option value="oficio">Oficio</option>
                                                            </select>
                                                            <label for="producto">Tamaño de hoja</label>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-actionbar">
                                    <div class="card-actionbar-row">
                                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_edit" value="edit" disabled>Modificar Tiket</button>
                                        <button type="submit" class="btn btn-flat btn-primary ink-reaction" name="btn" id="btn_add" value="add" >Registrar Ticket</button>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="text-divider visible-xs"><span>Listado de Tickets</span></div>
                    <div class="card card-bordered style-primary">
                        <div class="card-body style-default-bright">
                            <div class="table-responsive">
                                <table id="datatableprod" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nª</th>
                                            <th>N° Inicial</th>
                                            <th>N° Final</th>
                                            <th>Rango</th>
                                            <th>Tipo</th>
                                            <th>N° Filas</th>
                                            <th>N° Columnas</th>
                                            <th>Acci&oacute;n</th>
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


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(function() {
      $('#con_repeticion').change(function() {
        if ($(this).prop('checked')) {
          $("#repeticionn").val('true');
        } else {
          $("#repeticionn").val('false');
        }
      })
    })
    //Ayrton Guevara 25/05/20023 GAN-MS-B7-0496
    function filcolrecomendado(){
            var filas = document.getElementById("NFilas").value;
            var columnas = document.getElementById("NColumnas").value;
            var Nini = document.getElementById("NInicial").value;
            var Nfin = document.getElementById("NFinal").value;
            var Nrango = document.getElementById("Rango").value;
            var tipo = $("input[type=radio][name=tipo]:checked").val();
            var divcolumnas = document.getElementById("mscolumnas");
            var divfilas = document.getElementById("msfilas");
            var elementfilas = document.getElementById("NFilas");
            var elementcolumnas = document.getElementById("NColumnas");
            var res1=0;
            var res2=0;
            //para resolver con el dato de las columnas puesto
            if(columnas.length > 0 && filas.length<=0){
                if(tipo == "incremental"){
                    //se encuentra la cantidad de tickets que se espera recibir
                    res1=Math.ceil(((Nfin-Nini)+1)/Nrango);
                    //se calcula el numero de filas con respecto al numero de columnas introducidas
                    res2=Math.ceil(res1/columnas);
                    //se manda mensaje a filas para dar la recomendacion del numero de columnas
                    divfilas.textContent = "Se debe introducir un número igual o mayor a " + res2;
                    $('#NFilas').val(res2).trigger('change');
                }else if(tipo == "decremental"){
                    res1=Math.ceil(((Nini-Nfin)+1)/Nrango);
                    res2=Math.ceil(res1/columnas);
                    divfilas.textContent = "Se debe introducir un número igual o mayor a " + res2 ;
                    $('#NFilas').val(res2).trigger('change');
                }
            //para resolver con el dato de las filas puesto
            }else if(filas.length > 0 && columnas.length <=0){
                if(tipo == "incremental"){
                    res1=Math.ceil(((Nfin-Nini)+1)/Nrango);
                    res2=Math.ceil(res1/filas);
                    divcolumnas.textContent = "Se debe introducir un número igual o mayor a " + res2;
                    $('#NColumnas').val(res2).trigger('change');
                }else if(tipo == "decremental"){
                    res1=Math.ceil(((Nini-Nfin)+1)/Nrango);
                    res2=Math.ceil(res1/filas);
                    divcolumnas.textContent = "Se debe introducir un número igual o mayor a " + res2;
                    $('#NColumnas').val(res2).trigger('change');
                }
            }else if(filas.length<=0 && columnas.length<=0 || filas.length>0 && columnas.length>0){
                divfilas.textContent = " ";
                divcolumnas.textContent = " ";
            }
        }
        //FIN Ayrton Guevara 25/05/20023 GAN-MS-B7-0496
     /*function Add_Ticket() {
            // Realizar la solicitud AJAX a PHP para obtener la respuesta de la base de datos
            var NInicial = document.getElementById("NInicial").value;
            var NFinal = document.getElementById("NFinal").value;
            var Rango = document.getElementById("Rango").value;
            var tipo = document.getElementById("tipo").value;
            var filas = document.getElementById("NFilas").value;
            var columnas = document.getElementById("NColumnas").value;
            console.log("pasa");
            console.log(NInicial);
            console.log(NFinal);
            console.log(Rango);
            console.log(tipo);
            console.log(filas);
            console.log(columnas);
            $.ajax({
                url: "<?php echo site_url('promociones/C_ticket/add_update_ticket') ?>",
                method: "POST",
                data: {
                    NInicial: NInicial,
                    NFinal: NFinal,
                    Rango: Rango,
                    tipo: tipo,
                    filas: filas,
                    columnas: columnas
                },
                success: function(response) {
                    // Mostrar una notificación en la ventana
                    alert("Consulta realizada correctamente");

                    // Llamar a la función en PHP con los parámetros JSON
                    $.ajax({
                        url:  "<?php echo site_url('promociones/C_ticket/generar_pdf_ticket') ?>",
                        method: "POST",
                        data: {
                            parametros: JSON.stringify(response)
                        },
                        success: function(response) {
                            // Decodificar el PDF base64
                            //var pdfData = atob(response.pdf);
                            // Crear un blob a partir de los datos del PDF
                            var blob = new Blob([response], { type: 'application/pdf' });
                            // Crear una URL para el blob
                            var pdfUrl = URL.createObjectURL(blob);
                            // Abrir una nueva ventana con el PDF
                            //window.open(pdfUrl);
                            $('#pdf_file_edit').attr("src",pdfUrl);
                            console.log("Función en PHP invocada con éxito");
                        }
                    });
                },
                error: function() {
                    console.error("Error al realizar la consulta");
                }
            });
        }*/
    
        
        function formulario() {
            $("#titulo").text("Registrar Ticket");
            $('#form_ticket')[0].reset();
            document.getElementById("form_registro").style.display = "block";
            document.getElementById("btn_update").style.display = "block";
            $('#btn_edit').attr("disabled", true);
            $('#btn_add').attr("disabled", false);
        }

        function cerrar_formulario() {
            document.getElementById("form_registro").style.display = "none";
            $('#form_ticket')[0].reset();
            document.getElementById("list").innerHTML = '';
        }

        function update_formulario() {
            $('#form_ticket')[0].reset();
            document.getElementById("list").innerHTML = '';
            $('#btn_edit').attr("disabled", true);
            $('#btn_add').attr("disabled", false);
        }

    </script>
<?php } else {
    redirect('inicio');
} ?>