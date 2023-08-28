<?php
/* 
------------------------------------------------------------------------------------------
Creado: Alison Paola Pari Pareja Fecha:03/03/2023, Codigo: GAN-DPR-M6-0335,
Se creo el controlador del sub modulo asistencia
 */
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_asistencia extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('recursos/M_asistencia','asistencia');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');

            $data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['id_ubicacion'] = $this->session->userdata('ubicacion');
            $data['lista_usuarios'] = $this->asistencia->get_usuario();
            $data['fecha_imp'] = date('Y-m-d H:i:s');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'recursos/asistencia';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

   
}