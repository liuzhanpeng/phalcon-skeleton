<?php
define('APP_PATH', realpath(__DIR__ . '/../app'));

require APP_PATH . '/core/Application.php';

$config = require APP_PATH . '/config/app.php';
(new \App\Core\Application($config))->run();
