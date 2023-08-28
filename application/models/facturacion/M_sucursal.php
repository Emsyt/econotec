<?php
class M_sucursal extends CI_Model {

    public function M_agregar_modifi_sucursal($json){
        $idlogin    = $this->session->userdata('id_usuario');
        $query      = $this->db->query("SELECT * FROM fn_registrar_sucursal($idlogin,'$json'::JSON)");
        return $query->result();
    }

    public function M_lista_sucursal() {
        $query = $this->db->query("SELECT * FROM fn_listar_sucursal()");
        return $query->result();
    }

    public function M_anular_sucursal($id_sucursal) {
        $idlogin    = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_anular_sucursal($idlogin, $id_sucursal)");
        return $query->result();
    }

    public function M_reactivar_sucursal($id_sucursal) {
        $idlogin    = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_reactivar_sucursal($idlogin, $id_sucursal)");
        return $query->result();
    }

    public function M_informacion_facturacion($id_sucursal) {
        $query = $this->db->query("SELECT * FROM fn_informacion_facturacion($id_sucursal);");
        return $query->result();
    }

    public function M_registrar_cuis($json) {
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_registrar_cuis($id_usuario,'$json'::JSON);");
        return $query->result();
    }

    public function M_datos_iniciales_cuis($id_sucursal){
        $query = $this->db->query("SELECT oc.id_facturacion,
                                        oc.cod_punto_venta,
                                        oc.cod_cuis 
                                    FROM ope_cuis oc 
                                    WHERE oc.apiestado ilike 'ELABORADO' 
                                    AND oc.cod_punto_venta = 0 
                                    AND id_facturacion = (SELECT cf.id_facturacion FROM cat_facturacion cf WHERE apiestado ilike 'ELABORADO')
                                    AND id_sucursal = $id_sucursal;");
        return $query->result();
    }      

    public function M_registrar_cufd($json){
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_registrar_cufd($id_usuario,'$json'::JSON)");
        return $query->result();
    }  

        public function M_credenciales_facturacion($codPuntoVenta,$id_sucursal) {
        $query = $this->db->query("SELECT * FROM fn_credenciales_facturacion($codPuntoVenta,$id_sucursal);");
        return $query->result();
    }

        public function M_gestionar_catalogo_facturacion($json){
        $idlogin= $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_gestionar_catalogo_facturacion($idlogin,'$json'::JSON)");
        return $query->result();
    }

    public function M_datos_iniciales_facturacion(){
        $query = $this->db->query("SELECT cf.cod_token, 
                                          cf.cod_ambiente, 
                                          cf.cod_sistema, 
                                          cf.nit, 
                                          cf.cod_modalidad 
                                     FROM cat_facturacion cf 
                                    WHERE cf.apiestado ilike 'ELABORADO' 
                                    LIMIT 1;");
        return $query->result();
      }
}
