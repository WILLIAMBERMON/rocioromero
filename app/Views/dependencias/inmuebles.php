<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong>Lista de Ventas</strong></h1>
      
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <p  style="text-align:justify" >
              Listado de Inmuebles:
            </p>
            <?php if(isset($get_inmuebles) && $get_inmuebles): ?>
            <table id="example1s" class="datatablew table table-bordered table-striped">
              <thead>
                <tr>
                    <th style="text-align:center; ">CODIGO</th>
                    <th style="text-align:center; ">DIRECCION</th>
                    <th style="text-align:center; ">BARRIO</th>
                    <th style="text-align:center; ">CIUDAD</th>
                    <th style="text-align:center; ">PROPIETARIO</th>
                    <th style="text-align:center; ">TIPO INMUEBLE</th>
                    <th style="text-align:center; ">TIPO ACTIVIDAD</th>
                    <th style="text-align:center; ">ESTADO</th>
                    <th style="text-align:center;">OPCIONES</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($get_inmuebles as $index => $inmueble):?>
                <tr>
                  <td style="text-align:center;" ><?php echo $inmueble['codigo_pagina'];?></td>
                  <td style="text-align:center;" ><?php echo $inmueble['direccion'];?></td>
                  <td style="text-align:center;" ><?php echo $inmueble['barrio'];?></td>
                  <td style="text-align:center;" ><?php echo $inmueble['ciudad'];?></td>
                  <td style="text-align:center;" ><?php echo $inmueble['nompropietario'];?></td>
                  <td style="text-align:center;" ><?php echo $inmueble['tipo_inmueble'];?></td>
                  <td style="text-align:center;" ><?php echo $inmueble['tipo_actividad'];?></td>
                  <td style="text-align:center;" ><?php echo ($inmueble['estado'])?('ACTIVO'):('INACTIVO');?></td>
                  <td style="text-align:center;" >
                    <button class="btn btn-primary regular-button botones" onclick="add_inmueble('editar','<?php echo $inmueble['codinmueble'];?>','<?php echo $inmueble['direccion'];?>','<?php echo $inmueble['barrio'];?>','<?php echo $inmueble['ciudad'];?>','<?php echo $inmueble['nompropietario'];?>','<?php echo $inmueble['tipo_inmueble'];?>','<?php echo $inmueble['tipo_actividad'];?>','<?php echo $inmueble['codigo_pagina'];?>','<?php echo $inmueble['estado'];?>')" title="Editar Inmueble"> <i class="fa fa-fw fa-edit"></i></button>
                  </td>
                </tr>
              <?php endforeach;?>
                      </tbody>
                <tfoot>
                  <tr>
                  <th style="text-align:center; ">CODIGO</th>
                    <th style="text-align:center; ">DIRECCION</th>
                    <th style="text-align:center; ">BARRIO</th>
                    <th style="text-align:center; ">CIUDAD</th>
                    <th style="text-align:center; ">PROPIETARIO</th>
                    <th style="text-align:center; ">TIPO INMUEBLE</th>
                    <th style="text-align:center; ">TIPO ACTIVIDAD</th>
                    <th style="text-align:center; ">ESTADO</th>
                    <th style="text-align:center;">OPCIONES</th>
                  </tr>
                </tfoot>
              </table> 
              <?php else: echo '<h4>Aún no se han registrado inmuebles.</h4>'?>   
            <?php endif; ?>  
            
            <div  class="col-md-12" id="agregardoc"></div>
    </div>
    <div class="card-footer">
      <button type="button" onclick="add_inmueble('nuevo','','','','','','','','')" title="Crear un Inmueble" class="btn btn-primary regular-button botones float-right" ><i class="fa fa-fw fa-plus"></i> Crear Inmueble</button>
    </div>
    
    <!-- /.card-body -->
  </div>
</div> 

<?php echo form_open(base_url('inmuebles'), ['class' => 'form-horizontal', 'id' => 'form_inmueble', 'role' => 'form'],[]);?>
  
  <div class="modal fade modal-danger" id="modal-addinmueble">
      <div class="modal-dialog">
        <div class="modal-content bg-info">
          <div class="modal-header">
            <h4 id="titleinmueble" class="modal-title text-white">Crear un Inmmueble</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="accion" id="accion" value="1">
            <p  style="text-align:justify" >
              Complete el siguiente formulario:
            </p>
              <label for="descripcion"><strong>Codigo de Inmueble (*)</strong></label>
              <input required type="text" class="form-control" name="codigo_pagina" id="codigo_pagina" style="width:100%" >
              <input required type="hidden" class="form-control" name="codinmueble" id="codinmueble" >
              
              <label for="descripcion"><strong>Dirección (*)</strong></label>
              <input required type="text" class="form-control" name="direccion" id="direccion" style="width:100%" >

              <label for="descripcion"><strong>Barrio (*)</strong></label>
              <input required type="text" class="form-control" name="barrio" id="barrio" style="width:100%" >

              <label for="descripcion"><strong>Ciudad (*)</strong></label>
              <input required type="text" class="form-control" name="ciudad" id="ciudad" style="width:100%" >

              <label for="descripcion"><strong>Nombre del propietario (*)</strong></label>
              <input required type="text" class="form-control" name="nompropietario" id="nompropietario" style="width:100%" >

              <label for="descripcion"><strong>Tipo de inmueble</strong></label>
              <select required class="form-control" name="tipo_inmueble" id="tipo_inmueble">
                <option value="">Seleccione...</option>
                <?php if(isset($tipo_inmuebles) && $tipo_inmuebles): 
                    foreach($tipo_inmuebles as $tinmueble):?>
                    <option value="<?php echo $tinmueble['id'] ?>"><?php echo $tinmueble['nombre']; ?></option>
                <?php endforeach; endif; ?>
              </select>

              <label for="descripcion"><strong>Tipo de actividad</strong></label>
              <select required class="form-control" name="tipo_actividad" id="tipo_actividad">
                <option value="">Seleccione...</option>
                <?php if(isset($tipo_actividad) && $tipo_actividad): 
                    foreach($tipo_actividad as $tactividad):?>
                    <option value="<?php echo $tactividad['id'] ?>"><?php echo $tactividad['nombre']; ?></option>
                <?php endforeach; endif; ?>
              </select>

              <label for="descripcion"><strong>Estado del inmueble</strong></label>
              <select required class="form-control" name="estado" id="estado">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
              
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button type="submit" name="guardar" class="btn btn-success pull-right "><i class="fa fa-fw fa-save"></i> Guardar</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<?php echo form_close();?>