<!DOCTYPE html>
<html lang="es">
  <head>

    <!-- BEGIN STYLESHEETS -->
    <link href="<?= base_url('assets/css/theme-3/bootstrap.css?1422792965'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme-3/materialadmin.css?1425466319'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme-3/font-awesome.min.css?1422529194'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme-3/material-design-iconic-font.min.css?1421434286'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme-3/libs/rickshaw/rickshaw.css?1422792967'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme-3/libs/morris/morris.core.css?1420463396'); ?>" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/libs/select2/select2.css?1424887856">
    <!--  DataTables  -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/libs/DataTables/jquery.dataTables.css?1423553989">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/libs/DataTables/extensions/dataTables.colVis.css?1423553990">
    <!-- Datepicker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'})?>/libs/bootstrap-datepicker/datepicker3.css?1424887858">
    <!-- SweetAlert Alertas Personalizadas -->
    <link href="<?php echo base_url();?>assets/sweetalert-master/sweetalert.css" rel="stylesheet">
    <!-- END STYLESHEETS -->
  </head>

  <style type="text/css">
    body {
      /*background: #a0cee2;  Color presentado en primera prueba*/
      /*background: #009de2;  Color logo robely import*/
      background: rgba(0, 157, 226, 0.3); /* Color logo robely import con opacidad*/
    }

    .centrar {
      width: 100%;
      display: flex;
      justify-content: center;
    }
  </style>

  <body class="menubar-hoverable header-fixed">
  <!-- <body class="menubar-hoverable header-fixed menubar-pin"> -->






        <!-- BOOTSTRAP -->
        <script src="<?= base_url(); ?>assets/js/libs/bootstrap/bootstrap.min.js"></script>

        <script src="<?= base_url(); ?>assets/js/libs/spin.js/spin.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/autosize/jquery.autosize.min.js"></script>

        <!-- Select2 -->
        <script src="<?= base_url(); ?>assets/js/libs/select2/select2.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/select2/select2_locale_es.js"></script>

        <!-- DATATABLES -->
        <!-- <script src="<?= base_url(); ?>assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script> -->

        <!-- DATEPICKER -->
        <script src="<?= base_url(); ?>assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/bootstrap-datepicker/locales/bootstrap-datepicker.es.js"></script>

        <script src="<?= base_url(); ?>assets/js/libs/moment/moment.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/flot/jquery.flot.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/flot/jquery.flot.time.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/flot/jquery.flot.resize.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/flot/jquery.flot.orderBars.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/flot/jquery.flot.pie.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/flot/curvedLines.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/jquery-knob/jquery.knob.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/sparkline/jquery.sparkline.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/d3/d3.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/d3/d3.v3.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/rickshaw/rickshaw.min.js"></script>

        <!-- Plantilla para validaciones -->
        <script src="<?= base_url(); ?>assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>

        <!-- Bootstrap-dialog -->
        <script src="<?= base_url(); ?>assets/js/libs/bootstrap-dialog/bootstrap-dialog.min.js"></script>

        <!-- SweetAlert Alertas Personalizadas -->
        <script src="<?= base_url(); ?>assets/sweetalert-master/sweetalert.min.js"></script>

        <script src="<?= base_url(); ?>assets/js/core/source/App.js"></script>
        <script src="<?= base_url(); ?>assets/js/core/source/AppNavigation.js"></script>
        <script src="<?= base_url(); ?>assets/js/core/source/AppOffcanvas.js"></script>
        <script src="<?= base_url(); ?>assets/js/core/source/AppCard.js"></script>
        <script src="<?= base_url(); ?>assets/js/core/source/AppForm.js"></script>
        <script src="<?= base_url(); ?>assets/js/core/source/AppNavSearch.js"></script>
        <script src="<?= base_url(); ?>assets/js/core/source/AppVendor.js"></script>
        <script src="<?= base_url(); ?>assets/js/core/demo/Demo.js"></script>


           <script src="<?= base_url(); ?>assets/js/core/demo/DemoDashboard.js"></script>


        <!-- FUNCIONES DATATABLES -->
        <script src="<?= base_url(); ?>assets/js/core/demo/DemoTableDynamic.js"></script>

        <!-- FUNCIONES COMPONENTES DE FORMULARIO -->
        <script src="<?= base_url(); ?>assets/js/core/demo/DemoFormComponents.js"></script>

        <!-- FUNCIONES EXTERNAS PROPIAS DE VALIDACION -->
        <script src="<?= base_url(); ?>assets/js/funciones.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>
