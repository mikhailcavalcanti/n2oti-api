<?php

namespace N2oti\Api\Controller;

use Doctrine\ORM\EntityManager;
use N2oti\Api\Servico\UsuarioServico;
use N2oti\Api\Servico\CrudableServico;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

/**
 * Description of UsuarioController
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 */
class UsuarioController implements CrudableController
{

    /**
     *
     * @var UsuarioServico
     */
    private $usuarioServico;

    /**
     *
     * @var Serializer
     */
    private $serializer;

    /**
     * 
     * @param Serializer $serializar
     * @param CrudableServico $usuarioServico
     */
    public function __construct(Serializer $serializar, CrudableServico $usuarioServico)
    {
        $this->serializer = $serializar;
        $this->usuarioServico = $usuarioServico;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function atualizarAction($indice, Request $request)
    {
        $this->usuarioServico->atualizar($indice, $request->request->all());
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function criarAction(Request $request)
    {
        $data = $this->usuarioServico->criar($request->request->all());
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')), Response::HTTP_CREATED);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function deletarAction($indice)
    {
        $this->usuarioServico->deletar($indice);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarAction($indice)
    {
        $data = $this->usuarioServico->encontrar($indice);
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarTodosAction(Request $request)
    {
        $data = $this->usuarioServico->encontrarTodos($request->query->all());
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

}
