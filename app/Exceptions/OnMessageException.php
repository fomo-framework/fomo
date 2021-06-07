<?php
namespace App\Exceptions;

use Throwable;
use Tower\Exception\Contract;
use Tower\Response;

class OnMessageException extends \Exception implements Contract
{
    public function __construct(Throwable $error)
    {
        parent::__construct($error->getMessage() , $error->getCode(), $error->getPrevious());
    }

    public function handle(): Response
    {
        return json([
            'message' => 'the operation failed'
        ] , Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}