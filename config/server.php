<?php

return [
    'listen'               => 'http://127.0.0.1:9000',
    'transport'            => 'tcp',
    'context'              => [],
    'name'                 => 'tower',
    'count'                => cpuCoreCount() * 2 ,
    'user'                 => '',
    'group'                => '',
    'pid_file'             => storagePath() . '/tower.pid',
    'max_request'          => 1000000,
    'stdout_file'          => storagePath() . '/logs/stdout.log',
    'max_package_size'     => 10*1024*1024
];
