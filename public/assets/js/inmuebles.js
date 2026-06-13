
  function add_inmueble(tipo,codinmueble,direccion,barrio,ciudad,nompropietario,tipo_inmueble,tipo_actividad,codigo_pagina,estado){
    if(tipo == 'nuevo'){
        $('#titleinmueble').val('Agregar un Inmmueble');
        $('#accion').val(tipo);
        $('#codinmueble').val('-1');
        $('#direccion').val('');
        $('#barrio').val('');
        $('#ciudad').val('');
        $('#nompropietario').val('');
        $('#codigo_pagina').val('');
        $('#tipo_inmueble').val('');
        $('#tipo_actividad').val('');
        $('#estado').val(1);
    }else{
        $('#titleinmueble').val('Editar un Inmmueble');
        $('#accion').val(tipo);
        $('#codinmueble').val(codinmueble);
        $('#direccion').val(direccion);
        $('#barrio').val(barrio);
        $('#ciudad').val(ciudad);
        $('#nompropietario').val(nompropietario);
        $('#codigo_pagina').val(codigo_pagina);
        $('#tipo_inmueble').val(tipo_inmueble);
        $('#tipo_actividad').val(tipo_actividad);
        $('#estado').val(estado);
        
    }

    var modaladdinmueble = new bootstrap.Modal(document.getElementById('modal-addinmueble'))
    modaladdinmueble.show();

    
    //$('#modal-buscarpersona').show();
  }
