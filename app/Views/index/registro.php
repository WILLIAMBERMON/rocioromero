<div class="text-center" style="background: url(<?php echo base_url('template/img/nosotros_1.jpg') ?>) center/cover #004494; position: relative">
    <?= view('home/styling') ?>
    <div class="justify-content-center container d-flex flex-column" style="min-height: 100vh; max-width: 476px; padding-bottom:100px">

        <p class="mt-5"><a href="<?php echo base_url(); ?>"><img style="background:white; border-radius:10px;padding:10px" src="<?php echo base_url('template/img/logo_rocio.png') ?>" alt="Logo" width="150px"></a></p>
        <?php echo form_open(base_url('registro'), ['class' => '', 'id' => 'form_login', 'role' => 'form','style'=>'padding:20px'], ['login' => 1]); ?>
            <h1 class="mb-4" style="color:white">REGISTRO</h1>
            <div id="step2" >
                        <div class="form_title">
							<h3 style="color:white"><strong>1</strong>Número de identificación</h3>
							<p style="color:white">
								Precargará la información personal.
							</p>
						</div>
						<div class="step">
							<div class="row">
								        <div class="col-md-10 col-sm-10">
                                        <span class="input">
                                            <input class="input_field"   name="codigo" id="codigo" type="number">
                                            <label class="input_label">
                                            <span class="input__label-content" >Número de identificación</span>
                                            </label>
                                        </span>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <button onclick="buscarinfo()" type="button" style="margin-top:30px" class="btn-primary btn btn-block mb-3"><i class="pe-7s-search"></i></button>
                                        </div>    
							</div>
						</div>
						<hr>
                        </div>
                        <div id="step3" style="display:none">
						<div class="form_title">
							<h3 style="color:white"><strong>2</strong>Datos personales</h3>
							<p style="color:white">
								Verifique que la información acá consignada sea correcta.
							</p>
						</div>
						<div class="step">
                            <div class="row">
								<div class="col-md-6 col-sm-6">
                                    <span id="ftipodoc" class="input">
                                        <select name="tipo_documento" id="tipo_documento" required class="input_field select_opt">
                                            <option>Seleccione...</option>    
                                            <option value="TI">Tarjeta de identidad</option>
                                            <option value="CC">Cedula de ciudadania</option>
                                            <option value="CE">Cedula de extranjeria</option>
                                            <option value="PS">Pasaporte</option>
                                        </select>    
                                        <label class="input_label">
                                        <span >Tipo de documento</span>
                                        </label>
                                    </span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <span id="fdoc" class="input">
                                        <input class="input_field" name="documento" id="documento" required type="number">
                                        <label class="input_label">
                                        <span class="input__label-content">Nº de documento</span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-md-6 col-sm-6">
                                    <span id="fname" class="input">
                                        <input class="input_field" name="nombres" id="nombres"  required type="text">
                                        <label class="input_label">
                                        <span class="input__label-content">Nombres</span>
                                        </label>
                                    </span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <span id="flastname" class="input">
                                        <input class="input_field" name="apellidos" id="apellidos" required type="text">
                                        <label class="input_label">
                                        <span class="input__label-content">Apelidos</span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-md-6 col-sm-6">
                                    <span id="fcel" class="input">
                                        <input class="input_field" name="celular" id="celular" required type="number">
                                        <label class="input_label">
                                        <span class="input__label-content">Celular</span>
                                        </label>
                                    </span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <span id="fmail" class="input">
                                        <input class="input_field" name="email" id="email" required type="email">
                                        <label class="input_label">
                                        <span class="input__label-content">Email</span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-md-6 col-sm-6">
                                    <span id="fcel" class="input">
                                        <input class="input_field" name="password" id="password" required type="text">
                                        <label class="input_label">
                                        <span class="input__label-content">Contraseña</span>
                                        </label>
                                    </span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <span id="fmail" class="input">
                                        <input class="input_field" name="rpassword" id="rpassword" required type="text">
                                        <label class="input_label">
                                        <span class="input__label-content">Repetir contraseña</span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="row inputs container" style="display:none" id="textpassword">
                                <div class=" col-md-12 col-sm-12 text-danger" style="text-align:justify">
                                    <div class="checkbox">
                                    <label><input type="checkbox" data-validation="quantity" disabled value="">La contraseña debe contener al menos 8 carecteres.</label>
                                    </div>
                                    <div class="checkbox">
                                    <label><input type="checkbox" data-validation="lowerCase" disabled value="">La contraseña deberá contener al menos una letra minuscula.</label>
                                    </div>
                                    <div class="checkbox disabled">
                                    <label><input type="checkbox" data-validation="upperCase" value="" disabled>La contraseña deberá contener al menos una letra mayuscula.</label>
                                    </div>
                                    <div class="checkbox disabled">
                                    <label><input type="checkbox" data-validation="numbers" value="" disabled>La contraseña debe contener al menos un numero.</label>
                                    </div>
                                    <div class="checkbox disabled">
                                    <label><input type="checkbox" data-validation="specialCharacters" value="" disabled>La contraseña deberá contener al menos un caracter especial. <b>Ej: $#¿!%*?& </b>.</label>
                                    </div>
                                    <div class="checkbox disabled">
                                    <label><input type="checkbox" data-validation="sequential" value="" disabled>La contraseña no puede presentar caracteres de manera secuencial.</label>
                                    </div>    
                                </div>
                            </div>  
                            <div class="row inputs container" style="display:none" id="textrpassword">
                                <div class=" col-md-12 col-sm-12 text-danger" style="text-align:justify">
                                    <div class="checkbox">
                                    <label><input type="checkbox" data-validation="iguality" disabled value="">La contraseña debe contener al menos 8 carecteres.</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <a href="<?php echo base_url('') ?>" type="button" style="margin-top:30px" class="btn-primary btn btn-block mb-3"><i class="pe-7s-angle-left-circle"></i> Regresar</a>
                            <button name="registrarse" value="1" type="submit" style="margin-top:30px" class="btn-primary btn btn-block mb-3"><i class="pe-7s-pen"></i> Registrarse</button>
						</div>
                        </div>
        <?php echo form_close(); ?>
        
    </div>
</div>