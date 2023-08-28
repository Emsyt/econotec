<?php
/* 
  ------------------------------------------------------------------------------
  Modificado: Saul Imanol Quiroga Castrillo Fecha:13/06/2022, Codigo:GAN-MS-M3-270
  Descripcion: se agrego un previsualizador para la contraseña, adicionando nuevos campos en HTML, style y una nueva funcion en JS denominada prev_password() 
  ------------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa Fecha:04/10/2022, Codigo:GAN-DPR-B5-0031
  Descripcion: se agrego un tamaño por defecto para que se vea esteticamente el nuevo icono de HELPDESK
  */
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <title><?php $obj = json_decode($descripcion->fn_mostrar_ajustes);
          print_r($obj->{'descripcion'}); ?> </title>

  <!-- BEGIN META -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="your,keywords">
  <meta name="description" content="Sistema de Inventarios">
  <!-- END META -->

  <!-- BEGIN STYLESHEETS -->
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/icoLogo/iconoEmpresa.ico') ?>" />

  <!-- BOOTSTRAP -->
  <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'}) ?>/bootstrap.css?1422792965" />
  <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'}) ?>/materialadmin.css?1425466319" />

  <!-- ICONOS -->
  <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'}) ?>/font-awesome.min.css?1422529194" />
  <link type="text/css" rel="stylesheet" href="<?= base_url(); ?>assets/css/<?php print(json_decode($thema->fn_mostrar_ajustes)->{'tema'}) ?>/material-design-iconic-font.min.css?1421434286" />

  <!-- END STYLESHEETS -->

  <style>
    body {
      background: url("<?= base_url('assets/img/backgrounds/fondo.jpg') ?>")no-repeat center center fixed;
      background-size: cover;
      color: #313335;
      -ms-overflow-style: scrollbar;
    }
    .card {
      border-radius: 25px 25px 25px 25px;
      -moz-border-radius: 25px 25px 25px 25px;
      -webkit-border-radius: 25px 25px 25px 25px;
      background: rgba(0, 0, 0, 0.45);
    }

    .card-logo {
      background: rgba(182, 218, 220, 0.6);
      border-radius: 25px 0px 0px 25px;
      -moz-border-radius: 25px 0px 0px 25px;
      -webkit-border-radius: 25px 0px 0px 25px;
      color: #d6e1ea;
      text-align: center;
      font-weight: bold;
    }

    .card-formulario {
      background: rgba(0, 0, 0, 0.5);
      border-radius: 0px 25px 25px 0px;
      -moz-border-radius: 0px 25px 25px 0px;
      -webkit-border-radius: 0px 25px 25px 0px;
    }

    /* moviles */
    @media screen and (max-width:640px) {
      .section-account {
        padding: 8%;
      }

      .card-logo {
        width: 100%;
        padding: auto;
        text-align: center;
        -moz-border-radius: 25px 25px 0px 0px;
        -webkit-border-radius: 25px 25px 0px 0px;
      }

      .card-head header {
        font-size: 30px;
        padding-top: 10;
        line-height: 35px;
      }

      .card-head p {
        font-size: 15px;
        line-height: 30px;
        font-weight: normal;
      }

      .card-formulario {
        width: auto;
        height: auto;
        -moz-border-radius: 0px 0px 25px 25px;
        -webkit-border-radius: 0px 0px 25px 25px;
      }

      .form img {
        height: 210px;
        width: 60%;
      }
      .soporte img{
        height: 52px;
        width: 52px;
      }
    }

    /* tablets y laptops */
    @media screen and (max-width:1024px) and (min-width:640px) {

      .card-logo {
        width: 100%;
        height: auto;
        padding: auto;
        text-align: center;
        -moz-border-radius: 25px 25px 0px 0px;
        -webkit-border-radius: 25px 25px 0px 0px;
      }  

      .card-head header {
        font-size: 30px;
        padding-top: 20;
        line-height: 45px;
        line-height: 35px;
      }

      .card-head p {
        font-size: 20px;
        padding-top: 2%;
        font-weight: normal;
      }

      .card-formulario {
        width: auto;
        height: auto;
        -moz-border-radius: 0px 0px 25px 25px;
        -webkit-border-radius: 0px 0px 25px 25px;
      }

      .form img {
        height: 0.1%;
        width: 50%;
      }

      .imagen {
        margin-left: 130px;
        height: 20%;
        width: 60%;
      }
      .soporte img{
        height: 52px;
        width: 52px;
      }
    }

    /* computadora de escritorio */
    @media screen and (min-width:1024px) {
      .card-logo {
        width: 40%;
        -moz-border-radius: 25px 25px 0px 0px;
        -webkit-border-radius: 25px 0px 0px 25px;
      }

      .card-head header {
        font-size: 30px;
        padding-top: 55%;
        line-height: 35px;
        padding: 55% 0px 0px;
      }

      .card-head p {
        font-size: 25px;
        line-height: 35px;
        padding-top: 10%;
        font-weight: normal;
      }

      .card-formulario {
        width: auto;
        height: auto;
        -moz-border-radius: 0px 0px 25px 25px;
        -webkit-border-radius: 0px 25px 25px 0px;
      }

      .form img {
        height: 20%;
        width: 60%;
      }
      .soporte img{
        height: 52px;
        width: 52px;
      }
    }

    .password-icon {
      float: right;
      position: relative;
      margin: -25px 10px 0 0;
      cursor: pointer;
      z-index: 10;
    }

  </style>
