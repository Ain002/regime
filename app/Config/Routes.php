<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * Restructured routes for Régime App
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

// Inscription & Profil
$routes->get('/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::registerSubmit');
$routes->get('/profile/complete', 'Auth::completeProfile');
$routes->post('/profile/complete', 'Auth::completeProfileSubmit');

// ============================================================================
// --- FRONT OFFICE (CLIENT) ---
// ============================================================================
//profile
$routes->group('profile', function($routes) {
    $routes->get('/', 'ProfileController::index');
    $routes->post('update', 'ProfileController::update');
});

// Recommandations & Régimes
$routes->get('/recommendation', 'RecommendationController::index'); 
$routes->get('/recommendation/detail/(:num)', 'RecommendationController::detail/$1'); 
$routes->get('/recommendation/show/(:num)', 'RecommendationController::show/$1');
 $routes->get('/recommendation/buy/(:num)', 'RecommendationController::buy/$1');
 $routes->get('/recommendation/export/(:num)', 'RecommendationController::exportFPDF/$1');

// Portefeuille & Codes
$routes->get('/wallet', 'WalletController::index');
$routes->get('/wallet/request', 'WalletCodeController::requestForm');
$routes->post('/wallet/request/code', 'WalletCodeController::requestCode');
$routes->get('/code', 'CodeRechargeController::saisieCode');
$routes->post('/code/validate', 'CodeRechargeController::validateCode');

// Objectifs
$routes->get('/objectif', 'ObjectifController::index');
$routes->post('/objectif/choose', 'ObjectifController::choose');

// Abonnements (Gold)
$routes->post('/subscription/gold', 'AbonnementController::acheterGold');
$routes->get('/subscription/status', 'AbonnementController::status');

// ============================================================================
// --- BACK OFFICE (ADMIN) ---
// ============================================================================

// Dashboard Admin
$routes->get('/admin', 'AdminDashboardController::index');
$routes->get('/admin/dashboard', 'AdminDashboardController::index');

// CRUD Régimes
$routes->group('admin/regime', static function ($routes) {
    $routes->get('', 'RegimeController::index');
    $routes->get('create', 'RegimeController::create');
    $routes->post('store', 'RegimeController::store');
    $routes->get('edit/(:num)', 'RegimeController::edit/$1');
    $routes->post('update/(:num)', 'RegimeController::update/$1');
    $routes->post('delete/(:num)', 'RegimeController::delete/$1');
});

// CRUD Régime Aliments (Composition)
$routes->group('admin/regime-aliment', static function ($routes) {
    $routes->get('(:num)', 'RegimeAlimentController::index/$1');
    $routes->get('create/(:num)', 'RegimeAlimentController::create/$1');
    $routes->post('store/(:num)', 'RegimeAlimentController::store/$1');
    $routes->get('edit/(:num)/(:num)', 'RegimeAlimentController::edit/$1/$2');
    $routes->post('update/(:num)/(:num)', 'RegimeAlimentController::update/$1/$2');
    $routes->get('delete/(:num)/(:num)', 'RegimeAlimentController::delete/$1/$2');
});

// CRUD Régime Sports
$routes->group('admin/regime-sport', static function ($routes) {
    $routes->get('(:num)', 'RegimeSportController::index/$1');
    $routes->get('create/(:num)', 'RegimeSportController::create/$1');
    $routes->post('store/(:num)', 'RegimeSportController::store/$1');
    $routes->get('edit/(:num)/(:num)', 'RegimeSportController::edit/$1/$2');
    $routes->post('update/(:num)/(:num)', 'RegimeSportController::update/$1/$2');
    $routes->get('delete/(:num)/(:num)', 'RegimeSportController::delete/$1/$2');
});

// CRUD Aliments
$routes->group('admin/aliment', static function ($routes) {
    $routes->get('', 'AlimentController::index');
    $routes->get('create', 'AlimentController::create');
    $routes->post('store', 'AlimentController::store');
    $routes->get('edit/(:num)', 'AlimentController::edit/$1');
    $routes->post('update/(:num)', 'AlimentController::update/$1');
    $routes->post('delete/(:num)', 'AlimentController::delete/$1');
});

// CRUD Activités
$routes->group('admin/activity', static function ($routes) {
    $routes->get('', 'ActivityController::index');
    $routes->get('create', 'ActivityController::create');
    $routes->post('store', 'ActivityController::store');
    $routes->get('edit/(:num)', 'ActivityController::edit/$1');
    $routes->post('update/(:num)', 'ActivityController::update/$1');
    $routes->post('delete/(:num)', 'ActivityController::delete/$1');
});

// CRUD Paramètres
$routes->group('admin/parameter', static function ($routes) {
    $routes->get('', 'ParameterController::index');
    $routes->get('create', 'ParameterController::create');
    $routes->post('store', 'ParameterController::store');
    $routes->get('edit/(:num)', 'ParameterController::edit/$1');
    $routes->post('update/(:num)', 'ParameterController::update/$1');
    $routes->get('delete/(:num)', 'ParameterController::delete/$1');
});

// Gestion Portefeuille & Codes
$routes->group('admin/wallet', static function ($routes) {
    $routes->get('', 'AdminWalletController::index');
    $routes->get('approve/(:num)', 'AdminWalletController::approve/$1');
    $routes->get('reject/(:num)', 'AdminWalletController::reject/$1');
    $routes->get('mark-used/(:num)', 'AdminWalletController::markUsed/$1');
});

// ============================================================================
// --- ROUTES PAR DÉFAUT ---
// ============================================================================

// Catch-all pour 404
$routes->setAutoRoute(true);
