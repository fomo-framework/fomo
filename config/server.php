<?php

return [
    /*
     * mode
     * SWOOLE_BASE ,
     * SWOOLE_PROCESS
     */
    'mode' => SWOOLE_BASE ,
    'host' => '127.0.0.1',
    'port' => 9000 ,
    'sockType' => SWOOLE_SOCK_TCP ,
    'additional' => [
        'worker_num' => cpuCount() * 2 ,
        /*
         * log level
         * SWOOLE_LOG_DEBUG (default)
         * SWOOLE_LOG_TRACE
         * SWOOLE_LOG_INFO
         * SWOOLE_LOG_NOTICE
         * SWOOLE_LOG_WARNING
         * SWOOLE_LOG_ERROR
         */
        'log_level' => SWOOLE_LOG_DEBUG ,
        'log_file' => storagePath('logs/tower.log') ,
    ],

    'ssl' => [
        'ssl_cert_file' => null ,
        'ssl_key_file' => null ,
    ] ,

    /*
     * The following services are created for better performance in the program, only one object is created from them and they can be used throughout the program
     */
    'services' => [
        \Fomo\Services\Database::class ,
        \Fomo\Services\Redis::class ,
        \Fomo\Services\Elasticsearch::class ,
        \Fomo\Services\Mail::class ,
    ] ,

    'watcher' => [
        'app',
        'config',
        'database',
        'language',
        'routes',
        'composer.lock',
        '.env',
    ]
];