<?php 
/*
  ------------------------------------------------------------------------------
  Creado: Alison Paola Pari Pareja Fecha:12/05/2022, GAN-FR-A1-219
  Descripcion: Se creo la vista del chat interno

*/
?>

<style>



button{
    border:none;
    outline: none;
    cursor: pointer;
}

ul {
padding-left: 0px;
}

.chat-btn{
    position: fixed;
    right:50px;
    bottom: 50px;
    background: dodgerblue;
    color: white;
    width:60px;
    height: 60px;
    border-radius: 50%;
    opacity: 0.8;
    transition: opacity 0.3s;
    box-shadow: 0 5px 5px rgba(0,0,0,0.4);
    padding-top: 8px;
 

}
.chat-btn-alerta{
    position: fixed;
    right:50px;
    bottom: 50px;
    background: dodgerblue;
    color: white;
    width:60px;
    height: 60px;
    border-radius: 50%;
    opacity: 0.8;
    transition: opacity 0.3s;
    box-shadow: 0 5px 5px rgba(0,0,0,0.4);
    padding-top: 8px;
    animation-name: parpadeo;
  animation-duration: 1.5s;
  animation-timing-function: linear;
  animation-iteration-count: infinite;

  -webkit-animation-name:parpadeo;
  -webkit-animation-duration: 1.5s;
  -webkit-animation-timing-function: linear;
  -webkit-animation-iteration-count: infinite;

}
@-moz-keyframes parpadeo{  
  0% { opacity: 1.0; }
  50% { opacity: 0.0; }
  100% { opacity: 1.0; }
}

@-webkit-keyframes parpadeo {  
  0% { opacity: 1.0; }
  50% { opacity: 0.0; }
   100% { opacity: 1.0; }
}

@keyframes parpadeo {  
  0% { opacity: 1.0; }
   50% { opacity: 0.0; }
  100% { opacity: 1.0; }
}

.chat-btn:hover, .submit:hover, #emoji-btn:hover{
    opacity: 1;
}

.chat-popup{
    display: none;
    position: fixed;
    
}
#frame {
    
    position: fixed;
    bottom:80px;
    right:120px;
    height: 380px;
    width: 400px;
    
    flex-direction: column;
    justify-content: space-between;

   
    border-radius: 10px;
}
#frame #sidepanel {
  float: left;
  width: 35%;
  height: 380px;
  background: dodgerblue;
  color: #f5f5f5;
  overflow: hidden;
  position: relative;
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;
  
}
#frame #sidepanel #profile {
  width: 90%;
  margin: 10px auto;
}
#frame #sidepanel #profile .wrap {
  height: 40px;
  overflow: hidden;
  -moz-transition: 0.3s height ease;
  -o-transition: 0.3s height ease;
  -webkit-transition: 0.3s height ease;
  transition: 0.3s height ease;
}
#frame #sidepanel #profile .wrap img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2px solid #2ecc71;
  float: left;
  cursor: pointer;
  -moz-transition: 0.3s border ease;
  -o-transition: 0.3s border ease;
  -webkit-transition: 0.3s border ease;
  transition: 0.3s border ease;
  object-fit: cover;
}
#frame #sidepanel #profile .wrap p {
    font-size: 1.2rem;
    margin-left: 50px;
    margin-bottom:0;
    white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
