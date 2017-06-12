<?php

use N2oti\Api\Controller\AcessorioController;
use N2oti\Api\Controller\ModeloController;
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

$app['acessorio.controller'] = function(Application $app) {
    return new AcessorioController($app['serializer'], $app['acessorio.servico']);
};
$app['acessorio.servico'] = function(Application $app) {
    return new N2oti\Api\Servico\AcessorioServico($app['orm.em']);
};

$app['modelo.controller'] = function(Application $app) {
    return new ModeloController($app['orm.em'], $app['serializer']);
};