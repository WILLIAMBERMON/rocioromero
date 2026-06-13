<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong><?php echo ($titulo_tabla) ? ($titulo_tabla):'Lista de Expedientes'; ?></strong></h1>
      
    </div>
    <!-- /.card-header -->
    <div class="card-body">
            <p  style="text-align:justify" >
            <?php echo ($titulo_tabla) ? ($titulo_tabla):'Lista de Expedientes'; ?>
            </p>
            <?php if(isset($data['expedientes']) && $data['expedientes']): ?>
            <table id="example1s" class="datatablew table table-bordered table-striped">
              <thead>
                <tr>
                    <th style="text-align:center; ">CONSECUTIVO</th>
                    <th style="text-align:center; ">VENDEDOR</th>
                    <th style="text-align:center; ">COMRPADOR</th>
                    <th style="text-align:center; ">DIRECCION</th>
                    <th style="text-align:center; ">DOCUMENTOS</th>
                    <th style="text-align:center;">OPCIONES</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($data['expedientes'] as $index => $prop):?>
                <tr>
                  <td style="text-align:center;" ><?php echo $prop['consecutivo'];?></td>
                  <td style="text-align:center;" ><?php echo $prop['vendedor'];?></td>
                  <td style="text-align:center;" ><?php echo $prop['comprador'];?></td>
                  <td style="text-align:center;" ><?php echo $prop['direccion'];?></td>
                 
                  <td style="text-align:center;" >
                    <button class="btn btn-success regular-button botones" onclick="buscar_documentos(<?php echo "'9','".$prop['id_compraventa']."','','agregardoc',true";?>)" title="Archivos cargados"> <i class="fa fa-fw fa-file-pdf"></i></button>
                  </td>
                  <td style="text-align:center;" >
                  <a type= "button" class="btn btn-flat btn-primary regular-button botones" style="color:white" onclick="editar_compraventa('<?php echo $prop['consecutivo'];?>','<?php echo $prop['vendedor'];?>','<?php echo $prop['comprador'];?>','<?php echo $prop['direccion'];?>','<?php echo $prop['id_compraventa'];?>')" title="Editar Compraventa" data-toggle="modal"><i class="fa-sharp fa-regular fa-pencil" ></i></a>
                  <a type= "button" class="btn btn-flat btn-danger " href="#modal-eliminar<?php echo $prop['id_compraventa'];?>" title="Eliminar compraventa" data-toggle="modal"><i class="fa-sharp fa-regular fa-times"></i></a>  
                  

            
                  <?php echo form_open(base_url($tiporeal), ['class' => 'form-horizontal', 'id' => 'form_expediente', 'role' => 'form'],['eliminar'=>'1']);?>
              
              <div class="modal fade modal-danger" id="modal-eliminar<?php echo $prop['id_compraventa'];?>">
                  <div class="modal-dialog">
                    <div class="modal-content bg-info">
                      <div class="modal-header">
                        <h4 class="modal-title text-white">Eliminar Compraventa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p  style="text-align:left" >
                          ¿Esta seguro de que desea eliminar el Compraventa <?php echo $prop['consecutivo'];?>?
                        </p>
                        <input type="hidden" name="des" value="<?php echo $prop['id_compraventa'];?>">
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary"  type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="elimina" value="<?php echo $prop['id_compraventa'];?>" class="btn btn-flat btn-primary pull-right "><i class="fa fa-fw fa-times"></i> Eliminar</button>
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
                  <th style="text-align:center; ">CONSECUTIVO</th>
                    <th style="text-align:center; ">VENDEDOR</th>
                    <th style="text-align:center; ">COMRPADOR</th>
                    <th style="text-align:center; ">DIRECCION</th>
                    <th style="text-align:center; ">DOCUMENTOS</th>
                    <th style="text-align:center;">OPCIONES</th>
                  </tr>
                </tfoot>
              </table> 
              
            <?php endif; ?>  
            
            <?php echo form_open_multipart(base_url($tiporeal), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],['documentos'=>'1']);?>
            <div  class="col-md-12" id="agregardoc"></div>
            <?php echo form_close();?>
    </div>
    
    <!-- /.card-body -->
  </div>
</div> 

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
            <button type="button" onclick="buscarpersona2()"class="btn  btn-light pull-right "><i class="fa fa-fw fa-search"></i> Buscar</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <input type="hidden" id="modalactivo">


  <?php /*Agregar una nuevo expediente*/ ?>
<div id="new_expediente" style="display:none">
  <style>
  .select2-selection{
    height:38px !important
  }
</style>
<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title" id="titleinmueble"><strong>Nuevo avaluo</strong></h1>
      
    </div>
    <!-- /.card-header -->
    <?php echo form_open_multipart(base_url($tiporeal), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],['editar'=>'1']);?>
    <input type="hidden" name="id_compraventa" id="id_compraventa" value="">
    <input type="hidden" name="crearexpediente" id="crearexpediente" value="1">
    
    <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="descripcion"><strong>Nombres del vendedor (Inmmueble)</strong></label>
              <input type="text" disabled id="vendedor" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="descripcion"><strong>Dirección del inmueble</strong></label>
              <input type="text" disabled id="direccion" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="descripcion"><strong>Escriba el conseuctivo</strong></label>
              <input type="text" name="consecutivo" id="consecutivo" required class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="descripcion"><strong>Escriba los nombres del comprador</strong></label>
              <input type="text" name="nombres" id="nombres" required class="form-control">
            </div>
          </div>
			</div>

    </div>
    
    <div class="card-footer">
          <button type="button" onclick="$('#new_expediente').hide()" class="btn btn-flat btn-danger float-left" > Cerrar</button>
          <button type="submit" class="btn btn-flat btn-success float-right" name="crear" value="1"> Guardar</button>
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
</div>