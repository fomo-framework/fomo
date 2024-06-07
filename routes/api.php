<?php

/** @var Fomo\Router\Router $router */

$router->get('/' , function () {
    return response()->plainText('hello world');
});
    