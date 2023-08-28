<!DOCTYPE html>
<html lang="es">
  <head>
    <title><?php print_r(json_decode($descripcion->fn_mostrar_ajustes)->{'descripcion'}); ?></title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Sistema de Inventarios">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
     <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/icoLogo/iconoEmpresa.ico')?>" />
     <!-- <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/> -->

     <!-- BOOTSTRAP -->
     <link type="text/css" rel="stylesheet" href="<?= base_url();?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/bootstrap.css?1422792965" />
     <link type="text/css" rel="stylesheet" href="<?= base_url();?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/materialadmin.css?1425466319" />

     <!-- ICONOS -->
     <link type="text/css" rel="stylesheet" href="<?= base_url();?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/font-awesome.min.css?1422529194" />
     <link type="text/css" rel="stylesheet" href="<?= base_url();?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/material-design-iconic-font.min.css?1421434286" />
     <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css">
     <link rel="stylesheet" href="<?=base_url();?>assets/css/AwesomeMarkers/leaflet.awesome-markers.css">
     <!-- SELECT2 - SELECTOR CON BUSCADOR -->
     <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/libs/select2/select2.css?1424887856" />

     <!-- DATEPICKER - FECHAS -->
		 <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/libs/bootstrap-datepicker/datepicker3.css?1424887858" />

     <!-- DATATABLES - TABLAS -->
     <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/libs/DataTables/jquery.dataTables.css?1423553989" />
     <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
     <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />

     <!-- SWEETALERT - ALERTAS -->
     <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/libs/sweetalert-master/sweetalert.css" />
     <!--Mapas-->
     <link href="<?php echo base_url();?>assets/libs/leaflet/leaflet.css" rel="stylesheet">
     <!--iconos-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
      <!--chat-->
    
    <!-- END STYLESHEETS -->



    <!-- BEGIN JAVASCRIPT -->
     <script src="<?= base_url(); ?>assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
     <script src="<?= base_url(); ?>assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
     <script src="<?= base_url(); ?>assets/js/libs/jquery-ui/jquery-ui.min.js"></script>

     <!-- BOOTSTRAP -->
     <script src="<?= base_url(); ?>assets/js/libs/bootstrap/bootstrap.min.js"></script>
     <script src="<?= base_url(); ?>assets/js/libs/spin.js/spin.min.js"></script>
     <script src="<?= base_url(); ?>assets/js/libs/autosize/jquery.autosize.min.js"></script>

     <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
     <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
     <!-- mapas -->
     <script src="<?= base_url(); ?>assets/libs/leaflet/leaflet.js"></script>
    <!-- END JAVASCRIPT -->
  </head>

  <body class="menubar-hoverable header-fixed">

    
