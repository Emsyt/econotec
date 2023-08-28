<?php
/*
-------------------------------------------------------------------------------------
Creacion: Ariel Ramos Paucara Fecha 15/03/2023, Codigo: GAN-MS-M0-0357
Descripcion: se realizo el modulo de recursos submodulo file personal 
segun actividad GAN-MS-M0-0357
-------------------------------------------------------------------------------------
Creacion: Oscar Laura Aguirre Fecha 23/03/2023, Codigo: GAN-MS-M4-0368
Descripcion: Se implemento la funcion mostrar_usuario y actualizar_fil_per para
mostrar el usuario actual y modificar el usuario actual
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 30/03/2023, Codigo: GAN-MS-B5-0387 
Descripcion: Se agrego el campo expedido para que pueda actualizarlo
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 13/04/2023, Codigo: GAN-MS-M0-0407
Descripcion: se agrego la funcion para agregar el modulo y hacer un 
registro de academia y una funcion para listarlo
------------------------------------------------------------------------------
Modificacion: Oscar Laura Aguirre Fecha 13/04/2023, Codigo: GAN-MS-M5-0435
Descripcion: se agrego la funcion para agregar el modulo y hacer un 
curso y una funcion para listarlo
*/

?>
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_file extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('upload');
        $this->load->model('recursos/M_file', 'file');
    }

    public function index()
    {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['departamentos'] = $this->file->get_departamento_cmb();
            $data['residencia'] = $this->file->get_residencia();
            $data['nacionalidad'] = $this->file->get_nacionalidad();
            $data['genero'] = $this->file->get_genero();
            $data['civil'] = $this->file->get_civil();
            $data['nacademico'] = $this->file->get_nacademico();
            $data['certificacion'] = $this->file->get_certificacion();
            $data['capacitacion'] = $this->file->get_capacitacion();
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'recursos/file';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura', $data);
        } else {
            redirect('logout');
        }
    }
    public function mostrar_usuario()
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M4-0368 */
        $id_usuario = $this->session->userdata('id_usuario');
        $data = $this->file->mostrar_usuario_dt($id_usuario);
        echo json_encode($data);
        /* FIN Oscar Laura Aguirre GAN-MS-M4-0368 */
    }
    public function actualizar_fil_per()
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M4-0368 */
        $config['allowed_types'] = 'jpg|png|JPEG';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $newName = '';
        if (!file_exists($_FILES['sub_archivo']['tmp_name']) || !is_uploaded_file($_FILES['sub_archivo']['tmp_name'])) {
            $newName = NULL;
        } else {
            $extension = explode('.', $_FILES['sub_archivo']['name']);
            $newName = $extension[0] . '.' . $extension[1];
            $destination = './assets/img/personal/' . $newName;
            move_uploaded_file($_FILES['sub_archivo']['tmp_name'], $destination);
        }
        $id_gen = 0;
        if ($this->input->post('id_genero') === '1379') {
            $id_gen = 1;
        }
        if ($this->input->post('id_genero') === '1380') {
            $id_gen = 2;
        }

        $f = array(
            'id_usuari'         => $this->session->userdata('id_usuario'),
            'nombre_p_oo'       => $this->input->post('nombre_p'),
            'pri_ape_oo'        => $this->input->post('pri_ape'),
            'sec_ape_oo'        => $this->input->post('sec_ape'),
            'fecha_n_oo'        => $this->input->post('fecha_n'),
            'telefono_p_oo'     => $this->input->post('telefono_p'),
            'ced_identidad_oo'  => $this->input->post('ced_identidad'),
            'id_genero_oo'      => $id_gen,
            'cor_ele_oo'        => $this->input->post('cor_ele'),
            'sub_archivo_oo'    => $newName ?? '',
            'cargo_p_oo'        => $this->input->post('cargo_p'),
            'lug_naci_oo'       => $this->input->post('lug_naci'),
            'id_residencia0_oo' => $this->input->post('id_residencia0'),
            'dir_domi_oo'       => $this->input->post('dir_domi'),
            'celular_p_oo'      => $this->input->post('celular_p'),
            'id_nacionalidad_oo' => $this->input->post('id_nacionalidad0'),
            'id_ecivil_oo'      => $this->input->post('id_ecivil'),
            'fec_vin_oo'        => $this->input->post('fec_vin'),
            'fec_des_oo'        => $this->input->post('fec_des'),
            'califi_oo'         => $this->input->post('califi')
        );

        $data = $this->file->actualizar_usuario_dt($f);

        echo json_encode($data);
        /* FIN Oscar Laura Aguirre GAN-MS-M4-0368 */
    }
    public function actualizar_fil_per2()
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M4-0368 */
        $config['allowed_types'] = 'jpg|png|JPEG';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $newName = '';
        if (!file_exists($_FILES['sub_archivo']['tmp_name']) || !is_uploaded_file($_FILES['sub_archivo']['tmp_name'])) {
            $newName = $this->input->post('foto');
        } else {
            $extension = explode('.', $_FILES['sub_archivo']['name']);
            $newName = $extension[0] . '.' . $extension[1];
            $destination = './assets/img/personal/' . $newName;
            move_uploaded_file($_FILES['sub_archivo']['tmp_name'], $destination);
        }
        $id_gen = 0;
        if ($this->input->post('id_genero') === '1379') {
            $id_gen = 1;
        }
        if ($this->input->post('id_genero') === '1380') {
            $id_gen = 2;
        }

        $f = array(
            'id_usuari'         => $this->session->userdata('id_usuario'),
            'nombre_p_oo'       => $this->input->post('nombre_p'),
            'pri_ape_oo'        => $this->input->post('pri_ape'),
            'sec_ape_oo'        => $this->input->post('sec_ape'),
            'fecha_n_oo'        => $this->input->post('fecha_n'),
            'telefono_p_oo'     => $this->input->post('telefono_p'),
            'ced_identidad_oo'  => $this->input->post('ced_identidad'),
            'id_genero_oo'      => $id_gen,
            'cor_ele_oo'        =>  $this->input->post('cor_ele'),
            'expedido_oo'       =>  $this->input->post('expedido'),
            'sub_archivo_oo'    => $newName,
            'cargo_p_oo'        =>  $this->input->post('cargo_p'),
            'lug_naci_oo'       =>  $this->input->post('lug_naci'),
            'id_residencia0_oo' =>  $this->input->post('id_residencia0'),
            'dir_domi_oo'       =>  $this->input->post('dir_domi'),
            'celular_p_oo'      =>  $this->input->post('celular_p'),
            'id_nacionalidad_oo' => $this->input->post('id_nacionalidad0'),
            'id_ecivil_oo'      =>  $this->input->post('id_ecivil'),
            'fec_vin_oo'        =>  $this->input->post('fec_vin'),
            'fec_des_oo'        =>  $this->input->post('fec_des'),
            'califi_oo'         =>  $this->input->post('califi')
        );

        $usr_insert = $this->file->actualizar_usuario_dt($f);

        if ($usr_insert[0]->fn_actualizar_usuario_actual == 'TRUE') {
            $this->session->set_flashdata('success', 'Registro actualizado exitosamente.');
        } else {
            $this->session->set_flashdata('error', "" + $usr_insert[0]->fn_actualizar_usuario_actual);
        }
        redirect('file');

        /* FIN Oscar Laura Aguirre GAN-MS-M4-0368 */
    }
    public function registrar_formacion_academic()
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M0-0407*/
        $config['allowed_types'] = 'jpg|png|JPEG';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $newName = '';
        if (!file_exists($_FILES['sub_arch']['tmp_name']) || !is_uploaded_file($_FILES['sub_arch']['tmp_name'])) {
            $newName = null;
        } else {
            $extension = explode('.', $_FILES['sub_arch']['name']);
            $newName = $extension[0] . '.' . $extension[1];
            $destination = './assets/img/personal/' . $newName;
            move_uploaded_file($_FILES['sub_arch']['tmp_name'], $destination);
        }

        $f = array(
            'id_usuari'              => $this->session->userdata('id_usuario'),
            'uni_inst_o'             => $this->input->post('uni_inst'),
            'id_nacademico_o'        => $this->input->post('id_nacademico'),
            'id_certificacion_o'     => $this->input->post('id_certificacion'),
            'fecha_emi_cer_o'        => $this->input->post('fecha_emi_cer'),
            'sub_arch_o'             => $newName
        );

        /*  $vData = array_values($f);
        echo '<pre>';
        print_r($vData);
        echo '</pre>'; */
        $usr_insert = $this->file->registrar_formacion_academica($f);

        // $this->session->set_flashdata('success', 'Registrado exitosamente.');
        // redirect('file');
        echo json_encode($usr_insert);
        /* FIN Oscar Laura Aguirre GAN-MS-M0-0407 */
    }
    public function lstformacionacademica()
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M0-0407 */
        $postData   = $this->input->post();
        $data = $this->file->get_listar_formacion_academica($postData);
        echo json_encode($data);
        /* FIN Oscar Laura Aguirre GAN-MS-M0-0407 */
    }

    public function registrar_curso()
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M5-0435 */
        $config['allowed_types'] = 'jpg|png|JPEG';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $newName = '';
        if (!file_exists($_FILES['id_arch_curso']['tmp_name']) || !is_uploaded_file($_FILES['id_arch_curso']['tmp_name'])) {
            $newName = null;
        } else {
            $extension = explode('.', $_FILES['id_arch_curso']['name']);
            $newName = $extension[0] . '.' . $extension[1];
            $destination = './assets/img/curso/' . $newName;
            move_uploaded_file($_FILES['id_arch_curso']['tmp_name'], $destination);
        }
        $v = '';
        if ($this->input->post('id_participacion') === '0') {
            $v = 'participacion';
        } else { //if ($this->input->post('id_aprobacion') === '1')  
            $v = 'aprobacion';
        }
        $f = array(
            'id_usuari'            => $this->session->userdata('id_usuario'),
            'id_uni_inst_aus'      => $this->input->post('id_uni_inst_aus'),
            'id_capacitacion_o'    => $this->input->post('id_capacitacion'),
            'id_nom_cur_sem_tal_o' => $this->input->post('id_nom_cur_sem_tal'),
            'id_nacademico_o_o'    => $v,
            'id_fecha_emi_cer_o'   => $this->input->post('id_fecha_emi_cer'),
            'id_dur_hor_aca_o'     => $this->input->post('id_dur_hor_aca'),
            'id_arch_curso_o'      => $newName
        );
        // mostrar mensajito
        // $vData = array_values($f);
        //echo '<pre>';
        //print_r($vData);
        //echo '</pre>';
        $usr_insert = $this->file->registrar_curso($f);

        echo json_encode($usr_insert);
        /* INICIO Oscar Laura Aguirre GAN-MS-M5-0435 */
    }
    public function lstcursos()
    {
        /* INICIO Oscar Laura Aguirre GAN-MS-M5-0435 */
        $postData = $this->input->post();
        $data = $this->file->get_listar_cursos($postData);
        echo json_encode($data);
        /*  FIN Oscar Laura Aguirre GAN-MS-M5-0435 */
    }
}
