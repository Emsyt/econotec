<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_perfil extends CI_Controller {
  function __construct() {
      parent::__construct();
  }

	public function index() {
    if ($this->session->userdata('login')) {
        $id_usr = $this->session->userdata('id_usuario');
        $data['usuario'] = $this->general->get_datos_per($id_usr);

        $data['lib'] = 0;
        $data['datos_menu'] = $this->setpermiso();
        $data['cantidadN'] = $this->general->count_notificaciones();
        $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
        $data['titulo'] = $this->general->get_ajustes("titulo");
        $data['thema'] = $this->general->get_ajustes("tema");
        $data['descripcion'] = $this->general->get_ajustes("descripcion");
        $data['contenido'] = 'perfil/perfil_usuario';

        $data['chatUsers'] = $this->general->chat_users($id_usr);
        $data['getUserDetails'] = $this->general->get_user_details($id_usr);
        $this->load->view('templates/estructura',$data);
    } else {
        redirect('logout');
    }

	}

	    function setpermiso(){
            $login=$this->session->userdata('login');
            if($login) {
                $accesos['permisos'] = $this->session->userdata('permisos');
                return $accesos;
            }
        }
}
