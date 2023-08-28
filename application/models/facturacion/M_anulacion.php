<?php
class M_anulacion extends CI_Model {

    public function M_listado_facturas_recepcionadas($fecha_inicial,$fecha_fin,$tipofactura){
        $idlogin = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_facturas_recepcionadas($idlogin,'$fecha_inicial'::DATE,'$fecha_fin'::DATE,$tipofactura)");
        return $query->result();
    }

    public function M_datos_facturacion(){
        $idlogin = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_datos_facturacion($idlogin)");
        return $query->result();
    }

    public function M_actualizar_estado_factura($cuf){
        $idlogin = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_actualizar_estado_factura($idlogin,'$cuf')");
        return $query->result();
    }

    public function M_recuperar_nombre($nit){
        $query = $this->db->query("select (COALESCE(cp.nombre_rsocial,'')||
        CASE WHEN cp.apellidos_sigla IS NULL THEN '' ELSE ' '||cp.apellidos_sigla END) nombre_rsocial from cat_personas cp where cp.nit_ci ilike '$nit'");
        return $query->result();
    }

    public function M_nit_emisor(){
        $query = $this->db->query("SELECT cf.nit from cat_facturacion cf where apiestado ilike 'ELABORADO'");
        return $query->result();
    }

}