<?php

namespace N2oti\Api\Servico;

use Doctrine\ORM\EntityManager;
use N2oti\Api\Entidade\AcessorioEntidade;

/**
 * Description of AcessorioServico
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class AcessorioServico implements CrudableServico
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function atualizar($indice, array $dados)
    {
        $acessorio = $this->entityManager->find(AcessorioEntidade::class, $indice);
        if (!$acessorio) {
            throw new \DomainException("Não existe acessório com este identificador : {$indice}");
        }
        $acessorio->alterar($dados);
        $this->entityManager->persist($acessorio);
        $this->entityManager->flush();
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function criar(array $dados)
    {
        $acessorio = new AcessorioEntidade($dados['nome'], $dados['tipo']);
        $this->entityManager->persist($acessorio);
        $this->entityManager->flush();
        return $acessorio;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function deletar($indice)
    {
        
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrar($indice)
    {
        return $this->entityManager->find(AcessorioEntidade::class, $indice);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarTodos(array $dados)
    {
        return $this->entityManager->getRepository(AcessorioEntidade::class)->findBy($dados);
    }

}
