<?php
/*
-----------------------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:20/04/2022, Codigo: GAN-MS-M6-173,
Descripcion: se modifico la funcion add_update_cliente y delete_cliente una para que acepte un array
de datos para su registro y el otro para que devuelva el mensaje de error al momento de realizar el eliminar
-----------------------------------------------------------------------------------------------
Modificado: Melvin Salvador Cussi Callisaya Fecha:20/04/2022, Codigo: GAN-MS-M6-173,
Descripcion: se modifico la funcion add_update_cliente y delete_cliente una para que acepte un array
de datos para su registro y el otro para que devuelva el mensaje de error al momento de realizar el eliminar
-----------------------------------------------------------------------------------------------
Modificado: Richard Hector Orihuela G. Fecha:23/06/2022, Codigo: GAN-MS-A3-285,
Descripcion: Se agrego el area direccion para las funciones de Base de datos de cliente.
-----------------------------------------------------------------------------------------------
Modificado: Alvaro Ruben Gonzales Vilte Fecha:09/12/2022, Codigo: GAN-MS-A1-0176,
Descripcion: Se agrego un campo para la descripcion del cliente.
*/
defined('BASEPATH') or exit('No direct script access allowed');

class C_cliente extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cliente/M_cliente', 'cliente');
        $this->load->library('Facturacion');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            
            $log['permisos'] = $this->session->userdata('permisos');
            $data['lst_clientes'] = $this->cliente->get_cliente();
            $data['conf_facturacion'] = $this->cliente->M_confirmar_facturacion();
            $data['lst_documentos'] = $this->cliente->M_listar_documentos();
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'cliente/cliente';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        
        } else {
            redirect('logout');
            
        }
    }
    
    public function lista_cliente()
    {

        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->cliente->get_cliente1($postData);

        echo json_encode($data);
    }

    public function C_gestionar_cliente($cad){
        //Asignar el valor a la variable $id_cliente utilizando la función ternaria
        $id_cliente = ($cad == 'REGISTRADO') ? 0 : $this->input->post('id_cliente');
            
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
            'id_cliente'    => $id_cliente,
            'nombres'       => $this->input->post('nombres'),
            'apellidos'     => $this->input->post('apellidos'),
            'tipo_documento'=> $this->input->post('doc_identidad'),
            'documento'     => $documento,
            'valid_docs'    => $this->input->post('valid_docs'),
            'valid_excep'   => $this->input->post('valid_excep'),
            'correo'        => $this->input->post('correo'),
            'movil'         => $this->input->post('movil'),
            'direccion'     => $this->input->post('direccion'),
            'descripcion'   => $this->input->post('descripcion'),
            'latitud'       => $this->input->post('latitud'),
            'longitud'      => $this->input->post('longitud'),
            'id_ubicacion'  => $this->session->userdata('ubicacion'),
        );

        $data = $this->cliente->M_gestionar_cliente(json_encode($data));
        echo json_encode($data);
    }

    public function add_update_cliente()
    {
        $array = $this->input->post('array');

        $usuario = $this->session->userdata('usuario');
        $nombre_rsocial = $array[0];
        $apellidos_sigla = $array[1];
        $nit_ci = $array[2];
        $movil = $array[3];
        $direccion = $array[4];
        $latitud = $array[6];
        $longitud = $array[7];
        $descripcion = $array[9];

        if ($array[8] == 'REGISTRADO') {
            $id_personas = 0;
        } elseif ($array[8] == 'MODIFICADO') {
            $id_personas = $array[5];
        }
        $cli_add_update = $this->cliente->M_add_update_cliente($usuario, $id_personas, $nombre_rsocial, $apellidos_sigla, $nit_ci, $movil, $direccion, $latitud,$longitud,$descripcion);
        echo json_encode($cli_add_update);
    }

    public function datos_cliente($id_cli)
    {
        $data = $this->cliente->get_datos_cliente($id_cli);
        echo json_encode($data);
    }


    public function dlt_cliente($id_cli, $estado)
    {
        if ($estado == 'ELABORADO') {
            $estado_act = 'ELIMINADO';
        } else {
            $estado_act = 'ELABORADO';
        }
        $data = array(
            'apiestado' => $estado_act,
            'usumod' => $this->session->userdata('usuario'),
            'fecmod' => date('Y-m-d H:i:s')
        );
        $var = $this->cliente->delete_cliente($id_cli, $data);

        if ($var > 0) {
            if ($estado_act = 'ELABORADO') {
                $this->session->set_flashdata('success', 'Cliente inactivado exitosamente');
            }else{
                $this->session->set_flashdata('success', 'Cliente activado exitosamente');
            }
        } else {
            $this->session->set_flashdata('error');
        }

        redirect('cliente');
    }
    
    function verificar_nit(){

        $nitVerificar       = $this->input->post('documento');
        $facturacion        = $this->cliente->datos_facturacion();
        $lib_Codigo         = new Codigos($facturacion);

        $data = $lib_Codigo->solicitudVerificarNit($nitVerificar);

        echo json_encode($data);
    }

    function xmlEscape($string) {
        return str_replace(array('&', '<', '>', "'", '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }
}