#frame #sidepanel #contacts {
  height: 320px;
  overflow-y: scroll;
  overflow-x: hidden;
  
}
#frame #sidepanel #contacts.expanded {
  height: calc(100% - 334px);
}
#frame #sidepanel #contacts::-webkit-scrollbar {
  width: 8px;
  background: white;
}
#frame #sidepanel #contacts::-webkit-scrollbar-thumb {
  background-color: dodgerblue;
}
#frame #sidepanel #contacts ul li.contact {
  position: relative;
  padding: 10px 0 15px 0;
  font-size: 0.9em;
  cursor: pointer;
  list-style-type:none;
}
#frame #sidepanel #contacts ul li.contact:hover {
  background: #32465a;
}
#frame #sidepanel #contacts ul li.contact .wrap {
  width: 88%;
  margin: 0 auto;
  position: relative;
}
#frame #sidepanel #contacts ul li.contact .wrap span {
  position: absolute;
  left: 0;
  margin: -2px 0 0 -2px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  border: 2px solid #2c3e50;
  background: #95a5a6;
}
#frame #sidepanel #contacts ul li.contact .wrap span.online {
  background: #2ecc71;
}
#frame #sidepanel #contacts ul li.contact .wrap span.unread {
   background:red;  
   position: relative;
}
#frame #sidepanel #contacts ul li.contact .wrap img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  float: left;
  margin-right: 10px;
  object-fit: cover;
}
#frame #sidepanel #contacts ul li.contact .wrap .meta {
  padding: 5px 0 0 0;
}
#frame #sidepanel #contacts ul li.contact .wrap .meta .name {
  font-weight: 600;
  font-size: 1rem;
  margin:0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
#frame #sidepanel #contacts ul li.contact .wrap .meta .preview {
  margin: 0;
  padding: 0 0 1px;
  font-weight: 400;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  -moz-transition: 1s all ease;
  -o-transition: 1s all ease;
  -webkit-transition: 1s all ease;
  transition: 1s all ease;
}
#frame #sidepanel #contacts ul li.contact .wrap .meta .preview span {
  position: initial;
  border-radius: initial;
  background: none;
  border: none;
  padding: 0 2px 0 0;
  margin: 0 0 0 1px;
  opacity: .5;
  font-size: 1rem;
}
.isTyping {
	font-size:12px;	
}
.show{
    display: flex;
}
#frame .content .messages {
  height: 287px;
  
  
  overflow-y: scroll;
  
}
#frame .content .messages ul li {
  display: inline-block;
  clear: both;
  float: left;
  margin: 10px 10px 5px 10px;
  width: calc(100% - 25px);
  font-size: 0.9em;
}
#frame .content .messages ul li:nth-last-child(1) {
  margin-bottom: 20px;
}
#frame .content .messages ul li.replies img {
  margin: 6px 8px 0 0;
  object-fit: cover;
}
#frame .content .messages ul li.replies p {
  background: #435f7a;
  color: #f5f5f5;
  margin: 0px;
}
#frame .content .messages ul li.sent img {
  float: right;
  margin: 6px 0 0 8px;
  object-fit: cover;
}
#frame .content .messages ul li.sent p {
  background: white;
  float: right;
  margin: 0px;
}
#frame .content .messages ul li img {
  width: 22px;
  border-radius: 50%;
  float: left;
  object-fit: cover;
}
#frame .content .messages ul li p {
  display: inline-block;
  padding: 10px 15px;
  border-radius: 20px;
  max-width: 175px;
  line-height: 130%;
  margin: 0px;
}
#frame .content .message-input {
  position: absolute;
  bottom: 0;
  width: 100%;
  z-index: 99;
  padding: 0.60rem;
}
#frame .content .message-input .wrap {
  position: relative;
}
#frame .content .message-input .wrap input {
  font-family: "proxima-nova",  "Source Sans Pro", sans-serif;
  float: left;
  border: 1px solid #ccc;
  width: calc(100% - 40px);
  padding: 11px 32px 10px 8px;
  font-size: 0.8em;
  color: #32465a;
  height: 2.2rem;
  border-radius: 5px;
}
#frame .content .message-input .wrap button {
  border: none;
  width: 30px;
  cursor: pointer;
  color: white;
  background-color: green;
  border-radius: 5px;
  opacity: 0.7;
  margin-left: 0.5rem;
}
#frame .content .message-input .wrap button:hover {
  background: #435f7a;
}

