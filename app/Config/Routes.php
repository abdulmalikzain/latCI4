<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('user', 'User::index');
$routes->get('map', 'Home::map');
$routes->get('getData', 'Home::getData');
$routes->get('inputData', 'Kebakaran::inputData');
$routes->post('insertData', 'Kebakaran::insertData');
$routes->post('data/updateData/(:segment)', 'Kebakaran::updateData/$1');
$routes->get('data/editData/(:segment)', 'Kebakaran::editData/$1');
$routes->get('data/tampilData', 'Kebakaran::tampilData');
$routes->get('data/(:any)', 'Kebakaran::detail/$1');
$routes->delete('data/(:num)', 'Kebakaran::delete/$1');

$routes->get('admin/tambahuser', 'Admin::index', ['filter' => 'role:admin']);
$routes->post('admin/simpanuser', 'Admin::save', ['filter' => 'role:admin']);
$routes->get('admin/listuser', 'Admin::listuser', ['filter' => 'role:admin']);
$routes->get('admin/(:num)', 'Admin::detailtuser/$1', ['filter' => 'role:admin']);
$routes->get('admin/getUser/(:num)', 'Admin::getUser/$1', ['filter' => 'role:admin']);
// $routes->post('admin/edit', 'Admin::edit', ['filter' => 'role:admin']);
$routes->post('admin/updatePhotoAjax', 'Admin::updatePhotoAjax', ['filter' => 'role:admin']);
$routes->post('admin/updateAjax', 'Admin::updateAjax', ['filter' => 'role:admin']);
$routes->post('admin/validateField', 'Admin::validateField', ['filter' => 'role:admin']);


$routes->get('getDataKebakaran', 'User::getData');
$routes->get('testpassword', 'Home::testpass');


require ROOTPATH . 'vendor/myth/auth/src/Config/Routes.php';
