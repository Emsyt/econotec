<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_apertura extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cajas/M_apertura', 'apertura');
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
            $data['contenido'] = 'cajas/apertura';
            $usrid = $this->session->userdata('id_usuario');
            $data['usrid'] = $usrid;
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $data['lista_usuarios'] = $this->apertura->get_usuario();
            $data['items'] = $this->apertura->fn_reporte();
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }
    public function datos_apertura(){
        $fecha=$this->input->post('fecha');
        $data = $this->apertura->M_fn_datos_aperturacaja($fecha);
        echo json_encode($data);
    }
    public function registrar_apertura()
    {
        if ($this->input->post('btn') == 0) {
            $saldo = $this->input->post('monto_aper');
            $fecha = $this->input->post('fecha_aper');
            $encargado = $this->input->post('usuario_aper');
            $idlogin = $this->session->userdata('id_usuario');

            $cli_insert = $this->apertura->fn_registrar((int)$idlogin, 0, -1, (float)$saldo, "'{$fecha}'", (int)$encargado);
            echo json_encode($cli_insert);
        } else {
            $idcaja = $this->input->post('id_caja');
            $saldo = $this->input->post('monto_aper');
            $fecha = $this->input->post('fecha_aper');
            $encargado = $this->input->post('usuario_aper');
            $idlogin = $this->session->userdata('id_usuario');

            $cli_insert = $this->apertura->fn_registrar((int)$idlogin, 1, (int)$idcaja, (float)$saldo, "'{$fecha}'", (int)$encargado);
            echo json_encode($cli_insert);
        }
    }

    public function dlt_apertura($id)
    {
        $persdelete = $this->apertura->fn_eliminar((int)$id);
        redirect('apertura');
    }

    public function recuperar($id){
        $data = $this->tarea->fn_datos($id);
        echo json_encode($data);
    }
}
