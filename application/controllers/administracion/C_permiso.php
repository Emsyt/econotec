<?php 
/* 
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha: 02/09/2022, Codigo: GAN-FR-A1-433,
Descripcion: Creacion del Controlador C_permiso para poder mostrar la vista.
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha: 02/09/2022, Codigo: GAN-FR-A1-433,
Descripcion: Creacion del Controlador C_permiso para poder mostrar la vista.
-------------------------------------------------------------------------------------------------------------------------------
Creador: Melani Alisson Cusi Burgoa Fecha: 28/09/2022, Codigo: GAN-CV-M0-0017,
Descripcion: Se modifico la parte de enviar id 0 en caso de agregar nuevo rol por -1
*/
?>
<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_permiso extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('administracion/M_permiso','permiso');
    }
    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['lib'] = 0;
            $data['datos_log'] = $log;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'administracion/permiso';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function add_update_roles(){
        if ($this->input->post('btn') == 'add') {
            $cont=count(json_decode($_POST['descrip']));
            $descrip = json_decode($_POST['descrip']); 
            $apiesta = json_decode($_POST['apiesta']); 
            $array_datos = array();
            for($i = 0; $i < $cont; $i++){
                if( $apiesta[$i]){
                    $array_datos[] = array('descripcion' => $descrip[$i],'apiestado' => $apiesta[$i]);
                }
            }
            $arry = array(
                'sigla' => $this->input->post('sigla'),
                'descripcion' => $this->input->post('descripcion'),
                "permisos" => $array_datos
            );
            $json=json_encode($arry);
            $idlogin = $this->session->userdata('id_usuario');
            $data = $this->permiso->registrar_modificar_rol(-1, $idlogin, $json);
        
        } elseif ($this->input->post('btn') == 'edit') {
            $id_rol=$this->input->post('idrol');
            $cont=count(json_decode($_POST['descrip']));
            $descrip = json_decode($_POST['descrip']); 
            $apiesta = json_decode($_POST['apiesta']); 
            $array_datos = array();
            for($i = 0; $i < $cont; $i++){
                $array_datos[] = array('descripcion' => $descrip[$i],'apiestado' => $apiesta[$i]);
            }
            $arry = array(
                'sigla' => $this->input->post('sigla'),
                'descripcion' => $this->input->post('descripcion'),
                "permisos" => $array_datos
            );
            $json=json_encode($arry);
            $idlogin = $this->session->userdata('id_usuario');
            $data = $this->permiso->registrar_modificar_rol($id_rol, $idlogin, $json);
            
        }
        //redirect('permiso');
        echo json_encode($data);
    }

    public function lista_roles(){
        $data = $this->permiso-> get_lst_roles();
        echo json_encode($data);
    }

    public function lista_permisos(){
        $data = $this->permiso-> get_lst_permisos();
        echo json_encode($data);
    }

    public function lista_permisos_rol($id_rol){
        $data = $this->permiso-> get_lst_permisos_rol($id_rol);
        echo json_encode($data);
    }

    public function datos_rol($id_rol){
        $data = $this->permiso-> get_datos_rol($id_rol);
        echo json_encode($data);
    }

    public function delete_roles($id_rol){
        $id_login = $this->session->userdata('id_usuario');
        $data= $this->permiso->delete_rol($id_login, $id_rol);
        echo json_encode($data);
    }
}