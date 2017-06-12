<?php

namespace N2oti\Api\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMInvalidArgumentException;
use N2oti\Api\Entidade\AcessorioEntidade;
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
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var Serializer
     */
    private $serializer;

    /**
     * 
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, Serializer $serializar)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializar;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function atualizarAction($indice, Request $request)
    {
        $data = $this->entityManager->find(AcessorioEntidade::class, $indice);
        if (!$data) {
            throw new \DomainException("Não existe acessório com este identificador : {$indice}");
        }
        $data->alterar($request->request->all());
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function criarAction(Request $request)
    {
        $data = new AcessorioEntidade($request->request->get('nome'), $request->request->get('tipo'));
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')), Response::HTTP_CREATED);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function deletarAction($indice)
    {
        try {
            $this->entityManager->remove($this->entityManager->find(AcessorioEntidade::class, $indice));
            $this->entityManager->flush();
        } catch (ORMInvalidArgumentException $exception) {
            // Vai lançar essa exception se não encontrar o recurso no banco para deletar, por fim caindo no finally
        } finally {
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarAction($indice)
    {
        $data = $this->entityManager->find(AcessorioEntidade::class, $indice);
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarTodosAction(Request $request)
    {
        $data = $this->entityManager->getRepository(AcessorioEntidade::class)->findBy($request->query->all());
        return new JsonResponse(json_decode($this->serializer->serialize($data, 'json')));
    }

}
