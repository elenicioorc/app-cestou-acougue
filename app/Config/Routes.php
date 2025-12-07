<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// app/Config/Routes.php
// app/Config/Routes.php

// app/Config/Routes.php

$routes->group('api', ['filter' => 'cors'], function($routes){
    $routes->post('login', 'API\AuthController::login');
    
    // O alias 'apiToken' é usado aqui:
    $routes->group('', ['filter' => 'apiToken'], function($routes){
        $routes->get('profile', 'API\ProfileController::index'); 
    });
});


