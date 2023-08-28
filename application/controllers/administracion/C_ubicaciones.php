<?php 
/* A
-------------------------------------------------------------------------------------------------------------------------------
Creador: Gabriela Mamani Choquehuanca Fecha:24/06/2022, Codigo: GAN-MS-A5-275,
Descripcion: Se creo el controlador del ABM llamado Ubicaciones, el cual cuenta con la funcion de add_update_ubicacion() 
para insertar datos en el formulario
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Gabriela Mamani Choquehuanca Fecha:27/06/2022, Codigo: GAN-MS-A4-290,
Descripcion: Se creo el controlador del listado de registros de ubicaciones  denominado lista_ubicacion1()
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Gabriela Mamani Choquehuanca Fecha:27/06/2022, Codigo: GAN-MS-A4-291,
Descripcion: Se creo los controladores para  eliminar y modificar los registros  en la tabla de la vista
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Jose Daniel Luna Flores     Fecha: 30/08/2022    Código: GAN-SC-M5-409
Descripción: Se modifico la funcion de add_update_ubicacion()/insert_ubicacion para que reciba un parametro de entrada 'id_relacion'
Se modifico la funcion de add_update_ubicacion()/modificar_ubicacion para que reciba un parametro de entrada 'apiestado'
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Jose Daniel Luna Flores     Fecha: 07/09/2022    Código: GAN-MS-A1-435
Descripción: Se modifico la funcion de add_update_ubicacion()/insert_ubicacion para que ya no reciba el parametro de entrada 'apiestado'
ya que por defecto se crea como 'ELABORADO', eso con el objetivo de que la funcion actualizada fn_registrar_ubicacion() funcione
correctamente
---------------------------------------------------------------------------------------------------------------------------------------------------------
Modificado: Jade Piza                   Fecha:10/05/2023   Codigo: GAN-MS-B1-0457
Descripcion: se agrego la funcion add_update_ubi_modal para que registre la latitud y longitud en el punto de ubicacion con un array 
para que funcione el punto de ubicacion y ahi se pueda editar una nueva ubicacion
------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
?>
<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_ubicaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('administracion/M_ubicaciones','ubicaciones');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['lst_ubicacion']=$this->ubicaciones->get_lst_ubicacion();

            $data['lib'] = 0;
            $data['datos_log'] = $log;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'administracion/ubicaciones';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function C_insert_ubicacion($cad){
        
        //Asignar el valor a la variable $id_ubicaciones utilizando la función ternaria
        $id_ubicaciones = ($cad == 'REGISTRADO') ? 0 : $this->input->post('id_ubicaciones');
            
        //Validar la entrada del tipo de documento
        $tipo_documento = $this->input->post('doc_identidad');
        if (!empty($tipo_documento)) {
            if ($tipo_documento == '1334') {
                //Validar la entrada del documento
                $documento = $this->input->post('documento');
                $complemento = $this->input->post('complemento');
                if (!empty($complemento)) {
                    $documento = $documento . '-' . $complemento;
                }
            }else{
                $documento = $this->input->post('documento');
            }
        }
        //Agrupar las variables relacionadas en un arreglo
        $data = array(
            'id_ubicaciones'    => $id_ubicaciones,
            'codigo'       => $this->input->post('codigo'),
            'id_catalogo'     => $this->input->post('id_catalogo'),
            'tipo_documento'=> $this->input->post('doc_identidad'),
            'documento'     => $documento,
            'valid_docs'    => $this->input->post('valid_docs'),
            'valid_excep'   => $this->input->post('valid_excep'),
            'descripcion'   => $this->input->post('descripcion'),
            'direccion'     => $this->input->post('direccion'),
            'latitud'       => $this->input->post('latitud'),
            'longitud'      => $this->input->post('longitud'),
        );

        $data = $this->ubicaciones->insert_ubicacion(json_encode($data));
        echo json_encode($data);
    }

    public function add_update_ubicacion(){
        if ($this->input->post('btn') == 'add') {
        // GAN-MS-A1-435 , 07/09/2022, dev_jluna 
            $id_catalogo=$this->input->post('ubi_ini');
            $codigo =$this->input->post('codigo');
            $descripcion = $this->input->post('descripcion');
            //$area = $this->input->post('area');
            $direccion = $this->input->post('direccion');
            $usucre =  $this->session->userdata('usuario');
            /* $id_departamento = $this->input->post('expedido'); */
            $latitud = $this->input->post('latitud');
            $longitud =$this->input->post('longitud');
            $this->ubicaciones->insert_ubicacion($id_catalogo,$codigo ,$descripcion,$direccion,$usucre,2, $latitud, $longitud);
        } else if ($this->input->post('btn') == 'edit') {
            $id_ubicaciones=$this->input->post('id_ubicacion');
            $id_catalogo=$this->input->post('ubi_ini');
            $codigo =$this->input->post('codigo');
            $descripcion = $this->input->post('descripcion');
            //$area = $this->input->post('area');
            $direccion = $this->input->post('direccion');
            $usucre =  $this->session->userdata('usuario');
            /* $id_departamento = $this->input->post('expedido'); */
            $latitud = $this->input->post('latitud');
            $longitud =$this->input->post('longitud');
            // GAN-SC-M5-409 , 30/08/2022, dev_jluna 
            $this->ubicaciones-> modificar_ubicacion($id_ubicaciones,$id_catalogo,$codigo ,$descripcion,$direccion,$usucre,2, $latitud, $longitud);
            // FIN GAN-SC-M5-409 , 30/08/2022, dev_jluna 
        }
         redirect('ubicaciones');
    }

    public function get_lst_ubicacion(){
        $data = $this->ubicaciones->get_lst_ubicacion();
        echo json_encode($data);
    }

     public function lista_ubicacion1(){
        $data = $this->ubicaciones-> get_lst_ubicacion1();
        echo json_encode($data);
     }

     public function datos_ubicacion($id_ubi){
        $data = $this->ubicaciones->get_datos_ubicacion($id_ubi);
        echo json_encode($data);
    }

    public function add_update_ubi_modal()
    {
        $array = $this->input->post('array');
        $usucre =  $this->session->userdata('usuario');
        $id_ubicaciones = $array[0];
        $id_catalogo = $array[1];
        $codigo = $array[2];
        $descripcion = $array[3];
        $direccion = $array[4];
        $latitud = $array[5];
        $longitud = $array[6];

        if ($array[8] == 'REGISTRADO') {
            $id_personas = 0;
        } elseif ($array[8] == 'MODIFICADO') {
            $id_personas = $array[5];
        }
        $resp=$this->ubicaciones-> modificar_ubicacion($id_ubicaciones,$id_catalogo,$codigo ,$descripcion,$direccion,$usucre,2, $latitud, $longitud);
        echo json_encode($resp);
    }
    
    public function dlt_ubicaciones($id_prov){
       $data= $this->ubicaciones->delete_ubicacion($id_prov);
       echo json_encode($data); 
    }
    
}

