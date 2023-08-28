<?php
/*
---------------------------------------------------------------------------------------------------------
Modificado:  Luis Fabricio Pari Wayar.   Fecha:26/08/2022,   Codigo: GAN-MS-A1-397,
Descripcion: Se modifico la funcion datos_marca() par que funcione de acuerdo a la funcion 
fn_get_datos_marca de M_marca.
-----------------------------------------------------------------------------------------------------------
Modificado: Deivit Pucho Aguilar.   Fecha:26/08/2022,   Codigo: GAN-SC-M4-394,
Descripcion: Se modifico la funcion add_update_marca en la validacion de SUCCESS y ERROR 

*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_marca extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('producto/M_marca','marca');
    }

    public function index() {
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
            $data['contenido'] = 'producto/marca';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
    public function lista_marca(){
     
        // POST data
        $postData = $this->input->post();
   
        // Get data
        $data = $this->marca->get_marca2($postData);
   
        echo json_encode($data);
     }
    public function add_update_marca(){
        if ($this->input->post('btn') == 'add') {
            if ($this->input->post('tiempo_gar')) {
                $tiempo = $this->input->post('tiempo_gar');
            } else {
                $tiempo = 0;
            }

            $codigo_mar = $this->input->post('codigo_mar');
            $config['allowed_types'] = 'png';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] =TRUE;

            $this->load->library('upload', $config);

            if (!file_exists($_FILES['img_marca']['tmp_name']) || !is_uploaded_file($_FILES['img_marca']['tmp_name'])) {
                $newName = NULL;
                $val_mostrar = FALSE;
            } else {
                $extension = explode('.',$_FILES['img_marca']['name']);
                $newName = $codigo_mar.'.'.$extension[1];
                $destination = './assets/img/marcas/'.$newName;
                move_uploaded_file($_FILES['img_marca']['tmp_name'],$destination);
                $val_mostrar = TRUE;
            }

              $data = array(
                'codigo' => $codigo_mar,
                'descripcion' => $this->input->post('marca'),
                'garantia' => $this->input->post('garantia'),
                'tiempo_garantia' => $tiempo,
                'imagen' => $newName,
                'mostrar' => $val_mostrar,
                'usucre' => $this->session->userdata('usuario')
              );

              // GAN-SC-M4-394, 26/08/2022 Deivit Pucho
              $mar_insert = $this->marca->insert_marca($data);
              $auxiliar;
              foreach ($mar_insert as $row) {
                $auxiliar=$row->oboolean;
              }
                if ($auxiliar) {
                    $this->session->set_flashdata('success','Registro insertado exitosamente.');
                } else {
                    $this->session->set_flashdata('error','Error al insertar Registro.');
                }
                // Fin GAN-SC-M4-394, 26/08/2022 Deivit Pucho

        } elseif ($this->input->post('btn') == 'edit') {
            if ($this->input->post('tiempo_gar')) {
                $tiempo = $this->input->post('tiempo_gar');
            } else {
                $tiempo = 0;
            }
              $codigo_mar = $this->input->post('codigo_mar');

              $config['allowed_types'] = 'png';
              $config['max_size'] = '0';
              $config['max_width'] = '0';
              $config['max_height'] = '0';
              $config['overwrite'] =TRUE;

              $this->load->library('upload', $config);

              if ($_FILES['img_marca']['name'] == '') {
                    $newName = $this->input->post('imagen');
              } else {
                  $extension = explode('.',$_FILES['img_marca']['name']);
                  $newName = $codigo_mar.'.'.$extension[1];
                  $destination = './assets/img/marcas/'.$newName;
                  move_uploaded_file($_FILES['img_marca']['tmp_name'],$destination);
              }

              $data = array(
                'codigo' => $codigo_mar,
                'descripcion' => $this->input->post('marca'),
                'garantia' => $this->input->post('garantia'),
                'tiempo_garantia' => $tiempo,
                'imagen' => $newName,
                'usumod' => $this->session->userdata('usuario'),
                'fecmod' => date('Y-m-d H:i:s')
              );
              $mar_update = $this->marca->update_marca(array('id_marca' => $this->input->post('id_marca')), $data);
                if ($mar_update) {
                    $this->session->set_flashdata('success','Registro modificado exitosamente.');
                } else {
                    $this->session->set_flashdata('error','Error al modificar registro.');
                }
        }
        redirect('marca');
    }

    public function datos_marca($id_mar){
        $data = $this->marca->get_datos_marca($id_mar);
        // GAN-MS-A1-397, 26/08/2022 Luis Fabricio Pari Wayar.
        // se sustituye los keys del array $data para que funcione correctamente.
        $rewriteKeys = array(
            'oidmarca' => 'id_marca',
            'ocodigo' => 'codigo',
            'odescripcion' => 'descripcion',
            'ogarantia' => 'garantia',
            'otiempo_garantia' => 'tiempo_garantia',
            'ofeccre' => 'feccre',
            'ousucre' => 'usucre',
            'ofecmod' => 'fecmod',
            'ousumod'=> 'usumod',
            'oapiestado' => 'apiestado',
            'oimagen' =>'imagen',
            'omostrar' => 'mostar'
        );
  
        $datos = array();
  
        foreach($data as $key => $value) {
           $datos[ $rewriteKeys[ $key ] ] = $value;
        }

        echo json_encode($datos);
        // FIN GAN-MS-A1-397, 26/08/2022 Luis Fabricio Pari Wayar. 
    }

    public function dlt_marca($id_mar,$estado){
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
        $this->marca->delete_marca($id_mar, $data);
        redirect('marca');
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
                  $query = $this->marca->validacion($codigo);
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
