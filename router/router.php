<?php

use Fomo\Facades\Route;

Route::get('/', function () {
    return response()->plainText('hello world');
});
