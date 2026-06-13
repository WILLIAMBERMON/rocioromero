<?php $crear =true; if(isset($usuarios) && $usuarios): $crear =false;?>

<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong>Listado de Usuarios</strong></h1>
      
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <table id="example1s" class="datatablew table table-bordered table-striped">
              <thead>
                <tr>
                    <th style="text-align:center; width: 10%">DOCUMENTO</th>
                    <th style="text-align:center; width: 40%">NOMBRES Y APELLIDOS</th>
                    <th style="text-align:center; width: 10%">EMAIL</th>
                    <th style="text-align:center; width: 10%">CELULAR</th>
                    <th style="text-align:center; width: 10%">OPCION</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($usuarios as $index => $user):?>
                <tr>
                  <td style="text-align:center;" ><?php echo $user['tipo_documento'].' '.$user['documento'];?></td>
                  <td style="text-align:center;" ><?php echo $user['nombres'].' '.$user['apellidos'];?></td>
                  <td style="text-align:center;" ><?php echo $user['email'];?></td>
                  <td style="text-align:center;" ><?php echo $user['celular'];?></td>
                  <td><button type="button" title="Editar usuario" onclick="editarusuario('<?php echo $user['documento'];?>','<?php echo $user['tipo_documento']; ?>','<?php echo $user['nombres'];?>','<?php echo $user['apellidos'];?>','<?php echo $user['email'];?>','<?php echo $user['celular'];?>')"  class="btn btn-flat btn-primary"><i class="fa-sharp fa-regular fa-pencil"></i></button>
                  <button type="button" title="Permisos del usuario" onclick="permisosusuario('<?php echo $user['documento'];?>')"  class="btn btn-flat btn-primary"><i class="fa-sharp fa-regular fa-id-card"></i></button>
                </td>

                </tr>
              <?php endforeach;?>
                      </tbody>
                <tfoot>
                  <tr>
                    <th style="text-align:center; width: 10%">DOCUMENTO</th>
                    <th style="text-align:center; width: 40%">NOMBRES Y APELLIDOS</th>
                    <th style="text-align:center; width: 10%">EMAIL</th>
                    <th style="text-align:center; width: 10%">CELULAR</th>
                    <th style="text-align:center; width: 10%">OPCION</th>
                  </tr>
                </tfoot>
              </table> 
              
    </div>
    
    <div class="card-footer">
          <button type="button" onclick="newusuario()" class="btn btn-flat btn-success float-right" name="crear" value="1"> Crear Usuario</button>
      </div>
    <!-- /.card-body -->
  </div>
</div> 
<?php endif;  ?>
<div id="adduser" style="display:<?php echo (($crear)?'block':'none') ?>" class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong>Crear un usuario</strong></h1>
      
    </div>
    <!-- /.card-header -->
    
    <?php echo form_open(base_url('createuser'), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],[]);?>
    <div class="card-body">
                <input type="hidden" name="agregarusuario" value="1" id="agregarusuario">
            <p  style="text-align:justify" >
              Para agregar un nuevo usuario complete el siguiente formulario:
            </p>
            <label for="descripcion"><strong>Tipo de documento</strong></label>
              <select name="tipo_documento" id="tipo_documento" required class="form-control input_field select_opt">
                  <option>Seleccione...</option>    
                  <option value="TI">Tarjeta de identidad</option>
                  <option value="CC">Cedula de ciudadania</option>
                  <option value="CE">Cedula de extranjeria</option>
                  <option value="PS">Pasaporte</option>
              </select>
              <label for="descripcion"><strong>Número de documento de identidad</strong></label>
              <input type="text" class="form-control" name="documento" id="documento" style="width:100%" >
              <label for="descripcion"><strong>Nombres</strong></label>
              <input type="text" class="form-control" name="nombres" id="nombres" style="width:100%" >
              <label for="descripcion"><strong>Apellidos</strong></label>
              <input type="text" class="form-control" name="apellidos" id="apellidos" style="width:100%" >
              
              <label for="descripcion"><strong>Email</strong></label>
              <input type="email" class="form-control" name="email" id="email" style="width:100%" >
              <label for="descripcion"><strong>Celular</strong></label>
              <input type="text" class="form-control" name="celular" id="celular" style="width:100%" >
              <div id="rclave" style="display:none">
              <label for="descripcion"><strong>Reestablecer clave</strong></label>
              <select name="cambioclave" id="cambioclave" required class="form-control input_field select_opt">
                  <option value="SI">SI</option>
                  <option selected value="NO">NO</option>
              </select></div>
    </div>
    
    <div class="card-footer">
      <?php if(isset($data['get_propietarios']) && $data['get_propietarios']):?>
          <button type="button" onclick="$('#adduser').hide()" class="btn btn-flat btn-success float-left"> Cancelar</button>
          <?php endif; ?>
          <button type="submit" id="crearbb" class="btn btn-flat btn-success float-right" name="crear" value="1"> Crear Usuario</button>
      </div>
      <?php echo form_close();?>
      </div>
</div> 
