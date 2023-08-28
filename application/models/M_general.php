<?php

/*
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:09/11/2021, GAN-MS-A1-068
  Descripcion: Se modifico para crear la funcion lts_productos_mas_vendidos y lts_productos_menos_vendidos
  
  -------------------------------------------------------------------------------
  Modificado: Fabian Alejandro Candia Alvizuri Fecha:015/11/2021, Codigo: GAN-MS-A1-073
  Descripcion: Se modifico en la funciones de func_auxiliares para corregir el ingreso del dashboard
  
  -------------------------------------------------------------------------------
  Modificado: Fabian Alejandro Candia Alvizuri Fecha:016/11/2021, Codigo: GAN-PN-A4-089
  Descripcion: Se modifico en la funciones de func_auxiliares para corregir el gasto del dashboard

  -------------------------------------------------------------------------------
  Modificado: Milena Rojas Fecha:21/03/2022, Codigo: GAN-MS-A5-134
  Descripcion: Se aumento la funcion get_ajustes para poder modificar el titulos, el logo y los temas del sistema
   
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:21/04/2022, Codigo: GAN-MS-A0-180
  Descripcion: se adiciono las funciontes fechas y lts_ingresos_egresos para los datos del grafico ingreso egreso
  ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:12/05/2022, GAN-FR-A1-219
  Descripcion: Se agregaron funciones globales para el uso del chat
  --------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa  Fecha:30/08/2022, Codigo: GAN-SC-M5-407
  Descripcion: Se añadio la funcion get_papel_size para poder cambiar el precio del producto.
  --------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa  Fecha:28/10/2022, Codigo: GAN-MS-A2-0077
  Descripcion: Se añadio la funcion lst_diez_mejores_clientes para los datos del grafico los 10 mejores clientes.
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:17/11/2022, Codigo: GAN-MS-A7-0108
  Descripcion: Se modifico en la funciones de monto_ingreso y monto_gasto para poder obtener sus valores mediante el mes y año 
   -------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:28/04/2023, Codigo: 
  Descripcion: Se anadio la funcion datos_smtp() para obtner los datos del servidor de correo 
*/
class M_general extends CI_Model {

  public function get_datos_per($id_usr = false){
    if ($id_usr === false) {
        $this->db->select('u.id_usuario, u.id_departamento, u.login, u.carnet, u.nombre, u.paterno, u.materno, u.direccion, u.telefono, u.foto, u.fec_nacimiento, u.correo, u.apiestado, u.genero, u.id_proyecto, u.cargo, d.nombre AS departamento, ub.descripcion ubicacion');
        $this->db->from('seg_usuario u');
        $this->db->join('cat_departamento d', 'd.id_departamento = u.id_departamento');
        $this->db->join('cat_ubicaciones ub', 'ub.id_ubicacion =  u.id_proyecto');

        $query = $this->db->get();
        return $query->result();

    } else {
          $this->db->select('u.id_usuario, u.id_departamento, u.login, u.carnet, u.nombre, u.paterno, u.materno, u.direccion, u.telefono, u.foto, u.fec_nacimiento, u.correo, u.apiestado, u.genero, u.id_proyecto, u.cargo, d.nombre AS departamento, ub.descripcion ubicacion');
          $this->db->from('seg_usuario u');
          $this->db->join('cat_departamento d', 'd.id_departamento = u.id_departamento');
          $this->db->join('cat_ubicaciones ub', 'ub.id_ubicacion =  u.id_proyecto');
          $this->db->where('u.id_usuario',$id_usr);

          $query = $this->db->get();
          return $query->row();
    }
  }

  public function detalle_indicadores($fmes){
    $query = $this->db->query("SELECT * FROM fn_indicadores('$fmes'::date)");
    return $query->row();
  }

  public function monto_ingreso($mes,$anno){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT SUM(ROUND((mi.monto-(COALESCE(mg.monto_total,0)- COALESCE(mg.monto_pagado,0))),2)) TOTAL 
      FROM mov_ingreso mi LEFT JOIN mov_gastos mg  
      ON mi.id_ingreso::text=mg.codigo_gasto
      WHERE EXTRACT(MONTH FROM mi.feccre)=$mes
      AND EXTRACT(YEAR FROM mi.feccre)=$anno
      AND ( mi.apiestado='COBRADO' or mi.apiestado='CANCELADO')
      AND mi.id_ubicacion=(SELECT id_proyecto FROM seg_usuario       
      WHERE id_usuario=$id_usuario)");
    foreach ($query->result() as $row)
    {
      if($row->total != '')
        return $row->total;
      else 
        return 0;
    }
  }

