<?php

use Core\Route;

$router = new Route();

$router->get('/test' , 'Test@test');

return $router;
