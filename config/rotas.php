<?php

use N2oti\Api\Controller\AcessorioController;
use N2oti\Api\Controller\ModeloController;
use N2oti\Api\Controller\UsuarioController;
use N2oti\Api\Servico\AcessorioServico;
use N2oti\Api\Servico\ModeloServico;
use N2oti\Api\Servico\UsuarioServico;
use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app->register(new ServiceControllerServiceProvider());

/* @var $app Application */

# acessorio
$app->get('/acessorio/{indice}', function (Application $app, $indice) {
    return $app['acessorio.controller']->encontrarAction($indice);
});
$app->get('/acessorio', function (Application $app, Request $request) {
    return $app['acessorio.controller']->encontrarTodosAction($request);
});
$app->post('/acessorio', function (Application $app, Request $request) {
    return $app['acessorio.controller']->criarAction($request);
});
$app->put('/acessorio/{indice}', function (Application $app, Request $request, $indice) {
    return $app['acessorio.controller']->atualizarAction($indice, $request);
});
$app->delete('/acessorio/{indice}', function (Application $app, $indice) {
    return $app['acessorio.controller']->deletarAction($indice);
});

# modelo
$app->get('/modelo/{indice}', function (Application $app, $indice) {
    return $app['modelo.controller']->encontrarAction($indice);
});
$app->get('/modelo', function (Application $app, Request $request) {
    return $app['modelo.controller']->encontrarTodosAction($request);
});
$app->post('/modelo', function (Application $app, Request $request) {
    return $app['modelo.controller']->criarAction($request);
});
$app->put('/modelo/{indice}', function (Application $app, Request $request, $indice) {
    return $app['modelo.controller']->atualizarAction($indice, $request);
});
$app->delete('/modelo/{indice}', function (Application $app, $indice) {
    return $app['modelo.controller']->deletarAction($indice);
});

# usuário
$app->get('/usuario/{indice}', function (Application $app, $indice) {
    return $app['usuario.controller']->encontrarAction($indice);
});
$app->get('/usuario', function (Application $app, Request $request) {
    return $app['usuario.controller']->encontrarTodosAction($request);
});
$app->post('/usuario', function (Application $app, Request $request) {
    return $app['usuario.controller']->criarAction($request);
});
$app->put('/usuario/{indice}', function (Application $app, Request $request, $indice) {
    return $app['usuario.controller']->atualizarAction($indice, $request);
});
$app->delete('/usuario/{indice}', function (Application $app, $indice) {
    return $app['usuario.controller']->deletarAction($indice);
});

$app['acessorio.controller'] = function(Application $app) {
    return new AcessorioController($app['serializer'], $app['acessorio.servico']);
};
$app['acessorio.servico'] = function(Application $app) {
    return new AcessorioServico($app['orm.em']);
};

$app['modelo.controller'] = function(Application $app) {
    return new ModeloController($app['serializer'], $app['modelo.servico']);
};
$app['modelo.servico'] = function(Application $app) {
    return new ModeloServico($app['orm.em']);
};

$app['usuario.controller'] = function(Application $app) {
    return new UsuarioController($app['serializer'], $app['usuario.servico']);
};
$app['usuario.servico'] = function(Application $app) {
    return new UsuarioServico($app['orm.em']);
};