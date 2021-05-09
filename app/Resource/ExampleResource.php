<?php


use Core\JsonResponse;

class ExampleResource extends JsonResponse
{
    protected function toArray($request)
    {
        return $request;
    }
}