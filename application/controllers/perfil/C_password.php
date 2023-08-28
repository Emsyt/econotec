<?php
/*
-------------------------------------------------------------------------------------------------------------------------------
Modificacion: Milena Rojas Fecha:18/04/2022, Codigo: GAN-MS-M4-162,
Descripcion: se aImplementó el funcionamiento del cambio de contraseña
-------------------------------------------------------------------------------------------------------------------------------
Modificado: Gary German Valverde Quisbert Fecha:28/09/2022, Codigo: GAN-MS-B9-0002
Descripcion: Se cambio los flashdata por TempData para no perder datos de sesion y mostrar alerta al usuario
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_password extends CI_Controller {
  function __construct() {
      parent::__construct();
      $this->load->model(array('perfil/M_perfil' => 'perfil'));
  }

	public function index(){
        if ($this->session->userdata('login')) {
            $id_usr = $this->session->userdata('id_usuario');
            $data['lib'] = 0;
            $data['datos_menu'] = $this->setpermiso();
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['contenido'] = 'perfil/cambio_password';
          
            $data['chatUsers'] = $this->general->chat_users($id_usr);
            $data['getUserDetails'] = $this->general->get_user_details($id_usr);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
	}

        function setpermiso(){
            $login=$this->session->userdata('login');
            if($login) {
                $accesos['permisos'] = $this->session->userdata('permisos'); 
                return $accesos;   
            }
        }

    public function update_pass(){          
        $idus = $this->session->userdata('id_usuario');
        $result = $this->perfil->verificar_password();  
        $old_pass = $this->input->post('password');
        $new_pass = $this->input->post('password1');
        if (count($result) == 1) {
            // $data = array(
            //     'password' => md5($this->input->post('password1')),
            //     'usumod' => $id_usr,
            //     'fecmod' => date('Y-m-d H:i:s')
            //     );

            $pass_update = $this->perfil->update_pass($idus, $old_pass, $new_pass);
            print_r($pass_update);
            if ($pass_update[0]->oboolean == 't') {
                /* GAN-MS-B9-0002 GaryValverde 28-09-2022 */
                //Se comento el envio de flashdata por si surge errores posteriores
                /* $this->session->set_flashdata('success','Contraseña modificado exitosamente.');   */
                $this->session->set_tempdata('success', 'Contraseña modificado exitosamente.', 50);
                redirect('cambio_password');
            } else {
                /* $this->session->set_flashdata('error',$pass_update[0]->omensaje); */
                $this->session->set_tempdata('error', $pass_update[0]->omensaje, 50);
                redirect('cambio_password');
                /* fin GAN-MS-B9-0002 GaryValverde 28-09-2022 */
            }
        }else{
            redirect('error_password');
        }
    }

    public function error() {
        if ($this->session->userdata('login')) {
            $data['error'] = "Contraseña actual incorrecta, por favor vuelva a intentar";
            $data['lib'] = 0;
            $data['datos_menu'] = $this->setpermiso();
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['cantidadN'] = $this->general->count_notificaciones();
            $data['lst_noti'] = $this->general->lst_notificacion();
            $data['mostrar_chat'] = $this->general->get_ajustes("mostrar_chat");
            $data['contenido'] = 'perfil/cambio_password';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
}