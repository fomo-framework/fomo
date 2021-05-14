<?php


namespace Core;


use Predis\Client;

class Redis
{
    public static function __callStatic(string $method, array $arguments)
    {
        $config = include "config/redis.php";

        return (new Client($config))->$method(...$arguments);
    }
}