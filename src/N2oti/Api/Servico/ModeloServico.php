<?php

namespace N2oti\Api\Servico;

use Doctrine\ORM\EntityManager;
use N2oti\Api\Entidade\ModeloEntidade;

/**
 * Description of ModeloServico
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class ModeloServico implements CrudableServico
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * 
     * @param EntityManager $entityManager
     */
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
        $modelo = $this->entityManager->find(ModeloEntidade::class, $indice);
        if (!$modelo) {
            throw new \DomainException("Não existe modelo com este identificador : {$indice}");
        }
        $modelo->alterar($dados);
        $this->entityManager->persist($modelo);
        $this->entityManager->flush();
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function criar(array $dados)
    {
        $modelo = new ModeloEntidade(
                $dados['nome'],
                $dados['ano'],
                $dados['aro']
                );
        $this->entityManager->persist($modelo);
        $this->entityManager->flush();
        return $modelo;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function deletar($indice)
    {
        $motivo = $this->encontrar($indice);
        if ($motivo) {
            $this->entityManager->remove($motivo);
            $this->entityManager->flush();
        }
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrar($indice)
    {
        return $this->entityManager->find(ModeloEntidade::class, $indice);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarTodos(array $dados)
    {
        return $this->entityManager->getRepository(ModeloEntidade::class)->findBy($dados);
    }

}
