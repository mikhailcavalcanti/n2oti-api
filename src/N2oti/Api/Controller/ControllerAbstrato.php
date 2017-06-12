<?php

namespace N2oti\Api\Controller;

use N2oti\Api\Servico\AcessorioServico;
use N2oti\Api\Servico\CrudableServico;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

/**
 * Description of ControllerAbstrato
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 */
class ControllerAbstrato implements CrudableController
{

    /**
     *
     * @var AcessorioServico
     */
    private $servico;

    /**
     *
     * @var Serializer
     */
    private $serializer;

    /**
     * 
     * @param Serializer $serializar
     * @param CrudableServico $servido
     */
    public function __construct(Serializer $serializar, CrudableServico $servido)
    {
        $this->serializer = $serializar;
        $this->servico = $servido;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function atualizarAction($indice, Request $request)
    {
        $this->servico->atualizar($indice, $request->request->all());
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function criarAction(Request $request)
    {
        $data = $this->servico->criar($request->request->all());
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')), Response::HTTP_CREATED);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function deletarAction($indice)
    {
        $this->servico->deletar($indice);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarAction($indice)
    {
        $data = $this->servico->encontrar($indice);
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarTodosAction(Request $request)
    {
        $data = $this->servico->encontrarTodos($request->query->all());
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

}
