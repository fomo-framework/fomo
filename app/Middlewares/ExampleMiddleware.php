<?php
namespace App\Middlewares;

use Tower\Middleware\Contract;
use Tower\Request;
use Tower\Response;

class ExampleMiddleware implements Contract
{
    public function handle(Request $request): bool|Response
    {
        //
    }
}