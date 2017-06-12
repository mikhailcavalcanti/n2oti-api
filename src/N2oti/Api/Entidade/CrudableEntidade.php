<?php

namespace N2oti\Api\Entidade;

/**
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 */
interface CrudableEntidade
{

    /**
     * Aletrar os atributos privados desta entidade
     * @param array $atributos
     */
    public function alterar(array $atributos);
}
