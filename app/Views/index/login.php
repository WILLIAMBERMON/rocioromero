<div class="text-center" style="background: url(<?php echo base_url('template/img/nosotros_1.jpg') ?>) center/cover #004494; position: relative">
    <?= view('home/styling') ?>
    <div class="justify-content-center container d-flex flex-column" style="min-height: 100vh; max-width: 476px; padding-bottom:100px">

        <p class="mt-5"><a href="<?php echo base_url(); ?>"><img style="background:white; border-radius:10px;padding:10px"  src="<?php echo base_url('template/img/logo_rocio.png') ?>" alt="Logo" width="150px"></a></p>
        <?php echo form_open_multipart(base_url('login'), ['class' => '', 'id' => 'form_login', 'role' => 'form','style'=>'padding:20px'], ['login' => 1]); ?>
            <h1 class="mb-4" style="color:white">Iniciar Sesión</h1>
            <input type="text" required name="documento" placeholder="Nº Documento" class="form-control mb-2">
            <input type="password" required name="password" autocomplete="current-password" placeholder="Password" class="form-control mb-2">
            <div class="separator mb-3" style="color:white"> * </div>
            <div style="align:center"><input type="submit" value="Iniciar Sesión" class="btn align-items-center btn-light border-secondary mb-2"></div>
        <?php echo form_close(); ?>
        
    </div>
</div>