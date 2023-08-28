<?php
class M_apertura extends CI_Model
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

    public function fn_registrar($idlogin, $idtipo, $idcaja, $saldo, $fecha, $encargado)
    {
        $query = $this->db->query("SELECT * FROM fn_registro_apertura($idlogin,$idtipo,$idcaja,$saldo,$fecha,$encargado)");
        return $query->result();
    }

    public function fn_reporte()
    {
        $query = $this->db->query("SELECT * FROM fn_listar_apertura()");
        return $query->result();
    }

    public function fn_eliminar($id)
    {
        $query = $this->db->query("SELECT * FROM fn_eliminar_apertura($id)");
        return $query->result();
    }

    public function fn_datos($id)
    {
        $query = $this->db->query("SELECT * FROM fn_recuperar_apertura($id)");
        return $query->result();
    }
    public function M_fn_datos_aperturacaja($fecha)
    {
        $idlogin= $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT * FROM fn_datos_aperturacaja('$fecha')");
        return $query->result();
    }
}
