<?php
/*
      Creador: Heidy Soliz Santos Fecha:20/04/2021, Codigo:SYSGAM-001
      Descripcion:Creacion de la vista pedido por codigo
      ------------------------------------------------------------------------------
      Modificado: Heidy Soliz Santos Fecha:27/04/2021, Codigo:SYSGAM-003
      Descripcion:Se modifico para enviar el codigo de producto
      ------------------------------------------------------------------------------
      Modificado: Heidy Soliz Santos Fecha:29/04/2021, Codigo:SYSGAM-004
      Descripcion:Se modifico el campo de cantidad por un input que venia pre llenado pero el mismo se puede editar
      ------------------------------------------------------------------------------
      Modificado: Heidy Soliz Santos Fecha:30/04/2021, Codigo:SYSGAM-005
      Descripcion:Se modifico cambiar la cantidad
      -------------------------------------------------------------------------
      Modificado: Heidy Soliz Santos Fecha:05/05/2021, Codigo:SYSGAM-007
      Descripcion:Se modifico eliminar un producto
      ------------------------------------------------------------------------------
      Modificado: Heidy Soliz Santos Fecha:06/05/2021, Codigo: SYSGAM-008
      Descripcion:Se modifico para implementar mostrar el calculo de cambio y tambien el metodo de realizar cobro
      ------------------------------------------------------------------------------
      Modificado: Heidy Soliz Santos Fecha:11/05/2021, Codigo: SYSGAM-009
      Descripcion: Se modifico para corregir  el error
      ------------------------------------------------------------------------------
       Modificado: Heidy Soliz Santos Fecha:14/05/2021, Codigo: SYSGAM-009
      Descripcion: Se modifico para corregir  el error
      ------------------------------------------------------------------------------
       Modificado: Heidy Soliz Santos Fecha:15/05/2021, Codigo: SYSGAM-0010
      Descripcion: Se modifico para actualizar el total
      ------------------------------------------------------------------------------
   Modificado: Heidy Soliz Santos Fecha:15/05/2021, Codigo: SYSGAM-011
    Descripcion: Se modifico para actualizar la vista
    ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:26/05/2021, Codigo:  GAM -011
  Descripcion: Se modifico para hacer la busqueda de nit como en el maquetado
    ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:1/06/2021, Codigo:  GAM -011
  Descripcion: Se modifico mejorar el alert de realizar cobro
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:8/06/2021, Codigo: GAM-026
  Descripcion: Se modifico para que el radio de los iconos funcione correctamente
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:8/06/2021, Codigo: GAM-027
  Descripcion: Se modifico para que el input codigo tenga un autocompletado
  ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:15/06/2021, Codigo: GAM-028
  Descripcion: Se modifico para completar el nombre del producto
    ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:29/06/2021, Codigo: GAM-032
  Descripcion: Se modifico poner tooltip a los radio button
    ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:07/07/2021, Codigo: GAM-032
  Descripcion: Se modifico para que el cliente no desaparesca
    ------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:12/07/2021, Codigo: GAM-032
  Descripcion: Se modifico arreglar el campo cantidad
  -------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha:19/07/2021, Codigo: GAN-BA-A0-008
  Descripcion: Se modifico para poner un mensaje de error
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:11/08/2021, Codigo: GAN-MS-A1-012
  Descripcion: Se modifico el campo accion donde se aumento un icono para visualizar
  la imagen imagen del producto
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:14/09/2021, Codigo: GAN-MS-A1-012
  Descripcion: Se modifico botton btnFinalizar para que pueda abrir un modal 
  el cual permitira generar un pdf o no
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:20/09/2021, Codigo: GAN-MS-M0-032
  Descripcion: Se ajusto el modal finalizar venta para una mejor visualizacion la cual
  permite generar un pdf nota venta
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:23/09/2021, GAN-MS-A1-033
  Descripcion: Se realizaron la modificacion de la funcion finalizar para que esta pueda abrir el modal que permite generar un pdf
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:05/11/2021, Codigo: GAN-MS-A4-063
  Descripcion: Se modifico la funcion onkeydown_cantidad() y enter() para que puedan validar la cantidad de un producto
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:05/11/2021, Codigo: GAN-MS-A4-064
  Descripcion: Se modifico en la funciones para que se devuelva el dato en redondeo a dos decimales en: precio_unidad, precio_total, total, cambio, saldo, pagado.
  -------------------------------------------------------------------------------
  Correccion: Melvin Salvador Cussi Callisaya Fecha:23/11/2021, Codigo: GAN
  Descripcion: se corrigio la funcion relizar pedido por codigo para reemplazar en la busqueda por el nuevo codigo que se le asigno por base de datos,
  se corrigio el autocompletado con el parametro correspondiente de CI/NIT/Cod. Cliente
  -------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:24/11/2021, Codigo: GAN-MS-A4-100
  Descripcion: se adiciono una manera de que se recuperen los ids correspondientes a pesar que los nombres sean similares
  -------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:24/11/2021, Codigo: GAN-MS-A4-100
  Descripcion: Se edito el focus del sistema para que al momento de registrar un producto este campo sea el mismo focus para insertar otro
  -------------------------------------------------------------------------------
  Modificado: Daniel Castillo Quispe Fecha:05/03/2022
  Descripcion: Se ha cambiado el posicionamiento del cursor a la cantidad cada vez que se agrega un nuevo producto
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:22/03/2022, Codigo:GAN-MS-M5-135
  Descripcion: se agrego un boton al momento de realizar el calculo para que este sea mas amigable con el usuario al momento de realizar el calculo,
  ademas de que se agrego un filtro para evitar el error de cambio con numeros negativos
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:14/04/2022, Codigo:GAN-FR-A5-157
  Descripcion: se cambiaron los nombres/titulos segun lo acordado en la reunion
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:20/04/2022, Codigo:GAN-MS-A4-172
  Descripcion: se soluciono el error al momento de enviar, ademas de que se elimino el boton de CALCULAR como se quedo acordado
    ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:21/04/2022, Codigo:GAN-MS-A4-184
  Descripcion: se reviso y corrigio el error al finalizar la venta rapida
 ------------------------------------------------------------------------------
  Modificado: karen quispe chavez fecha 23/06/2022 Codigo :GAN-MS-A6-276
  Descripcion : se aumento  un tipo de pago por QR en el modulo de venta rapida
  ------------------------------------------------------------------------------
  Modificado: Saul Imanol Quiroga Castrillo fecha 02/08/2022 Codigo :GAN-MS-A1-334
  Descripcion : se adicionaron a los campos cantidad y precio unidad el evento "onblur" para que su calculo interno pueda ser 
  ahora ejecutado en dispositivos moviles. Tambien se adiciono la opcion "charCode == null" para que dicho funcionamiento se realize.
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana fecha 03/08/2022 Codigo :GAN-MS-A1-336
  Descripcion : se modifico la funcion finalizar para la eliminacion de modales y pop-ups
 ------------------------------------------------------------------------------
  Modificado: Gabriela Mamani Choquehuanca fecha 15/08/2022 Codigo :GAN-MS-A1-358
  Descripcion : se modifico el input nit para que no acepte valores negativos 
 ------------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma fecha 08/09/2022 Codigo :GAN-FR-A1-431
  Descripcion : se agrego el boton para ver stock y su modal correspondiente.
 ------------------------------------------------------------------------------
  Modificado: Pedro Rodrigo Beltran Poma fecha 08/09/2022 Codigo :GAN-MS-A1-436
  Descripcion : se agrego la funcionalidad al boton para ver el stock funcion mostrar_stock()
 ------------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa 26/09/2022 Codigo : GAN-FR-A1-488
  Descripcion : se agrego el campo unidad a la derecha de la cantidad y se ajusto el tamaño de las columnas
   ------------------------------------------------------------------------------
  Modificado: Alvaro Ruben Gonzales Vilte 28/09/2022 Codigo : GAN-MS-A1-485
  Descripcion : se modifico el onClick de la visualizacion del stock del producto en otras ubicaciones
     ------------------------------------------------------------------------------
  Modificado:Gary Germnan Valverde Quisbert 04/10/2022 Codigo : GAN-MS-A0-0030
  Descripcion : Se agrego el td de unida a la destruccion y estructuracion de los inner.html
  ------------------------------------------------------------------------------
  Modificado: Keyla Paola Usnayo Aguilar 11/10/2022 Codigo : GAN-SC-M3-0041
  Descripcion : Se agrego una pagina modal y una función para mostrar los precios de cada producto
  ------------------------------------------------------------------------------
  Modificado: Keyla Paola Usnayo Aguilar 13/10/2022 Codigo : GAN-MS-M0-0045
  Descripcion : Se modifico la función cambio_uni para que la pagina modal se cierre y se
  modifico visualmente la tabla de productos
  ------------------------------------------------------------------------------
  Modificado: Keyla Paola Usnayo Aguilar 14/10/2022 Codigo :   GAN-CV-M3-0050
  Descripcion : Se modifico Optimizar el tema visual en el desfase de venta rapida con el total y cambio
  ------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar        14/10/2022       Codigo : GM-ECOGAN-PN-A1-0003
  Descripcion : Se soluciono el error donde no se vusualizaban los precios por producto en 
  la funcion mostrar_precios.
  ------------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa - Jose Daniel Luna Flores 01/11/2022  Codigo:GM-ECOGAN-PN-A7-0006
  Descripcion : Se modico en todos los botones de mostrar stock la forma de enviar el parametro a la funcion mostrar_stock
  ------------------------------------------------------------------------------
  Modificado: Adamary Margell Uchani Mamani  09/11/2022  Codigo:GAN-IC-A0-0092
  Descripcion : Se soluciono el error de cambiar el precio del producto en la función mostrar_precios
    ------------------------------------------------------------------------------
  Modificado: Adamary Margell Uchani Mamani  09/11/2022  Codigo:GAN-MS-A7-0094
  Descripcion : Se soluciono el error de cambiar el precio del producto en la función mostrar_precios de nuevos precios
  -----------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa  11/11/2022  Codigo:GAN-MS-M4-0102
  Descripcion : Se soluciono el error de ajax2 al momento eliminar algo recién agregado
  ------------------------------------------------------------------------------
  Modificado: Keyla Paola Usnayo Aguilar    Fecha: 02/12/2022   Codigo :   GAN-MS-M5-0161
  Descripcion : Se modifico el campo de pago de venta a rápida para que acepte decimales
   ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja    Fecha: 19/12/2022   Codigo :   GAN-MS-A7-0185
  Descripcion : Se optimizo el modulo de venta rapida con el calculo automatico del cambio o saldo
     ------------------------------------------------------------------------------
  Modificado: Kevin Gerardo Alcon Lazarte    Fecha: 08/02/2023   Codigo :   GAN-PN-B0-0216
  Descripcion : Se soluciono el error ajax al momento de eliminar todos los productos en la función eliminar
  ------------------------------------------------------------------------------
  Modificado: Oscar Laura Aguirre    Fecha: 10/02/2023   Codigo :   GAN-MS-B0-0213
  Descripcion : Se modifico la funcion ver_imagen para que las imagenes que no tegan un archivo fisico se pueda ver la imagen por defecto
    -------------------------------------------------------------------------------
  Modificado: Ariel Ramos Paucara      Fecha: 29/03/2023     Codigo: GAN-MS-M0-0379
  Descripcion : Se valido los inputs codigo y Nombre donde la cantidad es mayor a 0 y precio mayor a 0
  -------------------------------------------------------------------------------
  Modificado: Ariel Ramos Paucara      Fecha: 10/04/2023     Codigo: GAN-MS-M4-0408
  Descripcion : Se modifico la caja de texto razon social y numero de documento para visualizar alineadamente en pantallas moviles
  */

