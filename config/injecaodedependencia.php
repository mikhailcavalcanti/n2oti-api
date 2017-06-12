<?php

use N2oti\Api\Controller\AcessorioController;
use N2oti\Api\Controller\ModeloController;
use N2oti\Api\Controller\UsuarioController;
use N2oti\Api\Servico\AcessorioServico;
use N2oti\Api\Servico\ModeloServico;
use N2oti\Api\Servico\UsuarioServico;
use Silex\Application;

#controllers
$app['acessorio.controller'] = function(Application $app) {
    return new AcessorioController($app['serializer'], $app['acessorio.servico']);
};
$app['modelo.controller'] = function(Application $app) {
    return new ModeloController($app['serializer'], $app['modelo.servico']);
};
$app['usuario.controller'] = function(Application $app) {
    return new UsuarioController($app['serializer'], $app['usuario.servico']);
};

#serviços
$app['acessorio.servico'] = function(Application $app) {
    return new AcessorioServico($app['orm.em']);
};
$app['modelo.servico'] = function(Application $app) {
    return new ModeloServico($app['orm.em']);
};
$app['usuario.servico'] = function(Application $app) {
    return new UsuarioServico($app['orm.em']);
};
