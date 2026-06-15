function buscar_documentos(tipo,num_contrato='',tipodoc='',activadoc = 'agregardoc',boton = false){
          
$('#'+activadoc).html('');
var host = window.location.protocol + "//" + window.location.host + "/";
$.ajax({
    url: host+'buscardocumentos',
    type: "POST",
    cache: false,
    data:{tipo: tipo,num_contrato:num_contrato,tipodoc:tipodoc},
    success: function(data){
        var info = jQuery.parseJSON(data);
        if(info.carga){
            var mostrarGuardar = boton || tipodoc == 'imagenes';
            var cerrar = (activadoc == 'agregardoc') ? ('<br><button type="button" onclick="$(`#'+activadoc+'`).hide()" class="btn btn-flat btn-primary float-'+((mostrarGuardar)?'left':'right')+'"><i class="fa fa-fw fa-times"></i> Cerrar </button>'+((mostrarGuardar)?'<button type="submit" name="contrato" value="'+num_contrato+'" class="btn btn-flat btn-success float-right"><i class="fa fa-fw fa-save"></i> Guardar </button><br>':'<br>')):'';
            $('#'+activadoc).html(info.tabla+cerrar);
            $('#'+activadoc).show();
            var urls = info.ruta_archivos;
            console.log(urls);
            var deleteurl = host+'file_delete';
            var extensionesPermitidas = (tipodoc == 'imagenes') ? ["jpg", "jpeg", "jpe", "jfif", "png", "gif", "webp", "bmp"] : ["jpg", "jpeg", "jpe", "jfif", "png", "gif", "webp", "bmp","pdf","doc","docx","ppt","pptx","xls","xlsx"];
            if(urls.length > 0){
                var urlcaption = [];
                var contador = 1;
                var urlsArray = urls.split(',');
                urlsArray.forEach(url_respuesta=>{
                    if(url_respuesta.length > 0){
                        var respuesta = url_respuesta.split('.');
                        var ultimo_punto = respuesta.length;
                        var extension = respuesta[ultimo_punto-1];
                        var idurl = btoa(url_respuesta);
                        idurl = idurl.replaceAll('+','-');
                        idurl = idurl.replaceAll('/','_');
                        idurl = idurl.replaceAll('=','__-w-__');
                        
                        if((extension == 'jpg')||(extension == 'png')||(extension == 'gif')||(extension == 'jpeg')){
                            objeto = {
                                "caption": "Archivo N° "+contador,
                                "description": 'Archivo N° '+contador,
                                "url": deleteurl+'/'+idurl,
                                "downloadUrl": url_respuesta,
                                "key": contador,
                                
                            }
                        }else{
                            objeto = {
                                "type": extension,
                                "caption": "Archivo N° "+contador,
                                "description": 'Archivo N° '+contador,
                                "size": "847000",
                                "url": deleteurl+'/'+idurl,
                                "downloadUrl": url_respuesta,
                                "key": contador,
                                
                            }
                        }
                        urlcaption.push(objeto);
                        contador = contador+1;
                    }
                });
                
                $("#input-24").fileinput({
                    language: "es",
                    initialPreview: urlsArray,
                    initialPreviewAsData: true,
                    initialPreviewConfig: urlcaption,
                    initialPreviewShowDelete: false,
                    overwriteInitial: false,
                    maxFileSize: 8600,
                    showRemove: true,
                    allowedFileExtensions: extensionesPermitidas,
                    browseLabel: "Cargar ...",
                }).on('filebeforedelete', function(event, key, data) {
                    var aborted = !window.confirm('¿Esta seguro que desea borrar este archivo?');
                    if (aborted) {
                        console.log(data);
                        console.log(event);
                        console.log(key);
                        var index =  key-1;
                        $('#thumb-input-24-init-'+index).show();
                       
                        setTimeout(function(){
                            $('.file-error-message').hide();
                        }, 2000);
                        
                    }else{
                        console.log(data);
                        console.log(event);
                        console.log(key);
                        var index =  key-1;
                        $('#thumb-input-24-init-'+index).hide();
                        setTimeout(function(){
                            $('.file-error-message').hide();
                        }, 2000);
                        
                    };
                    return aborted;
                });
                }else{
                    $("#input-24").fileinput({
                        language: "es",
                        allowedFileExtensions: extensionesPermitidas,
                          initialPreviewAsData: true,
                          deleteUrl: deleteurl,
                          initialPreviewShowDelete: false,
                          overwriteInitial: false,
                          showRemove: true,
                          browseLabel: "Cargar ...",
                      });
                }
            /*$("#input-24").fileinput({
                language: "es",
                allowedFileExtensions: ["jpg", "png", "jpeg"],
                browseLabel: "Cargar ...",
                maxFileSize: 4800,
            });*/
        }else{
            toastr.error('No se encontro documentos con la dependencia seleccionada.');
        }
    }
    });

}

function textoSeguro(valor){
    return $('<div>').text(valor).html();
}

