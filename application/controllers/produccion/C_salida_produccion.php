<?php
/*A
    -------------------------------------------------------------------------------------------------------------------------------
    Creacion: Melvin Salvador Cussi Callisaya Fecha 23/05/2022, Codigo: GAN-MS-A5-235
    Descripcion: se realizo el modulo de salida_de_produccion segun actividad GAN-MS-A5-235
     -------------------------------------------------------------------------------------------------------------------------------
    Modificacion: Alison Paola Pari Pareja   Fecha:02/08/2022   Actividad:GAN-MS-A1-337
    Descripcion: Se modificaron y anadieron algunas funciones para realizar los ajustes y correcciones en salida_produccion
    -------------------------------------------------------------------------------------------------------------------------------
    Creacion: Ariel Ramos Paucara          Fecha:22/03/2023           Actividad:GAN-DPR-M5-0245
    Descripcion: Se creo dos funciones que obtiene id_lote y la otra funcion obtiene un array id_productos
    -------------------------------------------------------------------------------------------------------------------------------
    Creacion: Flavio Abdon Condori Vela    Fecha:25/04/2023           Actividad:GAN-MC-B5-0422
    Descripcion: -En la funcion add_salida_produccion Se actulizó los nombres de las variables que se reciben por el metodo post
    -Se cambió el nombre de la variable $produtcArray a $productArray que generaba errores en la ejecución 

*/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_salida_produccion extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');

        $this->load->library('upload');
        $this->load->model('produccion/M_salida_produccion','salida_produccion');
        $this->load->library('Pdf_venta');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['ubicacion'] = $this->salida_produccion->get_ubicacion();
            $data['producto'] = $this->salida_produccion->get_producto();
            $data['unidad'] = $this->salida_produccion->get_unidad();
            $data['lst_salida'] = $this->salida_produccion->get_reporte_salida();

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'produccion/salida_produccion';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function datos_salida($id){
        $data = $this->salida_produccion->get_salida($id);
        $data=json_encode($data);
        echo $data;
}
public function get_lote_salida(){
    $id = $this->input->post('id_lote');
    $data=$this->salida_produccion->get_lote_salida($id);
    echo json_encode($data);
}
public function dlt_salida($id,$login){
    $this->salida_produccion->eliminar_salida($id,$login);
    redirect('salida_produccion');
}
public function confirmar_salida($id_lote){
    $data=$this->salida_produccion->confirmar_salida($id_lote);
    echo json_encode($data);
}
public function add_salida_produccion(){
    $id_lot= $this->input->post('id_lote');
    $login= $this->session->userdata('usuario');
    $productArray= array();
    for ($i = 0; $i <= $this->input->post('count'); $i++) {
  
            $productArray[$i] = array(
                'id_destino' => $this->input->post('id_destino'. $i),
                'id_producto' => $this->input->post('id_producto' . $i),
                'cantidad' => $this->input->post('cantidad'. $i),
                'id_unidad' => $this->input->post('id_unidad'. $i),
            );
        
    }
    $data = array(
        'fecha' => $this->input->post('fecmes'),
        'hora' => $this->input->post('hora'),
        'productos' => $productArray,
    );

    $json=json_encode($data);
         $data_insert = $this->salida_produccion->set_salida($id_lot,$login,$json);
            if ($data_insert) {
                 $this->session->set_flashdata('success','Registro insertado exitosamente.');
             } else {
                 $this->session->set_flashdata('error','Error al insertar Registro.');
             }
     redirect('salida_produccion');
}

    public function get_product_lote(){
        $id_lote = $this->input->post('lote');
        $data = $this->salida_produccion->get_productos_lote($id_lote);
        echo json_encode($data);
    }
}
