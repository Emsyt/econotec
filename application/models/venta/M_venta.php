<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:14/09/2021, Codigo: GAN-MS-A4-028
  Descripcion: Se modifico para crear la funcion  get_lst_nota_venta que devuelve una lista en formato JSON
  ------------------------------------------------------------------------------
  Modificado: Jesus Mendoza Viscarra Fecha:25/11/2021, Codigo: GAN-MS-A6-103
  Descripcion: Se modifico los parametros al momento de actualizar al cobrar para que el fecmod tenga la fecha
               del cobro y el id tipo corresponde a contado
  ------------------------------------------------------------------------------
  Modificado: Daniel Castillo Quispe     Fecha: 12/05/2022    Código: GAN-SC-A4-232
  Descripción: Se agregó el INSERT a las notificaciones cuando la cantidad de algún producto es menor a la
               cantidad mínima de existencia. Esto cuando se confirma un pedido.
   ------------------------------------------------------------------------------
  Modificado: Gabriela Mamani Choquehuanca     Fecha: 09/08/2022    Código: GAN-MS-A1-330
  Descripción: Se modifico la funcion get_producto_cmb para que ya no se tome en cuanta el atributo id_relacion
  en ningun select 
     ------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar     Fecha: 29/08/2022    Código: GAN-SC-M5-403
  Descripción: Se modifico la funcion get_producto_cmb para llamar a la funcion del databrach fn_get_productos_plataforma
  en ningun select 
  ---------------------------------------------------------------------------------------------------------
  Modificado:  Pedro Rodrigo Beltran Poma.   Fecha:29/08/2022,   Codigo: GAN-SC-M5-405,
  Descripcion: Se reemplazo el query en insert_garantia()  por la funcion fn_insert_garantia() que realiza  un insert
  en la tabla mov_garantia.
  ------------------------------------------------------------------------------
  Modificado: Deivit Pucho Aguilar  Fecha:30/08/2022,   Codigo: GAN-MS-M5-411,
  Descripcion: Se modifico la funcion confirmar_pedido para reemplazar el query por una funcion.
  ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja  Fecha:17/11/2022,   Codigo: GAN-MS-A4-0061,
  Descripcion: Se modifico la funcion confirmar_venta para hacer el update en mov_movimiento .
*/
class M_venta extends CI_Model
{

  public function get_producto_cmb()
  {
    //GAN-SC-M5-403, 29-08-2022, Luis Fabricio Pari Wayar.
    $ID_UBICACION = $this->session->userdata('ubicacion');
    $query = $this->db->query(" SELECT * FROM fn_get_productos_plataforma($ID_UBICACION)");
    return $query->result();
    // FINGAN-SC-M5-403, 29-08-2022, Luis Fabricio Pari Wayar.
  }

  public function get_datos_producto($id_producto)
  {
    $id_ubicacion = $this->session->userdata('ubicacion');
    $query = $this->db->query("SELECT * FROM fn_buscar_producto($id_producto, $id_ubicacion)");
    return $query->row();
  }

  public function get_cliente_cmb()
  {
    $query = $this->db->query("SELECT * FROM vw_clientes");
    return $query->result();
  }

  public function insert_pedido($data)
  {
    $this->db->insert('mov_venta', $data);
    return $this->db->affected_rows();
  }

