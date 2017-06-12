<?php

namespace N2oti\Api\Servico;

use Doctrine\ORM\EntityManager;
use DomainException;
use N2oti\Api\Entidade\CrudableEntidade;

/**
 * Description of ServicoAbstrato
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
abstract class ServicoAbstrato implements CrudableServico
{

    /**
     *
     * @var string
     */
    private $nomeDaEntidade;

    /**
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * 
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->nomeDaEntidade = str_replace('Servico', 'Entidade', get_class($this));
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function atualizar($indice, array $dados)
    {
        $entidade = $this->encontrar($indice);
        if (!$entidade) {
            throw new DomainException("Não existe recurso com este identificador : {$indice}");
        } else if (!$entidade instanceof CrudableEntidade) {
            throw new DomainException(printf('A entidade %s precisa implementar a interface %s', get_class($entidade), CrudableEntidade::class));
        }
        // este método está garantido de existir porque implementa CrudableEntidade
        $entidade->alterar($dados);
        $this->entityManager->persist($entidade);
        $this->entityManager->flush();
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function criar(array $dados)
    {
        $entidade = $this->criarInstanciaDaEntidade($dados);
        $this->entityManager->persist($entidade);
        $this->entityManager->flush();
        return $entidade;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function deletar($indice)
    {
        $entidade = $this->encontrar($indice);
        if ($entidade) {
            $this->entityManager->remove($entidade);
            $this->entityManager->flush();
        }
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrar($indice)
    {
        return $this->entityManager->find($this->nomeDaEntidade, $indice);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarTodos(array $dados)
    {
        return $this->entityManager->getRepository($this->nomeDaEntidade)->findBy($dados);
    }

    /**
     * Retorna uma intancia da entidade a partir dos dados passados por parâmetro
     */
    public abstract function criarInstanciaDaEntidade(array $dados);
}
