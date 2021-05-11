<?php

namespace Core;

class Request extends \Workerman\Protocols\Http\Request
{
    protected static ?Request $_instance = null;

    public static function getInstance(): Request
    {
        return self::$_instance;
    }

    public static function setInstance(Request $request): void
    {
        self::$_instance = $request;
    }

    public function input(string $name, $default = null): mixed
    {
        $post = $this->post();
        if (isset($post[$name])) {
            return $post[$name];
        }
        $get = $this->get();
        return $get[$name] ?? $default;
    }

    public function url(): string
    {
        return '//' . $this->host() . $this->path();
    }
}
