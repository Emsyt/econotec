<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Ignacio Laquis Camargo Fecha:21/07/2023, GAN-MS-A6-0549,
Descripcion: Se creo el controlador del submodulo Recepcion de Comandas del modulo Ventas.
-------------------------------------------------------------------------------------------------------------------------------
*/
?>
<?php
if (!defined('BASEPATH'))
  exit('Not access system ...');

class C_recepcion_comanda extends CI_Controller {

  public function __construct() {
    parent::__construct();

    //$this->load->model('venta/M_recepcion_comanda', 'recepcion');
  }

  public function index() {
    if ($this->session->userdata('login')) {
      $log['permisos'] = $this->session->userdata('permisos');
      $id_ubicacion = $this->session->userdata('ubicacion');

      $data['lib'] = 0;
      $data['datos_log'] = $log;
      $data['datos_menu'] = $log;
      $data['cantidadN'] = $this->general->count_notificaciones();
      $data['lst_noti'] = $this->general->lst_notificacion();
      $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
      $data['titulo'] = $this->general->get_ajustes("titulo");
      $data['thema'] = $this->general->get_ajustes("tema");
      $data['descripcion'] = $this->general->get_ajustes("descripcion");
      $data['contenido'] = 'venta/recepcion_comanda';
      $usrid = $this->session->userdata('id_usuario');
      $data['chatUsers'] = $this->general->chat_users($usrid);
      $data['getUserDetails'] = $this->general->get_user_details($usrid);
      $this->load->view('templates/estructura', $data);
    } else {
      redirect('logout');
    }
  }
}
