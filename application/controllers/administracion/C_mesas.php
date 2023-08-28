<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Ignacio Laquis Camargo Fecha:30/05/2023, Codigo: GAN-MS-M0-0504,
Descripcion: Se creo el controlador del ABM llamado Mesas, el cual cuenta con funciones para la relacion con su Model.
-------------------------------------------------------------------------------------------------------------------------------
*/
?>
<?php
if (!defined('BASEPATH'))
  exit('Not access system ...');

class C_mesas extends CI_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->model('administracion/M_mesas', 'mesas');
  }

  public function index() {
    if ($this->session->userdata('login')) {
      $log['permisos'] = $this->session->userdata('permisos');
      $data['lst_ubicacion'] = $this->mesas->get_lst_ubicacion();
      $id_ubicacion = $this->session->userdata('ubicacion');
      $data['lst_usuarios'] = $this->mesas->get_usuario($id_ubicacion);

      $data['lib'] = 0;
      $data['datos_log'] = $log;
      $data['datos_menu'] = $log;
      $data['cantidadN'] = $this->general->count_notificaciones();
      $data['lst_noti'] = $this->general->lst_notificacion();
      $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
      $data['titulo'] = $this->general->get_ajustes("titulo");
      $data['thema'] = $this->general->get_ajustes("tema");
      $data['descripcion'] = $this->general->get_ajustes("descripcion");
      $data['contenido'] = 'administracion/mesas';
      $usrid = $this->session->userdata('id_usuario');
      $data['chatUsers'] = $this->general->chat_users($usrid);
      $data['getUserDetails'] = $this->general->get_user_details($usrid);
      $this->load->view('templates/estructura', $data);
    } else {
      redirect('logout');
    }
  }

  public function add_update_mesa() {
    if ($this->input->post('btn') == 'add') {
      $id_ubicacion = $this->session->userdata('ubicacion');
      //$id_ubicacion = $this->input->post('ubi_ini');
      $id_usuario = $this->input->post('usuario');
      $mesa = $this->input->post('mesa');
      $this->mesas->insert_mesa($id_ubicacion, $id_usuario, $mesa);
    } else if ($this->input->post('btn') == 'edit') {
      $id_mesa = $this->input->post('id_mesa');
      $id_ubicacion = $this->session->userdata('ubicacion');
      //$id_ubicacion = $this->input->post('ubi_ini');
      $id_usuario = $this->input->post('usuario');
      $mesa = $this->input->post('mesa');
      $this->mesas->modificar_mesa($id_mesa, $id_ubicacion, $id_usuario, $mesa);
    }
    redirect('mesas');
  }

  public function get_lst_ubicacion() {
    $data = $this->mesas->get_lst_ubicacion();
    echo json_encode($data);
  }

  public function lista_mesas() {
    $id_usuario = $this->session->userdata('id_usuario');
    $data = $this->mesas->get_lst_mesas($id_usuario);
    echo json_encode($data);
  }

  public function datos_mesa($id_mesa) {
    $id_usuario = $this->session->userdata('id_usuario');
    $data = $this->mesas->get_datos_mesa($id_usuario, $id_mesa);
    echo json_encode($data);
  }

  public function dlt_mesas($id_mesa) {
    $data = $this->mesas->delete_mesa($id_mesa);
    echo json_encode($data);
  }
}
