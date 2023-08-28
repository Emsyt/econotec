<?php 
/*  
  -------------------------------------------------------------------------------------------------------
  Modificado: Melvin Salvador Cussi Callisaya Fecha:14/03/2022, Codigo: GAN-MS-A6-130
  Descripcion: se modifico la funcion add_update_usuario() para que el mismo no genere cambios
  en la contraseña ni login al momento de editar un usuario
  -------------------------------------------------------------------------------------------------------
  Modificado: Richard Hector Orihuela Gil Fecha:29/07/2022, Codigo: GAN-MS-A1-327
  Descripcion: correcion del modulo de usuarios, En cuanto a la eliminacion de usuarios
  -------------------------------------------------------------------------------------------------------
  Modificado: Alison Paola Pari Fecha:29/07/2022, Codigo: GAN-MS-A1-328
  Descripcion: Se modifico la funcion add_update_usuario para insertar y editar usuarios desde la funcion 
  fn_registrar_usuario del modelo abm_usuario
  -------------------------------------------------------------------------------------------------------
  Modificado: Kevin Mauricio Larrazabal Calle  Fecha:31/08/2022, Codigo: GAN-SC-A1-419
  Descripcion: Actualizacion de query por funcion fn_auxiliares para validar que el numero de CI sea unico
  -------------------------------------------------------------------------------------------------------
  Modificado: Adamary Margell Uchani Mamani Fecha:31/08/2022, Codigo: GAN-MS-A1-424
  Descripcion: Se modifico la funcion add_rol() para insertar desde la función un rol
  fn_insert_rol() de M_usuario
  -------------------------------------------------------------------------------------------------------
  Modificado: Luis Fabricio Pari Wayar  Fecha:31/08/2022, Codigo: GAN-SC-A1-420
  Descripcion: Actualizacion de array en lugar de recibir el id_usuariorestriccion recibimos el id_usuario
  -------------------------------------------------------------------------------------------------------
  Modificado:  Melani Alisson Cusi Burgoa Fecha:22/09/2022, Codigo: GAN-MS-A1-478
  Descripcion: Actualizacion funcion editar_usuariores
   -------------------------------------------------------------------------------------------------------
  Modificado:  Noemi Rosio Vera Velasquez Fecha:21/07/2023, Codigo: GAN-MS-B0-0548
  Descripcion: Agregar dato de descripcion en la funcion asignacion_rol
  */
