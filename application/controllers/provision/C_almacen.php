<?php
/*
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:15/04/2022, Codigo:GAN-FR-M4-159
  Descripcion: se modificaron las funciones para que estas hagan uso de las funciones
  actualizadas en base de datos
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:27/04/2022, Codigo:GAN-MS-A7-205
  Descripcion: se agrego la funcion get_lst_solicitudes para que recupere la tabla segun
  la ubicacion que se le mande
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_almacen extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('provision/M_almacen','almacen');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $id_ubicacion = $this->session->userdata('ubicacion');
            $login = $this->session->userdata('usuario');
            $id_usuario = $this->session->userdata('id_usuario'); 
            $data['ubicacion'] = $this->almacen->get_lst_ubicacion($login,$id_ubicacion);
            $data['contador'] = $this->almacen->contador_solicitudes($login,$id_ubicacion);
            // GAN-MS-B5-0456, 11/05/2023 ILaquis.
            $data['clientes'] = $this->almacen->get_lst_cliente();
            $data['cod_catalogo']=$this->session->userdata('cod_catalogo');
            // FIN GAN-MS-B5-0456, 11/05/2023 ILaquis.

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'provision/solicitud_almacen';
           
            $data['chatUsers'] = $this->general->chat_users($id_usuario);
            $data['getUserDetails'] = $this->general->get_user_details($id_usuario);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function get_prod(){
        $id_ubicacion = $this->input->post('ubicacion');
        $data = $this->almacen->get_producto_cmb($id_ubicacion);
        echo json_encode($data);
    }
    public function get_lst_solicitud(){
        $id_usuario = $this->session->userdata('id_usuario'); 
        $id_ubicacion = $this->input->post('ubicacion');
        $data = $this->almacen->get_lst_solicitud($id_usuario,$id_ubicacion);
        echo json_encode($data);
    }
    public function add_solicitud(){ 
        $id_mod = $this->input->post('id_mod');
        $id_usuario = $this->session->userdata('id_usuario'); 

        $producto = $this->input->post('producto');
        $cantidad_sol=$this->input->post('cantidad_sol');
        $fec_entrega=$this->input->post('fecha');
        $fec_entrega=str_replace("/", "-", $fec_entrega);
        $ubi_ini=$this->input->post('ubi_ini');
        // GAN-MS-B5-0456, 11/05/2023 ILaquis.
        $vCliente=$this->input->post('vCliente');
        // FIN GAN-MS-B5-0456, 11/05/2023 ILaquis.
        
        $array = array(
            "id_producto" => $producto,
            "solicitado" => $cantidad_sol,
            "fecha_entrega" => $fec_entrega,
            "id_ubicacion" => $ubi_ini,
            // GAN-MS-B5-0456, 11/05/2023 ILaquis.
            "id_cliente" => $vCliente,
            // FIN GAN-MS-B5-0456, 11/05/2023 ILaquis.
        );
        
        $json=json_encode($array);
        // GAN-MS-B5-0456, 11/05/2023 ILaquis.
        $id_cat=$this->session->userdata('cod_catalogo');
        if(!strcmp($id_cat,'DIS')){            
            $prov_insert = $this->almacen->insert_solicitud_distribuidor($id_mod,$id_usuario,$json);
        }else{
            $prov_insert = $this->almacen->insert_solicitud($id_mod,$id_usuario,$json);            
        }
        // FIN GAN-MS-B5-0456, 11/05/2023 ILaquis.
        echo json_encode($prov_insert);
    }

    public function confirmar_solicitud(){
        $id_usuario = $this->session->userdata('id_usuario'); 
        $fec_entrega=$this->input->post('fec');
        $sel_ubi=$this->input->post('sel_ubi');
        $id_cat=$this->session->userdata('cod_catalogo');
        // GAN-MS-B1-0456, 12/05/2023 ILaquis.
        $id_cliente=$this->input->post('id_cli');
        if (!strcmp($id_cat,'DIS')) {
            $com_update = $this->almacen->confirmar_solicitud_distribuidor($id_usuario,$fec_entrega,$sel_ubi,$id_cliente);
        }else {
            $com_update = $this->almacen->confirmar_solicitud($id_usuario,$fec_entrega,$sel_ubi);
        }
        // FIN GAN-MS-B1-0456, 12/05/2023 ILaquis.
        if ($com_update[0]->oboolean=='f') {
            $this->session->set_flashdata('error',$com_update[0]->omensaje);
           } else {
            $this->session->set_flashdata('success','Solicitud de Producto realizada exitosamente.');
           } 
        redirect('almacen');    
    }

    public function dlt_solicitud($id_prod){
        $id_usuario = $this->session->userdata('id_usuario'); 
        $sol_delete = $this->almacen->delete_solicitud($id_usuario, $id_prod);
        echo json_encode($sol_delete); 
    }

    //------- FUNCIONES AUXILIARES -------//
    public function func_auxiliares(){
        try{
            $accion = $_REQUEST['accion'];
            if(empty($accion))
                throw new Exception("Error accion no valida"); 
            switch($accion) {
                case 'cantidad_almacen':
                    $id_ubicacion = $this->input->post('ubi_ini');
                    if($id_producto = $this->input->post('selc_prod')!=""){
                        $id_producto = $this->input->post('selc_prod');
                        $cantidad = $this->almacen->get_cantidad_almacen($id_ubicacion,$id_producto);
                        echo json_encode($cantidad);
                    }else{
                        echo json_encode("");
                    }
                  break;

                default;
                    echo 'Error: Accion no encontrada';
            }
        }
        catch(Exception $e)
        {
            $log['error'] = $e;  
        }
    }    
}


