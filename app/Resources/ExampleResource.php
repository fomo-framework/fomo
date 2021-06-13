<?php
namespace App\Resources;

use Tower\JsonResource;

class ExampleResource extends JsonResource
{
    protected function toArray($request)
    {
        return $request;
    }
}
