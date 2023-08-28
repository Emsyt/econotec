<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_cierre extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cajas/M_cierre', 'cierre');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {

            $log['permisos'] = $this->session->userdata('permisos');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'cajas/cierre';
            $usrid = $this->session->userdata('id_usuario');
            $data['usrid'] = $usrid;
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $data['lista_usuarios'] = $this->cierre->get_usuario();
            $data['items'] = $this->cierre->fn_reporte();
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }
    public function datos_cierre(){
        $fecha=$this->input->post('fecha');
        $data = $this->cierre->M_fn_datos_cierrecaja($fecha);
        echo json_encode($data);
    }
    public function registrar_cierre()
    {
        if ($this->input->post('btn') == 0) {
            $saldo = $this->input->post('monto_cierre');
            $monto_chica = $this->input->post('monto_chica');
            $fecha = $this->input->post('fecha_cierre');
            $encargado = $this->input->post('usuario_cierre');
            $idlogin = $this->session->userdata('id_usuario');

            $cli_insert = $this->cierre->fn_registrar((int)$idlogin, 0, -1, (float)$saldo,(float)$monto_chica, "'{$fecha}'", (int)$encargado);
            echo json_encode($cli_insert);
        } else {
            $idcaja = $this->input->post('id_caja');
            $saldo = $this->input->post('monto_cierre');
            $monto_chica = $this->input->post('monto_chica');
            $fecha = $this->input->post('fecha_cierre');
            $encargado = $this->input->post('usuario_cierre');
            $idlogin = $this->session->userdata('id_usuario');

            $cli_insert = $this->cierre->fn_registrar((int)$idlogin, 1, (int)$idcaja, (float)$saldo, (float)$monto_chica, "'{$fecha}'", (int)$encargado);
            echo json_encode($cli_insert);
        }
    }

    public function dlt_cierre($id)
    {
        $persdelete = $this->cierre->fn_eliminar((int)$id);
        redirect('cierre');
    }

    public function recuperar($id){
        $data = $this->tarea->fn_datos($id);
        echo json_encode($data);
    }
}
