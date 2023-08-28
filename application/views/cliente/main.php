<?php
/* 
  ---------------------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos Fecha: 20/04/2021, Codigo:SYSGAM-001
  Descripcion: Se modifico el menu venta para que se pueda acceder a la vista pedido por codigo
  ---------------------------------------------------------------------------------------------
  Modificado: Luis Andres Cachaga Leuca Fecha: 11/07/2021, Codigo:GAN-MS-A6-004
  Descripcion: Se agrego un campo para las notificaciones se excluyen los permisos
  ---------------------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:17/08/2021, Codigo: GAN-FR-A4-018,
  Descripcion: Se modifico el menu provision para que se pueda acceder a la vista conversion paq/unid.
  ---------------------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:07/09/2021, Codigo: GAN-MS-A3-026,
  Descripcion: Se modifico el menu reportes para que se pueda acceder a la vista abastecimiento y gastos.
  ---------------------------------------------------------------------------------------------
  Modificado: Fabian Alejandro Candia Alvizuri Fecha:23/09/2021, Codigo: GAN-FR-M3-030,
  Descripcion: Se agrego al menu el campo gastos para que se pueda acceder a la vista
  ---------------------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:11/11/2021, Codigo: GAN-MS-A5-078,
  Descripcion: Se agrego al menu el campo reporte de creditos para que se pueda acceder a la vista
  ---------------------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:17/11/2021, GAN-MS-A4-092,
  Descripcion: Se agrego al menu el campo listado de venta para que se pueda acceder a la vista
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:14/04/2022, Codigo:GAN-FR-A5-157
  Descripcion: se cambiaron los nombres/titulos segun lo acordado en la reunion
  ------------------------------------------------------------------------------
  Modificado: Saul Imanol Quiroga Castrillo Fecha:07/06/2022, Codigo:GAN-MS-M1-268
  Descripcion: se elimino el show modal de notificaciones alojado en la funcion visto, se agrego data-toggle y data-target en las notificaciones para su visualizacion
  ------------------------------------------------------------------------------
  Modificado: Gabriela Mamani Choquehuanca Fecha:24/06/2022,  Codigo:GAN-MS-A5-275,
  Descripcion: Se adiciono en al BEGIN ADMINISTRACION el campo de Ubicaciones  para que se pueda acceder a la vista
  ------------------------------------------------------------------------------
  Modificado: Ronaldo Alcon Fecha:22/06/2022, Codigo:GAN-MS-A5-280
  Descripcion: Se modifico la parte de notificaciones, con un scroll que permita mover las notificaciones
  ------------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa Fecha:02/09/2022, Codigo:GAN-FR-A1-433
  Descripcion: Se modifico el menu administracion para que se pueda acceder a la vista permiso.
  ------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar Fecha:19/10/2022, Codigo:GAN-DPR-M6-0060
  Descripcion: Se modifico el menu provision para que se pueda acceder a la vista envio de producto.
*/
?>

<script>
  function visto(id_notificacion, notificacion) {
    
    $('#text_modal').html(notificacion);

    $.ajax({
      url: "<?php echo site_url('C_inicio/leer_notificacion') ?>/" + id_notificacion,
      type: "POST",
      dataType: "JSON",
      success: function(data) {

        $("#NumNotificaciones").load(" #NumNotificaciones");
        $("#notifications").load(" #notifications");
      }
    });
  }
