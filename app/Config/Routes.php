<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('user', 'User::index');
$routes->get('data/maphome', 'Home::map');
$routes->get('register', 'Home::register');
$routes->get('inputData', 'Kebakaran::inputData');
$routes->post('insertData', 'Kebakaran::insertData');
$routes->post('data/updateData/(:segment)', 'Kebakaran::updateData/$1');
$routes->get('data/editData/(:segment)', 'Kebakaran::editData/$1');
$routes->get('data/tampilData', 'Kebakaran::tampilData');
$routes->get('data/(:any)', 'Kebakaran::detail/$1');
$routes->delete('data/(:num)', 'Kebakaran::delete/$1');


require ROOTPATH . 'vendor/myth/auth/src/Config/Routes.php';
