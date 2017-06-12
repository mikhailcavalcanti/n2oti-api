<?php

namespace N2oti\Api\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMInvalidArgumentException;
use N2oti\Api\Entidade\ModeloEntidade;
use N2oti\Api\Servico\ModeloServico;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

/**
 * Description of ModeloController
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 */
class ModeloController implements CrudableController
{

    /**
     *
     * @var Serializer
     */
    private $serializer;

    /**
     *
     * @var ModeloServico
     */
    private $modeloServico;

    /**
     * 
     * @param EntityManager $entityManager
     */
    public function __construct(Serializer $serializar, ModeloServico $modeloService)
    {
        $this->serializer = $serializar;
        $this->modeloServico = $modeloService;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function atualizarAction($indice, Request $request)
    {
        $this->modeloServico->atualizar($indice, $request->request->all());
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function criarAction(Request $request)
    {
        $data = $this->modeloServico->criar($request->request->all());
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')), Response::HTTP_CREATED);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function deletarAction($indice)
    {
        $this->modeloServico->deletar($indice);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarAction($indice)
    {
        $data = $this->modeloServico->encontrar($indice);
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarTodosAction(Request $request)
    {
        $data = $this->modeloServico->encontrarTodos($request->query->all());
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

}
