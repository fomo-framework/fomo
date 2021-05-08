<?php

namespace Core;

class Request extends \Workerman\Protocols\Http\Request
{
    private static ?Request $_instance = null;

    public static function getInstance(): Request
    {
        if(! is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Request();

        return self::$_instance;
    }

    public function input($name, $default = null)
    {
        $post = $this->post();
        if (isset($post[$name])) {
            return $post[$name];
        }
        $get = $this->get();
        return $get[$name] ?? $default;
    }
}
