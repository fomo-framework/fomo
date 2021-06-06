<?php
namespace App\Exceptions;

use Tower\Exception\Contract;
use Tower\Response;

class NotFoundException extends \Exception implements Contract
{
    public function handle(): Response
    {
        return json([
            'message' => 'not found'
        ] , Response::HTTP_NOT_FOUND);
    }
}