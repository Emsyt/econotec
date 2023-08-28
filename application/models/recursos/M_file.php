<?php
/*A
---------------------------------------------------------------------------------------
Creacion: Ariel Ramos Paucara Fecha 15/03/2023, Codigo: GAN-MS-M0-0357
Descripcion: se realizo el modulo de recursos submodulo file personal 
segun actividad GAN-MS-M0-0357
---------------------------------------------------------------------------------------
Creacion: Oscar Laura Aguirre Fecha 23/03/2023, Codigo: GAN-MS-M4-0368
Descripcion: Se implemento la funcion mostrar_usuario_dt y actualizar_usuario_dt
mostrar el usuario actual y modificar el usuario actual
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 30/03/2023, Codigo: GAN-MS-B5-0387 
Descripcion: Se esta enviando el campo expedido para que pueda enviar a la 
base de datos y posterior actualizarlo.
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 13/04/2023, Codigo: GAN-MS-M0-0407
Descripcion: se agrego la funcion get_listar_formacion_academica para obtener 
los registro y listarlos.
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 13/04/2023, Codigo: GAN-MS-M5-0435
Descripcion: se agrego la funcionregistrar_curso get_listar_cursos para obtener 
los registro y listarlos.
*/

?>
<?php
class M_file extends CI_Model
{

    public function get_residencia()
    {
        $query = $this->db->query("SELECT * FROM fn_listar_residencia()");
        return $query->result();
    }

    public function get_nacionalidad()
    {
        $query = $this->db->query("SELECT * FROM fn_listar_nacionalidad()");
        return $query->result();
    }

    public function get_genero()
    {
        $query = $this->db->query("SELECT * FROM fn_listar_genero()");
        return $query->result();
    }

    public function get_civil()
    {
        $query = $this->db->query("SELECT * FROM fn_listar_civil()");
        return $query->result();
    }

    public function get_nacademico()
    {
        $query = $this->db->query("SELECT * FROM fn_listar_nacademico()");
        return $query->result();
    }

    public function get_certificacion()
    {
        $query = $this->db->query("SELECT * FROM fn_listar_certificacion()");
        return $query->result();
    }

    public function get_capacitacion()
    {
        $query = $this->db->query("SELECT * FROM fn_listar_capacitacion()");
        return $query->result();
    }
    public function mostrar_usuario_dt($id_usr)
    {
        $query = $this->db->query("SELECT * FROM fn_get_usuario_actual($id_usr)");
        return $query->result();
    }
    public function actualizar_usuario_dt($arr_data)
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M4-0368 */
        $vData = array_values($arr_data);
        $id_usuari = $vData[0];
        $nombre_p_oo = $vData[1];
        $pri_ape_oo = $vData[2];
        $sec_ape_oo = $vData[3];
        $fecha_n_oo = $vData[4];
        $telefono_p_oo = $vData[5];
        $ced_identidad_oo = $vData[6];
        $id_genero_oo = $vData[7];
        $cor_ele_oo = $vData[8];
        /* INICIO Oscar Laura Aguirre GAN-MS-B5-0387  */
        $expedido_oo = $vData[9];
        /* FIN Oscar Laura Aguirre GAN-MS-B5-0387  */
        $sub_archivo_oo = $vData[10];
        $cargo_p_oo = $vData[11];
        $lug_naci_oo = $vData[12];
        $id_residencia0_oo = $vData[13];
        $dir_domi_oo = $vData[14];
        $celular_p_oo = $vData[15];
        $id_nacionalidad_oo = $vData[16];
        $id_ecivil_oo = $vData[17];
        $fec_vin_oo = $vData[18];
        $fec_des_oo = $vData[19];
        $califi_oo = $vData[20];

