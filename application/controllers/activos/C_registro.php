<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Creador: Adamary Margel Uchani Mamani Fecha: 22/11/2022, Codigo: SAM-MS-A7-0001,
Descripcion: Creacion del Controlador C_registros y la funcion listar registros de activos
-------------------------------------------------------------------------------------------------------------------------------
Creador: Adamary Margel Uchani Mamani Fecha: 24/11/2022, Codigo: SAM-MS-A7-0007,
Descripcion: Creacion del Controlador C_registros y la funcion del AVM de activos
-------------------------------------------------------------------------------------------------------------------------------
Creador: Flavio Abdon Condori Vela  Fecha: 28/03/2023, Codigo: GAN-MS-M0-0364
Descripcion: Se añadió la funcionalidad al boton devolución, se creó la función guardar_devolucion.
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_registro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('activos/M_registro','registro_activo');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $this->session->userdata('id_usuario');

            $data['productos'] = $this->registro_activo->get_productos_cmb();
            $data['usuarios'] = $this->registro_activo->get_usuarios_cmb();
            
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'activos/registro';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function listar_registro_activos(){
        $id_usuario = $this->input->post('id_usuario');
        $data = $this->registro_activo->listar_reg_activos($id_usuario);
        echo json_encode($data);
    }


    public function aggre_modi_activo()
    {
        if ($this->input->post('btn') == 'add') {
            //JALAMOS LOS DATOS
            $idlogin = $this->session->userdata('id_usuario');
            $id_usuario = $this->input->post('id_usuario');
            $activo = $this->input->post('activo');
            $fecha_asignacion = $this->input->post('fecha_asignacion');
            $array_datos = array();
            $array_datos = array('id_usuario'=>$id_usuario,'id_producto'=>$activo, 'fecha_asignacion'=>$fecha_asignacion);
            //PARA EL JSON DEL FORMULARIO
            $json = json_encode($array_datos);
            
            $activo_add_update = $this->registro_activo->agg_mod_activo(0, $idlogin, $json);

        } elseif ($this->input->post('btn') == 'edit') {
            $id_activo=$this->input->post('id_activo');
            $idlogin = $this->session->userdata('id_usuario');
            $id_usuario = $this->input->post('id_usuario');
            $activo = $this->input->post('activo');
            $fecha_asignacion = $this->input->post('fecha_asignacion');
            $array_datos = array();
            $array_datos = array('id_usuario'=>$id_usuario,'id_producto'=>$activo, 'fecha_asignacion'=>$fecha_asignacion);
            //PARA EL JSON DEL FORMULARIO
            $json = json_encode($array_datos);
            
            $activo_add_update = $this->registro_activo->agg_mod_activo($id_activo, $idlogin, $json);
            
        }
        echo json_encode($activo_add_update);
    }

    public function recuperar_registro_activos($id_activo){
        $data = $this->registro_activo->recuperar_activos($id_activo);
        echo json_encode($data);
    }
    // GAN-MS-M0-0364 Inicio Flavio A.C.V -->
    public function guardar_devolucion()
    {
        $id_activo=$this->input->post('id_activo');
        $idlogin = $this->session->userdata('id_usuario');
        $motivo_devolucion = $this->input->post('motivo_devolucion');
        $array_datos = array();
        $array_datos = array('motivo_devolucion'=>$motivo_devolucion);
        //PARA EL JSON DEL FORMULARIO
        $json = json_encode($array_datos);
        
        $devolucion_add = $this->registro_activo->registrar_devolucion($id_activo, $idlogin, $json);
        
        echo json_encode($devolucion_add);
    }
    // GAN-MS-M0-0364 Fin Flavio A.C.V -->

    public function eliminar_activos($id_activo){
        $idlogin = $this->session->userdata('id_usuario');
        $data = $this->registro_activo->eliminar_activos($idlogin, $id_activo);
        echo json_encode($data);
    }
}