<?php

namespace N2oti\Api\Servico;

use N2oti\Api\Entidade\UsuarioEntidade;

/**
 * Description of UsuarioServico
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class UsuarioServico extends ServicoAbstrato
{

    /**
     * 
     * {@inheritDoc}
     */
    public function criarInstanciaDaEntidade(array $dados)
    {
        return new UsuarioEntidade($dados['login'], $dados['senha']);
    }

}