?>
<?php if (in_array("smod_vent_rap", $permisos)) { ?>
    <style>
        #finalizar_venta .modal-dialog {
            -webkit-transform: translate(0, -50%);
            -o-transform: translate(0, -50%);
            transform: translate(0, -50%);
            top: 50%;
            margin: 0 auto;
        }
    </style>
    <script>
        var cont_pedido = $("#contador").val();
        $(document).ready(function() {
            activarMenu('menu5', 3);
            let username = getCookie("Cliente");
            if (username != null) {
                document.getElementById("nit").value = username;
                valor_nit = document.getElementById("nit").value;
                if (valor_nit != "" && valor_nit != null) {
                    agregar_nombre();
                }
            }
            /* GAN-MS-B5-0448 GValverde */
            $('#btn_add').attr("disabled", false);
            $('#btn_edit').attr("disabled", true);
            var fechahoy = obtener_fecha();
            $.ajax({
                url: "<?php echo site_url('C_inicio/verificar_apertura_caja') ?>/" + fechahoy,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    if (data["oboolean"] == 'f') {
                        document.getElementById('apertura_error').style.display = "block";
                        document.getElementById('apertura_error').innerHTML = "<i class='fa fa-exclamation-circle' style='color:red;'></i>    " +
                            data["omensaje"] +
                            "<a class='btn btn-flat btn-info' href='<?= base_url(); ?>apertura'>apertura de caja</a>";
                        $('#btnFinalizar').attr("disabled", true);
                    } else {
                        document.getElementById('apertura_error').style.display = "none";
                        document.getElementById('apertura_error').innerHTML = "";
                        $('#btnFinalizar').attr("disabled", false);
                    }
                }
            });
            /* FIN GAN-MS-B5-0448 GValverde */

        });
    </script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript">
        ;
        //jQuery.noConflict();
        (function($) {
            $(document).ready(function(e) {
                var baseForm = $("#base_form");
                baseForm.on("keydown", "#id_producto", function(evt) {
                    var charCode = evt.keyCode || e.which;
                    if (charCode == 9 || charCode == 13) {
                        evt.preventDefault();
                        baseForm.submit();
                    }
                });
            });
        }) //(jQuery);
    </script>
    <script>
        function enviar(destino) {
            document.conf_pedido.action = destino;
            console.log(destino);
            document.conf_pedido.submit();
        }
        $('#finalizar_venta').on('hidden.bs.modal', function() {
            window.location.reload(true);
        })
    </script>
    <style>
        hr {
            margin-top: 0px;
        }

        .select2-container .select2-choice>.select2-chosen {
            white-space: normal;
        }

        .novedades i {
            background-color: #ffffff;
            border-color: #ffffff;
            color: #eb0038;
            text-align: center;
            line-height: 50px;

        }

        .formulario {
            display: block;
            width: 80%;
            height: 35px;
            padding: 4.5px 14px;
            font-size: 13px;
            line-height: 1.846153846;
            color: #0c0c0c;
            background-color: #ffffff;
            background-image: none;
            border: 2px solid rgba(12, 12, 12, 0.12);
            border-radius: 2px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            border-color: #eb0038;

        }
    </style>
    <!-- Inicio Ariel Ramos GAN-MS-M4-0408 -->
    <style>
        @media only screen and (max-width: 480px) {
            label.lb_nombre {
                top: 88px;
                position: absolute;
                display: block;
            }

            .caja_texto {
                width: 100% !important;
                display: block;
                margin-top: 10px;
            }
        }
    </style>
    <!-- Fin Ariel Ramos GAN-MS-M4-0408 -->
    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li><a href="#">Venta</a></li>
                    <li class="active">Venta R&aacute;pida</li>
                </ol>
            </div>

            <?php if ($this->session->flashdata('success')) { ?>
                <script>
                    window.onload = function mensaje() {
                        swal(" ", "<?php echo $this->session->flashdata('success'); ?>", "success");
                    }
                </script>
            <?php } else if ($this->session->flashdata('error')) { ?>
                <script>
                    window.onload = function mensaje() {
                        swal(" ", "<?php echo $this->session->flashdata('error'); ?>", "error");
                    }
                </script>
            <?php } ?>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-divider visible-xs"><span>Listado de Registros</span></div>
                        <div class="card card-bordered style-primary">
                            <div class="card-body style-default-bright">
                                <label>CI/NIT/Cod. Cliente
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <label class="lb_nombre">Nombre/Razon Social</label></br>
                                <input type="number" min="0" name="nit" id="nit" class="caja_texto" onkeypress="onkeypress_nit_razonSocial()" style="border:1px solid #c7254e;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input name="razonSocial" id="razonSocial" type="text" class="caja_texto" onkeypress="onkeypress_nit_razonSocial()" style="border:1px solid #c7254e; width: 30%;">
                                </br>
                                </br>
                                <div class="table-responsive">
                                    <table id="datatable3" class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Cód.</th>
                                                <th>Nombre</th>
                                                <th>Cant.</th>
                                                <th>Unidad</th>
                                                <th>Precio Unidad</th>
                                                <th>Precio Total</th>
                                                <th>Acci&oacute;n</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td style="width: 5%">
                                                <form method="post" id="base_form" onsubmit=" return listar(this);">
                                                    <input type="text" class="formulario" size="1" style="width : 150px" maxlength="50" name="id_producto" id="id_producto">
                                                </form>
                                            </td>
                                            <td style="width: 34%">
                                                <form method="post" id="form_nombre" onsubmit=" return listar1(this);">
                                                    <input type="text" class="formulario" size="1" style="width : 550px" maxlength="5000" name="nombre_producto" id="nombre_producto" onkeydown="onkeydown_nombre_producto()">
                                                </form>
                                            </td>
                                            <td style="width: 5%">1</td>
                                            <td style="width: 5%">UNIDAD</td>
                                            <td style="width: 8%"></td>
                                            <td style="width: 8%"></td>
                                            <td style="width: 12%" align="center"></td>
                                        </tr>
                                        <tbody id="con">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" style="text-align: right;">
                                                    <font size=4>Total</font>
                                                </th>
                                                <th style="text-align: right;" size=4>

                                                    <font id="total" size=4></font><?php echo $total ?>
                                                    <input type="hidden" id="total_venta" name="total_venta">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="5" style="text-align: right;">
                                                    <font size=4>Pagado</font>
                                                </th>
                                                <td>
                                                    <form id="miForm" name="miForm" onsubmit="return myFunction(this)">
                                                        <input type="number" name="pagado" id="pagado" step="0.10" style="border:2px solid #c7254e; font-size: 18px;  width: 100%; ">
                                                        </br>
                                                        <div>
                                                            <input type="radio" id="efectivo" name="contact" value="efectivo" title="Al contado" checked>
                                                            <label for="efectivo" title="Al contado"><i style="color: #006400; " class="fa fa-money fa-2x"></i></label>
                                                            <input type="radio" id="tarjeta" name="contact" value="tarjeta" title="Con tarjeta">
                                                            <label for="tarjeta" title="Con tarjeta"><i style="color: #000000; " class="fa fa-credit-card fa-2x"></i></label>
                                                            </br>
                                                            <input type="radio" id="tarQR" name="contact" value="tarQR" title="Con codigoQR">
                                                            <label for="tarQR" title="Con codigoQR"><i style="color: #000000; " class="fa fa-qrcode fa-2x"></i></label>
                                                            <input type="radio" id="deuda" name="contact" value="deuda" title="A deuda">
                                                            <label for="deuda" title="A deuda">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">

                                                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                                                </svg>
                                                            </label>
                                                        </div>
                                                    </form>

                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="5" style="text-align: right;">
                                                    <font id="cam" size=4>Cambio</font>
                                                </th>
                                                <th style="text-align: right;">
                                                    <font id="cambio" name="cambio" size=4></font>
                                                    <input type="hidden" id="cambio_venta" name="cambio_venta">
                                                </th>
                                            </tr>
                                            </tfoot-->
                                    </table>
                                    <div class="modal-footer">
                                        <!-- /* GAN-MS-B5-0448 GValverde */ -->
                                        <div class="alert alert-danger" id="apertura_error" style="text-align: left;display: none;"></div>
                                        <!-- /* FIN GAN-MS-B5-0448 GValverde */ -->
                                        <button type="submit" id="btnFinalizar" class="btn btn-primary " onclick="finalizar();">Finalizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ver Imagen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <output id="verImagen"></output>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal info stock -->
    <div class="modal fade" id="infoStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ver Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Locación</th>
                                <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="tstock">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clear_modal()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal info precios -->
    <div class="modal fade" id="infoPrecio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ver Precios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tprecio">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clear_modal()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="finalizar_venta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:450px;">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h3 class="modal-title">IMPRIMIR RECIBO!!</h3>
                    </center>
                </div>
                <div class="modal-body">
                    <center>
                        <img src="<?= base_url() ?>assets/img/icoLogo/imp.png" width="100px" height="100px" alt="Avatar" class="image"><br><br>
                        <font size="3">Desea recibir un recibo de la compra?</font>
                    </center>
                </div>
                <div class="modal-footer">
                    <center>
                        <form class="form" name="conf_pedido" id="conf_pedido" method="post" target="_blank" action="<?= site_url() ?>generar_venta_cod">

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <output id="idventa"></output>
                                </div>
                                <button type="button" class="btn ink-reaction btn-raised btn-primary" onclick="enviar()">Si</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="finalizar_compra()">Salir</button>
                            </div>
                        </form>
                    </center>
                </div>
            </div>
        </div>
    </div>




    <script>
        //Script movimiento entre inputs con flechas direccionales
        //para habilitar añadir al input objetivo el valor class="move"
        $(document).ready(function() {
            $(document).keydown(
                function(e) {
                    if (e.keyCode == 39) {
                        console.log("39");
                        $(".move:focus").next().focus();
                    }
                    if (e.keyCode == 37) {
                        $(".move:focus").prev().focus();
                        console.log("37");
                    }
                }
            );
        });
        //fin de script 
        function getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function eliminar(id_venta) {
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/dlt_pedido') ?>",
                type: "POST",
                data: {
                    buscar: id_venta
                },
                success: function(respuesta) {
                    if (respuesta) {
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_produc') ?>",
                            type: "POST",
                            success: function(respuesta) {
                                var json = JSON.parse(respuesta);
                                con.innerHTML = '';
                                let total = 0.000;
                                for (var i = 0; i < json.length; i++) {
                                    var codigo_producto = json[i].ocodigo.toString();
                                    var codigo = json[i].ocodigo;
                                    let num = parseFloat(json[i].oprecio);
                                    total = total + num;
                                    var id = json[i].oidventa;
                                    var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                                    var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                                    con.innerHTML = con.innerHTML +
                                        '<tr>' +
                                        '<td>' + codigo_producto + '</td>' +
                                        '<td>' + json[i].onombre + '</td>' +
                                        '<td>' +
                                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                        i + '" id="cantidad' + i + '" value="' + json[i].ocantidad +
                                        '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' +
                                        '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' +
                                        '&nbsp' +
                                        '</td>' +
                                        //Gary Valverde GAN-MS-M5-0034
                                        '<td>' + json[i].unidad + '</td>' +
                                        //fin GAN-MS-M5-0034
                                        '<td>' +
                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                        i + '" id="precio_uni' + i + '" value="' + precio_unidad +
                                        '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i +
                                        ')"' + '" onblur="onkeydown_precio_uni(this,' + id + ',' + i +
                                        ')"' + '&nbsp' +
                                        '</td>' +
                                        '<td>' +
                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                        i + '" id="precio' + i + '" value="' + precio_total +
                                        '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                                        '</td>' +
                                        '<form method="post"  onsubmit="eliminar(' + json[i].oidventa +
                                        ');">' +
                                        '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                        json[i].oidventa + '"></input>' +
                                        '<td style="width: 10%" align="center">' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                        // INICIO Oscar L. GAN-MS-B0-0213
                                        json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                        // FIN GAN-MS-B0-0213
                                        '</button>' +
                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                        json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' +
                                        '</i>' + '</button>' +
                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                        codigo_producto + '\')">' + '<i class="fa fa-eye fa-lg">' +
                                        '</i>' + '</button>' +
                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                        codigo_producto + '\',' + id + ',' + i + ')">' +
                                        '<i class="fa fa-dollar fa-lg">' + '</i>' + '</button>' +
                                        '</td>' +
                                        '</form>' +
                                        '</tr>'
                                }
                                total = total.toFixed(2);
                                $("#total").html(total);
                                $('#total_venta').val(total).trigger('change');
                                if ($("#deuda").is(':checked')) {
                                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                    //Kevin Gerardo Alcon Lazarte GAN-PN-B0-0216
                                    if (json.length != 0) {
                                        cambio_automatico();
                                    } else {
                                        $("#pagado").val("0.00");
                                        $("#cambio").html("0.00");
                                        $("#cambio_venta").val("0.00").trigger('change');
                                        $("#total").html("0.00");
                                    }
                                } else {
                                    $('#pagado').val(total).trigger('change');
                                    if (json.length != 0) {
                                        cambio_automatico();
                                    } else {
                                        $("#pagado").val("0.00");
                                        $("#cambio").html("0.00");
                                        $("#cambio_venta").val("0.00").trigger('change');
                                        $("#total").html("0.00");
                                    }
                                    //fin:GAN-PN-B0-0216    
                                }
                                //$('#cambio_venta').val("").trigger('change');
                                //$("#cambio").html("");
                                const inpPassword = document.getElementById('id_producto');
                                inpPassword.focus();
                                var m_codigo = [];
                                $.ajax({
                                    url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_codigo') ?>",
                                    type: "POST",
                                    success: function(respuesta) {
                                        var json = JSON.parse(respuesta);
                                        m_codigo = Object.values(json);
                                        const items = m_codigo.map(function(m_codigo) {
                                            return m_codigo.codigo;
                                        });
                                        $("#id_producto").autocomplete({
                                            source: items
                                        });
                                    }
                                });
                                var m_producto = [];
                                $.ajax({
                                    url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_producto') ?>",
                                    type: "POST",
                                    success: function(respuesta) {
                                        var json = JSON.parse(respuesta);
                                        m_producto = Object.values(json);
                                        const items = m_producto.map(function(m_producto) {
                                            return m_producto.descripcion;
                                        });
                                        $("#nombre_producto").autocomplete({
                                            source: items
                                        });
                                    }
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax');
                            }
                        });
                    } else {
                        alert(respuesta.omensaje);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }
    </script>
    <script>
        function enviar() {
            document.getElementById("conf_pedido").submit();
            document.cookie = "Cliente = ;";
            window.location.reload();
        }

        function finalizar_compra() {
            document.cookie = "Cliente = ;";
            window.location.reload();
        }
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--js para la funccion final-->
    <script>
        function finalizar() {
            razonSocial = document.getElementById("razonSocial").value.trim();
            valor_nit = document.getElementById("nit").value;
            dato = document.getElementById("pagado").value;
            total = document.getElementById("total_venta").value;
            cambio = document.getElementById("cambio_venta").value;
            var tipo = "";
            var id_tipo;
            var total2;
            if ($("#efectivo").is(':checked')) {
                tipo = "Contado";
            } else if ($("#tarjeta").is(':checked')) {
                tipo = "Tarjeta";
            } else if ($("#tarQR").is(':checked')) {
                tipo = "QR";
            } else {
                tipo = "A Deuda";
            }
            if (tipo == "Tarjeta" || tipo == "Contado" || tipo == "QR") {
                total2 = parseFloat(dato, 10) - parseFloat(cambio, 10);
            } else {
                total2 = parseFloat(dato, 10) + parseFloat(cambio, 10);
            }
            total2 = total2.toFixed(2);
            console.log(total2 + "-" + total);
            if (total2 != total) {
                Swal.fire({
                    icon: 'error',
                    title: 'Sucedio un error',
                    text: 'Se realizó un cambio inesperado en el monto pagado. Vuelva a realizar el cálculo, por favor',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ACEPTAR'
                });
            } else {
                if (tipo == "A Deuda" && ((valor_nit == "" || valor_nit == null || valor_nit == " ") || (razonSocial == "" ||
                        razonSocial == null || razonSocial == " "))) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sucedio un error',
                        text: 'No se puede finalizar sin CI/NIT/Cod. Cliente o Nombre/Razon Social',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'ACEPTAR'
                    });
                } else {
                    if ((valor_nit !== "" && razonSocial === "")) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Sucedio un error',
                            text: 'Los datos del cliente deben estar completos o vacios',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        });
                    } else {
                        var newMessage = "";
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/verifica_cliente') ?>",
                            type: "POST",
                            data: {
                                valor_nit: valor_nit
                            },
                            success: function(result) {
                                var r = JSON.parse(result);
                                r = r[0]["fn_verifica_cliente"];
                                if ((r == "f") && (razonSocial !== "")) {
                                    $.ajax({
                                        url: "<?php echo site_url('venta/C_pedidoCodigo/registrar') ?>",
                                        type: "POST",
                                        data: {
                                            valor_nit: valor_nit,
                                            razonSocial: razonSocial
                                        },
                                        success: function(reg) {
                                            var res = JSON.parse(reg);
                                            if (res[0]["oboolean"] == "f") {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: res[0]["omensaje"],
                                                    confirmButtonColor: '#d33',
                                                    confirmButtonText: 'ACEPTAR'
                                                })
                                            } else {
                                                valor_nit = res[0]["oci"];
                                                $('#nit').val(valor_nit);
                                                if (valor_nit !== "") {
                                                    newMessage =
                                                        ", SE REGISTRO EL CLIENTE SATISFACTORIAMENTE"
                                                }
                                                $.ajax({
                                                    url: "<?php echo site_url('venta/C_pedidoCodigo/lst_tipo_venta') ?>",
                                                    type: "POST",
                                                    success: function(resp) {
                                                        var c = JSON.parse(resp);

                                                        if ($("#efectivo").is(':checked')) {
                                                            tipo = "Contado";
                                                        } else if ($("#tarjeta").is(
                                                                ':checked')) {
                                                            tipo = "Tarjeta";
                                                        } else if ($("#tarQR").is(
                                                                ':checked')) {
                                                            tipo = "QR";
                                                        } else {
                                                            tipo = "A Deuda";
                                                        }
                                                        for (var i = 0; i < c.length; i++) {
                                                            if (c[i].otipo == tipo) {
                                                                id_tipo = c[i].oidtipo;
                                                            }
                                                        }
                                                        if (dato != null && dato >= 0 &&
                                                            dato != "" && total >= 0 &&
                                                            total != null && total != "" &&
                                                            cambio >= 0 && cambio != null &&
                                                            cambio != "") {
                                                            console.log(tipo);
                                                            $.ajax({
                                                                url: "<?php echo site_url('venta/C_pedidoCodigo/relizar_cobro') ?>",
                                                                type: "POST",
                                                                data: {
                                                                    valor_nit: valor_nit,
                                                                    tipo: id_tipo
                                                                },
                                                                success: function(
                                                                    resp) {
                                                                    var c = JSON
                                                                        .parse(
                                                                            resp
                                                                        );
                                                                    console.log(
                                                                        c);
                                                                    $.each(c,
                                                                        function(
                                                                            i,
                                                                            item
                                                                        ) {
                                                                            if (item
                                                                                .oestado ==
                                                                                't'
                                                                            ) {
                                                                                Swal.fire({
                                                                                        icon: 'success',
                                                                                        title: 'PEDIDO REALIZADO' +
                                                                                            newMessage,
                                                                                        text: 'IMPRIMIR RECIBO',
                                                                                        showCancelButton: true,
                                                                                        confirmButtonColor: '#3085d6',
                                                                                        cancelButtonColor: '#d33',
                                                                                        confirmButtonText: 'ACEPTAR'
                                                                                    })
                                                                                    .then(
                                                                                        (
                                                                                            result
                                                                                        ) => {
                                                                                            if (result
                                                                                                .isConfirmed
                                                                                            ) {
                                                                                                jQuery
                                                                                                    .noConflict();
                                                                                                dato =
                                                                                                    '<input type="hidden" name="id_venta" value="' +
                                                                                                    item
                                                                                                    .idventa +
                                                                                                    '"><input type="hidden" name="pagado" value="' +
                                                                                                    dato +
                                                                                                    '">';
                                                                                                document
                                                                                                    .getElementById(
                                                                                                        "idventa"
                                                                                                    )
                                                                                                    .innerHTML =
                                                                                                    dato;
                                                                                                document
                                                                                                    .getElementById(
                                                                                                        "conf_pedido"
                                                                                                    )
                                                                                                    .submit();
                                                                                                document
                                                                                                    .cookie =
                                                                                                    "Cliente = ;";
                                                                                                window
                                                                                                    .location
                                                                                                    .reload();
                                                                                                //$('#finalizar_venta').modal('show');
                                                                                            } else {
                                                                                                document
                                                                                                    .cookie =
                                                                                                    "Cliente = ;";
                                                                                                window
                                                                                                    .location
                                                                                                    .reload();
                                                                                            }
                                                                                        }
                                                                                    )

                                                                            } else {
                                                                                Swal.fire({
                                                                                    icon: 'error',
                                                                                    title: 'Oops...',
                                                                                    text: item
                                                                                        .omensaje,
                                                                                    confirmButtonColor: '#d33',
                                                                                    confirmButtonText: 'ACEPTAR'
                                                                                })
                                                                            }
                                                                        });
                                                                },
                                                                error: function(
                                                                    jqXHR,
                                                                    textStatus,
                                                                    errorThrown
                                                                ) {
                                                                    alert(
                                                                        'Error al obtener datos de ajax'
                                                                    );
                                                                }
                                                            });
                                                        } else {
                                                            if (total == 0) {
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Sucedio un error',
                                                                    text: 'Agrege al menos un producto para realizar la venta',
                                                                    confirmButtonColor: '#d33',
                                                                    confirmButtonText: 'ACEPTAR'
                                                                });
                                                            } else if (dato < 0) {
                                                                $('#pagado').val("")
                                                                    .trigger('change');
                                                                $('#cambio_venta').val("")
                                                                    .trigger('change');
                                                                $("#cambio").html("");
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Sucedio un error',
                                                                    text: 'El pago no puede tener valor negativo',
                                                                    confirmButtonColor: '#d33',
                                                                    confirmButtonText: 'ACEPTAR'
                                                                });
                                                            } else {
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Sucedio un error',
                                                                    text: 'Agrege un monto pago para su venta',
                                                                    confirmButtonColor: '#d33',
                                                                    confirmButtonText: 'ACEPTAR'
                                                                });
                                                            }

                                                        }

                                                    },
                                                    error: function(jqXHR, textStatus,
                                                        errorThrown) {
                                                        alert(
                                                            'Error al obtener datos de ajax'
                                                        );
                                                    }
                                                });
                                            }

                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            alert('Error al obtener datos de ajax');
                                        }
                                    });
                                } else {
                                    $.ajax({
                                        url: "<?php echo site_url('venta/C_pedidoCodigo/lst_tipo_venta') ?>",
                                        type: "POST",
                                        success: function(resp) {
                                            var c = JSON.parse(resp);

                                            if ($("#efectivo").is(':checked')) {
                                                tipo = "Contado";
                                            } else if ($("#tarjeta").is(':checked')) {
                                                tipo = "Tarjeta";
                                            } else if ($("#tarQR").is(':checked')) {
                                                tipo = "QR";
                                            } else {
                                                tipo = "A Deuda";
                                            }
                                            for (var i = 0; i < c.length; i++) {
                                                if (c[i].otipo == tipo) {
                                                    id_tipo = c[i].oidtipo;
                                                }
                                            }
                                            if (dato != null && dato >= 0 && dato != "" && total >= 0 &&
                                                total != null && total != "" && cambio >= 0 && cambio !=
                                                null && cambio != "") {
                                                console.log(tipo);
                                                $.ajax({
                                                    url: "<?php echo site_url('venta/C_pedidoCodigo/relizar_cobro') ?>",
                                                    type: "POST",
                                                    data: {
                                                        valor_nit: valor_nit,
                                                        tipo: id_tipo
                                                    },
                                                    success: function(resp) {
                                                        var c = JSON.parse(resp);
                                                        $.each(c, function(i, item) {
                                                            if (item.oestado ==
                                                                't') {
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'PEDIDO REALIZADO',
                                                                    text: 'IMPRIMIR RECIBO',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#3085d6',
                                                                    cancelButtonColor: '#d33',
                                                                    confirmButtonText: 'ACEPTAR'
                                                                }).then((
                                                                    result
                                                                ) => {
                                                                    if (result
                                                                        .isConfirmed
                                                                    ) {
                                                                        jQuery
                                                                            .noConflict();
                                                                        dato =
                                                                            '<input type="hidden" name="id_venta" value="' +
                                                                            item
                                                                            .idventa +
                                                                            '"><input type="hidden" name="pagado" value="' +
                                                                            dato +
                                                                            '">';
                                                                        document
                                                                            .getElementById(
                                                                                "idventa"
                                                                            )
                                                                            .innerHTML =
                                                                            dato;
                                                                        document
                                                                            .getElementById(
                                                                                "conf_pedido"
                                                                            )
                                                                            .submit();
                                                                        document
                                                                            .cookie =
                                                                            "Cliente = ;";
                                                                        window
                                                                            .location
                                                                            .reload();
                                                                        //$('#finalizar_venta').modal('show');
                                                                    } else {
                                                                        document
                                                                            .cookie =
                                                                            "Cliente = ;";
                                                                        window
                                                                            .location
                                                                            .reload();
                                                                    }
                                                                })
                                                            } else {
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Oops...',
                                                                    text: item
                                                                        .omensaje,
                                                                    confirmButtonColor: '#d33',
                                                                    confirmButtonText: 'ACEPTAR'
                                                                })
                                                            }
                                                        });
                                                    },
                                                    error: function(jqXHR, textStatus,
                                                        errorThrown) {
                                                        alert(
                                                            'Error al obtener datos de ajax'
                                                        );
                                                    }
                                                });
                                            } else {
                                                if (total == 0) {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Sucedio un error',
                                                        text: 'Agrege al menos un producto para realizar la venta',
                                                        confirmButtonColor: '#d33',
                                                        confirmButtonText: 'ACEPTAR'
                                                    });
                                                } else if (dato < 0) {
                                                    $('#pagado').val("").trigger('change');
                                                    $('#cambio_venta').val("").trigger('change');
                                                    $("#cambio").html("");
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Sucedio un error',
                                                        text: 'El pago no puede tener valor negativo',
                                                        confirmButtonColor: '#d33',
                                                        confirmButtonText: 'ACEPTAR'
                                                    });
                                                } else {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Sucedio un error',
                                                        text: 'Agrege un monto pago para su venta',
                                                        confirmButtonColor: '#d33',
                                                        confirmButtonText: 'ACEPTAR'
                                                    });
                                                }

                                            }

                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            alert('Error al obtener datos de ajax');
                                        }
                                    });
                                }

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax');
                            }
                        });
                    }

                }
            }

            var tipo;
            if ($("#deuda").is(':checked')) {
                tipo = 0;
            } else {
                tipo = 1;
            }



        }
    </script>
    <script>
        const inpPassword = document.getElementById('id_producto');
        setTimeout(() => {
            inpPassword.focus();
        }, 300);
    </script>
    <!--js para buscar el ci de un cliente-->
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-1.12.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/jquery-ui.css">
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var nombres = [];
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_nit') ?>",
                type: "POST",
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    nombres = Object.values(json);
                    const items = nombres.map(function(nombres) {
                        return nombres.nit_ci;
                    });
                    $("#nit").autocomplete({
                        source: items,
                        select: function(event, item) {
                            $.ajax({
                                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_nombre') ?>",
                                type: "POST",
                                data: {
                                    buscar: item.item.value
                                },
                                success: function(resp) {
                                    var c = JSON.parse(resp);
                                    $.each(c, function(i, item) {
                                        $("#razonSocial").val(item
                                            .fn_recuperar_cliente);
                                    });
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    alert('Error al obtener datos de ajax');
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var nit = [];
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_lts_nombre') ?>",
                type: "POST",
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    nit = Object.values(json);
                    const items = nit.map(function(nit) {
                        return nit.cliente + "-" + nit.ci;
                    });
                    $("#razonSocial").autocomplete({
                        source: items,
                        select: function(event, item) {
                            $.ajax({
                                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_nit_usuario') ?>",
                                type: "POST",
                                data: {
                                    buscar: item.item.value
                                },
                                success: function(resp) {
                                    $("#nit").val(resp);
                                    var nom = "";
                                    for (var i = 0; i < item.item.value
                                        .length; i++) {
                                        if (item.item.value.charAt(i) == "-") {
                                            break;
                                        } else {
                                            nom = nom + item.item.value.charAt(i);
                                        }
                                    }
                                    $("#razonSocial").val(nom);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    alert('Error al obtener datos de ajax');
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        function agregar_nombre() {
            valor_nit = document.getElementById("nit").value;
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_nombre') ?>",
                type: "POST",
                data: {
                    buscar: valor_nit
                },
                success: function(resp) {
                    var c = JSON.parse(resp);
                    $.each(c, function(i, item) {
                        $("#razonSocial").val(item.fn_recuperar_cliente);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        }
    </script>

    <!--js para buscar codigo-->
    <script type="text/javascript">
        $(document).ready(function() {
            var codigo = [];
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_codigo') ?>",
                type: "POST",
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    codigo = Object.values(json);
                    const items = codigo.map(function(codigo) {
                        return codigo.codigo;
                    });
                    $("#id_producto").autocomplete({
                        source: items
                    });
                }
            });
        });
    </script>
    <!--js para modificar el pago-->
    <script>
        function cambio_automatico() {
            pago = parseFloat(document.getElementById("pagado").value);
            total = parseFloat(document.getElementById("total_venta").value);
            var tipo = "";
            var id_tipo;
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/lst_tipo_venta') ?>",
                type: "POST",
                success: function(resp) {
                    var c = JSON.parse(resp);
                    console.log('entrada a l json de cambio automatico')
                    console.log(c);
                    if ($("#efectivo").is(':checked')) {
                        tipo = "Contado";
                    } else if ($("#tarjeta").is(':checked')) {
                        tipo = "Tarjeta";
                    } else if ($("#tarQR").is(':checked')) {
                        tipo = "QR";
                    } else {
                        tipo = "A Deuda";
                    }
                    for (var i = 0; i < c.length; i++) {
                        if (c[i].otipo == tipo) {
                            id_tipo = c[i].oidtipo;
                        }
                    }
                    if (pago < total && $("#deuda").is(':checked')) {
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/calcular_cambio') ?>",
                            type: "POST",
                            data: {
                                pagado: pago,
                                id_tipo: id_tipo
                            },
                            success: function(resp) {
                                var c = JSON.parse(resp);
                                $.each(c, function(i, item) {
                                    let omonto = (parseFloat(item.omonto)).toFixed(2);
                                    let ocambio_saldo = (parseFloat(item.ocambio_saldo))
                                        .toFixed(2);
                                    let ototal = (parseFloat(item.ototal)).toFixed(2);
                                    $("#pagado").val(omonto);
                                    $("#cambio").html(ocambio_saldo);
                                    $('#cambio_venta').val(ocambio_saldo).trigger('change');
                                    $("#total").html(ototal);
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax');
                            }
                        });
                    } else if (pago >= total && $("#deuda").is(':checked')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debe ingresar un valor menor al total',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        })
                    } else if (pago >= total && ($("#efectivo").is(':checked') || $("#tarjeta").is(':checked')) ||
                        $("#tarQR").is(':checked') && total != 0) {
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/calcular_cambio') ?>",
                            type: "POST",
                            data: {
                                pagado: pago,
                                id_tipo: id_tipo
                            },
                            success: function(resp) {
                                var c = JSON.parse(resp);
                                $.each(c, function(i, item) {
                                    let omonto = (parseFloat(item.omonto)).toFixed(2);
                                    let ocambio_saldo = (parseFloat(item.ocambio_saldo))
                                        .toFixed(2);
                                    let ototal = (parseFloat(item.ototal)).toFixed(2);
                                    $("#pagado").val(omonto);
                                    $("#cambio").html(ocambio_saldo);
                                    $('#cambio_venta').val(ocambio_saldo).trigger('change');
                                    $("#total").html(ototal);
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax');
                            }
                        });
                    } else if (total == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debe ingresar un producto para continuar con la venta',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debe ingresar un valor mayor ó igual al total',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        })
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });

            return false;
        }

        function myFunction(form) {
            pago = parseFloat(form.pagado.value);
            total = parseFloat(document.getElementById("total_venta").value);
            var tipo = "";
            var id_tipo;
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/lst_tipo_venta') ?>",
                type: "POST",
                success: function(resp) {
                    var c = JSON.parse(resp);

                    if ($("#efectivo").is(':checked')) {
                        tipo = "Contado";
                    } else if ($("#tarjeta").is(':checked')) {
                        tipo = "Tarjeta";
                    } else if ($("#tarQR").is(':checked')) {
                        tipo = "QR";
                    } else {
                        tipo = "A Deuda";
                    }
                    for (var i = 0; i < c.length; i++) {
                        if (c[i].otipo == tipo) {
                            id_tipo = c[i].oidtipo;
                        }
                    }
                    if (pago < total && $("#deuda").is(':checked')) {
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/calcular_cambio') ?>",
                            type: "POST",
                            data: {
                                pagado: pago,
                                id_tipo: id_tipo
                            },
                            success: function(resp) {
                                var c = JSON.parse(resp);
                                $.each(c, function(i, item) {
                                    let omonto = (parseFloat(item.omonto)).toFixed(2);
                                    let ocambio_saldo = (parseFloat(item.ocambio_saldo))
                                        .toFixed(2);
                                    let ototal = (parseFloat(item.ototal)).toFixed(2);
                                    $("#pagado").val(omonto);
                                    $("#cambio").html(ocambio_saldo);
                                    $('#cambio_venta').val(ocambio_saldo).trigger('change');
                                    $("#total").html(ototal);
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax');
                            }
                        });
                    } else if (pago >= total && $("#deuda").is(':checked')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debe ingresar un valor menor al total',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        })
                    } else if (pago >= total && ($("#efectivo").is(':checked') || $("#tarjeta").is(':checked')) ||
                        $("#tarQR").is(':checked') && total != 0) {
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/calcular_cambio') ?>",
                            type: "POST",
                            data: {
                                pagado: pago,
                                id_tipo: id_tipo
                            },
                            success: function(resp) {
                                var c = JSON.parse(resp);
                                $.each(c, function(i, item) {
                                    let omonto = (parseFloat(item.omonto)).toFixed(2);
                                    let ocambio_saldo = (parseFloat(item.ocambio_saldo))
                                        .toFixed(2);
                                    let ototal = (parseFloat(item.ototal)).toFixed(2);
                                    $("#pagado").val(omonto);
                                    $("#cambio").html(ocambio_saldo);
                                    $('#cambio_venta').val(ocambio_saldo).trigger('change');
                                    $("#total").html(ototal);
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax');
                            }
                        });
                    } else if (total == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debe ingresar un producto para continuar con la venta',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debe ingresar un valor mayor ó igual al total',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        })
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });

            return false;
        }
    </script>

    <!--js para buscar nombre de un producto-->
    <script type="text/javascript">
        $(document).ready(function() {
            var nombre = [];
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_producto') ?>",
                type: "POST",
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    codigo = Object.values(json);
                    const items = codigo.map(function(codigo) {
                        return codigo.descripcion;
                    });
                    $("#nombre_producto").autocomplete({
                        source: items
                    });
                }
            });
        });
    </script>

    <!--js validar-->
    <script type="text/javascript">
        document.getElementById("deuda").onclick = function() {
            validar()
        };

        function validar() {
            valor = document.getElementById("razonSocial").value;
            valor1 = document.getElementById("nit").value;
            if (valor == null || valor.length == 0 || valor1 == null || valor1.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Debes ingresar un cliente',
                    text: item.omensaje,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'ACEPTAR'
                });
            }
        }
    </script>

    <!--Para mostrar la tabla-->
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_produc') ?>",
                type: "POST",
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    con.innerHTML = '';
                    let total = 0.000;
                    for (var i = 0; i < json.length; i++) {
                        const codigo_producto = json[i].ocodigo.toString();
                        let num = parseFloat(json[i].oprecio);
                        total = total + num;
                        var id = json[i].oidventa;
                        var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                        var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                        con.innerHTML = con.innerHTML +
                            '<tr>' +
                            '<td>' + codigo_producto + '</td>' +
                            '<td>' + json[i].onombre + '</td>' +
                            '<td>' +
                            '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                            i + '" id="cantidad' + i + '" value="' + json[i].ocantidad +
                            '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' +
                            '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                            '</td>' +
                            //Gary Valverde GAN-MS-M5-0034
                            '<td>' + json[i].unidad + '</td>' +
                            //fin GAN-MS-M5-0034
                            '<td>' +
                            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                            i + '" id="precio_uni' + i + '" value="' + precio_unidad +
                            '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' +
                            '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                            '</td>' +
                            '<td>' +
                            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                            i + '" id="precio' + i + '" value="' + precio_total +
                            '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                            '</td>' +
                            '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                            '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa +
                            '"></input>' +
                            '<td style="width: 10%" align="center">' +
                            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                            // INICIO Oscar L. GAN-MS-B0-0213
                            json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                            // FIN GAN-MS-B0-0213
                            '</button>' +
                            '<label>&nbsp;&nbsp;&nbsp;</label>' +
                            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                            json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' +
                            '</button>' +
                            '<label>&nbsp;&nbsp;&nbsp;</label>' +
                            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                            codigo_producto + '\')">' + '<i class="fa fa-eye fa-lg">' + '</i>' +
                            '</button>' +
                            '<label>&nbsp;&nbsp;&nbsp;</label>' +
                            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                            codigo_producto + '\',' + id + ',' + i + ')">' +
                            '<i class="fa fa-dollar fa-lg">' + '</i>' +
                            '</button>' +
                            '</td>' +
                            '</form>' +
                            '</tr>'
                    }
                    total = total.toFixed(2);

                    $("#total").html(total);
                    $('#total_venta').val(total).trigger('change');
                    $('#pagado').val("").trigger('change');
                    $('#cambio_venta').val("").trigger('change');
                    $("#cambio").html("");
                    const inpPassword = document.getElementById('id_producto');
                    inpPassword.focus();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax');
                }
            });
        });
    </script>

    <!--js listar-->
    <script type="text/javascript">
        function listar() {
            let con = document.getElementById('con');
            let codigo = document.getElementById("id_producto").value;
            // INICIO Ariel R. GAN-MS-M0-0379
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('venta/C_pedidoCodigo/get_codigo') ?>",
                data: {
                    code: codigo
                },
                success: function(res) {
                    var data = JSON.parse(res);
                    console.log(data);
                    if (data !== null && data.ocantidad > '0' && data.oprecio > '0') {
                        var codigoo = data.ocodigo;
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/datos_producto') ?>",
                            type: "POST",
                            data: {
                                buscar: codigoo
                            },
                            success: function(respuesta) {
                                var json = JSON.parse(respuesta);
                                con.innerHTML = '';
                                let total = 0.000;
                                for (var i = 0; i < json.length; i++) {
                                    // wilson Huanca GAN-MS-B1-0186
                                    try {
                                        var codigo_producto = json[i].ocodigo;
                                    } catch (e) {
                                        console.error(`Error en el json ToString ${e}`);
                                    }
                                    //fin GAN-MS-B1-0186
                                    let num = parseFloat(json[i].oprecio);
                                    total = total + num;
                                    var id = json[i].oidventa;
                                    var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                                    var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                                    con.innerHTML = con.innerHTML +
                                        '<tr>' +
                                        '<td>' + codigo_producto + '</td>' +
                                        '<td>' + json[i].onombre + '</td>' +
                                        '<td>' +
                                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                        i + '" id="cantidad' + i + '" value="' + json[i].ocantidad +
                                        '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' +
                                        '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                                        '</td>' +
                                        //Gary Valverde GAN-MS-M5-0034
                                        '<td>' + json[i].unidad + '</td>' +
                                        //fin GAN-MS-M5-0034
                                        '<td>' +
                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                        i + '" id="precio_uni' + i + '" value="' + precio_unidad +
                                        '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' +
                                        '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                                        '</td>' +
                                        '<td>' +
                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                        i + '" id="precio' + i + '" value="' + precio_total +
                                        '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                                        '</td>' +
                                        '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                                        '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa +
                                        '"></input>' +
                                        '<td style="width: 10%" align="center">' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                        // INICIO Oscar L. GAN-MS-B0-0213
                                        json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                        // FIN GAN-MS-B0-0213
                                        '</button>' +
                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                        json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                        codigo_producto + '\')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                        codigo_producto + '\',' + id + ',' + i + ')">' +
                                        '<i class="fa fa-dollar fa-lg">' +
                                        '</i>' + '</button>' +
                                        '</td>' +
                                        '</form>' +
                                        '</tr>'
                                }
                                total = total.toFixed(2);
                                //console.log(total)
                                $("#total").html(total);
                                document.getElementById("base_form").reset();
                                $('#total_venta').val(total).trigger('change');
                                if ($("#deuda").is(':checked')) {
                                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                    cambio_automatico();
                                } else {
                                    $('#pagado').val(total).trigger('change');
                                    cambio_automatico();
                                }

                                //cambie 
                                // $('#cambio_venta').val("").trigger('change');
                                // $("#cambio").html("")
                                document.getElementById("cantidad0").select();
                                var m_codigo = [];
                                $.ajax({
                                    url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_codigo') ?>",
                                    type: "POST",
                                    success: function(respuesta) {
                                        var json = JSON.parse(respuesta);
                                        m_codigo = Object.values(json);
                                        const items = m_codigo.map(function(m_codigo) {
                                            return m_codigo.codigo;
                                        });
                                        $("#id_producto").autocomplete({
                                            source: items
                                        });
                                    }
                                });
                                var m_producto = [];
                                $.ajax({
                                    url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_producto') ?>",
                                    type: "POST",
                                    success: function(respuesta) {
                                        var json = JSON.parse(respuesta);
                                        m_producto = Object.values(json);
                                        const items = m_producto.map(function(m_producto) {
                                            return m_producto.descripcion;
                                        });
                                        $("#nombre_producto").autocomplete({
                                            source: items
                                        });
                                    }
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Sucedio un error con el producto seleccionado',
                                    text: 'por favor revise inventarios y abastecimiento',
                                    confirmButtonColor: '#d33',
                                    confirmButtonText: 'ACEPTAR'
                                });
                                document.getElementById("base_form").reset();
                            }
                        });
                        return false;
                    } else if (data !== null && (data.ocantidad == 0 || data.oprecio == 0)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'El producto: ' + data.odescripcion + ' no está disponible',
                            text: 'por favor revise la cantidad en stock y el precio del producto',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        });
                    } else {
                        if (data === null) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ingrese un Codigo Valido.',
                                text: 'por favor revise el codigo ingresado',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'ACEPTAR'
                            });
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Ha ocurrido un error");
                }
            });
            return false;
            // FIN Ariel R. GAN-MS-M0-0379
        }
    </script>

    <!--js listar nombre-->
    <script type="text/javascript">
        function listar1() {

            let con = document.getElementById('con');
            var codigo = document.getElementById("nombre_producto").value;
            codigo = codigo.split('//');
            codigo =  codigo[0];
            // INICIO Ariel R. GAN-MS-M0-0379
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('venta/C_pedidoCodigo/get_descripcion') ?>",
                data: {
                    code: codigo
                },
                success: function(res) {
                    var data = JSON.parse(res);
                    if (data !== null && data.ocantidad > '0' && data.oprecio > '0') {
                        var codigoo = data.odescripcion;
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/datos_nombre') ?>",
                            type: "POST",
                            data: {
                                buscar: codigoo
                            },
                            success: function(respuesta) {
                                var json = JSON.parse(respuesta);
                                //console.log("JSON datos nombre");
                                //console.log(json);
                                con.innerHTML = '';
                                let total = 0.000;
                                for (var i = 0; i < json.length; i++) {
                                    //wilson Huanca GAN-MS-B1-0187
                                    try {

                                        var codigo_producto = json[i].ocodigo;
                                    } catch (e) {
                                        console.error(`Error en el json ToString ${e}`);
                                    }
                                    //fin GAN-MS-B1-0187
                                    let num = parseFloat(json[i].oprecio);
                                    total = total + num;
                                    var id = json[i].oidventa;
                                    var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                                    var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                                    con.innerHTML = con.innerHTML +
                                        '<tr>' +
                                        '<td>' + codigo_producto + '</td>' +
                                        '<td>' + json[i].onombre + '</td>' +
                                        '<td>' +
                                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                        i + '" id="cantidad' + i + '" value="' + json[i].ocantidad +
                                        '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' +
                                        '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                                        '</td>' +
                                        //Gary Valverde GAN-MS-M5-0034
                                        '<td>' + json[i].unidad + '</td>' +
                                        //fin GAN-MS-M5-0034
                                        '<td>' +
                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                        i + '" id="precio_uni' + i + '" value="' + precio_unidad +
                                        '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' +
                                        '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                                        '</td>' +
                                        '<td>' +
                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                        i + '" id="precio' + i + '" value="' + precio_total +
                                        '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                                        '</td>' +
                                        '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                                        '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa +
                                        '"></input>' +
                                        '<td style="width: 10%" align="center">' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                        // INICIO Oscar L. GAN-MS-B0-0213
                                        json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                        // FIN GAN-MS-B0-0213
                                        '</button>' +
                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                        json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                        codigo_producto + '\')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                        codigo_producto + '\',' + id + ',' + i + ')">' +
                                        '<i class="fa fa-dollar fa-lg">' +
                                        '</i>' + '</button>' +
                                        '</td>' +
                                        '</form>' +
                                        '</tr>'
                                }
                                total = total.toFixed(2);
                                $("#total").html(total);
                                document.getElementById("form_nombre").reset();
                                $('#total_venta').val(total).trigger('change');
                                if ($("#deuda").is(':checked')) {
                                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                    cambio_automatico();
                                } else {
                                    $('#pagado').val(total).trigger('change');
                                    cambio_automatico();
                                }
                                //$('#cambio_venta').val("").trigger('change');
                                //$("#cambio").html("");
                                document.getElementById("cantidad0").select();
                                var m_producto = [];
                                $.ajax({
                                    url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_producto') ?>",
                                    type: "POST",
                                    success: function(respuesta) {
                                        var json = JSON.parse(respuesta);
                                        m_producto = Object.values(json);
                                        const items = m_producto.map(function(m_producto) {
                                            return m_producto.descripcion;
                                        });
                                        $("#nombre_producto").autocomplete({
                                            source: items
                                        });
                                    }
                                });
                                var m_codigo = [];
                                $.ajax({
                                    url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_codigo') ?>",
                                    type: "POST",
                                    success: function(respuesta) {
                                        var json = JSON.parse(respuesta);
                                        m_codigo = Object.values(json);
                                        const items = m_codigo.map(function(m_codigo) {
                                            return m_codigo.codigo;
                                        });
                                        $("#id_producto").autocomplete({
                                            source: items
                                        });
                                    }
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Sucedio un error con el producto seleccionado',
                                    text: 'por favor revise inventarios y abastecimiento',
                                    confirmButtonColor: '#d33',
                                    confirmButtonText: 'ACEPTAR'
                                });
                                document.getElementById("form_nombre").reset();
                            }
                        });
                        return false;
                    } else if (data !== null && (data.ocantidad == 0 || data.oprecio == 0)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'El producto: ' + data.odescripcion + ' no está disponible',
                            text: 'por favor revise la cantidad en stock y el precio del producto',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        });
                    } else {
                        if (data === null) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ingrese un Nombre Valido.',
                                text: 'por favor revise el nombre ingresado',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'ACEPTAR'
                            });
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Ha ocurrido un error");
                }
            });
            return false;
            // FIN Ariel R. GAN-MS-M0-0379 
        }
    </script>

    <script>
        function onkeydown_precio_uni(msg, idventa, dato) {
            var e = event || evt;
            var charCode = e.which || e.keyCode;
            if (charCode == 9 || charCode == 13 || charCode == null) {
                $.ajax({
                    url: "<?php echo site_url('venta/C_pedidoCodigo/verificar_cambio_precio') ?>",
                    type: "POST",
                    data: {
                        dato1: idventa,
                        dato2: msg.value
                    },
                    success: function(respuesta) {
                        var js = JSON.parse(respuesta);
                        $.each(js, function(i, item) {
                            if (item.oboolean == 'f') {
                                Swal.fire({
                                    icon: 'warning',
                                    text: item.omensaje,
                                    title: "¿Desea Continuar con el Cambio de Precio?",
                                    showDenyButton: true,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                    denyButtonText: 'CANCELAR',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            url: "<?php echo site_url('venta/C_pedidoCodigo/cambio_precio_uni') ?>",
                                            type: "POST",
                                            data: {
                                                dato3: idventa,
                                                dato4: msg.value
                                            },
                                            success: function(respuesta) {
                                                var json = JSON.parse(respuesta);
                                                con.innerHTML = '';
                                                let total = 0.000;
                                                for (var i = 0; i < json.length; i++) {
                                                    var codigo_producto = json[i]
                                                        .ocodigo.toString();
                                                    let num = parseFloat(json[i]
                                                        .oprecio);
                                                    total = total + num;
                                                    var id = json[i].oidventa;
                                                    var precio_total = (parseFloat(json[
                                                        i].oprecio)).toFixed(2);
                                                    var precio_unidad = (parseFloat(
                                                            json[i].oprecio_uni))
                                                        .toFixed(2);
                                                    con.innerHTML = con.innerHTML +
                                                        '<tr>' +
                                                        '<td>' + codigo_producto +
                                                        '</td>' +
                                                        '<td>' + json[i].onombre +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                        i + '" id="cantidad' + i +
                                                        '" value="' + json[i]
                                                        .ocantidad +
                                                        '" onkeydown="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        //Gary Valverde GAN-MS-M5-0034
                                                        '<td>' + json[i].unidad +
                                                        '</td>' +
                                                        //fin GAN-MS-M5-00342
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                        i + '" id="precio_uni' + i +
                                                        '" value="' + precio_unidad +
                                                        '" onkeydown="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                        i + '" id="precio' + i +
                                                        '" value="' + precio_total +
                                                        '" onkeydown="onkeydown_cant(this,' +
                                                        id + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<form method="post"  onsubmit="eliminar(' +
                                                        json[i].oidventa + ');">' +
                                                        '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                        json[i].oidventa +
                                                        '"></input>' +
                                                        '<td style="width: 10%" align="center">' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                        // INICIO Oscar L. GAN-MS-B0-0213
                                                        json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                        // FIN GAN-MS-B0-0213
                                                        '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                        json[i].oidventa + '); ">' +
                                                        '<i class="fa fa-trash-o">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                        codigo_producto + '\')">' +
                                                        '<i class="fa fa-eye fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                        codigo_producto + '\',' + id +
                                                        ',' + i + ')">' +
                                                        '<i class="fa fa-dollar fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '</td>' +
                                                        '</form>' +
                                                        '</tr>'
                                                }
                                                total = total.toFixed(2);
                                                $("#total").html(total);
                                                $('#total_venta').val(total).trigger(
                                                    'change');
                                                if ($("#deuda").is(':checked')) {
                                                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                                    cambio_automatico();
                                                } else {
                                                    $('#pagado').val(total).trigger('change');
                                                    cambio_automatico();
                                                }
                                                //$('#cambio_venta').val("").trigger('change');
                                                //$("#cambio").html("");
                                                document.getElementById("precio" + dato)
                                                    .focus();
                                                document.getElementById("precio" + dato)
                                                    .select();

                                            },
                                            error: function(jqXHR, textStatus,
                                                errorThrown) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Sucedio un error',
                                                    text: 'por favor revise los datos',
                                                    confirmButtonColor: '#d33',
                                                    confirmButtonText: 'ACEPTAR'
                                                });
                                            }
                                        });

                                    } else {
                                        $.ajax({
                                            url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_produc') ?>",
                                            type: "POST",
                                            success: function(respuesta) {
                                                var json = JSON.parse(respuesta);
                                                con.innerHTML = '';
                                                let total = 0.000;
                                                for (var i = 0; i < json.length; i++) {
                                                    var codigo_producto = json[i]
                                                        .ocodigo.toString();
                                                    let num = parseFloat(json[i]
                                                        .oprecio);
                                                    total = total + num;
                                                    var id = json[i].oidventa;
                                                    var precio_total = (parseFloat(json[
                                                        i].oprecio)).toFixed(2);
                                                    var precio_unidad = (parseFloat(
                                                            json[i].oprecio_uni))
                                                        .toFixed(2);
                                                    con.innerHTML = con.innerHTML +
                                                        '<tr>' +
                                                        '<td>' + codigo_producto +
                                                        '</td>' +
                                                        '<td>' + json[i].onombre +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                        i + '" id="cantidad' + i +
                                                        '" value="' + json[i]
                                                        .ocantidad +
                                                        '" onkeydown="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        //Gary Valverde GAN-MS-M5-0034
                                                        '<td>' + json[i].unidad +
                                                        '</td>' +
                                                        //fin GAN-MS-M5-0034
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                        i + '" id="precio_uni' + i +
                                                        '" value="' + precio_unidad +
                                                        '" onkeydown="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                        i + '" id="precio' + i +
                                                        '" value="' + precio_total +
                                                        '" onkeydown="onkeydown_cant(this,' +
                                                        id + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<form method="post"  onsubmit="eliminar(' +
                                                        json[i].oidventa + ');">' +
                                                        '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                        json[i].oidventa +
                                                        '"></input>' +
                                                        '<td style="width: 10%" align="center">' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                        // INICIO Oscar L. GAN-MS-B0-0213
                                                        json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                        // FIN GAN-MS-B0-0213
                                                        '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                        json[i].oidventa + '); ">' +
                                                        '<i class="fa fa-trash-o">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                        codigo_producto + '\')">' +
                                                        '<i class="fa fa-eye fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                        codigo_producto + '\',' + id +
                                                        ',' + i + ')">' +
                                                        '<i class="fa fa-dollar fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '</td>' +
                                                        '</form>' +
                                                        '</tr>'
                                                }
                                                total = total.toFixed(2);
                                                $("#total").html(total);
                                                $('#total_venta').val(total).trigger(
                                                    'change');
                                                if ($("#deuda").is(':checked')) {
                                                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                                    cambio_automatico();
                                                } else {
                                                    $('#pagado').val(total).trigger('change');
                                                    cambio_automatico();
                                                }
                                                //$('#cambio_venta').val("").trigger('change');
                                                //$("#cambio").html("");
                                            },
                                            error: function(jqXHR, textStatus,
                                                errorThrown) {
                                                alert('Error al obtener datos de ajax');
                                            }
                                        });
                                    }
                                })
                            } else {
                                $.ajax({
                                    url: "<?php echo site_url('venta/C_pedidoCodigo/cambio_precio_uni') ?>",
                                    type: "POST",
                                    data: {
                                        dato3: idventa,
                                        dato4: msg.value
                                    },
                                    success: function(respuesta) {
                                        var json = JSON.parse(respuesta);
                                        con.innerHTML = '';
                                        let total = 0.000;
                                        for (var i = 0; i < json.length; i++) {
                                            var codigo_producto = json[i].ocodigo.toString();
                                            let num = parseFloat(json[i].oprecio);
                                            total = total + num;
                                            var id = json[i].oidventa;
                                            var precio_total = (parseFloat(json[i].oprecio))
                                                .toFixed(2);
                                            var precio_unidad = (parseFloat(json[i]
                                                .oprecio_uni)).toFixed(2);
                                            con.innerHTML = con.innerHTML +
                                                '<tr>' +
                                                '<td>' + codigo_producto + '</td>' +
                                                '<td>' + json[i].onombre + '</td>' +
                                                '<td>' +
                                                '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                i + '" id="cantidad' + i + '" value="' + json[i]
                                                .ocantidad +
                                                '" onkeydown="onkeydown_cantidad(this,' + id +
                                                ',' + i + ')"' +
                                                '" onblur="onkeydown_cantidad(this,' + id +
                                                ',' + i + ')"' + '&nbsp' +
                                                '</td>' +
                                                //Gary Valverde GAN-MS-M5-0034
                                                '<td>' + json[i].unidad + '</td>' +
                                                //fin GAN-MS-M5-0034
                                                '<td>' +
                                                '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                i + '" id="precio_uni' + i + '" value="' +
                                                precio_unidad +
                                                '" onkeydown="onkeydown_precio_uni(this,' + id +
                                                ',' + i + ')"' +
                                                '" onblur="onkeydown_precio_uni(this,' + id +
                                                ',' + i + ')"' + '&nbsp' +
                                                '</td>' +
                                                '<td>' +
                                                '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                i + '" id="precio' + i + '" value="' +
                                                precio_total +
                                                '" onkeydown="onkeydown_cant(this,' + id +
                                                ')"' + '&nbsp' +
                                                '</td>' +
                                                '<form method="post"  onsubmit="eliminar(' +
                                                json[i].oidventa + ');">' +
                                                '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                json[i].oidventa + '"></input>' +
                                                '<td style="width: 10%" align="center">' +
                                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                // INICIO Oscar L. GAN-MS-B0-0213
                                                json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                // FIN GAN-MS-B0-0213
                                                '</button>' +
                                                '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                json[i].oidventa + '); ">' +
                                                '<i class="fa fa-trash-o">' + '</i>' +
                                                '</button>' +
                                                '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                codigo_producto + '\')">' +
                                                '<i class="fa fa-eye fa-lg">' + '</i>' +
                                                '</button>' +
                                                '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                codigo_producto + '\',' + id + ',' + i + ')">' +
                                                '<i class="fa fa-dollar fa-lg">' + '</i>' +
                                                '</button>' +
                                                '</td>' +
                                                '</form>' +
                                                '</tr>'
                                        }
                                        total = total.toFixed(2);
                                        $("#total").html(total);
                                        $('#total_venta').val(total).trigger('change');
                                        if ($("#deuda").is(':checked')) {
                                            $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                            cambio_automatico();
                                        } else {
                                            $('#pagado').val(total).trigger('change');
                                            cambio_automatico();
                                        }
                                        //$('#cambio_venta').val("").trigger('change');
                                        //$("#cambio").html("");
                                        document.getElementById("precio" + dato).focus();
                                        document.getElementById("precio" + dato).select();
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Sucedio un error',
                                            text: 'por favor revise los datos',
                                            confirmButtonColor: '#d33',
                                            confirmButtonText: 'ACEPTAR'
                                        });
                                    }
                                });
                            }
                        });

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax');
                    }
                });
            }
        }
    </script>

    <script>
        function onkeydown_cant(msg, idventa) {
            var e = event || evt;
            var charCode = e.which || e.keyCode;
            if (charCode == 9 || charCode == 13) {
                $.ajax({
                    url: "<?php echo site_url('venta/C_pedidoCodigo/verificar_cambio_precio_total') ?>",
                    type: "POST",
                    data: {
                        dato1: idventa,
                        dato2: msg.value
                    },
                    success: function(respuesta) {
                        var js = JSON.parse(respuesta);
                        $.each(js, function(i, item) {
                            if (item.oboolean == 'f') {
                                Swal.fire({
                                    icon: 'warning',
                                    text: item.omensaje,
                                    title: "¿Desea Continuar con el Cambio de Precio?",
                                    showDenyButton: true,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ACEPTAR',
                                    denyButtonText: 'CANCELAR',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            url: "<?php echo site_url('venta/C_pedidoCodigo/cambiar_precio') ?>",
                                            type: "POST",
                                            data: {
                                                dato1: idventa,
                                                dato2: msg.value
                                            },
                                            success: function(respuesta) {
                                                var json = JSON.parse(respuesta);
                                                con.innerHTML = '';
                                                let total = 0.000;
                                                for (var i = 0; i < json.length; i++) {
                                                    var codigo_producto = json[i]
                                                        .ocodigo.toString();
                                                    let num = parseFloat(json[i]
                                                        .oprecio);
                                                    total = total + num;
                                                    var id = json[i].oidventa;
                                                    var precio_total = (parseFloat(json[
                                                        i].oprecio)).toFixed(2);
                                                    var precio_unidad = (parseFloat(
                                                            json[i].oprecio_uni))
                                                        .toFixed(2);
                                                    con.innerHTML = con.innerHTML +
                                                        '<tr>' +
                                                        '<td>' + codigo_producto +
                                                        '</td>' +
                                                        '<td>' + json[i].onombre +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                        i + '" id="cantidad' + i +
                                                        '" value="' + json[i]
                                                        .ocantidad +
                                                        '" onkeydown="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        //Gary Valverde GAN-MS-M5-0034
                                                        '<td>' + json[i].unidad +
                                                        '</td>' +
                                                        //fin GAN-MS-M5-0034
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                        i + '" id="precio_uni' + i +
                                                        '" value="' + precio_unidad +
                                                        '" onkeydown="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                        i + '" id="precio' + i +
                                                        '" value="' + precio_total +
                                                        '" onkeydown="onkeydown_cant(this,' +
                                                        id + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<form method="post"  onsubmit="eliminar(' +
                                                        json[i].oidventa + ');">' +
                                                        '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                        json[i].oidventa +
                                                        '"></input>' +
                                                        '<td style="width: 10%" align="center">' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                        // INICIO Oscar L. GAN-MS-B0-0213
                                                        json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                        // FIN GAN-MS-B0-0213
                                                        '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                        json[i].oidventa + '); ">' +
                                                        '<i class="fa fa-trash-o">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                        codigo_producto + '\')">' +
                                                        '<i class="fa fa-eye fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                        codigo_producto + '\',' + id +
                                                        ',' + i + ')">' +
                                                        '<i class="fa fa-dollar fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '</td>' +
                                                        '</form>' +
                                                        '</tr>'
                                                }
                                                total = total.toFixed(2);
                                                $("#total").html(total);
                                                $('#total_venta').val(total).trigger(
                                                    'change');
                                                if ($("#deuda").is(':checked')) {
                                                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                                    cambio_automatico();
                                                } else {
                                                    $('#pagado').val(total).trigger('change');
                                                    cambio_automatico();
                                                }
                                                // $('#cambio_venta').val("").trigger('change');
                                                //$("#cambio").html("");
                                                document.getElementById("pagado")
                                                    .focus();

                                            },
                                            error: function(jqXHR, textStatus,
                                                errorThrown) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Sucedio un error',
                                                    text: 'por favor revise los datos',
                                                    confirmButtonColor: '#d33',
                                                    confirmButtonText: 'ACEPTAR'
                                                });
                                            }
                                        });
                                    } else {
                                        $.ajax({
                                            url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_produc') ?>",
                                            type: "POST",
                                            success: function(respuesta) {
                                                var json = JSON.parse(respuesta);
                                                con.innerHTML = '';
                                                let total = 0.000;
                                                for (var i = 0; i < json.length; i++) {
                                                    var codigo_producto = json[i]
                                                        .ocodigo.toString();
                                                    let num = parseFloat(json[i]
                                                        .oprecio);
                                                    total = total + num;
                                                    var id = json[i].oidventa;
                                                    var precio_total = (parseFloat(json[
                                                        i].oprecio)).toFixed(2);
                                                    var precio_unidad = (parseFloat(
                                                            json[i].oprecio_uni))
                                                        .toFixed(2);
                                                    con.innerHTML = con.innerHTML +
                                                        '<tr>' +
                                                        '<td>' + codigo_producto +
                                                        '</td>' +
                                                        '<td>' + json[i].onombre +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                        i + '" id="cantidad' + i +
                                                        '" value="' + json[i]
                                                        .ocantidad +
                                                        '" onkeydown="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        //Gary Valverde GAN-MS-M5-0034
                                                        '<td>' + json[i].unidad +
                                                        '</td>' +
                                                        //fin GAN-MS-M5-0034
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                        i + '" id="precio_uni' + i +
                                                        '" value="' + precio_unidad +
                                                        '" onkeydown="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                        i + '" id="precio' + i +
                                                        '" value="' + precio_total +
                                                        '" onkeydown="onkeydown_cant(this,' +
                                                        id + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<form method="post"  onsubmit="eliminar(' +
                                                        json[i].oidventa + ');">' +
                                                        '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                        json[i].oidventa +
                                                        '"></input>' +
                                                        '<td style="width: 10%" align="center">' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                        // INICIO Oscar L. GAN-MS-B0-0213
                                                        json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                        // FIN GAN-MS-B0-0213
                                                        '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                        json[i].oidventa + '); ">' +
                                                        '<i class="fa fa-trash-o">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                        codigo_producto + '\')">' +
                                                        '<i class="fa fa-eye fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                        codigo_producto + '\',' + id +
                                                        ',' + i + ')">' +
                                                        '<i class="fa fa-dollar fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '</td>' +
                                                        '</form>' +
                                                        '</tr>'
                                                }
                                                total = total.toFixed(2);
                                                $("#total").html(total);
                                                $('#total_venta').val(total).trigger(
                                                    'change');
                                                if ($("#deuda").is(':checked')) {
                                                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                                    cambio_automatico();
                                                } else {
                                                    $('#pagado').val(total).trigger('change');
                                                    cambio_automatico();
                                                }
                                                //$('#cambio_venta').val("").trigger('change');
                                                //$("#cambio").html("");
                                            },
                                            error: function(jqXHR, textStatus,
                                                errorThrown) {
                                                alert('Error al obtener datos de ajax');
                                            }
                                        });
                                    }
                                })
                            } else {
                                $.ajax({
                                    url: "<?php echo site_url('venta/C_pedidoCodigo/cambiar_precio') ?>",
                                    type: "POST",
                                    data: {
                                        dato1: idventa,
                                        dato2: msg.value
                                    },
                                    success: function(respuesta) {
                                        var json = JSON.parse(respuesta);
                                        con.innerHTML = '';
                                        let total = 0.000;
                                        for (var i = 0; i < json.length; i++) {
                                            var codigo_producto = json[i].ocodigo.toString();
                                            let num = parseFloat(json[i].oprecio);
                                            total = total + num;
                                            var id = json[i].oidventa;
                                            var precio_total = (parseFloat(json[i].oprecio))
                                                .toFixed(2);
                                            var precio_unidad = (parseFloat(json[i]
                                                .oprecio_uni)).toFixed(2);
                                            con.innerHTML = con.innerHTML +
                                                '<tr>' +
                                                '<td>' + codigo_producto + '</td>' +
                                                '<td>' + json[i].onombre + '</td>' +
                                                '<td>' +
                                                '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                i + '" id="cantidad' + i + '" value="' + json[i]
                                                .ocantidad +
                                                '" onkeydown="onkeydown_cantidad(this,' + id +
                                                ',' + i + ')"' +
                                                '" onblur="onkeydown_cantidad(this,' + id +
                                                ',' + i + ')"' + '&nbsp' +
                                                '</td>' +
                                                //Gary Valverde GAN-MS-M5-0034
                                                '<td>' + json[i].unidad + '</td>' +
                                                //fin GAN-MS-M5-0034
                                                '<td>' +
                                                '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                i + '" id="precio_uni' + i + '" value="' +
                                                precio_unidad +
                                                '" onkeydown="onkeydown_precio_uni(this,' + id +
                                                ',' + i + ')"' +
                                                '" onblur="onkeydown_precio_uni(this,' + id +
                                                ',' + i + ')"' + '&nbsp' +
                                                '</td>' +
                                                '<td>' +
                                                '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                i + '" id="precio' + i + '" value="' +
                                                precio_total +
                                                '" onkeydown="onkeydown_cant(this,' + id +
                                                ')"' + '&nbsp' +
                                                '</td>' +
                                                '<form method="post"  onsubmit="eliminar(' +
                                                json[i].oidventa + ');">' +
                                                '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                json[i].oidventa + '"></input>' +
                                                '<td style="width: 10%" align="center">' +
                                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                // INICIO Oscar L. GAN-MS-B0-0213
                                                json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                // FIN GAN-MS-B0-0213
                                                '</button>' +
                                                '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                json[i].oidventa + '); ">' +
                                                '<i class="fa fa-trash-o">' + '</i>' +
                                                '</button>' +
                                                '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                codigo_producto + '\')">' +
                                                '<i class="fa fa-eye fa-lg">' + '</i>' +
                                                '</button>' +
                                                '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                codigo_producto + '\',' + id + ',' + i + ')">' +
                                                '<i class="fa fa-dollar fa-lg">' + '</i>' +
                                                '</button>' +
                                                '</td>' +
                                                '</form>' +
                                                '</tr>'
                                        }
                                        total = total.toFixed(2);
                                        $("#total").html(total);
                                        $('#total_venta').val(total).trigger('change');
                                        if ($("#deuda").is(':checked')) {
                                            $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                            cambio_automatico();
                                        } else {
                                            $('#pagado').val(total).trigger('change');
                                            cambio_automatico();
                                        }
                                        //$('#cambio_venta').val("").trigger('change');
                                        //$("#cambio").html("");
                                        document.getElementById("pagado").focus();

                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Sucedio un error',
                                            text: 'por favor revise los datos',
                                            confirmButtonColor: '#d33',
                                            confirmButtonText: 'ACEPTAR'
                                        });
                                    }
                                });
                            }
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error al obtener datos de ajax');
                    }
                });
            }
        }
    </script>
    <script>
        function onkeypress_nit_razonSocial() {
            if (event.key === 'Enter') {
                document.getElementById("id_producto").focus();
                document.getElementById("id_producto").select();
            }
        };

        $("#nit").keyup(function() {

            var valor = $(this).prop("value");

            if (valor < 0)
                $(this).prop("value", " ");
        })


        function onkeydown_nombre_producto() {
            var e = event || evt;
            var charCode = e.which || e.keyCode;
            if (charCode == 9) {
                let con = document.getElementById('con');
                var codigo = document.getElementById("nombre_producto").value;
                $.ajax({
                    url: "<?php echo site_url('venta/C_pedidoCodigo/datos_nombre') ?>",
                    type: "POST",
                    data: {
                        buscar: codigo
                    },
                    success: function(respuesta) {
                        var json = JSON.parse(respuesta);
                        console.log("Mel_respuesta: " + respuesta);
                        console.log("Mel_json:" + json);
                        con.innerHTML = '';
                        let total = 0.000;
                        for (var i = 0; i < json.length; i++) {

                            var codigo_producto = json[i].ocodigo.toString();
                            console.log("Mel_codigo_producto:" + codigo_producto);
                            let num = parseFloat(json[i].oprecio);
                            total = total + num;
                            var id = json[i].oidventa;
                            var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                            var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                            con.innerHTML = con.innerHTML +
                                '<tr>' +
                                '<td>' + codigo_producto + '</td>' +
                                '<td>' + json[i].onombre + '</td>' +
                                '<td>' +
                                '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                i + '" id="cantidad' + i + '" value="' + json[i].ocantidad +
                                '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' +
                                '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                                '</td>' +
                                //Gary Valverde GAN-MS-M5-0034
                                '<td>' + json[i].unidad + '</td>' +
                                //fin GAN-MS-M5-0034
                                '<td>' +
                                '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                i + '" id="precio_uni' + i + '" value="' + precio_unidad +
                                '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' +
                                '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' +
                                '</td>' +
                                '<td>' +
                                '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                i + '" id="precio' + i + '" value="' + precio_total +
                                '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' +
                                '</td>' +
                                '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                                '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa +
                                '"></input>' +
                                '<td style="width: 10%" align="center">' +
                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                // INICIO Oscar L. GAN-MS-B0-0213
                                json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                // FIN GAN-MS-B0-0213
                                '</button>' +
                                '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                                '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                codigo_producto + '\')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                                '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                codigo_producto + '\',' + id + ',' + i + ')">' +
                                '<i class="fa fa-dollar fa-lg">' +
                                '</i>' +
                                '</button>' +
                                '</td>' +
                                '</form>' +
                                '</tr>'
                        }
                        total = total.toFixed(2);
                        $("#total").html(total);
                        document.getElementById("form_nombre").reset();
                        $('#total_venta').val(total).trigger('change');
                        if ($("#deuda").is(':checked')) {
                            $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                            cambio_automatico();
                        } else {
                            $('#pagado').val(total).trigger('change');
                            cambio_automatico();
                        }
                        //$('#cambio_venta').val("").trigger('change');
                        //$("#cambio").html("");
                        document.getElementById("nombre_producto").focus();
                        document.getElementById("nombre_producto").select();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sucedio un error con el producto seleccionado',
                            text: 'por favor revise inventarios y abastecimiento',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'ACEPTAR'
                        });
                        document.getElementById("form_nombre").reset();
                    }
                });
            }
        }
    </script>
    <script>
        function onkeydown_cantidad(msg, idventa, dato) {
            var e = event || evt;
            var charCode = e.which || e.keyCode;
            if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) {
                if (charCode == 9 || charCode == 13 || charCode == undefined) {
                    $.ajax({
                        url: "<?php echo site_url('venta/C_pedidoCodigo/verifica_cantidad') ?>",
                        type: "POST",
                        data: {
                            dato1: idventa,
                            dato2: msg.value
                        },
                        success: function(respuesta) {
                            var js = JSON.parse(respuesta);
                            $.each(js, function(i, item) {
                                if (item.oboolean == 'f') {
                                    Swal.fire({
                                        icon: 'info',
                                        text: item.omensaje,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ACEPTAR',
                                    }).then((result) => {
                                        $.ajax({
                                            url: "<?php echo site_url('venta/C_pedidoCodigo/cantidad_producto') ?>",
                                            type: "POST",
                                            data: {
                                                dato1: idventa,
                                                dato2: msg.value
                                            },
                                            success: function(respuesta) {
                                                var json = JSON.parse(respuesta);
                                                con.innerHTML = '';
                                                let total = 0.000;
                                                for (var i = 0; i < json.length; i++) {
                                                    var codigo_producto = json[i].ocodigo
                                                        .toString();
                                                    let num = parseFloat(json[i].oprecio);
                                                    total = total + num;
                                                    var id = json[i].oidventa;
                                                    var precio_total = (parseFloat(json[i]
                                                        .oprecio)).toFixed(2);
                                                    var precio_unidad = (parseFloat(json[i]
                                                        .oprecio_uni)).toFixed(2);
                                                    con.innerHTML = con.innerHTML +
                                                        '<tr>' +
                                                        '<td>' + codigo_producto + '</td>' +
                                                        '<td>' + json[i].onombre + '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                        i + '" id="cantidad' + i +
                                                        '" value="' + json[i].ocantidad +
                                                        '" onkeydown="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        //Gary Valverde GAN-MS-M5-0034
                                                        '<td>' + json[i].unidad + '</td>' +
                                                        //fin GAN-MS-M5-0034
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                        i + '" id="precio_uni' + i +
                                                        '" value="' + precio_unidad +
                                                        '" onkeydown="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                        i + '" id="precio' + i +
                                                        '" value="' + precio_total +
                                                        '" onkeydown="onkeydown_cant(this,' +
                                                        id + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<form method="post"  onsubmit="eliminar(' +
                                                        json[i].oidventa + ');">' +
                                                        '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                        json[i].oidventa + '"></input>' +
                                                        '<td style="width: 10%" align="center">' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                        // INICIO Oscar L. GAN-MS-B0-0213
                                                        json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                        // FIN GAN-MS-B0-0213
                                                        '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                        json[i].oidventa + '); ">' +
                                                        '<i class="fa fa-trash-o">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                        codigo_producto + '\')">' +
                                                        '<i class="fa fa-eye fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                        codigo_producto + '\',' + id + ',' +
                                                        i + ')">' +
                                                        '<i class="fa fa-dollar fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '</td>' +
                                                        '</form>' +
                                                        '</tr>'
                                                }
                                                total = total.toFixed(2);
                                                $("#total").html(total);
                                                $('#total_venta').val(total).trigger(
                                                    'change');
                                                if ($("#deuda").is(':checked')) {
                                                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                                    cambio_automatico();
                                                } else {
                                                    $('#pagado').val(total).trigger('change');
                                                    cambio_automatico();
                                                }
                                                //$('#cambio_venta').val("").trigger('change');
                                                //$("#cambio").html("");
                                                document.getElementById("id_producto")
                                                    .focus();
                                                document.getElementById("id_producto")
                                                    .select();
                                            },

                                            error: function(jqXHR, textStatus, errorThrown) {
                                                alert('Error al obtener datos de ajax1');
                                            }
                                        });
                                    })
                                } else {
                                    console.log(idventa);
                                    console.log(msg.value);
                                    $.ajax({
                                        url: "<?php echo site_url('venta/C_pedidoCodigo/cantidad_producto') ?>",
                                        type: "POST",
                                        data: {
                                            dato1: idventa,
                                            dato2: msg.value
                                        },
                                        success: function(respuesta) {
                                            var json = JSON.parse(respuesta);
                                            console.log('JSON cantidad_producto');
                                            console.log(json);
                                            con.innerHTML = '';
                                            let total = 0.000;
                                            for (var i = 0; i < json.length; i++) {
                                                var codigo_producto = json[i].ocodigo.toString();
                                                let num = parseFloat(json[i].oprecio);
                                                total = total + num;
                                                var id = json[i].oidventa;
                                                var precio_total = (parseFloat(json[i].oprecio))
                                                    .toFixed(2);
                                                var precio_unidad = (parseFloat(json[i]
                                                    .oprecio_uni)).toFixed(2);
                                                con.innerHTML = con.innerHTML +
                                                    '<tr>' +
                                                    '<td>' + codigo_producto + '</td>' +
                                                    '<td>' + json[i].onombre + '</td>' +
                                                    '<td>' +
                                                    '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                    i + '" id="cantidad' + i + '" value="' + json[i]
                                                    .ocantidad +
                                                    '" onkeydown="onkeydown_cantidad(this,' + id +
                                                    ',' + i + ')"' +
                                                    '" onblur="onkeydown_cantidad(this,' + id +
                                                    ',' + i + ')"' + '&nbsp' +
                                                    '</td>' +
                                                    //Gary Valverde GAN-MS-M5-0034
                                                    '<td>' + json[i].unidad + '</td>' +
                                                    //fin GAN-MS-M5-0034
                                                    '<td>' +
                                                    '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                    i + '" id="precio_uni' + i + '" value="' +
                                                    precio_unidad +
                                                    '" onkeydown="onkeydown_precio_uni(this,' + id +
                                                    ',' + i + ')"' +
                                                    '" onblur="onkeydown_precio_uni(this,' + id +
                                                    ',' + i + ')"' + '&nbsp' +
                                                    '</td>' +
                                                    '<td>' +
                                                    '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                    i + '" id="precio' + i + '" value="' +
                                                    precio_total +
                                                    '" onkeydown="onkeydown_cant(this,' + id +
                                                    ')"' + '&nbsp' +
                                                    '</td>' +
                                                    '<form method="post"  onsubmit="eliminar(' +
                                                    json[i].oidventa + ');">' +
                                                    '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                    json[i].oidventa + '"></input>' +
                                                    '<td style="width: 10%" align="center">' +
                                                    '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                    // INICIO Oscar L. GAN-MS-B0-0213
                                                    json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                    // FIN GAN-MS-B0-0213
                                                    '</button>' +
                                                    '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                    '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                    json[i].oidventa + '); ">' +
                                                    '<i class="fa fa-trash-o">' + '</i>' +
                                                    '</button>' +
                                                    '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                    '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                    codigo_producto + '\')">' +
                                                    '<i class="fa fa-eye fa-lg">' + '</i>' +
                                                    '</button>' +
                                                    '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                    '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                    codigo_producto + '\',' + id + ',' + i + ')">' +
                                                    '<i class="fa fa-dollar fa-lg">' + '</i>' +
                                                    '</button>' +
                                                    '</td>' +
                                                    '</form>' +
                                                    '</tr>'
                                            }
                                            total = total.toFixed(2);
                                            $("#total").html(total);
                                            $('#total_venta').val(total).trigger('change');
                                            if ($("#deuda").is(':checked')) {
                                                $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                                cambio_automatico();
                                            } else {
                                                $('#pagado').val(total).trigger('change');
                                                cambio_automatico();
                                            }
                                            //$('#cambio_venta').val("").trigger('change');
                                            //$("#cambio").html("");
                                            document.getElementById("id_producto").focus();
                                            document.getElementById("id_producto").select();
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            alert('Error al obtener datos de ajax2');
                                        }
                                    });
                                }
                            });

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error al obtener datos de ajax');
                        }
                    });
                }
            } else {
                if (charCode == 9 || charCode == 13) {
                    $.ajax({
                        url: "<?php echo site_url('venta/C_pedidoCodigo/verifica_cantidad') ?>",
                        type: "POST",
                        data: {
                            dato1: idventa,
                            dato2: msg.value
                        },
                        success: function(respuesta) {
                            var js = JSON.parse(respuesta);
                            $.each(js, function(i, item) {
                                if (item.oboolean == 'f') {
                                    Swal.fire({
                                        icon: 'info',
                                        text: item.omensaje,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ACEPTAR',
                                    }).then((result) => {
                                        $.ajax({
                                            url: "<?php echo site_url('venta/C_pedidoCodigo/cantidad_producto') ?>",
                                            type: "POST",
                                            data: {
                                                dato1: idventa,
                                                dato2: msg.value
                                            },
                                            success: function(respuesta) {
                                                var json = JSON.parse(respuesta);
                                                con.innerHTML = '';
                                                let total = 0.000;
                                                for (var i = 0; i < json.length; i++) {
                                                    var codigo_producto = json[i].ocodigo
                                                        .toString();
                                                    let num = parseFloat(json[i].oprecio);
                                                    total = total + num;
                                                    var id = json[i].oidventa;
                                                    var precio_total = (parseFloat(json[i]
                                                        .oprecio)).toFixed(2);
                                                    var precio_unidad = (parseFloat(json[i]
                                                        .oprecio_uni)).toFixed(2);
                                                    con.innerHTML = con.innerHTML +
                                                        '<tr>' +
                                                        '<td>' + codigo_producto + '</td>' +
                                                        '<td>' + json[i].onombre + '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                        i + '" id="cantidad' + i +
                                                        '" value="' + json[i].ocantidad +
                                                        '" onkeydown="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_cantidad(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        //Gary Valverde GAN-MS-M5-0034
                                                        '<td>' + json[i].unidad + '</td>' +
                                                        //fin GAN-MS-M5-0034
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                        i + '" id="precio_uni' + i +
                                                        '" value="' + precio_unidad +
                                                        '" onkeydown="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' +
                                                        '" onblur="onkeydown_precio_uni(this,' +
                                                        id + ',' + i + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<td>' +
                                                        '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                        i + '" id="precio' + i +
                                                        '" value="' + precio_total +
                                                        '" onkeydown="onkeydown_cant(this,' +
                                                        id + ')"' + '&nbsp' +
                                                        '</td>' +
                                                        '<form method="post"  onsubmit="eliminar(' +
                                                        json[i].oidventa + ');">' +
                                                        '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                        json[i].oidventa + '"></input>' +
                                                        '<td style="width: 10%" align="center">' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                        // INICIO Oscar L. GAN-MS-B0-0213
                                                        json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                        // FIN GAN-MS-B0-0213
                                                        '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                        json[i].oidventa + '); ">' +
                                                        '<i class="fa fa-trash-o">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                        codigo_producto + '\')">' +
                                                        '<i class="fa fa-eye fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                        '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                        codigo_producto + '\',' + id + ',' +
                                                        i + ')">' +
                                                        '<i class="fa fa-dollar fa-lg">' +
                                                        '</i>' + '</button>' +
                                                        '</td>' +
                                                        '</form>' +
                                                        '</tr>'
                                                }
                                                total = total.toFixed(2);
                                                $("#total").html(total);
                                                $('#total_venta').val(total).trigger(
                                                    'change');
                                                if ($("#deuda").is(':checked')) {
                                                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                                    cambio_automatico();
                                                } else {
                                                    $('#pagado').val(total).trigger('change');
                                                    cambio_automatico();
                                                }
                                                //$('#cambio_venta').val("").trigger('change');
                                                //$("#cambio").html("");
                                                document.getElementById("id_producto")
                                                    .focus();
                                                document.getElementById("id_producto")
                                                    .select();
                                            },

                                            error: function(jqXHR, textStatus, errorThrown) {
                                                alert('Error al obtener datos de ajax1');
                                            }
                                        });
                                    })
                                } else {
                                    console.log(idventa);
                                    console.log(msg.value);
                                    $.ajax({
                                        url: "<?php echo site_url('venta/C_pedidoCodigo/cantidad_producto') ?>",
                                        type: "POST",
                                        data: {
                                            dato1: idventa,
                                            dato2: msg.value
                                        },
                                        success: function(respuesta) {
                                            var json = JSON.parse(respuesta);
                                            console.log('JSON cantidad_producto');
                                            console.log(json);
                                            con.innerHTML = '';
                                            let total = 0.000;
                                            for (var i = 0; i < json.length; i++) {
                                                var codigo_producto = json[i].ocodigo.toString();
                                                let num = parseFloat(json[i].oprecio);
                                                total = total + num;
                                                var id = json[i].oidventa;
                                                var precio_total = (parseFloat(json[i].oprecio))
                                                    .toFixed(2);
                                                var precio_unidad = (parseFloat(json[i]
                                                    .oprecio_uni)).toFixed(2);
                                                con.innerHTML = con.innerHTML +
                                                    '<tr>' +
                                                    '<td>' + codigo_producto + '</td>' +
                                                    '<td>' + json[i].onombre + '</td>' +
                                                    '<td>' +
                                                    '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                                                    i + '" id="cantidad' + i + '" value="' + json[i]
                                                    .ocantidad +
                                                    '" onkeydown="onkeydown_cantidad(this,' + id +
                                                    ',' + i + ')"' +
                                                    '" onblur="onkeydown_cantidad(this,' + id +
                                                    ',' + i + ')"' + '&nbsp' +
                                                    '</td>' +
                                                    //Gary Valverde GAN-MS-M5-0034
                                                    '<td>' + json[i].unidad + '</td>' +
                                                    //fin GAN-MS-M5-0034
                                                    '<td>' +
                                                    '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                                                    i + '" id="precio_uni' + i + '" value="' +
                                                    precio_unidad +
                                                    '" onkeydown="onkeydown_precio_uni(this,' + id +
                                                    ',' + i + ')"' +
                                                    '" onblur="onkeydown_precio_uni(this,' + id +
                                                    ',' + i + ')"' + '&nbsp' +
                                                    '</td>' +
                                                    '<td>' +
                                                    '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                                                    i + '" id="precio' + i + '" value="' +
                                                    precio_total +
                                                    '" onkeydown="onkeydown_cant(this,' + id +
                                                    ')"' + '&nbsp' +
                                                    '</td>' +
                                                    '<form method="post"  onsubmit="eliminar(' +
                                                    json[i].oidventa + ');">' +
                                                    '<input type="hidden" name="idVenta" id="id_Venta" value="' +
                                                    json[i].oidventa + '"></input>' +
                                                    '<td style="width: 10%" align="center">' +
                                                    '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                                                    // INICIO Oscar L. GAN-MS-B0-0213
                                                    json[i].oimagen + '\',' + json[i].ocodigo + ')">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                                                    // FIN GAN-MS-B0-0213
                                                    '</button>' +
                                                    '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                    '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                                                    json[i].oidventa + '); ">' +
                                                    '<i class="fa fa-trash-o">' + '</i>' +
                                                    '</button>' +
                                                    '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                    '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                                                    codigo_producto + '\')">' +
                                                    '<i class="fa fa-eye fa-lg">' + '</i>' +
                                                    '</button>' +
                                                    '<label>&nbsp;&nbsp;&nbsp;</label>' +
                                                    '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                                                    codigo_producto + '\',' + id + ',' + i + ')">' +
                                                    '<i class="fa fa-dollar fa-lg">' + '</i>' +
                                                    '</button>' +
                                                    '</td>' +
                                                    '</form>' +
                                                    '</tr>'
                                            }
                                            total = total.toFixed(2);
                                            $("#total").html(total);
                                            $('#total_venta').val(total).trigger('change');
                                            if ($("#deuda").is(':checked')) {
                                                $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                                                cambio_automatico();
                                            } else {
                                                $('#pagado').val(total).trigger('change');
                                                cambio_automatico();
                                            }
                                            //$('#cambio_venta').val("").trigger('change');
                                            //$("#cambio").html("");
                                            document.getElementById("id_producto").focus();
                                            document.getElementById("id_producto").select();
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            alert('Error al obtener datos de ajax2');
                                        }
                                    });
                                }
                            });

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error al obtener datos de ajax');
                        }
                    });
                }
            }
        }
    </script>
    <!--js validar-->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#deuda").click(function() {
                valor = document.getElementById("razonSocial").value;
                valor1 = document.getElementById("nit").value;
                pago = document.getElementById("pagado").value;

                if (valor == null || valor.length == 0 || valor1 == null || valor1.length == 0) {
                    //alert('Debe ingresar el cliente');
                    document.getElementById("miForm").reset();
                    //document.getElementById("deuda").value = "";
                    document.getElementById("pagado").value = pago;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Debe ingresar el cliente',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'ACEPTAR'
                    })
                } else {
                    document.getElementById("cam").innerHTML = "Saldo";
                    $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                    cambio_automatico();
                    $('#cambio_venta').val("").trigger('change');
                    $("#cambio").html("");
                }

            });
            $("#efectivo").click(function() {
                document.getElementById("cam").innerHTML = "Cambio";
                $('#pagado').val("").trigger('change');
                $('#cambio_venta').val("").trigger('change');
                $("#cambio").html("");
            });
            $("#tarjeta").click(function() {
                document.getElementById("cam").innerHTML = "Cambio";
                $('#pagado').val("").trigger('change');
                $('#cambio_venta').val("").trigger('change');
                $("#cambio").html("");
            });
            $("#tarQR").click(function() {
                document.getElementById("cam").innerHTML = "Cambio";
                $('#pagado').val("").trigger('change');
                $('#cambio_venta').val("").trigger('change');
                $("#cambio").html("");
            });
        });
    </script>

    <script type="text/javascript">
        // INICIO Oscar L., GAN-MS-B0-0213
        function ver_imagen(oimagen, id_imagen_verificar) {
            if (oimagen == null || oimagen == '' || oimagen == "null") {
                dato = '<img src="<?php echo base_url(); ?>assets/img/productos/sin_imagen.jpg" class="img-responsive">';
                document.getElementById("verImagen").innerHTML = dato;
            } else {

                $.ajax({
                    url: "assets/img/productos/" + oimagen,
                    type: 'HEAD',
                    error: function() {
                        console.log("El archivo no existe.");
                        $.ajax({
                            url: "<?php echo site_url('venta/C_pedidoCodigo/cambiar_null_a_imagenes_sin_archivos_fisicos') ?>",
                            type: "POST",
                            data: {
                                dato1: id_imagen_verificar,
                            },
                            success: function(respuesta) {
                                console.log(respuesta);
                                dato = '<img src="<?php echo base_url(); ?>assets/img/productos/sin_imagen.jpg" class="img-responsive">';
                                document.getElementById("verImagen").innerHTML = dato;
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error al obtener datos de ajax3', jqXHR);
                            }
                        });
                    },
                    success: function() {
                        console.log('el archivo existe')
                        dato = '<img src="<?php echo base_url(); ?>assets/img/productos/' + oimagen + '" class="img-responsive">';
                        document.getElementById("verImagen").innerHTML = dato;
                    }
                });
            }
        };
        //  FIN GAN-MS-B0-0213
    </script>

    <script type="text/javascript">
        function limpiar() {
            var nom = document.getElementById("nit").value;
            var nit = document.getElementById("razonSocial").value;
            if (nom == "") {
                $('#razonSocial').val("").trigger('change');
            }
            if (nit == "") {
                $('#nit').val("").trigger('change');
            }
        }
    </script>

    <script type="text/javascript">
        function mostrar_stock(codigo) {
            var contenido = document.getElementById("tstock");
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_stock_total') ?>",
                type: "POST",
                data: {
                    dato1: codigo.toString()
                },
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    console.log('stock');
                    console.log(json);
                    contenido.innerHTML = '';
                    for (var i = 0; i < json.length; i++) {

                        contenido.innerHTML = contenido.innerHTML +
                            '<tr>' +
                            '<th scope="row">' + i + '</th>' +
                            '<td>' + json[i].odescripcion + '</td>' +
                            '<td>' + json[i].ocantidad + '</td>' +
                            '</tr>'
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax2');
                }
            });
        }
    </script>
    <script type="text/javascript">
        function clear_modal() {
            var contenido = document.getElementById("tstock");
            contenido.innerHTML = '';
        }
    </script>

    <!--PARA LISTAR LOS PRECIOS-->
    <script type="text/javascript">
        function mostrar_precios(codigo, idventa, dato) {
            document.getElementById("infoPrecio").style.visibility = "visible";
            var contenido = document.getElementById("tprecio");
            console.log(idventa);
            console.log(dato);
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/mostrar_precios_total') ?>",
                type: "POST",
                data: {
                    dato1: codigo.toString()
                },
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    console.log('precio');
                    console.log(json.length);
                    console.log(json);
                    contenido.innerHTML = '';
                    if (json.length != 0) {
                        for (var i = 0; i < json.length; i++) {
                            contenido.innerHTML = contenido.innerHTML +
                                '<tr>' +
                                '<th scope="row">' + i + '</th>' +
                                '<td>' + json[i].odescripcion + '</td>' +
                                '<td>' + json[i].oprecio + '</td>' +
                                '<td>' +
                                '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" onclick="cambio_uni(' +
                                json[i].oprecio + ',' + idventa + ',' + dato + ')"><i class="fa fa-plus fa-lg">' +
                                '</i>' + '</button>' + '</td>' +
                                '</tr>'
                        }
                    } else {
                        contenido.innerHTML = contenido.innerHTML +
                            '<center>No se encontro registro de precios</center>'
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al obtener datos de ajax3');
                }
            });
        }
    </script>
    <script type="text/javascript">
        function clear_modal_precio() {
            var contenido = document.getElementById("tprecio");
            contenido.innerHTML = '';
        }
    </script>

    <script type="text/javascript">
        function cambio_uni(msg, idventa, dato) {
            $.ajax({
                url: "<?php echo site_url('venta/C_pedidoCodigo/cambio_precio_uni') ?>",
                type: "POST",
                data: {
                    dato3: idventa,
                    dato4: msg

                },
                success: function(respuesta) {
                    var json = JSON.parse(respuesta);
                    console.log(json);
                    con.innerHTML = '';
                    let total = 0.000;
                    for (var i = 0; i < json.length; i++) {
                        var codigo_producto = json[i].ocodigo.toString();
                        let num = parseFloat(json[i].oprecio);
                        total = total + num;
                        var id = json[i].oidventa;
                        var precio_total = (parseFloat(json[i].oprecio)).toFixed(2);
                        var precio_unidad = (parseFloat(json[i].oprecio_uni)).toFixed(2);
                        con.innerHTML = con.innerHTML +
                            '<tr>' +
                            '<td>' + codigo_producto + '</td>' +
                            '<td>' + json[i].onombre + '</td>' +
                            '<td>' +
                            '<input type="number" style="border:1px solid #c7254e; width : 60px" min="1"  name="cantidad' +
                            i + '" id="cantidad' + i + '" value="' + json[i].ocantidad +
                            '" onkeydown="onkeydown_cantidad(this,' + id + ',' + i + ')"' +
                            '" onblur="onkeydown_cantidad(this,' + id + ',' + i + ')"' + '&nbsp' +
                            '</td>' +
                            //Gary Valverde GAN-MS-M5-0034
                            '<td>' + json[i].unidad + '</td>' +
                            //fin GAN-MS-M5-00342
                            '<td>' +
                            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio_uni' +
                            i + '" id="precio_uni' + i + '" value="' + precio_unidad +
                            '" onkeydown="onkeydown_precio_uni(this,' + id + ',' + i + ')"' +
                            '" onblur="onkeydown_precio_uni(this,' + id + ',' + i + ')"' + '&nbsp' + '</td>' +
                            '<td>' +
                            '<input type="number" style="border:1px solid #c7254e; width : 100px" min="0" name="precio' +
                            i + '" id="precio' + i + '" value="' + precio_total +
                            '" onkeydown="onkeydown_cant(this,' + id + ')"' + '&nbsp' + '</td>' +
                            '<form method="post"  onsubmit="eliminar(' + json[i].oidventa + ');">' +
                            '<input type="hidden" name="idVenta" id="id_Venta" value="' + json[i].oidventa +
                            '"></input>' +
                            '<td style="width: 10%" align="center">' +
                            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="ver_imagen(\'' +
                            json[i].oimagen + '\');">' + '<i class="fa fa-picture-o fa-lg">' + '</i>' +
                            '</button>' +
                            '<label>&nbsp;&nbsp;&nbsp;</label>' +
                            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-danger" onclick="eliminar(' +
                            json[i].oidventa + '); ">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>' +
                            '<label>&nbsp;&nbsp;&nbsp;</label>' +
                            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-info" data-toggle="modal" data-target="#infoStock" onclick="mostrar_stock(\'' +
                            codigo_producto + '\')">' + '<i class="fa fa-eye fa-lg">' + '</i>' + '</button>' +
                            '<label>&nbsp;&nbsp;&nbsp;</label>' +
                            '<button type="button" class="btn ink-reaction btn-floating-action btn-xs btn-warning" data-toggle="modal" data-target="#infoPrecio" onclick="mostrar_precios(\'' +
                            codigo_producto + '\',' + id + ',' + i + ')" > ' +
                            '<i class="fa fa-dollar fa-lg">' +
                            '</i>' + '</button>' +
                            '</td>' +
                            '</form>' +
                            '</tr>'
                    }
                    total = total.toFixed(2);
                    $("#total").html(total);
                    $('#total_venta').val(total).trigger('change');
                    if ($("#deuda").is(':checked')) {
                        $('#pagado').val((parseFloat(0)).toFixed(2)).trigger('change');
                        cambio_automatico();
                    } else {
                        $('#pagado').val(total).trigger('change');
                        cambio_automatico();
                    }
                    //$('#cambio_venta').val("").trigger('change');
                    //$("#cambio").html("");
                    document.getElementById("infoPrecio").style.visibility = "hidden";
                    document.getElementById("precio" + dato).focus();
                    document.getElementById("precio" + dato).select();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Console.log('Error');
                }
            });
        }

        /* GAN-MS-B5-0448 GValverde */
        function obtener_fecha() {
            var esteMomento = new Date();
            var fecha = esteMomento.toLocaleDateString();
            var partesFecha = fecha.split("/");
            var dia = partesFecha[0];
            var mes = partesFecha[1];
            var anio = partesFecha[2];
            dia = dia.padStart(2, "0");
            mes = mes.padStart(2, "0");
            return fechaFormateada = dia + "-" + mes + "-" + anio;
        }
        /*FIN  GAN-MS-B5-0448 GValverde */
    </script>
<?php } else {
    redirect('inicio');
} ?>