        $query = $this->db->query("SELECT public.fn_actualizar_usuario_actual(
        '$id_usuari',
        '$nombre_p_oo',
        '$pri_ape_oo',
        '$sec_ape_oo',
        '$fecha_n_oo',
        '$telefono_p_oo',
        '$ced_identidad_oo',
        '$id_genero_oo',
        '$cor_ele_oo',
        /* INICIO Oscar Laura Aguirre GAN-MS-B5-0387  */
        '$expedido_oo',
        /* FIN Oscar Laura Aguirre GAN-MS-B5-0387  */
        '$sub_archivo_oo',
        '$cargo_p_oo',
        '$lug_naci_oo',
        '$id_residencia0_oo',
        '$dir_domi_oo',
        '$celular_p_oo',
        '$id_nacionalidad_oo',
        '$id_ecivil_oo',
        '$fec_vin_oo',
        '$fec_des_oo',
        '$califi_oo')");
        return $query->result();
        /* FIN Oscar Laura Aguirre GAN-MS-M4-0368 */
    }
    public function registrar_formacion_academica($arr_data)
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M0-0407*/
        $vData = array_values($arr_data);
        $id_usuari = $vData[0];
        $nombre_p_oo = $vData[1];
        $pri_ape_oo = $vData[2];
        $sec_ape_oo = $vData[3];
        $fecha_n_oo = $vData[4];
        $telefono_p_oo = $vData[5];
        /*  echo '<pre>';
        print_r($vData);
        echo '</pre>'; */
        $query = $this->db->query("SELECT public.fn_insert_formacion_academica(
        '$id_usuari',
        '$nombre_p_oo',
        '$pri_ape_oo',
        '$sec_ape_oo',
        '$fecha_n_oo',
        '$telefono_p_oo')");
        return $query->result();
        /* FIN Oscar Laura Aguirre GAN-MS-M0-0407 */
    }
    public function get_departamento_cmb()
    {
        $this->db->where('apiestado', 'ELABORADO');
        $query = $this->db->get('cat_departamento');
        return $query->result();
    }
    public function get_listar_formacion_academica($postData = null)
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M0-0407 */
        try {
            $response = array();
            ## Read value
            $draw = $postData['draw'];
            $start = $postData['start'];
            $rowperpage = $postData['length']; // Rows display per page
            $columnIndex = $postData['order'][0]['column']; // Column index
            $columnName = $postData['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
            $searchValue = $postData['search']['value']; // Search value
            $ordernar = 'ofecha';

            switch ($columnName) {
                case 'oid_formacion':
                    $ordernar = 'id_formacion';
                    break;
                case 'ouniversidad':
                    $ordernar = 'universidad';
                    break;
                case 'onivel_acad':
                    $ordernar = 'nivel_acad';
                    break;
                case 'ocertificacion':
                    $ordernar = 'certificacion';
                    break;
                default:
                    # code...
                    break;
            }
            $id_usuario = $this->session->userdata('id_usuario');

            $query = $this->db->query("SELECT * FROM fn_listar_formacion_academica('$ordernar','$columnSortOrder',$rowperpage,$start,'$searchValue');");
            $querytotal = $this->db->query("SELECT fn_total_formacion_academica() as count; ");
            $queryfilter = $this->db->query("SELECT fn_total_formacion_academica_filtrado('$searchValue') as count;;");

            $records      = $query->result();
            $totales      = $querytotal->result();
            $totalRecords = $totales[0]->count;

            $totfilter =  $queryfilter->result();
            $totalRecordwithFilter = $totfilter[0]->count;

            $data = array();

            $status = "Error";

            foreach ($records as $record) {
                $data[] = array(
                    "oid_formacion" => $record->oid_formacion,
                    "ouniversidad" => $record->ouniversidad,
                    "onivel_acad" => $record->onivel_acad,
                    "ocertificacion" => $record->ocertificacion,
                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "columnsna" => $columnName,
                "start" => $start,
                "aaData" => $data
            );

            return $response;
        } catch (Exception $error) {
            $log['error'] = $error;
        }
        /* FIN Oscar Laura Aguirre GAN-MS-M0-0407 */
    }
    public function registrar_curso($arr_data)
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M5-0435  */
        $vData = array_values($arr_data);
        $id_usuari = $vData[0];
        $id_uni_inst_aus_o = $vData[1];
        $id_capacitacion_o = $vData[2];
        $id_nom_cur_sem_tal_o = $vData[3];
        $id_nacademico_o_o = $vData[4];
        $id_fecha_emi_cer_o = $vData[5];
        $id_dur_hor_aca_o = $vData[6];
        $id_arch_curso_o = $vData[7];

        $query = $this->db->query("SELECT public.fn_insert_curso(
        '$id_usuari',
        '$id_uni_inst_aus_o',
        '$id_capacitacion_o',
        '$id_nom_cur_sem_tal_o',
        '$id_nacademico_o_o',
        '$id_fecha_emi_cer_o',
        '$id_dur_hor_aca_o',
        '$id_arch_curso_o')");
        return $query->result();
        /* FIN Oscar Laura Aguirre GAN-MS-M5-0435  */
    }
    public function get_listar_cursos($postData = null)
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M5-0435  */
        try {
            $response = array();
            ## Read value
            $draw = $postData['draw'];
            $start = $postData['start'];
            $rowperpage = $postData['length']; // Rows display per page
            $columnIndex = $postData['order'][0]['column']; // Column index
            $columnName = $postData['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
            $searchValue = $postData['search']['value']; // Search value
            $ordernar = 'ofecha';

            switch ($columnName) {
                    // aqui ordenamos con el parametro al id de la columna para que vaya ascendente o descendente
                case 'onro':
                    $ordernar = 'id_cursos';
                    break;
                case 'oinstitucion':
                    $ordernar = 'institucion';
                    break;
                case 'otipo_capa':
                    $ordernar = 'tipo_capa';
                    break;
                case 'ofec_emi_cert':
                    $ordernar = 'fec_emi_cert';
                    break;
                case 'oduracion':
                    $ordernar = 'duracion';
                    break;
                default:
                    # code...
                    break;
            }
            $id_usuario = $this->session->userdata('id_usuario');

            $query = $this->db->query("SELECT * FROM fn_listar_cursos('$ordernar','$columnSortOrder',$rowperpage,$start,'$searchValue');");
            $querytotal = $this->db->query("SELECT fn_total_cursos() as count; ");
            $queryfilter = $this->db->query("SELECT fn_total_cursos_filtrado('$searchValue') as count;;");

            $records      = $query->result();
            $totales      = $querytotal->result();
            $totalRecords = $totales[0]->count;

            $totfilter =  $queryfilter->result();
            $totalRecordwithFilter = $totfilter[0]->count;

            $data = array();

            $status = "Error";

            foreach ($records as $record) {
                $data[] = array(
                    "onro" => $record->onro,
                    "oinstitucion" => $record->oinstitucion,
                    "otipo_capa" => $record->otipo_capa,
                    "ofec_emi_cert" => $record->ofec_emi_cert,
                    "oduracion" => $record->oduracion,
                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "columnsna" => $columnName,
                "start" => $start,
                "aaData" => $data
            );

            return $response;
        } catch (Exception $error) {
            $log['error'] = $error;
        }
        /* FIN Oscar Laura Aguirre GAN-MS-M5-0435  */
    }
}
