<?php

namespace App\Exceptions;

use Exception;
use Tower\Response;
use Tower\Response\Status;

class AuthenticationException extends Exception
{
    public function handle(): Response
    {
        return response()->json([
            'message' => 'Unauthorized'
        ] , Status::HTTP_UNAUTHORIZED->value);
    }
}