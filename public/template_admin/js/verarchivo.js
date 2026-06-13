function versoporte(ruta){
    var host = window.location.protocol + "//" + window.location.host + "/";
    $.ajax({
        url: host+'visualizarsoporte',
        type: "POST",
        cache: false,
        data:{ruta: ruta},
        success: function(data){
            var info = jQuery.parseJSON(data);
            if(info.carga){
                

                $('#modalbody-visualizar_documento').html(info.data); 
                var myModal = new bootstrap.Modal(document.getElementById('modal-visualizar_documento'))
                myModal.show();
                /*$('#modal-visualizar_documento').modal(); 
                $('#modal-visualizar_documento').show();*/
                toastr.success('Archivo cargado con éxito.');
            }else{
                toastr.error('El archivo no fue encontrado en el sistema.');
            }
        }
        });
	
}
