<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Alison Paola Pari Pareja Fecha:14/12/2022   GAN-MS-A3-0182,
Descripcion: Se realizo la implementacion del modulo IMPORTAR , para que todos los datos que se suban a la tabla ope_importacion
mediante la funcion add_datos()

*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_importar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->library('Pdf');
        $this->load->library('excel');
        $this->load->model('producto/M_importar','importar');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['ubicaciones'] = $this->importar->get_ubicacion_cmb();
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'producto/importar';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function datos_producto_excel() {
        date_default_timezone_set('America/La_Paz');
        $fechaActual = date('d/m/y h:i:s');
        $nom_archivo = str_replace("/", "", str_replace(":", "", $fechaActual));
        $vec = array();
        $path = './assets/docs/productos/';
        $mi_archivo = 'archivo';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'xlsx|csv|xls';
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $config['file_name'] = "productos_" . $nom_archivo;
        $config['overwrite'] =TRUE;
        require_once APPPATH . "/third_party/PHPExcel.php";
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data());
            $nom_archivo = $data['upload_data']['file_name'];
        }
        if(empty($error)){
            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, null, true);
                $column = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K",
                "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
                $abc = array("Categoria","Marca","Codigo_Producto","Codigo_Alternativo","Nombre_Producto","Descripcion_Producto",
                "Cantidad_en_Stock","Precio_Unitario_de_Compra","Precio_Unitario_de_Venta");
                $flag = true;
                $existe=0;
                foreach ($allDataInSheet as $value) {
                    if($flag){
                        for($j = 0; $j < count($column); ++$j) {
                            $var=trim($value[$column[$j]]);;
                            if(!empty($var)){
                                if($var != "" && $var != null && $var != " "){
                                    $existe=$existe+1;
                                }
                            }
                        }
                        if($existe != 0){
                            for($k = 0; $k < count($column); ++$k) {
                                if(!empty($value[$column[$k]])){
                                    $vec[] = array("texto" => $value[$column[$k]],"columna" => $column[$k],"valor" => false);
                                }
                            }
                            $flag =false;
                        }
                    }
                }  
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                . '": ' .$e->getMessage());
            }
        }
        $nro=0;
        for($i = 0, $size = count($abc); $i < $size; ++$i) {
            for ($j=0; $j < count($vec) ; $j++) {
                $x=$vec[$j];
                if (!$x["valor"]) {
                    $t=str_replace(" ", "", $x["texto"]);
                    $t=$this->eliminar_acentos($t);
                    if (preg_match('/'.$abc[$i].'/i', $t)){
                        $vec2[$nro] = array("nombre" =>$abc[$i],"valor" => $x["columna"]);
                        $x["valor"]=true;
                        $reemp = array($j => $x);
                        $vec = array_replace($vec,$reemp);
                        $j=count($vec);
                        $nro=$nro+1;
                    }
                }
            }
        }

        $data= array('lista'=>$vec,'encontrados'=>$vec2,'ruta' => $inputFileName, 'rawname' => $nom_archivo);
        echo json_encode($data);
    }

    
    public function eliminar_acentos($cadena){
		
		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);
		
		return $cadena;
	}
    public function add_datos()
    {
        if ($this->session->userdata('login')) {
            $c_categoria = $this->input->post('c_categoria');
            $c_marca = $this->input->post('c_marca');
            $c_codigo = $this->input->post('c_codigo');
            $c_codigo_alt = $this->input->post('c_codigo_alt');
            $c_producto = $this->input->post('c_producto');
            $c_caracteristica = $this->input->post('c_caracteristica');
            $c_cantidad = $this->input->post('c_cantidad');
            $c_precio_compra = $this->input->post('c_precio_compra');
            $c_precio_venta = $this->input->post('c_precio_venta');
            $ruta = $this->input->post('ruta');
            $rawname = $this->input->post('rawname');
            $id_ubicacion = $this->input->post('id_ubicacion');

            $inputFileType = PHPExcel_IOFactory::identify($ruta);
            $objReader = new PHPExcel_Reader_Excel2007();
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($ruta);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, null, true);

            $columLength = sizeof($allDataInSheet);

            $array_categoria = [];
            $array_marca = [];
            $array_codigo = [];
            $array_codigoalt = [];
            $array_producto = [];
            $array_caracteristica = [];
            $array_cantidad = [];
            $array_preciocompra = [];
            $array_precioventa = [];
      

            for ($i = 2; $i <= $columLength; $i++) {
                array_push($array_categoria, $allDataInSheet[$i][$c_categoria]);
                array_push($array_marca, $allDataInSheet[$i][$c_marca]);
                array_push($array_codigo, $allDataInSheet[$i][$c_codigo]);
                array_push($array_codigoalt, $allDataInSheet[$i][$c_codigo_alt]);
                array_push($array_producto, $allDataInSheet[$i][$c_producto]);
                array_push($array_caracteristica, $allDataInSheet[$i][$c_caracteristica]);
                array_push($array_cantidad, $allDataInSheet[$i][$c_cantidad]);
                array_push($array_preciocompra, $allDataInSheet[$i][$c_precio_compra]);
                array_push($array_precioventa, $allDataInSheet[$i][$c_precio_venta]);
                
            }
            $vector = [
                $array_categoria,
                $array_marca,
                $array_codigo,
                $array_codigoalt,
                $array_producto,
                $array_caracteristica,
                $array_cantidad,
                $array_preciocompra,
                $array_precioventa,
            ];

           /*  for ($i = 0; $i < sizeof($vector); $i++) {
                for ($j = 0; $j < sizeof($vector[0]); $j++) {
                    $actual = $vector[$i][$j];
                    if ($actual == null) {
                        $vector[$i][$j] = "";
                    }
                }
            } */


            $datos_guardados = $this->importar->insert_datos_masivos($vector, $rawname,$id_ubicacion);
            $data = array(
                'archivo' => $rawname,
                'usucre' => $this->session->userdata('usuario')
            );
            $arch_insert = $this->importar->insert_archivo($data);
            $idusuario = $this->session->userdata('id_usuario');
            $insert = $this->importar->M_fn_migracion_masiva($rawname,$idusuario);
                
            
            echo json_encode($insert);
        } else {
            redirect('logout');
        }
    }
    public function lst_archivos()
    {
        $lst_archivos = $this->importar->get_lst_archivos();
        $data = array('responce' => 'success', 'posts' => $lst_archivos);
        echo json_encode($data);
    }
}
