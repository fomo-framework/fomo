<?php

namespace Core\Authentication;

use stdClass;

class Auth
{
    protected static ?Auth $_instance = null;

    protected ?stdClass $user = null;

    public function __construct(stdClass $user)
    {
        $this->user = $user;
    }

    public static function setInstance(stdClass $user): void
    {
        self::$_instance = new self($user);
    }

    public static function getInstance(): Auth
    {
        return self::$_instance;
    }

    public function user(): stdClass
    {
        return $this->user;
    }
}