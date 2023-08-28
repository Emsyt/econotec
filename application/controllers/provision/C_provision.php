<?php 
/*------------------------------------------------------------------------------
  Modificado: Heidy Soliz Santos  Fecha:28/06/2021, Codigo:GAM-030
  Descripcion: Se modifico el formulario para guardar el  precio de venta
  ------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:11/11/2021, Codigo: GAN-MS-A6-083,
  Descripcion: Se modifico al modulo de ECOGAN , ABASTECIMIENTO para recuperar
               los valores de precios de compra y de venta de acuerdo a lo 
               explicado en la reunion
 ------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Pareja Fecha:14/04/2021, Codigo: GAN-MS-A0-156,
  Descripcion: Se modifico la funcion add_compra() , insertando un producto con la 
  funcion dada fn_registrar_abastecimiento
  ------------------------------------------------------------------------------
  Modificado: Kevin Mauricio Larrazabal Calle Fecha:23/08/2022, Codigo: GAN-SC-M3-369,
  Descripcion: Se modifico la funcion confirmar_provision, para recibir datos 
  de M_provicion/confirmar_provision
  ------------------------------------------------------------------------------
Modificado: Keyla Paola Usnayo Aguilar Fecha:28/09/2022, Codigo: GAN-MS-A1-487,
Descripcion: Se modifico la funcion de add_compra() para que se muestre el tipo de unidad 
que se selecciono en el select unidad
------------------------------------------------------------------------------
Modificado: Brayan Janco Cahuana Fecha:28/11/2022, Codigo: GAN-MS-A6-0139
Descripcion: Se modifico la funcion add_compra para que guarde los datos del switch de IVA y de GARANTIA
----------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja  Fecha: 29/12/2022 Codigo:GAN-MS-A7-0188
Descripcion: Se modifico el modulo de provision para incluir el ingreso de diferentes precios de venta  
----------------------------------------------------------------------------------------
Modificado: Briyan Julio Torrez Vargas        Fecha: 15/02/2023 Codigo:GAN-MS-B1-0275
Descripcion: Se modifico la funcion confirmar provision, para que se envien los mensajes flashdata
----------------------------------------------------------------------------------------
Modificado: Kevin Gerardo Alcon Lazarte Fecha: 28/03/2023 Codigo:GAN-DPR-M1-0373
Descripcion: Se agregaron las funciones de editar y de get_edit
----------------------------------------------------------------------------------------
Modificado: Kevin Gerardo Alcon Lazarte  Fecha: 05/04/2023 Codigo:GAN-MS-M4-0391
Descripcion: Se edito las funciones de editar y de get_edit
----------------------------------------------------------------------------------------
Modificado: Ayrton Jhonny Guevara Montaño  Fecha: 26/04/2023 Codigo:GAN-MS-B1-0437
Descripcion: Se añadio consignacion la forma de obtencion de pago a confirmar_provision
y se pasa una variable mas a la funcion correspondiente
----------------------------------------------------------------------------------------
*/

