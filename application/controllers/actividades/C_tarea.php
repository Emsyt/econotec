<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_tarea extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('actividades/M_tarea', 'tarea');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
          
            $log['permisos'] = $this->session->userdata('permisos');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'actividades/tarea';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
           
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $data['clientes'] = $this->tarea->listar_clientes();  
            $data['empleado'] = $this->tarea->listar_empleado();  
            $data['tareas'] = $this->tarea->fn_reporte_tarea();  
            $usr = $this->session->userdata('id_usuario');
            $data['productos'] = $this->tarea->get_producto($usr);
            $this->load->view('templates/estructura', $data);
          
        } else {
            redirect('logout');
            
        }
    }
    /*
    public function lista_tareas(){
        
      //hola
        // POST data
        $postData = $this->input->post();
        // Get data
        $data = $this->tarea->fn_reporte_tarea1($postData);
   
        echo json_encode($data);
     }
     */

    public function calcular_stock(){
        $id_producto = $this->input->post('id_producto');
        $data = $this->tarea->fn_calcular_stock($id_producto);
        $data = $data[0]->fn_calcular_stock;
        echo json_encode($data);
    }
    
    public function add_update_tarea(){
        if ($this->input->post('btn') == 'add') {
            //aqui inicia json
            $btnid = $this->input->post('btnid'); //0

            $cont=count(json_decode($_POST['pers']));
            $pers = json_decode($_POST['pers']); 
            
            $cont2=count(json_decode($_POST['prod']));
            $prod = json_decode($_POST['prod']); 
            $cant = json_decode($_POST['cant']); 

            $array_datos = array();
            for($i = 0; $i < $cont; $i++){
                array_push($array_datos, (int)$pers[$i]);
            }
            $array_datos2 = array();
            for($i = 0; $i < $cont2; $i++){
                // $array_datos2[] = array('id_producto' => (int)$prod[$i],'cantidad' => (int)$cant[$i]);
                // array_push($array_datos2, (int)$prod[$i], (int)$cant[$i]);
                array_push($array_datos2, array('id_material' => (int)$prod[$i],'cantidad' => (int)$cant[$i]));
            }

            $array = array(
                "descripcion" => $this->input->post('descripcion'),
                "fecini" => $this->input->post('fecini'),
                "fecfin" => $this->input->post('fecfin'),
                "idcliente" => $this->input->post('idcliente'),
                "usuarios" => $array_datos,
                "estado" => $this->input->post('estado'),
                "materiales" => $array_datos2,
            );

            $json = json_encode($array);
            $idlogin = $this->session->userdata('id_usuario');
            $cli_insert = $this->tarea->fn_registrar_tarea($btnid,$idlogin,$json);
            echo json_encode($cli_insert);
        } elseif ($this->input->post('btn') == 'edit') {
            $btnid = $this->input->post('btnid');//se utiliza cuando se edita 
            $cont=count(json_decode($_POST['pers']));
            $pers = json_decode($_POST['pers']);

            $cont2=count(json_decode($_POST['prod']));
            $prod = json_decode($_POST['prod']); 
            $cant = json_decode($_POST['cant']); 

            $array_datos = array();
            for($i = 0; $i < $cont; $i++){
                array_push($array_datos, (int)$pers[$i]);
            }

            $array_datos2 = array();
            for($i = 0; $i < $cont2; $i++){
                // $array_datos2[] = array('id_producto' => (int)$prod[$i],'cantidad' => (int)$cant[$i]);
                // array_push($array_datos2, (int)$prod[$i], (int)$cant[$i]);
                array_push($array_datos2, array('id_material' => (int)$prod[$i],'cantidad' => (int)$cant[$i]));
            }
            
            $array = array(
                "descripcion" => $this->input->post('descripcion'),
                "fecini" => $this->input->post('fecini'),
                "fecfin" => $this->input->post('fecfin'),
                "idcliente" => $this->input->post('idcliente'),
                "usuarios" => $array_datos,
                "estado" => $this->input->post('estado'),
                "materiales" => $array_datos2,
            );
            $json = json_encode($array);
            //json fin
            $idlogin = $this->session->userdata('id_usuario');
            $cli_insert = $this->tarea->fn_registrar_tarea($btnid,$idlogin,$json);
            echo json_encode($cli_insert);
        }
        //redirect('promociones');
    }

    public function datos_tarea($id_tarea){
        $data = $this->tarea->fn_datos_tarea($id_tarea);
        echo json_encode($data);
    }

    public function dlt_tarea($id_tarea){
        $idlogin = $this->session->userdata('id_usuario');
        $persdelete = $this->tarea->fn_eliminar_tarea($idlogin,$id_tarea);
        redirect('tarea');
    }
}
