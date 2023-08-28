<?php
/* A
------------------------------------------------------------------------------------------
Creador: Aliso Paola Pari Pareja Fecha:18/11/2022, GAN-MS-A7-0111,
Creacion del Controlador C_retorno para conectar con retorno y M_retorno con sus respectivas funciones
------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:09/12/2022   GAN-MS-A5-0177,
Descripcion: Se Realizo y/o modifico el funcionamiento garantia ejecucion, registro y retorno 
considerando ya el numero de serie
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_retorno extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('garantias/M_retorno','retorno');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $data['proveedores'] = $this->retorno->get_proveedor_cmb();
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['fecha_imp'] = date('Y-m-d H:i:s');
           
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'garantias/retorno';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function get_retorno() {
        $id_proveedor=$this->input->post('id_proveedor');
        $data = $this->retorno->M_get_retorno($id_proveedor);
        echo json_encode($data); 
    
    }
    public function realizar_retorno() {
        $id_lotes=$this->input->post('lotes');
        $data = $this->retorno->M_realizar_retorno($id_lotes);
        echo json_encode($data); 
    
    }

}
