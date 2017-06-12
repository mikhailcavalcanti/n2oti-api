<?php

namespace N2oti\Api\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMInvalidArgumentException;
use DomainException;
use N2oti\Api\Entidade\AcessorioEntidade;
use N2oti\Api\Servico\AcessorioServico;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

/**
 * Description of AcessorioController
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 */
class AcessorioController implements CrudableController
{

    /**
     *
     * @var AcessorioServico
     */
    private $acessorioServico;

    /**
     *
     * @var Serializer
     */
    private $serializer;

    /**
     * 
     * @param EntityManager $entityManager
     */
    public function __construct(Serializer $serializar, AcessorioServico $acessorioServico)
    {
        $this->serializer = $serializar;
        $this->acessorioServico = $acessorioServico;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function atualizarAction($indice, Request $request)
    {
        $this->acessorioServico->atualizar($indice, $request->request->all());
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function criarAction(Request $request)
    {
        $data = $this->acessorioServico->criar($request->request->all());
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')), Response::HTTP_CREATED);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function deletarAction($indice)
    {
        $this->acessorioServico->deletar($indice);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarAction($indice)
    {
        $data = $this->acessorioServico->encontrar($indice);
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarTodosAction(Request $request)
    {
        $data = $this->acessorioServico->encontrarTodos($request->query->all());
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

}
