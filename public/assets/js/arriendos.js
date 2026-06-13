function editarpropietario(documento, tipodoc, nombres,email, direcc,celular,tipos){
    $('#nombres').val(nombres);
    $('#documento').val(documento);
    $('#documento').prop("readonly",true);
    $('#email').val(email);
    $('#direccion').val(direcc);
    $('#celular').val(celular);
    $('#crearbb').text('Editar Propietario');
    $('#crearbb').val(documento);
    $('#agregarpropietario').val('2');
    $('#addpro').show();
}

function newpropietario(){
    $('#nombres').val('');
    $('#documento').val('');
    $('#documento').prop("readonly",false);
    $('#email').val('');
    $('#direccion').val('');
    $('#celular').val('');
    $('#crearbb').text('Crear Propietario');
    $('#agregarpropietario').val('1');
    $('#crearbb').val('1');
    $('#addpro').show();
}


$('.inmuebles').select2();
$('.clientes-multiple').select2();
