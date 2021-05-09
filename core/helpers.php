<?php

use Core\Request;
use Workerman\Protocols\Http\Response;

define('BASE_PATH', realpath(__DIR__.'/../'));

function storagePath(): string
{
    return BASE_PATH . DIRECTORY_SEPARATOR . 'storage';
}

function cpuCoreCount(): int
{
    if (strtolower(PHP_OS) === 'darwin')
        $count = shell_exec('sysctl -n machdep.cpu.core_count');
    else
        $count = shell_exec('nproc');

    return (int) $count > 0 ? (int) $count : 4;
}

function basePath(): bool|string
{
    return BASE_PATH;
}

function appPath(): string
{
    return BASE_PATH . DIRECTORY_SEPARATOR . 'app';
}

function configPath(): string
{
    return BASE_PATH . DIRECTORY_SEPARATOR . 'config';
}

function json(array $data , int $status = 200 , $options = JSON_UNESCAPED_UNICODE): Response
{
    return new Response(
        $status ,
        ['Content-Type' => 'application/json']
        , json_encode($data, $options)
    );
}

function request(string $input)
{
    return Request::getInstance()->input($input);
}