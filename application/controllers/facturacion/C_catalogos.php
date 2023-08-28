<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_catalogos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Factu');
        $this->load->library('Facturacion');
        $this->load->model('facturacion/M_catalogos','catalogos'); 
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $this->session->userdata('id_usuario');
            $data['fecha_imp'] = date('Y-m-d H:i:s');
            
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'facturacion/catalogos';
           
            $data['chatUsers'] = $this->general->chat_users($usr);
            $data['getUserDetails'] = $this->general->get_user_details($usr);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    function sincronizarActividades(){
        $codigoAmbiente     = 2;
        $codigoPuntoVenta   = 1;
        $codigoSistema      = '7704DAABCD0C741E1E6CFF7';
        $nit                = 311502029;
        $codigoSucursal     = 0;
        $token              = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJEQU9TWVNURU1TIiwiY29kaWdvU2lzdGVtYSI6Ijc3MDREQUFCQ0QwQzc0MUUxRTZDRkY3Iiwibml0IjoiSDRzSUFBQUFBQUFBQURNMk5EUTFNREl3c2dRQTV6SnNqd2tBQUFBPSIsImlkIjo0OTEyMDAsImV4cCI6MTY3OTAxMTIwMCwiaWF0IjoxNjc2NjQ4NTk0LCJuaXREZWxlZ2FkbyI6MzExNTAyMDI5LCJzdWJzaXN0ZW1hIjoiU0ZFIn0._KGFR0EPEdGqsfX4awmFAqYHEf6CJhKXF2KXBCpMi5GrCmXdYcJzbQ3_e8VolDRKKmgpoQRnRgEiUqdJjlPSzg';
        $cuis               = '1C8870B7';


        $lib_Sincronizacion     = new Sincronizacion($token,$codigoAmbiente,$codigoSistema,$nit,$codigoSucursal,$cuis,$codigoPuntoVenta);

        $respons        = $lib_Sincronizacion->sincronizarListaProductosServicios();

      //  $data = $this->catalogos->insert_Actividades($respons);
        print_r($respons);

    }
    
}
