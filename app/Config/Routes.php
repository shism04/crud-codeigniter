<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/jugadores', 'Home::index');
$routes->get('/calculadora','Calculadora::index');
$routes->get('/signup','User::index');
$routes->get('/loginview','User::getlogin');
$routes->get('/test','TestDatabase::index');

//routa para extraer resultado desde un fetch al metodo procesar (ajax)
$routes->post('/calculadora/procesar','Calculadora::procesar');
$routes->post('/anadirJugador','Home::insertPlayer');
$routes->post('editarJugador/(:num)', 'Home::updatePlayer/$1');
$routes->get('eliminarJugador/(:num)', 'Home::deletePlayer/$1');
$routes->post('/buscar','Home::index');

$routes->post('/signup','User::signup');
$routes->post('/login','User::login');
