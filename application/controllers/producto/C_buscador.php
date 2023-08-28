<?php
/* A
------------------------------------------------------------------------------------------
Creador: Aliso Paola Pari Pareja Fecha:28/11/2022, GAN-MS-A7-0142
Creacion del Controlador C_items para conectar con la vista items y M_items con sus respectivas funciones
------------------------------------------------------------------------------------------
Modificacion: Aliso Paola Pari Pareja Fecha:29/11/2022, GAN-MS-A7-0145
Se anadieron funciones para el registro, edicion, y eliminacion de series
------------------------------------------------------------------------------
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_buscador extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('producto/M_buscador', 'buscador');
        $this->load->library('Pdf_venta');
        $this->load->helper('url');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr = $data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'producto/buscador';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    public function lst_productos()
    {
        $producto = $_POST['producto'];
        $param_equi = $_POST['param_equi'];
        $all_medidas = $_POST['medidas'];
        $tipo_medidas_check = $_POST['tipo_medidas'];
        $opc_cod = $_POST['opc_cod'];
        $opc_codalt = $_POST['opc_codalt'];
        $opc_prod = $_POST['opc_prod'];
        $opc_desc = $_POST['opc_desc'];

        if ($opc_cod === "true") {
            $columSearch = 'codigo';
        }else if ($opc_codalt === "true") {
            $columSearch = 'codigo_alt';
        }else if ($opc_prod === "true") {
            $columSearch = 'descripcion';
        }else if ($opc_desc === "true") {
            $columSearch = 'caracteristica';
        }

        $preciso = ($tipo_medidas_check === "true") ? true : false;

        $id_ubi = $this->session->userdata('ubicacion');

        
        $lst_productos = $this->buscador->get_lst_producto_buscador($id_ubi, $producto, $all_medidas, $param_equi, $columSearch, $tipo_medidas_check);
            $data = array('responce' => 'success', 'posts' => $lst_productos);
            echo json_encode($data);
    }

    public function list_precios()
    {
        try {
            $id_prod = $_POST['id_prod'];
            $id_ubi = $this->session->userdata('ubicacion');
            $lst_precios = $data = $this->buscador->get_lst_precios($id_prod, $id_ubi);
            $data = array('responce' => 'success', 'posts' => $lst_precios);
            echo json_encode($data);
        } catch (Exception $uu) {
            $log['error'] = $uu;
        }
    }

    public function lst_stock_sucursales()
    {
        try {
            $id_prod = $_POST['id_prod'];
            $lst_stock = $data = $this->buscador->get_lst_stock_sucursales($id_prod);
            $data = array('responce' => 'success', 'posts' => $lst_stock);
            echo json_encode($data);
        } catch (Exception $uu) {
            $log['error'] = $uu;
        }
    }
}
