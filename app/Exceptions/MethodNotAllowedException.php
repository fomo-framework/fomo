<?php
namespace App\Exceptions;

use Tower\Exception\Contract;
use Tower\Response;

class MethodNotAllowedException extends \Exception implements Contract
{
    public function __construct(string $method)
    {
        parent::__construct($method);
    }

    public function handle(): Response
    {
        return json([
            "message" => "this is route supported {$this->getMessage()} method"
        ] , Response::HTTP_METHOD_NOT_ALLOWED);
    }
}