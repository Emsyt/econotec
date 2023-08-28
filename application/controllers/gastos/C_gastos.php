<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:24/09/2021, GAN-MS-M6-035
  Descripcion: Se realizaron la modificacion de para la creacion de funciones de las páginas 105 a 108 
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_gastos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('gastos/M_gastos','gastos'); 
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $this->session->userdata('id_usuario');
            $data['lst_gastos'] = $this->gastos->fn_mostrar_gastos($usr);
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'gastos/gastos';
           
            $data['chatUsers'] = $this->general->chat_users($usr);
            $data['getUserDetails'] = $this->general->get_user_details($usr);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function lista_gastos(){
        
      
        // POST data
        $postData = $this->input->post();
   
        // Get data
        $data = $this->gastos->fn_mostrar_gastos1($postData);
   
        echo json_encode($data);
     }
    public function add_gastos(){
        if ($this->input->post('btn') == 'add') {
              $arry = array(
                'descripcion' => $this->input->post('descripcion'),
                'monto' => $this->input->post('monto'),
                'cantidad' => $this->input->post('cantidad'),
              );
              $json=json_encode($arry);
              $idlogin = $this->session->userdata('id_usuario');
              $this->gastos->fn_registrar_gasto(0,$idlogin,$json);

        } elseif ($this->input->post('btn') == 'edit') {
            $id_gasto = $this->input->post('id_gast');
            $arry = array(
                'descripcion' => $this->input->post('descripcion'),
                'monto' => $this->input->post('monto'),
                'cantidad' => $this->input->post('cantidad'),
            );
            $json=json_encode($arry);
            $idlogin = $this->session->userdata('id_usuario');

            $this->gastos->fn_registrar_gasto($id_gasto,$idlogin,$json);
        }
        redirect('gastos');
    }

    public function datos_gasto($id_gasto){
        $data = $this->gastos->fn_recuperar_gasto($id_gasto);
        $lst_recuperar_gasto= $data[0]->fn_recuperar_gasto;
        echo $lst_recuperar_gasto;
    }

    public function dlt_gasto($id_gasto){
        $idlogin = $this->session->userdata('id_usuario');    
        $this->gastos->fn_eliminar_gasto($idlogin,$id_gasto);
        redirect('gastos');
    }
}
