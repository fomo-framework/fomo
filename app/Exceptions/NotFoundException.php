<?php

namespace App\Exceptions;

use Exception;
use Tower\Response;
use Tower\Response\Status;

class NotFoundException extends Exception
{
    public function handle(): Response
    {
        return response()->json([
            'message' => 'not found'
        ] , Status::HTTP_NOT_FOUND->value);
    }
}