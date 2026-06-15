<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Index');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Index::login');
$routes->add('/procesos', 'Dependencia::index');
$routes->add('/dependencia', 'Dependencia::index');
$routes->add('/login', 'Index::login');
$routes->add('/registro', 'Index::registro');
$routes->add('/logout', 'Index::logout');
$routes->add('/buscarinfo', 'Index::buscarinfo');
$routes->add('/expediente', 'Dependencia::expediente');
$routes->add('/add_expediente', 'Dependencia::add_expediente');


$routes->add('/activar_usuario/(:any)', 'Index::activar_usuario/$1');
$routes->add('/buscardocumentos', 'Dependencia::buscardocumentos');

$routes->add('/buscarpropietario', 'Dependencia::buscarpropietario');


$routes->add('/createuser', 'Users::create');
$routes->add('/permissions', 'Users::permissions');

$routes->add('/visualizarsoporte', 'Index::visualizarsoporte');
$routes->add('/file_delete/(:any)', 'Index::file_delete/$1');


$routes->add('/inmuebles', 'Dependencia::inmuebles');

$routes->add('/ventas', 'Dependencia::ventas');

$routes->add('/propietarios', 'Dependencia::propietario');
$routes->add('/arrendatarios', 'Dependencia::arrendatario');

$routes->add('/expediente_arriendos', 'Dependencia::expediente_arriendos');
$routes->add('/compraventa', 'Dependencia::compraventa');
$routes->add('/consignacion', 'Dependencia::consignacion');
$routes->add('/avaluo', 'Dependencia::avaluo');

$routes->add('/arriendos', 'Dependencia::arriendos');
$routes->add('/notificaciones', 'Dependencia::notificaciones');
$routes->add('/consignacion_arriendo', 'Dependencia::consignacion_arriendo');
$routes->add('/consignacion_arriendo_inactivas', 'Dependencia::consignacion_arriendo_inactivas');

/*$routes->add('/radicar', 'index::radicar');
$routes->add('/consultas', 'index::consultas');


$routes->add('/radicar/(:any)', 'index::radicar/$1');
$routes->add('/login', 'index::login');
$routes->add('/registro', 'index::registro');
$routes->add('/admin', 'index::admin');
$routes->add('/logout', 'index::logout');
$routes->add('/radicados', 'radicados::index');
$routes->add('/create', 'radicados::create');
$routes->add('/versoporte/(:any)', 'radicados::soporte/$1');
$routes->add('/radicados_ugad', 'radicados::ugad');
$routes->add('/asignar_dependencia', 'radicados::asignar_dependencia');
$routes->add('/radicados_dependencia', 'radicados::radicados_dependencia');
//$routes->add('/radicados/soporte', 'radicados::soporte');
$routes->add('/radicado', 'index::radicado');
$routes->add('/radicados_personales', 'index::radicados');
$routes->add('/asignar_responsable', 'radicados::asignar_responsable');
//$routes->add('/radicados/soporte', 'radicados::soporte');
$routes->add('/radicados_encargado', 'radicados::radicados_encargado');
$routes->add('/responder', 'radicados::responder');
$routes->add('/responder_radicado', 'radicados::responder_radicado');
$routes->add('/finalizar', 'radicados::finalizar');
$routes->add('/finalizar_radicado', 'radicados::finalizar_radicado');
$routes->add('/eliminar_archivo/(:any)/(:any)', 'radicados::eliminar_archivo/$1/$2');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
