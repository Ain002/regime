<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- INITIALISATION BASE DE DONNÉES ---
$routes->get('/init-db', 'InitDB::index');

// --- RACINE & AUTHENTIFICATION ---
$routes->get('/', 'Auth::choose');
$routes->get('/choose', 'Auth::choose');

// Auth Admin
$routes->get('/auth/admin-login', 'Auth::adminLogin');
$routes->post('/auth/admin-authenticate', 'Auth::adminAuthenticate');

// Auth Client
$routes->get('/login', 'Auth::login');
$routes->post('/auth/authenticate', 'Auth::authenticate');
$routes->get('/logout', 'Auth::logout');

// Inscription & Profil (Séparation en 2 pages demandée par le sujet)
$routes->get('/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::registerSubmit');
$routes->get('/profile/complete', 'Auth::completeProfile');
$routes->post('/profile/complete', 'Auth::completeProfileSubmit');

// --- FRONT OFFICE (FONCTIONNALITÉS CLIENT) ---

// Suggestions de régimes & Activités (Ton travail actuel)
$routes->get('/recommendation', 'RecommendationController::index');
$routes->get('/recommendation/export/(:num)', 'RecommendationController::exportFPDF/$1');

// Porte-monnaie & Codes
$routes->get('/code', 'CodeRechargeController::saisieCode');
$routes->post('/wallet/request/code', 'WalletCodeController::requestCode');
$routes->get('/wallet/request', 'WalletCodeController::requestForm');

// Option Gold
$routes->post('/achat-gold', 'AbonnementController::acheterGold');

// --- BACK OFFICE (FONCTIONNALITÉS ADMIN) ---

// CRUD Régimes
$routes->get('/regime', 'RegimeController::index', ['filter' => 'admin']);
$routes->get('/regime/create', 'RegimeController::create', ['filter' => 'admin']);
$routes->post('/regime/store', 'RegimeController::store', ['filter' => 'admin']);
$routes->get('/regime/edit/(:num)', 'RegimeController::edit/$1', ['filter' => 'admin']);
$routes->post('/regime/update/(:num)', 'RegimeController::update/$1', ['filter' => 'admin']);
$routes->post('/regime/delete/(:num)', 'RegimeController::delete/$1', ['filter' => 'admin']);

// CRUD Régime Sports (Gestion des activités par régime)
$routes->get('/regime-sport/(:num)', 'RegimeSportController::index/$1', ['filter' => 'admin']);
$routes->get('/regime-sport/create/(:num)', 'RegimeSportController::create/$1', ['filter' => 'admin']);
$routes->post('/regime-sport/store/(:num)', 'RegimeSportController::store/$1', ['filter' => 'admin']);
$routes->get('/regime-sport/edit/(:num)/(:num)', 'RegimeSportController::edit/$1/$2', ['filter' => 'admin']);
$routes->post('/regime-sport/update/(:num)/(:num)', 'RegimeSportController::update/$1/$2', ['filter' => 'admin']);
$routes->get('/regime-sport/delete/(:num)/(:num)', 'RegimeSportController::delete/$1/$2', ['filter' => 'admin']);

// CRUD Activités sportives
$routes->get('/activity', 'ActivityController::index', ['filter' => 'admin']);
$routes->get('/activity/create', 'ActivityController::create', ['filter' => 'admin']);
$routes->post('/activity/store', 'ActivityController::store', ['filter' => 'admin']);
$routes->get('/activity/edit/(:num)', 'ActivityController::edit/$1', ['filter' => 'admin']);
$routes->post('/activity/update/(:num)', 'ActivityController::update/$1', ['filter' => 'admin']);
$routes->post('/activity/delete/(:num)', 'ActivityController::delete/$1', ['filter' => 'admin']);

// CRUD Aliments (Composants des régimes)
$routes->get('/aliment', 'AlimentController::index', ['filter' => 'admin']);
$routes->get('/aliment/create', 'AlimentController::create', ['filter' => 'admin']);
$routes->post('/aliment/store', 'AlimentController::store', ['filter' => 'admin']);
$routes->get('/aliment/edit/(:num)', 'AlimentController::edit/$1', ['filter' => 'admin']);
$routes->post('/aliment/update/(:num)', 'AlimentController::update/$1', ['filter' => 'admin']);
$routes->post('/aliment/delete/(:num)', 'AlimentController::delete/$1', ['filter' => 'admin']);

// Validation des codes par l'Admin
$routes->get('/admin/wallet', 'AdminWalletController::index', ['filter' => 'admin']);
$routes->get('/admin/wallet/approve/(:num)', 'AdminWalletController::approve/$1', ['filter' => 'admin']);
$routes->get('/admin/wallet/reject/(:num)', 'AdminWalletController::reject/$1', ['filter' => 'admin']);
$routes->get('/admin/wallet/mark-used/(:num)', 'AdminWalletController::markUsed/$1', ['filter' => 'admin']);

// Dashboard Admin
$routes->get('/admin/dashboard', 'AdminDashboardController::index', ['filter' => 'admin']);
$routes->get('/admin', 'AdminDashboardController::index', ['filter' => 'admin']);

// Paramètres Généraux
$routes->get('/parameter', 'ParameterController::index', ['filter' => 'admin']);
$routes->get('/parameter/create', 'ParameterController::create', ['filter' => 'admin']);
$routes->post('/parameter/store', 'ParameterController::store', ['filter' => 'admin']);
$routes->get('/parameter/edit/(:num)', 'ParameterController::edit/$1', ['filter' => 'admin']);
$routes->post('/parameter/update/(:num)', 'ParameterController::update/$1', ['filter' => 'admin']);
$routes->get('/parameter/delete/(:num)', 'ParameterController::delete/$1', ['filter' => 'admin']);