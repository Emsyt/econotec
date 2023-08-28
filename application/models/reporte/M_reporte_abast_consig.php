<?php
/*
-----------------------------------------------------------------------------------------------
Creador: Ayrton Jhonny Guevara Montaño Fecha:11/05/2023, Codigo: GAN-MS-A5-078,
Descripcion: Se Realizo el modelo del reporte de compras por consignacion
-----------------------------------------------------------------------------------------------
 */
class M_reporte_abast_consig extends CI_Model {

  public function get_proveedor_cmb() {
    $query = $this->db->query("SELECT * from vw_proveedores");
    return $query->result();
  }
  public function get_lst_deudas_abastecimiento($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_consignacion_abastecimiento($id_usuario,'$json'::JSON)");
   /* $query = $this ->db->query(

      "SELECT ROW_NUMBER() OVER (ORDER BY T3.fecha DESC)::INTEGER,T3.* 
      from
      (
      select DISTINCT ON (T1.id_lote) T1.id_lote, T1.cantidad, T1.fecha from 
          (select mp.id_provision,
          mp.id_lote,
          SUM(mp.cantidad) AS cantidad,
          max(mp.feccre::DATE) AS fecha
          from mov_provision mp
          group by mp.id_lote, mp.id_provision
          ORDER BY mp.id_lote, MAX(mp.feccre::DATE) DESC) AS T1 
          join 
          (SELECT DISTINCT a.*
             FROM
              (SELECT UNNEST(('{' || REPLACE(mg.codigo_gasto, ' | ', ',') || '}')::INTEGER[]) AS id_provision, apiestado
               FROM mov_gastos mg) AS a)as T2 on T1.id_provision = T2.id_provision
               where t2.apiestado like 'EN CONSIGNACION') as T3"
    );*/
    return $query->result();
  }

  public function get_pagar_deuda_abastecimiento($json) {
    $id_usuario = $this->session->userdata('id_usuario');
    $query = $this->db->query("SELECT * FROM fn_pagar_consignacion_abastecimiento($id_usuario, '$json'::json)");
    return $query->result();
  }

  public function get_historial_deuda_consignacion_abastecimiento($codigo, $detalle) {
    $query = $this->db->query("SELECT * FROM fn_historial_deuda_abastecimiento('$codigo', '$detalle')");
    return $query->result();
  }
  
}

