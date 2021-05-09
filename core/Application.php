<?php


namespace Core;

use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Pagination\Paginator;

class Application
{
    protected Route $router;

    protected function database()
    {
        $config = include "config/database.php";

        $capsule = new Capsule();

        $capsule->addConnection($config['mysql']);

        $capsule->setAsGlobal();

        Paginator::currentPageResolver(function ($pageName = 'page')  {
            $page = \request($pageName);

            if (filter_var($page, FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                return (int) $page;
            }

            return 1;
        });
    }

    public function onWorkerStart()
    {
        $this->router = include "route/api.php";

        Http::requestClass(Request::class);

        $this->database();
    }

    public function onMessage(TcpConnection $connection , Request $request)
    {
        Request::setInstance($request);
        $connection->send($this->router->dispatch($request->uri() , $request->method()));
    }
}