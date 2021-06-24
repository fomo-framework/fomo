<?php

use Tower\Application;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(basePath());
$dotenv->load();


$config = include configPath() . "server.php";

Worker::$pidFile = $config['pid_file'];
Worker::$stdoutFile = $config['stdout_file'];
TcpConnection::$defaultMaxPackageSize = $config['max_package_size'] ?? 10*1024*1024;

$http_worker = new Worker($config['listen'], $config['context']);
$property_map = [
    'name',
    'count',
    'user',
    'group',
    'reusePort',
    'transport',
];
foreach ($property_map as $property) {
    if (isset($config[$property])) {
        $http_worker->$property = $config[$property];
    }
}

date_default_timezone_set($config['timezone']);


$boot = new Application();

$http_worker->onWorkerStart = [$boot , 'onWorkerStart'];

$http_worker->onMessage = [$boot , 'onMessage'];

Worker::runAll();