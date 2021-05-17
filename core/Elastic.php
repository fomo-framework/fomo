<?php

namespace Core;

use Elasticsearch\ClientBuilder;

class Elastic
{
    public static function __callStatic(string $method, array $arguments)
    {
        $config = include "config/elastic.php";

        $elastic = ClientBuilder::create()
            ->setHosts($config)
            ->build();

        return $elastic->$method(...$arguments);
    }
}