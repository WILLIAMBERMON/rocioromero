function activar(valor){
    if(valor == 'SI-ANONIMA'){
        $('#notificacion').css("display", "block");
        $('#notificarcorreo').css("display", "none");
        $('#step2').css("display", "none");
        $('#progreso2').removeClass('active');
        $('#progreso2').addClass("disabled");
    }
    if(valor == 'SI-NOTIFICACION'){
        $('#notificarcorreo').css("display", "block");
        $('#step2').css("display", "none");
        $('#progreso2').removeClass('active');
        $('#progreso2').addClass("disabled");
    }
    
    if(valor == 'NO-NOTIFICACION'){
        $('#emaili').val();
        $('#notificarcorreo').css("display", "none");
        $('#step2').css("display", "block");
        $('#progreso2').removeClass('disabled');
        $('#progreso2').addClass("active");
    }
}

$('#emaili').on( "change", function() {
    $('#step2').css("display", "block");
    $('#progreso2').removeClass('disabled');
    $('#progreso2').addClass("active");
});

function verificarstep1(){
    var anonima = $("input[name=anonima]:checked").val();
    if(anonima){
        if(anonima.length){
            var notificacion = $("input[name=notificacion]:checked").val();
            if(notificacion == 'SI'){
                var emaili = $("#emaili").val();
                if(emaili.length){
                    return anonima;
                }else{
                    return false;
                }
            }
            return anonima;
        }else{
            return false;
        }
    }
}

function verificarstep2(){
    var tipopqrsd = $('#tipo_pqrsd').val();
    var dependencia = $('#dependencia').val();
    var descri = $('#descripcion').val();
    if((tipopqrsd.length > 0) && (dependencia.length > 0) && (descri.length > 0)){
        return true;
    }else{
        return false;
    }
}

function validarform(){
    var step1 = verificarstep1();
    if(step1){
        if(step1 == 'SI'){
            if(verificarstep2()){
                $('#form_radicar').submit();
            }else{
                toastr.error('Para poder radicar el PQRSD es necesario que complete el paso 2.');
            }
        }
    }else{
        toastr.error('Para poder radicar el PQRSD es necesario que diligencie el paso 1 del el formulario.');
    }
}

  $(document).ready(function() {
    $("#dependencia").select2({
        placeholder: "Seleccione...",
        allowClear: true
    });

    
});

window.addEventListener("keypress", function(event){
    if (event.keyCode == 13){
        event.preventDefault();
    }
}, false);

function buscarinfo(){
    var codigo = $('#codigo').val();
    var host = window.location.protocol + "//" + window.location.host + "/";
    $.ajax({
        url: host+'buscarinfo',
        type: "POST",
        cache: false,
        data:{codigo: codigo},
        success: function(data){
            $('#step3').hide();
            var info = jQuery.parseJSON(data);
            if(info.carga){
                if(info.registrado == 'S'){
                    window.location.replace(host+"login");
                }else{
                    var infousuario = jQuery.parseJSON(info.infod);
                    if(infousuario['LDAP'] == 'S'){
                        window.location.replace(host+"login");
                    }else{
                    $('#tipo_documento').val(infousuario['TIPO_DOCUMENTO']);
                    $('#ftipodoc').addClass("input--filled");
                    $('#documento').val(infousuario['DOCUMENTO']);
                    $('#fdoc').addClass("input--filled");
                    $('#nombres').val(infousuario['PRIMER_NOMBRE']+' '+infousuario['SEGUNDO_NOMBRE']);
                    $('#fname').addClass("input--filled");
                    $('#apellidos').val(infousuario['PRIMER_APELLIDO']+' '+infousuario['SEGUNDO_APELLIDO']);
                    $('#flastname').addClass("input--filled");
                    $('#celular').val(infousuario['CELULAR']);
                    $('#fcel').addClass("input--filled");
                    $('#email').val(infousuario['EMAIL']);
                    $('#fmail').addClass("input--filled");
                    $('#emaili').val(infousuario['EMAIL']);
                    $('#fmaili').addClass("input--filled");
                    verificarstep2();}
                }
            }else{
                $('#step3').show();
                $('#documento').val(codigo);
                $('#fdoc').addClass("input--filled");
                toastr.error('No se encontro información con el número de identificación digitado.');
            }
        }
        });
}