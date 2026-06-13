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
                    <th style="text-align:center; ">NUMERO</th>
                    <th style="text-align:center; ">DATOS</th>
                    <th style="text-align:center; ">ESTADO</th>
                    <th style="text-align:center; ">CLIENTE</th>
                    <th style="text-align:center;">OPCIONES</th>
                    <th style="text-align:center; ">DOCUMENTOS</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($data['expedientes'] as $index => $prop):?>
                <tr>
                  <td style="text-align:center;" ><?php echo $prop['num_contrato'];?></td>
                  <td style="text-align:center;" ><?php 
                   foreach($dependencias  as $dep){
                    if($dep['id_dependencia'] == $prop['dependencia']){
                      echo $dep['nombre'];
                    }
                   }
                   ?></td>
                  <td style="text-align:center;" ><?php echo ($prop['estado']=='abierto')?'Activo':'Inactivo';?></td>
                  <td style="text-align:center;" ><?php echo $prop['cliente'];?></td>
                  <td style="text-align:center;" >
                  
                  <a type= "button" class="btn btn-flat btn-primary regular-button botones" href="#modal-editar<?php echo $prop['num_contrato'];?>" title="Editar Expediente" data-toggle="modal"><i class="fa-sharp fa-regular fa-pencil" ></i></a>
                  <a type= "button" class="btn btn-flat btn-danger " href="#modal-eliminar<?php echo $prop['num_contrato'];?>" title="Eliminar Expediente" data-toggle="modal"><i class="fa-sharp fa-regular fa-times"></i></a>  
                  <?php echo form_open(base_url($tipo_expediente), ['class' => 'form-horizontal', 'id' => 'form_dependencia', 'role' => 'form'],['actualizar'=>'1','contrato'=>$prop['num_contrato']]);?>
                    
                    <div class="modal fade" id="modal-editar<?php echo $prop['num_contrato'];?>">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content bg-info">
                            <div class="modal-header">
                              <h4 class="modal-title text-white">Editar Expediente</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Número de contrato o de Inmueble</label>
                                  <input type="number" disabled class="form-control" value="<?php echo $prop['num_contrato'] ?>" placeholder="Número de contrato o de Inmueble">
                                </div>
                              </div>
                            
                              
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Dependencia asociada</label>
                                  <select disabled name="dependencia" id="dependencia" onchange="buscar_documentos(this.value)" required class="form-control" placeholder="Dependencia asociada">
                                    <option value='' selected>Seleccione...</option>
                                    <?php foreach($data['dependencias'] as $dep ): ?>
                                      <option <?php echo ( $dep['id_dependencia'] == $prop['dependencia'])?('selected'):''; ?> value="<?php echo $dep['id_dependencia'] ?>"><?php echo $dep['nombre'] ?></option>
                                    <?php  endforeach; ?>
                                </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Estado del expediente</label>
                                  <select name="estado" id="estado" required class="form-control" required placeholder="Estado del expediente">
                                  <option value='' selected>Seleccione...</option>
                                  <option <?php echo ( 'abierto' == $prop['estado'])?('selected'):''; ?> value="abierto">Activo</option>
                                  <option <?php echo ( 'cerrado' == $prop['estado'])?('selected'):''; ?> value="cerrado">Inactivo</option>
                                </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>Cliente </label>
                                  <input type="hidden" value="<?php echo $prop['cliente']; ?>" name="clienter" id="cliente<?php echo $prop['num_contrato']; ?>">
                                  <input type="text" disabled class="form-control" value="<?php echo $prop['cliente'].'-'.$prop['nombre_cliente']; ?>" name="cliente" id="arrendatario<?php echo $prop['num_contrato']; ?>" required placeholder="Arrendatario">
                                </div>
                              </div>
                              <div class="col-md-2">
                              <div class="form-group">
                              <ul class="buttons">
                              
                                  <li><a onclick="abrirbuscador(`<?php echo $prop['num_contrato'];?>`)" class="btn btn-success" data-target="#modal-buscarpersona" title="Buscar cliente" >Buscar</a> </li>
                              </ul>
                              </div>
                            </div>
                </div>
                            </div>
                            <div class="modal-footer">
                              <button class="btn btn-secondary" id="cerrar<?php echo $prop['num_contrato'];?>" type="button" data-dismiss="modal">Cancel</button>
                              <button type="submit" name="guardar" value="<?php echo $prop['num_contrato'];?>" class="btn btn-flat btn-primary pull-right "><i class="fa fa-fw fa-save"></i>  Guardar</button>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
            <?php echo form_close();?>

            
                  <?php echo form_open(base_url($tipo_expediente), ['class' => 'form-horizontal', 'id' => 'form_expediente', 'role' => 'form'],['eliminar'=>'1']);?>
              
              <div class="modal fade modal-danger" id="modal-eliminar<?php echo $prop['num_contrato'];?>">
                  <div class="modal-dialog">
                    <div class="modal-content bg-info">
                      <div class="modal-header">
                        <h4 class="modal-title text-white">Eliminar Expediente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p  style="text-align:left" >
                          ¿Esta seguro de que desea eliminar el Expediente <?php echo $prop['num_contrato'];?>?
                        </p>
                        <input type="hidden" name="des" value="<?php echo $prop['num_contrato'];?>">
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary"  type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="elimina" value="<?php echo $prop['num_contrato'];?>" class="btn btn-flat btn-primary pull-right "><i class="fa fa-fw fa-times"></i> Eliminar</button>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <?php echo form_close();?>

                  </td>
                  <td style="text-align:center;" >
                    <button class="btn btn-success regular-button botones" onclick="buscar_documentos(<?php echo "'".$prop['dependencia']."','".$prop['num_contrato']."',''";?>)" title="Archivos cargados"> <i class="fa fa-fw fa-file-pdf"></i></button>
                    <?php if($prop['dependencia'] == '8'): ?>
                    <button class="btn btn-primary regular-button botones" onclick="buscar_documentos(<?php echo "'".$prop['dependencia']."','".$prop['num_contrato']."','imagenes'";?>)" title="Imagenes cargadas"> <i class="fa fa-fw fa-file-image"></i></button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach;?>
                      </tbody>
                <tfoot>
                  <tr>
                    <th style="text-align:center; ">NUMERO</th>
                    <th style="text-align:center; ">DEPENDENCIA</th>
                    <th style="text-align:center; ">ESTADO</th>
                    <th style="text-align:center; ">CLIENTE</th>
                    <th style="text-align:center;">OPCIONES</th>
                    <th style="text-align:center; ">DOCUMENTOS</th> 
                  </tr>
                </tfoot>
              </table> 
              
            <?php endif; ?>  
            <br><hr><button type="button" onclick="add_expedientew()" class="btn btn-flat btn-primary float-right"><i class="fa fa-fw fa-plus"></i> <?php echo ($titulo_boton) ? ($titulo_boton):'Agregar'; ?></button><br>
            
            <div  class="col-md-12" id="agregardoc"></div>
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
      <h1 class="card-title"><strong>Nuevo registro <?php echo ($tiporeal)?('de '.$tiporeal):'' ?></strong></h1>
      
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
                <option value="<?php echo $inmueble['codinmueble']; ?>"><?php echo $inmueble['codigo_pagina'].'-'.$inmueble['direccion'].'-'.$inmueble['nompropietario']; ?></option>
                <?php endforeach; ?>  
              </select><br>


            </div>
          </div>
          <input type="hidden" name="estado" id="estado" value="abierto">
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
         
          <div  class="col-md-12" id="add_agregardoc"></div>
			</div>

        
        <?php else: ?>
          <h5>Para crear un expediente es necesario que las dependencias se encuentren definidas.</h5>
      <?php endif; ?>
    </div>
    
    <div class="card-footer">
          <button type="submit" class="btn btn-flat btn-success float-right" name="crear" value="1"> Crear</button>
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