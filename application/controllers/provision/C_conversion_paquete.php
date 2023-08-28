<?php
/* A
------------------------------------------------------------------------------------------
Creador: Brayan Janco Cahuana Fecha:17/08/2021, Codigo: GAN-FR-A4-018,
Creacion del Controlador C_conversion_paquete para conectar con conversion_paquete 
y M_conversion_paquete por codigo
------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja  Fecha:21/04/2022, Codigo: GAN-MS-A3-182,
Descripcion: Se crearon las funciones get_ubiproducto para mostrar los productos
en los combos de la vista y registrar_conversion para registrar la conversion
 */
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_conversion_paquete extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('provision/M_conversion_paquete','conversion');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $id_ubicacion = $this->session->userdata('ubicacion');
            $login = $this->session->userdata('usuario');

            //$data['lst_solicitudes'] = $this->solicitud->get_lst_solicitud_ubicacion($login);
            $data['lst_ubicaciones'] = $this->conversion->get_lst_ubicaciones();
            $data['lst_unidades'] = $this->conversion->get_lst_unidades();
            $data['lst_conversiones'] = $this->conversion->get_lst_conversiones();
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'provision/conversion_paquete';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function get_ubiproducto(){
        $id_ubicacion = $this->input->post('ubicacion');
        $data = $this->conversion->get_lst_productos_ubi($id_ubicacion);
        echo json_encode($data);
    }
    public function registrar_conversion(){ 
        $id_origen = $this->input->post('ubi_origen');
        $id_destino = $this->input->post('ubi_destino'); 
        $id_producto_origen = $this->input->post('producto_origen');
        $id_producto_destino=$this->input->post('producto_destino');
        $cant_origen=$this->input->post('cant_origen');
        $cant_destino=$this->input->post('cant_destino');
        $login = $this->session->userdata('usuario');
        
        $array = array(
            "id_origen" => $id_origen,
            "id_destino" => $id_destino,
            "id_producto_origen" => $id_producto_origen,
            "id_producto_destino" => $id_producto_destino,
            "cant_origen" => $cant_origen,
            "cant_destino" => $cant_destino,
        
        );

        $json=json_encode($array);
        $reg_conv = $this->conversion->insert_conversion($login,$json);
        echo json_encode($reg_conv);
        redirect('conversion');    
    }
}


