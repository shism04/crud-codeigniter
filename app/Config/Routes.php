<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/jugadores', 'Home::index');
$routes->get('/calculadora','Calculadora::index');
$routes->get('/signup','User::index');
$routes->get('/test','TestDatabase::index');

//routa para extraer resultado desde un fetch al metodo procesar (ajax)
$routes->post('/calculadora/procesar','Calculadora::procesar');

$routes->post('/signup','User::signup');
