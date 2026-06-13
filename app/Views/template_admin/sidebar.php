<nav class="navbar navbar-expand-lg navbar-dark bg-default fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?php echo base_url('admin'); ?>"><img src="<?php echo base_url('/template/img/logo_rocio.png'); ?>" data-retina="true" alt="" width="163" height="36"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <?php if(isset($usuario_pqrsd) && $usuario_pqrsd): ?>
                    <li class="nav-item <?php echo (($active_sidebar == 'procesos')?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Bookings">
                      <a class="nav-link" href="<?php echo base_url('procesos'); ?>">
                        <i class="fa fa-fw fa-archive"></i>
                        <span class="nav-link-text"> Procesos</span>
                      </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Arriendos" >
                      <a class="nav-link nav-link-collapse" data-toggle="collapse" href="#menuarriendos" data-parent="#exampleAccordion">
                        <i class="fa fa-duotone fa-building"></i>
                        <span class="nav-link-text"> Arriendos</span>
                      </a>
                      <ul class="sidenav-second-level collapse <?php echo ((in_array($active_sidebar ,array('arriendos','notificaciones','consignacion_arriendo')))?'show':''); ?>" id="menuarriendos">
                        
                        <li class="<?php echo (($active_sidebar == 'consignacion_arriendo')?'active':''); ?>">
                        <a href="<?php echo base_url('consignacion_arriendo'); ?>"> <i class="fa fa-fw fa-list"></i>
                          <span class="nav-link-text"> Consignación de inmueble</span></a>
                        </li>

                        <li class="<?php echo (($active_sidebar == 'arriendos')?'active':''); ?>">
                          <a href="<?php echo base_url('arriendos'); ?>"> <i class="fa fa-fw fa-bed"></i>
                          <span class="nav-link-text"> Arriendos</span></a>
                        </li>
                        <?php /* <li class="<?php echo (($active_sidebar == 'notificaciones')?'active':''); ?>">
                          <a href="<?php echo base_url('notificaciones'); ?>"> <i class="fa fa-fw fa-bed"></i>
                          <span class="nav-link-text"> Notificaciones</span></a>
                        </li>*/ ?>
                      </ul>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Ventas" >
                      <a class="nav-link nav-link-collapse" data-toggle="collapse" href="#menuventas" data-parent="#exampleAccordion">
                        <i class="fa fa-duotone fa-building"></i>
                        <span class="nav-link-text"> Ventas</span>
                      </a>
                      <ul class="sidenav-second-level collapse <?php echo ((in_array($active_sidebar ,array('compraventa','consignacion','avaluo')))?'show':''); ?>" id="menuventas">
                        <li class="<?php echo (($active_sidebar == 'compraventa')?'active':''); ?>">
                        <a href="<?php echo base_url('consignacion'); ?>"> <i class="fa fa-fw fa-list"></i>
                          <span class="nav-link-text"> Consignación inmueble</span></a>
                        </li>
                        <li class="<?php echo (($active_sidebar == 'compraventa')?'active':''); ?>">
                        <a href="<?php echo base_url('compraventa'); ?>"> <i class="fa fa-fw fa-list"></i>
                          <span class="nav-link-text"> Compraventas</span></a>
                        </li>
                        <li class="<?php echo (($active_sidebar == 'compraventa')?'active':''); ?>">
                        <a href="<?php echo base_url('avaluo'); ?>"> <i class="fa fa-fw fa-list"></i>
                          <span class="nav-link-text"> Avaluos</span></a>
                        </li>
                        <?php /*<li class="<?php echo (($active_sidebar == 'arriendos')?'active':''); ?>">
                          <a class="nav-link" href="<?php echo base_url('ventas'); ?>"><i class="fa fa-fw fa-credit-card"></i>
                            <span class="nav-link-text"> Ventas</span>
                          </a>
                        </li>*/ ?>
                      </ul>
                    </li>
                    <?php /*<li class="nav-item <?php echo (($active_sidebar == 'expediente')?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Bookings">
                      <a class="nav-link" href="<?php echo base_url('expediente'); ?>">
                        <i class="fa fa-fw fa-list"></i>
                        <span class="nav-link-text"> Expedientes</span>
                      </a>
                    </li>
                    <li class="nav-item <?php echo (($active_sidebar == 'add_expediente')?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Bookings">
                      <a class="nav-link" href="<?php echo base_url('add_expediente'); ?>">
                        <i class="fa fa-fw fa-folder-open"></i>
                        <span class="nav-link-text">Agregar expediente</span>
                      </a>
                    </li>
                    <li class="nav-item <?php echo (($active_sidebar == 'arriendos')?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Bookings">
                      <a class="nav-link" href="<?php echo base_url('arriendos'); ?>">
                        <i class="fa fa-fw fa-bed"></i>
                        <span class="nav-link-text"> Arriendos</span>
                      </a>
                    </li>
                    <li class="nav-item <?php echo (($active_sidebar == 'ventas')?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Bookings">
                      <a class="nav-link" href="<?php echo base_url('ventas'); ?>">
                        <i class="fa fa-fw fa-credit-card"></i>
                        <span class="nav-link-text"> Ventas</span>
                      </a>
                    </li>*/?>
                    <li class="nav-item <?php echo (($active_sidebar == 'inmuebles')?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Bookings">
                      <a class="nav-link" href="<?php echo base_url('inmuebles'); ?>">
                        <i class="fa fa-fw fa-house"></i>
                        <span class="nav-link-text"> Inmuebles</span>
                      </a>
                    </li>
                    <li class="nav-item <?php echo (($active_sidebar == 'propietarios')?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Bookings">
                      <a class="nav-link" href="<?php echo base_url('propietarios'); ?>">
                        <i class="fa fa-fw fa-user"></i>
                        <span class="nav-link-text"> Propietarios</span>
                      </a>
                    </li>
                    <li class="nav-item <?php echo (($active_sidebar == 'arrendatarios')?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Bookings">
                      <a class="nav-link" href="<?php echo base_url('arrendatarios'); ?>">
                        <i class="fa fa-fw fa-people"></i>
                        <span class="nav-link-text"> Arrendatario</span>
                      </a>
                    </li>

                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Administración de Usuarios" >
                      <a class="nav-link nav-link-collapse" data-toggle="collapse" href="#collapseRad" data-parent="#exampleAccordion">
                        <i class="fa fa-duotone fa-building"></i>
                        <span class="nav-link-text"> Administración de Usuarios</span>
                      </a>
                      <ul class="sidenav-second-level collapse <?php echo ((in_array($active_sidebar ,array('createuser','permissions')))?'show':''); ?>" id="collapseRad">
                        <li class="<?php echo (($active_sidebar == 'createuser')?'active':''); ?>">
                          <a href="<?php echo base_url('createuser'); ?>"> Crear usuarios</a>
                        </li>

                        <?php /*<li class="<?php echo (($active_sidebar == 'permissions')?'active':''); ?>">
                          <a href="<?php echo base_url('permissions'); ?>"> Permisos Usuario</a>
                        </li>*/ ?>
                      </ul>
                    </li>

        <?php  endif; ?>  
<!-- fin del sidebar -->
      </ul>

      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul  class="navbar-nav ml-auto">
        
        <?php if(isset($usuario_pqrsd) && $usuario_pqrsd): ?>
          <?php echo '<li style="padding-top:9px" class="nav-item"><font style="color:white">'.$usuario_pqrsd["nombres"].' '.$usuario_pqrsd["apellidos"].'</font></li>'; ?>
          <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('logout'); ?>">
            <i class="fa fa-fw fa-sign-out"></i> Cerrar Sesión</a>
        </li>
      </ul>
    </div>
  </nav>