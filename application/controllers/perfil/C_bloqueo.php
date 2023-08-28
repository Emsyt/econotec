<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_bloqueo extends CI_Controller {
  function __construct() {
      parent::__construct();
      $this->load->model(array('perfil/M_perfil' => 'perfil'));
  }

	public function index(){
        if ($this->session->userdata('login')) {
            $data['lib'] = 0;
            $data['titulo'] = $this->general->get_ajustes("titulo");
            $data['thema'] = $this->general->get_ajustes("tema");
            $data['descripcion'] = $this->general->get_ajustes("descripcion");
            $this->load->view('perfil/bloqueo',$data);
            $this->load->view('templates/footer',$data);
        } else {
            redirect('logout');
        }
	}

    public function verificar_password() {
    	$user = $this->session->userdata('usuario');
    	$pass = $this->input->post('password');
    	$result = $this->perfil->verificar_password($user, $pass);
		if (count($result) == 1) {
			redirect('inicio', 'refresh'); 	
	   	} else {
	    	$this->load->view('perfil/bloqueo');
            redirect('error_desbloqueo');
		}
    }

    public function error_desbloqueo() {
        if ($this->session->userdata('login')) {
            $data['error'] = "Password incorrecto, por favor vuelva a intentar";
            $data['lib'] = 0;
            $this->load->view('perfil/bloqueo',$data);
            $this->load->view('templates/footer',$data);
        } else {
            redirect('logout');
        } 
    }
}
