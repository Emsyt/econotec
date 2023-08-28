<?php
/*
------------------------------------------------------------------------------
Modificado: karen quispe chavez fecha 27/06/2022 Codigo :GAN-MS-A5-289
Descripcion : se aumento  un 3 nuevos campos para la tabla razon social, telefono y nit 
------------------------------------------------------------------------------
Modificado: Deivit Pucho Aguilar      Fecha: 31/10/2022       Codigo: GAN-MS-A7-0086
Descripcion : se implemento la redimension de imagenes seleccionadas. 
------------------------------------------------------------------------------
Modificado: Jose Daniel Luna Flores Fecha: 24/11/2022   Actividad: GAN-MS-A6-0132      
Descripcion : Se aumento el nuevo campo para la tabla iva                          
------------------------------------------------------------------------------
Modificado: Briyan Julio Torrez Vargas  Fecha: 08/02/2023   Actividad: GAN-MS-B0-0230       
Descripcion : Se adiciono el campo validez   
------------------------------------------------------------------------------
Modificado: Briyan Julio Torrez Vargas  Fecha:18/02/2023   Actividad: GAN-FCL-B5-0267       
Descripcion : Se adiciono el campo mostrar_chat    
------------------------------------------------------------------------------
Modificado: Ayrton Guevara Fecha:06/06/2023 Actividad: GAN-MS-B3-0510          
Descripcion : Se agrego un filtro preg_replace para evitar caracteres no deseados
  
  */
if (!defined('BASEPATH'))
    exit('Not access system ...');

class C_ajustes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('administracion/M_ajustes','ajustes');
    }

    public function index() {
        if ($this->session->userdata('login')) {
            $log['permisos'] = $this->session->userdata('permisos');
            $id_usuario = $this->session->userdata('id_usuario');
            
            $data['lib'] = 0;
            $data['datos_log'] = $log;
            $data['datos_menu'] = $log;
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['logo'] = $this->ajustes->get_ajustes("logo", $id_usuario);
            $data['titulo'] = $this->ajustes->get_ajustes("titulo", $id_usuario);
            $data['descripcion'] = $this->ajustes->get_ajustes("descripcion", $id_usuario);
         
            //datos nuevos para las 3 nuevas entrada
            $data['razon_social'] = $this->ajustes->get_ajustes("razon_social", $id_usuario);
            $data['direccion'] = $this->ajustes->get_ajustes("direccion", $id_usuario);
            $data['telefono'] = $this->ajustes->get_ajustes("telefono", $id_usuario);
            $data['nit'] = $this->ajustes->get_ajustes("nit", $id_usuario);

            // INICIO GAN-MS-A6-0132 24/11/2022 JLuna
            //dato nuevo para la nueva entrada
            $data['iva'] = $this->ajustes->get_ajustes("iva", $id_usuario);
            $data['validez'] = $this->ajustes->get_ajustes("validez_cotizacion", $id_usuario);
            $data['consideracion'] = $this->ajustes->get_ajustes("consideracion", $id_usuario);

            // dato nuevo para el boton activar desactivar chat
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");

            $data['tipo_impresion'] = $this->ajustes->get_papeles();
            $data['thema'] = $this->ajustes->get_ajustes("tema", $id_usuario);
            $data['id_papel'] = $this->general->get_papel_size($id_usuario);
            $data['theme_list'] = $this->ajustes->get_theme_list();
            $data['contenido'] = 'administracion/ajustes';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }

    public function add_update_ajustes() {
        if ($this->session->userdata('login')) {
            $config['allowed_types'] = 'jpg|png|JPEG';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] =TRUE;
            $this->load->library('upload', $config);

            if (!file_exists($_FILES['photo']['tmp_name']) || !is_uploaded_file($_FILES['photo']['tmp_name'])) {                
                $newName = $this->input->post('logo');
            } else {
                  $extension = explode('.',$_FILES['photo']['name']);
                  $newName = $extension[0].'.'.$extension[1];
                  $destination = './assets/img/icoLogo/'.$newName;
                  move_uploaded_file($_FILES['photo']['tmp_name'],$destination);
                  $val_mostrar = TRUE;
            }
            // GAN-MS-A7-0086 31/10/2022 DPucho
            // Procesar imagen con direccion path
            $config2['source_image'] = './assets/img/icoLogo/'.$newName;
            // Asignar maximo de la dimesion de imagen
            $config2['width'] = 175;
            // $config2['height'] = 100;
            $this->load->library('image_lib', $config2);
            // Redimencionar
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
            }
            // FIN GAN-MS-A7-0086 31/10/2022 DPucho

            $id_usuario = $this->session->userdata('id_usuario');
            $data = array(
                "logo"=>$newName,
                "titulo"=>$this->input->post('sistema_titulo'),
                "descripcion"=> $this->input->post('descripcion'),
               
                "razon_social"=>$this->input->post('razon_social'),
                "direccion"=>$this->input->post('direccion'),
                "nit"=>$this->input->post('nit'),

                "iva"=>$this->input->post('iva'),
                "validez"=>$this->input->post('dias_validez'),
                //FIN GAN-MS-A6-0132 24/11/2022 JLuna
                "consideracion"=>$this->input->post('consideracion'),

                "telefono"=>$this->input->post('telefono'),

                "mostrar_chat"=>$this->input->post('mostrarChat'),

                "tema"=>$this->input->post('thema')
                );
            
            if($data["mostrar_chat"]!="true"){
                $data["mostrar_chat"]="false";
            }
            //Ayrton Guevara GAN-MS-B3-0510 06/06/2023
            foreach ($data as &$d){
                $d = preg_replace('/[^A-Za-z0-9\'\.\ \-\!\áéíóúÁÉÍÓÚ]/', '', $d);
            };
            //FIN Ayrton Guevara GAN-MS-B3-0510 06/06/2023
            //print_r($data);
            $json=json_encode($data); 
            //echo $json;
            //exit();
            $tamano_papel = intval($this->input->post('impresion'));
            // GAN-MS-B1-0469, 15/05/2023 ILaquis.
            $this->session->set_userdata('id_papel', $tamano_papel);  
            // FIN GAN-MS-B1-0469, 15/05/2023 ILaquis.

            $papel_update = $this->ajustes->update_papeles($id_usuario,$tamano_papel);
            $ajustes_insert = $this->ajustes->update_ajustes($json, $id_usuario);
            if ($ajustes_insert) {
                $this->session->set_flashdata('success','Datos registrados correctamente.');
            } else {
                $this->session->set_flashdata('error','Error al registrar los datos.');
            }
            redirect('ajustes');
        }
    }
}

