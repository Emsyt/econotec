<?php
/*
--------------------------------------------------------------------------------------------------------------------------------------------------
 Modificado: Gary German Valverde Quisbert Fecha:23/08/2022, Codigo: GAN-SC-M3-367
 Descripcion: Se modifico el nombre de que_permisos_tiene por listar_permisos_rol, para que tenga una descripción mas apropiada
 -------------------------------------------------------------------------------------------------------------------------------------------------
*/
/* 
-----------------------------------------------------------------------------------------------
Modificado: Pedro Rodrigo Beltran Poma.   Fecha:23/08/2022,   Codigo: GAN-SC-M3-364,
Descripcion: Se cambiaron nombres de argumentos en el foreach para funcionar con el array de objetos
retornado por fn_verificar_usuario.
------------------------------------------------------------------------------------------------
*/
/*
-----------------------------------------------------------------------------------------------
Modificado: Luis Fabricio Pari Wayar.   Fecha:04/10/2022,   Codigo: GAN-MS-M4-0019,
Descripcion: Se añadio un ciclo for para rescatar y validar si un usuario tiene permiso al dashboard.
------------------------------------------------------------------------------------------------
Modificado: Jose Daniel Luna Flores.   Fecha:02/12/2022,   Codigo: GAN-MS-M5-0154,
Descripcion: Se añadio un nuevo campo para los datos de usuario (Ubicacion).
------------------------------------------------------------------------------------------------
*/


defined('BASEPATH') OR exit('No direct script access allowed');

class C_login extends CI_Controller {
  function __construct() {
      parent::__construct();
      $this->load->model(array('M_login' => 'login'));
  }

    public function index() {
        if ($this->session->userdata('login')) {
            redirect(base_url(). 'inicio');
            $usrid = $this->session->userdata('id_usuario');
            $this->general->update_user_online($usrid,1);
        } else {
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['thema'] = $this->general->get_ajustes("tema");
            $this->load->view('templates/login', $data);
        }  
    }
    
