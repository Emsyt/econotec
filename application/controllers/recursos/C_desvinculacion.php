<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_desvinculacion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('recursos/M_desvinculacion', 'desvinculacion');
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
            $data['contenido'] = 'recursos/desvinculacion';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
           
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $usr = $this->session->userdata('id_usuario');
            $this->load->view('templates/estructura', $data);
          
        } else {
            redirect('logout');
            
        }
    }
   
}
