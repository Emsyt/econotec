<?php
class M_cierre extends CI_Model
{
    public function get_usuario()
    {
        $this->db->select('u.id_usuario, u.login,carnet, u.nombre, u.paterno, u.materno, u.direccion, u.telefono, u.correo, u.apiestado, d.abreviatura expedido, ub.descripcion ubicacion');
        $this->db->from('seg_usuario u');
        $this->db->join('cat_departamento d', 'd.id_departamento = u.id_departamento');
        $this->db->join('cat_ubicaciones ub', 'ub.id_ubicacion = u.id_proyecto');
        $this->db->where('u.apiestado', 'ELABORADO');
        $this->db->order_by('u.nombre');
        $query = $this->db->get();
        return $query->result();
    }

    public function fn_registrar($idlogin, $idtipo, $idcaja, $saldo,$monto_chica, $fecha, $encargado)
    {
        $query = $this->db->query("SELECT * FROM fn_registro_cierre($idlogin,$idtipo,$idcaja,$saldo,$monto_chica,$fecha,$encargado)");
        return $query->result();
    }

    public function fn_reporte()
    {
        $query = $this->db->query("SELECT * FROM fn_listar_cierre()");
        return $query->result();
    }
    public function M_fn_datos_cierrecaja($fecha)
    {
        $idlogin= $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_datos_cierrecaja($idlogin,'$fecha')");
        return $query->result();
    }
    public function fn_eliminar($id)
    {
        $idlogin= $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_eliminar_cierre( $idlogin,$id)");
        return $query->result();
    }

    public function fn_datos($id)
    {
        $query = $this->db->query("SELECT * FROM fn_recuperar_apertura($id)");
        return $query->result();
    }
}
