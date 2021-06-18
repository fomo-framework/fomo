<?php

require __DIR__ . '/vendor/autoload.php';

use Tower\JobWorker;
use Workerman\Worker;

$config = include configPath() . "server.php";

$worker = new Worker();

$worker->name = $config['name'];

date_default_timezone_set($config['timezone']);

$jobWorker = new JobWorker();

$worker->onWorkerStart = [$jobWorker, 'workerRun'];

Worker::runAll();