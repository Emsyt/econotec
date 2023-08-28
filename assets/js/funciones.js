function activarMenu(id,sub){
    $('.menu').removeClass('active');
    $('.submenuli').removeClass('active');

    $('#'+id).addClass('active');
    $('#'+id+'_'+sub).addClass('active');
}

function activarMenuHeader(id){
    $('.menuHeader').removeClass('active');
    $('#'+id).addClass('active');
}

  //------- Validacion de los Campos -------// 
  function mayuscula(field) {
      field.value = field.value.toUpperCase();
  }

  function letra(e){
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = ' áéíóúabcdefghijklmnñopqrstuvwxyz0123456789.,;:/-°()"" ';

        if(letras.indexOf(tecla)==-1 ){
            return false;
        }
  }

  function numero(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
  }







