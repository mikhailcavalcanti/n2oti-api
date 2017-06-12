<?php

namespace N2oti\Api\Entidade;

/**
 * Description of AbstractEntidade
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class AbstractEntidade implements CrudableEntidade
{

    /**
     * 
     * {@inheritDoc}
     */
    public function alterar(array $atributos)
    {
        foreach ($this as $nomeDoAtributo => $valorDoAtributo) {
            $this->$nomeDoAtributo = isset($atributos[$nomeDoAtributo]) ? $atributos[$nomeDoAtributo] : $valorDoAtributo;
        }
    }

}