#frame .content {
  float: right;
  width: 65%;
  height: 100%;
  overflow: hidden;
  position: relative;
  padding-top: 0px;
  background-color: whitesmoke;
  border-radius: 10px;
}
#frame .content .contact-profile {
  width: 100%;
  height: 60px;
  background: dodgerblue;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;

}
#frame .content .contact-profile img {
  width:45px;
  height: 45px;
  border-radius: 50%;
  float: left;
  margin: 9px 12px 0 10px;
  object-fit: cover;
}
#frame .content .contact-profile p {
  float: left;
  color: white;
  padding-top: 7px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  margin:0;
}
.barra {
  float: left;
  margin:20px 0 0 5px;
  color:white;
}

</style>


    <section>
    

        <button class="chat-btn" id="btn_chat"> 
            <i class="material-icons"> comment </i>
        </button>

        <div class="chat-popup" id="popup">
            <div id="frame">
                <div id="sidepanel" class="collapse">
                    <div id="profile">
                        <div class="wrap">
                            <?php $foto = $getUserDetails->foto;
                            if (empty($foto)) { ?>
                              <img id="profile-img" src="<?php echo base_url('assets/img/personal/default-user.png'); ?>" class="online" alt="" />
                            <?php } else { ?>
                              <img id="profile-img" src="<?php echo base_url(); ?>assets/img/personal/<?php echo $foto?>" class="online" alt=""/>
                            <?php } ?>
                            
						                <p><?php echo $getUserDetails->login ?></p>
                            <p style="opacity: .5;"><?php echo $getUserDetails->descripcion ?></p>
                        </div>
                    </div>
                    <div id="contacts">	
                        <ul>
                        <?php foreach ($chatUsers as $users) {  
                            $status = 'offline';						
                            if($users->online==1) {
                              $status = 'online';
                            }
                            $activeUser = '';
                            if($user->id_usuario == $getUserDetails->sesion_actual) {
                              $activeUser = "active";
                            }?>
                            <li id="<?php echo $users->id_usuario?>" class="contact <?php echo $activeUser?>" data-user="<?php echo $getUserDetails->id_usuario ?>" data-touserid="<?php echo $users->id_usuario?>" data-tousername="<?php echo $users->login?>">
                                <div class="wrap">
                                    <span id="" class="contact-status <?php echo $status?>"></span>
                                    <?php $foto = $users->foto;
                                      if (empty($foto)) { ?>
                                        <img  src="<?php echo base_url('assets/img/personal/default-user.png'); ?>" alt="" />
                                      <?php } else { ?>
                                        <img  src="<?php echo base_url(); ?>assets/img/personal/<?php echo $foto?>" alt=""/>
                                      <?php } ?>
                                    <div class="meta">
                                    <p class="name"><span id="unread_<?php echo $users->id_usuario?>" class="unread"></span><?php echo $users->login ?></p>
                                       
                                        <p class="preview"><span id="" class="isTyping"><?php echo $users->descripcion ?></span></p>
                                    </div>
                                </div>
                            </li>
                            <?php }  ?>
                           
                        </ul>
					
					          </div>
                  </div>
              <div class="content" id="content"> 
                    <div class="contact-profile" id="userSection">
                      <a data-toggle="collapse" data-target="#sidepanel" class="barra"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
                        
                    </div>

                    <div class="messages" id="conversation">		
                    <input type="hidden" id="sesion_actual" name="sesion_actual" value="<?php echo $getUserDetails->sesion_actual ?>">
					          </div>
                    <div class="message-input" id="replySection">				
                      <div class="message-input" id="replyContainer">
                        <div class="wrap">
                          <input type="text" class="chatMessage" id="chatMessage<?php echo $getUserDetails->sesion_actual?>" placeholder="Escribe tu mensaje..." />
                          <button class="submit chatButton" id="chatButton<?php echo $getUserDetails->sesion_actual?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>	
                        </div>
                      </div>					
                    </div>
                    
                    
                    
                </div>
            </div>    
        </div>
    </section>
 

  <script>
   
const popup = document.querySelector('.chat-popup');
const chatBtn = document.querySelector('.chat-btn');

//   chat button toggler 

