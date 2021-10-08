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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index',['filter' => 'auth']);
$routes->get('/', 'view\Dashboard::index'); #view
$routes->get('/login', 'view\Login::index'); #view
$routes->post('/login','Login::index');


# ADMIN ENDPOINTS
$routes->post('/register','Register::index',['filter' => 'auth']); 
$routes->match(['get','post'],'/logout','Logout::index');
$routes->post('/product/create','Product::create',['filter' => 'auth']);
$routes->match(['get','post'],'/products','Product::index',['filter' => 'auth']);
$routes->match(['post'],'/delete/(:any)','Product::delete/$1',['filter' => 'auth']);
$routes->match(['get','post'],'/find/(:any)','Product::show/$1',['filter' => 'auth']);
$routes->match(['get','post'],'/find','Product::show',['filter' => 'auth']);
$routes->match(['get','post'],'/ajax/(:any)','Product::showBatch/$1',['filter' => 'auth']);
$routes->match(['get','post'],'/market/(:any)/(:any)','Product::setSold/$1/$2',['filter' => 'auth']);
$routes->post('/update/(:any)','Product::update/$1',['filter' => 'auth']);


$routes->post('/feed/update/(:any)','Feeds::update/$1',['filter' => 'auth']);
$routes->post('/feed/delete/(:any)','Feeds::delete/$1',['filter' => 'auth']);
$routes->post('/feed/create','Feeds::create',['filter' => 'auth']);
$routes->post('/feed/pull/(:any)','Feeds::show/$1',['filter' => 'auth']);
$routes->post('/feed','Feeds::index',['filter' => 'auth']);
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
