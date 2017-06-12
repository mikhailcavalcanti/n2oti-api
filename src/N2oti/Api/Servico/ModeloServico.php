<?php

namespace N2oti\Api\Servico;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use DomainException;
use N2oti\Api\Entidade\ModeloEntidade;

/**
 * Description of ModeloServico
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class ModeloServico extends ServicoAbstrato
{

    /**
     *
     * @var AcessorioServico
     */
    private $acessorioServico;

    public function __construct(EntityManager $entityManager, AcessorioServico $acessorioServico)
    {
        parent::__construct($entityManager);
        $this->acessorioServico = $acessorioServico;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function criarInstanciaDaEntidade(array $dados)
    {
        $acessoriosColecao = new ArrayCollection();
        $acessorios = isset($dados['acessorios']) ? $dados['acessorios'] : null;
        if ($acessorios) {
            foreach ($acessorios as $acessorio) {
                $acessorioEntidade = $this->acessorioServico->encontrar($acessorio['id']);
                if ($acessorioEntidade) {
                    $acessoriosColecao->add($acessorioEntidade);
                }
            }
        }
        return new ModeloEntidade($dados['nome'], $dados['ano'], $dados['aro'], $acessoriosColecao);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function validarDadosParaCriarRecurso(array $dados)
    {
        $errors = [];
        $camposObrigatorios = ['nome', 'ano', 'aro', 'acessorio'];
        foreach ($camposObrigatorios as $campo) {
            try {
                call_user_func(array($this, "validar" . ucfirst($campo)), $dados);
            } catch (\DomainException $exeption) {
                $errors[] = $exeption->getMessage();
            }
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
    }

    /**
     * 
     * @param array $dados
     * @throws DomainException
     */
    private function validarNome(array $dados)
    {
        $erros = [];
        $nome = isset($dados['nome']) ? $dados['nome'] : null;
        if (empty($nome)) {
            $errors[] = 'O campo nome do modelo é obrigatório';
        } else {
            $tamanhoMaximo = 100;
            if (strlen($nome) > $tamanhoMaximo) {
                $errors[] = sprintf('O campo nome do modelo só pode ter %d caracteres', $tamanhoMaximo);
            }
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
    }

    /**
     * 
     * @param array $dados
     * @throws DomainException
     */
    private function validarAno(array $dados)
    {
        $erros = [];
        $ano = isset($dados['ano']) ? $dados['ano'] : null;
        if (empty($ano)) {
            $errors[] = 'O campo ano do modelo é obrigatório';
        } else {
            if (!preg_match('?^\d{4}$?', $ano)) {
                $errors[] = sprintf('O valor "%s" não é um ano válido.', $ano);
            }
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
    }

    /**
     * 
     * @param array $dados
     * @throws DomainException
     */
    private function validarAro(array $dados)
    {
        $erros = [];
        $aro = isset($dados['aro']) ? $dados['aro'] : null;
        if (empty($aro)) {
            $errors[] = 'O campo aro do modelo é obrigatório';
        } else {
            $arosPossiveis = range(13, 23);
            if (!in_array($aro, $arosPossiveis)) {
                $errors[] = sprintf('O aro tem que ser um destes (%s).', implode(', ', $arosPossiveis));
            }
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
    }

    /**
     * 
     * @param array $dados
     */
    private function validarAcessorio(array $dados)
    {
        $errors = [];
        $acessorios = isset($dados['acessorios']) && is_array($dados['acessorios']) ? $dados['acessorios'] : null;
        if ($acessorios) {
            $mensagem = 'Não foi encontrado um acessório com identificador %d para associar ao modelo.';
            foreach ($acessorios as $acessorio) {
                $acessorioEntidade = $this->acessorioServico->encontrar($acessorio['id']);
                if (!$acessorioEntidade) {
                    $errors[] = sprintf($mensagem, $acessorio['id']);
                }
            }
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
    }

}
