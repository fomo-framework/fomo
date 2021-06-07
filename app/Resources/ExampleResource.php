<?php
namespace App\Resources;

use Tower\JsonResponse;

class ExampleResource extends JsonResponse
{
    protected function toArray($request)
    {
        return $request;
    }
}
