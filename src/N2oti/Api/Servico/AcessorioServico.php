<?php

namespace N2oti\Api\Servico;

use DomainException;
use N2oti\Api\Entidade\AcessorioEntidade;

/**
 * Description of AcessorioServico
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class AcessorioServico extends ServicoAbstrato
{

    /**
     * 
     * {@inheritDoc}
     */
    public function criarInstanciaDaEntidade(array $dados)
    {
        return new AcessorioEntidade($dados['nome'], $dados['tipo']);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function validarDadosParaCriarRecurso(array $dados)
    {
        $errors = [];
        $camposObrigatorios = ['nome', 'tipo'];
        foreach ($camposObrigatorios as $campo) {
            try {
                call_user_func(array($this, "validar" . ucfirst($campo)), $dados);
            } catch (DomainException $exeption) {
                $errors[] = $exeption->getMessage();
            }
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function validarDadosParaAlterarRecurso(array $dados)
    {
        $this->validarDadosParaCriarRecurso($dados);
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
            $errors[] = 'O campo nome do acessório é obrigatório';
        } else {
            $tamanhoMaximo = 100;
            if (strlen($nome) > $tamanhoMaximo) {
                $errors[] = sprintf('O campo nome do acessório só pode ter %d caracteres', $tamanhoMaximo);
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
    private function validarTipo(array $dados)
    {
        $erros = [];
        $tipo = isset($dados['tipo']) ? $dados['tipo'] : null;
        if (empty($tipo)) {
            $errors[] = 'O campo tipo do acessório é obrigatório';
        } else {
            $tiposPossiveis = [AcessorioEntidade::TIPO_FABRICA, AcessorioEntidade::TIPO_OPCIONAL];
            if (!in_array($tipo, $tiposPossiveis)) {
                $errors[] = sprintf('O tipo tem que ser um destes (%s).', implode(', ', $tiposPossiveis));
            }
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
    }

}