chatBtn.addEventListener('click', ()=>{
    popup.classList.toggle('show');
})
$(document).ready(function(){
  setInterval(function(){
    if ($('#frame').is(':hidden')){
    //console.log('cerrado');
    alertabotonpopup();
    }else{
    //console.log('abierto');
    $('#btn_chat').removeClass('chat-btn-alerta');
    $('#btn_chat').addClass('chat-btn');
    }	
	}, 4000);
 
                
  var to_user_id=document.getElementById("sesion_actual").value;
  //console.log(to_user_id);
  
  setInterval(function(){
		if(to_user_id==''){
      showUserChat(1);	
    }else{
      showUserChat(to_user_id);	
     
    };
    updateUnreadMessageCount();
	}, 4000);
      $(document).on('click', '.chat-btn', function(){		
        $(".messages").animate({ scrollTop: $('.messages')[0].scrollHeight}, 2000); 
      });	
    
      $(document).on('click', '.contact', function(){	
          $(".messages").animate({ scrollTop: $('.messages')[0].scrollHeight}, 500); 	
          $('.contact').removeClass('active');
          $(this).addClass('active');
          to_user_id = $(this).data('touserid');
          showUserChat(to_user_id);
         
        });	
      $(document).on("click", '.submit', function(event) {
        
        //console.log(to_user_id);
        sendMessage(to_user_id);
        $(".messages").animate({ scrollTop: $('.messages')[0].scrollHeight}, 3000); 
      });
     
      $(".chatMessage").keyup(function(event) {
            if (event.keyCode === 13) {
              
              sendMessage(to_user_id);
              $(".messages").animate({ scrollTop: $('.messages')[0].scrollHeight}, 3000); 
            }
        });
       
}); 

function showUserChat(to_user_id){

  //console.log(to_user_id);
	$.ajax({
		url:"<?php echo site_url('chat/C_chat/showUserChat') ?>/" + to_user_id,
		method:"POST",
		dataType: "json",
		success:function(response){
      $('#userSection').html(response.userSection);
      $('#conversation').html(response.conversation);
      $('#unread_'+to_user_id).html('');
      updateUnreadMessageCount();
		//console.log(response);
		}
	});
}
function updateUnreadMessageCount() {
 
	$('li.contact').each(function(){
		if(!$(this).hasClass('active')) {
			var to_user_idread = $(this).attr('data-touserid');
     
			$.ajax({
				url:"<?php echo site_url('chat/C_chat/getUnreadMessageCount') ?>/" + to_user_idread,
				method:"POST",
				dataType: "json",
				success:function(response){		
					if(response.count>0) {
            //console.log(to_user_idread);
            //console.log(response.count);
						$('#unread_'+to_user_idread).html(response.count);
            // document.getElementById(to_user_idread).className ='';	
            // document.getElementById(to_user_idread).className ='contact_animate';	
					}					
				}
			});
		}
	});
}
function alertabotonpopup() {
 
 $('li.contact').each(function(){
  var to_user_idread = $(this).attr('data-touserid');
    
     $.ajax({
       url:"<?php echo site_url('chat/C_chat/getUnreadMessageCount') ?>/" + to_user_idread,
       method:"POST",
       dataType: "json",
       success:function(response){		
         if(response.count>0) {
           //console.log(to_user_idread);
           //console.log(response.count);
           $('#btn_chat').removeClass('chat-btn');
          $('#btn_chat').addClass('chat-btn-alerta');
           	
         }					
       }
     });
   
 });
}

function sendMessage(to_user_id) {
	message = $(".message-input input").val();
  //console.log(message);
	$('.message-input input').val('');
	if($.trim(message) == '') {
		return false;
	}
	$.ajax({
		url:"<?php echo site_url('chat/C_chat/insertChat') ?>/" + to_user_id,
		method:"POST",
		data:{
      chat_message:message
    },
		dataType: "json",
		success:function(response) {
      //console.log(response);
			var resp = $.parseJSON(response);			
			$('#conversation').html(resp.conversation);				
			
		}
	});	
}
</script>
    