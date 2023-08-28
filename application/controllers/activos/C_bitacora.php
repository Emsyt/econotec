<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Creador: Keyla Paola Usnayo Aguilar Fecha: 22/11/2022, Codigo: SAM-MS-A7-0003,
Descripcion: Creacion del Controlador C_bitacora
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_bitacora extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('activos/M_bitacora','bitacora');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $this->session->userdata('id_usuario');
            $data['usuarios'] = $this->bitacora->get_lst_usuarios();
            $data['productos'] = $this->bitacora->get_lst_productos();


            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'activos/bitacora';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function lista_usuarios(){
        $data = $this->permiso-> get_lst_usuarios();
        echo json_encode($data);
    }

    public function add_edit_bitacora()
    {
        if ($this->input->post('btn') == 'add') {
            //JALAMOS LOS DATOS
            //$id_bitacora = 0;
            $id_usuario = $this->input->post('usuario');
            $id_producto = $this->input->post('id_producto');
            $fecha_salida = $this->input->post('fecha_salida');
            $fecha_retorno = $this->input->post('fecha_retorno');
            $km_inicio = $this->input->post('km_inicio');
            $km_final = $this->input->post('km_final');
            $km_recorrido = $this->input->post('km_recorrido');
            $destino = $this->input->post('destino');
            $motivo = $this->input->post('motivo');
            $gasolina = $this->input->post('gasolina');
            $array_datos = array();
            $array_datos = array('id_producto'=>$id_producto,
                                 'fecha_salida'=>$fecha_salida,
                                 'fecha_retorno'=>$fecha_retorno,
                                 'km_inicio'=>$km_inicio,
                                 'km_final'=>$km_final,
                                 'km_recorrido'=>$km_recorrido,
                                 'destino'=>$destino,
                                 'motivo'=>$motivo,
                                 'gasolina'=>$gasolina
                                );

            //PARA EL JSON DEL FORMULARIO
            $json = json_encode($array_datos);
            
            $activo_add_updateñl = $this->bitacora->add_edit_bitacora(0, $id_usuario, $json);

        } elseif ($this->input->post('btn') == 'edit') {
            $id_usuario = $this->input->post('usuario');
            $id_producto = $this->input->post('id_producto');
            $fecha_salida = $this->input->post('fecha_salida');
            $fecha_retorno = $this->input->post('fecha_retorno');
            $km_inicio = $this->input->post('km_inicio');
            $km_final = $this->input->post('km_final');
            $km_recorrido = $this->input->post('km_recorrido');
            $destino = $this->input->post('destino');
            $motivo = $this->input->post('motivo');
            $gasolina = $this->input->post('gasolina');
            $array_datos = array();
            $array_datos = array('id_producto'=>$id_producto,
                                 'fecha_salida'=>$fecha_salida,
                                 'fecha_retorno'=>$fecha_retorno,
                                 'km_inicio'=>$km_inicio,
                                 'km_final'=>$km_final,
                                 'km_recorrido'=>$km_recorrido,
                                 'destino'=>$destino,
                                 'motivo'=>$motivo,
                                 'gasolina'=>$gasolina
                                );

            //PARA EL JSON DEL FORMULARIO
            $json = json_encode($array_datos);
            
            $activo_add_updateñl = $this->bitacora->add_edit_bitacora(1, $id_usuario, $json);
            
        }
        echo json_encode($activo_add_update);
    }
}