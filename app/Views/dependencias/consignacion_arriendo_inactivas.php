<div class="container-fluid">
  <div class="card card-dark">
    <div class="card-header">
      <h1 class="card-title"><strong><?php echo ($titulo_tabla) ? ($titulo_tabla):'Consignaciones de arriendo inactivadas'; ?></strong></h1>
    </div>
    <div class="card-body">
      <p style="text-align:justify">
        <?php echo ($titulo_tabla) ? ($titulo_tabla):'Consignaciones de arriendo inactivadas'; ?>
      </p>

      <a href="<?php echo base_url('consignacion_arriendo'); ?>" class="btn btn-flat btn-primary float-right">
        <i class="fa fa-fw fa-arrow-left"></i> Volver
      </a>
      <br><br>

      <?php if(isset($data['expedientes']) && $data['expedientes']): ?>
      <table id="example1s" class="datatablew table table-bordered table-striped">
        <thead>
          <tr>
            <th style="text-align:center;">NUM CONSIGNACION</th>
            <th style="text-align:center;">CODIGO INACTIVADO</th>
            <th style="text-align:center;">DATOS</th>
            <th style="text-align:center;">ESTADO</th>
            <th style="text-align:center;">DOCUMENTOS</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data['expedientes'] as $prop):?>
          <tr>
            <td style="text-align:center;"><?php echo $prop['codigo'];?></td>
            <td style="text-align:center;"><?php echo isset($prop['codigo_inactivado']) && $prop['codigo_inactivado'] ? $prop['codigo_inactivado'] : '-';?></td>
            <td style="text-align:center;"><?php echo '<b>Propietario: </b>'.$prop['nompropietario'].'<br><b>Direccion: </b>'.$prop['direccion'].'. '.$prop['barrio'].'<br><b>Ciudad: </b>'.$prop['ciudad'];?></td>
            <td style="text-align:center;">Inactivo</td>
            <td style="text-align:center;">
              <button class="btn btn-success regular-button botones" onclick="buscar_documentos(<?php echo "'8','".$prop['codigo']."','','agregardoc'";?>)" title="Archivos cargados">
                <i class="fa fa-fw fa-file-pdf"></i>
              </button>
            </td>
          </tr>
          <?php endforeach;?>
        </tbody>
        <tfoot>
          <tr>
            <th style="text-align:center;">NUM CONSIGNACION</th>
            <th style="text-align:center;">CODIGO INACTIVADO</th>
            <th style="text-align:center;">DATOS</th>
            <th style="text-align:center;">ESTADO</th>
            <th style="text-align:center;">DOCUMENTOS</th>
          </tr>
        </tfoot>
      </table>
      <?php else: ?>
        <div class="alert alert-info">No hay consignaciones de arriendo inactivadas.</div>
      <?php endif; ?>

      <div class="col-md-12" id="agregardoc"></div>
    </div>
  </div>
</div>
