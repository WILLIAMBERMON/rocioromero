
<div class="container-fluid">
    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title">Finalizar Radicado</h3>
        </div><!-- /.card-header -->
                
            <?php echo form_open(base_url('finalizar_radicado'), ['class' => 'form-horizontal', 'id' => 'form_finalizar_radicado', 'role' => 'form'],[]);?>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" id="id_radicado" name="id_radicado" value="<?php echo $data['radicado']; ?>">
                            <?php if((isset($data['informacion']) && $data['informacion'])&&(isset($data['fecha_max']) && $data['fecha_max'])): ?>
                                        <div class="col-md-6">
                                            <label for="FECHA_MAXIMA">Fecha Máxima</label>
                                            <?php foreach($data['fecha_max'] as $fecha):?>                                            
                                                <input disabled class ="form-control" type="text" name="FECHA_MAXIMA" id="FECHA_MAXIMA" value="<?php echo $fecha['FECHA_MAXIMA'];?>"> 
                                            <?php endforeach;?>                                        

                                        </div>
                                        <?php
                                        $textocon = '';$textosin = '';
                                         foreach($data['informacion'] as $info){
                                            $textocon = ($textocon)?($textocon.'<br><br>'.$info['NOMBRES'].'. '.$info['RESPUESTA']):($info['NOMBRES'].'. '.$info['RESPUESTA']);
                                            $textosin = ($textosin)?($textosin.'<br><br>'.$info['RESPUESTA']):($info['RESPUESTA']);
                                            $radicado = $info['ID_RADICADO'];
                                         }
                                        ?>
                                        <input type="hidden" id="textocon" value="<?php echo $textocon ?>">
                                        <input type="hidden" id="textosin" value="<?php echo $textosin ?>">
                                        <div class="col-md-6">
                                            <label for="responsables"> Mostrar Responsables </label>
                                            <select class="form-control" name="responsables" id="responsables">
                                                <option selected value="Si">SI</option>
                                                <option value="No">NO</option>
                                            </select>
                                            <br>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="RESPUESTA">Respuesta</label>                                            
                                                <textarea class="summernotejd" id="RESPUESTA" name="RESPUESTA">
                                                
                                                </textarea>
                                        </div>

                                        <?php if(isset($data['soporte']) && $data['soporte']): foreach($data['soporte'] as $sop):?>
                                            <input type="hidden" name="soportes" id="soportes" value="<?php echo $sop['url_respuesta']?>">
                                        <?php endforeach; endif;?>

                                        <div class="col-md-12">
                                            
                                            <label for="url_respuesta">Soporte de Respuesta</label>
                                            <br>
                                            <input id="url_respuesta" name="url_respuesta[]" type="file"  multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Seleccionar Archivos...">
                                            
                                        </div>
                                                                                        
                                         <?php
                                         $observacion = ''; 
                                         foreach($data['informacion'] as $inf){
                                            $observacion = $inf['OBSERVACION'];
                                         }
                                        ?>
                                        <input type="hidden" id="obser" value="<?php echo $observacion ?>">
                                        <div class="col-md-12">
                                            <label for="OBSERVACION">Observación</label>                                            
                                                <textarea class="summernotejd" id="OBSERVACION" name="OBSERVACION">
                                                
                                                </textarea>
                                        </div>

                                        
                                    
                                    
                                
                            <?php endif;?>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-flat btn-default float-left" href="<?php echo base_url('radicados_dependencia');?>" style="margin-right: 20px">Regresar</a>
                    <button type="submit" class="btn btn-flat btn-dark float-left" name="actualizar" value="1">Actualizar</button>
                    <button type="submit" class="btn btn-flat btn-danger float-right" name="Finalizar" value="1"> Finalizar</button>
                </div>
            <?php echo form_close();?>
    </div>
      
</div>
  <!-- /.content-wrapper -->
<script src="<?php echo base_url('/template_admin/vendor/jquery/jquery.min.js'); ?>" ></script>
<script>
    
$("#url_respuesta").fileinput({
    language: "es",
    allowedFileExtensions: ["jpg", "png", "gif","pdf","doc","docx","ppt","pptx","xls","xlsx"],
    browseLabel: "Pick Image"
});

$('#url_respuesta').on('fileclear', function(event) {
        console.log("fileclear");
    });


</script>