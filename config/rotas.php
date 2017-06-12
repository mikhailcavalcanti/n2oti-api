<?php

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;

$app->register(new ServiceControllerServiceProvider());

/* @var $app Application */

# acessorio
$app->get('/acessorio/{indice}', 'acessorio.controller:encontrarAction');
$app->get('/acessorio', 'acessorio.controller:encontrarTodosAction');
$app->post('/acessorio', 'acessorio.controller:criarAction');
$app->put('/acessorio/{indice}', 'acessorio.controller:atualizarAction');
$app->delete('/acessorio/{indice}', 'acessorio.controller:deletarAction');

# modelo
$app->get('/modelo/{indice}', 'modelo.controller:encontrarAction');
$app->get('/modelo', 'modelo.controller:encontrarTodosAction');
$app->post('/modelo', 'modelo.controller:criarAction');
$app->put('/modelo/{indice}', 'modelo.controller:atualizarAction');
$app->delete('/modelo/{indice}', 'modelo.controller:deletarAction');

# usuário
$app->get('/usuario/{indice}', 'usuario.controller:encontrarAction');
$app->get('/usuario', 'usuario.controller:encontrarTodosAction');
$app->post('/usuario', 'usuario.controller:criarAction');
$app->put('/usuario/{indice}', 'usuario.controller:atualizarAction');
$app->delete('/usuario/{indice}', 'usuario.controller:deletarAction');

# login
$app->post('autenticar', function(Application $app) {
    return $app['autenticar.controller']->autenticar($app['security.token_storage']->getToken(), $app['jwt.key']);
});
