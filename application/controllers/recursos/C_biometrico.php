<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Creado: Alison Paola Pari Pareja Fecha:07/03/2023   GAN-DPR-M0-0340,
Descripcion: Se creo el controlador del sub modulo de biometrico y el reconocimiento de las columnas al cargar un archivo

*/
defined('BASEPATH') or exit('No direct script access allowed');

class C_biometrico extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->library('Pdf');
        $this->load->library('excel');
        $this->load->model('recursos/M_biometrico', 'biometrico');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'recursos/biometrico';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }

    public function lst_archivos_biometrico()
    {
        $lst_archivos = $this->biometrico->get_lst_archivos_biometrico();
        $data = array('responce' => 'success', 'posts' => $lst_archivos);
        echo json_encode($data);
    }

    public function add_biometrico()
    {
        if ($this->session->userdata('login')) {
            $fecha_inicial = $this->input->post('fecha_inicial');
            $fecha_final = $this->input->post('fecha_final');
            $c_usuario = $this->input->post('c_usuario');
            $c_fecha = $this->input->post('c_fecha');
            $c_hora_ingreso = $this->input->post('c_hora_ingreso');
            $c_hora_salida = $this->input->post('c_hora_salida');
            $rawname = $this->input->post('rawname');
            $ruta = $this->input->post('ruta');

            $inputFileType = PHPExcel_IOFactory::identify($ruta);
            $objReader = new PHPExcel_Reader_Excel2007();
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($ruta);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, null, true);

            $columLength = sizeof($allDataInSheet);

            $arrayUser = [];
            $arrayFecha = [];
            $arrayHoraIngreso = [];
            $arrayHoraSalida = [];

            /* SE AGREGAN LOS VALORES DEL EXCEL A LOS ARRAYS */
            for ($i = 2; $i <= $columLength; $i++) {
                array_push($arrayUser, $allDataInSheet[$i][$c_usuario]);

                $fecha = $allDataInSheet[$i][$c_fecha];
                $fecha_datetime = PHPExcel_Shared_Date::ExcelToPHPObject($fecha); // Convertir el valor a un objeto DateTime
                $fecha = $fecha_datetime->format('Y-m-d'); // Formatear el objeto DateTime como fecha en formato YYYY-MM-DD
                array_push($arrayFecha, strval($fecha));

                $hora_ing = $allDataInSheet[$i][$c_hora_ingreso];
                $hora_datetime_ing = PHPExcel_Shared_Date::ExcelToPHPObject($hora_ing); // Convertir el valor a un objeto DateTime
                $hora_ing = $hora_datetime_ing->format('H:i:s');
                array_push($arrayHoraIngreso, strval($hora_ing));

                $hora_sal = $allDataInSheet[$i][$c_hora_salida];
                $hora_datetime = PHPExcel_Shared_Date::ExcelToPHPObject($hora_sal); // Convertir el valor a un objeto DateTime
                $hora_sal = $hora_datetime->format('H:i:s');
                array_push($arrayHoraSalida, strval($hora_sal));
            }

            /* Se empaquetan en un array  */
            $vector = [
                $arrayUser,
                $arrayFecha,
                $arrayHoraIngreso,
                $arrayHoraSalida
            ];

            $datos_guardados = $this->biometrico->insert_biometrico_masivo($vector, $rawname);


            if ($datos_guardados[0]->oboolean == 't') {
                $this->session->set_flashdata('success', 'Archivo almacenado con exito.');
            } else {
                $this->session->set_flashdata('error', 'Error al almacenar archivo.');
            }
            echo json_encode(true);
        } else {
            redirect('logout');
        }
    }

    public function add_biometrico_dat()
    {
        if ($this->session->userdata('login')) {
            $c_usuario = $this->input->post('c_usuario');
            $c_fecha = $this->input->post('c_fecha');
            $c_hora = $this->input->post('c_hora');
            $c_dato1 = $this->input->post('c_dato1');
            $c_dato2 = $this->input->post('c_dato2');
            $c_dato3 = $this->input->post('c_dato3');
            $c_dato4 = $this->input->post('c_dato4');
            $rawname = $this->input->post('rawname');
            $ruta = $this->input->post('ruta');

            /* Variables */
            $ci_dat = array();
            $fecha_dat = array();
            $hora_dat = array();
            $dato1_dat = array();
            $dato2_dat = array();
            $dato3_dat = array();
            $dato4_dat = array();

            $archivo = fopen($ruta, "r");
            if ($archivo) {
                $linea = fgets($archivo);
                while ($linea) {

                    $variables = preg_split('/\s+/', $linea);
                    array_push($ci_dat, $variables[1]);
                    array_push($fecha_dat, $variables[2]);
                    array_push($hora_dat, $variables[3]);
                    array_push($dato1_dat, $variables[4]);
                    array_push($dato2_dat, $variables[5]);
                    array_push($dato3_dat, $variables[6]);
                    array_push($dato4_dat, $variables[7]);
                    $linea = fgets($archivo);
                }
                
                fclose($archivo);
                $vector = array(
                    'var0' => $ci_dat,
                    'var1' => $fecha_dat,
                    'var2' => $hora_dat,
                    'var3' => $dato1_dat,
                    'var4' => $dato2_dat,
                    'var5' => $dato3_dat,
                    'var6' => $dato4_dat
                );
                $data= array(
                    'usuario'=>$vector[$c_usuario],
                    'fecha'=>$vector[$c_fecha],
                    'hora'=>$vector[$c_hora],
                    'dato1'=>$vector[$c_dato1],
                    'dato2'=>$vector[$c_dato2],
                    'dato3'=>$vector[$c_dato3],
                    'dato4'=>$vector[$c_dato4]
                );
                $datos_guardados = $this->biometrico->insert_biometrico_masivo_dat($data, $rawname);


                if ($datos_guardados) {
                    $this->session->set_flashdata('success', 'Almacenamiento masivo realizado con exito!');
                } else {
                    $this->session->set_flashdata('error', 'Error al almacenar datos.');
                }
                echo json_encode(true);
                
            } else {
                echo "No se pudo abrir el archivo";
            }
        }
    }
    public function datos_biometrico_excel()
    {
        date_default_timezone_set('America/La_Paz');
        $fechaActual = date('d/m/y h:i:s');
        $nom_archivo = str_replace("/", "", str_replace(":", "", $fechaActual));
        $vec = array();
        $path = './assets/docs/biometrico/';
        $mi_archivo = 'archivo';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'xlsx|csv|xls';
        $config['max_size'] = "0";
        $config['max_width'] = "0";
        $config['max_height'] = "0";
        $config['file_name'] = "biometrico_" . $nom_archivo;
        $config['overwrite'] = TRUE;
        require_once APPPATH . "/third_party/PHPExcel.php";
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($mi_archivo)) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data());
            $nom_archivo = $data['upload_data']['file_name'];
        }
        if (empty($error)) {
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
                $column = array(
                    "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K",
                    "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
                );
                $abc = array("Usuario", "Fecha", "Hora_ingreso", "Hora_salida");
                $flag = true;
                $existe = 0;
                foreach ($allDataInSheet as $value) {
                    if ($flag) {
                        for ($j = 0; $j < count($column); ++$j) {
                            $var = trim($value[$column[$j]]);;
                            if (!empty($var)) {
                                if ($var != "" && $var != null && $var != " ") {
                                    $existe = $existe + 1;
                                }
                            }
                        }
                        if ($existe != 0) {
                            for ($k = 0; $k < count($column); ++$k) {
                                if (!empty($value[$column[$k]])) {
                                    $vec[] = array("texto" => $value[$column[$k]], "columna" => $column[$k], "valor" => false);
                                }
                            }
                            $flag = false;
                        }
                    }
                }
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
            }
        }
        $nro = 0;
        for ($i = 0, $size = count($abc); $i < $size; ++$i) {
            for ($j = 0; $j < count($vec); $j++) {
                $x = $vec[$j];
                if (!$x["valor"]) {
                    $t = str_replace(" ", "", $x["texto"]);
                    $t = $this->eliminar_acentos($t);
                    if (preg_match('/' . $abc[$i] . '/i', $t)) {
                        $vec2[$nro] = array("nombre" => $abc[$i], "valor" => $x["columna"]);
                        $x["valor"] = true;
                        $reemp = array($j => $x);
                        $vec = array_replace($vec, $reemp);
                        $j = count($vec);
                        $nro = $nro + 1;
                    }
                }
            }
        }

        $data = array('lista' => $vec, 'encontrados' => $vec2, 'ruta' => $inputFileName, 'rawname' => $nom_archivo);
        echo json_encode($data);
    }

    public function datos_biometrico_dat()
    {

        /* Variables */
        $ci_dat = array();
        $fecha_dat = array();
        $hora_dat = array();
        $dato1_dat = array();
        $dato2_dat = array();
        $dato3_dat = array();
        $dato4_dat = array();

        /* Crear archivo en assets */
        date_default_timezone_set('America/La_Paz');
        $fechaActual = date('d/m/y h:i:s');
        $nom_archivo = str_replace(" ", "_", str_replace("/", "", str_replace(":", "", $fechaActual)));
        $path = './assets/docs/biometrico/';

        if ($this->input->post() && isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
            $ruta_temporal = $_FILES['archivo']['tmp_name'];
            $nombre_archivo = $_FILES['archivo']['name'];
            $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
            if ($extension == 'dat') {

                $contenido = file_get_contents($ruta_temporal);;
                $nuevoarchivodat = $path . $nom_archivo . ".dat";
                file_put_contents($nuevoarchivodat, $contenido);

                $archivo = fopen($ruta_temporal, "r");
                $linea = fgets($archivo);
                while ($linea) {

                    $variables = preg_split('/\s+/', $linea);
                    array_push($ci_dat, $variables[1]);
                    array_push($fecha_dat, $variables[2]);
                    array_push($hora_dat, $variables[3]);
                    array_push($dato1_dat, $variables[4]);
                    array_push($dato2_dat, $variables[5]);
                    array_push($dato3_dat, $variables[6]);
                    array_push($dato4_dat, $variables[7]);
                    $linea = fgets($archivo);
                }
                fclose($archivo);
                $variables_encontradas = array();
                array_push($variables_encontradas, $ci_dat);
                array_push($variables_encontradas, $fecha_dat);
                array_push($variables_encontradas, $hora_dat);
                array_push($variables_encontradas, $dato1_dat);
                array_push($variables_encontradas, $dato2_dat);
                array_push($variables_encontradas, $dato3_dat);
                array_push($variables_encontradas, $dato4_dat);
            }
            $data = array('variables_encontradas' => $variables_encontradas, 'ruta' => $nuevoarchivodat, 'rawname' => $nom_archivo);
            echo json_encode($data);
        } else {
            echo "No se pudo subir el archivo";
        }
    }

    public function eliminar_acentos($cadena)
    {

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
            $cadena
        );

        //Reemplazamos la I y i
        $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena
        );

        //Reemplazamos la O y o
        $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena
        );

        //Reemplazamos la U y u
        $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena
        );

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $cadena
        );

        return $cadena;
    }
}
