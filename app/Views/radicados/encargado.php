
<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong>Mis Radicados</strong></h1>
      
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <?php if(isset($data['informacion']) && $data['informacion']): ?>
      <table id="example1s" class="datatablew table table-bordered table-striped">
        <thead>
          <tr>
              <th style="text-align:center;">ID</th>
              <th style="text-align:center;">ANONIMA</th>
              <th style="text-align:center;">TIPO DE PQRSD</th>
              <th style="text-align:center;">DESCRIPCION</th>
              <th style="text-align:center;">DOCUMENTO DE SOPORTE</th>
              <th style="text-align:center;">ACCIONES</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($data['informacion'] as $info):?>
        
          <tr>
            <td style="text-align:center;"><?php echo $info['id'];?></td>
            <td style="text-align:center;"><?php echo $info['anonima'];?></td>
            <td style="text-align:center;"><?php echo $info['tipo_pqrs'];?></td>
            <td style="text-align:center;"><?php echo $info['descripcion'];?></td>
            <td style="text-align:center;">
              <?php
              if($info['url_soporte']):
               $ultimo = explode("/",$info['url_soporte']);
                $cantidad = count($ultimo); $name = '';
                for($i = 0; $i < $cantidad; $i++){
                  echo $i.'--'.$ultimo[$i].'<br>';
                  if($cantidad == $i+1){
                    $name = $ultimo[$i];
                  }
                }
              ?>
              <a type= "button" class="btn btn-accion-tabla tooltipsC" title="Documento de Soporte" href="<?php echo site_url('versoporte/'.$name);?>"> <i class="fa-regular fa-file-pdf" style="color:   #a93226  ;"></i></a>
              <?php endif; ?>
            </td>
            
            <td style="text-align:center;">
            <?php echo form_open(base_url('responder'), ['class' => 'form-vertical', 'id' => 'form_finalizar'.$info['id'], 'role' => 'form'], ['id_radicado' => $info['id']]); ?>
                <a type= "button" class="btn btn-accion-tabla tooltipsC" href="#modal-informacion<?php echo $info['id'];?>" title="Más información" data-toggle="modal"><i class="fa-sharp fa-regular fa-circle-info" style="color:  #17a2b8;"></i></a> 
                <?php if($info['estado'] != 'FINALIZADO'):?>
                  <button type="submit" class="btn btn-accion-tabla tooltipsC" title="Responder Radicado"><i class="fa-regular fa-file-pen" style="color:   #28a745 ;"></i></button>
                <?php endif;?>
              <?php echo form_close();?> 
              <div class="modal fade" id="modal-informacion<?php echo $info['id'];?>">
                  <div class="modal-dialog">
                    <div class="modal-content bg-info">
                      <div class="modal-header">
                        <h4 class="modal-title text-white">Más información</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p  style="text-align:left" >
                          <label for="remitente"><strong>Remitente</strong></label>
                          <input type="text" name="remitente" id="remitente" value="<?php echo $info['nombres'].$info['apellidos'];?>" style="width:100%" disabled>
                        </p>
                        <p  style="text-align:left" >
                          <label for="tipo_documento"><strong>Tipo de Documento</strong></label>
                          <input type="text" name="tipo_documento" id="tipo_documento" value="<?php echo $info['tipo_documento'];?>" style="width:100%" disabled>
                        </p>
                        <p  style="text-align:left" >
                          <label for="documento"><strong>Documento</strong></label>
                          <input type="text" name="documento" id="documento" value="<?php echo $info['documento'];?>" style="width:100%" disabled>
                        </p>
                        <?php if(!empty($info['codigo'])){?>
                          <p  style="text-align:left" >
                            <label for="codigo"><strong>Código</strong></label>
                            <input type="text" name="codigo" id="codigo" value="<?php echo $info['codigo'];?>" style="width:100%" disabled>
                          </p>
                        <?php }?>  
                        <p  style="text-align:left" >
                          <label for="fecha_solicitud"><strong>Fecha de la Solicitud</strong></label>
                          <input type="text" name="fecha_solicitud" id="fecha_solicitud" value="<?php echo $info['fecha_solicitud'];?>" style="width:100%" disabled>
                        </p>
                      </div>
                      
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              
              <div class="modal fade" id="modal-respuesta<?php echo $info['id'];?>">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-success">
                      <div class="modal-header">
                        <h6 class="modal-title text-white">Información adicional y Respuesta</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <?php echo form_open_multipart(base_url('responder_radicado'), ['class' => 'form-vertical', 'id' => 'form_responder_radicado'.$info['id'], 'role' => 'form'], ['id_radicado' => $info['id']]); ?>  
                      <div class="modal-body">
                        <?php if(isset($data['responsables']) && $data['responsables']): ?>
                        <p  style="text-align:left" >
                            
                            <br>
                            
                                <?php foreach($data['responsables'] as $resp ):?>
                                    <?php if($info['id']==$resp['ID_RADICADO']){?>
                                      <label><b>Fecha Máxima</b></label>
                                      <input type="text" name="fecha_maxima" id="fecha_maxima" value="<?php echo $resp['FECHA_MAXIMA']?>" style="width:100%" disabled>
                                    <?php }?>
                                <?php endforeach;?>
                            
                        </p>

                        <p style="text-align:left">
                            <label for="RESPUESTA">Respuesta</label>
                            <textarea name="RESPUESTA"  rows="5" cols="54"><?php echo $resp['RESPUESTA']?></textarea>
                        </p>

                        <p style="text-align:left">
                            <label for="url_respuesta">Soporte de respuesta</label>
                            <input type="file" id="url_respuesta" name="url_respuesta">
                        </p>

                        <p style="text-align:left">
                            <label for="OBSERVACION">Observación</label>
                            <textarea name="OBSERVACION"  rows="5" cols="54" disabled><?php echo $resp['OBSERVACION']?></textarea>
                        </p>

                        

                        <?php endif;?>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-flat btn-primary pull-right "><i class="fa fa-fw fa-download"></i>  Guardar</button>
                      </div>
                      <?php echo form_close();?>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              
            </td>
          </tr>
        
        <?php endforeach;?>
        </tbody>
        <tfoot>
          <tr>
              <th style="text-align:center;">ID</th>
              <th style="text-align:center;">ANONIMA</th>
              <th style="text-align:center;">TIPO DE PQRSD</th>
              <th style="text-align:center;">DESCRIPCION</th>
              <th style="text-align:center;">DOCUMENTO DE SOPORTE</th>
              <th style="text-align:center;">ACCIONES</th>
          </tr>
        </tfoot>

      </table>
      <?php endif; ?>
    </div>
    <!-- /.card-body -->
  </div>
</div>