</head>

<body class="menubar-hoverable header-fixed ">
  <section class="section-account" style="padding-top: 4.5%">

    <div class="card contain-sm">
      <div class="card-tiles">
        <div class="hbox-md col-xs-14 col-sm-14 col-md-14 col-lg-14">
          <!-- BEGIN IMAGEN -->
          <div class="hbox-column col-xs-14 col-sm-14 col-md-5 col-lg-5 card-logo">


            <div class="row">
              <div class="col-xs-14">
                <div class="card-head">
                  <header>GESTION DE ADMINISTRACIÓN DE NEGOCIOS</header>
                  <p><?php $obj = json_decode($descripcion->fn_mostrar_ajustes);
                      print_r($obj->{'descripcion'}); ?></p>
                </div>
              </div>
            </div>
          </div>
          <!-- END IMAGEN -->

          <!-- BEGIN FORMULARIO -->
          <div class="hbox-column col-xs-14 col-sm-14 col-md-9 col-lg-9 card-formulario">
            <div class="row justify-content-center">
              <div class="col-xs-14">
                <form class="form form-validate floating-label" novalidate="novalidate" name="form_login" method="post" action="<?= base_url(); ?>verficar">

                  <div class="row imagen" align="center" style="padding-top: 10px">
                    <img src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes);
                                                  print($obj->{'logo'}); ?>" alt="" height="">
                  </div>
                  <div class="card-body form-inverse">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-user fa-2x" style="color: #a6cded"></span></span>
                          <div class="input-group-content">
                            <input type="text" class="form-control" name="usuario" id="usuario" required>
                            <label for="usuario" style="color:#a6cded; font-weight: 700">Usuario</label>
                          </div>
                        </div>
                      </div>

                      <div class="form-group ">
                        <div class="input-group">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-lock fa-2x" style="color: #a6cded"></span></span>
                          <div class="input-group-content">
                            <input type="password" class="form-control" name="password" id="password" required>
                            <label for="password" style="color:#a6cded; font-weight: 700">Contraseña</label>
                            <span class="fa fa-fw fa-eye password-icon show-password" style="color:#a6cded;" id="password-icon" onclick="prev_password()"></span>
                          </div>
                        </div>
                      </div>

                      <div class="control-group error">
                        <div align="center">
                          <label class="control-label" style="color:#de5050">
                            <strong><?php if (isset($error)) echo  $error; ?></strong>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-3 soporte">
                    <a href="https://help.econotec.com.bo" target="_blank"><img src="assets/img/icoLogo/helpdesk.png" class="img-support" alt="Soporte"></a>
                  </div>
                  <div class="col-lg-4"></div>
                  <button type="submit" class="btn ink-reaction btn-primary">Ingresar</button>
                </form>
              </div>
            </div>
          </div>
          <!-- END FORMULARIO -->
        </div>
      </div>
    </div>
  </section>


  <!-- BEGIN JAVASCRIPT -->
  <script src="<?= base_url(); ?>assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/libs/jquery-ui/jquery-ui.min.js"></script>

  <!-- BOOTSTRAP -->
  <script src="<?= base_url(); ?>assets/js/libs/bootstrap/bootstrap.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/libs/spin.js/spin.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/libs/autosize/jquery.autosize.min.js"></script>

  <!-- SCRIPTS PARA CARGA DE LIBRERIAS -->
  <script src="<?= base_url(); ?>assets/js/core/source/App.js"></script>
  <script src="<?= base_url(); ?>assets/js/core/source/AppNavigation.js"></script>
  <script src="<?= base_url(); ?>assets/js/core/source/AppOffcanvas.js"></script>
  <script src="<?= base_url(); ?>assets/js/core/source/AppCard.js"></script>
  <script src="<?= base_url(); ?>assets/js/core/source/AppForm.js"></script>
  <script src="<?= base_url(); ?>assets/js/core/source/AppNavSearch.js"></script>
  <script src="<?= base_url(); ?>assets/js/core/source/AppVendor.js"></script>
  <script src="<?= base_url(); ?>assets/js/core/demo/Demo.js"></script>

  <!-- SCRIPT PARA PREVISUALIZAR LA CONTRASEÑA-->
  <script>
    function prev_password() {
      let showPassword = document.querySelector('.show-password');
      let password = document.getElementById('password');
      if (password.type === "text") {
        password.type = "password";
        showPassword.classList.remove('fa-eye-slash');
      } else {
        password.type = "text";
        showPassword.classList.toggle("fa-eye-slash");
      }
    }
  </script>
  <!-- END JAVASCRIPT -->

</body>

</html>