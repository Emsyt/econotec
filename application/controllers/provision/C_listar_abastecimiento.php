<?php
/* 
------------------------------------------------------------------------------------------
Creador: Kevin Gerardo Alcon Lazarte Fecha:28/03/2023, Codigo:GAN-DPR-M1-0373 ,
Creacion:Se creo el controlador C_listar_abastecimiento
----------------------------------------------------------------------------------------

 */
?>
<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_listar_abastecimiento extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('provision/M_listar_abastecimiento','listar_abastecimiento');
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->library('excel');
        
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $data['codigo_usr'] = $this->session->userdata('id_usuario');
            $data['ubicaciones'] = $this->listar_abastecimiento->get_lst_ubicaciones();
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
            // $data['contenido'] = 'reporte/abastecimiento';
            $data['contenido'] = 'provision/listar_abastecimiento';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    
    public function lst_reporte_abastecimiento() {

        $array_abast = array(
            'fecha_inicial' => $this->input->post('selc_frep'),
            'fecha_fin' => $this->input->post('selc_finrep'),
        );
        $json_abast=json_encode($array_abast);
        
        $lst_abastecimiento = $this->listar_abastecimiento->get_rep_abastecimiento($json_abast);
        $data= array('responce'=>'success','posts'=>$lst_abastecimiento);
        echo json_encode($data);
    }
    
    public function eliminar_abast() {
        $id_lote = $this->input->post('dato1');
        $eliminar_abast = $this->listar_abastecimiento->get_eliminar_abastecimiento($id_lote);
        echo json_encode($eliminar_abast);
    }
    
    public function historial_compra(){
        $id_lote = $this->input->post('dato1');
        $historial_compras = $this->listar_abastecimiento->get_historial_compra($id_lote);
        // $historial_compras = $historial_compras[0]->fn_historial_compra;
        echo json_encode($historial_compras);
    }
    public function editar_abastecimiento_lotes(){
        $id_lote = $this->input->post('dato1');
        $date = $this->listar_abastecimiento->get_editar_abast_lotes($id_lote);
        echo json_encode($date);
    }

    public function get_solicitud(){ 
        $login = $this->session->userdata('usuario');
        $dato = $this->listar_abastecimiento->get_verificar_solicitud($login);
        echo json_encode($dato);

    }

}
