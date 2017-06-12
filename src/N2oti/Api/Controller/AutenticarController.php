<?php

namespace N2oti\Api\Controller;

use Firebase\JWT\JWT;
use N2oti\Api\Servico\AutenticarServico;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * Description of AutenticarController
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class AutenticarController
{

    /**
     *
     * @var Serializer
     */
    private $serializer;

    /**
     *
     * @var AutenticarServico
     */
    private $autenticarServico;

    /**
     * 
     * @param \N2oti\Api\Controller\Serializer $serializer
     * @param type $autenticarServico
     */
    public function __construct(Serializer $serializer, $autenticarServico)
    {
        $this->serializer = $serializer;
        $this->autenticarServico = $autenticarServico;
    }

    /**
     * 
     * @param TokenInterface $token
     * @param string $jwtKey
     * @return JsonResponse
     */
    public function autenticar(TokenInterface $token, $jwtKey)
    {
        $data = array(
            'iss' => $_SERVER['HTTP_HOST'],
            'aud' => "{$_SERVER['HTTP_HOST']}/sigorg/web",
            'iat' => time(),
            'nbf' => time(),
            'uid' => $token->getAttribute('uid'),
            'utype' => $token->getAttribute('utype'),
        );
        $usuarioJson = $this->serializer->serialize($token->getUser(), 'json');
        $usuarioData = json_decode($usuarioJson, 'json');
        return new JsonResponse($usuarioData, Response::HTTP_OK, array('Authorization' => JWT::encode($data, $jwtKey)));
    }

}
