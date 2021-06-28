<?php
namespace App\Exceptions;

use Exception;
use Tower\Response;

class NotFoundException extends Exception
{
    public function handle(): Response
    {
        return json([
            'message' => 'not found'
        ] , Response::HTTP_NOT_FOUND);
    }
}