  public function monto_gasto($mes,$anno){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT COALESCE(ROUND(SUM(monto_pagado),2),0) TOTAL 
    FROM mov_gastos 
   WHERE EXTRACT(MONTH FROM feccre) = $mes
     AND EXTRACT(YEAR FROM feccre) = $anno
     AND id_ubicacion=(SELECT id_proyecto 
                         FROM seg_usuario       
                        WHERE id_usuario=$id_usuario)
     AND apiestado NOT ILIKE 'ANULADO'
     AND apiestado NOT ILIKE 'ELIMINADO'");
    foreach ($query->result() as $row)
    {
      if($row->total != '')
        return $row->total;
      else 
        return 0;
    }
  }


  public function detalle_grafico($fmes){
    $query = $this->db->query("SELECT * FROM fn_dashboard('$fmes'::date)");
    return $query->result();
  }

  public function lts_productos_mas_vendidos($fecha){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_productos_mas_vendidos($id_usuario,'$fecha')");
    return $query->result();
  }
  public function lts_ingresos_egresos($fecha){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_ingresos_egresos($id_usuario,'$fecha')");
    return $query->result();
  }
  public function fechas($fecha){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT ofecha FROM fn_ingresos_egresos($id_usuario,'$fecha') where otipo='ingreso'; ");
    return $query->result();
  }
  
  public function lts_productos_menos_vendidos($fecha){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_productos_menos_vendidos($id_usuario,'$fecha')");
    return $query->result();
  }
  public function lst_diez_mejores_clientes($fecha){
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_mejores_clientes($id_usuario,'$fecha')");
    return $query->result();
  }

  // Metodos para las notificaciones
  //Cantidad de notificaciones
  public function count_notificaciones(){
    $id_usuario = $this->session->userdata('usuario');
    $query = $this->db->query("SELECT * FROM fn_notificaciones('admin')");
    return $query->result();
  }

  //listar notificaciones
  function lst_notificacion() {
    $id_usuario = $this->session->userdata('usuario');
    $query = $this->db->query("SELECT * FROM fn_resumen_notificaciones('admin')");
    return $query->result();
  }

  //leer notificacion
  function leer_notificacion($id_not) {
    $query = $this->db->query("SELECT * FROM fn_leer_notificacion($id_not);");
    return $query->row();
  }

  function verificar_hora($hour,$date) {
    $date=str_replace("-","/",$date);
    $query = $this->db->query("SELECT * FROM fn_verificar_hora('$hour','$date');"); 
    return $query->row();
  }
  function verificar_apertura_caja($date) {
    $date=str_replace("-","/",$date);
    $query = $this->db->query("select * from fn_verificar_caja_aperturada('$date');"); 
    return $query->row();
  }

  public function get_ajustes($valor){
    $query = $this->db->query("SELECT * FROM fn_mostrar_ajustes(1,'$valor')");
    return  $query->row();
  }

  public function get_papel_size($idLogin) {
    // GAN-SC-M5-407, 30/08/2022 ACusi.
    $query = $this->db->query("SELECT * FROM fn_get_papel_size($idLogin)");
    return $query->result();
    // FIN GAN-SC-M5-407, 30/08/2022 ACusi.
  }
  //funciones del chat
  public function chat_users($usrid){
    $query = $this->db->query("SELECT cu.descripcion, su.id_usuario,su.login,su.online,su.sesion_actual,su.foto
                              from seg_usuario su,cat_ubicaciones cu 
                              where su.id_proyecto=cu.id_ubicacion and su.id_usuario!=$usrid  order by su.online");
    return $query->result();
  }
  public function get_user_details($usrid){
    $query = $this->db->query("SELECT cu.descripcion, su.id_usuario,su.login,su.online,su.sesion_actual,su.foto
                              from seg_usuario su,cat_ubicaciones cu 
                              where su.id_proyecto=cu.id_ubicacion and su.id_usuario=$usrid");
    return $query->row();
  }
  public function get_user_avatar($usrid){
    $query = $this->db->query("SELECT foto FROM seg_usuario WHERE id_usuario = $usrid");
    return $query->row();
  }
  public function update_user_online($usrid,$online){
    $query = $this->db->query("UPDATE seg_usuario SET online = $online WHERE id_usuario = $usrid");
    
  }
  public function datos_smtp(){
    $query = $this->db->query("SELECT cc.descripcion ,smtp_host ,smtp_port ,smtp_user ,smtp_pass 
                                    FROM cat_facturacion cf,cat_catalogo cc  
                                    WHERE cf.apiestado ilike 'ELABORADO'
                                    and cc.catalogo ='cat_sistema'
                                    and cc.codigo='titulo'");
    return $query->result();
  }
}
