<?php
/* A
------------------------------------------------------------------------------------------
Creador: Aliso Paola Pari Pareja Fecha:18/11/2022, GAN-MS-A7-0111,
Creacion del Controlador C_ejecucion para conectar con ejecucion y M_ejecucion con sus respectivas funciones
------------------------------------------------------------------------------
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_ejecucion extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('garantias/M_ejecucion','ejecucion');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['fecha_imp'] = date('Y-m-d H:i:s');
           
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'garantias/ejecucion';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function lts_codigos_venta(){
        $data = $this->ejecucion->lts_codigos_venta();
        echo json_encode($data);
    }

    public function mostrar_venta_garantia(){
        $codigo_venta = $this->input->post('codigo_venta');
        $data = $this->ejecucion->mostrar_venta_garantia($codigo_venta);
        echo json_encode($data);
    }

    public function validar_garantia(){
        $codigo_venta = $this->input->post('cod_venta');
        $data = $this->ejecucion->validar_garantia($codigo_venta);
        echo json_encode($data);
    }

    public function datos_venta(){
        $idubicacion = $this->input->post('ubicacion');
        $idlote = $this->input->post('lote');
        $usucre = $this->input->post('usuario');
        $data = $this->ejecucion->datos_venta($idubicacion, $idlote, $usucre);
        $data= $data[0]->fn_historial_venta_garantia;
        echo $data;
    }

    public function realizar_ejecucion() {
        $config['allowed_types'] = 'jpg|png|JPEG';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] =TRUE;
        $this->load->library('upload', $config);

        if (!file_exists($_FILES['photo']['tmp_name']) || !is_uploaded_file($_FILES['photo']['tmp_name'])) {                
            $newName = 'sin_img.jpg';
        } else {
                $extension = explode('.',$_FILES['photo']['name']);
                $newName = $extension[0].'.'.$extension[1];
                $destination = './assets/img/icoLogo/'.$newName;
                move_uploaded_file($_FILES['photo']['tmp_name'],$destination);
                $val_mostrar = TRUE;
        }
        $cod_venta = $this->input->post('cd_ventas');
        $ids_venta = $this->input->post('c_ids_venta');
        $observaciones = $this->input->post('observaciones');
        $ajustes_insert = $this->ejecucion->realizar_ejecucion($cod_venta, $ids_venta,trim($observaciones),$newName);

        if ($ajustes_insert[0]->oboolean == 't') {
            $this->session->set_flashdata('success','Datos registrados correctamente.');
        } else {
            $this->session->set_flashdata('error','Error al registrar los datos.');
        }
        redirect('ejecucion');
    }

}
