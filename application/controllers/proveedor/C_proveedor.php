<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_proveedor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('proveedor/M_proveedor','proveedor');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['lst_proveedores'] = $this->proveedor->get_proveedor();

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['contenido'] = 'proveedor/proveedor';
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function lista_proveedores(){
     
        // POST data
        $postData = $this->input->post();
   
        // Get data
        $data = $this->proveedor->get_proveedor1($postData);
   
        echo json_encode($data);
     }
    public function add_update_proveedor(){
        if ($this->input->post('btn') == 'add') {
              $data = array(
                'id_catalogo' => 1274,
                'nombre_rsocial' => $this->input->post('razon_social'),
                'apellidos_sigla' => $this->input->post('sigla'),
                'nit_ci' => $this->input->post('nit'),
                'movil' => $this->input->post('tel_movil'),
                'usucre' => $this->session->userdata('usuario')
              );
              $prov_insert = $this->proveedor->insert_proveedor($data);
                if ($prov_insert) {
                    $this->session->set_flashdata('success','Registro insertado exitosamente.');
                } else {
                    $this->session->set_flashdata('error','Error al insertar Registro.');
                }
        } elseif ($this->input->post('btn') == 'edit') {
              $data = array(
                'nombre_rsocial' => $this->input->post('razon_social'),
                'apellidos_sigla' => $this->input->post('sigla'),
                'nit_ci' => $this->input->post('nit'),
                'movil' => $this->input->post('tel_movil'),
                'usumod' => $this->session->userdata('usuario'),
                'fecmod' => date('Y-m-d H:i:s')
              );
              $prov_update = $this->proveedor->update_proveedor(array('id_personas' => $this->input->post('id_proveedor')), $data);
                if ($prov_update) {
                    $this->session->set_flashdata('success','Registro modificado exitosamente.');
                } else {
                    $this->session->set_flashdata('error','Error al modificar registro.');
                }
        }
        redirect('proveedor');
    }

    public function datos_proveedor($id_prov){
        $data = $this->proveedor->get_datos_proveedor($id_prov);
        echo json_encode($data);
    }


    public function dlt_proveedor($id_prov,$estado){
        if ($estado == 'ELABORADO') {
            $estado_act = 'ELIMINADO';
        } else {
            $estado_act = 'ELABORADO';
        }
            $data = array(
                'apiestado' => $estado_act,
                'usumod' => $this->session->userdata('usuario'),
                'fecmod' => date('Y-m-d H:i:s')
            );
        $this->proveedor->delete_proveedor($id_prov, $data);
        redirect('proveedor'); 
    }
}
