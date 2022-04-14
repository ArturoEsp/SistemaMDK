<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/* $routes->get('/', 'Home::index');
$routes->get('/create-user', 'UserController::createUser'); */

$routes->get('/', 'AuthController::dashboard', ['filter' => 'authFilter']);
$routes->get('login', 'AuthController::index', ['as' => 'login']);

$routes->post('signin', 'AuthController::login', ['as' => 'signin']);
$routes->get('logout', 'AuthController::logout', ['as' => 'logout']);

$routes->group('/users', function ($routes) {
    $routes->post('create-user-form', 'UserController::store', ['as' => 'create-user-form']);
    $routes->get('search-users', 'UserController::findUsersByParams', ['as' => 'search-users']);
    $routes->delete('user', 'UserController::deleteUserById');
    $routes->get('user/(:num)', 'UserController::getUserById/$1');
    $routes->post('user/(:num)', 'UserController::updateUserById/$1');

    // Views
    $routes->get('create-user', 'UserController::create', ['filter' => 'authFilter']);
    $routes->get('', 'UserController::index', ['filter' => 'authFilter']);
});


$routes->group('/escuelas', function ($routes) {
    $routes->post('save', 'EscuelaController::store');
    $routes->get('teachers', 'EscuelaController::getListTeachers');
    $routes->get('all', 'EscuelaController::getSchools');
    $routes->delete('(:num)', 'EscuelaController::deleteSchool/$1');

    // Views
    $routes->get('', 'EscuelaController::index', ['filter' => 'authFilter']);
});

$routes->group('/participantes', function ($routes) {
    $routes->get('escuela/(:num)', 'AlumnoController::getParticipantesByEscuela/$1');
    $routes->post('save', 'AlumnoController::store');
    $routes->post('update/(:num)', 'AlumnoController::update/$1');

    $routes->get('categories/(:any)/(:any)', 'AlumnoController::getCategoriesByGenreAndWeight/$1/$2');
    $routes->get('levels/(:any)', 'AlumnoController::getLevelsByAge/$1');
    $routes->get('(:num)', 'AlumnoController::getParticipanteById/$1');

    // Views
    $routes->get('', 'AlumnoController::participantesView', ['filter' => 'authFilter']);
    $routes->get('registro-evento', 'AlumnoController::registroEvento', ['filter' => 'authFilter']);
    $routes->get('edit', 'AlumnoController::editParticipanteView', ['filter' => 'authFilter']);
});

$routes->group('/areas', function ($routes) {
    $routes->post('save', 'AreaController::store');
    $routes->get('all', 'AreaController::getAllAreas');
    $routes->post('update/(:num)', 'AreaController::update/$1');
    $routes->delete('delete/(:num)', 'AreaController::delete/$1');


    // Views
    $routes->get('', 'AreaController::index', ['filter' => 'authFilter']);
});

$routes->group('/eventos', function ($routes) {
    $routes->post('save', 'EventoController::store');
    $routes->get('escuela/(:num)/mod/(:num)/participantes-disponibles', 'AlumnoController::getParticipantesForEvent/$1/$2');
    $routes->get('escuela/(:num)/participantes/mod/(:num)', 'EventoController::getParticipantesInEventBySchoolAndMod/$1/$2');
    $routes->post('register', 'EventoController::registerParticipantes');
    $routes->delete('participante/(:num)', 'EventoController::deleteParticipanteEvento/$1');

    // Views
    $routes->get('', 'EventoController::index', ['filter' => 'authFilter']);
    $routes->get('nuevo', 'EventoController::crearEvento', ['filter' => 'authFilter']);
});

$routes->group('/graficas', function ($routes) {

    $routes->post('participantes/params', 'GraficaController::getParticipantesForParams');
    $routes->post('store', 'GraficaController::store');
    $routes->get('info/(:num)', 'GraficaController::getGraficaMatchs/$1');

    // Views
    $routes->get('', 'GraficaController::index', ['filter' => 'authFilter']);
    $routes->get('nueva', 'GraficaController::create_grafica', ['filter' => 'authFilter']);
    $routes->get('view/(:num)', 'GraficaController::view_grafica/$1', ['filter' => 'authFilter']);
    $routes->get('edit/(:num)', 'GraficaController::edit_grafica/$1', ['filter' => 'authFilter']);
});

$routes->group('/matchs', function ($routes) {
    $routes->post('update', 'MatchController::update');
});

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
