<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Creador: karen quispe chavez Fecha:01/08/2022, Codigo: GAN-MS-A1-333,
Descripcion: Se creo el controlador del ABM llamado recepcion de pedidos, el cual muestra su respectivo formulario 
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Keyla Paola Usnayo Aguilar    Fecha:29/09/2022,     Codigo: GAN-MS-M0-0013,
Descripcion: Se modifico la funcion index() para que en la URL se muestre el nombre registrado en ajustes
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_recepcion_pedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('provision/M_recepcion_pedidos','recepcion');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $id_ubicacion = $this->session->userdata('ubicacion');
            $login = $this->session->userdata('usuario');
            $id_usuario = $this->session->userdata('id_usuario'); 
           
            $data['listar_recepciones'] = $this->recepcion->get_lst_solicitud_recepcion($id_usuario);

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'provision/recepcion_pedidos';
           
            $data['chatUsers'] = $this->general->chat_users($id_usuario);
            $data['getUserDetails'] = $this->general->get_user_details($id_usuario);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function cambia_estado(){
        $array = $this->input->post('array');
        $array = json_encode($array);
        $array = str_replace('"', '', $array);

        $array2 = $this->input->post('array2');
        $array2 = json_encode($array2);
        $array2 = str_replace('"', '', $array2);

        $data = $this->recepcion->confirmar_cambio($array, $array2);
        echo json_encode($data);

    }
    public function dlt_recepcion($id_lote){
        $data = $this->recepcion->eliminar_recepcion($id_lote);
        echo json_encode($data);
    }

    public function lst_solicitud_recepcion(){
        $lote = $this->input->post('idlote');
        $data = $this->recepcion->get_conf_solicitud($lote);
        echo json_encode($data);
    }

    public function lista_pedidos(){
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $id_ubicacion = $this->session->userdata('ubicacion');
            $login = $this->session->userdata('usuario');
            $id_usuario = $this->session->userdata('id_usuario'); 
            $lote = $this->input->post('id_lote');
            //$data['lista_pedidos'] = $this->recepcion->get_conf_solicitud($lote);
            $data['id_lote'] = $this->input->post('id_lote');
            $data['nro'] = $this->input->post('nro');
            $data['ode'] = $this->input->post('ode');
            $data['oa'] = $this->input->post('oa');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'provision/listado_recepcion';
           
            $data['chatUsers'] = $this->general->chat_users($id_usuario);
            $data['getUserDetails'] = $this->general->get_user_details($id_usuario);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function get_lst_solicitud(){
        $lote = $_COOKIE["lote"];
        $data = $this->solicitud->get_conf_solicitud($lote);
        echo json_encode($data);
    }

    
}