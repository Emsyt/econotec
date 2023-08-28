<?php
/*
  ------------------------------------------------------------------------------
  Creado: Luis Fabricio Pari Wayar   Fecha:19/10/2022, Codigo:GAN-DPR-M6-0060
  Descripcion: Se creo el Controlador de "envio de productos" 
  ------------------------------------------------------------------------------
  Modificado: Ignacio Laquis Camargo Fecha: 18/05/2023, Codigo: GAN-MS-B1-0477
  Descripcion: Se realizo el mantenimiento de todo este controlador para que el sub modulo Envio de productos funcione.
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_envio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('provision/M_envio','envio');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $id_ubicacion = $this->session->userdata('ubicacion');
            $login = $this->session->userdata('usuario');
            $id_usuario = $this->session->userdata('id_usuario'); 
            $data['ubicacion'] = $this->envio->get_lst_ubicacion($login,$id_ubicacion);
            $data['contador'] = $this->envio->contador_solicitudes($login,$id_ubicacion);

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'provision/envio_productos';
           
            $data['chatUsers'] = $this->general->chat_users($id_usuario);
            $data['getUserDetails'] = $this->general->get_user_details($id_usuario);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function get_prod(){
        // GAN-MS-B1-0471, 17/05/2023 ILaquis.
        $id_ubicacion = $this->session->userdata('ubicacion');
        // FIN GAN-MS-B1-0471, 17/05/2023 ILaquis.
        $data = $this->envio->get_producto_cmb($id_ubicacion);
        echo json_encode($data);
    }
    public function get_lst_solicitud(){
        $id_usuario = $this->session->userdata('id_usuario'); 
        $id_ubicacion = $this->session->userdata('ubicacion');
        $data = $this->envio->get_lst_solicitud($id_usuario,$id_ubicacion);
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
        
        $array = array(
            "id_producto" => $producto,
            "solicitado" => $cantidad_sol,
            "fecha_entrega" => $fec_entrega,
            "id_ubicacion" => $ubi_ini,
        );

        $json=json_encode($array);
        $prov_insert = $this->envio->insert_solicitud($id_mod,$id_usuario,$json);
          echo json_encode($prov_insert);
    }

    public function confirmar_solicitud(){
        $id_usuario = $this->session->userdata('id_usuario'); 
        $fec_entrega=$this->input->post('fec');
        $sel_ubi=$this->input->post('sel_ubi');
        
        $com_update = $this->envio->confirmar_solicitud($id_usuario,$fec_entrega,$sel_ubi);
        if ($com_update[0]->oboolean=='f') {
            $this->session->set_flashdata('error',$com_update[0]->omensaje);
           } else {
            $this->session->set_flashdata('success','Solicitud de Producto realizada exitosamente.');
           } 
        
        // GAN-MS-B1-0471, 22/05/2023 ILaquis.
        //ultimo id_lote registrado por del usuario
        $lst_lotes = $this->envio->lista_lotes_solicitudes($id_usuario);
        $id_lote = array_pop($lst_lotes)->olote;
        $lote_productos = $this->envio->get_conf_solicitud($id_lote);
        //movimientos y cantidades de ese lote
        $oidmovimientos = array();
        $ocantidad_solicitada = array();
        foreach ($lote_productos as $item) {
            $oidmovimiento = $item->oidmovimiento;
            $oidmovimientos[] = $oidmovimiento;
            $ocantidad = $item->ocantidad_solicitada;
            $ocantidad_solicitada[] = $ocantidad;
        }
        $array = json_encode($oidmovimientos);
        $array2 = json_encode($ocantidad_solicitada);
        $array = str_replace('"', '', $array);
        $array2 = str_replace('"', '', $array2);
        $id_transporte = "0";
        //actualizar inventario
        $data = $this->envio->confirmar_cambio($array, $array2);
        // FIN GAN-MS-B1-0477, 22/05/2023 ILaquis.

        redirect('envio');    
    }

    public function dlt_solicitud($id_prod){
        $id_usuario = $this->session->userdata('id_usuario'); 
        $sol_delete = $this->envio->delete_solicitud($id_usuario, $id_prod);
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
                    $id_ubicacion = $this->session->userdata('ubicacion');
                    if($id_producto = $this->input->post('selc_prod')!=""){
                        $id_producto = $this->input->post('selc_prod');
                        $cantidad = $this->envio->get_cantidad_almacen($id_ubicacion,$id_producto);
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