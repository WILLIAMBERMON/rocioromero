function editarusuario (documento, tipodoc, nombres,apellidos,email, celular){
    $('#nombres').val(nombres);
    $('#tipo_documento').val(tipodoc);
    $('#documento').val(documento);
    $('#documento').prop("readonly",true);
    $('#email').val(email);
    $('#apellidos').val(apellidos);
    $('#celular').val(celular);
    $('#crearbb').text('Editar Usuario');
    $('#crearbb').val(documento);
    $('#agregarusuario').val('2');
    $('#rclave').show();
    $('#adduser').show();
    
}

function newusuario(){
    $('#rclave').hide();
    $('#rclave').val('');
    $('#nombres').val('');
    $('#tipo_documento').val('');
    $('#documento').val('');
    $('#documento').prop("readonly",false);
    $('#email').val('');
    $('#apellidos').val('');
    $('#celular').val('');
    $('#crearbb').text('Crear Usuario');
    $('#agregarusuario').val('1');
    $('#crearbb').val('1');
    $('#adduser').show();
}

