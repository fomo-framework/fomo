<?php

use Core\Request;
use Core\Authentication\Auth;
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

function json(array $data , int $status = 200): Response
{
    return new Response(
        $status ,
        ['Content-Type' => 'application/json']
        , json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE)
    );
}

function request(string $input)
{
    return Request::getInstance()->input($input);
}

function bearerToken(): string
{
    $header = Request::getInstance()->header('Authorization', '');

    return mb_substr($header , 7 , null , 'UTF-8');
}

function auth(): Auth
{
    return Auth::getInstance();
}