?>
<?php
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('administracion/M_usuario','usuario');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['departamentos'] = $this->usuario->get_departamento_cmb();
            $data['ubicaciones'] = $this->usuario->get_ubicacion_cmb();
            $data['lst_usuarios'] = $this->usuario->get_usuario();

            $data['lib'] = 0;
            $data['datos_log'] = $log;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'administracion/usuario';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function add_update_usuario(){
        date_default_timezone_set('America/La_Paz');
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $cadena = explode(" ", trim($this->input->post('nombre')));
            $pnombre = $cadena[0];
            $login_ini = strtolower($pnombre.'.'.trim($this->input->post('ap_paterno')));
            $password = md5($this->input->post('nro_carnet'));

            if ($this->input->post('btn') == 'add') {
                $btn=0;
                $query = $this->db->query("SELECT count(login) AS log FROM seg_usuario WHERE login LIKE '$login_ini%' ");
                $cont_log = $query->row('log');
                if ($cont_log == 0) {
                    $login = $login_ini;
                } else if ($cont_log == 1) {
                    $login = $login_ini . 1;
                } else if ($cont_log > 1) {
                    $query = $this->db->query("SELECT max(login) AS max_log FROM seg_usuario WHERE login LIKE '$login_ini%' ");
                    $login_ul = $query->row('max_log');
                    $cadena_num = substr($login_ul, -1);
                    $login = $login_ini.("$cadena_num" + 1);
                }

                $config['allowed_types'] = 'jpg|png|JPEG';
                $config['max_size'] = '0';
                $config['max_width'] = '0';
                $config['max_height'] = '0';
                $config['overwrite'] =TRUE;
                $this->load->library('upload', $config);
                $genero= $this->input->post('genero');
                if($genero ==""){
                    $genero=1;
                }
                $telefono= $this->input->post('telefono');
                if($telefono ==""){
                    $telefono=null;
                }
                $fec_nacimiento= $this->input->post('fec_nacimiento');
                if($fec_nacimiento ==""){
                    $fec_nacimiento=null;
                }
                $array = array(
                    'login' => $login,
                    'password' => $password,
                    'id_departamento' => $this->input->post('expedido'),
                    'carnet' => $this->input->post('nro_carnet'),
                    'nombre' => $this->input->post('nombre'),
                    'paterno' => $this->input->post('ap_paterno'),
                    'materno' => $this->input->post('ap_materno'),
                    'direccion' => $this->input->post('direccion'),
                    'telefono' => $telefono,
                    'fec_nacimiento' => $fec_nacimiento,
                    'correo' => $this->input->post('correo'),
                    'foto' => $this->upload_image($this->input->post('nro_carnet')),
                    'genero' => $genero,
                    'id_brigada' => 1,
                    'id_proyecto' => $this->input->post('ubi_trabajo'),
                    'cargo' => $this->input->post('cargo'),
                    'usucre' => $this->session->userdata('usuario'),
                );
                $data=json_encode($array);
                $usr_insert = $this->usuario->abm_usuario($btn,$data);
                
                if ($usr_insert[0]->oboolean=='t' ) {
                    $this->session->set_flashdata('success','Registro insertado exitosamente.');
                } else {
                    $this->session->set_flashdata('error',$usr_insert[0]->omensaje);
                }
                redirect('usuarios');
            
            } elseif ($this->input->post('btn') =='edit') {
                    if ($cont_log == 0) {
                    } else if ($cont_log > 1) {
                        $query = $this->db->query("SELECT max(login) AS max_log FROM seg_usuario WHERE login LIKE '$login_ini%' ");
                        $login_ul = $query->row('max_log');
                        $cadena_num = substr($login_ul, -1);
                    }
                $config['allowed_types'] = 'jpg|png|JPEG';
                $config['max_size'] = '0';
                $config['max_width'] = '0';
                $config['max_height'] = '0';
                $config['overwrite'] =TRUE;
                $this->load->library('upload', $config);

                $genero= $this->input->post('genero');
                if($genero ==""){
                    $genero=1;
                }
                $telefono= $this->input->post('telefono');
                if($telefono ==""){
                    $telefono=null;
                }
                $fec_nacimiento= $this->input->post('fec_nacimiento');
                if($fec_nacimiento ==""){
                    $fec_nacimiento=null;
                }
                $login= $this->input->post('login');
                $password = $this->input->post('password');
                $id_usuario=$this->input->post('id_usuario');
                $array = array(
                    'login' => $login,
                    'password' => $password,
                    'id_departamento' => $this->input->post('expedido'),
                    'carnet' => $this->input->post('nro_carnet'),
                    'nombre' => $this->input->post('nombre'),
                    'paterno' => $this->input->post('ap_paterno'),
                    'materno' => $this->input->post('ap_materno'),
                    'direccion' => $this->input->post('direccion'),
                    'telefono' => $telefono,
                    'fec_nacimiento' => $fec_nacimiento,
                    'correo' => $this->input->post('correo'),
                    'foto' => $this->upload_image($this->input->post('nro_carnet')),
                    'genero' => $genero,
                    'id_brigada' => 1,
                    'id_proyecto' => $this->input->post('ubi_trabajo'),
                    'cargo' => $this->input->post('cargo'),
                    'usucre' => $this->session->userdata('usuario'),
                    'fecmod' => date('Y-m-d H:i:s')
                );
                $data=json_encode($array);
               $usr_update = $this->usuario->ABM_usuario( $id_usuario,$data);
                if ($usr_update[0]->oboolean=='t') {
                    $this->session->set_flashdata('success','Datos modificados correctamente.');
                } else {
                    $this->session->set_flashdata('error',$usr_update[0]->omensaje);
                }
            
                redirect('usuarios');
                
            }
        } else {
            redirect('logout');
        }
    }

        public function upload_image($ci) {
            if(isset($_FILES['photo'])){
                $extension = explode('.',$_FILES['photo']['name']);
                  if ($_FILES['photo']['name'] == '') {
                      if ($btn == 'add') {
                          $new_name = NULL;
                      } else {
                          $new_name = $this->input->post('foto');
                      }
                  } else {
                        $new_name = $ci.'.'.$extension[1];
                  }
                $destination = './assets/img/personal/'.$new_name;
                move_uploaded_file($_FILES['photo']['tmp_name'],$destination);
                return $new_name;
            }
        }

    public function datos_usuario($id_usr){

        // GAN-SC-A1-418 Denilson Santander Rios, 31/08/2022
        $data = $this->usuario->get_datos_usuario($id_usr); 
        $rewriteKeys = array(
            'oidusario' => 'id_usuario',
            'oiddepartamento' => 'id_departamento',
            'oidbrigada' => 'id_brigada', 
            'oiddependencia' => 'id_dependencia',
            'oidproyecto' => 'id_proyecto',
            'oidpapel' => 'id_papel',
            'ologin' => 'login',
            'opassword' => 'password',
            'ocarnet' => 'carnet',
            'onombre' => 'nombre',
            'opaterno' => 'paterno',
            'omaterno' => 'materno',
            'odireccion' => 'direccion',
            'otelefono' => 'telefono',
            'ofechavigente' => 'fecha_vigente',
            'ofoto' => 'foto',
            'ofecnacimiento' => 'fec_nacimiento',
            'ocorreo' => 'correo',
            'oserie' => 'serie',
            'orememberToken' => 'remember_token',
            'ogenero' => 'genero',
            'ocargo' =>'cargo',
            'osesionActual' => 'sesion_actual',
            'oonline' => 'online',
            'ofeccre' => 'feccre',
            'ousucre' => 'usucre',
            'ofecmod' => 'fecmod',
            'ousumod' => 'usumod',
            'oapiestado' => 'apiestado'
          );
          
          $datos = array();

          foreach($data as $key => $value) {
            $datos[ $rewriteKeys[ $key ] ] = $value;
          }
          
        echo json_encode($datos);
         // FIN  GAN-SC-A1-418 Denilson Santander Rios, 31/08/2022
    }

    public function dlt_usuario($id_usr,$estado){
        date_default_timezone_set('America/La_Paz');
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
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
            $usr_delete = $this->usuario->delete_usuario($id_usr, $data);
            if ($usr_delete) {
                $this->session->set_flashdata('success','Datos actualizados correctamente.');
            } else {
                $this->session->set_flashdata('error','Error al actualizar los datos.');
            }
            redirect('usuarios');
        } else {
            redirect('logout');
        }
    }

    public function asignacion_rol() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['usuarios'] = $this->usuario->get_usuario();
            $data['departamentos'] = $this->usuario->get_departamento_cmb();
            $data['rol_usuario'] = $this->usuario->get_roles_cmb();
            $data['lst_asignacion_roles'] = $this->usuario->get_asgroles();

            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            //GAN-MS-B0-0548 21/07/2023 NVera.
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            //Fin GAN-MS-B0-0548 21/07/2023 NVera.
            $data['contenido'] = 'administracion/asignacion_rol';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function lista_usuarios(){
     
        // POST data
        $postData = $this->input->post();
   
        // Get data
        $data = $this->usuario->get_usuario1($postData);
   
        echo json_encode($data);
     }
    public function lista_rol(){
     
        // POST data
        $postData = $this->input->post();
   
        // Get data
        $data = $this->usuario->get_asgroles1($postData);
   
        echo json_encode($data);
     }
    public function datos_persona($id_usr){
        $data = $this->usuario->get_datos_per($id_usr);
        echo json_encode($data);
    }

    public function add_rol(){
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data = array(
            //GAN-SC-A1-424     AUchani
                'id_proyecto' => 9,
                'id_usuario' => $this->input->post('id_usuario'),
                'id_rol' => $this->input->post('rol_usuario'),
                'departamentos' =>'1,2,3,4,5,6,7,8,9',
                'usucre' => $this->session->userdata('usuario'),
            );
            //FIN GAN-SC-A1-424     AUchani

            $rol_insert = $this->usuario->insert_rol($data);
            if ($rol_insert) {
                $this->session->set_flashdata('success','Datos registrados correctamente.');
            } else {
                $this->session->set_flashdata('error','Error al registrar los datos.');
            }
            redirect('asignacion_rol');
        } else {
            redirect('logout');
        }
    }

    public function datos_usuariores($id_usres){
        $data = $this->usuario->get_datos_usuariores($id_usres);
        echo json_encode($data);
    }

    public function editar_usuariores(){
        // GAN-MS-A1-478, 22/09/2022 ACusi.
        $pid_usurestriccion=$this->input->post('id_usurestriccion');
        $pid_rol=$this->input->post('rol_usuario_mod');
        $papiestado=$this->input->post('estado_usr_mod');
        $pusumod=$this->input->post('usuario');
        $this->usuario->update_usuariores( $pid_usurestriccion, $pid_rol, $papiestado, $pusumod);         
         // FIN GAN-MS-A1-478, 22/09/2022 ACusi.
        echo json_encode(array("status" => TRUE));
    }

    public function editar_usuario(){
        $data = array(
            'id_rol' => $this->input->post('rol_usuario_mod'),
            'apiestado' => $this->input->post('estado_usr_mod'),
            'usumod' => $this->session->userdata('usuario'),
            'fecmod' => date('Y-m-d H:i:s')
            );
            //GAN-SC-A1-420 FPari
        $this->usuario->update_usuario(array('id_usuario' => $this->input->post('id_usuario')), $data);
            // FIN GAN-SC-A1-420 FPari
        echo json_encode(array("status" => TRUE));
    }




    public function dlt_usuariores($id_usres){
        if ($this->session->userdata('login')) {
            $data = array(
                'apiestado' => 'INACTIVO',
                'usumod' => $this->session->userdata('usuario'),
                'fecmod' => date('Y-m-d H:i:s')
            );
            $ua_delete = $this->usuario->eliminar_usuariores($id_usres,$data);
            if ($ua_delete) {
                $this->session->set_flashdata('success','Datos eliminados correctamente.');
            } else {
                $this->session->set_flashdata('error','Error al eliminar los datos.');
            }
            redirect('asignacion_rol');
        } else {
            redirect('logout');
        }
    }

    public function fn_auxiliares(){
        try{
            $accion = $_REQUEST['accion'];
            if(empty($accion))
                throw new Exception("Error accion no valida");
            switch($accion)
            {
                case 'validar_unico':
                    $options = "";
                    // KLarrazabal, 31/08/2022, GAN-SC-A1-419
                        $carnet = $this->input->post('nro_ci');
                        $query = $this->db->query("SELECT * FROM fn_auxiliares($carnet)");
                        $query_result =  $query->result();
                        $cont ;
                       foreach ($query_result as $row){
                        $cont = $row->vcoincidencia_ci;
                         }
                        echo $cont;
                    // KLarrazabal, 31/08/2022, GAN-SC-A1-419
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
