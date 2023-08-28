<?php 
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Gabriela Mamani Choquehuanca Fecha:25/07/2022, Codigo: GAN-MS-A1-317,
Descripcion: Se creo el controlador del ABM llamado unidades, el cual cuenta con la funcion de add_update_unidades() 
para insertar datos en el formulario

 */
?>
<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_unidades extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('administracion/M_unidades','unidades');
    }
    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['lib'] = 0;
            $data['datos_log'] = $log;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'administracion/unidades';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    } 

    public function add_update_unidades(){
    
        if ($this->input->post('btn') == 'add') {
      
            $codigo =$this->input->post('codigo');
            $descripcion = $this->input->post('descripcion');
            $usucre =  $this->session->userdata('usuario');
            $catalogo ='cat_unidades';
            $apiestado = 'ELABORADO';
     
           $this->unidades-> insert_unidad($codigo ,$descripcion, $usucre ,$catalogo,$apiestado);
            
        } else if ($this->input->post('btn') == 'edit') {
            $id_catalogo=$this->input->post('id_ubicacion');
            $codigo =$this->input->post('codigo');
            $descripcion = $this->input->post('descripcion');
            $usucre =  $this->session->userdata('usuario');
            $catalogo ='cat_unidades';
            $apiestado = $this->input->post('apiestado');
            print_r($apiestado);
           $this->unidades-> modificar($id_catalogo,$codigo ,$descripcion);
        }
        redirect('unidades');
    }

    public function lista_unidades(){
        $data = $this->unidades-> get_lst_unidades();
        echo json_encode($data);
     }
     public function datos_unidad($id_ubi){
        $data = $this->unidades-> get_datos_unidad($id_ubi);
        echo json_encode($data);
    }

    public function dlt_unidades($id_cli, $estado){

        if($estado == 'ELABORADO'){
            $apiestado ='ANULADO';
          
        }else{
            $apiestado ='ELABORADO';
        
        }
        $data= $this->unidades->delete_unidad($id_cli, $apiestado);
        redirect('unidades');


     }
}

