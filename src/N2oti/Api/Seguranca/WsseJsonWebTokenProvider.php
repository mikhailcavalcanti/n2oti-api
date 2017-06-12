<?php

namespace N2oti\Api\Seguranca;

use Firebase\JWT\JWT;
use N2oti\Api\Servico\AutenticarServico;
use N2oti\Api\Servico\UsuarioServico;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use TheSeer\Tokenizer\Exception;

/**
 * Description of WsseJsonWebTokenProvider
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class WsseJsonWebTokenProvider implements AuthenticationProviderInterface
{

    /**
     *
     * @var AutenticarServico
     */
    private $autenticacaoServico;

    /**
     *
     * @var string
     */
    private $jwtKey;

    /**
     * 
     * @param UsuarioServico $autenticacaoServico
     * @param string $jwtKey
     */
    public function __construct(AutenticarServico $autenticacaoServico, $jwtKey)
    {
        $this->autenticacaoServico = $autenticacaoServico;
        $this->jwtKey = $jwtKey;
    }

    /**
     * 
     * @param TokenInterface $token
     */
    public function supports(TokenInterface $token)
    {
        return 'jwt' == $token->getProviderKey();
    }

    /**
     * 
     * @param TokenInterface $token
     */
    public function authenticate(TokenInterface $token)
    {
        try {
            $data = JWT::decode(str_replace(' ', '', $token->getCredentials()), $this->jwtKey, array('HS256'));
            $usuario = $this->autenticacaoServico->autenticarPorId($data->uid);
            if (!$usuario) {
                return $token;
            }
            $authenticatedToken = new PreAuthenticatedToken($usuario, null, 'user_password', array("ROLE_USUARIO"));
            $authenticatedToken->setAttribute('uid', $usuario->getIndice());
            $authenticatedToken->setAttribute('utype', $data->utype);
            return $authenticatedToken;
        } catch (Exception $e) {
            return $token;
        }
    }

}
