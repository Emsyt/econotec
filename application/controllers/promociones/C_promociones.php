<?php
/*
    ------------------------------------------------------------------------------
    Modificado: Fabian Candia Alvizuri Fecha:13/10/2021, GAN-MS-A5-041
    Descripcion: Se realizaron la modificacion de para la creacion de funciones de las páginas 94 a 103
    ------------------------------------------------------------------------------
    Modificado: Fabian Candia Alvizuri Fecha:26/10/2021, GAN-MS-A5-041
    Descripcion: Se realizaron la modificacion para que funcione el registro de promociones
    ------------------------------------------------------------------------------
    Modificado: Fabian Candia Alvizuri Fecha:10/11/2021, GAN-MS-A4-069
    Descripcion: Se realizaron la modificacion para que liste los productos por su ubicacion 
    ------------------------------------------------------------------------------
    Modificado: Brayan Janco Cahuana Fecha:23/11/2021, GAN-MS-A5-097
    Descripcion: Se realizaron la modificacion para que al momento de enviar una nueva promocion o edicion esta incluya stock
    ------------------------------------------------------------------------------
    Modificado: Melvin Salvador Cussi Callisaya Fecha:29/11/2021, GAN-MS-A7-105
    Descripcion: Se modifico la funcion add_update_promocion2 para que reciba un array de productos desde la funcion ajax

*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_promociones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('promociones/M_promociones','promociones'); 
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $this->session->userdata('id_usuario');
            $data['productos'] = $this->promociones->get_producto($usr);
            $data['lst_promociones'] = $this->promociones->fn_reporte_promociones($usr);
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'promociones/promociones';
            
            $data['chatUsers'] = $this->general->chat_users($usr);
            $data['getUserDetails'] = $this->general->get_user_details($usr);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function lista_promociones(){
        
      
        // POST data
        $postData = $this->input->post();
   
        // Get data
        $data = $this->promociones->fn_reporte_promociones1($postData);
   
        echo json_encode($data);
     }
    
    public function add_update_promocion(){
        if ($this->input->post('btn') == 'add') {
            //aqui inicia json
            $btnid = $this->input->post('btnid'); //0
            $registros = count($_POST["producto"]);
            $array_datos = array();
            for($i = 0; $i < $registros; $i++)
            {
                $array_datos[] = array('id_producto' => $_POST["producto"][$i],'cantidad' => $_POST["cantidad"][$i]);
            }
            $array = array(
                "nombre" => $this->input->post('nombre'),
                "codigo" => $this->input->post('codigo'),
                "precio" => $this->input->post('precio'),
                "stock" => $this->input->post('stock'),
                "fecha_limite" => $this->input->post('fecha_limite'),
                "productos" => $array_datos
            );
            $json = json_encode($array);
        
            $idlogin = $this->session->userdata('id_usuario');
            
            echo "<script>console.log('" . $btnid . "' );</script>";
            echo "<script>console.log('" . $idlogin . "' );</script>";
            echo "<script>console.log('" . $json . "' );</script>";
            $cli_insert = $this->promociones->fn_registrar_promocion($btnid,$idlogin,$json);
            echo "<script>console.log('" . $cli_insert[0]->oboolean . "' );</script>";
            if ($cli_insert[0]->oboolean=='t') {
                $this->session->set_flashdata('success','Registro insertado exitosamente.');
            } else {
                $this->session->set_flashdata('error',$cli_insert[0]->omensaje);
            }
        } elseif ($this->input->post('btn') == 'edit') {
            $btnid = $this->input->post('btnid');//se utiliza cuando se edita 
            //json
            $registros = count($_POST["producto"]);
            $array_datos = array();
            for($i = 0; $i < $registros; $i++)
            {
                $array_datos[] = array('id_producto' => $_POST["producto"][$i],'cantidad' => $_POST["cantidad"][$i]);
            }
            $array = array(
                "nombre" => $this->input->post('nombre'),
                "codigo" => $this->input->post('codigo'),
                "precio" => $this->input->post('precio'),
                "stock" => $this->input->post('stock'),
                "fecha_limite" => $this->input->post('fecha_limite'),
                "productos" =>$array_datos
            );
            $json = json_encode($array);
            //json fin
            $idlogin = $this->session->userdata('id_usuario');

            echo "<script>console.log('" . $btnid . "' );</script>";
            echo "<script>console.log('" . $idlogin . "' );</script>";
            echo "<script>console.log('" . $json . "' );</script>";
            $cli_insert = $this->promociones->fn_registrar_promocion($btnid,$idlogin,$json);
            if ($cli_insert[0]->oboolean=='t') {
                $this->session->set_flashdata('success','Registro insertado exitosamente.');
            } else {
                $this->session->set_flashdata('error',$cli_insert[0]->omensaje);
            }
        }
        //redirect('promociones');
    }

    public function add_update_promocion2(){
        if ($this->input->post('btn') == 'add') {
            //aqui inicia json
            $btnid = $this->input->post('btnid'); //0

            $cont=count(json_decode($_POST['prod']));
            $prod = json_decode($_POST['prod']); 
            $cant = json_decode($_POST['cant']); 
            $array_datos = array();
            for($i = 0; $i < $cont; $i++){
                $array_datos[] = array('id_producto' => $prod[$i],'cantidad' => $cant[$i]);
            }
            $array = array(
                "nombre" => $this->input->post('nombre'),
                "codigo" => $this->input->post('codigo'),
                "precio" => $this->input->post('precio'),
                "stock" => $this->input->post('stock'),
                "fecha_limite" => $this->input->post('fecha_limite'),
                "productos" => $array_datos
            );
            $json = json_encode($array);
            $idlogin = $this->session->userdata('id_usuario');
            $cli_insert = $this->promociones->fn_registrar_promocion($btnid,$idlogin,$json);
            echo json_encode($cli_insert);
        } elseif ($this->input->post('btn') == 'edit') {
            $btnid = $this->input->post('btnid');//se utiliza cuando se edita 
            //json
            $cont=count(json_decode($_POST['prod']));
            $prod = json_decode($_POST['prod']); 
            $cant = json_decode($_POST['cant']); 
            $array_datos = array();
            for($i = 0; $i < $cont; $i++){
                $array_datos[] = array('id_producto' => $prod[$i],'cantidad' => $cant[$i]);
            }
            $array = array(
                "nombre" => $this->input->post('nombre'),
                "codigo" => $this->input->post('codigo'),
                "precio" => $this->input->post('precio'),
                "stock" => $this->input->post('stock'),
                "fecha_limite" => $this->input->post('fecha_limite'),
                "productos" =>$array_datos
            );
            $json = json_encode($array);
            //json fin
            $idlogin = $this->session->userdata('id_usuario');
            $cli_insert = $this->promociones->fn_registrar_promocion($btnid,$idlogin,$json);
            echo json_encode($cli_insert);
        }
        //redirect('promociones');
    }

    public function datos_promocion($id_promocion){
        $data = $this->promociones->fn_recuperar_promocion($id_promocion);
        $lst_recuperar_promocion = $data[0]->fn_recuperar_promocion;
        echo $lst_recuperar_promocion;
    }

    public function calcular_stock(){
        $id_producto = $this->input->post('id_producto');
        $data = $this->promociones->fn_calcular_stock($id_producto);
        $data = $data[0]->fn_calcular_stock;
        echo json_encode($data);
    }

    public function dlt_promocion($id_promocion){
        $idlogin = $this->session->userdata('id_usuario');
        $prodelete = $this->promociones->fn_eliminar_promocion($idlogin,$id_promocion);
        redirect('promociones');
    }
}
