<<<<<<< HEAD
=======

>>>>>>> 43651dde952c00d5725aac8f8b9b2086eb32d7e4
<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong>Radicados</strong></h1>
      
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
                  if($cantidad == $i+1){
                    $name = $ultimo[$i];
                  }
                }
              ?>
              <a type= "button" class="btn btn-accion-tabla tooltipsC" title="Documento de Soporte" href="<?php echo site_url('versoporte/'.$name);?>"> <i class="fa-regular fa-file-pdf" style="color:   #a93226  ;"></i></a>
              <?php endif;?>
            </td>
            
            <td style="text-align:center;">
            
                <a type= "button" class="btn btn-accion-tabla tooltipsC" href="#modal-informacion<?php echo $info['id'];?>" title="Más información" data-toggle="modal"><i class="fa-sharp fa-regular fa-circle-info" style="color:  #17a2b8;"></i></a>
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
              <a type= "button" class="btn btn-accion-tabla tooltipsC" title="Redireccionar" href="#modal-dependencia<?php echo $info['id'];?>" data-toggle="modal"> <i class="fa-regular fa-right-left-large" style="color:  #343a40;"></i></a>
              <div class="modal fade" id="modal-dependencia<?php echo $info['id'];?>">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-secondary">
                      <div class="modal-header">
                        <h6 class="modal-title text-white">Asignar Dependencia</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <?php echo form_open(base_url('asignar_dependencia'), ['class' => 'form-vertical', 'id' => 'form_asignar_dependencia'.$info['id'], 'role' => 'form'], ['id_radicado' => $info['id']]); ?>  
                      <div class="modal-body">
                        <?php if(isset($data['opciones']) && $data['opciones']): ?>
                        <p  style="text-align:left" >
                            <label><b>Dependencia</b></label>
                            <br>
                            <select required class="form-control" name="dependencia" id="dependencia"><option>Seleccione...</option>
                                <?php foreach($data['opciones'] as $opc ):?>
                                    <option value="<?php echo $opc['CODDEPEN'];?>"><?php echo $opc['NOMDEPEN'];?></option>
                                <?php endforeach;?>
                            </select>
                        </p>
                        <?php endif;?>
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-flat btn-danger pull-right ">Asignar</button>
                      </div>
                      <?php echo form_close();?>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <a type= "button" class="btn btn-accion-tabla tooltipsC" title="Asignar Responsable" href="#modal-responsable<?php echo $info['id'];?>" data-toggle="modal"><i class="fa-sharp fa-regular fa-user-plus" style="color:   #0e6655  ;"></i></a>
              <div class="modal fade modal-responsable" id="modal-responsable<?php echo $info['id'];?>">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-success">
                      <div class="modal-header">
                        <h6 class="modal-title text-white">Asignar Responsable</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <?php echo form_open(base_url('asignar_responsable'), ['class' => 'form-vertical', 'id' => 'form_asignar_responsable'.$info['id'], 'role' => 'form'], ['id_radicado' => $info['id']]); ?>  
                      <div class="modal-body">
                      <style>
                        .toggle.android { border-radius: 0px;}
                        .toggle.android .toggle-handle { border-radius: 0px; }
                      </style>
                        <?php $responsables = array(); if(isset($data['responsables']) && $data['responsables']): ?>
                          <?php foreach($data['responsables'] as $res ):?> 
                            <?php if($info['id'] == $res['ID_RADICADO']): array_push($responsables,$res['ENCARGADO']);?>
                              <div style="text-align:left">
                                <input checked type="checkbox"  id="asignado" name="asignado[<?php echo  $res['ENCARGADO']; ?>]"  data-on="Si" data-off="No" data-toggle="toggle" data-style="android" data-onstyle="primary" data-offstyle="danger" data-size="xs">  
                                <label for="asignado">
                                  <?php echo $res['NOMBRES'];?>
                                </label>
                            </div>
                            <?php endif;?>
                          <?php endforeach;?>
                        <?php endif;?>
                        
                        <?php if(isset($data['colaboradores']) && $data['colaboradores']): ?>
                        <p  style="text-align:left" >
                            <label for="responsable"><b>Colaboradores</b></label>
                            <br>
                            <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="responsable" name="responsable[]" multiple="multiple">
                              <option>Seleccione</option>
                              <?php foreach($data['colaboradores'] as $col ):?>
                                
                                  <?php if(($info['id'] == $res['ID_RADICADO'])): if(!(in_array($col['CEDULA'],$responsables))):?>
                                    <option value="<?php echo $col['CEDULA'];?>"><?php echo $col['NOMBRES'];?></option>
                                  <?php endif; endif;?>
                                
                              <?php endforeach;?>
                            </select>
                        </p>
                        <p style="text-align:left">
                            <label for="fecha_maxima"><b>Fecha Máxima</b></label>
                            <br>
                            <input type="datetime-local" class="form-control" name="fecha_maxima" id="fecha_maxima" required>
                            
                        </p>                        
                        <?php endif;?>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-flat btn-primary pull-right ">Asignar</button>
                      </div>
                      <?php echo form_close();?>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <?php echo form_open(base_url('finalizar'), ['class' => 'form-vertical', 'id' => 'form_finalizar'.$info['id'], 'role' => 'form'], ['id_radicado' => $info['id']]); ?>  
                  <?php if($info['estado']!='FINALIZADO'){?>
                    <!--<a type="button" class="btn btn-accion-tabla tooltipsC" title="Finalizar Radicado" href="<?php echo base_url('finalizar');?>" ><i class="fa-regular fa-ballot-check" style="color:  #922b21 ;"></i></a>-->
                    <button type="submit" class="btn btn-accion-tabla tooltipsC pull-left" title="Finalizar Radicado"><i class="fa-regular fa-ballot-check" style="color:  #922b21 ;"></i></button>
                  <?php }?>
              <?php echo form_close();?> 
                             
              

              
      <!--onclick="location.href='<?php echo base_url('finalizar');?>'-->
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
