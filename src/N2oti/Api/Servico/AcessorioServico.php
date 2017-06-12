<?php

namespace N2oti\Api\Servico;

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

}
