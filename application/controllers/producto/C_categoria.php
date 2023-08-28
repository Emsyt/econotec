<?php
/*
---------------------------------------------------------------------------------------------------------
Modificado:  Pedro Rodrigo Beltran Poma.   Fecha:25/08/2022,   Codigo: GAN-MS-A1-388,
Descripcion: Se modifico la funcion datos_categoria() par que funcione de acuerdo a la funcion 
fn_get_datos_categoria de M_categoria.

*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_categoria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('producto/M_categoria','categoria');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $data['lst_categorias'] = $this->categoria->get_categoria();
            $data['lib'] = 0;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'producto/categoria';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function lista_categoria(){
     
        // POST data
        $postData = $this->input->post();
   
        // Get data
        $data = $this->categoria->get_categoria($postData);
   
        echo json_encode($data);
     }
    public function add_update_categoria(){
        if ($this->input->post('btn') == 'add') {
              $codigo_cat = $this->input->post('codigo_cat');

              $config['allowed_types'] = 'jpg|png|JPEG';
              $config['max_size'] = '0';
              $config['max_width'] = '0';
              $config['max_height'] = '0';
              $config['overwrite'] =TRUE;

              $this->load->library('upload', $config);

              if (!file_exists($_FILES['img_categoria']['tmp_name']) || !is_uploaded_file($_FILES['img_categoria']['tmp_name'])) {
                  $newName = NULL;
              } else {
                  $extension = explode('.',$_FILES['img_categoria']['name']);
                  $newName = $codigo_cat.'.'.$extension[1];
                  $destination = './assets/img/categorias/'.$newName;
                  move_uploaded_file($_FILES['img_categoria']['tmp_name'],$destination);
              }
             // GAN-MS-A1-390 Denilson Santander Rios
              $data = array(
                'codigo' => $codigo_cat,
                'descripcion' => $this->input->post('categoria'),
                'usucre' => $this->session->userdata('usuario'),
                'imagen' => $newName    
              );
              // FIN GAN-MS-A1-390 Denilson Santander Rios Descripcion: se modifico el orden
              $cat_insert = $this->categoria->insert_categoria($data);
                if ($cat_insert) {
                    $this->session->set_flashdata('success','Registro insertado exitosamente.');
                } else {
                    $this->session->set_flashdata('error','Error al insertar Registro.');
                }
        } elseif ($this->input->post('btn') == 'edit') {
              $codigo_cat = $this->input->post('codigo_cat');

              $config['allowed_types'] = 'jpg|png|JPEG';
              $config['max_size'] = '0';
              $config['max_width'] = '0';
              $config['max_height'] = '0';
              $config['overwrite'] =TRUE;

              $this->load->library('upload', $config);

              if ($_FILES['img_categoria']['name'] == '') {
                    $newName = $this->input->post('imagen');
              } else {
                  $extension = explode('.',$_FILES['img_categoria']['name']);
                  $newName = $codigo_cat.'.'.$extension[1];
                  $destination = './assets/img/categorias/'.$newName;
                  move_uploaded_file($_FILES['img_categoria']['tmp_name'],$destination);
              }

              $data = array(
                'codigo' => $codigo_cat,
                'descripcion' => $this->input->post('categoria'),
                'imagen' => $newName,
                'usumod' => $this->session->userdata('usuario'),
                'fecmod' => date('Y-m-d H:i:s')
              );
              $cat_update = $this->categoria->update_categoria(array('id_categoria' => $this->input->post('id_categoria')), $data);
                if ($cat_update) {
                    $this->session->set_flashdata('success','Registro modificado exitosamente.');
                } else {
                    $this->session->set_flashdata('error','Error al modificar registro.');
                }
        }
        redirect('categoria');
    }

    public function datos_categoria($id_cat){
        $data = $this->categoria->get_datos_categoria($id_cat);

        // GAN-MS-A1-388, 25/08/2022 PBeltran.
        // se sustituye los keys del array $data para que funcione correctamente.
        $rewriteKeys = array(
          'oidcategoria' => 'id_categoria',
          'ocodigo' => 'codigo',
          'odescripcion' => 'descripcion', 
          'ofeccre' => 'feccre',
          'ousucre' => 'usucre',
          'ofecmod' => 'fecmod',
          'ousumod'=> 'usumod',
          'oapiestado' => 'apiestado',
          'oimagen' =>'imagen'
        );

        $datos = array();

        foreach($data as $key => $value) {
          $datos[ $rewriteKeys[ $key ] ] = $value;
        }

        echo json_encode($datos);
        // FIN GAN-MS-A1-388, 25/08/2022 PBeltran. 
    }

    public function dlt_categoria($id_cat,$estado){
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
        $this->categoria->delete_categoria($id_cat, $data);
        redirect('categoria');
    }

    //------- FUNCIONES AUXILIARES -------//
    public function func_auxiliares(){
      try{
          $accion = $_REQUEST['accion'];
          if(empty($accion))
              throw new Exception("Error accion no valida");
          switch($accion)
          {
              case 'val_codigo':
                  $codigo = $this->input->post('text_cod');
                  $query = $this->categoria->validacion($codigo);
                  echo $query;
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
