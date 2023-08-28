<?php
/*A
  --------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa  Fecha:09/11/2022, Codigo: GAN-MS-A0-0091
  Descripcion: Se cambio el logo al correspondiente al registro de ajustes
*/
?>
<style>
  #titulo{
    text-align: center;
  }
</style>
<div id="content">
  <section class="section-account" style="padding-top: 5.5%">
    <div class="row" id="titulo">
      <div class="col-xs-14">
        <div class="card-head">
          <img src="assets/img/icoLogo/<?php $obj = json_decode($logo->fn_mostrar_ajustes);
                                                  print($obj->{'logo'}); ?>" class="img-support" alt="Logo Empresa" height="" >
          <h3>BIENVENIDO AL SISTEMA DE GESTIÓN Y ADMINISTRACIÓN DE NEGOCIOS</h3>
        </div>
      </div>
    </div>
  </section>
</div>