<?php
 /*
  -------------------------------------------------------------------------------------------------------
  -- Creado: Jhonatan Nestor Romero Condori                                            Fecha:03/07/202 --
  -- Modulo: recursos/feriado           Proyecto: ECOGAN                     Actividad:GAN-FCL-B3-0318 -- 
  -- Descripcion: se creo el modulo feriado y funciones para que realize un ABM.                       --
  -------------------------------------------------------------------------------------------------------
  */
defined('BASEPATH') OR exit('No direct script access allowed');

class C_feriado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('recursos/M_feriado','feriado');
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
            $data['contenido'] = 'recursos/feriado';
            $usrid = $this->session->userdata('id_usuario');
            $data['chatUsers'] = $this->general->chat_users($usrid);
            $data['getUserDetails'] = $this->general->get_user_details($usrid);
            $this->load->view('templates/estructura',$data);
        } else {
            redirect('logout');
        }
    }
 

    public function listar_registro_feriado(){
        $id_feriado = $this->input->post('id_feriado');
        $data = $this->feriado->listar_reg_feriado();
        echo json_encode($data);
    }

     
 
    public function add_update_feriado(){
        if ($this->input->post('btn') == 'add') {
           
            $id_feriado = 0;
            $fecha = $this->input->post('fecha_feriado');
            $descripcion = $this->input->post('descr_feriado');
            $ambito = $this->input->post('ambito');
            $fer_insert = $this->feriado->gestionar_feriado($id_feriado,$fecha,$descripcion,$ambito);

            foreach ($fer_insert as $row) {
                $auxiliar=$row->oboolean;
              }
                if ($auxiliar) {
                    $this->session->set_flashdata('success','Registro insertado exitosamente111.');
                } else {
                    $this->session->set_flashdata('error','Error al insertar Registro.');
                }
               
                

            

        } elseif ($this->input->post('btn') == 'edit') {
                           
                $id_feriado = $this->input->post('id_feriado');
                $fecha = $this->input->post('fecha_feriado');
                $descripcion = $this->input->post('descr_feriado');
                $ambito = $this->input->post('ambito');
                $fer_update = $this->feriado->gestionar_feriado($id_feriado,$fecha,$descripcion,$ambito);
                foreach ($fer_update as $row) {
                    $auxiliar=$row->oboolean;
                  }
                    if ($auxiliar) {
                        $this->session->set_flashdata('success','Registro modificado exitosamente.');
                    } else {
                        $this->session->set_flashdata('error','Error al modificar registro.');
                    }

                
                
        }
      
        redirect('feriado');
    }

    public function datos_feriado($id_fer){
        $data = $this->feriado->get_datos_feriado($id_fer);
        
        $rewriteKeys = array(
            'oidferiado' => 'id_feriado',
            'ofecha' => 'fecha',
            'odescripcion' => 'descripcion',
            'oambito' => 'ambito'
         
        );
  
        $datos = array();
  
        foreach($data as $key => $value) {
           $datos[ $rewriteKeys[ $key ] ] = $value;
        }

        echo json_encode($datos);
       
    }

    public function dlt_feriado($id_fer,$estado){
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
        $this->feriado->delete_feriado($id_fer, $data);
      

        redirect('feriado');
    }

}
