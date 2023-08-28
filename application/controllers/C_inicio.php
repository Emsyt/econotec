<?php 
/*
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:09/11/2021, Codigo: GAN-MS-A1-068
  Descripcion: Se modifico en la funciones de func_auxiliares para que se reciban y envie los datos de lts_productos_mas_vendidos y lts_productos_menos_vendidos
  
  -------------------------------------------------------------------------------
  Modificado: Fabian Alejandro Candia Alvizuri Fecha:015/11/2021, Codigo: GAN-MS-A1-073
  Descripcion: Se modifico en la funciones de func_auxiliares para corregir el ingreso del dashboard
  
  -------------------------------------------------------------------------------
  Modificado: Fabian Alejandro Candia Alvizuri Fecha:016/11/2021, Codigo: GAN-PN-A4-089
  Descripcion: Se modifico en la funciones de func_auxiliares para corregir el gasto del dashboard
  
  -------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:21/04/2022, Codigo: GAN-MS-A0-180
  Descripcion: Se modifico en la funciones de func_auxiliares para que devuelva los datos para
  el grafico de ingresos y egresos.
  --------------------------------------------------------------------------
  Modificado: Melani Alisson Cusi Burgoa  Fecha:28/10/2022, Codigo: GAN-MS-A2-0077
  Descripcion: Se modifico en la funciones de func_auxiliares ppara que devuelva los datos para
  el grafico de los diez mejores clientes.
  -------------------------------------------------------------------------------
  Modificado: Brayan Janco Cahuana Fecha:17/11/2022, Codigo: GAN-MS-A7-0108
  Descripcion: Se modifico en la funciones de func_auxiliares en el caso de indic_inicio 
  */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class C_inicio extends CI_Controller {
    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('login')) {
            redirect(base_url());
        }
        $this->load->model(array('M_login' => 'login'));
    }

    public function index(){
        if ($this->session->userdata('login')) {
            $data['lib'] = 0;
            $data['datos_menu'] = $this->setpermiso();
            //la cantidad y listado de notificaciones
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'inicio';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function leer_notificacion($id_notificacion){
        $success= $this->general->leer_notificacion($id_notificacion);
        //$data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
        echo json_encode($success);
    }

    public function verificar_hora($hour,$date){
        $resp= $this->general->verificar_hora($hour,$date);
        echo json_encode($resp);
    }

    public function verificar_apertura_caja($fechahoy){
        $resp = $this->general->verificar_apertura_caja($fechahoy);
        echo json_encode($resp);
    }
    
    function setpermiso(){
        $login=$this->session->userdata('login');
        if($login) {
            $accesos['permisos'] = $this->session->userdata('permisos');
            return $accesos;
        }
    }

    public function getRealIP(){
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
            return $_SERVER["REMOTE_ADDR"];
    }

    public function getBrowser($user_agent){
        if(strpos($user_agent, 'MSIE') !== FALSE)
           return 'Internet explorer';
         elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
           return 'Microsoft Edge';
         elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
            return 'Internet explorer';
         elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
           return "Opera Mini";
         elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
           return "Opera";
         elseif(strpos($user_agent, 'Firefox') !== FALSE)
           return 'Mozilla Firefox';
         elseif(strpos($user_agent, 'Chrome') !== FALSE)
           return 'Google Chrome';
         elseif(strpos($user_agent, 'Safari') !== FALSE)
           return "Safari";
         else
           return 'No hemos podido detectar su navegador';
    }



    //------- FUNCIONES AUXILIARES -------//
    public function func_auxiliares(){

        try{
            $accion = $_REQUEST['accion'];
            if(empty($accion))
                //echo "aca accion" .$accion;
                throw new Exception("Error accion no valida");
            //$cmb = new Combo_box();
            switch($accion)
            {
                case 'indic_inicio':
                    $data['fmes'] = $fmes = $this->input->post('selc_fmes');

                    $data['anno'] = $anno = date("Y", strtotime($fmes));
                    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                    $data['mes'] = $mes = $mes[(date('m', strtotime($fmes))*1)-1];

                    $data['datos_ind'] = $this->general->detalle_indicadores($fmes);
                    $nmes = (date('m', strtotime($fmes))*1);
                    $data['monto_ingreso'] = $this->general->monto_ingreso($nmes,$anno);
                    echo "<script>console.log('" . $data['monto'] . "' );</script>";
                    $data['monto_gasto'] = $this->general->monto_gasto($nmes,$anno);

                    
                    $this->load->view('indicadores_inicio', $data);
                break;

                case 'graf_inicio':
                    $data['fmes'] = $fmes = $this->input->post('selc_fmes');

                    $anno = date("Y", strtotime($fmes));
                    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                    
                    $mes_num = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
                    $mes_num = $mes_num[(date('m', strtotime($fmes))*1)-1];
                    $fecha = $mes_num.'/'.$anno;

                    $mes = $mes[(date('m', strtotime($fmes))*1)-1];

                    $data['titulo'] = "GRÁFICA DE VENTAS DE LOS VENDEDORES POR MES";
                    $data['subtitulo'] = "Ventas del mes de $mes del $anno ";
                    $data['titulo_x'] = "Detalle de vendedores";
                    $data['titulo_y'] = "Cantidad de Ventas";

                    $data['datos_graf'] = $this->general->detalle_grafico($fmes);

                    $lts_ingresos_egresos = $this->general->lts_ingresos_egresos($fecha);

                    $ingreso=[];
                    $egreso=[];
                    foreach ($lts_ingresos_egresos as $entrada):
                        if($entrada->otipo=='ingreso'){
                            array_push($ingreso,(int)$entrada->ocantidad);
                        }else{
                            array_push($egreso,(int)$entrada->ocantidad);
                        }
                    endforeach;
                    $data['ingresos']= json_encode($ingreso);
                    $data['egresos']= json_encode($egreso);


                    $fechas = $this->general->fechas($fecha);
                    $fec=[];
                    foreach ($fechas as $fech):
                        array_push($fec,$fech->ofecha);
                    endforeach;
                    $data['fechas']= json_encode($fec);

                    $lts_mas_vendidos = $this->general->lts_productos_mas_vendidos($fecha);
                    $mas_vendidos_producto = [];
                    $mas_vendidos_cantidad = [];
                    foreach ($lts_mas_vendidos as $lts):
                        array_push($mas_vendidos_producto,$lts->oproducto);
                        array_push($mas_vendidos_cantidad,(int)$lts->ocantidad);
                    endforeach;
                    $data['lts_mas_vendidos_producto'] = json_encode($mas_vendidos_producto);
                    $data['lts_mas_vendidos_cantidad'] = json_encode($mas_vendidos_cantidad);

                    $lts_menos_vendidos = $this->general->lts_productos_menos_vendidos($fecha);
                    $menos_vendidos = [];
                    foreach ($lts_menos_vendidos as $lts):
                        $producto=array($lts->oproducto,(int)$lts->ocantidad);
                        array_push($menos_vendidos,$producto);
                    endforeach;
                    $data['lts_menos_vendidos_producto'] = json_encode($menos_vendidos);

                    $mejores_clientes = $this->general->lst_diez_mejores_clientes($fecha);
                    $diez_mejores_clientes = [];
                    $diez_mejores_clientes_monto = [];
                    foreach ($mejores_clientes as $lts):
                        array_push($diez_mejores_clientes,$lts->onombre);
                        array_push($diez_mejores_clientes_monto,(int)$lts->ototal);
                    endforeach;
                    $data['lts_diez_mejores_clientes'] = json_encode($diez_mejores_clientes);
                    $data['lts_diez_mejores_clientes_monto'] = json_encode($diez_mejores_clientes_monto);

                    $this->load->view('grafico_inicio', $data);
                  break;
                default;
                    echo 'Error: Accion no encontrada';
            }
        }
        catch(Exception $e)
        {
            $log['error'] = $e;
        }
    }

}
