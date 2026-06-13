
<div class="container-fluid">
    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title">Responder Radicado</h3>
        </div><!-- /.card-header -->
                
            <?php echo form_open_multipart(base_url('responder_radicado'), ['class' => 'form-horizontal', 'id' => 'form_finalizar_radicado', 'role' => 'form'],['id_radicado' => $data['radicado']]);?>
                <div class="card-body">
                <div class="row">
                            <?php if((isset($data['informacion']) && $data['informacion'])&&(isset($data['fecha_max']) && $data['fecha_max'])): ?>
                                        <div class="col-md-6">
                                            <label for="FECHA_MAXIMA">Fecha Máxima</label>
                                            <?php foreach($data['fecha_max'] as $fecha):?>                                            
                                                <input disabled class ="form-control" type="text" name="FECHA_MAXIMA" id="FECHA_MAXIMA" value="<?php echo $fecha['FECHA_MAXIMA'];?>"> 
                                            <?php endforeach;?>                                        
                                            <br>
                                        </div>
                                        <?php foreach($data['info_radicado'] as $rad ):?> 
                                            
                                            <div class="col-md-12">
                                                <label for="OBSERVACION">Observación</label> 
                                                <br>                                           
                                                <textarea  disabled class="form-control" id="OBSERVACION" name="OBSERVACION" style="align-content:left">
                                                    <?php echo $rad['OBSERVACION'];?>
                                                </textarea>
                                                <br>
                                            </div>

                                            <div class="col-md-12" style="text-align:left">
                                                <label for="RESPUESTA">Respuesta</label>                                            
                                                <textarea class="summernotejd" id="RESPUESTA" name="RESPUESTA" >
                                                    
                                                </textarea>
                                            </div>
                                            
                                        <?php endforeach;?>

                                        <div class="col-md-12">
                                            
                                            <label for="url_respuesta">Soporte de Respuesta</label>
                                            <br>
                                            <input id="url_respuesta" name="url_respuesta[]" type="file"  multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Seleccionar Archivos...">
                                            
                                        </div>
                                    
                                
                            <?php endif;?>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-flat btn-default float-left" href="<?php echo base_url('radicados_encargado');?>" style="margin-right: 20px">Regresar</a>
                    <button type="submit" class="btn btn-flat btn-success float-right" name="responder"> Responder</button>
                </div>
            <?php echo form_close();?>
    </div>
      
</div>
  <!-- /.content-wrapper -->
<script>
    
$("#url_respuesta").fileinput({
    language: "es",
    allowedFileExtensions: ["jpg", "png", "gif","pdf","doc","docx","ppt","pptx","xls","xlsx"],
    browseLabel: "Pick Image"
});
</script>
 
