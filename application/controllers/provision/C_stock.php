<?php

/*
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana    Fecha:15/09/2022,     Codigo: GAN-MS-A1-439,
Descripcion: Se modifico la funcion get_lst_stock para  insertar el limit del modelo en el datatable en el modulo de stock
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class C_stock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('provision/M_stock','stock');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $id_ubicacion = $this->session->userdata('ubicacion');
            $login = $this->session->userdata('usuario');
            //$data['lst_solicitudes'] = $this->solicitud->get_lst_solicitud_ubicacion($login);
            $data['ubicaciones'] = $this->stock->get_ubicacion_cmb();
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'provision/Stock';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function get_lst_stock($id_ubi){
        try{
            $postData   = $this->input->post();
            $data       = $this->stock->get_lst_inventarios($id_ubi,$postData);
            echo json_encode($data);
        }
        catch(Exception $uu){
            $log['error'] = $uu;
        }
    }

    public function change_cantidad($id_prod,$newcantidad, $id_ubi, $description)
    {
        $idus = $this->session->userdata('id_usuario');
        //$resultado = 0;
        $resultado = $this->stock->cambiar_cantidad($id_ubi, $id_prod,$idus,$newcantidad, $description);
        //print_r($resultado[0]->oboolean);
        if($resultado[0]->oboolean == 't')
        {
            $this->session->set_flashdata('success','Registro modificado exitosamente.');  
        }
        else
        {
            $this->session->set_flashdata('error',$resultado[0]->omensaje);  
        }
        
        redirect('stock');
            
    }

    public function change_cantidad_1( )
    {
        $id_prod = $this->input->post('valor_1');
        $newprecio = $this->input->post('valor_2');
        $id_ubi = $this->input->post('valor_3');
        $descripcion = $this->input->post('valor_4');
       $idus = $this->session->userdata('id_usuario');
        //$resultado = 0;
       $resultado = $this->stock->cambiar_cantidad($id_ubi, $id_prod,$idus,$newprecio, $descripcion);
        //print_r($resultado[0]->oboolean);
      
        //  echo json_encode($id_prod."-".$newprecio."-".$id_ubi."-".$descripcion."-".$idus);
          echo  json_encode($resultado);  
    }

   
}


