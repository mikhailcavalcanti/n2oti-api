<?php

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;

require __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app['debug'] = true;
$app['config'] = include __DIR__ . '/config/config.php';

return $app;
