<?php

namespace App\Exceptions;

use Exception;
use Tower\Response;
use Tower\Response\Status;

class MethodNotAllowedException extends Exception
{
    public function __construct(string $method)
    {
        parent::__construct($method);
    }

    public function handle(): Response
    {
        return response()->json([
            "message" => "this is route supported {$this->getMessage()} method"
        ] , Status::HTTP_METHOD_NOT_ALLOWED->value);
    }
}