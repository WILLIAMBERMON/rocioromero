<style>
  .select2-selection{
    height:38px !important
  }
</style>
<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong>Expedientes <?php echo ($tipoexpediente == '8')?'para arriendos':'para ventas' ?></strong></h1>
      
    </div>
    <!-- /.card-header -->
    <?php echo form_open_multipart(base_url($tiporeal), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],['crearexpediente'=>'1']);?>
    <input type="hidden" id="tipoexpediente" name="dependencia" value="<?php echo $tipoexpediente ?>">
    <input type="hidden" name="finicio" value="">
    <input type="hidden" name="ffin" value="">
    
    <div class="card-body">
      <?php if(isset($data['dependencias']) && $data['dependencias']): ?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="descripcion"><strong>Seleccione el inmueble</strong></label>
              <select required class="form-control select2 select2-danger inmuebles" data-dropdown-css-class="select2-danger" id="contrato" style="width: 100%;"name="contrato">
                <option value="">Seleccione...</option>
                <?php foreach($get_inmuebles as $inmueble): ?>
                <option value="<?php echo $inmueble['codinmueble']; ?>"><?php echo $inmueble['codinmueble'].'-'.$inmueble['direccion'].'-'.$inmueble['nompropietario']; ?></option>
                <?php endforeach; ?>  
              </select><br>


            </div>
          </div>
         
          <div class="col-md-6">
            <div class="form-group">
              <label>Estado del expediente</label>
              <select name="estado" id="estado" required class="form-control" required placeholder="Estado del expediente">
              <option value='' selected>Seleccione...</option>
              <option value="abierto">Activo</option>
              <option value="cerrado">Inactivo</option>
            </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php if($tipoexpediente == '8'): ?>
              <label for="descripcion"><strong>Seleccione inquilinos</strong></label>
              <select required class="form-control select2 select2-danger inquilinos-multiple" data-dropdown-css-class="select2-danger" placeholder="Seleccione..." id="inquilinos" style="width: 100%;" multiple="multiple" name="inquilinos[]">
                <?php foreach($get_propietarios as $prop): ?>
                <option value="<?php echo $prop['documento']; ?>"><?php echo $prop['nombres']; ?></option>
                <?php endforeach; ?>  
              </select>
              <?php else: echo '<input hidden name="inquilinos[]" value="N/A">'; endif; ?>
            </div>
          </div>
         
          <div  class="col-md-12" id="agregardoc"></div>
			</div>

        
        <?php else: ?>
          <h5>Para crear un expediente es necesario que las dependencias se encuentren definidas.</h5>
      <?php endif; ?>
    </div>
    
    <div class="card-footer">
          <button type="submit" class="btn btn-flat btn-success float-right" name="crear" value="1"> Crear Expediente</button>
    </div>
    <?php echo form_close();?>
    <!-- /.card-body -->
  </div>
</div> 

<?php echo form_open(base_url($tiporeal), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],['agregarpropietario'=>'1']);?>
  
  <div class="modal fade modal-danger" id="modal-addpersona">
      <div class="modal-dialog">
        <div class="modal-content bg-info">
          <div class="modal-header">
            <h4 class="modal-title text-white">Agregar Propietario</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p  style="text-align:justify" >
              Para agregar un propietario nuevo complete el siguiente formulario:
            </p>
              <label for="descripcion"><strong>Nombres y Apellidos</strong></label>
              <input required type="text" class="form-control" name="nombres" id="nombres" style="width:100%" >
              <label for="descripcion"><strong>Tipo de Documento</strong></label>
              <select required class="form-control" id="tipo_documento" name="tipo_documento">
                <option>Seleccione...</option>
                <option value="CC">Cedula de Ciudadanía</option>
                <option value="CE">Cedula de Extranjería</option>
                <option value="PA">Pasaporte</option>
                <option value="VI">VISA</option>
                <option value="PPT">Permiso de protección temporal</option>
              </select>
              <label for="descripcion"><strong>Número de documento de identidad</strong></label>
              <input required type="text" class="form-control" name="documento" id="documento" style="width:100%" >
              <label for="descripcion"><strong>Email</strong></label>
              <input required type="email" class="form-control" name="email" id="email" style="width:100%" >
              <label for="descripcion"><strong>Dirección</strong></label>
              <input required type="text" class="form-control" name="direccion" id="direccion" style="width:100%" >
              <label for="descripcion"><strong>Celular</strong></label>
              <input required type="text" class="form-control" name="celular" id="celular" style="width:100%" >
              <label for="descripcion"><strong>Tipo de Cliente</strong></label>
              <select required class="form-control select2 select2-danger clientes-multiple" data-dropdown-css-class="select2-danger" id="tipo_cliente" style="width: 100%;" multiple="multiple" name="tipo_cliente[]">
                <option>Seleccione</option>
                <?php foreach($tipos_cliente as $cli): ?>
                <option value="<?php echo $cli['id']; ?>"><?php echo $cli['descripcion']; ?></option>
                <?php endforeach; ?>  
              </select>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button type="submit" name="guardar" class="btn btn-light pull-right "><i class="fa fa-fw fa-save"></i> Guardar</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<?php echo form_close();?>



  
  <div class="modal fade modal-success" id="modal-buscarpersona">
      <div class="modal-dialog">
        <div class="modal-content bg-info">
          <div class="modal-header">
            <h4 class="modal-title text-white">Buscar Propietario</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p  style="text-align:justify" >
              Para buscar un propietario seleccione un tipo y complemente con la información:
            </p>
              <label for="descripcion"><strong>Tipo de Busqueda</strong></label>
              <select class="form-control" id="tipo_busqueda">
                <option>Seleccione...</option>
                <option value="documento">Número de documento</option>
                <option value="nombres">Nombres o Apellidos</option>
                <option value="email">email</option>
                <option value="celular">celular</option>
              </select>
              <label for="complemento"><strong>Complemento del tipo de búsqueda</strong></label>
              <input type="text" class="form-control" id="complemento" style="width:100%" >
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" id="cerrarmodal" type="button" data-dismiss="modal">Cancel</button>
            <button type="button" onclick="buscarpropietario()"class="btn  btn-light pull-right "><i class="fa fa-fw fa-search"></i> Buscar</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
