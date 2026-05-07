<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/choose', 'Auth::choose');
// New entry point for choosing admin or client
$routes->get('/auth/admin-login', 'Auth::adminLogin');
$routes->post('/auth/admin-authenticate', 'Auth::adminAuthenticate');

// root -> choose page
$routes->get('/', 'Auth::choose');

// Auth routes
$routes->get('/login', 'Auth::login');
$routes->post('/auth/authenticate', 'Auth::authenticate');
$routes->get('/logout', 'Auth::logout');
// Register & profile
$routes->get('/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::registerSubmit');
$routes->get('/profile/complete', 'Auth::completeProfile');
$routes->post('/profile/complete', 'Auth::completeProfileSubmit');

// acaht gold
$routes->post('/achat-gold', 'AbonnementController::acheterGold');

// saisie de code
$routes->get('/code', 'CodeRechargeController::saisieCode');

// ajout de régime
$routes->get('/regime', 'RegimeController::index');
$routes->get('/regime/create', 'RegimeController::create');
$routes->post('/regime/store', 'RegimeController::store');
$routes->get('/regime/edit/(:num)', 'RegimeController::edit/$1');
$routes->post('/regime/update/(:num)', 'RegimeController::update/$1');
$routes->post('/regime/delete/(:num)', 'RegimeController::delete/$1');

// activités sportives
$routes->get('/activity', 'ActivityController::index');
$routes->get('/activity/create', 'ActivityController::create');
$routes->post('/activity/store', 'ActivityController::store');
$routes->get('/activity/edit/(:num)', 'ActivityController::edit/$1');
$routes->post('/activity/update/(:num)', 'ActivityController::update/$1');
$routes->post('/activity/delete/(:num)', 'ActivityController::delete/$1');

// codes porte-monnaie (user)
$routes->get('/wallet/request', 'WalletCodeController::requestForm');
$routes->post('/wallet/request/code', 'WalletCodeController::requestCode');

// codes porte-monnaie (admin)
$routes->get('/admin/wallet', 'AdminWalletController::index');
$routes->get('/admin/wallet/approve/(:num)', 'AdminWalletController::approve/$1');
$routes->get('/admin/wallet/reject/(:num)', 'AdminWalletController::reject/$1');
$routes->get('/admin/wallet/mark-used/(:num)', 'AdminWalletController::markUsed/$1');

// paramètres
$routes->get('/parameter', 'ParameterController::index');
$routes->get('/parameter/edit/(:num)', 'ParameterController::edit/$1');
$routes->post('/parameter/update/(:num)', 'ParameterController::update/$1');

// aliments
$routes->get('/aliment', 'AlimentController::index');
$routes->get('/aliment/create', 'AlimentController::create');
$routes->post('/aliment/store', 'AlimentController::store');
$routes->get('/aliment/edit/(:num)', 'AlimentController::edit/$1');
$routes->post('/aliment/update/(:num)', 'AlimentController::update/$1');
$routes->post('/aliment/delete/(:num)', 'AlimentController::delete/$1');

