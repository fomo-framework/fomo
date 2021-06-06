<?php
namespace App\Middlewares;

use Tower\Middleware\Contract;
use Tower\Response;

class ExampleMiddleware implements Contract
{
    public function handle(): bool|Response
    {
        //
    }
}