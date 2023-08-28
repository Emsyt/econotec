<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Dotnara Isabel condori Condori Fecha:12/05/2023, Codigo:GAN-MS-B1-0463
  Descripcion: se creo el controlador de Rutas que contiene un dropdown con 
  distribuidores y un mapa
  ------------------------------------------------------------------------------
   Modificado: Alison Paola Pari Pareja Fecha:18/05/2023, Codigo:GAN-MS-A1-0481
  Descripcion: Se creo la funcion cargar_marcadores para obtener la lista de 
  la ubicacion geografica y estado de los clientes acuerdo a la ubicacion enviada
------------------------------------------------------------------------------ 
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_rutas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('distribucion/M_rutas','rutas');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $id_usuario = $this->session->userdata('id_usuario'); 
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'distribucion/rutas_distribuidores';
            $data['distribuidores'] = $this->rutas->get_listar_distribuidores($id_usuario);
            $data['chatUsers'] = $this->general->chat_users($id_usuario);
            $data['getUserDetails'] = $this->general->get_user_details($id_usuario);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }

    }
    public function cargar_marcadores()
    {
        $id_ubicacion=$this->input->post('id_ubicacion');
        $data = $this->rutas->M_fn_listar_clientes_distribuidor($id_ubicacion);
        echo json_encode($data);
    }
    public function cobrar()
    {
        $id_lote=$this->input->post('id_lote');
        $data = $this->rutas->M_fn_ruta_cobrar($id_lote);
        echo json_encode($data);
    }
}


