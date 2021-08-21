<?php

return [
    'listen'               => 'http://127.0.0.1:9000',
    'timezone'               => env('APP_TIMEZONE' , 'UTC'),
    'faker_locale'            => 'en_US',
    'transport'            => 'tcp',
    'context'              => [],
    'name'                 => env('APP_NAME' , 'Tower'),
    'count'                => env('APP_WORKER_COUNT' , cpuCoreCount() * 2) ,
    'user'                 => '',
    'group'                => '',
    'pid_file'             => storagePath() . 'tower.pid',
    'max_request'          => 1000000,
    'stdout_file'          => storagePath() . 'logs/tower.log',
    'max_package_size'     => 10*1024*1024
];