</script>
<!-- BEGIN HEADER-->
<header id="header">
  <div class="headerbar">
    <div class="headerbar-left">
      <ul class="header-nav header-nav-options">
        <li class="header-nav-brand">
          <div class="brand-holder">
            <a href="<?= base_url(); ?>inicio">
              <span class="text-lg text-bold" style="color:#00793a"><?php $obj = json_decode($titulo->fn_mostrar_ajustes);
                                                                    print_r($obj->{'titulo'}); ?></span>
            </a>
          </div>
        </li>
        <li>
          <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
            <i class="fa fa-bars"></i>
          </a>
        </li>
      </ul>
    </div>

    <div class="headerbar-right">
      <!-- se implemento la campana de las notificaciones el foreach para leer las notificaciones y un echo de la cantidad que se muestra en caso de que exista notificaciones y una etiqueta a para modificar el estado de la notificacion a leido-->
      <ul class="header-nav header-nav-options">
        <li class="dropdown">
          <a href="javascript:void(0);" class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
            <i class="fa fa-bell"></i><sup class="badge style-danger" id="NumNotificaciones"> <?php foreach ($cantidadN as $cantidad) {
                                                                                                echo $cantidad->ocantnotificaciones;
                                                                                              } ?> </sup>
          </a>
          <ul class="dropdown-menu animation-expand">
            <li class="dropdown-header"><?php foreach ($cantidadN as $cantidad) {
                                          echo $cantidad->ocantnotificaciones;
                                        } ?> Mensajes de Notificaci&oacuten</li>
            <li class="lista_notificaciones">
              <div id="notifications" style="height:57vh; overflow-y:scroll; min-width: 250px;">
                <table class="table table-hover" id="notifi">
                  <thead>
                    <tr class="alert">
                      <th>Nro</th>
                      <th>Detalles</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <div id="data_notifications">
                      <?php $nro = 0;
                      foreach ($lst_noti as $notificacion) {
                        $nro++;
                        if ($notificacion->prioridad == 'ALTA') {
                          $alert = 'alert-danger';
                        }
                        if ($notificacion->prioridad == 'MEDIA') {
                          $alert = 'alert-warning';
                        }
                        if ($notificacion->prioridad == 'BAJA') {
                          $alert = 'alert-success';
                        }
                      ?>
                        <tr class="selected; alert alert-callout <?php echo $alert ?>">
                          <td><?php echo $nro;
                              $id_notificacion = $notificacion->oidnotificacion;
                              $text_notificacion = $notificacion->odetallenotif;
                              ?></td><!-- se agrego el data-toggle y data-target-->
                          <td><button name="notificacion" class="button-notificacion" data-toggle="modal" data-target="#modal_notificaciones" onclick="visto(<?php echo $id_notificacion ?>,'<?php echo $text_notificacion ?>')">
                              <?php echo $text_notificacion ?></button></td>
                          <td><i class="glyphicon glyphicon-check"></i></td>
                        </tr>
                      <?php }  ?>
                    </div>
                  </tbody>
                </table>
              </div>
            </li>

          </ul>
        </li>
      </ul>

      <ul class="header-nav header-nav-profile">
        <li class="dropdown">
          <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
            <?php $foto = $this->session->userdata('foto');
            if (empty($foto)) { ?>
              <img src="<?php echo base_url('assets/img/personal/default-user.png'); ?>" alt="" />
            <?php } else { ?>
              <img src="<?php echo base_url(); ?>assets/img/personal/<?php echo $foto ?>" alt="" />
            <?php } ?>
            <span class="profile-info">
              <?php echo $this->session->userdata('nombre') ?>
              <small><?php echo $this->session->userdata('cargo') ?></small>
            </span>
          </a>
          <ul class="dropdown-menu animation-dock">
            <li class="dropdown-header">Configuraci&oacute;n</li>
            <li id="menuHeader1"><a href="<?= base_url(); ?>perfil">Mi perfil</a></li>
            <li id="menuHeader2"><a href="<?= base_url(); ?>cambio_password">Cambiar Contrase&ntilde;a</a></li>
            <li class="divider"></li>
            <li><a href="<?= base_url(); ?>bloquo_sesion"><i class="fa fa-fw fa-lock"></i> Bloquear</a></li>
            <li><a href="<?= base_url(); ?>logout"><i class="fa fa-fw fa-power-off text-danger"></i> Cerrar sesi&oacute;n</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</header>
