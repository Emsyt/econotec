<?php
$this->load->view('templates/header');
$this->load->view('templates/main',$datos_menu);
$this->load->view($contenido);
$this->load->view('templates/footer',$lib);
// 
$obj = json_decode($mostrar_chat->fn_mostrar_ajustes);
$mstr_chat = $obj->{'mostrar_chat'};
if($mstr_chat == "true"){
$this->load->view('templates/chat');
}