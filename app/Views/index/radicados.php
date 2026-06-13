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
              <th style="text-align:center;">TIPO DE PQRSD</th>
              <th style="text-align:center;">DEPENDENCIA</th>
              <th style="text-align:center;">DESCRIPCION</th>
              <th style="text-align:center;">DOCUMENTO</th>
              <th style="text-align:center;">FECHA</th>
              
          </tr>
        </thead>
        <tbody>
        <?php foreach($data['informacion'] as $info):?>
        
          <tr>
            <td style="text-align:center;"><?php echo $info['id'];?></td>
            <td style="text-align:center;"><?php echo $info['tipopqrs'];?></td>
            <td style="text-align:center;"><?php
            $depenradicado = $info['dependencia'];
             if(isset ($data['dependencias']) && $data['dependencias']){
              foreach($data['dependencias'] as $depen): 
                if($depen['CODIGODEPEN'] == $info['dependencia']){
                  $depenradicado = $depen['NOMDEPEN'];
                }
              endforeach;
             }
             echo $depenradicado;
             
             ?></td>
            <td style="text-align:center;"><?php echo $info['descripcion'];?></td>
            <td style="text-align:center;">
            <?php 
            if($info['url_soporte']){
                $ultimo = explode("/",$info['url_soporte']);
                $cantidad = count($ultimo); $name = '';
                for($i = 0; $i < $cantidad; $i++){
                    if($cantidad == $i+1){
                    $name = $ultimo[$i];
                    }
                }
              ?>
              <a target="_blank" class="btn btn-flat btn-info pull-left " title="Documento de Soporte" href="<?php echo site_url('versoporte/'.$name);?>"><i class="fa fa-fw fa-file-pdf"></i> Ver</a>
              <?php }else{ echo '-';} ?>
            </td>
            <td style="text-align:center;"><?php echo $info['fecha_solicitud'];?></td>
          </tr>
        
        <?php endforeach;?>
        </tbody>
        <tfoot>
          <tr>
              <th style="text-align:center;">ID</th>
              <th style="text-align:center;">TIPO DE PQRSD</th>
              <th style="text-align:center;">DEPENDENCIA</th>
              <th style="text-align:center;">DESCRIPCION</th>
              <th style="text-align:center;">DOCUMENTO</th>
              <th style="text-align:center;">FECHA</th>
              
          </tr>
        </tfoot>

      </table>
      <?php else: echo '<h5>Aún no hay información para mostrar.</h5>' ?>
    <?php endif; ?>
    </div>
    <!-- /.card-body -->
  </div>
</div> 