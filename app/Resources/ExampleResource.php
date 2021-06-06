<?php
namespace App\Resource;

use Tower\JsonResponse;

class ExampleResource extends JsonResponse
{
    protected function toArray($request)
    {
        return $request;
    }
}