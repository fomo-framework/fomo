<?php

namespace App\Resource;

use Core\JsonResponse;

class ExampleResource extends JsonResponse
{
    protected function toArray($request)
    {
        return $request;
    }
}