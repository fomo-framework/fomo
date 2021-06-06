<?php
namespace App\Exceptions;

use Tower\Exception\Contract;
use Tower\Response;

class OnMessageException extends \Exception implements Contract
{
    public function handle(): Response
    {
        return json([
            'message' => 'the operation failed'
        ] , Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}