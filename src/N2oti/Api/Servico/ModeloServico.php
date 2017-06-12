<?php

namespace N2oti\Api\Servico;

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
     * {@inheritDoc}
     */
    public function criarInstanciaDaEntidade(array $dados)
    {
        return new ModeloEntidade($dados['nome'], $dados['ano'], $dados['aro']);
    }

}
