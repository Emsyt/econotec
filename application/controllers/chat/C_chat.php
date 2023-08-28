<?php
/*
  ------------------------------------------------------------------------------
  Creado: Alison Paola Pari Pareja Fecha:12/05/2022, GAN-FR-A1-219
  Descripcion: Se crearon las funciones para el uso del chat
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
       
    }

    public function insertChat($reciever_userid){ 
        $message = $this->input->post('chat_message');
        $user_id = $this->session->userdata('id_usuario'); 
		$query = $this->db->query("INSERT INTO ope_chats (id_usuario_receptor, id_usuario_remitente, mensaje , estado) 
		values ($reciever_userid,$user_id,'$message ',1)");
      
        $conversation = $this->getUserChat($user_id, $reciever_userid);
        $data = array(
            "conversation" => $conversation			
        );
        echo json_encode($data);
    }
    public function updateUserChat($from_user_id, $to_user_id) {
        
        $conversation = $this->getUserChat($from_user_id, $to_user_id);
        $data = array(
            "conversation" => $conversation			
        );
        echo json_encode($data);
    }
    public function getUserChat($from_user_id, $to_user_id) {
        $fromUserAvatar = $this->general->get_user_avatar($from_user_id);
        $fromavatar=$fromUserAvatar->foto;
		$toUserAvatar = $this->general->get_user_avatar($to_user_id);
        $toavatar=$toUserAvatar->foto;
		$query = $this->db->query("
			SELECT * FROM ope_chats 
			WHERE (id_usuario_remitente = $from_user_id
			AND id_usuario_receptor = $to_user_id) 
			OR (id_usuario_remitente = $to_user_id
			AND id_usuario_receptor = $from_user_id) 
			ORDER BY hora ASC");
		$userChat = $query->result();	
		$conversation = '<ul>';
		foreach($userChat as $chat){
			$user_name = '';
            if (empty($fromavatar) && empty($toavatar)) { 
                if($chat->id_usuario_remitente == $from_user_id) {
                    $conversation .= '<li class="sent">';
                    $conversation .= '<img width="22px" height="22px" src="assets/img/personal/default-user.png" alt="" />';
                } else {
                    $conversation .= '<li class="replies">';
                    $conversation .= '<img width="22px" height="22px" src="assets/img/personal/default-user.png" alt="" />';
                }
            }else{
                if (empty($fromavatar)) { 
                    if($chat->id_usuario_remitente == $from_user_id) {
                        $conversation .= '<li class="sent">';
                        $conversation .= '<img width="22px" height="22px" src="assets/img/personal/default-user.png" alt="" />';
                    } else {
                        $conversation .= '<li class="replies">';
                        $conversation .= '<img width="22px" height="22px" src="assets/img/personal/'.$toavatar.'" alt="" />';
                    }
                }else{
                    if (empty($toavatar)) { 
                        if($chat->id_usuario_remitente == $from_user_id) {
                            $conversation .= '<li class="sent">';
                            $conversation .= '<img width="22px" height="22px" src="assets/img/personal/'.$fromavatar.'" alt="" />';
                        } else {
                            $conversation .= '<li class="replies">';
                            $conversation .= '<img width="22px" height="22px" src="assets/img/personal/default-user.png" alt="" />';
                        }

                    }else{
                        if($chat->id_usuario_remitente == $from_user_id) {
                            $conversation .= '<li class="sent">';
                            $conversation .= '<img width="22px" height="22px" src="assets/img/personal/'.$fromavatar.'" alt="" />';
                        } else {
                            $conversation .= '<li class="replies">';
                            $conversation .= '<img width="22px" height="22px" src="assets/img/personal/default-user.png" alt="" />';
                        }
                    }
                }
            }	
            $conversation .= '<p>'.$chat->mensaje.'</p>';			
            $conversation .= '</li>';
		}		
		$conversation .= '</ul>';
        return $conversation;
	}
    public function showUserChat($to_user_id) {		
        
        $from_user_id = $this->session->userdata('id_usuario');
        $userDetails = $this->general->get_user_details($to_user_id);
		$toUserAvatar = $userDetails->foto;
        if (empty($toUserAvatar)) { 
            $userSection = '  <a style="cursor:pointer;" data-toggle="collapse" data-target="#sidepanel" class="barra"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a> <img src="assets/img/personal/default-user.png" alt="" /> <p>'.$userDetails->login.'</p><br> <p style="padding-top:0; opacity:.5; float: left;">'.$userDetails->descripcion.'</p>';
           } else { 
            $userSection = '  <a style="cursor:pointer;" data-toggle="collapse" data-target="#sidepanel" class="barra"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a> <img src="assets/img/personal/'.$userDetails->foto.'" alt="" /> <p>'.$userDetails->login.'</p><br> <p style="padding-top:0; opacity:.5; float: left;">'.$userDetails->descripcion.'</p>';
           }
        // get conversacion usuario
		$conversation = $this->getUserChat($from_user_id, $to_user_id);
        // actualizacion del estado del chat del usuario	
		$query = $this->db->query("
        UPDATE ope_chats
        SET estado = '0' 
        WHERE id_usuario_remitente = $to_user_id AND id_usuario_receptor =$from_user_id AND estado = '1'");
        // actualizacion de sesion actual
        $query1 =  $this->db->query("
        UPDATE seg_usuario
        SET sesion_actual = $to_user_id 
        WHERE id_usuario  = $from_user_id");

		$data = array(
			"userSection" => $userSection,
            "conversation" => $conversation	
		 );
		
		 echo json_encode($data);		
	}	
    public function getUnreadMessageCount($recieverUserid) {
        $senderUserid=$this->session->userdata('id_usuario');
		$query = $this->db->query("
			SELECT count(*) FROM ope_chats 
			WHERE id_usuario_remitente = $recieverUserid AND id_usuario_receptor = $senderUserid  AND estado = '1'");
        $sqlQuery=$query->row();
            
		$output = '';
		if($sqlQuery > 0){
			$output = $sqlQuery;
		}
       
        echo json_encode($output );
	}
}
