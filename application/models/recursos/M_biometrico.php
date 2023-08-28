<?php
/*
-------------------------------------------------------------------------------------------------------------------------------


*/
class M_biometrico extends CI_Model
{

    public function insert_biometrico_masivo($data, $namefile)
    {
        $usucre =  $this->session->userdata('usuario');
        for ($i = 0; $i < sizeof($data[0]); $i++) {
            $c_usuario = $data[0][$i];    // id
            $c_fecha = $data[1][$i];    // Brigada
            $c_hora_ingreso = $data[2][$i];    // login
            $c_hora_salida = $data[3][$i];

            if ($c_usuario != null) {
                $this->db->query("SELECT * FROM fn_insertar_biometrico(0,'$c_usuario','$c_fecha','$c_hora_ingreso','$c_hora_salida','','$namefile','$usucre');");
            }
        }
    }
    public function insert_biometrico_masivo_dat($data, $namefile)
    {
        $usucre =  $this->session->userdata('usuario');
        try {
            $x=sizeof($data['usuario']);
            for ($i = 0; $i < sizeof($data['usuario']); $i++) {
                $c_usuario = $data['usuario'][$i];    // id
                $c_fecha = $data['fecha'][$i];    // Brigada
                $c_hora = $data['hora'][$i];    // login
                $c_dato1 = $data['dato1'][$i];
                $c_dato2 = $data['dato2'][$i];
                $c_dato3 = $data['dato3'][$i];
                $c_dato4 = $data['dato4'][$i];
    
                if ($c_usuario != null) {
                    $this->db->query("SELECT * FROM public.fn_insertar_biometrico(0,'$c_usuario','$c_fecha','$c_hora','$c_dato1','$c_dato2','$c_dato3','$c_dato4','$namefile','$usucre');");
                }
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
        
        
    }

    public function get_lst_archivos_biometrico()
    {
        $usucre =  $this->session->userdata('usuario');
        $query = $this->db->query("SELECT row_number () over(order by nombrearchivo  asc)as nro,* FROM fn_lst_archivos_biometrico('$usucre')");
        return $query->result();
    }
}
