<?php $nuevo = true; if(isset($data['dependencias']) && $data['dependencias']): $nuevo = false;?>
<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong>Procesos</strong></h1>
      
    </div>
    <!-- /.card-header -->
    
    <div class="card-body">
      <?php if(isset($data['dependencias']) && $data['dependencias']): ?>
      <table id="example1s" class="datatablew table table-bordered table-striped">
        <thead>
          <tr>
              <th style="text-align:center; width: 10px">ID</th>
              <th style="text-align:center; width: 40px">NOMBRE</th>
              <th style="text-align:center; width: 10px">EDITAR</th>
              <th style="text-align:center; width: 10px">ELIMINAR</th>
              <th style="text-align:center; width: 30px">DOCUMENTOS</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($data['dependencias'] as $index => $info):?>
        
          <tr>
            <td style="text-align:center;"><?php echo $index+1;?></td>
            <td style="text-align:center;"><?php echo $info['nombre'];?></td>
            <td style="text-align:center;">
            <?php echo form_open(base_url('dependencia'), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],['actualizar'=>'1']);?>
              <a type= "button" class="btn btn-flat btn-primary" href="#modal-editar<?php echo $info['id_dependencia'];?>" title="Editar dependencia" data-toggle="modal"><i class="fa-sharp fa-regular fa-pencil" ></i></a>
              <div class="modal fade" id="modal-editar<?php echo $info['id_dependencia'];?>">
                  <div class="modal-dialog">
                    <div class="modal-content bg-info">
                      <div class="modal-header">
                        <h4 class="modal-title text-white">Editar dependencia</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p  style="text-align:left" >
                          <label for="descripcion"><strong>Nombre de Dependencia</strong></label>
                          <input type="text" class="form-control" name="descripcion" id="descripcion" value="<?php echo $info['nombre'];?>" style="width:100%" >
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="guardar" value="<?php echo $info['id_dependencia'];?>" class="btn btn-flat btn-primary pull-right "><i class="fa fa-fw fa-save"></i>  Guardar</button>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <?php echo form_close();?>
        </td>
        <td style="text-align:center;">
            <?php echo form_open(base_url('dependencia'), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],['eliminar'=>'1']);?>
              <a type= "button" class="btn btn-flat btn-danger" href="#modal-eliminar<?php echo $info['id_dependencia'];?>" title="Eliminar dependencia" data-toggle="modal"><i class="fa-sharp fa-regular fa-times"></i></a>
              <div class="modal fade modal-danger" id="modal-eliminar<?php echo $info['id_dependencia'];?>">
                  <div class="modal-dialog">
                    <div class="modal-content bg-info">
                      <div class="modal-header">
                        <h4 class="modal-title text-white">Eliminar dependencia</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p  style="text-align:left" >
                          ¿Esta seguro de que desea eliminar la dependencia <?php echo $info['nombre'];?>?
                        </p>
                        <input type="hidden" name="des" value="<?php echo $info['nombre'];?>">
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="elimina" value="<?php echo $info['id_dependencia'];?>" class="btn btn-flat btn-primary pull-right "><i class="fa fa-fw fa-times"></i> Eliminar</button>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <?php echo form_close();?>
            </td>
            <td style="text-align:center;">
            <?php echo form_open(base_url('procesos'), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],['add_document'=>'1']);?>
              <a type= "button" class="btn btn-flat btn-success" href="#modal-add_document<?php echo $info['id_dependencia'];?>" title="Agregar documentos al proceso" data-toggle="modal"><i class="fa-sharp fa-regular fa-plus"></i></a>
              <div class="modal fade modal-success" id="modal-add_document<?php echo $info['id_dependencia'];?>">
                  <div class="modal-dialog">
                    <div class="modal-content bg-info">
                      <div class="modal-header">
                        <h4 class="modal-title text-white">Agregar documentos al proceso</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p  style="text-align:left" >
                        Agregar documentos al proceso <?php echo $info['nombre'];?>
                        </p>
                        <HR>
                        <?php if(isset($data['documentos']) && $data['documentos']): 
                          $aux = array();
                          $auxdoc = '';
                          foreach($data['documentos'] as $docu){
                            if($docu['id_dependencia'] == $info['id_dependencia']){
                              array_push($aux,$docu);
                              $auxdoc = ($auxdoc) ? ($auxdoc.','.$docu['id_documento']):($docu['id_documento']);
                            }
                          }
                          if($aux){ ?>
                            <p  style="text-align:left" >
                            <label for="descripcion"><strong>Documentos existentes</strong></label>
                            <table style="width:100%"><thead><tr><th>Nº</th><th>Documento</th><th>Eliminar</th></tr></thead><tbody>
                            <?php foreach($aux as $indext => $docaux){  ?>
                              <tr>
                                <td><?php echo $indext+1; ?></td>
                                <td><input class="form-control js-document-description" type="text" name="doc_cambio<?php echo $docaux['id_documento'] ?>" value="<?php echo $docaux['tipo_documento']; ?>"></td>
                                <td><select class="form-control js-delete-document-select" name="del<?php echo $docaux['id_documento'] ?>" data-document-id="<?php echo $docaux['id_documento'] ?>"><option>Seleccione...</option><option value="SI">SI</option><option value="NO">NO</option></select></td>
                              </tr>
                            <?php } ?>
                            </tbody></table>
                            </p>
                          <?php }?>
                          <input type="hidden" name="cambiar_doc" value="<?php echo $auxdoc; ?>">
                        <HR>
                        <?php endif; ?>
                        <p  style="text-align:left" >
                          <label for="descripcion"><strong>Nombre del documento</strong></label>
                          <input type="text" class="form-control" name="documento" id="documento" style="width:100%" >
                        </p>
                        <input type="hidden" name="des" value="<?php echo $info['nombre'];?>">
                        <input type="hidden" name="agregardoc" value="<?php echo $info['id_dependencia'];?>">
                        <input type="hidden" name="documento_eliminar" class="js-delete-document-id" value="">
                        <input type="hidden" name="documento_eliminar_descripcion" class="js-delete-document-description" value="">
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="agregardoc" value="<?php echo $info['id_dependencia'];?>" class="btn btn-flat btn-primary pull-right "><i class="fa fa-fw fa-save"></i> Guardar</button>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <?php echo form_close();?>
            </td>
          </tr>
        
        <?php endforeach;?>
        </tbody>
        <tfoot>
          <tr>
              <th style="text-align:center;">ID</th>
              <th style="text-align:center;">NOMBRE</th>
              <th style="text-align:center;">EDITAR</th>
              <th style="text-align:center; width: 10px">ELIMINAR</th>
              <th style="text-align:center; width: 30px">DOCUMENTOS</th>
          </tr>
        </tfoot>
      </table>
      <?php endif; ?>
    </div>
    
    <div class="card-footer">
          <button style="display:none" type="button" onclick="$('#add_dependencia').show()" class="btn btn-flat btn-success float-right" name="crear" value="1"> Crear Proceso</button>
      </div>
    <!-- /.card-body -->
  </div>