  public function get_lst_pedido_lote($id_ubicacion)
  {
    $query = $this->db->query("SELECT mv.id_lote, mv.id_persona, mv.factura, mv.usucre vendedor,
      case when cpe.nombre_rsocial is null and cpe.apellidos_sigla is null
        THEN 'Sin Cliente'
        ELSE
          (coalesce(cpe.nombre_rsocial, '')|| ' ' ||coalesce(cpe.apellidos_sigla, ''))
      END
      cliente, string_agg(cp.descripcion,', ') productos
      FROM mov_venta mv
      JOIN cat_producto cp ON mv.id_producto = cp.id_producto
      LEFT JOIN cat_personas cpe ON mv.id_persona = cpe.id_personas
      WHERE mv.apiestado = 'PEDIDO' AND mv.id_ubicacion = $id_ubicacion
      GROUP BY mv.id_lote, mv.id_persona, cpe.nombre_rsocial, cpe.apellidos_sigla, mv.factura, mv.usucre
      ORDER BY mv.id_lote ");
    return $query->result();
  }

  public function get_lst_pedido_lote_ant($id_ubicacion)
  {
    $query = $this->db->query("SELECT mv.id_lote, mv.id_persona, mv.factura, (coalesce(cpe.nombre_rsocial, '')|| ' ' ||coalesce(cpe.apellidos_sigla, '')) cliente, string_agg(cp.descripcion,', ') productos
      FROM mov_venta mv
      JOIN cat_producto cp ON mv.id_producto = cp.id_producto
      JOIN cat_personas cpe ON mv.id_persona = cpe.id_personas
      WHERE mv.apiestado = 'PEDIDO' AND mv.id_ubicacion = $id_ubicacion
      GROUP BY mv.id_lote, mv.id_persona, cpe.nombre_rsocial, cpe.apellidos_sigla, mv.factura
      ORDER BY mv.id_lote ");
    return $query->result();
  }

  public function get_conf_pedido($id_lote)
  {
    $ubicacion = $this->session->userdata('ubicacion');
    $query = $this->db->query("SELECT a.id_venta,a.id_lote,
    CASE WHEN (b.nombre_rsocial||' '||b.apellidos_sigla) IS NULL OR TRIM(b.nombre_rsocial||' '||b.apellidos_sigla)=''
    THEN 'SIN CLIENTE'
    ELSE
    b.nombre_rsocial||' '||b.apellidos_sigla END cliente, b.id_personas,
    a.id_producto,a.codigo,a.descripcion producto,a.cantidad,a.precio,a.fecha,a.hora,
    CASE WHEN a.factura=0 THEN 'Sin Factura'
    ELSE 'Con Factura' END factura
    from
    (
    select mv.id_producto,cp.codigo,mv.id_lote,mv.id_venta,cp.descripcion,mv.id_persona,mv.cantidad,mv.precio,mv.feccre::date fecha,to_char(mv.feccre, 'HH24:MI:SS')hora,mv.factura
    from mov_venta mv,
    cat_producto cp
    where mv.apiestado='PEDIDO' and mv.id_ubicacion=$ubicacion and mv.id_lote=$id_lote and cp.apiestado<>'ANULADO' and mv.id_producto=cp.id_producto
    )a left join
    (
    select * from cat_personas
    )b
    on a.id_persona=b.id_personas");
    return $query->result();
  }
  public function update_venta($id_lote)
  {
    $ubicacion = $this->session->userdata('ubicacion');
    $usuario= $this->session->userdata('usuario');
    $resp = $this->db->query("SELECT * FROM fn_uppdate_venta_lote($ubicacion,'$usuario',$id_lote)");
    return $resp->result();
  }
  public function get_conf_cobrado($id_lote)
  {
    $ubicacion = $this->session->userdata('ubicacion');
    $query = $this->db->query("select mv.id_venta
    from mov_venta mv
    where mv.apiestado='COBRADO' and mv.id_ubicacion=$ubicacion and mv.id_lote=$id_lote");
    return $query->result();
  }

  public function get_precio_total($id_lote, $id_ubicacion)
  {
    if ($id_lote == NULL) {
      $query = $this->db->query("SELECT sum(mv.precio::numeric) AS total_pedido
        FROM MOV_VENTA MV
        JOIN cat_producto CP ON MV.id_producto=CP.id_producto
        WHERE MV.APIESTADO='PEDIDO' AND MV.ID_LOTE=0 AND mv.id_ubicacion = $id_ubicacion ");
      return $query->row('total_pedido');
    } else {
      $query = $this->db->query("SELECT sum(mv.precio::numeric) AS total_pedido
        FROM MOV_VENTA MV
        JOIN cat_producto CP ON MV.id_producto=CP.id_producto
        WHERE MV.APIESTADO='PEDIDO' AND MV.ID_LOTE=$id_lote AND mv.id_ubicacion = $id_ubicacion ");
      return $query->row('total_pedido');
    }
  }

  public function get_conf_pedido_proporcionado()
  {
    $ubicacion = $this->session->userdata('ubicacion');
    $query = $this->db->query("SELECT a.id_venta,a.id_lote,
      CASE WHEN (b.nombre_rsocial||' '||b.apellidos_sigla) IS NULL OR TRIM(b.nombre_rsocial||' '||b.apellidos_sigla)=''
      THEN 'SIN CLIENTE'
      ELSE
      b.nombre_rsocial||' '||b.apellidos_sigla END cliente,
      a.descripcion producto,a.cantidad,a.precio,a.fecha,a.hora,
      CASE WHEN a.factura=0 THEN 'Sin Factura'
      ELSE 'Con Factura' END factura
      from
      (
      select mv.id_lote,mv.id_venta,cp.descripcion,mv.id_persona,mv.cantidad,mv.precio,mv.feccre::date fecha,to_char(mv.feccre, 'HH24:MI:SS')hora,mv.factura
      from mov_venta mv,
      cat_producto cp
      where mv.apiestado='PEDIDO' and mv.id_ubicacion=$ubicacion and cp.apiestado<>'ANULADO' and mv.id_producto=cp.id_producto
      )a left join
      (
      select * from cat_personas
      )b
      on a.id_persona=b.id_personas ");
    return $query->result();
  }

  public function get_lote()
  {
    $ubicacion = $this->session->userdata('ubicacion');
    $query = $this->db->query("SELECT mv.id_lote lote from mov_venta mv, cat_producto cp where mv.apiestado='PEDIDO' and mv.id_ubicacion=$ubicacion and cp.apiestado<>'ANULADO' and mv.id_producto=cp.id_producto group by mv.id_lote ");
    return $query->row('lote');
  }

  public function confirmar_venta($id_lote, $total)
  {
    $id_ubicacion = $this->session->userdata('ubicacion');
    $login = $this->session->userdata('usuario');
    $this->db->trans_start();

    $this->db->query("UPDATE mov_inventario SET cantidad=query.nueva_cantidad,fecmod = NOW()
      FROM (
        SELECT mi.id_inventario,mi.id_producto,mi.cantidad,mv.cantidad,mi.cantidad-mv.cantidad nueva_cantidad
        FROM mov_inventario mi
        JOIN mov_venta mv ON mi.id_producto=mv.id_producto AND mi.id_ubicacion=mv.id_ubicacion
        where mi.id_ubicacion =$id_ubicacion
        AND mv.apiestado='PEDIDO'
        AND mv.id_lote=$id_lote
      ) AS query
      WHERE query.id_inventario=mov_inventario.id_inventario ");
    //Actualizamos mov_movimiento
    $this->db->query("UPDATE mov_movimiento mm SET cantidad_destino=mi.cantidad,
                                                    apiestado = 'ELABORADO',
                                                    fecmod = NOW(),
                                                    usumod = '$login'
                                                from mov_inventario mi
                                                where mi.id_producto=mm.id_producto
                                                and mi.id_ubicacion=$id_ubicacion
                                                and mm.ubi_fin = $id_ubicacion
                                                AND mm.ubi_ini = $id_ubicacion
                                                AND mm.apiestado LIKE 'PENDIENTE'
                                                and mm.id_lote=$id_lote
                                                AND mm.usucre = '$login' ");
    // INICIO DCastillo, GAN-SC-A4-232, 12/05/2022
    // Se inserta la notificación en caso de que algún producto tenga una cantidad menor a la existencia mínima
    $this->db->query("INSERT INTO ope_notificaciones (id_ubicacion,id_rol,notificacion,usucre,apiestado,prioridad)
    SELECT mi.id_ubicacion, 
           (SELECT id_rol FROM seg_rol WHERE sigla = 'ADM'), 
           'Ya sólo existe(n) '||mi.cantidad||' unidad(es) del producto '||(SELECT descripcion FROM cat_producto WHERE id_producto = mi.id_producto),
           '$login',
           'ELABORADO',
           'ALTA'
      FROM mov_inventario mi
      JOIN mov_venta mv ON mi.id_producto=mv.id_producto AND mi.id_ubicacion=mv.id_ubicacion
     WHERE mi.cantidad < (SELECT descripcion::integer 
                            FROM cat_catalogo 
                           WHERE catalogo ILIKE '%cat_sistema%'
                             AND codigo='min_existencia') 
       AND mi.apiestado = 'ELABORADO'
       AND mi.id_ubicacion =$id_ubicacion
       AND mv.apiestado='PEDIDO'
       AND mv.id_lote=$id_lote;");
    // FIN DCastillo, GAN-SC-A4-232, 12/05/2022
    $this->db->query("UPDATE MOV_VENTA MV
            SET
            apiestado='COBRADO',
            --JMendoza, GAN-MS-A6-103 , 25/11/2021
            id_tipo = (select id_catalogo from cat_catalogo where catalogo = 'cat_tipos_ventas' AND codigo = 'CONT'),
            fecmod = NOW(),
            usumod ='$login'
            --FIN GAN-MS-A6-103
            WHERE
            MV.ID_UBICACION=$id_ubicacion AND MV.APIESTADO='PEDIDO' AND MV.ID_VENTA IN
            (
            Select id_venta from mov_venta where apiestado='PEDIDO' AND id_ubicacion=$id_ubicacion
            ) AND MV.ID_LOTE=$id_lote ");

    $data = array(
      'id_ubicacion' => $id_ubicacion,
      'codigo_ingreso' => $id_lote,
      'detalle' => 'VENTA',
      'monto' => $total,
      'usucre' => $login,
      'apiestado' => 'COBRADO'
    );
    $this->db->insert('mov_ingreso', $data);

    $this->db->trans_complete();
    return $this->db->trans_status() === FALSE ? FALSE : TRUE;
  }

  public function insert_garantia($data)
  {
    // GAN-SC-M5-405, 29/08/2022, PBeltran
    $vId_venta = $data[0];
    $vId_producto = $data[1];
    $vId_cliente = $data[2];
    $vSerie = $data[3];
    $vDetalle = $data[4];
    $vfecfin = $data[5];
    $vUsucre  = $data[6];
    $query = $this->db->query("SELECT * FROM fn_insert_garantia($vId_venta, $vId_producto, $vId_cliente, '$vSerie', '$vDetalle', '$vfecfin', '$vUsucre');");
    return $query->result();
    // FIN GAN-SC-M5-405, 29/08/2022, PBeltran
  }

  public function delete_pedido($id_ped, $data)
  {
    $this->db->where('id_venta', $id_ped);
    $this->db->update('mov_venta', $data);
    return $this->db->affected_rows();
  }

  public function confirmar_pedido()
  {
    $ID_UBICACION = $this->session->userdata('ubicacion');
    $LOGIN = $this->session->userdata('usuario');
    // GAN-SC-M5-411 30/08/2022 Deivit Pucho
    $query = $this->db->query("SELECT * FROM fn_confirmar_pedido_venta($ID_UBICACION,'$LOGIN')");
    // Fin GAN-SC-M5-411 30/08/2022 Deivit Pucho
    return $this->db->affected_rows();
  }

  public function get_producto()
  {
    $this->db->select('p.id_producto, p.id_categoria, p.id_marca, p.codigo, p.descripcion producto, p.caracteristica, p.apiestado apiestado_prod, c.descripcion categoria, m.descripcion marca');
    $this->db->from('cat_producto p');
    $this->db->join('cat_categoria c', 'c.id_categoria = p.id_categoria');
    $this->db->join('cat_marca m', 'm.id_marca = p.id_marca');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_lst_nota_venta($id_usuario, $id_venta)
  {
    $query = $this->db->query("SELECT * FROM fn_nota_venta($id_usuario,$id_venta,0)");
    return $query->result();
  }
  public function eliminar_confirmar_venta($id_venta)
  {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_eliminar_confirmar_venta($id_usuario,$id_venta)");
    return $query->result();
  }

  /* GAN */

  public function agregarproductos_ventafacturada($productos)
  {
    foreach ($productos as $producto) {
      $valor = $producto->codigo;
      $id_usuario = $this->session->userdata('id_usuario');
      //GAN-MS-M5-0034 06/10/2022 GValverde.
      $x="SELECT * FROM fn_mostrar_producto_v3($id_usuario,'$valor')";
      $query = $this->db->query("SELECT * FROM fn_mostrar_producto_v3($id_usuario,'$valor')");
    }
    return true;
  }
}
