
<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong>Lista de arrendatarios</strong></h1>
      
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <p  style="text-align:justify" >
              Listado de arrendatarios:
            </p>
            <?php if(isset($data['get_arrendatarios']) && $data['get_arrendatarios']): ?>
            <table id="example1s" class="datatablew table table-bordered table-striped">
              <thead>
                <tr>
                    <th style="text-align:center; width: 10%">DOCUMENTO</th>
                    <th style="text-align:center; width: 30%">NOMBRES Y APELLIDOS</th>
                    <th style="text-align:center; width: 10%">EMAIL</th>
                    <th style="text-align:center; width: 25%">DIRECCION</th>
                    <th style="text-align:center; width: 9%">CELULAR</th>
                    <th style="text-align:center; width: 7%">NUM CONTRATO</th>
                    <th style="text-align:center; width: 7%">ESTADO</th>
                    <th style="text-align:center; width: 7%">OPCION</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($data['get_arrendatarios'] as $index => $prop):?>
                <tr>
                  <td style="text-align:center;" ><?php echo $prop['documento'];?></td>
                  <td style="text-align:center;" ><?php echo $prop['nombres'];?></td>
                  <td style="text-align:center;" ><?php echo $prop['email'];?></td>
                  <td style="text-align:center;" ><?php echo $prop['direccion'];?></td>
                  <td style="text-align:center;" ><?php echo $prop['celular'];?></td>
                  <td style="text-align:center;" ><?php echo $prop['num_contrato'];?></td>
                  <td style="text-align:center;" ><?php echo ($prop['estado'])?'Activo':'Inactivo';?></td>
                  <td><button type="button" onclick="editararrendatario('<?php echo $prop['documento'];?>','<?php echo $prop['nombres'];?>','<?php echo $prop['email'];?>','<?php echo $prop['direccion'];?>','<?php echo $prop['celular'];?>','<?php echo $prop['estado'];?>','<?php echo $prop['num_contrato'];?>','<?php echo $prop['id_inquilino'];?>')"  class="btn btn-flat btn-primary"><i class="fa-sharp fa-regular fa-pencil"></i></button></td>
                </tr>
              <?php endforeach;?>
                      </tbody>
                <tfoot>
                  <tr>
                  <th style="text-align:center; width: 10%">DOCUMENTO</th>
                    <th style="text-align:center; width: 30%">NOMBRES Y APELLIDOS</th>
                    <th style="text-align:center; width: 10%">EMAIL</th>
                    <th style="text-align:center; width: 25%">DIRECCION</th>
                    <th style="text-align:center; width: 9%">CELULAR</th>
                    <th style="text-align:center; width: 7%">NUM CONTRATO</th>
                    <th style="text-align:center; width: 7%">ESTADO</th>
                    <th style="text-align:center; width: 7%">OPCION</th>
                  </tr>
                </tfoot>
              </table> 
              
            <?php endif; ?>    
    </div>
    
    <div class="card-footer">
          <button type="button" onclick="newarrendatario()"  class="btn btn-flat btn-success float-right" name="crear" value="1"> Crear arrendatario</button>
      </div>
    <!-- /.card-body -->
  </div>
</div> 

<div style="display: <?php echo (isset($data['get_arrendatarios']) && $data['get_arrendatarios'])?'none':'block' ?>" id="addpro" class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong>Arrendatarios</strong></h1>
      
    </div>
    <!-- /.card-header -->
    <?php echo form_open(base_url('arrendatarios'), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],[]);?>
    <div class="card-body">
                <input type="hidden" name="agregararrendatario" value="1" id="agregararrendatario">
            <p  style="text-align:justify" >
              Para agregar un arrendatario nuevo complete el siguiente formulario:
            </p>
            
              <label for="descripcion"><strong>Nombres y Apellidos</strong></label>
              <input required type="text" class="form-control" name="nombres" id="nombres" style="width:100%" >
              <input type="hidden" id="tipo_documento" name="tipo_documento" value="CC">
              <input type="hidden" id="tipo_cliente" name="tipo_cliente" value="N/A">
              <input type="hidden" id="id" name="id" >
              <label for="descripcion"><strong>Número de documento de identidad</strong></label>
              <input required type="text" class="form-control" name="documento" id="documento" style="width:100%" >
              <label for="descripcion"><strong>Email</strong></label>
              <input type="email" class="form-control" name="email" id="email" style="width:100%" >
              <label for="descripcion"><strong>Dirección</strong></label>
              <input required type="text" class="form-control" name="direccion" id="direccion" style="width:100%" >
              <label for="descripcion"><strong>Celular</strong></label>
              <input required type="text" class="form-control" name="celular" id="celular" style="width:100%" >
              <label for="descripcion"><strong>Número de contrato</strong></label>
              <input required type="text" class="form-control" name="num_contrato" id="num_contrato" style="width:100%" >
              <label for="descripcion"><strong>Estado del arrendatario</strong></label>
              <select required class="form-control" name="estado" id="estado">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
              </div> 
    <div class="card-footer">
      <?php if(isset($data['get_arrendatarios']) && $data['get_arrendatarios']):?>
          <button type="button" onclick="$('#addpro').hide()" class="btn btn-flat btn-success float-left"> Cancelar</button>
          <?php endif; ?>
          <button type="submit" id="crearbb" class="btn btn-flat btn-success float-right" name="crear" value="1"> Crear arrendatario</button>
      </div>
      <?php echo form_close();?>
    <!-- /.card-body -->
  </div>
</div> 