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
              <th style="text-align:center;">CODIGO</th>
              <th style="text-align:center;">TIPO DE PQRSD</th>
              <th style="text-align:center;">TIPO DE DOCUMENTO</th>
              <th style="text-align:center;">DOCUMENTO</th>
              <th style="text-align:center;">REMITENTE</th>
              <th style="text-align:center;">ACCIONES</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($data['informacion'] as $info):?>
        
          <tr>
            <td style="text-align:center;"><?php echo $info['id'];?></td>
            <td style="text-align:center;"><?php echo $info['anonima'];?></td>
            <td style="text-align:center;"><?php echo $info['codigo'];?></td>
            <td style="text-align:center;"><?php echo $info['tipo_pqrs'];?></td>
            <td style="text-align:center;"><?php echo $info['tipo_documento'];?></td>
            <td style="text-align:center;"><?php echo $info['documento'];?></td>
            <td style="text-align:center;"><?php echo $info['nombres'].$info['apellidos'];?></td>
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
                          <label for="descripcion"><strong>Descripción</strong></label>
                          <input type="text" name="descripcion" id="descripcion" value="<?php echo $info['descripcion'];?>" style="width:100%" disabled>
                        </p>
                        <p  style="text-align:left" >
                          <label for="estado"><strong>Estado</strong></label>
                          <input type="text" name="estado" id="estado" value="<?php echo $info['estado'];?>" style="width:100%" disabled>
                        </p>
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
                      <?php echo form_open(base_url('asignar_dependencia'), ['class' => 'form-vertical', 'id' => 'form_asignar_dependencia'.$info['id'], 'role' => 'form'], ['id_sol_req' => $info['id']]); ?>  
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
                        <a class="btn btn-flat btn-warning pull-left " href="<?php echo base_url('radicados');?>"><i class="fa fa-fw fa-arrow-left"></i>Cancelar</a>
                        <button type="submit" class="btn btn-flat btn-success pull-right "><i class="fa fa-fw fa-download"></i>Asignar</button>
                      </div>
                      <?php echo form_close();?>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <a type= "button" class="btn btn-accion-tabla tooltipsC" title="Asignar Responsable" href="#modal-responsable<?php echo $info['id'];?>" data-toggle="modal"><i class="fa-sharp fa-regular fa-user-plus" style="color:   #0e6655  ;"></i></a>
              <div class="modal fade" id="modal-dependencia<?php echo $info['id'];?>">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-success">
                      <div class="modal-header">
                        <h6 class="modal-title text-white">Asignar Responsable</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <?php echo form_open(base_url('asignar_responsable'), ['class' => 'form-vertical', 'id' => 'form_asignar_dependencia'.$info['id'], 'role' => 'form'], ['id_sol_req' => $info['id']]); ?>  
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
                        <a class="btn btn-flat btn-warning pull-left " href="<?php echo base_url('radicados_dependencia');?>"><i class="fa fa-fw fa-arrow-left"></i>Cancelar</a>
                        <button type="submit" class="btn btn-flat btn-success pull-right "><i class="fa fa-fw fa-download"></i>Asignar</button>
                      </div>
                      <?php echo form_close();?>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
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
              <a type= "button" class="btn btn-accion-tabla tooltipsC" title="Documento de Soporte" href="<?php echo site_url('versoporte/'.$name);?>"> <i class="fa-regular fa-file-pdf" style="color:   #922b21 ;"></i></a>
              <?php endif;?>
            </td>
          </tr>
        
        <?php endforeach;?>
        </tbody>
        <tfoot>
          <tr>
              <th style="text-align:center;">ID</th>
              <th style="text-align:center;">ANONIMA</th>
              <th style="text-align:center;">CODIGO</th>
              <th style="text-align:center;">TIPO DE PQRSD</th>
              <th style="text-align:center;">TIPO DE DOCUMENTO</th>
              <th style="text-align:center;">DOCUMENTO</th>
              <th style="text-align:center;">REMITENTE</th>
              <th style="text-align:center;">ACCIONES</th>
          </tr>
        </tfoot>

      </table>
      <?php endif; ?>
    </div>
    <!-- /.card-body -->
  </div>
</div> 