?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_provision extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('produccion/M_produccion', 'produccion');
        $this->load->model('provision/M_provision','provision');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $id_ubicacion = $this->session->userdata('ubicacion');
            $login = $this->session->userdata('usuario');

            $data['proveedores'] = $this->provision->get_proveedor_cmb();
            $data['productos'] = $this->provision->get_producto_cmb($id_ubicacion);
            $data['destinos'] = $this->provision->get_destino_cmb($id_ubicacion);

            $data['lst_compras'] = $this->provision->get_lst_compra($login);
            $data['contador'] = $this->provision->contador_provisiones($login);
            $data['monto_total'] = $this->provision->get_precio_total($login);

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['unidad'] = $this->produccion->get_unidad();
            $data['contenido'] = 'provision/abastecimiento';
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function recuperar_precio(){
        $usuario=$this->session->userdata('id_usuario');
        $prov  = $this->input->post('prov');
        $prod  = $this->input->post('prod');
        $datos = $this->provision->recuperar_precio_abastecimiento($usuario,$prov,$prod);       
		echo json_encode($datos); 
    }

  
    public function add_compra(){
        $fecha_ven= $this->input->post('fecha_vencimiento');
        if($fecha_ven ==""){
            $fecha_ven=null;
        }
        $precio_form = $this->input->post('precio_compra');
        $precio_ven  = $this->input->post('precio_venta');
        $cantidad = $this->input->post('cantidad');

        if ($this->input->post('tipo_precio') == 'unidad') {
               $precio = $precio_form * $cantidad;
               $precio_venta = $precio_ven * $cantidad;
        } else if ($this->input->post('tipo_precio') == 'lote') {
            $precio = $precio_form;
            $precio_venta = $precio_ven;
        }

        $data = array(
            'id_ubicacion' => $this->input->post('des_provision'),
            'id_personas' => $this->input->post('proveedor'),
            'id_producto' => $this->input->post('producto'),
            'cantidad' => $cantidad,
            'unidad' => $this->input->post('tipo_unidad'),
            'precio' => $precio,
            'precio_venta' => $precio_venta,
            'iva' => $this->input->post('iva'),
            'usucre' => $this->session->userdata('usuario'),
            'apiestado' => 'SOLICITUD',
            'fecha_vencimiento'=>$fecha_ven
        );

        $json = json_encode($data);
        $idlogin = $this->session->userdata('id_usuario');
        $prov_insert = $this->provision->insert_provision($idlogin,$json);
        echo json_encode($prov_insert);


        $precioArray = array();
        for ($i = 0; $i <= $this->input->post('count'); $i++) {
            if ($this->input->post('descripcion' . $i) != null) {
                $precioArray[$i] = array(
                    'descripcion' => $this->input->post('descripcion' . $i),
                    'precio_venta' => $this->input->post('precio_venta' . $i),
                );
            }
        }
        $data1 = array(
            'id_producto' => $this->input->post('producto'),
            'precios' => $precioArray,
        );

        $json1 = json_encode($data1);
        echo json_encode($data1);
        $precio_insert = $this->provision->insert_precios($idlogin,$json1);
        redirect('provision');
    }


    public function confirmar_provision(){
        $login = $this->session->userdata('usuario');
        $id_usuario = $this->session->userdata('id_usuario');
        $id_ubicacion = $this->session->userdata('ubicacion');
        $pago = $this->input->post('forma_pago');

        if ($pago == 'total') {
            $precio = $this->input->post('monto_total');
            echo $pago;
        } else if ($pago == 'parcial') {
            $precio = $this->input->post('monto_deuda');
            //Ayrton Guevara M. 26/04/2023 GAN-MS-B1-0437
        } else if ($pago == 'deuda' || $pago == 'consignacion' ) {
            $precio = 0;
        }
        $com_update = $this->provision->confirmar_provision($login, $id_usuario, $id_ubicacion, $precio, $pago);
        //Fin  Ayrton Guevara M. 26/04/2023 GAN-MS-B1-0437
        $resp = $com_update[0]->oboolean;
        if($resp == "t"){
            $this->session->set_flashdata('success','Provision confirmada exitosamente.');
        }else{
            $this->session->set_flashdata('error','Error al confirmar provision.');
        }
        redirect('provision');
        // Fin KLarrazabal, 23/08/2022, GAN-SC-M3-369
    }

    public function dlt_provision($id_prov){
        $data = array(
            'apiestado' => 'ANULADO',
            'usumod' => $this->session->userdata('usuario'),
            'fecmod' => date('Y-m-d H:i:s')
        );
        $prov_delete = $this->provision->delete_provision($id_prov, $data);
        
        if($prov_delete[0]->ovalor == 1){
            $this->session->set_flashdata('success','Registro eliminado exitosamente.');
        }else{
            $this->session->set_flashdata('error','Error al eliminar Registro.');
        }
        redirect('provision');
    }
    //Inicio ALKG 05/04/2023 GAN-MS-M4-0391
    //Inicio ALKG 27/03/2023 GAN-DPR-M1-0373
    public function get_edit($id_lote,$id_prov){
        $data = $this->provision->get_edit_fil($id_lote, $id_prov);
        echo json_encode($data);
    }
    public function editar($edit_lote){ 
        $oprovision = $this->input->post('provision');
        $oproveedor = $this->input->post('proveedor');
        $oproducto = $this->input->post('producto');
        $ocantidad = $this->input->post('cantidad');
        $oid_unidad0 = $this->input->post('id_unidad0');
        $oprecio_compra = $this->input->post('precio_compra');
        $oprecio_venta = $this->input->post('precio_venta');
        $odes_provision = $this->input->post('des_provision');
        $ofecha_vencimiento = $this->input->post('fecha_vencimiento');
        
        if($ofecha_vencimiento ==""){
            $ofecha_vencimiento=null;
        }
        $precio_form = $this->input->post('precio_compra');
        $precio_ven  = $this->input->post('precio_venta');
        // $cantidad = $this->input->post('cantidad');

        if ($this->input->post('tipo_precio') == 'unidad') {
            $oprecio_compra = $oprecio_compra * $ocantidad;
            $oprecio_venta =  $oprecio_venta * $ocantidad;
        } else if ($this->input->post('tipo_precio') == 'lote') {
            $oprecio_compra  = $precio_form;
            $oprecio_venta  = $precio_ven;
        }
        // $data = array(
        //     'oprovision' => $oprovision,
        //     'edit_lote'=> $edit_lote,
        //     'oproveedor' => $oproveedor,
        //     'oproducto'=> $oproducto,
        //     'ocantidad' => $ocantidad,
        //     'oid_unidad0' => $oid_unidad0,
        //     'oprecio_compra'=> $oprecio_compra,
        //     'oprecio_venta' => $oprecio_venta,
        //     'odes_provision'=> $odes_provision,
        //     'ofecha_vencimiento'=> $ofecha_vencimiento
        // );
        $data = $this->provision->editar_fila($oprovision,$edit_lote,$oproveedor,$oproducto,$ocantidad,$oid_unidad0,$oprecio_compra,$oprecio_venta,$odes_provision,$ofecha_vencimiento);
        echo json_encode($data);
    }
    //FIN ALKG 27/03/2023 GAN-DPR-M1-0373
    //FIN ALKG 05/04/2023 GAN-MS-M4-0391
}
