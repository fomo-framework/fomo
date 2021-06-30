<?php

require __DIR__ . '/vendor/autoload.php';

use Tower\SchedulingWorker;
use Workerman\Worker;

$dotenv = Dotenv\Dotenv::createImmutable(basePath());
$dotenv->load();

$config = include configPath() . "server.php";

$worker = new Worker();

$worker->name = $config['name'];

date_default_timezone_set($config['timezone']);

$jobWorker = new SchedulingWorker();

$worker->onWorkerStart = [$jobWorker, 'workerRun'];

Worker::runAll();