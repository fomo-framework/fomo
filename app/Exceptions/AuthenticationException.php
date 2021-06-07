<?php
namespace App\Exceptions;

use Tower\Exception\Contract;
use Tower\Response;

class AuthenticationException extends \Exception implements Contract
{
    public function handle(): Response
    {
        return json([
            'message' => 'Unauthorized'
        ] , Response::HTTP_UNAUTHORIZED);
    }
}