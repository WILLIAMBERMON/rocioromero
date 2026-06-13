

<div class="card card-info">
  <div class="card-header">
    <h3 class="card-title">Diligenciar un radicado</h3>
  </div>
  <?php echo form_open_multipart(base_url('radicado'), ['class' => 'form-horizontal', 'id' => 'form_radicar', 'role' => 'form'], ['radicar' => 1]); ?>
      <div class="card-body">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Tipo de solicitud</label>
          <div class="col-sm-10">
                <select name="tipo_pqrsd" required id="tipo_pqrsd" class="form-control">
                    <option value=''>Seleccione...</option>    
                    <option value="P">Petición</option>
                    <option value="Q">Quejas</option>
                    <option value="R">Reclamos</option>
                    <option value="S">Sugerencias</option>
                    <option value="D">Denuncias</option>
                </select>  
          </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Dependencia</label>
          <div class="col-sm-10">
          <select name="dependencia" id="dependencia" class="form-control">
                                            <option value=''>Seleccione...</option>
                                            <option value='N/A'>No Aplica</option>
                                            <?php foreach($data['dependencias'] as $dependencia):?> 
                                                <option value="<?php echo $dependencia['CODIGODEPEN']; ?>"><?php echo $dependencia['NOMDEPEN']; ?></option>
                                            <?php endforeach; ?>      
                                        </select>  
          </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Descripción</label>
          <div class="col-sm-10">
              <textarea name="descripcion" required id="descripcion" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>  
          </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Documento soporte</label>
          <div class="col-sm-10">
          <input  name="archivo_soporte" id="archivo_soporte" type="file" id="formFile">
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-info float-right">Radicar</button>
      </div>
      <?php echo form_close(); ?>
</div>


