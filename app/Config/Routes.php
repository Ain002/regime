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
