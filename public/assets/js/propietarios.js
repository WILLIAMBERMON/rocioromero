function editarpropietario(documento,  nombres,email, direcc,celular,estado){
    $('#nombres').val(nombres);
    $('#documento').val(documento);
    $('#documento').prop("readonly",true);
    $('#email').val(email);
    $('#direccion').val(direcc);
    $('#celular').val(celular);
    $('#crearbb').text('Editar Propietario');
    $('#crearbb').val(documento);
    $('#estado').val(estado);
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
    $('#estado').val('1');
    $('#crearbb').val('1');
    $('#addpro').show();
}

function editararrendatario(documento,  nombres,email, direcc,celular,estado,num_contrato,id){
    $('#nombres').val(nombres);
    $('#documento').val(documento);
    $('#email').val(email);
    $('#direccion').val(direcc);
    $('#celular').val(celular);
    $('#crearbb').text('Editar Arrendatario');
    $('#crearbb').val(documento);
    $('#estado').val(estado);
    $('#num_contrato').val(num_contrato);
    $('#id').val(id);
    $('#agregararrendatario').val('2');
    $('#addpro').show();
}

function newarrendatario(){
    $('#nombres').val('');
    $('#documento').val('');
    $('#email').val('');
    $('#direccion').val('');
    $('#celular').val('');
    $('#crearbb').text('Crear Arrendatario');
    $('#agregararrendatario').val('1');
    $('#estado').val('1');
    $('#num_contrato').val('');
    $('#id').val('-1');
    $('#crearbb').val('1');
    $('#addpro').show();
}