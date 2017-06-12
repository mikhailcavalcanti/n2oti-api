<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Silex\Application;

$app = new Application();
$app['config'] = include __DIR__ . '/config.php';
require __DIR__ . '/banco.php';

return ConsoleRunner::createHelperSet($app['orm.em']);