</div> 
<?php endif; ?>

<?php echo form_open(base_url('procesos'), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],[]);?>
  <div id="add_dependencia" style="display:<?php echo ($nuevo)?'block':'none'; ?>" class="container-fluid">
    <div class="card card-dark">
      <div class="card-header">
        <h1 class="card-title"><strong>Crear Nuevo Proceso</strong></h1>
        
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <p  style="text-align:left" >
          <label for="descripcion"><strong>Nombre del proceso</strong></label>
          <input type="text" class="form-control" name="descripcion" id="descripcion" required style="width:100%">
        </p>
      </div>
      <div class="card-footer" id="botones">
                    <a class="btn btn-flat btn-info float-left" href="<?php echo base_url('procesos');?>" style="margin-right: 20px">Regresar</a>
                    <button type="submit" class="btn btn-flat btn-success float-right" name="crear" value="1"> Crear</button>
      </div>
    </div> 
  </div>
  <?php echo form_close();?>

<div class="modal fade" id="modal-confirmar-eliminar-documento" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-eliminar-documento-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title text-white" id="modal-confirmar-eliminar-documento-title">Eliminar documento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="text-align:left">
          ¿Esta seguro de que desea eliminar el documento <strong id="documento-eliminar-descripcion"></strong>?
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <button class="btn btn-flat btn-danger" type="button" id="confirmar-eliminar-documento"><i class="fa fa-fw fa-times"></i> Eliminar</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var pendingSelect = null;
  var confirmedDelete = false;
  var modal = $('#modal-confirmar-eliminar-documento');

  document.addEventListener('focusin', function (event) {
    if (event.target.classList.contains('js-delete-document-select')) {
      event.target.setAttribute('data-previous-value', event.target.value);
    }
  });

  document.addEventListener('change', function (event) {
    var select = event.target;

    if (!select.classList.contains('js-delete-document-select')) {
      return;
    }

    if (select.value !== 'SI') {
      select.setAttribute('data-previous-value', select.value);
      return;
    }

    pendingSelect = select;
    confirmedDelete = false;

    var row = select.closest('tr');
    var descriptionInput = row ? row.querySelector('.js-document-description') : null;
    var description = descriptionInput && descriptionInput.value ? descriptionInput.value : 'seleccionado';

    document.getElementById('documento-eliminar-descripcion').textContent = description;
    modal.modal('show');
  });

  modal.on('hidden.bs.modal', function () {
    if (pendingSelect && !confirmedDelete) {
      pendingSelect.value = pendingSelect.getAttribute('data-previous-value') || 'Seleccione...';
      pendingSelect = null;
    }
  });

  document.getElementById('confirmar-eliminar-documento').addEventListener('click', function () {
    if (!pendingSelect || !pendingSelect.form) {
      return;
    }

    confirmedDelete = true;

    var form = pendingSelect.form;
    var row = pendingSelect.closest('tr');
    var descriptionInput = row ? row.querySelector('.js-document-description') : null;
    var description = descriptionInput && descriptionInput.value ? descriptionInput.value : 'seleccionado';
    var documentId = pendingSelect.getAttribute('data-document-id') || pendingSelect.name.replace('del', '');
    var deleteIdInput = form.querySelector('.js-delete-document-id');
    var deleteDescriptionInput = form.querySelector('.js-delete-document-description');
    var submitButton = form.querySelector('button[name="agregardoc"]');

    if (deleteIdInput) {
      deleteIdInput.value = documentId;
    }

    if (deleteDescriptionInput) {
      deleteDescriptionInput.value = description;
    }

    pendingSelect.value = 'SI';
    modal.modal('hide');

    if (form.requestSubmit && submitButton) {
      form.requestSubmit(submitButton);
      return;
    }

    if (submitButton) {
      submitButton.click();
      return;
    }

    form.submit();
  });
});
</script>
  
