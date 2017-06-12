<?php

namespace N2oti\Api\Seguranca;

use DomainException;
use N2oti\Api\Entidade\UsuarioEntidade;
use N2oti\Api\Servico\AutenticarServico;
use N2oti\Api\Servico\UsuarioServico;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Description of WsseUsuarioProvider 
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class WsseUsuarioProvider implements AuthenticationProviderInterface
{

    /**
     *
     * @var AutenticarServico
     */
    private $autenticarServico;

    /**
     * 
     * @param UsuarioServico $autenticarServico
     */
    public function __construct(AutenticarServico $autenticarServico)
    {
        $this->autenticarServico = $autenticarServico;
    }

    /**
     * 
     * @param TokenInterface $token
     */
    public function supports(TokenInterface $token)
    {
        return 'usuario' == $token->getProviderKey();
    }

    /**
     * 
     * @param TokenInterface $token
     */
    public function authenticate(TokenInterface $token)
    {
        $login = $token->getUsername();
        $senha = $token->getCredentials();
        /* @var $usuarioEntidade UsuarioEntidade */
        $usuarioEntidade = $this->autenticarServico->autenticarPorLoginSenha($token->getUsername(), $token->getCredentials());
        if (!$usuarioEntidade) {
            throw new DomainException('Usuário não encontrado');
        }
        $authenticatedToken = new UsernamePasswordToken($usuarioEntidade, null, 'user_password', array('ROLE_USUARIO'));
        $authenticatedToken->setAttribute('uid', $usuarioEntidade->getIndice());
        $authenticatedToken->setAttribute('utype', 'ROLE_USUARIO');
        return $authenticatedToken;
    }

}
