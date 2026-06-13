<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Nueva Dependencia</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                
                <?php echo form_open('', ['class' => '', 'id' => 'form_dependencias','role' => 'form']);?>
                <div class="card-body">
                    <?php if(isset($data['opciones']) && $data['opciones']): ?>
                    <div class="col-md-6">
                        <div class="row">
                            <label for="OPCION"><b>Que desea crear?</b></label>
                            <br>
                            <select required class="form-control" name="OPCION" id="OPCION" >
                                    <option>Seleccione...</option>
                                    <option value="1">DEPENDENCIA</option>
                                    <option value="2">SUBDEPENDENCIA</option>
                                    <option value="3">SECCION</option>
                                    <option value="4">SUBSECCION</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="DEPENDENCIA" style="display: none;">
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="NOMDEPEN"><b>NOMBRE</b></label>
                                <br>
                                <input class="form-control" type="text" name="NOMDEPEN" id="NOMDEPEN">
                            </div>

                            <div class="col-md-6">
                                <label for="RESPONSABLE"><b>RESPONSABLE</b></label>
                                <br>
                                <select required class="form-control" name="RESPONSABLE" id="RESPONSABLE" >
                                    <option>Seleccione...</option>
                                    
                                </select>
                            </div>
                        </div>

                    </div>

                    <div id="SUBDEPENDENCIA" style="display: none;">
                        <br>
                        <div class="row">

                            <div class="col-md-6">
                                <label for="DEPENDENCIA"><b>DEPENDENCIA</b></label>
                                <select required class="form-control" name="DEPENDENCIA" id="DEPENDENCIA" >
                                        <option>Seleccione...</option>
                                        <?php foreach($data['opciones'] as $opc ):?>
                                            <option value="<?php echo $opc['CODDEPEN'];?>"><?php echo $opc['NOMDEPEN'];?></option>
                                        <?php endforeach;?>
                                    </select>
                            </div>

                            <div class="col-md-6">
                                <label for="NOMDEPEN"><b>NOMBRE</b></label>
                                <br>
                                <input class="form-control" type="text" name="NOMDEPEN" id="NOMDEPEN">
                            </div>

                            <div class="col-md-6">
                                <label for="RESPONSABLE"><b>RESPONSABLE</b></label>
                                <br>
                                <select required class="form-control" name="RESPONSABLE" id="RESPONSABLE" >
                                    <option>Seleccione...</option>
                                    
                                </select>
                            </div>

                        </div>
                    </div>

                    <div id="SECCION" style="display: none;">
                        <div class="col-md-6">
                            <label for="SECCION"><b>SECCION</b></label>
                            <br>
                            <select required class="form-control" name="SECCION" id="SECCION" >
                                    <option>Seleccione...</option>
                                    <?php foreach($data['opciones'] as $opc ):?>
                                        <option value="<?php echo $opc['CODDEPEN'];?>"><?php echo $opc['NOMDEPEN'];?></option>
                                    <?php endforeach;?>
                                </select>
                        </div>
                    </div>

                    <div id="SUBSECCION" style="display: none;">
                        <div class="col-md-6">
                            <label for="SUBSECCION"><b>SUBSECCION</b></label>
                            <br>
                            <select required class="form-control" name="SUBSECCION" id="SUBSECCION" >
                                    <option>Seleccione...</option>
                                    <?php foreach($data['opciones'] as $opc ):?>
                                        <option value="<?php echo $opc['CODDEPEN'];?>"><?php echo $opc['NOMDEPEN'];?></option>
                                    <?php endforeach;?>
                                </select>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-flat btn-success pull-right "><i class="fa fa-fw fa-download"></i>Crear</button>
                    <a class="btn btn-flat btn-warning pull-left " href="<?php echo base_url('dependencias/index');?>"><i class="fa fa-fw fa-arrow-left"></i>Cancelar</a>
                </div>
                <?php echo form_close();?>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<script src="<?php echo base_url('template_admin/vendor/jquery/jquery.min.js');?>"></script>
<script>
        document.getElementById("OPCION").addEventListener("change", function() {
            if (this.value === "1") {
                document.getElementById("DEPENDENCIA").style.display = "block";
                document.getElementById("SUBDEPENDENCIA").style.display = "none";
                document.getElementById("SECCION").style.display = "none";
                document.getElementById("SUBSECCION").style.display = "none";
            } else if (this.value === "2") {
                document.getElementById("DEPENDENCIA").style.display = "none";
                document.getElementById("SUBDEPENDENCIA").style.display = "block";
                document.getElementById("SECCION").style.display = "none";
                document.getElementById("SUBSECCION").style.display = "none";
            }else if(this.value === "3"){
                document.getElementById("DEPENDENCIA").style.display = "none";
                document.getElementById("SUBDEPENDENCIA").style.display = "none";
                document.getElementById("SECCION").style.display = "block";
                document.getElementById("SUBSECCION").style.display = "none";
            } else if(this.value === "4"){
                document.getElementById("DEPENDENCIA").style.display = "none";
                document.getElementById("SUBDEPENDENCIA").style.display = "none";
                document.getElementById("SECCION").style.display = "none";
                document.getElementById("SUBSECCION").style.display = "block";
            }
        });
</script>

