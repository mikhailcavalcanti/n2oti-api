<?php

use N2oti\Api\Controller\AcessorioController;
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

$app['acessorio.controller'] = function(Application $app) {
    return new AcessorioController($app['orm.em'], $app['serializer']);
};