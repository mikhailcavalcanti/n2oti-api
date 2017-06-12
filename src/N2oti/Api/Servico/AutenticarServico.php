<?php

namespace N2oti\Api\Servico;

use N2oti\Api\Entidade\UsuarioEntidade;

/**
 * Description of AutenticarServico
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class AutenticarServico
{

    /**
     *
     * @var UsuarioServico
     */
    private $usuarioServico;

    /**
     * 
     * @param UsuarioServico $usuarioServico
     */
    public function __construct(UsuarioServico $usuarioServico)
    {
        $this->usuarioServico = $usuarioServico;
    }

    /**
     * 
     * @param integer $indice
     * @return UsuarioEntidade|null
     */
    public function autenticarPorId($indice)
    {
        return $this->usuarioServico->encontrar($indice);
    }

    /**
     * 
     * @param string $login
     * @param type $senha
     */
    public function autenticarPorLoginSenha($login, $senha)
    {
        $usuarios = $this->usuarioServico->encontrarTodos(array('login' => $login, 'senha' => $senha));
        return $usuarios ? current($usuarios) : null;
    }

}