<!-- END HEADER-->
<!-- Modal -->
<div class="modal fade modal-notificacion" id="modal_notificaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NOTIFICACI&Oacute;N</h4>
      </div>
      <div class="modal-body">
        <div id="text_modal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- BEGIN BASE-->
<div id="base">
  <!-- BEGIN OFFCANVAS LEFT -->
  <div class="offcanvas">
  </div>
  <!-- END OFFCANVAS LEFT -->

  <!-- BEGIN MENUBAR-->
  <div id="menubar" class="menubar-inverse animate">
    <div class="menubar-scroll-panel">
      <!-- BEGIN MAIN MENU -->
      <ul id="main-menu" class="gui-controls">
        <!-- BEGIN INICIO -->
        <li>
          <a href="<?= base_url(); ?>inicio" id="menu1">
            <div class="gui-icon"><i class="fa fa-home fa-lg"></i></div>
            <span class="title">Dashboard</span>
          </a>
        </li>
        <!-- END INICIO -->

        <!-- BEGIN PRODUCCION -->
        <?php if (in_array("produccion", $permisos)) { ?>
          <li class="gui-folder">
            <a id="menu10">
              <div class="gui-icon"><i class="glyphicon glyphicon-object-align-vertical"></i></div>
              <span class="title">Producci&oacute;n</span>
            </a>
          <?php } ?>
          <ul>
            <?php if (in_array("ingreso_prod", $permisos)) { ?>
              <li><a id="menu10_1" href="<?= base_url(); ?>produccion"><span class="title">Ingreso</span></a></li>
            <?php }
            if (in_array("salida_prod", $permisos)) { ?>
              <li><a id="menu10_2" href="<?= base_url(); ?>salida_produccion"><span class="title">Salida</span></a></li>
            <?php } ?>
          </ul>
          </li>
          <!-- END PRODUCCION -->

          <!-- BEGIN PROVISION -->
          <?php if (in_array("provision", $permisos)) { ?>
            <li class="gui-folder">
              <a id="menu9">
                <div class="gui-icon"><i class="fa fa-truck"></i></div>
                <span class="title">Provisi&oacute;n </span>
              </a>
              <ul>
                <li><a id="menu9_1" href="<?= base_url(); ?>provision"><span class="title">Abastecimiento</span></a></li>
                <li><a id="menu9_2" href="<?= base_url(); ?>almacen"><span class="title">Solicitud de Productos</span></a></li>
                <li><a id="menu9_3" href="<?= base_url(); ?>solicitud"><span class="title">Solicitudes Realizadas</span></a></li>
                <li><a id="menu9_4" href="<?= base_url(); ?>recepciones"><span class="title">Recepción de solicitudes</span></a></li>
                <li><a id="menu9_5" href="<?= base_url(); ?>envio"><span class="title">Envio de producto</span></a></li>
                <li><a id="menu9_6" href="<?= base_url(); ?>conversion"><span class="title">Conversion Paq/Unid.</span></a></li>
                <li><a id="menu9_7" href="<?= base_url(); ?>stock"><span class="title">Stock</span></a></li>
                <!--INICIO GAN-DPR-B5-0373 ALKG 23/03/2023 -->
                <li><a id="menu9_8" href="<?= base_url(); ?>listar_compras"><span class="title">Listado de compras</span></a></li>
                <!--FIN  GAN-DPR-B5-0373 ALKG 23/03/2023 -->
              </ul>
            </li>
          <?php } ?>
          <!-- END PROVISION -->

          <!-- BEGIN PRODUCTOS -->
          <?php if (in_array("producto", $permisos)) { ?>
            <li class="gui-folder">
              <a id="menu2">
                <div class="gui-icon"><i class="fa fa-shopping-cart"></i></div>
                <span class="title">Productos</span>
              </a>
            <?php } ?>
            <ul>
              <?php if (in_array("categoria", $permisos)) { ?>
                <li><a id="menu2_1" href="<?= base_url(); ?>categoria"><span class="title">Categor&iacute;as</span></a></li>
              <?php }
              if (in_array("marca", $permisos)) { ?>
                <li><a id="menu2_2" href="<?= base_url(); ?>marca"><span class="title">Marcas</span></a></li>
              <?php } ?>
              <?php if (in_array("producto_cat", $permisos)) { ?>
                <li><a id="menu2_3" href="<?= base_url(); ?>producto"><span class="title">Productos</span></a></li>
              <?php } ?>
              <?php if (in_array("producto_cat", $permisos)) { ?>
                <li><a id="menu2_4" href="<?= base_url(); ?>importar"><span class="title">Importar</span></a></li>
              <?php } ?>
            </ul>
            </li>
            <!-- END PRODUCTOS -->

            <!-- BEGIN CLIENTES -->
            <?php if (in_array("cliente", $permisos)) { ?>
              <li>
                <a id="menu3" href="<?= base_url(); ?>cliente">
                  <div class="gui-icon"><i class="fa fa-user-secret"></i></div>
                  <span class="title">Clientes</span>
                </a>
              </li>
            <?php } ?>
            <!-- END CLIENTES  -->

            <!-- BEGIN PROVEEDORES -->
            <?php if (in_array("proveedor", $permisos)) { ?>
              <li>
                <a id="menu4" href="<?= base_url(); ?>proveedor">
                  <div class="gui-icon"><i class="fa fa-users"></i></div>
                  <span class="title">Proveedores</span>
                </a>
              </li>
            <?php } ?>
            <!-- END PROVEEDORES  -->

            <!-- BEGIN VENTAS -->
            <?php if (in_array("venta", $permisos)) { ?>
              <li class="gui-folder">
                <a id="menu5">
                  <div class="gui-icon"><i class="fa fa-money"></i></div>
                  <span class="title">Ventas</span>
                </a>
              <?php } ?>
              <ul>
                <?php if (in_array("pedido", $permisos)) { ?>
                  <li><a id="menu5_1" href="<?= base_url(); ?>pedido"><span class="title">Venta en Caja </span></a></li>
                <?php }
                if (in_array("venta_conf", $permisos)) { ?>
                  <li><a id="menu5_2" href="<?= base_url(); ?>venta"><span class="title">Cobro en Caja </span></a></li>
                <?php }
                if (in_array("pedido", $permisos)) { ?>
                  <li><a id="menu5_3" href="<?= base_url(); ?>pedidoCodigo"><span class="title">Venta R&aacute;pida </span></a></li>
                <?php }
                if (in_array("venta_conf", $permisos)) { ?>
                  <li><a id="menu5_4" href="<?= base_url(); ?>listado_ventas"><span class="title">Listado de Ventas </span></a></li>
                <?php } ?>

              </ul>
              </li>
              <!-- END VENTAS -->

              <!-- BEGIN REPORTES -->
              <?php if (in_array("reporte", $permisos)) { ?>
                <li class="gui-folder">
                  <a id="menu6">
                    <div class="gui-icon"><i class="fa fa-bar-chart"></i></div>
                    <span class="title">Reportes</span>
                  </a>
                <?php } ?>
                <ul>
                  <?php if (in_array("rep_ventas", $permisos)) { ?>
                    <li><a id="menu6_1" href="<?= base_url(); ?>reporte_ventas"><span class="title">Reporte de Ventas</span></a></li>
                  <?php } ?>
                  <?php if (in_array("rep_inventarios", $permisos)) { ?>
                    <li><a id="menu6_2" href="<?= base_url(); ?>reporte_inventarios"><span class="title">Reporte de Inventarios</span></a></li>
                  <?php } ?>
                  <?php if (in_array("rep_ventas", $permisos)) { ?>
                    <li><a id="menu6_3" href="<?= base_url(); ?>reporte_abastecimiento"><span class="title">Reporte de Abastecimiento</span></a></li>
                  <?php } ?>
                  <?php if (in_array("rep_ventas", $permisos)) { ?>
                    <li><a id="menu6_4" href="<?= base_url(); ?>reporte_gastos"><span class="title">Reporte de Gastos</span></a></li>
                  <?php } ?>
                  <?php if (in_array("rep_ventas", $permisos)) { ?>
                    <li><a id="menu6_5" href="<?= base_url(); ?>reporte_creditos"><span class="title">Reporte de Ventas a Credito</span></a></li>
                  <?php } ?>
                  <?php if (in_array("rep_ventas", $permisos)) { ?>
                    <li><a id="menu6_6" href="<?= base_url(); ?>reporte_abast_pagar"><span class="title">Reporte de Abast. a Pagar</span></a></li>
                  <?php } ?>
                  <?php if (in_array("rep_ventas", $permisos)) { ?>
                    <li><a id="menu6_7" href="<?= base_url(); ?>reporte_stock"><span class="title">Reporte de Ajuste de Stock</span></a></li>
                  <?php } ?>
                  <?php if (in_array("rep_ventas", $permisos)) { ?>
                    <li><a id="menu6_8" href="<?= base_url(); ?>reporte_produccion"><span class="title">Reporte de Producci&oacute;n</span></a></li>
                  <?php } ?>
                </ul>
                </li>
                <!-- END REPORTES -->

                <!-- BEGIN PROMOCIONES -->

                <li class="gui-folder">
                  <a id="menu11">
                    <div class="gui-icon"><i class="fa fa-ticket"></i></div>
                    <span class="title">Promociones</span>
                  </a>
                  <ul>
                    <li><a id="menu11_1" href="<?= base_url(); ?>promociones"><span class="title">Promociones y descuentos</span></a></li>
                  </ul>
                </li>

                <!-- END PROMOCIONES -->


                <!-- BEGIN GASTOS -->


                <li>
                  <a id="menu7" href="<?= base_url() ?>gastos">
                    <div class="gui-icon"><i class="fa fa-dollar"></i></div>
                    <span class="title">Gastos</span>
                  </a>
                </li>


                <!-- END GASTOS -->

                <!-- BEGIN ADMINISTRACION -->
                <?php if (in_array("administracion", $permisos)) { ?>
                  <li class="gui-folder">
                    <a class="menu" id="menu8">
                      <div class="gui-icon"><i class="md md-settings"></i></div>
                      <span class="title">Administraci&oacute;n</span>
                    </a>
                  <?php } ?>
                  <ul>
                    <?php if (in_array("usuario", $permisos)) { ?>
                      <li><a href="<?= base_url() ?>usuarios" id="menu8_1"><span class="title">Usuario</span></a></li>
                      <li><a href="<?= base_url() ?>ajustes" id="menu8_2"><span class="title">Ajustes</span></a></li>
                      <li><a href="<?= base_url() ?>informacion" id="menu8_3"><span class="title">información</span></a></li>
                      <li><a href="<?= base_url() ?>ubicaciones" id="menu8_4"><span class="title">Ubicaciones</span></a></li>
                      <li><a href="<?= base_url() ?>unidades" id="menu8_5"><span class="title">Unidades</span></a></li>
                      <li><a href="<?= base_url() ?>permiso" id="menu8_6"><span class="title">Permisos</span></a></li>
                    <?php } ?>
                  </ul>
                  </li>
                  <!-- END ADMINISTRACION -->
      </ul>
      <!-- END MAIN MENU -->
      <div class="menubar-foot-panel" style="text-align: center">
        <small class="no-linebreak hidden-folded">
          <span class="opacity-75">Copyright &copy; 2020</span>
        </small>
      </div>
    </div>
    <!--end .menubar-scroll-panel-->
  </div>
  <!--end #menubar-->
  <!-- END MENUBAR -->