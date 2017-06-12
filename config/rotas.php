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
