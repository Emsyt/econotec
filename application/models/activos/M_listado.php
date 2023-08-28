<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha:22/11/2022   SAM-MS-A7-0002,
Descripcion: Se Realizo el modelo de listado bitacora activos
*/

class M_listado extends CI_Model {
    
    public function mostrar_listado_producto_cod($codigo) {
        $query = $this->db->query("SELECT * FROM fn_mostrar_listado('$codigo')");
        return $query->result();
    }
    public function lts_codigos_bitacora() {
        $query = $this->db->query("SELECT * FROM fn_listar_codigos_bitacora()");
        return $query->result();
    }
}