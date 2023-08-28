<?php
/* A
------------------------------------------------------------------------------------------
Creador: Aliso Paola Pari Pareja Fecha:18/11/2022, GAN-MS-A7-0111,
Creacion del Controlador C_registro_garantia para conectar con registro_garantia y M_registro_garantia con sus respectivas funciones
------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:18/11/2022   GAN-MS-A7-0120,
Descripcion: Se crearon las funciones para listado y registro de garantias
*/
?>

<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_registro_garantia extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('garantias/M_registro_garantia','garantia');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['usuario'] = $this->session->userdata('usuario');
            $log['permisos'] = $this->session->userdata('permisos');
            $usr=$data['codigo_usr'] = $this->session->userdata('id_usuario');
            date_default_timezone_set('America/La_Paz');
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
            $data['contenido'] = 'garantias/registro_garantia';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function get_lst_garantias1() {
        
            $array_gar = array(
                'fecha_inicial' => $this->input->post('fecha_inicial'),
                'fecha_fin' => $this->input->post('fecha_fin'),
            );
            $json_gar=json_encode($array_gar);
            $data = $this->garantia->M_get_lst_garantias1($json_gar);
            echo json_encode($data);
        
    }
    public function get_lst_garantias() {
    try{
        $postData = $this->input->post();
        $array_gar = array(
            'fecha_inicial' => $this->input->post('fecha_inicial'),
            'fecha_fin' => $this->input->post('fecha_fin'),
        );
        $json_gar=json_encode($array_gar);
        //echo json_encode($json_gar);
        $data = $this->garantia->M_get_lst_garantias();
        echo ($data);
    }
    catch(Exception $uu){
        $log['error'] = $uu;
    } 
    }
    public function registrar_garantia(){
            $lote = $this->input->post('id_lote');
            $config['allowed_types'] = 'jpg|png|JPEG';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] =TRUE;

            $this->load->library('upload', $config);

            if (!file_exists($_FILES['img_gar']['tmp_name']) || !is_uploaded_file($_FILES['img_gar']['tmp_name'])) {
                $newName = NULL;
                $val_mostrar = FALSE;
            } else {
                $extension = explode('.',$_FILES['img_gar']['name']);
                $newName = $extension[0].$lote.'.'.$extension[1];
                $destination = './assets/img/garantias/'.$newName;
                move_uploaded_file($_FILES['img_gar']['tmp_name'],$destination);
                $val_mostrar = TRUE;
            }
            $idusuario = $this->session->userdata('id_usuario');
            $caracteristica=$this->input->post('caracteristica');
            $fecha=$this->input->post('fecha_garan');
            //$fecha = date("Y-m-d", strtotime($fecha));
            $fecha = explode('/',$fecha);
            $fecha=$fecha[2].'/'.$fecha[1].'/'.$fecha[0];
              $gar_insert = $this->garantia->M_registro_garantias($idusuario,$lote,$fecha,$caracteristica,$newName);
            
                if ($gar_insert[0]->fn_registro_garantia=='t' ) {
                    $this->session->set_flashdata('success','Registro insertado exitosamente.');
                } else {
                    $this->session->set_flashdata('error','Error en el registro');
                }

     
                redirect('registro_garantia');
            }
     
}