    public function verificar_usuario() {
        $this->form_validation->set_rules('usuario', 'usuario', 'required|min_length[5]|max_length[30]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[3]|max_length[30]');
        
        if (($this->form_validation->run() == FALSE)) {
            $data['error'] = $er = "Ingrese usuario y password válidos";
            $log = array(
                'tipo' => 'INGRESO-ERROR',
                'ip' => $this->getRealIP(),
                'url' => 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'],
                'navegador' => $this->getBrowser($_SERVER['HTTP_USER_AGENT']),
                'mensaje' => $er,          
                'usucre' => $_POST['usuario'],
                'feccre' => date('Y-m-d H:i:s')
            );
            $result = $this->login->guardar_log($log);
            $data['logo'] = $this->general->get_ajustes("logo");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $data['thema'] = $this->general->get_ajustes("tema"); 
            $this->load->view('templates/login', $data);            
        } else {        
            $result = $this->login->verificar_usuario();   
            $id_rol = -1; 
            $cargo='';
            $nacional='';            
            if (count($result) == 1) {
                
                    // GAN-SC-M3-364, 23-08-2022, Pedro Beltran.
                    foreach ($result as $row) {
                        $this->session->set_userdata('login', TRUE);
                        $this->session->set_userdata('usuario', $row->ologin);
                        $this->session->set_userdata('id_usuario', $row->oidusuario);
                        $this->session->set_userdata('id_papel', $row->oidpapel);  
                        $reg = $this->login->que_cargo_es($row->oidusuario);             
                        // GAN-SC-M-366, 23-08-2022, Denilson Santander
                        foreach ($this->login->que_cargo_es($row->oidusuario) as $res_cargo){
                            $id_rol = $res_cargo->oid_rol;
                            $cargo = $res_cargo->odescripcion;
                            $nacional = $res_cargo->odepartamentos;
                        }   
                        $permisos = '';  
                        // Fin GAN-SC-M-366, 23-08-2022, Denilson Santander      
                            if($id_rol!=-1&&$cargo!=''&&$nacional!=''){
                                // GAN-SC-M3-367, 23-08-2022, Gary Valverde.
                                foreach ($this->login->listar_permisos_rol($id_rol) as $registros) {
                                // FIN GAN-SC-M3-367, 23-08-2022, Gary Valverde.
                                    $permisos = $permisos . $registros->descripcion . ",";
                                }
                                 $this->session->set_userdata('cargo', $cargo);
                        $permisos = explode(",", $permisos);
                        unset($permisos[count($permisos)-1]);
                        
                        $this->session->set_userdata('nacional', explode(",", $nacional));
                        $this->session->set_userdata('permisos', $permisos);                    
                        $this->session->set_userdata('nombre', $row->onombre.' '.$row->opaterno.' '.$row->omaterno);                   
                        $this->session->set_userdata('carnet', $row->ocarnet);
                        $this->session->set_userdata('id_depto', $row->oiddepartamento);
                        $this->session->set_userdata('foto', $row->ofoto);
                        $this->session->set_userdata('ubicacion', $row->oidproyecto);
                        // INICIO GAN-MS-M5-0154, 02/12/2022, JLuna -- Se modifico el nombre del dato para evitar errores al mandar un texto en vez del id
                        $this->session->set_userdata('name_ubicacion', $row->oubicacion);
                        // FIN GAN-MS-M5-0154, 02/12/2022, JLuna 
                        // FIN GAN-SC-M3-364, 23-08-2022, Pedro Beltran.
                        // GAN-MS-B1-0456, 11/05/2023, ILaquis 
                        $this->session->set_userdata('cod_catalogo', $row->ocodcatalogo);
                        // FIN GAN-MS-B1-0456, 11/05/2023, ILaquis 
                            }
                            else{
                                $log = array(
                                    'tipo' => 'INGRESO-ERROR',
                                    'ip' => $this->getRealIP(),
                                    'url' => 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'],
                                    'navegador' => $this->getBrowser($_SERVER['HTTP_USER_AGENT']),
                                    'mensaje' => 'Usuario sin id_rol asignado',          
                                    'usucre' => $_POST['usuario'],
                                    'feccre' => date('Y-m-d H:i:s') 
                                );
                                echo("error");
                                $result = $this->login->guardar_log($log); 
                                redirect('errorrol');
                            }
                    }                      
                    $log = array(
                        'tipo' => 'INGRESO-OK',
                        'ip' => $this->getRealIP(),
                        'url' => 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'],
                        'navegador' => $this->getBrowser($_SERVER['HTTP_USER_AGENT']),
                        'mensaje' => null,          
                        'usucre' => $_POST['usuario'],
                        'feccre' => date('Y-m-d H:i:s') 
                    );
                    $usrid = $this->session->userdata('id_usuario');
                    $this->general->update_user_online($usrid,1);
                    $result = $this->login->guardar_log($log);
                    //GAN-MS-M4-0019 - 04/10/2022 LPari
                    for ($i = 0; $i<=count($permisos) ; $i++) {
                        $aquiesta=$permisos[$i];
                        if ($permisos[$i] == 'dashboard' ) {
                            redirect('inicio','refresh');
                            break;
                        }
                    } 
                    redirect('inicial');
                    //FIN GAN-MS-M4-0019 - 04/10/2022 LPari
                
                       
            }else {
                $log = array(
                    'tipo' => 'INGRESO-ERROR',
                    'ip' => $this->getRealIP(),
                    'url' => 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'],
                    'navegador' => $this->getBrowser($_SERVER['HTTP_USER_AGENT']),
                    'mensaje' => 'Usuario no existe',          
                    'usucre' => $_POST['usuario'],
                    'feccre' => date('Y-m-d H:i:s') 
                );
                $result = $this->login->guardar_log($log); 
                redirect('error');
            }
        }
    }

    public function error() {
        $data['error'] = "Usuario o password incorrecto, por favor vuelva a intentar";
        $data['logo'] = $this->general->get_ajustes("logo");
        $data['descripcion'] = $this->general->get_ajustes("descripcion");
        $data['thema'] = $this->general->get_ajustes("tema");
        $this->load->view('templates/login', $data);
    }
   
    public function logout() {
        $usrid = $this->session->userdata('id_usuario');
        $this->session->sess_destroy();
        $this->general->update_user_online($usrid,0);
        redirect(base_url());
    }
    public function errorrol() {
      
        $usrid = $this->session->userdata('id_usuario');
        $this->session->sess_destroy();
        $this->general->update_user_online($usrid,0);
        //redirect(base_url());
        $data['error'] = "Usuario sin rol asignado";
        $data['logo'] = $this->general->get_ajustes("logo");
        $data['descripcion'] = $this->general->get_ajustes("descripcion");
        $data['thema'] = $this->general->get_ajustes("tema");
        $this->load->view('templates/login', $data);
    }
    public function getRealIP(){
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else        
            return $_SERVER["REMOTE_ADDR"];     
    }

    public function getBrowser($user_agent){
        if(strpos($user_agent, 'MSIE') !== FALSE)
           return 'Internet explorer';
         elseif(strpos($user_agent, 'Edge') !== FALSE)
           return 'Microsoft Edge';
         elseif(strpos($user_agent, 'Trident') !== FALSE)
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
}