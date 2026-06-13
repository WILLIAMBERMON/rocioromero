

<div class="text-center" style="background: url(<?php echo base_url('template/img/nosotros_1.jpg') ?>) center/cover #004494; position: relative">
    <?= view('home/styling') ?>
    <div class="justify-content-center container d-flex flex-column" style="min-height: 100vh; max-width: 476px; padding-bottom:100px">

        <p class="mt-5"><a href="<?php echo base_url(); ?>"><img style="background:white; border-radius:10px;padding:10px" src="<?php echo base_url('template/img/logo_rocio.png') ?>" alt="Logo" width="150px"></a></p>
        <?php echo form_open(base_url('activar_usuario').'/'.$llave, ['class' => '', 'id' => 'form_registro', 'role' => 'form','style'=>'padding:20px'], ['registrarsew' => 1]); ?>
            <h1 class="mb-4" style="color:white">Completar registro</h1>
            <div id="step2" >
						<div class="step">
                            <div class="row">
								
                                <div class="col-md-6 col-sm-6">
                                    <span id="fdoc" class="input">
                            
                                        <input class="input_field" disabled value="<?php echo $info['documento'] ?>" required type="number">
                                        <label class="input_label">
                                        <span class="input__label-content">Nº de documento</span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-md-6 col-sm-6">
                                    <span id="fcel" class="input">
                                        <input class="input_field" onkeyup="hizoclic(this.value)" name="password" id="password" required type="text">
                                        <label class="input_label">
                                        <span class="input__label-content">Contraseña</span>
                                        </label>
                                    </span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <span id="fmail" class="input">
                                        <input class="input_field" onkeyup="validigual(this.value)" name="rpassword" id="rpassword" required type="text">
                                        <label class="input_label">
                                        <span class="input__label-content">Repetir contraseña</span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="row inputs container" id="pswd_info" style="display: none">
                                <div class=" col-md-12 col-sm-12" style="text-align:justify">
                                    <div class="checkbox">
                                    <label class="invalid" id="length"><input type="checkbox"  disabled value=""> La contraseña debe contener al menos 8 carecteres.</label>
                                    </div>
                                    <div class="checkbox">
                                    <labe class="invalid" id="minuscula" l><input type="checkbox" disabled value=""> La contraseña deberá contener al menos una letra minuscula.</label>
                                    </div>
                                    <div class="checkbox disabled">
                                    <label class="invalid" id="capital"><input type="checkbox" value="" disabled> La contraseña deberá contener al menos una letra mayuscula.</label>
                                    </div>
                                    <div class="checkbox disabled">
                                    <label class="invalid" id="number"><input type="checkbox" value="" disabled> La contraseña debe contener al menos un numero.</label>
                                    </div>
                                    <div class="checkbox disabled">
                                    <label class="invalid" id="letter" ><input type="checkbox" value="" disabled> La contraseña deberá contener al menos una letra.</label>
                                    </div>
                                </div>
                            </div>  
                            <div class="row inputs container" style="display:none" id="pswd_rep">
                                <div class=" col-md-12 col-sm-12 text-danger" style="text-align:justify">
                                    <div class="checkbox">
                                    <label class="invalid" id="igual" ><input type="checkbox"disabled value="">La contraseña debe contener al menos 8 carecteres.</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <a href="<?php echo base_url('') ?>" type="button" style="margin-top:30px" class="btn-primary btn btn-block mb-3"><i class="pe-7s-angle-left-circle"></i> Regresar</a>
                            <button type="button" onclick="validarclaves()" style="margin-top:30px" class="btn-primary btn btn-block mb-3"><i class="pe-7s-pen"></i> Finalizar Registro</button>
						</div>
                        </div>
        <?php echo form_close(); ?>
        
    </div>
</div>