
$(document).ready(function() {
    $('#RESPUESTA').val($('#textocon').val());
    $('#OBSERVACION').val($('#obser').val());
      
    var con = $('#textocon').val();
    var sin = $('#textosin').val();

	$('#responsables').change(function() {
        if($(this).val() == 'Si'){
            $('#RESPUESTA').summernote('code',con);
        }else{
            $('#RESPUESTA').summernote('code',sin);;
        }


		
	});
});

// Supongamos que tienes las URLs separadas por comas en la variable $urls
const urls = $('#soportes').val(); // Obtén la cadena de URLs desde PHP
const id_radicado = $('#id_radicado').val();
// Divide la cadena por comas para obtener un array de URLs
var urlsArray = urls.split(',');
var urlcaption = [];
var contador = 1;
urlsArray.forEach(url_respuesta=>{
    var respuesta = url_respuesta.split('.');
    var extencion = respuesta[1];
    var urldiv = url_respuesta.split('/');
    //var cantidad = urldiv.length();
    //var cantidad = cantidad - 1;
    var nombre = urldiv[urldiv.length-1];
      
let objeto = {
    "type": extencion,
    "caption": "Archivo N° "+contador,
    "description": 'Archivo N° '+contador,
    "size": "847000",
    "url": "eliminar_archivo/"+nombre+"/"+id_radicado,
    "downloadUrl": url_respuesta,
    "key": contador,
    
   }
   urlcaption.push(objeto);
   contador = contador+1
})

console.log(urlsArray);
$("#url_respuesta").fileinput({
    initialPreview: urlsArray,
    initialPreviewAsData: true,
    initialPreviewConfig: urlcaption,
    
    overwriteInitial: false,
    maxFileSize: 100,
    
});

        




