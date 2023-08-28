<?php
/* 
-----------------------------------------------------------------------------------------------
Creador: Ayrton Jhonny Guevara Montaño Fecha:11/05/2023, Codigo: GAN-MS-A5-078,
Descripcion: Se Realizo el Controlador del reporte de compras por consignacion
-----------------------------------------------------------------------------------------------
 */
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_reporte_abast_consig extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('reporte/M_reporte_abast_consig','reporte_abast_consig');//?1*
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['proveedores'] = $this->reporte_abast_consig->get_proveedor_cmb();//?1*
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
            $data['contenido'] = 'reporte/abastecimiento_consig';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function lst_reporte_abast_consig() {

        $array_deudas_abastecimiento = array(
            'id_proveedor' => $this->input->post('selc_prov'),
            'fecha_inicial' => $this->input->post('selc_frep'),
            'fecha_fin' => $this->input->post('selc_finrep'),
        );
        $json_deudas_abastecimiento=json_encode($array_deudas_abastecimiento);
        $lst_deudas_abastecimiento = $this->reporte_abast_consig->get_lst_deudas_abastecimiento($json_deudas_abastecimiento);
        $data= array('responce'=>'success','posts'=>$lst_deudas_abastecimiento);
        echo json_encode($data);
        
        
    }
  
    public function pagar_deuda() {
        $json = $_POST['json'];
        $json2 = substr($json, 1, -1);
        
        $pago_deuda = $this->reporte_abast_consig->get_pagar_deuda_abastecimiento($json2);
        $data= array('responce'=>'success','posts'=>$pago_deuda);
        echo json_encode($data);
    }
}
