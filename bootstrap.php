<?php

use Silex\Application;
use Silex\Provider\SerializerServiceProvider;

require __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app['debug'] = true;

$app['config'] = include __DIR__ . '/config/config.php';
require __DIR__ . '/config/rotas.php';
require __DIR__ . '/config/banco.php';
require __DIR__ . '/config/erro.php';
require __DIR__ . '/config/injecaodedependencia.php';
require __DIR__ . '/config/autenticacao.php';
$app->register(new SerializerServiceProvider());

return $app;
