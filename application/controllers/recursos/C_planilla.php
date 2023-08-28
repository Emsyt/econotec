<?php
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Oscar Laura Aguirre Fecha:6/03/2023, Codigo: GAN-DPR-B3-0329,
Descripcion: se creo el diseño del modulo de RECURSOS HUMANOS en el sub modulo de planillas
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_planilla extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('recursos/M_planilla', 'planilla');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'recursos/planilla';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }
}
