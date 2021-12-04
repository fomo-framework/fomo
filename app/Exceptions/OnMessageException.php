<?php

namespace App\Exceptions;

use Exception;
use Tower\Response;
use Tower\Response\Status;

class OnMessageException extends Exception
{
    public function __construct(string $message , string $file , string $line)
    {
        $this->message = $message;
        $this->file = $file;
        $this->line = $line;
    }

    public function handle(): Response
    {
        return response()->json([
            'message' => $this->getMessage() ,
            'file' => $this->getFile() ,
            'line' => $this->getLine() ,
        ] , Status::HTTP_INTERNAL_SERVER_ERROR->value);
    }
}
