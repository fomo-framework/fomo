<?php


namespace Core;

use Workerman\Connection\TcpConnection;

class Application
{
    protected Route $router;

    public function onWorkerStart()
    {
        $this->router = include "route/api.php";
        // include "bootstrap/database.php";
    }

    public function onMessage(TcpConnection $connection , Request $request)
    {
        Request::setInstance($request);
        $connection->send($this->router->dispatch($request->uri() , $request->method()));
    }
}