<?php
/*A
  --------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa  Fecha:09/11/2022, Codigo: GAN-MS-A0-0091
  Descripcion: Se agrego en la funcion index el logo de get_ajustes
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class C_inicial extends CI_Controller {
    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('login')) {
            redirect(base_url());
        }
        $this->load->model(array('M_login' => 'login'));
    }
    public function index(){
        if ($this->session->userdata('login')) {
            $data['lib'] = 0;
            $data['datos_menu'] = $this->setpermiso();
            //la cantidad y listado de notificaciones
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'inicial';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
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