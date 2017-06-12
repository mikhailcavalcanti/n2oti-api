<?php

use N2oti\Api\Controller\AcessorioController;
use N2oti\Api\Controller\AutenticarController;
use N2oti\Api\Controller\ModeloController;
use N2oti\Api\Controller\UsuarioController;
use N2oti\Api\Seguranca\WsseJsonWebTokenProvider;
use N2oti\Api\Seguranca\WsseUsuarioProvider;
use N2oti\Api\Servico\AcessorioServico;
use N2oti\Api\Servico\AutenticarServico;
use N2oti\Api\Servico\ModeloServico;
use N2oti\Api\Servico\UsuarioServico;
use Silex\Application;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;
use Symfony\Component\Security\Core\SecurityContext;

#controllers
$app['acessorio.controller'] = function(Application $app) {
    return new AcessorioController($app['serializer'], $app['acessorio.servico']);
};
$app['autenticar.controller'] = function(Application $app) {
    return new AutenticarController($app['serializer'], $app['autenticar.servico']);
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
$app['autenticar.servico'] = function(Application $app) {
    return new AutenticarServico( $app['usuario.servico']);
};
$app['modelo.servico'] = function(Application $app) {
    return new ModeloServico($app['orm.em'], $app['acessorio.servico']);
};
$app['usuario.servico'] = function(Application $app) {
    return new UsuarioServico($app['orm.em']);
};

# autenticacao
$app['jwt.key'] = '4f1g23a12aa';
$app['security.token_storage'] = function() {
    return new TokenStorage();
};
$app['security.authentication_manager'] = function(Application $app) {
    return new AuthenticationProviderManager(array(
        new WsseUsuarioProvider(new AutenticarServico(new UsuarioServico($app['orm.em']))),
        new WsseJsonWebTokenProvider($app['autenticar.servico'], $app['jwt.key']),
    ));
};
$app['security.access_decision_manager'] = function () {
    return new AccessDecisionManager(array(new RoleVoter()));
};
$app['security.authorization_checker'] = function (Application $app) {
    return new AuthorizationChecker(
        $app['security.token_storage'], $app['security.authentication_manager'], $app['security.access_decision_manager']
    );
};
$app['security'] = function (Application $app) {
    return new SecurityContext($app['security.token_storage'], $app['security.authorization_checker']);
};
