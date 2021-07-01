<?php

namespace App\Exceptions;

use Exception;
use Tower\Response;

class OnMessageException extends Exception
{
    public function handle(): Response
    {
        return json([
            'message' => $this->getMessage() ,
            'file' => $this->getFile() ,
            'line' => $this->getLine() ,
        ] , Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
