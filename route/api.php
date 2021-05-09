<?php

use App\Middleware\ExampleMiddleware;
use Core\Route;

$router = new Route();

$router->get('/middleware' , ['uses' => 'ExampleController@test' , 'middleware' => ExampleMiddleware::class]);
$router->get('/test' , 'Test@test');

return $router;
