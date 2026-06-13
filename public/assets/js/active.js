function validarclave(pswd,algo) {
    var detener = true;
    $('#length').removeClass('invalid').addClass('valid');
    if ( pswd.length < 8 ) {
        detener = false;
        $("#wlength").prop('checked', false);
        $('#length').removeClass('valid').addClass('invalid');
    } else {
        $("#wlength").prop('checked', true);
        $('#length').removeClass('invalid').addClass('valid');
    }

    //validate letter
    if ( pswd.match(/[A-z]/) ) {
        $("#wlletter").prop('checked', true);
        $('#letter').removeClass('invalid').addClass('valid');
    } else {
        detener = false;
        $("#wlletter").prop('checked', false);
        $('#letter').removeClass('valid').addClass('invalid');
    }

    //validate capital letter
    if ( pswd.match(/[A-Z]/) ) {
        $("#wcapital").prop('checked', true);
        $('#capital').removeClass('invalid').addClass('valid');
    } else {
        detener = false;
        $("#wcapital").prop('checked', false);
        $('#capital').removeClass('valid').addClass('invalid');
    }

    if ( pswd.match(/[a-z]/) ) {
        $("#wminuscula").prop('checked', true);
        $('#minuscula').removeClass('invalid').addClass('valid');
    } else {
        detener = false;
        $("#wminuscula").prop('checked', false);
        $('#minuscula').removeClass('valid').addClass('invalid');
    }


    //validate number
    if ( pswd.match(/\d/) ) {
        $("#wnumber").prop('checked', true);
        $('#number').removeClass('invalid').addClass('valid');
    } else {
        detener = false;
        $("#wnumber").prop('checked', false);
        $('#number').removeClass('valid').addClass('invalid');
    }

    if(algo){
        return detener;
    }

    if(!detener){
        $('#pswd_info').show();
    }else{
        $('#pswd_info').hide();
    }
}

function hizoclic(pswd) {
    //$('#pswd_info').show();
    validarclave(pswd);
    $('#pswd_rep').hide();
}

function validigual(pswd) {
    var clave = document.getElementById('password').value;
    var bien = true;
    var validar = true;
    if(!clave){
        var validar = false;
        document.getElementById('rpassword').value = '';
        toastr.error('Para poder finalizar, primero debe escribir la contraseña principal.');
        $('#pswd_rep').hide();
    }else{
        if (( clave.length < 8 ) || (!( clave.match(/[A-z]/))) || (!( clave.match(/[A-Z]/) )) || (!( clave.match(/[a-z]/) )) || (!( clave.match(/\d/) ) )) {
            var validar = false;
            document.getElementById('rpassword').value = '';
            toastr.error('Para poder finalizar, la contraseña principal debe cumplir con los requisitos.');
            $('#pswd_rep').hide();
        }
    }
    if(validar){
        if(clave == pswd){
            $("#wigual").prop('checked', true);
            $('#igual').removeClass('invalid').addClass('valid');
        }else{
            bien =false;
            $("#wigual").prop('checked', false);
            $('#igual').removeClass('valid').addClass('invalid');
        }
        if(!bien){
            $('#pswd_rep').show();
        }else{
            $('#pswd_rep').hide();
        }
    }
}

function validarclaves(){
    var pswd = document.getElementById('password').value;
    if(validarclave(pswd,true)){
        var rpswd = document.getElementById('rpassword').value;
        if(pswd == rpswd){
            toastr.success('Gracias por finalizar el registro.');
            $("#form_registro").submit();
        }else{
            toastr.error('Para poder finalizar, las contraseñas deben coincidir.');
        }
    }else{
        toastr.error('Para poder finalizar, la contraseña principal debe cumplir con los requisitos.');
    }
}