function renderizarDescripcionesImagenes(input){
    var archivos = input.files || [];
    var contenedor = $('#descripciones-imagenes');
    contenedor.html('');

    if(archivos.length === 0){
        return;
    }

    contenedor.append('<br><label>Descripcion de cada imagen</label>');
    Array.from(archivos).forEach(function(archivo, index){
        contenedor.append(
            '<div class="form-group">' +
                '<label>Imagen '+(index + 1)+': '+textoSeguro(archivo.name)+'</label>' +
                '<input type="text" class="form-control" name="descripcion_imagen[]" placeholder="Descripcion de la imagen">' +
            '</div>'
        );
    });
}

$(document).on('change', '#input-24', function(){
    renderizarDescripcionesImagenes(this);
});

function buscarpropietario(){
          
    var tipo_busqueda = $('#tipo_busqueda').val();
    var complemento = $('#complemento').val();

    if((tipo_busqueda.length > 0 ) && (complemento.length > 0)){
        $('#agregardoc').html();
        var host = window.location.protocol + "//" + window.location.host + "/";
        $.ajax({
            url: host+'buscarpropietario',
            type: "POST",
            cache: false,
            data:{tipo_busqueda: tipo_busqueda,complemento:complemento},
            success: function(data){
                var info = jQuery.parseJSON(data);
                if(info.carga){
                    $('#arrendatario').val(info.info['documento']+'-'+info.info['nombres']);
                    $('#cliente').val(info.info['documento']);
                }else{
                    toastr.error('No se encontro documentos con la dependencia seleccionada.');
                }
            }
            });
    }else{
        toastr.error('Debe completar los campos para poder realizar una busqueda.');
    }

    $('#cerrarmodal').click();
    
    }


$('.clientes-multiple').select2({
    dropdownParent: $('#modal-addpersona')
  });

  
  function abrirbuscador(num_contrato){
    //$('#modal-editar'+num_contrato).hide();
    $('#cerrar'+num_contrato).click();
    $('#modalactivo').val(num_contrato);

    var myModal2 = new bootstrap.Modal(document.getElementById('modal-buscarpersona'))
    myModal2.show();

    
    //$('#modal-buscarpersona').show();
  }

  function buscarpersona2(){
    var num_contrato = $('#modalactivo').val();
    var tipo_busqueda = $('#tipo_busqueda').val();
    var complemento = $('#complemento').val();

    if((tipo_busqueda.length > 0 ) && (complemento.length > 0)){
        $('#agregardoc').html();
        var host = window.location.protocol + "//" + window.location.host + "/";
        $.ajax({
            url: host+'buscarpropietario',
            type: "POST",
            cache: false,
            data:{tipo_busqueda: tipo_busqueda,complemento:complemento},
            success: function(data){
                var info = jQuery.parseJSON(data);
                if(info.carga){
                    $('#arrendatario'+num_contrato).val(info.info['documento']+'-'+info.info['nombres']);
                    $('#cliente'+num_contrato).val(info.info['documento']);
                }else{
                    toastr.error('No se encontro documentos con la dependencia seleccionada.');
                }
            }
            });
    }else{
        toastr.error('Debe completar los campos para poder realizar una busqueda.');
    }

    $('#cerrarmodal').click();
    var myModal2 = new bootstrap.Modal(document.getElementById('modal-editar'+num_contrato))
    myModal2.show();
  }

  
 
  $('.inmuebles').select2();
  $('.inquilinos-multiple').select2();
  //buscar_documentos($('#tipoexpediente').val());

  function add_expedientew(){
    $('#new_expediente').show();
    buscar_documentos($('#tipoexpediente').val(),'','','add_agregardoc');
  }


  function editar_avaluo(codigo, nombres,direccion,tipo_inmueble,ano,id_avaluo,estado,tipo){
    $('#new_expediente').show();
    if(tipo == 'nuevo'){
        $('#titleinmueble').html('<strong>Nuevo avaluo</strong>');
        $('#codigo').val('');
        $('#nombres').val('');
        $('#direccion').val('');
        $('#ano').val('');
        $('#tipo_inmueble').val('');
        $('#estado').val(1);
        $('#id_avaluo').val('');
    }else{
        $('#titleinmueble').html('<strong>Editar avaluo</strong>');
        $('#codigo').val(codigo);
        $('#nombres').val(nombres);
        $('#direccion').val(direccion);
        $('#ano').val(ano);
        $('#id_avaluo').val(id_avaluo);
        $('#tipo_inmueble').val(tipo_inmueble);
        $('#estado').val(estado);
    }
  }

  function editar_compraventa(codigo, vendedor, comprador,direccion,id_compraventa){
        $('#new_expediente').show();
        $('#titleinmueble').html('<strong>Editar Compraventa</strong>');
        $('#consecutivo').val(codigo);
        $('#nombres').val(comprador);
        $('#direccion').val(direccion);
        $('#vendedor').val(vendedor);
        $('#id_compraventa').val(id_compraventa);
        
  }

