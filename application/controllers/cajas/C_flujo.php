<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_flujo extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();
      $this->load->model('cajas/M_flujo', 'flujo');
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
         $data['contenido'] = 'cajas/flujo';
         $usrid = $this->session->userdata('id_usuario');
         $data['usrid'] = $usrid;
         $data['chatUsers'] = $this->general->chat_users($usrid);
         $data['getUserDetails'] = $this->general->get_user_details($usrid);
         $data['chatUsers'] = $this->general->chat_users($usrid);
         $data['getUserDetails'] = $this->general->get_user_details($usrid);
         $fechaActual = date('Y-m-d');
         $data['items'] = $this->flujo->fn_reporte((int)$usrid, "'{$fechaActual}'");
         $this->load->view('templates/estructura', $data);
      } else {
         redirect('logout');
      }
   }

   public function registrar()
   {
      $fechaActual = date('Y-m-d');
      if ($this->input->post('tipo') == '1') {
         $monto = $this->input->post('monto');
         $descripcion = $this->input->post('descripcion');

         $idusuario = $this->session->userdata('id_usuario');

         $cli_insert = $this->flujo->fn_registrar_ingreso((int)$idusuario, (float)$monto, "'{$descripcion}'","'{$fechaActual}'");
         echo json_encode($cli_insert);
      } else {
         $monto = $this->input->post('monto');
         $descripcion = $this->input->post('descripcion');

         $idusuario = $this->session->userdata('id_usuario');

         $cli_insert = $this->flujo->fn_registrar_gasto((int)$idusuario, (float)$monto, "'{$descripcion}'","'{$fechaActual}'");
         echo json_encode($cli_insert);
      }
   }
}
