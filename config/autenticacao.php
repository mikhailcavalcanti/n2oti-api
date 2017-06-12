<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

$app->before(function(Request $request, Application $app) {
    # escapando rotas publicas
    $rota = $request->attributes->get('_route');
    $isRotaCadastroUsuario = 'POST_usuario' == $rota;
    $isRotaAutenticar = 'POST_autenticar' == $rota;
    if ($cadastroUsuario) {
        return;
    }
    try {
        # autenticacao token (usuario)
        $token = $request->headers->get('Authorization');
        $login = $request->request->get('login');
        $senha = $request->get('senha');
        # autenticacao por token
        if ('null' !== $token && $token) {
            $token = new PreAuthenticatedToken('user', $token, 'jwt');
        }
        # autenticacao usuario e senha
        if (null === $token && $isRotaAutenticar && $login && $senha) {
            $token = new UsernamePasswordToken($login, $senha, 'usuario');
        }
        $tokenStorage = $app['security.token_storage'];
        # Seta o token anonimo para usuario nao autenticado
        $tokenStorage->setToken(new AnonymousToken($app['jwt.key'], 'user'));
        if ($token) {
            $tokenStorage->setToken($app['security.authentication_manager']->authenticate($token));
        }
    } catch (Exception $e) {
        return new JsonResponse(array('validate' => false, 'message' => $e->getMessage()), Response::HTTP_UNAUTHORIZED);
    }
    # validacao
    if (!$app['security']->isGranted(array('ROLE_USUARIO'))) {
        return new JsonResponse(array('validate' => false), Response::HTTP_UNAUTHORIZED);
    }
});
